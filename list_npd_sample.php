<?php 
	        $npd='active';
	        

        include_once('including/all-include.php');
        include_once('including/header.php');
		unset($_SESSION['working-active-asset']);
		

		$sql="SELECT 
				o.opportunity_id, 
				o.lead_id, 
				d.deal_sub_type, 
				c.cka_name, 
				o.project_name, 
				t.territory_name, 
				o.city, 
				o.tile_stage_date, 
				o.obl_sale_forecast_inr, 
				o.obl_sales_forecast_sqmt, 
				u.fullname, 
				o.npd_status, 
				o.npd_doc, 
				o.npd_create_date 
				from opportunity o
				inner join deal_sub_type d on d.deal_sub_type_id = o.sub_type
				inner join cka_name_master c on c.cka_name_id = o.cka_name_id
				inner join territory_master t on t.territory_id = o.territory
				inner join user_management u on u.uid = o.npd_created_by 
								  ";
  
    if(trim($_SESSION['user_type'])=='management' || trim($_SESSION['user_type'])=='plant' ) {
		$sql.="  where 1=1 and o.npd_status is NOT NULL order by o.npd_create_date desc ";
	}else{

			if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$sql .="o.npd_created_by = '".$vx."' or o.npd_created_by='".$_SESSION['uid']."' ";
							else
								$sql .=" or o.npd_created_by = '".$vx."' ";
							$xcnt++;
						}
						$sql .=" )order by o.npd_create_date desc";
					}else{
						$sql.="  where o.npd_created_by='".$_SESSION['uid']."' 
						order by o.npd_create_date desc";	
					}

			}
		
	}


	//echo $sql;
	
									$rs=odbc_exec($conn,$sql);
									$count=1;


			
			//print_r($_SESSION);
        ?>
            

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>NPD Sample Request</h4>
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
										<a href="create_sample.php">
                                        <button class="btn green">
										Create NPD Sample <i class="icon-plus"></i>
										</button>
                                        </a>
									</div>	
                    
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<!-- <li><a href="#">Print</a></li> -->
											<li><a href="export_doc.php?val_proj=<?php echo base64_encode($sql); ?>">Export Details</a></li>
										</ul>
									</div>
								</div>
								<div class="scrollable">
								<table class="table table-striped table-bordered table-hover" id="sample_1" >

									<thead style="white-space: nowrap; padding: 0px;">
										<tr>
                                            <th>#</th>
                                            <th>Lead ID</th>
                                            <th>Project Name</th>
											<th>Account Domain</th>
											<th>Account Name</th>
											<th>Territory</th>
                                            <th>City</th>
											<th>Tiling Date</th>
											<th>OBL Forecast(INR)</th>
											<th>OBL Forecast(SQMT)</th>
											<th>Status</th>                                            
	                                        <th>Created_by</th>
	                                        <th>Created_On</th>
	                                        <th>File</th>
                                            <th>Action</th>
                                        </tr>

									</thead>
									<tbody style="white-space: nowrap;">
									
								       <?php
										
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										$path = "assets/npd_doc/";
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										
										echo '<td class="highlight">';
										echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" title="'.ucfirst($f['lead_id']).'" target="_blank">'.trim($f['lead_id']).'</a>';
										echo '</td>';
										echo '<td title="'.ucfirst($f['project_name']).'">'.(strlen($f['project_name']) > 30 ? substr($f['project_name'],0,30)."..." : $f['project_name']).'</td>';	
										echo '<td>'.trim($f['deal_sub_type']).'</td>';	
										echo '<td>'.ucfirst(trim($f['cka_name'])).'</td>';
										echo '<td>'.ucfirst(trim($f['territory_name'])).'</td>';
										echo '<td>'.ucfirst(trim($f['city'])).'</td>';
										echo '<td>'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';
										echo '<td>'.ucfirst(trim($f['obl_sale_forecast_inr'])).'</td>';
										echo '<td>'.ucfirst(trim($f['obl_sales_forecast_sqmt'])).'</td>';
										echo '<td>'.ucfirst(trim($f['npd_status'])).'</td>';
										echo '<td>'.ucfirst(trim($f['fullname'])).'</td>';
										echo '<td>'.date('d-m-Y',strtotime(trim($f['npd_create_date']))).'</td>';
										echo '<td style="text-align: center;">';
										echo '<a href='.$path.''.$f['npd_doc'].' target="_blank"><img src="assets/img/pdf2.png" alt="" style="max-width: 30px"></a>';
										echo '</td>';
										
										if(trim($f['npd_status'])=='Open'){
										echo '<td>';
										echo '<a href="npd_submit.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print"><i class="icon-edit"></i>Edit</a>';
										echo '<a href="npd_history.php?pid='.$f['opportunity_id'].'" class="btn mini green no-print">Detail</a>';
										echo '</td>';
										}

										if(trim($f['npd_status'])=='In Process'){
										echo '<td>';
										echo '<a href="npd_submit.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print"><i class="icon-edit"></i>Edit</a>';
										echo '</td>';
										}

										if(trim($f['npd_status'])=='Closed'){
										echo '<td>';
										echo '<a href="npd_history.php?pid='.$f['opportunity_id'].'" class="btn mini green no-print">Detail</a>';
										echo '</td>';
										}
									}
									?>
       
									</tbody>
								</table>
							</div>
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