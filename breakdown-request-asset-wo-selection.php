<?php 
	        
	        $bdm='active';
        include_once('including/all-include.php');
        include_once('including/header.php');


?>

<script type="text/javascript">
function submitform()
{
 
	  document.myform.submit();
	
}
</script>
	  

 
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Breakdown / Unscheduled Work Order Generation</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Work Order</a></li>			
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <!-- tab 1 asset details start --> 
                           <form action="breakdown-work-order.php" method="post" name="myform">
                           <input type="hidden" name="asset_id" value="<?php echo trim($_GET['id'])?>">
                          <input type="hidden" name="request_id" value="<?php echo trim($_GET['request_id'])?>">
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
                                            <th>Maintenance Type</th>
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
     where a.factory_id='".$_SESSION['factory-id']."' and a.asset_id='".trim($_GET['id'])."'
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
											echo '<td>';
										echo '<select name="maintenance_type_id" required style="width:140px;" onChange="submitform();">';
                                       		echo '<option value="">-Select-</option>';
									$sql="select * from maintenance_type_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										echo '<option value="'.$f['maintenance_type_id'].'">'.trim($f['maintenance_type']).'</option>';
										}
                                        echo ' </select>';
										echo '</td>';							
									}
									?>
									</tbody>
									
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