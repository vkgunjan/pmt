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
						<div class="portlet box" style="background-color: #00897B;">
							<div class="portlet-title">
								<h4><i class="icon-edit" style="color: #fff;"></i>List of All Lead Details</h4>
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
                                        <button class="btn" style="background-color: #26A69A;color: #fff;" title="Add New Opportunity">
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
                                        					

	

<form action="list-all-lead.php" method="get">
<!-- <tr>
	<td colspan="8">&nbsp;</td>
</tr> -->

<div class="controls controls-row">
	
    <input class="span2 m-wrap" type="text" name="account_name" placeholder="Account Name" value="<?php echo $_GET['account_name']?>" style=" background-color:<?php echo (!empty($_GET['account_name']))?'#d6f5d6':'' ?>"/>
    
    <input type="text" class="span2 m-wrap" name="lead_id" placeholder="Lead ID" value="<?php echo $_GET['lead_id']?>" style="background-color:<?php echo (!empty($_GET['lead_id']))?'#d6f5d6':'' ?>"/>
    
    <select name="territory" class="span2 m-wrap">
		<option value=""> -Territory- </option>
	<?php
	    $sql="select * from territory_master order by territory_name asc";
		$rs=odbc_exec($conn,$sql);
		while($f = odbc_fetch_array($rs)){
		$selected=($f['territory_name']==$_GET['territory'])?'selected':'';
		echo '<option value="'.$f['territory_name'].'"'.$selected.'>'.$f['territory_name'].'</option>';
		}
	?>
    </select>
    
 
 <select name="sales_phase" class="span2 m-wrap">
    
		<option value="" > -Sales Phase- </option>
        		<option value="Opportunity" <?php echo ($_GET['sales_phase']=='Opportunity')?'selected':''?>>Opportunity</option>		
                <option value="Discussion" <?php echo ($_GET['sales_phase']=='Discussion')?'selected':''?>>Discussion</option>		
                <option value="Won" <?php echo ($_GET['sales_phase']=='Won')?'selected':''?>>Won</option>		
                <option value="Lost" <?php echo ($_GET['sales_phase']=='Lost')?'selected':''?>>Lost</option>
   		 </select>
    
		
		<select name="lead_source" class="span2 m-wrap">
        
		<option value=""> -Lead Source- </option>
        		<option value="GET" <?php echo ($_GET['lead_source']=='GET')?'selected':''?>>GET</option>		
                <option value="PET" <?php echo ($_GET['lead_source']=='PET')?'selected':''?>>PET</option>		
                <option value="SET" <?php echo ($_GET['lead_source']=='SET')?'selected':''?>>SET</option>
                <option value="CTU" <?php echo ($_GET['lead_source']=='CTU')?'selected':''?>>Corporate Tie Up</option>		
                <option value="Retail" <?php echo ($_GET['lead_source']=='Retail')?'selected':''?>>Retail</option>
	    </select>

	
	
	<select name="zone" class="span2 m-wrap">
        
		<option value=""> -Zone- </option>
        		<option value="East" <?php echo ($_GET['zone']=='East')?'selected':''?>>East</option>		
                <option value="North&Central" <?php echo ($_GET['zone']=='North&Central')?'selected':''?>>North and Central</option>		
                <option value="South" <?php echo ($_GET['zone']=='South')?'selected':''?>>South</option>		
                <option value="West" <?php echo ($_GET['zone']=='West')?'selected':''?>>West</option>
	    </select>

  </div>

  <div class="controls controls-row">
    	<input placeholder="Tiling Date"  class=" span2 m-wrap m-ctrl-medium date-range" size="16" type="text"  name="tile_stage_date" value="<?php echo $_GET['tile_stage_date']?>" style="height: 16px;background-color:<?php echo (!empty($_GET['tile_stage_date']))?'#d6f5d6':'#FFF' ?>"/>
    
 		<input placeholder="Generated Date" class=" span2 m-wrap m-ctrl-medium date-range" size="16" type="text"  name="generated_date" value="<?php echo $_GET['generated_date']?>" style="height: 16px;background-color:<?php echo (!empty($_GET['generated_date']))?'#d6f5d6':'#FFF' ?>"/>
  
    	<input placeholder="Generated By" type="text" class="span2 m-wrap"  name="generated_by" value="<?php echo $_GET['generated_by']?>" style=" background-color:<?php echo (!empty($_GET['generated_by']))?'#d6f5d6':'' ?> "/>
    
    	<input placeholder="City" type="text" class="span2 m-wrap"   name="city" value="<?php echo $_GET['city']?>" style="background-color:<?php echo (!empty($_GET['city']))?'#d6f5d6':'' ?>" />
    
    	<select name="pmt_lead_source" class="span2 m-wrap">
    	
		<option value=""> -Source- </option>
        		<option value="PMT" <?php echo ($_GET['pmt_lead_source']=='PMT')?'selected':''?>>PMT</option>		
                <option value="Marketing" <?php echo ($_GET['pmt_lead_source']=='Marketing')?'selected':''?>>Marketing</option>		
                <option value="99AC" <?php echo ($_GET['pmt_lead_source']=='99AC')?'selected':''?>>99 Acres</option>		
                
	    </select>
    <div class="span2 m-wrap">
    	
    
    	<input class="btn" type="submit" value="Search!" name="show_result" id="show_result" />
    	<a href="list-all-lead.php"><input class="btn" type="button" style="background-color: #26A69A;color: #fff;" value="View All" name="viewall" /></a>
   	</div>
 </div>

