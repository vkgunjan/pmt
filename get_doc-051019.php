
<?php


$gdoc='active'; 
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
?>



<div class="row-fluid profile">
					<div class="span12">
						<!--BEGIN TABS-->
					<div class="tabbable tabbable-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1_1" data-toggle="tab">CENTRAL</a></li>
								<li><a href="#tab_1_2" data-toggle="tab">STATE</a></li>
								<li><a href="#tab_1_3" data-toggle="tab">PSU</a></li>
								
							</ul>
							<div class="tab-content">
							
								<!-- tab-1-pane-starts -->

								<div class="tab-pane row-fluid active" id="tab_1_1">
									<div class="row-fluid">
										<div class="span12">
											<div class="span3">
												<ul class="ver-inline-menu tabbable margin-bottom-10">
													<li class="active"><a data-toggle="tab" href="#tab_1"><i class="icon-briefcase"></i> GENERAL</a> 
														                          			
													</li>
													<li><a data-toggle="tab" href="#tab_2"><i class="icon-group"></i> CPWD</a></li>
													<li><a data-toggle="tab" href="#tab_3"><i class="icon-leaf"></i> MES</a></li>
													<li><a data-toggle="tab" href="#tab_4"><i class="icon-info-sign"></i> RAILWAY</a></li>
													<li><a data-toggle="tab" href="#tab_5"><i class="icon-tint"></i> IIT</a></li>
													<li><a data-toggle="tab" href="#tab_6"><i class="icon-plus"></i> OTHERS</a></li>
												</ul>
											</div>
											<div class="span9">
												<div class="tab-content">
													<div id="tab_1" class="tab-pane active">
														<div style="height: auto;" id="accordion1" class="accordion collapse">
															<div class="portlet-body" style="display: block;">
																<table class="table table-striped table-bordered table-advance table-hover">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td><a href="#">Bhopal CD 1</a></td>
																			<td class="hidden-phone">Bhopal CD 1</td>
																			<td>General</td>
																			<td style="text-align: center;"><a href="#" target="_blank"><img src="assets/img/pdf2.png" alt="" style="max-width: 30px"></a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				Smart House
																				</a>	
																			</td>
																			<td class="hidden-phone">Office furniture purchase</td>
																			<td>5760.00$ <span class="label label-warning label-mini">Pending</span></td>
																			<td><a class="btn mini blue-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				FoodMaster Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Company Anual Dinner Catering</td>
																			<td>12400.00$ <span class="label label-success label-mini">Paid</span></td>
																			<td><a class="btn mini blue-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				WaterPure Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Payment for Jan 2013</td>
																			<td>610.50$ <span class="label label-danger label-mini">Overdue</span></td>
																			<td><a class="btn mini red-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td><a href="#">Pixel Ltd</a></td>
																			<td class="hidden-phone">Server hardware purchase</td>
																			<td>52560.10$ <span class="label label-success label-mini">Paid</span></td>
																			<td><a class="btn mini green-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				Smart House
																				</a>	
																			</td>
																			<td class="hidden-phone">Office furniture purchase</td>
																			<td>5760.00$ <span class="label label-warning label-mini">Pending</span></td>
																			<td><a class="btn mini blue-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				FoodMaster Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Company Anual Dinner Catering</td>
																			<td>12400.00$ <span class="label label-success label-mini">Paid</span></td>
																			<td><a class="btn mini blue-stripe" href="#">View</a></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div id="tab_2" class="tab-pane">
														<div style="height: auto;" id="accordion2" class="accordion collapse">
															<div class="portlet-body" style="display: block;">
																<table class="table table-striped table-bordered table-advance table-hover">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>
																				<a href="#">
																				WaterPure Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Payment for Jan 2013</td>
																			<td>610.50$ <span class="label label-danger label-mini">Overdue</span></td>
																			<td><a class="btn mini red-stripe" href="#">View</a></td>
																		</tr>
																		
																		
																		
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div id="tab_3" class="tab-pane">
														<div style="height: auto;" id="accordion3" class="accordion collapse">
															<div class="portlet-body" style="display: block;">
																<table class="table table-striped table-bordered table-advance table-hover">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td><a href="#">Pixel Ltd</a></td>
																			<td class="hidden-phone">Server hardware purchase</td>
																			<td>52560.10$ <span class="label label-success label-mini">Paid</span></td>
																			<td><a class="btn mini green-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				Smart House
																				</a>	
																			</td>
																			<td class="hidden-phone">Office furniture purchase</td>
																			<td>5760.00$ <span class="label label-warning label-mini">Pending</span></td>
																			<td><a class="btn mini blue-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				FoodMaster Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Company Anual Dinner Catering</td>
																			<td>12400.00$ <span class="label label-success label-mini">Paid</span></td>
																			<td><a class="btn mini blue-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				WaterPure Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Payment for Jan 2013</td>
																			<td>610.50$ <span class="label label-danger label-mini">Overdue</span></td>
																			<td><a class="btn mini red-stripe" href="#">View</a></td>
																		</tr>
																		
																		
																		
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div id="tab_4" class="tab-pane">
														<div style="height: auto;" id="accordion4" class="accordion collapse">
															<div class="portlet-body" style="display: block;">
																<table class="table table-striped table-bordered table-advance table-hover">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>
																				<a href="#">
																				WaterPure Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Payment for Jan 2013</td>
																			<td>610.50$ <span class="label label-danger label-mini">Overdue</span></td>
																			<td><a class="btn mini red-stripe" href="#">View</a></td>
																		</tr>
																		
																		
																		
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div id="tab_5" class="tab-pane">
														<div style="height: auto;" id="accordion5" class="accordion collapse">
															<div class="portlet-body" style="display: block;">
																<table class="table table-striped table-bordered table-advance table-hover">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>
																				<a href="#">
																				WaterPure Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Payment for Jan 2013</td>
																			<td>610.50$ <span class="label label-danger label-mini">Overdue</span></td>
																			<td><a class="btn mini red-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				DDA Flats
																				</a>
																			</td>
																			<td class="hidden-phone">Payment for Jan 2013</td>
																			<td>CPWD</td>
																			<td><a class="btn mini red-stripe" href="#">View</a></td>
																		</tr>
																		
																		
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<div id="tab_6" class="tab-pane">
														<div style="height: auto;" id="accordion6" class="accordion collapse">
															<div class="portlet-body" style="display: block;">
																<table class="table table-striped table-bordered table-advance table-hover">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>
																				<a href="#">
																				WaterPure Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Payment for Jan 2013</td>
																			<td>610.50$ <span class="label label-danger label-mini">Overdue</span></td>
																			<td><a class="btn mini red-stripe" href="#">View</a></td>
																		</tr>
																		<tr>
																			<td>
																				<a href="#">
																				WaterPure Ltd
																				</a>
																			</td>
																			<td class="hidden-phone">Payment for Jan 2013</td>
																			<td>610.50$ <span class="label label-danger label-mini">Overdue</span></td>
																			<td><a class="btn mini red-stripe" href="#">View</a></td>
																		</tr>
																		
																		
																		
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!--end span9-->                                   
										</div>
									</div>
								</div>

								<!--end tab-pane-1-->

								<!-- tab-2-pane-starts -->

								<!--end tab-pane-2-->
							</div>
						</div>
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

	<script src="assets/breakpoints/breakpoints.js"></script>       
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   <script src="assets/js/jquery.blockui.js"></script>
   <script src="assets/js/jquery.cookie.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="assets/js/excanvas.js"></script>
   <script src="assets/js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   
  
   <script src="assets/js/app.js"></script>  


	<script>
  $(document).ready(function(){
      var items = ["#9062aa", "#3fb4e9", "#6fc063", "#d94949", "#f8951e", "#7a564a", "#029688", "#2d2f79", "#e81f63"];
      var index = 0;
      var color;
      $(".ooicon").each(function() {
        if (index == items.length)
          index = 0;

        color = items[index];
        $(this).css('background', color);
        index++;
      });
  });
</script>



    