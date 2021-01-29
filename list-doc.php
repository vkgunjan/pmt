<?php 
	        $cd='active';
	        $cda='active';

        include_once('including/all-include.php');
        include_once('including/header.php');
		unset($_SESSION['working-active-asset']);
		

		$sql="SELECT 
												g.get_id,
												g.get_name,
												g.get_desc,
												g.get_category,
												g.get_sub_category,
												g.get_dept,
												g.get_city,
												g.get_pdf,
												g.get_cat,
												g.creation_remark,
												g.created_on,
												u.fullname,
												case 
												when g.get_status = '1' Then 'Approved' 
												when g.get_status = '2' Then 'Rejected'
												when g.get_status = '0' Then 'Pending' 
												Else '' End as get_status

												from get_doc_new g
												left join user_management u on u.uid = g.created_by 
								  ";
  
    if(trim($_SESSION['user_type'])=='management' || $_SESSION['uid']== '2015') {
		$sql.="  where 1=1 order by g.created_on desc ";
	}else{

			if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
					
					if($_SESSION['user_type']=='manager'){
					$sql.=" where ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$sql .="g.created_by = '".$vx."' or g.created_by='".$_SESSION['uid']."' ";
							else
								$sql .=" or g.created_by = '".$vx."' ";
							$xcnt++;
						}
						$sql .=" )order by g.created_on desc";
					}else{
						$sql.="  where g.created_by='".$_SESSION['uid']."' 
						order by g.created_on desc";	
					}

			}
		
	}


	//echo $sql;
	
									$rs=odbc_exec($conn,$sql);
									$count=1;


			
			//print_r($_SESSION);
        ?>
            

				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>List of All GET Documents</h4>
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
										<a href="create_doc.php">
                                        <button class="btn green">
										Upload New Document <i class="icon-plus"></i>
										</button>
                                        </a>
									</div>	
                    
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<!-- <li><a href="#">Print</a></li> -->
											<li><a href="export_doc.php?val_proj=<?php echo base64_encode($sql); ?>">Export Details</a></li>
										</ul>
									</div>
								</div>
								<div class="scrollable">
								<table class="table table-striped table-bordered table-hover" id="sample_1" >

									<thead style="white-space: nowrap; padding: 0px;">
										<tr>
                                            <th>#</th>
                                            <th>File</th>
                                            <th>Document Name</th>
                                            <th>Descreption</th>
											<th>Category</th>
											<th>Sub Category</th>
											<th>Department</th>
                                            <th>City</th>
											<th>Type</th>
											<th>Uploaded By</th>
											<th>Uploaded On</th>
											<th>Status</th>                                            
	                                        <th>Creation Remark</th>
                                            <th>Action</th>
                                        </tr>

									</thead>
									<tbody style="white-space: nowrap;">
									
								       <?php
										
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										$path = "assets/get_doc/".$f['get_category']."/";
										echo '<tr>';
										echo '<td>'.$count++.'</td>';
										echo '<td style="text-align: center;">';
										echo '<a href='.$path.''.$f['get_pdf'].' target="_blank"><img src="assets/img/pdf2.png" alt="" style="max-width: 30px"></a>';
										echo '</td>';
										echo '<td class="highlight">';
										echo '<a href='.$path.''.$f['get_pdf'].' title="'.ucfirst($f['get_name']).'" target="_blank">'.(strlen($f['get_name']) > 30 ? substr($f['get_name'],0,30)."..." : $f['get_name']).'</a>';
										echo '</td>';
										echo '<td title="'.ucfirst($f['get_desc']).'">'.(strlen($f['get_desc']) > 30 ? substr($f['get_desc'],0,30)."..." : $f['get_desc']).'</td>';	
										echo '<td>'.trim($f['get_category']).'</td>';	
										echo '<td>'.ucfirst(trim($f['get_sub_category'])).'</td>';
										echo '<td>'.ucfirst(trim($f['get_dept'])).'</td>';
										echo '<td>'.ucfirst(trim($f['get_city'])).'</td>';
										echo '<td style="text-align:center;">'.ucfirst(trim($f['get_cat'])).'</td>';
										echo '<td>'.ucfirst(trim($f['fullname'])).'</td>';
										echo '<td>'.date('d-m-Y',strtotime(trim($f['created_on']))).'</td>';
										echo '<td>'.trim($f['get_status']).'</td>';
										echo '<td>'.ucfirst(trim($f['creation_remark'])).'</td>';
										
										if(trim($f['get_status'])=='Pending' && $_SESSION['uid'] == '2015'){
										echo '<td>';
										echo '<a href="create_doc.php?pid='.$f['get_id'].'" class="btn mini red no-print"><i class="icon-edit"></i>Approve</a>';
										echo '</td>';
										}

										if(trim($f['get_status'])=='Rejected'){
										echo '<td>';
										echo '<a href="create_doc.php?pid='.$f['get_id'].'" class="btn mini yellow no-print"><i class="icon-edit"></i> Edit</a>';
										echo '</td>';
										}

										if(trim($f['get_status'])=='Approved'){
										echo '<td>';
										echo '<a href="#" class="btn mini green no-print">Approved</a>';
										echo '</td>';
										}

										if(trim($f['get_status'])=='Pending' && $_SESSION['uid'] != '2015'){
										echo '<td>';
										echo '<a href="create_doc.php?pid='.$f['get_id'].'" class="btn mini purple no-print"><i class="icon-edit"></i> Pending</a>';
										echo '</td>';
										}
									}
									?>
       
									</tbody>
								</table>
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