<?php
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('including/connect.php');

$name_arch = 'PMT_Won_Summary_'.date('Ymd').'.xls';

//$header = '';
$result_arch ='';
$val_won=base64_decode($_GET['val_won']);
$exportArch = odbc_exec($conn, $val_won) or die ( "Sql error : ");
//$exportData1 = odbc_exec($conn, $val) or die ( "Sql error : ");
 
$fields_arch = odbc_num_fields ( $exportArch );
/*foreach (odbc_fetch_array($exportData) as $key=>$value) {*/
	 /*var_dump($key); exit;*/
		/*if($key != 'territory')
        $header .= $key."\t";*/
	/*var_dump($header); exit;*/
/*}*/

$header_arch ='';
$header_arch = "Opportunity ID"."\t"."Lead ID"."\t"."Project Name"."\t"."Account Name"."\t"."Territory"."\t"."State"."\t"."City"."\t"."Tile Category"."\t"."Tile Size"."\t"."Final Tile Name"."\t"."Final Qty(SQMT)"."\t"."Competitor"."\t"."OBL Price/SQMT"."\t"."Plant"."\t"."Created By"."\t"."Department"."\t"."Tiling Date"."\t"."Added On"."\t"."Last Updated"."\t"."Lead Status"."\t";
 
while( $row = odbc_fetch_array( $exportArch ) )
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
		$result_arch .= trim( $line ) . "\n";
	
}
$result_arch = str_replace( "\r" , "" , $result_arch );
 
if ( $result_arch == "" )
{
    $result_arch = "\nNo Record(s) Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$name_arch");
header("Pragma: no-cache");
header("Expires: 0");
print "$header_arch\n$result_arch";
 
?>


