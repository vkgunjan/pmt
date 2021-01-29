<?php
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp1=date('YmdHis');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];

if (isset($_POST['upload'])) {
    # code...

    $file = $_FILES['newDoc'];
    /*print_r($file);*/
   /* var_dump($file);
    exit();*/

    $fileName = $_FILES['newDoc']['name'];
    $fileTmpName = $_FILES['newDoc']['tmp_name'];
    $fileSize = $_FILES['newDoc']['size'];
    $fileError = $_FILES['newDoc']['error'];
    $fileType = $_FILES['newDoc']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'doc');

    $get_category = $_POST['get_category'];
    $get_sub_category = $_POST['get_sub_category'];
    $get_dept = $_POST['get_dept'];
    $get_city = $_POST['get_city'];
    $get_cat = $_POST['get_cat'];
    $doc_name = str_replace("'", "''", $_POST['get_doc_name']);
    $doc_desc = str_replace("'", "''", $_POST['get_doc_desc']);
    $creation_remark = str_replace("'", "''", $_POST['creation_remark']);

    /*var_dump($get_category);*/

    if(in_array($fileActualExt, $allowed)){
        if ($fileError === 0) {
            if ($fileSize < 4000000) {
                $fileNameNew = $timestamp1.".".$fileActualExt;
                $path = 'assets/get_doc/'.$get_category.'/';
                $fileDestination = $path.$fileNameNew;
                /*var_dump($fileDestination);*/
                $hasFileUploaded = move_uploaded_file($fileTmpName, $fileDestination);
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
                                '$fileNameNew',
                                '$timestamp',
                                '$get_cat',
                                '$creation_remark',
                                '$timestamp',
                                '$uid',
                                '0'
                              )";

                              $stmt = odbc_prepare($conn, $insert);
                              $lead_result = odbc_execute($stmt);
                if ($lead_result) {
                    
                    $msgTxt = 'New Document added successfully. Waiting for Approval.';
                    $msgType = 1;
                    //insert form data in the database
                    
                }else {
                    $msgTxt = 'Sorry! Unable To Add New Document Due To Some Reason. Please Try Later.';
                    $msgType = 2;
                }
            }else {
                    $msgTxt = 'Document Size is more than the limit provided.';
                    $msgType = 2;
            }
        }else {
                    $msgTxt = 'Sorry! Unable To Add New Document Due To Some Reason. Please Try Later.';
                    $msgType = 2;  
        }
    }else {
                    $msgTxt = 'Kindly choose only PDF file to upload.';
                    $msgType = 2;
    }



    header('Location:list-doc.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
    exit;

}

?>

