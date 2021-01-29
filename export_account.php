<?php 
ob_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('including/connect.php');
$name_proj = 'PMT_Account_Engagement_'.date('Ymd').'.xls';

//$header = '';
$result_proj ='';
$val_proj=base64_decode($_GET['val_proj']);
$exportProj = odbc_exec($conn, $val_proj) or die ( "Sql error : ");
//$exportData1 = odbc_exec($conn, $val) or die ( "Sql error : ");
 
$fields_proj = odbc_num_fields ( $exportProj );
/*foreach (odbc_fetch_array($exportData) as $key=>$value) {*/
	 /*var_dump($key); exit;*/
		/*if($key != 'territory')
        $header .= $key."\t";*/
	/*var_dump($header); exit;*/
/*}*/

$header_proj ='';
$header_proj = "Account ID"."\t"."Deal Type"."\t"."Deal Sub Type"."\t"."Account Name"."\t"."City"."\t"."Engaged"."\t"."Enagegement Status"."\t"."Engagement Sub Status"."\t"."Project Count"."\t"."Total SQMT"."\t"."Category"."\t"."Updated By"."\t"."Updated On"."\t";
 
while( $row = odbc_fetch_array( $exportProj ) )
{
	/*unset($row['territory']);*/
	//unset($row['opportunity_id']);
	
		$line = '';
		foreach( $row as $value_proj )
		{                                            
			if ( ( !isset( $value_proj ) ) || ( $value_proj == "" ) )
			{
				$value_proj = "\t";
			}
			else
			{
				$value_proj = str_replace( '"' , '""' , $value_proj );
				$value_proj = '"' . $value_proj . '"' . "\t";
			}
			$line .= $value_proj;
		}
		$result_proj .= trim( $line ) . "\n";
	
}
$result_proj = str_replace( "\r" , "" , $result_proj );
 
if ( $result_proj == "" )
{
    $result_proj = "\nNo Record(s) Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$name_proj");
header("Pragma: no-cache");
header("Expires: 0");
print "$header_proj\n$result_proj";

 ?>