<?php 
	        $pm='active';
	        //$lsrd='active';

        include_once('including/all-include.php');
        include_once('including/header.php');
		//unset($_SESSION['working-active-asset']);
			
			
//			print_r($_SESSION);
	
    $ss="select o.*, c.cka_name, t.territory_name, s.state_name  from [opportunity] o 
		left join cka_name_master c on o.cka_name_id = c.cka_name_id
		left join territory_master t on o.territory=t.territory_id
		left join state_master s on o.state_id=s.state_id
		where opportunity_id='".dbInput($_GET['pid'])."' 
	";
	$c=odbc_exec($conn, $ss);
	$f=odbc_fetch_array($c);
//echo '<pre>';
//print_r($f);
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
						<div class="span3">
							<ul class="ver-inline-menu tabbable margin-bottom-10">
								<li class="active">
									<a href="#tab_1" data-toggle="tab">
									<i class="icon-briefcase"></i> 
									 Lead Profile Details
                                    </a> 
									<span class="after"></span>                           			
								</li>
								<li><a href="#tab_2" data-toggle="tab"><i class="icon-group"></i> Business Details</a></li>
								<li><a href="#tab_3" data-toggle="tab"><i class="icon-leaf"></i> Requirement Details</a></li>

								<li><a href="#tab_4" data-toggle="tab"><i class="icon-info-sign"></i>Account Connect</a></li>
								<li><a href="#tab_5" data-toggle="tab"><i class="icon-tint"></i>30 Day Action Plan</a></li>
								<li><a href="#tab_6" data-toggle="tab"><i class="icon-plus"></i>Closure History & Sales Plan</a></li>
								<li><a href="#tab_7" data-toggle="tab"><i class="icon-plus"></i>Deal History</a></li>

							</ul>
						</div>
						<div class="span9">
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
									<div class="accordion in collapse" id="accordion1" style="height: auto;">
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1">
												LEAD PROFILE DETAILS 
												</a>
											</div>
											<div id="collapse_1" class="accordion-body collapse in">
												<div class="accordion-inner">
														<table  border="0" width="100%">
                                                        	<tr>
                                                            	<td width="47%">
                                                                	<table class="table table-condensed table-hover" border="0">
                                                                    	<tr>
                                                                        	<td>Account Name</td>
                                                                            <td> : <?php echo $f['cka_name']?></td>
                                                                        </tr>

                                                                    	<tr>
                                                                        	<td>Location</td>
                                                                            <td> : <?php echo $f['city']?>, <?php echo $f['state_name']?></td>
                                                                        </tr>

                                                                    	<tr>
                                                                        	<td>Territory</td>
                                                                            <td> : <?php echo ucfirst($f['territory_name'])?></td>
                                                                        </tr>

                                                                    	<tr>
                                                                        	<td>Tile Stage Date</td>
                                                                            <td> : <?php echo $f['tile_stage_date']?></td>
                                                                        </tr>

																				<tr>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>

                                                                    </table>
                                                                </td>
                                                                <td width="3%"></td>
                                                                
                                                                <td width="50%">
                                                                <table class="table table-condensed table-hover">
                                                                    	<tr>
                                                                        	<td width="40%">Project Name</td>
                                                                            <td> : <?php echo $f['project_name']?></td>
                                                                        </tr>

                                                                    	<tr>
                                                                        	<td>Lead Sales Phase</td>
                                                                            <td> : <?php 
																		//echo $f['current_stage'];
																		$salesphase=$f['current_stage'];
										if(trim($f['current_stage'])=='1'){
											$cstage='Opportunity';
										}
										
										if(trim($f['current_stage'])=='2'){
											$cstage='First Discussion';
										}
										
										if(trim($f['current_stage'])=='3'){
											$cstage='Sampling';
										}
										
										if(trim($f['current_stage'])=='4'){
											$cstage='Product Approval';
										}
										
										if(trim($f['current_stage'])=='5'){
											$cstage='Quotation';
										}
										
										if(trim($f['current_stage'])=='6'){
											$cstage='Negotiation';
										}
										
										if(trim($f['current_stage'])=='7'){
											$cstage='Won';
										}
											
											echo $cstage;
																			?> </td>
                                                                        </tr>

                                                                    	<tr>
                                                                        	<td>Lead Date</td>
                                                                            <td> : <?php echo date('d-m-Y',strtotime(trim($f['added_date'])))?> </td>
                                                                        </tr>

                                                                    	<tr>
                                                                        	<td>Last updated Date</td>
                                                                            <td> : <?php echo date('d-m-Y',strtotime(trim($f['last_modified'])))?> </td>
                                                                        </tr>

                                                                    	<tr>
                                                                        	<td>Last Updated by</td>
                                                                            <td> : 
																				<?php 
																			$uq="select fullname, employee_department from [user_management] 
																			where uid= '".dbInput($f['modified_by'])."' ";
																			$ue=odbc_exec($conn, $uq);
																			$uf=odbc_fetch_array($ue);
																				echo $uf['fullname'].' ('.$uf['employee_department'].')';
																				?> 
                                                                             </td>
                                                                        </tr>

                                                                    	<tr>
                                                                        	<td>Generated By</td>
                                                                            <td> : 
																				<?php 
																			$uq="select fullname, employee_department from [user_management] 
																			where uid= '".dbInput($f['created_by'])."' ";
																			$ue=odbc_exec($conn, $uq);
																			$uf=odbc_fetch_array($ue);
																				echo $uf['fullname'].' ('.$uf['employee_department'].')';
																				?> 
                                                                             </td>
                                                                        </tr>

																				<tr>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>


                                                                    </table>
                                                                </td>
                                                            </tr>
															
                                                            <tr height="15">
                                                            	<td colspan="4"></td>
                                                            </tr>
                                                            
                                                            <tr>
                                                            	<td colspan="4" >
                                                        				<table class="table table-condensed table-hover">
                                                                                <tr>                                                                                    <td width="30%">Account Contact Person</td>
                                                                                    <td> : <?php echo $f['project_contact_name']?></td>
                                                                                    <td>Contact No.</td>
                                                                                    <td> : <?php echo $f['project_contact_no']?></td>
                                                                                </tr>

                                                                                <tr>                                                                                    <td>Architect Firm</td>
                                                                                    <td> : <?php echo $f['architect_firm_name']?></td>
                                                                                    <td>Architect Name</td>
                                                                                    <td> : <?php echo $f['architect_name']?></td>
                                                                                </tr>

                                                                                <tr>                                                                                    <td>GPS Department</td>
                                                                                    <td> : <?php echo $f['gps_department_name']?></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>

																				<tr>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>

																		</table>
                                                                </td>
                                                            </tr>
                                                        
                                                        </table>
												</div>
											</div>
										</div>
									</div>
								</div>

