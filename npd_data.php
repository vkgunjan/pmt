
<?php
include_once('including/all-include.php');
$timestamp=date('Y-m-d H:i:s');
//$lead_id=$_GET['pid'];

//print_r($_GET);
//exit;

if(isset($_POST['plant_name'])){
		$uid = $_SESSION['uid'];
		$opp_id=$_POST['opp_id'];
		$plant_name=$_POST['plant_name'];
  	$sku_size=$_POST['sku_size'];
  	$tile_category=$_POST['tile_category'];
  	$punch_type=$_POST['punch_type'];
  	$npd_tile_name=$_POST['npd_tile_name'];
    $ref_tile_name=$_POST['ref_tile_name'];
  	$qty=$_POST['qty'];
    $thickness=$_POST['thickness'];
    $expected_price=$_POST['expected_price'];
    $expected_date=$_POST['expected_date'];

      	/*print_r($_POST);
      	exit;*/
	
	/*$_SESSION['cka_name_id']=$cka_name_id;*/	
	
$insert  ="INSERT INTO npd_tile(opp_id, plant_name, sku_size, tile_category, punch_type, npd_tile_name, ref_tile_name, tile_qty, tile_thickness, expected_price, expected_date, po_status, created_on, created_by)";
				$insert .="values('".$opp_id."', '".$plant_name."', '".$sku_size."', '".$tile_category."', '".$punch_type."',  '".$npd_tile_name."', '".$ref_tile_name."',   '".$qty."',   '".$thickness."',   '".$expected_price."',   '".$expected_date."','Created', getdate(), '".$_SESSION['uid']."' ) ";

			//	echo $insert;
				$stmt = odbc_exec($conn, $insert);
				

}
?>
                                  
<?php 



//echo 'hello';
//print_r($_GET);
if(isset($_POST['opp_id']) && $_POST['opp_id'] > 0 ){
/*alert($_POST['cka']);*/
 $ssql="select * from npd_tile where opp_id='".$_POST['opp_id']."' ";	
}else{
 $ssql="select * from npd_tile where opp_id='".$_POST['opp_id']."'";	
}
$rs=odbc_exec($conn,$ssql);
 $vp=odbc_num_rows($rs);

//$_SESSION['atc']=$vv;

if($vp <= 0){
  $output = '';
}else{
  $output = '<table class="table table-striped table-bordered table-hover" >

    <tr>
        <th>Plant</th>
        <th>SKU Size</th>
        <th>Category</th>
        <th>Punch Type</th>
        <th>NPD Tile Name</th>
        <th>Reference Tile</th>
        <th>Qty(SQMT)</th>
        <th>Thickness</th>
        <th>Price/SQMT</th>
        <th>Expected Date</th>
        <th>Created On</th>
        </tr>';

while($f = odbc_fetch_array($rs)){
//print_r($f);

$output .= '<tr align="center">';
$output .= '<td>'.$f['plant_name'].'</td>';
$output .= '<td>'.$f['sku_size'].'</td>';
$output .= '<td>'.$f['tile_category'].'</td>';
$output .= '<td>'.$f['punch_type'].'</td>';
$output .= '<td>'.$f['npd_tile_name'].'</td>';
$output .= '<td>'.$f['ref_tile_name'].'</td>';
$output .= '<td>'.$f['tile_qty'].'</td>';
$output .= '<td>'.$f['tile_thickness'].'</td>';
$output .= '<td>'.$f['expected_price'].'</td>';
$output .= '<td>'.date('d-m-Y',strtotime(trim($f['expected_date']))).'</td>';
$output .= '<td>'.date('d-m-Y',strtotime(trim($f['created_on']))).'</td>';
$output .= '</tr>';
}

$output .= '</table>';
}


echo $output;

?>
