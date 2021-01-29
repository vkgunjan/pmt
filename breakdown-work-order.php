<?php 
	ob_start();        
	          $bdm='active';
			$be='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
define('SCRIPT_DEBUG', true);
//print_r($_SESSION);
	//print_r($_POST);
//exit;
//echo $_POST['wo'][0];

if($_POST['form-submit']){
	
	$asset_id=$_POST['asset_id'];

	//print_r($_POST);

echo $sqll="SELECT a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.model_number,
	  a.serial_number,
	  a.safty_caution,
	 a.asset_kept_area
	  ,atm.asset_type
      ,pbm.[plant_building_name]
      ,dsm.[department_section_name]
      ,lm.[location_name]
	  ,a.[asset_condition]
       from asset_master a
	   left join asset_type_master atm on a.asset_type=atm.asset_type_id
	   left join plant_building_master pbm on a.plant_building = pbm.plant_building_id
	   left join department_section_master dsm on a.department_section = dsm.department_section_id
	   left join location_master lm on a.asset_location = lm.location_master_id
     where a.factory_id='".$_SESSION['factory-id']."' and a.asset_id='".trim($asset_id)."'
	 ";
									$rss=odbc_exec($conn,$sqll);
									$fr = odbc_fetch_array($rss);
									echo '<pre>';
									print_r($fr);


       echo $eid=implode(',',$_POST['engineer']);
$wo_date=$_POST['wo_yy'].'-'.$_POST['wo_mm'].'-'.$_POST['wo_dd'];

$dataArray=array(
	'wono'						=> 	trim($_POST['wono']),
	'work_order_date'			=>	trim($wo_date),
	'work_order_time'			=>  trim($_POST['work_order_time']),
	'work_order_end_time'			=>  trim($_POST['work_order_end_time']),
	'work_order_description'	=>  trim($_POST['work_order_description']),
    'workorder_priority'		=>	trim($_POST['priority']),
	'work_order_engineer_id'	=>	trim($eid),
	'wo_type'					=>	trim($_POST['wo_type']),
	  'asset_code'						=> trim($fr['asset_code']),
      'asset_type'						=>trim($fr['asset_type']),
      'asset_name'						=>trim($fr['asset_name']),
      'plant_building'					=>trim($fr['plant_building_name']),
      'dept'							=>trim($fr['department_section_name']),
      'location'						=>trim($fr['location_name']),
      'area'							=>trim($fr['asset_kept_area']),
      'model'							=>trim($fr['model_number']),
      'serial'							=>trim($fr['serial_number']),
      'maintenance_type'				=>trim($_POST['maintenance_type_id']),
      'maintenance_date'				=>trim(date('Y-m-d')),
      'schedule_recurrence'				=>'NA',
      'safty_caution'					=>trim($fr['safty_caution'])

);

 echo $iins=" insert into work_order
([asset_code] ,[asset_type],[asset_name],[plant_building],[dept],[location],[area],[model],[serial],[maintenance_type],[maintenance_date],
	[schedule_recurrence],[safty_caution] ,[work_order_engineer_id] ,[workorder_start_date],[workorder_start_time] , [workorder_end_time] ,	
	 [work_description] , [workorder_generated_timestamp] , schedule_generated_id, 
	factory_id, work_order_type)
	values(
	'".$dataArray['asset_code']."', '".$dataArray['asset_type']."','".$dataArray['asset_name']."','".$dataArray['plant_building']."',
	'".$dataArray['dept']."', '".$dataArray['location']."', '".$dataArray['area']."','".$dataArray['model']."','".$dataArray['serial']."',
	'".$dataArray['maintenance_type']."', '".$dataArray['maintenance_date']."','".$dataArray['schedule_recurrence']."',
	'".$dataArray['safty_caution']."','".$dataArray['work_order_engineer_id']."','".$dataArray['work_order_date']."',
	'".$dataArray['work_order_time']."', '".$dataArray['work_order_end_time']."' , 
	'".$dataArray['work_order_description']."',
	 CURRENT_TIMESTAMP, '0', ".dbInput($_SESSION['factory-id']).", '".$dataArray['wo_type']."' )";
		$sst = odbc_prepare($conn, $iins);
		if (odbc_execute($sst)){ 
			$msgTxt = 'Work Order Generated Sucessfully.';
			$msgType = 2;
			
			//request_id
				$uupd="update breakdown_request set request_status_for_wo='generated' where request_id='".trim($_POST['request_id'])."' ";
				$p=odbc_prepare($conn,$uupd);
				if(odbc_execute($p)){
					header('Location:breakdown-work-order-list.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
					exit;
				}
		}

}else{
	$wo=$_POST['wo'][0];	
}
?>

<script type="text/javascript">
function submitform()
{
 
		var work_order_description=document.getElementById("work_order_description").value;
		var work_order_time=document.getElementById("work_order_time").value; 	
		
		var wo_type=document.getElementById("wo_type").value;
  

if (!wo_type.trim()) {
     alert('Please select work order type');
	 return false;
}


if (!work_order_time.trim()) {
     alert('Please enter work order start time');
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
                           <span class="hidden-480">Work Order Generate</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Work Order</a></li>			
                           </ul>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="myform">
                        <input type="hidden" name="asset_id" value="<?php echo $_POST['asset_id']?>">
				<input type="hidden" name="request_id" value="<?php echo trim($_POST['request_id'])?>">
                        <input type="hidden" name="form-submit" value="form-submit">
                        
                      <!-- tab 1 asset details start --> 
                           <!-- tab 1 asset details start --> 
                           <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
                                            <th>Asset Code</th>
											<th>Type</th>
											<th>Name</th>
											<th>Plant / Building</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>Area</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                            <th>MA Type</th>
                                            <th>MA Date</th>
                                            <th>Work Order Type</th>
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		 $sql="SELECT a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.model_number,
	  a.serial_number,
	  a.safty_caution,
	 a.asset_kept_area
	  ,atm.asset_type
      ,pbm.[plant_building_name]
      ,dsm.[department_section_name]
      ,lm.[location_name]
	  ,a.[asset_condition]
       from asset_master a
	   left join asset_type_master atm on a.asset_type=atm.asset_type_id
	   left join plant_building_master pbm on a.plant_building = pbm.plant_building_id
	   left join department_section_master dsm on a.department_section = dsm.department_section_id
	   left join location_master lm on a.asset_location = lm.location_master_id
     where a.factory_id='".$_SESSION['factory-id']."' and a.asset_id='".trim($_POST['asset_id'])."'
	 ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$f['asset_code'].'</td>';
										echo '<td>'.$f['asset_type'].'</td>';										
										echo '<td>'.$f['asset_name'].'</td>';																
										echo '<td>'.$f['plant_building_name'].'</td>';	
										echo '<td>'.$f['department_section_name'].'</td>';
										echo '<td>'.$f['location_name'].'</td>';
										echo '<td>'.$f['asset_kept_area'].'</td>';
										echo '<td>'.$f['model_number'].'</td>';
										echo '<td>'.$f['serial_number'].'</td>';
	 $msql=" select maintenance_type from maintenance_type_master where maintenance_type_id='".trim($_POST['maintenance_type_id'])."' ";
									$mrs=odbc_exec($conn,$msql);
									$mf = odbc_fetch_array($mrs);
									
										echo '<td>'.$mf['maintenance_type'].'</td>';

										echo '<td>'.date('d-m-Y').'</td>';
										echo '<td>';
										echo '<select name="wo_type" id="wo_type" required style="width:120px;">';
                                       		echo '<option value="">-Select-</option>';
											echo '<option value="BRK">Break Down</option>';
											echo '<option value="UNS">Unscheduled</option>';
									
                                        echo ' </select>';
										echo '</td>';
										$mt_id=$_POST['maintenance_type_id'];
										$safty_caution=$f['safty_caution'];	
										$maintenance_type=$mf['maintenance_type'];									
									}
									?>
									</tbody>
									
								</table>
                                

                           <hr>
						
                     
                        	<table border="0" style="width:100%">
                            	<tr>
                                	<td rowspan="3" valign="top" style=" width: 200px; height:150px;  border: 1px solid #336699; padding-left: 5px">
                               	<b>Select Engineer: </b> 	
									<br>
								
								<?php
									 $ssql="select * from user_management where user_type='engineer' and  maintenance_type='".$mt_id."' and factory_id='".$_SESSION['factory-id']."' ";
									$rrs=odbc_exec($conn,$ssql);
										while($fff = odbc_fetch_array($rrs)){
											if(trim($_SESSION['user_type'])=='engineer'){
											$ch=($_SESSION['uid']==$fff['uid'])?'checked':'disabled';
											}
										echo '<input type="checkbox" name="engineer[]" value='.$fff['uid'].' '.$ch.'>';
										echo $fff['fullname'];
										echo '<br>';

										}
							 ?>
                               
                                     </td>
                                     <td align="right"><b>Work Order Date: </b></td>
                                     	<td>
                                        <select name="wo_dd"  style="width:60px;">
												<?php 
                                                    for($x=date('d'); $x<=31; $x++){
                                                        $selected=($_POST['installation_dd']==$x || date('d')==$x? 'selected' : '');
                                                    if($x<0)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                        
                                        <select name="wo_mm" style="width:120px;">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=date('m')-1;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['installation_mm']==$x || date('m')==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="wo_yy" style="width:80px;">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                        
                                        </td>
                                     
              <td><b>Breakdown Start Time: </b><input type="text" name="work_order_time" id="work_order_time" style="width:50px;"></td>
              <td><b>Breakdown End Time: </b><input type="text" name="work_order_end_time" id="work_order_end_time" style="width:50px;"></td>  
                                     
                                </tr>
                                   </div>
 
        <tr>
            <td align="right" >
            <b>Work Description: </b></td>
   <td colspan="3"><textarea name="work_order_description" id="work_order_description" style="width:95%; height:250px; resize:none;"  ></textarea>
        </td>
    </tr>
                            
        	<tr>
          	      <th style="background-color:#FFFFFF" align="right">Safty Caution:</th>
                <td colspan="11" style="color:#CD0003; background-color:#FFFFFF" ><?php echo $safty_caution; ?></td>
            </tr>
                            
                            </table>

     <input type="hidden" name="maintenance_type_id" value="<?php echo $maintenance_type?>">

									<div  style="text-align:right;">
                                       <a class="btn blue" href="javascript: submitform()"> 
                 <i class="icon-ok"></i> Save</a>
                 
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                             </form>
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