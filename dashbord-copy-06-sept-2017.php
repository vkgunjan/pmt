<?php
 ob_implicit_flush(true);
ob_end_flush();
 include_once('including/all-include.php');

	if(!empty($_GET['factory_id'])){
	
	 $_SESSION['factory-id']				=base64_decode($_GET['factory_id']);
	 $_SESSION['login-factory']			=	base64_decode($_GET['factname']);
	
	}
 include_once('including/header.php');
 
// print_r($_SESSION);

if(trim($_SESSION['user_type'])=='management') {
	 $hsqa="SELECT current_stage, COUNT(*) as no, sum(obl_sale_forecast_inr) as project, sum(won_po_value) as won_po_value FROM opportunity where [status]<>'lost'  GROUP BY current_stage";
}else{
	 $hsqa="SELECT current_stage, COUNT(*) as no, sum(obl_sale_forecast_inr) as project, sum(won_po_value) as won_po_value FROM opportunity where [status]<>'lost' and created_by='".$_SESSION['uid']."'  GROUP BY current_stage";
}
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
			
			if(trim($_SESSION['user_type'])=='management') {
			$lq="SELECT  COUNT(*) as totallost,  sum(obl_sale_forecast_inr) as project  FROM opportunity where [status]='lost' ";

			}else{
			$lq="SELECT  COUNT(*) as totallost,  sum(obl_sale_forecast_inr) as project  FROM opportunity where [status]='lost' and created_by='".$_SESSION['uid']."' ";
			}
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
			if(trim($_SESSION['user_type'])=='management') {
			$totq="SELECT COUNT(*) as tlead, sum(obl_sale_forecast_inr) as tval FROM opportunity where [status]='open' ";

			}else{
			$totq="SELECT COUNT(*) as tlead, sum(obl_sale_forecast_inr) as tval FROM opportunity where [status]='open' and created_by='".$_SESSION['uid']."' ";
			}
			$tote=odbc_exec($conn,$totq);
			$tot=odbc_fetch_array($tote);
 ?>                   
<!--Total Lead in pipeline ENDS -->
 
<div class="portlet box blue" style="padding-left:120px;">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>CKA Sales Target Vs Achievement in (%) <font size="2">&nbsp;(Dummy Data)</font></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row-fluid">
									<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
										<div class="circle-stat">
											<div class="visual">
<!-- Target Vs Achievement Start-->

<?php
			
//Target Vs Achievement Start

 $tqry="select * from sales_target where target_for_uid='".$_SESSION['uid']."' ";
$trs=odbc_exec($conn,$tqry);
$tf = odbc_fetch_array($trs);

		$targetArray=array(
			'apr_tgt'	=>	$tf['apr'],			
			'may_tgt'	=>	$tf['may'],
			'jun_tgt'	=>	$tf['jun'],			
			'jul_tgt'	=>	$tf['jul'],
			'aug_tgt'	=>	$tf['aug'],			
			'sep_tgt'	=>	$tf['sep'],
			'oct_tgt'	=>	$tf['oct'],			
			'nov_tgt'	=>	$tf['nov'],
			'dec_tgt'	=>	$tf['dec'],			
			'jan_tgt'	=>	$tf['jan'],
			'feb_tgt'	=>	$tf['feb'],			
			'mar_tgt'	=>	$tf['mar']
		);

//print_r($targetArray);

$aqry="select * from sales_achievement where achievement_for_uid='".$_SESSION['uid']."' ";
$ars=odbc_exec($conn,$aqry);
$af = odbc_fetch_array($ars);


		$achievementArray=array(
			'apr_ach'	=>	$af['apr'],			
			'may_ach'	=>	$af['may'],
			'jun_ach'	=>	$af['jun'],			
			'jul_ach'	=>	$af['jul'],
			'aug_ach'	=>	$af['aug'],			
			'sep_ach'	=>	$af['sep'],
			'oct_ach'	=>	$af['oct'],			
			'nov_ach'	=>	$af['nov'],
			'dec_ach'	=>	$af['dec'],
			'jan_ach'	=>	$af['jan'],
			'feb_ach'	=>	$af['feb'],			
			'mar_ach'	=>	$af['mar']
		);

	
	if(trim($_SESSION['user_type'])=='management') {
	 $bq="SELECT sum(t.".strtolower(date("M")).") as c_tgt, sum(a.".strtolower(date("M")).") as c_ach FROM sales_target t, sales_achievement a  ";
			}else{
	  $bq="SELECT t.".strtolower(date("M"))." as c_tgt, a.".strtolower(date("M"))." as c_ach FROM sales_target t, sales_achievement a 
				 where t.target_for_uid='".$_SESSION['uid']."' and a.achievement_for_uid='".$_SESSION['uid']."' ";
			}
			$bqe=odbc_exec($conn,$bq);
			$bf=odbc_fetch_array($bqe);
			$current_month_target=$bf['c_tgt'];
			$current_month_achivement=$bf['c_ach'];
			$cmp=number_format(($current_month_achivement/$current_month_target*100), 1, '.', '');
