<?php 
	
	
	/*$sd='active';*/

        include_once('including/all-include.php');
        include_once('including/header.php');
		unset($_SESSION['working-active-asset']);
			
		//print_r($_SESSION);
//		print_r($_GET);
		
		
	//	echo '<br><br>';
		
		//echo ;

		

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
                                        <button class="btn green">
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
										//print_r($hxx);
										//echo '<br>';
											//echo $hxx['status'];
											//echo $hxx['no'];
											
											if(trim($hxx['status'])=='close'){
												$w=$hxx['no'];
											}
										
											if(trim($hxx['status'])=='open'){
												$o=$hxx['no'];
											}
										
											if(trim($hxx['status'])=='lost'){
												$l=$hxx['no'];
											}
										
											//echo $l;
										}
										?>
                                        
<?php /*?><span class="label label-success" style="font:14px Verdana; font-weight:lighter;">&nbsp;<?php echo ($w>0)?$w:'0'; ?>-Won&nbsp;</span>&nbsp;

<span class="label label-warning" style="font:14px Verdana;font-weight:lighter;">&nbsp;<?php echo ($o>0)?$o:'0'; ?>-Open&nbsp;</span>&nbsp;

<span class="label label-important" style="font:14px Verdana;font-weight:lighter;">&nbsp;<?php echo ($l>0)?$l:'0'; ?>-Lost&nbsp;</span>
<?php */?>					
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

	
    <!-- <th>
    	OBL Approval Status <br />
    	<select multiple name="obl_approval_status[]" style="width:230px; background-color:<?php echo (!empty($_GET['obl_approval_status']))?'#d6f5d6':'' ?>" >
    			<option value="">-All-</option>
    	                                     <option value="Brand Approved and SKU Approved" <?php echo ($_GET['obl_approval_status'])=='Brand Approved and SKU Approved' ? 'selected' : '' ?>>Brand Approved and SKU Approved</option>
    	
    	 <option value="Brand Approved and SKU In Process" <?php echo ($_GET['obl_approval_status'])=='Brand Approved and SKU In Process' ? 'selected' : '' ?>>Brand Approved and SKU In Process</option>
    	
    	 <option value="Brand Approval In Process" <?php echo ($_GET['obl_approval_status'])=='Brand Approval In Process' ? 'selected' : '' ?>>Brand Approval In Process</option>
    	
    	 <option value="Only SKU Approved" <?php echo ($_GET['obl_approval_status'])=='Only SKU Approved' ? 'selected' : '' ?>>Only SKU Approved</option>
    	
    	 <option value="Not Approved" <?php echo ($_GET['obl_approval_status'])=='Not Approved' ? 'selected' : '' ?>>Not Approved</option>
    	                                      
    										
    	                                </select>
    	</select>
    	</th> -->	

	
    <th>
Territory <br />
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
        		<option value="1" <?php echo ($_GET['sales_phase']=='1')?'selected':''?>>Opportunity</option>		
                <option value="2" <?php echo ($_GET['sales_phase']=='2')?'selected':''?>>Discussion</option>		
                <!-- <option value="3" <?php echo ($_GET['sales_phase']=='3')?'selected':''?>>Sampling</option>		
                		<option value="4" <?php echo ($_GET['sales_phase']=='4')?'selected':''?>>Product Approval</option>
                		        		<option value="5" <?php echo ($_GET['sales_phase']=='5')?'selected':''?>>Quotation</option>		
                		<option value="6" <?php echo ($_GET['sales_phase']=='6')?'selected':''?>>Negotiation</option> -->		
                <option value="7" <?php echo ($_GET['sales_phase']=='7')?'selected':''?>>Won</option>		
                <option value="8" <?php echo ($_GET['sales_phase']=='8')?'selected':''?>>Lost</option>
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
    <input type="text"   name="city" value="<?php echo $_GET['city']?>" style="width:120px; background-color:<?php echo (!empty($_GET['city']))?'#d6f5d6':'' ?>" /></th>	

	
    <th colspan="2">
    <input type="submit" value=" &#128269 Show" name="show_result" />
    <a href="list-all-lead.php"><input type="button" value="View All" name="viewall" /></a>
    </th>	    

</tr>

