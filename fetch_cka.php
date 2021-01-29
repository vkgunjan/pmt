<?php
	
   include('including/all-include.php');
   $uid = $_SESSION['uid'];
   /*var_dump($_REQUEST);*/

   if (isset($_POST['cka'])) {
    $cka = $_POST['cka'];
     $sql = "SELECT c.cka_name_id,c.cka_name,c.address,c.city,c.e_status, c.sub_status, e.engagement, c.engaged, c.cka_category, s.eng_sub_name, d.deal_sub_type
    from cka_name_master c
    left join deal_sub_type d on d.deal_sub_type_id = c.account_type
    left join engagement_status e on e.id = c.e_status
    left join engagement_sub_status s on s.id = c.sub_status
    where c.cka_name_id = '$cka'";
     $result = odbc_exec($conn, $sql);
     while ($row = odbc_fetch_array($result)) {
      $data["cka_name_id"] = $row["cka_name_id"];
       $data["account_name"] = $row["cka_name"];
       $data["deal_sub_type"] = $row["deal_sub_type"];
       $data["city"] = $row["city"];
       $data["engaged"] = $row["engaged"];
       $data["e_status_id"] = $row["e_status"];
       $data["e_status"] = $row["engagement"];
       $data["e_sub_status_id"] = $row["sub_status"];
       $data["e_sub_status"] = $row["eng_sub_name"];
       $data["address"] = $row["address"];
       $data["cka_category"] = $row["cka_category"];
     }

     echo json_encode($data);
   }

   if (isset($_POST['eng'])) {
    $eng = $_POST['eng'];
     $sql = "SELECT * from engagement_sub_status where engagement_id = '$eng' and eng_sub_status = 1";
     $result = odbc_exec($conn, $sql);
     $sub = array();
     while ($row = odbc_fetch_array($result)) {
      $sub_id = $row['id'];
      $sub_name = $row['eng_sub_name'];

      $data[] = array("id" => $sub_id, "eng_sub_name" => $sub_name);
      /*$sub[] = array("eng_sub_name" => $sub_name);*/

     }

     echo json_encode($data);
   }


   if (isset($_POST['account_name_modal_u'])) {
    $account_name_modal_u = $_POST['account_name_modal_u'];
    $engaged_u = $_POST['engaged_u'];
    /*$architect_modal_u = $_POST['architect_modal_u'];*/
    $c_city = $_POST['c_city'];
    $eng_status_modal_u = $_POST['eng_status_modal_u'];
    $sub_status_modal_u = $_POST['sub_status_modal_u'];
    $address_modal_u = $_POST['address_modal_u'];
    $cka_category_modal_u = $_POST['cka_category_modal_u'];


     $sql_update = 
     "UPDATE cka_name_master set 
     engaged = '$engaged_u',
     city = '$c_city',
     e_status = '$eng_status_modal_u',
     sub_status = '$sub_status_modal_u',
     cka_category = '$cka_category_modal_u',
     address = '$address_modal_u',
     updated_by = '$uid',
     updated_on = getdate()
     WHERE cka_name_id = '$account_name_modal_u'";
     $result = odbc_exec($conn, $sql_update);
     
     echo json_encode($sub);
   }


?>