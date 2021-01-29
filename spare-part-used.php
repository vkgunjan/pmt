<?php 
    include_once('including/all-include.php');

if(isset($_GET['disc'])){
		$spare_part_id=$_GET['add_to_cart_data'];
	$qty=$_GET['disc'];
	
$insert  ="INSERT INTO spare_part_used(spare_part_id, qty, wo_id)";
				$insert .="values('".$spare_part_id."', '".$qty."', '".$_SESSION['wo_id']."') ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						
				}

}
?>
<?php 
//echo 'hello';
//print_r($_GET);

$ssql="select * from spare_part_used ";	
$rs=odbc_exec($conn,$ssql);
while($f = odbc_fetch_array($rs)){
//print_r($f);

echo '<tr>';
echo '<th>'.$f['spare_part_used_id'].'</th>';
echo '<th>UOM</th>';
echo '<th>'.$f['qty'].'</th>';
echo '<th>Del</th>';
echo '</tr>';
}
?>