?>
<input class="knobify" data-width="115" data-fgcolor="#4b8df8" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="<?php echo $cmp?>"  data-max="160" data-min="-100" title="<?php echo $cmp?>% of Sales Achievement"/>
											</div>
											<div class="details">
				<div class="title"><?php echo date("M")?> '17 <i class="<?php echo($cmp<30)?'icon-caret-down down' :'icon-caret-up' ?>"></i></div>
				<div class="number">&#8377 <?php echo valchar($current_month_achivement);?></div>




<!--Current Month small boxes calculation STARTs-->
<?php
		if(trim($_SESSION['user_type'])=='management') {
			 $cmq="
 select 
	cmth_deal=(select count(*) from opportunity where MONTH(added_date)='".date("m")."'  ),
	won_deal=(select count(*) from opportunity where MONTH(closure_won_date)='".date("m")."'   ),
	lost_count=(select count(*) from opportunity where MONTH(lost_date)='".date("m")."'   ),
	lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date)='".date("m")."'  )
		 ";

		}else{
			 $cmq="
 select 
	cmth_deal=(select count(*) from opportunity where MONTH(added_date)='".date("m")."' and created_by='".$_SESSION['uid']."'  ),
	won_deal=(select count(*) from opportunity where MONTH(closure_won_date)='".date("m")."' and created_by='".$_SESSION['uid']."'  ),
	lost_count=(select count(*) from opportunity where MONTH(lost_date)='".date("m")."' and created_by='".$_SESSION['uid']."'  ),
	lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date)='".date("m")."' and created_by='".$_SESSION['uid']."'  )
		 ";

		}
//echo $cmq;
			$cme=odbc_exec($conn,$cmq);
			$cm=odbc_fetch_array($cme);
					
 ?>  
<!--Target Vs Achievement [Number of lead in month] calculation ENDS-->
 <span class="label label-warning" title="No. of Deals in Added in Current Month" style="cursor:help;">
 	<i class="icon-folder-open"></i> <?php echo $cm['cmth_deal']?>
 </span>

 <span class="label label-success" title="No Leads Won in Current Month" style="cursor:help;">
 	<i class="icon-trophy"></i> <?php echo $cm['won_deal']?>
 </span>

 <span class="label label-important" title=" Total Lost Value: <?php echo valchar($cm['lost_deal'])?> | No. of Lost Leads: <?php echo $cm['lost_count'] ?>" style="cursor:help;">
 	<i class="icon-lock"></i> <?php echo valchar1($cm['lost_deal']).''?></span>

										</div>
										</div>
									</div>





<!--QUARTERLY AREA START-->
									<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
										<div class="circle-stat block">
											<div class="visual">
<?php
		

$current_month=date("m");

if($current_month >=4 && $current_month<=6 ){
$qtr_tgt_qry= "SELECT 
			    Jan,
				Feb,
				Mar,
				(Jan + Feb + Mar) as 'qtr_tot_target'
				FROM sales_target";

$qtr_ach_qry= "SELECT 
			    Jan,
				Feb,
				Mar,
				(Jan + Feb + Mar) as 'qtr_tot_achievement'
				FROM sales_achievement";
$quarter='QUARTER 1';

if(trim($_SESSION['user_type'])=='management') {
$quarter_box_qry="select 
q1_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '04' and MONTH(added_date)<='06' ),
q1_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '04' and MONTH(closure_won_date)<='06' ),
q1_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='06' ),
q1_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='06' )";

}else{
$quarter_box_qry="select 
q1_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '04' and MONTH(added_date)<='06' and created_by='".$_SESSION['uid']."'  ),
q1_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '04' and MONTH(closure_won_date)<='06' and created_by='".$_SESSION['uid']."'  ),
q1_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='06' and created_by='".$_SESSION['uid']."'  ),
q1_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='06' and created_by='".$_SESSION['uid']."' )";
}

			$quarter_box_qry_execute=odbc_exec($conn,$quarter_box_qry);
			$cbf=odbc_fetch_array($quarter_box_qry_execute);

			$q_deal=$cbf['q1_total_deal'];
			$q_won=$cbf['q1_won_deal'];
			$q_lost_count=$cbf['q1_lost_count'];
			$q_lost_deal=$cbf['q1_lost_deal'];

}


if($current_month >=7 && $current_month<=9 ){
$qtr_tgt_qry= "SELECT 
			    Apr,
				May,
				Jun,
				(Apr + May + Jun) as 'qtr_tot_target'
				FROM sales_target";

$qtr_ach_qry= "SELECT 
			    Apr,
				May,
				Jun,
				(Apr + May + Jun) as 'qtr_tot_achievement'
				FROM sales_achievement";
				
$quarter='QUARTER 2';

if(trim($_SESSION['user_type'])=='management') {
$quarter_box_qry="select 
q2_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '07' and MONTH(added_date)<='09' ),
q2_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '07' and MONTH(closure_won_date)<='09' ),
q2_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '07' and MONTH(lost_date)<='09' ),
q2_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '07' and MONTH(lost_date)<='09' )";

}else{
$quarter_box_qry="select 
q2_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '07' and MONTH(added_date)<='09' and created_by='".$_SESSION['uid']."'  ),
q2_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '07' and MONTH(closure_won_date)<='09' and created_by='".$_SESSION['uid']."'  ),
q2_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '07' and MONTH(lost_date)<='09' and created_by='".$_SESSION['uid']."'  ),
q2_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '07' and MONTH(lost_date)<='09' and created_by='".$_SESSION['uid']."' )";
}


			$quarter_box_qry_execute=odbc_exec($conn,$quarter_box_qry);
			$cbf=odbc_fetch_array($quarter_box_qry_execute);

			$q_deal=$cbf['q2_total_deal'];
			$q_won=$cbf['q2_won_deal'];
			$q_lost_count=$cbf['q2_lost_count'];
			$q_lost_deal=$cbf['q2_lost_deal'];


}

