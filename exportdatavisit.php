<?php
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('including/connect.php');

$name = 'visit_summary_'.date('Ymd').'.xls';

//$header = '';
$result ='';
$val=base64_decode($_GET['val']);
$exportData = odbc_exec($conn, $val) or die ( "Sql error : ");
//$exportData1 = odbc_exec($conn, $val) or die ( "Sql error : ");
 
$fields = odbc_num_fields ( $exportData );
/*foreach (odbc_fetch_array($exportData) as $key=>$value) {*/
	 /*var_dump($key); exit;*/
		/*if($key != 'territory')
        $header .= $key."\t";*/
	/*var_dump($header); exit;*/
/*}*/

$header ='';
$header = "Opportunity ID"."\t"."Lead ID"."\t"."Account Name"."\t"."Project Name"."\t"."Visit Activity"."\t"."Person Name"."\t"."Person Contact"."\t"."Visit Date"."\t"."Visit Remarks"."\t"."Tile Stage Date"."\t"."Project Tile Potential(INR)"."\t"."Project Tile Potential(SQMT)"."\t"."OBL Sales Forecast(INR)"."\t"."OBL Sales Forecast(SQMT)"."\t"."Created By"."\t"."Employee Department"."\t"."Visit Added Date"."\t"."Lead Last Modified"."\t"."Lead Status"."\t";
 
while( $row = odbc_fetch_array( $exportData ) )
{
	/*unset($row['territory']);*/
	//unset($row['opportunity_id']);
	
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
header("Content-Disposition: attachment; filename=$name");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
 
?>