<!-- NEW TAB START -->
								<div class="tab-pane" id="tab_2">
									<div class="accordion in collapse" id="accordion2" style="height: auto;">
										<div class="accordion-group">
											<div class="accordion-heading">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
												BUSINESS DETAILS
												</a>
											</div>
											<div id="collapse_2_1" class="accordion-body collapse in">
												<div class="accordion-inner">
<table width="100%">
                                          <tr>
                                             <td>
													<table class="table table-condensed table-hover" border="0" width="40%">
                                                        <tr>
                                                            <td>Tile Potential (Sqm)</td>
                                                            <td> : <?php echo ($f['project_tile_potential_sqm']).' (SQM)'?> </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Tile Potential (Value)</td>
                                                            <td> : &#8377 <?php echo valchar($f['project_tile_potential_inr'])?></td>
                                                        </tr>


                                                        <tr>
                                                            <td>OBL Forecast</td>
                                                            <td> : &#8377 <?php echo valchar($f['obl_sale_forecast_inr'])?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Sales Value</td>
                                                            <td> : &#8377 <?php echo valchar($f['won_po_value'])?></td>
                                                        </tr>
                                                    </table>
                                                  </td>
                                                 
                                                  <td width="50%">&nbsp;
                                                	
                                                  </td>
                                                
                                                </tr>
                                              </table>   
                                              </div>
											</div>
										</div>
									</div>
								</div>

<!-- NEW TAB ENDS -->