if($current_month >=10 && $current_month<=12 ){
$qtr_tgt_qry= "SELECT 
			    Jul,
				Aug,
				Sep,
				(Jul + Aug + Sep) as 'qtr_tot_target'
				FROM sales_target";

$qtr_ach_qry= "SELECT 
			    Jul,
				Aug,
				Sep,
				(Jul + Aug + Sep) as 'qtr_tot_achievement'
				FROM sales_achievement";

$quarter='QUARTER 3';

if(trim($_SESSION['user_type'])=='management') {
$quarter_box_qry="select 
q3_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '10' and MONTH(added_date)<='12' ),
q3_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '10' and MONTH(closure_won_date)<='12' ),
q3_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '10' and MONTH(lost_date)<='12' ),
q3_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '10' and MONTH(lost_date)<='12' )";

}else{
$quarter_box_qry="select 
q3_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '10' and MONTH(added_date)<='12' and created_by='".$_SESSION['uid']."'  ),
q3_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '10' and MONTH(closure_won_date)<='12' and created_by='".$_SESSION['uid']."'  ),
q3_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '10' and MONTH(lost_date)<='12' and created_by='".$_SESSION['uid']."'  ),
q3_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '10' and MONTH(lost_date)<='12' and created_by='".$_SESSION['uid']."' )";
}


//echo $quarter_box_qry;

			$quarter_box_qry_execute=odbc_exec($conn,$quarter_box_qry);
			$cbf=odbc_fetch_array($quarter_box_qry_execute);

			$q_deal=$cbf['q3_total_deal'];
			$q_won=$cbf['q3_won_deal'];
			$q_lost_count=$cbf['q3_lost_count'];
			$q_lost_deal=$cbf['q3_lost_deal'];


}


if($current_month >=01 && $current_month<=03 ){
$qtr_tgt_qry= "SELECT 
			    Oct,
				Nov,
				Dec,
				(Oct + Nov + Dec) as 'qtr_tot_target'
				FROM sales_target";

$qtr_ach_qry= "SELECT 
			    Oct,
				Nov,
				Dec,
				(Oct + Nov + Dec) as 'qtr_tot_achievement'
				FROM sales_achievement";

$quarter='QUARTER 4';

if(trim($_SESSION['user_type'])=='management') {
$quarter_box_qry="select 
q4_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '01' and MONTH(added_date)<='03' ),
q4_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '01' and MONTH(closure_won_date)<='03' ),
q4_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '01' and MONTH(lost_date)<='03' ),
q4_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '01' and MONTH(lost_date)<='03' )";

}else{
$quarter_box_qry="select 
q4_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '01' and MONTH(added_date)<='03' and created_by='".$_SESSION['uid']."'  ),
q4_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '01' and MONTH(closure_won_date)<='03' and created_by='".$_SESSION['uid']."'  ),
q4_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '01' and MONTH(lost_date)<='03' and created_by='".$_SESSION['uid']."'  ),
q4_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '01' and MONTH(lost_date)<='03' and created_by='".$_SESSION['uid']."' )";
}


			$quarter_box_qry_execute=odbc_exec($conn,$quarter_box_qry);
			$cbf=odbc_fetch_array($quarter_box_qry_execute);

			$q_deal=$cbf['q4_total_deal'];
			$q_won=$cbf['q4_won_deal'];
			$q_lost_count=$cbf['q4_lost_count'];
			$q_lost_deal=$cbf['q4_lost_deal'];
			
		

}
		
			if(trim($_SESSION['user_type'])=='management') {

			
			}else{
				$qtr_tgt_qry .=" where target_for_uid='".$_SESSION['uid']."' ";
				$qtr_ach_qry .=" where achievement_for_uid='".$_SESSION['uid']."' ";
			}

//echo $qtr_tgt_qry;

//echo $qtr_ach_qry;

			$qtr_tgt_qry_exe=odbc_exec($conn,$qtr_tgt_qry);
			$qtr_tgt_qry_fetch=odbc_fetch_array($qtr_tgt_qry_exe);

			$qtr_ach_qry_exe=odbc_exec($conn,$qtr_ach_qry);
			$qtr_ach_qry_fetch=odbc_fetch_array($qtr_ach_qry_exe);


			$qtr_tgt=$qtr_tgt_qry_fetch['qtr_tot_target'];
			$qtr_ach=$qtr_ach_qry_fetch['qtr_tot_achievement'];
			$qtap=number_format(($qtr_ach/$qtr_tgt*100), 1, '.', '');
?>

