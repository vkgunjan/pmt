<?php 
	        $pm='active';
	        $fld='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
		
		$_SESSION['fld_leadID']=$_REQUEST['pid'];

//print_r($_SESSION);
//asset part starts


print_r($_REQUEST);


$pid=(int)$_REQUEST['pid'];		

if(isset($_GET['pid']) && $_GET['pid']>0){
		
		$pid = (int)$_GET['pid'];
		$formType = 'Update Asset Master Details ';
		
		$btsel="select * from opportunity where opportunity_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		
		//print_r($f);
		$_SESSION['working-active-asset']=$f['asset_code'];
		$dataArray=array(
					'ckaname'					=>	trim(dbOutput($f['ckaname'])),
					'cka_type'					=>	trim(dbOutput($f['cka_type'])),
					'project_type'				=>	trim(dbOutput($f['project_type'])),
					'project_name'				=>	trim(dbOutput($f['project_name'])),
					'state'						=>	trim(dbOutput($f['state'])),
					'city'						=>	trim(dbOutput($f['city'])),
					'project_contact'			=>	trim(dbOutput($f['project_contact'])),
					'architect_contact'			=>	trim(dbOutput($f['architect_contact'])),
					'tile_stage_date'			=>	trim(dbOutput($f['tile_stage_date'])),
					'obl_sales_forecast'		=>	trim(dbOutput($f['obl_sales_forecast'])),
					'probability_of_win'		=>	trim(dbOutput($f['probability_of_win'])),
					'tile_potential_sqm'		=>	trim(dbOutput($f['tile_potential_sqm'])),
					'tile_potential_inr'		=>	trim(dbOutput($f['tile_potential_inr'])),
					'status'					=>  trim(dbOutput($f['status']))
			);

	//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add Asset Master';

	}


if(isset($_POST['opportunity'])){
		
		$dataArray=array(
					'ckaname'					=>	trim(dbOutput($_POST['ckaname'])),
					'cka_type'					=>	trim(dbOutput($_POST['cka_type'])),
					'project_type'				=>	trim(dbOutput($_POST['project_type'])),
					'project_name'				=>	trim(dbOutput($_POST['project_name'])),
					'state'						=>	trim(dbOutput($_POST['state'])),
					'city'						=>	trim(dbOutput($_POST['city'])),
					'project_contact'			=>	trim(dbOutput($_POST['project_contact'])),
					'architect_contact'			=>	trim(dbOutput($_POST['architect_contact'])),
					'tile_stage_date'			=>	trim(dbOutput($_POST['tile_stage_date'])),
					'obl_sales_forecast'		=>	trim(dbOutput($_POST['obl_sales_forecast'])),
					'probability_of_win'		=>	trim(dbOutput($_POST['probability_of_win'])),
					'tile_potential_sqm'		=>	trim(dbOutput($_POST['tile_potential_sqm'])),
					'tile_potential_inr'		=>	trim(dbOutput($_POST['tile_potential_inr'])),
					'status'					=>  trim(dbOutput($_POST['status']))
			);

print_r($dataArray);
	

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE asset_master set 
		 asset_code='".dbInput($dataArray['asset_code'])."',
		 asset_name='".dbInput($dataArray['asset_name'])."',
		 asset_type='".dbInput($dataArray['asset_type'])."',
		 plant_building='".dbInput($dataArray['plant_building'])."',
		 department_section='".dbInput($dataArray['department_section'])."',
		 asset_location='".dbInput($dataArray['asset_location'])."',
		 asset_kept_area='".dbInput($dataArray['asset_kept_area'])."',
		 asset_description='".dbInput($dataArray['asset_description'])."',
		 model_number='".dbInput($dataArray['model_number'])."',
		 serial_number='".dbInput($dataArray['serial_number'])."',
		 aggreement_number='".dbInput($dataArray['aggreement_number'])."',
		 asset_condition='".dbInput($dataArray['asset_condition'])."',
 		 safty_caution='".dbInput($dataArray['safty_caution'])."',
		 consern_emails='".dbInput($dataArray['consern_emails'])."'		 
		  ";
		 $upd .=" where asset_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Asset  Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Assset  Details , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO opportunity (
				cka_name_id,
				cka_type_id,
				project_type_id,
				project_name,
				state_id,
				city,
				project_contact,
				architect_contact,
				tile_stage_date,
				obl_sale_forecast_inr,
				probability_of_win,
				project_tile_potential_sqm,
				project_tile_potential_inr,
				status,
				added_date,
				last_modified,
				modified_by
				)";
				$insert .="values(
				'".dbInput($dataArray['ckaname'])."', 
				'".dbInput($dataArray['cka_type'])."', 
				'".dbInput($dataArray['project_type'])."', 
				'".dbInput($dataArray['project_name'])."', 
				'".dbInput($dataArray['state'])."', 
				'".dbInput($dataArray['city'])."', 
				'".dbInput($dataArray['project_contact'])."', 
				'".dbInput($dataArray['architect_contact'])."', 
				'".dbInput($dataArray['tile_stage_date'])."', 
				'".dbInput($dataArray['obl_sales_forecast'])."', 
				'".dbInput($dataArray['probability_of_win'])."', 
				'".dbInput($dataArray['tile_potential_sqm'])."', 
				'".dbInput($dataArray['tile_potential_inr'])."', 
				'".dbInput($dataArray['status'])."', 
				'".dbInput($_SESSION['added_date'])."',
				'".dbInput($dataArray['last_modified'])."',
 			    '".dbInput($dataArray['modified_by'])."'
				) ";

				//echo $insert;
				$_SESSION['working-active-asset']=$dataArray['asset_code'];
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Asset Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Asset Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				
			//	header('Location:list-asset.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				//exit;

	}//empty error array check ends here
}//main post end here	

