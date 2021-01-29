<?php 
	        $am='active';
	        $aa='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
//print_r($_SESSION);
//asset part starts
$pid=(int)$_REQUEST['pid'];		
if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update Asset Master Details ';
		
		$btsel="select * from asset_master where asset_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);
		$_SESSION['working-active-asset']=$f['asset_code'];
		$dataArray=array(
					'asset_code'						=>	trim(dbOutput($f['asset_code'])),
					'asset_name'						=>	trim(dbOutput($f['asset_name'])),
					'asset_type'						=>	trim(dbOutput($f['asset_type'])),
					'plant_building'					=>	trim(dbOutput($f['plant_building'])),
					'department_section'				=>	trim(dbOutput($f['department_section'])),
					'asset_location'					=>	trim(dbOutput($f['asset_location'])),
					'asset_kept_area'					=>	trim(dbOutput($f['asset_kept_area'])),
					'asset_description'					=>	trim(dbOutput($f['asset_description'])),
					'model_number'						=>	trim(dbOutput($f['model_number'])),
					'serial_number'						=>	trim(dbOutput($f['serial_number'])),
					'aggreement_number'					=>	trim(dbOutput($f['aggreement_number'])),
					'asset_condition'					=>	trim(dbOutput($f['asset_condition'])),
					'safty_caution'						=>	trim(dbOutput($f['safty_caution'])),
					'consern_emails'					=>	trim(dbOutput($f['consern_emails'])),
					
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


		//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add Asset Master';

	}


