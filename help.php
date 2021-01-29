
<?php


$help='active'; 
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
?>



<div class="row-fluid">
					<div class="span12">
						<!--BEGIN TABS-->
					
						<!-- BEGIN ACCORDION PORTLET-->
						<div class="portlet box yellow">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Help</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!-- <div class="accordion in collapse" id="accordion1" style="height: auto;"> -->
									
		<!-- Datatable start -->							
		<table class="table" id="sample_1">
									<thead>
										<tr>
											
											<th></th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										$sql = "SELECT * from help where hStatus = 1";
										$rs=odbc_exec($conn,$sql);
						                  $count=1;
						                  while($f = odbc_fetch_array($rs)){
										 ?>
										<tr>
											<td>
												<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_<?php echo $count; ?>">
													<i style="font-size: 15px;" class="<?php echo $f['hIcon']; ?>"></i>&nbsp;&nbsp;
													<b style="font-size: 15px;"><?php echo strtoupper($f['hTitle']); ?></b><i class="icon-sort-down pull-right"></i>
													</a>
												</div>
												<div id="collapse_<?php echo $count; ?>" class="accordion-body collapse">
													<div class="accordion-inner">
														<?php echo $f['hContent']; ?>
													</div>
												</div>
												</div>
											</td>
										</tr>
									<?php 
									$count++;
								} ?>
										
									</tbody>
								</table>
		<!-- Datatable end -->
								<!-- </div> -->
							</div>
						</div>
						<!-- END ACCORDION PORTLET-->      
					
						<!--END TABS-->
					</div>
				</div>
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







    