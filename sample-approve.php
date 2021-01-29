 <?php

	

	include_once('including/connect.php');
	include_once('including/functions.php');
  include('including/datetime.php');
  $timestamp=date('Y-m-d H:i:s'); 	
	//include_once('including/all-include.php');
	//print_r($_SESSION);


if($_GET['code']){
	$lead_id = $_GET['ld'];
	$code = $_GET['code'];
}

$sql = "SELECT o.opportunity_id, o.lead_id, u.fullname, o.project_name, o.sampling_code, m.email, o.project_name  from opportunity o
inner join user_management u on u.uid = o.created_by
inner join user_management m on m.uid = o.created_by where o.lead_id = '$lead_id'";

$result = odbc_exec($conn,$sql);
				while($f = odbc_fetch_array($result)){
        $opp_id = $f['opportunity_id'];
				$lead_no = $f['lead_id'];
				$u_name = $f['fullname'];
				$p_name = $f['project_name'];
				$u_mail = $f['email'];
				$sampling_code = $f['sampling_code'];

				}


$msg="";
		
if(isset($_POST['approve'])){

	$remarks         = trim(dbOutput($_POST['remarks']));
	$lead_id 			   = $_GET['ld'];
	$code 				   = $_GET['code'];


	if ($lead_no == $lead_id && $sampling_code == $code) {
		$query = "UPDATE opportunity set sampling_status = '2', sampling_code = '0', current_stage = '2', sp_approve_date = '$timestamp', sp_approval_remark = '$remarks' where lead_id = '$lead_id'";
		$query_result = odbc_exec($conn, $query);

    $fld_query = "UPDATE fld set sampling = 'Yes' where opp_id = '$opp_id' ";
    $fld_result = odbc_exec($conn, $fld_query);


    $sql = "SELECT o.lead_id, u.fullname, o.project_name, m.email, o.project_name  from opportunity o
    inner join user_management u on u.uid = o.created_by
    inner join user_management m on m.uid = o.created_by where o.lead_id = '$lead_id'";

    $result = odbc_exec($conn,$sql);
        while($m = odbc_fetch_array($result)){
        
        $lead = $m['lead_id'];
        $name = $m['fullname'];
        $pr_name = $m['project_name'];
        $ud_mail = $m['email'];
        

        }


		if($query_result){
                        $to = $ud_mail;
                        $subject = "PMT || Sampling Approval Request-[$lead]";
                        $body = "
                        <h4>Dear $name,</h4>
                        <br>
                        <p>This is an automatic email. Please DO NOT reply to this.
                        Your PMT Lead [$lead] has been Approved by Corresponding PCH</p>
                        <p><a href=\"http://pmt.orientapps.com/pipeline/index.php\">Click Here</a> to Login in to PMT for more details. </p>
                        <br><br><br><br><br>
                        <p>Administrator - IT</p>
                        <p>Orient Bell Limited</p>

                        ";

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
                          //$mail->addCC('vkgunjan@gmail.com');

                         
                          
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
                           $msg = "Lead Approved by PCH";
                          }
              header("Location: approved.php");
              exit();
			
		}else{
						$msg = "Something went wrong. Please try again later";            
		}
	}else{
		$msg =  "Something went wrong as provided lead has already been Approved/Rejected.";
	}		

}


if(isset($_POST['reject'])){

	$remarks         = trim(dbOutput($_POST['remarks']));
	$lead_id 			   = $_GET['ld'];
	$code 				   = $_GET['code'];


	if ($lead_no == $lead_id && $sampling_code == $code) {
		$query = "UPDATE opportunity set sampling_status = '0', sampling_code = '0', sp_reject_date = '$timestamp', sp_reject_remark = '$remarks' where lead_id = '$lead_id'";
		$query_result = odbc_exec($conn, $query);

    $fld_query = "UPDATE fld set sampling = 'No' where opp_id = '$opp_id' ";
    $fld_result = odbc_exec($conn, $fld_query);

    $sql = "SELECT o.lead_id, u.fullname, o.project_name, m.email, o.project_name  from opportunity o
    inner join user_management u on u.uid = o.created_by
    inner join user_management m on m.uid = o.created_by where o.lead_id = '$lead_id'";

    $result = odbc_exec($conn,$sql);
        while($m = odbc_fetch_array($result)){
        
        $lead = $m['lead_id'];
        $name = $m['fullname'];
        $pr_name = $m['project_name'];
        $ud_mail = $m['email'];
        

        }

		if($query_result){
                        $to = $ud_mail;
                        $subject = "PMT || Sampling Approval Request-[$lead]";
                        $body = "
                        <h4>Dear $name,</h4>
                        <br>
                        <p>This is an automatic email. Please DO NOT reply to this.
                        Your PMT Lead [$lead] has been Rejected by Corresponding PCH</p>
                        <p><a href=\"http://pmt.orientapps.com/pipeline/index.php\">Click Here</a> to Login in to PMT for more details. </p>
                        <br><br><br><br><br>
                        <p>Administrator - IT</p>
                        <p>Orient Bell Limited</p>

                        ";

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
                          //$mail->addCC('vkgunjan@gmail.com');

                         
                          
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
                           $msg = "Lead Rejected by PCH";
                          }
              header("Location: reject.php");
              exit();
			
		}else{
						    $msg = "Something went wrong. Please try again later";        
		}
	}else{
		$msg =  "Something went wrong as provided lead has already been Approved/Rejected.";
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
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="assets/css/style.css" rel="stylesheet" />
   <link href="assets/css/style_responsive.css" rel="stylesheet" />
   <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
   <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="assets/jquery-tags-input/jquery.tagsinput.css" />
   <link rel="stylesheet" type="text/css" href="assets/clockface/css/clockface.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login" style="background-color: #fff !important;">
  <!-- BEGIN LOGO -->
    <H2 align="center" style="color:#000000">Pipeline Management Tool</H2>
  <div class="logo">
   <a href="index.php"> <img src="assets/img/logo-header.png" alt="ORIENT BELL LIMITED" /> </a>
  </div>

  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
 <div class="row-fluid">
               <div class="span8 offset2">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box">
                     
                     <div class="portlet-body form">
                     	<div class="well" style="margin-top: 50px;">
										<h4>Approval for Sampling on Lead <b>[<?php echo $lead_id ?>]</b></h4>
										This is an approval request for Lead generated by <b><?php echo $u_name ?></b> for <b>"<?php echo $p_name ?>"</b> . Kindly Approve/Reject sampling details with your relevent remarks.
									</div>
                        <!-- BEGIN FORM-->
                        <div class="control-group" style="text-align: center;">
                              <label class="control-label" style="color: red;"><b><?php echo $msg; ?></b></label>
                              
                           </div>
                        <form action="sample-approve.php?ld=<?php echo $lead_id ?>&code=<?php echo $code ?>" class="form-horizontal" style="margin-top: 30px !important;" method="POST">
                           
                           
                           <div class="control-group">
                              <label class="control-label">Remarks:</label>
                              <div class="controls">
                                 <textarea class="span10 m-wrap" rows="3" name="remarks" required="required"></textarea>
                              </div>
                           </div>
                           <div class="form-actions">
                              <button type="submit" name="approve" class="btn green">Approve</button>&nbsp;&nbsp;
                              <button type="submit" name="reject" class="btn red">Reject</button>
                           </div>
                        </form>
                        <!-- END FORM-->           
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
       2019 &copy; Orient Bell Ltd. <br> Best Viewed in Chrome | Developed BY: OBL IT Department
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