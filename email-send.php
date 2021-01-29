<?php
require("mail/phpmailer/class.phpmailer.php"); // path to the PHPMailer class


!extension_loaded('openssl')?"Not Available":"Available";
$mail = new PHPMailer();  
 
$mail->IsSMTP();  // telling the class to use SMTP
$mail->SMTPdebug = true;
$mail->CharSet = 'UTF-8';
$mail->IsHTML();
$mail->Mailer = "smtp";
$mail->SMTPSecure = "tls";
$mail->Host = "smtp.logix.in";
$mail->Port = 587;
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "donotreply@orientbell.com"; // SMTP username
$mail->Password = "Orient@987"; // SMTP password 
 
$mail->From = "donotreply@orientbell.com";
$mail->FromName="Pipeline Management Tool";

$fromemp='Vineet Kumar';

$mail->Subject  = "PMT Support Request by ".$fromemp." ";

/*
	$se="select fullname,email from user_management where uid in (".$dataArray['work_order_engineer_id'].")";
	$rse=odbc_exec($conn,$se);
	$c=0;
	while($fr = odbc_fetch_array($rse)){
		++$c;
		$mail->AddAddress($fr['email']); 
	if($c==1)
		$name=$fr['fullname'];
	else
		$name.=' / '.$fr['fullname'];
	}
*/


$mgr1='vineet.kumar@orientbell.com';
//$mgr2='vijay.thakur@orientbell.com';

$mail->AddAddress($mgr1); 
 //$mail->AddAddress($mgr2); 
 
//$bcc = "sanjeev.gupta@orientbell.com;anil.agarwal@orientbell.com"; //(use ; for multiple)
//if($bcc)$mail->AddBCC($bcc);

$mailbody= "
<b>Dear name,</b><br><br>

Vineet Kumar from BD Department need your support for executing following below lead, Please provide your utmost support by 11 Jan 2018 and get in touch as soon as possible for further clarifications. <br><br>

<table cellpadding=5 style=font:14px Verdana, Geneva, sans-serif; width=600px; bgcolor=#009999>
  <tr>
    <td colspan=4><b><font color=#FFFFFF>Support Requirement Details</font></b></td>
  </tr>
  
  <tr>
    <td bgcolor=#FFFFFF><b>Activity:</b></td>
	<td bgcolor=#FFFFFF>Architect Design SKU Approval</td>     
	<td bgcolor=#FFFFFF><b>Time Line</b></td>	
	<td bgcolor=#FFFFFF>10-Dec-2018</td>
  </tr>

  <tr>
    <td bgcolor=#FFFFFF><b>Request Reamarks</b></td> 
	<td colspan=3 bgcolor=#FFFFFF>asdf</td>     
  </tr>
</table>  

<br><br>

<table cellpadding=5 style=font:14px Verdana, Geneva, sans-serif; width=800px; bgcolor=#009999>
  <tr>
    <td colspan=2><b><font color=#FFFFFF>Basic Lead Details</font></b></td>
  </tr>
  
  <tr>
    <td bgcolor=#FFFFFF><b>Account Name:</b></td>
	<td bgcolor=#FFFFFF>sdf</td>     
  </tr>

  <tr>
    <td bgcolor=#FFFFFF><b>Project Name:</b></td>
	<td bgcolor=#FFFFFF>sdf</td>     
  </tr>

  <tr>
    <td bgcolor=#FFFFFF><b>Project Type:</b></td>
	<td bgcolor=#FFFFFF>sdf</td>     
  </tr>

  <tr>
    <td bgcolor=#FFFFFF><b>City:</b></td>
	<td bgcolor=#FFFFFF>sdf</td>     
  </tr>

  <tr>
    <td bgcolor=#FFFFFF><b>OBL Forecast:</b></td>
	<td bgcolor=#FFFFFF>sdf</td>     
  </tr>

  <tr>
    <td bgcolor=#FFFFFF><b>Tiling Date:</b></td>
	<td bgcolor=#FFFFFF>sfd </td>     
  </tr>

  <tr>
    <td bgcolor=#FFFFFF><b>Current Sales Phase:</b></td>
	<td bgcolor=#FFFFFF>sdf</td>     
  </tr>

  <tr>
    <td bgcolor=#FFFFFF><b>Link for Complete Lead Detail:</b></td> 
	<td bgcolor=#FFFFFF>
	<a href=http://localhost:8080/pipeline/lead-history.php?pid=1498 target=_blank>http://localhost:8080/pipeline/lead-history.php?pid=1498</a>
	</td>     
  </tr>
</table>  


<br><br>
<b>Warm Regards,<br>
Orient Bell Tiles</b>
<br><br>

<hr>
	<font color=red size=2> 
		<u>Note</u>:
		This is a system generated mail. Please do not reply to this email ID. For Any clarification, Please contact to concern person/department.
	</font>
<hr>

<br><font size=1>
----------------------------------------------------------------------- DISCLAIMER ----------------------------------------------------------------------- <br>
The contents of this e-mail and any attachment(s) are confidential and intended for the named recipient(s) only. It shall not attach any liability on the originator or Orient Bell Ltd. (OBL) or its affiliates. Any views or opinions presented in this email are solely those of the author and may not necessarily reflect the opinions of OBL or its affiliates. Any form of reproduction, dissemination, copying, disclosure, modification, distribution and / or publication of this message without the prior written consent of the author of this e-mail is strictly prohibited. If you have received this email in error please delete it and notify the sender immediately. Before opening any mail and attachments, please check them for viruses and defect.<br>
";

echo $mailbody;

$mail->Body="$mailbody";
$mail->WordWrap = 50; 

/*
if(!$mail->Send()) {
echo 'E-mail was not sent.';
echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
echo 'Message has been sent.';
		//header('Location:schedule-management.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
		//exit;
	//header('location:../../email-acknoledgment.php?BlanketOrderNumber='.base64_encode($BlanketOrderNumber).'');
	//exit;
}
			
*/			
			
//******EMAIL ENDS************EMAIL ENDS************EMAIL ENDS************EMAIL ENDS************EMAIL ENDS******

?>