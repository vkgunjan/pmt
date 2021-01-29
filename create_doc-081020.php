<?php 
/*$um='active';
$uma='active';*/
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
    'created_by'    => trim(dbOutput($f['created_by']))
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

                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" id="updateData" enctype="multipart/form-data">
                                  <input type="hidden" name="pid" id="pid" value="<?php echo $pid?>"> 
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
                                             <label class="control-label">Sub Category:</label>
                                             <div class="controls">
                                                <select class="medium m-wrap" name="u_get_sub_category" id="u_get_sub_category" tabindex="1" >
                                                <!-- <option value="">- Sub Category -</option> -->
                                                <?php  
                                                  $sql="SELECT * from get_category where category_name = '".trim($dataArray['get_category'])."' and category_status = 1";
                                                  $rs=odbc_exec($conn,$sql);
                                                  while($f = odbc_fetch_array($rs)){
                                                  $selected=($f['category_sub_name']==$dataArray['get_sub_category'])?'selected':'';
                                                  echo '<option value="'.$f['category_sub_name'].'" '.$selected.'>'.$f['category_sub_name'].'</option>';
                                                  }
                                                  ?>
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Department:</label>
                                             <div class="controls">
                                                <select class="span8 m-wrap" name="u_get_dept" id="u_get_dept" tabindex="1" >
                                                <!-- <option value="">- Department -</option> -->
                                                <?php  
                                                  $sql="SELECT * from get_department where get_category = '".trim($dataArray['get_category'])."' and get_status = 1";
                                                  $rs=odbc_exec($conn,$sql);
                                                  while($f = odbc_fetch_array($rs)){
                                                  $selected=($f['get_department']==$dataArray['get_dept'])?'selected':'';
                                                  echo '<option value="'.$f['get_department'].'" '.$selected.'>'.$f['get_department'].'</option>';
                                                  }
                                                  ?>
                                                
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">City:</label>
                                             <div class="controls">
                                                <select class="span4 m-wrap" name="u_get_city" id="u_get_city" tabindex="1" >
                                                <option value="">- City -</option>
                                                <?php
                                                $city_sql="SELECT id, city, territory from city_master where territory_id = '".$_SESSION['employee_territory']."' and status = 1 order by city asc";
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
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Short Remark:</label>
                                             <div class="controls">
                                                <input type="text" name="u_creation_remark" id="u_creation_remark" class="span9 m-wrap" value="<?php echo $dataArray['creation_remark']?>">
                                             </div>
                                          </div>
                                       </div>
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
                                         <a href="<?php echo $new_file; ?>" target="_blank"><img src="assets/img/pdf2.png" alt="" style="max-width: 30px"></a> 
                                         <input type="file" name="newFile" id="u_fileExtension">
                                         
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
                                          echo '<button type="submit" id="approve" name="approve" class="btn green"> Approve</button> 
                                       <button type="submit" id="reject" name="reject" class="btn red">Reject</button>';
                                        }else {
                                          echo '<button type="submit" id="update" name="update" class="btn green"> Update</button> 
                                       <a href="list-doc.php"><button class="btn red">Cancel</button></a> ';
                                        }

                                       ?>
                                    </div>
                                    </div>
                                 </div>
                                       
                                    </div>
                                    <!--/row--> 

                                  </form>

                    <?php }else{ ?>

                            <form method="post" class="form-horizontal" id="addData" name="addData" enctype="multipart/form-data">
                                  <!-- <input type="hidden" name="pid" value="<?php echo $pid?>">  -->
                                    <h3 class="form-section">Upload Document</h3>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Document Category:</label>
                                             <div class="controls">
                                                  <select class="medium m-wrap" name="get_category" id="get_category" tabindex="1" required>

                                      <option value="">- Category -</option>
                                     
                                       <?php
                                        $sql="SELECT distinct category_name from get_category order by category_name asc";
                                        $rs=odbc_exec($conn,$sql);
                                        while($f = odbc_fetch_array($rs)){
                                        /*$selected=($f['cka_name_id']==$dataArray['cka_name_id'])?'selected':'';*/
                                        echo '<option value="'.$f['category_name'].'">'.$f['category_name'].'</option>';
                                        }
                                        ?>
                                         </select>
                                       
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Sub Category:</label>
                                             <div class="controls">
                                                <select class="medium m-wrap" name="get_sub_category" id="get_sub_category" tabindex="1" required>
                                                <option value="">- Sub Category -</option>
                                                
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Department:</label>
                                             <div class="controls">
                                                <select class="span8 m-wrap" name="get_dept" id="get_dept" tabindex="1" >
                                                <option value="">- Department -</option>
                                                
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">City:</label>
                                             <div class="controls">
                                                <select class="span6 m-wrap" name="get_city" id="get_city" tabindex="1" required>
                                                <option value="">- City -</option>
                                                <?php
                                                $city_sql="SELECT id, city, territory from city_master where territory_id = '".$_SESSION['employee_territory']."' and status = 1 order by city asc";
                                                $city_rs=odbc_exec($conn,$city_sql);
                                                while($c = odbc_fetch_array($city_rs)){
                                                echo '<option value="'.$c['city'].'">'.$c['city'].' ('.$c['territory'].')</option>';
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
                                                <input type="text" name="get_doc_name" id="get_doc_name" class="span7 m-wrap" required>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Description:</label>
                                             <div class="controls">
                                                <input type="text" name="get_doc_desc" id="get_doc_desc" class="span7 m-wrap" required>
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
                                                <select class="m-wrap span3" name="get_cat" id="get_cat" tabindex="1" required>
                                                <!-- <option value="">- Select -</option> -->
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Short Remark:</label>
                                             <div class="controls">
                                                <input type="text" name="creation_remark" id="creation_remark" class="span9 m-wrap" required>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>

                                    <div class="row-fluid">
                                       <div class="span12 ">
                                      <div class="control-group">
                                         <label class="control-label">PDF Document:</label>
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
                              <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                    <div class="form-actions">
                                      <img src="assets/img/loader_01.gif" alt="loader1" style="display:none; height:30px; width:auto; " id="loaderImg" class="loaderImg">
                                      <input type="submit" class="btn blue" name="upload" id="upload" value="Upload">
                                       <a href="list-doc.php"><button class="btn red">Cancel</button></a> 
                                    </div>
                                    </div>
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


});
   
   </script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#upload').click(function(){
    /*$('#action').val('insert');
    $('#upload').val('Upload');  */
    });
    $('#addData').submit(function(event){
      event.preventDefault();
      var filename = $('#newDoc').val();
      /*var get_category = $('select#get_category').children("option:selected").val();
      var get_sub_category = $('select#get_sub_category').children("option:selected").val();
      var get_dept = $('select#get_dept').children("option:selected").val();
      var get_city = $('select#get_city').children("option:selected").val();
      var get_cat = $('select#get_cat').children("option:selected").val();
      var get_doc_name = $('#get_doc_name').val();
      var get_doc_desc = $('#get_doc_desc').val();
      var creation_remark = $('#creation_remark').val();*/
      /*var pid = $('#pid').val();*/
      var data = $(this).serialize();
      /*data.append('#newDoc', $('input[type=file]')[0].files[0]);*/
      alert(data);
      if(filename == ''){
        $("#error_msg").html("<span class='label label-important'>NOTE!</span><span> Please Select Document to Upload.</span>").fadeIn();
          return false;
      }else {
        var extension = $('#newDoc').val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['pdf', 'doc']) == -1){
          $("#error_msg").html("<span class='label label-important'>NOTE!</span><span> Only PDF Document is allowed to upload.</span>").fadeIn();
          $('#newDoc').val('');
          return false;
        }else {
          $.ajax({
            url: "upload_doc.php",
            method: "POST",
            enctype: 'multipart/form-data',
            data: data,
            contentType: false,
            processData: false,
            
            beforeSend : function()
             {
              //$("#preview").fadeOut();
              $("#error_msg").fadeOut();
             },
            success: function(data){
            if(data != 'success'){
              alert("Something Went Wrong. Please Try again later");
              return false;
              }else{
                alert("success");
              }
            }
          });
        }
      }
    });
  });
</script>
   