<input class="knobify" data-width="115" data-fgcolor="#852b99" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="<?php echo $qtap?>" data-max="150" data-min="-100" title="<?php echo $qtap?>% of Last Quarter Sales Achievement"/>
											</div>
											<div class="details">
				<div class="title"><?php echo $quarter?> <i class="<?php echo($qtap<30)?'icon-caret-down down' :'icon-caret-up' ?>"></i></div>
				<div class="number">&#8377 <?php echo valchar($qtr_ach)?></div>


<!--Target Vs Achievement QUARTERLY small box query execution calculation STARTs-->
<?php
	//box value calculation is above in main circle query
//echo $cmq;	
			//$q_deal=$cbf['q4_total_deal'];
			//$q_won=$cbf['q4_won_deal'];
			//$q_lost_count=$cbf['q4_lost_count'];
			//$q_lost_deal=$cbf['q4_lost_deal'];

					
 ?>  
 <span class="label label-warning" title="No. of Deals in Added in Last Querter" style="cursor:help;">
 	<i class="icon-folder-open"></i> <?php echo $q_deal?>
 </span>

 <span class="label label-success" title="No Leads Won in Current Month" style="cursor:help;">
 	<i class="icon-trophy"></i> <?php echo $q_won?>
 </span>

 <span class="label label-important" title=" Total Lost Value: <?php echo valchar($q_lost_deal)?> | No. of Lost Leads: <?php echo $q_lost_count ?>" style="cursor:help;">
 	<i class="icon-lock"></i> <?php echo valchar1($q_lost_deal).''?></span>

 <!--QUARTER CALCULATION ENDS-->


										</div>
										</div>
									</div>
                                    
 <!--QUARTER ENDS-->

									<div class="span3 responsive" data-tablet="span6 fix-margin" data-desktop="span3">
										<div class="circle-stat block">
											<div class="visual">


<!--MTD Month to Date Calculation START-->
<?php

$monthArray=array('Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan','Feb','Mar');
//$current_month=12;

//***ISSUE*** month calculation needs to be corrected, if Jan then it will give error.

for($z=0;$z<$current_month-3;$z++){
	if($z>0){
		$mth .=",";
		$mth1 .="+";
	}
	$mth .=$monthArray[$z];

	$mth1 .=$monthArray[$z];

}
//echo $mth;

 $mtd_tgt_qry= "SELECT 
				".$mth." ,
				(".$mth1.") as 'mtd_tot_target'
				FROM sales_target";

$mtd_ach_qry= "SELECT 
			   ".$mth." ,
				(".$mth1.") as 'mtd_tot_achievement'
				FROM sales_achievement";


			if(trim($_SESSION['user_type'])=='management') {

			
			}else{
				$mtd_tgt_qry .=" where target_for_uid='".$_SESSION['uid']."' ";
				$mtd_ach_qry .=" where achievement_for_uid='".$_SESSION['uid']."' ";
			}

		//echo $mtd_ach_qry;
		
			$mtd_tgt_qry_exe=odbc_exec($conn,$mtd_tgt_qry);
			$mtd_tgt_qry_fetch=odbc_fetch_array($mtd_tgt_qry_exe);

			$mtd_ach_qry_exe=odbc_exec($conn,$mtd_ach_qry);
			$mtd_ach_qry_fetch=odbc_fetch_array($mtd_ach_qry_exe);


			$mtd_tgt=$mtd_tgt_qry_fetch['mtd_tot_target'];
			$mtd_ach=$mtd_ach_qry_fetch['mtd_tot_achievement'];
			$mtdap=number_format(($mtd_ach/$mtd_tgt*100), 1, '.', '');
?>


												<input class="knobify" data-width="115" data-fgcolor="#987B10" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="<?php echo $mtdap?>" data-max="200" data-min="-100" title="<?php echo $mtdap?>% of MTD Sales Achievement"/>
											</div>
											<div class="details">
					<div class="title">Month to Date <i class="<?php echo($mtdap<30)?'icon-caret-down down' :'icon-caret-up' ?>"></i></div>
					<div class="number">&#8377 <?php echo valchar($mtd_ach);?></div>


<!--MTD small box CALCULATION starts -->
                    
<?php

if(trim($_SESSION['user_type'])=='management') {
$mtd_box_qry="select 
mtd_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '04' and MONTH(added_date)<='".$current_month."' ),
mtd_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '04' and MONTH(closure_won_date)<='".$current_month."' ),
mtd_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='".$current_month."' ),
mtd_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='".$current_month."' )";

}else{
$mtd_box_qry="select 
mtd_total_deal=(select count(*) from opportunity where MONTH(added_date) >= '04' and MONTH(added_date)<='".$current_month."' and created_by='".$_SESSION['uid']."'  ),
mtd_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '04' and MONTH(closure_won_date)<='".$current_month."' and created_by='".$_SESSION['uid']."'  ),
mtd_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='".$current_month."' and created_by='".$_SESSION['uid']."'  ),
mtd_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='".$current_month."' and created_by='".$_SESSION['uid']."' )";
}

