<?php 
	        $pm='active';
	        $cw='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['supply_lead_id']=$_REQUEST['pid'];

//action plan_project_session_id
	$_SESSION['action_plan_opp_id']=$_REQUEST['pid'];
	$_SESSION['visit_plan_opp_id']=$_REQUEST['pid'];
	
//print_r($_SESSION);
//asset part starts

//print_r($_POST);

$errorArray=array();
$dataArray=array();
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];		

if(isset($_POST['submit'])){
	
	$dataArray=array(
		'status' => $_POST['status'],
		'remarks'=> $_POST['remarks']
	);

// Date checking
	if($dataArray['status']=='lost' && empty($dataArray['remarks'])){
		$errorArray['remarks']='Error: Please Enter Reason For Lost';
	}

// Date checking
	if($dataArray['status']=='close' && $_SESSION['atc']=='0'){
		$errorArray['remarks']='Error: Please Add SKU Details before Submit';
	}



  if(empty($errorArray)){
	
	 if(isset($pid) && $pid>0){

		 $upd  ="UPDATE opportunity set  ";
		 
		 if($dataArray['status'] =='lost'){
					 $upd .=" status='lost', lost_date= '".dbInput($timestamp)."', lost_remarks= '".dbInput($dataArray['remarks'])."'	 ";
				}

		 if($dataArray['status'] =='close'){
					 $upd .=" current_stage='3' , sampling_date='".dbInput($timestamp)."' ";
				}
				
		 $upd .=" where opportunity_id='".(int)dbInput($pid)."'";

		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' First Level Discussion Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update First Level Discussion , Please Try Later.';
					$msgType = 2;
				}
		}
	
				header('Location:first-level-discussion.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;
	}

}

?>

<script type="text/javascript" src="supply_spare_part.js"></script>
<script type="text/javascript" src="supply_add_to_cart_data.js"></script>
<script type="text/javascript" src="supply_delete_from_cart_data.js"></script>

<script>
function show_name(){
	
var	opportunity_id = document.getElementById("opportunity_id").value;
var person_name = document.getElementById("person_name").value;
var activity_visit = document.getElementById("activity_visit").value;
var contact_no = document.getElementById("contact_no").value
var visit_date = document.getElementById("visit_date").value;
var visit_remarks = document.getElementById("visit_remarks").value;

	if(person_name==""){
			alert("Error: Please Enter Person Name");
			return false;
		}

	if(activity_visit==""){
			alert("Error: Please Enter Visit Details");
			return false;
		}

	if(contact_no==""){
			alert("Error: Please Select Responsible Owner");
			return false;
		}

	if(visit_date==""){
			alert("Error: Please Select Visit Date");
			return false;
		}

	if(visit_remarks==""){
			alert("Error: Please Enter Visit Remarks");
			return false;
		}


 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("visit_plan").innerHTML =
      this.responseText;
    }
  };
 
xhttp.open("GET","visit_plan.php?opportunity_id="+opportunity_id+"&activity_visit="+activity_visit+"&person_name="+person_name+"&contact_no="+contact_no+"&visit_date="+visit_date+"&visit_remarks="+visit_remarks,true);
  xhttp.send();
}
</script>




<script type="text/javascript">
        function codeAddress() {
				$("#p").hide();	

           if(document.getElementById("move").checked==true && document.getElementById("remarks").value==''){
				$("#p").show();
			}else{
				$("#p").hide();	
			}


           if(document.getElementById("lost").checked==true){
				$("#p").show();
			}
       
			$("#move").click(function(){
				$("#p").hide();
			});
  
			$("#lost").click(function(){
				$("#p").show();
			});
	   
	    }
        window.onload = codeAddress;
        </script>
        
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box green tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Supply Plan</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
<?php /*?>                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
<?php */?>                      <?php /*?><li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Project Action Plan</a></li><?php */?>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Supply Plan</a></li>			
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
                                            <th>Account Name</th>
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
			d.opportunity_id,
			d.lead_id,
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
			d.[status]
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
						</table><hr>

					
            
<table width="100%" border="1">
	<tr height="25">
