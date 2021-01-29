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


        <?php
		$sql="SELECT
		d.opportunity_id,
		d.lead_id,
	 a.cka_name,
	 b.cka_type,
	 c.project_type,
	 d.[project_name],
     e.state_name,
	 e.zone,
     d.[city],
     d.[architect_name],
	 d.[tile_stage_date],
     d.[obl_sale_forecast_inr],
	 d.[probability_of_win],
     d.[status],
	 d.deal_type,
	 d.territory,
	 d.current_stage,
	 d.gps_department_name,
	 d.modified_by,
	 u.fullname,
	 u.employee_department,
	 t.territory_name,
	 d.quotation_status,
	 d.added_date
  FROM [opportunity] d
  left join cka_name_master a on a.cka_name_id = d. cka_name_id
  left join cka_type_master b on b.cka_type_id = d.cka_type_id
  left join project_type_master c on c.project_type_id = d.project_type_id
  left join state_master e on e.state_id = d.state_id 
  left join user_management u on d.created_by = u.uid 
  left join territory_master t on t.territory_id = d.territory 
  ";
  
    if(trim($_SESSION['user_type'])=='management') {
		$sql.="  where d.current_stage='2' and status='open' order by added_date desc ";
	}else{

			/*if($_SESSION['employee_department']=='Retail'){
				$sql.=" where d.deal_type='Retail' 
						and d.territory in (".$_SESSION['employee_territory'].") 
						and d.current_stage='2' 
						and status='open' 
						order by added_date desc ";
			}*/


			if($_SESSION['employee_department']=='CKA'){
//vks start
					if($_SESSION['user_type']=='manager'){
					
					$sql.=" where d.current_stage='2' 
						and status='open' 
						and ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$sql .="a.cka_mapped_with_emp = '".$vx."' ";
							else
								$sql .=" or a.cka_mapped_with_emp = '".$vx."' ";
							$xcnt++;
						}
						$sql .=" )order by obl_sale_forecast_inr desc ";
					}else{
						$sql.=" where ( d.deal_type='CKA' 
						and d.current_stage='2' 
						and status='open' 
						) and ( ";

						$ex=explode(",",$_SESSION['emp_cka_mapping']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$sql .="d.cka_name_id = '".$vx."' ";
							else
								$sql .=" or d.cka_name_id = '".$vx."' ";
							$xcnt++;
						}

						$sql .=" )order by obl_sale_forecast_inr desc ";
					}

//vks ends

					
				
				//echo $sql;
			}

			if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where d.current_stage='2' 
						and status='open' 
						and ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$sql .="d.created_by = '".$vx."' or d.created_by='".$_SESSION['uid']."' ";
							else
								$sql .=" or d.created_by = '".$vx."' ";
							$xcnt++;
						}
						$sql .=" )order by added_date desc ";
					}else{
						$sql.="  where d.current_stage='2' and status='open' and d.created_by='".$_SESSION['uid']."' 
						order by added_date desc ";	
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
								<h4><i class="icon-edit"></i>List of All Deal at Discussion</h4>
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
										<a href="exportdatavisit.php?val=<?php echo base64_encode($sql); ?>"><button class="btn green">Export Visit Details &nbsp;<i class="icon-angle-right"></i>
										</button></a>
										<!-- <ul class="dropdown-menu">
											<li><a href="#">Print</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul> -->
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1" >
									<thead>
										<tr>
											<!--<th>Lead ID</th>-->
                                            <th width="1%">#</th>
                                            <th width="10%">Lead ID</th>
                                            <th width="10%">Account Name</th>
											<!--<th >CKA Type</th>-->
										<!--	<th >Project Type</th>-->
											<th width="10%">Project Name</th>
											<!-- <th width="5%">Project Type</th> -->
											<th width="5%">State</th>
											<th width="5%">City</th>
											<th width="5%">Zone</th>
											<!--<th width="2%">Territory</th>-->

											<!--<th >Architect Name</th>-->
                                          <!--  <th>Tile Stage Date</th>-->
                                            <th width="5%">OBL Forecast (INR Lac)</th>
                                            <!--<th>Status</th>-->
											<th width="5%">Tiling Date</th>
											<th width="5%">Generated By</th>
											<th width="5%">Lead Source</th>                                            
											<!--<th width="5%">Modified By</th>-->                                                                                        
<!--                                            <th>Status</th>
-->                                            <th width="5%">Sales Phase</th>
                                            <th width="5%">Action</th>
                                        </tr>
									</thead>
									<tbody>
									
       

	<?php


	//echo $sql;
	
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										echo '<td>'.$f['lead_id'].'</td>';
										echo '<td>'.$f['cka_name'].'</td>';
										//echo '<td>'.$f['cka_type'].'</td>';										

										echo '<td>'.substr(ucfirst($f['project_name']),0,30).'</td>';	
										//echo '<td>'.trim($f['project_type']).'</td>';	
																									
										echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.ucfirst(trim($f['city'])).'</td>';
										echo '<td>'.ucfirst(trim($f['zone'])).'</td>';
										//echo '<td width="5%">'.$f['territory_name'].'</td>';

										//echo '<td>'.$f['architect_name'].'</td>';
										//echo '<td>'.$f['tile_stage_date'].'</td>';
										
										//echo '<td>'.valchar(trim($f['obl_sale_forecast_inr'])).'</td>';
										echo '<td>'.number_format(trim($f['obl_sale_forecast_inr']/100000),0).'</td>';

										//echo '<td>'.number_format(trim($f['obl_sale_forecast_inr']),0).'</td>';
											
											
											echo '<td width="9%">'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';

											echo '<td>'.$f['fullname'].'</td>';
											echo '<td>'.$f['employee_department'].'</td>';
			
											//$uq="select fullname, employee_department from [user_management] 
											//where uid= '".dbInput($f['modified_by'])."' ";
											//$ue=odbc_exec($conn, $uq);
											//$uf=odbc_fetch_array($ue);
//											echo '<td>'.$uf['fullname'].' ('.$uf['employee_department'].')</td>';
											//echo '<td>'.$uf['fullname'].' </td>';

											//echo '<td>pp</td>';

																															
										if(trim($f['current_stage'])=='1'){
											$cstage='Opportunity';
										}
										
										if(trim($f['current_stage'])=='2'){
											$cstage='Discussion';
										}
										
										if(trim($f['current_stage'])=='3'){
											$cstage='Sampling';
										}
										
										
										if(trim($f['status'])=='open'){
											//echo '<td align="center"><span class="label label-success">O</span></td>';

											echo '<td>'.$cstage.'</td>';

											echo '<td width="8%">';
											echo '<a href="fld-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue"><i class="icon-edit"></i>Update</a>';
											echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
				
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