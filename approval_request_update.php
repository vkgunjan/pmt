<?php 
	       $pm='active';
	        $app='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['fld_leadID']=$_REQUEST['pid'];

//action plan_project_session_id
	$_SESSION['approval_opp_id']=$_REQUEST['pid'];
	
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

$ex=explode(",",$_POST['value_id']);
foreach($ex as $x){
	 $status=$x.'status';
 	 $remarks=$x.'approval_remarks';
	// $_POST[$status][0];
	// $_POST[$action_remarks][0];
//echo $x;
			if($_POST[$status][0]=='Approve'){
				$val=0;
			}

			if($_POST[$status][0]=='Reject'){
				$val=1;
			}


			

			
			if($val==0){
					echo $upd="update fld set status = '".$val."', approval_remarks = '".$_POST[$remarks][0]."' 
					where fld_id = '".$x."' ";
		
						$stmt1 = odbc_prepare($conn, $upd);

						if (odbc_execute($stmt1)){ 
							$msgTxt = ' Approval Request Updated Successfully.';
							$msgType = 1;
						}else{
							$msgTxt = 'Sorry! Unable To Update Approval Request, Please Try Later.';
							$msgType = 2;
						}

						header('Location:my_approval.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
							exit;
			} else{
				echo $upd="update opportunity set current_stage = '5'
					where opportunity_id = '".$_REQUEST['pid']."' ";
		
						$stmt1 = odbc_prepare($conn, $upd);

						if (odbc_execute($stmt1)){ 
							$msgTxt = ' Approval Request Updated Successfully.';
							$msgType = 1;
						}else{
							$msgTxt = 'Sorry! Unable To Update Approval Request, Please Try Later.';
							$msgType = 2;
						}

						header('Location:my_approval.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
							exit;
			}
}

	//updation process ends

	

}


?>

<script type="text/javascript" src="spare_part.js"></script>
<script type="text/javascript" src="add_to_cart_data.js"></script>
<script type="text/javascript" src="delete_from_cart_data.js"></script>

<script type="text/javascript">
function submitform()
{
 
 	if(confirm('Please confirm your submission...'))
	  document.myform.submit();
	else
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
                           <span class="hidden-480">Approval Request</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
<?php /*?>                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
<?php */?>                      
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Lead Approval Request</a></li>			
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
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" name="myform" >
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 

                             <table border="1" style="width:100%" align="center">

                              	<tr height="25">
			<th colspan="11" style="background-color:#FF9900; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF"> Required Approval Details </th>
								</tr>

								<tr>
                                    <th>FLD ID</th>
                                    <th>SKU Size</th>
                                    <th>Qty</th>
                                    <th>Competitor</th>
                                    <th>No. of SKU</th>
									<th>Tile Category</th>
									<th>OBL BID Price</th>
									<th>Visited User</th>
									<th>Contact No</th>
                                    <th>Action</th>
                                    <th>Remarks</th>                                    

                               </tr>
								<?php 
                                //echo 'hello';
                                //print_r($_GET);
								  $ssql="select * from fld where opp_id='".$_REQUEST['pid']."' 
								  and status = 1";	
                                 
                                $rs=odbc_exec($conn,$ssql);
                                 $vv=odbc_num_rows($rs);
                                $_SESSION['atc']=$vv;
								$cnt=0;
                                while($f = odbc_fetch_array($rs)){

								if($cnt==0){
									$value_id =$f['fld_id'];
								}else{
									$value_id .=','.$f['fld_id'];
								}
									$cnt++;	

								//print_r($f);
								$av=$f['fld_id'];
                                echo '<tr align="center">';

								echo '<td>'.$f['fld_id'].'</td>';
								echo '<td>'.$f['size'].'</td>';
							
								
								echo '<td>'.$f['qty'].'</td>';
								
								echo '<td>'.$f['competitor'].'</td>';
								echo '<td>'.$f['no_of_samples_given'].'</td>';
								echo '<td>'.$f['sample_tile_cateroty'].'</td>';
								echo '<td>'.$f['obl_bid_price'].'</td>';
								echo '<td>'.$f['to_meet_with'].'</td>';
								echo '<td>'.$f['contact_no'].'</td>';
								
								//echo gettype($f['status']);
																
							if($f['status']=='1'){
									$as='checked';	
								}else{
									$as='';	
								}

								
							
							//echo $sd;
								echo '<td align="left">

								  <label class="radio">
				 <input type="radio" name="'.$f['fld_id'].'status[]" value="Approve" '.$as.'/>Approve
								  </label>

								  <label class="radio">
				 <input type="radio" name="'.$f['fld_id'].'status[]" value="Reject" />Reject
								  </label>
								  
								  
										  
								</td>';
							
									echo '<td><textarea name="'.$f['fld_id'].'remarks[]">'.$f['approval_remarks'].'</textarea></td>';
                              
							  
                                }
                                ?>
							</table><br>
									<div  style="text-align:right;">
                                   <input type="hidden" name="formsubmit" /> 
                                   <input type="hidden" name="value_id" value="<?php echo $value_id?>" />
                                    <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
                                    
			                        <a class="btn blue" href="javascript: submitform()"> <i class="icon-ok"></i> Update</a>
                 
                                       <button type="button" class="btn">Cancel</button>

                                    </div>
                             </form>
                             
                        
                        
                                 <!-- tab 1, asset detail ends -->  
                              </div>
                                
                                 <!--#################### purchase details part start tab2 ##############################-->  
                                 <!-- tab 2, purchase detail-->  
                              <div class="tab-pane " id="portlet_tab2">
                                   
                                   
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
   
   if(isset($skucheck) && $skucheck>0){
			$ms='Please Enter Number of SKU given for Sampling';
                echo '<script>alert(\''.$ms.'\');</script>';
            }

   if(isset($tcat) && $tcat>0){
			$ms='Please Select Tile Sample Tile Category ';
                echo '<script>alert(\''.$ms.'\');</script>';
            }






   
   ?>