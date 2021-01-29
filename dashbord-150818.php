<?php

 ob_implicit_flush(true);
ob_end_flush();
 include_once('including/all-include.php');

	if(!empty($_GET['factory_id'])){
	
	 $_SESSION['factory-id']				= base64_decode($_GET['factory_id']);
	 $_SESSION['login-factory']				= base64_decode($_GET['factname']);
	
	}
 include_once('including/header.php');
 
// print_r($_SESSION);
/*
if(trim($_SESSION['user_type'])=='management') {
	 $hsqa="SELECT current_stage, COUNT(*) as no, sum(obl_sale_forecast_inr) as project, sum(won_po_value) as won_po_value FROM opportunity where [status]<>'lost'  GROUP BY current_stage";
}else{
	 $hsqa="SELECT current_stage, COUNT(*) as no, sum(obl_sale_forecast_inr) as project, sum(won_po_value) as won_po_value FROM opportunity where [status]<>'lost' and created_by='".$_SESSION['uid']."'  GROUP BY current_stage";
}
*/

//vks starting

          if(trim($_SESSION['user_type'])=='management') {
		  $hsqa="SELECT t.stage_name as opportunityname, COUNT(*) as no, sum(o.obl_sale_forecast_inr) as project, sum(o.won_po_value) as won_po_value FROM opportunity o
				 left join pmt_current_stage t on t.stage_id = o.current_stage
  
				 where o.status<>'lost' and o.state_id is not null GROUP BY t.stage_name";
	}else{
			//$headersql="SELECT count(*) as headercnt,sum(obl_sale_forecast_inr) as fcast, current_stage FROM [opportunity]   
			//			where created_by='".$_SESSION['uid']."' and [status]='open' group by current_stage  ";

		//vineet start
		$hsqa="SELECT count(*) as no,sum(d.obl_sale_forecast_inr) as project, sum(d.won_po_value) as won_po_value, current_stage FROM [opportunity] d
left join cka_name_master a on a.cka_name_id = d. cka_name_id  
 ";


    if(trim($_SESSION['user_type'])=='management') {
		$hsqa.="  where [status]<>'lost' group by current_stage";
	}else{

			if($_SESSION['employee_department']=='Retail'){
				$hsqa.=" where d.deal_type='Retail' 
						and d.territory in (".$_SESSION['employee_territory'].") 
						group by current_stage ";
			}


			if($_SESSION['employee_department']=='CKA'){

					if($_SESSION['user_type']=='manager'){
					
					$hsqa.=" where [status]<>'lost' 
						and ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$hsqa .="a.cka_mapped_with_emp = '".$vx."' ";
							else
								$hsqa .=" or a.cka_mapped_with_emp = '".$vx."' ";
							$xcnt++;
						}
						$hsqa .=" )group by current_stage ";
					}else{
						$hsqa.=" where ( d.deal_type='CKA') and ( ";

						$ex=explode(",",$_SESSION['emp_cka_mapping']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$hsqa .="d.cka_name_id = '".$vx."' ";
							else
								$hsqa .=" or d.cka_name_id = '".$vx."' ";
							$xcnt++;
						}

						$hsqa .=" )group by current_stage ";
					}

				//echo $sql;
			}

			if($_SESSION['employee_department']=='BD' || $_SESSION['employee_department']=='GPS'){
					
					if($_SESSION['user_type']=='manager'){
					$hsqa.=" where [status]<>'lost' 
						and ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$hsqa .="d.created_by = '".$vx."' or d.created_by='".$_SESSION['uid']."' ";
							else
								$hsqa .=" or d.created_by = '".$vx."' ";
							$xcnt++;
						}
						$hsqa .=" )group by current_stage ";
					}else{
						$hsqa.="  where d.created_by='".$_SESSION['uid']."' 
						group by current_stage ";	
					}

			}
		
	}

		//vineet ends
	}
