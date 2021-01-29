<?php 
	        $am='active';
	        $aa='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
        ?>
            

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Editable Table</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                									
										<font color="#000000"><span class="label label-success">W</span> - Working</font>
										&nbsp;
										<font color="#000000"><span class="label label-warning">M</span> - Under Maintainance</font>
										&nbsp;
										<font color="#000000"><span class="label label-info">B</span> - Breakdown</font>
										&nbsp;
										<font color="#000000"><span class="label label-danger">S</span> - Scrap</font>

									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Print</a></li>
											<li><a href="#">Save as PDF</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											<th>Code</th>
											<th>Type</th>
											<th>Name</th>
											<th>Plant/Building</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>Area</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                            <th>Status</th>
                                            <th>Action</th>                                            
										
                                        </tr>
									</thead>
									<tbody>
										<tr class="">
											<td>H-001</td>
											<td>Server</td>
											<td>Domain Controler</td>
											<td>Head-Office</td>
											<td>IT</td>
											<td>First Floor</td>                                            
											<td>Server Room</td>   
											<td>HP DL 360 G9</td>											
                                            <td>HGH0058745</td>
                                            <td><span class="label label-success">W</span></td>
                                            <td><a href="#" class="btn mini purple"><i class="icon-edit"></i> Maintenance</a></td>
                                         </tr>
										
                                        <tr class="">
											<td>H-001</td>
											<td>Server</td>
											<td>Navision Server</td>
											<td>Head-Office</td>
											<td>IT</td>
											<td>First Floor</td>                                            
											<td>Server Room</td>   
											<td>HP DL 360 G9</td>											
                                            <td>HGH0058745</td>
                                            <td><span class="label label-warning">M</span></td>
											<td><a href="#" class="btn mini purple"><i class="icon-edit"></i> Maintenance</a></td>
                                         </tr>
										
                                        
										
									</tbody>
								</table>
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
	<!-- BEGIN FOOTER -->
	<div class="footer">
		2013 &copy; Metronic by keenthemes.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<script src="assets/breakpoints/breakpoints.js"></script>	
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>		
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("table_editable");
			App.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
