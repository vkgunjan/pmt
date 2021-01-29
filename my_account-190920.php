<?php 
/*$um='active';
$uma='active';*/
include_once('including/all-include.php');
include_once('including/header.php');
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];
$department = $_SESSION['employee_department'];	

?>

<?php 

  /*engagement query*/

    $m = "SELECT 
          m.cka_name_id,
          d.deal_sub_type,
          m.cka_name,
          m.engaged,
          e.engagement,
          s.eng_sub_name,
          m.cka_category,
          c.arch_name,
          c.arch_designation,
          c.arch_contact_no,
          c.arch_email_id,
          count(o.cka_name_id) as [project_count],
          sum(o.obl_sale_forecast_inr) as [total_sale],
          sum(try_convert(decimal(18,0),project_tile_potential_sqm)) as total_sqmt,
          c.arch_visit_date,
          c.arch_visit_remarks,
          u.fullname,
          um.fullname as [manager],
          m.city,
          m.address,
          m.updated_on
          
          from cka_name_master m
      
          left join cka_visit c on c.cka_id = m.cka_name_id
          left join opportunity o on o.cka_name_id = m.cka_name_id and o.architect_name = c.arch_name
          left join user_management u on u.uid = m.updated_by
          left join engagement_status e on e.id = m.e_status
          left join engagement_sub_status s on s.id = m.sub_status
          left join deal_sub_type d on d.deal_sub_type_id = m.account_type
          left join user_management um on um.uid = (select parent_id from user_management where uid = m.updated_by)";


          if(trim($_SESSION['user_type'])=='management') {
                $m.="  WHERE 1= 1 group by m.cka_name_id, d.deal_sub_type, m.cka_name, m.engaged, e.engagement, s.eng_sub_name, m.cka_category, c.arch_name, c.arch_designation, c.arch_contact_no, c.arch_email_id,c.arch_visit_date, m.address, u.fullname, um.fullname, m.city, c.arch_visit_remarks, m.updated_on
          order by m.updated_on desc ";
                }else{

                        if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
          
                          if($_SESSION['user_type']=='manager'){
                          $m.=" where 
                             ( ";

                            $ex=explode(",",$_SESSION['my_team_id']);
                              $xcnt=0;
                            foreach ($ex as $vx){
                            //echo $vx;
                              if($xcnt==0)
                                $m.=" m.updated_by = '".$vx."' or m.updated_by='".$_SESSION['uid']."' ";
                              else
                                $m.=" or m.updated_by = '".$vx."' ";
                              $xcnt++;
                            }
                            $m.=" )group by m.cka_name_id, d.deal_sub_type, m.cka_name, m.engaged, e.engagement, s.eng_sub_name, m.cka_category, c.arch_name, c.arch_designation, c.arch_contact_no, c.arch_email_id,c.arch_visit_date, m.address, u.fullname, um.fullname, m.city, c.arch_visit_remarks, m.updated_on order by m.updated_on desc ";
                          }else{
                            $m.="  where m.updated_by='".$_SESSION['uid']."' group by m.cka_name_id, d.deal_sub_type, m.cka_name, m.engaged, e.engagement, s.eng_sub_name, m.cka_category, c.arch_name, c.arch_designation, c.arch_contact_no, c.arch_email_id,c.arch_visit_date, m.address, u.fullname, um.fullname, m.city, c.arch_visit_remarks, m.updated_on
                              order by m.updated_on desc ";  
                          }

                    }

                  }





  /*engagement query*/

 ?>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box green tabbable">
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
                              <li><a href="#portlet_tab2" data-toggle="tab"><b>List Account</b></a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab"><b>My Account</b></a></li>

                           </ul>

                      <!-- ADD user START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form  id="view_form" class="form-horizontal">
                                 	<input type="hidden" name="pid" value="<?php echo $pid?>"> 
                                    <h3 class="form-section">Account Info</h3>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Account Name:</label>
                                             <div class="controls">
                                                <select class="span8 chosen" name="cka_name_id" id="cka_name_id" tabindex="1" >

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
                                       
                                       <div class="controls span6" style="padding-left: 20px;">
                    <!-- <?php $Yes=($dataArray['engaged']=='Yes')?'checked':''; ?>
                      <?php $No=($dataArray['engaged']=='No')?'checked':''; ?> -->
                      

                                        <label class="radio span2">
                                          <input type="radio" name="engaged" id="Yes" value="Yes" disabled="" />
                                          <span style="font-weight:bold; color:#090">Yes</span>
                                          </label>
                                          <label class="radio span2">
                                          <input type="radio" name="engaged" value="No" id="No" disabled="" />
                                           <span style="font-weight:bold; color:#F00">No</span>
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
                                             <label class="control-label">Account Domain:</label>
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
                                                <span id="city" class="text"></span>
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
                                                <span id="address" class="text"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Category:</label>
                                             <div class="controls">
                                                <span class="text"  id="cka_category"></span>
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

                                  </form>



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
      <div class="modal-body" style="background-color: white;">
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
                                       <div class="span6">
                                          <div class="control-group">
                                       <label class="control-label">Engaged:<span class="required">*</span></label>
                                       
                                       <div class="controls" style="padding-left: 30px;">
                    <!-- <?php $open=($dataArray['status']=='open')?'checked':''; ?>
                      <?php $close=($dataArray['status']=='close')?'checked':''; ?>
                      <?php $lost=($dataArray['status']=='lost')?'checked':''; ?> -->

                                        <label class="radio span3">
                                          <input type="radio" name="engaged_modal" value="Yes" id="Yes_modal" />
                                          <span style="font-weight:bold; color:#090">Yes</span>
                                          </label>
                                          <label class="radio span3">
                                          <input type="radio" name="engaged_modal" value="No" id="No_modal" />
                                           <span style="font-weight:bold; color:#F00">No</span>
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
                                             <label class="control-label">Account Domain:</label>
                                             <div class="controls">
                                                <!-- <input type="text" class="m-wrap span12" name="architect_modal" id="architect_modal"> -->
                                                <span id="account_domain_modal" class="text"></span> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">City:</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap span10" name="c_city" id="c_city">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>       
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Engagement Status:<span class="required">*</span></label>
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
                                             <label class="control-label">Sub Status:<span class="required">*</span></label>
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
                                             <select class="small m-wrap" name="cka_category_modal" id="cka_category_modal" tabindex="1" >

                                                <option value="">-Category-</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>

                                                
                                            </select>
                                            </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn black" data-dismiss="modal">Close</button>
        <button type="button" class="btn blue" id="save_info">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Data Model End -->



                                    <h3 class="form-section">My Engagement</h3>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          
                             
