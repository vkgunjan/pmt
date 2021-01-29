<?php 
	
        include_once('including/all-include.php');
        include_once('including/header.php');
		unset($_SESSION['working-active-asset']);

?>
  
  
<script type="text/javascript">
	function PrintPage()
	{
	 window.print();
	}
</script>

<style>
@media print
{
    
    .no-print
    {
        display: none !important;
        height: 0;
    }

    .no-print, .no-print *{
        display: none !important;
        height: 0;
    }
}
</style>

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>List of All Lead Details</h4>
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
										<!-- button display area !-->
										<a href="add-opportunity.php">
                                        <button class="btn green" title="Add New Opportunity">
										Add New Opportunity <i class="icon-plus"></i>
										</button>
										</a>
									</div>
                                    	<?php
                 	if(trim($_SESSION['user_type'])=='management') {
					 $hsqa='SELECT [status], COUNT(*) as no FROM opportunity  GROUP BY [status]';
					}else{
					 $hsqa='SELECT [status], COUNT(*) as no FROM opportunity where created_by='.$_SESSION['uid'].' GROUP BY [status]';
					}
										$hee=odbc_exec($conn,$hsqa);
										while($hxx=odbc_fetch_array($hee)){
										
											if(trim($hxx['status'])=='close'){
												$w=$hxx['no'];
											}
										
											if(trim($hxx['status'])=='open'){
												$o=$hxx['no'];
											}
										
											if(trim($hxx['status'])=='lost'){
												$l=$hxx['no'];
											}
										
										}
										?>
                                        					
<table border="1" width="100%" style="border:1px solid #CCC; background-color:#efefef; font:13px Verdana, Geneva, sans-serif;">
<form action="list-all-lead.php" method="get">
<tr>
	<td colspan="8">&nbsp;</td>
</tr>

<tr>
	<th>Account Name <br />
    <input type="text" name="account_name" value="<?php echo $_GET['account_name']?>" style="width:200px; background-color:<?php echo (!empty($_GET['account_name']))?'#d6f5d6':'' ?>"/>
    </th>
    <th>Lead ID <br />
    <input type="text" name="lead_id" value="<?php echo $_GET['lead_id']?>" style="width:200px; background-color:<?php echo (!empty($_GET['lead_id']))?'#d6f5d6':'' ?>"/>
    </th>	
	
    <th>Territory <br />
    <select multiple name="territory[]" style="width:155px; background-color:<?php echo (!empty($_GET['territory']))?'#d6f5d6':'' ?>" >
		<option value="">-All-</option>
	<?php
	    $sql="select * from territory_master";
		$rs=odbc_exec($conn,$sql);
		while($f = odbc_fetch_array($rs)){
		$selected=($f['territory_id']==$_GET['territory'])?'selected':'';
		echo '<option value="'.$f['territory_id'].'"'.$selected.'>'.$f['territory_name'].'</option>';
		}
	?>
    </select>
    </th>	
	
    <th>
 Sales Phase <br />
    <select multiple name="sales_phase[]" style="width:180px; background-color:<?php echo (!empty($_GET['sales_phase']))?'#d6f5d6':'' ?> ">
		<option value="" >-All-</option>
        		<option value="Opportunity" <?php echo ($_GET['sales_phase']=='Opportunity')?'selected':''?>>Opportunity</option>		
                <option value="Discussion" <?php echo ($_GET['sales_phase']=='Discussion')?'selected':''?>>Discussion</option>		
                <option value="Won" <?php echo ($_GET['sales_phase']=='Won')?'selected':''?>>Won</option>		
                <option value="Lost" <?php echo ($_GET['sales_phase']=='Lost')?'selected':''?>>Lost</option>
   		 </select>
    </th>	


	<th>
		Lead Source <br />
        <select multiple name="lead_source[]" style="width:120px; background-color:<?php echo (!empty($_GET['lead_source']))?'#d6f5d6':'' ?> ">
		<option value="">-All-</option>
        		<option value="GET" <?php echo ($_GET['lead_source']=='GET')?'selected':''?>>GET</option>		
                <option value="PET" <?php echo ($_GET['lead_source']=='PET')?'selected':''?>>PET</option>		
                <option value="SET" <?php echo ($_GET['lead_source']=='SET')?'selected':''?>>SET</option>
                <option value="CTU" <?php echo ($_GET['lead_source']=='CTU')?'selected':''?>>Corporate Tie Up</option>		
                <option value="Retail" <?php echo ($_GET['lead_source']=='Retail')?'selected':''?>>Retail</option>
	    </select>

	</th>

	<th>
	Zone <br />
        <select multiple name="zone[]" style="width:120px; background-color:<?php echo (!empty($_GET['zone']))?'#d6f5d6':'' ?> ">
		<option value="">-All-</option>
        		<option value="East" <?php echo ($_GET['zone']=='East')?'selected':''?>>East</option>		
                <option value="North&Central" <?php echo ($_GET['zone']=='North&Central')?'selected':''?>>North and Central</option>		
                <option value="South" <?php echo ($_GET['zone']=='South')?'selected':''?>>South</option>		
                <option value="West" <?php echo ($_GET['zone']=='West')?'selected':''?>>West</option>
	    </select>

    </th>


