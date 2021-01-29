<?php 
	        $sm='active';
	        $aa='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
//echo '<pre>';
//print_r($_SESSION);
	//print_r($_REQUEST);

//echo $_POST['wo'][0];

if(isset($_POST['wono'])){
	
	$wo=$_POST['wono'];

	//print_r($_POST);

$sqll="SELECT 
	sg.schedule_generated_date,
	s. schedule_id,
	s.recurrence_schedule,
	s.maintenance_type_id,
		a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.model_number,
	  a.serial_number,
	 a.asset_kept_area
	  ,atm.asset_type
      ,pbm.[plant_building_name]
      ,dsm.[department_section_name]
      ,lm.[location_name]
	  ,m.maintenance_type
	  ,a.safty_caution
       
	   from schedule_generated sg 
	   left join schedule s on sg.schedule_id = s.schedule_id
	   left join asset_master a on a.asset_id = s.asset_id
	   left join maintenance_type_master m on s.maintenance_type_id = m.maintenance_type_id
	   left join asset_type_master atm on a.asset_type=atm.asset_type_id
	   left join plant_building_master pbm on a.plant_building = pbm.plant_building_id
	   left join department_section_master dsm on a.department_section = dsm.department_section_id
	   left join location_master lm on a.asset_location = lm.location_master_id
     where a.factory_id='".$_SESSION['factory-id']."' and sg.schedule_generated_id='".$wo."'
	 ";
									$rss=odbc_exec($conn,$sqll);
									$fr = odbc_fetch_array($rss);
									//print_r($fr);


        $eid=implode(',',$_POST['engineer']);
$wo_date=$_POST['wo_yy'].'-'.$_POST['wo_mm'].'-'.$_POST['wo_dd'];

$dataArray=array(
	'wono'						=> 	$_POST['wono'],
	'work_order_date'			=>	$wo_date,
	'work_order_time'			=>  $_POST['work_order_time'],
	'work_order_description'	=>  $_POST['work_order_description'],
    'workorder_priority'		=>	$_POST['priority'],
    'work_order_engineer_id'	=>	$eid,


	   'asset_code'						=> $fr['asset_code'],
      'asset_type'						=>$fr['asset_type'],
      'asset_name'						=>$fr['asset_name'],
      'plant_building'					=>$fr['plant_building_name'],
      'dept'							=>$fr['department_section_name'],
      'location'						=>$fr['location_name'],
      'area'							=>$fr['asset_kept_area'],
      'model'							=>$fr['model_number'],
      'serial'							=>$fr['serial_number'],
      'maintenance_type'				=>$fr['maintenance_type'],
      'maintenance_date'				=>$fr['schedule_generated_date'],
      'schedule_recurrence'				=>$fr['recurrence_schedule'],
      'safty_caution'					=>$fr['safty_caution']

);

 $iins=" insert into work_order
([asset_code] ,[asset_type],[asset_name],[plant_building],[dept],[location],[area],[model],[serial],[maintenance_type],[maintenance_date],
	[schedule_recurrence],[safty_caution] ,[work_order_engineer_id] ,[workorder_start_date],[workorder_start_time] ,	[workorder_priority] ,
	[work_description] , [workorder_generated_timestamp] , schedule_generated_id, factory_id, work_order_type)
	values(
	'".$dataArray['asset_code']."', '".$dataArray['asset_type']."','".$dataArray['asset_name']."','".$dataArray['plant_building']."','".$dataArray['dept']."',
	'".$dataArray['location']."', '".$dataArray['area']."','".$dataArray['model']."','".$dataArray['serial']."',
	'".$dataArray['maintenance_type']."', '".$dataArray['maintenance_date']."','".$dataArray['schedule_recurrence']."',
	'".$dataArray['safty_caution']."','".$dataArray['work_order_engineer_id']."','".$dataArray['work_order_date']."',
	'".$dataArray['work_order_time']."','".$dataArray['workorder_priority']."','".$dataArray['work_order_description']."', CURRENT_TIMESTAMP, 
	'".$dataArray['wono']."', ".dbInput($_SESSION['factory-id']).", 'SCH' )";
		$sst = odbc_prepare($conn, $iins);
		if (odbc_execute($sst)){ 
			$msgTxt = 'Work Order Generated Sucessfully.';
			$msgType = 2;
			
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

$wo_action='Created';

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

Maintenance work order created for you, please do the needfull.<br><br>

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
		header('Location:schedule-management.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
		exit;
	//header('location:../../email-acknoledgment.php?BlanketOrderNumber='.base64_encode($BlanketOrderNumber).'');
	//exit;
}
			
			
			
//******EMAIL ENDS************EMAIL ENDS************EMAIL ENDS************EMAIL ENDS************EMAIL ENDS******
			
	
		}

}else{
	$wo=$_POST['wo'][0];	
}
?>

