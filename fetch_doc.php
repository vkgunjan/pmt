<?php
	
   include('including/all-include.php');
   $uid = $_SESSION['uid'];
   include('including/datetime.php');
  $timestamp1=date('YmdHis');
  $timestamp=date('Y-m-d H:i:s');
   /*var_dump($_REQUEST);*/

/*   if (isset($_POST['cka'])) {
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
*/
   if (isset($_POST['get_category'])) {
    $get_category = $_POST['get_category'];
     $sql = "SELECT * from get_category where category_name = '$get_category' and category_status = 1 order by category_sub_name asc";
     $result = odbc_exec($conn, $sql);
     $sub = array();
     while ($row = odbc_fetch_array($result)) {
      $category_sub_id = $row['category_sub_id'];
      $category_sub_name = $row['category_sub_name'];

      $data[] = array("category_sub_id" => $category_sub_id, "category_sub_name" => $category_sub_name);
      /*$sub[] = array("eng_sub_name" => $sub_name);*/

     }

     echo json_encode($data);
   }


   if (isset($_POST['get_department'])) {
    $get_department = $_POST['get_department'];
     $sql = "SELECT * from get_department where get_category = '$get_department' and get_status = 1 order by get_department asc";
     $result = odbc_exec($conn, $sql);
     $sub = array();
     while ($row = odbc_fetch_array($result)) {
      $dpt_id = $row['dpt_id'];
      $get_department = $row['get_department'];

      $data[] = array("dpt_id" => $dpt_id, "get_department" => $get_department);
      /*$sub[] = array("eng_sub_name" => $sub_name);*/

     }

     echo json_encode($data);
   }




?>


