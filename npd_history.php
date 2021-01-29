
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
				opportunity_id, npd_create_date, npd_docket_no,npd_docket_date,npd_boxes, npd_dispatch_remark
				from opportunity
				where opportunity_id = '$pid'";

				$rs=odbc_exec($conn,$sql);
				while($f = odbc_fetch_array($rs)){
					$npd_create_date = $f['npd_create_date'];
					$npd_docket_no = $f['npd_docket_no'];
					$npd_docket_date = $f['npd_docket_date'];
					$npd_boxes = $f['npd_boxes'];
					$npd_dispatch_remark = $f['npd_dispatch_remark'];
					
				}

				
?>
<?php 

		$pid=$_GET['pid'];

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
					<div class="row-fluid invoice-logo">
						<div class="span6"><img src="assets/img/logo-header.png" alt="" /> </div>
						<div class="span6">
							<p style="font-size: 16px;"> <?php echo date('d M, Y h:m',strtotime(trim($npd_create_date)))?> </p>
						</div>
					</div>
					<p style="text-align: center; font-size: 20px; font-weight: bold;">NPD ORDER DETAILS</p>
					<hr />

					<div class="row-fluid">
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
											<th>NPD Status</th>
                                           
                                          
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
			d.npd_status
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
										echo '<td>'.$f['npd_status'].'</td>';
									}
									?>
									</tbody>
						</table>
					</div>
					<hr>
					<div class="row-fluid">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
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
							<tbody>

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
								                    echo '<td>'.$l_po_status.'</td>';
								                    echo '<td>'.$l_expected_delivery_date.'</td>';
								                    echo '<td>'.$l_receive_date.'</td>';
								                    echo '<td>'.$l_actual_delivery_date.'</td>';
								                    echo '<td>'.$l_tile_matching_status.'</td>';

								                    echo '</tr>';

								                    $count++;

								                }
									?>
					
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
                                                <span class="text"><b><?php echo strtoupper($npd_docket_no); ?></b></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label" for="docketDate">Docket Date:</label>
                                             <div class="controls">
                                                <span class="text"><b><?php echo date('Y-m-d',strtotime(trim($npd_docket_date))) ?></b></span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dispatchQuantity">No of Box(s):</label>
                                             <div class="controls">
                                                <span class="text"><b><?php echo $npd_boxes; ?></b></span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dispatchQuantity">Dispatch Remark:</label>
                                             <div class="controls">
                                                <span class="text"><b><?php echo $npd_dispatch_remark; ?></b></span>
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
							<!-- <ul class="unstyled">
								<li><br/></li>
								<li><br/></li>
								<li>________________________</li>
								<li><strong>Authorised Signatory</strong></li>
							</ul> -->
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
									<a href="mailto:itsupport@orientbell.com">itsupport@orientbell.com</a>
								</address>
						</div>
						
					</div>
					<div class="span2 invoice-block">
							
							<a href="list_npd_sample.php" class="btn"><i class="icon-circle-arrow-left icon-white"></i>  Back</a>  <a class="btn" onclick="printDiv('printableArea')">Print  <i class="icon-print icon-white"></i></a>
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