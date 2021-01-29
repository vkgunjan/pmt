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




 <?php
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp1=date('YmdHis');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];

if (isset($_POST['create'])) {
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
    $opp_id = $_POST['opp_id'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'doc');

    $short_remark = str_replace("'", "''", $_POST['short_remark']);

    /*var_dump($get_category);*/

    if(in_array($fileActualExt, $allowed)){
        if ($fileError === 0) {
            if ($fileSize < 4000000) {
                $fileNameNew = $timestamp1.".".$fileActualExt;
                $path = 'assets/npd_doc/'.$get_category.'/';
                $fileDestination = $path.$fileNameNew;
                /*var_dump($fileDestination);*/
                $hasFileUploaded = move_uploaded_file($fileTmpName, $fileDestination);
                $insert = "UPDATE opportunity 
                        set npd_doc = '$fileNameNew',
                        npd_remark = '$short_remark',
                        npd_status = 'Open',
                        npd_created_by = '$uid',
                        npd_create_date = getdate()
                        where opportunity_id = '$opp_id'
                ";

                              $stmt = odbc_prepare($conn, $insert);
                              $lead_result = odbc_execute($stmt);
                if ($lead_result) {


                    //query for email
                $pid=$_POST['opp_id'];
                $sql_user = "SELECT 
                    d.opportunity_id,
                    d.lead_id,
                    a.cka_name,
                    c.project_type,
                    d.[project_name],
                    e.state_name,
                    d.[city],
                    d.[tile_stage_date],
                    d.[obl_sale_forecast_inr],
                    d.npd_status,
                    d.npd_docket_no,
                    d.npd_docket_date,
                    d.npd_boxes,
                    d.npd_create_date,
                    d.npd_dispatch_remark,
                    u.fullname as [npd_created_by],
                    u.email as [npd_created_by_email],
                    um.fullname as [bm_name],
                    um.email as [bm_email],
                    umm.email as [npd_updated_by]
                    FROM [opportunity] d
                    left  join user_management u on u.uid = d.npd_created_by
                    left join user_management umm on umm.uid = d.npd_updated_by
                    left join user_management um on um.uid = (select parent_id from user_management where uid = d.npd_created_by)
                    left join cka_name_master a on a.cka_name_id = d. cka_name_id
                    left join cka_type_master b on b.cka_type_id = d.cka_type_id
                    left join project_type_master c on c.project_type_id = d.project_type_id
                    left join state_master e on e.state_id = d.state_id
                    where d.opportunity_id = '$pid'";

                $rs=odbc_exec($conn,$sql_user);
                while($f = odbc_fetch_array($rs)){
                    $npd_lead_id = $f['lead_id'];
                    $npd_cka_name = $f['cka_name'];
                    $npd_project_type = $f['project_type'];
                    $npd_project_name = $f['project_name'];
                    $npd_city = $f['city'];
                    $npd_state = strtoupper($f['state_name']);
                    $npd_tiling_date = $f['tile_stage_date'];
                    $npd_obl_sales_forecast_inr = $f['obl_sale_forecast_inr'];
                    $npd_status = $f['npd_status'];
                    $npd_create_date = $f['npd_create_date'];
                    $npd_docket_date = $f['npd_docket_date'];
                    $npd_docket_no = strtoupper($f['npd_docket_no']);
                    $npd_boxes = $f['npd_boxes'];
                    $npd_dispatch_remark = $f['npd_dispatch_remark'];
                    $npd_created_by = strtoupper($f['npd_created_by']);
                    $npd_created_by_email = $f['npd_created_by_email'];
                    $npd_bm_name = $f['bm_name'];
                    $npd_bm_email = $f['bm_email'];
                    $npd_updated_by_email = $f['npd_updated_by'];
                }

                if($npd_docket_date == '1900-01-01'){
                    $npd_docket_date1 = '';
                }else{
                    $npd_docket_date1 = $npd_docket_date;
                }

                //Email Configuration Start
            //$m_email = "vikash.gunjan@orientbell.com";
            $subject = "PMT || NPD ORDER DETAILS - [$npd_lead_id] - $npd_created_by";
                        $to = $npd_created_by_email;
                        $body = '<html>
                             <head>
                             <title></title>
                              <style>
                               table{
                               border-collapse: collapse;
                               width: 100%;
                                 }

                              th, td {
                                border: 0.5px solid #1B5E20;
                                  text-align: center;
                                  padding: 4px;
                                  color:black
                                  font-size:10px;
                                  font-family: Arial, sans-serif;
                                  font-weight:normal;
                                  font-style:normal;
                              }

                              h3,p,div {
                                  font-family: Arial, sans-serif;
                                  font-weight:normal;
                                  font-style:normal;
                                  }

                              tr:nth-child(even){background-color: #f2f2f2}

                              th {
                                  background-color: #0b9444;
                                  color: white;
                                }
                           </style>
                        </head>
                        <body>';
                        
                  $body .= "
                  <h3>Dear $npd_created_by,</h3>

                  <p>This is an auto generated Email, Please do not reply. There is New Product Development Request has been raised. Kindly refer to below details for more clarification.
                  </p>
                    <div>
                     <table>
                           <thead>
                              <tr>
                                     <th>Lead ID</th>
                                     <th>Accunt Name</th>
                                     <th>Project Name</th>
                                     <th>Project Type</th>
                                     <th>State</th>
                                     <th>City</th>
                                     <th>Tiling Date</th>
                                     <th>OBL Forecast</th>
                                     <th>NPD Created By</th>
                                     <th>NPD Created On</th>
                                     <th>NPD Status</th>
                              </tr>
                           </thead>
                           <tbody>
                           <tr>
                                      <td>{$npd_lead_id}</td>
                                      <td>{$npd_cka_name}</td>
                                      <td>{$npd_project_name}</td>
                                      <td>{$npd_project_type}</td>
                                      <td>{$npd_state}</td>
                                      <td>{$npd_city}</td>
                                      <td>{$npd_tiling_date}</td>
                                      <td>{$npd_obl_sales_forecast_inr}</td>
                                      <td>{$npd_created_by}</td>
                                      <td>".date('Y-m-d',strtotime(trim($npd_create_date)))."</td>
                                      <td>{$npd_status}</td>
                               </tr>
                           </tbody>
                           </table>
                    </div>
                    <br><br>
                  ";

                  $body .= '<table>
                           <thead>
                              <tr>
                                     <th>#</th>
                                     <th>Plant</th>
                                     <th>SKU Size</th>
                                     <th>Category</th>
                                     <th>Punch Type</th>
                                     <th>NPD Tile</th>
                                     <th>Reference Tile</th>
                                     <th>Qty(SQMT)</th>
                                     <th>Thickness</th>
                                     <th>Price/SQMT</th>
                                     <th>Expected Date</th>
                                     <th>PO Status</th>
                                     <th>Expected Delivery</th>
                                     <th>Receive Date</th>
                                     <th>Actual Delivery</th>
                                     <th>Matching Status</th>
                              </tr>
                           </thead>
                           <tbody>
                               
                           ';


                  $cat_query = "SELECT
                                npd_id, 
                                opp_id, 
                                plant_name,
                                sku_size,
                                tile_category,
                                punch_type,
                                npd_tile_name,
                                ref_tile_name,
                                tile_qty,
                                tile_thickness,
                                expected_price,
                                expected_date,
                                expected_delivery_date,
                                tile_matching_status,
                                po_status,
                                receive_date,
                                actual_delivery_date,
                                created_on 
                                from npd_tile
                                where opp_id = '$pid'";

                                $rss=odbc_exec($conn,$cat_query);
                                $count=1;
                                while($q = odbc_fetch_array($rss)){
                                    
                                    
                                 
                        $body .= " <tr>
                                          <td>{$count}</td>
                                          <td>{$q['plant_name']}</td>
                                          <td>{$q['sku_size']}</td>
                                          <td>{$q['tile_category']}</td>
                                          <td>{$q['punch_type']}</td>
                                          <td>{$q['npd_tile_name']}</td>
                                          <td>{$q['ref_tile_name']}</td>
                                          <td>{$q['tile_qty']}</td>
                                          <td>".round($q['tile_thickness'],2)."</td>
                                          <td>".round($q['expected_price'],2)."</td>
                                          <td>".date('Y-m-d',strtotime(trim($q['expected_date'])))."</td>
                                          <td>{$q['po_status']}</td>
                                          <td>".date('Y-m-d',strtotime(trim($q['expected_delivery_date'])))."</td>
                                          <td>".date('Y-m-d',strtotime(trim($q['receive_date'])))."</td>
                                          <td>".date('Y-m-d',strtotime(trim($q['actual_delivery_date'])))."</td>
                                          <td>{$q['tile_matching_status']}</td>";
                                          

                      
                  $body .= "</tr>";
                                $count++;
                         }

                  $body .= " </tbody>
                  </table>
                    <br><br>
                  
                  
                  <br><br><br>
                  <div>
                  Regards,<br>
                  Administrator - IT <br>
                  Orient Bell Limited
                  </div>
                  </body></html>";

                  require 'PHPMailer/PHPMailerAutoload.php';

                     $mail = new PHPMailer();
  
                          //Enable SMTP debugging.
                          //$mail->SMTPDebug = 1;
                          //Set PHPMailer to use SMTP.
                          $mail->isSMTP();
                          //Set SMTP host name
                          $mail->Host = "smtp.logix.in";
                          $mail->SMTPOptions = array(
                                            'ssl' => array(
                                                'verify_peer' => false,
                                                'verify_peer_name' => false,
                                                'allow_self_signed' => true
                                            )
                                        );
                          //Set this to true if SMTP host requires authentication to send email
                          $mail->SMTPAuth = TRUE;
                          //Provide username and password
                          $mail->Username = "donotreply@orientbell.com";
                          $mail->Password = "Orient@2019";
                          //If SMTP requires TLS encryption then set it
                          $mail->SMTPSecure = "tls";
                          $mail->Port = 587;
                          

                          
                          
                          $mail->setFrom('donotreply@orientbell.com', 'Orient Bell Limited');
                         $mail->addCC($to);

                         
                          
                          //$mail->addAddress($to);
                          $mail->addAddress('vikash.gunjan@orientbell.com');
                          $mail->addAddress('vkgunjan@gmail.com');
                          
                          $mail->isHTML(true);
                         
                          $mail->Subject = $subject;
                          $mail->Body = $body;
                          $mail->AltBody = "This is the plain text version of the email content";
                          if(!$mail->send())
                          {
                           echo "Mailer Error: " . $mail->ErrorInfo;
                          }
                          else
                          {
                           $msg = "An Email has been sent to your Registerd Email ID";
                          }     
                    // query ends

                    
                    $msgTxt = 'NPD Sample Request Created Successfully.';
                    $msgType = 1;
                    //insert form data in the database
                    
                }else {
                    $msgTxt = 'Sorry! Unable To Create NPD Sample Request. Please Try Later.';
                    $msgType = 2;
                }
            }else {
                    $msgTxt = 'Document Size is more than the limit provided.';
                    $msgType = 2;
            }
        }else {
                    $msgTxt = 'Sorry! Unable To Create NPD Sample Request. Please Try Later.';
                    $msgType = 2;  
        }
    }else {
                    $msgTxt = 'Kindly choose only PDF file to upload.';
                    $msgType = 2;
    }



    header('Location:list_npd_sample.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
    exit;

}

?>