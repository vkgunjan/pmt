	
    	<?php 
	        $master='active';
	        $atm='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
       

if(isset($_GET['checklistID']) && $_GET['checklistID']>0){
		$pid = (int)$_GET['checklistID'];
		
		$btsel="delete from checklist_master where checklist_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		if($rs){
			header('location:checklist-master.php?asset_type_id='.$_GET['asset_type_id'].'amtype='.$_GET['asset_type'].'"');
			exit;
		}

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add Checklist for Maintenance';
			
			$dataArray=array(
					'asset_type_id'		=>	trim(dbOutput($_GET['asset_type_id']))
			);
	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'checklist_name'						=>	trim(dbOutput($_POST['checklist_name'])),
					'asset_type_id'					=>	trim(dbOutput($_POST['asset_type_id'])),
				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['checklist_name'])){
		 $errorArray['checklist_name']='Enter Spare Part Name';
	}elseif(empty($pid)){
				$bt="select * from checklist_master where checklist_name='".dbInput($dataArray['checklist_name'])."' and asset_type_id='".dbInput($dataArray['asset_type_id'])."' ";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['checklist_name']='Checklist Allready Exist...';
				}
		}

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

 $upd  ="UPDATE checklist set checklist_name='".dbInput($dataArray['checklist_name'])."'  ";
		 $upd .="where checklist_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Checklist Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Checklist , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO checklist_master (checklist_name, asset_type_id)";
				$insert .="values('".dbInput($dataArray['checklist_name'])."', '".dbInput($dataArray['asset_type_id'])."' ) ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Checklist Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add Checlkist Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				//header('Location:checklist-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			//	exit;

	}//empty error array check ends here
}//main post end here	

	    ?>
  
  <script>
  	function conf(){
		if(confirm('Are you sure to delete checklist'))
			return true;
		else
			return false;
		
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
                           <span class="hidden-480">Maintenance Type Checklist</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Checklist</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">  
<input type="hidden" name="asset_type_id" value="<?php echo $_GET['asset_type_id']?>" >  
<input type="hidden" name="atype" value="<?php echo $_GET['atype']?>" >                                                                        
                                    <div class="control-group">
                                       <label class="control-label">Asset Type</label>
                                       <div class="controls">
 <input type="text"   class="m-wrap medium" value="<?php echo $_GET['atype']?>"  readonly style="background-color:#B9B0B0"/>
                                       </div>
                                    </div>

									                                  
                                     <div class="control-group">
                                       <label class="control-label">Checklist Name</label>
                                       <div class="controls">
 <input type="text" name="checklist_name" placeholder="" class="m-wrap large" value="<?php echo $dataArray['checklist_name']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['checklist_name']?></div>
                                       </div>
                                    </div>

                                    
                                    
                                                                        
                                    <div class="form-actions">
                                       <button type="submit" name="submit"  class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <a href="javascript:window.history.back()"><button type="button" class="btn">Back</a></button>
                                    </div>
                                 </form>
                                 <!-- ADD FACTORY ENDS -->  
                              </div>
                                
                                
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Checklist ID</th>
											<th>Checklist Name</th>
											<th><center>Delete Checklist</center></th>
										</tr>
									</thead>
									<tbody>
										<tr>
									<?php
									$sql="select * from checklist_master where asset_type_id='".$dataArray['asset_type_id']."'";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['checklist_id'].'</td>';
										echo '<td>'.$f['checklist_name'].'</td>';										
									echo '<th><center>';
echo '<a href="checklist-master.php?checklistID='.$f['checklist_id'].'&asset_type_id='.$dataArray['asset_type_id'].'&atype='.$_GET['atype'].'" title="Delete Checklist" onClick="return conf();">';
echo '<input type="button" value="Delete" style="background-color:red; color:white;" >';
echo '</a>';
									echo '</center></th>';
										$count++;
									}
									?>									</tbody>
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