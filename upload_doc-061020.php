<?php
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp1=date('YmdHis');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];


$valid_extensions = array('pdf' , 'doc'); // valid extensions

if(!empty($_POST['get_category']) || !empty($_POST['get_sub_category']) || !empty($_POST['get_dept']) || !empty($_POST['get_city']) || !empty($_POST['get_cat']) || !empty($_POST['get_doc_name']) || !empty($_POST['get_doc_desc']) || !empty($_POST['creation_remark']) || $_FILES['file'])
{
$path = 'assets/get_doc/'.$_POST['get_category'].'/'; // upload directory
$img = $_FILES['file']['name'];
$tmp = $_FILES['file']['tmp_name'];
// get uploaded file's extension
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
// can upload same image using rand function
$final_image = $timestamp1.'.'.$ext;
// check's valid format
if(in_array($ext, $valid_extensions)) 
{ 
$path = $path.strtolower($final_image); 
if(move_uploaded_file($tmp,$path)) 
{
/*echo "<img src='$path' />";*/
$get_category = $_POST['get_category'];
$get_sub_category = $_POST['get_sub_category'];
$get_dept = $_POST['get_dept'];
$get_city = $_POST['get_city'];
$get_cat = $_POST['get_cat'];
$doc_name = str_replace("'", "''", $_POST['get_doc_name']);
$doc_desc = str_replace("'", "''", $_POST['get_doc_desc']);
$creation_remark = str_replace("'", "''", $_POST['creation_remark']);

//insert form data in the database
$insert = "INSERT INTO get_doc_new (
            get_title,
            get_name,
            get_desc,
            get_category,
            get_sub_category,
            get_dept,
            get_city,
            get_pdf,
            get_date,
            get_cat,
            creation_remark,
            created_on,
            created_by,
            get_status
              )";
            $insert .= " values (
            '$doc_name',
            '$doc_name',
            '$doc_desc',
            '$get_category',
            '$get_sub_category',
            '$get_dept',
            '$get_city',
            '$path',
            '$timestamp',
            '$get_cat',
            '$creation_remark',
            '$timestamp',
            '$uid',
            '0'
          )";

          $stmt = odbc_prepare($conn, $insert);
          $lead_result = odbc_execute($stmt);
//echo $insert?'ok':'err';
/*$data = 'valid';
echo json_encode($data);*/
}
} 
else 
{
echo 'invalid';
/*echo 'invalid';*/
}
}
?>

