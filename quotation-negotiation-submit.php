<?php 
	        $pm='active';
	        $qn='active';
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
//print_r($_POST['sampling']);

$dataArray=array(
		'status' 				=> $_POST['status'],
		'lost_by' 				=> $_POST['lost_by'],
		'reason_for_lost' 		=> $_POST['reason_for_lost'],
		'remarks'				=> $_POST['lost_remark'],
		'qt_remark'				=> $_POST['qt_remark']
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
	
	if($dataArray['status']=='close' && empty($dataArray['qt_remark'])){
	
		$errorArray['qt_remark']='Error: Please Enter Quotation Remarks';
	}
	
	
if(empty($errorArray)) {
	
	 if(isset($pid) && $pid>0){

		 $upd2  ="UPDATE opportunity set  ";
		 
		 if($dataArray['status'] =='lost') {
					 $upd2 .=" status='lost', lost_date= '".dbInput($timestamp)."', lost_by= '".dbInput($dataArray['lost_by'])."', reason_for_lost= '".dbInput($dataArray['reason_for_lost'])."', lost_remark= '".dbInput($dataArray['remarks'])."'	 ";
				}

		
		 if($dataArray['status'] =='close'){
					 $upd2.=" quotation_status='1' , quotation_date='".dbInput($timestamp)."', qt_remark= '".dbInput($dataArray['qt_remark'])."' ";
				}
				
		 $upd2 .=" where opportunity_id='".(int)dbInput($pid)."'";

		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd2);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Pricing details has been Updated Successfully. Waiting for Approval.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Pricing Information , Please Try Later.';
					$msgType = 2;
				}
		}


$ssql="select * from fld where opp_id='".$_SESSION['fld_leadID']."'";	
$rs=odbc_exec($conn,$ssql);
$vv=odbc_num_rows($rs);


	while($f = odbc_fetch_array($rs)){
	//print_r($f);
	$av=$f['fld_id'];

		if(count($_POST['sampling'])>=0){
			$tick='';
			foreach($_POST['sampling'] as $sd)
				if($sd==$f['fld_id']){
					$tick='checked';
				}
		}
							
	//echo $sd;
		//echo $tick;					
								
		foreach($_POST['no_of_sku'] as $key => $nsku){
			if($key==$av){
				if(empty($_POST['no_of_sku'][$av]) && $tick=='checked'){
					$c='red';
					$skucheck++;
				}else{
					$c='';
				}
			}
		}

                              
		

	}//while closure

//echo '<br>';
//echo 'nosku-'.$skucheck;
//echo '<br>';
//echo 'tcat-'.$tcat;


	if($skucheck+$tcat>=1){
		$error='Form not completed...Error';
	}else{
		
		// updation process start 
		
		//print_r($_POST);
			$fchk=0;
			foreach($_POST['sampling'] as $sd){
				//echo $sd;
				$_POST['no_of_sku'][$sd];
				$_POST['tile_category'][$sd];

				 $upd="update fld set previous_bid_price='".$_POST['no_of_sku'][$sd]."',final_bid_price='".$_POST['no_of_sku'][$sd]."', status='1'  
					  where fld_id='".$sd."' ";
					
					$stmt = odbc_prepare($conn, $upd);

				if (odbc_execute($stmt)){ 
					$msgTxt = ' OBL BID Price Tile Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update BID Price Details, Please Try Later.';
					$msgType = 2;
					$fchk++;
				}
			}// main foreach ends
				//echo 'vin-'.$fchk;

				if(!$fchk){
				
				echo $upd1= "update opportunity set  
						quotation_date='".dbInput($timestamp)."'  
						where opportunity_id='".$_SESSION['fld_leadID']."' ";
				
						$stmt1 = odbc_prepare($conn, $upd1);

						if (odbc_execute($stmt1)){ 
							$msgTxt = ' BID Price Details Has Been Updated Successfully.';
							$msgType = 1;
						}else{
							$msgTxt = 'Sorry! Unable To Update BID Price Details, Please Try Later.';
							$msgType = 2;
							$fchk++;
						}
				}else{
					echo 'Something Went Wrong Please Contact to Administrator';
				}
		//updation process ends

			header('Location:quotation-negotiation.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			exit;

	}

}

}


