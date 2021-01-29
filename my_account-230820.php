<?php 
$um='active';
$uma='active';
include_once('including/all-include.php');
include_once('including/header.php');
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];
$department = $_SESSION['employee_department'];	

?>

 <!-- <script src="assets/js/jquery-1.11.3.min.js"></script> -->
 
 <?php /*?><script>
$(document).ready(function(){
$("#mt").hide();

if(document.getElementById("g").checked){
    $("#mt").show();
}else{
    $("#mt").hide();
}

//alert(genchk);
if(genchk=='general'){
   $("#mt").show();
}

  $("#mgr").click(function(){
    $("#mt").hide();
  });

  $("#mgt").click(function(){
    $("#mt").hide();
  });

 $("#a").click(function(){
    $("#mt").hide();
  });
  
   $("#g").click(function(){
    $("#mt").show();
  });

  
});
</script><?php */?>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box purple tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480"><?php echo $formType?></span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                              <li><a href="#portlet_tab2" data-toggle="tab">List Account</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add Account</a></li>

                           </ul>

                      <!-- ADD user START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                 	<input type="hidden" name="pid" value="<?php echo $pid?>"> 
                                    <h3 class="form-section">Account Info</h3>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Account Name:</label>
                                             <div class="controls">
                                                <select class="m-wrap span8" name="cka_name_id" id="cka_name_id" tabindex="1" >

										<option value="">-Select Account-</option>
	                                   
                                       <?php
										$sql="SELECT  
											a.deal_type, 
											b.deal_sub_type, 
											c.cka_name_id,
											c.account_type, 
											c.cka_name
											from 
											deal_type a, deal_sub_type b, cka_name_master c 
											where 
											a.deal_type_id = b.deal_type_id
											 and b.deal_sub_type_id = c.account_type and a.deal_type like '%$department%' order by c.cka_name asc";
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
                                       <label class="control-label">Engaged:</label>
                                       <div class="controls">
                                          <label class="radio">
                                          <div class="radio" id="uniform-undefined"><span><input checked=""  type="radio" name="engaged" value="Yes" id="engaged" style="opacity: 0;"></span></div>
                                          Yes
                                          </label>
                                          <label class="radio">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="engaged" id="engaged" value="No" style="opacity: 0;"></span></div>
                                          No
                                          </label>  
                                           
                                       </div>
                                    </div>
                                       </div>
                                       <!--/span-->
                                       
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Architect:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span8" name="architect" id="architect" disabled="disabled"> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contact Person:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span8" name="c_person" id="c_person" disabled="disabled">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>       
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Engagement Status:</label>
                                             <div class="controls">
                                                <select class="medium m-wrap" name="eng_status" id="eng_status" tabindex="1" >
                                                <option value="">-Status-</option>
                                                
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Sub Status:</label>
                                             <div class="controls">
                                                <select class="medium m-wrap" name="sub_status" id="sub_status" tabindex="1" >

                                                <option value="">-Sub Status-</option>
                                                
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Address:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span8" name="address" id="address" disabled="disabled"> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Category:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span2" name="cka_category" id="cka_category" disabled="disabled">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>

                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                             <div class="form-actions">
                                       <button type="submit" data-toggle="modal" id="edit" name="edit" data-target="#exampleModalLong" class="btn blue"><i class="icon-pencil"></i> Edit</button>
                                       
                                    </div>
                                          </div>
                                       </div>
                                       
                                    </div>
                                    <!--/row--> 



