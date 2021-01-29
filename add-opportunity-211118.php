<?php 

	        $pm='active';
	        $lopp='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
        include('including/datetime.php');

$timestamp=date('Y-m-d H:i:s');
//print_r($_SESSION);
//asset part starts


//print_r($_REQUEST);


$pid=(int)$_REQUEST['pid'];		
if(isset($_GET['pid']) && $_GET['pid']>0){

//action plan_project_session_id
	$_SESSION['action_plan_opp_id']=$_REQUEST['pid'];	
		
		$pid = (int)$_GET['pid'];
		$formType = 'Update Opportunity Details ';
		
		$btsel="select * from opportunity where opportunity_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		
		//print_r($f);
		$_SESSION['working-active-asset']=$f['asset_code'];
		$dataArray=array(

					'deal_type'					=>	trim(dbOutput($f['deal_type'])),
					'territory'					=>	trim(dbOutput($f['territory'])),
			
					'ckaname'					=>	trim(dbOutput($f['cka_name_id'])),
					'cka_type'					=>	trim(dbOutput($f['cka_type_id'])),
					'project_type'				=>	trim(dbOutput($f['project_type_id'])),
					'project_name'				=>	trim(dbOutput($f['project_name'])),
					'state'						=>	trim(dbOutput($f['state_id'])),
					'city'						=>	trim(dbOutput($f['city'])),
					'contractor_firm_name'		=>	trim(dbOutput($f['contractor_firm_name'])),
					'project_contact_name'		=>	trim(dbOutput($f['project_contact_name'])),
					'project_contact_no'		=>	trim(dbOutput($f['project_contact_no'])),
					'architect_firm_name'		=>	trim(dbOutput($f['architect_firm_name'])),
					'architect_name'			=>	trim(dbOutput($f['architect_name'])),
					'architect_contact_no'		=>	trim(dbOutput($f['architect_contact_no'])),
					'obl_approval_status'		=>	trim(dbOutput($f['obl_approval_status'])),
					'tile_stage_date'			=>	trim(dbOutput($f['tile_stage_date'])),
					'opp_remark'				=>	trim(dbOutput($f['opp_remark'])),
					'obl_sales_forecast'		=>	trim(dbOutput($f['obl_sale_forecast_inr'])),
					'probability_of_win'		=>	trim(dbOutput($f['probability_of_win'])),
					'tile_potential_sqm'		=>	trim(dbOutput($f['project_tile_potential_sqm'])),
					'tile_potential_inr'		=>	trim(dbOutput($f['project_tile_potential_inr'])),
					'status'					=>  trim(dbOutput($f['status'])),
					'current_stage'				=>  trim(dbOutput($f['current_stage'])),
					'tender_reference_no'		=>	trim(dbOutput($f['tender_reference_no'])),
					'gps_department_name'		=>	trim(dbOutput($f['gps_department_name']))
			);

	//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add New Opportunity';

	}


