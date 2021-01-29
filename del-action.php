
<?php
    include_once('including/all-include.php');
print_r($_GET);

echo $del="DELETE FROM project_action_plan_cart where action_plan_cart_id='".$_GET['del_ap']."'";
$stmt = odbc_prepare($conn, $del);
if (odbc_execute($stmt)){ 
	header('location:action_plan_cart.php?order_del_id=1');
	exit();
}else{
			//echo 'no';
}

	

?>
