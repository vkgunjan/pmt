
<?php
	
   include('including/all-include.php');
   include('including/datetime.php');
   $timestamp=date('Y-m-d H:i:s');
   $user = $_SESSION['uid'];
   /*var_dump($_REQUEST);*/
   $url = $_POST['url'];
   $contact = $_POST['contact'];
   $plant = $_POST['catPlant'];
   $cat_name = $_POST['catImg'];

   $url1 = $_POST['url1'];
   
   $plant1 = $_POST['catPlant1'];
   $cat_name1 = $_POST['catImg1'];
   
   if(empty($contact)){
    $sql = "INSERT into click_log values ('$user','$plant1','$cat_name1','$url1','','CD','$timestamp')";
    }else{
    $sql = "INSERT into click_log values ('$user','$plant','$cat_name','$url','$contact','WS','$timestamp')";
    }

    $result = odbc_exec($conn, $sql);

?>



  
