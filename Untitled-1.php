
<?php 
//echo 'hello';
//print_r($_GET);
   include_once('including/all-include.php');
$ssql="select * from spare_part_master s left join uom_master u on s.uom_id = u.uom_id where s.spare_part_id='".$_GET['ipg']."' ";	
$rs=odbc_exec($conn,$ssql);
$f = odbc_fetch_array($rs);
//print_r($f);									
echo '<b>UOM: '.$f['uom_name'].'</b>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;';
echo '<b>Used Quantity:</b>';
echo '<input type="text">'; 
echo '<input type="button" value="Add" style="margin-top:-10px;">'; 

?>
