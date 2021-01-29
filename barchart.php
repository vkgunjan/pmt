<?php 
include_once('including/connect.php');

			$sqlmonth = "SELECT * FROM (SELECT p.current_stage,YEAR(added_date) [Year], DATENAME(MONTH, added_date) [Month], MONTH(added_date)[Months], COUNT(1) [Sales Count]
      FROM opportunity o inner join pmt_current_stage p on o.current_stage=p.stage_id where  added_date > DATEADD(m,-5,getdate()-datepart(d,getdate())+1)
      GROUP BY p.current_stage,YEAR(added_date),MONTH(added_date), DATENAME(MONTH, added_date)) AS MontlySalesData PIVOT( SUM([Sales Count])   
    FOR current_stage IN ([Opportunity],[First Discussion],[Sampling],[Product Approval], [Quotation],[Negotiation],[Won])) AS MNamePivot order by [Months] asc";
	
		$salesmonth = odbc_exec($conn, $sqlmonth);
	
	
?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
         ['Month', 'Opportunity', 'First Discussion', 'Sampling', 'Product Approval', 'Quotation', 'Negotiation', 'Won'],
		 
		 
		 <?php 
		 while($hxx1=odbc_fetch_array($salesmonth)){
				
				echo "['".$hxx1["Month"]."', ".$hxx1["Opportunity"].", ".$hxx1["First Discussion"].", ".$hxx1["Sampling"].", ".$hxx1["Product Approval"].", ".$hxx1["Quotation"].", ".$hxx1["Negotiation"].", ".$hxx1["Won"]."],";
			
			}
		  ?>
			
         
      ]);

    var options = {
      title : 'Monthly Pipeline Summary (Last 6 Months)',
      vAxis: {title: 'Pipeline'},
      hAxis: {title: 'Month'},
      seriesType: 'bars',
     
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script> 


	
	<html>
	<head>
	</head>
	
	<body>
	
	<div>
    <div id="chart_div" style="width: 100%; height: 300px;"></div>
    </div>
	
	
	
	
	</body>
	</html>