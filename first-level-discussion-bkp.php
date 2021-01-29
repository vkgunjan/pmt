<?php 
	        $pm='active';
	        $fld='active';
			

        include_once('including/all-include.php');
        include_once('including/header.php');
		
			if(isset($_SESSION['fld_leadID'])){
			 unset($_SESSION['fld_leadID']);
			}


		unset($_SESSION['working-active-asset']);
			
			
//			print_r($_SESSION);
        ?>
            

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>List of All Deal at First Level Discussion</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                	
                                    	<?php /*?>&nbsp;&nbsp;&nbsp;							
										<font color="#000000"><span class="label label-success">Total: 8 Deals</font><?php */?>
                    				<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Print</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1" >
									<thead>
										<tr>
											<!--<th>Lead ID</th>-->
                                            <th>#</th>
                                            <th width="15%">CKA Name</th>
											<!--<th >CKA Type</th>-->
										<!--	<th >Project Type</th>-->
											<th width="15%">Project Name</th>
											<!--<th >State</th>-->
											<th>City</th>
											<!--<th >Architect Name</th>-->
                                          <!--  <th>Tile Stage Date</th>-->
                                            <th>OBL Forecast</th>
                                            <!--<th>Status</th>-->
											<th>Win Probability</th>
											<th>Tiling Date</th>
                                            <th>Sales Phase</th>
                                            <th>Action</th>
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		$sql="SELECT 
		d.opportunity_id,
	 a.cka_name,
	 b.cka_type,
	 c.project_type,
	 d.[project_name],
     e.state_name,
     d.[city],
     d.[architect_name],
	 d.[tile_stage_date],
     d.[obl_sale_forecast_inr],
	 probability_of_win,
     d.[status],
	 d.current_stage
  FROM [opportunity] d
  left join cka_name_master a on a.cka_name_id = d. cka_name_id
  left join cka_type_master b on b.cka_type_id = d.cka_type_id
  left join project_type_master c on c.project_type_id = d.project_type_id
  left join state_master e on e.state_id = d.state_id ";
 
 if(trim($_SESSION['user_type'])=='management') {
		$sql.=" where d.current_stage='2' and status='open'  order by obl_sale_forecast_inr desc";
	}else{
		$sql.=" where d.current_stage='2' and status='open'  and d.created_by='".$_SESSION['uid']."'  order by obl_sale_forecast_inr desc ";
	}
	
 
	 
	//echo $sql;
	
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										//echo '<td>'.$f['opportunity_id'].'</td>';
										echo '<td>'.$f['cka_name'].'</td>';
										//echo '<td>'.$f['cka_type'].'</td>';										
										//echo '<td >'.$f['project_type'].'</td>';																
										echo '<td>'.ucfirst($f['project_name']).'</td>';	
										//echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.$f['city'].'</td>';
										//echo '<td>'.$f['architect_name'].'</td>';
										//echo '<td>'.$f['tile_stage_date'].'</td>';
										
										echo '<td>'.valchar(trim($f['obl_sale_forecast_inr'])).'</td>';
										//echo '<td>'.number_format(trim($f['obl_sale_forecast_inr']),0).'</td>';
											
											echo '<td align="center">'.ucfirst($f['probability_of_win']).'</td>';
											
											//echo '<td>'.trim($f['tile_stage_date']).'</td>';

											echo '<td>'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';
																															
										if(trim($f['current_stage'])=='1'){
											$cstage='Opportunity';
										}
										
										if(trim($f['current_stage'])=='2'){
											$cstage='First Level Discussion';
										}
										
										if(trim($f['current_stage'])=='3'){
											$cstage='Sampling';
										}
										
										
										if(trim($f['status'])=='open'){
											//echo '<td align="center"><span class="label label-success">O</span></td>';

											echo '<td>'.$cstage.'</td>';
			echo '<td >';
				echo '<a href="fld-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue"><i class="icon-edit"></i>Update</a>';
			echo '</td>';
										}
								
								}
									?>
       
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
   <?php include_once('including/footer.php')?>
      <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
			$ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>