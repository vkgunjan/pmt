		<?php 
	        $master='active';
	        $spm='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
       
	   	$pid=(int)$_REQUEST['pid'];		


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update Spare Part Details ';
		
		$btsel="select * from spare_part_master where spare_part_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					'spare_part_id'				=>	trim(dbOutput($f['spare_part_id'])),
					'spare_part_name'			=>	trim(dbOutput($f['spare_part_name'])),
					'uom_id'					=>	trim(dbOutput($f['uom_id'])),
					'unit_cost'					=>	trim(dbOutput($f['unit_cost']))
			);


		print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add Spare Part';

	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'spare_part_name'						=>	trim(dbOutput($_POST['spare_part_name'])),
					'uom_id'								=>	trim(dbOutput($_POST['uom_id'])),
					'unit_cost'								=>	trim(dbOutput($_POST['unit_cost']))
					
				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['spare_part_name'])){
		 $errorArray['spare_part_name']='Enter Spare Part Name';
	}elseif(empty($pid)){
				$bt="select * from spare_part_master where spare_part_name='".dbInput($dataArray['spare_part_name'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['spare_part_name']='Spare Part Allready Exist...';
				}
		}

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

 $upd  ="UPDATE spare_part_master set spare_part_name='".dbInput($dataArray['spare_part_name'])."', uom_id='".dbInput($dataArray['uom_id'])."',    unit_cost='".dbInput($dataArray['unit_cost'])."'  ";
		 $upd .="where spare_part_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Spare Part Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Spare Part , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO spare_part_master (spare_part_name, uom_id, unit_cost)";
				$insert .="values('".dbInput($dataArray['spare_part_name'])."', '".dbInput($dataArray['uom_id'])."', '".dbInput($dataArray['unit_cost'])."' ) ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Spare Part Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Spare Part Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				header('Location:spare-part-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
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
                           <span class="hidden-480">Spare Part Master</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                              <li><a href="#portlet_tab2" data-toggle="tab">List Spare Part</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add Spare Part</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        
                                    <div class="control-group">
                                       <label class="control-label">Spare Part Name</label>
                                       <div class="controls">
 <input type="text" name="spare_part_name" placeholder="" class="m-wrap large" value="<?php echo $dataArray['spare_part_name']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['spare_part_name']?></div>
                                       </div>
                                    </div>


									<div class="control-group">
                                       <label class="control-label">UOM</label>
                                       <div class="controls">
								<select name="uom_id" style="width:140px;" required>
                                       		<option value="">-Select-</option>
                                             <?php
						
								$ssql="select * from uom_master";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$ss=($f['uom_id']==$dataArray['uom_id'])?'selected':'';
										echo '<option value="'.$f['uom_id'].'" '.$ss.'>'.$f['uom_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Unit Cost</label>
                                       <div class="controls">
 <input type="text" name="unit_cost" placeholder="" class="m-wrap small" value="<?php echo $dataArray['unit_cost']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['unit_cost']?></div>
                                       </div>
                                    </div>

                                    
                                    
                                                                        
                                    <div class="form-actions">
                                       <button type="submit" name="submit"  class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                                 <!-- ADD FACTORY ENDS -->  
                              </div>
                                 <!-- LIST FACTORY START -->  
                              <div class="tab-pane " id="portlet_tab2">
                                 <div class="portlet box red">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>Spare Part List </h4>
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
											<th>Spare Part ID</th>
											<th>Spare Part Name</th>
											<th>UOM</th>
                                            <th>Unit Cost</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
									<?php
									$sql="select * from spare_part_master s left join uom_master u on s.uom_id = u.uom_id ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['spare_part_id'].'</td>';
										echo '<td>'.$f['spare_part_name'].'</td>';										
										echo '<td>'.$f['uom_name'].'</td>';	
										echo '<td>'.$f['unit_cost'].'</td>';																										
									echo '<td>';
										echo '<a href="spare-part-master.php?pid='.$f['spare_part_id'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
										echo '&nbsp;&nbsp;<a href="locaiton-master.php?delid='.$f['location_master_id'].'" class="btn mini black"><i class="icon-trash"></i> Delete</a>';
									echo '</td>';
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