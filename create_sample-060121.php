<?php 
$cd='active';
$cda='active';
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

          <?php 
          if(isset($_REQUEST['pid']) && $_REQUEST['pid']>0){
          ?>

                                 <form action="upload_doc.php" method="post" class="form-horizontal" id="updateData" enctype="multipart/form-data">
                                  <input type="hidden" name="pid" id="pid" value="<?php echo $pid?>">
                                  <input type="hidden" name="get_current_category" id="get_current_category" value="<?php echo $dataArray['get_category']?>"> 
                                    <h3 class="form-section">Document Details</h3>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Document Category:</label>
                                             <div class="controls">
                                                <select class="medium m-wrap" name="u_get_category" id="u_get_category" tabindex="1" >

                                      <option value="">- Category -</option>
                                     
                                       <?php
                                        $sql="SELECT distinct category_name from get_category order by category_name asc";
                                        $rs=odbc_exec($conn,$sql);
                                        while($f = odbc_fetch_array($rs)){
                                        $selected=($f['category_name']==$dataArray['get_category'])?'selected':'';
                                        echo '<option value="'.$f['category_name'].'" '.$selected.'>'.$f['category_name'].'</option>';
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
                                                <span id="account_domain" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">City:</label>
                                             <div class="controls">
                                                <select class="chosen span6 m-wrap" name="u_get_city" id="u_get_city" tabindex="1" >
                                                <option value="">- City -</option>
                                                <?php
                                                $city_sql="SELECT id, city, territory from city_master where status = 1 order by city asc";
                                                $city_rs=odbc_exec($conn,$city_sql);
                                                while($c = odbc_fetch_array($city_rs)){
                                                $selected=($c['city']==$dataArray['get_city'])?'selected':'';
                                                echo '<option value="'.$c['city'].'" '.$selected.'>'.$c['city'].' ('.$c['territory'].')</option>';
                                                }
                                                ?>
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>       
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Document Name:</label>
                                             <div class="controls">
                                                <input type="text" name="u_get_doc_name" id="u_get_doc_name" class="span7 m-wrap" value="<?php echo $dataArray['get_name']?>">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Description:</label>
                                             <div class="controls">
                                                <input type="text" name="u_get_doc_desc" id="u_get_doc_desc" class="span7 m-wrap" value="<?php echo $dataArray['get_desc']?>">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Category:</label>
                                             <div class="controls">
                                                <select class="m-wrap span3" name="u_get_cat" id="u_get_cat" tabindex="1" >
                                                <!-- <option value="">- Select -</option> -->
                                                <option value="A" <?php echo ($dataArray['get_cat'])=='A' ? 'selected' : '' ?>>A</option>
                                                <option value="B" <?php echo ($dataArray['get_cat'])=='B' ? 'selected' : '' ?>>B</option>
                                                <option value="C" <?php echo ($dataArray['get_cat'])=='C' ? 'selected' : '' ?>>C</option>
                                                
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->

                                       <?php 
                                        if($_SESSION['uid'] == '2015' || $_SESSION['user_type'] == 'management'){

                                          if($dataArray['get_status'] == 0){

                                         echo '<div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Approval Remark:</label>
                                             <div class="controls">
                                                <input type="text" name="u_approval_remark" id="u_approval_remark" class="span9 m-wrap" value="'.$dataArray['approval_remark'].'">
                                             </div>
                                          </div>
                                       </div>';

                                      }else {
                                        echo '<div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Short Remark:</label>
                                             <div class="controls">
                                                <input type="text" name="u_creation_remark" id="u_creation_remark" class="span9 m-wrap" value="'.$dataArray['creation_remark'].'">
                                             </div>
                                          </div>
                                       </div>';
                                      }

                                    }else {

                                      echo '<div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Short Remark:</label>
                                             <div class="controls">
                                                <input type="text" name="u_creation_remark" id="u_creation_remark" class="span9 m-wrap" value="'.$dataArray['creation_remark'].'">
                                             </div>
                                          </div>
                                       </div>';
                                       
                                    }

                                    ?>


                                       <!-- <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Short Remark:</label>
                                             <div class="controls">
                                                <input type="text" name="u_creation_remark" id="u_creation_remark" class="span9 m-wrap" value="<?php echo $dataArray['creation_remark']?>">
                                             </div>
                                          </div>
                                       </div> -->
                                       <!--/span-->
                                    </div>









                                    <?php 
          
                                    $sql_file = "SELECT get_pdf from get_doc_new where get_id='".dbInput($pid)."'";
                                    $sql_result = odbc_exec($conn, $sql_file);
                                    while($fl = odbc_fetch_array($sql_result)){
                                      $new_file = $fl['get_pdf'];
                                    }
                                    ?>

                                    <div class="row-fluid">
                                       <div class="span12 ">
                                      <div class="control-group">
                                         <label class="control-label">PDF Document:</label>
                                         <div class="controls">
                                         <a href="<?php echo 'assets/get_doc/'.$dataArray['get_category'].'/'.$new_file; ?>" target="_blank"><img src="assets/img/pdf2.png" alt="" style="max-width: 30px"></a> 
                                         <input type="file" name="newFile" id="newFile">
                                         <input type="hidden", name="img_url" id="img_url" value="<?php echo $new_file; ?>">
                                         </div>
                                      </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                            <label class="control-label"></label>
                                            <div class="controls">
                                             <div id="err_msg"></div>
                                            </div>
                                             
                                             
                                          </div>
                                       </div>
                                      
                                    </div> 

                              <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                    <div class="form-actions">
                                      <?php 
                                        if($_SESSION['uid'] == '2015' || $_SESSION['user_type'] == 'management'){

                                          if($dataArray['get_status'] == 2){
                                             echo '<button type="submit" id="update" name="update" class="btn green"> Update</button> '; 
                                             echo '<a href="list-doc.php"><button type="button" class="btn">Cancel</button></a>';
                                          }else {
                                            echo '<button type="submit" id="approve" name="approve" class="btn green"> Approve</button> 
                                       <button type="submit" id="reject" name="reject" class="btn red">Reject</button>';
                                          }
                                          
                                        }else {
                                          echo '<button type="submit" id="update" name="update" class="btn green"> Update</button> '; 
                                          echo '<a href="list-doc.php"><button type="button" class="btn">Cancel</button></a>';
                                        }

                                       ?>

                                    </div>
                                    </div>
                                 </div>
                                       
                                    </div>
                                    <!--/row--> 

                                  </form>

                    <?php }else{ ?>

                            <form action="upload_doc.php" method="post" class="form-horizontal" id="addData" name="addData" enctype="multipart/form-data">
                                  <!-- <input type="hidden" name="pid" value="<?php echo $pid?>">  -->
                                    <h3 class="form-section">Create NPD Sample Request</h3>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">PMT Lead ID:</label>
                                             <div class="controls">
                                                  <select class="span12 chosen" name="get_category" id="get_category" tabindex="1" required>

                                      <option value="">- Select Lead -</option>
                                     
                                       <?php
                                        $sql="SELECT opportunity_id, lead_id, project_name, created_by, added_date from opportunity";

                                          if(trim($_SESSION['user_type'])=='management') {
                                            $sql.="  where 1=1  ";
                                          }else{

                                              if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
                                                  
                                                  if($_SESSION['user_type']=='manager'){
                                                  $sql.=" where 1=1 
                                                    and ( ";

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
                                                    $sql.=" where created_by='".$_SESSION['uid']."' 
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
                                                <span id="account_domain" class="text">Architects & Design</span>
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
                                                <span id="account_name" class="text">Cambridge Montessori</span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">City:</label>
                                             <div class="controls">
                                                <span id="account_domain" class="text">New Delhi</span>
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
                                                <span id="account_domain" class="text">25/12/2020</span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Tile Potential (SQMT):</label>
                                             <div class="controls">
                                                <span id="account_domain" class="text">2500</span>
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
                                                <span id="account_domain" class="text">SET</span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Created On:</label>
                                             <div class="controls">
                                                <span id="account_domain" class="text">10/06/2020</span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>

                                    <div class="row-fluid">
                                       <div class="span12 ">
                                      <div class="control-group">
                                         <label class="control-label">Document (If Any):</label>
                                         <div class="controls">
                                         <input type="file" name="newDoc" id="newDoc" required>
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
                                    <h3 class="form-section">Production Team</h3>

                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Expected Delivery Date:</label>
                                             <div class="controls">
                                                <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="arch_visit_date"  id="arch_visit_date" style="height: 17px;" />
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Tile Matching Status:</label>
                                             <div class="controls">
                                                <input type="text" name="arch_visit_remarks" id="arch_visit_remarks" placeholder="">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Sales Team Feedback:</label>
                                             <div class="controls">
                                                <input type="text" name="arch_visit_remarks" id="arch_visit_remarks" placeholder="">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">PO Status:</label>
                                             <div class="controls">
                                                <select name="tile_category" id="tile_category" style="width:100px; height: 30px;" required="required"> 
                                                  <option value="">-Status-</option>
                                                  <option value="pending">Pending</option>
                                                  <option value="created">Created</option>';
                                                  <option value="dispatched">Dispatched</option>
                                                  <option value="closed">Closed</option>
                                                  </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div> 



                                    <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                    <div class="form-actions">
                                      <img src="assets/img/loader_01.gif" alt="loader1" style="display:none; height:30px; width:auto; " id="loaderImg" class="loaderImg">
                                      <input type="submit" class="btn blue" name="create" id="create" value="Create">
                                      <a href="list-doc.php"><button type="button" class="btn">Cancel</button></a> 
                                    </div>
                                    </div>
                                 </div>
                                       
                                    </div>
                                    <!-- Adding Sampling details -->


                                    <h3 class="form-section">NPD Product Details</h3>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          
                             
<form action="<?php echo $_SERVER['PHP_SELF']?>" id="cform" method="post" class="form-horizontal">
 <!-- <input type="hidden" value="<?php echo $_GET['pid']?>" name="opportunity_id"  id="opportunity_id"/> -->
  <table border="0" style="width:100%" align="center">
  <tr>
    <th></th>
  </tr>
  <tr>
    <th><select name="tile_category" id="tile_category" style="width:100px; height: 30px;" required="required"> 
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
    <th><select name="tile_category" id="tile_category" style="width:120px; height: 30px;" required="required"> 
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
    <th><input type="text" style="width:90%; height: 20px; resize:none;" name="tile_name" id="tile_name" placeholder="NPD Tile Name"></th>
    <th><input type="text" style="width:90%; height: 20px; resize:none;" name="tile_name" id="tile_name" placeholder="Reference Tile"></th>
    <!-- <th><input type="text" style="width:90%; height: 20px; resize:none;" name="desc" id="desc" placeholder="Description"></th>  -->   
    <th><input type="number" style="width:50px; height: 20px; resize:none;" name="qty" id="qty" placeholder="Qty"></th>  
    <th><input type="number" style="width:80px; height: 20px; resize:none;" name="size_mm" id="size_mm" placeholder="Size(MM)"></th>
    <th><input type="number" style="width:80px; height: 20px; resize:none;" name="thickness" id="thickness" placeholder="Thickness"></th> 
    <th><input type="number" style="width:90px; height: 20px; resize:none;" name="ex_price" id="ex_price" placeholder="Price/SQMT"></th>  
    <th><input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="sampling_date"  id="sampling_date" style="width:90%; height: 18px;" placeholder="Expected Date" /></th>    
    <td><input type="button" class="btn yellow no-print" value="add" id="add_arch" /></td>
  </tr>
  </table>
</form>

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
          <div id="cka_visit"></div> 
    </td>
</tr>

</table>
<!-- </form> -->
                                       </div>
                                    </div>




                              
                                    <!--/row-->


                                  </form>

                          <?php } ?>

                          
                           

                                 <!-- </form> -->
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
      $("#get_category").change(function(){
        var get_category = $('select#get_category').children("option:selected").val();
        if(get_category != '')
        {
          $.ajax({
               url: 'fetch_doc.php',
               type: 'post',
               data: {get_category:get_category},
               dataType: 'json',
               success:function(data){
                var len = data.length;
                $("#get_sub_category").empty();
                 $("#get_sub_category").append("<option>- Sub Category -</option>");
                 for(var i= 0; i<len; i++){
                  var category_sub_id = data[i]['category_sub_id'];
                  var category_sub_name = data[i]['category_sub_name'];
                  $("#get_sub_category").append("<option value='"+category_sub_name+"'>"+category_sub_name+"</option>");
                 }
                 
                 
               }
            });
        }else
        {
          $("#get_sub_category").empty();
          $("#get_sub_category").append("<option>- Sub Category -</option>");
          $("#get_dept").empty();
          $("#get_dept").append("<option>- Department -</option>");

          /*return false;*/
        }
        
      });

      

      $("#get_category").change(function(){
        var get_department = $('select#get_category').children("option:selected").val();
        if(get_department != '')
        {
          $.ajax({
               url: 'fetch_doc.php',
               type: 'post',
               data: {get_department:get_department},
               dataType: 'json',
               success:function(data){
                var len = data.length;
                $("#get_dept").empty();
                 $("#get_dept").append("<option>- Department -</option>");
                 for(var i= 0; i<len; i++){
                  var dpt_id = data[i]['dpt_id'];
                  var get_department = data[i]['get_department'];
                  $("#get_dept").append("<option value='"+get_department+"'>"+get_department+"</option>");
                 }
                 
                 
               }
            });
        }else
        {
          $("#sub_category").empty();
          $("#sub_category").append("<option>- Sub Category -</option>");
          $("#get_dept").empty();
          $("#get_dept").append("<option>- Department -</option>");
        }
        
      });


      /*update functionality for drop down*/

      $("#u_get_category").change(function(){
        var get_category = $('select#u_get_category').children("option:selected").val();
        if(get_category != '')
        {
          $.ajax({
               url: 'fetch_doc.php',
               type: 'post',
               data: {get_category:get_category},
               dataType: 'json',
               success:function(data){
                var len = data.length;
                $("#u_get_sub_category").empty();
                 $("#u_get_sub_category").append("<option>- Sub Category -</option>");
                 for(var i= 0; i<len; i++){
                  var category_sub_id = data[i]['category_sub_id'];
                  var category_sub_name = data[i]['category_sub_name'];
                  $("#u_get_sub_category").append("<option value='"+category_sub_name+"'>"+category_sub_name+"</option>");
                 }
                 
                 
               }
            });
        }else
        {
          $("#u_get_sub_category").empty();
          $("#u_get_sub_category").append("<option>- Sub Category -</option>");
          $("#u_get_dept").empty();
          $("#u_get_dept").append("<option>- Department -</option>");

          /*return false;*/
        }
        
      });

      $("#u_get_category").change(function(){
        var get_department = $('select#u_get_category').children("option:selected").val();
        if(get_department != '')
        {
          $.ajax({
               url: 'fetch_doc.php',
               type: 'post',
               data: {get_department:get_department},
               dataType: 'json',
               success:function(data){
                var len = data.length;
                $("#u_get_dept").empty();
                 $("#u_get_dept").append("<option>- Department -</option>");
                 for(var i= 0; i<len; i++){
                  var dpt_id = data[i]['dpt_id'];
                  var get_department = data[i]['get_department'];
                  $("#u_get_dept").append("<option value='"+get_department+"'>"+get_department+"</option>");
                 }
                 
                 
               }
            });
        }else
        {
          $("#u_sub_category").empty();
          $("#u_sub_category").append("<option>- Sub Category -</option>");
          $("#u_get_dept").empty();
          $("#u_get_dept").append("<option>- Department -</option>");
        }
        
      });

});
   
   </script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#upload').click(function(event){
      /*event.preventDefault();*/
      var filename = $('#newDoc').val();
    
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
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#approve').click(function(event){
      /*event.preventDefault();*/
      var filename = $('#newFile').val();
    
      
      var extension = $('#newFile').val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['pdf', 'doc']) == -1 && filename != ''){
          $("#err_msg").html("<span class='label label-important'>NOTE!</span><span> Only PDF Document is allowed to upload.</span>").fadeIn();
          $('#newFile').val('');
          return false;
        }
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#reject').click(function(event){
      /*event.preventDefault();*/
      var filename = $('#newFile').val();

      var extension = $('#newFile').val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['pdf', 'doc']) == -1 && filename != ''){
          $("#err_msg").html("<span class='label label-important'>NOTE!</span><span> Only PDF Document is allowed to upload.</span>").fadeIn();
          $('#newFile').val('');
          return false;
        }
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#update').click(function(event){
      /*event.preventDefault();*/
      var filename = $('#newFile').val();
    
      
      var extension = $('#newFile').val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['pdf', 'doc']) == -1 && filename != ''){
          $("#err_msg").html("<span class='label label-important'>NOTE!</span><span> Only PDF Document is allowed to upload.</span>").fadeIn();
          $('#newFile').val('');
          return false;
        }
    });
  });
</script>   