<!-- NEW TAB START -->
								<div class="tab-pane" id="tab_3">
									<div class="accordion in collapse" id="accordion2" style="height: auto;">
										<div class="accordion-group">
											<div class="accordion-heading">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
												REQUIREMENT DETAILS
												</a>
											</div>
											<div id="collapse_2_1" class="accordion-body collapse in">
												<div class="accordion-inner">

													<table class="table table-condensed table-hover" border="0" width="40%">

                                                        <tr>
                                                            <td>#</td>
                                                            <td>Size</td>
                                                            <td>Category</td>
                                                            <td>Competition</td>
                                                            <td>QTY (SQMT)</td>
                                                            <td>Approved Tile</td>
                                                            <td>First BID </td>
                                                            <td>Last BID </td>
                                                        </tr>
<?php
 $fldq="select f.*, n.negotiation_price, n.negotiation_last_updated from fld f 
left join negotiation n on f.fld_id = n.fld_id
where f.opp_id='".$_GET['pid']."' order by n.negotiation_last_updated desc 
";	
$flde=odbc_exec($conn,$fldq);
$fldcount=1;
while($fldf = odbc_fetch_array($flde)){
echo '<tr>';
echo '<td>'.$fldcount++.'</td>';
echo '<td>'.$fldf['size'].'</td>';
echo '<td>'.$fldf['sample_tile_cateroty'].'</td>';
echo '<td>'.$fldf['competitor'].'</td>';
echo '<td>'.$fldf['qty'].'</td>';
echo '<td>'.$fldf['approved_tile_name'].'</td>';
echo '<td>'.$fldf['obl_bid_price'].'</td>';
echo '<td>'.$fldf['negotiation_price'].'</td>';

echo '</td>';
}
?>

                                                    </table>
                                              </div>
											</div>
										</div>
									</div>
								</div>

<!-- NEW TAB ENDS -->

<!-- NEW TAB START -->
								<div class="tab-pane" id="tab_4">
									<div class="accordion in collapse" id="accordion2" style="height: auto;">
										<div class="accordion-group">
											<div class="accordion-heading">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
												ACCOUNT CONNECT 
												</a>
											</div>
											<div id="collapse_2_1" class="accordion-body collapse in">
												<div class="accordion-inner">

<?php
 $papi_qry="select * from project_action_plan where opportunity_id='".$_GET['pid']."' ";	
$papi_qry_exe=odbc_exec($conn,$papi_qry);
$papi = odbc_fetch_array($papi_qry_exe);
//print_r($papi);

?>
													<table class="table table-condensed table-hover" border="0" width="90%">

                                                        <tr>
                                                            <th colspan="5"> Project Influencer Role & Degree of Influence</th>
                                                        </tr>

                                                        <tr>
                                                            <td></td>
                                                            <td>Name</td>
                                                            <td>Degree of Influence</td>
                                                            <td>OBL Perception Rating</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Key Purchaser</td> 
															<td><?php echo $papi['key_purchaser_name']?></td>
															<td><?php echo $papi['key_purchaser_degree']?></td>
															<td><?php echo $papi['key_purchaser_rating']?></td>
                                                        </tr>
                                                        
                                                        <tr>	
                                                            <td>Architect Involved</td>
															<td><?php echo $papi['architect_involved_name']?></td>
															<td><?php echo $papi['architect_involved_degree']?></td>
															<td><?php echo $papi['architect_involved_rating']?></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>OBL Champion</td>
															<td><?php echo $papi['obl_champion_name']?></td>
															<td><?php echo $papi['obl_champion_degree']?></td>
															<td><?php echo $papi['obl_champion_rating']?></td>

                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>User / Project Manager</td>

															<td><?php echo $papi['user_project_manager_name']?></td>
															<td><?php echo $papi['user_project_manager_degree']?></td>
															<td><?php echo $papi['user_project_manager_rating']?></td>
                                                         </tr>
                                                        
                                                        <tr>
                                                            <td>Key Decision Maker</td>
															<td><?php echo $papi['key_decision_maker_name']?></td>
															<td><?php echo $papi['key_decision_maker_degree']?></td>
															<td><?php echo $papi['key_decision_maker_rating']?></td>

                                                        </tr>

														</table>

  													<table class="table table-condensed table-hover" border="0" width="90%">

                                                        <tr>
                                                            <th colspan="5">Key Purchase Driver for Project</th>
                                                        </tr>

                                                        <tr>
                                                            <td width="30%"></td>
                                                            <td>Degree of Influence</td>
														</tr>
                                                        <tr>
                                                            <td>Account Relationship</td>
                                                          	<td><?php echo $papi['account_relationship_degree']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Product Quality	</td>
                                                          	<td><?php echo $papi['product_quality_degree']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Product Price</td>
                                                          	<td><?php echo $papi['product_price_degree']?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Design Options</td>
                                                          	<td><?php echo $papi['design_options_degree']?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Strength</td>
                                                          	<td><?php echo $papi['obl_strength']?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Weakness</td>
                                                          	<td><?php echo $papi['obl_weekness']?></td>
                                                        </tr>


                                                    </table>
                                              </div>
											</div>
										</div>
									</div>
								</div>

