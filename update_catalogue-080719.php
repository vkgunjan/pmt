
<?php 
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
$pid=$_GET['pid'];
?>

<?php 

		

		if(isset($_POST['submit'])){

		/*	$ssql = "SELECT lg_id from log_history where lg_code = '$pid'";
		$rs = odbc_exec($conn, $ssql);
		while($c = odbc_fetch_array($rs)){
				$av = $c['lg_id'];

		}*/

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
					lg_status = '2' 
					WHERE lg_code = '$pid'";
			$fdp = odbc_prepare($conn, $dp);
			$fdpp = odbc_execute($fdp);


			$ssql = "SELECT * from cat_log where u_code = '$pid'";
			$rs = odbc_exec($conn, $ssql);
			$vv = odbc_num_rows($rs);
			while($c = odbc_fetch_array($rs)){
				$av = $c['id'];

				foreach($_POST['c_id'] as $key => $sd){
					var_dump($sd);
					exit();
					
				if($key==$av){
					if(empty($_POST['c_id'][$av])){
						$c='red';
						$skucheck++;
					}else{
						$c='';
					}
			}
		}

			}
			$fchk=0;
			foreach($_POST['c_id'] as $sd){
				
				
					$_POST['qty'][$sd];	
	
				
				


				$p = "UPDATE cat_log SET
					qty = '".$_POST['qty'][$sd]."' WHERE id = '".$sd."'";
				$fp = odbc_prepare($conn, $p);
				$fpp = odbc_execute($fp);

			
				if ($fpp && $fdpp){

					//query for email
						
					// query ends
					$msgTxt = 'Details Updated Successfully';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Details, Please Try Later.';
					$msgType = 2;
					$fchk++;
				}
				header('Location:cat_history.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;
			
			}
		}		

?>

<?php 
		$sql = "SELECT 
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

				$rs=odbc_exec($conn,$sql);
				while($f = odbc_fetch_array($rs)){
					$c_name = $f['full_name'];
					$c_email = $f['email'];
					$c_contact = $f['mobile'];
					$c_address = $f['address'];
					$c_city = $f['city'];
					$c_state = $f['state'];
					$c_required_date = $f['required_date'];
					$c_order_date = $f['created_date'];
					$c_docket_date = $f['lg_docket_date'];
					$c_docket_no = $f['lg_docket_no'];
					$c_dispatch_qty = $f['lg_dispatch_quantity'];
					$c_dispatch_remark = $f['lg_dispatch_remark'];
				}
?>
<?php 

		$pid=$_GET['pid'];

		$sql = "SELECT
				l.id, 
				m.cat_name, 
				m.cat_desc, 
				l.qty, 
				h.lg_required_date, 
				h.lg_created_date

				from cat_log l
				inner join cat_master m on m.cat_id = l.cat_id
				inner join log_history h on h.lg_code = l.u_code

				WHERE l.u_code = '$pid'
				";

?>


<div class="row-fluid" id="printableArea">
					<div class="row-fluid invoice">
					<div class="row-fluid invoice-logo">
						<div class="span6"><img src="assets/img/logo-header.png" alt="" /> </div>
						<div class="span6">
							<p style="font-size: 16px;"> <?php echo date('d M, Y h:m',strtotime(trim($c_order_date)))?> </p>
						</div>
					</div>
					<p style="text-align: center; font-size: 20px; font-weight: bold;">UPDATE ORDER DETAILS</p>
					<hr />

					<div class="row-fluid">
						<div class="span6">
							<h5>Order Details: <b>#<?php echo $pid; ?></b></h5>
							<ul class="unstyled">
								<li><strong><?php echo $c_name; ?></strong></li>
								<li><?php echo $c_email; ?></li>
								<li>M: +91 <?php echo $c_contact; ?></li>
								<li><?php echo $c_address; ?></li>
								<li><?php echo $c_city; ?>, <?php echo strtoupper($c_state); ?></li>
								<!-- <li><?php echo $c_state; ?></li> -->
							</ul>
						</div>
						
					</div>
					
			<form action="update_catalogue.php?pid=<?php echo $pid;?>" method="post" class="form-horizontal">
                       <!-- <input type="hidden" name="id[]" value="<?php echo $c['id']; ?>">  --> 
                       <input type="hidden" name="pid" value="<?php echo $pid?>">           
					<div class="row-fluid">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th></th>
									<th>#</th>
									<th>Item</th>
									<th class="hidden-480">Description</th>
									<th class="hidden-480">Quantity</th>
									<th class="hidden-480">Required Date</th>
									<th>Order Date</th>
								</tr>
							</thead>
							<tbody>

								<?php 

									$rs=odbc_exec($conn,$sql);
								    $count=1;
								    while($f = odbc_fetch_array($rs)){
								    $quantity = $f['qty'];
								    $av = $f['id'];
									echo '<tr>';
													echo "<td><input type=hidden name=c_id[] value=$av></td>";
								                    echo '<td>'.$count.'</td>';
								                    echo '<td>'.$f['cat_name'].'</td>';
								                    echo '<td>'.$f['cat_desc'].'</td>';
								    if(isset($_POST['submit'])){
													foreach($_POST['qty'] as $key => $quantity){
													if($key==$av){
													if(empty($_POST['qty'][$av])){
												$c='red';
												$skucheck++;
											}else{
												$c='';
											}
													/*$skucheck++;*/
											 		echo "<td><input type=number name=qty[$av] id='qty'  style=width:70px; value=$quantity></td>";
										}
									}

								}else{
									echo "<td><input type=number id='qty' name=qty[$av] value=$quantity style=width:70px;></td>";
								}
								    				/*echo "<td><input type=number name=qty[] id='qty' value=$quantity></td>";*/
								                    echo '<td>'.date('Y-m-d',strtotime(trim($f['lg_required_date']))).'</td>';
								                    echo '<td>'.date('Y-m-d',strtotime(trim($f['lg_created_date']))).'</td>';
								                    echo '</tr>';

								                    $count++;

								                }
									?>
								
							</tbody>
						</table>
					</div>
					<div class="row-fluid">
						<br/><br/>
					</div>
				
				</div>
				</div>
				
					<div class="row-fluid">
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label">Docket No:</label>
                                             <div class="controls">
                                                <input type="text" name="docket_no" value="<?php echo $c_docket_no; ?>" class="m-wrap span10"> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Date:</label>
                                             <div class="controls">
                                       <div class="input-append date date-picker" data-date="2012-02-12" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                          <input class="m-wrap m-ctrl-medium date-picker" value="<?php echo $c_docket_date; ?>" size="16" type="text" name="docket_date" id="docket_date"><span class="add-on"><i class="icon-calendar" ></i></span>
                                    </div>
                                    </div>
                                          </div>
                                       </div>
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label">No of Box(s):</label>
                                             <div class="controls">
                                                <input type="number" name="dispatch_qty" value="<?php echo $c_dispatch_qty; ?>" class="m-wrap span10"> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span5 ">
                                          <div class="control-group">
                                             <label class="control-label">Remarks:</label>
                                             <div class="controls">
                                                <textarea class="span12 m-wrap" name="dispatch_remark" value="" rows="1"><?php echo $c_dispatch_remark; ?></textarea>
                                             </div>
                                          </div>
                                       </div>
                    </div>
				
				<div class="row-fluid">
					<div class="span9">
						<!-- <div class="control-group">
						                              <label class="control-label">Remarks:</label>
						                              <div class="controls">
						                                 <textarea class="span10 m-wrap" rows="3"></textarea>
						                              </div>
						                           </div> -->
						
					</div>
					<div class="span3 invoice-block">
						<button type="submit" id="btn" name="submit" class="btn blue"><i class="icon-ok"></i> Submit</button>
							<button type="submit" id="btn" name="update" class="btn green"><i class="icon-save"></i> Update</button>
							<a class="btn red" href="cat_history.php">Cancel  <i class="icon-remove icon-white"></i></a>
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

