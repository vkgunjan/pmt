<?php 
	        $sm='active';
	        $la='active';

        include_once('including/all-include.php');
        include_once('including/header.php');

//print_r($_POST);

if(isset($_POST['submit'])){
	 $from_date=$_POST['from_year'].'-'.$_POST['from_month'].'-'.$_POST['from_date'];
 	 $to_date=$_POST['to_year'].'-'.$_POST['to_month'].'-'.$_POST['to_date'];
	 //$maintenance_type=$_POST['maintenance_type'];	
	 
	 $dataArray=array(
		'from_date'					=> $from_date,
		'to_date'					=> $to_date,
		'maintenance_type'			=> trim($_POST['maintenance_type']),
		'asset_type'				=> trim($_POST['asset_type']),
		'plant_building'			=> trim($_POST['plant_building'])
		);
	

	 $sql="
select gs.schedule_generated_date, gs.reschedule, s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.frequency, s.maintenance_type_id, m.maintenance_type , a.asset_code, a.asset_name, at.asset_type, a.asset_kept_area, p.plant_building_name from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where gs.schedule_generated_date >= '".$from_date."' and gs.schedule_generated_date <= '".$to_date."' 
and gs.skip is null ";


if($dataArray['asset_type']!='all'){
	$sql.=" and at.asset_type_id= '".$dataArray['asset_type']."' ";
}

if($dataArray['plant_building']!='all'){
	$sql.=" and p.plant_building_id = '".$dataArray['plant_building']."' ";
}


if(trim($_SESSION['user_type'])=='engineer')
{
	$sql .="and s.maintenance_type_id='".$_SESSION['maintenance_type']."' ";
}else{
	if($dataArray['maintenance_type']!='all'){
	$sql .="and s.maintenance_type_id='".$dataArray['maintenance_type']."' ";
	}
}


$sql .="and NOT EXISTS (
   SELECT 1              
   FROM   work_order w
   WHERE  w.schedule_generated_id = gs.schedule_generated_id )
 ";
//echo $sql; 
}else{
		 $from_date=date('Y').'-'.date('m').'-'.date('d');
 	 $to_date=date('Y').'-'.date('m').'-'.date('d');

		$sql="
select gs.schedule_generated_date,gs.reschedule,  s.asset_id, gs.schedule_generated_id, s.recurrence_schedule, s.frequency, s.maintenance_type_id, m.maintenance_type , a.asset_code, a.asset_name, at.asset_type, a.asset_kept_area, p.plant_building_name  from schedule_generated gs
left join schedule s on s.schedule_id=gs.schedule_id
left join maintenance_type_master m on s.maintenance_type_id=m.maintenance_type_id
left join asset_master a on a.asset_id = s.asset_id 
left join work_order w on w.schedule_generated_id = gs.schedule_generated_id
left join asset_type_master at on at.asset_type_id = a.asset_type
left join plant_building_master p on p.plant_building_id = a.plant_building
where gs.schedule_generated_date >= '".$from_date."' and gs.schedule_generated_date <= '".$to_date."' ";

if(trim($_SESSION['user_type'])=='engineer')
{
	$sql .="and s.maintenance_type_id='".$_SESSION['maintenance_type']."' ";
}


$sql .=" and NOT EXISTS (
   SELECT 1              
   FROM   work_order w
   WHERE  w.schedule_generated_id = gs.schedule_generated_id)
 ";
 
 }



//echo $sql;


        ?>
    

        
<script type="text/javascript">
function submitform()
{
 var checkboxs=document.getElementsByName("wo[]");
    var okay=0;
    for(var i=0,l=checkboxs.length;i<l;i++)
    {
        if(checkboxs[i].checked)
        {
            okay++;
	    }
    }
   
   if(okay > 1 )
	  alert("Please select 1 schedule.");
	else{
		if(okay==0){
			alert("Please select at least 1 schedule.");
		}else{
		  document.myform.submit();
		}
	}
}
</script>

