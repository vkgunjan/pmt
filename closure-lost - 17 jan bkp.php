<?php 
	        $pm='active';
	        $cl='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['fld_leadID']=$_REQUEST['pid'];

//action plan_project_session_id
	$_SESSION['action_plan_opp_id']=$_REQUEST['pid'];
	
	
//print_r($_SESSION);
//asset part starts
//echo '<pre>';
//print_r($_POST);

$errorArray=array();
$dataArray=array();
$timestamp=date('Y-m-d H:i:s');

$pid=(int)$_REQUEST['pid'];		

if(isset($_POST['formsubmit'])){
$dataArray=array(
		'lost_by' 					=> $_POST['lost_by'],
		'reason_for_lost'			=> $_POST['reason_for_lost']
	);

// Date checking
	if(empty($dataArray['lost_by'])){
		$errorArray['lost_by']='Error: Please Secect Lost By';
	}

// Date checking
	if(empty($dataArray['reason_for_lost'])){
		$errorArray['reason_for_lost']='Error: Please Enter Reason for Lost';
	}

//print_r($errorArray);

  if(empty($errorArray)){
	
	 if(isset($pid) && $pid>0){

		$upd  =" UPDATE opportunity set status='lost', lost_date= '".dbInput($timestamp)."', lost_by= '".dbInput($dataArray['lost_by'])."',  
				lost_remarks= '".dbInput($dataArray['reason_for_lost'])."' ";		 				
		$upd .=" where opportunity_id='".(int)dbInput($pid)."'";

		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Opportunity Lost Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Opportunity Lost Details, Please Try Later.';
					$msgType = 2;
				}
		}
	
				header('Location:list-lost-opportunity.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;

	}

}


?>

<script type="text/javascript" src="spare_part.js"></script>
<script type="text/javascript" src="add_to_cart_data.js"></script>
<script type="text/javascript" src="delete_from_cart_data.js"></script>

           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box red tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Closure Won</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
<?php /*?>                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
<?php */?>                      <li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Project Action Plan</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Closure Won</a></li>			
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
                                       		 <th>Lead ID</th>
                                             <th>CKA Name</th>
											<th >CKA Type</th>
											<th >Project Type</th>
											<th >Project Name</th>
											<th >State</th>
											<th >City</th>
                                            <th >Architect Name</th>
                                            <th>Tile Stage Date</th>
                                            <th>Sale Forecast(INR)</th>
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
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$f['opportunity_id'].'</td>';
										echo '<td>'.$f['cka_name'].'</td>';
										echo '<td>'.$f['cka_type'].'</td>';										
										echo '<td >'.$f['project_type'].'</td>';																
										echo '<td>'.ucfirst($f['project_name']).'</td>';	
										echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.$f['city'].'</td>';
										echo '<td>'.$f['architect_name'].'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['tile_stage_date'])).'</td>';
										echo '<td>'.$f['obl_sale_forecast_inr'].'</td>';
										
										$safty_caution=$f['safty_caution'];	
										$workorder_start_time=$f['workorder_start_time'];
										$work_description=$f['work_description'];
										$workorder_priority=$f['workorder_priority'];
										$engineer=$f['work_order_engineer_id'];
										$workorder_start_date=$f['workorder_start_date'];
										$wo_completion_description=$f['wo_completion_description'];
									}
									?>
									</tbody>
						</table>
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" name="myform" >
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 


