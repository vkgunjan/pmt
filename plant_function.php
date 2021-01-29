<?php
// var_dump($_REQUEST);
// die;

   function load_category(){
      include('including/connect.php');
      $output = '';
      $sql = "select distinct pr_product_group from product_master order by pr_product_group asc";
      $result = odbc_exec($conn, $sql);
      while($f = odbc_fetch_array($result)){
         $output .= '<option value="'.trim($f['pr_product_group']).'">'.trim($f['pr_product_group']).'</option>'; 
      }
      
     return $output;

   }

   function load_sku_size(){
      include('including/connect.php');
      $output = '';
      $sql = "select distinct pr_sku_size from product_master order by pr_sku_size asc";
      $result = odbc_exec($conn, $sql);
      while($f = odbc_fetch_array($result)){
         $output .= '<option value="'.trim($f['pr_sku_size']).'">'.trim($f['pr_sku_size']).'</option>'; 
      }
      
     return $output;

   }
                                                                                                                                                                  
   function load_plant(){
      include('including/connect.php');
      $output = '';
      $sql = "select * from plant_master order by plant_name asc";
      $result = odbc_exec($conn, $sql);
      while($f = odbc_fetch_array($result)){
         $output .= '<option value="'.$f['plant_id'].'">'.trim($f['plant_name']).'</option>'; 
      }
      
     return $output;

   }

   function load_comp(){
      include('including/connect.php');
      $output = '';
      $sql = "select * from competitor order by c_name asc";
      $result = odbc_exec($conn, $sql);
      while($f = odbc_fetch_array($result)){
         $output .= '<option value="'.$f['c_id'].'">'.trim($f['c_name']).'</option>'; 
      }
      
     return $output;

   }
   function load_cp(){
      include('including/connect.php');
      $output = '';
      $sql = "select * from channel_partner order by p_name asc";
      $result = odbc_exec($conn, $sql);
      while($f = odbc_fetch_array($result)){
         $output .= '<option value="'.$f['p_id'].'">'.$f['p_name'].'</option>'; 
      }
      
     return $output;

   }
?>