//echo $cmq;
			$mtd_box_qry_exe=odbc_exec($conn,$mtd_box_qry);
			$mtdf=odbc_fetch_array($mtd_box_qry_exe);
					
 ?>  

 <span class="label label-warning" title="No. of Deals in Added in Current Month" style="cursor:help;">
 	<i class="icon-folder-open"></i> <?php echo $mtdf['mtd_total_deal']?>
 </span>

 <span class="label label-success" title="No Leads Won in Current Month" style="cursor:help;">
 	<i class="icon-trophy"></i> <?php echo $mtdf['mtd_won_deal']?>
 </span>

 <span class="label label-important" title=" Total Lost Value: <?php echo valchar($mtdf['mtd_lost_deal'])?> | No. of Lost Leads: <?php echo $mtdf['mtd_lost_count'] ?>" style="cursor:help;">
 	<i class="icon-lock"></i> <?php echo valchar1($mtdf['mtd_lost_deal']).''?></span>
    
    
    
											</div>
										</div>
									</div>
                                    




 <!--ANUAL Target Vs Achievement START-->
<?php
			if(trim($_SESSION['user_type'])=='management') {

			$aaq=" select 
apr=(select sum(apr) from sales_achievement),
may=(select sum(may) from sales_achievement),
jun=(select sum(jun) from sales_achievement),
jul=(select sum(jul) from sales_achievement),
aug=(select sum(aug) from sales_achievement),
sep=(select sum(sep) from sales_achievement),
oct=(select sum(oct) from sales_achievement),
nov=(select sum(nov) from sales_achievement),
dec=(select sum(dec) from sales_achievement),
jan=(select sum(jan) from sales_achievement),
feb=(select sum(feb) from sales_achievement),
mar=(select sum(mar) from sales_achievement)";

			$aaqe=odbc_exec($conn,$aaq);
			$aaf=odbc_fetch_array($aaqe);

			$atq=" select 
apr=(select sum(apr) from sales_achievement),
may=(select sum(may) from sales_achievement),
jun=(select sum(jun) from sales_achievement),
jul=(select sum(jul) from sales_achievement),
aug=(select sum(aug) from sales_achievement),
sep=(select sum(sep) from sales_achievement),
oct=(select sum(oct) from sales_achievement),
nov=(select sum(nov) from sales_achievement),
dec=(select sum(dec) from sales_achievement),
jan=(select sum(jan) from sales_achievement),
feb=(select sum(feb) from sales_achievement),
mar=(select sum(mar) from sales_achievement)";

			$atqe=odbc_exec($conn,$atq);
			$atf=odbc_fetch_array($atqe);


			$anual_target= array_sum($atf);
			$anual_achievement= array_sum($aaf);
				
			$aap=number_format(($anual_achievement/$anual_target*100), 1, '.', '');
			
			}else{
				$anual_target= array_sum($targetArray);
				$anual_achievement= array_sum($achievementArray);
				$aap=number_format(($anual_achievement/$anual_target*100), 1, '.', '');
			}
					
 ?>  
                                    
									<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
										<div class="circle-stat block">
											<div class="visual">
												<input class="knobify" data-width="115" data-fgcolor="#339966" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="<?php echo $aap?>" data-max="150" data-min="-100" title="<?php echo $mtdap?>% of Annual Sales Achievement"/>
											</div>
											<div class="details">
												<div class="title">Annual <i class="icon-caret-up"></i></div>

	<div class="number"><?php echo valchar($anual_achievement)?></div>

 
<!--Yearly WON / LOST-->
<?php

if(trim($_SESSION['user_type'])=='management') {
$annual_box_qry="select 
annual_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '04' and MONTH(closure_won_date)<='12' ),
annual_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='12' ),
annual_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='12' )";

}else{
$annual_box_qry="select 
annual_won_deal=(select count(*) from opportunity where MONTH(closure_won_date) >= '04' and MONTH(closure_won_date)<='12' and created_by='".$_SESSION['uid']."'  ),
annual_lost_count=(select count(*) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='12' and created_by='".$_SESSION['uid']."'  ),
annual_lost_deal=(select sum(obl_sale_forecast_inr) from opportunity where MONTH(lost_date) >= '04' and MONTH(lost_date)<='12' and created_by='".$_SESSION['uid']."' )";
}

//echo $cmq;
			$annual_box_qry_exe=odbc_exec($conn,$annual_box_qry);
			$annualf=odbc_fetch_array($annual_box_qry_exe);
					
 ?>  

 <span class="label label-success" title="WON Leads" style="cursor:help;"><i class="icon-trophy"></i> <?php echo $annualf['annual_won_deal']?></span>
 
 <span class="label label-important" title="L Total Lost Value: <?php echo valchar($annualf['annual_lost_deal'])?> | No. of Lost Leads: <?php echo $annualf['annual_lost_count'] ?>" style="cursor:help;"><i class="icon-lock"></i> <?php echo valchar($annualf['annual_lost_deal'])?></span>
 
 											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

													</div>

<!--vineet new table data start-->

                    <div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3" style="width:100%;">

 
