<?php 
$um='active';
$uma='active';
include_once('including/all-include.php');
include_once('including/header.php');
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];		

//print_r($_SESSION);
//print_r($_POST);

//echo '<br><br>';


//exit;

	
$formType = 'Change Password';


//print_r($_POST);
if(isset($_POST['submit'])){

		
	$dataArray=array(
					
					'currentpassword'						  =>	trim(dbOutput($_POST['currentpassword'])),					
					'password'						        =>	trim(dbOutput($_POST['password'])),
					'confirmpassword'				      =>	trim(dbOutput($_POST['confirmpassword']))
				);


	
	if(EmptyCheck($dataArray['currentpassword'])){
		 $errorArray['currentpassword']='Enter Current Password';
	}else{
		$bt="select *  from user_management where uid='".dbInput($_SESSION['uid'])."' and password='".dbInput($dataArray['password'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['currentpassword']='Wrong Password Entered...';
				}
		}



	if(empty($dataArray['password'])){
		 $errorArray['password']='Enter New Password';
	}elseif(strlen($dataArray['password']) < 4 ){
		 $errorArray['password']='Password length should be greater then 3 characters';
	}


	if(empty($dataArray['confirmpassword']) ){
		 $errorArray['confirmpassword']='Enter Confirm Password';
	}elseif($dataArray['confirmpassword']!=$dataArray['password']){
		 $errorArray['confirmpassword']='Confirm Password Doesn\'t Matched';
	}

	


//print_r($errorArray);

	if(empty($errorArray)){
		
		 $upd  ="UPDATE user_management set password='".dbInput($dataArray['confirmpassword'])."' ";
		 $upd .="where uid='".dbInput($_SESSION['uid'])."' ";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Password Changed Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Change Password, Please Try Later.';
					$msgType = 2;
				}

				header('Location:change-password.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;

		}
	
}//main post end here	

?>

 <script src="assets/js/jquery-1.11.3.min.js"></script>
 
 <?php /*?><script>
$(document).ready(function(){
$("#mt").hide();

if(document.getElementById("g").checked){
    $("#mt").show();
}else{
    $("#mt").hide();
}

//alert(genchk);
if(genchk=='general'){
   $("#mt").show();
}

  $("#mgr").click(function(){
    $("#mt").hide();
  });

  $("#mgt").click(function(){
    $("#mt").hide();
  });

 $("#a").click(function(){
    $("#mt").hide();
  });
  
   $("#g").click(function(){
    $("#mt").show();
  });

  
});
</script><?php */?>

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
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Change Password</a></li>

                           </ul>

                      <!-- ADD user START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                                              

                                    <div class="control-group">
                                       <label class="control-label">Current Password</label>
                                       <div class="controls">
               <input type="password"  name="currentpassword" class="m-wrap large" value="<?php echo $dataArray['currentpassword']?>" required/>
                                     <div style="color:#CB0205"><?php echo $errorArray['currentpassword']?></div>
                                       </div>
                                    </div>    
                                              
                                    <div class="control-group">
                                       <label class="control-label">Password</label>
                                       <div class="controls">
                         <input type="password"  name="password" class="m-wrap large" value="<?php echo $dataArray['password']?>" required />
                                    <div style="color:#CB0205"><?php echo $errorArray['password']?></div>
                                       </div>
                                    </div>                              
                                   
                                   
                                   <div class="control-group">
                                       <label class="control-label">Confirm Password</label>
                                       <div class="controls">
           <input type="password"  name="confirmpassword" class="m-wrap large"  value="<?php echo $dataArray['confirmpassword']?>" required/>
										  <div style="color:#CB0205"><?php echo $errorArray['confirmpassword']?></div>
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
                              <div class="tab-pane " id="portlet_tab2">
                                 <div class="portlet box red">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>User List </h4>
								<div class="tools">
								</div>
							</div>
							<div class="portlet-body">
								    <!-- LIST user data ssss-->  
							</div>
						</div>
                              </div>
                                 <!-- LIST user ENDS -->  
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