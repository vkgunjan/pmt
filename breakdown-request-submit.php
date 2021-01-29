<?php 
	        
	        $bdm='active';
        include_once('including/all-include.php');
        include_once('including/header.php');

if($_POST['submit']){
	//print_r($_POST);

	$in="insert into breakdown_request (asset_id, factory_id, request_generated_by, request_description)
	  values ('".dbInput($_POST['id'])."', '".dbInput($_SESSION['factory-id'])."', 
	  '".dbInput($_SESSION['uid'])."', '".dbInput($_POST['request_text'])."' ) ";
	$p=odbc_prepare($conn, $in);
	if (odbc_execute($p)){ 
		$msgTxt = 'Breakdown request sent successfully.';
		$msgType = 1;
				header('Location:breakdown-request.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;
	}
}

?>
 
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Breakdown Maintenance Request </span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Request Form</a></li>			
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <!-- tab 1 asset details start --> 
                           <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="myform">
                           <input type="hidden" name="id" value="<?php echo trim($_GET['id'])?>">
                           <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
                                            <th>Asset Code</th>
											<th>Type</th>
											<th>Name</th>
											<th>Plant / Building</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>Area</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                            <th>Condition</th>
                                       
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		 $sql="SELECT a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.model_number,
	  a.serial_number,
	 a.asset_kept_area
	  ,atm.asset_type
      ,pbm.[plant_building_name]
      ,dsm.[department_section_name]
      ,lm.[location_name]
	  ,a.[asset_condition]
       from asset_master a
	   left join asset_type_master atm on a.asset_type=atm.asset_type_id
	   left join plant_building_master pbm on a.plant_building = pbm.plant_building_id
	   left join department_section_master dsm on a.department_section = dsm.department_section_id
	   left join location_master lm on a.asset_location = lm.location_master_id
     where a.factory_id='".$_SESSION['factory-id']."' and a.asset_id='".trim($_REQUEST['id'])."'
	 ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$f['asset_code'].'</td>';
										echo '<td>'.$f['asset_type'].'</td>';										
										echo '<td>'.$f['asset_name'].'</td>';																
										echo '<td>'.$f['plant_building_name'].'</td>';	
										echo '<td>'.$f['department_section_name'].'</td>';
										echo '<td>'.$f['location_name'].'</td>';
										echo '<td>'.$f['asset_kept_area'].'</td>';
										echo '<td>'.$f['model_number'].'</td>';
										echo '<td>'.$f['serial_number'].'</td>';
										echo '<td>'.ucfirst($f['asset_condition']).'</td>';
										
										echo '</td>';							
									}
									?>
									</tbody>
					<tr>
                    <th valign="middle">Write  Breakdown Request here</th>
                    <td colspan="9"><textarea name="request_text" style="height:100px; width:900px;resize:none" required></textarea></td>
                    </tr>

					<tr>
                    <td colspan="10" style="text-align:right;"><input type="submit" name="submit" value="Submit Request"></td>
                    </tr>
									
								</table>
                                

                          
                             </form>
                              </div>
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
   <!-- END CONTAINER -->
   <?php include_once('including/footer.php')?>
      <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
			$ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>