<?php
	
   include('including/all-include.php');
   /*var_dump($_REQUEST);*/
   $msg = $_POST['msg'];
   
   
   $output = '';
   $sql = "insert into msg (msg,created_by,created_on, status) values ('$msg','admin',getdate(),'1')";
   /*$sql = "SELECT * from product_master where p_id = $cp";*/
   $result = odbc_exec($conn, $sql);

   if($result){
   	$sql1 = "SELECT * from msg order by created_on desc";
   	$result1 = odbc_exec($conn, $sql1);

   	$users_arr = array();
   
while( $row = odbc_fetch_array($result1) ){
    $msg = $row['msg'];
   	$created_by = $row['created_by'];
   	$created_on = $row['created_on'];
    
    $users_arr[] = array("msg" => $msg);
}
   }
   

// encoding array to json format
echo json_encode($users_arr);
?>