<script>
function submitcheck(){
	//alert ('hello');

		var fd=document.getElementById("from_date").value;
		var fm=document.getElementById("from_month").value;
		var fy=document.getElementById("from_year").value;
		var datefrom = fd+'/'+fm+'/'+fy;

		var td=document.getElementById("to_date").value;
		var tm=document.getElementById("to_month").value;
		var ty=document.getElementById("to_year").value;
		var dateto = td+'/'+tm+'/'+ty;


if(datefrom > dateto)
{
    alert("Error: From date can not be greater than to date.");
	return false;
}


//	alert(dd);
}
</script>



				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>List of All Scheduled Assets </h4>
								<div class="tools">
                
                <?php 
					if($_SESSION['user_type']=='superadmin' || $_SESSION['user_type']=='admin' || $_SESSION['user_type']=='superwiser' ){
				?>
                 <a href="generate-schedule.php" class="btn purple" style="margin-top:-10px;"> 
                 <i class="icon-calendar"></i> Generate Maintenance Schedule Calender</a>
				 <?php } ?>
    

     
                 <a class="btn green" style="margin-top:-10px;" href="javascript: submitform()"> 
                 <i class="icon-file"></i> Generate Work Order</a>
                 
                             
                                   
                                    <a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
								</div>
							</div>
							<div class="portlet-body">

                  			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                         <div style="width:100%;" >   

                                     <b> From Date</b>
                                
                                          <select  name="from_date"  style="width:100px;" id="from_date">
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
                                          <select name="from_month" style="width:210px;" id="from_month">
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
                                          <select  name="from_year" style="width:100px;" id="from_year">
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
                                      
                                                   <select name="to_date"  style="width:100px;" id="to_date">
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
                                          <select  name="to_month" style="width:210px;" id="to_month">
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
                                          <select  name="to_year" style="width:100px;" id="to_year">
											   <?php
                                                    $cyr=date("Y");
                                                    for($x=$cyr; $x<=($cyr); $x++){
                                                        $selected=($_POST['installation_yy']==$x || $dd[0]==$x ? 'selected' : '');
                                                            echo '<option value='.$x.' '.$selected.'>'.$x.'</option>';	
                                                    }
                                                ?>
                                          </select>
								<br>
                                    <b>Maintenance Type</b>
                         	<select name="maintenance_type" style="width:190px;">
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
                            	&nbsp;&nbsp;&nbsp;	 
                         <b>  Asset Type	</b><select name="asset_type" style="width:190px;">
                                       		<option value="all">All</option>
                                             <?php
							if(trim($_SESSION['user_type'])=='engineer')
								$ssql="select * from asset_type_master where factory_id='".$_SESSION['factory-id']."' order by asset_type asc ";
							else
								$ssql="select * from asset_type_master where factory_id='".$_SESSION['factory-id']."' order by asset_type asc";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$sel=($f['asset_type_id']==$_POST['asset_type'])?'selected':'';
										echo '<option value="'.$f['asset_type_id'].'" '.$sel.'>'.$f['asset_type'].'</option>';
										}
									?>
                                          </select>     
                                      	&nbsp;&nbsp;&nbsp;    
                                        <b>  Plant Building </b><select name="plant_building" style="width:190px;">
                                       		<option value="all">All</option>
                                             <?php
							if(trim($_SESSION['user_type'])=='engineer')
								$ssql="select * from plant_building_master where factory_id='".$_SESSION['factory-id']."' ";
							else
								$ssql="select * from plant_building_master where factory_id='".$_SESSION['factory-id']."' ";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
											$sel=($f['plant_building_id']==$_POST['plant_building'])?'selected':'';
										echo '<option value="'.$f['plant_building_id'].'" '.$sel.'>'.$f['plant_building_name'].'</option>';
										}
									?>
                                          </select>     
                                 &nbsp;&nbsp;&nbsp;	         
                                           
 <button type="submit" name="submit" value="true" class="btn green" style="margin-top:-10px;" onClick="return submitcheck();">Refresh&nbsp; 
                                    <i class="icon-refresh"></i></button>
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
										    <th>Work Order</th>                                                                                        
                                        </tr>
									</thead>

                                    <tbody>
 								<?php
									//echo $sql;
									$rs=odbc_exec($conn,$sql);
									//echo odbc_num_rows($rs);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										if($f['reschedule']==1){
											echo '<tr style="color:red">';
										echo '<td>'.$count.'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['schedule_generated_date'])).' | Re-SCH</td>';										

										}else{
											echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['schedule_generated_date'])).'</td>';										

										}
										echo '<td>'.strtoupper($f['asset_code']).'</td>';
										echo '<td>'.strtoupper($f['asset_type']).'</td>';				
										echo '<td>'.ucfirst($f['asset_name']).'</td>';
										echo '<td>'.ucfirst($f['plant_building_name']).'</td>';
										
										echo '<td>'.strtoupper($f['asset_kept_area']).'</td>';	
										echo '<td>'.$f['maintenance_type'].'</td>';
										//echo '<br>'.$f['frequency'].'-'.$f['recurrence_schedule'];	
											
											if(trim($f['recurrence_schedule'])=='monthly'){

												if(trim($f['frequency'])==3){
													$dv='Quartly';
												}elseif(trim($f['frequency'])==6){
													$dv='Halfyearly';
												}else{
													$dv='Monthly';
												}
												
											}
											
											
											if(trim($f['recurrence_schedule'])=='weekly'){

												
												if(trim($f['frequency'])==2){
													$dv='Fortnightly';
												}else{
													$dv='Weekly';
												}
												
												
											}
											
										echo '<td>'.ucfirst($dv).'</td>';
//										echo '<td>'.ucfirst($f['recurrence_schedule']).'</td>';
//										echo '<td>
//											<a href="#" class="btn mini red"><i class="icon-trash"></i> Skip Schedule</a>
//										</td>';
										echo '<td align="center"><input type="checkbox" name="wo[]" value='.$f['schedule_generated_id'].'></td>';
										$count++;
									}
									?>
       
									</tbody>
								</table>
							</form>
                        </div>  
                         <?php /*?><button class="btn red"> <a href="generate-schedule.php" style="color:#FFFFFF">Generate Schedule </a></button>
							  <button class="btn red"> <a href="generate-schedule.php" style="color:#FFFFFF">Generate Work Order</a></button><?php */?>						                                
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