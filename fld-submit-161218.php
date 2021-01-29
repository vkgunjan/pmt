<script>
function papi(val,id){
//alert(id);
	//alert(refered_by);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     // document.getElementById("demo").innerHTML =  this.responseText;
		val.innerHTML=XMLHttpRequestObject.responseText;   
    }
  };
//document.getElementById("show_size").innerHTML=XMLHttpRequestObject.responseText;

// XMLHttpRequestObject.open("GET","show_size.php?ipg="+show_size,true);

  xhttp.open("GET", "papi.php?val="+val+"&id="+id+"&pid="+<?php echo $_GET['pid']?>, true);
  xhttp.send();
}
</script>


 <script>
function loadDoc(refered_by) {
	//alert(refered_by);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("demo").innerHTML =  this.responseText;
    }
  };
//document.getElementById("show_size").innerHTML=XMLHttpRequestObject.responseText;

// XMLHttpRequestObject.open("GET","show_size.php?ipg="+show_size,true);
  xhttp.open("GET", "responsible-employee-list.php?ref_name="+refered_by, true);
  xhttp.send();
}
</script>

<script>
function show(){
	
var	opportunity_id = document.getElementById("opportunity_id").value;
var activity_visit = document.getElementById("activity_visit").value;
var refered_by = document.getElementById("refered_by").value;
var refered_by_name = document.getElementById("refered_by_name").value
var tile_stage_date = document.getElementById("tile_stage_date").value;
var request_remarks = document.getElementById("request_remarks").value;

	if(activity_visit==""){
			alert("Error: Please Enter Activity Visit Details");
			return false;
		}

	if(refered_by==""){
			alert("Error: Please Select Department");
			return false;
		}

	if(refered_by_name==""){
			alert("Error: Please Select Responsible Owner");
			return false;
		}

	if(tile_stage_date==""){
			alert("Error: Please Select Tile Stage Date");
			return false;
		}

	if(request_remarks==""){
			alert("Error: Please Enter Request Remarks");
			return false;
		}


 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("visit_plan").innerHTML =
      this.responseText;
    }
  };
 
xhttp.open("GET","visit_plan.php?opportunity_id="+opportunity_id+"&action_plan_activity="+action_plan_activity+"&refered_by="+refered_by+"&refered_by_name="+refered_by_name+"&tile_stage_date="+tile_stage_date+"&request_remarks="+request_remarks,true);
  xhttp.send();
}
</script>

 <script>
function action_plan_delete_from_cart_data(refered_by) {
	//alert(refered_by);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("visit_plan").innerHTML =  this.responseText;
    }
  };
//document.getElementById("show_size").innerHTML=XMLHttpRequestObject.responseText;
//      document.getElementById("visit_plan").innerHTML =  this.responseText;

// XMLHttpRequestObject.open("GET","show_size.php?ipg="+show_size,true);
  xhttp.open("GET", "del-action.php?del_ap="+refered_by, true);
  xhttp.send();
}
</script>



<?php 
	        $pm='active';
	        $fld='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['fld_leadID']=$_REQUEST['pid'];

//action plan_project_session_id
	$_SESSION['visit_plan_opp_id']=$_REQUEST['pid'];
	
//print_r($_SESSION);
//asset part starts

//print_r($_POST);

$errorArray=array();
$dataArray=array();
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];		

