<?php 
	        $sm='active';
	        $la='active';

        include_once('including/all-include.php');
        include_once('including/header.php');

if(isset($_POST['submit'])){
	echo 'From Date:'.$_POST['fromdate'];
	echo '<br>';
	echo 'To Date:'.$_POST['todate'];

	
	echo $sql="select * from schedule where  activation_date <= '".$_POST['todate']."' and factory_id='".$_SESSION['factory-id']."' ";
	$rs=odbc_exec($conn,$sql);
	echo '<br>count-'.odbc_num_rows($rs);
	while($f = odbc_fetch_array($rs)){
		echo '<pre>';
		print_r($f);

			$current_date=date('Y-m-d');
			$activation_date=date('Y-m-d', strtotime($f['activation_date'])) ;
			$from_date=$_POST['fromdate'];
			$to_date=$_POST['todate'];
			
			
	if(!empty($f['last_maintenance_date'])){
		$start_date=$f['last_maintenance_date'];
	}else{
		if($activation_date<$from_date){
			
			if($current_date<=$from_date){
				echo 'startdate-A-'.$start_date=$from_date;
				echo '<br>';
			}else{
				echo 'startdate-B-'.$start_date=$current_date;
				echo '<br>';
			}
		}else{
			if($current_date>$from_date){
				echo 'startdate-C-'.$start_date=$current_date;
				echo '<br>';
			}else{
				echo 'startdate-D-'.$start_date=$activation_date;
				echo '<br>';
			}
		}
	}
	
		if(trim($f['recurrence_schedule'])=='weekly'){
			$day_of_working_date=date('w', strtotime($start_date)); 
			$day_of_s=$f['day'];
			$diff=$day_of_s - $day_of_working_date;
			$start_date=date('Y-m-d', strtotime($start_date. ' + '.($diff).' days'));	
		}
		
		if(trim($f['recurrence_schedule'])=='monthly'){
			
			$st=explode("-",$start_date);
			$day_of_sd=$st[2];
			$day_of_d=$f['day'];

			if((int)$day_of_sd > (int)$day_of_d ){
				 $start_date=date('Y-m-d', strtotime($start_date. ' + 1 month'));	
			}
				 if($day_of_d<10)
				 $day_of_d='0'.$day_of_d;
				 
				 $start_date=$st[0].'-'.$st[1].'-'.$day_of_d;
		}


		if(trim($f['recurrence_schedule'])=='yearly'){
			
			$st=explode("-",$start_date);
			$day_of_sd=$st[2];
			$day_of_d=$f['day'];

			if((int)$day_of_sd > (int)$day_of_d ){
				 $start_date=date('Y-m-d', strtotime($start_date. ' + 1 year'));	
			}
				 if($day_of_d<10)
				 $day_of_d='0'.$day_of_d;
				 
				 $start_date=$st[0].'-'.$st[1].'-'.$day_of_d;
		}


		
		$working_date=$start_date;		
		
		while($working_date<=$to_date){
			
			if(trim($f['recurrence_schedule'])=='daily'){
				if($working_date>=$from_date && $working_date<=$to_date){
					echo $working_date;
					echo '<br>';
				}
				$working_date=date('Y-m-d', strtotime($working_date. ' + '.$f['frequency'].' days'));	
			}
			
			if(trim($f['recurrence_schedule'])=='weekly'){
				if($working_date>=$from_date && $working_date<=$to_date){
					$day_of_working_date=date('w', strtotime($working_date)); 
					if($day_of_working_date == $f['day'] ){
						echo $working_date;
						echo '<br>';
					}
				}
				$working_date=date('Y-m-d', strtotime($working_date. ' + '.(7*$f['frequency']).' days'));	
			}
			
			
			if(trim($f['recurrence_schedule'])=='monthly'){
				if($working_date>=$from_date && $working_date<=$to_date){
						echo '@'.$working_date;
						echo '<br>';
				}
				$working_date=date('Y-m-d', strtotime($working_date. ' + '.($f['frequency']).' month'));	
			}
			
			
			if(trim($f['recurrence_schedule'])=='yearly'){
				if($working_date>=$from_date && $working_date<=$to_date){
						echo '@'.$working_date;
						echo '<br>';
				}
				$working_date=date('Y-m-d', strtotime($working_date. ' + '.($f['frequency']).' year'));	
			}
			
			
		}
		

			
	}
}

        ?>
            

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>List of All Scheduled Assets </h4>
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
										<a href="asset-master.php">
                                        <button class="btn red">
										Generate Schedule 
										</button>
                                        </a>
									</div>
                                    	&nbsp;&nbsp;&nbsp;							
										<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                                        From Date<input type="text" name="fromdate">
   										To Date<input type="text" name="todate">
                                        <input type="submit" name="submit" value="Search">
										</form>
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
								<!--display table-space-vineet-->
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