<script type="text/javascript">
function submitform()
{
		//alert('hello');
		var recurrence=document.getElementById("recurrence").value; 
		//var work_order_description=document.getElementById("work_order_description").value;
		var work_order_time=document.getElementById("work_order_time").value; 	
		var priority=document.getElementById("priority").value;
 
//alert(recurrence);

		var dd=document.getElementById("dd").value;
		var mm=document.getElementById("mm").value;
		var yy=document.getElementById("yy").value;
		var inputdate = dd+'/'+mm+'/'+yy;

		var today = new Date();
    	var d = today.getDate();
 	    var m = today.getMonth()+1; //January is 0!
	    var y = today.getFullYear();
	
	if(d<10){
		d='0'+d;
	}
	
	var curdate = d+'/'+m+'/'+y;

//alert(inputdate);
//alert(curdate);



if(dd=='' || mm==''|| yy==''){
    alert("Please select activation date");
	return false;

}

if(inputdate<curdate)
{
    alert("Error: Workorder date can not be less than today.");
	return false;
}


	if( (recurrence =='daily' || recurrence =='weekly' )  && (inputdate > curdate) )	{ 
			alert("Error: You cannot change Workorder date of daily/weekely maintenance schedule.");
			return false;
	}


//if(recurrence =='daily'){
//		if(inputdate>curdate)	 	
//		    alert("Error: Workorder date can not be change as it is daily schedule.");
//			return false;
//}





if (!work_order_time.trim()) {
     alert('Please enter work order start time');
	 return false;
}

if (!priority.trim()) {
     alert('Please select priority or work order.');
	 return false;
}

 
 
 var checkboxs=document.getElementsByName("engineer[]");
    var okay=0;
    for(var i=0,l=checkboxs.length;i<l;i++)
    {
        if(checkboxs[i].checked)
        {
            okay++;
	    }
    }
   
   if(okay > 0)
	  document.myform.submit();
	else
	  alert("Please select at least 1 engineer.");
	
}
</script>
	  

 
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Work Order Generate</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
     							<li class="">
                                 <a class="btn red" href="skip-reschedule.php?SCH_GDI=<?php echo $wo ?>"> 
                 <i class="icon-file"></i> Skip/Re-Schedule</a>
                                </li>			
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Work Order</a></li>

                           </ul>

                      <!-- tab 1 asset details start --> 
                           <!-- tab 1 asset details start --> 
                           <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
                                            <th>Asset Code</th>
											<th>Type</th>
											<th>Name</th>
											<th>Plant / Building</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>Area</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                            <th>MA Type</th>
                                            <th>MA Date</th>
                                            <th>Recurrence</th>
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		 $sql="SELECT 
	sg.schedule_generated_date,
	  sg.[original_sch_date],
      sg.[s_r_done_by],
      sg.[reason],
	  sg.timestamp,
	  
	s. schedule_id,
	s.check_list_id,
	s.recurrence_schedule,
	s.maintenance_type_id,
		a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.model_number,
	  a.serial_number,
	 a.asset_kept_area
	  ,atm.asset_type
      ,pbm.[plant_building_name]
      ,dsm.[department_section_name]
      ,lm.[location_name]
	  ,m.maintenance_type
	  ,a.safty_caution
       
	   from schedule_generated sg 
	   left join schedule s on sg.schedule_id = s.schedule_id
	   left join asset_master a on a.asset_id = s.asset_id
	   left join maintenance_type_master m on s.maintenance_type_id = m.maintenance_type_id
	   left join asset_type_master atm on a.asset_type=atm.asset_type_id
	   left join plant_building_master pbm on a.plant_building = pbm.plant_building_id
	   left join department_section_master dsm on a.department_section = dsm.department_section_id
	   left join location_master lm on a.asset_location = lm.location_master_id
     where a.factory_id='".$_SESSION['factory-id']."' and sg.schedule_generated_id='".$wo."'
	 ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$f['asset_code'].'</td>';
										echo '<td>'.$f['asset_type'].'</td>';										
										echo '<td>'.$f['asset_name'].'</td>';																
										echo '<td>'.$f['plant_building_name'].'</td>';	
										echo '<td>'.$f['department_section_name'].'</td>';
										echo '<td>'.$f['location_name'].'</td>';
										echo '<td>'.$f['asset_kept_area'].'</td>';
										echo '<td>'.$f['model_number'].'</td>';
										echo '<td>'.$f['serial_number'].'</td>';
										echo '<td>'.$f['maintenance_type'].'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['schedule_generated_date'])).'</td>';
										echo '<td>'.ucfirst($f['recurrence_schedule']).'</td>';
										$recurrence=trim($f['recurrence_schedule']);
										$mt_id=$f['maintenance_type_id'];
										$safty_caution=$f['safty_caution'];	
										$check_list_id=$f['check_list_id'];	
										
										$reason=$f['reason'];
										$s_r_done_by=$f['s_r_done_by'];
										$original_sch_date=$f['original_sch_date'];	
										 $timestamp=$f['timestamp'];							
									}
									?>
									 <input type="hidden" name="recurrence" value="<?php echo $recurrence?>" id="recurrence">
                                    </tbody>
									
								</table>
                                
      <?php if(!empty($original_sch_date)){?>
                                <table border="0" width="100%" >
                                <tr>
 <td width="40%" ><b><font color="#E00307">Original Schedule Date&nbsp;:&nbsp; </font><?php echo date('d-m-Y',strtotime($original_sch_date))?></b></td>
 <?php
 $ssql="select fullname from user_management where uid='".$s_r_done_by."' ";
 $rrs=odbc_exec($conn,$ssql);
 $fff = odbc_fetch_array($rrs);
?>
 <td width="30%" ><b><font color="#E00307">Re-Schedule By&nbsp;:&nbsp; </font><?php echo $fff['fullname'] ?></b></td>
 <td width="30%" ><b><font color="#E00307">Re-Schedule Done Date&nbsp;:&nbsp; </font><?php echo date('d-m-Y',strtotime($timestamp)); ?></b></td>
 
                                </tr>
 
                                <tr>
 <td  colspan="2" ><b><font color="#E00307">Reason for Re-Schedule&nbsp;:&nbsp; </font><?php echo $reason ?></b></td>
                                </tr>

                                </table>
<?php } ?>
                           <hr>
						<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="myform">
                        <input type="hidden" name="wono" value="<?php echo $wo?>">
                    
                     
                        	<table border="0" style="width:100%">
                            	<tr>
                                	<td rowspan="3" valign="top" style=" width: 200px; height:150px;  border: 1px solid #336699; padding-left: 5px">
                               	<b>Select Engineer: </b> 	
									<br>
								
								<?php
									$ssql="select * from user_management where user_type='engineer' and  maintenance_type='".$mt_id."' and factory_id='".$_SESSION['factory-id']."' ";
									$rrs=odbc_exec($conn,$ssql);
										while($fff = odbc_fetch_array($rrs)){
											if(trim($_SESSION['user_type'])=='engineer'){
											$ch=($_SESSION['uid']==$fff['uid'])?'checked':'disabled';
											}
										echo '<input type="checkbox" name="engineer[]" value='.$fff['uid'].' '.$ch.'>';
										echo $fff['fullname'];
										echo '<br>';

										}
							 ?>
                               
                                     </td>
                                     <td align="right"><b>Work Order Date: </b></td>
                                     	<td>
                                        <select name="wo_dd"  style="width:60px;" id="dd">
												<?php 
                                                    for($x=1; $x<=31; $x++){
                                                        //$selected=($_POST['installation_dd']==$x || date('d')==$x? 'selected' : '');
														if(empty($_POST['submit']) )
														 {
														 		if(date('d')==$x)
																$selected='selected';
																else		
																$selected='';
														 }else{
														  		if($_POST['wo_dd']==$x)
																$selected='selected';
																else		
																$selected='';
														 }
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                        
                                        <select name="wo_mm" style="width:120px;" id="mm">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<sizeof($monthArray);$x++){
													//	 $selected=($_POST['installation_mm']==$x || date('m')==$x ? 'selected' : '');
														 if(empty($_POST['submit']) )
														 {
														 		if(date('m')==$x)
																$selected='selected';
																else		
																$selected='';
														 }else{
														  		if($_POST['wo_mm']==$x)
																$selected='selected';
																else		
																$selected='';
														 }
														 
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="wo_yy" style="width:80px;" id="yy">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr)+1; $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                        
                                        </td>
                                     
                                     <td><b>Time: </b><input type="text" name="work_order_time" id="work_order_time" style="width:130px;"></td>
                                     
                                     <td><b>Priority: </b>
                                     	 <label class="radio">
                                        <input type="radio" name="priority" value="high"  id="priority" checked>High
										</label>
                                         <label class="radio">
                                        <input type="radio" name="priority" value="medium"  id="priority">Medium
										</label>
                                         <label class="radio">
                                        <input type="radio" name="priority" value="low"  id="priority" >Low</td>
										</label>
                                </tr>
                                   </div>
 
                            <tr>
                            	<td align="right" >
              
                                <b>Work Description: </b></td>
              
                                <td colspan="3">
                    <?php
					if(!empty($check_list_id)){	
					$cnt=1;
					 $ssql="select * from checklist_master where checklist_id in (".$check_list_id.") ";
									$rrs=odbc_exec($conn,$ssql);
								
                                echo '<textarea name="work_order_description" style="width:95%; height:150px; resize:none;">';							
									
									echo 'Checklist to do : ';
									
									while($fff = odbc_fetch_array($rrs)){
										echo $cnt.'.'.$fff['checklist_name'].' | ';
										//echo '<br>';
										$cnt++;
									}
									echo '&#13;&#10;';
								echo '</textarea>';
					}else{
					            echo '<textarea name="work_order_description" style="width:95%; height:150px; resize:none;"></textarea>';							
					}
						
								?>
                                </td>
                            </tr>
                            
                            	<tr>
                                    	<th style="background-color:#FFFFFF" align="right">Safty Caution:</th>
                                        <td colspan="11" style="color:#CD0003; background-color:#FFFFFF" ><?php echo $safty_caution; ?></td>
                                    </tr>
                            
                            </table>

									<div  style="text-align:right;">
                        
                         <a class="btn blue" href="javascript: submitform()"> <i class="icon-ok"></i> Save</a>
                 
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                             </form>
                              </div>
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