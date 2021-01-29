<?php 
	$sm='active';
	$aa='active';

include_once('including/all-include.php');
include_once('including/header.php');

$wo=$_GET['SCH_GDI'];	

if(isset($_POST['wo'])){
	$wo=$_POST['wo'];	
		print_r($_POST);

$dd=$_POST['from_year'].'-'.$_POST['from_month'].'-'.$_POST['from_date'];
	 

if($_POST['optionsRadios']=='skip'){
	$up="update schedule_generated set skip='1' ";
	
}

if($_POST['optionsRadios']=='re_sch'){
	$up="update schedule_generated set reschedule='1', schedule_generated_date ='".$dd."',  original_sch_date='".$_POST['ma_date']."' ";
}

echo 	$up .=", s_r_done_by='".$_SESSION['uid']."', reason='".$_POST['s_r_reason']."', timestamp=CURRENT_TIMESTAMP  where schedule_generated_id='".$wo."' ";
$sst = odbc_prepare($conn, $up);
		if (odbc_execute($sst)){ 
			$msgTxt = 'Schedule Updated Sucessfully.';
			$msgType = 2;
			header('Location:schedule-management.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
			exit;
		}

}

?>

<script src="assets/js/jquery-1.11.3.min.js"></script>

 <script>
$(document).ready(function(){
$("#current_month").hide();
$("#date_range").hide();


  $("#c").click(function(){
    $("#current_month").show();
   $("#date_range").hide();
  });
  
  $("#d").click(function(){
    $("#date_range").show();
	$("#current_month").hide();
  });
  
});


function chkrange(){
	var range = document.getElementById("cnfrange").checked;
	var s_r_reason = document.getElementById("s_r_reason").value;
	
if (!s_r_reason.length) {
		alert('Please enter reason for Re-Schedule.');
		return false;
}

	if(range){
		document.myform.submit();
	}else{
		alert('Please confirm to Re-Schedule.');
		return false;
	}

}

function chkcurrent(){
	var range1 = document.getElementById("cnfcurrent").checked;
		var s_r_reason = document.getElementById("s_r_reason").value;
		
	if (!s_r_reason.length) {
		alert('Please enter reason for Skip.');
		return false;
	}


	if(range1){
		document.myform1.submit();
	}else{
		alert('Please confirm to Skip.');
		return false;
	}
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
                           <span class="hidden-480">Skip / Re-Schedule Generated Schedule</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
     						<li class="">
                                 <a class="btn red"> 
                 <i class="icon-file"></i> Skip/Re-Schedule</a>
                                </li>	
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <!-- tab 1 asset details start --> 
                           <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
                                            <th>Asset Code</th>
											<th>Type</th>
											<th>Name</th>
											<th width="2%">Plant / Building</th>
											<th>Dept</th>
											<th>Location</th>
                                       
                                            <th>Model</th>
                                          
                                            <th>MA Type</th>
                                            <th>MA Date</th>
                                            <th>Recurrence</th>
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		 $sql="SELECT 
	sg.schedule_generated_date,
	s. schedule_id,
	s.check_list_id,
	s.recurrence_schedule,
	s.maintenance_type_id,
		a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.model_number,
	  a.serial_number,
	 a.asset_kept_area
	  ,atm.asset_type
      ,pbm.[plant_building_name]
      ,dsm.[department_section_name]
      ,lm.[location_name]
	  ,m.maintenance_type
	  ,a.safty_caution
       
	   from schedule_generated sg 
	   left join schedule s on sg.schedule_id = s.schedule_id
	   left join asset_master a on a.asset_id = s.asset_id
	   left join maintenance_type_master m on s.maintenance_type_id = m.maintenance_type_id
	   left join asset_type_master atm on a.asset_type=atm.asset_type_id
	   left join plant_building_master pbm on a.plant_building = pbm.plant_building_id
	   left join department_section_master dsm on a.department_section = dsm.department_section_id
	   left join location_master lm on a.asset_location = lm.location_master_id
     where a.factory_id='".$_SESSION['factory-id']."' and sg.schedule_generated_id='".$wo."'
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
										//echo '<td>'.$f['asset_kept_area'].'</td>';
										echo '<td>'.$f['model_number'].'</td>';
										//echo '<td>'.$f['serial_number'].'</td>';
										echo '<td>'.$f['maintenance_type'].'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['schedule_generated_date'])).'</td>';
										echo '<td>'.ucfirst($f['recurrence_schedule']).'</td>';
										$recurrence=trim($f['recurrence_schedule']);
										$mt_id=$f['maintenance_type_id'];
										$safty_caution=$f['safty_caution'];	
										$check_list_id=$f['check_list_id'];		
										$ma_date=$f['schedule_generated_date'];							
									}
									?>
									 <input type="hidden" name="recurrence" value="<?php echo $recurrence?>" id="recurrence">
                                    </tbody>                    
                            
                            		<tr>
                                    	<th style="background-color:#FFFFFF" align="right">Safty Caution:</th>
                                        <td colspan="11" style="color:#CD0003; background-color:#FFFFFF" ><?php echo $safty_caution; ?></td>
                                    </tr>
                            
                          </table>
                          
                          <table  width="100%" align="center">
                          <tr>
                          <td>  		
                         <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="myform1">
                         <input type="hidden" name="wo" value="<?php echo $wo?>">
                         <input type="hidden" name="ma_date" value="<?php echo $ma_date?>">
                         <div style="width:100%;" >   
                            <div style="width:98%;">
                     
                                  <h3 style="color:#F3060A">Please Enter Reson for Skip / Re-Schedule: </h3>
                                  <textarea style="width:99%; resize:none" name="s_r_reason" id="s_r_reason"></textarea>
                                  
                               <table border="0" width="100%">
                               <tr>
                               <td width="25%">
                                	  <h3> Please Selection Action: </h3>
                                </td>
                                <td>
                                       <label class="radio">
                                          <input type="radio" name="optionsRadios"  value="skip"  id="c"/>
                                         <b> Skip</b>
                                        </label>  
                                          
                                  		<label class="radio">
                                          <input type="radio" name="optionsRadios"  value="re_sch"  id="d"/>
                                         <b> Re-Schedule</b>
                                        </label>
                        		</td>
                                </tr>
                                </table>
                                	
                                    <div id="current_month"> 
                                    <hr>
                                    	<input type="checkbox" name="cnfcurrent" id="cnfcurrent" >Confirm to Skip this Schedule
                                        <button type="submit" name="submit" class="btn red" onClick="javascript: return chkcurrent();"> 
                                        Skip
                                        </button>
                                    </div>
                            
                            		<div id="date_range"> 
                                    <hr>
                                    	<div class="control-group">
                                       <label class="control-label"><b>New Re-Schedule Date</b></label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1" name="from_date">
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
                                          <select class="small m-wrap" tabindex="1" name="from_month">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['installation_mm']==$x || date('m')==$x ? 'selected' : '');
														if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
														//echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
														//
                                                    }
													
											  ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="from_year">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
										 <div style="color:#E10307"><?php echo $errorArray['installation_date']?></div>
                                       </div>
                                    </div>
                                    
                                   
                                    
                                        <input type="checkbox" name="cnfrange" id="cnfrange" >Confirm to Re-Schedule Date
                                        <button type="submit" name="submit" class="btn red" onClick="javascript: return chkrange();"> 
                                        Re-Schedule
                                        </button>
                                    </div>
                            
                            </div>
                        </div>    
              
                         </td>
                         </tr>  
                         
                           
                            
                                    
                                    
                           
                            </table>

				
                                 
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