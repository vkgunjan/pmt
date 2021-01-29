
<?php

$ct='active'; 
$oc='active'; 
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
?>

<!-- cat order data -->

<?php
		$d="SELECT 
				h.lg_id as [Log ID],
				h.lg_code as [Log Code],
				h.lg_emp_code as [Employee Code], 
				h.lg_full_name as [Employee Name], 
				h.lg_emp_email as [Email ID], 
				h.lg_mobile as [Mobile No],
				s.zone as [Zone], 
				m.state as [State], 
				m.territory as [Territory],
				m.city as [City], 
				(SELECT TOP 1 dbo.getCatNames(h.lg_catalogue_id, ',')) as [Catalogue],
				
				h.lg_docket_no as [Docket No],
				h.lg_docket_date as [Docket Date],			
				 
				h.lg_required_date as [Required Date],
				h.lg_address as [Address],
				h.lg_created_date as [Created On],
				case
				when h.lg_status = 1 Then 'Open'
				when h.lg_status = 2 Then 'In Process'
				when h.lg_status = 3 Then 'Dispatched'
				Else '' End as Status
	
				FROM log_history h
				left join city_master m on m.id = h.lg_city
				inner join state_master s on s.state_id = (select state_id from city_master where id = h.lg_city)
  ";
  
    if(trim($_SESSION['user_type'])=='management' || $_SESSION['employee_department']=='obtbadmin') {
    			$d .="  where 1=1 order by h.lg_created_date desc ";
  				}else{


      			if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail' || $_SESSION['employee_department']=='obtbadmin' || $_SESSION['employee_department']=='coco'){
          
          		if($_SESSION['user_type']=='manager'){
          		$d .=" where 1=1 
            	and ( ";

            	$ex=explode(",",$_SESSION['my_team_id']);
              	$xcnt=0;
            	foreach ($ex as $vx){
            	//echo $vx;
              	if($xcnt==0)
                $d .=" h.lg_uid = '".$vx."' or h.lg_uid='".$_SESSION['uid']."' ";
              	else
                $d .=" or h.lg_uid = '".$vx."' ";
             	$xcnt++;
            	}
            	$d .=" ) order by h.lg_created_date desc ";
          		}else{
            	$d .="  where h.lg_uid='".$_SESSION['uid']."' order by h.lg_created_date desc"; 
          }

      }
    
  }

	?>

<!-- cat order data end -->




<?php 

		$sql = "SELECT 
				h.lg_id as [log_id],
				h.lg_uid,
				h.lg_code as [lg_code],
				h.lg_emp_code as [emp_code], 
				h.lg_full_name as [full_name], 
				h.lg_emp_email as [email], 
				h.lg_mobile as [mobile], 
				m.state as [state], 
				m.territory as [territory],
				m.city as [city], 
				  
				h.lg_required_date as [required_date],
				h.lg_address as [address],
				h.lg_dispatch_remark,
				h.lg_created_date,
				h.lg_status,
				(SELECT TOP 1 dbo.getCatNames(h.lg_catalogue_id, ',')) as [cat_name] 
				

				FROM log_history h
				left join city_master m on m.id = h.lg_city";

				if(trim($_SESSION['user_type'])=='management' || $_SESSION['employee_department']=='obtbadmin') {
    			$sql.="  where 1=1 order by h.lg_created_date desc ";
  				}else{


      			if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail' || $_SESSION['employee_department']=='obtbadmin' || $_SESSION['employee_department']=='coco'){
          
          		if($_SESSION['user_type']=='manager'){
          		$sql.=" where 1=1 
            	and ( ";

            	$ex=explode(",",$_SESSION['my_team_id']);
              	$xcnt=0;
            	foreach ($ex as $vx){
            	//echo $vx;
              	if($xcnt==0)
                $sql .=" h.lg_uid = '".$vx."' or h.lg_uid='".$_SESSION['uid']."' ";
              	else
                $sql .=" or h.lg_uid = '".$vx."' ";
             	$xcnt++;
            	}
            	$sql .=" ) order by h.lg_created_date desc ";
          		}else{
            	$sql .="  where h.lg_uid='".$_SESSION['uid']."' order by h.lg_created_date desc"; 
          }

      }
    
  }

				$rs=odbc_exec($conn,$sql);
				$count=1;

?>