<div class="portlet box blue" style="padding-left:120px;">
							<div class="portlet-title">
								<h4><i class="icon-signal"></i>Regional Level Pipeline Split</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row-fluid">

				 <table width="100%" border="1" style=" font:14px Verdana, Geneva, sans-serif; ">
									<thead>
										<tr align="center">
                            <th rowspan="2" width="13%">Sales Phase</th>
                            <th colspan="2" style="background-color:#27a9e3; color:#FFF; font-size:16px;">North & Central</th>
                            <th colspan="2" style="background-color:#852b99; color:#FFF; font-size:16px;">East</th>
                            <th colspan="2" style="background-color:#d8076e; color:#FFF; font-size:16px;">South</th>
                            <th colspan="2" style="background-color:#666666; color:#FFF; font-size:16px;">West</th>
                            <th rowspan="2" width="8%">Total</th>

                                        </tr>


										<tr align="center">
                                            <td bgcolor="#fffb92">Forcasted Sales</td>
                                            <td bgcolor="#fffb92">% of Total</td>

                                            <td bgcolor="#fffb92">Forcasted Sales </td>
                                            <td bgcolor="#fffb92">% of Total</td>

                                            <td bgcolor="#fffb92">Forcasted Sales </td>
                                            <td bgcolor="#fffb92">% of Total</td>

                                            <td bgcolor="#fffb92">Forcasted Sales </td>
                                            <td bgcolor="#fffb92">% of Total</td>

                                        </tr>
<?php
	$stage=array('Opportunity', 'First Discussion', 'Sampling', 'Product Approval', 'Quotation', 'Closure');

	$nc_fs=0;$nc_tot=0;
	$east_fs=0;$east_tot=0;
	$west_fs=0;$west_tot=0;
	$south_fs=0;$south_tot=0;
	
	for($x=1; $x<=sizeof($stage); $x++){
		
		  
$reg_sql="
 select 
	ncsum=(select sum(obl_sale_forecast_inr) as fc from opportunity o
			left join state_master s on o.state_id=s.state_id
			where o.[status]<>'lost' and o.[current_stage]=".$x." and s.zone='North&Central') , 

	east = (select sum(obl_sale_forecast_inr) as fc from opportunity o
			left join state_master s on o.state_id=s.state_id
			where o.[status]<>'lost' and o.[current_stage]=".$x." and s.zone='East') , 

   
    west = (select sum(obl_sale_forecast_inr) as fc from opportunity o
			left join state_master s on o.state_id=s.state_id
			where o.[status]<>'lost' and o.[current_stage]=".$x." and s.zone='West') , 

   
    south = (select sum(obl_sale_forecast_inr) as fc from opportunity o
			left join state_master s on o.state_id=s.state_id
			where o.[status]<>'lost' and o.[current_stage]=".$x." and s.zone='South') ,

	tot_opp=(select sum(obl_sale_forecast_inr) as fc from opportunity o where o.[current_stage]=".$x." and o.[status]<>'lost')
  "; 

$reg_sqlexe=odbc_exec($conn,$reg_sql);
$ftch=odbc_fetch_array($reg_sqlexe);

		echo '<tr align="right">';
					echo  '<td align="left">'.$stage[$x-1].'</td>';
					
					$sum=0;

					echo '<td>&#8377 '.valchar($ftch['ncsum']).'</td>';
							$sum=$sum+$ftch['ncsum'];
							$nc_fs=$nc_fs+$ftch['ncsum'];
							
					echo '<td>'.number_format(($ftch['ncsum']/$ftch['tot_opp']*100), 1, '.', '').' %</td>';
					

					echo '<td>&#8377 '.valchar($ftch['east']).'</td>';
							$sum=$sum+$ftch['east'];
							$east_fs=$east_fs+$ftch['east'];
					echo '<td>'.number_format(($ftch['east']/$ftch['tot_opp']*100), 1, '.', '').' %</td>';


					echo '<td>&#8377 '.valchar($ftch['west']).'</td>';
							$sum=$sum+$ftch['west'];
							$west_fs=$west_fs+$ftch['west'];
					echo '<td>'.number_format(($ftch['west']/$ftch['tot_opp']*100), 1, '.', '').' %</td>';

					echo '<td>&#8377 '.valchar($ftch['south']).'</td>';
							$sum=$sum+$ftch['south'];
							$south_fs=$south_fs+$ftch['south'];
					echo '<td>'.number_format(($ftch['south']/$ftch['tot_opp']*100), 1, '.', '').' %</td>';
					
					echo '<th>'.valchar($sum).'</th>';
					
				echo '</tr>';

	}
	
?>
										<tr align="right" >
                                            <th align="left">Total</th>

										<?php $total_val=$nc_fs+$east_fs+$south_fs+$west_fs; ?>
                                        
                                            <th><?php echo valchar($nc_fs)?></th>
                                            <th><?php echo number_format(($nc_fs/$total_val*100), 1, '.', '')?>%</th>


                                            <th ><?php echo valchar($east_fs)?></th>
                                            <th><?php echo number_format(($east_fs/$total_val*100), 1, '.', '')?>%</th>

                                            <th ><?php echo valchar($south_fs)?></th>
                                            <th><?php echo number_format(($south_fs/$total_val*100), 1, '.', '')?>%</th>

                                            <th ><?php echo valchar($west_fs)?></th>
                                            <th><?php echo number_format(($west_fs/$total_val*100), 1, '.', '')?>%</th>
											
                                            <th ><?php echo valchar($total_val)?></th>
                                        </tr>


									</thead>
									<tbody>
</tbody>
</table>                                                                       
									
								</div>
							</div>
						</div>
					</div>

													</div>

<!--vineet new table data ends -->

<!--top 5 SKU start-->

                    <div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3" style="width:100%;">

 