if(isset($_POST['submit'])){
	//var_dump($_POST); exit;
	$dataArray=array(
		'status' 				=> $_POST['status'],
		'lost_by' 				=> $_POST['lost_by'],
		'reason_for_lost' 		=> $_POST['reason_for_lost'],
		'remarks'				=> $_POST['lost_remark'],
		'fld_remark'			=> $_POST['fld_remark']
	);

// Date checking
	if($dataArray['status']=='lost' && empty($dataArray['remarks'])){
		$errorArray['remarks']='Error: Please Enter Lost Remarks';
	}

	if($dataArray['status']=='lost' && empty($dataArray['lost_by'])){
		$errorArray['remarks']='Error: Please Select Lost By';
	}

	if($dataArray['status']=='lost' && empty($dataArray['reason_for_lost'])){
		$errorArray['reason_for_lost']='Error: Please Enter Reason for Lost';
	}
	
	if($dataArray['status']=='close' && empty($dataArray['fld_remark'])){
		$errorArray['fld_remark']='Error: Please Enter First Level Remarks';
	}
	
	

// Date checking
//	if($dataArray['status']=='close' && $_SESSION['atc']=='0'){
//		$errorArray['remarks']='<br> Error: Please Add At Least 1 SKU Detail Before Submit<br>';
//	}



  if(empty($errorArray)){
	
	 if(isset($pid) && $pid>0){

		 $upd  ="UPDATE opportunity set  ";
		 
		 if($dataArray['status'] =='lost'){
					 $upd .=" status='lost', lost_date= '".dbInput($timestamp)."', lost_by= '".dbInput($dataArray['lost_by'])."', reason_for_lost= '".dbInput($dataArray['reason_for_lost'])."', lost_remark= '".dbInput($dataArray['remarks'])."'	 ";
				}

		
		 if($dataArray['status'] =='close'){
					 $upd .=" current_stage='2', sampling_date='".dbInput($timestamp)."', fld_remark= '".dbInput($dataArray['fld_remark'])."' ";
				}
				
		 $upd .=" where opportunity_id='".(int)dbInput($pid)."'";




		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = 'Discussion Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Discussion , Please Try Later.';
					$msgType = 2;
				}
		}
	
				header('Location:first-level-discussion.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;
	}

}

?>

<script type="text/javascript" src="spare_part.js"></script>
<script type="text/javascript" src="add_to_cart_data.js"></script>
<script type="text/javascript" src="delete_from_cart_data.js"></script>