<table border="0" width="100%" align="center" style="font:14px Verdana, Geneva, sans-serif; ">

                        <tr align="left" height="60">

                        	<th align="left" width="10%">Lost By:</th>
							<td align="left" width="20%">
                            <select name="lost_by" required="required" style="width:170px;">
								<option value="">-Select-</option>
								<option value="Kajaria">Kajaria</option>
								<option value="Somany">Somany</option>                                                                
								<option value="Somany">AGL</option>                                                                
								<option value="Somany">Jhonson</option>                                                                
								<option value="Somany">Varmora</option>                                                                
								<option value="Somany">Sun Heart</option>                                                                
								<option value="Somany">Simpolo</option>                                                                
								<option value="Somany">RAK</option>                                                                
								<option value="Somany">Cera</option>                                                                
								<option value="Somany">Swastik Tiles</option>                                                                
								<option value="Somany">Vita Tiles</option>
                                <option value="Somany">Local Morbie</option>                                                                
                                                                                                
                            </select>
                            </td>

                        	<th align="left" width="15%" >Reason for Lost:</th>
							<td align="left" width="45%" >
                                <select name="reason_for_lost" required="required" style="width:270px;">
                                    <option value="">-Select-</option>
                                    <option value="High prise">High prise</option>
                                    <option value="Design Rejected">Design Rejected</option>
                                    <option value="Size Unavailable">Size Unavailable</option>
                                    <option value="Loss to Retail">Loss to Retail</option>
                                    <option value="Payment Terms Issue">Payment Terms Issue</option>
                                    <option value="GPS Approval Issue">GPS Approval Issue</option>
                                    <option value="Architect/Project Approval Issue">Architect/Project Approval Issue</option>
                                    <option value="Issue from previous supply">Issue from previous supply</option>
                                    <option value="Complaints in product">Complaints in product</option>
									<option value="Invalid Lead">Invalid Lead</option>
										
                                </select>
                            </td>

                        </tr>
		</table>

                             <table border="1" style="width:100%;" align="center">

                              	<tr height="25">
			<th colspan="11" style="background-color:#E02222; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">List of Requirements </th>
								</tr>


								<tr>
									<th width="5%">FLD ID</th>
                                    <th width="6%">SKU Size</th>
                                    <th width="5%">Qty</th>
                                    <th width="10%">Competitor</th>
                                    <th width="5%">No.of SKU</th>
									<th width="7%">Tile Category</th>
                                    <th width="10%">Approved Tile Name</th>
                                    <th width="5%">OBL BID Price</th>                                    
                                    <th width="5%">Final BID Price</th>                                    
                               </tr>
								<?php 
                                //echo 'hello';
                                //print_r($_GET);

                                 $ssql="select * from fld where opp_id='".$_SESSION['fld_leadID']."' and sampling='yes' and approved='yes' ";	
                                $rs=odbc_exec($conn,$ssql);
                                 $vv=odbc_num_rows($rs);
                                $_SESSION['atc']=$vv;
            while($f = odbc_fetch_array($rs)){
                                //print_r($f);
								$av=$f['fld_id'];
                                echo '<tr align="center">';
								echo '<td>'.$f['fld_id'].'</td>';
                                echo '<td>'.$f['size'].'</td>';
                                echo '<td>'.$f['qty'].'</td>';
                                echo '<td>'.$f['competitor'].'</td>';
								echo '<td>'.$f['no_of_samples_given'].'</td>';
								echo '<td>'.strtoupper($f['sample_tile_cateroty']).'</td>';
								echo '<td>'.strtoupper($f['approved_tile_name']).'</td>';
								echo '<td>'.strtoupper($f['obl_bid_price']).'</td>';

                      $assql="select top 1 negotiation_price from negotiation where fld_id='".$f['fld_id']."' order by negotiation_last_updated desc";	
                      $ars=odbc_exec($conn,$assql);
					  $af = odbc_fetch_array($ars);
						if(!empty($af['negotiation_price'])){
							echo '<td>'.$af['negotiation_price'].'</td>';
						}else{
							echo '<td>N/A</td>';
						}
			}

                                ?>
							</table>
									<div  style="text-align:right;">
                                   <input type="hidden" name="formsubmit" /> 
                                    <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
                                    
					                    <button type="submit" class="btn red"><i class="icon-ok"></i> Submit</button>
                                       <button type="button" class="btn">Cancel</button>

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