</tr>

<tr>
	<th>Tiling Date <br />
    	<input class="m-wrap m-ctrl-medium date-range" size="16" type="text"  name="tile_stage_date" value="<?php echo $_GET['tile_stage_date']?>" style="background-color:<?php echo (!empty($_GET['tile_stage_date']))?'#d6f5d6':'#FFF' ?>"/>
    </th>	
    <th>Generated Date <br />
 		<input class="m-wrap m-ctrl-medium date-range" size="16" type="text"  name="generated_date" value="<?php echo $_GET['generated_date']?>" style="background-color:<?php echo (!empty($_GET['generated_date']))?'#d6f5d6':'#FFF' ?>"/>
    </th>	
    <th>Generated By <br />
    	<input type="text"  name="generated_by" value="<?php echo $_GET['generated_by']?>" style="width:120px; background-color:<?php echo (!empty($_GET['generated_by']))?'#d6f5d6':'' ?> "/>
    </th>	
    <th>City <br />
    	<input type="text"   name="city" value="<?php echo $_GET['city']?>" style="width:120px; background-color:<?php echo (!empty($_GET['city']))?'#d6f5d6':'' ?>" />
    </th>
    <th>Source <br />
    	<select multiple name="pmt_lead_source[]" style="width:120px; background-color:<?php echo (!empty($_GET['pmt_lead_source']))?'#d6f5d6':'' ?> ">
		<option value="">-All-</option>
        		<option value="PMT" <?php echo ($_GET['pmt_lead_source']=='PMT')?'selected':''?>>PMT</option>		
                <option value="Marketing" <?php echo ($_GET['pmt_lead_source']=='Marketing')?'selected':''?>>Marketing</option>		
                <option value="99AC" <?php echo ($_GET['pmt_lead_source']=='99AC')?'selected':''?>>99 Acres</option>		
                
	    </select>
    </th>	
    <th>
    	<input type="submit" value=" &#128269 Show" name="show_result" id="show_result" />
    	<a href="list-all-lead.php"><input type="button" value="View All" name="viewall" /></a>
    </th>	    

</tr>

</form>
</table>
<?php
		$sql="SELECT 
		o.opportunity_id,
		o.lead_id,
		d.deal_type,
		s.deal_sub_type,
		c.cka_name,
		p.project_type,
		ps.project_sub_type,
		o.project_name,
		st.zone,
		st.state_name,
		t.territory_name,
		o.city,
		o.address,
		o.contractor_firm_name,
		o.project_contact_name,
		o.project_contact_no,
		o.architect_firm_name,
		o.architect_name,
		cp.p_name,
		o.contractor_name, 
		o.tile_stage_date,
		o.project_tile_potential_sqm,
		o.project_tile_potential_inr,
		o.obl_sales_forecast_sqmt,
		o.obl_sale_forecast_inr,
		o.probability_of_win,
		o.status,
		pc.stage_name,
		o.lead_source,
		o.fld_remark,
		o.spl_remark,
		o.ng_remark,
		o.lead_approval_remark,
		o.lead_reject_remark,
		o.qt_approval_remark,
		o.qt_reject_remark,
		o.sp_approval_remark,
		o.sp_reject_remark,
		o.lead_approve_date,
		o.lead_reject_date,
		o.sampling_date,
		o.sp_approve_date,
		o.sp_reject_date,
		o.product_approval_date,
		o.quotation_date,
		o.qt_approve_date,
		o.qt_reject_date,
		o.added_date,
		u.last_login,
		o.last_modified,
		u.fullname as [created_by],
		um.fullname as [manager_name],
		u.employee_department,
		l.status_name as [ld_status],
		sa.app_status as [sp_status],
		qs.app_status as [qt_status]
		





		from opportunity o
		
		left join app_status qs on qs.app_status_id = o.quotation_status
		left join app_status sa on sa.app_status_id = o.sampling_status
		left join lead_status_master l on l.status_id = o.lead_approval_status
		left join deal_type d on d.deal_type_id = o.deal_type
		left join deal_sub_type s on s.deal_sub_type_id = o.sub_type
		left join cka_name_master c on c.cka_name_id = o.cka_name_id
		left join project_type_master p on p.project_type_id = o.project_type_id
		left join project_sub_type_master ps on ps.project_sub_type_id = o.project_sub
		left join state_master st on st.state_id = o.state_id
		left join territory_master t on t.territory_id = o.territory
		left join channel_partner cp on cp.p_id = o.partner
		left join pmt_current_stage pc on pc.stage_id = o.current_stage
		left join user_management u on u.uid = o.created_by
		left join user_management um on um.uid = (select parent_id from user_management where uid = o.created_by)
  
  
  ";
  
    if(trim($_SESSION['user_type'])=='management') {
		$sql.="  where 1=1  ";
	}else{

			if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where 1=1 
						and ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$sql.=" o.created_by = '".$vx."' or o.created_by='".$_SESSION['uid']."' ";
							else
								$sql .=" or o.created_by = '".$vx."' ";
							$xcnt++;
						}
						$sql.=" ) ";
					}else{
						$sql.=" where o.created_by='".$_SESSION['uid']."' 
						 ";	
					}

			}
		
	}

