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
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Complete Work Order</a></li>			
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
		$sql="SELECT * from work_order  where factory_id='".$_SESSION['factory-id']."' and workorder_id='".$wo."' and workorder_status=1";
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
										$wo_completion_description=$f['wo_completion_description'];
									}
									?>
									</tbody>
									
								</table>
                                
                     <table border="1" style="width:100%" align="center">
                     <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">  
                     <input type="hidden" name="woid" value="<?php echo $wo?>"> 
                      <input type="hidden" name="submit_wo" value="submit_wo">    	
                                <tr>
									<th colspan="4" style="background-color:#C57B00; color:#FFFFFF">Work Order Description</th>
								</tr>
                                
                                <tr>
                                	<th>Engineer Name</th>
									<th>Work Order Start Date</th>
                                    <th>Work Start Time</th>
									<th>Work Order Priority</th>
                                </tr>

                               
                                
                                <tr align="center">
                                	<td> 
								
								<?php
									 $ssql="select fullname,uid from user_management where uid in (".$engineer.") ";
									$rrs=odbc_exec($conn,$ssql);
										$ee=explode(",",$engineer);
										$n=1;
											$xp=explode(",",$engineer);
										while($fff = odbc_fetch_array($rrs)){
										echo $n.'.'. $fff['fullname'];
										echo '<br>';
										$n++;
										}
								 ?>
                               
                                     </td>
                                   
                                   
                                     	<td>
                                        <?php echo $workorder_start_date;?>
                                        </td>
                                     
                                     	<td>
                                        <?php echo $workorder_start_time;?>
                                        </td>
                                     
                                     
                                     <td>
                                     	<?php echo $workorder_priority;?>
                                     </td>
                                </tr>
 
                            <tr>
                            	<td align="right" >
                                <b>Work Description: </b></td>
                                <td colspan="3" style="color:#CD0003; background-color:#FFFFFF" ><?php echo $work_description; ?></td>
                            </tr>
                            
                            	<tr>
                                    	<th style="background-color:#FFFFFF" align="right">Safty Caution:</th>
                                        <td colspan="3" style="color:#CD0003; background-color:#FFFFFF" ><?php echo $safty_caution; ?></td>
                                    </tr>
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