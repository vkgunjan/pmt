<?php 
	        $am='active';
	        $la='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
   
   if(isset($_POST['submit'])){
  // print_r($_POST);


  $checklist=implode(',',$_POST['checklist']);
 //   exit;
if($_POST['recurrence_schedule']=='daily'){
	$day=0;
	$frequency=1;
	$month=0;
}

if($_POST['recurrence_schedule']=='weekly'){
	$day=$_POST['weekly_day_of_week'];
	$frequency=$_POST['weekly_frequency'];
	$month=0;
}

if($_POST['recurrence_schedule']=='monthly'){
	$day=$_POST['monthly_date_of_month'];
	$frequency=$_POST['month_month_frequency'];
	$month=0;
}
  
if($_POST['recurrence_schedule']=='yearly'){
	$day=$_POST['yearly_date_of_month'];
	$frequency=$_POST['yearly_year_frequency'];
	$month=$_POST['yearly_month'];
}

$activation_date=$_POST['activation_yy'].'-'.$_POST['activation_mm'].'-'.$_POST['activation_dd'];
	if($_POST['activation_dd']=='Date' || $_POST['activation_mm']=='Month' || $_POST['activation_yy']=='Year' ){
		$errorArray['activation_date']='Please Select Activation Date';
	}elseif(!checkdate($_POST['activation_mm'],$_POST['activation_dd'],$_POST['activation_yy'])  ){
		$errorArray['activation_date']='Please Select Valid Activation Date';
	}
	
 
   	$dataArray=array(
					
					'asset_id'						=>	trim(dbOutput($_POST['pid'])),
					'maintenance_type_id'			=>	trim(dbOutput($_POST['maintenance_type_id'])),					
					'activation_date'				=>	trim(dbOutput($activation_date)),
					'recurrence_schedule'			=>	trim(dbOutput($_POST['recurrence_schedule'])),					
					'day'							=>	trim(dbOutput($day)),
					'frequency'						=>	trim(dbOutput($frequency)),
					'month'							=>	trim(dbOutput($month)),					
					'factory_id'					=>	trim(dbOutput($_SESSION['factory-id']))		
				);


//print_r($dataArray);

	if(empty($errorArray)){
   		
		
				$bt="select schedule_id from schedule where asset_id='".dbInput($dataArray['asset_id'])."' 
				 and maintenance_type_id='".dbInput($dataArray['maintenance_type_id'])."' and  recurrence_schedule='".dbInput($dataArray['recurrence_schedule'])."' ";
				$rs=odbc_exec($conn,$bt);

				if(odbc_num_rows($rs)>0){
					$msgTxt = 'Schedule Allready Exist.';
						$msgType = 1;
					header('Location:schedule-maintenance.php?pid='.$_POST['pid'].'&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
					exit;
				}else{
		
		$insert  ="INSERT INTO schedule (asset_id, maintenance_type_id, activation_date, recurrence_schedule, day, 
		frequency, month, factory_id, check_list_id)";
				$insert .="values('".dbInput($dataArray['asset_id'])."', '".dbInput($dataArray['maintenance_type_id'])."', 
				'".dbInput($dataArray['activation_date'])."',	'".dbInput($dataArray['recurrence_schedule'])."', 
				'".dbInput($dataArray['day'])."', '".dbInput($dataArray['frequency'])."',
				'".dbInput($dataArray['month'])."', '".dbInput($_SESSION['factory-id'])."', '".$checklist."' ) ";

				//echo $insert;
				//exit;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New Schedule Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New Schedule Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}

					header('Location:schedule-maintenance.php?pid='.$_POST['pid'].'&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
					exit;
				}
		}
   
   }
   
   
        ?>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="mtype.js"></script>
 <script>
$(document).ready(function(){
$("#week").hide();
$("#month").hide();
$("#scm").hide();
$("#year").hide();

  $("#am").click(function(){
    $("#scm").show();
  });


  $("#d").click(function(){
    $("#week").hide();
	$("#month").hide();
	$("#year").hide();
  });
  
  $("#w").click(function(){
    $("#week").show();
	$("#month").hide();
  	$("#year").hide();
  });
  
  $("#m").click(function(){
	$("#month").show();
	$("#week").hide();
  	$("#year").hide();
  });

$("#y").click(function(){
	$("#year").show();
	$("#month").hide();
	$("#week").hide();	
  });
  
  
});
</script>