//vks ending
					//echo $hsqa;
					
					$hee=odbc_exec($conn,$hsqa);
					$heee=odbc_exec($conn,$hsqa);
					$heeesum=odbc_exec($conn,$hsqa);
					while($hxx=odbc_fetch_array($hee)){
					//print_r($hxx);
					//exit();
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
								$current_stage = "Opportunity";
							}
							
							if(trim($hxx['current_stage'])=='3'){
								$samplingval=$hxx['project'];
								$samplingno=$hxx['no'];
								$sad=round($samplingval/$samplingno);
								$current_stage = "Sampling";
							}
							
							if(trim($hxx['current_stage'])=='4'){
								$productapproval=$hxx['project'];
								$productapprovalno=$hxx['no'];
								$pad=round($productapproval/$productapprovalno);
								$current_stage = "Product Approval";
							}
							
							if(trim($hxx['current_stage'])=='5'){
								$quotation=$hxx['project'];
								$quotationno=$hxx['no'];
								$qad=round($quotation/$quotationno);
								$current_stage = "Quotation";
							}
							
							if(trim($hxx['current_stage'])=='6'){
								$negotiation=$hxx['project'];
								$negotiationno=$hxx['no'];
								$nad=round($negotiation/$negotiationno);
								$current_stage = "Negotiation";
							}
							
							if(trim($hxx['current_stage'])=='7'){
								$won=$hxx['won_po_value'];
								$wonno=$hxx['no'];
								$wad=round($won/$wonno);
								$current_stage = "Closure Won";
							}
										//echo $l;
					}
			
			if(trim($_SESSION['user_type'])=='management') {
			$lq="SELECT  COUNT(*) as totallost,  sum(obl_sale_forecast_inr) as project  FROM opportunity where [status]='lost' ";

			}else{
			//$lq="SELECT  COUNT(*) as totallost,  sum(obl_sale_forecast_inr) as project  FROM opportunity where [status]='lost' and created_by='".$_SESSION['uid']."' ";
			
			$lq="SELECT  COUNT(*) as totallost,  sum(obl_sale_forecast_inr) as project  FROM dashboard_view_tbl where [status]='lost' and view_data_visible_to='".$_SESSION['uid']."' ";

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

					  
		  
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
</script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Pipeline', 'Summary'],
		  <?php 
			while($hxx=odbc_fetch_array($heee)){
				echo "['".$hxx["opportunityname"]."', ".$hxx["no"]."],";
			}
		  ?>
          
        ]);

        var options = {
          title: 'Pipeline Summary'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['North & Central',  11],
          ['East', 7],
          ['West', 9],
          ['South', 5]
          
        ]);

        var options = {
          title: 'Zone Wise Pipeline Summary',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php 
			while($hxx1=odbc_fetch_array($heeesum)){
				
				echo "['".$hxx1["opportunityname"]."', ".$hxx1["project"]."],";
			}
		  ?>
        ]);

        var options = {
          title: 'Pipeline Sales Forecast',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
         ['Month', 'Opportunity', 'First Discussion', 'Sampling', 'Product Approval', 'Quotation', 'Negotiation', 'Won', 'Average'],
         
         ['Mar 18',  157,      1167,        587,             807,           397,     	397,		807,	 623],
         ['Apr 18',  139,      1110,        615,             968,           215,  		1268,		807,    609.4],
		 ['May 18',  439,      810,         215,             668,           615,  		268,		507,    409.4],
         ['Jun 18',  136,      691,         629,             1026,          366,    	807,		397,	  569.6],
		 ['Jul 18',  165,      938,         522,             998,           450, 		807,		268,     614.6],
         ['Aug 18',  135,      1120,        599,             1268,          288,    	1268,		397,	  682]
      ]);

    var options = {
      title : 'Monthly Pipeline Summary (Last 6 Months)',
      vAxis: {title: 'Pipeline'},
      hAxis: {title: 'Month'},
      seriesType: 'bars',
      series: {7: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script>
	
	<script type="text/javascript">
    google.charts.load('current', {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var oldData = google.visualization.arrayToDataTable([
      ['Name', 'Pipeline 2017'],
      ['Opportunity', 8250],
      ['first Discussion', 4200],
      ['Sampling', 2900],
      ['Product Approval', 2200],
	  ['Quotation', 3200],
	  ['Negotiation', 5200],
	  ['Closure Won', 200]
    ]);

    var newData = google.visualization.arrayToDataTable([
      ['Name', 'Pipeline 2018'],
      ['Opportunity', 8250],
      ['first Discussion', 4200],
      ['Sampling', 2900],
      ['Product Approval', 2200],
	  ['Quotation', 3200],
	  ['Negotiation', 5200],
	  ['Closure Won', 200]
    ]);

    var colChartBefore = new google.visualization.ColumnChart(document.getElementById('colchart_before'));
    var colChartAfter = new google.visualization.ColumnChart(document.getElementById('colchart_after'));
    var colChartDiff = new google.visualization.ColumnChart(document.getElementById('colchart_diff'));
    var barChartDiff = new google.visualization.BarChart(document.getElementById('barchart_diff'));

    var options = { legend: { position: 'top' } };

    colChartBefore.draw(oldData, options);
    colChartAfter.draw(newData, options);

    var diffData = colChartDiff.computeDiff(oldData, newData);
    colChartDiff.draw(diffData, options);
    barChartDiff.draw(diffData, options);
  }
</script>

		<div id="dashboard">
					
					<!-- BEGIN DASHBOARD STATS 
					
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
								<?php echo (empty($oppno))?'0':$oppno?> DEALS  | Avg Deal: &#8377 <?php echo valchar($oad) ?> <i class="m-icon-swapright m-icon-white"></i>
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
								<?php echo (empty($fldno))?'0':$fldno?> DEALS | Avg Deal: <?php echo valchar($fad) ?> <i class="m-icon-swapright m-icon-white"></i>
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
								<?php echo (empty($samplingno))?'0':$samplingno?> DEALS | Avg Deal: <?php echo valchar($sad) ?> <i class="m-icon-swapright m-icon-white"></i>
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
								<?php echo (empty($productapprovalno))?'0':$productapprovalno?> DEALS  | Avg Deal: <?php echo valchar($pad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
					</div> -->
                    
					<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS 
					
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
								<?php echo (empty($quotationno))?'0':$quotationno?> DEALS | Avg Deal: <?php echo valchar($qad) ?> <i class="m-icon-swapright m-icon-white"></i>
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
								<?php echo (empty($negotiationno))?'0':$negotiationno?> DEALS  | Avg Deal: <?php echo valchar($nad) ?> <i class="m-icon-swapright m-icon-white"></i>
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
									<div class="desc">Closure WON</div>
								</div>
								<a class="more" href="list-won-opportunity.php" style="font-size:12px;">
								<?php echo (empty($wonno))?'0':$wonno?> DEALS  | Avg Deal: <?php echo valchar($wad) ?> <i class="m-icon-swapright m-icon-white"></i>
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
									<div class="desc">Closure LOST</div>
								</div>
								<a class="more" href="list-lost-opportunity.php" style="font-size:12px;">
								<?php echo $lv['totallost']?> DEALS | Avg Deal: <?php echo valchar($lad) ?> <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
					</div> -->

			<div class="row-fluid">
			
				<div class="col-sm-5" id="piechart" style="width: 40%; height: 300px;  float: left;"></div>
				<div class="col-sm-4" id="piechart_3d" style="width: 30%; height: 300px; float: left;"></div>
				<div class="col-sm-3" id="donutchart" style="width: 30%; height: 300px; float: left;"></div>
			
			</div>
			<div class="row-fluid">
			<div id="chart_div" style="width: 100%; height: 400px;"></div>
			</div>
			<div class="row-fluid">
				<span id='colchart_before' style="width: 50%; height: 300px; float:left;"></span>
				<span id='colchart_after' style="width: 50%; height: 300px; float:left;"></span>
				
			</div>
			<div class="row-fluid">
				<span id='colchart_diff' style="width: 50%; height: 300px; float:left;"></span>
				<span id='barchart_diff' style="width: 50%; height: 300px; float:left;"></span>
			</div>
								   
			<!-- END PAGE HEADER-->
					


                    
                    

<!--vineet new table data start-->
<?php //*********************************DADHBOARD VIEW TABLE QUERY START HERE ********************************************** ?>

<?php
		$sql="SELECT 
		d.opportunity_id,
		d.cka_name_id,
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
	 d.project_tile_potential_inr, 
	 d.[probability_of_win],
     d.[status],
	 d.deal_type, 
	 d.territory, 
	 d.current_stage, 
	 d.closure_won_date, 
	 d.won_po_value, 
	 d.lost_date, 
	 u.fullname as created_by
  FROM [opportunity] d
  left join cka_name_master a on a.cka_name_id = d. cka_name_id
  left join cka_type_master b on b.cka_type_id = d.cka_type_id
  left join project_type_master c on c.project_type_id = d.project_type_id
  left join state_master e on e.state_id = d.state_id 
  left join user_management u on d.created_by = u.uid
  ";
  
    if(trim($_SESSION['user_type'])=='management') {
		$sql.="  where 1=1 order by obl_sale_forecast_inr desc ";
	}else{

			if($_SESSION['employee_department']=='Retail'){
				$sql.=" where d.deal_type='Retail' 
						and d.territory in (".$_SESSION['employee_territory'].") 
						order by obl_sale_forecast_inr desc ";
			}


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
						$sql .=" )order by obl_sale_forecast_inr desc ";
					}else{
						$sql.=" where ( d.deal_type='CKA') and ( ";

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

			if($_SESSION['employee_department']=='BD' || $_SESSION['employee_department']=='GPS'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where 1=1 
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
						$sql .=" )order by obl_sale_forecast_inr desc ";
					}else{
						$sql.="  where d.created_by='".$_SESSION['uid']."' 
						order by obl_sale_forecast_inr desc ";	
					}

			}
		
	}


	
	$rs=odbc_exec($conn,$sql);
	$count=1;

	$del_view_data="DELETE from dashboard_view_tbl where view_data_visible_to= '".$_SESSION['uid']."' ";
	$del_view_data_exe=odbc_exec($conn,$del_view_data);

	while($f = odbc_fetch_array($rs)){
//		echo $_SESSION['uid'];
//echo '<pre>';
//	print_r($f);
	
  $view_qry="INSERT into dashboard_view_tbl 
		   ( 
			opportunity_id ,cka_name ,cka_name_id ,cka_type ,project_type ,project_name ,state_name ,zone ,city
            ,architect_name, tile_stage_date ,obl_sale_forecast_inr ,project_tile_potential_inr, probability_of_win ,status ,deal_type ,territory
            ,current_stage ,created_by ,closure_won_date, won_po_value, lost_date, lost_by, reason_for_lost, view_data_visible_to 
		   ) 
		   VALUES 
		   (
   '".$f['opportunity_id']."', '".dbInput($f['cka_name'])."', '".$f['cka_name_id']."', '".$f['cka_type']."', '".$f['project_type']."', 
   '".dbInput($f['project_name'])."', 
		   '".$f['state_name']."', '".$f['zone']."', '".dbInput($f['city'])."', '".dbInput($f['architect_name'])."', '".$f['tile_stage_date']."',  
		   '".$f['obl_sale_forecast_inr']."', '".$f['project_tile_potential_inr']."', '".$f['probability_of_win']."', 
		   '".$f['status']."', '".$f['deal_type']."', '".$f['territory']."', '".$f['current_stage']."', '".$f['created_by']."', 
		   '".$f['closure_won_date']."', '".$f['won_po_value']."', '".$f['lost_date']."', '".$f[lost_by]."', '".$f[reason_for_lost]."', '".$_SESSION['uid']."'  
		   )
		   ";

		$view_qry_exe=odbc_exec($conn,$view_qry);
//echo '<br><br>';
	}
?>


<?php //********************************* query ending ********************************************** ?>


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
                                            <td bgcolor="#fffb92">Pipeline Sales</td>
                                            <td bgcolor="#fffb92">% of Total</td>

                                            <td bgcolor="#fffb92">Pipeline Sales </td>
                                            <td bgcolor="#fffb92">% of Total</td>

                                            <td bgcolor="#fffb92">Pipeline Sales </td>
                                            <td bgcolor="#fffb92">% of Total</td>

                                            <td bgcolor="#fffb92">Pipeline Sales </td>
                                            <td bgcolor="#fffb92">% of Total</td>

                                        </tr>
<?php
	$stage=array('Opportunity', 'First Discussion', 'Sampling', 'Product Approval', 'Quotation', 'Negotiation', 'Closure Won');

	$nc_fs=0;$nc_tot=0;
	$east_fs=0;$east_tot=0;
	$west_fs=0;$west_tot=0;
	$south_fs=0;$south_tot=0;
	
	for($x=1; $x<=sizeof($stage); $x++){

		if($x==7){
			$sum_field='won_po_value';
		}else{
			$sum_field='obl_sale_forecast_inr';
		}
		
	$reg_sql="
 select 
	ncsum=(select sum(".$sum_field.") as fc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." and o.zone='North&Central' and o.view_data_visible_to='".$_SESSION['uid']."' ) , 

	east = (select sum(".$sum_field.") as fc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." and o.zone='East' and o.view_data_visible_to='".$_SESSION['uid']."' ) , 

   
    west = (select sum(".$sum_field.") as fc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." and o.zone='West' and o.view_data_visible_to='".$_SESSION['uid']."' ) , 

   
    south = (select sum(".$sum_field.") as fc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." and o.zone='South' and o.view_data_visible_to='".$_SESSION['uid']."' ) ,

	tot_opp=(select sum(".$sum_field.") as fc from dashboard_view_tbl o where o.[current_stage]=".$x." and o.[status]<>'lost' and o.view_data_visible_to='".$_SESSION['uid']."' )
  "; 


//echo $x.'--<br><br>'.$reg_sql;


$reg_sqlexe=odbc_exec($conn,$reg_sql);
$ftch=odbc_fetch_array($reg_sqlexe);

		echo '<tr align="right">';
					echo  '<td align="left">'.$stage[$x-1].'</td>';
					
					$sum=0;

					echo '<td>&#8377 '.valchar($ftch['ncsum']).'</td>';
							$sum=$sum+$ftch['ncsum'];
							$nc_fs=$nc_fs+$ftch['ncsum'];
							
					if($ftch['tot_opp']==0){
						echo '<td>0 %</td>';
					}else{
						echo '<td>'.number_format(($ftch['ncsum']/$ftch['tot_opp']*100), 0, '.', '').' %</td>';
					}

					echo '<td>&#8377 '.valchar($ftch['east']).'</td>';
							$sum=$sum+$ftch['east'];
							$east_fs=$east_fs+$ftch['east'];

					if($ftch['tot_opp']==0){
						echo '<td>0 %</td>';
					}else{
						echo '<td>'.number_format(($ftch['east']/$ftch['tot_opp']*100), 0, '.', '').' %</td>';
					}

					
					
					echo '<td>&#8377 '.valchar($ftch['south']).'</td>';
							$sum=$sum+$ftch['south'];
							$south_fs=$south_fs+$ftch['south'];

					if($ftch['tot_opp']==0){
						echo '<td>0 %</td>';
					}else{
						echo '<td>'.number_format(($ftch['south']/$ftch['tot_opp']*100), 0, '.', '').' %</td>';
					}

										
					echo '<td>&#8377 '.valchar($ftch['west']).'</td>';
							$sum=$sum+$ftch['west'];
							$west_fs=$west_fs+$ftch['west'];

					if($ftch['tot_opp']==0){
						echo '<td>0 %</td>';
					}else{
						echo '<td>'.number_format(($ftch['west']/$ftch['tot_opp']*100), 0, '.', '').' %</td>';
					}


	
					echo '<th>'.valchar($sum).'</th>';
					
				echo '</tr>';

	}
	
?>
										<tr align="right" >
                                            <th align="left">Total</th>

										<?php $total_val=$nc_fs+$east_fs+$south_fs+$west_fs; ?>
                                        
                                            <th><?php echo valchar($nc_fs)?></th>
                                            <th><?php 
													if($total_val==0){
														echo '0';
													}else{
														echo number_format(($nc_fs/$total_val*100), 1, '.', '');
													}
												?> %</th>


                                            <th ><?php echo valchar($east_fs)?></th>
                                            <th><?php 
													if($total_val==0){
														echo '0';
													}else{
														echo number_format(($east_fs/$total_val*100), 1, '.', '');
													}
												?> %</th>

												
                                            <th ><?php echo valchar($south_fs)?></th>
                                            <th><?php 
													if($total_val==0){
														echo '0';
													}else{
														echo number_format(($south_fs/$total_val*100), 1, '.', '');
													}
												?> %</th>


                                            <th ><?php echo valchar($west_fs)?></th>
                                            <th><?php 
													if($total_val==0){
														echo '0';
													}else{
														echo number_format(($west_fs/$total_val*100), 1, '.', '');
													}
												?> %</th>




											
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


<!-- Comming Tiling Date START-->

                    <div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3" style="width:100%;">

 
<div class="portlet box blue" style="padding-left:120px;">
							<div class="portlet-title">
								<h4><i class="icon-bell"></i>Tiling Stage for Coming Months </font></h4>
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
                    <th colspan="2" style="background-color:#CC9900; color:#FFF; font-size:16px;"><?php echo date('M-Y')?></th>
                     <th colspan="2" style="background-color:#CC9900; color:#FFF; font-size:16px;"><?php echo date('M-Y', strtotime('+30 days'))?></th>
                     <th colspan="2" style="background-color:#CC9900; color:#FFF; font-size:16px;"><?php echo date('M-Y', strtotime('+2 month'))?></th>
                            <th rowspan="2" width="12%">Total Value</th>

                                        </tr>


										<tr align="center">
                                            <td bgcolor="#fffb92">Project Value</td>
                                            <td bgcolor="#fffb92">Count</td>

                                            <td bgcolor="#fffb92">Project Value </td>
                                            <td bgcolor="#fffb92">Count</td>

                                            <td bgcolor="#fffb92">Project Value</td>
                                            <td bgcolor="#fffb92">Count</td>
                                        </tr>

<?php
	$stage=array('Opportunity', 'First Discussion', 'Sampling', 'Product Approval', 'Quotation', 'Negotiation', 'Closure Won');
/*
$m1s=date('Y-m-1'); // first month
$m1e=date('Y-m-31');

$m2s=date('Y-m-1', strtotime('+1 month')); // second previous month
$m2e=date('Y-m-31', strtotime('+1 month')); // second previous month

$m3s=date('Y-m-1', strtotime('+2 month')); // second previous month
$m3e=date('Y-m-31', strtotime('+2 month')); // second previous month
*/

 $m1s=date('m/1/Y'); // first month
if(date('m')==02){
	$m1e=date('m/28/Y');
}else{
	$m1e=date('m/30/Y');
}

$m2s=date('m/1/Y', strtotime('+30 days')); // second previous month
if(date('m', strtotime('+30 days'))==02){
	$m2e=date('m/28/Y', strtotime('+30 days')); // second previous month
}else{
	$m2e=date('m/30/Y', strtotime('+30 days')); // second previous month
}

$m3s=date('m/1/Y', strtotime('+2 month')); // second previous month
if(date('m', strtotime('+2 month'))==02){
	$m3e=date('m/28/Y', strtotime('+2 month')); // second previous month
}else{
	$m3e=date('m/30/Y', strtotime('+2 month')); // second previous month
}

	$m1sum=0;	$m2sum=0;	$m3sum=0;
	$m1csum=0;	$m2csum=0;	$m3csum=0;
	
	for($x=1; $x<=sizeof($stage); $x++){
			
					if($x==7){
						$sum_field='won_po_value';
					}else{
						$sum_field='obl_sale_forecast_inr';
					}

	 $reg_sql="
 select 
	m1=(
			select sum(".$sum_field.") as fc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." 
			and o.view_data_visible_to='".$_SESSION['uid']."' 
			and tile_stage_date BETWEEN '".$m1s."' and '".$m1e."' 
		),

	m1c=(
			select count(".$sum_field.") as cc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." 
			and o.view_data_visible_to='".$_SESSION['uid']."' 
			and tile_stage_date BETWEEN '".$m1s."' and '".$m1e."' 
		),

	m2= (
			select sum(".$sum_field.") as fc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." 
			and o.view_data_visible_to='".$_SESSION['uid']."' 
			and tile_stage_date BETWEEN '".$m2s."' and '".$m2e."' 
		),

	m2c= (
			select count(".$sum_field.") as cc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." 
			and o.view_data_visible_to='".$_SESSION['uid']."' 
			and tile_stage_date BETWEEN '".$m2s."' and '".$m2e."' 
		),

   
    m3 = (
			select sum(".$sum_field.") as fc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." 
			and o.view_data_visible_to='".$_SESSION['uid']."' 
			and tile_stage_date BETWEEN '".$m3s."' and '".$m3e."' 
		),

    m3c = (
			select count(".$sum_field.") as cc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." 
			and o.view_data_visible_to='".$_SESSION['uid']."' 
			and tile_stage_date BETWEEN '".$m3s."' and '".$m3e."' 
		)
		
"; 
  
/*	 $reg_sql="
		select sum(".$sum_field.") as fc from dashboard_view_tbl o 
			where o.[status]<>'lost' and o.[current_stage]=".$x." 
			and o.view_data_visible_to='".$_SESSION['uid']."' 
			and tile_stage_date BETWEEN '".$todate."' and '".$fromdate."'
	  "; 

*/
		$reg_sqlexe=odbc_exec($conn,$reg_sql);
		$fftch=odbc_fetch_array($reg_sqlexe);
					
	$totalvalue=0;
			echo '<tr align="center">';
					echo  '<td align="left">'.$stage[$x-1].'</td>';

					
					echo '<td><a href="list-all-lead.php?sales_phase='.$x.'&show_result=true&tile_stage_date='.$m1s.' - '.$m1e.'">'.valchar($fftch['m1']).'</a></td>';
					echo '<td><a href="list-all-lead.php?sales_phase='.$x.'&show_result=true&tile_stage_date='.$m1s.' - '.$m1e.'">'.($fftch['m1c']).'</a></td>';

					echo '<td><a href="list-all-lead.php?sales_phase='.$x.'&show_result=true&tile_stage_date='.$m2s.' - '.$m2e.'">'.valchar($fftch['m2']).'</a></td>';
					echo '<td><a href="list-all-lead.php?sales_phase='.$x.'&show_result=true&tile_stage_date='.$m2s.' - '.$m2e.'">'.($fftch['m2c']).'</a></td>';

					echo '<td><a href="list-all-lead.php?sales_phase='.$x.'&show_result=true&tile_stage_date='.$m3s.' - '.$m3e.'">'.valchar($fftch['m3']).'</a></td>';
					echo '<td><a href="list-all-lead.php?sales_phase='.$x.'&show_result=true&tile_stage_date='.$m3s.' - '.$m3e.'">'.($fftch['m3c']).'</a></td>';

					$totalvalue=$fftch['m1']+$fftch['m2']+$fftch['m3'];

					echo '<th>'.valchar($totalvalue).'</th>';
					
				echo '</tr>';
		
					$m1sum=$m1sum+$fftch['m1'];
					$m1csum=$m1csum+$fftch['m1c'];

					$m2sum=$m2sum+$fftch['m2'];
					$m2csum=$m2csum+$fftch['m1c'];

					$m3sum=$m3sum+$fftch['m3'];
					$m3csum=$m3csum+$fftch['m1c'];

					$mtot=$m1sum+$m2sum+$m3sum;
					
		}//closer for FOR		
?>

										<tr align="center" >
                                            <th align="left">Total</th>

										<?php $total_val=$nc_fs+$east_fs+$south_fs+$west_fs; ?>
                                        
                                            <th><?php echo valchar($m1sum)?></th>
                                            <th><?php echo ($m1csum)?></th>

                                            <th ><?php echo valchar($m2sum)?></th>
                                            <th><?php echo ($m2csum)?></th>

                                            <th ><?php echo valchar($m3sum)?></th>
                                            <th><?php echo ($m3csum)?></th>
                                            
                                            <th ><?php echo valchar($mtot)?></th>
                                        </tr>



                            </tbody>
                            </table>                                                                       
									
								</div>
							</div>
						</div>
					</div>

													</div>

<!-- Comming Tiling Date ENDS -->

<!-- Reason for Lost Start -->


                    <div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3" style="width:100%;">
<?php
	 $lsql="select reason_for_lost,sum(obl_sale_forecast_inr)as val from opportunity where status='lost' group by reason_for_lost";
		$lsqle=odbc_exec($conn,$lsql);
		while($llf=odbc_fetch_array($lsqle)){
			//print_r($llf);
			//echo '<br>';

				if($llf['reason_for_lost']=='Architect Approval'){
					$lost_aa=$llf['val'];
				}

				if($llf['reason_for_lost']=='Price'){
					$price=$llf['val'];
				}

				if($llf['reason_for_lost']=='Complaint in previous supply'){
					$cnps=$llf['val'];
				}

				if(trim($llf['reason_for_lost'])=='Design Issue'){
					$d_issue=$llf['val'];
				}

				if($llf['reason_for_lost']=='GPS Approval'){
					$ga=$llf['val'];
				}

				if($llf['reason_for_lost']=='Lead Not appropriate'){
					$lna=$llf['val'];
				}

				if($llf['reason_for_lost']=='Size Unavailability'){
					$su=$llf['val'];
				}

				if($llf['reason_for_lost']=='Payment terms'){
					$pterm=$llf['val'];
				}

				if($llf['reason_for_lost']=='Credit Period'){
					$cperiod=$llf['val'];
				}

				if($llf['reason_for_lost']=='SKU Approval'){
					$skuap=$llf['val'];
				}

				if($llf['reason_for_lost']=='Relation with Purchaser'){
					$rwp=$llf['val'];
				}

				if($llf['reason_for_lost']=='Redundant/To be deleted'){
					$rtbd=$llf['val'];
				}


		}

?>
 
<div class="portlet box blue" style="padding-left:120px;">
							<div class="portlet-title">
								<h4><i class="icon-bell"></i>Reason for Loss </font></h4>
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
	                    <tr style="background-color:#C00; color:#FFF; font-size:16px;" height="30">
    		                <td><b>Nature of Loss Reason</b></td>
                            <td><b>Reason for Loss</b></td>
                            <td align="center"><b>Sum of OBL Tile Potential Value</b></td>
                            <td align="center"><b>Collective Sum of OBL Potential</b></td>
            	        </tr>
                
                <tr style="border-bottom:2px solid; border-bottom-color:#033">
                	<td>Business</td>
                    <td>
                    	<table border="0" width="100%">
                        	<tr> <td style="border-bottom:1px solid; border-bottom-color:#999">Price</td> </tr>
                        	<tr> <td style="border-bottom:1px solid;border-bottom-color:#999">Payment terms</td> </tr>
                        	<tr> <td>Credit Period</td> </tr>
                        </table>
                    </td>

                    <td>
                    	<table border="0" width="100%">
                        	<tr> <td align="center" style="border-bottom:1px solid; border-bottom-color:#999"><?php echo valchar($price)?></td> </tr>
                        	<tr> <td align="center" style="border-bottom:1px solid;border-bottom-color:#999"><?php echo valchar($pterm)?></td> </tr>
                        	<tr> <td align="center" ><?php echo valchar($cperiod)?></td> </tr>
                        </table>
                    </td>

				<td align="center"><?php $lbusiness=$price+$pterm+$cperiod; echo valchar($lbusiness)?></td>	
                </tr>

                <tr style="border-bottom:2px solid; border-bottom-color:#033">
                	<td>Product</td>
                    <td>
                    	<table border="0" width="100%">
                        	<tr> <td style="border-bottom:1px solid;border-bottom-color:#999">Design Issue</td> </tr>
                        	<tr> <td style="border-bottom:1px solid;border-bottom-color:#999">Size Unavailability</td> </tr>
                        	<tr> <td >Complaint in previous supply</td> </tr>
                        </table>
                    </td>

                    <td>
                    	<table border="0" width="100%">
                        	<tr> <td align="center" style="border-bottom:1px solid;border-bottom-color:#999"><?php echo valchar($d_issue)?></td> </tr>
                        	<tr> <td align="center" style="border-bottom:1px solid;border-bottom-color:#999"><?php echo valchar($su)?></td> </tr>
                        	<tr> <td align="center"><?php echo valchar($price)?></td> </tr>
                        </table>
                    </td>

				<td align="center"><?php $lproduct=$d_issue+$su+$price; echo valchar($lproduct)?></td>	
                </tr>


                <tr style="border-bottom:2px solid; border-bottom-color:#033">
                	<td>Relationship</td>
                    <td>
                    	<table border="0" width="100%">
                        	<tr> <td style="border-bottom:1px solid;border-bottom-color:#999">Architect Approval</td> </tr>
                        	<tr> <td style="border-bottom:1px solid;border-bottom-color:#999">SKU Approval</td> </tr>
                        	<tr> <td style="border-bottom:1px solid;border-bottom-color:#999">GPS Approval</td> </tr>
                        	<tr> <td>Relation with Purchaser</td> </tr>

                        </table>
                    </td>

                    <td>
                    	<table border="0" width="100%">
                        	<tr> <td align="center" style="border-bottom:1px solid;border-bottom-color:#999"><?php echo valchar($lost_aa)?></td> </tr>
                        	<tr> <td align="center" style="border-bottom:1px solid;border-bottom-color:#999"><?php echo valchar($skuap)?></td> </tr>
                        	<tr> <td align="center" style="border-bottom:1px solid;border-bottom-color:#999"><?php echo valchar($ga)?></td> </tr>
                        	<tr> <td align="center" ><?php echo valchar($rwp)?></td> </tr>
                        </table>
                    </td>

				<td align="center"><?php $lrelation=$lost_aa+$skuap+$ga+$rwp; echo valchar($lrelation)?></td>	
                </tr>


                <tr>
                	<td>Invalid Lead</td>
                    <td>
                    	<table border="0" width="100%">
                        	<tr> <td style="border-bottom:1px solid;border-bottom-color:#999">Lead info. Not appropriate</td> </tr>
                        	<tr> <td >Redundant/To be deleted</td> </tr>
                        </table>
                    </td>

                    <td>
                    	<table border="0" width="100%">
                        	<tr> <td align="center" style="border-bottom:1px solid;border-bottom-color:#999"><?php echo valchar($lna)?></td> </tr>
                        	<tr> <td align="center" ><?php echo valchar($rtbd)?></td> </tr>
                        </table>
                    </td>

				<td align="center"><?php $lil=$lna+$rtbd; echo valchar($lil)?></td>	
                </tr>


                <tr height="30">
                <td colspan="3" align="right" style="padding-right:20px; font-size:18px;"><b>Total</b></td>
				<th align="center" style="background-color:#C00; color:#FFF; font-size:16px;">
					<?php $ltv=$lil+$lrelation+$lproduct+$lbusiness; echo valchar($ltv)?>
                </th>	
                </tr>

                
                    </tbody>
                    </table>
                                
                                									
								</div>
							</div>
						</div>
					</div>

													</div>

<!-- Comming Supply Date START-->

                    <div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3" style="width:100%;">

 
<div class="portlet box blue" style="padding-left:120px;">
							<div class="portlet-title">
								<h4><i class="icon-bell"></i>Supply Plan for Comming Months </font></h4>
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
                    <th  width="13%" style="font-size:14px;" rowspan="2">Project Type</th>
                    <th  style="background-color:#d8076e; color:#FFF; font-size:16px;"><?php echo date('M-Y')?></th>
                     <th  style="background-color:#d8076e; color:#FFF; font-size:16px;"><?php echo date('M-Y', strtotime('+30 days'))?></th>
                     <th  style="background-color:#d8076e; color:#FFF; font-size:16px;"><?php echo date('M-Y', strtotime('+2 month'))?></th>
                      <th rowspan="2" width="12%">Total Value</th>

                                        </tr>

										<tr align="center">
                                            

                                            <td bgcolor="#99FFFF">Supply in SQMT</td>

                                            <td bgcolor="#99FFFF">Supply in SQMT</td>

                                            <td bgcolor="#99FFFF">Supply in SQMT</td>

                                        </tr>

											<?php
                                            $m1=date('M-Y');
                                            $m2=date('M-Y', strtotime('+30 days'));
                                            $m3=date('M-Y', strtotime('+2 month'));

											$month1=explode("-",$m1);
											//print_r($month1);
											$month2=explode("-",$m2);
											
											$month3=explode("-",$m3);

$projectType=array('Goverment', 'Hospital', 'School', 'Private');

for($y=1; $y<=sizeof($projectType); $y++){
											
$mth1=0;
$mth2=0;
$mth3=0;

$dfq="select opportunity_id from dashboard_view_tbl where view_data_visible_to='".$_SESSION['uid']."' and project_type like '%".$projectType[$y-1]."%'";
	$dfqe=odbc_exec($conn,$dfq);
	while($df=odbc_fetch_array($dfqe)){
	//print_r($df);
	
		 $supply_sql="
			select 
		m1=(
				select sum(supply_qty) as supply from supply_plan  
				where supply_month='".ucfirst(strtolower($month1[0]))."' and supply_year='".$month1[1]."' and opp_id='".$df['opportunity_id']."'
			),
	
		m2= (
				select sum(supply_qty) as supply from supply_plan  
				where supply_month='".ucfirst(strtolower($month2[0]))."' and supply_year='".$month2[1]."' and opp_id='".$df['opportunity_id']."'
			),
		   
		m3 = (
				select sum(supply_qty) as supply from supply_plan  
				where supply_month='".ucfirst(strtolower($month3[0]))."' and supply_year='".$month3[1]."' and opp_id='".$df['opportunity_id']."'
			)
		  "; 
	
			$supply_sql_exe=odbc_exec($conn,$supply_sql);
			$sf=odbc_fetch_array($supply_sql_exe);
	
			$mth1 = $mth1 + $sf['m1'];
			$mth2 = $mth2 + $sf['m2'];
			$mth3 = $mth3 + $sf['m3'];
	}


       ?>	

										<tr align="center">
                                            <td align="left"><?php echo $projectType[$y-1] ?></td>

                                            <td ><?php echo $mth1 ?></td>

                                            <td ><?php echo $mth2 ?></td>

                                            <td ><?php echo $mth3 ?></td>

                                            <td ><?php echo $mth1+$mth2+$mth3 ?></td>

                                        </tr>
<?php 

	$m1supply=$m1supply+$mth1;

	$m2supply=$m2supply+$mth2;

	$m3supply=$m3supply+$mth3;

	$totsupply=$m1supply+$m2supply+$m3supply;

} // end of project type loop ?>

										<tr align="center" >
                                            <th align="left">Total</th>

                                            <th><?php echo $m1supply?></th>

                                            <th><?php echo $m2supply?></th>

                                            <th><?php echo $m3supply?></th>
                                            
                                            <th ><?php echo $totsupply ?></th>
                                        </tr>



                            </tbody>
                            </table>                                                                       
									
								</div>
							</div>
						</div>
					</div>

													</div>

<!-- Comming Supply Date ENDS -->




<!--top 5 SKU start-->
<?php /*?>
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

<?php */?>
<!-- top 5 SKU ends -->




<!--vin new start -->
<!-- other content area--> 

				<div class="row-fluid">
					<div class="span6">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-bell"></i>TOP 5 Account <font size="2">&nbsp;</font></h4>
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
											<th><i class="icon-briefcase"></i> Account Name </th>                                            
											<th  class="hidden-phone"><i class="icon-flag"></i> OBL Potential</th>
											<th class="hidden-phone"><i class="icon-trophy"></i> Won</th>
											<th><i class="icon-lock"></i> Lost</th>
										</tr>
									</thead>
                                    <tbody>


<?php
			if(trim($_SESSION['user_type'])=='management') {
 $ttv="select top 5 cka_name_id, sum(o.obl_sale_forecast_inr) as amt, count(obl_sale_forecast_inr) as cnt from dashboard_view_tbl o 
group by o.cka_name_id order by amt desc";
			}else{
$ttv="
 select top 5 cka_name_id, sum(o.obl_sale_forecast_inr) as amt, count(obl_sale_forecast_inr) as cnt from dashboard_view_tbl o 
 where o.view_data_visible_to='".$_SESSION['uid']."' 
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
							//echo '<a href="#">'.trim($wqf['cka_name']).'</a>';
			echo '<a href="list-all-lead.php?account_name='.substr(trim($wqf['cka_name']),0,30).'&show_result=true">'.trim($wqf['cka_name']).'</a>';
							
							echo '</td>';
							echo '<td>&#8377 '.valchar($ttf['amt']).'</td>';
							echo '<td>&#8377 '.valchar($wqf['won']).'</td>';
							echo '<td>&#8377 '.valchar($wqf['lost']).'</td>';
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
								<h4><i class="icon-shopping-cart"></i>Bottom 5 Account <font size="2">&nbsp;</font></h4>
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
											<th><i class="icon-briefcase"></i> Account Name </th>                                            
											<th class="hidden-phone"><i class="icon-flag"></i> OBL Potential</th>
											<th class="hidden-phone"><i class="icon-trophy"></i> Won</th>
											<th><i class="icon-lock"></i> Lost</th>
										</tr>
									</thead>

<?php
			if(trim($_SESSION['user_type'])=='management') {
$ttv="select top 5 cka_name_id, sum(o.obl_sale_forecast_inr) as amt, count(obl_sale_forecast_inr) as cnt from dashboard_view_tbl o where o.obl_sale_forecast_inr !='0'
group by o.cka_name_id  order by amt asc ";
			}else{
$ttv="
 select top 5 cka_name_id, sum(o.obl_sale_forecast_inr) as amt, count(obl_sale_forecast_inr) as cnt from dashboard_view_tbl o where o.obl_sale_forecast_inr !='0'
 and o.view_data_visible_to='".$_SESSION['uid']."' 
 group by o.cka_name_id  order by amt asc";
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
			//print_r($wqf);

						echo '<tr align="center">';
							echo '<td class="highlight">';
							echo '<div class="success"></div>';
//							echo '<a href="#">'.trim($wqf['cka_name']).'</a>';
			echo '<a href="list-all-lead.php?account_name='.substr(trim($wqf['cka_name']),0,30).'&show_result=true">'.trim($wqf['cka_name']).'</a>';
							
							echo '</td>';
							echo '<td>&#8377 '.valchar($ttf['amt']).'</td>';
							echo '<td>&#8377 '.valchar($wqf['won']).'</td>';
							echo '<td>&#8377 '.valchar($wqf['lost']).'</td>';
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
											<th><i class="icon-briefcase"></i> Project Name </th>                                            
											<th class="hidden-phone"><i class="icon-flag"></i> State</th>
											<th class="hidden-phone"><i class="icon-map-marker"></i> Stage</th>
											<th><i class="icon-shopping-cart"></i> Total INR</th>
											<th><i class="icon-shopping-cart"></i> Generator</th>
										</tr>
									</thead>
                                    <tbody>
<?php
			$sql = "select top 10 d.opportunity_id, a.cka_name, d.project_name, s.state_name, d.city, d.project_name, d.current_stage, u.fullname, d.project_tile_potential_inr,
d.obl_sale_forecast_inr 
from opportunity d
left join cka_name_master a on a.cka_name_id = d.cka_name_id
left join state_master s on s.state_id = d.state_id
left join user_management u on d.created_by = u.uid";

if(trim($_SESSION['user_type'])=='management') {
		$sql.="  where d.[status]='open' order by obl_sale_forecast_inr desc ";
	}else{

			if($_SESSION['employee_department']=='Retail'){
				$sql.=" where d.deal_type='Retail' 
						and d.territory in (".$_SESSION['employee_territory'].") 
						order by obl_sale_forecast_inr desc ";
			}


			if($_SESSION['employee_department']=='CKA'){
//vks start
					if($_SESSION['user_type']=='manager'){
					
					$sql.=" where d.[status]='open' 
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
						$sql.=" where ( d.deal_type='CKA') and ( ";

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

			if($_SESSION['employee_department']=='BD' || $_SESSION['employee_department']=='GPS'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where d.[status]='open' 
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
						$sql .=" )order by obl_sale_forecast_inr desc ";
					}else{
						$sql.="  where d.created_by='".$_SESSION['uid']."' 
						order by obl_sale_forecast_inr desc ";	
					}

			}
		
	}



					$tte=odbc_exec($conn,$sql);
					$count=1;
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
							echo '<td class="highlight" width=300px>';
							echo '<div class="success"></div>';
							//echo '<a href="#">'.$ttf['cka_name'].'</a>';
							echo '<a href=lead-history.php?pid='.$ttf['opportunity_id'].'>'.trim($ttf['project_name']).'</a>';
							echo '</td>';
							echo '<td>'.$ttf['state_name'].'</td>';
							echo '<td>'.$cstage.'</td>';
							echo '<td>&#8377 '.valchar($ttf['obl_sale_forecast_inr']).'</td>';
							echo '<td>'.$ttf['fullname'].'</td>';

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
											<th><i class="icon-briefcase"></i> Project Name </th>
											<th ><i class="icon-flag"></i> State </th>
											<th ><i class="icon-trash"></i> Stage</th>
											<th><i class="icon-shopping-cart"></i>  INR</th>
											<th><i class="icon-shopping-cart"></i> Generator</th>

										</tr>
									</thead>
                                    <tbody>
<?php
	
	$sql = "select top 10 d.opportunity_id, a.cka_name, d.project_name, s.state_name, d.city, d.project_name, d.current_stage, u.fullname, d.project_tile_potential_inr,
d.obl_sale_forecast_inr 
from opportunity d
left join cka_name_master a on a.cka_name_id = d.cka_name_id
left join state_master s on s.state_id = d.state_id
left join user_management u on d.created_by = u.uid";

if(trim($_SESSION['user_type'])=='management') {
		$sql.="  where d.[status]='lost' order by obl_sale_forecast_inr desc ";
	}else{

			if($_SESSION['employee_department']=='Retail'){
				$sql.=" where d.deal_type='Retail' 
						and d.territory in (".$_SESSION['employee_territory'].") 
						order by obl_sale_forecast_inr desc ";
			}


			if($_SESSION['employee_department']=='CKA'){
//vks start
					if($_SESSION['user_type']=='manager'){
					
					$sql.=" where d.[status]='lost' 
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
						$sql.=" where d.[status]='lost' and ( d.deal_type='CKA') and ( ";

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

						$sql .=" ) order by obl_sale_forecast_inr desc ";
					}

//vks ends

					
				
				//echo $sql;
			}

			if($_SESSION['employee_department']=='BD' || $_SESSION['employee_department']=='GPS'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where d.[status]='lost' 
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
						$sql .=" )and d.[status]='lost' order by obl_sale_forecast_inr desc ";
					}else{
						$sql.="  where d.created_by='".$_SESSION['uid']."' 
						and d.[status]='lost' order by obl_sale_forecast_inr desc ";	
					}

			}
		
	}

//echo $ttv;
					$tte=odbc_exec($conn,$sql);
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
							echo '<td class="highlight" width=300px>';
							echo '<div class="danger"></div>';
//							echo '<a href="#">'.$ttf['cka_name'].'</a>';
//							echo '<a href="#">'.$ttf['project_name'].'</a>';
							echo '<a href=lead-history.php?pid='.$ttf['opportunity_id'].'>'.trim($ttf['project_name']).'</a>';

							echo '</td>';
							echo '<td>'.$ttf['state_name'].'</td>';
							echo '<td>'.$cstage.'</td>';
							echo '<td>&#8377 '.valchar($ttf['project_tile_potential_inr']).'</td>';
							echo '<td>'.$ttf['fullname'].'</td>';

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