<!-- NEW TAB ENDS -->


<!-- NEW TAB START -->
								<div class="tab-pane" id="tab_5">
									<div class="accordion in collapse" id="accordion2" style="height: auto;">
										<div class="accordion-group">
											<div class="accordion-heading">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
												30 DAY ACTION PLAN 
												</a>
											</div>
											<div id="collapse_2_1" class="accordion-body collapse in">
												<div class="accordion-inner">

													<table class="table table-condensed table-hover" border="0" width="90%">
                                                        <tr>
                                                            <td width="30%">Activity</td>
                                                            <td>Responsibility</td>
                                                            <td>Deadline</td>
                                                        </tr>

	                                   
<?php 
//echo 'hello';
//print_r($_GET);

$ssql="select * from project_action_plan_cart where opportunity_id='".$_GET['pid']."' ";	

$rs=odbc_exec($conn,$ssql);



while($f = odbc_fetch_array($rs)){
//print_r($f);

echo '<tr align="center">';
echo '<td>'.$f['activity'].'</td>';
//echo '<td>'.$f['responsible_dept'].'</td>';

$eq="select fullname from user_management where uid='".$f['responsible_owner']."' ";
$eqe=odbc_exec($conn,$eq);
$eqf=odbc_fetch_array($eqe);
echo '<td>'.$eqf['fullname'].' ('.$f['responsible_dept'].')'.'</td>';
echo '<td>'.$f['timeline'].'</td>';

/*
$eq1="select fullname from user_management where uid='".$f['added_by']."' ";
$eqe1=odbc_exec($conn,$eq1);
$eqf1=odbc_fetch_array($eqe1);
echo '<td>'.$eqf1['fullname'].'</td>';


if($f['action_status']==0){
	$action_status='Pending';
}

if($f['action_status']==1){
	$action_status='Work in Progress';
}

if($f['action_status']==2){
	$action_status='Rejected';
}

if($f['action_status']==3){
	$action_status='Rejected';
}


echo '<td>'.$action_status.'</td>';

echo '<td width="15%">'.$f['action_remarks'].'</td>';

*/
}
?>
	                                                     <tr height="50">
                                                            <td colspan="3"></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Support Required to Win</td>
                                                            <td colspan="2"><?php //echo 'data fetch from action plan table' ?></td>
                                                        </tr>

                                                    </table>
                                              </div>
											</div>
										</div>
									</div>
								</div>

<!-- NEW TAB ENDS -->


<!-- NEW TAB START -->
								<div class="tab-pane" id="tab_6">
									<div class="accordion in collapse" id="accordion2" style="height: auto;">
										<div class="accordion-group">
											<div class="accordion-heading">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
												CLOSURE HISTORY & SALES PLAN 
												</a>
											</div>
											<div id="collapse_2_1" class="accordion-body collapse in">
												<div class="accordion-inner">

													<table class="table table-condensed table-hover" border="0" width="90%">
                                                        <tr>
                                                            <td width="30%">PO Valve</td>
                                                            <td>Demo Text</td>
                                                            <td>Balance Amount</td>
                                                            <td>demo eext</td>

                                                        </tr>

                                                        <tr>
                                                            <td>Billing Customer Name</td>
                                                            <td>demo</td>
                                                            <td>Payment Terms</td>
                                                            <td>demo</td>
                                                        </tr>

											        <tr>
                                                            <td colspan="4">&nbsp;</td>
                                                        </tr>

                                                    </table>
<br />
													<table class="table table-condensed table-hover" border="0" width="90%">

                                                        <tr>
                                                            <th colspan="6">Purchase Details</th>
                                                        </tr>

                                                        <tr>
                                                            <td>#</td>
                                                            <td>Size</td>
                                                            <td>Category</td>
                                                            <td>SKU Name</td>
                                                            <td>OBL Rates</td>
                                                            <td>Total Volume</td>
                                                        </tr>

