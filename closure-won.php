<?php 
	        $pm='active';
	        $cw='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['fld_leadID']=$_REQUEST['pid'];

//action plan_project_session_id
	$_SESSION['action_plan_opp_id']=$_REQUEST['pid'];
	
//print_r($_SESSION);
//asset part starts
//echo '<pre>';
//print_r($_POST);

//echo $_POST['final_qty']['1120'];

//$finalarray=array();


$errorArray=array();
$dataArray=array();
$timestamp=date('Y-m-d H:i:s');

$pid=(int)$_REQUEST['pid'];		

if(isset($_POST['formsubmit'])){
$dataArray=array(
		'po_value' 					=> $_POST['po_value'],
		'payment_terms'				=> $_POST['payment_terms'],
		'billing_customer_name'		=> $_POST['billing_customer_name'],
		'2nd_lowest_bid'			=> $_POST['2nd_lowest_bid'],
		'closure_won_remarks'		=> $_POST['closure_won_remarks']
	);

// Date checking
	if(empty($dataArray['po_value'])){
		$errorArray['po_value']='Error: Please Enter PO Value';
	}

// Date checking
	if(empty($dataArray['payment_terms'])){
		$errorArray['payment_terms']='Error: Please Enter Payment Terms Value';
	}

// Date checking
	if(empty($dataArray['billing_customer_name'])){
		$errorArray['billing_customer_name']='Error: Please Billing Customer Name';
	}

// Date checking
//	if(empty($dataArray['2nd_lowest_bid'])){
//		$errorArray['2nd_lowest_bid']='Error: Please Enter 2nd Lowest BID';
//	}

	/*$count = "select * from fld where opp_id = '$pid'";
	$rs_count=odbc_exec($conn,$count);*/
	/*print_r(odbc_num_rows($rs_count));
	exit();*/
 



  if(empty($errorArray)){
	
	 if(isset($pid) && $pid>0){

		$upd  =" UPDATE opportunity set current_stage='7' , status='close' , closure_won_date='".dbInput($timestamp)."', last_modified='".dbInput($timestamp)."' ";
		 
		$upd .=" , won_po_value='".dbInput($dataArray['po_value'])."', won_payment_terms='".dbInput($dataArray['payment_terms'])."' ,
cw_remark='".dbInput($dataArray['closure_won_remarks'])."' ";
				
		$upd .=" , won_billing_customer_name='".dbInput($dataArray['billing_customer_name'])."', 
		won_2nd_lowest_bid='".dbInput($dataArray['2nd_lowest_bid'])."' ";
		 				
	$upd .=" where opportunity_id='".(int)dbInput($pid)."'";

		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
		odbc_execute($stmt);

			//final tile & qty change start	
						$fchk=0;
						foreach($_POST['fldidcheck'] as $ftn){
							//echo '<br>';
							//echo $ftn.'-';
							$_POST['final_tile_name'][$ftn];
							$_POST['final_qty'][$ftn];
							
							$updt=" update fld set final_tile_name='".$_POST['final_tile_name'][$ftn]."' , final_qty='".$_POST['final_qty'][$ftn]."' where fld_id = '".$ftn."' ";

							$stmt1 = odbc_prepare($conn, $updt);
							$final_execute = odbc_execute($stmt1);
							
							$fchk++;
						}
						
			//final tile & qty change ends
				if ($final_execute){ 
					$msgTxt = ' Project WON Details Has Been Updated Successfully.';
					$msgType = 1;

				}else{
					$msgTxt = 'Sorry! Unable To Update WON Details, Please Try Later.';
					$msgType = 2;
				}
		}
			header('Location:list-won-opportunity.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
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
                  <div class="portlet box green tabbable">
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
			b.deal_type,
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
			left join deal_type b on b.deal_type_id = d.deal_type
			left join project_type_master c on c.project_type_id = d.project_type_id
			left join state_master e on e.state_id = d.state_id
			where d.opportunity_id = '".$_REQUEST['pid']."'
		";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
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
									}
									?>
									</tbody>
						</table>
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" name="myform" >
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 


		<table border="0" width="100%" align="center">

                        <tr align="left" height="40">
                        	<th align="left" >PO Value</th>
							<td align="left" ><input type="number" name="po_value" / required="required"></td>
                       
                        	<th align="left" >Payment Terms</th>
							<td align="left" >
                            <select name="payment_terms" required="required">
								<option value="">-Select-</option>
								<option value="Credit">Credit</option>
								<option value="Cash">Cash</option>                                                                
                            </select>
                            </td>
                        </tr>


                        <tr align="left" height="40">
                        	<th align="left" >Billing Customer Name</th>
							<td align="left" ><input type="text" name="billing_customer_name" / required="required"></td>
                       
                        	
							<th align="left" >Closure Won Remarks</th>
							<td align="left" ><input type="text" name="closure_won_remarks" / required="required"></td>
                        </tr>
		</table>



                             <table border="1" style="width:100%" align="center">

                              	<tr height="25">
			<th colspan="11" style="background-color:#009933; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">List of Requirements </th>
								</tr>

								<tr>
									<th width="4%">FLD ID</th>
									<th width="4%">Plant</th>
                                    <th width="5%">SKU Size</th>
                                    <th width="4%">Qty(SQMT)</th>
                                    <th width="5%">Competitor</th>
									<th width="7%">Tile Category</th>
                                    <th width="10%">Approved Tile Name</th>
                                    <th width="7%">Final Price/SQMT</th>                                    
                                    <th width="5%">Final Tile Name</th>                                    
                                    <th width="5%">Final Qty(SQMT)</th>   
                                    
                               </tr>
								<?php 
                                //echo 'hello';
                                //print_r($_GET);

                                 $ssql="select * from fld where opp_id='".$_SESSION['fld_leadID']."'  and approved='yes' ";	
                                $rs=odbc_exec($conn,$ssql);
                                 $vv=odbc_num_rows($rs);
                                $_SESSION['atc']=$vv;
            while($f = odbc_fetch_array($rs)){
                                //print_r($f);
								$av=$f['fld_id'];
                                echo '<tr align="center">';
								echo '<td>'.$f['fld_id'].'</td>';
								echo '<td>'.$f['d_location'].'</td>';
                                echo '<td>'.$f['size'].'</td>';
                                echo '<td>'.$f['qty'].'</td>';
                                echo '<td>'.$f['competitor'].'</td>';
								echo '<td>'.strtoupper($f['sample_tile_cateroty']).'</td>';
								echo '<td>'.strtoupper($f['approved_tile_name']).'</td>';
								echo '<td>'.round(strtoupper($f['obl_bid_price']),2).'</td>';

                     /* $assql="select top 1 negotiation_price from negotiation where fld_id='".$f['fld_id']."' order by negotiation_last_updated desc";	
                      $ars=odbc_exec($conn,$assql);
					  $af = odbc_fetch_array($ars);
						if(!empty($af['negotiation_price'])){
							echo '<td>'.$af['negotiation_price'].'</td>';
						}else{
							echo '<td>N/A</td>';
						}*/

						echo "<td>
						<input type=hidden name=fldidcheck[$av] value=$av>
						<input type=text name=final_tile_name[$av] required>
						</td>";
						echo "<td><input type=number name=final_qty[$av] style=width:60px; required></td>";
			}

                                ?>
							</table>
									<div  style="text-align:right;">
                                   <input type="hidden" name="formsubmit" /> 
                                    <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
                                    <?php 
										//print_r($_SESSION);
										if($vv > 0){

									?>

					                    <button type="submit" class="btn green"><i class="icon-ok"></i> Submit</button>
					                    <button type="button" class="btn">Cancel</button>

					                    <?php } else{
					                    	echo '<h4 align="center"><font color="#F00A0E"><b>Error: Please Add Atleast One Product in Discussion to Won/Lost the Lead</b></font></h4>';
					                    }

					                     ?>
                                       

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