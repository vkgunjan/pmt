<?php 
	        $sm='active';
	        $la='active';

        include_once('including/all-include.php');
        include_once('including/header.php');

//******submit part start********

if(isset($_POST['submit'])){

//print_r($_POST);

if($_POST['optionsRadios']=='current_month'){
$number = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
 $from_date=date('Y').'-'.date('m').'-1';
 $to_date=date('Y').'-'.date('m').'-'.$number;
	
}else{
 $from_date=$_POST['from_year'].'-'.$_POST['from_month'].'-'.$_POST['from_date'];
 $to_date=$_POST['to_year'].'-'.$_POST['to_month'].'-'.$_POST['to_date'];
}

//	echo 'From Date:'.$_POST['fromdate'];
//	echo '<br>';
//	echo 'To Date:'.$_POST['todate'];

	echo $sql="select * from schedule s 
left join asset_master a on a.asset_id=s.asset_id
where  s.activation_date <= '".$to_date."' and s.factory_id='".$_SESSION['factory-id']."' 
and a.[asset_condition]<>'deactive' ";

//exit;


	// $sql="select * from schedule where  activation_date <= '".$to_date."' and factory_id='".$_SESSION['factory-id']."' ";
	 $rs=odbc_exec($conn,$sql);
	 //echo '<br>count-'.odbc_num_rows($rs);
	
	 while($f = odbc_fetch_array($rs)){
		//echo '<pre>';
		//print_r($f);
//exit;
			$current_date=date('Y-m-d');
			$activation_date=date('Y-m-d', strtotime($f['activation_date']));
			$from_date=$from_date;
			$to_date=$to_date;
			
			
	if(!empty($f['last_maintenance_date'])){
		$start_date=$f['last_maintenance_date'];
	}else{
		if($activation_date<$from_date){
			
			if($current_date<=$from_date){
				$start_date=$from_date;
			}else{
				$start_date=$current_date;
			}
		}else{
			if($current_date>$from_date){
				$start_date=$current_date;
			}else{
				$start_date=$activation_date;
			}
		}
	}
	
		echo $start_date;
		if(trim($f['recurrence_schedule'])=='weekly'){
			$day_of_working_date=date('w', strtotime($start_date)); 
			$day_of_s=$f['day'];
			 $diff=$day_of_s - $day_of_working_date;
			if($diff < 0){
				$diff=7+($diff);
			}
			 $start_date=date('Y-m-d', strtotime($start_date. ' + '.($diff).' days'));	
			
		
		}
		
		if(trim($f['recurrence_schedule'])=='monthly'){
			
			$st=explode("-",$start_date);
			$day_of_sd=$st[2];
			$day_of_d=$f['day'];

			if((int)$day_of_sd > (int)$day_of_d ){
				 $start_date=date('Y-m-d', strtotime($start_date. ' + 1 month'));	
			}
				 if($day_of_d<10)
				 $day_of_d='0'.$day_of_d;
				 
				 $start_date=$st[0].'-'.$st[1].'-'.$day_of_d;
		}


		if(trim($f['recurrence_schedule'])=='yearly'){
			
			$st=explode("-",$start_date);
			$day_of_sd=$st[2];
			$day_of_d=$f['day'];

			if((int)$day_of_sd > (int)$day_of_d ){
				 $start_date=date('Y-m-d', strtotime($start_date. ' + 1 year'));	
			}
				 if($day_of_d<10)
				 $day_of_d='0'.$day_of_d;
				 
				 $start_date=$st[0].'-'.$st[1].'-'.$day_of_d;
		}


		
		$working_date=$start_date;		
		
		while($working_date<=$to_date){
			
			if(trim($f['recurrence_schedule'])=='daily'){
				if($working_date>=$from_date && $working_date<=$to_date){
					//echo '<br>D-'.$working_date;
					
						 $in="If Not Exists
								(select * from schedule_generated where schedule_generated_date='".dbInput($working_date)."' and 
								schedule_id=$f[schedule_id])
							Begin
								insert into schedule_generated (schedule_generated_date, schedule_id, factory_id)  
									values ('".dbInput($working_date)."' , $f[schedule_id], ".dbInput($_SESSION['factory-id']).")
							End 
							";
						$stmt = odbc_prepare($conn, $in);
						if (odbc_execute($stmt)){ 
							//odbc_close();
						}
					
				
				}
				$working_date=date('Y-m-d', strtotime($working_date. ' + '.$f['frequency'].' days'));	
			}
			
			if(trim($f['recurrence_schedule'])=='weekly'){
				if($working_date>=$from_date && $working_date<=$to_date){
					$day_of_working_date=date('w', strtotime($working_date)); 
					if($day_of_working_date == $f['day'] ){
						//echo '<br>W-'.$working_date;
						 $in="If Not Exists
								(select * from schedule_generated where schedule_generated_date='".dbInput($working_date)."' and 
								schedule_id=$f[schedule_id])
							Begin
								insert into schedule_generated (schedule_generated_date, schedule_id, factory_id)  
									values ('".dbInput($working_date)."' , $f[schedule_id], ".dbInput($_SESSION['factory-id']).")
							End 
							";
						$stmt = odbc_prepare($conn, $in);
						if (odbc_execute($stmt)){ 
							//odbc_close();
						}
					}
				}
				$working_date=date('Y-m-d', strtotime($working_date. ' + '.(7*$f['frequency']).' days'));	
			}
			
			
			if(trim($f['recurrence_schedule'])=='monthly'){
				if($working_date>=$from_date && $working_date<=$to_date){
						//echo '<br>M-'.$working_date;
						 $in="If Not Exists
								(select * from schedule_generated where schedule_generated_date='".dbInput($working_date)."' and 
								schedule_id=$f[schedule_id])
							Begin
								insert into schedule_generated (schedule_generated_date, schedule_id, factory_id)  
									values ('".dbInput($working_date)."' , $f[schedule_id], ".dbInput($_SESSION['factory-id']).")
							End 
							";
						$stmt = odbc_prepare($conn, $in);
						if (odbc_execute($stmt)){ 
							//odbc_close();
						}
				}
				$working_date=date('Y-m-d', strtotime($working_date. ' + '.($f['frequency']).' month'));	
			}
			
			
			if(trim($f['recurrence_schedule'])=='yearly'){
				if($working_date>=$from_date && $working_date<=$to_date){
						//echo '<br>Y-'.$working_date;
						 $in="If Not Exists
								(select * from schedule_generated where schedule_generated_date='".dbInput($working_date)."' and 
								schedule_id=$f[schedule_id])
							Begin
								insert into schedule_generated (schedule_generated_date, schedule_id, factory_id)  
									values ('".dbInput($working_date)."' , $f[schedule_id], ".dbInput($_SESSION['factory-id']).")
							End 
							";
						$stmt = odbc_prepare($conn, $in);
						if (odbc_execute($stmt)){ 
							//odbc_close();
						}
				}
				$working_date=date('Y-m-d', strtotime($working_date. ' + '.($f['frequency']).' year'));	
			}else{
				//$working_date=date('Y-m-d', strtotime($working_date. ' + '.($f['frequency']).' year'));	
			}
			
			//exit;
		}
		
			$msgTxt = 'Schedule Generated Successfully.';
			$msgType = 1;
			
	}
		header('Location:schedule-management.php?&msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
		exit;
} //**** submit part ends *****

 
 //exit;
 
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
	if(range){
		document.myform.submit();
	}else{
		alert('Please confirm your submittion.');
		return false;
	}
}