<?php 
    if (isset($_POST['update'])) {
    # code...
    $u_pid = $_POST['pid'];
    $file = $_FILES['newFile'];
    $get_current_category = $_POST['get_current_category'];
    /*print_r($file);*/
   /* var_dump($file);
    exit();*/
    $img_url = $_POST['img_url'];
    $newFileName = $img_url;

    $fileName = $_FILES['newFile']['name'];
    $fileTmpName = $_FILES['newFile']['tmp_name'];
    $fileSize = $_FILES['newFile']['size'];
    $fileError = $_FILES['newFile']['error'];
    $fileType = $_FILES['newFile']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'doc');

    $u_get_category = $_POST['u_get_category'];
    $u_get_sub_category = $_POST['u_get_sub_category'];
    $u_get_dept = $_POST['u_get_dept'];
    $u_get_city = $_POST['u_get_city'];
    $u_get_cat = $_POST['u_get_cat'];
    $u_get_doc_name = str_replace("'", "''", $_POST['u_get_doc_name']);
    $u_get_doc_desc = str_replace("'", "''", $_POST['u_get_doc_desc']);
    $u_creation_remark = str_replace("'", "''", $_POST['u_creation_remark']);

    /*var_dump($get_category);*/

    if(in_array($fileActualExt, $allowed)){
        if ($fileError === 0) {
            if ($fileSize < 4000000) {
                $newFileName = $timestamp1.".".$fileActualExt;
                $path = 'assets/get_doc/'.$u_get_category.'/';
                $fileDestination = $path.$newFileName;
                /*var_dump($fileDestination);*/
                $hasFileUploaded = move_uploaded_file($fileTmpName, $fileDestination);
                
            }

            else {
                    $msgTxt = 'Document Size is more than the limit provided.';
                    $msgType = 2;
            }
        }else {
                    $msgTxt = 'Sorry! Unable To Add New Document Due To Some Reason. Please Try Later.';
                    $msgType = 2;  
        }
    }else {
                    $msgTxt = 'Kindly choose only PDF file to upload.';
                    $msgType = 2;
    }



    $update = "UPDATE get_doc_new set 
                 get_title='$u_get_doc_name',
                 get_name='$u_get_doc_name',
                 get_desc='$u_get_doc_desc',
                 get_category='$u_get_category',
                 get_sub_category='$u_get_sub_category',
                 get_dept='$u_get_dept',
                 get_city='$u_get_city',
                 get_pdf='$newFileName',
                 get_cat='$u_get_cat',
                 creation_remark='$u_creation_remark',
                 get_status='0' where get_id = '$u_pid'
                 ";

                  $stmt = odbc_prepare($conn, $update);
                  $lead_result = odbc_execute($stmt);
                if ($lead_result) {

                    if($hasFileUploaded){
                        unlink('assets/get_doc/'.$get_current_category.'/'.$img_url);
                    }
                    
                    $msgTxt = 'Document details have been updated successfully. Waiting for Approval.';
                    $msgType = 1;
                    //insert form data in the database
                    
                }else {
                    $msgTxt = 'Sorry! Unable To Add New Document Due To Some Reason. Please Try Later.';
                    $msgType = 2;
                }



    header('Location:list-doc.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
    exit;

}
 ?>

 <?php 
    if (isset($_POST['reject'])) {
    # code...
    $u_pid = $_POST['pid'];
    $file = $_FILES['newFile'];
    $get_current_category = $_POST['get_current_category'];
    /*print_r($file);*/
   /* var_dump($file);
    exit();*/
    $img_url = $_POST['img_url'];
    $newFileName = $img_url;

    $fileName = $_FILES['newFile']['name'];
    $fileTmpName = $_FILES['newFile']['tmp_name'];
    $fileSize = $_FILES['newFile']['size'];
    $fileError = $_FILES['newFile']['error'];
    $fileType = $_FILES['newFile']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'doc');

    $u_get_category = $_POST['u_get_category'];
    $u_get_sub_category = $_POST['u_get_sub_category'];
    $u_get_dept = $_POST['u_get_dept'];
    $u_get_city = $_POST['u_get_city'];
    $u_get_cat = $_POST['u_get_cat'];
    $u_get_doc_name = str_replace("'", "''", $_POST['u_get_doc_name']);
    $u_get_doc_desc = str_replace("'", "''", $_POST['u_get_doc_desc']);
    $u_creation_remark = str_replace("'", "''", $_POST['u_creation_remark']);
    $u_approval_remark = str_replace("'", "''", $_POST['u_approval_remark']);
    /*var_dump($get_category);*/

    if(in_array($fileActualExt, $allowed)){
        if ($fileError === 0) {
            if ($fileSize < 4000000) {
                $newFileName = $timestamp1.".".$fileActualExt;
                $path = 'assets/get_doc/'.$u_get_category.'/';
                $fileDestination = $path.$newFileName;
                /*var_dump($fileDestination);*/
                $hasFileUploaded = move_uploaded_file($fileTmpName, $fileDestination);
                
            }

            else {
                    $msgTxt = 'Document Size is more than the limit provided.';
                    $msgType = 2;
            }
        }else {
                    $msgTxt = 'Sorry! Unable To Reject Document Due To Some Reason. Please Try Later.';
                    $msgType = 2;  
        }
    }else {
                    $msgTxt = 'Kindly choose only PDF file to upload.';
                    $msgType = 2;
    }



    $update = "UPDATE get_doc_new set 
                 get_title='$u_get_doc_name',
                 get_name='$u_get_doc_name',
                 get_desc='$u_get_doc_desc',
                 get_category='$u_get_category',
                 get_sub_category='$u_get_sub_category',
                 get_dept='$u_get_dept',
                 get_city='$u_get_city',
                 get_pdf='$newFileName',
                 get_cat='$u_get_cat',
                 rejection_remark='$u_approval_remark',
                 rejected_by='$uid',
                 rejected_on=getdate(),
                 get_status='2' where get_id = '$u_pid'
                 ";

                  $stmt = odbc_prepare($conn, $update);
                  $lead_result = odbc_execute($stmt);
                if ($lead_result) {

                    if($hasFileUploaded){
                        unlink('assets/get_doc/'.$get_current_category.'/'.$img_url);
                    }
                    
                    $msgTxt = 'Document Rejected successfully.';
                    $msgType = 1;
                    //insert form data in the database
                    
                }else {
                    $msgTxt = 'Sorry! Unable To Reject Document Due To Some Reason. Please Try Later.';
                    $msgType = 2;
                }



    header('Location:list-doc.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
    exit;

}
 ?>

 <?php 
    if (isset($_POST['approve'])) {
    # code...
    $u_pid = $_POST['pid'];
    $file = $_FILES['newFile'];
    $get_current_category = $_POST['get_current_category'];
    /*print_r($file);*/
   /* var_dump($file);
    exit();*/
    $img_url = $_POST['img_url'];
    $newFileName = $img_url;

    $fileName = $_FILES['newFile']['name'];
    $fileTmpName = $_FILES['newFile']['tmp_name'];
    $fileSize = $_FILES['newFile']['size'];
    $fileError = $_FILES['newFile']['error'];
    $fileType = $_FILES['newFile']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'doc');

    $u_get_category = $_POST['u_get_category'];
    $u_get_sub_category = $_POST['u_get_sub_category'];
    $u_get_dept = $_POST['u_get_dept'];
    $u_get_city = $_POST['u_get_city'];
    $u_get_cat = $_POST['u_get_cat'];
    $u_get_doc_name = str_replace("'", "''", $_POST['u_get_doc_name']);
    $u_get_doc_desc = str_replace("'", "''", $_POST['u_get_doc_desc']);
    $u_creation_remark = str_replace("'", "''", $_POST['u_creation_remark']);
    $u_approval_remark = str_replace("'", "''", $_POST['u_approval_remark']);

    /*var_dump($get_category);*/

    if(in_array($fileActualExt, $allowed)){
        if ($fileError === 0) {
            if ($fileSize < 4000000) {
                $newFileName = $timestamp1.".".$fileActualExt;
                $path = 'assets/get_doc/'.$u_get_category.'/';
                $fileDestination = $path.$newFileName;
                /*var_dump($fileDestination);*/
                $hasFileUploaded = move_uploaded_file($fileTmpName, $fileDestination);
                
            }

            else {
                    $msgTxt = 'Document Size is more than the limit provided.';
                    $msgType = 2;
            }
        }else {
                    $msgTxt = 'Sorry! Unable To Add New Document Due To Some Reason. Please Try Later.';
                    $msgType = 2;  
        }
    }else {
                    $msgTxt = 'Kindly choose only PDF file to upload.';
                    $msgType = 2;
    }



    $update = "UPDATE get_doc_new set 
                 get_title='$u_get_doc_name',
                 get_name='$u_get_doc_name',
                 get_desc='$u_get_doc_desc',
                 get_category='$u_get_category',
                 get_sub_category='$u_get_sub_category',
                 get_dept='$u_get_dept',
                 get_city='$u_get_city',
                 get_pdf='$newFileName',
                 get_cat='$u_get_cat',
                 approval_remark='$u_approval_remark',
                 approved_on=getdate(),
                 approved_by='$uid',
                 get_status='1' where get_id = '$u_pid'
                 ";

                  $stmt = odbc_prepare($conn, $update);
                  $lead_result = odbc_execute($stmt);
                if ($lead_result) {

                    if($hasFileUploaded){
                        unlink('assets/get_doc/'.$get_current_category.'/'.$img_url);
                    }
                    
                    $msgTxt = 'Document Approved successfully.';
                    $msgType = 1;
                    //insert form data in the database
                    
                }else {
                    $msgTxt = 'Sorry! Unable To Approve Document Due To Some Reason. Please Try Later.';
                    $msgType = 2;
                }



    header('Location:list-doc.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
    exit;

}
 ?>