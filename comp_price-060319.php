<?php 
include_once('including/all-include.php');
        include_once('including/header.php');
        include('including/datetime.php');
        include('plant_function.php');
        $timestamp=date('Y-m-d H:i:s');
        $uid = $_SESSION['uid'];
?>

<?php 
      if (isset($_POST['submit'])) {
        $file = $_FILES["file"]['name'];
        $Target="assets/img/upload/".basename($_FILES["file"]['name']);
        $dataArray=array(
          'cp'                        =>  trim(dbOutput($_POST['cp'])),
          'tile_category'             =>  trim(dbOutput($_POST['tile_category'])),
          'sku_size'                  =>  trim(dbOutput($_POST['sku_size'])),
          'o_source'                  =>  trim(dbOutput($_POST['o_source'])),
          'c1_source'                 =>  trim(dbOutput($_POST['c1_source'])),
          'c2_source'                 =>  trim(dbOutput($_POST['c2_source'])),
          'o_price'                   =>  trim(dbOutput($_POST['o_price'])),
          'c1_price'                  =>  trim(dbOutput($_POST['c1_price'])),
          'c2_price'                  =>  trim(dbOutput($_POST['c2_price'])),
          'o_discount'                =>  trim(dbOutput($_POST['o_discount'])),
          'c1_discount'               =>  trim(dbOutput($_POST['c1_discount'])),
          'c2_discount'               =>  trim(dbOutput($_POST['c2_discount'])),
          'o_thickness'               =>  trim(dbOutput($_POST['o_thickness'])),
          'c1_thickness'              =>  trim(dbOutput($_POST['c1_thickness'])),
          'c2_thickness'              =>  trim(dbOutput($_POST['c2_thickness'])),
          'o_tile'                    =>  trim(dbOutput($_POST['o_tile'])),
          'c1_tile'                   =>  trim(dbOutput($_POST['c1_tile'])),
          'c2_tile'                   =>  trim(dbOutput($_POST['c2_tile'])),
          'o_weight'                  =>  trim(dbOutput($_POST['o_weight'])),
          'c1_weight'                 =>  trim(dbOutput($_POST['c1_weight'])),
          'c2_weight'                 =>  trim(dbOutput($_POST['c2_weight'])),
          'o_area'                    =>  trim(dbOutput($_POST['o_area'])),
          'c1_area'                   =>  trim(dbOutput($_POST['c1_area'])),
          'c2_area'                   =>  trim(dbOutput($_POST['c2_area'])),
          'o_factory_price'           =>  trim(dbOutput($_POST['o_factory_price'])),
          'c1_factory_price'          =>  trim(dbOutput($_POST['c1_factory_price'])),
          'c2_factory_price'          =>  trim(dbOutput($_POST['c2_factory_price'])),
          'o_ins'                     =>  trim(dbOutput($_POST['o_ins'])),
          'o_ins_value'               =>  trim(dbOutput($_POST['o_ins_value'])),
          'c1_ins'                    =>  trim(dbOutput($_POST['c1_ins'])),
          'c1_ins_value'              =>  trim(dbOutput($_POST['c1_ins_value'])),
          'c2_ins'                    =>  trim(dbOutput($_POST['c2_ins'])),
          'c2_ins_value'              =>  trim(dbOutput($_POST['c2_ins_value'])),
          'o_gst'                     =>  trim(dbOutput($_POST['o_gst'])),
          'c1_gst'                    =>  trim(dbOutput($_POST['c1_gst'])),
          'c2_gst'                    =>  trim(dbOutput($_POST['c2_gst'])),
          'o_freight'                 =>  trim(dbOutput($_POST['o_freight'])),
          'c1_freight'                =>  trim(dbOutput($_POST['c1_freight'])),
          'c2_freight'                =>  trim(dbOutput($_POST['c2_freight'])),
          'o_transport_type'          =>  trim(dbOutput($_POST['o_transport_type'])),
          'c1_transport_type'         =>  trim(dbOutput($_POST['c1_transport_type'])),
          'c2_transport_type'         =>  trim(dbOutput($_POST['c2_transport_type'])),
          'o_load'                    =>  trim(dbOutput($_POST['o_load'])),
          'c1_load'                   =>  trim(dbOutput($_POST['c1_load'])),
          'c2_load'                   =>  trim(dbOutput($_POST['c2_load'])),
          'o_total_freight'           =>  trim(dbOutput($_POST['o_total_freight'])),
          'c1_total_freight'          =>  trim(dbOutput($_POST['c1_total_freight'])),
          'c2_total_freight'          =>  trim(dbOutput($_POST['c2_total_freight'])),
          'o_total'                   =>  trim(dbOutput($_POST['o_total'])),
          'c1_total'                  =>  trim(dbOutput($_POST['c1_total'])),
          'c2_total'                  =>  trim(dbOutput($_POST['c2_total'])),
          'remarks'                   =>  trim(dbOutput($_POST['remarks'])),


        );

        $sql = "INSERT INTO comp_price values (
               '".dbInput($dataArray['cp'])."',
               '".dbInput($dataArray['tile_category'])."',
               '".dbInput($dataArray['sku_size'])."',
               '".dbInput($dataArray['o_source'])."',
               '".dbInput($dataArray['c1_source'])."',
               '".dbInput($dataArray['c2_source'])."',
               '".dbInput($dataArray['o_price'])."',
               '".dbInput($dataArray['c1_price'])."',
               '".dbInput($dataArray['c2_price'])."',
               '".dbInput($dataArray['o_discount'])."',
               '".dbInput($dataArray['c1_discount'])."',
               '".dbInput($dataArray['c2_discount'])."',
               '".dbInput($dataArray['o_thickness'])."',
               '".dbInput($dataArray['c1_thickness'])."',
               '".dbInput($dataArray['c2_thickness'])."',
               '".dbInput($dataArray['o_tile'])."',
               '".dbInput($dataArray['c1_tile'])."',
               '".dbInput($dataArray['c2_tile'])."',
               '".dbInput($dataArray['o_weight'])."',
               '".dbInput($dataArray['c1_weight'])."',
               '".dbInput($dataArray['c2_weight'])."',
               '".dbInput($dataArray['o_area'])."',
               '".dbInput($dataArray['c1_area'])."',
               '".dbInput($dataArray['c2_area'])."',
               '".dbInput($dataArray['o_factory_price'])."',
               '".dbInput($dataArray['c1_factory_price'])."',
               '".dbInput($dataArray['c2_factory_price'])."',
               '".dbInput($dataArray['o_ins'])."',
               '".dbInput($dataArray['o_ins_value'])."',
               '".dbInput($dataArray['c1_ins'])."',
               '".dbInput($dataArray['c1_ins_value'])."',
               '".dbInput($dataArray['c2_ins'])."',
               '".dbInput($dataArray['c2_ins_value'])."',
               '".dbInput($dataArray['o_gst'])."',
               '".dbInput($dataArray['c1_gst'])."',
               '".dbInput($dataArray['c2_gst'])."',
               '".dbInput($dataArray['o_freight'])."',
               '".dbInput($dataArray['c1_freight'])."',
               '".dbInput($dataArray['c2_freight'])."',
               '".dbInput($dataArray['o_transport_type'])."',
               '".dbInput($dataArray['c1_transport_type'])."',
               '".dbInput($dataArray['c2_transport_type'])."',
               '".dbInput($dataArray['o_load'])."',
               '".dbInput($dataArray['c1_load'])."',
               '".dbInput($dataArray['c2_load'])."',
               '".dbInput($dataArray['o_total_freight'])."',
               '".dbInput($dataArray['c1_total_freight'])."',
               '".dbInput($dataArray['c2_total_freight'])."',
               '".dbInput($dataArray['o_total'])."',
               '".dbInput($dataArray['c1_total'])."',
               '".dbInput($dataArray['c2_total'])."',
               '".dbInput($dataArray['remarks'])."',
               '".dbInput($file)."',
               '".dbInput($uid)."',
               '".dbInput($timestamp)."'



      )";

              $stmt = odbc_prepare($conn, $sql);
              $result = odbc_execute($stmt);
              move_uploaded_file($_FILES["file"]['tmp_name'], $Target);

              if ($result) {
                $msgTxt = 'Competitor Price Added Successfully';
                $msgType = 1;
              }else{
                $msgTxt = 'Sorry! Unable To Add Competitor Price. Please Try Later.';
                $msgType = 2;
          }

          header('Location:comp_price.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
          exit;
      }
