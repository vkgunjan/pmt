<?php 
	     
		 if(isset($_GET['report'])){
		   $report='active';
		 	$wr='active';
		 }else{
		   $wrkod='active';
		 $la='active';
		 }
		 

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

            function checkR()
            {
                if (document.getElementById('wo_remarks').value=="" || document.getElementById('wo_remarks').value==undefined)
                {
                    alert ("Please enter remarks for rejection...");
                    return false;
                }
                
            }

        </script>
        
         <script type="text/javascript">

            function checkA()
            {
                if (document.getElementById('wo_remarks').value=="" || document.getElementById('wo_remarks').value==undefined)
                {
                    alert ("Please enter remarks to approve...");
                    return false;
                }
                
            }

        </script>
        
        
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
                           <span class="hidden-480"> Completed Work Order</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Completed Work Order Details</a></li>			
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
		$sql="SELECT * from work_order  where factory_id='".$_SESSION['factory-id']."' and workorder_id='".$wo."' ";
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
										$workorder_start_date=date("d-m-Y", strtotime($f['workorder_start_date']));
										//$workorder_start_date=$f['workorder_start_date'];
										$wo_completion_description=$f['wo_completion_description'];
										$workorder_complete_date=date("d-m-Y", strtotime($f['workorder_complete_date']));
										$workorder_complete_time=$f['workorder_complete_time'];
										$wo_status=$f['workorder_status'];
										$approver_remarks=$f['wo_remarks'];
										$wo_approved_rejected=$f['wo_approved_rejected'];
										$wo_approved_rejected=$f['wo_approved_rejected'];
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
                           
                           <?php 
						   if(!empty($approver_remarks) || ($wo_status==1 && $wo_approved_rejected==2) ){ 
						   

											if($wo_approved_rejected==2 && $wo_status!=3){
												$stat='Rejection Remarks';	
												$col='red';
											}else{
												$stat='Approval Remarks';
												$col='green';
											}
										
						   
						   ?>
                            <tr>
                             	<th bgcolor='<?php echo $color; ?>'; style="color:<?php echo $col ?>" align="right"><?php echo $stat; ?>:</th>
                                <th align="left" colspan="4" style="color:<?php echo $col ?>" >
                                	<?php echo $approver_remarks?>
                                </th>
                             </tr>
                           <?php } ?>  
                           
                            </table>
            
         <?php
//dont display before work order accept...start
          if($wo_status>1){
         ?>                             
                            
                             <table border="1" style="width:100%" align="center">
                             
  	
                                <tr>
                                	<th colspan="3" style="background-color:#069A09; color:#FFFFFF">Work Order Completion Details</th>
								</tr>
                               
                                <tr>
                                	<th width="18%">Completion Description</th>
                            		<td colspan="2"><?php echo $wo_completion_description ?></td>
                                </tr>
							
	                         <tr>
                             	<th>Completion Date & Time</th>
                                <td colspan="2">
                                
                                	<?php echo $workorder_complete_date?>
                                &nbsp;&nbsp;&nbsp;
                                	&nbsp;<b>Time:</b> <?php echo $workorder_complete_time ;?>
                                
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
<?php
}
//dont display before work order accept...ends
?>                            

									<div  style="text-align:right;">
                                
                               <?php

 if(!isset($_GET['report'])){  //report page check start

/*	vks comment 						   
if($wo_status<1 && ($_SESSION['user_type']=='superadmin' || $_SESSION['user_type']=='admin' || $_SESSION['user_type']=='superwiser' )){

echo '<a href="edit-work-order.php?woid='.$wo.'" title="Final Submit" ><input type="button" value="Edit WO"></a>';
}
*/

	if($wo_status==2 && ($_SESSION['user_type']=='superadmin' || $_SESSION['user_type']=='admin' || $_SESSION['user_type']=='superwiser' )){
//work order remarks input
echo '
<span style="text-align:left"><br><b><font color="#D4090C">Work Order Remarks : </font></b><input type="text" name="wo_remarks" id="wo_remarks" style="width:84%;" required="required">&nbsp;</span>';
echo '<br>';

//echo '
//<a href="generated-work-order-list.php?wo_approve_id='.base64_encode($wo).'" title="Approve" ><input type="button" value="Approve"></a></a>
//	';
?>

 <a href="generated-work-order-list.php?wo_approve_id=<?php echo base64_encode($wo); ?>&wo_remarks= " onclick="checkA();this.href+=document.getElementById('wo_remarks').value;" ><input type="button" value="Approve"></a>

<?php

//echo '<input type="button" name="inspecionar" id="inspecionar" value="inspecionar" onclick="location.href=show-work-order-details.php?'.base64_encode($wo).'&cod_meio="+document.getElementById(\'wo_remarks\').value" "> ';

//echo '
//<a href="generated-work-order-list.php?wo_reject_id='.base64_encode($wo).'" title="Reject" ><input type="button" value="Reject"></a></a>
//	';	
?>
	
<a href="generated-work-order-list.php?wo_reject_id=<?php echo base64_encode($wo);?>&wo_remarks=" onclick="checkR();this.href+=document.getElementById('wo_remarks').value;"><input type="button" value="Reject"></a>
<?php

	

 /*?>echo '<a href="generated-work-order-list.php?wo_approve_id='.base64_encode($wo).'"  title="Approve"><i class="icon-ok">Approve</i></a>

<a href="generated-work-order-list.php?wo_reject_id='.base64_encode($wo).'" data-toggle="modal" class="btn mini red" title="Reject"><i class=" icon-ok">Reject</i></a>

	';	<?php */
	}
	
	
	if($wo_status==1){
echo '
<a href="complete-work-order.php?woid='.$wo.'" title="Final Submit"><input type="button" value="Final Submit"></a>
	';	
	}
	

	
	
	if(empty($wo_status)){
	echo '
<a href="generated-work-order-list.php?woacceptid='.$wo.'" title="Acept" onClick="javascript: return accept(this.value);"><input type="button" value="Accept"></a></a>
	';
	}
							   

 }//report page check ends
 
 ?>
               					
                <a href="generated-work-order-list.php"><input type="button" value="Back" onClick="javascript:window.history.back();"></a>
                <a href="generated-work-order-list.php"><input type="button" value="Print" onClick="javascript:window.print();"></a>

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