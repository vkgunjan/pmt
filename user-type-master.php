		<?php 
ob_start();
	        $master='active';
	        $utm='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
       
	   	$pid=(int)$_REQUEST['pid'];		


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update User Type Details ';
		
		$btsel="select * from user_type_master where user_type_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					'user_type_id'				=>	trim(dbOutput($f['user_type_id'])),
					'user_type'					=>	trim(dbOutput($f['user_type']))
			);


		//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add User Type';

	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'user_type'						=>	trim(dbOutput($_POST['user_type']))
				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['user_type'])){
		 $errorArray['user_type']='Enter Asset Type';
	}elseif(empty($pid)){
				$bt="select * from user_type_master where user_type='".dbInput($dataArray['user_type'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['user_type']='Asset Type Allready Exist...';
				}
		}

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE user_type_master set user_type='".dbInput($dataArray['user_type'])."' ";
		 $upd .="where user_type_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' User Type Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update User Type Details , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO user_type_master (user_type)";
				$insert .="values('".dbInput($dataArray['user_type'])."') ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New User Type Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New User Type Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				header('Location:user-type-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
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
                           <span class="hidden-480">User Type Master</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                              <li><a href="#portlet_tab2" data-toggle="tab">List User Type</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add User Type</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                    
                                    <div class="control-group" >
                                       <label class="control-label" style="width:170px;">User Type</label>
                                       <div class="controls">
                                          <input type="text" name="user_type" value="<?php echo $dataArray['user_type']?>" placeholder=""  required="required" class="m-wrap large" />
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
								<h4><i class="icon-cogs"></i>User Type List </h4>
								<div class="tools">
									
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>User Type ID</th>
											<th>User Type </th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
									<?php
									$sql="select * from user_type_master  ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['user_type_id'].'</td>';
										echo '<td>'.$f['user_type'].'</td>';																
									echo '<td>';
										echo '<a href="user-type-master.php?pid='.$f['user_type_id'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
										//echo '&nbsp;&nbsp;<a href="user-type-master.php?delid='.$f['user_type_id'].'" class="btn mini black"><i class="icon-trash"></i> Delete</a>';
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