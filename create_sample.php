<?php 
$npd='active';
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp1=date('YmdHis');
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];
$department = $_SESSION['employee_department']; 

if(isset($_GET['pid']) && $_GET['pid']>0){
 
  $doc_sql = "SELECT * from get_doc_new where get_id ='".dbInput($pid)."' ";
  $rs=odbc_exec($conn,$doc_sql);
  $f = odbc_fetch_array($rs);

  $dataArray=array(
    'get_id'    => trim(dbOutput($f['get_id'])),
    'get_name'    => trim(dbOutput($f['get_name'])),
    'get_desc'    => trim(dbOutput($f['get_desc'])),
    'get_category'    => trim(dbOutput($f['get_category'])),
    'get_sub_category'    => trim(dbOutput($f['get_sub_category'])),
    'get_dept'    => trim(dbOutput($f['get_dept'])),
    'get_city'    => trim(dbOutput($f['get_city'])),
    'get_cat'    => trim(dbOutput($f['get_cat'])),
    'creation_remark'    => trim(dbOutput($f['creation_remark'])),
    'approval_remark'    => trim(dbOutput($f['approval_remark'])),
    'created_by'    => trim(dbOutput($f['created_by'])),
    'approval_remark'=> trim(dbOutput($f['approval_remark'])),
    'get_status'    => trim(dbOutput($f['get_status']))
  );

}

?>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box green">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480"><?php echo $formType?></span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">

                      <!-- ADD user START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">

          

                            <form method="post" action="upload_doc.php" class="form-horizontal" enctype="multipart/form-data">
                                  <!-- <input type="hidden" name="pid" value="<?php echo $pid?>">  -->
                                    <h3 class="form-section">Create NPD Sample Request</h3>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">PMT Lead ID:</label>
                                             <div class="controls">
                                                  <select class="span12 chosen" name="opp_id" id="opp_id" tabindex="1" required>

                                      <option value="">- Select Lead -</option>
                                     
                                       <?php
                                        $sql="SELECT opportunity_id, lead_id, project_name, created_by, added_date from opportunity";

                                          if(trim($_SESSION['user_type'])=='management') {
                                            $sql.="  where 1=1 and npd_status is NULL  ";
                                          }else{

                                              if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
                                                  
                                                  if($_SESSION['user_type']=='manager'){
                                                  $sql.=" where 1=1 
                                                    and npd_status is NULL and ( ";

                                                    $ex=explode(",",$_SESSION['my_team_id']);
                                                      $xcnt=0;
                                                    foreach ($ex as $vx){
                                                    //echo $vx;
                                                      if($xcnt==0)
                                                        $sql.=" created_by = '".$vx."' or created_by='".$_SESSION['uid']."' or o.support_asked = '".$_SESSION['uid']."' ";
                                                      else
                                                        $sql.=" or created_by = '".$vx."' or support_asked = '".$vx."' ";
                                                      $xcnt++;
                                                    }
                                                    $sql.=" ) ";
                                                  }else{
                                                    $sql.=" where npd_status is NULL and created_by='".$_SESSION['uid']."' 
                                                     "; 
                                                  }

                                              }
                                            
                                          }

                                        $rs=odbc_exec($conn,$sql);
                                        while($f = odbc_fetch_array($rs)){
                                        /*$selected=($f['cka_name_id']==$dataArray['cka_name_id'])?'selected':'';*/
                                        echo '<option value="'.$f['opportunity_id'].'">'.$f['lead_id'].' - '.(strlen($f['project_name']) > 50 ? substr($f['project_name'],0,50)."..." : $f['project_name']).'</option>';
                                        }
                                        ?>
                                         </select>
                                       
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Account Domain:</label>
                                             <div class="controls">
                                                <span id="account_domain" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Account Name:</label>
                                             <div class="controls">
                                                <span id="account_name" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">City:</label>
                                             <div class="controls">
                                                <span id="city" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>       
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Tiling Date:</label>
                                             <div class="controls">
                                                <span id="tiling_date" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Tile Potential (SQMT):</label>
                                             <div class="controls">
                                                <span id="tile_potential" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Department:</label>
                                             <div class="controls">
                                                <span id="user_department" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Created On:</label>
                                             <div class="controls">
                                                <span id="added_date" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>


                                    



                                    <div class="row-fluid">
                                       <div class="span6 ">
                                      <div class="control-group">
                                         <label class="control-label">Document (If Any):</label>
                                         <div class="controls">
                                         <input type="file" name="newDoc" id="newDoc">
                                         </div>
                                      </div>
                                       </div>
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Short Remark:</label>
                                             <div class="controls">
                                                <input class="span10" name="short_remark" id="short_remark" type="text" placeholder="Short Remark" required="required">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                            <label class="control-label"></label>
                                            <div class="controls">
                                             <div id="error_msg"></div>
                                            </div>
                                             
                                             
                                          </div>
                                       </div>
                                      
                                    </div> 
                                    <!-- <br> -->
                                    



                                    
                                    <!-- Adding Sampling details -->


                                    <h3 class="form-section">Add NPD Product Details</h3>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          
                             
