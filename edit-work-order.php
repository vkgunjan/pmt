<?php 
	        $sm='active';
	        $aa='active';
        include_once('including/all-include.php');
        include_once('including/header.php');

if(isset($_REQUEST['woid'])){
	$wo=$_REQUEST['woid'];
}

if(isset($_POST['submit-form']) && $_POST['submit-form']=='submit-form'){
//	print_r($_POST);

 $eid=implode(',',$_POST['engineer']);
$wo_date=$_POST['wo_yy'].'-'.$_POST['wo_mm'].'-'.$_POST['wo_dd'];

$dataArray=array(
	'wono'						=> 	$_POST['woid'],
	'work_order_date'			=>	$wo_date,
	'work_order_time'			=>  $_POST['work_order_time'],
	'work_order_description'	=>  $_POST['work_order_description'],
    'workorder_priority'		=>	$_POST['priority'],
    'work_order_engineer_id'	=>	$eid
);

echo $iins=" update  work_order set
[work_order_engineer_id]  = '".$dataArray['work_order_engineer_id']."',
[workorder_start_date]    = '".$dataArray['work_order_date']."',
[workorder_start_time]    = '".$dataArray['work_order_time']."',
[workorder_priority]      = '".$dataArray['workorder_priority']."',
[work_description] 		  = '".$dataArray['work_order_description']."',
[workorder_generated_timestamp] = CURRENT_TIMESTAMP 
	where workorder_id = '".$dataArray['wono']."' and factory_id = ".dbInput($_SESSION['factory-id'])."  ";
		$sst = odbc_prepare($conn, $iins);
		if (odbc_execute($sst)){ 
			$msgTxt = 'Work Order Updated Sucessfully.';
			$msgType = 2;
			header('Location:generated-work-order-list.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			exit;
		}


}



?>

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
                           <span class="hidden-480">Edit Work Order </span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Work Order Edit</a></li>			
                           </ul>

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
                                            <th>Recurrence</th>
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		$sql="SELECT * from work_order  where factory_id='".$_SESSION['factory-id']."' and workorder_id='".$wo."'	";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$f['asset_code'].'</td>';
										echo '<td>'.$f['asset_type'].'</td>';										
										echo '<td>'.$f['asset_name'].'</td>';																
										echo '<td>'.$f['plant_building'].'</td>';	
										echo '<td>'.$f['dept'].'</td>';
										echo '<td>'.$f['location'].'</td>';
										echo '<td>'.$f['area'].'</td>';
										echo '<td>'.$f['model'].'</td>';
										echo '<td>'.$f['serial'].'</td>';
										echo '<td>'.$f['maintenance_type'].'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['maintenance_date'])).'</td>';
										echo '<td>'.ucfirst($f['schedule_recurrence']).'</td>';
										$safty_caution=$f['safty_caution'];	
										$workorder_start_time=$f['workorder_start_time'];
										$work_description=$f['work_description'];
										$workorder_priority=$f['workorder_priority'];
										$engineer=$f['work_order_engineer_id'];
										$workorder_start_date=$f['workorder_start_date'];
										$mt_id=$f['maintenance_type'];
									}
									?>
									</tbody>
									
								</table>
                                

                           <hr>
						<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="myform">
                        <input type="hidden" name="woid" value="<?php echo $wo?>">
                        <input type="hidden" name="submit-form" value="submit-form">
                     
                        	<table border="0" style="width:100%">
                            	<tr>
                                	<td rowspan="3" valign="top" style=" width: 200px; height:150px;  border: 1px solid #336699; padding-left: 5px">
                               	<b>Select Engineer: </b> 	
									<br>
								
								<?php

									//$ssql="select fullname,uid from user_management where uid in (".$engineer.") ";
	$ssql="select u.[uid],u.[fullname] from user_management u
right join maintenance_type_master m
on m.maintenance_type_id = u.maintenance_type
where m.maintenance_type='".trim($mt_id)."' and u.factory_id='".$_SESSION['factory-id']."' and u.user_type='engineer'";

									
										$rrs=odbc_exec($conn,$ssql);
										$ee=explode(",",$engineer);
										$n=0;
										$xp=explode(",",$engineer);
										
										while($fff = odbc_fetch_array($rrs)){
											//echo '<pre>';
											//print_r($fff);
											//print_r($xp);
											
											//echo $xp[$n].'='.$fff['uid'];
											
											$s=(trim($xp[$n])==trim($fff['uid']))?'checked':'';
										
										echo '<input type="checkbox" name="engineer[]" value='.$fff['uid'].' '.$s.' >';
										echo $fff['fullname'];
										echo '<br>';
										  if(count($xp)>1)
										   $n++;
										}
								 ?>
                               
                                     </td>
                                     <td align="right"><b>Work Order Date: </b></td>
                                     	<td>
                                        <select name="wo_dd"  style="width:60px;">
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
                                        
                                        <select name="wo_mm" style="width:120px;">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<sizeof($monthArray);$x++){
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
                                     
                                     <td><b>Time: </b><input type="text" name="work_order_time" id="work_order_time" style="width:130px;" value="<?php echo $workorder_start_time ?>"></td>
                                     
                                     <td><b>Priority: </b>
                                     	 <label class="radio">
    <input type="radio" name="priority" value="high"  id="priority" <?php echo ($workorder_priority=='high')?'checked':''?>>High
    </label>
     <label class="radio">
    <input type="radio" name="priority" value="medium"  id="priority" <?php echo ($workorder_priority=='medium')?'checked':''?>>Medium
    </label>
     <label class="radio">
    <input type="radio" name="priority" value="low"  id="priority" <?php echo ($workorder_priority=='low')?'checked':''?>>Low</td>
    </label>
                                </tr>
                                   </div>
 
                            <tr>
                            	<td align="right" >
                                <b>Work Description: </b></td>
                                <td colspan="3">
<textarea name="work_order_description" id="work_order_description" style="width:95%;height:70px;resize:none;"><?php echo $work_description?></textarea>
                                </td>
                            </tr>
                            
                            	<tr>
                                    	<th style="background-color:#FFFFFF" align="right">Safty Caution:</th>
                                        <td colspan="11" style="color:#CD0003; background-color:#FFFFFF" ><?php echo $safty_caution; ?></td>
                                    </tr>
                            
                            </table>

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