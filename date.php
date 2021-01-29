<?php
$Date = "2015-10-30";
echo date('Y-m-d', strtotime($Date. ' + 1 month'));
echo '<br>';
echo date('Y-m-d', strtotime($Date. ' + 2 days'));


//if(date('Y-m-d', strtotime($Date. ' + 1 days')) == date('Y-m-d', strtotime($Date. ' + 1 days')))
if(date('Y-m-d', strtotime($Date)) == date('Y-m-d', strtotime($Date)))
echo 'yes';
else
echo 'no';




echo $first_day_of_September=date('w', strtotime('2015-10-31')); // 2



$ss=explode("-",'2015-10-31');
			echo $day_of_sd=$ss[1];
			
			
?>