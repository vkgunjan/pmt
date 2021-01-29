 <?php

 	include_once('including/connect.php');
	include_once('including/functions.php');

  if($_GET['code']){
        $emp_code = $_GET['ecode'];
        $code = $_GET['code'];
    }
    $sql="SELECT * from user_management where passreset='$code'";
    $result = odbc_exec($conn, $sql);

    
    while($row = odbc_fetch_array($result)){
        $db_emp_code = $row['emp_code'];
        $db_code = $row['passreset'];

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
  <br><br>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" action="reset_pass.php" method="post">
    <input type="hidden" name="form-submit" value="form-submit">
      <h5 class="form-title" style="text-align: center;">Your Password has been successfully reset. Click <a href="index.php">Here</a> to Login in to PMT.</h5>
      
      
      
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