?>


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> -->
<div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Competitor Price</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <li><a href="#portlet_tab2" data-toggle="tab">List Competitor</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Add Competitor Price</a></li>			

                           </ul>

                      <!-- tab 1 asset details start --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <!-- <input type="hidden" name="pid" value="<?php echo $pid?>">  -->
									
                              <table border="0" style="width:100%" align="center">

        <tbody>
            <tr height="27">
               <th colspan="4" align="center" style="background-color:#0099CC; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">
                    &nbsp; Add Product and Competitor Details 
                  </th>
          </tr>
    <tr>
      <h3 class="form-section"></h3>
      <div class="row-fluid">
                                       <div class="span4">
                                        <div class="control-group">
                                          <label class="control-label bold">Channel Partner:</label>
                                             <div class="controls">
                                                <select class="chosen-with-diselect m-wrap span12" name="cp" id="cp" required>
                                                   <option value="">- Select -</option>
                                                   <?php
                                                   echo load_cp();
                                                   ?>
                                                </select>
                                                </div>
                                             </div>
                                       </div>
                                       <div class="span2">
                                       <div class="control-group">
                                             <label class="control-label bold">City:</label>
                                             <div class="controls">
                                                <span class="text" id="cp_city" style="font-weight: bold; color: red;"></span>
                                             </div>
                                          </div>
                                         </div>
                                      
                                       <div class="span3">
                                          <label class="control-label bold">Tile Category:</label>
                                             <div class="controls">
                                                <select class="m-wrap span12" name="tile_category" id="tile_category" class="tile_category" required>
                                                   <option value="">- Select -</option>
                                                   
                                                </select>
                                                
                                             </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label bold">SKU Size:</label>
                                             <div class="controls">
                                                <select class="m-wrap span12" name="sku_size" id="sku_size" required>
                                                   <option value="">- Select -</option>
                                                   
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       
                                       
                                       
                                       
                                    </div>
                                    
    </tr>
        
        
    <tr height="50">
      <th>&nbsp;</th>
      <th>OBL</th>
      <th>Competitor-1</th>  
      <th>Competitor-2</th>
    </tr>


    <tr height="50">
      <th>Source</th>
      <th> 
        <select name="o_source" id="o_source" required>
                  <option>-Select Plant-</option>
              <?php echo load_plant(); ?> 
        </select>
      </th>
      <th> 
        <select name="c1_source" id="c1_source">
                <option value="">-Select-</option>
                <?php echo load_comp(); ?>                                                             
        </select>
      </th>         
      <th>
        <select name="c2_source" id="c2_source">
                <option value="">-Select-</option>
                <?php echo load_comp(); ?>                                                             
        </select>

      </th>
    </tr>
    <tr height="50">
      <th>List Price (Rs/SQMT)</th>
      <th> <input type="number" step=0.01 name="o_price" id="o_price" value="" required="required"></th>
      <th> <input type="number" step=0.01 name="c1_price" id="c1_price" value="" required="required"></th>
      <th> <input type="number" step=0.01 name="c2_price" id="c2_price" value=""></th>
    </tr>
    <tr height="50">
      <th>Discount (Rs/SQMT)</th>
      <th> <input type="number" step=0.01 name="o_discount" id="o_discount" value=""></th>
      <th> <input type="number" step=0.01 name="c1_discount" id="c1_discount" value=""></th>
      <th> <input type="number" step=0.01 name="c2_discount" id="c2_discount" value=""></th>
    </tr>
    <tr height="50">
      <th>Thikness (MM)</th>
      <th> <input type="number" step=0.01 name="o_thickness" id="o_thickness" value=""></th>
      <th> <input type="number" step=0.01 name="c1_thickness" id="c1_thickness" value=""></th>
      <th> <input type="number" step=0.01 name="c2_thickness" id="c2_thickness" value=""></th>
    </tr>
    <tr height="50">
      <th>Tile/Box (Nos/Box)</th>
      <th> <input type="number" step=0.01 name="o_tile" id="o_tile" value=""></th>
      <th> <input type="number" step=0.01 name="c1_tile" id="c1_tile" value=""></th>
      <th> <input type="number" step=0.01 name="c2_tile" id="c2_tile" value=""></th>
    </tr>
    <tr height="50">
      <th>Weight/Box(KGs/Box)</th>
      <th> <input type="number" step=0.01 name="o_weight" id="o_weight" value="" required></th>
      <th> <input type="number" step=0.01 name="c1_weight" id="c1_weight" value=""></th>
      <th> <input type="number" step=0.01 name="c2_weight" id="c2_weight" value=""></th>
    </tr>
    <tr height="50">
      <th>Area/Box (SQMT/Box)</th>
      <th> <input type="number" step=0.01 name="o_area" id="o_area" value="" required></th>
      <th> <input type="number" step=0.01 name="c1_area" id="c1_area" value=""></th>
      <th> <input type="number" step=0.01 name="c2_area" id="c2_area" value=""></th>
    </tr>
    <tr height="50">
      <th>Net Ex-Factory (Rs./SQMT)</th>
      <th> <input type="number" step=0.01 readonly="readonly" name="o_factory_price" id="o_factory_price" value=""></th>
      <th> <input type="number" step=0.01 readonly="readonly" name="c1_factory_price" id="c1_factory_price" value=""></th>
      <th> <input type="number" step=0.01 readonly="readonly" name="c2_factory_price" id="c2_factory_price" value=""></th>
    </tr>
    <tr height="50">
      <th>Insurance(%)</th>
      <th> <input type="number" step=0.01 name="o_ins" id="o_ins" value="" required></th>
      <th> <input type="number" step=0.01 name="c1_ins" id="c1_ins" value=""></th>
      <th> <input type="number" step=0.01 name="c2_ins" id="c2_ins" value=""></th>
    </tr>
    <tr height="50">
      <th>Insurance(Rs)</th>
      <th> <input type="number" step=0.01 readonly="readonly" name="o_ins_value" id="o_ins_value" value=""></th>
      <th> <input type="number" step=0.01 readonly="readonly" name="c1_ins_value" id="c1_ins_value" value=""></th>
      <th> <input type="number" step=0.01 readonly="readonly" name="c2_ins_value" id="c2_ins_value" value=""></th>
    </tr>
    <tr height="50">
      <th>GST @ 18%</th>
      <th> <input type="number" step=0.01 readonly="readonly" name="o_gst" id="o_gst" value=""></th>
      <th> <input type="number" step=0.01 readonly="readonly" name="c1_gst" id="c1_gst" value=""></th>
      <th> <input type="number" step=0.01 readonly="readonly" name="c2_gst" id="c2_gst" value=""></th>
    </tr>
      
      <tr height="50">
         <th>Freight/Ton</th>
         <th> <input type="number" step=0.01 name="o_freight" id="o_freight" value="" required></th>
         <th> <input type="number" step=0.01 name="c1_freight" id="c1_freight" value=""></th>
         <th> <input type="number" step=0.01 name="c2_freight" id="c2_freight" value=""></th>
      </tr>

      <tr height="50">
         <th>Type of Transport</th>
         <th><select name="o_transport_type" id="o_transport_type">
                        <option value="">-Select-</option>
                        <option value="Truck">Truck</option>
                        <option value="Rail">Rail</option>
                        <option value="Sea">Sea</option>                                                                
                </select></th>
         <th><select name="c1_transport_type" id="c1_transport_type">
                        <option value="">-Select-</option>
                        <option value="Truck">Truck</option>
                        <option value="Rail">Rail</option>
                        <option value="Sea">Sea</option>                                                                
                </select></th>
         <th><select name="c2_transport_type" id="c2_transport_type">
                        <option value="">-Select-</option>
                        <option value="Truck">Truck</option>
                        <option value="Rail">Rail</option>
                        <option value="Sea">Sea</option>                                                                
                </select></th>
      </tr>
      <tr height="50">
         <th>Load/Vehicle(Metric Ton)</th>
         <th> <input type="number" step=0.01 name="o_load" id="o_load" value=""></th>
         <th> <input type="number" step=0.01 name="c1_load" id="c1_load" value=""></th>
         <th> <input type="number" step=0.01 name="c2_load" id="c2_load" value=""></th>
      </tr>
      <tr height="50">
         <th>Freight/SQMT(Including GST)</th>
         <th> <input type="number" step=0.01 readonly="readonly" name="o_total_freight" id="o_total_freight" value=""></th>
         <th> <input type="number" step=0.01 readonly="readonly" name="c1_total_freight" id="c1_total_freight" value=""></th>
         <th> <input type="number" step=0.01 readonly="readonly" name="c2_total_freight" id="c2_total_freight" value=""></th>
      </tr>
      <tr height="50">
          <th>CP Landed Price</th>
          <th> <input type="number" step=0.01 readonly="readonly" name="o_total" id="o_total" value=""></th>
          <th> <input type="number" step=0.01 readonly="readonly" name="c1_total" id="c1_total" value=""></th>
          <th> <input type="number" step=0.01 readonly="readonly" name="c2_total" id="c2_total" value=""></th>
      </tr>
      <tr height="100">
        <th>Remarks</th>
        <th colspan="3"><div class="controls" style="margin-left: 0px;padding: 0 70px;">
                                    <textarea class="span12 m-wrap" rows="3" name="remarks"></textarea>
                                 </div></th>
      </tr>
      <tr height="50">
        <th></th>
        <th colspan="2">
                                 <input type="file" name="file" class="default" style="margin-left: -317px;">
                              </th>
      </tr>
      
    
      