if(isset($_POST['asset'])){
		

		$dataArray=array(
					'asset_code'					=>	trim(dbOutput($_POST['asset_code'])),
					'asset_name'					=>	trim(dbOutput($_POST['asset_name'])),
					'asset_type'					=>	trim(dbOutput($_POST['asset_type'])),
					'plant_building'				=>	trim(dbOutput($_POST['plant_building'])),
					'department_section'			=>	trim(dbOutput($_POST['department_section'])),
					'asset_location'				=>	trim(dbOutput($_POST['asset_location'])),
					'asset_kept_area'				=>	trim(dbOutput($_POST['asset_kept_area'])),
					'asset_description'				=>	trim(dbOutput($_POST['asset_description'])),
					'model_number'					=>	trim(dbOutput($_POST['model_number'])),
					'serial_number'					=>	trim(dbOutput($_POST['serial_number'])),
					'aggreement_number'				=>	trim(dbOutput($_POST['aggreement_number'])),
					'asset_condition'				=>	trim(dbOutput($_POST['asset_condition'])),
					'safty_caution'					=>	trim(dbOutput($_POST['safty_caution'])),
					'consern_emails'				=>  trim(dbOutput($_POST['consern_emails']))
			);


//print_r($dataArray);

	if(EmptyCheck($dataArray['asset_code'])){
		 $errorArray['asset_code']='Enter Asset Code Name';
	}elseif(empty($pid)){
				$bt="select * from asset_master where asset_code='".dbInput($dataArray['asset_code'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['asset_code']='Asset Code Allready Exist...';
				}
		}

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
				$insert  ="INSERT INTO asset_master (
				asset_code,
				asset_name,
				asset_type,
				plant_building,
				department_section,
				asset_location,
				asset_kept_area,
				asset_description,
				model_number,
				serial_number,
				aggreement_number,
				asset_condition,
				safty_caution,
				factory_id,
				consern_emails
				)";
				$insert .="values(
				'".dbInput($dataArray['asset_code'])."', 
				'".dbInput($dataArray['asset_name'])."', 
				'".dbInput($dataArray['asset_type'])."', 
				'".dbInput($dataArray['plant_building'])."', 
				'".dbInput($dataArray['department_section'])."', 
				'".dbInput($dataArray['asset_location'])."', 
				'".dbInput($dataArray['asset_kept_area'])."', 
				'".dbInput($dataArray['asset_description'])."', 
				'".dbInput($dataArray['model_number'])."', 
				'".dbInput($dataArray['serial_number'])."', 
				'".dbInput($dataArray['aggreement_number'])."', 
				'".dbInput($dataArray['asset_condition'])."', 
				'".dbInput($dataArray['safty_caution'])."', 
				'".dbInput($_SESSION['factory-id'])."',
				'".dbInput($dataArray['consern_emails'])."'  
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

				
				header('Location:list-asset.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;

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


	  

 
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Asset Master</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
                                <li><a href="#portlet_tab3" data-toggle="tab">Maintenance Scheduled Details</a></li>
                                <li><a href="#portlet_tab2" id="tab2" data-toggle="tab">Purchase Details</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Asset Details</a></li>			
<?php /*?>
         <li class="<?php echo (isset($_GET['tab2'])?'active':'')?>"><a href="#portlet_tab2" id="tab2" data-toggle="tab">Purchase Details</a></li>
		 <li class="<?php echo (!isset($_GET['tab2'])?'active':'')?>"><a href="#portlet_tab1" data-toggle="tab">Asset Details</a></li>			
<?php */?>

                           </ul>

                      <!-- tab 1 asset details start --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal">
                                    <input type="hidden" name="pid" value="<?php echo $pid?>"> 
                                    <div class="control-group">
                                       <label class="control-label">Asset Code</label>
                                       <div class="controls">   
                                          <input class="m-wrap medium" type="text"  name="asset_code" 
                                          value="<?php echo $dataArray['asset_code']?>" required />    
                                           <div style="color:#E10307"><?php echo $errorArray['asset_code']?></div>
                                         
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Asset Name</label>
                                       <div class="controls">
                                            <input type="text"  class="m-wrap large" name="asset_name" value="<?php echo $dataArray['asset_name']?>"required/>
                                         
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Asset Type</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="asset_type"  required>
                                          <option value="">-Select-</option>
                                             <?php
									$sql="select * from asset_type_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										$selected=($f['asset_type_id']==$dataArray['asset_type'])?'selected':'';
										echo '<option value="'.$f['asset_type_id'].'"'.$selected.'>'.$f['asset_type'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                  

                                    <div class="control-group">
                                       <label class="control-label">Plant / Building</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="plant_building" required>
                                       <option value="">-Select-</option>
                                             <?php
									$sql="select * from plant_building_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										$selected=($f['plant_building_id']==$dataArray['plant_building'])?'selected':'';
										echo '<option value="'.$f['plant_building_id'].'"'.$selected.'>'.$f['plant_building_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>


                                    
                                    <div class="control-group">
                                       <label class="control-label">Department / Section </label>
                                       <div class="controls">
                                          <select class="medium m-wrap" name="department_section" required>
                                   <option value="">-Select-</option>
                                             <?php
									$sql="select * from department_Section_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									$selected=($f['department_section_id']==$dataArray['department_section'])?'selected':'';
									echo '<option value="'.$f['department_section_id'].'"'.$selected.'>'.$f['department_section_name'].'</option>';
										
										}
									?>
                                          </select>
                                       </div>
                                    </div>


                                    <div class="control-group">
                                       <label class="control-label">Asset Location </label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="asset_location" required>
                                      <option value="">-Select-</option>
                                             <?php
									$sql="select * from location_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									$selected=($f['location_master_id']==$dataArray['asset_location'])?'selected':'';
									echo '<option value="'.$f['location_master_id'].'"'.$selected.'>'.$f['location_name'].'</option>';

										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                    
                                                                        
                               
                              <div class="control-group">
                                       <label class="control-label">Asset Kept Area</label>
                                       <div class="controls">
                                          <input type="text"  class="m-wrap large" name="asset_kept_area" value="<?php echo $dataArray['asset_kept_area']?>" required/>
                                          
                                       </div>
                                    </div>
                                           
                                  <div class="control-group">
                                       <label class="control-label">Asset Description</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="asset_description" required><?php echo $dataArray['asset_description']?></textarea>
                                       </div>
                                    </div>
                                      
                                    <div class="control-group">
                                       <label class="control-label">Model Number</label>
                                       <div class="controls">
                                          <input type="text"  class="m-wrap large" name="model_number" 
                                          value="<?php echo $dataArray['model_number']?>" required/>
                                    
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Serial Number</label>
                                       <div class="controls">
                                          <input type="text"  class="m-wrap large" name="serial_number" 
                                          value="<?php echo $dataArray['serial_number']?>" required/>
                                    
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Aggreement Number</label>
                                       <div class="controls">
                                          <input type="text" class="m-wrap large" name="aggreement_number" 
                                          value="<?php echo $dataArray['aggreement_number']?>" />
                                          
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Asset Condition</label>
                                       <div class="controls">
										<?php $active=($dataArray['asset_condition']=='active')?'checked':''; ?>
   										<?php $deactive=($dataArray['asset_condition']=='deactive')?'checked':''; ?>
                                        <?php $scrap=($dataArray['asset_condition']=='scrap')?'checked':''; ?>

                                          <label class="radio">
                                          <input type="radio" name="asset_condition" value="active" <?php echo $active ?> required/>
                                          Active
                                          </label>
                                          <label class="radio">
                                          <input type="radio" name="asset_condition" value="deactive"  <?php echo $deactive ?> required/>
                                          Deactive
                                          </label>  
                                          <label class="radio">
                                          <input type="radio" name="asset_condition" value="scrap" <?php echo $scrap ?> required/>
                                          Scrap
                                          </label>  
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Safty Cautions</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" name="safty_caution" rows="3"><?php echo $dataArray['safty_caution']?></textarea>
                                       </div>
                                    </div>
                                    
                                    
                                    <div class="control-group">
                                       <label class="control-label">Consern Person Email</label>
                                       <div class="controls">
                                          <input type="text" class="m-wrap large" name="consern_emails" 
                                          value="<?php echo $dataArray['consern_emails']?>" />
                                          
                                       </div>
                                    </div>
                                    
                                    
                                    <hr>
                                    
                                    <div class="form-actions">
                                       <button type="submit" name="asset" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" onClick="javascript:window.history.back();">Cancel</button>
                                    </div>
                                 </form>
                                 <!-- tab 1, asset detail ends -->  
                              </div>
                                
                                 <!--#################### purchase details part start tab2 ##############################-->  
                                 <!-- tab 2, purchase detail-->  
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
                                       <div class="controls">
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
                                 <!-- tab 2 purchase details ends--> 
                           <!--#################### purchase details part ends ##############################-->   
                                 
                          <!-- tab 3, maintenance detail-->  
                              <div class="tab-pane " id="portlet_tab3">

 							 <div class="portlet-body">
								<div class="clearfix">
                                		

									
								</div>
								
							</div>

                                   
                                   <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											<th>Code</th>
											<th>Maintenance Type</th>
											<th>Start Date</th>
											<th>Recurence Schedule</th>
											<th>Day / Date</th>                                            
											<th>Frequency</th>											
                                            <th>Month</th>                                           
										
                                        </tr>
									</thead>
									
                                    
                                    <tbody>
									
       <?php
		$sql="select a.asset_code, m.maintenance_type, s.schedule_id, s.activation_date, s.recurrence_schedule, s.[day], s.frequency, s.[month] 
 from schedule s 
 left join asset_master a on s.asset_id=a.asset_id
 left join maintenance_type_master m on m.maintenance_type_id=s.maintenance_type_id 
 

     where a.factory_id='".$_SESSION['factory-id']."' and s.asset_id='".$_REQUEST['pid']."'
	 ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$f['asset_code'].'</td>';
										echo '<td>'.$f['maintenance_type'].'</td>';										
										echo '<td>'.$f['activation_date'].'</td>';																
										echo '<td>'.ucfirst($f['recurrence_schedule']).'</td>';	
										
										if(trim($f['recurrence_schedule'])=='weekly'){
											$arr=array('Monday','Tuesday','Wednesday','Thrusday','Friday','Saturday','Sunday');
											$v=$f['day']-1;
											echo '<td>'.$arr[$v].'</td>';
										}else{
											echo '<td>'.$f['day'].'</td>';
										}
										echo '<td>'.$f['frequency'].'</td>';
										echo '<td>'.$f['month'].'</td>';

									}
									?>
       
									</tbody>
                                    
                                   
								</table>
                                
                           <hr>

                           
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