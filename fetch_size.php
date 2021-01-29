
<?php
	
   include('including/all-include.php');
   /*var_dump($_REQUEST);*/
   $cp = $_POST['cat_id'];
   
   
   $output = '';
   $sql = "SELECT distinct pr_product_group FROM product_master where pr_state_code = (select p_state_code_new from channel_partner where p_id = '$cp') order by pr_product_group asc";
   /*$sql = "SELECT * from product_master where p_id = $cp";*/
   $result = odbc_exec($conn, $sql);
   $users_arr = array();
   
while( $row = odbc_fetch_array($result) ){
    $userid = $row['pr_product_group'];
   // $name = $row['name'];
    
    $users_arr[] = array("pr_product_group" => $userid);
}

// encoding array to json format
echo json_encode($users_arr);

   

// encoding array to json format
// echo json_encode($users_arr);

//    $output = '<option value="">- Select -</option>';
//    while($f = odbc_fetch_array($result)){
//       $pr_group = $f['pr_product_group'];

//    	/*$output .= '<option value="'.$f["pr_product_group"].'">'.$f["pr_product_group"].'</option>';*/
//    }
//    echo json_decode($pr_group);
?>



  