function chkcurrent(){
	var range1 = document.getElementById("cnfcurrent").checked;
	if(range1){
		document.myform1.submit();
	}else{
		alert('Please confirm your submittion.');
		return false;
	}
}


</script>
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Generate Asset Schedule</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">

                  			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="myform1">
                         <div style="width:100%;" >   
                            <div style="width:98%;">
                     
                                     Generate Schedule for 
                                       
                                       <label class="radio">
                                          <input type="radio" name="optionsRadios"  value="current_month"  id="c"/>
                                          Current Month
                                        </label>  
                                          
                                  		<label class="radio">
                                          <input type="radio" name="optionsRadios"  value="date_range"  id="d"/>
                                          Date Range
                                        </label>
                        			
                                    <div id="current_month"> 
                                    <hr>
                                    	<input type="checkbox" name="cnfcurrent" id="cnfcurrent" >Confirm to Generate Current Month Schedule
                                        <button type="submit" name="submit" class="btn blue" onClick="javascript: return chkcurrent();"> 
                                        Generate Schedule
                                        </button>
                                    </div>
                            
                            		<div id="date_range"> 
                                    <hr>
                                    	<div class="control-group">
                                       <label class="control-label">From Date</label>
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
                                    
                                    <div class="control-group">
                                       <label class="control-label">To Date</label>
                                       <div class="controls">
                                                   <select class="small m-wrap" tabindex="1" name="to_date">
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
                                          <select class="small m-wrap" tabindex="1" name="to_month">
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
                                          <select class="small m-wrap" tabindex="1" name="to_year">
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
                                    
                                        <input type="checkbox" name="cnfrange" id="cnfrange" >Confirm to Generate Date Range Schedule
                                        <button type="submit" name="submit" class="btn blue" onClick="javascript: return chkrange();"> 
                                        Generate Schedule
                                        </button>
                                    </div>
                            
                            </div>
                        </div>    
                           
                         
                           
                            </form>
							</div>
                            		
								</div>
								
                                <!--display table-space-vineet-->
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		2013 &copy; Metronic by keenthemes.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<script src="assets/breakpoints/breakpoints.js"></script>	
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>		
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("table_editable");
			App.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
