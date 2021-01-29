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
//$lead_id=$_GET['pid'];

//print_r($_GET);
//print_r($_SESSION);
//exit;



$timestamp=date('Y-m-d H:i:s');
if(isset($_GET['disc'])){

		$opp_id=$_SESSION['supply_lead_id'];
		$size=$_GET['add_to_cart_data'];
      	$qty=$_GET['disc'];
      	$supply_year=$_GET['supply_year'];
      	$supply_month=$_GET['supply_month'];
		$tilecategory=$_GET['tilecategory'];
		$modified_by=$_SESSION['uid'];

		$insert  ="INSERT INTO supply_plan (opp_id,size,tile_category,supply_year,supply_month,supply_qty,last_modified, modified_by)";
		$insert .="values('".$opp_id."', '".trim($size)."', '".$tilecategory."', '".trim($supply_year)."', '".trim($supply_month)."', '".trim($qty)."', '".$timestamp."', '".trim($modified_by)."' ) ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						
				}

}
?>
<table width="100%" border="1">
 										<tr>
                                            	<th>SKU Size</th>
												<th>Tile Category</th>
                                              <?php /*?>  <th>Tile Name</th><?php */?>
                                                <th>Supply Qty</th>
                                                <th>Month</th>
                                                <th>Year</th>
                                                <th>Action</th>                                                
                                            </tr>
                        
<?php 
//echo 'hello';
//print_r($_GET);

 $ssql="select * from supply_plan where opp_id='".$_SESSION['supply_lead_id']."'";	
 $rs=odbc_exec($conn,$ssql);
 $vv=odbc_num_rows($rs);

$_SESSION['atc']=$vv;

while($f = odbc_fetch_array($rs)){
//print_r($f);

echo '<tr align="center">';
echo '<td>'.$f['size'].'</td>';
echo '<td>'.$f['tile_category'].'</td>';

$tns="select final_tile_name,approved_tile_name from fld where size='".trim($f['size'])."' and sample_tile_cateroty='".trim($f['tile_category'])."'";	
$te=odbc_exec($conn,$tns);
$tf=odbc_fetch_array($te);

$tilename=(!empty($tf['final_tile_name'])?$tf['final_tile_name']:$tf['approved_tile_name']);

//echo '<td>'.$tilename.'</td>';
echo '<td>'.$f['supply_qty'].'</td>';
echo '<td>'.$f['supply_month'].'</td>';
echo '<td>'.$f['supply_year'].'</td>';
//echo $_SERVER['SCRIPT_NAME'];

if($_SERVER['SCRIPT_NAME']!='pipeline/supply-plan-submit.php')
echo '<th><input type="button" class="myButton" value="'.$f['suplly_id'].'" style="background-color:red; color:white;"  onClick="return confirm(\'Are you sure to delete ?\')? delete_from_cart_data(this.value): alert(\'Something went wrong, Please try again...\') ;"></th>';


	//echo '<th><input type="button" class="myButton" value="'.$f['fld_id'].'" style="background-color:red; color:white;"  onClick="delete_from_cart_data(this.value)"></th>';
	
else
echo '<th>N/A</th>';


echo '</tr>';
}


?>
</table>