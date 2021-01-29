<?php 
$master='active';
$ctm='active';
include_once('including/all-include.php');
include_once('including/header.php');

	$pid=(int)$_REQUEST['pid'];		


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update project Type Details ';
		
		$btsel="select * from project_type_master where project_type_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					'project_type_id'				=>	trim(dbOutput($f['project_type_id'])),
					'project_type'					=>	trim(dbOutput($f['project_type']))
			);


		//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add project Type';

	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'project_type'				=>	trim(dbOutput($_POST['project_type']))
				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['project_type'])){
		 $errorArray['project_type']='Enter Project Type Name';
	}elseif(empty($pid)){
				$bt="select * from project_type_master where project_type='".dbInput($dataArray['project_type'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['project_type']='Project Type Allready Exist...';
				}
		}

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE project_type_master set project_type='".dbInput($dataArray['project_type'])."' ";
		 $upd .="where project_type_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Project Type Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Project Type Details , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO project_type_master (project_type)";
				$insert .="values('".dbInput($dataArray['project_type'])."') ";
//echo'<pre>';
//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Project Type Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New project Type Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				header('Location:project-type-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
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
                              <li><a href="#portlet_tab2" data-toggle="tab">List Project Type</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add Project Type</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        
                                    <div class="control-group">
                                       <label class="control-label">Project Type</label>
                                       <div class="controls">
                                          <input type="text" name="project_type" placeholder="" class="m-wrap large" value="<?php echo $dataArray['project_type']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['project_type']?></div>
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
											<th>Project Type</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									<?php
									$sql="select * from project_type_master  ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['project_type_id'].'</td>';
										echo '<td>'.$f['project_type'].'</td>';																
									echo '<td>';
										echo '<a href="project-type-master.php?pid='.$f['project_type_id'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
										//echo '&nbsp;&nbsp;<a href="project-type-master.php?delid='.$f['project_type_id'].'" class="btn mini black"><i class="icon-trash"></i> Delete</a>';
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