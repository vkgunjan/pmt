
<?php 
           
        $ct='active';

        include_once('including/all-include.php');
        include_once('including/header.php');
        include('including/datetime.php');
        
        $av = $_SESSION['uid'];
        $fullname = $_SESSION['fullname'];
        $emp_email = $_SESSION['email'];
        $emp_code = $_SESSION['emp_code'];
        $contact = $_SESSION['contact'];

         
         
         //print_r($_SESSION);
?>
<?php
      

         /*$cat_array = implode(",", '$catalogue');*/


         if(isset($_POST['formsubmit'])){
          $cat = implode(',', $_POST['catalogue_name']);
          $cat_new = implode($_POST['catalogue_name'], ",");
          $ex_cat = explode(',', $cat);
          $city          = $_POST['city'];
          
          //$required_date = $_POST['required_date'];
          $address       = $_POST['address'];
          $remarks       = $_POST['remarks'];
          

          foreach ($ex_cat as $cat) {
            $sql = "INSERT INTO cat_log values ('$unique_msg_id','$av', '$cat','', getdate())";
            $stmt = odbc_prepare($conn, $sql);
            $result = odbc_execute($stmt);
          }

            $cat_sql = "INSERT INTO log_history (lg_city,lg_code, lg_uid, lg_emp_code, lg_full_name, lg_emp_email, lg_mobile, lg_catalogue_id, lg_required_date, lg_address, lg_remarks, lg_created_date, lg_updated_date, lg_status) values 
              ('$city','$unique_msg_id','$av','$emp_code','$fullname','$emp_email','$contact','$cat_new',getdate(),'$address','$remarks',getdate(),getdate(),'1')";
              $cat_stmt = odbc_prepare($conn, $cat_sql);
              $cat_result = odbc_execute($cat_stmt);

          if ($result && $cat_result) {

            $mail_query = "SELECT top 1
                                       h.lg_id as [log_id],
                                       h.lg_code,
                                       h.lg_emp_code as [emp_code], 
                                       h.lg_full_name as [full_name], 
                                       h.lg_emp_email as [email], 
                                       h.lg_mobile as [mobile], 
                                       m.state as [state], 
                                       m.territory as [territory], 
                                       m.city as [city], 
                                       h.lg_other_mobile as [landline],  
                                       h.lg_required_date as [required_date],
                                       h.lg_address as [address],
                                       h.lg_created_date,
                                       h.lg_remarks,
                                       (SELECT TOP 1 dbo.getCatNames(h.lg_catalogue_id, ',')) as [cat_name]
                                       

                                       FROM log_history h
                                       left join city_master m on m.id = h.lg_city order by h.lg_created_date desc
                                       ";
                                       $mail_result = odbc_exec($conn, $mail_query);
                                       $mm=odbc_num_rows($mail_result);
                                       while($m = odbc_fetch_array($mail_result)){
                                       $m_code = $m['lg_code'];
                                       $m_territory = $m['territory'];
                                       $m_state = $m['state'];
                                       $m_city = $m['city'];
                                       $m_emp_code = $m['emp_code'];
                                       $m_full_name = $m['full_name'];
                                       $m_email = $m['email'];
                                       $m_mobile = $m['mobile'];
                                       $m_cat_name = $m['cat_name'];
                                       $m_required_date = $m['required_date'];
                                       $m_address = $m['address'];
                                       $m_order_date = date('Y-m-d',strtotime(trim($m['lg_created_date'])));
                                       $m_remarks = $m['lg_remarks'];
                                     }

            //Email Configuration Start
            //$m_email = "vikash.gunjan@orientbell.com";
            $subject = "OBL-MKT || Catalogue Dispatch Details";
                        $to = $m_email;
                        $body = '<html>
                             <head>
                             <title></title>
                              <style>
                               table{
                               border-collapse: collapse;
                               width: 100%;
                                 }

                              th, td {
                                border: 0.5px solid #1B5E20;
                                  text-align: center;
                                  padding: 4px;
                                  color:black
                                  font-size:10px;
                                  font-family: Arial, sans-serif;
                                  font-weight:normal;
                                  font-style:normal;
                              }

                              h3,p,div {
                                  font-family: Arial, sans-serif;
                                  font-weight:normal;
                                  font-style:normal;
                                  }

                              tr:nth-child(even){background-color: #f2f2f2}

                              th {
                                  background-color: #0b9444;
                                  color: white;
                                }
                           </style>
                        </head>
                        <body>';
                        
                  $body .= "
                  <h3>Dear Administrator,</h3>

                  <p>This is an auto generated Email, Please do not reply. Catalogue order requested by <b>$m_full_name</b> has been created. Kindly refer to below details for more clarification.
                  </p>
          <div>
             <b>$m_full_name</b><br>
             M: +91-$m_mobile<br>
             $m_address<br>
             $m_city, $m_state
            </div>
            <br><br>
                  ";

                  $body .= '<table>
                           <thead>
                              <tr>
                                     <th>#</th>
                                     <th>Item</th>
                                     <th>Description</th>
                                     <th>Quantity</th>
                                     <th>Required Date</th>
                                     <th>Order Date</th>
                              </tr>
                           </thead>
                           <tbody>';


                  $cat_query = "SELECT 
                m.cat_name, 
                m.cat_desc, 
                l.qty, 
                h.lg_required_date, 
                h.lg_created_date

                from cat_log l
                inner join cat_master m on m.cat_id = l.cat_id
                inner join log_history h on h.lg_code = l.u_code

                WHERE l.u_code = '$m_code'";

                $rss=odbc_exec($conn,$cat_query);
                $count=1;
                while($q = odbc_fetch_array($rss)){
                  $cat_name = $q['cat_name'];
                  $cat_desc = $q['cat_desc'];
                  $cat_qty = $q['qty'];
                  $cat_req_date = date('Y-m-d',strtotime(trim($q['lg_required_date'])));
                  $cat_order_date = date('Y-m-d',strtotime(trim($q['lg_created_date'])));
                  if($cat_qty == 0){
                                    $cat_quantity = "";
                                    }else{
                                    $cat_quantity = $cat_qty;  
                                    }
                                 
                        $body .= " <tr>
                                          
                                          <td>{$count}</td>
                                          <td>{$cat_name}</td>
                                          <td>{$cat_desc}</td>
                                          <td>{$cat_quantity}</td>
                                          <td>{$cat_req_date}</td>
                                          <td>{$cat_order_date}</td>";
                                          

                      
                  $body .= "</tr>";
                          $count++;
                         }

                  $body .= " </tbody>
                  </table>
          <br><br>
                  
                        
                  <p><b>Order Remarks:</b>&nbsp; $m_remarks</p>
                  
                  <br><br><br>
                  <div>
                  Regards,<br>
                  Administrator - IT <br>
                  Orient Bell Limited
                  </div>
                  </body></html>";

                  require 'PHPMailer/PHPMailerAutoload.php';

                     $mail = new PHPMailer();
  
                          //Enable SMTP debugging.
                          //$mail->SMTPDebug = 1;
                          //Set PHPMailer to use SMTP.
                          $mail->isSMTP();
                          //Set SMTP host name
                          $mail->Host = "smtp.logix.in";
                          $mail->SMTPOptions = array(
                                            'ssl' => array(
                                                'verify_peer' => false,
                                                'verify_peer_name' => false,
                                                'allow_self_signed' => true
                                            )
                                        );
                          //Set this to true if SMTP host requires authentication to send email
                          $mail->SMTPAuth = TRUE;
                          //Provide username and password
                          $mail->Username = "donotreply@orientbell.com";
                          $mail->Password = "Orient@2019";
                          //If SMTP requires TLS encryption then set it
                          $mail->SMTPSecure = "tls";
                          $mail->Port = 587;
                          

                          
                          
                          $mail->setFrom('donotreply@orientbell.com', 'Administrator - MKT');
                         // $mail->addCC($m_email);

                         
                          
                          //$mail->addAddress($to);
                          $mail->addAddress($to);
                          
                          $mail->isHTML(true);
                         
                          $mail->Subject = $subject;
                          $mail->Body = $body;
                          $mail->AltBody = "This is the plain text version of the email content";
                          if(!$mail->send())
                          {
                           echo "Mailer Error: " . $mail->ErrorInfo;
                          }
                          else
                          {
                           $msg = "An Email has been sent to your Registerd Email ID";
                          }   
          // query ends
          $msgTxt = 'Details Updated Successfully';
          $msgType = 1;
        }else{
          $msgTxt = 'Sorry! Unable To Update Details, Please Try Later.';
          $msgType = 2;
          $fchk++;
        }
        header('Location:cat_history.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));

         }



         

         //print_r($_POST);
      ?>



<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div class="row-fluid">
               <div class="span12">
                  <div class="portlet box light-grey" id="form_wizard_1">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i> Catalogue Wizard - <span class="step-title">Step 1 of 4</span>
                        </h4>
                        <div class="tools hidden-phone">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="form-horizontal" onsubmit="return submitform()" name="myform" id="myForm">
                           <div class="form-wizard">
                              <div class="navbar steps">
                                 <div class="navbar-inner">
                                    <ul class="row-fluid">
                                       <li class="span3">
                                          <a href="#tab1" data-toggle="tab" class="step active">
                                          <span class="number">1</span>
                                          <span class="desc"><i class="icon-ok"></i> Address Info</span>   
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab2" data-toggle="tab" class="step">
                                          <span class="number">2</span>
                                          <span class="desc"><i class="icon-ok"></i> Personal Info</span>   
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab3" data-toggle="tab" class="step">
                                          <span class="number">3</span>
                                          <span class="desc"><i class="icon-ok"></i> Catalogue Wizard</span>   
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab4" data-toggle="tab" class="step">
                                          <span class="number">4</span>
                                          <span class="desc"><i class="icon-ok"></i> Confirm</span>   
                                          </a> 
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div id="bar" class="progress progress-success progress-striped">
                                 <div class="bar"></div>
                              </div>
                              <div class="tab-content">
                                 <div class="tab-pane active" id="tab1">
                                    <h3 class="block">Provide your Branch details</h3>
                                    <div class="control-group">
                                       <label class="control-label">City<span class="required">*</span></label>
                                       <div class="controls">
                                          <select class="chosen-with-diselect m-wrap span3" tabindex="-1" name="city" id="city" required>
                                             <option value="">- Select -</option>
                                             <?php
                                             $dt = "SELECT * from city_master order by city ASC";
                                             $dt_result = odbc_exec($conn, $dt);
                                             while($dtr = odbc_fetch_array($dt_result)) {
                                                /*$city = $dtr['city'];*/
                                                //$selected=($dtr['city']==$dataArray['city'])?'selected':'';
                                                echo '<option value = "'.$dtr['id'].'" '.$selected.'>'.$dtr['city'].'</option>';
                                             }
                                           ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                             <label class="control-label" for="State">State:</label>
                                             <div class="controls">
                                                <span class="text" name="state" id="state" style="font-weight: bold; color: red;"></span>
                                             </div>
                                          </div>
                                    <div class="control-group">
                                             <label class="control-label" for="territory">Territory:</label>
                                             <div class="controls">
                                                <span class="text" name="territory" id="territory" style="font-weight: bold; color: red;"></span>
                                             </div>
                                          </div>
                                 </div>
                                 <div class="tab-pane" id="tab2">
                                    <h3 class="block">Provide your Personal details</h3>

                                    <!-- radio button  -->
                                  <div class="control-group">
                                       <label class="control-label"></label>
                                       <div class="controls">
                                          <label class="radio">
                                          <div class="radio" id="uniform-undefined"><span class=""><input type="radio" name="radiobutton" id="current" value="option1" checked="checked"></span></div>
                                          Current
                                          </label>
                                          <label class="radio">
                                          <div class="radio" id="uniform-undefined"><span class=""><input type="radio" name="radiobutton" value="option2" id="other"></span></div>
                                          Other
                                          </label>  
                                          
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Address<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left" id="address1">
                                             <i class="icon-edit"></i>
                                             <input class="span6 m-wrap " type="text" name="address" id="address" placeholder="Complete Address with PIN No for Dispatch.." value="<?php echo $fullname; ?>" disabled> 
                                          </div>
                                          <div class="input-icon left" id="address2">
                                             <i class="icon-edit"></i>
                                             <input class="span6 m-wrap " type="text" name="address" id="address" placeholder="Complete Address with PIN No for Dispatch.."> 
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Remarks<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="span6 m-wrap" rows="3" name="remarks" placeholder="Kindly Put Your Relevent Remarks.."></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab3">
                                    <h3 class="block">Catalogue Selection</h3>
                            <!-- <div class="control-group">
                                       <label class="control-label">Select Plant</label>
                                       <div class="controls">
                                          <select class="span6 chosen chzn-done" tabindex="-1" name="plant" id="plant" required onchange="getCat();">
                                             <option value="">- Select -</option>
                                             <option value="all">Select All</option>
                                             <?php
                                             $dt = "SELECT distinct cat_plant from cat_master where cat_status = 1 order by cat_plant ASC";
                                             $dt_result = odbc_exec($conn, $dt);
                                             while($dtr = odbc_fetch_array($dt_result)) {
                                                /*$city = $dtr['city'];*/
                                                //$selected=($dtr['city']==$dataArray['city'])?'selected':'';
                                                echo '<option value = "'.$dtr['cat_plant'].'" '.$selected.'>'.$dtr['cat_plant'].'</option>';
                                             }
                                           ?>
                                          </select>
                                       </div>
                                    </div> -->
                                    <hr>

                  <!-- <div class="control-group"> -->



                     <?php

                     $sql = "SELECT * from cat_master where cat_status = 1 order by cat_plant desc";
                     $rs=odbc_exec($conn,$sql);
                     while($f = odbc_fetch_array($rs)){
                     ?>

                    <div id="catList">
                      <div class="row-fluid span3">
                     <label class="checkbox line">
                                          <!-- <div class="checker" id="uniform-undefined"><span><input type="checkbox" value="<?php echo $f['cat_id']; ?>" name="catalogue_name[]" style="opacity: 0;" id="<?php echo $f['cat_title']; ?>"></span></div> <?php echo $f['cat_title']; ?> -->
                     
                     
                     <div class="tile double" style="background: <?php echo $f['cat_color']; ?>">
                      
                        <!-- <div class="IJsqo" style="background: rgb(250, 74, 91); color: rgb(255, 255, 255); border-color: rgb(209, 42, 59) transparent;"><div class="_1kXWW">New</div></div> -->
                        <div class="tile-body">
                          <div class="checker" id="uniform-undefined"><span><input type="checkbox" value="<?php echo $f['cat_id']; ?>" name="catalogue_name[]" style="opacity: 0;" id="<?php echo $f['cat_title']; ?>"></span></div>

      <?php 

                    if($f['cat_type'] == 'New'){
                          echo '<span class="badge badge-important pull-right" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">'.$f["cat_type"].'</span>';                      
                    }else if($f['cat_type'] == 'Promoted'){
                          echo '<span class="badge badge-info pull-right" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">'.$f["cat_type"].'</span>';
                    }else{
                          echo '<span class="badge badge-success pull-right" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">'.$f["cat_type"].'</span>';
                    }

      ?>

                                <!-- <span class="badge badge-important pull-right"><?php echo $f['cat_type']; ?></span> -->
                                 <a href="<?php echo "assets/Cataloge Cover Pages/".$f['cat_img'].".jpg"; ?>" target="_blank">
                                 <img src="<?php echo "assets/Cataloge Cover Pages/".$f['cat_img'].".jpg"; ?>" alt="" style="height: 85px; border-radius: 100px;"></a>
                                 <h4 style="margin-top: 15px;"><b><?php echo $f['cat_name']; ?></b></h4>
                                 <p>
                                    <!-- <?php echo $f['cat_desc']; ?> -->
                                 </p>
                        </div>
                        <div class="tile-object">
                                 <div class="name">
                                    <?php echo $f['cat_plant']; ?>
                                 </div>
                                 <div class="number">
                                    <?php echo date('M, Y',strtotime(trim($f['cat_date'])))?>
                                 </div>
                        </div>

                     </div>
                     </label>
                     </div>
                  </div>
  
            <?php 

               }
            ?>
                     
                  <!-- </div> -->



                  



                                    
                                 </div>
                                 <div class="tab-pane" id="tab4">
                                    <h3 class="block">Details Confirmation</h3>
                                    <div class="form-horizontal form-view">
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="FullName">Name:</label>
                                             <div class="controls">
                                                <span class="text" id="f_name"><?php echo $fullname; ?></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="State">State:</label>
                                             <div class="controls">
                                                <span class="text" id="state_name"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Email ID:</label>
                                             <div class="controls">
                                                <span class="text" id="e_mail"><?php echo $emp_email; ?></span> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contact No:</label>
                                             <div class="controls">
                                                <span class="text bold" id="c_no"><?php echo $contact; ?></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->        
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Employee Code:</label>
                                             <div class="controls">
                                                <span class="text bold" id="e_code"><?php echo $emp_code; ?></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <!-- <div class="control-group">
                                             <label class="control-label">Required Date:</label>
                                             <div class="controls">                                                
                                                <span class="text bold" id="r_date"></span>
                                             </div>
                                          </div> -->
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->                               
                                    <h3 class="form-section">Information</h3>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                             <label class="control-label">Catalogue Selection:</label>
                                             <div class="controls">
                                                

                                                <span class="text" id="catName"></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">City:</label>
                                             <div class="controls">
                                                <span class="text" id="city_name"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">Territory:</label>
                                             <div class="controls">
                                                <span class="text" id="territory_name"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->           
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                             <label class="control-label">Address:</label>
                                             <div class="controls">
                                                <span class="text" id="add"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       <!--/span-->
                                    </div>
                                    
                                 </div>
                                 </div>
                              </div>
                              <div class="form-actions clearfix">
                                 <a href="javascript:;" class="btn button-previous">
                                 <i class="m-icon-swapleft"></i> Back 
                                 </a>
                                 <a href="javascript:;" class="btn blue button-next" id="continue" name="continue" type="submit">
                                 Continue <i class="m-icon-swapright m-icon-white"></i>
                                 </a>
                                 <img src="assets/img/loader_01.gif" alt="loader1" style="display:none; height:30px; width:auto; margin-left: 10px;" id="loaderImg" class="loaderImg">
                                 <button type="submit" name="formsubmit" class="btn green button-submit" id="new_button">
                                 Submit <i class="m-icon-swapright m-icon-white"></i>
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>

        </div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>

   <?php include_once('including/footer.php')?>
   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <!-- <script src="assets/js/jquery-1.8.3.min.js"></script>  -->   
   <script src="assets/breakpoints/breakpoints.js"></script>       
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   <script src="assets/js/jquery.blockui.js"></script>
   <script src="assets/js/jquery.cookie.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="assets/js/excanvas.js"></script>
   <script src="assets/js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   
  
   <script src="assets/js/app.js"></script>     
   <script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
      });
   </script>
   <script>
      $(document).ready(function(){
         $("#city").change(function(){
            var st = $('select#city').children("option:selected").val();

            $.ajax({
               url: 'fetch_state.php',
               type: 'post',
               data: {st:st},
               dataType: 'json',
               success:function(response){
                  var len = response.length;
                  $('#state').empty();
                  for(var i = 0; i<len; i++){
                     var state = response[i]['state'];
                     $("#state").text(state);
                     $("#state_name").text(state);
                  }
               }
            });
         });


         $("#city").change(function(){
            var st = $('select#city').children("option:selected").val();

            $.ajax({
               url: 'fetch_territory.php',
               type: 'post',
               data: {st:st},
               dataType: 'json',
               success:function(response){
                  var len = response.length;
                  $('#territory').empty();
                  for(var i = 0; i<len; i++){
                     var territory = response[i]['territory'];
                     $("#territory").text(territory);
                     $("#territory_name").text(territory);
                  }
               }
            });
         });

         $("#city").change(function(){
            var st = $('select#city').children("option:selected").val();

            $.ajax({
               url: 'fetch_name.php',
               type: 'post',
               data: {st:st},
               dataType: 'json',
               success:function(response){
                  var len = response.length;
                  $('#city_name').empty();
                  for(var i = 0; i<len; i++){
                     var city_name = response[i]['city'];
                     $("#city_name").text(city_name);
                     
                  }
               }
            });
         });

      });
   </script>

  <script>
   $(document).ready(function(){

      $('#full_name').keyup(function() {
      $('#f_name').text($(this).val());
      });

      $('#email').keyup(function() {
      $('#e_mail').text($(this).val());
      });

      $('#contact').keyup(function() {
      $('#c_no').text($(this).val());
      });

      $('#emp_code').change(function() {
        if(!$(this).val() || $(this).val() == ''){
          alert("Input Value");
          return false;
        }else{
          $('#e_code').text($(this).val());    
        }
      
      });

      /*$('#required_date').keyup(function() {
      $('#r_date').text($(this).val());
      });*/

      $('#address').keyup(function() {
      $('#add').text($(this).val());
      });

     

      $('#city').change(function() {
      var territory = $('#territory').val();
      $('#territory_name').text($(territory).val());
      });


      /*$("#required_date").change(function() {
    var dateShow = $(this).date-picker("getDate");
    $("#r_date").text(dateShow);

    });*/
  
   });
    </script>
  
    <script type="text/javascript">
      $(document).ready(function(){
        $(function() {
            $( "#required_date" ).datepicker();
                $("#required_date").on("change",function(){
                var selected = $(this).val();
                $('#r_date').text(selected);
            });
        });
      });
        
    </script>
   

    <script type="text/javascript">
  function submitform()
  {
 
 
  var checkboxs=document.getElementsByName("catalogue_name[]");
    var okay=0;
    for(var i=0,l=checkboxs.length;i<l;i++)
    {
        if(checkboxs[i].checked)
        {
            okay++;
      }
    }
   
 if(okay > 0)
    document.myform.submit();
  else
    alert("Please Select Checkbox to Select catalogue.");
    /*return false;*/
}
</script>