?>

<script type="text/javascript" src="spare_part.js"></script>
<script type="text/javascript" src="add_to_cart_data.js"></script>
<script type="text/javascript" src="delete_from_cart_data.js"></script>

<script type="text/javascript">
function submitform()
{
 
 
 var checkboxs=document.getElementsByName("sampling[]");
    var okay=0;
    for(var i=0,l=checkboxs.length;i<l;i++)
    {
        if(checkboxs[i].checked)
        {
            okay++;
	    }
    }
   
   if(okay == checkboxs.length){
	  document.myform.submit();
   }
	else{
	 alert("Please Select SKU to enter Bid Price.");
	 return false;
	}
	
}
</script>

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
                           <span class="hidden-480">Pricing</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
<?php /*?>                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
<?php */?>                      <li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Project Action Plan</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Pricing</a></li>			
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
										$quotation_status = $f['quotation_status'];
										//print_r($f);
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
									}
									?>
									</tbody>
						</table>

						<?php 
				if ($quotation_status == 0) { ?>
						
					<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" onsubmit="return submitform()">
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
                                          <span style="font-weight:bold; color:#0C3">Pricing Remarks</span>
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
						<br/>
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
    <option value="Price" <?php echo ($dataArray['reason_for_lost']=='Price')?'selected': ''?>>Price</option>
    <option value="Payment terms" <?php echo ($dataArray['reason_for_lost']=='Payment terms')?'selected': ''?>>Payment terms</option>
    <option value="Credit Period" <?php echo ($dataArray['reason_for_lost']=='Credit Period')?'selected': ''?>>Credit Period</option>
    <option value="Design Issue" <?php echo ($dataArray['reason_for_lost']=='Design Issue')?'selected': ''?>>Design Issue</option>
    <option value="Size Unavailability" <?php echo ($dataArray['reason_for_lost']=='Size Unavailability')?'selected': ''?>>Size Unavailability</option>
    <option value="Complaint in previous supply" <?php echo ($dataArray['reason_for_lost']=='Complaint in previous supply')?'selected': ''?>>Complaint in previous supply</option>
    <option value="Architect Approval" <?php echo ($dataArray['reason_for_lost']=='Architect Approval')?'selected': ''?>>Architect Approval</option>
    <option value="SKU Approval" <?php echo ($dataArray['reason_for_lost']=='SKU Approval')?'selected': ''?>>SKU Approval</option>
    <option value="GPS Approval" <?php echo ($dataArray['reason_for_lost']=='GPS Approval')?'selected': ''?>>GPS Approval</option>
	<option value="Relation with Purchaser" <?php echo ($dataArray['reason_for_lost']=='Relation with Purchaser')?'selected': ''?>>Relation with Purchaser</option>
	<option value="Lead info. Not appropriate" <?php echo ($dataArray['reason_for_lost']=='Lead info. Not appropriate')?'selected': ''?>>Lead info. Not appropriate</option>
	<option value="Redundant/To be deleted" <?php echo ($dataArray['reason_for_lost']=='Redundant/To be deleted')?'selected': ''?>>Redundant/To be deleted</option>

	</select>
                                
							&nbsp;	&nbsp;
							<b>Lost Remarks:</b>
								<textarea style="width:400px;; height:20px;" id="remarks" name="lost_remark"></textarea>
                        <div style="color:#F00; font-size:15px; text-align:left"><b><br /><?php echo $errorArray['remarks']?></b><br /><br /></div>
                            </td>
                        </tr>


         <tr align="left" height="60" id="q">
                        	<td align="left" width="10%">
						&nbsp;	&nbsp;
                        
                           
						 <br/>
                         
                                
							
							<b>Remarks:</b>
								<textarea style="width:400px;; height:20px;" id="qt_remark" name="qt_remark"></textarea>
                        <div style="color:#F00; font-size:15px; text-align:left"><b><br /><?php echo $errorArray['qt_remark']?></b><br /><br /></div>
                            </td>
                        </tr>
                        
                        
                        </table>

                    <?php 	} ?>
						
						
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" name="myform" >
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 

                             <table border="1" style="width:100%" align="center">


                              	<tr height="25">
			<th colspan="13" style="background-color:#FF9900; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Requirements Details </th>
								</tr>


								<tr>
									<th>FLD ID</th>
                                    <th>SKU Size</th>
                                    <th>Qty</th>
                                    <th>Competitor</th>
                                    
									<th>Tile Category</th>
									<th>Initial BID Price</th>
									<th>Final BID Price</th>
                                    <th>Approved Tile Name</th>
                                    <?php
                                    $qts="select * from opportunity where opportunity_id='".$_SESSION['fld_leadID']."' ";	
                                $qs=odbc_exec($conn,$qts);
                                 while($q = odbc_fetch_array($qs)){
                                 	$qt_status = $q['quotation_status'];
                                 }

                                    	if ($qt_status == '0') { ?>
                                    <th>Quotation / BID Given <br>(Yes/No)</th>
									<th>BID Rate <br>(Ex.Fac / SQMT)</th>
                                   <?php 	}

                                    ?>
									
                               </tr>
								<?php 
                                //echo 'hello';
                                //print_r($_GET);

                                 $ssql="select * from fld where opp_id='".$_SESSION['fld_leadID']."' ";	
                                $rs=odbc_exec($conn,$ssql);
                                 $vv=odbc_num_rows($rs);
                                $_SESSION['atc']=$vv;
                                while($f = odbc_fetch_array($rs)){
                                //print_r($f);
								$av=$f['fld_id'];
								$obl_bid_price = $f['obl_bid_price'];
                                echo '<tr align="center">';
								echo '<td>'.$f['fld_id'].'</td>';
                                echo '<td>'.$f['size'].'</td>';
                                echo '<td>'.$f['qty'].'</td>';
                                echo '<td>'.$f['competitor'].'</td>';
								/*echo '<td>'.$f['no_of_samples_given'].'</td>';*/
								echo '<td>'.strtoupper($f['sample_tile_cateroty']).'</td>';
								if(empty($f['previous_bid_price'])){
									$previous_bid_price = "N/A";
								}else{
									$previous_bid_price = $f['previous_bid_price'];
								}
								echo '<td>'.$previous_bid_price.'</td>';
								if(empty($f['final_bid_price'])){
									$final_bid_price = "N/A";
								}else{
									$final_bid_price = $f['final_bid_price'];
								}
								echo '<td>'.$final_bid_price.'</td>';
								echo '<td>'.strtoupper($f['approved_tile_name']).'</td>';
								if(count($_POST['sampling'])>0){
									$tick='';
									foreach($_POST['sampling'] as $sd)
										if($sd==$f['fld_id']){
											$tick='checked';
										}
								}
							
							//echo $sd;

								if ($qt_status == '0') {
									echo '<td><input type="checkbox" name="sampling[]" value="'.$f['fld_id'].'" id=sampling '.$tick.'></td>';
							
								if(isset($_POST['formsubmit'])){
									foreach($_POST['no_of_sku'] as $key => $nsku){
										if($key==$av){
											if(empty($_POST['no_of_sku'][$av]) && $tick=='checked'){
												$c='red';
												$skucheck++;
											}else{
												$c='';
											}
											 echo "<td><input type=number name=no_of_sku[$av] style=width:60px;border-color:$c; value=$nsku></td>";
										}
									}

								}else{
									echo "<td><input type=number name=no_of_sku[$av] style=width:60px;></td>";
								}
								}
								



                           }

 if(isset($skucheck) && $skucheck>0){
			$ms='Please Enter OBL Bid Price ';
                echo '<script>alert(\''.$ms.'\');</script>';
                return false;
            }

                                ?>
							</table>
									<div  style="text-align:right;">
                                   <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
                                    
			                     <!--   <a class="btn blue" href="javascript: submitform()"> <i class="icon-ok"></i> Submit</a>
                 
                                       <button type="button" class="btn">Cancel</button> -->
									<br>
									<?php 
											if($quotation_status == 1 || $quotation_status == 2){
												?>
												<a href="quotation-negotiation.php"><input type="button" value= "Back" ></a>
														
							<?php			}else{ ?>

												
												<input type="submit" value="Submit" name="formsubmit">
												<a href="quotation-negotiation.php"><input type="button" value= "Back" ></a>

					<?php		} 
							
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