<?php 
	       $wrkod='active';
	        $la='active';

        include_once('including/all-include.php');
        include_once('including/header.php');


if(isset($_REQUEST['woid'])){
	$wo=trim($_REQUEST['woid']);
	$_SESSION['wo_id']=$wo;
}

//echo $wo;

if(isset($_POST['submit_wo'])){
	//print_r($_POST);
	$wo_date=$_POST['wo_c_year'].'-'.$_POST['wo_c_month'].'-'.$_POST['wo_c_date'];
	$wo_c_time=$_POST['wo_c_time'];
	
echo $iins=" update work_order set	wo_completion_description='".dbInput($_POST['wo_completetion_description'])."', 
workorder_complete_date = '".$wo_date."' , workorder_complete_time = '".$wo_c_time."' , 
workorder_status='2' where workorder_id = '".$wo."' and factory_id = ".dbInput($_SESSION['factory-id'])."  ";
		$sst = odbc_prepare($conn, $iins);
		if (odbc_execute($sst)){ 
			$msgTxt = 'Work Order Updated Sucessfully.';
			$msgType = 2;
			header('Location:generated-work-order-list.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			exit;
		}
	
	
}



?>
<script type="text/javascript" src="spare_part.js"></script>
<script type="text/javascript" src="add_to_cart_data.js"></script>
<script type="text/javascript" src="delete_from_cart_data.js"></script>

<script type="text/javascript">
function submitform()
{
 
		var work_order_description=document.getElementById("work_order_description").value;
		var work_order_time=document.getElementById("work_order_time").value; 	
		var priority=document.getElementById("priority").value;
 



if (!work_order_time.trim()) {
     alert('Please enter work order start time');
	 return false;
}

if (!priority.trim()) {
     alert('Please select priority or work order.');
	 return false;
}

 if (!work_order_description.trim()) {
     alert('Please enter work order description');
	 return false;
}
 
 var checkboxs=document.getElementsByName("engineer[]");
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
	  alert("Please select at least 1 engineer.");
	
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
                           <span class="hidden-480"> Complete Work Order</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                          <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
                                <li><a href="#portlet_tab3" data-toggle="tab">First Level Discussion</a></li>
                                <li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Project Action Plan</a></li>
<?php /*?>
         <li class="<?php echo (isset($_GET['tab2'])?'active':'')?>"><a href="#portlet_tab2" id="tab2" data-toggle="tab">Purchase Details</a></li>
		 <li class="<?php echo (!isset($_GET['tab2'])?'active':'')?>"><a href="#portlet_tab1" data-toggle="tab">Asset Details</a></li>			
<?php */?>
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <!-- tab 1 asset details start --> 
                           <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
                                             <th>CKA Name</th>
											<th >CKA Type</th>
											<th >Project Type</th>
											<th >Project Name</th>
											<th >State</th>
											<th >City</th>
                                            <th >Project Contact</th>
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
			d.[project_contact],
			d.[tile_stage_date],
			d.[obl_sale_forecast_inr],
			d.[status]
			FROM [opportunity] d
			left join cka_name_master a on a.cka_name_id = d. cka_name_id
			left join cka_type_master b on b.cka_type_id = d.cka_type_id
			left join project_type_master c on c.project_type_id = d.project_type_id
			left join state_master e on e.state_id = d.state_id
			where d.opportunity_id = '".$_GET['pid']."'
		";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$f['cka_name'].'</td>';
										echo '<td>'.$f['cka_type'].'</td>';										
										echo '<td >'.$f['project_type'].'</td>';																
										echo '<td>'.ucfirst($f['project_name']).'</td>';	
										echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.$f['city'].'</td>';
										echo '<td>'.$f['project_contact'].'</td>';
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
                                
                            
                             <table border="1" style="width:100%" align="center">

                                <tr>
                                	<th colspan="3" style="background-color:#069A09; color:#FFFFFF">Work Order Completion Details</th>
								</tr>
                               
                                <tr>
                                	<th width="18%">Completion Description</th>
     <td colspan="2"><textarea style="width:880px;" name="wo_completetion_description" required><?php echo $wo_completion_description?></textarea></td>
                                </tr>
							
	                         <tr>
                             	<th>Completion Date & Time</th>
                                <td colspan="2">
                                
                                 <select class="small m-wrap" tabindex="1" name="wo_c_date">
												<?php 
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['installation_dd']==$x || date('d')==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="wo_c_month">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=date('m')-1;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['installation_mm']==$x || date('m')==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="wo_c_year">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                
                                		<b>Time:</b> <input type="text" name="wo_c_time" value="<?php echo date("H:i:s");?>">
                                
                                </td>
                             </tr>
                             
                                 <tr>
                                	<th width="16%"> Spare Part</th>
                                    <td width="20%">
                                    <select name="spare_part_id" style="width:230px;"  onChange="display(this.value)" id="spare_part_id">
                                       		<option value="">-Select Spare Part-</option>
                                             <?php
								$ssql="select spare_part_id,spare_part_name from spare_part_master order by spare_part_name ";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$ss=($f['spare_part_id']==$dataArray['spare_part_id'])?'selected':'';
										echo '<option value="'.$f['spare_part_id'].'" '.$ss.'>'.$f['spare_part_name'].' </option>';
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
                              	<tr>
									<th colspan="4" style="background-color:#0062D8; color:#FFFFFF">Spare Part Uses Details</th>
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
                                      <input type="submit" value="Complete">
                 					<a href="generated-work-order-list.php"><input type="button" value="Back"></a>

                                    </div>
                             </form>
                             
                          
                          
                          
                           <div class="tab-pane " id="portlet_tab2">
                                    <?php 
										//print_r($_SESSION);
										if(isset($_SESSION['working-active-asset']) && !empty($_SESSION['working-active-asset'])){

									?>

                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal">
                                 <input type="hidden" name="buy" value="submit">
                                 <input type="hidden" name="session-asset-code" value="<?php echo $_SESSION['working-active-asset'];?>">
                                 
                                    <div class="control-group">
                                       <label class="control-label">Manufacturer Name</label>
                   <input type="text" class="m-wrap large" name="manufacturer_name" value="<?php echo $dataArray['manufacturer_name']?>"/>
                                       </div>
                                    </div>
                                    
                                   <div class="control-group">
                                       <label class="control-label">Vendor Details</label>
                                       <div class="controls">
                  <textarea class="large m-wrap" rows="3" name="vendor_details"><?php echo $dataArray['vendor_details']?></textarea>
                                       </div>
                                    </div>

									<div class="control-group">
                                       <label class="control-label">P.O Number</label>
                                       <div class="controls">
                                          <input type="text"  class="m-wrap large" name="po_number" value="<?php echo $dataArray['po_number']?>"/>
                                       </div>
                                    </div>

									<div class="control-group">
                                       <label class="control-label">Capax Number</label>
                                       <div class="controls">
                                          <input type="text"  class="m-wrap large" name="capax_number" value="<?php echo $dataArray['capax_number']?>"/>
                                       </div>
                                    </div>
                                    
                                    
									<div class="control-group">
                                       <label class="control-label">Invoice Number</label>
                                       <div class="controls">
                                          <input type="text"  class="m-wrap large" name="invoice_number" value="<?php echo $dataArray['invoice_number']?>"/>
                                       </div>
                                    </div>


									<div class="control-group">
                                       <label class="control-label">Purchase Cost</label>
                                       <div class="controls">
                                          <input type="text"  class="m-wrap small" name="purchase_cost" value="<?php echo $dataArray['purchase_cost']?>"/>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Purchase Date</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1" name="purchase_dd" required>
                                             <option value="Date">Date</option>
												<?php 
                                                    $dd=explode('-',$dataArray['purchase_date']);
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['purchase_dd']==$x || $dd[2]==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="purchase_mm">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=0;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['purchase_mm']==$x || $dd[1]==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="purchase_yy">
                                            <option value="Year">Year</option>
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=2010; $x<=($cyr); $x++){
                                                        $selected=($_POST['purchase_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
 											<div style="color:#E10307"><?php echo $errorArray['purchase_date']?></div>
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Installation Date</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1" name="installation_dd">
                                             <option value="Date">Date</option>
												<?php 
                                                    $dd=explode('-',$dataArray['installation_date']);
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['installation_dd']==$x || $dd[2]==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="installation_mm">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=0;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['installation_mm']==$x || $dd[1]==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="installation_yy">
                                            <option value="Year">Year</option>
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=2010; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
										 <div style="color:#E10307"><?php echo $errorArray['installation_date']?></div>
                                       </div>
                                    </div>
                                 
                                    
                                  <div class="control-group">
                                       <label class="control-label">Warranty Start</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1" name="warranty_start_dd">
                                             <option value="Date">Date</option>
												<?php 
                                                    $dd=explode('-',$dataArray['warranty_start']);
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['sdate']==$x || $dd[2]==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="warranty_start_mm">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=0;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['smonth']==$x || $dd[1]==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="warranty_start_yy">
                                            <option value="Year">Year</option>
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=2010; $x<=($cyr); $x++){
                                                        $selected=($_POST['syear']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
										 <div style="color:#E10307"><?php echo $errorArray['warranty_start']?></div>
                                       </div>
                                    </div>
                                    
                                   
                                      <div class="control-group">
                                       <label class="control-label">Warranty End</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1" name="warranty_end_dd">
                                             <option value="Date">Date</option>
												<?php 
                                                    $dd=explode('-',$dataArray['startdate']);
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['sdate']==$x || $dd[2]==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="warranty_end_mm">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=0;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['smonth']==$x || $dd[1]==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="warranty_end_yy">
                                            <option value="Year">Year</option>
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=2010; $x<=($cyr+20); $x++){
                                                        $selected=($_POST['syear']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
											 <div style="color:#E10307"><?php echo $errorArray['warranty_end']?></div>
                                       </div>
                                    </div>
                                    
                            
                                    <div class="form-actions">
                                       <button type="submit"  class="btn blue"><i class="icon-ok"></i> Save</button>
                                      <button type="button" class="btn" >Cancel</button>
                                    </div>
                                 </form>
                              <?php } else { echo '<h3 align="center"><font color="#F00A0E">Please Save Asset Details First</font></h3>'; } ?>
                              </div>
                             
                             
                             
                             
                             
                              </div>
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