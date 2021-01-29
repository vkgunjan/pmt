<?php 
	        $pm='active';
	        $samp='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['fld_leadID']=$_REQUEST['pid'];

//print_r($_SESSION);
//asset part starts
//echo '<pre>';
print_r($_POST);

$errorArray=array();
$dataArray=array();

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

  if(empty($errorArray)){
	
	 if(isset($pid) && $pid>0){

		 $upd  ="UPDATE opportunity set  ";
		 
		 if($dataArray['status'] =='lost'){
					 $upd .=" status='lost', lost_remarks= '".dbInput($dataArray['remarks'])."'	 ";
				}

		 if($dataArray['status'] =='close'){
					 $upd .=" current_stage='3' ";
				}
				
		 $upd .=" where opportunity_id='".(int)dbInput($pid)."'";

		echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' First Level Discussion Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update First Level Discussion , Please Try Later.';
					$msgType = 2;
				}
		}
	
				//header('Location:first-level-discussion.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				//exit;
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
	  alert("Please Select At Least 1 SKU in Sample Given.");
	
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
                           <span class="hidden-480">Sampling</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
<?php /*?>                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
<?php */?>                      <li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Project Action Plan</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Sampling</a></li>			
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

                             <table border="1" style="width:100%" align="center">

                              	<tr>
									<th colspan="7" style="background-color:#FF9900; color:#FFFFFF">List of Requirements </th>
								</tr>

								<tr>
                                    <th width="5%">FLD ID</th>
                                    <th width="15%">SKU Size</th>
                                    <th width="10%">Qty</th>
                                    <th width="30%">Competitor</th>
									<th width="10%">Sample Given </th>
                                    <th width="10%">No.of SKU</th>
									<th width="15%">Tile Category</th>
                               </tr>
								<?php 
                                //echo 'hello';
                                //print_r($_GET);

                                 $ssql="select * from fld where opp_id='".$_SESSION['fld_leadID']."'";	
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
																
								if(count($_POST['sampling'])>0){
									$tick='';
									foreach($_POST['sampling'] as $sd)
										if($sd==$f['fld_id']){
											$tick='checked';
										}
								}
							
							//echo $sd;
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
											 echo "<td><input type=number name=no_of_sku[$av] style=width:40px;border-color:$c; value=$nsku></td>";
										}
									}

								}else{
									echo "<td><input type=number name=no_of_sku[$av] style=width:40px;></td>";
								}

                              
							  if(isset($_POST['formsubmit'])){
									foreach($_POST['tile_category'] as $key => $nsku){
										if($key==$av){
											if(empty($_POST['tile_category'][$av]) && $tick=='checked'){
												$cc='red';
												$tcat++;
											}else{
												$cc='';
											}
											 //echo "<td><input type=number name=no_of_sku[$av] style=width:40px;border-color:$c; value=$nsku></td>";
										}
									}

								}else{
									//echo "<td><input type=number name=no_of_sku[$av] style=width:40px;></td>";
								}
								
								 
								echo '<td>';
									echo "<select name=tile_category[$av] style=width:100px;border-color:$cc;>";
									echo '<option value="">-Select-</option>';
									echo '<option value="ceramic">Ceramic</option>';
									echo '<option value="gvt">GVT</option>';
									echo '<option value="pavers">Pavers</option>';
									echo '</select>';
								echo '</td>';
                                }
                                ?>
							</table>
									<div  style="text-align:right;">
                                   <input type="hidden" name="formsubmit" /> 
                                    <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid']?>" />
                                    
			                        <a class="btn blue" href="javascript: submitform()"> <i class="icon-ok"></i> Submit</a>
                 
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
   
   if(isset($skucheck) && $skucheck>0){
			$ms='Please Enter Number of SKU given for Sampling';
                echo '<script>alert(\''.$ms.'\');</script>';
            }

   if(isset($tcat) && $tcat>0){
			$ms='Please Select Tile Sample Tile Category ';
                echo '<script>alert(\''.$ms.'\');</script>';
            }

   
   ?>