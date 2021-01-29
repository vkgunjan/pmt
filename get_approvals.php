<?php 
include_once('including/all-include.php');
        include_once('including/header.php');
        include('including/datetime.php');
        include('plant_function.php');
        $timestamp=date('Y-m-d H:i:s');
        $timestamp1=date('YmdHis');
        $uid = $_SESSION['uid'];
?>

<?php 
      if (isset($_POST['submit'])) {
        $file = $_FILES["file"]['name'];
        $div = explode('.', $file);
        $file_ext = strtolower(end($div));
        $unique_file = $timestamp1.'.'.$file_ext;
        $Target="assets/img/upload/".$unique_file;
        $dataArray=array(
          'cp'                        =>  trim(dbOutput($_POST['cp'])),
          'tile_category'             =>  trim(dbOutput($_POST['tile_category'])),
          'sku_size'                  =>  trim(dbOutput($_POST['sku_size'])),
          'o_source'                  =>  trim(dbOutput($_POST['o_source'])),
          'c1_source'                 =>  trim(dbOutput($_POST['c1_source'])),
          'c2_source'                 =>  trim(dbOutput($_POST['c2_source'])),
          'o_price'                   =>  trim(dbOutput($_POST['o_price'])),
          'c1_price'                  =>  trim(dbOutput($_POST['c1_price'])),
          'c2_price'                  =>  trim(dbOutput($_POST['c2_price'])),
          'o_discount'                =>  trim(dbOutput($_POST['o_discount'])),
          'c1_discount'               =>  trim(dbOutput($_POST['c1_discount'])),
          'c2_discount'               =>  trim(dbOutput($_POST['c2_discount'])),
          'o_thickness'               =>  trim(dbOutput($_POST['o_thickness'])),
          'c1_thickness'              =>  trim(dbOutput($_POST['c1_thickness'])),
          'c2_thickness'              =>  trim(dbOutput($_POST['c2_thickness'])),
          'o_tile'                    =>  trim(dbOutput($_POST['o_tile'])),
          'c1_tile'                   =>  trim(dbOutput($_POST['c1_tile'])),
          'c2_tile'                   =>  trim(dbOutput($_POST['c2_tile'])),
          'o_weight'                  =>  trim(dbOutput($_POST['o_weight'])),
          'c1_weight'                 =>  trim(dbOutput($_POST['c1_weight'])),
          'c2_weight'                 =>  trim(dbOutput($_POST['c2_weight'])),
          'o_area'                    =>  trim(dbOutput($_POST['o_area'])),
          'c1_area'                   =>  trim(dbOutput($_POST['c1_area'])),
          'c2_area'                   =>  trim(dbOutput($_POST['c2_area'])),
          'o_factory_price'           =>  trim(dbOutput($_POST['o_factory_price'])),
          'c1_factory_price'          =>  trim(dbOutput($_POST['c1_factory_price'])),
          'c2_factory_price'          =>  trim(dbOutput($_POST['c2_factory_price'])),
          'o_ins'                     =>  trim(dbOutput($_POST['o_ins'])),
          'o_ins_value'               =>  trim(dbOutput($_POST['o_ins_value'])),
          'c1_ins'                    =>  trim(dbOutput($_POST['c1_ins'])),
          'c1_ins_value'              =>  trim(dbOutput($_POST['c1_ins_value'])),
          'c2_ins'                    =>  trim(dbOutput($_POST['c2_ins'])),
          'c2_ins_value'              =>  trim(dbOutput($_POST['c2_ins_value'])),
          'o_gst'                     =>  trim(dbOutput($_POST['o_gst'])),
          'c1_gst'                    =>  trim(dbOutput($_POST['c1_gst'])),
          'c2_gst'                    =>  trim(dbOutput($_POST['c2_gst'])),
          'o_freight'                 =>  trim(dbOutput($_POST['o_freight'])),
          'c1_freight'                =>  trim(dbOutput($_POST['c1_freight'])),
          'c2_freight'                =>  trim(dbOutput($_POST['c2_freight'])),
          'o_transport_type'          =>  trim(dbOutput($_POST['o_transport_type'])),
          'c1_transport_type'         =>  trim(dbOutput($_POST['c1_transport_type'])),
          'c2_transport_type'         =>  trim(dbOutput($_POST['c2_transport_type'])),
          'o_load'                    =>  trim(dbOutput($_POST['o_load'])),
          'c1_load'                   =>  trim(dbOutput($_POST['c1_load'])),
          'c2_load'                   =>  trim(dbOutput($_POST['c2_load'])),
          'o_total_freight'           =>  trim(dbOutput($_POST['o_total_freight'])),
          'c1_total_freight'          =>  trim(dbOutput($_POST['c1_total_freight'])),
          'c2_total_freight'          =>  trim(dbOutput($_POST['c2_total_freight'])),
          'o_total'                   =>  trim(dbOutput($_POST['o_total'])),
          'c1_total'                  =>  trim(dbOutput($_POST['c1_total'])),
          'c2_total'                  =>  trim(dbOutput($_POST['c2_total'])),
          'remarks'                   =>  trim(dbOutput($_POST['remarks'])),


        );

        $sql = "INSERT INTO comp_price values (
               '".dbInput($dataArray['cp'])."',
               '".dbInput($dataArray['tile_category'])."',
               '".dbInput($dataArray['sku_size'])."',
               '".dbInput($dataArray['o_source'])."',
               '".dbInput($dataArray['c1_source'])."',
               '".dbInput($dataArray['c2_source'])."',
               '".dbInput($dataArray['o_price'])."',
               '".dbInput($dataArray['c1_price'])."',
               '".dbInput($dataArray['c2_price'])."',
               '".dbInput($dataArray['o_discount'])."',
               '".dbInput($dataArray['c1_discount'])."',
               '".dbInput($dataArray['c2_discount'])."',
               '".dbInput($dataArray['o_thickness'])."',
               '".dbInput($dataArray['c1_thickness'])."',
               '".dbInput($dataArray['c2_thickness'])."',
               '".dbInput($dataArray['o_tile'])."',
               '".dbInput($dataArray['c1_tile'])."',
               '".dbInput($dataArray['c2_tile'])."',
               '".dbInput($dataArray['o_weight'])."',
               '".dbInput($dataArray['c1_weight'])."',
               '".dbInput($dataArray['c2_weight'])."',
               '".dbInput($dataArray['o_area'])."',
               '".dbInput($dataArray['c1_area'])."',
               '".dbInput($dataArray['c2_area'])."',
               '".dbInput($dataArray['o_factory_price'])."',
               '".dbInput($dataArray['c1_factory_price'])."',
               '".dbInput($dataArray['c2_factory_price'])."',
               '".dbInput($dataArray['o_ins'])."',
               '".dbInput($dataArray['o_ins_value'])."',
               '".dbInput($dataArray['c1_ins'])."',
               '".dbInput($dataArray['c1_ins_value'])."',
               '".dbInput($dataArray['c2_ins'])."',
               '".dbInput($dataArray['c2_ins_value'])."',
               '".dbInput($dataArray['o_gst'])."',
               '".dbInput($dataArray['c1_gst'])."',
               '".dbInput($dataArray['c2_gst'])."',
               '".dbInput($dataArray['o_freight'])."',
               '".dbInput($dataArray['c1_freight'])."',
               '".dbInput($dataArray['c2_freight'])."',
               '".dbInput($dataArray['o_transport_type'])."',
               '".dbInput($dataArray['c1_transport_type'])."',
               '".dbInput($dataArray['c2_transport_type'])."',
               '".dbInput($dataArray['o_load'])."',
               '".dbInput($dataArray['c1_load'])."',
               '".dbInput($dataArray['c2_load'])."',
               '".dbInput($dataArray['o_total_freight'])."',
               '".dbInput($dataArray['c1_total_freight'])."',
               '".dbInput($dataArray['c2_total_freight'])."',
               '".dbInput($dataArray['o_total'])."',
               '".dbInput($dataArray['c1_total'])."',
               '".dbInput($dataArray['c2_total'])."',
               '".dbInput($dataArray['remarks'])."',
               '".dbInput($unique_file)."',
               '".dbInput($uid)."',
               '".dbInput($timestamp)."'



      )";

              $stmt = odbc_prepare($conn, $sql);
              $result = odbc_execute($stmt);
              move_uploaded_file($_FILES["file"]['tmp_name'], $Target);

              if ($result) {
                $msgTxt = 'Competitor Price Added Successfully';
                $msgType = 1;
              }else{
                $msgTxt = 'Sorry! Unable To Add Competitor Price. Please Try Later.';
                $msgType = 2;
          }

          header('Location:comp_price.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
          exit;
      }