if(isset($_POST['opportunity'])){
		

		$dataArray=array(
					'deal_type'					=>	trim(dbOutput($_POST['deal_type'])),
					'retail_acc_name'			=>	trim(dbOutput($_POST['retail_acc_name'])),
					'territory'					=>	trim(dbOutput($_POST['territory'])),
					'architect_firm_name_others' => trim(dbOutput($_POST['architect_firm_name_others'])),
					'architect_firm_type'		=>	trim(dbOutput($_POST['architect_firm_type'])),
		
					'ckaname'					=>	trim(dbOutput($_POST['ckaname'])),
					'cka_type'					=>	trim(dbOutput($_POST['cka_type'])),
					'project_type'				=>	trim(dbOutput($_POST['project_type'])),
					'project_name'				=>	trim(dbOutput($_POST['project_name'])),
					'state'						=>	trim(dbOutput($_POST['state'])),
					'city'						=>	trim(dbOutput($_POST['city'])),
					'contractor_firm_name'		=>	trim(dbOutput($_POST['contractor_firm_name'])),
					'project_contact_name'		=>	trim(dbOutput($_POST['project_contact_name'])),
					'project_contact_no'		=>	trim(dbOutput($_POST['project_contact_no'])),
					'architect_firm_name'		=>	trim(dbOutput($_POST['architect_firm_name'])),
					'architect_name'			=>	trim(dbOutput($_POST['architect_name'])),
					'architect_contact_no'		=>	trim(dbOutput($_POST['architect_contact_no'])),
					'obl_approval_status'		=>	trim(dbOutput($_POST['obl_approval_status'])),
					'tile_stage_date'			=>	trim(dbOutput($_POST['tile_stage_date'])),
					'opp_remark'				=>	trim(dbOutput($_POST['opp_remark'])),
					'obl_sales_forecast'		=>	trim(dbOutput($_POST['obl_sales_forecast'])),
					'probability_of_win'		=>	trim(dbOutput($_POST['probability_of_win'])),
					'tile_potential_sqm'		=>	trim(dbOutput($_POST['tile_potential_sqm'])),
					'tile_potential_inr'		=>	trim(dbOutput($_POST['tile_potential_inr'])),
					'status'					=>  trim(dbOutput($_POST['status'])),
					'tender_reference_no'		=>	trim(dbOutput($_POST['tender_reference_no'])),
					'gps_department_name'		=>	trim(dbOutput($_POST['gps_department_name']))
			);
		

	if($dataArray['architect_firm_name']=='Others'){
		$dataArray['architect_firm_name']=$dataArray['architect_firm_name_others'];
		$dataArray['architect_firm_type']='Other Architect';
	}else{
			$dataArray['architect_firm_type']='Key Architect';
	}

	if(!empty(trim($dataArray['retail_acc_name']))){
		$dataArray['ckaname']=$dataArray['retail_acc_name'];
	}


//echo '<pre>';
//print_r($dataArray);
	

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){
			
		 $upd  ="UPDATE opportunity set 
		 deal_type	='".dbInput($dataArray['deal_type'])."', 
		 cka_name_id='".dbInput($dataArray['ckaname'])."',
		 cka_type_id='".dbInput($dataArray['cka_type'])."',
		 project_type_id='".dbInput($dataArray['project_type'])."',
		 project_name='".dbInput($dataArray['project_name'])."',
		 state_id='".dbInput($dataArray['state'])."',
		 city='".dbInput($dataArray['city'])."',
		 territory = '".dbInput($dataArray['territory'])."',
		 contractor_firm_name='".dbInput($dataArray['contractor_firm_name'])."',
		 project_contact_name='".dbInput($dataArray['project_contact_name'])."',
		 project_contact_no='".dbInput($dataArray['project_contact_no'])."',
		 architect_firm_name='".dbInput($dataArray['architect_firm_name'])."',
		 architect_name='".dbInput($dataArray['architect_name'])."',
		 architect_contact_no='".dbInput($dataArray['architect_contact_no'])."',
		 obl_approval_status = '".dbInput($dataArray['obl_approval_status'])."',
		 tile_stage_date='".dbInput($dataArray['tile_stage_date'])."',
		 opp_remark='".dbInput($dataArray['opp_remark'])."',
		 obl_sale_forecast_inr='".dbInput($dataArray['obl_sales_forecast'])."',
 		 probability_of_win='".dbInput($dataArray['probability_of_win'])."',
		 project_tile_potential_sqm='".dbInput($dataArray['tile_potential_sqm'])."',		 
		project_tile_potential_inr='".dbInput($dataArray['tile_potential_inr'])."',		 
		last_modified='".dbInput($timestamp)."',		 
		modified_by='".dbInput($_SESSION['uid'])."'		 
		  ";

if(!empty($dataArray['tender_reference_no'])){
	$upd .=" , tender_reference_no='".dbInput($dataArray['tender_reference_no'])."' ";
}

if(!empty($dataArray['gps_department_name'])){
	$upd .=" , gps_department_name='".dbInput($dataArray['gps_department_name'])."' ";
}

				if($dataArray['status'] =='close'){
					$current_stage='2';
					 $upd .=" , fld_date='".dbInput($timestamp)."', current_stage = '".dbInput($current_stage)."'	 ";
				}else{
					
					if($dataArray['status']=='lost')
					 $upd .=" , lost_date='".dbInput($timestamp)."', status='".dbInput($dataArray['status'])."'	";						
					else
					 $upd .=" , status='".dbInput($dataArray['status'])."'	";						
				}

		 $upd .=" where opportunity_id='".(int)dbInput($pid)."'";
		
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Opportunity Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update Opportunity Details , Please Try Later.';
					$msgType = 2;
				}
		}else{

				$current_stage='1';
				$state_no = dbInput($dataArray['state']);
				$code = "SELECT * from state_master where state_id = '$state_no'";
				
				$result = odbc_execute($conn,$code);
				while($ff = odbc_fetch_row($result)){
					$state_code = $ff['state_code'];	
				}

				$lead_id = $state_code.$unique;
					var_dump($lead_id);
					exit();

	
				$insert  ="INSERT INTO opportunity (
				lead_id,
				deal_type,
				territory,
				architect_firm_type,
				cka_name_id,
				cka_type_id,
				project_type_id,
				project_name,
				state_id,
				city,
				contractor_firm_name,
				project_contact_name,
				project_contact_no,
				architect_firm_name,
				architect_name,
				architect_contact_no,
				obl_approval_status,
				tile_stage_date,
				opp_remark,
				obl_sale_forecast_inr,
				probability_of_win,
				project_tile_potential_sqm,
				project_tile_potential_inr,
				status,
				current_stage,
				added_date,
				last_modified,
				created_by,
				tender_reference_no,
				gps_department_name
				)";
				$insert .="values(
				'".dbInput($lead_id)."', 
				'".dbInput($dataArray['deal_type'])."', 
				'".dbInput($dataArray['territory'])."', 
				'".dbInput($dataArray['architect_firm_type'])."', 
												
				'".dbInput($dataArray['ckaname'])."', 
				'".dbInput($dataArray['cka_type'])."', 
				'".dbInput($dataArray['project_type'])."', 
				'".dbInput($dataArray['project_name'])."', 
				'".dbInput($dataArray['state'])."', 
				'".dbInput($dataArray['city'])."', 
				'".dbInput($dataArray['contractor_firm_name'])."', 
				'".dbInput($dataArray['project_contact_name'])."', 
				'".dbInput($dataArray['project_contact_no'])."', 
				'".dbInput($dataArray['architect_firm_name'])."', 
				'".dbInput($dataArray['architect_name'])."', 
				'".dbInput($dataArray['architect_contact_no'])."', 
				'".dbInput($dataArray['obl_approval_status'])."', 
				'".dbInput($dataArray['tile_stage_date'])."',
				'".dbInput($dataArray['opp_remark'])."',
				'".dbInput($dataArray['obl_sales_forecast'])."', 
				'".dbInput($dataArray['probability_of_win'])."', 
				'".dbInput($dataArray['tile_potential_sqm'])."', 
				'".dbInput($dataArray['tile_potential_inr'])."', 
				'".dbInput($dataArray['status'])."', 
				'".dbInput($current_stage)."', 
				'".dbInput($timestamp)."',
				'".dbInput($timestamp)."',
 			    '".dbInput($_SESSION['uid'])."',
				'".dbInput($dataArray['tender_reference_no'])."', 
				'".dbInput($dataArray['gps_department_name'])."'
				) ";

				//echo $insert;
				$_SESSION['working-active-asset']=$dataArray['asset_code'];
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Opportunity Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Opportunity Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				
		header('Location:list-opportunity.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
		exit;

	}//empty error array check ends here
}//main post end here	