<?php
 $fldq="select f.*, n.negotiation_price, n.negotiation_last_updated from fld f 
left join negotiation n on f.fld_id = n.fld_id
where f.opp_id='".$_GET['pid']."' order by n.negotiation_last_updated desc 
";	
$flde=odbc_exec($conn,$fldq);
$fldcount=1;
while($fldf = odbc_fetch_array($flde)){
	
	$tilename=(!empty($fldf['final_tile_name'])?$fldf['final_tile_name']:$fldf['approved_tile_name']);
	$oblrate=(!empty($fldf['negotiation_price'])?$fldf['negotiation_price']:$fldf['obl_bid_price']);


echo '<tr>';
echo '<td>'.$fldcount++.'</td>';
echo '<td>'.$fldf['size'].'</td>';
echo '<td>'.$fldf['sample_tile_cateroty'].'</td>';
echo '<td>'.$tilename.'</td>';
echo '<td>'.$oblrate.'</td>';
echo '<td>'.$fldf['qty'].'</td>';
echo '</td>';
echo '</tr>';

}
?>

													</table>


<br />
													<table class="table table-condensed table-hover" border="0" width="90%">

                                                        <tr>
                                                            <th colspan="6">Supply Plan Details</th>
                                                        </tr>
      
                                                        <tr>
                                                            <td>#</td>
                                                            <td>Size</td>
                                                            <td>Category</td>
                                                            <td>Supply Year</td>
                                                            <td>Supply Month</td>
                                                            <td>Supply QTY</td>
                                                        </tr>

<?php
 $fldq="select * from supply_plan where opp_id='".$_GET['pid']."' ";	
$flde=odbc_exec($conn,$fldq);
$fldcount=1;
while($fldf = odbc_fetch_array($flde)){
echo '<tr>';
echo '<td>'.$fldcount++.'</td>';
echo '<td>'.$f['size'].'</td>';
echo '<td>'.$f['tile_category'].'</td>';
echo '<td>'.$f['supply_year'].'</td>';
echo '<td>'.$f['supply_month'].'</td>';
echo '<td>'.$f['supply_qty'].'</td>';

echo '</td>';
echo '</tr>';

}
?>

													</table>



                                              </div>
											</div>
										</div>
									</div>
								</div>

<!-- NEW TAB ENDS -->



<!-- NEW TAB START -->
								<div class="tab-pane" id="tab_7">
									<div class="accordion in collapse" id="accordion2" style="height: auto;">
										<div class="accordion-group">
											<div class="accordion-heading">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
												DEAL HISTORY
												</a>
											</div>
											<div id="collapse_2_1" class="accordion-body collapse in">
												<div class="accordion-inner">
<?php
$ss="select 
		[added_date]
      ,[fld_date]
      ,[sampling_date]
      ,[product_approval_date]
      ,[quotation_date]
      ,[negotiation_date]
      ,[closure_won_date]

	from [opportunity] 
		where opportunity_id='".dbInput($_GET['pid'])."' 
	";
	$c=odbc_exec($conn, $ss);
	$h=odbc_fetch_array($c);
	
	//$days = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
	//print $days;