</tbody></table><br>             
                                    
                                    
                                    
                                    <div class="form-actions">
                                       <button type="submit" name="submit" class="btn blue" style="margin-left: 200px;"><i class="icon-ok"></i> Save</button>
                                       <a href="list-opportunity.php"><button type="button" class="btn">Cancel</button></a>
                                    </div>
                                 </form>
                                 <!-- tab 1, asset detail ends -->  
                              </div>
                              <div class="tab-pane " id="portlet_tab2">

        
<!--               <div class="portlet-title">
  <h4><i class="icon-cogs"></i>Competitor List</h4>
  <div class="tools">
  </div>
</div> -->
              <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Channel Partner</th>
                      <th>City</th>
                      <th>Tile Category</th>
                      <th>SKU Size</th>
                      <th>OBL Plant</th>
                      <th>OBL List Price</th>
                      <th>Comp1</th>
                      <th>Comp1-Price</th>
                      <th>Comp2</th>
                      <th>Comp2-Price</th>
                      <th>Created By</th>                      
                      <th>Created On</th>
                      <th>File</th>
                                        
                                                                                   
                                            
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $sql="SELECT p.p_name, p.p_city, cp.cp_tile_category, cp.cp_sku_size, pm.plant_name, 
                  cp.o_price, cp.file_path, t.c_name, cp.c1_price, tc.c_name as [c2_name], cp.c2_price, cp.created_on, u.fullname 
                  from comp_price cp 
                  left join channel_partner p on p.p_id = cp.cp_partner_id
                  left join competitor t on t.c_id = cp.c1_source
                  left join plant_master pm on pm.plant_id = cp.o_source
                  left join competitor tc on tc.c_id = cp.c2_source
                  left join user_management u on u.uid = cp.created_by

                  where cp.created_by = '".$_SESSION['uid']."' order by cp.cp_id desc ";
                  $rs=odbc_exec($conn,$sql);
                  $count=1;
                  while($f = odbc_fetch_array($rs)){
                    
                    //print_r($f);
                    echo '<tr>';
                    echo '<td>'.$count.'</td>';
                    echo '<td>'.$f['p_name'].'</td>';
                    echo '<td>'.$f['p_city'].'</td>';
                    echo '<td>'.$f['cp_tile_category'].'</td>';                                
                    echo '<td>'.$f['cp_sku_size'].'</td>';
                    echo '<td>'.$f['plant_name'].'</td>';  
                    echo '<td>'.$f['o_price'].'</td>';
                    echo '<td>'.$f['c_name'].'</td>';
                    echo '<td>'.$f['c1_price'].'</td>';
                    echo '<td>'.$f['c2_name'].'</td>';
                    echo '<td>'.$f['c2_price'].'</td>';
                    echo '<td>'.$f['fullname'].'</td>';
                    echo '<td>'.date('d-m-Y',strtotime(trim($f['created_on']))).'</td>';
                    if(!empty($f['file_path'])){ ?>
                      <td>
                      <a href="<?php echo "assets/img/upload/".$f['file_path']; ?>" target="_blank"><i class="icon-download-alt"></i></a>
                      </td>
                 <?php     
                    }else{
                      echo '<td>-</td>'; 
                    }

           
                    $count++;
                  }
                  ?>

                  </tbody>
                </table>
              </div>
            
                              </div>
                                
                                 <!--#################### purchase details part start tab2 ##############################-->  
                                 <!-- tab 2, purchase detail-->  
                             
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
            </div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>


    <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
      $ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>


