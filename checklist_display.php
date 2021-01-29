<?php
//print_r($_GET);

$maintenance_type=$_GET['ipg'];

include_once('including/all-include.php');

$checklist_asset_type_id=$_SESSION['checklist_asset_type_id'];

$ssql="select * from checklist_master where asset_type_id='".$checklist_asset_type_id."' ";	

$rs=odbc_exec($conn,$ssql);

?>

<table style="width:100%;" >
		<tr>
        	<td colspan="3" align="center" style="background-color:#009F2B; color:#FFFFFF;">PICK MAINTENANCE CHECKLIST</td>
        </tr>

        <tr>
		<td>
<?php
			while($f = odbc_fetch_array($rs)){
			echo '<input type="checkbox" name="checklist[]" value="'.$f['checklist_id'].'">'.$f['checklist_name'].' ';				
			echo '<br>';
			}

?>
    		

		<td>
        </tr>
   <tr>
   <td><hr></td>
   </tr>
    </table>