//asset part ends here



//################################## TAB2  ###################################

//*******************************************************************************
						//PURCHAGE PART STARTS HERE
//******************************************************************************

//print_r($_SESSION);

if(isset($_SESSION['working-active-asset']) && empty($_SESSION['working-active-asset'])){
		


		$formType = 'Update Asset Master Details ';
		
		echo $btsel="select * from asset_master where asset_code='".dbInput($_GET['pid'])."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					'manufacturer_name'					=>	trim(dbOutput($f['manufacturer_name'])),
					'vendor_details'					=>	trim(dbOutput($f['vendor_details'])),
					'po_number'							=>	trim(dbOutput($f['po_number'])),
					'capax_number'						=>	trim(dbOutput($f['capax_number'])),
					'invoice_number'					=>	trim(dbOutput($f['invoice_number'])),
					'purchase_cost'						=>	trim(dbOutput($f['purchase_cost'])),
					'purchase_date'						=>	trim(dbOutput($f['purchase_date'])),
					'installation_date'					=>	trim(dbOutput($f['installation_date'])),
					'warranty_start'					=>	trim(dbOutput($f['warranty_start'])),
					'warranty_end'						=>	trim(dbOutput($f['warranty_end']))
			);
		print_r($dataArray);
	}

if(isset($_POST['buy']) && $_POST['buy']='submit'){

	$purchase_date=$_POST['purchase_yy'].'-'.$_POST['purchase_mm'].'-'.$_POST['purchase_dd'];
	if($_POST['purchase_dd']=='Date' || $_POST['purchase_mm']=='Month' || $_POST['purchase_yy']=='Year' ){
		$errorArray['purchase_date']='Please Select Purchase Date';
	}elseif(!checkdate($_POST['purchase_mm'],$_POST['purchase_dd'],$_POST['purchase_yy'])  ){
		$errorArray['purchase_date']='Please Select Valid Purchase Date';
	}

	$installation_date=$_POST['installation_yy'].'-'.$_POST['installation_mm'].'-'.$_POST['installation_dd'];
	if($_POST['installation_dd']=='Date' || $_POST['installation_mm']=='Month' || $_POST['installation_yy']=='Year' ){
		$errorArray['installation_date']='Please Select Installation Date';
	}elseif(!checkdate($_POST['installation_mm'],$_POST['installation_dd'],$_POST['installation_yy'])  ){
		$errorArray['installation_date']='Please Select Valid Installation Date';
	}

	$warranty_start=$_POST['warranty_start_yy'].'-'.$_POST['warranty_start_mm'].'-'.$_POST['warranty_start_dd'];
	if($_POST['warranty_start_dd']=='Date' || $_POST['warranty_start_mm']=='Month' || $_POST['warranty_start_yy']=='Year' ){
		$errorArray['warranty_start']='Please Select Warranty Start Date';
	}elseif(!checkdate($_POST['warranty_start_mm'],$_POST['warranty_start_dd'],$_POST['warranty_start_yy'])  ){
		$errorArray['warranty_start']='Please Select Valid Warranty Start Date';
	}elseif($_POST['warranty_start_yy'] >= $_POST['warranty_end_yy']){
		$errorArray['warranty_start']='Please Select Valid Start / End Warranty Date';
	}

	$warranty_end=$_POST['warranty_start_yy'].'-'.$_POST['warranty_end_mm'].'-'.$_POST['warranty_end_dd'];
	if($_POST['warranty_end_dd']=='Date' || $_POST['warranty_end_mm']=='Month' || $_POST['warranty_end_yy']=='Year' ){
		$errorArray['warranty_end']='Please Select Warranty End Date';
	}elseif(!checkdate($_POST['warranty_end_mm'],$_POST['warranty_end_dd'],$_POST['warranty_end_yy'])  ){
		$errorArray['warranty_end']='Please Select Valid Warranty End Date';
	}

		$dataArray=array(
					'asset_code'						=>	trim(dbOutput($_POST['session-asset-code'])),
					'manufacturer_name'					=>	trim(dbOutput($_POST['manufacturer_name'])),
					'vendor_details'					=>	trim(dbOutput($_POST['vendor_details'])),
					'po_number'							=>	trim(dbOutput($_POST['po_number'])),
					'capax_number'						=>	trim(dbOutput($_POST['capax_number'])),
					'invoice_number'					=>	trim(dbOutput($_POST['invoice_number'])),
					'purchase_cost'						=>	trim(dbOutput($_POST['purchase_cost'])),
					'purchase_date'						=>	trim(dbOutput($purchase_date)),
					'installation_date'					=>	trim(dbOutput($installation_date)),
					'warranty_start'					=>	trim(dbOutput($warranty_start)),
					'warranty_end'						=>	trim(dbOutput($warranty_end))
			);

		print_r($dataArray);
		
		 $upd  ="UPDATE asset_master set 
		 manufacturer_name='".dbInput($dataArray['manufacturer_name'])."',
		 vendor_details='".dbInput($dataArray['vendor_details'])."',
		 po_number='".dbInput($dataArray['po_number'])."',
		 capax_number='".dbInput($dataArray['capax_number'])."',
		 invoice_number='".dbInput($dataArray['invoice_number'])."',
		 purchase_cost='".dbInput($dataArray['purchase_cost'])."',
		 purchase_date='".dbInput($dataArray['purchase_date'])."',
		 installation_date='".dbInput($dataArray['installation_date'])."',
		 warranty_start='".dbInput($dataArray['warranty_start'])."',
		 warranty_end='".dbInput($dataArray['warranty_end'])."'
		  ";
		 $upd .=" where asset_code='".dbInput($dataArray['asset_code'])."'";
		
		
		//echo '<br><br>'.$upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Purchase Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Purchase Details , Please Try Later.';
					$msgType = 2;
				}						
		
				header('Location:asset-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt).'&tab2=active');
				exit;
		
		}

				


