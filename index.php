 <?php

	if(!isset($_SESSION)){
		session_start();
	}

	unset($_SESSION['uid']);
	unset($_SESSION['user_type']);
	unset($_SESSION['maintenance_type']);
	unset($_SESSION['fullname']);
	unset($_SESSION['factory-id']);
	unset($_SESSION['multi_location']);
	unset($_SESSION['login-factory']);
	unset($_SESSION['software-name']);

	unset($_SESSION['employee_territory']);
	unset($_SESSION['employee_department']);
	unset($_SESSION['emp_cka_mapping']);
	unset($_SESSION['rootuser']);

	include_once('including/connect.php');
	include_once('including/functions.php');	
	//include_once('including/all-include.php');
	//print_r($_SESSION);


if($_GET['login-fail']){
	$msg='Invalid Login ID or Password';
}else{
	$msg='';
}
		
if(isset($_POST['form-submit']) && $_POST['form-submit']=='form-submit'){

					$hide_email = $_POST['username'];
                    
                    /*$resultmob = substr($hide_email,-5,-8);*/
                    /*$resultmob = substr($hide_email,0,strpos($hide_email, "@"));*/
                    $mm = "@orientbell.com";

                    $final = ($hide_email.$mm);
                    /*var_dump($final);
                    exit();*/

	
	 $ss="select * from user_management u where (u.username='".dbInput($_POST['username'])."' or u.username='$final' or u.emp_code='".dbInput($_POST['username'])."') and u.password='".dbInput($_POST['password'])."' and emp_status = 1 ";


	$c=odbc_exec($conn, $ss);
	$n=odbc_num_rows($c);
	$f=odbc_fetch_array($c);

	if(!$n){

		header('location:index.php?login-fail=true');
		exit;
	}else {

	
	
	
	$_SESSION['uid']					=	trim($f['uid']);
	$_SESSION['user_type']				=	trim($f['user_type']);
	$_SESSION['maintenance_type']		=	trim($f['maintenance_type']);
	$_SESSION['maintenance_type_name']	=	trim($f['maintenance_type_name']);
	$_SESSION['fullname']				=	trim($f['fullname']);
	$_SESSION['factory-id']				=	trim($f['factory_id']);
	$_SESSION['multi_location']			=	trim($f['multi_location']);
	$_SESSION['login-factory']			=	trim($f['factory_name']);
	$_SESSION['email']					=	trim($f['email']);
	$_SESSION['employee_territory'] 	= 	trim($f['employee_territory']);
	$_SESSION['employee_department'] 	= 	trim($f['employee_department']);
	$_SESSION['parent_id']				=	trim($f['parent_id']);
	$_SESSION['software-name']			=	trim('Pipeline Management Tool');
	$_SESSION['emp_code']				=	trim($f['emp_code']);
	$_SESSION['contact']				=	trim($f['contact']);
	$_SESSION['u_address']				=	trim($f['u_address']);

	$_SESSION['rootuser']=$f['uid'];
	

	$sqltime = "UPDATE user_management set last_login = getdate() WHERE uid='".$_SESSION['uid']."'";
	
	$time = odbc_exec($conn, $sqltime);
	$IP = $_SERVER['REMOTE_ADDR'];
	ob_start();
	system('ipconfig /all');
	$mycom=ob_get_contents();
	ob_clean();
	$findme = 'physique';
	$pmac = strpos($mycom, $findme);
	$mac=substr($mycom,($pmac+36),17);
	$user_log = "INSERT into user_log values ('".$_SESSION['uid']."','$IP','$mac', getdate())";
	$log = odbc_exec($conn, $user_log);
	//echo "Client's IP address is: $IP";
	}

	

		if($f['employee_department']=='CKA'){
	
	 		$ckam="select * from cka_name_master where cka_mapped_with_emp='".trim($f['uid'])."' ";
			$ckae=odbc_exec($conn, $ckam);
			$n=odbc_num_rows($ckae);
			$cnt=0;
			while($ff=odbc_fetch_array($ckae))
			{

				if($cnt==0){
					$emp_cka_mapping =$ff['cka_name_id'];
				}else{
					$emp_cka_mapping .=','.$ff['cka_name_id'];
				}
					$cnt++;							
			}
			//echo '<br><br>';
			//echo $emp_cka_mapping;
//			print_r($ckaf);
			$_SESSION['emp_cka_mapping'] = 		trim($emp_cka_mapping);

		}

	 		$vckam="select * from user_management where parent_id='".trim($f['uid'])."' and emp_status = 1 ";
			$vckae=odbc_exec($conn, $vckam);
			$vn=odbc_num_rows($vckae);
			$vcnt=0;
			while($vff=odbc_fetch_array($vckae))
			{
			//echo '<pre>';
			//echo '<br>';

			//print_r($vff['uid']);

//vvkksss
	 		 $avckam="select * from user_management where parent_id='".trim($vff['uid'])."' and emp_status = 1 ";
			$avckae=odbc_exec($conn, $avckam);
			$avn=odbc_num_rows($avckae);
			$avcnt=0;
		
		if($avn>0){	
//		echo 'Vineet';
			while($avff=odbc_fetch_array($avckae))
			{
				if($avcnt==0){
					$vemp_cka_mapping =$avff['uid'];
				}else{
					$vemp_cka_mapping .=','.$avff['uid'];
				}
					$vcnt++;							
			}
		}
//vvkkskss

				if($vcnt==0){
					$vemp_cka_mapping =$vff['uid'];
				}else{
					$vemp_cka_mapping .=','.$vff['uid'];
				}
					$vcnt++;							
			}
			//echo '<br><br>';
			//echo $emp_cka_mapping;
//			print_r($ckaf);
if($f['uid']==2015){
//echo '<br><br><br>hello</br>';
	$gpsq="select uid from user_management where employee_department='GET' and uid <> '2015' and emp_status = 1 ";
	$gpscnt=0;
	$gpsexe=odbc_exec($conn, $gpsq);
	while($fr=odbc_fetch_array($gpsexe)){
		//$gpscnt=odbc_num_rows($fr);
		if($gpscnt==0){
			$myteam = $fr['uid'];		
		}else{
			$myteam .= ','.$fr['uid'];		
		}
		$gpscnt++;	
	}
	
//	$_SESSION['my_team_id'] = 	'2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2089,2094';
	
	$_SESSION['my_team_id'] = $myteam;
	
}else{
	$_SESSION['my_team_id'] = 	trim($vemp_cka_mapping);
}


	
//	echo '<br><br>'.$myteam;	
	
//echo '<br>'. $vemp_cka_mapping;
//	echo $_SESSION['my_team_id'];
	
		/*header('location:list-all-lead.php');
		header('location:list-all-lead.php');
		exit;*/

		//print_r($_SESSION);

		if(trim($_SESSION['employee_department'])=='obtbadmin' || trim($_SESSION['employee_department'])=='coco'){
				header('location:cat_history.php');
		/*header('location:list-all-lead.php');*/
		exit;
		}
		if(trim($_SESSION['employee_department'])=='plantadmin'){
				header('location:list_npd_sample.php');
		/*header('location:list-all-lead.php');*/
		exit;
		}
		else{
			header('location:list-all-lead.php');
		/*header('location:list-all-lead.php');*/
		exit;
		}

	
}


	?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8" />
  <title>Orient Bell Ltd. | PMT </title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/metro.css" rel="stylesheet" />
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/style_responsive.css" rel="stylesheet" />
  <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
  <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
  <!-- BEGIN LOGO -->
    <H2 align="center" style="color:#FFFFFF; margin-top:150px;">Pipeline Management Tool</H2>
  <div class="logo">
   <a href="index.php"> <img src="assets/img/obllogo.png" alt="ORIENT BELL LIMITED" /> </a>
  </div>

  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <input type="hidden" name="form-submit" value="form-submit">
      <h3 class="form-title" style="text-align: center;">Login to Your Account</h3>
      <div class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span>Enter Username and Password.</span>
      </div>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password"/>
          </div>
        </div>
      </div>
      <div class="form-actions">
      	<label class="checkbox">
        <a href="pass_reset.php" title="Click to get forgot password page where Emp Code is required">Forgot Password ?</a> | <a href="https://www.youtube.com/watch?time_continue=325&v=Ct6VYOXksZc&feature=emb_title" target="_blank" title="Get the PMT Tutorial Link on Youtube">Get Help !</a>
        </label>
        <input type="submit" class="btn green pull-right " value="Login"> 
                   
      </div>
      <label style="font-size: 13px; color: red;">
        <?php echo $msg; ?>
        </label>
    </form>
    <!-- END LOGIN FORM -->        
    
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
       2019 &copy; Orient Bell Ltd. | Developed BY: OBL IT Department
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.3.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  
  <script src="assets/uniform/jquery.uniform.min.js"></script> 
  <script src="assets/js/jquery.blockui.js"></script>
  <script type="text/javascript" src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="assets/js/app.js"></script>
  <script>
    jQuery(document).ready(function() {     
      App.initLogin();
    });
  </script>

  <!-- END JAVASCRIPTS -->

</body>
<!-- END BODY -->
</html>