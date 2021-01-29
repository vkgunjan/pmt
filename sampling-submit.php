
<script>
function show_data(){
	
var	opportunity_id = document.getElementById("opportunity_id").value;
var sku_size = document.getElementById("sku_size").value;
var tile_category = document.getElementById("tile_category").value;
var tile_name = document.getElementById("tile_name").value;
var desc = document.getElementById("desc").value;
var qty = document.getElementById("qty").value;
var sampling_date = document.getElementById("sampling_date").value;
var sp_remark = document.getElementById("sp_remark").value;

	if(sku_size==""){
			alert("Error: Please Choose SKU Size");
			return false;
		}

	if(tile_category==""){
			alert("Error: Please Choose Tile Category");
			return false;
		}

	if(tile_name==""){
			alert("Error: Please Enter Tile Name");
			return false;
		}

	if(desc==""){
			alert("Error: Please Enter Tile Descreption");
			return false;
		}
	if(qty==""){
			alert("Error: Please Enter Quantity");
			return false;
		}
	if(sampling_date==""){
			alert("Error: Please Enter Sampling Date");
			return false;
		}

	if(sp_remark==""){
			alert("Error: Please Enter Sampling Remarks");
			return false;
		}


 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("sp_data").innerHTML =
      this.responseText;
    }
  };
 
xhttp.open("GET","sampling_details.php?opportunity_id="+opportunity_id+"&sku_size="+sku_size+"&tile_category="+tile_category+"&tile_name="+tile_name+"&desc="+desc+"&qty="+qty+"&sampling_date="+sampling_date+"&sp_remark="+sp_remark,true);
  xhttp.send();
}
</script>

<?php

	        $pm='active';
	        $samp='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['fld_leadID']=$_REQUEST['pid'];
		$fullname = $_SESSION['fullname'];
		$parent_id = $_SESSION['parent_id'];
		$code = rand(10000, 1000000);

//action plan_project_session_id
	$_SESSION['action_plan_opp_id']=$_REQUEST['pid'];
	$_SESSION['sampling_opp_id']=$_REQUEST['pid'];
	
//print_r($_SESSION);
//asset part starts
//echo '<pre>';
//print_r($_POST);

$errorArray=array();
$dataArray=array();
$timestamp=date('Y-m-d H:i:s');

$pid=(int)$_REQUEST['pid'];		

