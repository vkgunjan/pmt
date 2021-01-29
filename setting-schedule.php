<?php 
$master='active';
$ss='active';
include_once('including/all-include.php');
include_once('including/header.php');

	$pid=(int)$_REQUEST['pid'];		


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update Plant / Building Details ';
		
		$btsel="select * from user_management where uid='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					
					'user_type'						=>	trim(dbOutput($f['user_type'])),
					'maintenance_type'				=>	trim(dbOutput($f['maintenance_type'])),					
					'fullname'						=>	trim(dbOutput($f['fullname'])),
					'username'						=>	trim(dbOutput($f['username'])),					
					'password'						=>	trim(dbOutput($f['password'])),
					'confirmpassword'				=>	trim(dbOutput($f['password'])),
					'email'							=>	trim(dbOutput($f['email'])),					
					'contact'						=>	trim(dbOutput($f['contact']))		


			);


	//	print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add New User';

	}

//print_r($_POST);
if(isset($_POST['submit'])){
		
	$dataArray=array(
					
					'user_type'						=>	trim(dbOutput($_POST['user_type'])),
					'maintenance_type'				=>	trim(dbOutput($_POST['maintenance_type'])),					
					'fullname'						=>	trim(dbOutput($_POST['fullname'])),
					'username'						=>	trim(dbOutput($_POST['username'])),					
					'password'						=>	trim(dbOutput($_POST['password'])),
					'confirmpassword'				=>	trim(dbOutput($_POST['confirmpassword'])),
					'email'							=>	trim(dbOutput($_POST['email'])),					
					'contact'						=>	trim(dbOutput($_POST['contact']))		
				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['username'])){
		 $errorArray['username']='Enter Username';
	}elseif(empty($pid)){
				$bt="select * from user_management where username='".dbInput($dataArray['username'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['username']='Username Allready Exist...';
				}
		}

	if(EmptyCheck($dataArray['email'])){
		 $errorArray['email']='Emter Email ID';
	}elseif(empty($pid)){
				$bt="select * from user_management where email='".dbInput($dataArray['email'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['email']='Email ID Allready Exist...';
				}
		}

if(EmptyCheck($dataArray['contact'])){
		 $errorArray['contact']='Emter Contact Number';
	}elseif(empty($pid)){
				$bt="select * from user_management where contact='".dbInput($dataArray['contact'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['contact']='Contact Number Allready Exist...';
				}
		}


	if(empty($dataArray['password'])){
		 $errorArray['password']='Enter Password';
	}


	if(empty($dataArray['confirmpassword']) ){
		 $errorArray['confirmpassword']='Enter Confirm Password';
	}elseif($dataArray['confirmpassword']!=$dataArray['password']){
		 $errorArray['confirmpassword']='Confirm Password Doesn\'t Matched';
	}

	if($dataArray['user_type']=='engineer'  && empty($dataArray['maintenance_type'])){
		 $errorArray['maintenance_type']='Select Maintenance Type';
	}


//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE user_management set user_type='".dbInput($dataArray['user_type'])."', fullname='".dbInput($dataArray['fullname'])."',  
		 username='".dbInput($dataArray['username'])."', password='".dbInput($dataArray['password'])."', 
		 email='".dbInput($dataArray['email'])."', contact='".dbInput($dataArray['contact'])."', 
		 maintenance_type='".dbInput($dataArray['maintenance_type'])."', factory_id='".dbInput($_SESSION['factory-id'])."' ";
		 $upd .="where uid='".(int)dbInput($pid)."' ";
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
				$insert  ="INSERT INTO user_management (user_type, fullname, username, password, email, contact, maintenance_type, factory_id)";
				$insert .="values('".dbInput($dataArray['user_type'])."', '".dbInput($dataArray['fullname'])."', 
				'".dbInput($dataArray['username'])."',	'".dbInput($dataArray['password'])."', 
				'".dbInput($dataArray['email'])."', '".dbInput($dataArray['contact'])."',
				'".dbInput($dataArray['maintenance_type'])."', '".dbInput($_SESSION['factory-id'])."' ) ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New User Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Usre Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				header('Location:user-management.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;

	}//empty error array check ends here
}//main post end here	

?>

 <script src="assets/js/jquery-1.11.3.min.js"></script>
 

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Auto Mail Setting For Schedules</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Auto Mail Setting</a></li>

                           </ul>

                      <!-- ADD user START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        
                                 
                                  <div class="control-group" >
                                       <label class="control-label">&nbsp;Select Auto Process</label>
                                       <div class="controls" >
                                          <label class="radio">
                                          <input type="radio" name="user_type" value="admin" id="a"  <?php echo $admin ?> required/>
                                          ON
                                          </label>

                                          <label class="radio">
                                          <input type="radio" name="user_type" value="superwiser" id="s" <?php echo $engineer ?> required/>
                                          OFF
                                          </label>

                                       </div>
                                    </div>
                                    
                                	
                                  
                                    <div class="control-group">
                                       <label class="control-label">Days Start</label>
                                       <div class="controls">
                                    <input type="text" name="fullname" class="m-wrap small"  value="<?php echo $dataArray['fullname']?>" required/>
                                       </div>
                                    </div>  
                                    
                                     <div class="control-group">
                                       <label class="control-label">Days Start From</label>
                                       <div class="controls">
                                    <input type="text" name="fullname" class="m-wrap small"  value="<?php echo $dataArray['fullname']?>" required/>
                                       </div>
                                    </div>   
                                              
                                     <div class="control-group">
                                       <label class="control-label">Days End To</label>
                                       <div class="controls">
                                    <input type="text" name="fullname" class="m-wrap small"  value="<?php echo $dataArray['fullname']?>" required/>
                                       </div>
                                    </div>                            
                                   
                                   
                                            
                                     
                                    <div class="form-actions">
                                       <button type="submit" name="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                                 <!-- ADD user ENDS -->  
                              </div>
                                 <!-- LIST user START -->  
                              
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