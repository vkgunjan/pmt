<?php 
	        $pm='active';
	        $lopp='active';

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
								<h4><i class="icon-edit"></i>List of All Opportunities</h4>
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
										<a href="add-opportunity.php">
                                        <button class="btn green">
										Add New Opportunity <i class="icon-plus"></i>
										</button>
                                        </a>
									</div>
                                    	&nbsp;&nbsp;&nbsp;							
										<font color="#000000"><span class="label label-success">O</span> - Open</font>
										&nbsp;
										<font color="#000000"><span class="label label-warning">C</span> - Close</font>
					

                    
                        <form action="list-asset.php" method="post" style="float:right">     
                                          <b>Select Project Type to Filter</b>
                                          	<select name="asset_type" onChange="javascript:form.submit();">
                                	 <option value="all">All</option>
                                      <?php
										$sqa='select * from project_type_master';
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
											 echo '<option value="'.$xx['asset_type'].'" '.$selected.'>'.$xx['project_type'].'</option>';
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
                                            <th>CKA Name</th>
											<th >CKA Type</th>
											<th >Project Type</th>
											<th >Project Name</th>
											<th >State</th>
											<th >City</th>
                                            <th >Project Contact</th>
                                            <th>Tile Stage Date</th>
                                            <th>Sale Forecast(INR)</th>
                                            <th>Status</th>
                                            <th width="7%">Action</th>
                                            
                                                                                        
                                        </tr>
									</thead>
									<tbody>
									
       <?php
		$sql="SELECT 
		d.opportunity_id,
	 a.cka_name,
	 b.cka_type,
	 c.project_type,
	 d.[project_name],
     e.state_name,
     d.[city],
     d.[project_contact],
	 d.[tile_stage_date],
     d.[obl_sale_forecast_inr],
     d.[status]
  FROM [opportunity] d
  left join cka_name_master a on a.cka_name_id = d. cka_name_id
  left join cka_type_master b on b.cka_type_id = d.cka_type_id
  left join project_type_master c on c.project_type_id = d.project_type_id
  left join state_master e on e.state_id = d.state_id	 ";
	 
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
										echo '<td>'.$f['cka_name'].'</td>';
										echo '<td>'.$f['cka_type'].'</td>';										
										echo '<td >'.$f['project_type'].'</td>';																
										echo '<td>'.ucfirst($f['project_name']).'</td>';	
										echo '<td>'.ucfirst(strtolower($f['state_name'])).'</td>';	
										echo '<td>'.$f['city'].'</td>';
										echo '<td>'.$f['project_contact'].'</td>';
										echo '<td>'.$f['tile_stage_date'].'</td>';
										echo '<td>'.$f['obl_sale_forecast_inr'].'</td>';
										//echo '<th>'.ucfirst($f['status']).'</th>';
										
										if(trim($f['status'])=='open'){
											echo '<td align="center"><span class="label label-success">O</span></td>';
										}
																		
										if(trim($f['status'])=='close'){
											echo '<td align="center"><span class="label label-warning">C</span></td>';
										}
										
										
									echo '<td >';
						echo '<a href="#add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini blue"><i class="icon-edit"></i> Edit</a>';
						echo '&nbsp;';
						//echo '<a href="asset-master.php?delid='.$f['asset_id'].'" class="btn mini red"><i class="icon-trash"></i> Delete</a>';
						//echo '&nbsp;';		
	
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