<?php 
	        $report='active';
	        $wr='active';

        include_once('including/all-include.php');
        include_once('including/header.php');
		
		
if(isset($_POST['submit-form'])){
	 $from_date=$_POST['from_year'].'-'.$_POST['from_month'].'-'.$_POST['from_date'];
 	 $to_date=$_POST['to_year'].'-'.$_POST['to_month'].'-'.$_POST['to_date'];
//	print_r($_POST);
	
	$dataArray=array(
		'from_date'					=> $from_date,
		'to_date'					=> $to_date,
		'maintenance_type'			=> trim($_POST['maintenance_type']),
		'engineer'					=> trim($_POST['engineer']),
		'wo_type'					=> trim($_POST['wo_type']),
		'wo_status'					=> trim($_POST['wo_status']),
		'asset_code'				=> trim($_POST['asset_code'])
	);
	
	$sq="select s.schedule_id, s.schedule_generated_date,ss.recurrence_schedule,ss.frequency, w.* from  work_order w
left join schedule_generated s on s.schedule_generated_id = w.schedule_generated_id
left join schedule ss on s.schedule_id = ss.schedule_id where w.workorder_start_date  between '".$dataArray['from_date']."' and '".$dataArray['to_date']."' "; 
	
	if(!empty($dataArray['maintenance_type'])){
		$sq.=" and w.maintenance_type = '".$dataArray['maintenance_type']."' ";
	}

	if(!empty($dataArray['engineer'])){
		$sq.=" and w.work_order_engineer_id = '".$dataArray['engineer']."' ";
	}

	if(!empty($dataArray['wo_type'])){
		$sq.=" and w.work_order_type = '".$dataArray['wo_type']."' ";
	}

	if(!empty($dataArray['wo_status'])){
		if($dataArray['wo_status']=='NULL')
		$sq.=" and w.workorder_status = '' ";
		else
		$sq.=" and w.workorder_status = '".$dataArray['wo_status']."' ";
	}
	
	if(!empty($dataArray['asset_code'])){
		$sq.=" and w.asset_code = '".$dataArray['asset_code']."' ";
	}
	
	
	//workorder_status='".$_POST['wo_status']."' ";

}else{
		//$fromdate=date("Y").'-'.date("m").'-'.date("d");
		$fromdate='1-'.date("m").'-'.date("Y");
		//$todate=date("Y").'-'.date("m").'-'.date("d");
		$todate=date("d").'-'.date("m").'-'.date("Y");
	//$sq="select * from  work_order ";
//	$sq="select * from  work_order where workorder_start_date  between '".$fromdate."' and '".$todate."' "; 
	//without submit vks
	$sq="select s.schedule_id, s.schedule_generated_date,ss.recurrence_schedule,ss.frequency, w.* from  work_order w
left join schedule_generated s on s.schedule_generated_id = w.schedule_generated_id
left join schedule ss on s.schedule_id = ss.schedule_id "; 
}