<!-- <form action="<?php echo $_SERVER['PHP_SELF']?>" id="cform" method="post" class="form-horizontal"> -->
 <!-- <input type="hidden" value="<?php echo $_GET['pid']?>" name="opportunity_id"  id="opportunity_id"/> -->
  <table border="0" style="width:100%" align="center">
  <tr>
    <th></th>
  </tr>
  <tr>
    <th><select name="plant_name" id="plant_name" style="width:90px; height: 30px;"> 
      <option value="">-Plant-</option>
      <option value="SKD">SKD</option>
      <option value="DORA">DORA</option>';
      <option value="HSK">HSK</option>
      <option value="MORBI">Morbi</option>
      </select>
    </th> 
    <th>
      <select name="sku_size" style="width:120px; height: 30px;"  id="sku_size">
        <option value="">- SKU Size -</option>
           <?php
        $ssql="select distinct(size_code_desc) size_id, size_code_desc from size_master order by size_code_desc ";  
        $rs=odbc_exec($conn,$ssql);
        while($f = odbc_fetch_array($rs)){
        /*$ss=($f['size_id']==$dataArray['spare_part_id'])?'selected':'';*/
        echo '<option value="'.$f['size_code_desc'].'" '.$ss.'>'.trim($f['size_code_desc']).' </option>';
        }
        ?>
        </select>
    </th>              
    <th><select name="tile_category" id="tile_category" style="width:120px; height: 30px;" > 
      <option value="">-Category-</option>
      <option value="Ceramic">Ceramic</option>
      <option value="DC">DC</option>';
      <option value="DGVT">DGVT</option>
      <option value="LAP">LAP</option>
      <option value="Nano">Nano</option>
      <option value="Pavers">Pavers</option>
      <option value="PDC">PDC</option>
      <option value="PGVT">PGVT</option>
      <option value="PVT">PVT</option>
      </select>
    </th>
    <th><select name="punch_type" id="punch_type" style="width:120px; height: 30px;" > 
      <option value="">-Punch Type-</option>
      <option value="Plain">Plain</option>
      <option value="Embossed">Embossed</option>
      
      </select>
    </th>        
    <th><input type="text" style="width:90%; height: 20px; resize:none;" name="npd_tile_name" id="npd_tile_name" placeholder="NPD Tile Name"></th>
    <th><input type="text" style="width:90%; height: 20px; resize:none;" name="ref_tile_name" id="ref_tile_name" placeholder="Reference Tile"></th>
    <!-- <th><input type="text" style="width:90%; height: 20px; resize:none;" name="desc" id="desc" placeholder="Description"></th>  -->   
    <th><input type="number" style="width:90px; height: 20px; resize:none;" name="qty" id="qty" placeholder="Qty(SQMT)"></th>  
    <th><input type="number" style="width:80px; height: 20px; resize:none;" name="thickness" id="thickness" placeholder="Thickness"></th>
    
    <th><input type="number" style="width:90px; height: 20px; resize:none;" name="expected_price" id="expected_price" placeholder="Price/SQMT"></th>  
    <th><input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="expected_date"  id="expected_date" style="width:80%; height: 18px;" placeholder="Expected Date" /></th>    
    <td><input type="button" class="btn yellow no-print" value="add" id="add_npd" /></td>
  </tr>
  </table>
<!-- </form> -->

<table border="0" style="width:100%" align="center">
<td colspan="4" height="20"></td>
</tr>

    <tr height="1">
      <th colspan="5"  align="center" style="background-color:gray; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">
              <!-- Visit Details List -->
            </th>
    </tr>
</table>

<table style="width:100%" align="center">

<tr>
  <td>
          <div id="npd_tile"></div> 
    </td>
</tr>

</table>
<!-- </form> -->
                                       </div>
                                    </div>
                               <!--/row-->


                                  

                          
                                <br>
                                <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                    <div class="form-actions">
                                      <img src="assets/img/loader_01.gif" alt="loader1" style="display:none; height:30px; width:auto; " id="loaderImg" class="loaderImg">
                                      <input type="submit" class="btn blue" name="create" id="create" value="Submit">
                                      <a href="list_npd_sample.php"><button type="button" class="btn">Cancel</button></a> 
                                    </div>
                                    </div>
                                 </div>
                                       
                                    </div>

                          
                           

                                 </form>
                                 <!-- ADD user ENDS -->  
                              </div>
                                 <!-- LIST user START -->  
                              
                              </div>
                                 <!-- LIST user ENDS -->  
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
   <!-- END CONTAINER -->
   <?php include_once('including/footer.php')?>
   <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
      $ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>

   

     

