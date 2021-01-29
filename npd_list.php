<?php
  
   include('including/all-include.php');
   $uid = $_SESSION['uid'];
   /*var_dump($_REQUEST);*/

   if (isset($_POST['id'])) {
    $opp_id = $_POST['id'];
     $sql = "SELECT 
o.opportunity_id, s.deal_sub_type,c.cka_name,o.city, o.tile_stage_date, o.project_tile_potential_sqm, u.employee_department, o.added_date, o.npd_remark
from opportunity o
inner join cka_name_master c on c.cka_name_id = o.cka_name_id
inner join deal_sub_type s on s.deal_sub_type_id = o.sub_type
inner join user_management u on u.uid = o.created_by
    where o.opportunity_id = '$opp_id'";
     $result = odbc_exec($conn, $sql);
     while ($row = odbc_fetch_array($result)) {
      $data["deal_sub_type"] = $row["deal_sub_type"];
       $data["cka_name"] = $row["cka_name"];
       $data["city"] = $row["city"];
       $data["tile_stage_date"] = $row["tile_stage_date"];
       $data["project_tile_potential_sqm"] = $row["project_tile_potential_sqm"];
       $data["employee_department"] = $row["employee_department"];
       $data["added_date"] = $row["added_date"];
       $data["short_remark"] = $row["npd_remark"];
     }

     echo json_encode($data);
   }


?>