</form>



<?php

$top = '';

		$sql="SELECT ";
		$sql.= $top;
		$sql.="  
		o.opportunity_id,
		o.lead_id,
		d.deal_type,
		s.deal_sub_type,
		c.cka_name,
		c.cka_category,
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
		o.project_specification,
		o.obl_specified,
		o.sku_specified,
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
		ug.employee_department as [support_asked_department],
		ug.fullname as [support_asked],
		u.employee_department,
		l.status_name as [ld_status],
		sa.app_status as [sp_status],
		qs.app_status as [qt_status],
		fl.fld_id
		





		from opportunity o
		left join fld fl on fl.opp_id = o.opportunity_id
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
		left join user_management ug on ug.uid = o.support_asked
  
  
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
								$sql.=" o.created_by = '".$vx."' or o.created_by='".$_SESSION['uid']."' or o.support_asked = '".$_SESSION['uid']."' ";
							else
								$sql.=" or o.created_by = '".$vx."' or o.support_asked = '".$vx."' ";
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
	

	if($_GET['territory']){

		$sql.=" and t.territory_name ='".$_GET['territory']."'  ";	

	}

	
	if($_GET['sales_phase']){
			
			
				//echo $sp;
					if($_GET['sales_phase'] == 'Lost'){
						$sql.=" and o.status = 'lost' ";		
					}else{
						$sql.=" and ( pc.stage_name ='".$_GET['sales_phase']."' and o.status <> 'lost' )";
						
					}	

	}



	if($_GET['lead_source']){
		$sql.=" and u.employee_department ='".$_GET['lead_source']."'  ";	
			

	}
	

	if($_GET['zone']){
		$sql.=" and st.zone ='".$_GET['zone']."'  ";
			
	}
	
	/*pmt lead source*/

	if($_GET['pmt_lead_source']){
		$sql.=" and o.lead_source ='".$_GET['pmt_lead_source']."'  ";
			

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

	<div style="background-color:#00897B; height:5px;">
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
                                        <button class="btn" style="background-color: #26A69A;color: #fff;" title="Download PMT Lead Summary Report">
										Export Data &nbsp;<i class="icon-signout" style="color: white;"></i>
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
								<div class="scrollable">
								<table class="table table-striped table-bordered table-hover" id="sample_1" >

									<thead style="white-space: nowrap; padding: 0px;">
										<tr>
											<!--<th>Lead ID</th>-->
                                            <th>#</th>
                                            <th> Action</th>
                                            <th>Lead ID</th>
                                            <th>Account Name</th>
											<!--<th >CKA Type</th>-->
										<!--	<th >Project Type</th>-->
											<th>Project Name</th>
											<th>Contractor Firm</th>
											<th>Project Type</th>
											<th>City</th>
											<th>Territory</th>
											<!-- <th width="2%">Approval Status</th> -->
											<!--<th >Architect Name</th>-->
                                          <!--  <th>Tile Stage Date</th>-->
                                            <th>OBL Forecast (INR Lac)</th>
                                            <!--<th>Status</th>-->
											<th>Tiling Date</th>
                                            <th>Generated Date</th>
											<th>Generated By</th>
											<th>Manager Name</th>
											<th>Lead Source</th>                                            
											<!--<th width="5%">Modified By</th>-->                                                                                        
<!--                                            <th>Status</th>
-->                                            <th>Sales Phase</th>
											
                                            <th> Action</th>
                                        </tr>
									</thead>
									<tbody style="white-space: nowrap;">
									
      <?php 
//echo $sql;
	
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										$quotation_status = $f['quotation_status'];
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count++.'</td>';

/*Adding action status*/
if(trim($f['status']) == 'open'){

								if(trim($f['stage_name'])=='Opportunity'){
											$cstage='Opportunity';
											/*echo '<th>'.$cstage.'</th>';*/

			echo '<td >';
				if(trim($f['ld_status'])=='Rejected'){
				echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" title="Re-Submit Lead"><i style="padding:0px 12px; font-size:19px;" class="icon-pencil"></i></a>';
				/*echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'"><i style="padding:5px 7px;" class="icon-info-sign"></i></a>';*/
			}else{
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" title="Lead Details"><i style="padding:0px 12px; font-size:19px;" class="icon-info-sign"></i></a>';
			}
				
										}
										
							if(trim($f['stage_name'])=='Discussion'){
							$cstage='Discussion';

				/*echo '<th><a href="fld-submit.php?pid='.$f['opportunity_id'].'">'.$cstage.'</a></th>';*/
				echo '<td >';
				echo '<a href="edit-opportunity.php?pid='.$f['opportunity_id'].'" title="Edit Lead Info"><i style="padding:0px 12px; font-size:19px;" class="icon-edit"></i></a>';
				/*echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" title="Details"><i style="padding:5px 7px;" class="icon-info-sign"></i></a>';*/
										}
										
							if(trim($f['stage_name'])=='Won'){
							$cstage='Won';

				/*echo '<th>'.$cstage.'</th>';*/

										echo '<td >';
										echo '<a href="supply-plan-submit.php?pid='.$f['opportunity_id'].'" title="Add Supply Plan"><i style="padding:0px 12px; font-size:19px;"  class="icon-share"></i></a>';
										/*echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'"><i style="padding:5px 7px;" class="icon-info-sign"></i></a>';*/
										echo '</td>';
																}

														}
																
																
																if(trim($f['status'])=='lost'){
																	$cstage='Lost';
										/*echo '<th>'.$cstage.'</th>';*/
										echo '<td >';
										echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" title="Lead Details"><i style="padding:0px 12px; font-size:19px;" class="icon-info-sign"></i></a>';
										echo '</td>';
														}
																
																if(trim($f['status'])=='close'){
																	$cstage='Won';
																	
										/*echo '<th>'.$cstage.'</th>';*/
										echo '<td >';
										echo '<a href="supply-plan-submit.php?pid='.$f['opportunity_id'].'" title="Add Supply Plan"><i style="padding:0px 12px; font-size:19px;" class="icon-share"></i></a>';
										/*echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" title="Lead Details"><i style="padding:5px 15px;" class="icon-info-sign"></i></a>';*/
										echo '</td>';

									}

/*Adding action status end*/




										if ($f['ld_status'] == "Approved") {
											echo '<td title="'.$f['lead_id'].'"><a href=lead-history.php?pid='.$f['opportunity_id'].' title="'.($f['lead_id']).'">'.$f['lead_id'].'</a></td>';
										}elseif($f['ld_status'] == "Rejected") {
											echo '<td title="Rejected by BH" style="color:red;">Rejected by BH</td>';
										}else{
											echo '<td title="Pending for Approval" style="color:orange;">Pending for Approval</td>';
										}
										
										echo '<td title="'.ucfirst($f['cka_name']).'">'.$f['cka_name'].'</td>';
										echo '<td class="highlight">';
										echo '<a href=lead-history.php?pid='.$f['opportunity_id'].' title="'.ucfirst($f['project_name']).'">'.(strlen($f['project_name']) > 30 ? substr($f['project_name'],0,30)."..." : $f['project_name']).'</a>';
										echo '</td>';	
										echo '<td title="'.$f['contractor_firm_name'].'">'.trim($f['contractor_firm_name']).'</td>';
										echo '<td title="'.$f['project_type'].'">'.trim($f['project_type']).'</td>';	
										echo '<td title="'.ucfirst(trim($f['city'])).'">'.ucfirst(trim($f['city'])).'</td>';
										echo '<td title="'.$f['territory_name'].'"><a href="list-all-lead.php?territory='.$f['territory_name'].'&show_result=Search">'.substr($f['territory_name'],0,18).'</a></td>';
										echo '<td title="'.$f['obl_sale_forecast_inr'].'">'.number_format(trim($f['obl_sale_forecast_inr']/100000),0).'</td>';
										echo '<td title="'.date('F j, Y',strtotime(trim($f['tile_stage_date']))).'" width="9%">'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';
										echo '<td title="'.date('F j, Y, g:i A',strtotime(trim($f['added_date']))).'" width="9%">'.date('d-m-Y',strtotime(trim($f['added_date']))).'</td>';
										echo '<td title="'.$f['created_by'].'"><a href="list-all-lead.php?generated_by='.$f['created_by'].'&show_result=Search">'.$f['created_by'].'</a></td>';
										echo '<td title="'.$f['manager_name'].'">'.$f['manager_name'].'</td>';
										echo '<td title="'.$f['employee_department'].'">'.$f['employee_department'].'</td>';






			

						if(trim($f['status']) == 'open'){

								if(trim($f['stage_name'])=='Opportunity'){
											$cstage='Opportunity';
											echo '<th>'.$cstage.'</th>';

			echo '<td >';
				if(trim($f['ld_status'])=='Rejected'){
				echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-pencil"></i> Re-Submit</a>';
				
			}else{
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><i class="icon-info-sign"></i> Details</a>';
			}
				
										}
										
							if(trim($f['stage_name'])=='Discussion' && $f['fld_id']>1){
							$cstage='Pricing';

				echo '<th><a href="fld-submit.php?pid='.$f['opportunity_id'].'">'.$cstage.'</a></th>';
				echo '<td >';
				echo '<a href="edit-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini purple no-print"><i class="icon-edit"></i> Edit</a>';
				
										}
				if(trim($f['stage_name'])=='Discussion' && $f['fld_id']<1){
							$cstage='Discussion';

				echo '<th><a href="fld-submit.php?pid='.$f['opportunity_id'].'">'.$cstage.'</a></th>';
				echo '<td >';
				echo '<a href="edit-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini purple no-print"><i class="icon-edit"></i> Edit</a>';
				
										}
										
							if(trim($f['stage_name'])=='Won'){
							$cstage='Won';

				echo '<th>'.$cstage.'</th>';
				echo '<td >';
				echo '<a href="supply-plan-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue" style="width:73px;"><i class="icon-edit"></i> Supply Plan</a>';
				
				echo '</td>';
										}

								}
										
										
										if(trim($f['status'])=='lost'){
											$cstage='Lost';
				echo '<th>'.$cstage.'</th>';
				echo '<td >';
								echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><i class="icon-info-sign"></i> Details</a>';
				echo '</td>';
								}
										
										if(trim($f['status'])=='close'){
											$cstage='Won';
											
				echo '<th>'.$cstage.'</th>';
				echo '<td >';
				echo '<a href="supply-plan-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue" style="width:73px;"><i class="icon-edit"></i> Supply Plan</a>';
				
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

