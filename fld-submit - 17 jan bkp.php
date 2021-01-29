<?php 
	        $pm='active';
	        $fld='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['fld_leadID']=$_REQUEST['pid'];

//action plan_project_session_id
	$_SESSION['action_plan_opp_id']=$_REQUEST['pid'];
	
//print_r($_SESSION);
//asset part starts

//print_r($_POST);

$errorArray=array();
$dataArray=array();
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];		

if(isset($_POST['submit'])){
	
	$dataArray=array(
		'status' 				=> $_POST['status'],
		'lost_by' 				=> $_POST['lost_by'],
		'reason_for_lost' 		=> $_POST['reason_for_lost'],
		'remarks'				=> $_POST['remarks']
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

// Date checking
//	if($dataArray['status']=='close' && $_SESSION['atc']=='0'){
//		$errorArray['remarks']='<br> Error: Please Add At Least 1 SKU Detail Before Submit<br>';
//	}



  if(empty($errorArray)){
	
	 if(isset($pid) && $pid>0){

		 $upd  ="UPDATE opportunity set  ";
		 
		 if($dataArray['status'] =='lost'){
					 $upd .=" status='lost', lost_date= '".dbInput($timestamp)."', lost_by= '".dbInput($dataArray['lost_by'])."', reason_for_lost= '".dbInput($dataArray['reason_for_lost'])."', lost_remarks= '".dbInput($dataArray['remarks'])."'	 ";
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

<script type="text/javascript" src="spare_part.js"></script>
<script type="text/javascript" src="add_to_cart_data.js"></script>
<script type="text/javascript" src="delete_from_cart_data.js"></script>


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
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">First Level Discussion</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
<?php /*?>                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
<?php */?>                      <li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Project Action Plan</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">First Level Discussion</a></li>			
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
										//echo '<td>'.$f['opportunity_id'].'</td>';
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

                        <table border="0" width="100%">
                        <tr align="left" height="40">
                     
                        	<td align="left" >
                            	
                                       <label class="control-label" style="text-align:left;"><b>Status:</b></label>
                                       <div class="controls">
										<?php $open=($dataArray['status']=='open')?'checked':''; ?>
   										<?php $close=($dataArray['status']=='close')?'checked':''; ?>
    									<?php $lost=($dataArray['status']=='lost')?'checked':''; ?>

										
                                         <label class="radio">
                                          <input type="radio" name="status" value="close" <?php echo $close ?> required id="move"/>
                                          <span style="font-weight:bold; color:#0C3">Deal Qualified</span>
                                          </label>
                                          
                                  <label class="radio">
                                   <input type="radio" name="status" value="lost" <?php echo $lost ?> required id="lost" />
                                           <span style="font-weight:bold; color:#F00">Deal Lost</span>
                                          </label>  
                                    
                                       </div>
                            </td>
                        </tr>
                        
                        <tr align="left" height="60" id="p">
                        	<td align="left" width="10%">
						&nbsp;	&nbsp;
                        <b>Lost By:</b>
                        <select name="lost_by"  style="width:150px;">
								<option value="">-Select-</option>
    <option value="Kajaria" <?php echo ($dataArray['lost_by']=='Kajaria')?'selected': ''?>>Kajaria</option>
    <option value="Somany" <?php echo ($dataArray['lost_by']=='Somany')?'selected': ''?>>Somany</option>
    <option value="AGL" <?php echo ($dataArray['lost_by']=='AGL')?'selected': ''?>>AGL</option>
    <option value="Jhonson" <?php echo ($dataArray['lost_by']=='Jhonson')?'selected': ''?>>Jhonson</option>
    <option value="Varmora" <?php echo ($dataArray['lost_by']=='Varmora')?'selected': ''?>>Varmora</option>
    <option value="Sun Heart" <?php echo ($dataArray['lost_by']=='Sun Heart')?'selected': ''?>>Sun Heart</option>
    <option value="Simpolo"  <?php echo ($dataArray['lost_by']=='Simpolo')?'selected': ''?>>Simpolo</option>
    <option value="RAK" <?php echo ($dataArray['lost_by']=='RAK')?'selected': ''?>>RAK</option>    
    <option value="Cera" <?php echo ($dataArray['lost_by']=='Cera')?'selected': ''?>>Cera</option>    
    <option value="Swastik Tiles" <?php echo ($dataArray['lost_by']=='Swastik Tiles')?'selected': ''?>>Swastik Tiles</option>    
    <option value="Vita Tiles" <?php echo ($dataArray['lost_by']=='Vita Tiles')?'selected': ''?>>Vita Tiles</option>
    <option value="Local Morbie" <?php echo ($dataArray['lost_by']=='Local Morbie')?'selected': ''?>>Local Morbie</option>
    
                            </select>
                           
						&nbsp;	&nbsp;   
                         <b>Reason for Lost:</b>
                            <select name="reason_for_lost"  style="width:150px;">
                                    <option value="">-Select-</option>
    <option value="High price" <?php echo ($dataArray['reason_for_lost']=='High price')?'selected': ''?>>High price</option>
    <option value="Design Rejected" <?php echo ($dataArray['reason_for_lost']=='Design Rejected')?'selected': ''?>>Design Rejected</option>
    <option value="Size Unavailable" <?php echo ($dataArray['reason_for_lost']=='Size Unavailable')?'selected': ''?>>Size Unavailable</option>
    <option value="Loss to Retail" <?php echo ($dataArray['reason_for_lost']=='Loss to Retail')?'selected': ''?>>Loss to Retail</option>
    <option value="Payment Terms Issue" <?php echo ($dataArray['reason_for_lost']=='Payment Terms Issue')?'selected': ''?>>Payment Terms Issue</option>
    <option value="GPS Approval Issue" <?php echo ($dataArray['reason_for_lost']=='GPS Approval Issue')?'selected': ''?>>GPS Approval Issue</option>
    <option value="Architect/Project Approval Issue" <?php echo ($dataArray['reason_for_lost']=='Architect/Project Approval Issue')?'selected': ''?>>Architect/Project Approval Issue</option>
    <option value="Issue from previous supply" <?php echo ($dataArray['reason_for_lost']=='Issue from previous supply')?'selected': ''?>>Issue from previous supply</option>
    <option value="Complaints in product" <?php echo ($dataArray['reason_for_lost']=='Complaints in product')?'selected': ''?>>Complaints in product</option>
	<option value="Invalid Lead" <?php echo ($dataArray['reason_for_lost']=='Invalid Lead')?'selected': ''?>>Invalid Lead</option>

	</select>
                                
							&nbsp;	&nbsp;
							<b>Lost Remarks:</b>
								<textarea style="width:400px;; height:20px;" id="remarks" name="remarks"></textarea>
                        <div style="color:#F00; font-size:15px; text-align:left"><b><br /><?php echo $errorArray['remarks']?></b><br /><br /></div>
                            </td>
                        </tr>
                        
                        
                        </table>
                       
                         
                            
                             <table border="0" style="width:100%" align="center">

                              	<tr height="25">
<th colspan="11" style="background-color:#009999; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Add Product Details </th>
								</tr>
                               


                                 <tr height="50">
                                	
                                    
                                    <th width="10%"> SKU Size</th>
                                    <td width="10%">
                                    <select name="spare_part_id" style="width:160px;"  onChange="display(this.value)" id="spare_part_id">
                                       		<option value="">-Select Size -</option>
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
                                    
			                        <input type="submit" name="submit" value="Submit FLD" >
                        
                          
										<a href="first-level-discussion.php"> 
                                        <input type="button" value="Back">
                                        </a>

                                    </div>
                             </form>
                             
                        
                        
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