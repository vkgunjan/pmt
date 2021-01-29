<?php
 include_once('including/all-include.php');

	if(!empty($_GET['factory_id'])){
	
	 $_SESSION['factory-id']				=base64_decode($_GET['factory_id']);
	 $_SESSION['login-factory']			=	base64_decode($_GET['factname']);
	
	}
 include_once('including/header.php');
 
 
	$hsqa="SELECT current_stage, COUNT(*) as no, sum(project_tile_potential_inr) as project, sum(won_po_value) as won_po_value FROM opportunity where [status]<>'lost' and created_by='".$_SESSION['uid']."'  GROUP BY current_stage";
	
					$hee=odbc_exec($conn,$hsqa);
					while($hxx=odbc_fetch_array($hee)){
					//print_r($hxx);
					//echo '<br>';
						//echo $hxx['status'];
						//echo $hxx['no'];
						
							if(trim($hxx['current_stage'])=='1'){
								$oppval=$hxx['project'];
								$oppno=$hxx['no'];
								$oad=round($oppval/$oppno);
							}
							
							if(trim($hxx['current_stage'])=='2'){
								$fldval=$hxx['project'];
								$fldno=$hxx['no'];
								$fad=round($fldval/$fldno);
							}
							
							if(trim($hxx['current_stage'])=='3'){
								$samplingval=$hxx['project'];
								$samplingno=$hxx['no'];
								$sad=round($samplingval/$samplingno);
							}
							
							if(trim($hxx['current_stage'])=='4'){
								$productapproval=$hxx['project'];
								$productapprovalno=$hxx['no'];
								$pad=round($productapproval/$productapprovalno);
							}
							
							if(trim($hxx['current_stage'])=='5'){
								$quotation=$hxx['project'];
								$quotationno=$hxx['no'];
								$qad=round($quotation/$quotationno);
							}
							
							if(trim($hxx['current_stage'])=='6'){
								$negotiation=$hxx['project'];
								$negotiationno=$hxx['no'];
								$nad=round($negotiation/$negotiationno);
							}
							
							if(trim($hxx['current_stage'])=='7'){
								$won=$hxx['won_po_value'];
								$wonno=$hxx['no'];
								$wad=round($won/$wonno);
							}
										//echo $l;
					}
			
			
			$lq="SELECT  COUNT(*) as totallost,  sum(project_tile_potential_inr) as project  FROM opportunity where [status]='lost' and created_by='".$_SESSION['uid']."' ";
					$le=odbc_exec($conn,$lq);
					$lv=odbc_fetch_array($le);
					
					if($lv['totallost']>0){
						$lad=$lv['project']/$lv['totallost'];
					}else{
						$lad=0;
					}
							//echo $lad;
			?>
                                   

			<!-- END PAGE HEADER-->
				<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					
                    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue">
								<div class="visual">
									<i class="icon-bell"></i>
								</div>
								<div class="details">
									<div class="number" style="font-size:32px;">&#8377 <?php echo valchar($oppval);?></div>
									<div class="desc">									
										Opportunity
									</div>
								</div>
								<a class="more" href="list-opportunity.php" style="font-size:12px;">
								<?php echo (empty($oppno))?'0':$oppno?> DEALS  | Ave Deal: &#8377 <?php echo valchar($oad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="icon-sitemap"></i>
								</div>
								<div class="details">
									<div class="number" style="font-size:32px;">&#8377 <?php echo valchar($fldval);?></div>
                                    <div class="desc">First Discussion</div>
								</div>
								<a class="more" href="first-level-discussion.php" style="font-size:12px;">
								<?php echo (empty($fldno))?'0':$fldno?> DEALS | Ave Deal: <?php echo valchar($fad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="icon-dashboard"></i>
								</div>
								<div class="details">
									<div class="number" style="font-size:32px;">&#8377 <?php echo valchar($samplingval);?></div>
                                    <div class="desc">Sampling</div>
								</div>
								<a class="more" href="sampling.php" style="font-size:12px;">
								<?php echo (empty($samplingno))?'0':$samplingno?> DEALS | Ave Deal: <?php echo valchar($sad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat" style="background-color:#d8076e;">
								<div class="visual">
									<i class="icon-bullhorn"></i>
								</div>
								<div class="details">
									<div class="number" style="font-size:32px;">&#8377 <?php echo valchar($productapproval);?></div>
                                    <div class="desc">Product Approval</div>
								</div>
								<a class="more" href="product-approval.php" style="background-color:#fc2690;font-size:12px;" >
								<?php echo (empty($productapprovalno))?'0':$productapprovalno?> DEALS  | Ave Deal: <?php echo valchar($pad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
					</div>
                    
				<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					
                    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat" style="background-color:#000000;">
								<div class="visual">
									<i class="icon-book"></i>
								</div>
								<div class="details">
									<div class="number" style="font-size:32px;">&#8377 <?php echo valchar($quotation);?></div>
                                    <div class="desc">									
										Quotation
									</div>
								</div>
								<a class="more" href="quotation-negotiation.php" style="background-color:#333333;font-size:12px;">
								<?php echo (empty($quotationno))?'0':$quotationno?> DEALS | Ave Deal: <?php echo valchar($qad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat" style="background-color:#666;">
								<div class="visual">
									<i class="icon-retweet"></i>
								</div>
								<div class="details">
									<div class="number" style="font-size:32px;">&#8377 <?php echo valchar($negotiation);?></div>
									<div class="desc">Negotiation</div>
								</div>
								<a class="more" href="negotiation.php" style="background-color:#999;font-size:12px;">
								<?php echo (empty($negotiationno))?'0':$negotiationno?> DEALS  | Ave Deal: <?php echo valchar($nad) ?> <i class="m-icon-swapright m-icon-white"></i>
                                </a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="icon-trophy"></i>
								</div>
								<div class="details">
									<div class="number" style="font-size:32px;">&#8377 <?php echo valchar($won);?></div>
									<div class="desc">Closer WON</div>
								</div>
								<a class="more" href="list-won-opportunity.php" style="font-size:12px;">
								<?php echo (empty($wonno))?'0':$wonno?> DEALS  | Ave Deal: <?php echo valchar($wad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat red">
								<div class="visual">
									<i class="icon-lock"></i>
								</div>
								<div class="details">
									<div class="number" style="font-size:32px;">&#8377 <?php echo valchar($lv['project']);?></div>
									<div class="desc">Closer LOST</div>
								</div>
								<a class="more" href="list-lost-opportunity.php" style="font-size:12px;">
								<?php echo $lv['totallost']?> DEALS | Ave Deal: <?php echo valchar($lad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
					</div>


                    
                    <div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3" style="width:100%;">

<!--Total Lead in pipeline START-->
<?php
			$totq="SELECT COUNT(*) as tlead, sum(project_tile_potential_inr) as tval FROM opportunity where [status]='open' and created_by='".$_SESSION['uid']."' ";
			$tote=odbc_exec($conn,$totq);
			$tot=odbc_fetch_array($tote);
 ?>                   
<!--Total Lead in pipeline ENDS -->
 
<div class="portlet box blue" style="padding-left:120px;">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>CKA Target Vs Achievement</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row-fluid">
									<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
										<div class="circle-stat">
											<div class="visual">
<!--BUILDER Lead in pipeline START-->
<?php
			$bq="SELECT  COUNT(*) as totalb,  sum(project_tile_potential_inr) as project  FROM opportunity where [cka_type_id]='1' and [status]='open'  and created_by='".$_SESSION['uid']."' ";
			$bqe=odbc_exec($conn,$bq);
			$bf=odbc_fetch_array($bqe);
			//print_r($bf);
			//echo 'total lead - '.$tot['tlead'];
			//echo '<br>builder lead - '.$bf['totalb'];
			$bpercent=($bpercent>0)?round($bf['totalb']/$tot['tlead']*100):0;
?>
<!--BUILDER Lead in pipeline ENDS-->

												<input class="knobify" data-width="115" data-fgcolor="#4b8df8" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="+<?php echo $bpercent?>" data-max="100" data-min="-100" title="<?php echo $bpercent?> % of Builder Lead in Pipeline"/>
											</div>
											<div class="details">
						<div class="title">Builder <i class="<?php echo($bpercent<30)?'icon-caret-down down' :'icon-caret-up' ?>"></i></div>
						<div class="number">&#8377 <?php echo valchar($bf['project']);?></div>
<span class="label label-warning" title="Builder Leads Running Lead in Pipeline" style="cursor:help;"><i class="icon-folder-open"></i>  <?php echo $bf['totalb']?></span>

<!--BUILDER WON Lead in pipeline START-->
<?php
			$bwq="SELECT  COUNT(*) as tw FROM opportunity where [cka_type_id]='1' and [current_stage]='7' and created_by='".$_SESSION['uid']."' ";
			$bwe=odbc_exec($conn,$bwq);
			$bw=odbc_fetch_array($bwe);
					
 ?>  
 <!--BUILDER WON Lead in pipeline ENDS-->
 <span class="label label-success" title="WON Leads" style="cursor:help;"><i class="icon-trophy"></i> <?php echo $bw['tw']?></span>

<!--BUILDER LOST in pipeline START-->
<?php
			$blq="SELECT  COUNT(*) as tl FROM opportunity where [cka_type_id]='1' and [status]='lost' and created_by='".$_SESSION['uid']."' ";
			$ble=odbc_exec($conn,$blq);
			$bl=odbc_fetch_array($ble);
					
 ?>  
 <!--BUILDER LOST in pipeline ENDS-->
 
 <span class="label label-important" title="LOST Leads" style="cursor:help;"><i class="icon-lock"></i> <?php echo $bw['tw']?></span>
										</div>
										</div>
									</div>

<!--CONTRACTOR AREA START-->
									<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
										<div class="circle-stat block">
											<div class="visual">
<!--CONTRACTOR Lead in pipeline START-->
<?php
			$bq="SELECT  COUNT(*) as totalb,  sum(project_tile_potential_inr) as project  FROM opportunity where [cka_type_id]='2' and [status]='open'  and created_by='".$_SESSION['uid']."' ";
			$bqe=odbc_exec($conn,$bq);
			$bf=odbc_fetch_array($bqe);
			//print_r($bf);
			//echo 'total lead - '.$tot['tlead'];
			//echo '<br>builder lead - '.$bf['totalb'];
			$bpercent=($bpercent>0)?round($bf['totalb']/$tot['tlead']*100):0;
?>
<!--CONTRACTOR Lead in pipeline ENDS-->

												<input class="knobify" data-width="115" data-fgcolor="#852b99" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="+<?php echo $bpercent?>" data-max="100" data-min="-100" title="<?php echo $bpercent?> % of Contractor Lead in Pipeline"/>
											</div>
											<div class="details">
				<div class="title">Contractor <i class="<?php echo($bpercent<30)?'icon-caret-down down' :'icon-caret-up' ?>"></i></div>
				<div class="number">&#8377 <?php echo valchar($bf['project']);?></div>
<span class="label label-warning" title="Contractor Leads Running Lead in Pipeline" style="cursor:help;"><i class="icon-folder-open"></i>  <?php echo $bf['totalb']?></span>

<!--CONTRACTOR WON Lead in pipeline START-->
<?php
			$bwq="SELECT  COUNT(*) as tw FROM opportunity where [cka_type_id]='2' and [current_stage]='7' and created_by='".$_SESSION['uid']."' ";
			$bwe=odbc_exec($conn,$bwq);
			$bw=odbc_fetch_array($bwe);
					
 ?>  
 <!--CONTRACTOR WON Lead in pipeline ENDS-->
 <span class="label label-success" title="WON Leads" style="cursor:help;"><i class="icon-trophy"></i> <?php echo $bw['tw']?></span>

<!--CONTRACTOR LOST in pipeline START-->
<?php
			$blq="SELECT  COUNT(*) as tl FROM opportunity where [cka_type_id]='2' and [status]='lost' and created_by='".$_SESSION['uid']."' ";
			$ble=odbc_exec($conn,$blq);
			$bl=odbc_fetch_array($ble);
					
 ?>  
 <!--CONTRACTOR LOST in pipeline ENDS-->
 
 <span class="label label-important" title="LOST Leads" style="cursor:help;"><i class="icon-lock"></i> <?php echo $bl['tl']?></span>
										</div>
										</div>
									</div>
                                    
 <!--CONTRACTOR ENDS-->

									<div class="span3 responsive" data-tablet="span6 fix-margin" data-desktop="span3">
										<div class="circle-stat block">
											<div class="visual">
<!--Govt. Body Lead in pipeline START-->
<?php
			$bq="SELECT  COUNT(*) as totalb,  sum(project_tile_potential_inr) as project  FROM opportunity where [cka_type_id]='3' and [status]='open'  and created_by='".$_SESSION['uid']."' ";
			$bqe=odbc_exec($conn,$bq);
			$bf=odbc_fetch_array($bqe);
			//print_r($bf);
			//echo 'total lead - '.$tot['tlead'];
			//echo '<br>builder lead - '.$bf['totalb'];
			$bpercent=($bpercent>0)?round($bf['totalb']/$tot['tlead']*100):0;
?>
<!--Govt. Body Lead in pipeline ENDS-->

												<input class="knobify" data-width="115" data-fgcolor="#987B10" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="+<?php echo $bpercent?>" data-max="100" data-min="-100" title="<?php echo $bpercent?> % of Govt. Body Lead in Pipeline"/>
											</div>
											<div class="details">
					<div class="title">Govt. Body <i class="<?php echo($bpercent<30)?'icon-caret-down down' :'icon-caret-up' ?>"></i></div>
					<div class="number">&#8377 <?php echo valchar($bf['project']);?></div>
<span class="label label-warning" title="Govt. Body Leads Running Lead in Pipeline" style="cursor:help;"><i class="icon-folder-open"></i>  <?php echo $bf['totalb']?></span>

<!--Govt. Body WON Lead in pipeline START-->
<?php
			$bwq="SELECT  COUNT(*) as tw FROM opportunity where [cka_type_id]='3' and [current_stage]='7' and created_by='".$_SESSION['uid']."' ";
			$bwe=odbc_exec($conn,$bwq);
			$bw=odbc_fetch_array($bwe);
					
 ?>  
 <!--Govt. Body WON Lead in pipeline ENDS-->
 
 <span class="label label-success" title="WON Leads" style="cursor:help;"><i class="icon-trophy"></i> <?php echo $bw['tw']?></span>

<!--Govt. Body LOST in pipeline START-->
<?php
			$blq="SELECT  COUNT(*) as tl FROM opportunity where [cka_type_id]='3' and [status]='lost' and created_by='".$_SESSION['uid']."' ";
			$ble=odbc_exec($conn,$blq);
			$bl=odbc_fetch_array($ble);
					
 ?>  
 <!--Govt. Body LOST in pipeline ENDS-->
 
 <span class="label label-important" title="LOST Leads" style="cursor:help;"><i class="icon-lock"></i> <?php echo $bl['tl']?></span>
											</div>
										</div>
									</div>
                                    
 <!--Govt. Body WON Lead in pipeline START-->
<?php
			$bwq="SELECT  COUNT(*) as tw, sum(won_po_value) as ach FROM opportunity where [current_stage]='7' and created_by='".$_SESSION['uid']."' ";
			$bwe=odbc_exec($conn,$bwq);
			$bw=odbc_fetch_array($bwe);
					
 ?>  
 <!--Govt. Body WON Lead in pipeline ENDS-->
                                    
                                    
									<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
										<div class="circle-stat block">
											<div class="visual">
												<input class="knobify" data-width="115" data-fgcolor="#339966" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="<?php echo $bw['ach'];?>" data-max="1500000000" data-min="-100" />
											</div>
											<div class="details">
												<div class="title">All Achievement <i class="icon-caret-up"></i></div>

	<div class="number"><?php echo number_format((float)$bw['ach']/1500000000*100, 2, '.', '');  ?>%</div>

 
 <span class="label label-success" title="WON Leads" style="cursor:help;"><i class="icon-trophy"></i> <?php echo $bw['tw']?></span>

<!--Govt. Body LOST in pipeline START-->
<?php
			$blq="SELECT  COUNT(*) as tl FROM opportunity where [status]='lost' and created_by='".$_SESSION['uid']."' ";
			$ble=odbc_exec($conn,$blq);
			$bl=odbc_fetch_array($ble);
					
 ?>  
 <!--Govt. Body LOST in pipeline ENDS-->
 
 <span class="label label-important" title="LOST Leads" style="cursor:help;"><i class="icon-lock"></i> <?php echo $bl['tl']?></span>
 
 											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

													</div>


<!-- other content area--> 

				<div class="row-fluid">
					<div class="span6">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-bell"></i>TOP 10 Pipeline Deals</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<!--<th><i class="icon-briefcase"></i> CKA Name </th>-->
											<th><i class="icon-briefcase"></i> Project Name </th>                                            
											<th class="hidden-phone"><i class="icon-flag"></i> State</th>
											<th class="hidden-phone"><i class="icon-map-marker"></i> City</th>
											<th><i class="icon-shopping-cart"></i> Total INR</th>
										</tr>
									</thead>
                                    <tbody>
<?php
$ttv="SELECT top 10 c.cka_name,o.project_name, s.state_name,o.city, o.project_name,o.project_tile_potential_inr  FROM opportunity o, cka_name_master c, state_master s
where o.[status]='open' 
and o.created_by='".$_SESSION['uid']."' 
and c.cka_name_id = o.cka_name_id and s.state_id= o.state_id
order by o.project_tile_potential_inr desc ";

					$tte=odbc_exec($conn,$ttv);
					while($ttf=odbc_fetch_array($tte)){
						echo '<tr align="center">';
							echo '<td class="highlight">';
							echo '<div class="success"></div>';
							//echo '<a href="#">'.$ttf['cka_name'].'</a>';
							echo '<a href="#">'.$ttf['project_name'].'</a>';
							echo '</td>';
							echo '<td>'.$ttf['state_name'].'</td>';
							echo '<td>'.$ttf['city'].'</td>';
							echo '<td>&#8377 '.valchar($ttf['project_tile_potential_inr']).'</td>';
						echo '</tr>';
					}
			
?>
									
											
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
					<div class="span6">
						<!-- BEGIN SAMPLE TABLE PORTLET-->				
						<div class="portlet box red">
							<div class="portlet-title">
								<h4><i class="icon-shopping-cart"></i> TOP 10 Pipeline Lost Deals</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
																<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th><i class="icon-briefcase"></i> CKA Name </th>
											<th class="hidden-phone"><i class="icon-flag"></i> State</th>
											<th class="hidden-phone"><i class="icon-trash"></i> Stage</th>
											<th><i class="icon-shopping-cart"></i> Total INR</th>
										</tr>
									</thead>
                                    <tbody>
<?php
$ttv="SELECT top 10 c.cka_name,o.project_name, s.state_name,o.current_stage, o.project_tile_potential_inr  FROM opportunity o, cka_name_master c, state_master s
where o.[status]='lost' 
and o.created_by='".$_SESSION['uid']."' 
and c.cka_name_id = o.cka_name_id and s.state_id= o.state_id
order by o.project_tile_potential_inr desc";

					$tte=odbc_exec($conn,$ttv);
					while($ttf=odbc_fetch_array($tte)){
										if(trim($ttf['current_stage'])=='1'){
											$cstage='Opportunity';
										}
										
										if(trim($ttf['current_stage'])=='2'){
											$cstage='FLD';
										}
										
										if(trim($ttf['current_stage'])=='3'){
											$cstage='Sampling';
										}
										
										if(trim($ttf['current_stage'])=='4'){
											$cstage='Product Approval';
										}
										
										if(trim($ttf['current_stage'])=='5'){
											$cstage='Quotation';
										}
										
										if(trim($ttf['current_stage'])=='6'){
											$cstage='Negotiation';
										}
										
						echo '<tr align="center">';
							echo '<td class="highlight">';
							echo '<div class="danger"></div>';
							echo '<a href="#">'.$ttf['cka_name'].'</a>';
							echo '</td>';
							echo '<td>'.$ttf['state_name'].'</td>';
							echo '<td>'.$cstage.'</td>';
							echo '<td>&#8377 '.valchar($ttf['project_tile_potential_inr']).'</td>';
						echo '</tr>';
					}
			
?>
									
											
										
									</tbody>
								</table>

							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
				</div>


                      <?php /*?> <table border="1">
                            <tr><td>adsf</td></tr>
                            </table> <?php */?>


					</div>
                    
					
                        
                        
							<!-- END PORTLET-->
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTAINER-->		
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
   2017 &copy; Orient Bell Ltd. | Concept: Project Disha | Developed BY: OBL IT Department
      		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>	
	<![endif]-->	
	<script src="assets/breakpoints/breakpoints.js"></script>		
	<script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>	
	<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>	
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>	
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
	<script src="assets/flot/jquery.flot.js"></script>
	<script src="assets/flot/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>	
	<script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>	
	<script src="assets/js/app.js"></script>				
	
	<script src="assets/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
	<script src="assets/jquery-knob/js/jquery.knob.js"></script>
	<script src="assets/js/app.js"></script>



	<script>
		jQuery(document).ready(function() {		
			App.setPage("index");  // set current page
			App.setPage("sliders"); 
			App.init(); // init the rest of plugins and elements
		});
	</script>
    	

    
    
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
