 <?php

 	include_once('including/connect.php');
	include_once('including/functions.php');

?>


<?php

$msg = ''; 

if(isset($_POST['recover'])){
    $emp_code            = trim($_POST['emp_code']);

    if(empty($emp_code)){
                $msg = "Please Enter Employee Code";
             }else{
                $emailsql = "SELECT fullname, username, emp_code, email FROM user_management where emp_code = '$emp_code'";
                $emailresult = odbc_exec($conn, $emailsql);
                $emailnumrows = odbc_num_rows($emailresult);
                if($emailnumrows!=0){
                    while($rows = odbc_fetch_array($emailresult)){
                    	$db_email = $rows['email'];
                        $db_emp_code = $rows['emp_code'];
                        $db_fullname = $rows['fullname'];
                    }

                    $hide_email = $db_email;
                    $resultmob = substr($hide_email,0,5);
                    $resultmob .= "*******";
                    $resultmob .= substr($hide_email,strpos($hide_email, "@"));
                    $final = $resultmob;




                    if($emp_code == $db_emp_code){
                        $code = rand(10000, 1000000);
                        $to = $db_email;
                        $subject = "PMT || Password Reset";
                        $body = '<html>
                             <head>
                             <title></title>
                              <style>
                               
                              h4,p,div {
                                  font-family: Arial, sans-serif;
                                  font-weight:normal;
                                  font-style:normal;
                                  }

                              tr:nth-child(even){background-color: #f2f2f2}

                              th {
                                  background-color: #0b9444;
                                  color: white;
                                }
                           </style>
                        </head>
                        <body>';

                        $body .= "
                        <h4>Dear $db_fullname,</h4>
                        <br>
                        <p>This is an automatic email. Please DO NOT reply to this.
                        <a href=\"http://pmt.orientapps.com/pmt/reset_pass.php?ecode=$emp_code&code=$code\">Click Here</a> to reset your password for PMT.</p>
                        <br><br><br><br><br>
                        <div>
                        Regards,<br>
                        Administrator - IT <br>
                        Orient Bell Limited
                        </div>
                        </body></html>
                        ";

                        odbc_exec($conn, "UPDATE user_management SET passreset='$code' WHERE emp_code = '$emp_code'");

                        require 'PHPMailer/PHPMailerAutoload.php';

                        $mail = new PHPMailer();
  
                          //Enable SMTP debugging.
                          //$mail->SMTPDebug = 1;
                          //Set PHPMailer to use SMTP.
                          $mail->isSMTP();
                          //Set SMTP host name
                          $mail->Host = "smtp.logix.in";
                          $mail->SMTPOptions = array(
                                            'ssl' => array(
                                                'verify_peer' => false,
                                                'verify_peer_name' => false,
                                                'allow_self_signed' => true
                                            )
                                        );
                          //Set this to true if SMTP host requires authentication to send email
                          $mail->SMTPAuth = TRUE;
                          //Provide username and password
                          $mail->Username = "donotreply@orientbell.com";
                          $mail->Password = "Orient@2019";
                          //If SMTP requires TLS encryption then set it
                          $mail->SMTPSecure = "tls";
                          $mail->Port = 587;
                          

                          
                          
                          $mail->setFrom('donotreply@orientbell.com', 'Administrator - PMT');
                          /*$mail->addCC('vkgunjan@gmail.com');*/

                         
                          
                          $mail->addAddress($to);
                          
                          $mail->isHTML(true);
                         
                          $mail->Subject = $subject;
                          $mail->Body = $body;
                          $mail->AltBody = "This is the plain text version of the email content";
                          if(!$mail->send())
                          {
                           echo "Mailer Error: " . $mail->ErrorInfo;
                          }
                          else
                          {
                           $msg = "An Email has been sent to your Registerd Email ID <span style='color:grey;'>".$final." </span>";
                          }

                        
                    }
                }else{
                    $msg = "Employee Code doesn't Exists. Please contact Admin or Write Us on <a href='mailto:pmt@orientbell.com'>pmt@orientbell.com</a>";
                }
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
    <form class="form-vertical login-form" action="pass_reset.php" method="post">
    <input type="hidden" name="form-submit" value="form-submit">
      <h5 class="form-title" style="text-align: center;">Enter Your Employee Code and We will send you instructions how to recover Password</h5>
      <div class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span>Enter any username and password.</span>
      </div>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Employee Code</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Employee Code" name="emp_code"/>
          </div>
        </div>
      </div>
      
      <div class="form-actions">
      	<label class="checkbox">
        <a href="index.php">Back To Login</a>
        </label>
        <input type="submit" name="recover" class="btn red pull-right " value="Recover"> 
                  
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