
<?php
    include_once('including/all-include.php');

echo $del="DELETE FROM fld where fld_id='".$_GET['delid']."'";
$stmt = odbc_prepare($conn, $del);
if (odbc_execute($stmt)){ 
	header('location:add_to_cart_data.php?order_del_id=1');
	exit();
}else{
			//echo 'no';
}

	

?>
