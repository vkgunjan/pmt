
<?php 
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
$pid=$_GET['pid'];
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
				h.lg_dispatch_remark,
				h.lg_dispatch_quantity,
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

				if($c_docket_date == '1900-01-01'){
           			$c_docket_date1 = '';
           		}else{
           			$c_docket_date1 = $c_docket_date;
           		}
?>
<?php 

		$pid=$_GET['pid'];

		$sql = "SELECT 
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
					<p style="text-align: center; font-size: 20px; font-weight: bold;">CATALOGUE ORDER DETAILS</p>
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
						<!-- <div class="span4">
							<h4>About:</h4>
							<ul class="unstyled">
								<li>Drem psum dolor sit amet</li>
								<li>Laoreet dolore magna</li>
								<li>Consectetuer adipiscing elit</li>
								<li>Magna aliquam tincidunt erat volutpat</li>
								<li>Olor sit amet adipiscing eli</li>
								<li>Laoreet dolore magna</li>
							</ul>
						</div>
						<div class="span4 invoice-payment">
							<h4>Payment Details:</h4>
							<ul class="unstyled">
								<li><strong>V.A.T Reg #:</strong> 542554(DEMO)78</li>
								<li><strong>Account Name:</strong> FoodMaster Ltd</li>
								<li><strong>SWIFT code:</strong> 45454DEMO545DEMO</li>
								<li><strong>V.A.T Reg #:</strong> 542554(DEMO)78</li>
								<li><strong>Account Name:</strong> FoodMaster Ltd</li>
								<li><strong>SWIFT code:</strong> 45454DEMO545DEMO</li>
							</ul>
						</div> -->
					</div>
					<div class="row-fluid">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
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
									echo '<tr>';
								                    echo '<td>'.$count.'</td>';
								                    echo '<td>'.$f['cat_name'].'</td>';
								                    echo '<td>'.$f['cat_desc'].'</td>';
								                    if($quantity == 0){
								                    echo '<td></td>';
								                    }else{
								                    echo '<td>'.$f['qty'].'</td>';	
								                    }
								                    
								                    echo '<td>'.date('Y-m-d',strtotime(trim($f['lg_required_date']))).'</td>';
								                    echo '<td>'.date('Y-m-d',strtotime(trim($f['lg_created_date']))).'</td>';
								                    echo '</tr>';

								                    $count++;

								                }
									?>
								<!-- <tr>
									<td>1</td>
									<td>Hardware</td>
									<td class="hidden-480">Server hardware purchase</td>
									<td class="hidden-480">32</td>
									<td class="hidden-480">$75</td>
									<td>$2152</td>
								</tr>
								<tr>
									<td>2</td>
									<td>Furniture</td>
									<td class="hidden-480">Office furniture purchase</td>
									<td class="hidden-480">15</td>
									<td class="hidden-480">$169</td>
									<td>$4169</td>
								</tr>
								<tr>
									<td>3</td>
									<td>Foods</td>
									<td class="hidden-480">Company Anual Dinner Catering</td>
									<td class="hidden-480">69</td>
									<td class="hidden-480">$49</td>
									<td>$1260</td>
								</tr>
								<tr>
									<td>3</td>
									<td>Software</td>
									<td class="hidden-480">Payment for Jan 2013</td>
									<td class="hidden-480">149</td>
									<td class="hidden-480">$12</td>
									<td>$866</td>
								</tr> -->
							</tbody>
						</table>
					</div>
					<div class="row-fluid">
						<br/><br/>
					</div>
					<div class="row-fluid">
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label" for="docketNo">Docket No:</label>
                                             <div class="controls">
                                                <span class="text"><b><?php echo strtoupper($c_docket_no); ?></b></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label" for="docketDate">Docket Date:</label>
                                             <div class="controls">
                                                <span class="text"><b><?php echo $c_docket_date1; ?></b></span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dispatchQuantity">No of Box(s):</label>
                                             <div class="controls">
                                                <span class="text"><b><?php echo $c_dispatch_qty; ?></b></span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dispatchQuantity">Dispatch Remark:</label>
                                             <div class="controls">
                                                <span class="text"><b><?php echo $c_dispatch_remark; ?></b></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    
                                    <br>
					<div class="row-fluid">
						<div class="span6">
							<div>
								<address>
									<strong>Orient Bell Limited</strong><br />
									Corp. Office: Iris House, 16 Business Centre, Nangal Raya, New Delhi 110046, India<br />
									Regd. Office: 8, Industrial Area, Sikandrabad 203205, UP, India <br />
									<abbr>M:</abbr> +91 8373914473 / +91 9999973927 | T: +91 11 4711 9100 | F: +91 11 2852 1273 <br /> E: customercare@orientbell.com |W: www.orientbell.com
								</address>
								<!-- <address>
									<strong>Support</strong><br />
									<a>admin@orientbell.com</a>
								</address> -->
							</div>
						</div>
						<div class="span6 invoice-block">
							<ul class="unstyled">
								<li><br/></li>
								<li><br/></li>
								<li>________________________</li>
								<li><strong>Authorised Signatory</strong></li>
							</ul>
							<!-- <br />
							<a href="cat_history.php" class="btn"><i class="icon-circle-arrow-left icon-white"></i>  Back</a>  <a class="btn" onclick="printDiv('printableArea')">Print  <i class="icon-print icon-white"></i></a> -->
						</div>
					</div>
				</div>
				</div>
				<div class="row-fluid">
					<div class="span10">
						<div>
							<address>
									<strong>Help & Support :-</strong><br />
									<a href="mailto:admin@orientbell.com">admin@orientbell.com</a>
								</address>
						</div>
						
					</div>
					<div class="span2 invoice-block">
							
							<a href="cat_history.php" class="btn"><i class="icon-circle-arrow-left icon-white"></i>  Back</a>  <a class="btn" onclick="printDiv('printableArea')">Print  <i class="icon-print icon-white"></i></a>
					</div>
				</div><br/>
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

  <!--  <script type="text/javascript">
  function PrintPage()
  {
   window.print();
  }
  </script> -->

<script type="text/javascript">
	function printDiv(printableArea) {
     var printContents = document.getElementById(printableArea).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>