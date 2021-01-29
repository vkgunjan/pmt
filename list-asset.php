<?php 
	        $am='active';
	        $la='active';

        include_once('including/all-include.php');
        include_once('including/header.php');
			unset($_SESSION['working-active-asset']);
			
			
			//print_r($_SESSION);
        ?>
            

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>List of All Assets [Click on Schecule to Generate Maintenance Schedule]</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                	<div class="btn-group">
										<a href="asset-master.php">
                                        <button class="btn green">
										Add Asset <i class="icon-plus"></i>
										</button>
                                        </a>
									</div>
                                    	&nbsp;&nbsp;&nbsp;							
										<font color="#000000"><span class="label label-success">A</span> - Active</font>
										&nbsp;
										<font color="#000000"><span class="label label-warning">D</span> - Deactive</font>
										&nbsp;
										<font color="#000000"><span class="label label-danger">S</span> - Scrap</font>
					

                    
                        <form action="list-asset.php" method="post" style="float:right">     
                                          <b>Select Asset Type to Filter</b>
                                          	<select name="asset_type" onChange="javascript:form.submit();">
                                	 <option value="all">All</option>
                                      <?php
										$sqa='select * from asset_type_master order by asset_type asc';
										$ee=odbc_exec($conn,$sqa);
										while($xx=odbc_fetch_array($ee)){
										 //print_r($xx);
										  	 
											 if(!empty($_POST['asset_type']) && $_POST['asset_type']!='all'){
											  $selected=($_POST['asset_type']==$xx['asset_type'])?'selected':'';
											 }else{
												if(!empty($_SESSION['list_asset_filter']) && $_POST['asset_type']!='all' ){
												 $selected=($_SESSION['list_asset_filter']==$xx['asset_type'])?'selected':'';
												}
											 }
											 echo '<option value="'.$xx['asset_type'].'" '.$selected.'>'.$xx['asset_type'].'</option>';
										}
									?>
                                </select>
						</form>
									<?php 
									//vks comment
									/*?><div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Print</a></li>
											<li><a href="#">Save as PDF</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul>
									</div><?php */?>
								</div>
								<table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											<th>#</th>
                                            <th>Code</th>
											<th width="5%">Type</th>
											<th width="5%">Name</th>
											<th width="2%">Plant / Building</th>
											<th width="1%">Dept</th>
											<th width="5%">Location</th>
                                            <th width="5%">Area</th>
                                            <?php /*?><th>Model</th>
                                            <th>Serial</th><?php */?>
                                            <th>Status</th>
                                            <th>Action</th>                                            
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		$sql="SELECT a. [asset_id]
      ,a.[asset_code]
      ,a. [asset_name]
	  ,a.model_number,
	  a.serial_number,
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
     where a.factory_id='".$_SESSION['factory-id']."'
	 ";
	 
	 if(!empty($_POST['asset_type']) && $_POST['asset_type']!='all'){
	 
	   $sql.="and atm.asset_type='".$_POST['asset_type']."'";
	 
	   $_SESSION['list_asset_filter']=$_POST['asset_type'];
	 
	 }else{
	 	if(!empty($_SESSION['list_asset_filter']) && $_POST['asset_type']!='all' ){
	 	  $sql.="and atm.asset_type='".$_SESSION['list_asset_filter']."'";
	 	}
	 }
	//echo $sql;
	
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['asset_code'].'</td>';
										echo '<td>'.$f['asset_type'].'</td>';										
										echo '<td width="5%">'.$f['asset_name'].'</td>';																
										echo '<td>'.$f['plant_building_name'].'</td>';	
										echo '<td>'.$f['department_section_name'].'</td>';
										echo '<td>'.$f['location_name'].'</td>';
										echo '<td>'.$f['asset_kept_area'].'</td>';
										//echo '<td>'.$f['model_number'].'</td>';
										//echo '<td>'.$f['serial_number'].'</td>';
										
										if(trim($f['asset_condition'])=='active'){
											echo '<td><span class="label label-success">A</span></td>';
										}
										
										if(trim($f['asset_condition'])=='deactive'){
											echo '<td><span class="label label-warning">D</span></td>';
										}
										
										if(trim($f['asset_condition'])=='scrap'){
											echo '<td><span class="label label-danger">S</span></td>';
										}
										
										
									echo '<td>';
						echo '<a href="asset-master.php?pid='.$f['asset_id'].'" class="btn mini blue"><i class="icon-edit"></i> Edit</a>';
						echo '&nbsp;';
						//echo '<a href="asset-master.php?delid='.$f['asset_id'].'" class="btn mini red"><i class="icon-trash"></i> Delete</a>';
						//echo '&nbsp;';		
	
			 $ssl="select schedule_id from schedule where asset_id='".$f['asset_id']."'";
			$exe=odbc_exec($conn,$ssl);
			$n=odbc_num_rows($exe);
		if($n){
		echo '<a href="schedule-maintenance.php?pid='.$f['asset_id'].'" class="btn mini green"><i class="icon-cogs"></i> Sehedule</a>';
		}else{
		echo '<a href="schedule-maintenance.php?pid='.$f['asset_id'].'" class="btn mini red"><i class="icon-cogs"></i> Sehedule</a>';
		}
		echo '<br>';
		 $ssl="select recurrence_schedule, count(recurrence_schedule)as ccnt from schedule where asset_id='".$f['asset_id']."' group by recurrence_schedule";
			$exe=odbc_exec($conn,$ssl);
	while($ff=odbc_fetch_array($exe)){
		//echo '<pre>';
		//print_r($ff);
		
		//echo $ff['recurrence_schedule'];
		//echo $ff['ccnt'];
	
	if(trim($ff['recurrence_schedule'])=='daily'){
			 $ds=$ff['ccnt'];
		}

		if( trim($ff['recurrence_schedule'])=='weekly'){
			 $ws=$ff['ccnt'];
		}

		if(trim($ff['recurrence_schedule'])=='monthly'){
			 $ms=$ff['ccnt'];
		}

		if(trim($ff['recurrence_schedule'])=='yearly'){
			 $ys=$ff['ccnt'];
		}
		
	
			
	}
		if(isset($ds) && $ds>0){
		echo '<span style="background-color:red; color:white;" title="Total Daily Schedule">&nbsp;D&nbsp;'.$ds.' </span>';
				echo '&nbsp;';
		}
		
		if(isset($ws) && $ws>0){
		echo '<span style="background-color:magenta; color:white;" title="Total Weekly Schedule">&nbsp;W&nbsp;'.$ws.' </span>';
				echo '&nbsp;';
		}
		
		if(isset($ms) && $ms>0){
			echo '<span style="background-color:blue; color:white;" title="Total Monthly Schedule">&nbsp;M&nbsp;'.$ms.' </span>';
				echo '&nbsp;';
		}
		
		if(isset($ys) && $ys>0){
			echo '<span style="background-color:orange; color:white;" title="Total Yearly Schedule">&nbsp;Y&nbsp;'.$ys.' </span>';
		}
		
		unset($ds);unset($ws);unset($ms);unset($ys);
		
									echo '</td>';
										$count++;
									}
									?>
       
									</tbody>
								</table>
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