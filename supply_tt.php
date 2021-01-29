
<?php
    include_once('including/all-include.php');

echo $del="DELETE FROM supply_plan where suplly_id='".$_GET['delid']."'";
$stmt = odbc_prepare($conn, $del);
if (odbc_execute($stmt)){ 
	header('location:supply_add_to_cart_data.php?order_del_id=1');
	exit();
}else{
			//echo 'no';
}

	

?>
