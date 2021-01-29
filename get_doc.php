
<?php
$cd='active';
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


<?php 
						$sql_central = "SELECT get_sub_category from get_doc_new where get_status = 1 and get_category = 'CENTRAL' group by get_sub_category"; 	
						$ca_central = odbc_exec($conn, $sql_central);
						$count_central =  1;					
						
						$get_place_central = [];
						//print_r($array); exit;
						while($c = odbc_fetch_array($ca_central)){

						$get_place_central[] = 	$c['get_sub_category'];	//
						

							?>

													<li <?php echo $count_central==1 ? "class='active'" : ""; ?>><a data-toggle="tab" href="#tab_4_<?php echo $count_central; ?>"><i class="icon-home"></i> <?php echo strtoupper($c['get_sub_category']); ?></a> 
														                          			
													</li>

<?php 						$count_central++;}


//print_r($c); exit;


				?>

													
												</ul>
											</div>
											<div class="span9">
												<div class="tab-content">

<?php
									for($i=0; $i<count($get_place_central);$i++){


										
					$sql_central_main = "SELECT * from get_doc_new where get_status = 1 and get_category = 'CENTRAL' and get_sub_category = '".$get_place_central[$i]."' order by get_name asc";
				
				                     $rs_central=odbc_exec($conn,$sql_central_main);
									 
						?>

													<div id="tab_4_<?php echo $i+1; ?>" class="tab-pane <?php echo $i+1==1 ? "active" : ""; ?>">
														<div style="height: auto;" id="accordion1" class="accordion collapse">
															<div class="portlet-body" style="display: block;">



																<table class="table table-striped table-bordered table-advance table-hover table-responsive" id="sample_1">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th><i class="icon-map-marker"></i> City</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>

<?php 			 
									 
									 
				                    
				                     while($f = odbc_fetch_array($rs_central)){
										  $child_data_central = $f;
										  
										  
										 //echo "<pre>"; print_r($f); die;
										//  echo count($f);
										 // exit;
										  
										 

 ?>

													<tr>
														<td><a href="<?php echo "assets/get_doc/".$child_data_central['get_category']."/".$child_data_central['get_pdf']; ?>" target="_blank"><?php echo $child_data_central['get_name']; ?></a></td>
														<td class="hidden-phone"><?php echo $child_data_central['get_desc']; ?></td>
														<td><?php echo $child_data_central['get_dept']; ?></td>
														<td><?php echo strtoupper($child_data_central['get_city']); ?></td>
														<td style="text-align: center;"><a href="<?php echo "assets/get_doc/".$child_data_central['get_category']."/".$child_data_central['get_pdf']; ?>" target="_blank"><img src="assets/img/pdf2.png" alt="" style="max-width: 30px"></a></td>
													</tr>
	
								<?php  //print_r($child_data); 
	
	}	 ?>

																	</tbody>
																</table>

															</div>
														</div>
													</div>

								<?php  //print_r($child_data); 
	
	}	 ?>
													
													
												</div>
											</div>
											<!--end span9-->                                   
										</div>
									</div>
								</div>

								<!--end tab-pane-1-->

								<!-- tab-2-pane-starts -->
				<div class="tab-pane row-fluid" id="tab_1_2">
									<div class="row-fluid">
										<div class="span12">
											<div class="span3">
												<ul class="ver-inline-menu tabbable margin-bottom-10">


<?php 
						$sql_state = "SELECT get_sub_category from get_doc_new where get_status = 1 and get_category = 'STATE' group by get_sub_category"; 	
						$ca_state = odbc_exec($conn, $sql_state);
						$count_state =  1;					
						
						$get_place_state = [];
						//print_r($array); exit;
						while($d = odbc_fetch_array($ca_state)){

						$get_place_state[] = 	$d['get_sub_category'];	//
						

							?>

													<li <?php echo $count_state==1 ? "class='active'" : ""; ?>><a data-toggle="tab" href="#tab_2_<?php echo $count_state; ?>"><i class="icon-road"></i> <?php echo strtoupper($d['get_sub_category']); ?></a> 
														                          			
													</li>

<?php 						$count_state++;}


//print_r($c); exit;


				?>

													
												</ul>
											</div>
											<div class="span9">
												<div class="tab-content">

