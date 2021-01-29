<?php 
	        $pm='active';
	        $nn='active';
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
	
		
		'ng_remark'				=> $_POST['ng_remark']
	);

// Data Checking

if(empty($dataArray['ng_remark'])){
	
		$errorArray['ng_remark']='Error: Please Enter Negotiation Remarks';
	}

if(empty($errorArray)) {
	
	 if(isset($pid) && $pid>0){

		 $upd2  ="UPDATE opportunity set  ";
	
		$upd2.=" ng_remark= '".dbInput($dataArray['ng_remark'])."' , last_modified='".dbInput($timestamp)."', quotation_status='1' ";
			
				
		 $upd2 .=" where opportunity_id='".(int)dbInput($pid)."'";

		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd2);
				if (odbc_execute($stmt)){ 
					$msgTxt = 'Pricing details has been Updated Successfully and pending for approval.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Pricing Details , Please Try Later.';
					$msgType = 2;
				}
		}


$ssql="select * from fld where opp_id='".$_SESSION['fld_leadID']."'";	
$rs=odbc_exec($conn,$ssql);
$vv=odbc_num_rows($rs);


	while($f = odbc_fetch_array($rs)){
	//print_r($f);
	$av=$f['fld_id'];

		if(count($_POST['sampling'])>0){
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

				$p = "update fld set final_bid_price = '".$_POST['no_of_sku'][$sd]."' where fld_id = '".$sd."'";
				$fp = odbc_prepare($conn, $p);
					$fpp = odbc_execute($fp);

				$ins="insert into negotiation (fld_id, opp_id, negotiation_price, negotiation_last_updated ) ";
				$ins.="values ('".$sd."', '".(int)dbInput($pid)."', '".$_POST['no_of_sku'][$sd]."', '".$timestamp."' ) ";

					$stmt = odbc_prepare($conn, $ins);
					$stmt_ex = odbc_execute($stmt);

				if ($stmt_ex){ 
					$msgTxt = 'Pricing  Details Has Been Updated Successfully and waiting for Approval.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Price Details, Please Try Later.';
					$msgType = 2;
					$fchk++;
				}
			}// main foreach ends
				//echo 'vin-'.$fchk;

		//updation process ends

			header('Location:negotiation.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
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
   
 if(okay > 0)
	  document.myform.submit();
	else
	  alert("Please Select SKU to Enter Revised Given.");
	  return false;	
}
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
						
						<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" onsubmit="return submitform()">
                                    <input type="hidden" name="pid" value="<?php echo $pid?>">
						<table border="0" width="100%">
                        
                        
                        
						&nbsp;	&nbsp;
                        
                           
						 <br/>
                         	
                            <?php 
                            $qts="select * from opportunity where opportunity_id='".$_SESSION['fld_leadID']."' ";	
                                $qs=odbc_exec($conn,$qts);
                                 while($q = odbc_fetch_array($qs)){
                                 	$qt_status = $q['quotation_status'];
                                 }

                                    	if ($qt_status == '0') { ?>
                            	<b>Pricing Remarks: &nbsp;&nbsp;</b>
								<textarea style="width:400px;; height:20px;" id="ng_remark" name="ng_remark"  id="move"></textarea>
                        <div style="color:#F00; font-size:15px; text-align:left"><b><br /><?php echo $errorArray['ng_remark']?></b><br /></div>
                   <?php         } ?>    
							
							
                            </td>
                        </tr>
                        
                        
                        </table>
						
						
						
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal"  name="myform" >
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 

                             <table border="1" style="width:100%" align="center">

                              	<tr height="25">
			<th colspan="14" style="background-color:#FF9900; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">Requirements Details</th>
								</tr>

								<tr>
									<th>FLD ID</th>
                                    <th>SKU Size</th>
                                    <th>Qty</th>
                                    <th>Competitor</th>
                                    
									<th>Tile Category</th>
									
                                    <th>Approved Tile Name</th>
                                    <th>PCH Approval</th>
                                                                       
                                    <th>Current BID Price</th>
                                    <?php
                                    $qts="select * from opportunity where opportunity_id='".$_SESSION['fld_leadID']."' ";	
                                $qs=odbc_exec($conn,$qts);
                                 while($q = odbc_fetch_array($qs)){
                                 	$qt_status = $q['quotation_status'];
                                 }

                                    	if ($qt_status == '0') { ?>                                    
									<th>Revise BID</th>
									<th>Revised BID Price</th>
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
								$status = $f['status'];
                                echo '<tr align="center">';
								echo '<td>'.$f['fld_id'].'</td>';
                                echo '<td>'.$f['size'].'</td>';
                                echo '<td>'.$f['qty'].'</td>';
                                echo '<td>'.$f['competitor'].'</td>';
								
								echo '<td>'.strtoupper($f['sample_tile_cateroty']).'</td>';
								
								echo '<td>'.strtoupper($f['approved_tile_name']).'</td>';
								if($status == 1){
									$pch_approval = "No";
								}else{
									$pch_approval = "Yes";
								}
								echo '<td>'.$pch_approval.'</td>';
								

                      $assql="select top 1 negotiation_price from negotiation where fld_id='".$f['fld_id']."' order by negotiation_last_updated desc";	
                      $ars=odbc_exec($conn,$assql);
					  $af = odbc_fetch_array($ars);
						if(!empty($af['negotiation_price'])){
							echo '<td>'.$af['negotiation_price'].'</td>';
						}else{
							echo '<td>N/A</td>';
						}

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
            }

                                ?>
							</table>
									<div  style="text-align:right;">
                                   <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
                                    
			                     <!--   <a class="btn blue" href="javascript: submitform()"> <i class="icon-ok"></i> Submit</a>
                 
                                       <button type="button" class="btn">Cancel</button> -->
									<br>
				
									<?php 
											if($qt_status == 1 || $qt_status == 2){ ?>
												<a href="negotiation.php"><input type="button" value= "Back" ></a>
														
								<?php			}else{ ?>
                                        
                 						<input type="submit" value="Submit" name="formsubmit">
                                       <a href="negotiation.php"><input type="button" value= "Back" ></a>

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