<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box light-grey">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Catalogue Order List</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
									<a href="catalogue-order.php"><div class="example-1">Order New <i class="icon-plus"></i></div></a>
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<!-- <li><a href="#">Print</a></li>
											<li><a href="#">Save as PDF</a></li> -->
											<li><a href="export_cat.php?val=<?php echo base64_encode($d); ?>">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
										  <th width="1%">#</th>
					                      <th width="3%">Territory</th>
					                      <th width="5%">State</th>
					                      <th width="5%">City</th>
					                      <th width="5%">Emp Code</th>
					                      <th width="7%">Name</th>
					                      <th width="5%">Contact No</th>
					                      <th width="25%">Catalogue</th>
					                      <th width="7%">Required Date</th>
					                      <th width="15%">Address</th>
					                      <th width="7%">Dispatch Remarks</th>
					                      <th width="7%">Order Date</th>
					                      <th width="3%">Status</th>
					                      <th width="5%">Action</th>

										</tr>
									</thead>
									<tbody>

									<?php 
												

												  $rs=odbc_exec($conn,$sql);
								                  $count=1;
								                  while($f = odbc_fetch_array($rs)){
								                  $cat_explode=explode(',',$f['cat_name']);

								                  	echo '<tr>';
								                    echo '<td>'.$count.'</td>';
								                    echo '<td>'.$f['territory'].'</td>';
								                    echo '<td>'.$f['state'].'</td>';
								                    echo '<td>'.$f['city'].'</td>';                                
								                    echo '<td>'.$f['emp_code'].'</td>';
								                    echo '<td>'.$f['full_name'].'</td>';  
								                    echo '<td>'.$f['mobile'].'</td>';
								                    echo '<td>'.$f['cat_name'].'</td>';
								                    /*echo '<td>';
								                    echo '<pre>'.print_r($cat_explode).'</pre>';
								                    
								                    echo str_replace(array('&lt;?php&nbsp;','?&gt;'), '', highlight_string( '<?php ' .     var_export($f['cat_name'], true) . ' ?>', true ) );
								                    echo '</td>';*/
								                    echo '<td>'.$f['required_date'].'</td>';
								                    echo '<td>'.$f['address'].'</td>';
								                    echo '<td>'.$f['lg_dispatch_remark'].'</td>';
								                    echo '<td>'.date('Y-m-d',strtotime(trim($f['lg_created_date']))).'</td>';
								                    
								                    
								                    if($f['lg_status'] == 1){
								                    	$status = "Open";
								                    echo '<td style="color:red;"><b>'.$status.'</b></td>';	
								                    }else if($f['lg_status'] == 2){
								                    	$status = "In Process";
								                    	echo '<td style="color:orange; font-weight:400;"><b>'.$status.'</b></td>';	
								                    }else if($f['lg_status'] == 3){
								                    	$status = "Dispatched";
								                    	echo '<td style="color:green; font-weight:400;"><b>'.$status.'</b></td>';	
								                    }else{
								                    	$status = "Closed";
								                    	echo '<td style="color:gray; font-weight:400;"><b>'.$status.'</b></td>';
								                    }

								                    
								                    /*echo '<td style="text-align:center; vertical-align:middle;">';
								                    echo '<a href="update_catalogue.php?pid='.$f['lg_code'].'" class="no-print"><font color="#263238"><i class="icon-edit"></i></font></a>';
								                    echo '</td>';
								                    
								                    echo '<td style="text-align:center; vertical-align:middle;">';
								                    echo '<a href="cat_details.php?pid='.$f['lg_code'].'" class="no-print"><font color="#263238"><i class="icon-print"></i></font></a>';
								                    echo '</td>';*/
								                    echo '<td>';
				if(trim($_SESSION['employee_department'])=='obtbadmin' || trim($_SESSION['employee_department'])=='management'){
				echo '<a href="update_catalogue.php?pid='.$f['lg_code'].'" class="btn mini green icn-only"><i class="icon-edit"></i>&nbsp;Edit</a>';
				echo '<a href="cat_details.php?pid='.$f['lg_code'].'" class="btn mini icn-only" target="_blank"><font color="#000">Info&nbsp;<i class="icon-info-sign"></i></font></a>';
				}else{
				//echo '<a href="add-opportunity.php?pid='.$f['opportunity_id'].'" class="btn mini red no-print">History</a>';
				echo '<a href="cat_details.php?pid='.$f['lg_code'].'" class="btn mini icn-only no-print" target="_blank"><font color="#000">Info&nbsp;<i class="icon-info-sign"></i></font></a>';
				}

				echo '</td>';
								                    echo '</tr>';

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
			</div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
	

	<?php include_once('including/footer.php')?>
	
	<?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
      $ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>

   