?>
													<table class="table table-condensed table-hover" border="0" width="90%">
                                                        <tr>
                                                            <th width="30%">Sales Phase</th>
                                                            <th>Date of Entry</th>
                                                            <th>No of days in phase</th>
                                                        </tr>

                                                        <tr>
                                                            <td>Opportunity</td>
                                                            <td><?php echo date('d-m-Y',strtotime(trim($h['added_date'])))?></td>
                                                            <td>
																<?php
																if($h['fld_date']){                                                               
															   $days = (strtotime($h['fld_date']) - strtotime($h['added_date'])) / (60 * 60 * 24);
                                                                echo round($days).' days';
																}else{
																	echo 'N/A';
																}
                                                                ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>First Level Discussion</td>
                                                            <td><?php echo date('d-m-Y',strtotime(trim($h['fld_date'])))?></td>
                                                            <td>
																<?php
                                                                if($h['sampling_date']){
																$days = (strtotime($h['sampling_date']) - strtotime($h['fld_date'])) / (60 * 60 * 24);
                                                                echo round($days).' days';
																}else{
																echo 'N/A';	
																}
                                                                ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Sampling</td>
                                                            <td><?php echo date('d-m-Y',strtotime(trim($h['sampling_date'])))?></td>
                                                            <td>
																<?php
                                                                if($h['product_approval_date']){
																$days = (strtotime($h['product_approval_date']) - strtotime($h['sampling_date'])) / (60 * 60 * 24);
                                                                echo round($days).' days';
																}else{
																echo 'N/A';	
																}
                                                                ?>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Product Approval</td>
                                                            <td><?php echo date('d-m-Y',strtotime(trim($h['product_approval_date'])))?></td>
                                                            <td>
																<?php
																if($h['quotation_date']){
																$days = (strtotime($h['quotation_date']) - strtotime($h['product_approval_date'])) / (60 * 60 * 24);
                                                                echo round($days).' days';
																}else{
																	echo 'N/A';
																}
                                                                ?>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Quotation</td>
                                                            <td><?php echo date('d-m-Y',strtotime(trim($h['quotation_date'])))?></td>
                                                            <td>
																<?php
                                                                if($h['negotiation']){
																$days = (strtotime($h['negotiation']) - strtotime($h['quotation'])) / (60 * 60 * 24);
                                                                echo round($days).' days';
																}else{
																	echo 'N/A';
																}
                                                                ?>
                                                            </td>
                                                        </tr>



                                                        <tr>
                                                            <td>Negotation</td>
                                                            <td><?php echo date('d-m-Y',strtotime(trim($h['negotiation_date'])))?></td>
                                                            <td>
																<?php
															
												if(empty($h['negotiation_date'])){
													echo 'N/A';
												}else{
                                                    $days = (strtotime($h['closure_won_date']) - strtotime($h['negotiation_date'])) / (60 * 60 * 24);
                                                                echo round($days).' days';
												}
                                                                ?>
                                                            </td>
                                                        </tr>



                                                        <tr>
                                                            <td>Closure WON</td>
                                                            <td><?php echo date('d-m-Y',strtotime(trim($h['closure_won_date'])))?></td>
                                                            <td>
																	N/A
                                                            </td>
                                                        </tr>

                                                    </table>
                                              </div>
											</div>
										</div>
									</div>
								</div>

<!-- NEW TAB ENDS -->

								
                                <div class="tab-pane" id="tab_700">
									<div class="accordion in collapse" id="accordion3" style="height: auto;">
										<div class="accordion-group">
											<div class="accordion-heading">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">
												AREA - NOT IN USE 
												</a>
											</div>
											<div id="collapse_3_1" class="accordion-body collapse in">
												<div class="accordion-inner">
													Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2">
												Pariatur skateboard dolor brunch ?
												</a>
											</div>
											<div id="collapse_3_2" class="accordion-body collapse">
												<div class="accordion-inner">
													Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3">
												Food truck quinoa nesciunt laborum eiusmod ?
												</a>
											</div>
											<div id="collapse_3_3" class="accordion-body collapse">
												<div class="accordion-inner">
													Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_4">
												High life accusamus terry richardson ad squid enim eiusmod high ?
												</a>
											</div>
											<div id="collapse_3_4" class="accordion-body collapse">
												<div class="accordion-inner">
													Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_5">
												Reprehenderit enim eiusmod high  eiusmod ?
												</a>
											</div>
											<div id="collapse_3_5" class="accordion-body collapse">
												<div class="accordion-inner">
													<p>
														Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
													</p>
													<p> 
														moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmodBrunch 3 wolf moon tempor
													</p>
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_6">
												Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ?
												</a>
											</div>
											<div id="collapse_3_6" class="accordion-body collapse">
												<div class="accordion-inner">
													Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_7">
												Reprehenderit enim eiusmod high life accusamus aborum eiusmod ?
												</a>
											</div>
											<div id="collapse_3_7" class="accordion-body collapse">
												<div class="accordion-inner">
													<p>
														Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
													</p>
													<p> 
														moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmodBrunch 3 wolf moon tempor
													</p>
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_8">
												Reprehenderit enim eiusmod high life accusamus terry quinoa nesciunt laborum eiusmod ?
												</a>
											</div>
											<div id="collapse_3_8" class="accordion-body collapse">
												<div class="accordion-inner">
													<p>
														Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
													</p>
													<p> 
														moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmodBrunch 3 wolf moon tempor
													</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end span9-->                                   
					</div>
				</div>
				<!-- END PAGE CONTENT-->
                
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