//SEARCH QUERY BUILDING START
if(isset($_GET['show_result']) && !empty($_GET['show_result'])){

	if($_GET['account_name']){
			$sql.=" and c.cka_name like '%".$_GET['account_name']."%' ";		
	}
	if($_GET['lead_id']){
			$sql.=" and o.lead_id like '%".$_GET['lead_id']."%' ";		
	}

	if($_GET['city']){
			$sql.=" and o.city like '%".$_GET['city']."%' ";		
	}
	

	if(isset($_GET['territory']) && sizeof($_GET['territory'])>0 && $_GET['show_result']!='true'){
			$csp=0;
			foreach ($_GET['territory'] as $tsp){
				//echo $sp;
						if($csp >0){
							$sql.=" or o.territory ='".$tsp."'  ";		
						}else{
							$sql.=" and ( o.territory ='".$tsp."'  ";		
						}
				$csp++;
			}

			$sql.=" ) ";

	}else{
			if(!empty($_GET['territory']) && strlen(trim($_GET['territory'])>0) && $_GET['show_result']=='true' ){
			
					$sql.=" and o.territory ='".$_GET['territory']."'  ";		
			}
	}

	
	if(isset($_GET['sales_phase']) && sizeof($_GET['sales_phase'])>0 && $_GET['show_result']!='true'){
			$csp=0;
			foreach ($_GET['sales_phase'] as $sp){
				//echo $sp;
					if($sp == 'Lost'){
						$sql.=" and o.status = 'lost' ";		
					}else{
						if($csp != 'lost'){
							$sql.=" or pc.stage_name ='".$sp."' and o.status <> 'lost' ";		
						}else{
							$sql.=" and ( pc.stage_name ='".$sp."' and o.status <> 'lost' ";		
						}
					}
				$csp++;
			}

			$sql.=" ) ";

	}else{
			if(!empty($_GET['sales_phase']) && strlen(trim($_GET['sales_phase'])>0) && $_GET['show_result']=='true' ){
			
				if($_GET['sales_phase'] == 'lost'){
					$sql.=" and o.status = 'lost' ";		
				}else{
		
					$sql.=" and pc.stage_name ='".$_GET['sales_phase']."' and o.status != 'lost' ";		
				}
			}
	}



	if(isset($_GET['lead_source']) && sizeof($_GET['lead_source'])>0 && $_GET['show_result']!='true'){
			$csp=0;
			foreach ($_GET['lead_source'] as $tsp){
				//echo $sp;
						if($csp >0){
							$sql.=" or u.employee_department ='".$tsp."'  ";		
						}else{
							$sql.=" and ( u.employee_department ='".$tsp."'  ";		
						}
				$csp++;
			}

			$sql.=" ) ";

	}else{
			if(!empty($_GET['lead_source']) && strlen(trim($_GET['lead_source'])>0) && $_GET['show_result']=='true' ){
			
					$sql.=" and u.employee_department ='".$_GET['lead_source']."'  ";		
			}
	}
	

	if(isset($_GET['zone']) && sizeof($_GET['zone'])>0 && $_GET['show_result']!='true'){
			$csp=0;
			foreach ($_GET['zone'] as $tsp){
				//echo $sp;
						if($csp >0){
							$sql.=" or st.zone ='".$tsp."'  ";		
						}else{
							$sql.=" and ( st.zone='".$tsp."'  ";		
						}
				$csp++;
			}

			$sql.=" ) ";

	}else{
			if(!empty($_GET['zone']) && strlen(trim($_GET['zone'])>0) && $_GET['show_result']=='true' ){
			
					$sql.=" and st.zone='".$_GET['zone']."'  ";		
			}
	}
	
	/*pmt lead source*/

	if(isset($_GET['pmt_lead_source']) && sizeof($_GET['pmt_lead_source'])>0 && $_GET['show_result']!='true'){
			$csp=0;
			foreach ($_GET['pmt_lead_source'] as $tsp){
				//echo $sp;
						if($csp >0){
							$sql.=" or o.lead_source ='".$tsp."'  ";		
						}else{
							$sql.=" and ( o.lead_source='".$tsp."'  ";		
						}
				$csp++;
			}

			$sql.=" ) ";

	}else{
			if(!empty($_GET['lead_source']) && strlen(trim($_GET['lead_source'])>0) && $_GET['show_result']=='true' ){
			
					$sql.=" and o.lead_source='".$_GET['lead_source']."'  ";		
			}
	}

	/*pmt lead source end*/


	if($_GET['generated_by']){
		$sql.=" and u.fullname like '%".$_GET['generated_by']."%' ";		
	}


	if($_GET['tile_stage_date']){

		$dr=explode("-",$_GET['tile_stage_date']);
		//print_r($e);
		
		$from=explode("/",$dr[0]);
		//print_r($from);
		$fromdate=trim($from[2]).'/'.trim($from[0]).'/'.trim($from[1]);
		
		
		$to=explode("/",$dr[1]);
		$todate=trim($to[2]).'/'.trim($to[0]).'/'.trim($to[1]);
		//print_r($to);
	
		 $sql.=" and o.tile_stage_date between '".$fromdate."' and '".$todate."' ";		
	}

	if($_GET['generated_date']){

		$dr=explode("-",$_GET['generated_date']);
		//print_r($e);
		
		$from=explode("/",$dr[0]);
		//print_r($from);
		$fromdate=trim($from[2]).'/'.trim($from[0]).'/'.trim($from[1]);
		
		
		$to=explode("/",$dr[1]);
		$todate=trim($to[2]).'/'.trim($to[0]).'/'.trim($to[1]);
		//print_r($to);
	
		 $sql.=" and o.added_date between '".$fromdate."' and '".$todate."' ";		
	}

	

}


			$sql.=" order by o.added_date desc ";									
			
			$pipelineTotal=0;
			$sqaureTotal = 0;
			$rsData=odbc_exec($conn,$sql);
			$countTotal=1;
			while($rowdata = odbc_fetch_array($rsData)) {
				$pipelineTotal = $rowdata['obl_sale_forecast_inr'] + $pipelineTotal;
				$sqaureTotal = round($rowdata['project_tile_potential_sqm'],2) + $sqaureTotal;
				$countTotal++;
			}

			/*if($rsData){

			header('location:exportdatasummary.php?val='.base64_encode($sql));
			exit;
			}*/
			
	?>

	<div style="background-color:#4b8df8; height:40px;">
	</div>
                   <div style="text-align:center;">
				   
				   
										<ul class="breadcrumb">
							<li>
								
								<font size="4">Pipeline (All) : <b><?php echo valchar($pipelineTotal)?></b> </font>
								
							</li>
								
							<li style="margin-left:50px;"><font size="4">Avg. Deal : <b><?php echo valchar(round($pipelineTotal/$countTotal)); ?> </b></font></li>&nbsp;
							
							<li style="margin-left:50px;"><font size="4">Tiles In (SQMT) : <b><?php echo valchar(round($sqaureTotal))?></b> </font></li>
							<li style="margin-left:50px;"><font size="4">No of Leads : <b><?php echo ($countTotal-1)?></b> </font></li>
							<li class="pull-right no-text-shadow">
								<div style="margin-top:-14px; padding:8px; padding-bottom:7px; color:#FFF;">
									<div class="btn-group">
										<!-- button display area !-->
								
									<a href="exportdatasummary.php?val=<?php echo base64_encode($sql); ?>">
                                        <button class="btn green" title="Download PMT Lead Summary Report">
										Export Data &nbsp;<i class="icon-angle-right"></i>
										</button>
										</a>
									

									

									</div>
									<!-- <form action="export_new.php?val=<?php echo base64_encode($sql); ?>" method="post">
										<input type="submit" class="btn green" name="export" value="Export">
									</form> -->
								</div>
							</li>
		
        				
                      
                        </ul>
						
									</div>
									
									
								</div>
								<table class="table table-striped table-hover table-bordered table-responsive" id="sample_1" >

									<thead>
										<tr>
											<!--<th>Lead ID</th>-->
                                            <th width="1%">#</th>
                                            <th width="1%">Lead ID</th>
                                            <th width="8%">Account Name</th>
											<!--<th >CKA Type</th>-->
										<!--	<th >Project Type</th>-->
											<th width="8%">Project Name</th>
											<th width="8%">Contractor Firm</th>
											<th width="5%">Project Type</th>
											<th width="5%">City</th>
											<th width="2%">Territory</th>
											<!-- <th width="2%">Approval Status</th> -->
											<!--<th >Architect Name</th>-->
                                          <!--  <th>Tile Stage Date</th>-->
                                            <th width="8%">OBL Forecast (INR Lac)</th>
                                            <!--<th>Status</th>-->
											<th width="5%">Tiling Date</th>
                                            <th width="5%">Generated Date</th>
											<th width="5%">Generated By</th>
											<th width="5%">Manager Name</th>
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
										$quotation_status = $f['quotation_status'];
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										if ($f['ld_status'] == "Approved") {
											echo '<td title="'.$f['lead_id'].'">'.$f['lead_id'].'</td>';
										}elseif($f['ld_status'] == "Rejected") {
											echo '<td title="Rejected by BH" style="color:red;">Rejected by BH</td>';
										}else{
											echo '<td title="Pending for Approval" style="color:orange;">Pending for Approval</td>';
										}
										
										echo '<td title="'.ucfirst($f['cka_name']).'">'.$f['cka_name'].'</td>';
										echo '<td class="highlight">';
										echo '<a href=lead-history.php?pid='.$f['opportunity_id'].' title="'.ucfirst($f['project_name']).'">'.substr(ucfirst($f['project_name']),0,30).'</a>';
										echo '</td>';	
										echo '<td title="'.$f['contractor_firm_name'].'">'.trim($f['contractor_firm_name']).'</td>';
										echo '<td title="'.$f['project_type'].'">'.trim($f['project_type']).'</td>';	
										echo '<td title="'.ucfirst(trim($f['city'])).'">'.ucfirst(trim($f['city'])).'</td>';
										echo '<td title="'.$f['territory_name'].'" width="5%">'.substr($f['territory_name'],0,10).'</td>';
										echo '<td title="'.$f['obl_sale_forecast_inr'].'">'.number_format(trim($f['obl_sale_forecast_inr']/100000),0).'</td>';
										echo '<td title="'.date('F j, Y',strtotime(trim($f['tile_stage_date']))).'" width="9%">'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';
										echo '<td title="'.date('F j, Y, g:i A',strtotime(trim($f['added_date']))).'" width="9%">'.date('d-m-Y',strtotime(trim($f['added_date']))).'</td>';
										echo '<td title="'.$f['created_by'].'">'.$f['created_by'].'</td>';
										echo '<td title="'.$f['manager_name'].'">'.$f['manager_name'].'</td>';
										echo '<td title="'.$f['employee_department'].'">'.$f['employee_department'].'</td>';
			

						if(trim($f['status']) == 'open'){

								if(trim($f['stage_name'])=='Opportunity'){
											$cstage='Opportunity';
											echo '<th>'.$cstage.'</th>';

			echo '<td >';
				if(trim($f['lead_approval_status'])=='Rejected'){
				echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
			}else{
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
			}
				
										}
										
							if(trim($f['stage_name'])=='Discussion'){
							$cstage='Discussion';

				echo '<th><a href="fld-submit.php?pid='.$f['opportunity_id'].'">'.$cstage.'</a></th>';
				echo '<td >';
				echo '<a href="edit-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini purple no-print">Edit</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
										}
										
							if(trim($f['stage_name'])=='Won'){
							$cstage='Won';

				echo '<th>'.$cstage.'</th>';
				echo '<td >';
				echo '<a href="supply-plan-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue" style="width:73px;"><i class="icon-edit"></i> Supply Plan</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
				echo '</td>';
										}

								}
										
										
										if(trim($f['status'])=='lost'){
											$cstage='Lost';
				echo '<th>'.$cstage.'</th>';
				echo '<td >';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
				echo '</td>';
								}
										
										if(trim($f['status'])=='close'){
											$cstage='Won';
											
				echo '<th>'.$cstage.'</th>';
				echo '<td >';
				echo '<a href="supply-plan-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue" style="width:73px;"><i class="icon-edit"></i> Supply Plan</a>';
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