<!-- Data Model start -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" style="width: 980px; margin-left: -480px;" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Edit Account Information</h3>
        <!-- <button type="button" class="close" data-dismiss="modal"> -->

          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
        <br>
      </div>
      <div class="modal-body span12">
        <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Account Name:</label>
                                             <div class="controls">
                                                <select class="m-wrap span12" name="account_name_modal" id="account_name_modal" tabindex="1" >

                    <option value="">-Select Account-</option>
                                     
                                         </select>
                                       
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                       <label class="control-label">Engaged:</label>
                                       <div class="controls">
                                          <label class="radio">
                                          <div class="radio" id="uniform-undefined"><span><input checked=""  type="radio" name="engaged" value="Yes" id="engaged" style="opacity: 0;"></span></div>
                                          Yes
                                          </label>
                                          <label class="radio">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="engaged" id="engaged" value="No" style="opacity: 0;"></span></div>
                                          No
                                          </label>  
                                           
                                       </div>
                                    </div>
                                       </div>
                                       <!--/span-->
                                       
                                       <!--/span-->
                                    </div>

                        <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Architect:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span12" name="architect_modal" id="architect_modal"> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contact Person:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span10" name="c_person_modal" id="c_person_modal">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>       
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Engagement Status:</label>
                                             <div class="controls">
                                                <select class="medium m-wrap" name="eng_status_modal" id="eng_status_modal" tabindex="1" >
                                                <option value="">-Status-</option>
                                                <?php
                                                                    $eng_sql="SELECT * from engagement_status where status = 1";
                                                                    $eng_rs=odbc_exec($conn,$eng_sql);
                                                                    while($e = odbc_fetch_array($eng_rs)){
                                                                    /*$selected=($f['cka_name_id']==$dataArray['cka_name_id'])?'selected':'';*/
                                                                    echo '<option value="'.$e['id'].'">'.$e['engagement'].'</option>';
                                                                    }
                                                                    ?>
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Sub Status:</label>
                                             <div class="controls">
                                                <select class="medium m-wrap" name="sub_status_modal" id="sub_status_modal" tabindex="1" >

                                                <option value="">-Sub Status-</option>
                                                
                                            </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Address:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span12" name="address_modal" id="address_modal"> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Category:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span3" name="cka_category_modal" id="cka_category_modal">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn black" data-dismiss="modal">Close</button>
        <button type="button" class="btn blue">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Data Model End -->



                                    <h3 class="form-section">My Activity</h3>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          
                             
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" id="cform" method="post" class="form-horizontal">
 <input type="hidden" value="<?php echo $_GET['pid']?>" name="opportunity_id"  id="opportunity_id"/>
                              

          <table border="0" style="width:100%" align="center">
          	<!-- <tr height="30">
          										<th colspan="11" style="background-color:gray; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Add Visit Details </th>
          									</tr> -->

       <tr><th></th>
			<!-- <th>Activity</th>
			 <th>Person Name</th>  
			 <th>Contact No</th>  
			 <th>Date Timeline</th> 
			             <th>Visit Remarks</th> 
			             <th></th> --> 
        </tr>


		<tr>

		<th>
      <input type="text" style="width:250px; resize:none;" name="activity_visit" id="activity_visit" placeholder="Add Your Activity Decription">
	</th>              
      

			<th>
      <input type="text" style="width:250px; resize:none;" name="person_name" id="person_name" placeholder="Person Name">
	</th>         

	
	<th>
      <input type="number" style="width:230px; resize:none;" name="contact_no" id="contact_no" placeholder="Contact No">
	</th>    
            
 	<th>
      <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="visit_date"  id="visit_date" style="width:150px; height: 17px;" placeholder="Visit Date" />
	</th>    

 	<th>
      <input type="text" style="width:250px;resize:none;" name="visit_remarks" id="visit_remarks" placeholder="Write a Short Remark">
	</th>    

    <td>
   
   <input type="button" class="btn yellow no-print" value="add"  onclick="show_name();"/>
    </td>

</tr>
</table>

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
    	    <div id="visit_plan"><?php include('visit_plan.php');?></div> 
    </td>
</tr>

