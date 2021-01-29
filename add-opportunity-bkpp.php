<?php 
	        $pm='active';
	        $lopp='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
$timestamp=date('Y-m-d H:i:s');
print_r($_SESSION);
//asset part starts


print_r($_REQUEST);


$pid=(int)$_REQUEST['pid'];		
if(isset($_GET['pid']) && $_GET['pid']>0){
		
		$pid = (int)$_GET['pid'];
		$formType = 'Update Opportunity Details ';
		
		$btsel="select * from opportunity where opportunity_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		
		//print_r($f);
		$_SESSION['working-active-asset']=$f['asset_code'];
		$dataArray=array(
					'ckaname'					=>	trim(dbOutput($f['cka_name_id'])),
					'cka_type'					=>	trim(dbOutput($f['cka_type_id'])),
					'project_type'				=>	trim(dbOutput($f['project_type_id'])),
					'project_name'				=>	trim(dbOutput($f['project_name'])),
					'state'						=>	trim(dbOutput($f['state_id'])),
					'city'						=>	trim(dbOutput($f['city'])),
					'project_contact_name'		=>	trim(dbOutput($f['project_contact_name'])),
					'project_contact_no'		=>	trim(dbOutput($f['project_contact_no'])),
					'architect_name'			=>	trim(dbOutput($f['architect_name'])),
					'architect_contact_no'		=>	trim(dbOutput($f['architect_contact_no'])),
					'tile_stage_date'			=>	trim(dbOutput($f['tile_stage_date'])),
					'obl_sales_forecast'		=>	trim(dbOutput($f['obl_sale_forecast_inr'])),
					'probability_of_win'		=>	trim(dbOutput($f['probability_of_win'])),
					'tile_potential_sqm'		=>	trim(dbOutput($f['project_tile_potential_sqm'])),
					'tile_potential_inr'		=>	trim(dbOutput($f['project_tile_potential_inr'])),
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
					'project_contact_name'		=>	trim(dbOutput($_POST['project_contact_name'])),
					'project_contact_no'		=>	trim(dbOutput($_POST['project_contact_no'])),
					'architect_name'			=>	trim(dbOutput($_POST['architect_name'])),
					'architect_contact_no'		=>	trim(dbOutput($_POST['architect_contact_no'])),
					'tile_stage_date'			=>	trim(dbOutput($_POST['tile_stage_date'])),
					'obl_sales_forecast'		=>	trim(dbOutput($_POST['obl_sales_forecast'])),
					'probability_of_win'		=>	trim(dbOutput($_POST['probability_of_win'])),
					'tile_potential_sqm'		=>	trim(dbOutput($_POST['tile_potential_sqm'])),
					'tile_potential_inr'		=>	trim(dbOutput($_POST['tile_potential_inr'])),
					'status'					=>  trim(dbOutput($_POST['status']))
			);
//echo '<pre>';
//print_r($dataArray);
	

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE asset_master set 
		 cka_name_id='".dbInput($dataArray['ckaname'])."',
		 cka_type_id='".dbInput($dataArray['cka_type'])."',
		 project_type_id='".dbInput($dataArray['project_type'])."',
		 project_name='".dbInput($dataArray['project_name'])."',
		 state_id='".dbInput($dataArray['state'])."',
		 city='".dbInput($dataArray['city'])."',
		 project_contact_name='".dbInput($dataArray['project_contact_name'])."',
		 project_contact_no='".dbInput($dataArray['project_contact_no'])."',
		 architect_name='".dbInput($dataArray['architect_name'])."',
		 architect_contact_no='".dbInput($dataArray['architect_contact_no'])."',
		 tile_stage_date='".dbInput($dataArray['tile_stage_date'])."',
		 obl_sale_forecast_inr='".dbInput($dataArray['tile_potential_sqm'])."',
 		 probability_of_win='".dbInput($dataArray['tile_potential_inr'])."',
		 project_tile_potential_sqm='".dbInput($dataArray['obl_sales_forecast'])."',		 
		project_tile_potential_inr='".dbInput($dataArray['probability_of_win'])."',		 
		status='".dbInput($dataArray['status'])."',		 
		last_modified='".dbInput($dataArray['consern_emails'])."',		 
		modified_by='".dbInput($_SESSION['uid'])."'		 
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
				project_contact_name,
				project_contact_no,
				architect_name,
				architect_contact_no,
				tile_stage_date,
				obl_sale_forecast_inr,
				probability_of_win,
				project_tile_potential_sqm,
				project_tile_potential_inr,
				status,
				added_date,
				last_modified,
				created_by
				)";
				$insert .="values(
				'".dbInput($dataArray['ckaname'])."', 
				'".dbInput($dataArray['cka_type'])."', 
				'".dbInput($dataArray['project_type'])."', 
				'".dbInput($dataArray['project_name'])."', 
				'".dbInput($dataArray['state'])."', 
				'".dbInput($dataArray['city'])."', 
				'".dbInput($dataArray['project_contact_name'])."', 
				'".dbInput($dataArray['project_contact_no'])."', 
				'".dbInput($dataArray['architect_name'])."', 
				'".dbInput($dataArray['architect_contact_no'])."', 
				'".dbInput($dataArray['tile_stage_date'])."', 
				'".dbInput($dataArray['obl_sales_forecast'])."', 
				'".dbInput($dataArray['probability_of_win'])."', 
				'".dbInput($dataArray['tile_potential_sqm'])."', 
				'".dbInput($dataArray['tile_potential_inr'])."', 
				'".dbInput($dataArray['status'])."', 
				'".dbInput($_SESSION['added_date'])."',
				'".dbInput($timestamp)."',
 			    '".dbInput($_SESSION['uid'])."'
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




