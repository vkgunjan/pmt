<?php
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp1=date('YmdHis');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];

if(!empty($_POST['pid']) && $_POST['pid']>0){

/*print_r($_POST['pid']);
exit();*/
    $valid_extensions = array('pdf' , 'doc'); // valid extensions

if(!empty($_POST['pid']) || !empty($_POST['u_get_category']) || !empty($_POST['u_get_sub_category']) || !empty($_POST['u_get_dept']) || !empty($_POST['u_get_city']) || !empty($_POST['u_get_cat']) || !empty($_POST['u_get_doc_name']) || !empty($_POST['u_get_doc_desc']) || !empty($_POST['u_creation_remark']) || $_FILES['file'])
{
$u_path = 'assets/get_doc/'.$_POST['u_get_category'].'/'; // upload directory
$img = $_POST['filename'];
/*$img = $_FILES['file']['newFile'];*/
$tmp = $_FILES['file']['tmp_name'];
// get uploaded file's extension
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
// can upload same image using rand function
$final_image = $timestamp1.'.'.$ext;
// check's valid format
if(in_array($ext, $valid_extensions)) 
{ 
$u_path = $u_path.strtolower($final_image); 
if(move_uploaded_file($tmp,$u_path)) 
{
/*echo "<img src='$path' />";*/
$u_get_category = $_POST['u_get_category'];
$u_get_sub_category = $_POST['u_get_sub_category'];
$u_get_dept = $_POST['u_get_dept'];
$u_get_city = $_POST['u_get_city'];
$u_get_cat = $_POST['u_get_cat'];
$u_doc_name = str_replace("'", "''", $_POST['u_get_doc_name']);
$u_doc_desc = str_replace("'", "''", $_POST['u_get_doc_desc']);
$u_creation_remark = str_replace("'", "''", $_POST['u_creation_remark']);
$u_pid = $_POST['pid'];

//insert form data in the database
$insert = "UPDATE get_doc_new set 
         get_title='$u_doc_name',
         get_name='$u_doc_name',
         get_desc='$u_doc_desc',
         get_category='$u_get_category',
         get_sub_category='$u_get_sub_category',
         get_dept='$u_get_dept',
         get_city='$u_get_city',
         get_pdf='$u_path',
         get_cat='$u_get_cat',
         creation_remark='$u_creation_remark',
         get_status='0' where get_id = '$u_pid'
         ";

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
}

 ?>