<script>
  $(document).ready(function(){
   $("#cp").change(function(){
        var cat_id = $(this).val();
        /*alert(cat_id);*/
        $.ajax({
            url: 'fetch_size.php',
            type: 'post',
            data: {cat_id:cat_id},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                /*alert(len);*/

                $("#tile_category").empty();
                $("#tile_category").append("<option>- Select -</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['pr_product_group'];
                    var name = response[i]['pr_product_group'];
                    
                    $("#tile_category").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
        });
    });




    $("#tile_category").change(function(){
        var tile = $('select#tile_category').children("option:selected").val();
        var cp_id = $('select#cp').children("option:selected").val();
        /*alert(cat_id);*/
        $.ajax({
            url: 'fetch_category.php',
            type: 'post',
            data: {tile:tile, cp_id:cp_id},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                /*alert(len);*/

                $("#sku_size").empty();
                $("#sku_size").append("<option>- Select -</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['pr_sku_size'];
                    var name = response[i]['pr_sku_size'];
                    
                    $("#sku_size").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
        });
    });



    $("#sku_size").change(function(){
        var sk = $('select#sku_size').children("option:selected").val();
        var cp_id = $('select#cp').children("option:selected").val();
        /*alert(cat_id);*/
        $.ajax({
            url: 'fetch_price.php',
            type: 'post',
            data: {sk:sk, cp_id:cp_id},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                /*alert(len);*/

                $("#o_price").empty();
                
                for( var i = 0; i<len; i++){
                    var id = response[i]['pr_price'];
                    var name = response[i]['pr_price'];
                    /*alert(name);*/
                    
                    $("#o_price").val(name);

                }
            }
        });
    });

    $("#cp").change(function(){
        var st = $('select#cp').children("option:selected").val();
        /*var cp_id = $('select#cp').children("option:selected").val();*/
        /*alert(st);*/
        $.ajax({
            url: 'fetch_city.php',
            type: 'post',
            data: {st:st},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                /*alert(len);*/

                $("#cp_city").empty();
                
                for( var i = 0; i<len; i++){
                    var city = response[i]['p_city'];
                    /*var name = response[i]['pr_price'];*/
                    /*alert(name);*/
                    
                    $("#cp_city").text(city);

                }
            }
        });
    });

    

     
  });
    
