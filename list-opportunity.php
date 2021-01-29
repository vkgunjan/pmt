<?php 
	        
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
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>List of All Deal at Opportunity</h4>
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
										<a href="add-opportunity.php">
                                        <button class="btn green">
										Add New Opportunity <i class="icon-plus"></i>
										</button>
                                        </a>
									</div>
                                    	&nbsp;&nbsp;&nbsp;							
<?php /*?>										<font color="#000000"><span class="label label-success">O</span> - Open</font><?php */?>
										&nbsp;
<?php /*?>										<font color="#000000"><span class="label label-warning">C</span> - Close</font>
										&nbsp;
									<font color="#000000"><span class="label label-important">L</span> - Lost</font>
					
<?php */?>	
                    
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Print</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<div class="scrollable">
								<table class="table table-striped table-bordered table-hover" id="sample_1" >

									<thead style="white-space: nowrap; padding: 0px;">
										<tr>
											<!--<th>Lead ID</th>-->
                                            <th width="1%">#</th>
                                            <th width="10%">Lead ID</th>
                                            <th width="10%">Account Name</th>
											<!--<th >CKA Type</th>-->
										<!--	<th >Project Type</th>-->
											<th width="10%">Project Name</th>
											<th width="5%">Project Type</th>
											<th width="5%">City</th>
											<!--<th width="2%">Territory</th>-->

											<!--<th >Architect Name</th>-->
                                          <!--  <th>Tile Stage Date</th>-->
                                            <th width="5%">OBL Forecast (INR Lac)</th>
											<th width="5%">Tile Potential(SQMT)</th>
                                            <!--<th>Status</th>-->
											<th width="5%">Tiling Date</th>
											<th width="5%">Generated By</th>
											<th width="5%">Lead Source</th>                                            
											<!--<th width="5%">Modified By</th>-->                                                                                        
<!--                                            <th>Status</th>
-->                                         <th width="5%">Sales Phase</th>
                                            <th width="5%">Action</th>
                                        </tr>

									</thead>
									<tbody style="white-space: nowrap;">
									
       <?php
		$sql="SELECT 
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
	 d.deal_type,
	 d.territory,
	 d.current_stage,
	 d.gps_department_name,
	 d.project_tile_potential_sqm,
	 d.modified_by,
	 u.fullname,
	 u.employee_department,
	 t.territory_name,
	 d.lead_approval_status,
	 d.lead_code
  FROM [opportunity] d
  left join cka_name_master a on a.cka_name_id = d. cka_name_id
  left join cka_type_master b on b.cka_type_id = d.cka_type_id
  left join project_type_master c on c.project_type_id = d.project_type_id
  left join state_master e on e.state_id = d.state_id 
  left join user_management u on d.created_by = u.uid 
  left join territory_master t on t.territory_id = d.territory 
  ";
  
    if(trim($_SESSION['user_type'])=='management') {
		$sql.="  where d.current_stage='1' and d.status='open' order by d.added_date desc ";
	}else{
			/*if($_SESSION['employee_department']=='Retail'){
				$sql.=" where d.deal_type='Retail' 
						and d.territory in (".$_SESSION['employee_territory'].") 
						and d.current_stage='1' 
						and status='open' 
						order by d.added_date desc";
			}*/


			if($_SESSION['employee_department']=='CKA'){
//vks start
					if($_SESSION['user_type']=='manager'){
					
					$sql.=" where d.current_stage='1' 
						and d.status='open' 
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
						$sql .=" )order by d.added_date asc";
					}else{
						$sql.=" where ( d.deal_type='CKA' 
						and d.current_stage='1' 
						and d.status='open' 
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

						$sql .=" )order by d.added_date desc";
					}

//vks ends

					
				
				//echo $sql;
			}

			if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where d.current_stage='1' 
						and d.status='open' 
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
						$sql .=" )order by d.added_date desc";
					}else{
						$sql.="  where d.current_stage='1' and d.status='open' and d.created_by='".$_SESSION['uid']."' 
						order by d.added_date desc";	
					}

			}
		
	}


	//echo $sql;
	
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										if ($f['lead_approval_status'] == 0) {
											echo '<td>'.$f['lead_id'].'</td>';
										}elseif($f['lead_approval_status'] == 2) {
											echo '<td style="color:red;">Rejected by BH</td>';
										}else{
											echo '<td style="color:orange;">Pending for Approval</td>';
										}
										echo '<td>'.$f['cka_name'].'</td>';
										//echo '<td>'.$f['cka_type'].'</td>';										

										echo '<td>'.substr(ucfirst($f['project_name']),0,30).'</td>';	
										echo '<td>'.trim($f['project_type']).'</td>';	
																									
										//echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.ucfirst(trim($f['city'])).'</td>';
										//echo '<td width="5%">'.$f['territory_name'].'</td>';

										//echo '<td>'.$f['architect_name'].'</td>';
										//echo '<td>'.$f['tile_stage_date'].'</td>';
										
										//echo '<td>'.valchar(trim($f['obl_sale_forecast_inr'])).'</td>';
										echo '<td>'.number_format(trim($f['obl_sale_forecast_inr']/100000),0).'</td>';
										echo '<td>'.trim($f['project_tile_potential_sqm']).'</td>';
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
			echo '<td width="7%">';
				if(trim($f['lead_approval_status'])=='2'){
				echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
			}elseif(($_SESSION['user_type'] == 'manager') && ($f['lead_approval_status'])=='1'){
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
				echo '<a href="http://pmt.orientapps.com/pmt/lead-approve.php?ld='.$f['lead_id'].'&code='.$f['lead_code'].'" target="_blank" class="btn mini green no-print"><font color="#fff">Approve</font></a>';
			}else{
				//echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print">History</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
			}

				echo '</td>';

										}
									/*									
										if(trim($f['status'])=='close'){
											echo '<td align="center"><span class="label label-warning">C</span></td>';

											echo '<th>'.$cstage.'</th>';
			echo '<td >';
				echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue"><i class="icon-edit"></i> Edit</a>';
			echo '</td>';

										}
										*/
										
										if(trim($f['status'])=='lost'){
											echo '<td align="center"><span class="label label-important">L</span></td>';
											
											echo '<th>'.$cstage.'</th>';
			echo '<td >';
				echo '<a href="#add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini grey"><i class="icon-edit"></i>Edit</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
				
			echo '</td>';

										}
						//echo '<a href="asset-master.php?delid='.$f['asset_id'].'" class="btn mini red"><i class="icon-trash"></i> Delete</a>';
						//echo '&nbsp;';		


										
										
																					

	
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