</form>
</table>
<?php
		$sql="SELECT 
		
	 d.opportunity_id,
	 d.lead_id,
	 a.cka_name,
	 b.cka_type,
	 c.project_type,
	 d.[project_name],
	 d.[added_date],
     e.state_name,
     e.zone,
     d.[city],
     d.[architect_name],
	 d.[tile_stage_date],
     d.[obl_sale_forecast_inr],
     d.[project_tile_potential_inr],
	 d.[probability_of_win],
     d.[status],
	 d.current_stage,
	 
	 d.deal_type,
	 d.territory,
	 d.contractor_firm_name,
	 v.fullname as [modified_by],
	 d.obl_approval_status,
	 u.fullname,
	 x.fullname as [manager_name],
	 u.employee_department,
	 t.territory_name,
	 d.project_tile_potential_sqm,
	 d.quotation_status,
	 d.lead_approval_status
	
	  FROM [opportunity] d
	  left join pmt_current_stage p on d.current_stage = p.stage_id
	  left join cka_name_master a on a.cka_name_id = d.cka_name_id
	  left join cka_type_master b on b.cka_type_id = d.cka_type_id
	  left join project_type_master c on c.project_type_id = d.project_type_id
	  left join state_master e on e.state_id = d.state_id 
	  left join user_management u on d.created_by = u.uid
	  left join user_management v on d.modified_by = v.uid
	  left join user_management x on x.uid = (select parent_id from user_management where uid = d.created_by)
	  
	  left join territory_master t on t.territory_id = d.territory
  
  
  ";
  
    if(trim($_SESSION['user_type'])=='management') {
		$sql.="  where 1=1  ";
	}else{

			/*if($_SESSION['employee_department']=='Retail'){
				$sql.=" where d.deal_type='Retail' 
						and d.territory in (".$_SESSION['employee_territory'].") 
						 ";
			}*/


			if($_SESSION['employee_department']=='CKA'){
//vks start
					if($_SESSION['user_type']=='manager'){
					
					$sql.=" where 1=1 
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
						$sql.=" ) ";
					}else{
						$sql.=" where ( d.deal_type='CKA') and ( ";

						$ex=explode(",",$_SESSION['emp_cka_mapping']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$sql .=" d.cka_name_id = '".$vx."' ";
							else
								$sql .=" or d.cka_name_id = '".$vx."' ";
							$xcnt++;
						}

						$sql .=" ) ";
					}

//vks ends

					
				
				//echo $sql;
			}

			if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where 1=1 
						and ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$sql.=" d.created_by = '".$vx."' or d.created_by='".$_SESSION['uid']."' ";
							else
								$sql .=" or d.created_by = '".$vx."' ";
							$xcnt++;
						}
						$sql.=" ) ";
					}else{
						$sql.=" where d.created_by='".$_SESSION['uid']."' 
						 ";	
					}

			}
		
	}

//SEARCH QUERY BUILDING START
if(isset($_GET['show_result']) && !empty($_GET['show_result'])){

	if($_GET['account_name']){
			$sql.=" and a.cka_name like '%".$_GET['account_name']."%' ";		
	}
	if($_GET['lead_id']){
			$sql.=" and d.lead_id like '%".$_GET['lead_id']."%' ";		
	}

	if($_GET['city']){
			$sql.=" and d.city like '%".$_GET['city']."%' ";		
	}
	

/*	
	if(!empty($_GET['territory']) && strlen(trim($_GET['territory'])>0) ){
			$sql.=" and d.territory = '".$_GET['territory']."' ";		
	}
*/

	if(isset($_GET['territory']) && sizeof($_GET['territory'])>0 && $_GET['show_result']!='true'){
			$csp=0;
			foreach ($_GET['territory'] as $tsp){
				//echo $sp;
						if($csp >0){
							$sql.=" or d.territory ='".$tsp."'  ";		
						}else{
							$sql.=" and ( d.territory ='".$tsp."'  ";		
						}
				$csp++;
			}

			$sql.=" ) ";

	}else{
			if(!empty($_GET['territory']) && strlen(trim($_GET['territory'])>0) && $_GET['show_result']=='true' ){
			
					$sql.=" and d.territory ='".$_GET['territory']."'  ";		
			}
	}


	
	/*if(!empty($_GET['sales_phase']) && strlen(trim($_GET['sales_phase'])>0) ){
	
		if($_GET['sales_phase']>7){
			$sql.=" and d.status = 'lost' ";		
		}else{

			$sql.=" and d.current_stage ='".$_GET['sales_phase']."' ";		
		}
	}*/

	
	if(isset($_GET['sales_phase']) && sizeof($_GET['sales_phase'])>0 && $_GET['show_result']!='true'){
			$csp=0;
			foreach ($_GET['sales_phase'] as $sp){
				//echo $sp;
					if($sp == 8){
						$sql.=" and d.status = 'lost' ";		
					}else{
						if($csp >0){
							$sql.=" or d.current_stage ='".$sp."' and d.status <> 'lost' ";		
						}else{
							$sql.=" and ( d.current_stage ='".$sp."' and d.status <> 'lost' ";		
						}
					}
				$csp++;
			}

			$sql.=" ) ";

	}else{
			if(!empty($_GET['sales_phase']) && strlen(trim($_GET['sales_phase'])>0) && $_GET['show_result']=='true' ){
			
				if($_GET['sales_phase']>7){
					$sql.=" and d.status = 'lost' ";		
				}else{
		
					$sql.=" and d.current_stage ='".$_GET['sales_phase']."' and d.status != 'lost' ";		
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
							$sql.=" or e.zone ='".$tsp."'  ";		
						}else{
							$sql.=" and ( e.zone='".$tsp."'  ";		
						}
				$csp++;
			}

			$sql.=" ) ";

	}else{
			if(!empty($_GET['zone']) && strlen(trim($_GET['zone'])>0) && $_GET['show_result']=='true' ){
			
					$sql.=" and e.zone='".$_GET['zone']."'  ";		
			}
	}
	
	
/*
	if($_GET['lead_source']){
		$sql.=" and u.employee_department like '%".$_GET['lead_source']."%' ";		
	}
*/

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
	
		 $sql.=" and d.tile_stage_date between '".$fromdate."' and '".$todate."' ";		
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
	
		 $sql.=" and d.added_date between '".$fromdate."' and '".$todate."' ";		
	}

	

}
//SEARCH QUERY BUILDING ENDS

