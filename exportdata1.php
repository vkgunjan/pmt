<?php
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('including/connect.php');

//$SQL = "SELECT * from company_obtb_footfall where uid='".$_SESSION['id']."'";
$header = '';
$result ='';
$val=base64_decode($_GET['val']);
$exportData = odbc_exec ($conn, $val) or die ( "Sql error : " . odbc_error($link) );
 
$fields = odbc_num_fields ( $exportData );
 
for ( $i = 0; $i < $fields; $i++ )
{
    $header .= odbc_fetch_array($exportData , $i ) . "\t";
}
 
while( $row = odbc_fetch_row( $exportData ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
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
 
?>