</script>
<script>
  $(document).ready(function(){
    function f_price(){
      var o_price = $('#o_price').val();
      var o_discount = $('#o_discount').val();
      var total_factory = (o_price-o_discount);
    $('#o_factory_price').val(total_factory);
    }
    $('#o_discount, #o_price').change(f_price);
    
  });
</script>
<script>
  $(document).ready(function(){
    function freight_total(){
    
      var o_weight = $('#o_weight').val();
      var o_area = $('#o_area').val();
      var o_freight = $('#o_freight').val();
      var total_freight = (o_freight/1000)*(o_weight/o_area).toFixed(2);
    $('#o_total_freight').val(total_freight);
    }
    $('#o_freight, #o_weight, #o_area').change(freight_total);
    
  });
</script>
<script>
  $(document).ready(function(){
    function ins_value(){
    
      var o_factory_price = $('#o_factory_price').val();
      var o_ins = $('#o_ins').val();
      var o_price = $('#o_price').val();
      var o_discount = $('#o_discount').val();
      var total_ins = (o_factory_price*o_ins/100).toFixed(2);
    $('#o_ins_value').val(total_ins);
    }
    $('#o_factory_price, #o_ins, #o_price, #o_discount').change(ins_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function gst_value(){
    
      var o_factory_price = $('#o_factory_price').val();
      var o_gst = $('#o_gst').val();
      var o_price = $('#o_price').val();
      var o_ins_value = $('#o_ins_value').val();
      var o_discount = $('#o_discount').val();
      var total_gst = ((parseFloat(o_factory_price)+parseFloat(o_ins_value))*(.18)).toFixed(2);
    $('#o_gst').val(total_gst);
    }
    $('#o_factory_price, #o_gst, #o_price, #o_discount, #o_ins, #o_ins_value').change(gst_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function cp_price(){
      var o_factory_price = $('#o_factory_price').val();
      var o_gst = $('select#o_gst').children("option:selected").val();
      /*var o_ins = $('select#o_ins').children("option:selected").val();*/
      var o_total_freight = $('#o_total_freight').val();
      var o_freight = $('#o_freight').val();
      var o_discount = $('#o_discount').val();
      var o_ins_value = $('#o_ins_value').val();
      var o_gst = $('#o_gst').val();
      var cp = (parseFloat(o_factory_price)+parseFloat(o_ins_value)+parseFloat(o_gst)+parseFloat(o_total_freight)).toFixed(2);
      $('#o_total').val(cp);
    }
      $('#o_factory_price, #o_gst, #o_ins, #o_total_freight, #o_freight, #o_discount,#o_area,#o_weight').change(cp_price);
    
  });
</script>

<script>
   $(document).ready(function(){
      
     $('#sku_size').change(function(){
         
         /*var category = $(this).val();*/
         var sku = $('select#sku_size').children("option:selected").val();
         /*alert(sku);*/ 
         $.ajax({
            url: "fetch_size.php",
            method:"POST",
            data:{sk:sku},
            dataType:"text",
            success:function(data){
            $('#o_price').text(data);
            }
         });
      });
   });
</script>

<!-- Competitor-1 script -->

<script>
  $(document).ready(function(){
    function c_price(){
      var c1_price = $('#c1_price').val();
      var c1_discount = $('#c1_discount').val();
      var c1_total_factory = (c1_price-c1_discount);
    $('#c1_factory_price').val(c1_total_factory);
    }
    $('#c1_discount, #c1_price').change(c_price);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c1_freight_total(){
    
      var c1_weight = $('#c1_weight').val();
      var c1_area = $('#c1_area').val();
      var c1_freight = $('#c1_freight').val();
      var total_freight = (c1_freight/1000)*(c1_weight/c1_area).toFixed(2);
    $('#c1_total_freight').val(total_freight);
    }
    $('#c1_freight, #c1_weight, #c1_area').change(c1_freight_total);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c1_ins_value(){
    
      var c1_factory_price = $('#c1_factory_price').val();
      var c1_ins = $('#c1_ins').val();
      var c1_price = $('#c1_price').val();
      var c1_discount = $('#c1_discount').val();
      var total_ins = (c1_factory_price*c1_ins/100).toFixed(2);
    $('#c1_ins_value').val(total_ins);
    }
    $('#c1_factory_price, #c1_ins, #c1_price, #c1_discount').change(c1_ins_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c1_gst_value(){
    
      var c1_factory_price = $('#c1_factory_price').val();
      var c1_gst = $('#c1_gst').val();
      var c1_price = $('#c1_price').val();
      var c1_discount = $('#c1_discount').val();
      var c1_ins_value = $('#c1_ins_value').val(); 
      var total_gst = ((parseFloat(c1_factory_price)+parseFloat(c1_ins_value))*(.18)).toFixed(2);
    $('#c1_gst').val(total_gst);
    }
    $('#c1_factory_price, #c1_gst, #c1_price, #c1_discount, #c1_ins, #c1_ins_value').change(c1_gst_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c1_cp_price(){
      var c1_factory_price = $('#c1_factory_price').val();
      var c1_gst = $('select#c1_gst').children("option:selected").val();
      /*var c1_ins = $('select#c1_ins').children("option:selected").val();*/
      var c1_total_freight = $('#c1_total_freight').val();
      var c1_freight = $('#c1_freight').val();
      var c1_discount = $('#c1_discount').val();
      var c1_ins_value = $('#c1_ins_value').val();
      var c1_gst = $('#c1_gst').val();
      var cp = (parseFloat(c1_factory_price)+parseFloat(c1_ins_value)+parseFloat(c1_gst)+parseFloat(c1_total_freight)).toFixed(2);
      $('#c1_total').val(cp);
    }
      $('#c1_factory_price, #c1_gst, #c1_ins, #c1_total_freight, #c1_freight, #c1_discount,#c1_area,#c1_weight').change(c1_cp_price);
    
  });
</script>

<!-- Competitor-2 script -->

<script>
  $(document).ready(function(){
    function d_price(){
      var c2_price = $('#c2_price').val();
      var c2_discount = $('#c2_discount').val();
      var c2_total_factory = (c2_price-c2_discount);
    $('#c2_factory_price').val(c2_total_factory);
    }
    $('#c2_discount, #c2_price').change(d_price);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c2_freight_total(){
    
      var c2_weight = $('#c2_weight').val();
      var c2_area = $('#c2_area').val();
      var c2_freight = $('#c2_freight').val();
      var total_freight = (c2_freight/1000)*(c2_weight/c2_area).toFixed(2);
    $('#c2_total_freight').val(total_freight);
    }
    $('#c2_freight, #c2_weight, #c2_area').change(c2_freight_total);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c2_ins_value(){
    
      var c2_factory_price = $('#c2_factory_price').val();
      var c2_ins = $('#c2_ins').val();
      var c2_price = $('#c2_price').val();
      var c2_discount = $('#c2_discount').val();
      var total_ins = (c2_factory_price*c2_ins/100).toFixed(2);
    $('#c2_ins_value').val(total_ins);
    }
    $('#c2_factory_price, #c2_ins, #c2_price, #c2_discount').change(c2_ins_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c2_gst_value(){
    
      var c2_factory_price = $('#c2_factory_price').val();
      var c2_gst = $('#c2_gst').val();
      var c2_price = $('#c2_price').val();
      var c2_discount = $('#c2_discount').val();
      var c2_ins_value = $('#c2_ins_value').val();
      var total_gst = ((parseFloat(c2_factory_price)+parseFloat(c2_ins_value))*(.18)).toFixed(2);
    $('#c2_gst').val(total_gst);
    }
    $('#c2_factory_price, #c2_gst, #c2_price, #c2_discount, #c2_ins, #c2_ins_value').change(c2_gst_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c2_cp_price(){
      var c2_factory_price = $('#c2_factory_price').val();
      var c2_gst = $('select#c2_gst').children("option:selected").val();
      /*var c2_ins = $('select#c2_ins').children("option:selected").val();*/
      var c2_total_freight = $('#c2_total_freight').val();
      var c2_freight = $('#c2_freight').val();
      var c2_discount = $('#c2_discount').val();
      var c2_ins_value = $('#c2_ins_value').val();
      var c2_gst = $('#c2_gst').val();
      var cp = (parseFloat(c2_factory_price)+parseFloat(c2_ins_value)+parseFloat(c2_gst)+parseFloat(c2_total_freight)).toFixed(2);
      $('#c2_total').val(cp);
    }
      $('#c2_factory_price, #c2_gst, #c2_ins, #c2_total_freight, #c2_freight, #c2_discount,#c2_area,#c2_weight').change(c2_cp_price);
    
  });
</script>

  <!-- Competitor-2 script -->

   <?php include_once('including/footer.php')?>
    <?php 

      if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
      $ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>