?>


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> -->
<div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">GET Approval Documents</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <li><a href="#portlet_tab2" data-toggle="tab">Add Documents</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">List Documents</a></li>			

                           </ul>

                      <!-- tab 1 asset details start --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <!-- <input type="hidden" name="pid" value="<?php echo $pid?>">  -->
									               
                                 </form>
                                 <!-- tab 1, asset detail ends -->  
                              </div>
                              <div class="tab-pane " id="portlet_tab2">

        
<!--               <div class="portlet-title">
  <h4><i class="icon-cogs"></i>Competitor List</h4>
  <div class="tools">
  </div>
</div> -->
              <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Channel Partner</th>
                      <th>City</th>
                      <th>Tile Category</th>
                      <th>SKU Size</th>
                      <th>OBL Plant</th>
                      <th>OBL List Price</th>
                      <th>Comp1</th>
                      <th>Comp1-Price</th>
                      <th>Comp2</th>
                      <th>Comp2-Price</th>
                      <th>Created By</th>                      
                      <th>Created On</th>
                      <th>File</th>
                                        
                                                                                   
                                            
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $sql="SELECT p.p_name, p.p_city, cp.cp_tile_category, cp.cp_sku_size, pm.plant_name, 
                  cp.o_price, cp.file_path, t.c_name, cp.c1_price, tc.c_name as [c2_name], cp.c2_price, cp.created_on, u.fullname, cp.created_by 
                  from comp_price cp 
                  left join channel_partner p on p.p_id = cp.cp_partner_id
                  left join competitor t on t.c_id = cp.c1_source
                  left join plant_master pm on pm.plant_id = cp.o_source
                  left join competitor tc on tc.c_id = cp.c2_source
                  left join user_management u on u.uid = cp.created_by";

                  if(trim($_SESSION['user_type'])=='management') {
    $sql.="  where 1=1 order by cp.created_on desc  ";
  }else{


      if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'|| $_SESSION['employee_department']=='coco'){
          
          if($_SESSION['user_type']=='manager'){
          $sql.=" where 1=1 
            and ( ";

            $ex=explode(",",$_SESSION['my_team_id']);
              $xcnt=0;
            foreach ($ex as $vx){
            //echo $vx;
              if($xcnt==0)
                $sql .=" cp.created_by = '".$vx."' or cp.created_by='".$_SESSION['uid']."' ";
              else
                $sql .=" or cp.created_by = '".$vx."' ";
              $xcnt++;
            }
            $sql .=" ) order by cp.created_on desc ";
          }else{
            $sql.="  where cp.created_by='".$_SESSION['uid']."' order by cp.created_on desc
             "; 
          }

      }
    
  }
              

                  $rs=odbc_exec($conn,$sql);
                  $count=1;
                  while($f = odbc_fetch_array($rs)){
                    
                    //print_r($f);
                    echo '<tr>';
                    echo '<td>'.$count.'</td>';
                    echo '<td>'.$f['p_name'].'</td>';
                    echo '<td>'.$f['p_city'].'</td>';
                    echo '<td>'.$f['cp_tile_category'].'</td>';                                
                    echo '<td>'.$f['cp_sku_size'].'</td>';
                    echo '<td>'.$f['plant_name'].'</td>';  
                    echo '<td>'.round($f['o_price'],2).'</td>';
                    echo '<td>'.$f['c_name'].'</td>';
                    echo '<td>'.round($f['c1_price'],2).'</td>';
                    echo '<td>'.$f['c2_name'].'</td>';
                    echo '<td>'.round($f['c2_price'],2).'</td>';
                    echo '<td>'.$f['fullname'].'</td>';
                    echo '<td>'.date('d-m-Y',strtotime(trim($f['created_on']))).'</td>';
                    if(!empty($f['file_path'])){ ?>
                      <td>
                      <a href="<?php echo "assets/img/upload/".$f['file_path']; ?>" target="_blank"><i class="icon-download-alt"></i></a>
                      </td>
                 <?php     
                    }else{
                      echo '<td>-</td>'; 
                    }

           
                    $count++;
                  }
                  ?>

                  </tbody>
                </table>
              </div>
            
                              </div>
                                
                                 <!--#################### purchase details part start tab2 ##############################-->  
                                 <!-- tab 2, purchase detail-->  
                             
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
            </div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>


  
   <?php include_once('including/footer.php')?>
    <?php 

      if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
      $ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>

