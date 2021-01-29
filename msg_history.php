
<?php
include_once('including/connect.php');
$timestamp=date('Y-m-d H:i:s');
//$lead_id=$_GET['pid'];

//print_r($_GET);
//exit;

if(isset($_GET['msg'])){

		$msg=$_GET['msg'];
      	
	
$insert  ="INSERT INTO msg(msg,created_by,created_on,status)";
				$insert .="values('".$msg."', 'admin', getdate(), '1') ";

			//	echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){
				}else{
					echo 'Something went wrong, please contact to administrator';
				}

}
?>

	                                   
<?php 
//echo 'hello';
//print_r($_GET);

 $ssql="SELECT * from msg order by created_on desc";	

$rs=odbc_exec($conn,$ssql);
 $vv=odbc_num_rows($rs);



while($f = odbc_fetch_array($rs)){
//print_r($f);

echo '<blockquote>';
echo '<i class="icon-user span1" style="margin-top: 10px; margin-left: 5px; font-size: 25px;"></i>';
echo '<p id="sender" style="margin-left: 55px;">'.$f['msg'].'</p>';
echo '<small class="pull-right">'.date('F j, Y, g:i A', strtotime($f['created_on'])).'</small><br>';
echo '</blockquote>';

}


?>
