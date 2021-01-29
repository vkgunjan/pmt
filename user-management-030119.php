<?php 
$um='active';
$uma='active';
include_once('including/all-include.php');
include_once('including/header.php');
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];		

//print_r($_POST);

//echo '<br><br>';


//exit;


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update User Details ';
		
		$btsel="select * from user_management where uid='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					
					'user_type'						=>	trim(dbOutput($f['user_type'])),
					'maintenance_type'				=>	trim(dbOutput($f['maintenance_type'])),	
					'parent_id'						=>	trim(dbOutput($f['parent_id'])),					
					'fullname'						=>	trim(dbOutput($f['fullname'])),
					'username'						=>	trim(dbOutput($f['username'])),					
					'password'						=>	trim(dbOutput($f['password'])),
					'confirmpassword'				=>	trim(dbOutput($f['password'])),
					'email'							=>	trim(dbOutput($f['email'])),					
					'contact'						=>	trim(dbOutput($f['contact'])),
					'employee_territory'			=>	trim(dbOutput($f['employee_territory'])),
					'employee_department'			=>	trim(dbOutput($f['employee_department']))


			);


	//	print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add New User';

	}

//print_r($_POST);
if(isset($_POST['submit'])){

$employee_territory=implode($_POST['employee_territory'],",");
		
	$dataArray=array(
					
					'user_type'						=>	trim(dbOutput($_POST['user_type'])),
					'parent_id'						=>	trim(dbOutput($_POST['parent_id'])),					
					'fullname'						=>	trim(dbOutput($_POST['fullname'])),
					'username'						=>	trim(dbOutput($_POST['username'])),					
					'password'						=>	trim(dbOutput($_POST['password'])),
					'confirmpassword'				=>	trim(dbOutput($_POST['confirmpassword'])),
					'email'							=>	trim(dbOutput($_POST['email'])),					
					'contact'						=>	trim(dbOutput($_POST['contact'])),
					'employee_territory'			=>	trim(dbOutput($employee_territory)),
					'employee_department'			=>	trim(dbOutput($_POST['employee_department']))									
				);

//print_r($dataArray);

		if(empty($dataArray['employee_territory'])){
		 $errorArray['employee_territory']='Map At Least 1 Working Territory with Employee';
	}

	
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
		$errorArray['contact']='Please Enter Mobile Number';
	}elseif(CheckNumber($dataArray['contact'])){
		$errorArray['contact']='Please Enter A Valid Contact Number';
	}elseif(CheckLength($dataArray['contact'])<10 ){
		$errorArray['contact']='Please Enter A Valid Mobile Number';
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
		 email='".dbInput($dataArray['email'])."', contact='".dbInput($dataArray['contact'])."', parent_id= '".dbInput($dataArray['parent_id'])."',
		 employee_territory='".dbInput($dataArray['employee_territory'])."',  employee_department='".dbInput($dataArray['employee_department'])."' ";
		 $upd .="where uid='".(int)dbInput($pid)."' ";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' User Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update User Details , Please Try Later.';
					$msgType = 2;
				}
		}else{

				$insert  ="INSERT INTO user_management (user_type, fullname, username, password, email, contact, parent_id, added_date, employee_territory, employee_department)";
				$insert .="values('".dbInput($dataArray['user_type'])."', '".dbInput($dataArray['fullname'])."', 
				'".dbInput($dataArray['username'])."',	'".dbInput($dataArray['password'])."', 
				'".dbInput($dataArray['email'])."', '".dbInput($dataArray['contact'])."',
				'".dbInput($dataArray['parent_id'])."', '".dbInput($timestamp)."' , '".dbInput($dataArray['employee_territory'])."', 
				'".dbInput($dataArray['employee_department'])."') ";

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
                              <li><a href="#portlet_tab2" data-toggle="tab">List User</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add User</a></li>

                           </ul>

                      <!-- ADD user START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        

                                  <div class="control-group" >
                                       <label class="control-label">&nbsp;Select Type of User</label>
                                       <div class="controls" >
										<?php //echo trim($dataArray['user_type']);?>
                                    	<?php $admin=(trim($dataArray['user_type'])=='admin')?'checked':''; ?>
   										<?php $engineer=(trim($dataArray['user_type'])=='management')?'checked':''; ?>
                                        <?php $manager=(trim($dataArray['user_type'])=='manager')?'checked':''; ?>
                                        <?php $general=(trim($dataArray['user_type'])=='general')?'checked':''; ?>
                                     
                                          <label class="radio">
                                          <input type="radio" name="user_type" value="admin" id="a"  <?php echo $admin ?> required/>
                                          Admin
                                          </label>

                                          <label class="radio">
                                          <input type="radio" name="user_type" value="management" id="mgt" <?php echo $engineer ?> required/>
                                          Management
                                          </label>

                                          <label class="radio">
                                          <input type="radio" name="user_type" value="manager" id="mgr" <?php echo $manager ?> required/>
                                          Manager
                                          </label>

                                          <label class="radio">
                                          <input type="radio" name="user_type" value="general"  id="g" <?php echo $general ?> required />
                                          General
                                          </label>  
                                          
                                       </div>
                                    </div>
                                    
                                	<div class="control-group" id="mt">
                                       <label class="control-label">Manager Name</label>
                                       <div class="controls">
                                          <select class="medium m-wrap" name="parent_id" tabindex="1" >

										<option value="">-Select-</option>
	                                   <option value="">None</option>
                                       <?php
										$sql="select uid, fullname from user_management where user_type='manager' ";
										$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										$selected=($f['uid']==$dataArray['parent_id'])?'selected':'';
										echo '<option value="'.$f['uid'].'"'.$selected.'>'.$f['fullname'].'</option>';
										}
										?>
                                     	   </select>
                                       <div style="color:#CB0205"><?php echo $errorArray['parent_id']?></div>
                                       </div>
                                    </div>
                                    

                                 
                                  
                                    <div class="control-group">
                                       <label class="control-label">Full Name</label>
                                       <div class="controls">
                                    <input type="text" name="fullname" class="m-wrap large"  value="<?php echo $dataArray['fullname']?>" required/>
                                       </div>
                                    </div>  





                           <div class="control-group">
                              <label class="control-label">Employee Territory</label>
                              <div class="controls">
                        <select data-placeholder="Select Territory" name="employee_territory[]" class="chosen span6" multiple="multiple" tabindex="6" required>
									<option value="">-Select-</option>
                                            <?php
									$sql="select * from territory_master";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
											if($_GET['pid']){
												$xxx=explode(",",$dataArray['employee_territory']);
												$selected=(in_array($f['territory_id'],	$xxx))?'selected':'';
											}else{
												$selected=(in_array($f['territory_id'],$_POST['employee_territory']))?'selected':'';
											}
									echo '<option value="'.$f['territory_id'].'"'.$selected.'>'.$f['territory_name'].'</option>';
										}
									?>
                                 </select>
                                   <div style="color:#CB0205"><?php echo $errorArray['employee_territory']?></div>
                              </div>
                           </div>



                                  <div class="control-group">
                                       <label class="control-label">Employee Department</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="employee_department"  required >
                                          <option value="">-Select-</option>
                          <option value="CKA" <?php echo ($dataArray['employee_department'])=='CKA' ? 'selected' : '' ?>>CKA</option>
                          <option value="Retail" <?php echo ($dataArray['employee_department'])=='Retail' ? 'selected' : '' ?>>Retail</option>
                          <option value="BD" <?php echo ($dataArray['employee_department'])=='BD' ? 'selected' : '' ?>>BD</option>
                          <option value="GPS" <?php echo ($dataArray['employee_department'])=='GPS' ? 'selected' : '' ?>>GPS</option>

                                          
                                          </select>
                                       </div>
                                    </div>


                                    <div class="control-group">
                                       <label class="control-label">Username</label>
                                       <div class="controls">
                                   <input type="text"  name="username" class="m-wrap large" value="<?php echo $dataArray['username']?>" required/>
                                     <div style="color:#CB0205"><?php echo $errorArray['username']?></div>
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


                                     <div class="control-group">
                                       <label class="control-label">Email-ID</label>
                                       <div class="controls">
                                          <input type="email" name="email" class="m-wrap large" value="<?php echo $dataArray['email']?>" required />
											<div style="color:#CB0205"><?php echo $errorArray['email']?></div>
                                       </div>
                                    </div>   

   
                                       
                                     <div class="control-group">
                                       <label class="control-label">Contact Number</label>
                                       <div class="controls">
                                    <input type="text"  name="contact" class="m-wrap large" value="<?php echo $dataArray['contact']?>" required/>
                                     <div style="color:#CB0205"><?php echo $errorArray['contact']?></div>
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
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>User Type</th>
											<th>Department</th>
                                            <th>Full Name</th>
											<th>Username</th>
											<th>Email</th>											
                                            <th>Contact</th>											
                                            <th>Manager Name</th>																															
                                            <th>Action</th>
										</tr>
									</thead>
									<tbody>

									<?php
									$sql="select * from user_management ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.ucfirst($f['user_type']).'</td>';
										echo '<td>'.ucfirst($f['employee_department']).'</td>';
										echo '<td width="5%">'.$f['fullname'].'</td>';																
										echo '<td>'.$f['username'].'</td>';
										echo '<td>'.$f['email'].'</td>';	
										echo '<td>'.$f['contact'].'</td>';
									$sqll="select fullname from user_management where uid='".$f['parent_id']."'";
									$rss=odbc_exec($conn,$sqll);
									$ff = odbc_fetch_array($rss);

									if(empty($ff['fullname']))
										echo '<td>N/A</td>';	
									else
										echo '<td>'.$ff['fullname'].'</td>';	

									echo '<td>';
									echo '<a href="user-management.php?pid='.$f['uid'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
									echo '&nbsp;&nbsp;<a href="target-achievement.php?delid='.$f['uid'].'" class="btn mini red"><i class="icon-bar-chart"></i> TGT / ACH </a>';
									echo '</td>';
										$count++;
									}
									?>

									</tbody>
								</table>
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