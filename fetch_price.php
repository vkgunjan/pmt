
<?php
	
   include('including/all-include.php');
   /*var_dump($_REQUEST);*/
   $cp_id = $_POST['cp_id'];
   $sk = $_POST['sk'];
   
   
   $output = '';
   $sql = "SELECT distinct pr_price from product_master where pr_sku_size = '$sk' and pr_state_code = (select p_state_code_new from channel_partner where p_id = '$cp_id')";
   /*$sql = "SELECT * from product_master where p_id = $cp";*/
   $result = odbc_exec($conn, $sql);
   $sku_arr = array();
   
while( $row = odbc_fetch_array($result) ){
    $userid = $row['pr_price'];
   // $name = $row['name'];
    
    $sku_arr[] = array("pr_price" => $userid);
}

// encoding array to json format
echo json_encode($sku_arr);

?>



  