//asset part ends here




?>

<script src="assets/js/jquery-1.8.3.min.js"></script>
    <script>
  
    $( window ).on( "load", function() {
        codeAcc();
    });
    </script>
	
<script type="text/javascript">
        function codeAcc() {
				$("#p").hide();	
				$("#q").hide();	

           if(document.getElementById("deal_type").value=='CKA'){
				$("#p").show();
				$("#q").hide();	
			}

           if(document.getElementById("deal_type").value=='Retail'){
				$("#q").show();
				$("#p").hide();	
			}
	    }
        window.onload = codeAcc;
        </script>
	
    
    <script type="text/javascript">
        function codeArch() {
			$("#p").hide();	
			$("#q").hide();
				
				$("#z").hide();	

           if(document.getElementById("architect_firm_name").value=='Others'){
				$("#z").show();
			}

           if(document.getElementById("architect_firm_name").value!='Others'){
				$("#z").hide();
			}
       
	    }
        window.onload = codeArch;
        </script>  

 
 <script type="text/javascript">
        function showGPS() {

				$("#gps").hide();	

           if(document.getElementById("project_type").value==2){
				$("#gps").show();
			}

           if(document.getElementById("project_type").value!=2){
				$("#gps").hide();
			}
       
	    }
        window.onload = showGPS;
        </script>  
        
  
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480"><?php echo $formType?></span>
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
									
                              <input type="hidden" name="deal_type_db_value" id="deal_type_db_value" value="<?php echo trim($dataArray['deal_type'])?>"> 

 
                                   <div class="control-group">
                                       <label class="control-label">Deal Type</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="deal_type"  id="deal_type"  onchange="codeAcc()" required>
                                          <option value="">-Select-</option>
                                          <option value="CKA" <?php echo ($dataArray['deal_type']=='CKA')?'selected':''?>>CKA</option>
                                          <option value="Retail" <?php echo ($dataArray['deal_type']=='Retail')?'selected':''?>>Retail</option>

                                          </select>
                                       </div>
                                    </div>
