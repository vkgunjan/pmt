<?php
  
   include_once('including/all-include.php');


$SQL = "select  IIF(w.workorder_status is null, 'Pending', IIF(w.workorder_status = 1, 'Work on progress', IIF(w.workorder_status = 2, 
'Pending for approval', IIF(w.workorder_status = 3, 'Completed','')))) as workorder_current_status, 
iif(w.work_order_engineer_id is null,'', (select fullname from user_management where cast(uid as char) = w.work_order_engineer_id)) as wo_engineer, 
u.fullname as [wo accepted by],s.schedule_id, s.schedule_generated_date,ss.recurrence_schedule,ss.frequency, w.* from  work_order w
left join schedule_generated s on s.schedule_generated_id = w.schedule_generated_id
left join schedule ss on s.schedule_id = ss.schedule_id
left join user_management u on u.uid = w.workorder_accepted_by_uid ";

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
