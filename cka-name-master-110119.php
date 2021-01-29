<?php 
$master='active';
$cnm='active';
include_once('including/all-include.php');
include_once('including/header.php');

	$pid=(int)$_REQUEST['pid'];		


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update CKA Name Details ';
		
		$btsel="select * from cka_name_master where cka_name_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					'cka_name_id'		=>	trim(dbOutput($f['cka_name_id'])),
					'cka_name'			=>	trim(dbOutput($f['cka_name'])),
					'account_type'		=>	trim(dbOutput($f['account_type']))
			);


		//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add Account Name';

	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'cka_name'				=>	trim(dbOutput($_POST['cka_name'])),
					'account_type'		=>	trim(dbOutput($_POST['account_type']))

				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['cka_name'])){
		 $errorArray['cka_name']='Enter Account Name';
	}elseif(empty($pid)){
	
	$bt="select * from cka_name_master where cka_name='".dbInput($dataArray['cka_name'])."' and account_type='".dbInput($dataArray['account_type'])."' ";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['cka_name']='Account Name Allready Exist...';
				}
		}

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE cka_name_master set cka_name='".dbInput($dataArray['cka_name'])."', account_type='".dbInput($dataArray['account_type'])."' ";
		 $upd .="where cka_name_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Account Name Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Account Name Details , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO cka_name_master (cka_name, account_type)";
				$insert .="values('".dbInput($dataArray['cka_name'])."', '".dbInput($dataArray['account_type'])."' ) ";
//echo'<pre>';
//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Account Name Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Account Name Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				header('Location:cka-name-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
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
                              <li><a href="#portlet_tab2" data-toggle="tab">List Account Name</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add Account Name</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        
                                   
                                    <div class="control-group">
                                       <label class="control-label">Account Name</label>
                                       <div class="controls">
                           <input type="text" name="cka_name" placeholder="" class="m-wrap large" value="<?php echo $dataArray['cka_name']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['cka_name']?></div>
                                       </div>
                                    </div>


                                    <div class="control-group">
                                       <label class="control-label">Account Type</label>
                                       <div class="controls">
												<select name="account_type" placeholder="" class="m-wrap small" >
                                               <?php // 	<option>-Select-</option>  ?>
                           
					<?php	//  <option value="CKA" <?php echo ($dataArray['account_type'])=='CKA' ? 'selected' : '' ?>>CKA</option> ?>
                          
						  <option value="Retail" <?php echo ($dataArray['account_type'])=='Retail' ? 'selected' : '' ?>>Retail</option>

                                                </select>
						
                                          <div style="color:#E10307"><?php echo $errorArray['account_type']?></div>
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
											<th>Account Name</th>
											<th>Account Type</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									<?php
									$sql="select * from cka_name_master  ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['cka_name_id'].'</td>';
										echo '<td>'.$f['cka_name'].'</td>';																
										echo '<td>'.$f['account_type'].'</td>';																
									echo '<td>';
						echo '<a href="cka-name-master.php?pid='.$f['cka_name_id'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
										//echo '&nbsp;&nbsp;<a href="cka-name-master.php?delid='.$f['cka_name_id'].'" class="btn mini black"><i class="icon-trash"></i> Delete</a>';
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