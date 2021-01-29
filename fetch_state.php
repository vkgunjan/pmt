<?php
	
   include('including/all-include.php');
   /*var_dump($_REQUEST);*/
   
   $st = $_POST['st'];
   
   
   $output = '';
   $sql = "SELECT state from city_master where id = $st";
   /*$sql = "SELECT * from product_master where p_id = $cp";*/
   $result = odbc_exec($conn, $sql);
   $sku_arr = array();
   
while( $row = odbc_fetch_array($result) ){
    $userid = $row['state'];
   // $name = $row['name'];
    
    $sku_arr[] = array("state" => $userid);
}

// encoding array to json format
echo json_encode($sku_arr);

?>