<div class="portlet box blue" style="padding-left:120px;">
							<div class="portlet-title">
								<h4><i class="icon-signal"></i>TOP 5 SKU <font size="2">&nbsp;(Dummy Data)</font></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row-fluid">

				 <table width="100%" border="1" style=" font:14px Verdana, Geneva, sans-serif; ">
									<thead>
										<tr align="center">
                            <th  style="background-color:#27a9e3; color:#FFF; font-size:16px;">Size</th>
                            <th  style="background-color:#ef9f21; color:#FFF; font-size:16px;">Category</th>
                            <th  style="background-color:#852b99; color:#FFF; font-size:16px;">Qty (Sqmt)</th>
                            <th  style="background-color:#d8076e; color:#FFF; font-size:16px;">Value (INR)</th>
                            <th  style="background-color:#666666; color:#FFF; font-size:16px;">ASP</th>

                                        </tr>


										<tr align="center">
                                            <td>600x600</td>
                                            <td>DC</td>
                                            <td>8 LAC</td>
                                            <td>3.2 CR</td>
                                            <td>400</td>
                                        </tr>

										<tr align="center">
                                            <td>600x600</td>
                                            <td>PVT</td>
                                            <td>10 LAC</td>
                                            <td>3 CR</td>
                                            <td>300</td>
                                        </tr>

										<tr align="center">
                                            <td>300x300</td>
                                            <td>Ceramic</td>
                                            <td>12 LAC</td>
                                            <td>2.4 CR</td>
                                            <td>200</td>
                                        </tr>

										<tr align="center">
                                            <td>200x300</td>
                                            <td>Ceramic</td>
                                            <td>10 LAC</td>
                                            <td>2 CR</td>
                                            <td>200</td>
                                        </tr>

										<tr align="center">
                                            <td>300x450</td>
                                            <td>Ceramic</td>
                                            <td>5 LAC</td>
                                            <td>1.3 CR</td>
                                            <td>250</td>
                                        </tr>


									</thead>
									<tbody>
</tbody>
</table>                                                                       
									
								</div>
							</div>
						</div>
					</div>

													</div>


<!-- top 5 SKU ends -->



<!--vin new start -->
<!-- other content area--> 

				<div class="row-fluid">
					<div class="span6">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-bell"></i>TOP 5 CKA's <font size="2">&nbsp;</font></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th><i class="icon-briefcase"></i> CKA Name </th>                                            
											<th  class="hidden-phone"><i class="icon-flag"></i> OBL Potential</th>
											<th class="hidden-phone"><i class="icon-trophy"></i> Won</th>
											<th><i class="icon-lock"></i> Lost</th>
										</tr>
									</thead>
                                    <tbody>

