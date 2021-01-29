<?php 
	        $wrkod='active';
	        $la='active';

        include_once('including/all-include.php');
        include_once('including/header.php');




if(isset($_GET['wo_approve_id']) && base64_decode($_GET['wo_approve_id'])>0 ){

 echo $iins=" update work_order set	workorder_status='3' , wo_approved_rejected=2, wo_approve_rejected_by='".$_SESSION['uid']."', wo_remarks='".dbInput($_GET['wo_remarks'])."' where workorder_id = ".dbInput(base64_decode($_GET['wo_approve_id']))." and factory_id = ".dbInput($_SESSION['factory-id'])."  ";
		$sst = odbc_prepare($conn, $iins);
		if (odbc_execute($sst)){ 
			$msgTxt = 'Work Order Approved Sucessfully.';
			$msgType = 2;
			header('Location:generated-work-order-list.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			exit;
		}
}

//exit;

if(isset($_GET['wo_reject_id']) && base64_decode($_GET['wo_reject_id'])>0 ){

 $vsql="SELECT * from work_order where workorder_id='".trim(base64_decode($_GET['wo_reject_id']))."'	 ";
$vrs=odbc_exec($conn,$vsql);
$v = odbc_fetch_array($vrs);

 
 	
	$dataArray=array(
	'wono'						=> 	$_GET['wo_reject_id'],
	'work_order_date'			=>	$v['workorder_start_date'],
	'work_order_time'			=>  $v['workorder_start_time'],
	'work_order_description'	=>  $v['work_description'],
    'workorder_priority'		=>	$v['workorder_priority'],
	'work_order_engineer_id'	=>  $v['work_order_engineer_id'],


   'asset_code'						=> $v['asset_code'],
  'asset_type'						=>$v['asset_type'],
  'asset_name'						=>$v['asset_name'],
  'plant_building'					=>$v['plant_building'],
  'dept'							=>$v['dept'],
  'location'						=>$v['location'],
  'area'							=>$v['area'],
  'model'							=>$v['model'],
  'serial'							=>$v['serial'],
  'maintenance_type'				=>$v['maintenance_type']
);

										
										
echo $iins=" update work_order set	workorder_status='1',wo_approved_rejected=2, wo_approve_rejected_by='".$_SESSION['uid']."', wo_remarks='".dbInput($_GET['wo_remarks'])."' where workorder_id = ".dbInput(base64_decode($_GET['wo_reject_id']))." and factory_id = ".dbInput($_SESSION['factory-id'])."   ";
		$sst = odbc_prepare($conn, $iins);
		if (odbc_execute($sst)){ 
			$msgTxt = 'Work Order Rejected  Sucessfully.';
			$msgType = 2;
			
//			exit;
			header('Location:generated-work-order-list.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			exit;
		
		//******EMAIL START************EMAIL START************EMAIL START************EMAIL START************EMAIL START******
			
			
			require("mail/phpmailer/class.phpmailer.php"); // path to the PHPMailer class


 echo !extension_loaded('openssl')?"Not Available":"Available";
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
$mail->FromName="PMS System";

$wo_action='Rejected';

$mail->Subject  = "Maintenance Work Order $wo_action";


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


//$mgr1='vineet.kumar@orientbell.com';
//$mgr2='vijay.thakur@orientbell.com';

//$mail->AddAddress($mgr1); 
 //$mail->AddAddress($mgr2); 
 
$bcc = "sanjeev.gupta@orientbell.com;anil.agarwal@orientbell.com"; //(use ; for multiple)
if($bcc)$mail->AddBCC($bcc);

$mailbody= "
<hr><font color=red size=2> This is a system generated mail. Please do not reply to this email ID. <hr></font>

<b>Dear $name,</b><br><br>

Maintenance work order rejected for you, please check and do the needfull.<br><br>

<table border=1  cellpadding=8 style=font:14px Verdana, Geneva, sans-serif;>
  
 <tr>
    <td colspan=2><b>WORK ORDER DETAILS</b></td>
  </tr>
  
  <tr>
    <td>Work Order Type:</td>
    <td>Scheduled Work Order</td>
  </tr>
  
   <tr>
    <td>Work Order Date:</td>
    <td>$dataArray[work_order_date]</td>
  </tr>
  
  <tr>
    <td>Maintenance Type:</td>
    <td>$dataArray[maintenance_type]</td>
  </tr>
  
  
  <tr>
    <td>Asset Code:</td>
    <td>$dataArray[asset_code]</td>
  </tr>
 
  <tr>
    <td>Asset Type:</td>
    <td>$dataArray[asset_type]</td>
  </tr>
  <tr>
    <td>Asset Name:</td>
    <td>$dataArray[asset_name]</td>
  </tr>
  
    <tr>
    <td>Asset Model:</td>
    <td>$dataArray[model]</td>
  </tr>
 
  <tr>
    <td>Asset Serial:</td>
    <td>$dataArray[model]</td>
  </tr>

  
  <tr>
    <td>Plant / Building:</td>
    <td>$dataArray[plant_building]</td>
  </tr>
  
  <tr>
    <td>Department:</td>
    <td>$dataArray[dept]</td>
  </tr>
  
  <tr>
    <td>Location:</td>
    <td>$dataArray[location]</td>
  </tr>
  
<tr>
    <td>Asset Kept Area:</td>
    <td>$dataArray[area]</td>
  </tr>
  
  
 
</table>


<br><br>
<b>Warm Regards,<br>
Plant Maintenance Team</b>
<br><br>



<br><font size=1>
----------------------------------------------------------------------- DISCLAIMER ----------------------------------------------------------------------- <br>
The contents of this e-mail and any attachment(s) are confidential and intended for the named recipient(s) only. It shall not attach any liability on the originator or Orient Bell Ltd. (OBL) or its affiliates. Any views or opinions presented in this email are solely those of the author and may not necessarily reflect the opinions of OBL or its affiliates. Any form of reproduction, dissemination, copying, disclosure, modification, distribution and / or publication of this message without the prior written consent of the author of this e-mail is strictly prohibited. If you have received this email in error please delete it and notify the sender immediately. Before opening any mail and attachments, please check them for viruses and defect.<br>
";

echo $mailbody;

$mail->Body="$mailbody";
$mail->WordWrap = 50; 




if(!$mail->Send()) {
echo 'E-mail was not sent.';
echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
echo 'Message has been sent.';
			header('Location:generated-work-order-list.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			exit;

	//header('location:../../email-acknoledgment.php?BlanketOrderNumber='.base64_encode($BlanketOrderNumber).'');
	//exit;
}
			
			
			
//******EMAIL ENDS************EMAIL ENDS************EMAIL ENDS************EMAIL ENDS************EMAIL ENDS******
		
		
		
		}
}



	

if(isset($_POST['submit-form'])){
	 $from_date=$_POST['from_year'].'-'.$_POST['from_month'].'-'.$_POST['from_date'];
 	 $to_date=$_POST['to_year'].'-'.$_POST['to_month'].'-'.$_POST['to_date'];
//	print_r($_POST);
	
	$dataArray=array(
		'from_date'					=> $from_date,
		'to_date'					=> $to_date,
		'maintenance_type'			=> trim($_POST['maintenance_type']),
		'engineer'					=> trim($_POST['engineer']),
		'pbm'					=> trim($_POST['pbm']),
//	'wo_type'					=> trim($_POST['wo_type']),
		'wo_status'					=> trim($_POST['wo_status']),
		'asset_type'				=> trim($_POST['asset_type'])
	);
	
	$sq="select * from work_order where workorder_start_date  between '".$dataArray['from_date']."' and '".$dataArray['to_date']."' and work_order_type= 'SCH' "; 
	
	if(!empty($dataArray['maintenance_type'])){
		$sq.=" and maintenance_type = '".$dataArray['maintenance_type']."' ";
	}

	if(!empty($dataArray['engineer'])){
		$sq.=" and work_order_engineer_id = '".$dataArray['engineer']."' ";
	}

	//if(!empty($dataArray['wo_type'])){
	//	$sq.=" and work_order_type = '".$dataArray['wo_type']."' ";
	//}
	
	if(!empty($dataArray['pbm'])){
		$sq.=" and plant_building = '".$dataArray['pbm']."' ";
	}

	if(!empty($dataArray['wo_status'])){
		if($dataArray['wo_status']=='pending')
		$sq.=" and workorder_status is null";
		else
		$sq.=" and workorder_status = '".$dataArray['wo_status']."' ";
	}
	
	if(!empty($dataArray['asset_type'])){
		$sq.=" and asset_type = '".$dataArray['asset_type']."' ";
	}
	

	
	//workorder_status='".$_POST['wo_status']."' ";

}else{

	 $from_date=date('Y').'-'.intval(date('m')).'-'.date('01');
 	 $to_date=date('Y').'-'.intval(date('m')).'-'.date('d');
	
	//$sq="select * from  work_order ";
$sq="select * from  work_order where workorder_start_date >= '".$from_date."' and workorder_start_date <= '".$to_date."' and  work_order_type='SCH' "; 
	//without submit vks
	//$sq="select * from  work_order where work_order_type='SCH'"; 
}


	$sq .=" order by workorder_id desc";

//print_r($_SESSION);
	//echo $sq;

if(isset($_GET['woacceptid'])){
	//print_r($_POST);
	//print_r($_SESSION);

	$in="update work_order set workorder_status = 1, 
		  workorder_accepted_by_uid = '".$_SESSION['uid']."',
		  workorder_accepted_timestamp = CURRENT_TIMESTAMP
		  where workorder_id='".$_GET['woacceptid']."' ";
			$pp=odbc_prepare($conn,  $in);
		$ex=odbc_execute($pp);
	
	
}


 ?>
 
      
 <script>
 function accept(){
	if(confirm ('Are you sure to accept this work order.'))
	return true;
	else
	return false;
 }
 </script>  
 
 <script>
 function submitform(){
 	//alert('hello');
document.myform.submit();
 }
 </script>            

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box red">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>List of All Work Order Generated</h4>
								<div class="tools">
                             
                                   
                                    <a href="javascript:;" class="collapse"></a>
									
								</div>
							</div>
							<div class="portlet-body">

                  			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="myform">
                         <div style="width:100%;" >   

                                     <b> From Date</b>
                                
                                          <select  name="from_date"  style="width:60px;">
												<?php 
                                                    for($x=1; $x<=31; $x++){
												   //$selected=($_POST['from_date']==$x || date('d')==$x? 'selected' : '');
													 $selected=($_POST['from_date']==$x) ? 'selected' : '';
													if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select name="from_month" style="width:110px;">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<=date('m');$x++){
														
														if(empty($_POST['submit-form']) )
														 {
														 		if(date('m')==$x)
																$selected='selected';
																else		
																$selected='';
														 }else{
														  		if($_POST['from_month']==$x)
																$selected='selected';
																else		
																$selected='';
														 }
														
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="from_year" style="width:70px;">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['from_year']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
										
                                    &nbsp;&nbsp;&nbsp;
                                      <b> To Date</b>
                                      
                                                   <select name="to_date"  style="width:60px;">
												<?php 
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['installation_dd']==$x || date('d')==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select  name="to_month" style="width:110px;">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<=date('m');$x++){
														
														if(empty($_POST['submit-form']) )
														 {
														 		if(date('m')==$x)
																$selected='selected';
																else		
																$selected='';
														 }else{
														  		if($_POST['to_month']==$x)
																$selected='selected';
																else		
																$selected='';
														 }
														 
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="to_year" style="width:70px;">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
									
                                    &nbsp;&nbsp;&nbsp;
                                    <b>Maintenance Type</b>
                         	<select name="maintenance_type" style="width:240px;">
                                       		<option value="">All</option>
                                             <?php
									$ssql="select * from maintenance_type_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$selected=($_POST['maintenance_type']==$f['maintenance_type'])?'selected':'';
										echo '<option value="'.$f['maintenance_type'].'" '.$selected.'>'.$f['maintenance_type'].'</option>';
										}
									?>
                                          </select>
                                          <br>
									&nbsp;&nbsp;&nbsp;
                                    
                                    <b>Engineer</b>
                         	<select name="engineer" style="width:180px;">
                                       		<option value="">All</option>
                                             <?php
									$ssql="select * from user_management where user_type='engineer' and factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
										$selected=($_POST['engineer']==$f['uid'])?'selected':'';
										echo '<option value="'.$f['uid'].'" '.$selected.'>'.$f['fullname'].'</option>';
										}
									?>
                                          </select>
								 &nbsp;&nbsp;
                            	<?php /*?> &nbsp;&nbsp;
                                   <b>WO Type</b>
                                  <select name="wo_type" style="width:120px;">
                                       		<option value="">All</option>
                                            <option value="SCH" <?php echo ($_POST['priority']=='high')?'selected':''?>>Scheduled</option>
                                            <option value="BRK" <?php echo ($_POST['priority']=='medium')?'selected':''?>>Breakdown</option>
                                            <option value="UNS" <?php echo ($_POST['priority']=='low')?'selected':''?>>Un-Scheduled</option>
									
                                          </select>
                            	 &nbsp;&nbsp;<?php */?>
                                
                                &nbsp;&nbsp;
                                    <b>Plant/Building</b>
                         	<select name="pbm" style="width:100px;">
                                       		<option value="">All</option>
                                             <?php
									$ssql="select * from plant_building_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$selected=($_POST['pbm']==$f['plant_building_name'])?'selected':'';
										echo '<option value="'.$f['plant_building_name'].'" '.$selected.'>'.$f['plant_building_name'].'</option>';
										}
									?>
                                          </select>
                                   
									  
                                 &nbsp;&nbsp;
                                   <b>Status</b>
                                  <select name="wo_status" style="width:160px;" >
                                       		<option value="" <?php  echo  ($_POST['wo_status']=='')?'selected':''?>>All</option>
                                           <option value="pending" <?php  echo  ($_POST['wo_status']=='pending')?'selected':'pending'?>>Pending</option>
                                            <option value="1"  <?php echo  ($_POST['wo_status']=='1')?'selected':''?>>Work on progress</option>
                                            <option value="2" <?php echo  ($_POST['wo_status']=='2')?'selected':''?>>Pending for Approval</option>
                                            <option value="3" <?php echo  ($_POST['wo_status']=='3')?'selected':''?>>Approved</option>
                                          
                                          </select>
                            	 &nbsp;&nbsp;
                                  
                                   &nbsp;&nbsp;
                                   <b>Asset Type</b>
									<select name="asset_type" style="width:170px;">
                                       		<option value="">All</option>
                                             <?php
									$ssql="select asset_type from asset_type_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
										$selected=(trim($_POST['asset_type'])==trim($f['asset_type']))?'selected':'';
										echo '<option value="'.trim($f['asset_type']).'" '.$selected.'>'.trim($f['asset_type']).'</option>';
										}
									?>
                                          </select>
                            	 &nbsp;&nbsp;
                                    <input type="hidden" name="submit-form" value="submit-form">
                                    <input type="submit" value="Search" >
								</form>
                        	
                            </div>
									
                      <?php
							  	$rs=odbc_exec($conn,$sq);
									
									if( ! odbc_num_rows($rs)){
										echo '<h3 align="center"><br><br>No Workorder Generated Today</h3>';
										exit;
									}
					  ?>              
                        <table class=" table-striped table-hover table-bordered"  width="100%">
									<thead>
										<tr align="center" style="background-color:#000; color:#FFF">
                                            <th>#</th>
                                            <th width="5%">WO ID</th>
                                            <th width="10%">WO Date</th>
                                           <!-- <th>WO Type</th>-->
                                            <th width="13%">Engineer</th>
                                           
                                            <th >Asset Code</th>
											<th>Name</th>
											<th>Plant</th>
										<!--	<th>Dept</th>-->
											<th>Location</th>
                                            <th>MA Type</th>
                                             <th width="13%">WO Status</th>
                                             <th width="9%">Action</th>                                           
                                        </tr>
									</thead>

                                    <tbody>
 								<?php
									//echo $sq;
								

									
	
									$count=1;
									while($f = odbc_fetch_array($rs)){
									//print_r($f);	
											$e=array(
												'eng'	=> trim($f['work_order_engineer_id'])
											);
										//echo '<pre>';
										//print_r($e);
										
										if($_SESSION['user_type']=='engineer' || $_SESSION['user_type']=='superwiser' ){
											if(trim($_SESSION['maintenance_type_name'])!=trim($f['maintenance_type']))
											continue;
										
										if ($_SESSION['user_type']=='engineer'  && !in_array($_SESSION['uid'], $e)) {
												continue;
											}
												
										
											//if($f['workorder_status']==2 && $_SESSION['user_type']=='engineer')
											//continue;	
										
										
										}
										if(trim($_SESSION['user_type'])=='general'){
										
											continue;
										}
										//echo '<pre>';
										//print_r($f);
										echo '<tr align="center">';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['workorder_id'].'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['workorder_start_date'])).'</td>';
										//echo '<td>'.strtoupper($f['work_order_type']).'</td>';
										echo '<td>';
											 $se="select fullname from user_management where uid in (".$f['work_order_engineer_id'].")";
											$rse=odbc_exec($conn,$se);
											$ce=1;
											while($fr = odbc_fetch_array($rse)){
												echo $ce.'. ';
												echo $fr['fullname'];
												echo '<br>';
												$ce++;
											}
										echo '</td>';
										
										if($f['workorder_status']==1){
											if($f['wo_approved_rejected']==2){
												$stat='Rejected';	
											}else{
												$stat='Work on progress';
											}
										}
										
										if($f['workorder_status']==2){
											$stat='Pending for approval';
										}
										
										if(empty($f['workorder_status'])){
											$stat='Pending';
										}
										
										if($f['workorder_status']==3){
											$stat='Completed';
										}
									
										
										
										echo '<td>'.strtoupper($f['asset_code']).'</td>';																										
										echo '<td>'.ucfirst($f['asset_name']).'</td>';	
										echo '<td>'.$f['plant_building'].'</td>';
										//echo '<td>'.$f['dept'].'</td>';
										echo '<td>'.$f['location'].'</td>';
										echo '<td>'.$f['maintenance_type'].'</td>';
										//<a href="#" data-toggle="modal" class="btn mini purple" title="View"><i class=" icon-eye-open"> View</i></a>';
										echo '<td align="center">'.$stat.'</td>';
										echo '<th>';


echo '
<a href="show-work-order-details.php?woid='.$f['workorder_id'].'" data-toggle="modal" class="btn mini green" title="View Work Order"><i class=" icon-eye-open"> View WO </i></a>
	';	
	


	echo '</th>';
		$count++;
				}
	?>
									</tbody>
								</table>
							
                        </div>  
                         <?php /*?><button class="btn red"> <a href="generate-schedule.php" style="color:#FFFFFF">Generate Schedule </a></button>
							  <button class="btn red"> <a href="generate-schedule.php" style="color:#FFFFFF">Generate Work Order</a></button><?php */?>						                                
                            
			
                            		
								</div>
								
                                
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	   <!-- END CONTAINER -->
   <?php include_once('including/footer.php')?>
   <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
			$ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>