<th colspan="11" style="background-color:#50aa48; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Won Product List</th>
								</tr>
 										<tr>
									<th width="4%">FLD ID</th>
									<th width="4%">Plant</th>
                                    <th width="5%">SKU Size</th>
									<th width="7%">Tile Category</th>
                                    <th width="10%">Final Tile Name</th>
                                    <th width="4%">Final Qty</th>
                                    <th width="7%">Final BID Price</th>                                    
                                    
                               </tr>
								<?php 
                                //echo 'hello';
                                //print_r($_SESSION);

                                 $ssql="select * from fld where opp_id='".$_SESSION['supply_lead_id']."' ";	
                                $rs=odbc_exec($conn,$ssql);
                                 $vv=odbc_num_rows($rs);
                                $_SESSION['atc']=$vv;
            while($f = odbc_fetch_array($rs)){
                                //print_r($f);
            	/*$count = 1;*/
								$av=$f['fld_id'];
                                echo '<tr align="center">';
								echo '<td>'.$f['fld_id'].'</td>';
								echo '<td>'.$f['d_location'].'</td>';
                                echo '<td>'.$f['size'].'</td>';
								echo '<td>'.strtoupper($f['sample_tile_cateroty']).'</td>';

								$tilename=(!empty($f['final_tile_name'])?$f['final_tile_name']:$f['approved_tile_name']);
								echo '<td>'.strtoupper($tilename).'</td>';

								$finalqty=(!empty($f['final_qty'])?$f['final_qty']:$f['qty']);
                                echo '<td>'.$finalqty.'</td>';
								//echo '<td>'.strtoupper($f['obl_bid_price']).'</td>';

                     $assql="select top 1 negotiation_price from negotiation where fld_id='".$f['fld_id']."' order by negotiation_last_updated desc";	
                      $ars=odbc_exec($conn,$assql);
					  $af = odbc_fetch_array($ars);

					$finalprice=(!empty($af['negotiation_price'])?$af['negotiation_price']:$f['obl_bid_price']);
							echo '<td>'.$finalprice.'</td>';
						//if(!empty($af['negotiation_price'])){
							//echo '<td>'.$af['negotiation_price'].'</td>';
						//}else{
						//	echo '<td>N/A</td>';
						//}
		/*$count++;*/				
}

?>            
            


                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" >
                                    <input type="hidden" name="pid" value="<?php echo $pid?>">

                                                    
                             <table border="0" style="width:100%" align="center">

                              	<tr height="25">
<th colspan="11" style="background-color:#FF9900; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Add Order Supply Plan Details</th><br>
								</tr>
                               


                                 <tr height="50">
                                	
                                    
                                    <th width="10%"> SKU Size</th>
                                    <td width="10%">
                                    <select name="spare_part_id" style="width:120px;"  onChange="display(this.value)" id="spare_part_id">
                                       		<option value="">-Select Size -</option>
											<option value="Not Specified">Not Specified</option>
                                             <?php
									$ssql="select distinct (size) from fld where opp_id='".$_REQUEST['pid']."' and approved='yes' ";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$ss=($f['size']==$dataArray['size'])?'selected':'';
										echo '<option value="'.$f['size'].'" '.$ss.'>'.$f['size'].' </option>';
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
			<th colspan="4" style="background-color:#FF9900; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Complete Supply Plan </th>
								</tr>
                                           
                                <tr>
                                       <td colspan="4">
                                			<div id="add_to_cart_data"><?php include('supply_add_to_cart_data.php');?></div>       
                                       </td>
                                </tr>
                                       
                                       </table>
                                    </td>
                                </tr>


							</table>
                            

									<div  style="text-align:right;">
                                    
                                    <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
                                    
			                       
                        
                          
										<a href="list-won-opportunity.php"> 
                                        <input type="button" value="Back">
                                        </a>

                                    </div>
                             </form>
                            

                     <!-- Adding Visit Details Start -->
	
					<!-- <h3>Add Visit Details</h3> -->
					<h3><br></h3>
                             
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
      <input type="text" style="width:250px; resize:none;" name="activity_visit" id="activity_visit">
	</th>              
      

			<th>
      <input type="text" style="width:250px; resize:none;" name="person_name" id="person_name">
	</th>         

	
	<th>
      <input type="number" style="width:250px; resize:none;" name="contact_no" id="contact_no">
	</th>    
            
 	<th>
      <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="visit_date"  id="visit_date" style="width:130px; "/>
	</th>    

 	<th>
      <input type="text" style="width:250px;  resize:none;" name="visit_remarks" id="visit_remarks">
	</th>    

    <td>
   
   <input type="button" value="add"  onclick="show_name();"/>
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

                     <!-- Visit Details End --> 
                        
                        
                                 <!-- tab 1, asset detail ends -->  
                              </div>
                                
                                 <!--#################### purchase details part start tab2 ##############################-->  
                                 <!-- tab 2, purchase detail-->  
                              <div class="tab-pane " id="portlet_tab2">
                                   
                                    <?php 
										//print_r($_SESSION);
										if($vv > 0){

									?>
								
							<?php include_once("project-action-plan.php")?>


                                 <?php } else { echo '<h3 align="center"><font color="#F00A0E">Error: Please Submit First Level Discussion to Avtivate Project Action Plan</font></h3>'; } ?>

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