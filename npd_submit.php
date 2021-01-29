
<?php 
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
$pid=$_GET['pid'];
?>

<?php 

		if(isset($_POST['update'])){

			$pid = $_GET['pid'];
			$n_docket_no          	= $_POST['n_docket_no'];
			$n_docket_date          = $_POST['n_docket_date'];
			$n_boxes          		= $_POST['n_boxes'];
			$n_npd_status        	= $_POST['n_npd_status'];
			$n_dispatch_remark      = $_POST['n_dispatch_remark'];

			$dp = "UPDATE opportunity SET
					npd_docket_no = '$n_docket_no', 
					npd_docket_date = '$n_docket_date', 
					npd_boxes = '$n_boxes', 
					npd_dispatch_remark = '$n_dispatch_remark',
					npd_status = '$n_npd_status',
					npd_updated_by = '$uid',
					npd_updated_on = getdate()
					 
					WHERE opportunity_id = '$pid'";
			$fdp = odbc_prepare($conn, $dp);
			$fdpp = odbc_execute($fdp);

			$av = array();
			$ssql = "SELECT * from npd_tile where opp_id = '$pid'";
			$rs = odbc_exec($conn, $ssql);
			$vv = odbc_num_rows($rs);
			while($c = odbc_fetch_array($rs)){
				//$av = $c['id'];
				array_push($av, $c['npd_id']);
			}

/*			print_r($av);*/
			$fchk=0;
			//print_r($_POST['qty']);
			//exit();
			foreach($_POST['n_id'] as $key){
				
					/*$_POST['qty'][$key];*/	
					//var_dump($_POST['qty'][$key]);

				$p = "UPDATE npd_tile SET
					po_status = '".$_POST['n_po_status'][$key]."',
					tile_matching_status = '".$_POST['n_tile_matching_status'][$key]."',
					receive_date = '".$_POST['n_receive_date'][$key]."',
					actual_delivery_date = '".$_POST['n_actual_delivery_date'][$key]."',
					expected_delivery_date = '".$_POST['n_expected_delivery_date'][$key]."',
					updated_by = '".$_SESSION['uid']."',
					updated_on = getdate()
					WHERE npd_id = '".$key."'";
				$fp = odbc_prepare($conn, $p);
				$fpp = odbc_execute($fp);
				$fchk++;
			}
				if ($fpp && $fdpp){

					//query for email
				$pid=$_GET['pid'];
				$sql_user = "SELECT 
					d.opportunity_id,
					d.lead_id,
					a.cka_name,
					c.project_type,
					d.[project_name],
					e.state_name,
					d.[city],
					d.[tile_stage_date],
					d.[obl_sale_forecast_inr],
					d.npd_status,
					d.npd_docket_no,
					d.npd_docket_date,
					d.npd_boxes,
					d.npd_create_date,
					d.npd_dispatch_remark,
					u.fullname as [npd_created_by],
					u.email as [npd_created_by_email],
					um.fullname as [bm_name],
					um.email as [bm_email],
					umm.email as [npd_updated_by]
					FROM [opportunity] d
					left  join user_management u on u.uid = d.npd_created_by
					left join user_management umm on umm.uid = d.npd_updated_by
					left join user_management um on um.uid = (select parent_id from user_management where uid = d.npd_created_by)
					left join cka_name_master a on a.cka_name_id = d. cka_name_id
					left join cka_type_master b on b.cka_type_id = d.cka_type_id
					left join project_type_master c on c.project_type_id = d.project_type_id
					left join state_master e on e.state_id = d.state_id
					where d.opportunity_id = '$pid'";

				$rs=odbc_exec($conn,$sql_user);
				while($f = odbc_fetch_array($rs)){
					$npd_lead_id = $f['lead_id'];
					$npd_cka_name = $f['cka_name'];
					$npd_project_type = $f['project_type'];
					$npd_project_name = $f['project_name'];
					$npd_city = $f['city'];
					$npd_state = strtoupper($f['state_name']);
					$npd_tiling_date = $f['tile_stage_date'];
					$npd_obl_sales_forecast_inr = $f['obl_sale_forecast_inr'];
					$npd_status = $f['npd_status'];
					$npd_create_date = $f['npd_create_date'];
					$npd_docket_date = $f['npd_docket_date'];
					$npd_docket_no = strtoupper($f['npd_docket_no']);
					$npd_boxes = $f['npd_boxes'];
					$npd_dispatch_remark = $f['npd_dispatch_remark'];
					$npd_created_by = strtoupper($f['npd_created_by']);
					$npd_created_by_email = $f['npd_created_by_email'];
					$npd_bm_name = $f['bm_name'];
					$npd_bm_email = $f['bm_email'];
					$npd_updated_by_email = $f['npd_updated_by'];
				}

				if($npd_docket_date == '1900-01-01'){
           			$npd_docket_date1 = '';
           		}else{
           			$npd_docket_date1 = $npd_docket_date;
           		}

				//Email Configuration Start
            //$m_email = "vikash.gunjan@orientbell.com";
            $subject = "PMT || NPD ORDER DETAILS - [$npd_lead_id] - $npd_created_by";
                        $to = $npd_created_by_email;
                        $body = '<html>
                             <head>
                             <title></title>
                              <style>
                               table{
                               border-collapse: collapse;
                               width: 100%;
                                 }

                              th, td {
                                border: 0.5px solid #1B5E20;
                                  text-align: center;
                                  padding: 4px;
                                  color:black
                                  font-size:10px;
                                  font-family: Arial, sans-serif;
                                  font-weight:normal;
                                  font-style:normal;
                              }

                              h3,p,div {
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
                  <h3>Dear $npd_created_by,</h3>

                  <p>This is an auto generated Email, Please do not reply. There is an update on NPD Order Details. Kindly refer to below details for more clarification.
                  </p>
					<div>
				     <table>
                           <thead>
                              <tr>
                                     <th>Lead ID</th>
                                     <th>Accunt Name</th>
                                     <th>Project Name</th>
                                     <th>Project Type</th>
                                     <th>State</th>
                                     <th>City</th>
                                     <th>Tiling Date</th>
                                     <th>OBL Forecast</th>
                                     <th>NPD Created By</th>
                                     <th>NPD Created On</th>
                                     <th>NPD Status</th>
                              </tr>
                           </thead>
                           <tbody>
                           <tr>
			                          <td>{$npd_lead_id}</td>
			                          <td>{$npd_cka_name}</td>
			                          <td>{$npd_project_name}</td>
			                          <td>{$npd_project_type}</td>
			                          <td>{$npd_state}</td>
			                          <td>{$npd_city}</td>
			                          <td>{$npd_tiling_date}</td>
			                          <td>{$npd_obl_sales_forecast_inr}</td>
			                          <td>{$npd_created_by}</td>
			                          <td>".date('Y-m-d',strtotime(trim($npd_create_date)))."</td>
			                          <td>{$npd_status}</td>
	                           </tr>
                           </tbody>
                           </table>
				  	</div>
				  	<br><br>
                  ";

                  $body .= '<table>
                           <thead>
                              <tr>
                                     <th>#</th>
                                     <th>Plant</th>
                                     <th>SKU Size</th>
                                     <th>Category</th>
                                     <th>Punch Type</th>
                                     <th>NPD Tile</th>
                                     <th>Reference Tile</th>
                                     <th>Qty(SQMT)</th>
                                     <th>Thickness</th>
                                     <th>Price/SQMT</th>
                                     <th>Expected Date</th>
                                     <th>PO Status</th>
                                     <th>Expected Delivery</th>
                                     <th>Receive Date</th>
                                     <th>Actual Delivery</th>
                                     <th>Matching Status</th>
                              </tr>
                           </thead>
                           <tbody>
	                           
                           ';


                  $cat_query = "SELECT
								npd_id, 
								opp_id, 
								plant_name,
								sku_size,
								tile_category,
								punch_type,
								npd_tile_name,
								ref_tile_name,
								tile_qty,
								tile_thickness,
								expected_price,
								expected_date,
								expected_delivery_date,
								tile_matching_status,
								po_status,
								receive_date,
								actual_delivery_date,
								created_on 
								from npd_tile
								where opp_id = '$pid'";

								$rss=odbc_exec($conn,$cat_query);
								$count=1;
								while($q = odbc_fetch_array($rss)){
									
									
                                 
                        $body .= " <tr>
                                          <td>{$count}</td>
                                          <td>{$q['plant_name']}</td>
                                          <td>{$q['sku_size']}</td>
                                          <td>{$q['tile_category']}</td>
                                          <td>{$q['punch_type']}</td>
                                          <td>{$q['npd_tile_name']}</td>
                                          <td>{$q['ref_tile_name']}</td>
                                          <td>{$q['tile_qty']}</td>
                                          <td>".round($q['tile_thickness'],2)."</td>
                                          <td>".round($q['expected_price'],2)."</td>
                                          <td>".date('Y-m-d',strtotime(trim($q['expected_date'])))."</td>
                                          <td>{$q['po_status']}</td>
                                          <td>".date('Y-m-d',strtotime(trim($q['expected_delivery_date'])))."</td>
                                          <td>".date('Y-m-d',strtotime(trim($q['receive_date'])))."</td>
                                          <td>".date('Y-m-d',strtotime(trim($q['actual_delivery_date'])))."</td>
                                          <td>{$q['tile_matching_status']}</td>";
                                          

                      
                  $body .= "</tr>";
                  				$count++;
                         }

                  $body .= " </tbody>
                  </table>
					<br><br>
                  
	                  <div>
					     Docket No: <b>$npd_docket_no</b><br>
					     Docket Date: <b>".date('Y-m-d',strtotime(trim($npd_docket_date1)))."</b><br>
					     No of Box(s): <b>$npd_boxes</b><br>
					  </div>
					
                  <p><b>Dispatch Remarks:</b>&nbsp; $npd_dispatch_remark</p>
                  
                  <br><br><br>
                  <div>
                  Regards,<br>
                  Administrator - IT <br>
                  Orient Bell Limited
                  </div>
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
                          

                          
                          
                          $mail->setFrom('donotreply@orientbell.com', 'Orient Bell Limited');
                         $mail->addCC($to);

                         
                          
                          //$mail->addAddress($to);
                          $mail->addAddress('vikash.gunjan@orientbell.com');
                          $mail->addAddress('vkgunjan@gmail.com');
                          
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
					// query ends
					$msgTxt = 'Details Updated Successfully';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Details, Please Try Later.';
					$msgType = 2;
					$fchk++;
				}
				header('Location:list_npd_sample.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				
			
			/*}*/
		}		

?>

<?php 

		if(isset($_POST['submit'])){

			$pid = $_GET['pid'];
			$docket_no          	= $_POST['docket_no'];
			$docket_date          	= $_POST['docket_date'];
			$dispatch_qty          	= $_POST['dispatch_qty'];
			$dispatch_remark        = $_POST['dispatch_remark'];

			$dp = "UPDATE log_history SET
					lg_docket_no = '$docket_no', 
					lg_docket_date = '$docket_date', 
					lg_dispatch_quantity = '$dispatch_qty', 
					lg_dispatch_remark = '$dispatch_remark',
					lg_status = '3' 
					WHERE lg_code = '$pid'";
			$fdp = odbc_prepare($conn, $dp);
			$fdpp = odbc_execute($fdp);

			$av = array();
			$ssql = "SELECT * from cat_log where u_code = '$pid'";
			$rs = odbc_exec($conn, $ssql);
			$vv = odbc_num_rows($rs);
			while($c = odbc_fetch_array($rs)){
				//$av = $c['id'];
				array_push($av, $c['id']);
			}

/*			print_r($av);*/
			$fchk=0;
			//print_r($_POST['qty']);
			//exit();
			foreach($_POST['c_id'] as $key){
				
					$_POST['qty'][$key];	
					//var_dump($_POST['qty'][$key]);

				$p = "UPDATE cat_log SET
					qty = '".$_POST['qty'][$key]."' WHERE id = '".$key."'";
				$fp = odbc_prepare($conn, $p);
				$fpp = odbc_execute($fp);
				$fchk++;
			}
				if ($fpp && $fdpp){

					//query for email
				$pid=$_GET['pid'];
				$sql_user = "SELECT 
				h.lg_id as [log_id],
				h.lg_code as [lg_code],
				h.lg_emp_code as [emp_code], 
				h.lg_full_name as [full_name], 
				h.lg_emp_email as [email], 
				h.lg_mobile as [mobile], 
				m.state as [state], 
				m.territory as [territory],
				m.city as [city], 
				h.lg_other_mobile as [landline],  
				h.lg_required_date as [required_date],
				h.lg_created_date as [created_date],
				h.lg_address as [address],
				h.lg_created_date,
				h.lg_docket_no,
				h.lg_docket_date,
				h.lg_dispatch_quantity,
				h.lg_dispatch_remark,
				(SELECT TOP 1 dbo.getCatNames(h.lg_catalogue_id, ',')) as [cat_name] 
				

				FROM log_history h
				left join city_master m on m.id = h.lg_city 
				where h.lg_code = '$pid'";

				$rs=odbc_exec($conn,$sql_user);
				while($f = odbc_fetch_array($rs)){
					$c_name = $f['full_name'];
					$c_email = $f['email'];
					$c_contact = $f['mobile'];
					$c_address = $f['address'];
					$c_city = $f['city'];
					$c_state = strtoupper($f['state']);
					$c_required_date = $f['required_date'];
					$c_order_date = $f['created_date'];
					$c_docket_date = $f['lg_docket_date'];
					$c_docket_no = strtoupper($f['lg_docket_no']);
					$c_dispatch_qty = $f['lg_dispatch_quantity'];
					$c_dispatch_remark = $f['lg_dispatch_remark'];
				}

				if($c_docket_date == '1900-01-01'){
           			$c_docket_date1 = '';
           		}else{
           			$c_docket_date1 = $c_docket_date;
           		}

				//Email Configuration Start
            //$m_email = "vikash.gunjan@orientbell.com";
            $subject = "MKTG || $c_name";
                        $to = $c_email;
                        $body = '<html>
                             <head>
                             <title></title>
                              <style>
                               table{
                               border-collapse: collapse;
                               width: 100%;
                                 }

                              th, td {
                                border: 0.5px solid #1B5E20;
                                  text-align: center;
                                  padding: 4px;
                                  color:black
                                  font-size:10px;
                                  font-family: Arial, sans-serif;
                                  font-weight:normal;
                                  font-style:normal;
                              }

                              h3,p,div {
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
                  <h3>Dear Administrator,</h3>

                  <p>This is an auto generated Email, Please do not reply. Catalogue order requested by <b>$c_name</b> has been dispatched. Kindly refer to below details for more clarification.
                  </p>
					<div>
				     <b>$c_name</b><br>
				     M: +91-$c_contact<br>
				     $c_address<br>
				     $c_city, $c_state
				  	</div>
				  	<br><br>
                  ";

                  $body .= '<table>
                           <thead>
                              <tr>
                                     <th>#</th>
                                     <th>Item</th>
                                     <th>Description</th>
                                     <th>Quantity</th>
                                     
                                     <th>Order Date</th>
                              </tr>
                           </thead>
                           <tbody>';


                  $cat_query = "SELECT 
								m.cat_name, 
								m.cat_desc, 
								l.qty, 
								h.lg_required_date, 
								h.lg_created_date

								from cat_log l
								inner join cat_master m on m.cat_id = l.cat_id
								inner join log_history h on h.lg_code = l.u_code

								WHERE l.u_code = '$pid'";

								$rss=odbc_exec($conn,$cat_query);
								$count=1;
								while($q = odbc_fetch_array($rss)){
									$cat_name = $q['cat_name'];
									$cat_desc = $q['cat_desc'];
									$cat_qty = $q['qty'];
									$cat_req_date = date('Y-m-d',strtotime(trim($q['lg_required_date'])));
									$cat_order_date = date('Y-m-d',strtotime(trim($q['lg_created_date'])));
									
                                 
                        $body .= " <tr>
                                          
                                          <td>{$count}</td>
                                          <td>{$cat_name}</td>
                                          <td>{$cat_desc}</td>
                                          <td>{$cat_qty}</td>
                                          
                                          <td>{$cat_order_date}</td>";
                                          

                      
                  $body .= "</tr>";
                  				$count++;
                         }

                  $body .= " </tbody>
                  </table>
					<br><br>
                  
	                  <div>
					     Docket No: <b>$c_docket_no</b><br>
					     Docket Date: <b>$c_docket_date1</b><br>
					     No of Box(s): <b>$c_dispatch_qty</b><br>
					  </div>
					
                  <p><b>Dispatch Remarks:</b>&nbsp; $c_dispatch_remark</p>
                  
                  <br><br><br>
                  <div>
                  Regards,<br>
                  Administrator - IT <br>
                  Orient Bell Limited
                  </div>
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
                          

                          
                          
                          $mail->setFrom('donotreply@orientbell.com', 'Orient Bell Limited');
                          $mail->addCC($to);

                         
                          
                          $mail->addAddress('mithun.rakshit@orientbell.com');
                          $mail->addAddress('mohd.irfan@orientbell.com');
                          
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
					// query ends
					$msgTxt = 'Details Updated Successfully';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Details, Please Try Later.';
					$msgType = 2;
					$fchk++;
				}
				header('Location:cat_history.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				
			
			/*}*/
		}		

?>

<?php 
		$sql_list = "SELECT
						npd_id, 
						opp_id, 
						plant_name,
						sku_size,
						tile_category,
						punch_type,
						npd_tile_name,
						ref_tile_name,
						tile_qty,
						tile_thickness,
						expected_price,
						expected_date,
						expected_delivery_date,
						tile_matching_status,
						po_status,
						receive_date,
						actual_delivery_date,
						created_on 
						from npd_tile
				where opp_id = '$pid'";
				
?>



<div class="row-fluid" id="printableArea">
					<div class="row-fluid invoice">
					<table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											
                                            <th>#</th>
                                            <th>Lead ID</th>
                                            <th>CKA Name</th>
											<th>Project Name</th>
											<th>Project Type</th>
											<th>State</th>
											<th>City</th>
											<th>Tiling Date</th>
                                            <th>OBL Forecast</th>
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
			d.npd_status,
			d.npd_docket_no,
			d.npd_docket_date,
			d.npd_boxes,
			d.npd_dispatch_remark
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
										//print_r($f);
										$npd_status = $f['npd_status'];
										$l_docket_no = $f['npd_docket_no'];
										$l_docket_date = $f['npd_docket_date'];
										$l_boxes = $f['npd_boxes'];
										$l_dispatch_remark = $f['npd_dispatch_remark'];
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										echo '<td>'.$f['lead_id'].'</td>';
										echo '<td>'.$f['cka_name'].'</td>';
										echo '<td>'.ucfirst($f['project_name']).'</td>';	
										echo '<td >'.$f['project_type'].'</td>';																
										echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.$f['city'].'</td>';
										echo '<td>'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';
										echo '<td>'.valchar(trim($f['obl_sale_forecast_inr'])).'</td>';
										echo '<td align="center">'.ucfirst($f['probability_of_win']).'</td>';
									}
									?>
									</tbody>
						</table>
						<br>
					<p style="text-align: center; font-size: 20px; font-weight: bold;">UPDATE NPD ORDER DETAILS</p>
					

			<form action="npd_submit.php?pid=<?php echo $pid;?>" method="post" class="form-horizontal">
                       
                       <input type="hidden" name="pid" value="<?php echo $pid?>">           
					<div class="row-fluid">
						<div class="scrollable">
						<table class="table table-striped table-bordered table-hover">
							<thead style="white-space: nowrap; padding: 0px;">
								<tr>
									<th></th>
									<th>#</th>
									<th>Plant</th>
									<th>SKU Size</th>
									<th>Category</th>
									<th>Punch Type</th>
									<th>NPD Tile</th>
									<th>Ref Tile</th>
									<th>Qty(SQMT)</th>
									<th>Thickness</th>
									<th>Price/SQMT</th>
									<th>Expected Date</th>
									<th>PO Status</th>
									<th>Expected Delivery</th>
									<th>Receive Date</th>
									<th>Actual Delivery</th>
									<th>Matching Status</th>
								</tr>
							</thead>
							<tbody style="white-space: nowrap;">

								<?php 

									$rs=odbc_exec($conn,$sql_list);
								    $count=1;
								    while($f = odbc_fetch_array($rs)){
								    
								    $av = $f['npd_id'];
									$l_opp_id = $f['opp_id'];
									$l_plant_name = $f['plant_name'];
									$l_sku_size = $f['sku_size'];
									$l_tile_category = $f['tile_category'];
									$l_punch_type = $f['punch_type'];
									$l_npd_tile_name = $f['npd_tile_name'];
									$l_ref_tile_name = $f['ref_tile_name'];
									$l_tile_qty = $f['tile_qty'];
									$l_tile_thickness = round($f['tile_thickness'],2);
									$l_expected_price = round($f['expected_price'],2);
									$l_expected_date = $f['expected_date'];
									$l_expected_delivery_date = $f['expected_delivery_date'];
									$l_tile_matching_status = $f['tile_matching_status'];
									$l_po_status = $f['po_status'];
									$l_receive_date = $f['receive_date'];
									$l_actual_delivery_date = $f['actual_delivery_date'];
									$l_created_on = $f['created_on'];
									echo '<tr>';
													echo "<td><input type=hidden name=n_id[] value=$av></td>";
								                    echo '<td>'.$count.'</td>';
								                    echo '<td>'.$l_plant_name.'</td>';
								                    echo '<td>'.$l_sku_size.'</td>';
								                    echo '<td>'.$l_tile_category.'</td>';
								                    echo '<td>'.$l_punch_type.'</td>';
								                    echo '<td>'.$l_npd_tile_name.'</td>';
								                    echo '<td>'.$l_ref_tile_name.'</td>';
								                    echo '<td>'.$l_tile_qty.'</td>';
								                    echo '<td>'.$l_tile_thickness.'</td>';
								                    echo '<td>'.$l_expected_price.'</td>';
								                    echo '<td>'.$l_expected_date.'</td>';

								                    echo '<td>';
								                    ?>
								                    <select style='width:110px;height:25px'  name="n_po_status[<?php echo $av; ?>]" >
						                          	<option value="Created" <?php echo ($l_po_status)=='Created' ? 'selected' : '' ?>>Created</option>
						                          	<option value="Pending" <?php echo ($l_po_status)=='Pending' ? 'selected' : '' ?>>Pending</option>
						                          	<option value="Dispatched" <?php echo ($l_po_status)=='Dispatched' ? 'selected' : '' ?>>Dispatched</option>
			                                        </select>
			                                        <?php
								                    echo '</td>';



								                    /*echo '<td>'.$l_po_status.'</td>';*/
								                    echo '<td><input class=" date-picker" style="width:110px;height:15px" type="text"  name=n_expected_delivery_date['.$av.'] value="'.$l_expected_delivery_date.'" /></td>';
								                    /*echo '<td>'.$l_tile_matching_status.'</td>';*/
								                    
								                    echo '<td><input class=" date-picker" style="width:110px;height:15px" type="text"  name=n_receive_date['.$av.'] value="'.$l_receive_date.'" /></td>';
								                   echo '<td><input class=" date-picker" style="width:110px;height:15px" type="text"  name=n_actual_delivery_date['.$av.'] value="'.$l_actual_delivery_date.'" /></td>';
								                   echo '<td><input type=number style="width:110px;height:15px" name=n_tile_matching_status['.$av.'] value="'.$l_tile_matching_status.'" style=width:70px;></td>';
								    
													/*echo "<td><input type=number id='qty' name=qty[$av] value=$quantity style=width:70px;></td>";
								
								                    echo '<td>'.date('Y-m-d',strtotime(trim($f['lg_created_date']))).'</td>';*/
								                    echo '</tr>';

								                    $count++;

								                }
									?>
								
							</tbody>
						</table>
					</div>
					</div>
					<!-- <div class="row-fluid">
						<br/><br/>
					</div> -->
				
				</div>
				</div>
				
					<div class="row-fluid">
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label">Docket No:</label>
                                             <div class="controls">
                                                <input type="text" name="n_docket_no" value="<?php echo $l_docket_no; ?>" class="m-wrap span10"> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Date:</label>
                                             <div class="controls">
                                       <div class="input-append date date-picker" data-date="2012-02-12" data-date-format="yyyy-mm-dd" data-date-viewmode="years">

                                        	<?php 
                                       		if($l_docket_date == '1900-01-01'){
                                       			$l_docket_date1 = '';
                                       		}else{
                                       			$l_docket_date1 = $l_docket_date;
                                       		}
                                       	?> 
                                          <input class="m-wrap m-ctrl-medium date-picker" value="<?php echo date('Y-m-d',strtotime(trim($l_docket_date1)));; ?>" size="16" type="text" name="n_docket_date" id="docket_date"><span class="add-on"><i class="icon-calendar" ></i></span>
                                    </div>
                                    </div>
                                          </div>
                                       </div>
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label">No of Box(s):</label>
                                             <div class="controls">
                                                <input type="number" name="n_boxes" value="<?php echo $l_boxes; ?>" class="m-wrap span10"> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label">Status:</label>
                                             <div class="controls">
                                                <select class="m-wrap"  name='n_npd_status' >
					                          	<option value="Open" <?php echo ($npd_status)=='Open' ? 'selected' : '' ?>>Open</option>
					                          	<option value="In Process" <?php echo ($npd_status)=='In Process' ? 'selected' : '' ?>>In Process</option>
					                          	<option value="Closed" <?php echo ($npd_status)=='Closed' ? 'selected' : '' ?>>Closed</option>
		                                        </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Remarks:</label>
                                             <div class="controls">
                                                <textarea class="span12 m-wrap" name="n_dispatch_remark" value="" rows="1"><?php echo $l_dispatch_remark; ?></textarea>
                                             </div>
                                          </div>
                                       </div>
                    </div>
				
				<div class="row-fluid">
					<div class="span10">
						<!-- <div class="control-group">
						                              <label class="control-label">Remarks:</label>
						                              <div class="controls">
						                                 <textarea class="span10 m-wrap" rows="3"></textarea>
						                              </div>
						                           </div> -->
						
					</div>
					<div class="span2 invoice-block">
						<?php if ($npd_status == 'Open'){
							echo '<button type="submit" id="btn" name="update" class="btn green"><i class="icon-save"></i> Update</button>&nbsp;&nbsp;';
							echo '<a class="btn red" href="list_npd_sample.php">Cancel  <i class="icon-remove icon-white"></i></a>';
						}else if($npd_status == 'In Process'){
							echo '<button type="submit" id="btn" name="submit" class="btn blue"><i class="icon-ok"></i> Dispatch</button>&nbsp;&nbsp;';
							/*echo '<button type="submit" id="btn" name="update" class="btn green"><i class="icon-save"></i> Update</button>&nbsp;&nbsp;';*/
							echo '<a class="btn red" href="list_npd_sample.php">Cancel  <i class="icon-remove icon-white"></i></a>';
						} else{

							echo '<a class="btn red" href="list_npd_sample.php"><i class="icon-circle-arrow-left icon-white"></i> Back</a>';
						}


						?>
							
						<!-- 
						<button type="submit" id="btn" name="submit" class="btn blue"><i class="icon-ok"></i> Submit</button>
							<button type="submit" id="btn" name="update" class="btn green"><i class="icon-save"></i> Update</button>
							<a class="btn red" href="cat_history.php">Cancel  <i class="icon-remove icon-white"></i></a> -->
					</div>
				</div>
			</form>
				<br/><br/><br/><br/>
	</div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>


	<?php include_once('including/footer.php')?>
	<?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
      $ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>