<script>
  $(document).ready(function(){
      var items = ["#9062aa", "#3fb4e9", "#6fc063", "#d94949", "#f8951e", "#7a564a", "#029688", "#2d2f79", "#e81f63"];
      var index = 0;
      var color;
      $(".ooicon").each(function() {
        if (index == items.length)
          index = 0;

        color = items[index];
        $(this).css('background', color);
        index++;
      });
  });
</script>

<script type="text/javascript">
  
    $(document).ready(function(){
        var catname = '';      
        $('input[type="checkbox"]').click(function(){
          var flafCatname = [];
            if($(this).prop("checked") == true){
                /*var test = 'vikas';*/
            $.each($("input[type='checkbox']:checked"), function(){            
                flafCatname.push($(this).attr('id'));
            });
            var catName  = flafCatname.join(", ");
            var itemId = catName.substring(1, catName.length);
            
            }
            /*alert(itemId);*/
             if($(this).prop("checked") == false){
              /*alert("test");*/

                $.each($("input[type='checkbox']:not(:checked)"), function(){            
                  var itemId = itemId.replace($(this).attr('id'),'');


            });
                
                //alert("Checkbox is unchecked.");
            }
            $('#catName').text(itemId);
        });
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#myForm').submit(function() {
     $('#loaderImg').show();
     $('#new_button').hide(); 
      return true;
    });
});
  </script>

  <script>
    $(document).ready(function(){
      $("#address2").hide();
      $("#other").click(function(){
        $("#address1").hide();
        $("#address2").show();
        return true;
      });
      $("#current").click(function(){
        $("#address1").show();
        $("#address2").hide();
        return true;
      });
    });
  </script>


   <!-- END JAVASCRIPTS -->   
</body>


<!-- END BODY -->