if(isset($_POST['formsubmit'])) {


$dataArray=array(
		'status' 				=> $_POST['status'],
		'lost_by' 				=> $_POST['lost_by'],
		'reason_for_lost' 		=> $_POST['reason_for_lost'],
		'remarks'				=> $_POST['lost_remark'],
		'spl_remark'			=> $_POST['spl_remark']
	);

// Date checking
	if($dataArray['status']=='lost' && empty($dataArray['remarks'])){
		$errorArray['remarks']='Error: Please Enter Lost Remarks';
	}

	if($dataArray['status']=='lost' && empty($dataArray['lost_by'])){
		$errorArray['remarks']='Error: Please Select Lost By';
	}

	if($dataArray['status']=='lost' && empty($dataArray['reason_for_lost'])){
		$errorArray['reason_for_lost']='Error: Please Enter Reason for Lost';
	}
	
	if($dataArray['status']=='close' && empty($dataArray['spl_remark'])){
	
		$errorArray['spl_remark']='Error: Please Enter Sampling Level Remarks';
	}
	
	
if(empty($errorArray)) {
	
	 if(isset($pid) && $pid>0){

		 $upd2  ="UPDATE opportunity set  ";
		 
		 if($dataArray['status'] =='lost') {
					 $upd2 .=" status='lost', lost_date= '".dbInput($timestamp)."', lost_by= '".dbInput($dataArray['lost_by'])."', reason_for_lost= '".dbInput($dataArray['reason_for_lost'])."', lost_remark= '".dbInput($dataArray['remarks'])."'	 ";
				}

		
		 if($dataArray['status'] =='close'){
					 $upd2.=" sampling_date='".dbInput($timestamp)."', spl_remark= '".dbInput($dataArray['spl_remark'])."', sampling_status = '1', sampling_code = '$code' ";
				}
				
		 $upd2 .=" where opportunity_id='".(int)dbInput($pid)."'";

		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd2);
		$stmt_ex = odbc_execute($stmt);

				

				if ($stmt_ex){
										

					$msgTxt = ' Sampling Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Sampling Information , Please Try Later.';
					$msgType = 2;
				}
		}
	
				//header('Location:sampling.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				//exit;
				$ssql="select * from fld where opp_id='".$_SESSION['fld_leadID']."'";	
$rs=odbc_exec($conn,$ssql);
$vv=odbc_num_rows($rs);


	while($f = odbc_fetch_array($rs)){
	//print_r($f);
	$av=$f['fld_id'];

		if(count($_POST['sampling'])>0){
			$tick='';
			foreach($_POST['sampling'] as $sd)
				if($sd==$f['fld_id']){
					$tick='checked';
				}
		}
							
	//echo $sd;
		//echo $tick;					
								
		foreach($_POST['no_of_sku'] as $key => $nsku){
			if($key==$av){
				if(empty($_POST['no_of_sku'][$av]) && $tick=='checked'){
					$c='red';
					$skucheck++;
				}else{
					$c='';
				}
			}
		}

                              
		

	}//while closure

//echo '<br>';
//echo 'nosku-'.$skucheck;
//echo '<br>';
//echo 'tcat-'.$tcat;


	if($skucheck+$tcat>=1){
		$error='Form not completed...Error';
	}else{
		
		// updation process start 
		
		//print_r($_POST);
			$fchk=0;
			foreach($_POST['sampling'] as $sd){
				//echo $sd;
				$_POST['no_of_sku'][$sd];
				

				 $upd="update fld set sampling='No', 
					  no_of_samples_given='".$_POST['no_of_sku'][$sd]."'
					  where fld_id='".$sd."' ";
					
					$stmt = odbc_prepare($conn, $upd);

				if (odbc_execute($stmt)){ 
					$msgTxt = ' Sampling Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Sampling Details, Please Try Later.';
					$msgType = 2;
					$fchk++;
				}
			}// main foreach ends
				//echo 'vin-'.$fchk;

				if(!$fchk){
				
				echo $upd1= "update opportunity set current_stage='2', 
						product_approval_date='".dbInput($timestamp)."'  
						where opportunity_id='".$_SESSION['fld_leadID']."' ";
				
						$stmt1 = odbc_prepare($conn, $upd1);
						$stmt1_ex = odbc_execute($stmt1);

						//query for parent name and email id

						$m_query = "SELECT fullname, email from user_management where uid = '$parent_id'";
						$m_result=odbc_exec($conn, $m_query);
						$n=odbc_num_rows($m_result);
						
						while($d=odbc_fetch_array($m_result))
						{
							$m_fullname = $d['fullname'];
							$m_email = $d['email'];
						}

						// query end
						//query for fld details for email

						$lead = "SELECT * from opportunity where opportunity_id='".(int)dbInput($pid)."'";
						$lead_result = odbc_exec($conn, $lead);
						while($l = odbc_fetch_array($lead_result)){
							$lead_no = $l['lead_id'];
							$p_name = $l['project_name'];
							$s_remark = $l['spl_remark'];
							$p_city = $l['city'];
						}

						if ($stmt1_ex){

							$subject = "PMT || Sampling Approval Request-[$lead_no]";
                        $to = $m_email;
                        $body = '<html>
							        <head>
							        <title></title>
							         <style>
									    table{
									    border-collapse: collapse;
									    width: 100%;
											}

										th, td {
										  border: 0.5px solid #ddd;
										    text-align: left;
										    padding: 4px;
										    color:black
										}

										tr:nth-child(even){background-color: #f2f2f2}

										th {
										    background-color: #4CAF50;
										    color: white;
										}
									</style>
								</head>
								<body>';
                       	
						$body .= "
						<h3>Dear $m_fullname,</h3>

						<p>This is an auto generated Email. Please do not reply on this. Quotation request has been raised by  '<b>$fullname</b>'  for Project, named as  '<b>$p_name</b>' belongs to '<b>$p_city</b>' . Kindly Approve/Reject request from below link for any further operation.</p>

						<p>Please find below details.</p>";

						$body .= '<table>
									<thead>
										<tr>
											<th>FLD ID</th>
		                                    <th>SKU Size</th>
		                                    <th>Tile Category</th>
		                                    <th>Tile Name</th>
		                                    <th>Qty</th>
		                                    <th>OBL Price/Unit</th>
		                                    <th>No of Sample Given</th>
		                                    <th>PCH Approval</th>
		                                    <th>Competitor</th>
											
                                        </tr>
									</thead>
									<tbody>';


						$mail_query = "SELECT * from fld where opp_id = '".$_SESSION['fld_leadID']."'";
						$mail_result = odbc_exec($conn, $mail_query);
						$mm=odbc_num_rows($mail_result);
						while($m = odbc_fetch_array($mail_result)){
						$fld = $m['fld_id'];
						$size = $m['size'];
						$qty = $m['qty'];
						$competitor = $m['competitor'];
						$tile_cat = $m['sample_tile_cateroty'];
						$approved_tile = $m['approved_tile_name'];
						$obl_price = $m['obl_bid_price'];
						$sample_given = $m['no_of_samples_given'];
						$samp_status = $m['sampling'];
						

						
				
								$body .= " <tr>
											<td>{$fld}</td>
		                                    <td>{$size}</td>
		                                    <td>{$tile_cat}</td>
		                                    <td>{$approved_tile}</td>
											<td>{$qty}</td>
		                                    <td>{$obl_price}</td>
		                                    <td>{$sample_given}</td>
		                                    <td>{$samp_status}</td>
		                                    <td>{$competitor}</td>";

		                
						$body .= "</tr>";
                         }

						$body .= " </tbody>
						</table>

						<p><b>Sampling Remarks:</b>&nbsp; $s_remark</p>

						<p><a href=\"http://pmt.orientapps.com/pmt/sample-approve.php?ld=$lead_no&code=$code\">Click Here</a> to Approve/Reject the Sampling for futher operation.</p>
						<br><br><br><br><br>
						<p>Administrator - IT</p>
						<p>Orient Bell Limited</p>
						</body></html>";

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
                         // $mail->addCC($m_email);

                         
                          
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
                           $msg = "An Email has been sent to your Registerd Email ID";
                          }


							$msgTxt = ' Sampling Details Has Been Updated Successfully. Waiting for Approval from Branch Head.';
							$msgType = 1;
						}else{
							$msgTxt = 'Sorry! Unable To Update Sampling Details, Please Try Later.';
							$msgType = 2;
							$fchk++;
						}
				}else{
					echo 'Something Went Wrong Please Contact to Administrator';
				}
		//updation process ends

			header('Location:sampling.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			exit;


	}
	} 
	





}