<?php
									for($j=0; $j<count($get_place_state);$j++){


										
					$sql_state_main = "SELECT * from get_doc_new where get_status = 1 and get_category = 'STATE' and get_sub_category = '".$get_place_state[$j]."' order by get_name asc";
				
				                     $rs_state=odbc_exec($conn,$sql_state_main);
									 
						?>

													<div id="tab_2_<?php echo $j+1; ?>" class="tab-pane <?php echo $j+1==1 ? "active" : ""; ?>">
														<div style="height: auto;" id="accordion1" class="accordion collapse">
															<div class="portlet-body" style="display: block;">



																<table class="table table-striped table-bordered table-advance table-hover table-responsive" id="sample_1">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th><i class="icon-map-marker"></i> City</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>

<?php 			 
									 
									 
				                    
				                     while($g = odbc_fetch_array($rs_state)){
										  $child_data_state = $g;
										  
										  
										 //echo "<pre>"; print_r($f); die;
										//  echo count($f);
										 // exit;
										  
										 

 ?>

														<tr>
															<td><a href="<?php echo "assets/get_doc/".$child_data_state['get_category']."/".$child_data_state['get_pdf']; ?>" target = "_blank"><?php echo $child_data_state['get_name']; ?></a></td>
															<td class="hidden-phone"><?php echo $child_data_state['get_desc']; ?></td>
															<td><?php echo $child_data_state['get_dept']; ?></td>
															<td><?php echo strtoupper($child_data_state['get_city']); ?></td>
															<td style="text-align: center;"><a href="<?php echo "assets/get_doc/".$child_data_state['get_category']."/".$child_data_state['get_pdf']; ?>" target="_blank"><img src="assets/img/pdf2.png" alt="" style="max-width: 30px"></a></td>
														</tr>
	
								<?php  //print_r($child_data); 
	
	}	 ?>

																	</tbody>
																</table>

															</div>
														</div>
													</div>

								<?php  //print_r($child_data); 
	
	}	 ?>
													
													
												</div>
											</div>
											<!--end span9-->                                   
										</div>
									</div>
								</div>
								<!--end tab-pane-2-->

								<!-- start tab-pane-3 -->

<div class="tab-pane row-fluid" id="tab_1_3">
									<div class="row-fluid">
										<div class="span12">
											<div class="span3">
												<ul class="ver-inline-menu tabbable margin-bottom-10">


<?php 
						$sql_psu = "SELECT get_sub_category from get_doc_new where get_status = 1 and get_category = 'PSU' group by get_sub_category"; 	
						$ca_psu = odbc_exec($conn, $sql_psu);
						$count_psu =  1;					
						
						$get_place_psu = [];
						//print_r($array); exit;
						while($e = odbc_fetch_array($ca_psu)){

						$get_place_psu[] = 	$e['get_sub_category'];	//
						

							?>

													<li <?php echo $count_psu==1 ? "class='active'" : ""; ?>><a data-toggle="tab" href="#tab_3_<?php echo $count_psu; ?>"><i class="icon-bookmark"></i> <?php echo strtoupper($e['get_sub_category']); ?></a> 
														                          			
													</li>

<?php 						$count_psu++;}


//print_r($c); exit;


				?>

													
												</ul>
											</div>
											<div class="span9">
												<div class="tab-content">

<?php
									for($k=0; $k<count($get_place_psu);$k++){


										
					$sql_psu_main = "SELECT * from get_doc_new where get_status = 1 and get_category = 'PSU' and get_sub_category = '".$get_place_psu[$k]."' order by get_name asc";
				
				                     $rs_psu=odbc_exec($conn,$sql_psu_main);
									 
						?>

													<div id="tab_3_<?php echo $k+1; ?>" class="tab-pane <?php echo $k+1==1 ? "active" : ""; ?>">
														<div style="height: auto;" id="accordion1" class="accordion collapse">
															<div class="portlet-body" style="display: block;">



																<table class="table table-striped table-bordered table-advance table-hover table-responsive" id="sample_1">
																	<thead>
																		<tr>
																			<th><i class="icon-briefcase"></i> Document Name</th>
																			<th class="hidden-phone"><i class="icon-question-sign"></i> Descrition</th>
																			<th><i class="icon-bookmark"></i> Department</th>
																			<th><i class="icon-map-marker"></i> City</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>

<?php 			 
									 
									 
				                    
				                     while($h = odbc_fetch_array($rs_psu)){
										  $child_data_psu = $h;
										  
										  
										 //echo "<pre>"; print_r($f); die;
										//  echo count($f);
										 // exit;
										  
										 

 ?>

															<tr>
																<td><a href="<?php echo "assets/get_doc/".$child_data_psu['get_category']."/".$child_data_psu['get_pdf']; ?>" target="_blank"><?php echo $child_data_psu['get_name']; ?></a></td>
																<td class="hidden-phone"><?php echo $child_data_psu['get_desc']; ?></td>
																<td><?php echo $child_data_psu['get_dept']; ?></td>
																<td><?php echo strtoupper($child_data_psu['get_city']); ?></td>
																<td style="text-align: center;"><a href="<?php echo "assets/get_doc/".$child_data_psu['get_category']."/".$child_data_psu['get_pdf']; ?>" target="_blank"><img src="assets/img/pdf2.png" alt="" style="max-width: 30px"></a></td>
															</tr>
	
								<?php  //print_r($child_data); 
	
	}	 ?>

																	</tbody>
																</table>

															</div>
														</div>
													</div>

								<?php  //print_r($child_data); 
	
	}	 ?>
													
													
												</div>
											</div>
											<!--end span9-->                                   
										</div>
									</div>
								</div>
								<!-- end tab-pane-3 -->
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

<!-- 	<script src="assets/breakpoints/breakpoints.js"></script>       
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   <script src="assets/js/jquery.blockui.js"></script>
   <script src="assets/js/jquery.cookie.js"></script>
   ie8 fixes
   [if lt IE 9]>
   <script src="assets/js/excanvas.js"></script>
   <script src="assets/js/respond.js"></script>
   <![endif]
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
 -->




    