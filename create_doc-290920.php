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

if(isset($_POST['save'])){
  $file = $_FILES["file"]['name'];
        $div = explode('.', $file);
        $file_ext = strtolower(end($div));
        /*if($file_ext == 'pdf'){
          $unique_file_path = $timestamp1.'.'.$file_ext;
        } else{
          $msg = "Please upload PDF Document only";
          echo '<script>alert(\''.$msg.'\');</script>';
          return false;
        }*/


        if (strlen($file)>=0) {
          if($file_ext == 'pdf'){
            $unique_file_path = $timestamp1.'.'.$file_ext;
          }else{
          $msgTxt = "Please upload PDF Document only";
          $msgType = 1;
            }
          
          }else{
          $msgTxt = "Please attach document";
          $msgType = 2;
          }



        $dataArray=array(
          'get_doc_name'          =>  trim(dbOutput($_POST['get_doc_name'])),
          'get_doc_desc'          =>  trim(dbOutput($_POST['get_doc_desc'])),
          'get_category'          =>  trim(dbOutput($_POST['get_category'])),
          'get_sub_category'      =>  trim(dbOutput($_POST['get_sub_category'])),
          'get_dept'              =>  trim(dbOutput($_POST['get_dept'])),
          'get_city'              =>  trim(dbOutput($_POST['get_city'])),
          'get_cat'               =>  trim(dbOutput($_POST['get_cat'])),
          'creation_remark'       =>  trim(dbOutput($_POST['creation_remark']))
          
      );

        $cat = $dataArray['get_category'];
        $Target="assets/get_doc/".$cat."/".$unique_file;

        $doc_name = str_replace("'", "''", $dataArray['get_doc_name']);
        $doc_desc = str_replace("'", "''", $dataArray['get_doc_desc']);
        $creation_remark = str_replace("'", "''", $dataArray['creation_remark']);

        if($dataArray['get_doc_name'] == "" || (strlen($dataArray['get_doc_name']))<=0){
        $msg = "Document Name can't be empty";
        echo '<script>alert(\''.$msg.'\');</script>';
        return false;
        }

      
/*}*/
        if(empty($errorArray)){
          if(isset($pid) && $pid>0){

          }else{

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
            '".dbInput($dataArray['get_category'])."',
            '".dbInput($dataArray['get_sub_category'])."',
            '".dbInput($dataArray['get_dept'])."',
            '".dbInput($dataArray['get_city'])."',
            '".dbInput($unique_file)."',
            '".dbInput($timestamp)."',
            '".dbInput($dataArray['get_cat'])."',
            '$creation_remark',
            '".dbInput($timestamp)."',
            '".dbInput($_SESSION['uid'])."',
            '0'
          )";

          $stmt = odbc_prepare($conn, $insert);
          $lead_result = odbc_execute($stmt);

          if($lead_result){
            move_uploaded_file($_FILES["file"]['tmp_name'], $Target);
            $msgTxt = 'Document Uploaded successfully. Waiting for Approval.';
            $msgType = 1;
            }else{
            $msgTxt = 'Something went wrong. Please try again later.';
            $msgType = 2;
            }
            
          }

            header('Location:list-opportunity.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
            exit;
          
        }else {
            $msgTxt = 'Something went wrong. Please try again later.';
            $msgType = 2;
        }

        header('Location:list-opportunity.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
        exit;

    }


/*}*/
    


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

                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" id="myForm" enctype="multipart/form-data">
                                  <input type="hidden" name="pid" value="<?php echo $pid?>"> 
                                    <h3 class="form-section">Document Details</h3>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Document Category:</label>
                                             <div class="controls">
                                                <select class="medium m-wrap" name="get_category" id="get_category" tabindex="1" >

                                      <option value="">- Category -</option>
                                     
                                       <?php
                                        $sql="SELECT  
                                          a.deal_type, 
                                          b.deal_sub_type, 
                                          c.cka_name_id,
                                          c.account_type, 
                                          c.cka_name,
                                          c.cka_status
                                          from 
                                          deal_type a, deal_sub_type b, cka_name_master c 
                                          where 
                                          a.deal_type_id = b.deal_type_id
                                           and b.deal_sub_type_id = c.account_type and a.deal_type like '%$department%' and c.cka_status = 1 order by c.cka_name asc";
                                        $rs=odbc_exec($conn,$sql);
                                        while($f = odbc_fetch_array($rs)){
                                        /*$selected=($f['cka_name_id']==$dataArray['cka_name_id'])?'selected':'';*/
                                        echo '<option value="'.$f['cka_name_id'].'">'.$f['cka_name'].'</option>';
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
                                                <select class="medium m-wrap" name="eng_status" id="eng_status" tabindex="1" >
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
                                                <select class="span8 m-wrap" name="eng_status" id="eng_status" tabindex="1" >
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
                                                <select class="span4 m-wrap" name="eng_status" id="eng_status" tabindex="1" >
                                                <option value="">- City -</option>
                                                
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
                                                <input type="text" name="doc_name" id="doc_name" class="span7 m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Description:</label>
                                             <div class="controls">
                                                <input type="text" name="doc_name" id="doc_name" class="span7 m-wrap">
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
                                                <select class="m-wrap span3" name="sub_status" id="sub_status" tabindex="1" >
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
                                                <input type="text" name="doc_name" id="doc_name" class="span9 m-wrap">
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
                                         <input type="file" name="file" class="default">
                                         </div>
                                      </div>
                                       </div>
                                    </div><br>
                              <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                    <div class="form-actions">
                                      <?php 
                                        if($_SESSION['uid'] == '2015' || $_SESSION['user_type'] == 'management'){
                                          echo '<button type="submit" id="upload" name="edit" class="btn green"> Approve</button> 
                                       <button type="submit" id="cancel" name="edit" class="btn red">Reject</button>';
                                        }else {
                                          echo '<button type="submit" id="upload" name="edit" class="btn green"> Update</button> 
                                       <button type="submit" id="cancel" name="edit" class="btn red">Cancel</button> ';
                                        }

                                       ?>
                                    </div>
                                    </div>
                                 </div>
                                       
                                    </div>
                                    <!--/row--> 

                                  </form>

                    <?php }else{ ?>

                            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" id="myForm" enctype="multipart/form-data">
                                  <input type="hidden" name="pid" value="<?php echo $pid?>"> 
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
                                                <select class="medium m-wrap" name="get_sub_category" id="get_sub_category" tabindex="1" >
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
                                                <select class="chosen span6 m-wrap" name="get_city" id="get_city" tabindex="1" >
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
                                                <input type="text" name="get_doc_name" id="get_doc_name" class="span7 m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Description:</label>
                                             <div class="controls">
                                                <input type="text" name="get_doc_desc" id="get_doc_desc" class="span7 m-wrap">
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
                                                <select class="m-wrap span3" name="get_cat" id="get_cat" tabindex="1" >
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
                                                <input type="text" name="creation_remark" id="creation_remark" class="span9 m-wrap">
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
                                         <input type="file" name="file" class="default">
                                         </div>
                                      </div>
                                       </div>
                                    </div>
                                    <br>
                              <div class="row-fluid">
                                 <div class="span12 ">
                                    <div class="control-group">
                                    <div class="form-actions">
                                      <img src="assets/img/loader_01.gif" alt="loader1" style="display:none; height:30px; width:auto; " id="loaderImg" class="loaderImg">
                                      <button type="submit" id="save" name="save" class="btn blue" onclick="save_doc()"> Save</button> 
                                       <button type="submit" id="cancel" name="cancel" class="btn red">Cancel</button> 
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


      /*saving account info*/


       $("#save_info").click(function(){
        var cka_name_id = $('select#cka_name_id').children("option:selected").val();
        var account_name_modal_u = $('select#account_name_modal').children("option:selected").val();
        var engaged_u = $('input:radio[name=engaged_modal]:checked').val();
        /*var architect_modal_u = $('#architect_modal').val();*/
        var c_city = $('#c_city').val();
        var eng_status_modal_u = $('#eng_status_modal').val();
        var sub_status_modal_u = $('#sub_status_modal').val();
        var address_modal_u = $('#address_modal').val();
        var cka_category_modal_u = $('select#cka_category_modal').children("option:selected").val();

        if(account_name_modal_u != '' && engaged_u  != '' && eng_status_modal_u  != '' && sub_status_modal_u != '' && c_city != '' && address_modal_u != '' && cka_category_modal_u != '')
        {
          $.ajax({
               url: 'fetch_cka.php',
               type: 'post',
               data: {account_name_modal_u:account_name_modal_u, engaged_u:engaged_u, c_city:c_city, eng_status_modal_u:eng_status_modal_u, sub_status_modal_u:sub_status_modal_u, address_modal_u:address_modal_u, cka_category_modal_u:cka_category_modal_u},
               dataType: 'json',
               success:function(data){
                 alert("Account details updated successfully");
                 $("#exampleModalLong").modal('hide');
                 location.reload();
               }
            });
        }else
        {
          alert("( * ) Missing Mandatory Fields");
          return false;
        }
        
    
      });


      /*saving account info*/

   /*adding visit info*/



   /*adding visit info*/


    });
   </script>

   <script>
     $(document).ready(function(){
      $("#cka_name_id").change(function(){
        var cka_list_id = $('select#cka_name_id').children("option:selected").val();
        /*alert(cka);*/

        if(cka_list_id != '')
        {
          $.ajax({
               url: 'cka_visit.php',
               type: 'post',
               data: {cka_list_id:cka_list_id},
               dataType: 'text',
               success:function(data){
                /*alert(data);*/
                $("#cka_visit").html(data);                
               }
            });
        }else
        {
          alert("Please Select Account");
        }
        
      }); 
     });
   </script>

   <script type="text/javascript">
    $(document).ready(function(){
        $('#myForm').submit(function() {
         $('#loaderImg').show();
         $('#save').hide(); 
          return true;
        });
    });
  </script>

  <script>
function save_doc(){
  
var get_doc_name = document.getElementById("get_doc_name").value;


  if(get_doc_name==""){
      alert("Error: Please Enter Document Name");
      return false;
    }

}
</script>