//			$sql.=" and a.cka_name like '%God%' ";

			$sql.=" order by added_date desc ";
			
			$pipelineTotal=0;
			$sqaureTotal = 0;
			$rsData=odbc_exec($conn,$sql);
			$countTotal=1;
			while($rowdata = odbc_fetch_array($rsData)) {
				$pipelineTotal = $rowdata['obl_sale_forecast_inr'] + $pipelineTotal;
				$sqaureTotal = is_int($rowdata['project_tile_potential_sqm']) + $sqaureTotal;
				$countTotal++;
			}
			
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
										
									
									<a href="exportdata.php?val=<?php echo $sql; ?>">
                                        <button class="btn green">
										Export Data &nbsp;<i class="icon-angle-right"></i>
										</button>
										</a>

									</div>
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
										if ($f['lead_approval_status'] == 0) {
											echo '<td>'.$f['lead_id'].'</td>';
										}elseif($f['lead_approval_status'] == 2) {
											echo '<td style="color:red;">Rejected by PCH</td>';
										}else{
											echo '<td style="color:orange;">Pending for Approval</td>';
										}
										
										echo '<td>'.$f['cka_name'].'</td>';
										//echo '<td>'.$f['cka_type'].'</td>';										

										echo '<td class="highlight">';
										echo '<a href=lead-history.php?pid='.$f['opportunity_id'].'>'.substr(ucfirst($f['project_name']),0,30).'</a>';
										echo '</td>';	
										echo '<td>'.trim($f['contractor_firm_name']).'</td>';
										echo '<td>'.trim($f['project_type']).'</td>';	
																									
										//echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.ucfirst(trim($f['city'])).'</td>';
										echo '<td width="5%">'.substr($f['territory_name'],0,10).'</td>';


										
										/*if($f['obl_approval_status']=='Brand Approved and SKU Approved'){
											$as='BASA';
											$ast='Brand Approved and SKU Approved';
										}
										
										if($f['obl_approval_status']=='Brand Approved and SKU In Process'){
											$as='BASP';
											$ast='Brand Approved and SKU In Process';
										}
										
										if($f['obl_approval_status']=='Brand Approval In Process'){
											$as='BAP';
											$ast='Brand Approval In Process';
										}
										
										if($f['obl_approval_status']=='Only SKU Approved'){
											$as='OSA';
											$ast='Only SKU Approved';
										}
										
										if($f['obl_approval_status']=='Not Approved'){
											$as='NA';
											$ast='Not Approved';
										}


										echo '<td width="5%" title="'.$ast.'">'.$as.'</td>';*/

										//echo '<td>'.$f['architect_name'].'</td>';
										//echo '<td>'.$f['tile_stage_date'].'</td>';
										
										//echo '<td>'.valchar(trim($f['obl_sale_forecast_inr'])).'</td>';
										//echo '<td>'.number_format(trim($f['obl_sale_forecast_inr']),0).'</td>';
										echo '<td>'.number_format(trim($f['obl_sale_forecast_inr']/100000),0).'</td>';

											
											echo '<td width="9%">'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';
											echo '<td width="9%">'.date('d-m-Y',strtotime(trim($f['added_date']))).'</td>';

											echo '<td>'.$f['fullname'].'</td>';
											echo '<td>'.$f['manager_name'].'</td>';
											echo '<td>'.$f['employee_department'].'</td>';
			
											//$uq="select fullname, employee_department from [user_management] 
											//where uid= '".dbInput($f['modified_by'])."' ";
											//$ue=odbc_exec($conn, $uq);
											//$uf=odbc_fetch_array($ue);