<script type="text/javascript">
        function codeAddress() {
				$("#p").hide();
				$("#q").hide();	

           if(document.getElementById("move").checked==true){
				$("#q").show();
			}else{
				$("#q").hide();	
			}


           if(document.getElementById("lost").checked==true){
				$("#p").show();
				$("#q").hide();
			}
       
			$("#move").click(function(){
				$("#q").show();
				$("#p").hide();
			});
  
			$("#lost").click(function(){
				$("#p").show();
				$("#q").hide();
			});
	   
	    }
        window.onload = codeAddress;
        </script>
        
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Discussion</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
<?php /*?>                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
<?php */?>                      <li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Project Action Plan</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Discussion</a></li>			
<?php /*?>
         <li class="<?php echo (isset($_GET['tab2'])?'active':'')?>"><a href="#portlet_tab2" id="tab2" data-toggle="tab">Purchase Details</a></li>
		 <li class="<?php echo (!isset($_GET['tab2'])?'active':'')?>"><a href="#portlet_tab1" data-toggle="tab">Asset Details</a></li>			
<?php */?>
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 
                                   
						<table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											<!--<th>Lead ID</th>-->
                                            <th>#</th>
                                            <th>Lead ID</th>
                                            <th>CKA Name</th>
											<!--<th >CKA Type</th>-->
											<th>Project Name</th>
											<th >Project Type</th>
											<th >State</th>
											<th>City</th>
											<!--<th >Architect Name</th>-->
                                          <!--  <th>Tile Stage Date</th>-->
											<th>Tiling Date</th>

                                            <th>OBL Forecast</th>
                                            <!--<th>Status</th>-->
											<th>Win Probability</th>
                                           
                                          
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		$sql="
			SELECT
			d.lead_id, 
			d.opportunity_id,
			a.cka_name,
			b.cka_type,
			c.project_type,
			d.[project_name],
			e.state_name,
			d.[city],
			d.[architect_name],
			d.[tile_stage_date],
			d.[obl_sale_forecast_inr],
		 	 d.[probability_of_win],
			d.[status],
			d.quotation_status
			FROM [opportunity] d
			left join cka_name_master a on a.cka_name_id = d. cka_name_id
			left join cka_type_master b on b.cka_type_id = d.cka_type_id
			left join project_type_master c on c.project_type_id = d.project_type_id
			left join state_master e on e.state_id = d.state_id
			where d.opportunity_id = '".$_REQUEST['pid']."'
		";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									
									while($f = odbc_fetch_array($rs)){
										
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										echo '<td>'.$f['lead_id'].'</td>';
										echo '<td>'.$f['cka_name'].'</td>';
										//echo '<td>'.$f['cka_type'].'</td>';										
										echo '<td>'.ucfirst($f['project_name']).'</td>';	
										echo '<td >'.$f['project_type'].'</td>';																

										echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.$f['city'].'</td>';
										//echo '<td>'.$f['architect_name'].'</td>';
										//echo '<td>'.$f['tile_stage_date'].'</td>';
											echo '<td>'.date('d-m-Y',strtotime(trim($f['tile_stage_date']))).'</td>';
										
										echo '<td>'.valchar(trim($f['obl_sale_forecast_inr'])).'</td>';
										//echo '<td>'.number_format(trim($f['obl_sale_forecast_inr']),0).'</td>';
											
											echo '<td align="center">'.ucfirst($f['probability_of_win']).'</td>';
											
											//echo '<td>'.trim($f['tile_stage_date']).'</td>';
										
									}
									?>
									</tbody>
						</table>

							


                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" >
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 

                        
                       
                         
                            
                             <table border="0" style="width:100%" align="center">

                              	
                               
		
							
							<tr height="25">
									<th colspan="11" style="background-color:#009999; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Add Product Details </th>
								</tr>

						<tr height="50">
                                	
                                    
                                    <th width="10%"> SKU Size</th>
                                    <td width="10%">
                                    <select name="spare_part_id" style="width:160px;"  onChange="display(this.value)" id="spare_part_id">
                                       		<option value="">- Select Size -</option>
                                             <?php
								$ssql="select distinct(size_code_desc) size_id, size_code_desc from size_master order by size_code_desc ";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$ss=($f['size_id']==$dataArray['spare_part_id'])?'selected':'';
										echo '<option value="'.$f['size_id'].'" '.$ss.'>'.trim($f['size_code_desc']).' </option>';
										}
										?>
                                          </select>
                                    </td>
                               
                               	<td width="64%" align="left">
                                
                                <div id="show_size" >
                                	
                                </div>
                                
                                </td>
                               
                                </tr>
			

                                 
                                
								<tr>
                                	<td colspan="4" align="center">
                                    	<table border="1" style="width:100%">
                              	<tr height="25">
			<th colspan="4" style="background-color:#FF9900; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF"> Requirements Details </th>
								</tr>
                                           
                                <tr>
                                       <td colspan="4">
                                			<div id="add_to_cart_data"><?php include('add_to_cart_data.php');?></div>       
                                       </td>
                                </tr>
                                       
                                       </table>
                                    </td>
                                </tr>


							</table>
                            

									<div  style="text-align:right;">
                                    
                                    <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
                                    
							<?php 
									
										//echo '<input type="submit" name="submit" value="Submit">';

										echo '<a href="first-level-discussion.php">'; 
                                        echo '<input type="button" value="Back">';
                                        echo '</a>';
									

							?>

			                        <!-- <input type="submit" name="submit" value="Submit">
			                                                
			                                                  
			                        										<a href="first-level-discussion.php"> 
			                                                                <input type="button" value="Back">
			                                                                </a> -->

                                    </div>
                             </form>
                             
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal">
 <input type="hidden" value="<?php echo $_GET['pid']?>" name="opportunity_id"  id="opportunity_id"/>
                              

          <table border="0" style="width:100%" align="center">
          	<tr height="30">
									<th colspan="11" style="background-color:gray; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Visit Details </th>
								</tr>

       <tr>
			<th>Activity</th>
			<th>Person Name</th>  
			<th>Contact No</th>  
			<th>Date Timeline</th> 
            <th>Visit Remarks</th> 
            <th></th> 
        </tr>


		<tr>

		<th>
      <input type="text" style="width:250px; height: 30px; resize:none;" name="activity_visit" id="activity_visit">
	</th>              
       <th>
					

				<select name="action_plan_activity" id="action_plan_activity" >
					<option value="">-Select-</option>
					<option value="Architect Brand Approval">Architect Brand Approval</option>
					<option value="Architect SKU Design Approval">Architect SKU Design Approval</option>
					<option value="Business Workshop">Business Workshop</option>                    
					<option value="First Discussion Visit">First Discussion Visit</option>
					<option value="GPS Brand Approval">GPS Brand Approval</option>
					<option value="GPS Tender Approval">GPS Tender Approval</option>
					<option value="Mock Up">Mock Up</option>
					<option value="Plant Visit">Plant Visit</option>                    
					<option value="Prodduct Sampling">Prodduct Sampling</option>
					<option value="Sr. Management Visit">Sr. Management Visit</option>
					<option value="Technical Workshop">Technical Workshop</option>
					<option value="Vendor Registration">Vendor Registration</option>                    

				</select>
			</th>
     	
        	<th>
            	<select name="refered_by" onchange="loadDoc(this.value)" id="refered_by" style="width:120px;">
					<option value="">-Select-</option>
					<option value="SET">SET</option>
					<option value="PET">PET</option>
		   			<option value="GET">GET</option>
		   			<option value="CTU">CTU</option>
					<option value="Retail">Retail</option>
				</select>
			</th>         

		
         <th>

