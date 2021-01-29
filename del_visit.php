
<?php
    include_once('including/all-include.php');
print_r($_GET);

echo $del="DELETE FROM visit_plan where visit_plan_id='".$_GET['del_ap']."'";
$stmt = odbc_prepare($conn, $del);
if (odbc_execute($stmt)){ 
	header('location:visit_plan.php?order_del_id=1');
	exit();
}else{
			//echo 'no';
}

	

?>