?>

<script type="text/javascript" src="spare_part.js"></script>
<script type="text/javascript" src="add_to_cart_data.js"></script>
<script type="text/javascript" src="delete_from_cart_data.js"></script>

<script type="text/javascript">
function submitform()
{
 
 
 var checkboxs=document.getElementsByName("sampling[]");
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
	  alert("Please Select At Least 1 SKU in Sample Given.");
	return false;
}
</script>

<script type="text/javascript">
        function codeAddress() {
				$("#p").hide();
				$("#q").hide();	

           if(document.getElementById("move").checked==true){
				$("#q").show();
			}else{
				$("#q").hide();	
			}


           if(document.getElementById("lost").checked==true){
				$("#p").show();
				$("#q").hide();
			}
       
			$("#move").click(function(){
				$("#q").show();
				$("#p").hide();
			});
  
			$("#lost").click(function(){
				$("#p").show();
				$("#q").hide();
			});
	   
	    }
        window.onload = codeAddress;
        </script>
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Sampling</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
<?php /*?>                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
<?php */?>                      <li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Project Action Plan</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Sampling</a></li>			
<?php /*?>
         <li class="<?php echo (isset($_GET['tab2'])?'active':'')?>"><a href="#portlet_tab2" id="tab2" data-toggle="tab">Purchase Details</a></li>
		 <li class="<?php echo (!isset($_GET['tab2'])?'active':'')?>"><a href="#portlet_tab1" data-toggle="tab">Asset Details</a></li>			
<?php */?>
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 
                                   
						<table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											<!--<th>Lead ID</th>-->
                                            <th>#</th>
                                            <th>Lead ID</th>
                                            <th>CKA Name</th>
											<!--<th >CKA Type</th>-->
											<th>Project Name</th>
											<th >Project Type</th>
											<th >State</th>
											<th>City</th>
											<!--<th >Architect Name</th>-->
                                          <!--  <th>Tile Stage Date</th>-->
											<th>Tiling Date</th>

                                            <th>OBL Forecast</th>
                                            <!--<th>Status</th>-->
											<th>Win Probability</th>
                                           
                                          
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		$sql="
			SELECT 
			d.opportunity_id,
			d.lead_id,
			a.cka_name,
			b.cka_type,
			c.project_type,
			d.[project_name],
			e.state_name,
			d.[city],
			d.[architect_name],
			d.[tile_stage_date],
			d.[obl_sale_forecast_inr],
			d.[probability_of_win],
			d.[status],
			d.sampling_status
			FROM [opportunity] d
			left join cka_name_master a on a.cka_name_id = d. cka_name_id
			left join cka_type_master b on b.cka_type_id = d.cka_type_id
			left join project_type_master c on c.project_type_id = d.project_type_id
			left join state_master e on e.state_id = d.state_id
			where d.opportunity_id = '".$_REQUEST['pid']."'
		";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										echo '<td>'.$f['lead_id'].'</td>';
										echo '<td>'.$f['cka_name'].'</td>';
										//echo '<td>'.$f['cka_type'].'</td>';										
										echo '<td>'.ucfirst($f['project_name']).'</td>';	
										echo '<td >'.$f['project_type'].'</td>';																

										echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.$f['city'].'</td>';
										//echo '<td>'.$f['architect_name'].'</td>';
										//echo '<td>'.$f['tile_stage_date'].'</td>';
											echo '<td>'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';
										
										echo '<td>'.valchar(trim($f['obl_sale_forecast_inr'])).'</td>';
										//echo '<td>'.number_format(trim($f['obl_sale_forecast_inr']),0).'</td>';
											
											echo '<td align="center">'.ucfirst($f['probability_of_win']).'</td>';
											
											//echo '<td>'.trim($f['tile_stage_date']).'</td>';
									}
									?>
									</tbody>
						</table>

					
                               	
                               
						
						<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" onsubmit="return submitform()">
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 

                        <table border="0" width="100%">
                        <tr align="left" height="40">
                     
                        	<td align="left" >
                        		<?php 
                            $qts="select * from opportunity where opportunity_id='".$_SESSION['fld_leadID']."' ";	
                                $qs=odbc_exec($conn,$qts);
                                 while($q = odbc_fetch_array($qs)){
                                 	$sp_status = $q['sampling_status'];
                                 }

                                    	if ($sp_status == '0') { ?>
                            	
                                       <label class="control-label" style="text-align:left;"><b>Status:</b></label>
                                       <div class="controls">
										<?php $open=($dataArray['status']=='open')?'checked':''; ?>
   										<?php $close=($dataArray['status']=='close')?'checked':''; ?>
    									<?php $lost=($dataArray['status']=='lost')?'checked':''; ?>

										
                                         <label class="radio">
                                          <input type="radio" name="status" value="close" <?php echo $close ?> required id="move"/>
                                          <span style="font-weight:bold; color:#0C3">Sampling Remarks</span>
                                          </label>
                                          
                                  <label class="radio">
                                   <input type="radio" name="status" value="lost" <?php echo $lost ?> required id="lost" />
                                           <span style="font-weight:bold; color:#F00">Deal Lost</span>
                                          </label>  
                                    
                                       </div>
                            </td>
                        </tr>
                        
                        <tr align="left" height="60" id="p">
                        	<td align="left" width="10%">
						&nbsp;	&nbsp;
						<br/>
                        <b>Lost By:</b>
                        <select name="lost_by"  style="width:150px;">
								<option value="">-Select-</option>
    <option value="Kajaria" <?php echo ($dataArray['lost_by']=='Kajaria')?'selected': ''?>>Kajaria</option>
    <option value="Somany" <?php echo ($dataArray['lost_by']=='Somany')?'selected': ''?>>Somany</option>
    <option value="AGL" <?php echo ($dataArray['lost_by']=='AGL')?'selected': ''?>>AGL</option>
    <option value="Jonson" <?php echo ($dataArray['lost_by']=='Jhonson')?'selected': ''?>>Jonson</option>
    <option value="Varmora" <?php echo ($dataArray['lost_by']=='Varmora')?'selected': ''?>>Varmora</option>
    <option value="Sun Heart" <?php echo ($dataArray['lost_by']=='Sun Heart')?'selected': ''?>>Sun Heart</option>
    <option value="Simpolo"  <?php echo ($dataArray['lost_by']=='Simpolo')?'selected': ''?>>Simpolo</option>
    <option value="RAK" <?php echo ($dataArray['lost_by']=='RAK')?'selected': ''?>>RAK</option>    
    <option value="Cera" <?php echo ($dataArray['lost_by']=='Cera')?'selected': ''?>>Cera</option>    
    <option value="Swastik Tiles" <?php echo ($dataArray['lost_by']=='Swastik Tiles')?'selected': ''?>>Swastik Tiles</option>    
    <option value="Vita Tiles" <?php echo ($dataArray['lost_by']=='Vita Tiles')?'selected': ''?>>Vita Tiles</option>
    <option value="Local Morbie" <?php echo ($dataArray['lost_by']=='Local Morbi')?'selected': ''?>>Local Morbi</option>
    
                            </select>
                           
						&nbsp;	&nbsp;   
                         <b>Reason for Lost:</b>
                            <select name="reason_for_lost"  style="width:150px;">
                                    <option value="">-Select-</option>
    <option value="Price" <?php echo ($dataArray['reason_for_lost']=='Price')?'selected': ''?>>Price</option>
    <option value="Payment terms" <?php echo ($dataArray['reason_for_lost']=='Payment terms')?'selected': ''?>>Payment terms</option>
    <option value="Credit Period" <?php echo ($dataArray['reason_for_lost']=='Credit Period')?'selected': ''?>>Credit Period</option>
    <option value="Design Issue" <?php echo ($dataArray['reason_for_lost']=='Design Issue')?'selected': ''?>>Design Issue</option>
    <option value="Size Unavailability" <?php echo ($dataArray['reason_for_lost']=='Size Unavailability')?'selected': ''?>>Size Unavailability</option>
    <option value="Complaint in previous supply" <?php echo ($dataArray['reason_for_lost']=='Complaint in previous supply')?'selected': ''?>>Complaint in previous supply</option>
    <option value="Architect Approval" <?php echo ($dataArray['reason_for_lost']=='Architect Approval')?'selected': ''?>>Architect Approval</option>
    <option value="SKU Approval" <?php echo ($dataArray['reason_for_lost']=='SKU Approval')?'selected': ''?>>SKU Approval</option>
    <option value="GPS Approval" <?php echo ($dataArray['reason_for_lost']=='GPS Approval')?'selected': ''?>>GPS Approval</option>
	<option value="Relation with Purchaser" <?php echo ($dataArray['reason_for_lost']=='Relation with Purchaser')?'selected': ''?>>Relation with Purchaser</option>
	<option value="Lead info. Not appropriate" <?php echo ($dataArray['reason_for_lost']=='Lead info. Not appropriate')?'selected': ''?>>Lead info. Not appropriate</option>
	<option value="Redundant/To be deleted" <?php echo ($dataArray['reason_for_lost']=='Redundant/To be deleted')?'selected': ''?>>Redundant/To be deleted</option>

	</select>
                                
							&nbsp;	&nbsp;
							<b>Lost Remarks:</b>
								<textarea style="width:400px;; height:30px;" id="remarks" name="lost_remark"></textarea>
                        <div style="color:#F00; font-size:15px; text-align:left"><b><br /><?php echo $errorArray['remarks']?></b><br /><br /></div>
                            </td>
                        </tr>


         <tr align="left" height="60" id="q">
                        	<td align="left" width="10%">
						&nbsp;	&nbsp;
                        
                           
						 <br/>
                         
                                
							
							<b>Remarks:</b>
								<textarea style="width:400px;; height:30px;" id="spl_remark" name="spl_remark"></textarea>
                        <div style="color:#F00; font-size:15px; text-align:left"><b><br /><?php echo $errorArray['spl_remark']?></b><br /><br /></div>

                        <?php         } ?> 
                            </td>
                        </tr>
                        
                        
                        </table>

                    
						
                                 
                                    

                             <table border="1" style="width:100%" align="center">

                              	<tr height="25">
			<th colspan="11" style="background-color:#FF9900; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF"> Requirements Details </th>
								</tr>

								<tr>
                                    <th>FLD ID</th>
                                    <th>SKU Size</th>
                                    <th>Tile Category</th>
                                    <th>Tile Name</th>
                                    <th>Qty</th>
                                    <th>OBL Price/Unit</th>
                                    <th>No of Sample Given</th>
                                    <th>PCH Approval</th>
                                    <th>Competitor</th>
                                    <?php
                                    $qts="select * from opportunity where opportunity_id='".$_SESSION['fld_leadID']."' ";	
                                $qs=odbc_exec($conn,$qts);
                                 while($q = odbc_fetch_array($qs)){
                                 	$sp_status = $q['sampling_status'];
                                 }

                                    	if ($sp_status == '0') { ?> 
									<th>Sample Given </th>
                                    <th>No. of SKU</th>
								<?php 	}

                                    ?>
                               </tr>

							


								<?php 
                                //echo 'hello';
                                //print_r($_GET);

                                 $ssql="select * from fld where opp_id='".$_SESSION['fld_leadID']."'";	
                                $rs=odbc_exec($conn,$ssql);
                                 $vv=odbc_num_rows($rs);
                                $_SESSION['atc']=$vv;
                                while($f = odbc_fetch_array($rs)){
                                //print_r($f);
								$av=$f['fld_id'];
                                echo '<tr align="center">';
								echo '<td>'.$f['fld_id'].'</td>';
                                echo '<td>'.$f['size'].'</td>';
								echo '<td>'.$f['sample_tile_cateroty'].'</td>';
								echo '<td>'.$f['approved_tile_name'].'</td>';
                                echo '<td>'.$f['qty'].'</td>';
                                echo '<td>'.$f['obl_bid_price'].'</td>';
                                echo '<td>'.$f['no_of_samples_given'].'</td>';
                                echo '<td>'.$f['sampling'].'</td>';
                                echo '<td>'.$f['competitor'].'</td>';
                                
																
								if(($_POST['sampling'])>0){
									$tick='';
									foreach($_POST['sampling'] as $sd)
										if($sd==$f['fld_id']){
											$tick='checked';
										}
								}
							
							//echo $sd;
								if ($sp_status == '0') {
								echo '<td><input type="checkbox" name="sampling[]" value="'.$f['fld_id'].'" id=sampling '.$tick.'></td>';
							
								if(isset($_POST['formsubmit'])){
									foreach($_POST['no_of_sku'] as $key => $nsku){
										if($key==$av){
											if(empty($_POST['no_of_sku'][$av]) && $tick=='checked'){
												$c='red';
												$skucheck++;
											}else{
												$c='';
											}
											 echo "<td><input type=number name=no_of_sku[$av] style=width:60px;border-color:$c; value=$nsku></td>";
										}
									}

								}else{
									echo "<td><input type=number name=no_of_sku[$av] style=width:60px;></td>";
								}

                              
							  
                                }

                            }
                                ?>
								
								
								
								
							</table>
									<div  style="text-align:right;">
                                   
                                    <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
									<!-- <a href="javascript: submitform()" ><input type="submit" name="submit"  value="Submit FLD"></a> -->
                                    
			                        <!-- <a class="btn blue" href="javascript: submitform()"> <i class="icon-ok"></i> Submit</a> 
									<input type="submit" name="formsubmit" value="Submit Sampling" id= "submitform" >-->
								<?php 
                            $qts="select * from opportunity where opportunity_id='".$_SESSION['fld_leadID']."' ";	
                                $qs=odbc_exec($conn,$qts);
                                 while($q = odbc_fetch_array($qs)){
                                 	$sp_status = $q['sampling_status'];

                                  if ($sp_status == 1 || $sp_status == 2) { ?>
									
									 
                                        
                                        
                 
                                       <a href="sampling.php"><input type="button" value= "Back" ></a>

                                    
                                    <?php         }else{ ?>
                                    	<input type="submit" value="Submit Sampling" name="formsubmit">
									<a href="sampling.php"><input type="button" value= "Back" ></a>

									<?php } 
								}

									?> 
								</div>
                                    
                             </form>
                             <h3>Add Sampling Details</h3>
                             
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal">
 <input type="hidden" value="<?php echo $_GET['pid']?>" name="opportunity_id"  id="opportunity_id"/>
                              

          <table border="0" style="width:100%" align="center">
          	<tr height="30">
									<th colspan="11" style="background-color:gray; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Sampling Details </th>
								</tr>

       <tr>
			<th>SKU Size</th>
			<th>Tile Category</th>  
			<th>Tile Name</th>  
			<th>Descreption</th> 
            <th>Quantity</th>
            <th>Sampling Date</th>
            <th>Remarks</th> 
            <th></th> 
        </tr>


		<tr>

		<th>
      <!-- <input type="text" style="width:90%; height: 25px; resize:none;" name="sku_size" id="sku_size"> -->
      <select name="sku_size" style="width:120px; height: 25px;"  id="sku_size">
                                       		<option value="">- Select Size -</option>
                                             <?php
								$ssql="select distinct(size_code_desc) size_id, size_code_desc from size_master order by size_code_desc ";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											/*$ss=($f['size_id']==$dataArray['spare_part_id'])?'selected':'';*/
										echo '<option value="'.$f['size_code_desc'].'" '.$ss.'>'.trim($f['size_code_desc']).' </option>';
										}
										?>
                                          </select>
	</th>              
      

			<th>
      <!-- <input type="text" style="width:90%; height: 25px; resize:none;" name="tile_category" id="tile_category"> -->
      		<select name="tile_category" id="tile_category" style="width:100px; height: 25px;" required="required"> 
			<option value="">-Select-</option>
			<option value="Ceramic">Ceramic</option>
			<option value="DC">DC</option>';
			<option value="DGVT">DGVT</option>
			<option value="LAP">LAP</option>
			<option value="Nano">Nano</option>
			<option value="Pavers">Pavers</option>
			<option value="PDC">PDC</option>
			<option value="PGVT">PGVT</option>
			<option value="PVT">PVT</option>

			</select>
	</th>         

	
	<th>
      <input type="text" style="width:90%; height: 25px; resize:none;" name="tile_name" id="tile_name">
	</th>

	<th>
      <input type="text" style="width:90%; height: 25px; resize:none;" name="desc" id="desc">
	</th>

	<th>
      <input type="number" style="width:90%; height: 25px; resize:none;" name="qty" id="qty">
	</th>   
            
 	<th>
      <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="sampling_date"  id="sampling_date" style="width:90%; height: 25px;"/>
	</th>    

 	<th>
      <input type="text" style="width:90%; height: 25px; resize:none;" name="sp_remark" id="sp_remark">
	</th>    

    <td>
   
   <input type="button" value="add"  onclick="show_data();"/>
    </td>

