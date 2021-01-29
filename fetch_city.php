
<?php
	
   include('including/all-include.php');
   /*var_dump($_REQUEST);*/
   
   $st = $_POST['st'];
   
   
   $output = '';
   $sql = "SELECT p_city from channel_partner where p_id = $st";
   /*$sql = "SELECT * from product_master where p_id = $cp";*/
   $result = odbc_exec($conn, $sql);
   $sku_arr = array();
   
while( $row = odbc_fetch_array($result) ){
    $userid = $row['p_city'];
   // $name = $row['name'];
    
    $sku_arr[] = array("p_city" => $userid);
}

// encoding array to json format
echo json_encode($sku_arr);

?>



  