<div id="demo">

	<select name="" class="select" style="width:200px; height:30px; font-size:13.5px;" id="" >
    <option value="">- Select Employee -</option>
	</select>
</div>
<input type="hidden" name="refered_by_name" id="refered_by_name" />

			</th>   
            
 	<th>
      <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="tile_stage_date"  id="tile_stage_date" style="width:130px; height: 30px;"/>
	</th>    

 	<th>
      <input type="text" style="width:250px; height: 30px; resize:none;" name="request_remarks" id="request_remarks">
	</th>    

    <td>
   
   <input type="button" value="add"  onclick="show();"/>
    </td>

</tr>
</table>

<table border="0" style="width:100%" align="center">
<td colspan="4" height="20"></td>
</tr>

		<tr height="27">
			<th colspan="5"  align="center" style="background-color:gray; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">
            	Visit Details List
            </th>
		</tr>
</table>

<table border="1" style="width:100%" align="center">

<tr>
	<td>
    	    <div id="visit_plan"><?php include('visit_plan.php');?></div> 
    </td>
</tr>

</table>
</form>
                        
                                 <!-- tab 1, asset detail ends -->  
                              </div><br>
            
                                
                                 <!--#################### purchase details part start tab2 ##############################-->  
                                 <!-- tab 2, purchase detail-->  
                              <div class="tab-pane " id="portlet_tab2">
                                   
                                    <?php 
										//print_r($_SESSION);
										if($vv > 0){

									?>
								
							<?php include_once("project-action-plan.php")?>


                                 <?php } else { echo '<h3 align="center"><font color="#F00A0E">Error: Please Submit First Level Discussion to Activate Project Action Plan</font></h3>'; } ?>

                              </div>
                                 <!-- tab 2 purchase details ends--> 
                           <!--#################### purchase details part ends ##############################-->   
                                 
                          <!-- tab 3, maintenance detail-->  
                              <div class="tab-pane " id="portlet_tab3">

 							 <div class="portlet-body">
								<div class="clearfix">
                                		

									
								</div>
								
							</div>

                                   
                            <!-- work area-->  
                                
                          

                           
                              </div>
                                 <!-- tab 3 maintenance ends-->  
                                 
                                  
                                 
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