<?php                                    
   if(isset($_REQUEST['pid']) && $_REQUEST['pid']>0){
 ?>
							<div class="control-group">
                              <label class="control-label">Account Name</label>
                              <div class="controls">

             <select data-placeholder="Select Account Name" class="chosen-with-diselect span6" tabindex="-1" id="ckaname" name="ckaname" >
 <?php  
					 $sql="select * from cka_name_master where account_type='".trim($dataArray['deal_type'])."' ";
                        $rs=odbc_exec($conn,$sql);
                        while($f = odbc_fetch_array($rs)){
							
							$selected=($f['cka_name_id']==$dataArray['ckaname'])?'selected':'';
						
							echo '<option value="'.$f['cka_name_id'].'" '.$selected.'>'.$f['cka_name'].'</option>';
                        }
			echo '</select>';
			echo '</div>';
			echo '</div>';
   }else{
?>
			<table border="0" width="100%" >
            <tr id="p">
            <td>                                  
							<div class="control-group">
                              <label class="control-label">Account Name</label>
                              <div class="controls">

             <select data-placeholder="Select Account Name" class="chosen-with-diselect span6" tabindex="-1" id="ckaname" name="ckaname" >

							<?php
                                if(isset($_REQUEST['pid']) && $_REQUEST['pid']>0){
                               echo $sqla="select * from cka_name_master where cka_name_id='".$dataArray['ckaname']."' and account_type='CKA'";
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
                        $sql="select * from cka_name_master where account_type='CKA'";
                        $rs=odbc_exec($conn,$sql);
                        while($f = odbc_fetch_array($rs)){
                        echo '<option value="'.$f['cka_name_id'].'" >'.$f['cka_name'].'</option>';
                        }
                        ?>

                                 </select>
                              </div>
                           </div>
                 </td>
                 </tr>
                 
           
            <tr id="q">
            <td>                                  
							<div class="control-group">
                              <label class="control-label">Account Name</label>
                              <div class="controls">

             <select data-placeholder="Select Account Name" class="chosen-with-diselect span6" tabindex="-1" id="retail_acc_name" name="retail_acc_name" >

							<?php
                                if(isset($_REQUEST['pid']) && $_REQUEST['pid']>0){
                                $sqla="select * from cka_name_master where cka_name_id='".$dataArray['ckaname']."' and account_type='Retail' ";
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
                        $sql="select * from cka_name_master where account_type='Retail' ";
                        $rs=odbc_exec($conn,$sql);
                        while($f = odbc_fetch_array($rs)){
                        echo '<option value="'.$f['cka_name_id'].'" >'.$f['cka_name'].'</option>';
                        }
                        ?>

                                 </select>
                              </div>
                           </div>
                 </td>
                 </tr>
             </table>        

<?php } // else end - edit/account name part?>                           
                                   
                                   <div class="control-group">
                                       <label class="control-label">Account Type</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="cka_type" required  >
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
                                          <select class="medium m-wrap"  name="project_type" id="project_type"  onchange="showGPS()" required>
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
                                  
<table>
<tr id="gps">
<td>

	                                <div class="control-group">
                                       <label class="control-label">Tender Reference No</label>
                                       <div class="controls">
                        <input type="text"  class="m-wrap large" name="tender_reference_no" value="<?php echo $dataArray['tender_reference_no']?>"  />
                                       </div>
                                    </div>

	                                <div class="control-group">
                                       <label class="control-label">GPS Department Name</label>
                                       <div class="controls">
                        <input type="text"  class="m-wrap large" name="gps_department_name" value="<?php echo $dataArray['gps_department_name']?>"  />
                                       </div>
                                    </div>
</td>
</tr>
</table>


                                          <div class="control-group">
                                       <label class="control-label">Project Name</label>
                                       <div class="controls">
                        <input type="text"  class="m-wrap large" name="project_name" required value="<?php echo $dataArray['project_name']?>"  />
                                          
                                       </div>
                                    </div>
                       
							
                            <div class="control-group">
                                       <label class="control-label">State</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="state" required   >
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
                                       <label class="control-label">Territory</label>
                                       <div class="controls">

  <select data-placeholder="Select Territory" class="chosen-with-diselect span6" tabindex="-1" id="territory" name="territory" style="width:220px;">

                                          <option value="">-Select-</option>
                                            <?php
	
										if($_SESSION['employee_department']=='Retail' ){
										
										$sql="select * from territory_master where  ";
										
										$ex=explode(",",$_SESSION['employee_territory']);
												$xcnt=0;
												foreach ($ex as $vx){
												//echo $vx;
												if($xcnt==0)
													$sql .="territory_id = '".$vx."' ";
												else
													$sql .=" or territory_id = '".$vx."'  ";
												$xcnt++;
											}
									}else{
										$sql="select * from territory_master";
									}

									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									$selected=($f['territory_id']==$dataArray['territory'])?'selected':'';
									echo '<option value="'.$f['territory_id'].'"'.$selected.'>'.$f['territory_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>



                                    <div class="control-group">
                                       <label class="control-label">City</label>
                                       <div class="controls">
                    <input type="text"  class="m-wrap medium name=" name="city" value="<?php echo $dataArray['city']?>"  />
                                       </div>
                                    </div>
                                    
                                                                        

									<div class="control-group">
                                       <label class="control-label">Contactor Firm Name</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="contractor_firm_name" value="<?php echo $dataArray['contractor_firm_name']?>" />
                                       </div>
                                    </div>
                                    


									<div class="control-group">
                                       <label class="control-label">Project Contact Person</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="project_contact_name" value="<?php echo $dataArray['project_contact_name']?>" />
                                       </div>
                                    </div>
									
                                    <div class="control-group">
                                       <label class="control-label">Project Contact No.</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="project_contact_no" value="<?php echo $dataArray['project_contact_no']?>" />
                                       </div>
                                    </div>




<?php                                    
   if(isset($_REQUEST['pid']) && $_REQUEST['pid']>0){

	if($dataArray['architect_firm_type']=='Key Architect'){
		
	?>
							 <div class="control-group">
                                       <label class="control-label">Architect Firm Name</label>
                                       <div class="controls">

             <select data-placeholder="Select Firm Name" class="chosen-with-diselect span6" tabindex="-1" id="architect_firm_name" name="architect_firm_name"  style="width:335px;" onchange="codeArch()">
                                          <option value="">-Select-</option>
                                          <option value="Others">Others</option>
                                          
                                            <?php
									$sql="select * from key_architect_master";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									$selected=($f['key_architect_id']==$dataArray['key_architect_id'])?'selected':'';
									echo '<option value="'.$f['key_architect_id'].'"'.$selected.'>'.$f['key_architect_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                    
<?php 
	}else{
	echo '<div class="control-group">';
		echo '<label class="control-label">Architect Firm Name</label>';
			echo '<div class="controls">';
				echo '<input type="text"  class="m-wrap large name=" name="architect_firm_name" value="'.$dataArray['architect_firm_name'].'" />';
			echo '</div>';
	echo '</div>';								
	}
   }else{
?>


									 <div class="control-group">
                                       <label class="control-label">Architect Firm Name</label>
                                       <div class="controls">

             <select data-placeholder="Select Firm Name" class="chosen-with-diselect span6" tabindex="-1" id="architect_firm_name" name="architect_firm_name"  style="width:335px;" onchange="codeArch()">
                                          <option value="">-Select-</option>
                                          <option value="Others">Others</option>
                                          
                                            <?php
									$sql="select * from key_architect_master";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									$selected=($f['key_architect_name']==$dataArray['architect_firm_name'])?'selected':'';
									echo '<option value="'.$f['key_architect_name'].'"'.$selected.'>'.$f['key_architect_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                    


			<table border="0" width="100%" >
            	<tr id="z">
	                <td>  
                    <div class="control-group">
                          <label class="control-label">(Others)</label>
                     	<div class="controls">
				   	<input type="text"  class="m-wrap large name=" name="architect_firm_name_others" value="<?php echo $dataArray['architect_name']?>" />
                         </div>
                   </div>
                    </td>
            	</tr>
            </table>

<?php } ?>
									<div class="control-group">
                                       <label class="control-label">Architect Name</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="architect_name" value="<?php echo $dataArray['architect_name']?>" />
                                       </div>
                                    </div>
									
                                    
                                    <div class="control-group">
                                       <label class="control-label">Architect Contact No.</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="architect_contact_no" value="<?php echo $dataArray['architect_contact_no']?>" />
                                       </div>
                                    </div>


                                  <div class="control-group">
                                       <label class="control-label">OBL Approval Status</label>
                                       <div class="controls">
                                          <select class="large m-wrap"  name="obl_approval_status" required="required">
                                          <option value="">-Select-</option>
										
                                         <option value="Brand Approved and SKU Approved" <?php echo ($dataArray['obl_approval_status'])=='Brand Approved and SKU Approved' ? 'selected' : '' ?>>Brand Approved and SKU Approved</option>

 <option value="Brand Approved and SKU In Process" <?php echo ($dataArray['obl_approval_status'])=='Brand Approved and SKU In Process' ? 'selected' : '' ?>>Brand Approved and SKU In Process</option>

 <option value="Brand Approval In Process" <?php echo ($dataArray['obl_approval_status'])=='Brand Approval In Process' ? 'selected' : '' ?>>Brand Approval In Process</option>

 <option value="Only SKU Approved" <?php echo ($dataArray['obl_approval_status'])=='Only SKU Approved' ? 'selected' : '' ?>>Only SKU Approved</option>

 <option value="Not Approved" <?php echo ($dataArray['obl_approval_status'])=='Not Approved' ? 'selected' : '' ?>>Not Approved</option>
                                          
									
                                    </select>
                                       </div>
                                    </div>


                                    
                                   <div class="control-group">
                              <label class="control-label">Tile Stage Date</label>
                              <div class="controls">
               <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="tile_stage_date" value="<?php echo $dataArray['tile_stage_date']?>" />
                              </div>
                           </div>



                                    <div class="control-group">
                                       <label class="control-label">Overall Tile Potential (SQM)</label>
                                       <div class="controls">
 <input type="number"  class="m-wrap medium name=" name="tile_potential_sqm" value="<?php echo $dataArray['tile_potential_sqm']?>"  />
                                       </div>
                                    </div>
                                          
                       
                       
                                    <div class="control-group">
                                       <label class="control-label"> Overall Tile Potential (INR)</label>
                                       <div class="controls">
  <input type="number"  class="m-wrap medium name=" name="tile_potential_inr" value="<?php echo $dataArray['tile_potential_inr']?>"  />
                                       </div>
                                    </div>



                                    

                                    <div class="control-group">
                                       <label class="control-label">OBL Sales Forecast (INR)</label>
                                       <div class="controls">
        <input type="number"  class="m-wrap medium name=" name="obl_sales_forecast" value="<?php echo $dataArray['obl_sales_forecast']?>"  />
                                       </div>
                                    </div>
                                    
                       
                     			
                                
                                  <div class="control-group">
                                       <label class="control-label">Winning Probability</label>
                                       <div class="controls">
                                          <select class="medium m-wrap"  name="probability_of_win"   >
                                          <option value="">-Select-</option>
                          <option value="High" <?php echo ($dataArray['probability_of_win'])=='High' ? 'selected' : '' ?>>High</option>
                          <option value="Medium" <?php echo ($dataArray['probability_of_win'])=='Medium' ? 'selected' : '' ?>>Medium</option>
                          <option value="Low" <?php echo ($dataArray['probability_of_win'])=='Low' ? 'selected' : '' ?>>Low</option>

                                          
                                          </select>
                                       </div>
                                    </div>
									
									<div class="control-group">
                                       <label class="control-label">Opportunity Remarks</label>
                                       <div class="controls">
				   <input type="text"  class="m-wrap large name=" name="opp_remark" required value="<?php echo $dataArray['opp_remark']?>" />
                                       </div>
                                    </div>
                                    
                    <?php
						if(isset($_REQUEST['pid']) && $_REQUEST['pid']>0 && $dataArray['current_stage'] =='1' ){
						
					?>             
                           
                                    <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
										<?php $open=($dataArray['status']=='open')?'checked':''; ?>
   										<?php $close=($dataArray['status']=='close')?'checked':''; ?>
    									<?php $lost=($dataArray['status']=='lost')?'checked':''; ?>

                                        <label class="radio">
                                          <input type="radio" name="status" value="open" <?php echo $open ?>   id="open"/>
                                          <span style="font-weight:bold; color:#090">Open</span>
                                          </label>

                                         <label class="radio">
                                          <input type="radio" name="status" value="close" <?php echo $close ?>   id="move"/>
                                          <span style="font-weight:bold; color:#F60">Move to First Discussion</span>
                                          </label>
                                          
                                          <label class="radio">
                                          <input type="radio" name="status" value="lost"  <?php echo $lost ?>   id="lost"/>
                                           <span style="font-weight:bold; color:#F00">Lost</span>
                                          </label>  
                                    
                                       </div>
                                    </div>

                      <?php }else{
					  		echo '<input type="hidden" name="status" value="open">';
					  }?>              
                                    
                                    <hr>
                                    
                                    <div class="form-actions">
                                       <button type="submit" name="opportunity" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <a href="list-opportunity.php"><button type="button" class="btn">Cancel</button></a>
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