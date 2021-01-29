
<?php 
//echo 'hello';
//print_r($_GET);
   include_once('including/all-include.php');

   //include_once('assets/bootstrap-daterangepicker/date.js');


/*echo '<b>Plant:&nbsp;</b>';*/
echo '<select name="d_location" id="d_location" style="width:120px;" required="required">'; 
echo '<option value="">-Plant-</option>';
echo '<option value="SKD">SKD</option>';
echo '<option value="HSK">HSK</option>';
echo '<option value="Dora">Dora</option>';
echo '<option value="Local Morbi">Local Morbi</option>';


echo '</select>'; 




/*echo '<b>Tile Category:&nbsp;</b>';*/
echo '&nbsp;&nbsp;';
echo '<select name="tilecategory" id="tilecategory" style="width:130px;" required="required">'; 
echo '<option value="">-Tile Category-</option>';
echo '<option value="Ceramic">Ceramic</option>';
echo '<option value="DC">DC</option>';
echo '<option value="DGVT">DGVT</option>';
echo '<option value="Lapato">Lapato</option>';
echo '<option value="Nano">Nano</option>';
echo '<option value="Pavers">Pavers</option>';
echo '<option value="PDC">PDC</option>';
echo '<option value="PGVT">PGVT</option>';
echo '<option value="PVT">PVT</option>';
echo '<option value="School Tiles">School Tiles</option>';

echo '</select>'; 


//echo '<b>&nbsp;&nbsp;&nbsp;Qty (SQMT) :&nbsp;</b>';
echo '&nbsp&nbsp&nbsp';
echo '<input type="text" placeholder="Tile Name" name="tile_name" id="tile_name" style="width:165px;height: 30px;" required="required">';
echo '&nbsp&nbsp&nbsp&nbsp';
echo '<input type="number" placeholder="Qty(SQMT)" name="qty" id="qty" style="width:100px;height: 30px;" required="required">'; 

//echo '<b>&nbsp;&nbsp;Competitor:&nbsp;</b>';
//echo '<input type="text" name="competitor" id="competitor">'; 
echo '&nbsp&nbsp&nbsp';
/*echo '<b>&nbsp;&nbsp;&nbsp;OBL Price/SQMT:&nbsp;</b>';*/
//echo '<input type="number" placeholder="Qty(SQMT)" name="qty" id="qty" style="width:80px;">';
echo '<input type="number" placeholder="OBL Price/SQMT"  name="obl_price" id="obl_price" style="width:150px;height: 30px;" required="required">';

echo '&nbsp&nbsp&nbsp';
/*echo '<b>&nbsp;&nbsp;Competitor:&nbsp;</b>';*/
echo '<select name="competitor" id="competitor" style="width:160px;" required="required">'; 
echo '<option value="">-Competitor-</option>';
echo '<option value="Kajaria">Kajaria</option>';
echo '<option value="Somany">Somany</option>';
echo '<option value="NITCO">NITCO</option>';
echo '<option value="Asian Granito (AGL)">Asian Granito (AGL)</option>';
echo '<option value="HR Johnson">HR Johnson</option>';
echo '<option value="RAK Ceramics">RAK Ceramics</option>';
echo '<option value="HSIL (Hindware)">HSIL (Hindware)</option>';
echo '<option value="Simpolo">Simpolo</option>';
echo '<option value="Varmora">Varmora</option>';
echo '<option value="Local Morbi">Local Morbi</option>';
echo '</select>'; 



/*echo '&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<input type="number" placeholder="Contact No" name="contact_no" id="contact_no" style="width:120px;" required="required">';*/
  

echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" name="sp_id" id="sp_id" value="'.$_GET['ipg'].'">'; 


//echo '<input type="button"  style="background-color:orange; color:white;" value="show"  onClick="alert(document.getElementById(\'competitor\').value)" >'; 

echo '<input type="button" class="btn"  style="background-color:orange; color:white;" value="Add"  onClick="add_to_cart_data(document.getElementById(\'sp_id\').value,document.getElementById(\'d_location\').value, document.getElementById(\'qty\').value,document.getElementById(\'competitor\').value,document.getElementById(\'obl_price\').value,document.getElementById(\'tile_name\').value,document.getElementById(\'tilecategory\').value)" >'; 


//echo '<input type="button"  style="background-color:orange; color:white;" value="Add"  onClick="add_to_cart_data(document.getElementById(\'sp_id\').value, document.getElementById(\'qty\').value)" >'; 


?>
