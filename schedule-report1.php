<?php 
	        $report='active';
	        $sr='active';

        include_once('including/all-include.php');
        include_once('including/header.php');
//print_r($_POST);

if(isset($_POST['submit'])){

	 $from_date=$_POST['from_year'].'-'.$_POST['from_month'].'-'.$_POST['from_date'];
 	 $to_date=$_POST['to_year'].'-'.$_POST['to_month'].'-'.$_POST['to_date'];
	$maintenance_type=$_POST['maintenance_type'];	
	
	if($maintenance_type=='all'){
//all start	
	if(trim($_SESSION['user_type'])=='engineer'){
			 $sql="
select gs.schedule_generated_date, s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.maintenance_type_id, 
m.maintenance_type , a.asset_code, a.asset_name , at.asset_type, a.asset_kept_area, p.plant_building_name ,
w.schedule_generated_id as wosid, w.workorder_status, w.work_order_engineer_id from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where gs.schedule_generated_date >= '".$from_date."' and gs.schedule_generated_date <= '".$to_date."'
and s.maintenance_type_id='".$_SESSION['maintenance_type']."'

 ";
	}else{
		 $sql="
select gs.schedule_generated_date, s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.maintenance_type_id, 
m.maintenance_type , a.asset_code, a.asset_name , at.asset_type, a.asset_kept_area, p.plant_building_name ,
w.schedule_generated_id as wosid, w.workorder_status, w.work_order_engineer_id from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where gs.schedule_generated_date >= '".$from_date."' and gs.schedule_generated_date <= '".$to_date."'

 "; }
//all end
	}else{

	if(trim($_SESSION['user_type'])=='engineer'){
		$sql="
select gs.schedule_generated_date, s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.maintenance_type_id, 
m.maintenance_type , a.asset_code, a.asset_name , at.asset_type, a.asset_kept_area, p.plant_building_name ,
w.schedule_generated_id as wosid, w.workorder_status, w.work_order_engineer_id from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where s.maintenance_type_id='".$_SESSION['maintenance_type']."'
and gs.schedule_generated_date >= '".$from_date."' and gs.schedule_generated_date <= '".$to_date."' 

";
	}else{
		$sql="
select gs.schedule_generated_date, s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.maintenance_type_id, 
m.maintenance_type , a.asset_code, a.asset_name , at.asset_type, a.asset_kept_area, p.plant_building_name ,
w.schedule_generated_id as wosid, w.workorder_status, w.work_order_engineer_id from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where s.maintenance_type_id='".$maintenance_type."'
and gs.schedule_generated_date >= '".$from_date."' and gs.schedule_generated_date <= '".$to_date."' 

";}
	}

}else{
	 $from_date=date('Y').'-'.date('m').'-'.date('d');
 	 $to_date=date('Y').'-'.date('m').'-'.date('d');
	
	if(trim($_SESSION['user_type'])=='engineer'){
$sql="
select gs.schedule_generated_date, s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.maintenance_type_id, 
m.maintenance_type , a.asset_code, a.asset_name , at.asset_type, a.asset_kept_area, p.plant_building_name ,
w.schedule_generated_id as wosid, w.workorder_status, w.work_order_engineer_id from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where gs.schedule_generated_date >= '".$from_date."' and gs.schedule_generated_date <= '".$to_date."'
and s.maintenance_type_id='".$_SESSION['maintenance_type']."'

 ";
	}else{
		$sql="
select gs.schedule_generated_date, s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.maintenance_type_id, 
m.maintenance_type , a.asset_code, a.asset_name , at.asset_type, a.asset_kept_area, p.plant_building_name ,
w.schedule_generated_id as wosid, w.workorder_status, w.work_order_engineer_id from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where gs.schedule_generated_date >= '".$from_date."' and gs.schedule_generated_date <= '".$to_date."'

 ";}

}
        ?>
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Report of scheduled assets </h4>
								<div class="tools">
                
                <?php 
					if($_SESSION['user_type']=='superadmin' || $_SESSION['user_type']=='admin' || $_SESSION['user_type']=='superwiser' ){
				?>
                 
				 <?php } ?>
                 
                                    <a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
								</div>
							</div>
							<div class="portlet-body">

                  			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                         <div style="width:100%;" >   

                                     <b> From Date</b>
                                
                                          <select  name="from_date"  style="width:60px;" id="from_date">
												<?php 
                                                    for($x=1; $x<=31; $x++){
                                                        //$selected=($_POST['installation_dd']==$x || date('d')==$x? 'selected' : '');
                                                   // $selected=($_POST['from_date']==$x) ? 'selected' : '';
													 if(empty($_POST['submit']) )
														 {
														 		if(date('d')==$x)
																$selected='selected';
																else		
																$selected='';
														 }else{
														  		if($_POST['from_date']==$x)
																$selected='selected';
																else		
																$selected='';
														 }
													if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select name="from_month" style="width:105px;" id="from_month">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<sizeof($monthArray);$x++){
														 //$selected=($_POST['installation_mm']==$x || date('m')==$x ? 'selected' : '');
														 if(empty($_POST['submit']) )
														 {
														 		if(date('m')==$x)
																$selected='selected';
																else		
																$selected='';
														 }else{
														  		if($_POST['from_month']==$x)
																$selected='selected';
																else		
																$selected='';
														 }
														 
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="from_year" style="width:70px;" id="from_year">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
										
                                    &nbsp;&nbsp;&nbsp;
                                      <b> To Date</b>
                                      
                                                   <select name="to_date"  style="width:60px;" id="to_date">
												<?php 
                                                    for($x=1; $x<=31; $x++){
                                                        //$selected=($_POST['installation_dd']==$x || date('d')==$x? 'selected' : '');
														if(empty($_POST['submit']) )
														 {
														 		if(date('d')==$x)
																$selected='selected';
																else		
																$selected='';
														 }else{
														  		if($_POST['to_date']==$x)
																$selected='selected';
																else		
																$selected='';
														 }
                                                    if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select  name="to_month" style="width:105px;" id="to_month">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<sizeof($monthArray);$x++){
													//	 $selected=($_POST['installation_mm']==$x || date('m')==$x ? 'selected' : '');
														 if(empty($_POST['submit']) )
														 {
														 		if(date('m')==$x)
																$selected='selected';
																else		
																$selected='';
														 }else{
														  		if($_POST['to_month']==$x)
																$selected='selected';
																else		
																$selected='';
														 }
														 
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="to_year" style="width:70px;" id="to_year">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
									
                                    <b>Maintenance Type</b>
                         	<select name="maintenance_type" style="width:110px;">
                                       		<option value="all">All</option>
                                             <?php
							if(trim($_SESSION['user_type'])=='engineer')
								$ssql="select * from maintenance_type_master where factory_id='".$_SESSION['factory-id']."' and maintenance_type_id='".$_SESSION['maintenance_type']."'";
							else
								$ssql="select * from maintenance_type_master where factory_id='".$_SESSION['factory-id']."' ";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$sel=($f['maintenance_type_id']==$_POST['maintenance_type'])?'selected':'';
										echo '<option value="'.$f['maintenance_type_id'].'" '.$sel.'>'.$f['maintenance_type'].'</option>';
										}
									?>
                                          </select>
                            	 
 <button type="submit" name="submit" value="true" class="btn green" style="margin-top:-10px;" onClick="return submitcheck();">Show
                                    <i class="icon-refresh"></i></button>
<a href="export-excel-schedule.php?fromdate=<?php echo $from_date?>&todate=<?php echo $to_date ?>"><input type="button" value="Export to Excel"></a>                                    
								</form>
                        	
                            </div>
                      <form action="work-order.php" method="post" name="myform">
                        <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											<th>#</th>
											<th>Schedule Date</th>
											<th>Asset Code</th>
                                            <th>Asset Type</th>
											<th>Asset Name</th>
                                            <th>P/B</th>
											<th>Asset Kept Area</th>
                                            <th>Maintenance Type</th> 
											<th>Recurrence Type</th>                                            
										    <th>WO Status</th>
                                            <th>WO Engg.</th>
                                        </tr>
									</thead>

                                    <tbody>
 								<?php
									//echo $sql;
									$rs=odbc_exec($conn,$sql);
									//echo odbc_num_rows($rs);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//echo '<pre>';
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['schedule_generated_date'])).'</td>';										
										echo '<td>'.strtoupper($f['asset_code']).'</td>';
										echo '<td>'.strtoupper($f['asset_type']).'</td>';				
										echo '<td>'.ucfirst($f['asset_name']).'</td>';
										echo '<td>'.ucfirst($f['plant_building_name']).'</td>';
										
										echo '<td>'.strtoupper($f['asset_kept_area']).'</td>';	
										echo '<td>'.$f['maintenance_type'].'</td>';
										echo '<td>'.ucfirst($f['recurrence_schedule']).'</td>';
										if($f['workorder_status']==1){
											$stat='Work on progress';
										}
										
										if($f['workorder_status']==2){
											$stat='Pending for approval';
										}
										
										if(empty($f['workorder_status'])){
											if(empty($f['work_order_engineer_id']))
											 $stat='Wo Not Generated';
											else		
											  $stat='Pending';
										
										}
										
										if($f['workorder_status']==3){
											$stat='Completed';
										}
									echo '<th align="center">'.$stat.'</th>';
									
									echo '<td>';
										if(empty($f['work_order_engineer_id'])){
											echo 'N/A';
										}else{
											$se="select fullname from user_management where uid in (".$f['work_order_engineer_id'].")";
											$rse=odbc_exec($conn,$se);
											$ce=1;
											while($fr = odbc_fetch_array($rse)){
												echo $ce.'. ';
												echo $fr['fullname'];
												echo '<br>';
												$ce++;
											}
										}
										echo '</td>';
										
										$count++;
									}
									?>
       
									</tbody>
								</table>
							</form>
                        </div>  
                                                        
                            </form>
			
                            		
								</div>
								
                                
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
	   <!-- END CONTAINER -->
   <?php include_once('including/footer.php')?>
   <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
			$ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>