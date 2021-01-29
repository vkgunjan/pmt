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

$sql = "SELECT o.lead_id, u.fullname, o.project_name, o.lead_code, m.email, o.project_name  from opportunity o
inner join user_management u on u.uid = o.created_by
inner join user_management m on m.uid = o.created_by where o.lead_id = '$lead_id'";

$result = odbc_exec($conn,$sql);
				while($f = odbc_fetch_array($result)){
				$lead_no = $f['lead_id'];
				$u_name = $f['fullname'];
				$p_name = $f['project_name'];
				$u_mail = $f['email'];
				$approval_code = $f['lead_code'];

				}


$msg="";
		
if(isset($_POST['approve'])){

	$remarks         = trim(dbOutput($_POST['remarks']));
	$lead_id 			   = $_GET['ld'];
	$code 				   = $_GET['code'];


	if ($lead_no == $lead_id && $approval_code == $code) {
		$query = "UPDATE opportunity set lead_approval_status = '0', lead_code = '0', current_stage = '2', lead_approve_date = '$timestamp', lead_approval_remark = '$remarks' where lead_id = '$lead_id'";
		$query_result = odbc_exec($conn, $query);


    $sql = "SELECT o.lead_id, d.deal_type, s.deal_sub_type, c.cka_name,o.project_contact_name,o.address, t.state_name, o.project_tile_potential_sqm, o.project_tile_potential_inr, o.lead_approval_remark, o.added_date, u.fullname, o.created_by, o.project_name, m.email, o.project_name  from opportunity o
      inner join user_management u on u.uid = o.created_by
      inner join deal_type d on d.deal_type_id = o.deal_type
      inner join deal_sub_type s on s.deal_sub_type_id = o.sub_type
      inner join state_master t on t.state_id = o.state_id
      inner join cka_name_master c on c.cka_name_id = o.cka_name_id
      inner join user_management m on m.uid = o.created_by where o.lead_id = '$lead_id'";

    $result = odbc_exec($conn,$sql);
        while($m = odbc_fetch_array($result)){
        
        $lead = $m['lead_id'];
        $name = $m['fullname'];
        $pr_name = $m['project_name'];
        $ud_mail = $m['email'];
        $user = $m['created_by'];
        $deal = $m['deal_type'];
        $sub_deal = $m['deal_sub_type'];
        $ckaccount = $m['cka_name'];
        $pcn = $m['project_contact_name'];
        $add =  $m['address'];
        $st = $m['state_name'];
        $ptps = $m['project_tile_potential_sqm'];
        $ptpi = $m['project_tile_potential_inr'];
        $rs = $m['lead_approval_remark'];
        $timestamp = $m['added_date'];


    }

    $m_query = "SELECT email, fullname from user_management where uid in (SELECT parent_id from user_management where uid = '$user')";
        $m_result=odbc_exec($conn, $m_query);
        $n=odbc_num_rows($m_result);
        
        while($u=odbc_fetch_array($m_result))
        {
          $m_fullname = $u['fullname'];
          $m_email = $u['email'];
        }

		if($query_result){
                        $to = $u_mail;
                        $subject = "PMT || New Lead Approval-[$lead]";
                        $body = "
                        <h4>Dear $name,</h4>
                        <br>
                        <p>This is an automatic email. Please DO NOT reply to this.
                        Your PMT Lead [$lead] has been Approved by Corresponding PCH</p>
                        
                        <table cellspacing=\"0\">
                              <tbody>
                                <tr>
                                  <td colspan=\"2\" style=\"vertical-align:top; width:458.75pt\">
                                  <h3><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PMT New Lead Updates</strong></h3>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Lead ID:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$lead</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Deal Type:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$deal</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Deal Sub Type:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$sub_deal</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Account Name:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$ckaccount</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Contractor Name:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$pcn</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Address:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$add</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>State:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$st</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Required Tiles (SQMT):</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$ptps</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Amount (INR):</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$ptpi</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Remarks:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$rs</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>PCH Name:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$m_fullname</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Status:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>Approved</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Created On:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$timestamp</p>
                                  </td>
                                </tr>
                              </tbody>
            </table>

                        <p><a href=\"http://pmt.orientapps.com/pmt/index.php\">Click Here</a> to Login in to PMT for more details. </p>
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
                          $mail->addCC($m_email);

                         
                          
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


	if ($lead_no == $lead_id && $approval_code == $code) {
		$query = "UPDATE opportunity set lead_approval_status = '2', lead_code = '0', lead_reject_date = '$timestamp', lead_reject_remark = '$remarks' where lead_id = '$lead_id'";
		$query_result = odbc_exec($conn, $query);

     $sql = "SELECT o.lead_id, d.deal_type, s.deal_sub_type, c.cka_name,o.project_contact_name,o.address, t.state_name, o.project_tile_potential_sqm, o.project_tile_potential_inr, o.lead_reject_remark, o.added_date, u.fullname, o.created_by, o.project_name, m.email, o.project_name  from opportunity o
      inner join user_management u on u.uid = o.created_by
      inner join deal_type d on d.deal_type_id = o.deal_type
      inner join deal_sub_type s on s.deal_sub_type_id = o.sub_type
      inner join state_master t on t.state_id = o.state_id
      inner join cka_name_master c on c.cka_name_id = o.cka_name_id
      inner join user_management m on m.uid = o.created_by where o.lead_id = '$lead_id'";

    $result = odbc_exec($conn,$sql);
        while($m = odbc_fetch_array($result)){
        
        $lead = $m['lead_id'];
        $name = $m['fullname'];
        $pr_name = $m['project_name'];
        $ud_mail = $m['email'];
        $user = $m['created_by'];
        $deal = $m['deal_type'];
        $sub_deal = $m['deal_sub_type'];
        $ckaccount = $m['cka_name'];
        $pcn = $m['project_contact_name'];
        $add =  $m['address'];
        $st = $m['state_name'];
        $ptps = $m['project_tile_potential_sqm'];
        $ptpi = $m['project_tile_potential_inr'];
        $rm = $m['lead_reject_remark'];
        $timestamp = $m['added_date'];
      }

    $m_query = "SELECT email, fullname from user_management where uid in (SELECT parent_id from user_management where uid = '$user')";
        $m_result=odbc_exec($conn, $m_query);
        $n=odbc_num_rows($m_result);
        
        while($u=odbc_fetch_array($m_result))
        {
          $m_fullname = $u['fullname'];
          $m_email = $u['email'];
        }


		if($query_result){

                        $to = $u_mail;
                        $subject = "PMT || New Lead Approval-[$lead]";
                        $body = "
                        <h4>Dear $name,</h4>
                        <br>
                        <p>This is an automatic email. Please DO NOT reply to this.
                        Your PMT Lead [$lead] has been Rejected by Corresponding PCH</p>

                        <table cellspacing=\"0\">
                              <tbody>
                                <tr>
                                  <td colspan=\"2\" style=\"vertical-align:top; width:458.75pt\">
                                  <h3><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PMT New Lead Updates</strong></h3>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Lead ID:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$lead</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Deal Type:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$deal</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Deal Sub Type:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$sub_deal</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Account Name:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$ckaccount</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Contractor Name:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$pcn</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Address:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$add</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>State:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$st</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Required Tiles (SQMT):</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$ptps</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Amount (INR):</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$ptpi</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Remarks:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>$rm</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>PCH Name:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$m_fullname</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"vertical-align:top; width:200.5pt\">
                                  <p>Status:</p>
                                  </td>
                                  <td style=\"vertical-align:top; width:301.5pt\">
                                  <p>Rejected</p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style=\"background-color:#f2f2f2; width:200.5pt\">
                                  <p>Created On:</p>
                                  </td>
                                  <td style=\"background-color:#f2f2f2; width:301.5pt\">
                                  <p>$timestamp</p>
                                  </td>
                                </tr>
                              </tbody>
            </table>
                        <p><a href=\"http://pmt.orientapps.com/pmt/index.php\">Click Here</a> to Login in to PMT for more details. </p>
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
                          $mail->addCC($m_email);

                         
                          
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
										<h4>Approval for New Lead <b>[<?php echo $lead_id ?>]</b></h4>
										This is an approval request for Lead generated by <b><?php echo $u_name ?></b> for <b>"<?php echo $p_name ?>"</b> . Kindly Approve/Reject with your relevent remarks.
									</div>
                        <!-- BEGIN FORM-->
                        <div class="control-group" style="text-align: center;">
                              <label class="control-label" style="color: red;"><b><?php echo $msg; ?></b></label>
                              
                           </div>
                        <form action="lead-approve.php?ld=<?php echo $lead_id ?>&code=<?php echo $code ?>" class="form-horizontal" style="margin-top: 30px !important;" method="POST">
                           
                           
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