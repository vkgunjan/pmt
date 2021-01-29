<?php 
$master='active';
$cnm='active';
include_once('including/all-include.php');
include_once('including/header.php');

$user_id = $_SESSION['uid'];
$emp_territory = $_SESSION['employee_territory'];

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
					'account_type'		=>	trim(dbOutput($f['account_type'])),
					'territoryName'		=>	trim(dbOutput($f['cka_territory']))
			);


		//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add Retail Account';

	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'cka_name'				=>	trim(dbOutput($_POST['cka_name'])),
					'territory'				=>	trim(dbOutput($_POST['territory']))

				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['cka_name'])){
		 $errorArray['cka_name']='Enter Account Name';
	}elseif(empty($pid)){
	
	$bt="select * from cka_name_master where cka_name='".dbInput($dataArray['cka_name'])."' and account_type = 13 and cka_territory = '".dbInput($dataArray['territory'])."' ";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['cka_name']='Account Name Already Exist...';
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
				$insert  ="INSERT INTO cka_name_master (cka_name, account_type, cka_territory, cka_status, created_by, created_on, e_status, sub_status, engaged)";
				$insert .="values('".dbInput($dataArray['cka_name'])."', '13','".dbInput($dataArray['territory'])."', '1', '$user_id', getdate(), '2', '2', 'Yes') ";
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

				header('Location:list-all-lead.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
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
                              <!-- <li><a href="#portlet_tab2" data-toggle="tab">List Account Name</a></li> -->
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add Retail Account Name</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        
                                   
                                    <div class="control-group">
                                       <label class="control-label">Retail Account Name</label>
                                       <div class="controls">
                           <input type="text" name="cka_name" placeholder="" class="m-wrap large" value="<?php echo $dataArray['cka_name']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['cka_name']?></div>
                                       </div>
                                    </div>


                                    <div class="control-group">
                                       <label class="control-label">Employee Territory</label>
                                       <div class="controls">
												<!-- <select  class="chosen-with-diselect m-wrap span3" id="territory" tabindex="-1" name="territory" style="width:220px;" required disabled="disabled"> -->

                                          <!-- <option value="">-Select-</option> -->
                                            <?php
	
										
										$sql="select * from territory_master where territory_id = '$emp_territory'";
									/*}*/

									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									//$selected=($f['territory_id']==$dataArray['territory'])?'selected':'';
									//echo '<option value="'.$f['territory_id'].'"'.$selected.'>'.$f['territory_name'].'</option>';
									/*echo '<label class="control-label">'.$f['territory_name'].'</label>';*/
									echo '<span class="text" style="color:red; font-weight:bold;">'.$f['territory_name'].'</span>';
									/*echo '<input type="text" placeholder="" class="m-wrap large" value="'.$f['territory_name'].'" required/>';*/
									echo '<input type="hidden" name="territory" placeholder="" class="m-wrap large" value="'.$f['territory_id'].'" />';
										}
									?>
                                          <!-- </select> -->
						
                                          <div style="color:#E10307"><?php echo $errorArray['territory']?></div>
                                       </div>
                                    </div>
                                                                        
                                    
                                    <div class="form-actions">
                                       <button type="submit" name="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <a href="list-all-lead.php"><button type="button" class="btn">Cancel</button></a>
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

      
   <!-- <script src="assets/bootstrap/js/bootstrap.min.js"></script> -->
  <!-- <script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>-->
     
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="assets/js/excanvas.js"></script>
   <script src="assets/js/respond.js"></script>
   <![endif]-->
   
   
  
   