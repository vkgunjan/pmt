<?php 
$master='active';
$pm='active';
include_once('including/all-include.php');
include_once('including/header.php');

	$pid=(int)$_REQUEST['pid'];		


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update Plant / Building Details ';
		
		$btsel="select * from plant_building_master where plant_building_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					'plant_building_id'				=>	trim(dbOutput($f['plant_building_id'])),
					'plant_building_name'			=>	trim(dbOutput($f['plant_building_name']))
			);


		//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add Plant/Building';

	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'plant_building_name'				=>	trim(dbOutput($_POST['plant_building_name']))
				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['plant_building_name'])){
		 $errorArray['plant_building_name']='Enter Plant/ Building Name';
	}elseif(empty($pid)){
				$bt="select * from plant_building_master where plant_building_name='".dbInput($dataArray['plant_building_name'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['plant_building_name']='Plant / Building Allready Exist...';
				}
		}

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE plant_building_master set plant_building_name='".dbInput($dataArray['plant_building_name'])."' ";
		 $upd .="where plant_building_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Plant / Building Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Plant / Building Details , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO plant_building_master (plant_building_name, factory_id)";
				$insert .="values('".dbInput($dataArray['plant_building_name'])."', '".dbInput($_SESSION['factory-id'])."' ) ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Plant / Building Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Plant / Building Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				header('Location:plant-building-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;

	}//empty error array check ends here
}//main post end here	

?>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480"><?php echo $formType?></span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                              <li><a href="#portlet_tab2" data-toggle="tab">List Plant / Building</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add Plant / Building</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        
                                    <div class="control-group">
                                       <label class="control-label">Plant / Building Name</label>
                                       <div class="controls">
                                          <input type="text" name="plant_building_name" placeholder="" class="m-wrap large" value="<?php echo $dataArray['plant_building_name']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['plant_building_name']?></div>
                                       </div>
                                    </div>
                                                                        
                                    
                                    <div class="form-actions">
                                       <button type="submit" name="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                                 <!-- ADD FACTORY ENDS -->  
                              </div>
                                 <!-- LIST FACTORY START -->  
                              <div class="tab-pane " id="portlet_tab2">
                                 <div class="portlet box red">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>Plant List </h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Plant ID</th>
											<th>Plant Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									<?php
									$sql="select * from plant_building_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['plant_building_id'].'</td>';
										echo '<td>'.$f['plant_building_name'].'</td>';																
									echo '<td>';
										echo '<a href="plant-building-master.php?pid='.$f['plant_building_id'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
										echo '&nbsp;&nbsp;<a href="plant-building-master.php?delid='.$f['plant_building_id'].'" class="btn mini black"><i class="icon-trash"></i> Delete</a>';
									echo '</td>';
										$count++;
									}
									?>

									</tbody>
								</table>
							</div>
						</div>
                              </div>
                                 <!-- LIST FACTORY ENDS -->  
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