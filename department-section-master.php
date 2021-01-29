<?php 
$master='active';
$dm='active';
include_once('including/all-include.php');
include_once('including/header.php');

	$pid=(int)$_REQUEST['pid'];		


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update Department Details ';
		
		$btsel="select * from department_section_master where department_section_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					'department_section_id'				=>	trim(dbOutput($f['department_section_id'])),
					'department_section_name'			=>	trim(dbOutput($f['department_section_name']))
			);


		//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add Department / Section ';

	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'department_section_name'	=>	trim(dbOutput($_POST['department_section_name']))
				);

print_r($dataArray);

	if(EmptyCheck($dataArray['department_section_name'])){
		 $errorArray['department_section_name']='Enter Department / Section Name';
	}elseif(empty($pid)){
				$bt="select * from department_section_master where 
				department_section_name='".dbInput($dataArray['department_section_name'])."'
				";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['department_section_name']='Department Section Allready Exist...';
				}
		}

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE department_section_master set department_section_name='".dbInput($dataArray['department_section_name'])."' ";
		 $upd .="where department_section_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Department / Section Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Department / Section Details , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO department_section_master (department_section_name, factory_id)";
				$insert .="values('".dbInput($dataArray['department_section_name'])."', '".dbInput($_SESSION['factory-id'])."' ) ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Department / Section Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Department / Section Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				header('Location:department-section-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
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
                              <li><a href="#portlet_tab2" data-toggle="tab">List Department / Section</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add Department / Section</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        
                                    <div class="control-group">
                                       <label class="control-label" style="width:190px;">Department / Section Name&nbsp;&nbsp;</label>
                                       <div class="controls">
                                          <input type="text" name="department_section_name" placeholder="" class="m-wrap large" value="<?php echo $dataArray['department_section_name']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['department_section_name']?></div>
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
											<th>Department ID</th>
											<th>Department Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									<?php
									$sql="select * from department_section_master  where factory_id='".$_SESSION['factory-id']."'";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['department_section_id'].'</td>';
										echo '<td>'.$f['department_section_name'].'</td>';																
									echo '<td>';
										echo '<a href="department-section-master.php?pid='.$f['department_section_id'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
								
										echo '&nbsp;&nbsp;<a href="department-section-master.php?delid='.$f['department_section_id'].'" class="btn mini black"><i class="icon-trash"></i> Delete</a>';
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