<script>
function submitcheck(){
//	alert ('hello');
		var m_type=document.getElementById("m_type").value;
		var dd=document.getElementById("dd").value;
		var mm=document.getElementById("mm").value;
		var yy=document.getElementById("yy").value;
		var inputdate = dd+'/'+mm+'/'+yy;

		var today = new Date();
    	var d = today.getDate();
 	    var m = today.getMonth()+1; //January is 0!
	    var y = today.getFullYear();
	
	if(d < 10 ){
		d='0'+d;
	}
	
	var curdate = d+'/'+m+'/'+y;

//alert(inputdate);
//alert(curdate);


if(m_type==''){
    alert("Please select maintenance type");
	return false;

}

if(dd=='' || mm==''|| yy==''){
    alert("Please select activation date");
	return false;

}

//if(inputdate < curdate)
//{
 //   alert("Error: Activation date can not be less than today.");
//	return false;
//}


//	alert(dd);
}
</script>
           
 <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                          <h4><i class="icon-edit"></i>Generate Maintenance Schedule & Job Order </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">

								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Create Maintenance Schedule</a></li>			
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
                                            <th>Asset Code</th>
											<th>Type</th>
											<th>Name</th>
											<th>Plant / Building	</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>Area</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		$sql="SELECT a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.[asset_type] as asset_type_id
	  ,a.model_number,
	  a.serial_number,
	 a.asset_kept_area
	  ,atm.asset_type
      ,pbm.[plant_building_name]
      ,dsm.[department_section_name]
      ,lm.[location_name]
       from asset_master a
	   left join asset_type_master atm on a.asset_type=atm.asset_type_id
	   left join plant_building_master pbm on a.plant_building = pbm.plant_building_id
	   left join department_section_master dsm on a.department_section = dsm.department_section_id
	   left join location_master lm on a.asset_location = lm.location_master_id
     where a.factory_id='".$_SESSION['factory-id']."' and asset_id='".$_REQUEST['pid']."'
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
										//echo '<input type="text" name="asset_type_id" id="asset_type_id" value="'.$f['asset_type_id'].'">';
										$_SESSION['checklist_asset_type_id']=$f['asset_type_id'];
									}
									?>
       
									</tbody>
								</table>
                                
                           <hr>

                          
                          <div class="portlet-body">
								<div class="clearfix">
                                	<div class="btn-group">
										
                                        <button class="btn red" id="am">
										Add Maintenance Schedule <i class="icon-plus"></i>
										</button>
                                      
									</div>
                                    	

									<div class="btn-group pull-right">
										<button class="btn " ><a href="list-asset.php">Back</a> 
										</button>
										
									</div>
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
                                            <th>Action</th>                                            
                                        </tr>

									</thead>
									
                                    
                                    <tbody>
                                    
									
       <?php
		$sql="select a.asset_code, m.maintenance_type, s.schedule_id,s.check_list_id, s.activation_date, s.recurrence_schedule, s.[day], s.frequency, s.[month] 
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

										echo '<td><a href="#" class="btn mini red"><i class="icon-trash"></i> Delete Schedule</a></td>';

										echo '<tr>';
										
											echo '<th>';
												echo 'Current Checklist';
											echo '</th>';
											
											echo '<td colspan="6" style="text-align:justify; ">';
											
							if(!empty($f['check_list_id'])){
							 $ssql="select * from checklist_master where checklist_id in (".$f['check_list_id'].") ";
									$rrs=odbc_exec($conn,$ssql);
										while($fff = odbc_fetch_array($rrs)){
										echo '<input type="checkbox" name="checklist[]" value='.$f['check_list_id'].' checked disabled>';
										echo $fff['checklist_name'];
										//echo '<br>';
										}
							}else{
								echo 'N/A';
							}
											echo '</td>';

								echo '<td width="14%"><a href="#" class="btn mini blue"><i class="icon-refresh"></i> Update Checklist</a></td>';
										
										echo '</tr>';
										
									}
									?>
       
									</tbody>
                                    
                                   
								</table>
                                
                           <hr>

                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal" id="scm">
                           		<input type="hidden" name="pid" value="<?php echo $_GET['pid']?>">
 
                             <div class="control-group" >