</tr>
</table>

<table border="0" style="width:100%" align="center">
<td colspan="4" height="20"></td>
</tr>

		<tr height="27">
			<th colspan="5"  align="center" style="background-color:gray; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">
            	Sample Tile List
            </th>
		</tr>
</table>

<table border="1" style="width:100%" align="center">

<tr>
	<td>
    	    <div id="sp_data"><?php include('sampling_details.php');?></div> 
    </td>
</tr>

</table>
</form>

                             </div><br>
                             
                        
                        
                                 <!-- tab 1, asset detail ends -->  
                              


                                
                                 <!--#################### purchase details part start tab2 ##############################-->  
                                 <!-- tab 2, purchase detail-->  
                              <div class="tab-pane " id="portlet_tab2">
                                   
                                    <?php 
										//print_r($_SESSION);
										if($vv > 0){

									?>
								
							<?php include_once("project-action-plan.php")?>


                                 <?php } else { echo '<h3 align="center"><font color="#F00A0E">Error: Please Submit First Level Discussion to Activate Project Action Plan</font></h3>'; } ?>

                              </div>
                                 <!-- tab 2 purchase details ends--> 
                           <!--#################### purchase details part ends ##############################-->   
                                 
                          <!-- tab 3, maintenance detail-->  
                              <div class="tab-pane " id="portlet_tab3">

 							 <div class="portlet-body">
								<div class="clearfix">
                                		

									
								</div>
								
							</div>

                                   
                            <!-- work area-->  
                                
                          

                           
                              </div>
                                 <!-- tab 3 maintenance ends-->  
                                 
                                  
                                 
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
   
   if(isset($skucheck) && $skucheck>0){
			$ms='Please Enter Number of SKU given for Sampling';
                echo '<script>alert(\''.$ms.'\');</script>';
            }

   if(isset($tcat) && $tcat>0){
			$ms='Please Select Tile Sample Tile Category ';
                echo '<script>alert(\''.$ms.'\');</script>';
            }






   
   ?>