//											echo '<td>'.$uf['fullname'].' ('.$uf['employee_department'].')</td>';
											//echo '<td>'.$uf['fullname'].' </td>';

											//echo '<td>pp</td>';

	
						if(trim($f['status']) == 'open'){


										
										if(trim($f['current_stage'])=='1'){
											$cstage='Opportunity';
											echo '<th>'.$cstage.'</th>';
			echo '<td >';
				if(trim($f['lead_approval_status'])=='2'){
				echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
			}else{
				//echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print">History</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
			}
				
										}
										
										if(trim($f['current_stage'])=='2'){
											$cstage='Discussion';
											echo '<th>'.$cstage.'</th>';
			echo '<td >';
			/*echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';*/
				//echo '<a href="fld-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print">Update</a>';
				echo '<a href="edit-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini purple no-print">Edit</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
										}
										
										/*if(trim($f['current_stage'])=='3'){
											$cstage='Sampling';
											echo '<th>'.$cstage.'</th>';
			echo '<td >';
			echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';
				echo '<a href="sampling-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Update</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';

										}
										*/
										/*if(trim($f['current_stage'])=='4'){
											$cstage='Product Approval';

											echo '<th>'.$cstage.'</th>';
			echo '<td >';
			echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';
				echo '<a href="product-approval-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Update</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
										}*/
										
										/*if(trim($f['current_stage'])=='5'){
											$cstage='Quotation';
											echo '<th>'.$cstage.'</th>';
			echo '<td >';
			echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';
				echo '<a href="quotation-negotiation-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Update</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
										}*/
										
										/*if(trim($f['current_stage'])=='6'){
											$cstage='Negotiation';
											echo '<th>'.$cstage.'</th>';
			echo '<td >';
				echo '<a href="negotiation-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Update</a>';
				//echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print">History</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';

				echo '&nbsp;&nbsp;<a href="closure-won.php?pid='.$f['opportunity_id'].'" class="btn mini green"><i class="icon-edit"></i>Won</a>';
	
			echo '&nbsp;&nbsp;<a href="closure-lost.php?pid='.$f['opportunity_id'].'" class="btn mini red"><i class="icon-edit"></i>Lost</a>';
						echo '&nbsp;';

										}*/
										
										if(trim($f['current_stage'])=='7'){
											$cstage='Won';

											echo '<th>'.$cstage.'</th>';
			echo '<td >';
				
//				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print">History</a>';
					echo '<a href="supply-plan-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue" style="width:73px;">
										<i class="icon-edit"></i> Supply Plan</a>';
					echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
					
			echo '</td>';
										}

								}
										
										
										if(trim($f['status'])=='lost'){
											$cstage='Lost';
											echo '<th>'.$cstage.'</th>';
			echo '<td >';
				//echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';
				//echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print">History</a>';
				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini yellow no-print"><font color="#000">Detail&nbsp;</font></a>';
				
			echo '</td>';
										}
										
										
																		
									
										if(trim($f['status'])=='close'){
											$cstage='Won';
											//echo '<td align="center"><span class="label label-success">Won</span></td>';

											echo '<th>'.$cstage.'</th>';
			echo '<td >';
				// echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue no-print"><i class="icon-edit"></i>Edit</a>';
//				echo '<a href="lead-history.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print">History</a>';
					echo '<a href="supply-plan-submit.php?pid='.$f['opportunity_id'].'" class="btn mini blue" style="width:73px;">
										<i class="icon-edit"></i> Supply Plan</a>';
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