?>


	  

 
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Add New Opportunity</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Opportunity Details</a></li>			
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
                              <label class="control-label">CKA Name</label>
                              <div class="controls">
                              
								
                                


             <select data-placeholder="Select CKA Name" class="chosen-with-diselect span6" tabindex="-1" id="ckaname" name="ckaname" required>

							<?php
                                if(isset($_REQUEST['pid']) && $_REQUEST['pid']>0){
                               $sqla="select * from cka_name_master where cka_name_id='".$dataArray['ckaname']."'";
                                $rsa=odbc_exec($conn,$sqla);
                                $fa = odbc_fetch_array($rsa);
								//print_r($fa);
                                //echo  $fa['cka_name'];
                                echo '<option value="'.$f['cka_name_id'].'">'.$fa['cka_name'].'</option>';
                                }else{
                                echo '<option value="">-Select-</option>';
                                }
                                ?>
                                
						<?php
                        $sql="select * from cka_name_master";
                        $rs=odbc_exec($conn,$sql);
                        while($f = odbc_fetch_array($rs)){
                        echo '<option value="'.$f['cka_name_id'].'" >'.$f['cka_name'].'</option>';
                        }
                        ?>

                                 </select>
                              </div>
                           </div>
                         

                           
                                   
                                   <div class="control-group">
                                       <label class="control-label">CKA Type</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="cka_type"  required>
                                          <option value="">-Select-</option>
                                             <?php
									$sql="select * from cka_type_master";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										$selected=($f['cka_type_id']==$dataArray['cka_type'])?'selected':'';
										echo '<option value="'.$f['cka_type_id'].'"'.$selected.'>'.$f['cka_type'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="control-group">
                                       <label class="control-label">Project Type</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="project_type"  required>
                                          <option value="">-Select-</option>
                                             <?php
									$sql="select * from project_type_master";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										$selected=($f['project_type_id']==$dataArray['project_type'])?'selected':'';
										echo '<option value="'.$f['project_type_id'].'"'.$selected.'>'.$f['project_type'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                  

                                          <div class="control-group">
                                       <label class="control-label">Project Name</label>
                                       <div class="controls">
                        <input type="text"  class="m-wrap large" name="project_name" value="<?php echo $dataArray['project_name']?>" required/>
                                          
                                       </div>
                                    </div>
                       
							
                            <div class="control-group">
                                       <label class="control-label">State</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="state"  required>
                                          <option value="">-Select-</option>
                                            <?php
									$sql="select * from state_master";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									$selected=($f['state_id']==$dataArray['state'])?'selected':'';
									echo '<option value="'.$f['state_id'].'"'.$selected.'>'.$f['state_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>



                                    <div class="control-group">
                                       <label class="control-label">City</label>
                                       <div class="controls">
                    <input type="text"  class="m-wrap medium name=" name="city" value="<?php echo $dataArray['city']?>" required/>
                                       </div>
                                    </div>
                                    
                                                                        

									<div class="control-group">
                                       <label class="control-label">Project Contact Name</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="project_contact_name" value="<?php echo $dataArray['project_contact_name']?>" required/>
                                       </div>
                                    </div>
									
                                    <div class="control-group">
                                       <label class="control-label">Project Contact No.</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="project_contact_no" value="<?php echo $dataArray['project_contact_no']?>" required/>
                                       </div>
                                    </div>


									<div class="control-group">
                                       <label class="control-label">Architect Name</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="architect_name" value="<?php echo $dataArray['architect_name']?>" required/>
                                       </div>
                                    </div>
									
                                    <div class="control-group">
                                       <label class="control-label">Architect Contact No.</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="architect_contact_no" value="<?php echo $dataArray['architect_contact_no']?>" required/>
                                       </div>
                                    </div>

                                    
                                   <div class="control-group">
                              <label class="control-label">Tile Stage Date</label>
                              <div class="controls">
               <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="12-02-2012"  name="tile_stage_date" value="<?php echo $dataArray['tile_stage_date']?>" />
                              </div>
                           </div>



                                    <div class="control-group">
                                       <label class="control-label">Overall Tile Potential (SQM)</label>
                                       <div class="controls">
 <input type="number"  class="m-wrap medium name=" name="tile_potential_sqm" value="<?php echo $dataArray['tile_potential_sqm']?>" required/>
                                       </div>
                                    </div>
                                          
                       
                       
                                    <div class="control-group">
                                       <label class="control-label"> Overall Tile Potential (INR)</label>
                                       <div class="controls">
  <input type="number"  class="m-wrap medium name=" name="tile_potential_inr" value="<?php echo $dataArray['tile_potential_inr']?>" required/>
                                       </div>
                                    </div>



                                    

                                    <div class="control-group">
                                       <label class="control-label">OBL Sales Forecast (INR)</label>
                                       <div class="controls">
        <input type="number"  class="m-wrap medium name=" name="obl_sales_forecast" value="<?php echo $dataArray['obl_sales_forecast']?>" required/>
                                       </div>
                                    </div>
                                    
                       
                     			
                                
                                  <div class="control-group">
                                       <label class="control-label">Probability of Win</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="probability_of_win"  required>
                                          <option value="">-Select-</option>
                          <option value="high" <?php echo ($dataArray['probability_of_win'])=='high' ? 'selected' : '' ?>>High</option>
                          <option value="high" <?php echo ($dataArray['probability_of_win'])=='medium' ? 'selected' : '' ?>>Medium</option>
                          <option value="high" <?php echo ($dataArray['probability_of_win'])=='low' ? 'selected' : '' ?>>Low</option>

                                          
                                          </select>
                                       </div>
                                    </div>
                                    
                                                     
                           
                                    <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
										<?php $open=($dataArray['status']=='open')?'checked':''; ?>
   										<?php $close=($dataArray['status']=='close')?'checked':''; ?>
    									<?php $lost=($dataArray['status']=='lost')?'checked':''; ?>

                                          <label class="radio">
                                          <input type="radio" name="status" value="open" <?php echo $open ?> required/>
                                          <span style="font-weight:bold; color:#090">Open</span>
                                          </label>
										
                                         <label class="radio">
                                          <input type="radio" name="status" value="move" <?php echo $close ?> required/>
                                          <span style="font-weight:bold; color:#F60">Close</span>
                                          </label>
                                          
                                          <label class="radio">
                                          <input type="radio" name="status" value="close"  <?php echo $lost ?> required/>
                                           <span style="font-weight:bold; color:#F00">Lost</span>
                                          </label>  

                                       </div>
                                    </div>
                                    
                                    
                                    <hr>
                                    
                                    <div class="form-actions">
                                       <button type="submit" name="opportunity" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn" onClick="javascript:window.history.back();">Cancel</button>
                                    </div>
                                 </form>
                                 <!-- tab 1, asset detail ends -->  
                              </div>
                                
                                 <!--#################### purchase details part start tab2 ##############################-->  
                                 <!-- tab 2, purchase detail-->  
                             
                                 
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