<table style="width:100%; ">
<tr>
<td style="width:60%" valign="top";>
                        <label class="control-label">Maintenance Type </label>
                         <div class="controls">
                          <select class="medium m-wrap"  name="maintenance_type_id" required id="m_type" onChange="mtype(this.value)">
                                       		<option value="">-Select-</option>
                                             <?php
									$sql="select * from maintenance_type_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										echo '<option value="'.$f['maintenance_type_id'].'">'.$f['maintenance_type'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                
                     
                                    
                                   <div class="control-group" >
                                       <label class="control-label">&nbsp;Activation Date</label>
                                       
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1" name="activation_dd" required id="dd">
                                             <option value="">Date</option>
												<?php 
                                                    $dd=explode('-',$dataArray['purchase_date']);
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['purchase_dd']==$x || date("d")==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="activation_mm" required id="mm">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=0;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['purchase_mm']==$x || date("m")==$x ? 'selected' : '');
														 if($x==0)
														   echo '<option value="">Month</option>';
													  	else
														   echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select class="small m-wrap" tabindex="1" name="activation_yy" required id="yy">
                                            <option value="">Year</option>
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr+5); $x++){
                                                        $selected=($_POST['purchase_yy']==$x || date("Y")==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
										<div style="color:#C30307"><?php echo $errorArray['activation_date']?></div>
                                       </div>
                                    </div>
                                    
                                                                
                                    <div class="control-group" >
                                       <label class="control-label">&nbsp;Recurrence of Schedule</label>
                                       <div class="controls" >

                                          <label class="radio">
                                          <input type="radio" name="recurrence_schedule" value="daily" id="d" required/>
                                          Daily
                                          </label>

                                          <label class="radio">
                                          <input type="radio" name="recurrence_schedule" value="weekly" id="w" required/>
                                          Weekly
                                          </label>

                                          <label class="radio">
                                          <input type="radio" name="recurrence_schedule" value="monthly"  id="m" required/>
                                          Monthly
                                          </label>  
                                          
                                          <label class="radio">
                                          <input type="radio" name="recurrence_schedule" value="yearly" id="y" required/>
                                          Yearly
                                          </label>  
                                       </div>
                                    </div>
                                    
                                 
                                 <div class="control-group" id="week">
                                       <label class="control-label">Select Day of Week</label>
                                       <div class="controls">
                                             <select class="medium m-wrap" tabindex="1" name="weekly_day_of_week">
                                             <?php
											   $weekarray=array('Monday','Tuesday','Wednesday','Thrusday','Friday','Saturday','Sunday');
													 for($x=0;$x<sizeof($weekarray);$x++){
														 $selected=($_POST['weekly_day_of_week']==$x || $dd[1]==$x ? 'selected' : '');
														 echo '<option value='.($x+1).' '.$selected.'>'.$weekarray[$x].'</option>';
													  }	
											  ?>
                                          </select>                                       
                                       </div>

									<label class="control-label">Week Frequency</label>
                                       <div class="controls">
     <input type="text"  class="m-wrap small" name="weekly_frequency" value="<?php echo $dataArray['weekly_frequency']?>"/>
                                       </div>
                                       
                                    </div>

									
                                    <div class="control-group" id="month">
                                    	
                                        <label class="control-label">Date of Month </label>
                                       		<div class="controls">
                                          <select class="small m-wrap" name="monthly_date_of_month">
                                             <?php 
                                                    $dd=explode('-',$dataArray['monthly_date_of_month']);
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['purchase_dd']==$x || $dd[2]==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>                                         
                                          </select>
                                       		</div>
										
                                        
                                       
                                       <label class="control-label">Month Frequency</label>
                                       <div class="controls">
                                <input type="text"  class="m-wrap small" name="month_month_frequency" value="<?php echo $dataArray['month_month_frequency']?>"/>
                                       </div>
                        </div>


						<div class="control-group" id="year">
                                       <label class="control-label">Month</label>
                                       <div class="controls">
                                          <select class="large m-wrap" name="yearly_month">
                                              <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=0;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['yearly_month']==$x || $dd[1]==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>                                  
                                          </select>
                                       </div>
                                    
                                    	<label class="control-label">Date of Month </label>
                                       		<div class="controls">
                                          <select class="small m-wrap" name="yearly_date_of_month">
                                             <?php 
                                                    $dd=explode('-',$dataArray['yearly_date_of_month']);
                                                    for($x=1; $x<=31; $x++){
                                                        $selected=($_POST['purchase_dd']==$x || $dd[2]==$x? 'selected' : '');
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>                                                        
                                          </select>
                                       		</div>
                                       
                                       <label class="control-label">Year Frequency</label>
                                       <div class="controls">
         <input type="text"  class="m-wrap small" name="yearly_year_frequency" value="<?php echo $dataArray['yearly_year_frequency']?>"/>
                                       </div>
                        </div>
</td>
<td align="left"  valign="top" style="border-left:groove; width:40%">

<div id="show_checklist">
	
</div>

</td>
</tr>
	
</table>

 								<div class="form-actions">
                                       <button type="submit" name="submit" class="btn blue" onClick="return submitcheck();"><i class="icon-ok"></i> Save</button>
                                    </div>
                                </div>
                                
                                 </form>


                                 <!-- tab 1, asset detail ends -->  
                              </div>
                                 
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
            </div>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- END CONTAINER -->
   <?php include_once('including/footer.php')?>
   <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
			$ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>