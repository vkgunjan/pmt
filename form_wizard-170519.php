<?php 
include_once('including/all-include.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
?>

<?php
      
//   print_r($_POST);
      if(isset($_POST['submit'])){
         $city          = $_POST['city'];
         $state         = $_POST['state'];
         $territory     = $_POST['territory'];
         $emp_code      = $_POST['emp_code'];
         $full_name     = $_POST['full_name'];
         $mail          = $_POST['email'];
         $contact       = $_POST['contact'];
         $gender        = $_POST['gender'];
         $required_date = $_POST['required_date'];
         $address       = $_POST['address'];
         $remarks       = $_POST['remarks'];
         //$catalogue     = $_POST['catalogue_name'];


         /*$dataArray=array(
            'state'       => trim(dbOutput($_POST['state'])),
            'territory'       => trim(dbOutput($_POST['territory'])),
            'emp_code'       => trim(dbOutput($_POST['emp_code'])),
            'full_name'       => trim(dbOutput($_POST['full_name'])),
            'mail'       => trim(dbOutput($_POST['mail'])),
            'contact'       => trim(dbOutput($_POST['contact'])),
            'gender'       => trim(dbOutput($_POST['gender'])),
            'required_date'       => trim(dbOutput($_POST['required_date'])),
            'address'       => trim(dbOutput($_POST['address'])),
            'remarks'       => trim(dbOutput($_POST['remarks'])),
            'catalogue_name'       => dbOutput($_POST['catalogue_name']),

         );*/

         $catalogue     = implode($_POST['catalogue_name'], ",");

         $sql = "INSERT INTO log_history values
         (''
           ,'$city'
           ,'$emp_code'
           ,'$full_name'
           ,'$mail'
           ,'$contact'
           ,''
           ,'$gender'
           ,'$required_date'
           ,'$address'
           ,'$remarks'
           ,'itservice@orientbell.com'
           ,'$catalogue'
           ,getdate()
           ,getdate()
           ,'1')
          ";
            $stmt = odbc_prepare($conn, $sql);
            $result = odbc_execute($stmt);
         /*$cat_array = implode(",", '$catalogue');*/

         if ($result) {

            //Email Configuration Start
            //$m_email = "vikash.gunjan@orientbell.com";
            $subject = "OBL-MKT || Catalogue Order Request";
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

                  <p>This is an auto generated Email, Please do not reply. Catalogue order has been requested by <b>$full_name</b> for dispatch. Kindly refer to below details for more clarification.
                  </p>

                  ";

                  $body .= '<table>
                           <thead>
                              <tr>
                                     <th>Territory</th>
                                     <th>State</th>
                                     <th>City</th>
                                     <th>Emp Code</th>
                                     <th>Name</th>
                                     <th>Email ID</th>
                                     <th>Contact No</th>
                                     <th>Catalogue List</th>
                                     <th>Required Date</th>
                                     <th>Address</th>
                                     <th>Order Date</th>
                                          
                                        </tr>
                           </thead>
                           <tbody>';


                  $mail_query = "SELECT top 1
                                       h.lg_id as [log_id],
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
                  
                                 
                                 
                        $body .= " <tr>
                                          
                                          <td>{$m_territory}</td>
                                          <td>{$m_state}</td>
                                          <td>{$m_city}</td>
                                          <td>{$m_emp_code}</td>
                                          <td>{$m_full_name}</td>
                                          <td>{$m_email}</td>
                                          <td>{$m_mobile}</td>
                                          <td>{$m_cat_name}</td>
                                          <td>{$m_required_date}</td>
                                          <td>{$m_address}</td>
                                          <td>{$m_order_date}</td>";
                                          

                      
                  $body .= "</tr>";
                         }

                  $body .= " </tbody>
                  </table>

                  
                  <p><b>Order Remarks:</b>&nbsp; $m_remarks</p>
                  
                  <br><br><br><br><br>
                  <p>Administrator - IT</p>
                  <p>Orient Bell Limited</p>
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
                          $mail->addAddress($m_email);
                          
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

            // Email Configuration End


                $msgTxt = 'Details Updated Successfully';
                $msgType = 1;
              }else{
                $msgTxt = 'Sorry! Unable To Add Catalogue Details. Please Try Later.';
                $msgType = 2;
          }

          header('Location:success.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
          exit;

         //print_r($_POST);
      }
?>


<!-- <!DOCTYPE html>
[if IE 8]> <html lang="en" class="ie8"> <![endif]
[if IE 9]> <html lang="en" class="ie9"> <![endif]
[if !IE]>> <html lang="en"> <![endif]
BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Orientbell | Catalogue Submission Details</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/css/metro.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="assets/css/style.css" rel="stylesheet" />
   <link href="assets/css/style_responsive.css" rel="stylesheet" />
   <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
   <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <div class="header navbar navbar-inverse navbar-fixed-top">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <div class="navbar-inner" style="height: 50px;">
         <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <a class="brand" href="https://orientbell.com/" target="_blank" style="padding: 15px; margin-left: 20px;">
            <img src="assets/img/obl-header-logo.png">
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            
            <!-- END RESPONSIVE MENU TOGGLER -->            
            <!-- BEGIN TOP NAVIGATION MENU -->              
            
            <!-- END TOP NAVIGATION MENU --> 
         </div>
      </div>
      <!-- END TOP NAVIGATION BAR -->
   </div>
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div class="page-container row-fluid">
      <!-- BEGIN SIDEBAR -->
      
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         
         <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                  
                  <!-- END BEGIN STYLE CUSTOMIZER -->   
                  <h3 class="page-title">
                     Catalogue Wizard
                     <small>Request for Catalogue Order</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="#">Orientbell Limited | Online Catalogue Order Form</a> 
                        
                     </li>
                     
                  </ul>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
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
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="form-horizontal">
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
                                    <div class="control-group">
                                       <label class="control-label">Employee Code<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-briefcase"></i>
                                             <input class="span2 m-wrap " type="text" placeholder="Emp Code" id="emp_code" name="emp_code" required="required"> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Full Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-user"></i>
                                             <input class="span3 m-wrap " type="text" placeholder="Full Name" name="full_name" id="full_name"> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Email Address<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-envelope"></i>
                                             <input class="span4 m-wrap " type="text" name="email" id="email" placeholder="Email Address"> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Phone Number<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-phone"></i>
                                             <input class="span3 m-wrap " type="number" placeholder="Phone Number" name="contact" id="contact"> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Gender<span class="required">*</span></label>
                                       <div class="controls">
                                          <label class="radio">
                                          <input type="radio" name="gender" id="optionsRadios1" value="male" checked />
                                          Male
                                          </label>
                                          <!-- <div class="clearfix"></div> -->
                                          <label class="radio">
                                          <input type="radio" name="gender" id="optionsRadios1" value="female" />
                                          Female
                                          </label>  
                                       </div>
                                    </div>
                                    <div class="control-group">
                                    <label class="control-label">Required Date<span class="required">*</span></label>
                                    <div class="controls">
                                       <div class="input-append date date-picker" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                          <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="" name="required_date" id="required_date" style="height: 34px;"><span class="add-on"><i class="icon-calendar" ></i></span>
                                    </div>
                              </div>
                           </div>
                                    <div class="control-group">
                                       <label class="control-label">Address<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
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
               
                  

                  <!-- <div class="control-group"> -->

                     <?php

               $sql = "SELECT * from cat_master";
               $rs=odbc_exec($conn,$sql);
               while($f = odbc_fetch_array($rs)){
               ?>

                     <div class="row-fluid span3">
                     <label class="checkbox line">
                                          <div class="checker" id="uniform-undefined"><span><input type="checkbox" value="<?php echo $f['cat_id']; ?>" name="catalogue_name[]" style="opacity: 0;" id="catalogue_name"></span></div> <?php echo $f['cat_title']; ?>
                     </label>

                     <div class="tile double bg-grey">
                        <div class="tile-body">
                                 <a href="<?php echo "assets/Cataloge Cover Pages/".$f['cat_img'].".jpg"; ?>" target="_blank">
                                 <img src="<?php echo "assets/Cataloge Cover Pages/".$f['cat_img'].".jpg"; ?>" alt="" style="height: 65px; border-radius: 100px;"></a>
                                 <h4><b><?php echo $f['cat_name']; ?></b></h4>
                                 <p>
                                    <?php echo $f['cat_desc']; ?>
                                 </p>
                        </div>
                        <div class="tile-object">
                                 <div class="name">
                                    <?php echo $f['cat_plant']; ?>
                                 </div>
                                 <div class="number">
                                    <?php echo date('d M, Y',strtotime(trim($f['cat_date'])))?>
                                 </div>
                        </div>
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
                                                <span class="text" id="f_name"></span>
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
                                                <span class="text" id="e_mail"></span> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contact No:</label>
                                             <div class="controls">
                                                <span class="text bold" id="c_no"></span>
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
                                                <span class="text bold" id="e_code"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Required Date:</label>
                                             <div class="controls">                                                
                                                <span class="text bold" id="r_date"></span>
                                             </div>
                                          </div>
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
                                                

                                                <span class="text" id="cat"><?php print_r($cat_array_1); ?></span>
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
                                 <button type="submit" name="submit" class="btn green button-submit">
                                 Submit <i class="m-icon-swapright m-icon-white"></i>
                                 </button>
                              </div>
                           </div>
                        </form>
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
   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   <!-- <div class="footer">
      2019 &copy; Orientbell Limited | Design and Develop by OBL IT
      <div class="span pull-right">
         <span class="go-top"><i class="icon-angle-up"></i></span>
      </div>
   </div> -->
   <?php include_once('including/footer.php')?>
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="assets/js/jquery-1.8.3.min.js"></script>    
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

      $('#required_date').keyup(function() {
      $('#r_date').text($(this).val());
      });

      $('#address').keyup(function() {
      $('#add').text($(this).val());
      });

     

      $('#city').change(function() {
      var territory = $('#territory').val();
      $('#territory_name').text($(territory).val());
      });
  
   });
    </script>

 
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>



