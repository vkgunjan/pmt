<?php 
	        $am='active';
	        $la='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
   
   if(isset($_REQUEST['submit'])){
  //print_r($_POST);


  $checklist=implode(',',$_REQUEST['checklist']);
 //   exit;
 

	
   		
		$up="update schedule set check_list_id='".$checklist."' where schedule_id='".$_REQUEST['s_id']."'";
		
			
				//echo $insert;
				//exit;
			$stmt = odbc_prepare($conn, $up);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Schedule Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Schedule Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}

				//	header('Location:schedule-maintenance.php?pid='.$_POST['pid'].'&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
					//exit;
				
		
   
   }
   
   
        ?>
<script src="assets/js/jquery-1.11.3.min.js"></script>

<script>
function submitcheck(){


 var checkboxs=document.getElementsByName("checklist[]");
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
	else{
	  alert("Please select at least 1 checklist.");
	  return false;
	}
	  
}
</script>
           
 <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                          <h4><i class="icon-edit"></i>Update Checklist</h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">

								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Checklist Update </a></li>			
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
                                            <th>Asset Code</th>
											<th>Type</th>
											<th>Name</th>
											<th>Plant / Building	</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>Area</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		$sql="SELECT a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.[asset_type] as asset_type_id
	  ,a.model_number,
	  a.serial_number,
	 a.asset_kept_area
	  ,atm.asset_type
      ,pbm.[plant_building_name]
      ,dsm.[department_section_name]
      ,lm.[location_name]
       from asset_master a
	   left join asset_type_master atm on a.asset_type=atm.asset_type_id
	   left join plant_building_master pbm on a.plant_building = pbm.plant_building_id
	   left join department_section_master dsm on a.department_section = dsm.department_section_id
	   left join location_master lm on a.asset_location = lm.location_master_id
     where a.factory_id='".$_SESSION['factory-id']."' and asset_id='".$_REQUEST['pid']."'
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
										//echo '<input type="text" name="asset_type_id" id="asset_type_id" value="'.$f['asset_type_id'].'">';
										$_SESSION['checklist_asset_type_id']=$f['asset_type_id'];
									}
									?>
       
									</tbody>
								</table>
                                
                     
                                  <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											<th>Code</th>
											<th>Maintenance Type</th>
											<th>Start Date</th>
											<th>Recurence Schedule</th>
											<th>Day / Date</th>                                            
											<th>Frequency</th>											
                                            <th>Month</th>
                                        </tr>

									</thead>
									
                                    
                                    <tbody>
                                    
							
       <?php
		$sql="select a.asset_code, m.maintenance_type, s.schedule_id,s.check_list_id, s.activation_date, s.recurrence_schedule, s.[day], s.frequency, s.[month] 
 from schedule s 
 left join asset_master a on s.asset_id=a.asset_id
 left join maintenance_type_master m on m.maintenance_type_id=s.maintenance_type_id 
 

     where a.factory_id='".$_SESSION['factory-id']."' and s.asset_id='".$_REQUEST['pid']."'
	 and s.schedule_id='".$_REQUEST['s_id']."'
	 ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
								
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$f['asset_code'].'</td>';
										echo '<td>'.$f['maintenance_type'].'</td>';										
										echo '<td>'.$f['activation_date'].'</td>';																
										echo '<td>'.ucfirst($f['recurrence_schedule']).'</td>';	
										
										if(trim($f['recurrence_schedule'])=='weekly'){
											$arr=array('Monday','Tuesday','Wednesday','Thrusday','Friday','Saturday','Sunday');
											$v=$f['day']-1;
											echo '<td>'.$arr[$v].'</td>';
										}else{
											echo '<td>'.$f['day'].'</td>';
										}
										echo '<td>'.$f['frequency'].'</td>';
										echo '<td>'.$f['month'].'</td>';

										

										echo '<tr>';
										
											echo '<th>';
												echo 'Select Checklist';
											echo '</th>';
											
											echo '<td colspan="6" style="text-align:justify; ">';
					echo "<form action='".$_SERVER['PHP_SELF']."' method=post>";
							$checklist_asset_type_id=$_SESSION['checklist_asset_type_id'];
										$ssql="select * from checklist_master where asset_type_id='".$checklist_asset_type_id."' ";	

										$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
							//vks$$$
							 $ssqla="select * from schedule where schedule_id='".$_REQUEST['s_id']."' and check_list_id like '%".$f['checklist_id']."%' ";
									$rrsa=odbc_exec($conn,$ssqla);
									if(odbc_num_rows($rrsa)){
										 $ss='checked';
									}else{
										 $ss='';
									}
							//vks....
							
							echo '<input type="checkbox" name="checklist[]" value="'.$f['checklist_id'].'" '.$ss.'>'.$f['checklist_name'].' ';				
												//echo '<br>';
												}
														
											echo '</td>';

								
										
									}
									?>
<span style="float:right;">
   <input type="submit" name="submit" onclick="return submitcheck()" value="Save Checklist" style="background-color:#039F2D; color:#F3F3F3">
   &nbsp;&nbsp;
   <a href="schedule-maintenance.php?pid=<?php echo $_REQUEST['pid'];?>"> <input type="button" value="Back" style="background-color:#DE31E8; color:#F3F3F3"></a>
&nbsp;&nbsp;
</span> 
      
     
      
      <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>">
            <input type="hidden" name="s_id" value="<?php echo $_REQUEST['s_id']?>">
            
       </form>
									</tbody>
                                    
                                   
								</table>
                                
                           <hr>

                           

                                </div>
                                
                                 </form>


                                 <!-- tab 1, asset detail ends -->  
                              </div>
                                 
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
            </div>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- END CONTAINER -->
   <?php include_once('including/footer.php')?>
   <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
			$ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>