<style>
.myButton {
	cursor:pointer;
	font-size:0px;
	width:15px;
	height:12px;
	background-image:url(del.jpeg);
	background-repeat:no-repeat;
	border:0;
}
img {
	border:0;
}
</style>




<?php
include_once('including/all-include.php');
$timestamp=date('Y-m-d H:i:s');
//$lead_id=$_GET['pid'];

//print_r($_GET);
//exit;

if(isset($_GET['sku_size'])){

		$opportunity_id=$_GET['opportunity_id'];
      	$sku_size=$_GET['sku_size'];
      	$tile_category=$_GET['tile_category'];
		$tile_name=$_GET['tile_name'];
		$desc=$_GET['desc'];
		$qty=$_GET['qty'];
		$sampling_date=$_GET['sampling_date'];
		$sp_remark=$_GET['sp_remark'];
	
	$_SESSION['sampling_opp_id']=$opportunity_id;	
	
$insert  ="INSERT INTO sampling(opportunity_id, sku_size, tile_category,tile_name,descreption, qty, sampling_date,sp_remark, added_by,last_modified)";
				$insert .="values('".$opportunity_id."', '".$sku_size."', '".$tile_category."', '".$tile_name."', '".$desc."', '".$qty."', '".$sampling_date."',  '".$sp_remark."', '".$_SESSION['uid']."',  '".$timestamp."' ) ";

			//	echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){
					/*echo 'Something went wrong, please contact to administrator';*/
			
			/*} else {
			//echo 'Message has been sent.';
					//header('Location:schedule-management.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
					//exit;
				//header('location:../../email-acknoledgment.php?BlanketOrderNumber='.base64_encode($BlanketOrderNumber).'');
				//exit;
			}*/
						
						
				}else{
					echo 'Something went wrong, please contact to administrator';
				}

}
?>

<table width="100%" border="1">

		<tr>
        <th>SKU Size</th>
        <th>Tile Category</th>
        <th>Tile Name</th>
        <th>Descreption</th>
        <th>Quantity</th>
        <th>Sampling Date</th>
        <th>Sampling Remarks</th>
        <th>Created By</th>
        <th>Update On</th>
	    <!-- <th>Action</th> -->
        </tr>

	                                   
<?php 
//echo 'hello';
//print_r($_GET);
if(isset($_SESSION['sampling_opp_id']) && $_SESSION['sampling_opp_id'] > 0 ){
 $ssql="select * from sampling where opportunity_id='".$_SESSION['sampling_opp_id']."' ";	
}else{
 $ssql="select * from sampling where opportunity_id='".$_GET['pid']."'";	
}
$rs=odbc_exec($conn,$ssql);
 $vv=odbc_num_rows($rs);

$_SESSION['atc']=$vv;

while($f = odbc_fetch_array($rs)){
//print_r($f);

echo '<tr align="center">';
echo '<td>'.$f['sku_size'].'</td>';
echo '<td>'.$f['tile_category'].'</td>';
echo '<td>'.$f['tile_name'].'</td>';
echo '<td>'.$f['descreption'].'</td>';
echo '<td>'.$f['qty'].'</td>';
echo '<td>'.$f['sampling_date'].'</td>';
echo '<td>'.$f['sp_remark'].'</td>';
$eq1="select fullname from user_management where uid='".$f['added_by']."' ";
$eqe1=odbc_exec($conn,$eq1);
$eqf1=odbc_fetch_array($eqe1);
echo '<td>'.$eqf1['fullname'].'</td>';



echo '<td>'.date('d-m-Y',strtotime(trim($f['last_modified']))).'</td>';
/*echo '<td>'.$f['last_modified'].'</td>';*/

//echo $_SERVER['SCRIPT_NAME'];

//print_r($_SESSION);
/*if($f['added_by']!=$_SESSION['uid']){
echo '<td>-</td>';
}else{
echo '<th><input type="button" class="myButton" value="'.$f['visit_plan_id'].'" style="background-color:red; color:white;"  onClick="return confirm(\'Are you sure to delete ?\')? action_plan_delete_from_cart_data(this.value): alert(\'Something went wrong, Please try again...\') ;"></th>';
}*/

	//echo '<th><input type="button" class="myButton" value="'.$f['fld_id'].'" style="background-color:red; color:white;"  onClick="delete_from_cart_data(this.value)"></th>';

echo '</tr>';
}


?>
</table>