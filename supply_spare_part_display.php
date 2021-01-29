
<?php 
//echo 'hello';
//print_r($_GET);
   include_once('including/all-include.php');
//echo $_SESSION['supply_lead_id'];

echo '<b>&nbspTile Category:&nbsp;</b>';
echo '<select name="tilecategory" id="tilecategory" style="width:120px;" required="required">'; 
echo '<option value="">-Select-</option>';
//echo '<option value="Not Specified">Not Specified</option>';
echo '<option value="Ceramic">Ceramic</option>';
echo '<option value="DC">DC</option>';
echo '<option value="DGVT">DGVT</option>';
echo '<option value="LAP">LAP</option>';
echo '<option value="Nano">Nano</option>';
echo '<option value="Pavers">Pavers</option>';
echo '<option value="PDC">PDC</option>';
echo '<option value="PGVT">PGVT</option>';
echo '<option value="PVT">PVT</option>';

echo $ssql="select DISTINCT sample_tile_cateroty from fld  where opp_id='".$_SESSION['supply_lead_id']."' and size='".$_GET['ipg']."'";	
$rs=odbc_exec($conn,$ssql);
	while($f = odbc_fetch_array($rs)){
		print_r($f);
	echo '<option value="'.$f['sample_tile_cateroty'].'">'.$f['sample_tile_cateroty'].' </option>';
	}
echo '</select>'; 


echo '<b>&nbsp;&nbsp;Supply Qty (SQMT) :&nbsp;</b>';
echo '<input type="text" name="qty" id="qty" style="width:50px;">'; 

echo '<b>&nbsp;&nbsp; Year:&nbsp;</b>';
echo '<select name="supply_year" id="supply_year" style="width:80px;" required="required">'; 
	echo '<option value="'.date("Y").'">'.date("Y").' </option>';
	echo '<option value="'.(date("Y")+1).'">'.(date("Y")+1).' </option>';	
echo '</select>'; 

$jan=(date("M")=='Jan')?'selected':'';  $feb=(date("M")=='Feb')?'selected':'';  $mar=(date("M")=='Mar')?'selected':'';
$apr=(date("M")=='Apr')?'selected':'';  $may=(date("M")=='May')?'selected':'';  $jun=(date("M")=='Jun')?'selected':'';
$jul=(date("M")=='Jul')?'selected':'';  $aug=(date("M")=='Aug')?'selected':'';  $spt=(date("M")=='Sep')?'selected':'';
$oct=(date("M")=='Oct')?'selected':'';  $nov=(date("M")=='Nov')?'selected':'';  $dec=(date("M")=='Dec')?'selected':'';
		
echo '<b>&nbsp;&nbsp; Month:&nbsp;</b>';
echo '<select name="supply_month" id="supply_month" style="width:80px;" required="required">'; 
echo '<option value="Jan">Jan</option>';
echo '<option value="Feb">Feb</option>';
echo '<option value="Mar">Mar</option>';
echo '<option value="Apr">Apr</option>';
echo '<option value="May">May</option>';
echo '<option value="Jun">Jun</option>';
echo '<option value="Jul" '.$jul.'>Jul</option>';
echo '<option value="Aug">Aug</option>';
echo '<option value="Sep">Sep</option>';
echo '<option value="Oct">Oct</option>';
echo '<option value="Nov">Nov</option>';
echo '<option value="Dec">Dec</option>';
echo '</select>&nbsp;&nbsp;'; 


//echo '<b>&nbsp;&nbsp;Competitor:&nbsp;</b>';
//echo '<input type="text" name="competitor" id="competitor">'; 


echo '&nbsp;&nbsp;<input type="hidden" name="sp_id" id="sp_id" value="'.$_GET['ipg'].'">'; 


//echo '<input type="button"  style="background-color:orange; color:white;" value="show"  onClick="alert(document.getElementById(\'competitor\').value)" >'; 

echo '<input type="button"  style="background-color:orange; color:white;" value="Add"  onClick="add_to_cart_data(document.getElementById(\'sp_id\').value, document.getElementById(\'qty\').value),document.getElementById(\'supply_year\').value,document.getElementById(\'supply_month\').value,document.getElementById(\'tilecategory\').value" >'; 

//echo '<input type="button"  style="background-color:orange; color:white;" value="Add"  onClick="add_to_cart_data(document.getElementById(\'sp_id\').value, document.getElementById(\'qty\').value),document.getElementById(\'competitor\').value,document.getElementById(\'tilecategory\').value" >'; 


//echo '<input type="button"  style="background-color:orange; color:white;" value="Add"  onClick="add_to_cart_data(document.getElementById(\'sp_id\').value, document.getElementById(\'qty\').value)" >'; 


?>