//echo $sq;
 ?>
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box red">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Report of work order generated</h4>
								<div class="tools">
                             
                                   
                                    <a href="javascript:;" class="collapse"></a>
									
								</div>
							</div>
							<div class="portlet-body">

                  			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="myform">
                         <div style="width:100%;" >   

                                     <b> From Date</b>
                                
                                          <select  name="from_date"  style="width:60px;">
												<?php 
                                                    for($x=1; $x<=31; $x++){
												   //$selected=($_POST['from_date']==$x || date('d')==$x? 'selected' : '');
													 $selected=($_POST['from_date']==$x) ? 'selected' : '';
													if($x<10)
                                                        echo '<option value=0'.$x.' '.$selected.'>'.'0'.$x.'</option>';
                                                    else
                                                        echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
                                          <select name="from_month" style="width:110px;">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['from_month']==$x || date('m')==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="from_year" style="width:70px;">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['from_year']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
										
                                    &nbsp;&nbsp;&nbsp;
                                      <b> To Date</b>
                                      
                                                   <select name="to_date"  style="width:60px;">
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
                                          <select  name="to_month" style="width:110px;">
                                             <?php
											   $monthArray=array('Month','Janurary','Feburary','March','April','May','June','July',
											   'August','September','October','November','December');
													 for($x=1;$x<sizeof($monthArray);$x++){
														 $selected=($_POST['installation_mm']==$x || date('m')==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="to_year" style="width:70px;">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
									&nbsp;&nbsp;&nbsp;
                                    <b>Maintenance Type</b>
                         	<select name="maintenance_type" style="width:240px;">
                                       		<option value="">All</option>
                                             <?php
									$ssql="select * from maintenance_type_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$selected=($_POST['maintenance_type']==$f['maintenance_type'])?'selected':'';
										echo '<option value="'.$f['maintenance_type'].'" '.$selected.'>'.$f['maintenance_type'].'</option>';
										}
									?>
                                          </select>
                                          <br>
									&nbsp;&nbsp;&nbsp;
                                    <b>Engineer</b>
                         	<select name="engineer" style="width:140px;">
                                       		<option value="">All</option>
                                             <?php
									$ssql="select * from user_management where user_type='engineer' and factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
										$selected=($_POST['engineer']==$f['uid'])?'selected':'';
										echo '<option value="'.$f['uid'].'" '.$selected.'>'.$f['fullname'].'</option>';
										}
									?>
                                          </select>
								 
                            	 &nbsp;&nbsp;
                                   <b>WO Type</b>
                                  <select name="wo_type" style="width:120px;">
                                       		<option value="">All</option>
                                            <option value="SCH" <?php echo ($_POST['priority']=='high')?'selected':''?>>Scheduled</option>
                                            <option value="BRK" <?php echo ($_POST['priority']=='medium')?'selected':''?>>Breakdown</option>
                                            <option value="UNS" <?php echo ($_POST['priority']=='low')?'selected':''?>>Un-Scheduled</option>
									?>
                                          </select>
                            	 &nbsp;&nbsp;
                                  
                                 &nbsp;&nbsp;
                                   <b>Status</b>
                                  <select name="wo_status" style="width:130px;" >
                                       		<option value="" <?php  echo  ($_POST['wo_status']=='')?'selected':''?>>All</option>
                                           <option value="NULL" <?php  echo  ($_POST['wo_status']=='NULL')?'selected':'NULL'?>>Pending</option>
                                            <option value="1"  <?php echo  ($_POST['wo_status']=='1')?'selected':''?>>Work on progress</option>
                                            <option value="2" <?php echo  ($_POST['wo_status']=='2')?'selected':''?>>Completed</option>
                                            <option value="3" <?php echo  ($_POST['wo_status']=='3')?'selected':''?>>Approved</option>
                                          
                                          </select>
                            	 &nbsp;&nbsp;
                                  
                                   &nbsp;&nbsp;
                                   <b>Asset Code</b>
									<input type="text" style="width:120px;" name="asset_code">
                            	 &nbsp;&nbsp;
                                    <input type="hidden" name="submit-form" value="submit-form">
                                    <input type="submit" value="search" >
                                     <a href="export-excel-wo.php?export=true"><input type="button" value="Export to Excel" ></a>
								</form>
                        	
                            </div>
									
                                    
                        <table class=" table-striped table-hover table-bordered"  width="100%" >
									<thead>
										<tr>
                                            <th>#</th>
                                            <th>WO Date</th>
                                            <th>WO Type</th>
											<th>SCH Date</th>
<?php /*?>      <th>SCH Type</th>
                                            <th>FRQ</th><?php */?>
                                            <th>Engineer</th>
                                            <th>Asset Code</th>
											<th>Name</th>
											<th>Plant</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>MA Type</th>
                                             <th>WO Status</th>
                                             <th>Status Date</th>

                                        </tr>
									</thead>

                                    <tbody>
 								<?php
									//echo $sq;
									$rs=odbc_exec($conn,$sq);
									
									//echo odbc_num_rows($rs);
									$count=1;
									while($f = odbc_fetch_array($rs)){
									//print_r($f);	
											$e=array(
												'eng'	=> trim($f['work_order_engineer_id'])
											);
										
										if($_SESSION['user_type']=='engineer' || $_SESSION['user_type']=='superwiser' ){
											if(trim($_SESSION['maintenance_type_name'])!=trim($f['maintenance_type']))
											continue;
										
										if ($_SESSION['user_type']=='engineer'  && !in_array($_SESSION['uid'], $e)) {
												continue;
											}
												
										
											//if($f['workorder_status']==2 && $_SESSION['user_type']=='engineer')
											//continue;	
										
										
										}
										if(trim($_SESSION['user_type'])=='general'){
										
											continue;
										}
										//echo '<pre>';
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['workorder_start_date'])).'</td>';
										echo '<td align="center" width="1%">'.strtoupper($f['work_order_type']).'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['schedule_generated_date'])).'</td>';
										//echo '<td>'.strtoupper($f['recurrence_schedule']).'</td>';
										//echo '<td>'.strtoupper($f['frequency']).'</td>';
										echo '<td>';
											 $se="select fullname from user_management where uid in (".$f['work_order_engineer_id'].")";
											$rse=odbc_exec($conn,$se);
											$ce=1;
											while($fr = odbc_fetch_array($rse)){
												echo $ce.'. ';
												echo ucfirst($fr['fullname']);
												echo '<br>';
												$ce++;
											}
										echo '</td>';
										
										if($f['workorder_status']==1){
											$stat='Work on progress';
											$sdate=	$f['workorder_accepted_timestamp'];				
										}
										
										if($f['workorder_status']==2){
											$stat='Pending for approval';
											$sdate=	$f['workorder_complete_date'];	
										}
										
										if(empty($f['workorder_status'])){
											$stat='Pending';
											$sdate=	$f['workorder_generated_timestamp'];	
										}
										
										if($f['workorder_status']==3){
											$stat='Completed';
											$sdate=	$f['workorder_complete_date'];	
										}
									
										
										
										echo '<td>'.strtoupper($f['asset_code']).'</td>';																										
										echo '<td>'.ucfirst($f['asset_name']).'</td>';	
										echo '<td>'.$f['plant_building'].'</td>';
										echo '<td>'.$f['dept'].'</td>';
										echo '<td>'.$f['location'].'</td>';
										echo '<td>'.$f['maintenance_type'].'</td>';
										//<a href="#" data-toggle="modal" class="btn mini purple" title="View"><i class=" icon-eye-open"> View</i></a>';
										echo '<th align="center">'.$stat.'</th>';
										echo '<th align="center">'.date('d-m-Y',strtotime($sdate)).' </th>';
										echo '<th>';


echo '
<a href="show-work-order-details.php?woid='.$f['workorder_id'].'&report=true" data-toggle="modal" class="btn mini green" title="View Work Order"><i class=" icon-eye-open"> View WO </i></a>
	';	
	


	echo '</th>';
		$count++;
				}
	?>
									</tbody>
								</table>
							
                        </div>  
                         <?php /*?><button class="btn red"> <a href="generate-schedule.php" style="color:#FFFFFF">Generate Schedule </a></button>
							  <button class="btn red"> <a href="generate-schedule.php" style="color:#FFFFFF">Generate Work Order</a></button><?php */?>						                                
                            
			
                            		
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