<script>
     $(document).ready(function(){
      $("#opp_id").change(function(){
        var id = $('select#opp_id').children("option:selected").val();
        /*alert(cka);*/

        if(id != '')
        {
        
          $.ajax({
               url: 'npd_list.php',
               type: 'post',
               data: {id:id},
               dataType: 'json',
               success:function(data){
                 $('#account_domain').text(data.deal_sub_type);
                 $('#city').text(data.city);
                 $('#account_name').text(data.cka_name);
                 $('#tiling_date').text(data.tile_stage_date);
                 $('#user_department').text(data.employee_department);
                 $('#tile_potential').text(data.project_tile_potential_sqm);
                 $('#added_date').text(data.added_date);
                 
               }
            });
        }else
        {
          /*alert("Please Select Account");*/
          location.reload();
        }
        
      });


      $("#add_npd").click(function(){
        var opp_id = $('select#opp_id').children("option:selected").val();
        var plant_name = $('#plant_name').val();
        var sku_size = $('#sku_size').val();
        var tile_category = $('#tile_category').val();
        var punch_type = $('#punch_type').val();
        var npd_tile_name = $('#npd_tile_name').val();
        var ref_tile_name = $('#ref_tile_name').val();
        var qty = $('#qty').val();
        var thickness = $('#thickness').val();
        var expected_price = $('#expected_price').val();
        var expected_date = $('#expected_date').val();
        


        if(opp_id != '' && plant_name  != '' && sku_size  != '' && tile_category != '' && punch_type != '' && npd_tile_name != '' && ref_tile_name != '' && qty != '' && thickness != '' && expected_date != '' && expected_price != '')
        {
          /*$("#add_arch").prop('disabled', false);*/
          $.ajax({
               url: 'npd_data.php',
               type: 'post',
               data: {opp_id:opp_id, plant_name:plant_name, sku_size:sku_size, tile_category:tile_category, punch_type:punch_type, npd_tile_name:npd_tile_name, ref_tile_name:ref_tile_name, qty:qty, thickness:thickness, expected_date:expected_date, expected_price:expected_price},
               dataType: 'text',
               success:function(data){
                 /*alert("Account details updated successfully");*/
                 
                 $("#npd_tile").html(data);
                 $("#plant_name").val('');
                 $("#sku_size").val('');
                 $("#tile_category").val('');
                 $("#punch_type").val('');
                 $("#npd_tile_name").val('');
                 $("#ref_tile_name").val('');
                 $("#qty").val('');
                 $("#thickness").val('');
                 $("#expected_price").val('');
                 $("#expected_date").val('');

                 /*location.reload();*/
               }
            });
        }else
        {
          alert("All Fields are Mandatory");
          return false;
        }
        
    
      });



     });
   </script>

   <script>
     $(document).ready(function(){
      $("#opp_id").change(function(){
        var opp_id = $('select#opp_id').children("option:selected").val();
        /*alert(cka);*/

        if(opp_id != '')
        {
          $.ajax({
               url: 'npd_data.php',
               type: 'post',
               data: {opp_id:opp_id},
               dataType: 'text',
               success:function(data){
                /*alert(data);*/
                $("#npd_tile").html(data);                
               }
            });
        }else
        {
          alert("Please Select Lead");
        }
        
      }); 
     });
   </script>

   <script type="text/javascript">
  $(document).ready(function(){
    $('#create').click(function(event){
      /*event.preventDefault();*/
      var filename = $('#newDoc').val();
      var opp_id = $('select#opp_id').children("option:selected").val();
    
      if(filename == ''){
        $("#error_msg").html("<span class='label label-important'>NOTE!</span><span> Please Select Document to Upload.</span>").fadeIn();
          return false;
      }
      var extension = $('#newDoc').val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['pdf', 'doc']) == -1){
          $("#error_msg").html("<span class='label label-important'>NOTE!</span><span> Only PDF Document is allowed to upload.</span>").fadeIn();
          $('#newDoc').val('');
          return false;
        }

        if(opp_id != '')
        {
          $.ajax({
               url: 'npd_data.php',
               type: 'post',
               data: {opp_id:opp_id},
               dataType: 'text',
               success:function(data){
                /*alert(data);*/
                if(data === ''){
                  $("#error_msg").html("<span class='label label-important'>NOTE!</span><span> Please Add NPD Sample Product.</span>").fadeIn();
                  return false;
                }               
               }
            });
        }else
        {
          alert("Please Select Lead");
        }

    });
  });
</script>