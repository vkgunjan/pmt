
<?php 
	        $pm='active';
	        $lopp='active';

        include_once('including/all-include.php');
		
        include_once('including/header.php');
			unset($_SESSION['working-active-asset']);
			
			
			//print_r($_SESSION);
        ?>
            

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box light-grey">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Managed Table</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
									<div class="btn-group">
										<button id="sample_editable_1_new" class="btn green">
										Add New <i class="icon-plus"></i>
										</button>
									</div>
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
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
											<th>Username</th>
											<th class="hidden-480">Email</th>
											<th class="hidden-480">Points</th>
											<th class="hidden-480">Joined</th>
											<th ></th>
										</tr>
									</thead>
									<tbody>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>shuxer</td>
											<td class="hidden-480"><a href="mailto:shuxer@gmail.com">shuxer@gmail.com</a></td>
											<td class="hidden-480">120</td>
											<td class="center hidden-480">12 Jan 2012</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>looper</td>
											<td class="hidden-480"><a href="mailto:looper90@gmail.com">looper90@gmail.com</a></td>
											<td class="hidden-480">120</td>
											<td class="center hidden-480">12.12.2011</td>
											<td ><span class="label label-warning">Suspended</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>userwow</td>
											<td class="hidden-480"><a href="mailto:userwow@yahoo.com">userwow@yahoo.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">12.12.2012</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>user1wow</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">12.12.2012</td>
											<td ><span class="label label-inverse">Blocked</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>restest</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">12.12.2012</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>foopl</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">19.11.2010</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>weep</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">19.11.2010</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>coop</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">19.11.2010</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>pppol</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">19.11.2010</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>test</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">19.11.2010</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>userwow</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">12.12.2012</td>
											<td ><span class="label label-inverse">Blocked</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>test</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">12.12.2012</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>goop</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">12.11.2010</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>weep</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">15.11.2011</td>
											<td ><span class="label label-inverse">Blocked</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>toopl</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">16.11.2010</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>userwow</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">9.12.2012</td>
											<td ><span class="label label-inverse">Blocked</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>tes21t</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">14.12.2012</td>
											<td ><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>fop</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">13.11.2010</td>
											<td ><span class="label label-warning">Suspended</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>kop</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">17.11.2010</td>
											<td><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>vopl</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">19.11.2010</td>
											<td><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>userwow</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">userwow@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">12.12.2012</td>
											<td><span class="label label-inverse">Blocked</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>wap</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">test@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">12.12.2012</td>
											<td><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>test</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">19.12.2010</td>
											<td><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>toop</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">17.12.2010</td>
											<td><span class="label label-success">Approved</span></td>
										</tr>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td>weep</td>
											<td class="hidden-480"><a href="mailto:userwow@gmail.com">good@gmail.com</a></td>
											<td class="hidden-480">20</td>
											<td class="center hidden-480">15.11.2011</td>
											<td><span class="label label-success">Approved</span></td>
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
  <!-- END CONTAINER -->

	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
  	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
  	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>
  	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("table_managed");
			App.init();
		});
	</script>
    
   <?php include_once('including/footer.php')?>
      <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
			$ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>