</table>
</form>
                                       </div>
                                    </div>
                                    
                                    <!--/row-->           
                                    
                                    
                                 </form>
                                 <!-- ADD user ENDS -->  
                              </div>
                                 <!-- LIST user START -->  
                              <div class="tab-pane " id="portlet_tab2">
                                 <!-- <div class="portlet box red">
                                 							<div class="portlet-title">
                                 								<h4><i class="icon-cogs"></i>User List </h4>
                                 								<div class="tools">
                                 								</div>
                                 							</div> -->
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover table-managed" id="sample_1" >
									<thead>
										<tr>
											<th>#</th>
											<th>User Type</th>
											<th>Department</th>
											<th>Emp Code</th>
                                            <th>Full Name</th>
											<th>Username</th>
											<th>Email</th>											
                                            <th>Contact</th>											
                                            <th>Manager Name</th>																
                                            <th>Status</th>													
                                            <th>Action</th>
										</tr>
									</thead>
									<tbody>

									<?php
									$sql="SELECT u.uid, 
										u.user_type,
										u.emp_code, 
										u.fullname as [user_name], 
										u.username, 
										u.password,
										u.email, 
										u.contact, 
										t.fullname as [manager_name], 
										r.territory_name, 
										u.employee_department, 
										u.emp_status 
										from user_management u
										left join user_management t on t.uid = u.parent_id
										left outer join territory_master r on r.territory_id = u.employee_territory order by u.added_date desc";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.ucfirst($f['user_type']).'</td>';
										echo '<td>'.ucfirst($f['employee_department']).'</td>';
										echo '<td>'.ucfirst($f['emp_code']).'</td>';
										echo '<td width="5%">'.$f['user_name'].'</td>';																
										echo '<td>'.$f['username'].'</td>';
										echo '<td>'.$f['email'].'</td>';	
										echo '<td>'.$f['contact'].'</td>';
										echo '<td>'.$f['manager_name'].'</td>';

										if($f['emp_status'] == 0){
											$e_status = "Inactive";
										}else{
											$e_status = "Active";
										}
										echo '<td>'.$e_status.'</td>';									

									echo '<td>';
									echo '<a href="user-management.php?pid='.$f['uid'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
									echo '&nbsp;&nbsp;<a href="target-achievement.php?delid='.$f['uid'].'" class="btn mini red"><i class="icon-bar-chart"></i> TGT / ACH </a>';
									echo '</td>';
										$count++;
									}
									?>

									</tbody>
								</table>
							</div>
						</div>
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
   		$("#cka_name_id").change(function(){
   			var cka = $('select#cka_name_id').children("option:selected").val();
   			if(cka != '')
   			{
   				$.ajax({
               url: 'fetch_cka.php',
               type: 'post',
               data: {cka:cka},
               dataType: 'json',
               success:function(data){
                 $('#architect').val(data.architect);
                 $('#c_person').val(data.c_person);
                 /*$('#engaged').text(data.engaged);*/
                 /*$('#eng_status').val(data.e_status);*/
                 /*$('#sub_status').val(data.sub_status);*/
                 $('#address').val(data.address);
                 $('#cka_category').val(data.cka_category);
                 
                 $("#sub_status").empty();
                 if (data.e_status_id == null) {
                 //$("#eng_status").empty();
                 //$("#eng_status").append("<option>- Status -</option>");
                 	
                 }else{
                 $("#eng_status").empty();
                 $("#eng_status").append("<option value='"+data.e_status_id+"'>"+data.e_status+"</option>");
                 }
                 
                 if (data.e_status_id == null) {
                 $("#sub_status").empty();
                 $("#sub_status").append("<option>- Sub Status -</option>");
                 
                 }else{
                 //$("#sub_status").empty();
                 $("#sub_status").append("<option value='"+data.e_sub_status_id+"'>"+data.e_sub_status+"</option>");
                 }

                 
               }
            });
   			}else
   			{
   				/*alert("Please Select Account");*/
   			}
   			
   		});
   	});
   </script>

    <script>
   	$(document).ready(function(){
   		$("#eng_status").change(function(){
   			var eng = $('select#eng_status').children("option:selected").val();
   			if(eng != '')
   			{
   				$.ajax({
               url: 'fetch_cka.php',
               type: 'post',
               data: {eng:eng},
               dataType: 'json',
               success:function(data){
               	var len = data.length;
               	$("#sub_status").empty();
                 $("#sub_status").append("<option>- Sub Status -</option>");
                 for(var i= 0; i<len; i++){
                 	var sub_id = data[i]['id'];
                 	var sub_name = data[i]['eng_sub_name'];
                 	$("#sub_status").append("<option value='"+sub_id+"'>"+sub_name+"</option>");
                 }
                 
                 
               }
            });
   			}else
   			{
   				/*alert("Please Select Account");*/
   			}
   			
   		});

      $("#edit").click(function(){
       
        var cka = $('select#cka_name_id').children("option:selected").val();
        if(cka != '')
        {
          $.ajax({
               url: 'fetch_cka.php',
               type: 'post',
               data: {cka:cka},
               dataType: 'json',
               success:function(data){
                 $('#architect_modal').val(data.architect);
                 $('#c_person_modal').val(data.c_person);
                 /*$('#engaged').text(data.engaged);*/
                 /*$('#eng_status').val(data.e_status);*/
                 /*$('#sub_status').val(data.sub_status);*/
                 $('#address_modal').val(data.address);
                 $('#cka_category_modal').val(data.cka_category);
                 
                
                 
                 $("#account_name_modal").empty();
                 $("#account_name_modal").append("<option value='"+data.cka_name_id+"'>"+data.account_name+"</option>");

                 
               }
            });
        }else
        {
          alert("Please Select Account");
          return false;
        }
        
    
      });


      $("#eng_status_modal").change(function(){
        var eng = $('select#eng_status_modal').children("option:selected").val();
        if(eng != '')
        {
          $.ajax({
               url: 'fetch_cka.php',
               type: 'post',
               data: {eng:eng},
               dataType: 'json',
               success:function(data){
                var len = data.length;
                $("#sub_status_modal").empty();
                 $("#sub_status_modal").append("<option>- Sub Status -</option>");
                 for(var i= 0; i<len; i++){
                  var sub_id = data[i]['id'];
                  var sub_name = data[i]['eng_sub_name'];
                  $("#sub_status_modal").append("<option value='"+sub_id+"'>"+sub_name+"</option>");
                 }
                 
                 
               }
            });
        }else
        {
          /*alert("Please Select Account");*/
        }
        
      });


   	});
   </script>