<form action="<?php echo $_SERVER['PHP_SELF']?>" id="cform" method="post" class="form-horizontal">
 <!-- <input type="hidden" value="<?php echo $_GET['pid']?>" name="opportunity_id"  id="opportunity_id"/> -->
  <table border="0" style="width:100%" align="center">
  <tr>
    <th></th>
  </tr>
	<tr>
  	<th><input type="text"  name="arch_name" id="arch_name" placeholder="Architect Name"></th>              
  	<th><input type="text"  name="arch_designation" id="arch_designation" placeholder="Designation"></th>         
  	<th><input type="number"  name="arch_contact_no" id="arch_contact_no" placeholder="Contact No"></th>
    <th><input type="email"  name="arch_email_id" id="arch_email_id" placeholder="Email ID"></th>    
   	<th><input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="arch_visit_date"  id="arch_visit_date" style="width:150px; height: 17px;" placeholder="Visit Date" /></th>    
   	<th><input type="text" name="arch_visit_remarks" id="arch_visit_remarks" placeholder="Write a Short Remark"></th>    
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
                                    
                                    
                                 <!-- </form> -->
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
                            <div class="btn-group pull-right">
                    <a href="export_engagement.php?val=<?php echo base64_encode($m); ?>"><button class="btn red">Architect Details &nbsp;<i class="icon-signout"></i>
                    </button></a>
                    <!-- <ul class="dropdown-menu">
                      <li><a href="#">Print</a></li>
                      <li><a href="#">Export to Excel</a></li>
                    </ul> -->
                  </div>
							<div class="portlet-body">

              <div class="scrollable">
								<table class="table table-striped table-bordered table-hover table-managed" id="sample_1" >
									<thead style="white-space: nowrap; padding: 0px;">
										<tr>
  											<th>#</th>
  											<th>Account Domain</th>
  											<th>Account Name</th>
  											<th>City</th>
                        <th>Engaged</th>
  											<th>Statuse</th>
  											<th>Sub Status</th>
                        <th>Project Count</th>
                        <th>Project Value</th>										
                        <th>Total SQMT</th>
                        <th>Category</th>											
                        <th>Updated By</th>																
                        <th>Updated On</th>													
                        
										</tr>
									</thead>
									<tbody style="white-space: nowrap;">

									<?php
									$sql="SELECT  
                        c.cka_name_id,
                        a.deal_type, 
                        b.deal_sub_type, 
                        c.cka_name,
                        c.city,
                        c.engaged,
                        e.engagement,
                        s.eng_sub_name,
                        count(o.project_name) as [project_count],
                        sum(o.obl_sale_forecast_inr) as [total_sale],
                        sum(try_convert(decimal(18,0),project_tile_potential_sqm)) as total_sqmt,
                        c.cka_category,
                        c.updated_by,
                        u.fullname,
                        c.updated_on
                        from 
                        deal_type a, deal_sub_type b, cka_name_master c
                        left join opportunity o on o.cka_name_id = c.cka_name_id 
                        left join engagement_status e on e.id = c.e_status
                        left join engagement_sub_status s on s.id = c.sub_status
                        left join user_management u on u.uid = c.updated_by
                        where 
                        a.deal_type_id = b.deal_type_id and b.deal_sub_type_id = c.account_type ";

                if(trim($_SESSION['user_type'])=='management') {
                $sql.="  and c.updated_by is NOT NULL group by c.cka_name_id,a.deal_type, b.deal_sub_type, c.cka_name,c.city, c.engaged, e.engagement, s.eng_sub_name, c.cka_category, c.updated_by, u.fullname, c.updated_on order by c.updated_on desc ";
                }else{

                        if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
          
                          if($_SESSION['user_type']=='manager'){
                          $sql.=" and 
                             ( ";

                            $ex=explode(",",$_SESSION['my_team_id']);
                              $xcnt=0;
                            foreach ($ex as $vx){
                            //echo $vx;
                              if($xcnt==0)
                                $sql .=" c.updated_by = '".$vx."' or c.updated_by='".$_SESSION['uid']."' ";
                              else
                                $sql .=" or c.updated_by = '".$vx."' ";
                              $xcnt++;
                            }
                            $sql .=" ) group by c.cka_name_id,a.deal_type, b.deal_sub_type, c.cka_name,c.city, c.engaged, e.engagement, s.eng_sub_name, c.cka_category, c.updated_by, u.fullname, c.updated_on order by c.updated_on desc";
                          }else{
                            $sql.="  and c.updated_by='".$_SESSION['uid']."' 
                            group by c.cka_name_id,a.deal_type, b.deal_sub_type, c.cka_name,c.city, c.engaged, e.engagement, s.eng_sub_name, c.cka_category, c.updated_by, u.fullname, c.updated_on order by c.updated_on desc";  
                          }

                    }

                  }



									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['deal_sub_type'].'</td>';
										echo '<td>'.$f['cka_name'].'</td>';
										echo '<td>'.$f['city'].'</td>';
										echo '<td>'.$f['engaged'].'</td>';																
										echo '<td>'.$f['engagement'].'</td>';
										echo '<td>'.$f['eng_sub_name'].'</td>';
                    echo '<td>'.$f['project_count'].'</td>';	
                    echo '<td>'.$f['total_sale'].'</td>';
                    echo '<td>'.$f['total_sqmt'].'</td>';
										echo '<td>'.$f['cka_category'].'</td>';
                    echo '<td>'.$f['fullname'].'</td>';
                    echo '<td>'.date('d-m-Y',strtotime(trim($f['updated_on']))).'</td>';
										$count++;
									}
									?>

									</tbody>
								</table>
              </div>
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
      $("#edit").prop('disabled', true);
      $(".icon-pencil").prop('disabled',true);
      /*$("#add_arch").prop('disabled', true);*/
   		$("#cka_name_id").change(function(){
   			var cka = $('select#cka_name_id').children("option:selected").val();
        /*alert(cka);*/

   			if(cka != '')
   			{
        $("#edit").prop('disabled', false);
        $(".icon-pencil").prop('disabled',false);
        /*$("#add_arch").prop('disabled',false);*/
   				$.ajax({
               url: 'fetch_cka.php',
               type: 'post',
               data: {cka:cka},
               dataType: 'json',
               success:function(data){
                 $('#account_domain').text(data.deal_sub_type);
                 $('#city').text(data.city);
                 /*$('#engaged').val(data.engaged);
                 $( "#x" ).prop( "checked", true );*/
                 /*alert(data.engaged);*/

                 if(data.engaged == 'Yes'){
                  $('#Yes').prop("checked", true);
                 }else{
                  $('#No').prop("checked", true);
                 }

                 /*$('#eng_status').val(data.e_status);*/
                 /*$('#sub_status').val(data.sub_status);*/

                /*var engaged = $('input:radio[name=engaged]:checked').val();*/

                 $('#address').text(data.address);
                 $('#cka_category').text(data.cka_category);
                 
                 $("#sub_status").empty();
                 if (data.e_status_id == null || data.e_status_id == 0) {
                 $("#eng_status").empty();
                 $("#eng_status").append("<option>- Status -</option>");
                 $("#sub_status").append("<option>- Sub Status -</option>");
                 	
                 }else{
                 $("#eng_status").empty();
                 $("#sub_status").empty();
                 $("#eng_status").append("<option value='"+data.e_status_id+"'>"+data.e_status+"</option>");
                 $("#sub_status").append("<option value='"+data.e_sub_status_id+"'>"+data.e_sub_status+"</option>");
                 }
                 /*
                 if (data.e_status_id == null) {
                 $("#sub_status").empty();
                 $("#sub_status").append("<option>- Sub Status -</option>");
                 
                 }else{
                 //$("#sub_status").empty();
                 $("#sub_status").append("<option value='"+data.e_sub_status_id+"'>"+data.e_sub_status+"</option>");
                 }*/

                 
               }
            });
   			}else
   			{
   				/*alert("Please Select Account");*/
          location.reload();
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
                 $('#account_domain_modal').text(data.deal_sub_type);
                 $('#c_city').val(data.city);
                 /*$('#status_modal').text(data.engaged);*/
                 $("#eng_status_modal").val("<option value='"+data.e_status_id+"'>"+data.e_status+"</option>");
                 /*$('#sub_status_modal').val(data.sub_status);*/
                 /*print_r(data.eng_status);*/

                 $("#sub_status_modal").val("<option value='"+data.e_sub_status_id+"'>"+data.e_sub_status+"</option>");
                 $('#address_modal').val(data.address);
                 $('#cka_category_modal').val(data.cka_category);
                 if(data.engaged == 'Yes'){
                  $('#Yes_modal').prop("checked", true);
                 }else{
                  $('#No_modal').prop("checked", true);
                 }
                
                 
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
                 /*$("#sub_status_modal").append("<option value=''>- Sub Status -</option>");*/
                 for(var i= 0; i<len; i++){
                  var sub_id = data[i]['id'];
                  var sub_name = data[i]['eng_sub_name'];
                  $("#sub_status_modal").append("<option value='"+sub_id+"'>"+sub_name+"</option>");
                 }
                 
                 
               }
            });
        }else
        {
          $("#sub_status_modal").empty();
          $("#sub_status_modal").append("<option value=''>- Sub Status -</option>");
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

        if(account_name_modal_u != '' && engaged_u  != '' && eng_status_modal_u  != '' && sub_status_modal_u != '')
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

$("#add_arch").click(function(){
        var cka_name_id = $('select#cka_name_id').children("option:selected").val();
        var arch_name = $('#arch_name').val();
        var arch_designation = $('#arch_designation').val();
        var arch_contact_no = $('#arch_contact_no').val();
        var arch_email_id = $('#arch_email_id').val();
        var arch_visit_date = $('#arch_visit_date').val();
        var arch_visit_remarks = $('#arch_visit_remarks').val();
        


        if(arch_name != '' && arch_designation  != '' && arch_contact_no  != '' && arch_email_id != '' && arch_visit_date != '' && arch_visit_remarks != '' && cka_name_id != '')
        {
          /*$("#add_arch").prop('disabled', false);*/
          $.ajax({
               url: 'cka_visit.php',
               type: 'post',
               data: {cka_name_id:cka_name_id, arch_name:arch_name, arch_designation:arch_designation, arch_contact_no:arch_contact_no, arch_email_id:arch_email_id, arch_visit_date:arch_visit_date, arch_visit_remarks:arch_visit_remarks},
               dataType: 'text',
               success:function(data){
                 /*alert("Account details updated successfully");*/
                 
                 $("#cka_visit").html(data);
                 $("#arch_name").val('');
                 $("#arch_designation").val('');
                 $("#arch_contact_no").val('');
                 $("#arch_email_id").val('');
                 $("#arch_visit_date").val('');
                 $("#arch_visit_remarks").val('');

                 /*location.reload();*/
               }
            });
        }else
        {
          alert("All Fields are Mandatory");
          return false;
        }
        
    
      });

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