//*******************************************************************************
						// PURCHASE Details PART ENDS HERE
//*********************************************************************************
?>

<script type="text/javascript" src="spare_part.js"></script>
<script type="text/javascript" src="add_to_cart_data.js"></script>
<script type="text/javascript" src="delete_from_cart_data.js"></script>


<script>
	 function lostremarks(){
	 	alert('asdfasdf');
		
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
                                 
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" name="fld">
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 
                                   
                                   
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
                       
                        <table id="lrt">
                        <tr>
                        	<td>Lost Remarks</td>
                            <td><textarea name="lostremarks" id="lostremarks"></textarea></td>
                        </tr>			
                                    
                       </table>     
								
                                
                            
                             <table border="1" style="width:100%" align="center">

                                <tr>
                                	<th colspan="3" style="background-color:#069A09; color:#FFFFFF">Add First Level Discussion Details</th>
								</tr>
                               


                                 <tr>
                                	<th width="10%"> SKU Size</th>
                                    <td width="10%">
                                    <select name="spare_part_id" style="width:160px;"  onChange="display(this.value)" id="spare_part_id">
                                       		<option value="">-Select Size -</option>
                                             <?php
								$ssql="select distinct(size_code_desc) size_id, size_code_desc from size_master order by size_code_desc ";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$ss=($f['size_id']==$dataArray['spare_part_id'])?'selected':'';
										echo '<option value="'.$f['size_id'].'" '.$ss.'>'.$f['size_code_desc'].' </option>';
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
									<th colspan="4" style="background-color:#0062D8; color:#FFFFFF">List of Requirements </th>
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
                                    
                        <input type="submit" name="submit" style="background-color:#060; color:#FFF;" value="Submit FLD">

                        <input type="submit" name="lost" style="background-color:#F00; color:#FFF;" value="Lead Lost" onclick="lost();">
                                        
										<a href="first-level-discussion.php"> 
                                        <input type="button" style="background-color:#333; color:#FFF;" value="Back">
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


                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal">
                                 <table>
  <tr>
  <th>&nbsp;&nbsp;CKA Name&nbsp;&nbsp;</th>
  <td>&nbsp;&nbsp;<input type="text">&nbsp;&nbsp;</td>
  <td><p style="text-indent :13em;" >&nbsp; </p></td>
  <th>&nbsp;&nbsp;Project&nbsp;&nbsp;</th>
	<td>&nbsp;&nbsp;<input type="text">&nbsp;&nbsp;</td>
  </table>                 
	<br>
	<h2>CKA Influencer Role</h2>
	<table cellpadding="15">
		<tr>
			<th>&nbsp;</th>
			<th>Name</th>
			<th>Influence Degree</th>  
      <th> OBL Perception Rating</th>
		</tr>
		<tr>
			<th>Key Purchaser</th>
			<td> <input type="text"></td>
			<td> 
				<select name="degree_k">
					<option value="high">High</option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
				</select>
			</td>         
      <td>
          <input type="radio" value="0">0 &nbsp;
		      <input type="radio" value="1">1 &nbsp;
          <input type="radio" value="2">2 &nbsp;      
          <input type="radio" value="3">3 &nbsp;
          <input type="radio" value="4">4 &nbsp;
          <input type="radio" value="5">5 &nbsp;
      </td>
    </tr>
		<tr>
			<th>Architect Involved</th>
			<td> <input type="text"></td>
			<td> 
				<select name="degree_a">
					<option value="high">High</option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
				</select>
			</td> 
      <td>
          <input type="radio" value="0">0 &nbsp;
		      <input type="radio" value="1">1 &nbsp;
          <input type="radio" value="2">2 &nbsp;
          <input type="radio" value="3">3 &nbsp;
          <input type="radio" value="4">4 &nbsp;
          <input type="radio" value="5">5 &nbsp;
      </td>
		</tr>
		<tr>
			<th>OBL Champion</th>
			<td> <input type="text"></td>
			<td> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
				</select>
			</td>  
      <td>
          <input type="radio" value="0">0 &nbsp;
		      <input type="radio" value="1">1 &nbsp;
          <input type="radio" value="2">2 &nbsp;
          <input type="radio" value="3">3 &nbsp;
          <input type="radio" value="4">4 &nbsp;
          <input type="radio" value="5">5 &nbsp;
      </td>
		</tr>
	<table>                     
  <br>
  <b>OBL Strengths</b>
    <br>
    <textarea rows="4" cols="50"></textarea>
    <b><br><br>OBL Weaknesses</b>
    <br>
    <textarea rows="4" cols="50"></textarea>
    <br>
    <h2>30 Day Action Plan</h2> 
    <table cellpadding="15">
		<tr>
			<th>Activity</th>
      
			<th>Responsibility</th>  
		</tr>
		<tr>              
       <td>
				<select name="activity">
					<option value="prsamp">Prodduct Sampling</option>
					<option value="mockup">Mock Up</option>
					<option value="workshop">Workshop</option>
          <option value="smv">Snr. Mgm. Visit</option>
				</select>
			</td>
      <td>
				<select name="responsibility">
					<option value="gps">GPS</option>
					<option value="bd">BD</option>
					<option value="retail">Retail</option>
				</select>
			</td>         
      </table>

                                    
                            
                                    <div class="form-actions">
                                       <button type="submit"  class="btn blue"><i class="icon-ok"></i> Save</button>
                                      <button type="button" class="btn" >Cancel</button>
                                    </div>
                                 </form>
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