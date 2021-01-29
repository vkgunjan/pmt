<?php  
 include_once('including/all-include.php');

 $SQL = "select gs.schedule_generated_date, s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.maintenance_type_id, 
m.maintenance_type , a.asset_code, a.asset_name , at.asset_type, a.asset_kept_area, p.plant_building_name ,
w.schedule_generated_id as wosid, w.workorder_status, w.work_order_engineer_id,
IIF(w.workorder_status is null, 'Pending', IIF(w.workorder_status = 1, 'Work on progress', IIF(w.workorder_status = 2, 
'Pending for approval', IIF(w.workorder_status = 3, 'Completed','')))) as workorder_current_status, 
iif(w.work_order_engineer_id is null,'', (select fullname from user_management where cast(uid as char) = w.work_order_engineer_id)) as wo_engineer
 from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where gs.schedule_generated_date >= '".$_GET['fromdate']."' and gs.schedule_generated_date <= '".$_GET['todate']."' ";
//exit;
$header = '';
$result ='';
//$rs=odbc_exec($conn,$btsel);
//$f = odbc_fetch_array($rs);
		
$exportData = odbc_exec ($conn, $SQL ) or die ( "execute error" );
 
$fields = odbc_num_fields ( $exportData );

for ( $i = 1; $i <= $fields; $i++)
{
     $header .= odbc_field_name( $exportData , $i ) . "\t";
}
 

 
while($row = odbc_fetch_array($exportData))
{
    $line = '';
    foreach( $row as $value )
    {                                            
        //echo $value;
		if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $result .= trim( $line ) . "\n";
}

$result = str_replace( "\r" , "" , $result );
 
if ( $result == "" )
{
    $result = "\nNo Record(s) Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=export.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
unset($header);
unset($result); 
?>