<?php
			if(trim($_SESSION['user_type'])=='management') {
$ttv="select top 5 cka_name_id, sum(o.obl_sale_forecast_inr) as amt, count(obl_sale_forecast_inr) as cnt from opportunity o 
group by o.cka_name_id order by amt desc";
			}else{
$ttv="
 select top 5 cka_name_id, sum(o.obl_sale_forecast_inr) as amt, count(obl_sale_forecast_inr) as cnt from opportunity o 
 where o.created_by='".$_SESSION['uid']."' 
 group by o.cka_name_id order by amt desc";
			}

					$tte=odbc_exec($conn,$ttv);
					while($ttf=odbc_fetch_array($tte)){

		if(trim($_SESSION['user_type'])=='management') {
			$wq=" select lost= (select sum(obl_sale_forecast_inr) from  opportunity where cka_name_id ='".$ttf['cka_name_id']."' and [status]='lost') , 
				c.cka_name, sum(won_po_value)  as won from opportunity o 
				left join cka_name_master c 
				on c.cka_name_id = o.cka_name_id where o.cka_name_id ='".$ttf['cka_name_id']."'  group by c.cka_name ";
		}else{
			$wq=" select lost= (select sum(obl_sale_forecast_inr) from  opportunity where cka_name_id ='".$ttf['cka_name_id']."' and [status]='lost') , 
				c.cka_name, sum(won_po_value)  as won from opportunity o 
				left join cka_name_master c 
			on c.cka_name_id = o.cka_name_id where o.cka_name_id ='".$ttf['cka_name_id']."'  group by c.cka_name ";

		}
			// $wq.'<br><br>';
				$wqe=odbc_exec($conn,$wq);
				$wqf=odbc_fetch_array($wqe);
			

						echo '<tr align="center">';
							echo '<td class="highlight">';
							echo '<div class="success"></div>';
							echo '<a href="#">'.trim($wqf['cka_name']).'</a>';
							echo '</td>';
							echo '<td>&#8377 '.valchar($ttf['amt']).'</td>';
							echo '<td>&#8377 '.valchar($wqf['won']).'</td>';
							echo '<td>&#8377 '.valchar($ttf['lost']).'</td>';
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
								<h4><i class="icon-shopping-cart"></i>Bottom 5 CKA's <font size="2">&nbsp;</font></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th><i class="icon-briefcase"></i> CKA Name </th>                                            
											<th class="hidden-phone"><i class="icon-flag"></i> OBL Potential</th>
											<th class="hidden-phone"><i class="icon-trophy"></i> Won</th>
											<th><i class="icon-lock"></i> Lost</th>
										</tr>
									</thead>

<?php
			if(trim($_SESSION['user_type'])=='management') {
$ttv="select top 5 cka_name_id, sum(o.obl_sale_forecast_inr) as amt, count(obl_sale_forecast_inr) as cnt from opportunity o 
group by o.cka_name_id order by amt asc";
			}else{
$ttv="
 select top 5 cka_name_id, sum(o.obl_sale_forecast_inr) as amt, count(obl_sale_forecast_inr) as cnt from opportunity o 
 where o.created_by='".$_SESSION['uid']."' 
 group by o.cka_name_id order by amt asc";
			}

//echo '<br><br>'.$ttv;
					$tte=odbc_exec($conn,$ttv);
					while($ttf=odbc_fetch_array($tte)){

		if(trim($_SESSION['user_type'])=='management') {
			$wq=" select lost= (select sum(obl_sale_forecast_inr) from  opportunity where cka_name_id ='".$ttf['cka_name_id']."' and [status]='lost') , 
				c.cka_name, sum(won_po_value)  as won from opportunity o 
				left join cka_name_master c 
				on c.cka_name_id = o.cka_name_id where o.cka_name_id ='".$ttf['cka_name_id']."'  group by c.cka_name ";
		}else{
			$wq=" select lost= (select sum(obl_sale_forecast_inr) from  opportunity where cka_name_id ='".$ttf['cka_name_id']."' and [status]='lost') , 
				c.cka_name, sum(won_po_value)  as won from opportunity o 
				left join cka_name_master c 
			on c.cka_name_id = o.cka_name_id where o.cka_name_id ='".$ttf['cka_name_id']."'  group by c.cka_name ";
		}
			//echo $wq.'<br><br>';
				$wqe=odbc_exec($conn,$wq);
				$wqf=odbc_fetch_array($wqe);
			

						echo '<tr align="center">';
							echo '<td class="highlight">';
							echo '<div class="success"></div>';
							echo '<a href="#">'.trim($wqf['cka_name']).'</a>';
							echo '</td>';
							echo '<td>&#8377 '.valchar($ttf['amt']).'</td>';
							echo '<td>&#8377 '.valchar($wqf['won']).'</td>';
							echo '<td>&#8377 '.valchar($ttf['lost']).'</td>';
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

<!-- vin new ends -->

<!-- other content area--> 

				<div class="row-fluid">
					<div class="span6">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-bell"></i>TOP 10 Pipeline Deals</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<!--<th><i class="icon-briefcase"></i> CKA Name </th>-->
											<th width="40%"><i class="icon-briefcase"></i> Project Name </th>                                            
											<th class="hidden-phone"><i class="icon-flag"></i> State</th>
											<th class="hidden-phone"><i class="icon-map-marker"></i> City</th>
											<th><i class="icon-shopping-cart"></i> Total INR</th>
										</tr>
									</thead>
                                    <tbody>
<?php
			if(trim($_SESSION['user_type'])=='management') {
$ttv="SELECT top 10 c.cka_name,o.project_name, s.state_name,o.city, o.project_name,o.project_tile_potential_inr, o.obl_sale_forecast_inr  FROM opportunity o, cka_name_master c, state_master s
where o.[status]='open' 
and c.cka_name_id = o.cka_name_id and s.state_id= o.state_id
order by o.obl_sale_forecast_inr desc ";
			}else{
$ttv="SELECT top 10 c.cka_name,o.project_name, s.state_name,o.city, o.project_name,o.project_tile_potential_inr,o.obl_sale_forecast_inr  FROM opportunity o, cka_name_master c, state_master s
where o.[status]='open' 
and o.created_by='".$_SESSION['uid']."' 
and c.cka_name_id = o.cka_name_id and s.state_id= o.state_id
order by o.obl_sale_forecast_inr desc ";
			}

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
							echo '<td>&#8377 '.valchar($ttf['obl_sale_forecast_inr']).'</td>';
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
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
																<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th width="35%"><i class="icon-briefcase"></i> CKA Name </th>
											<th class="hidden-phone"><i class="icon-flag"></i> State</th>
											<th class="hidden-phone"><i class="icon-trash"></i> Stage</th>
											<th><i class="icon-shopping-cart"></i> Total INR</th>
										</tr>
									</thead>
                                    <tbody>
<?php
	if(trim($_SESSION['user_type'])=='management') {
$ttv="SELECT top 10 c.cka_name,o.project_name, s.state_name,o.current_stage, o.project_tile_potential_inr,o.obl_sale_forecast_inr  FROM opportunity o, cka_name_master c, state_master s
where o.[status]='lost' 
and c.cka_name_id = o.cka_name_id and s.state_id= o.state_id
order by o.obl_sale_forecast_inr desc";
	
	}else{
$ttv="SELECT top 10 c.cka_name,o.project_name, s.state_name,o.current_stage, o.project_tile_potential_inr,o.obl_sale_forecast_inr  FROM opportunity o, cka_name_master c, state_master s
where o.[status]='lost' 
and o.created_by='".$_SESSION['uid']."' 
and c.cka_name_id = o.cka_name_id and s.state_id= o.state_id
order by o.obl_sale_forecast_inr desc";
	}
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
