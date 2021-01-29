		<?php 
	        $master='active';
	        $uom='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
       
	   	$pid=(int)$_REQUEST['pid'];		


if(isset($_GET['pid']) && $_GET['pid']>0){
		$pid = (int)$_GET['pid'];
		$formType = 'Update UOM Details ';
		
		$btsel="select * from uom_master where uom_master_id='".dbInput($pid)."'";
		$rs=odbc_exec($conn,$btsel);
		$f = odbc_fetch_array($rs);
		//print_r($f);

		$dataArray=array(
					'uom_master_id'				=>	trim(dbOutput($f['uom_master_id'])),
					'uom_name'						=>	trim(dbOutput($f['uom_name']))
			);


		//print_r($dataArray);

	}elseif(!isset($_GET['pid'])){
	
		$formType = 'Add UOM';

	}


if(isset($_POST['submit'])){
		
	$dataArray=array(
					'uom_name'						=>	trim(dbOutput($_POST['uom_name']))
				);

//print_r($dataArray);

	if(EmptyCheck($dataArray['uom_name'])){
		 $errorArray['uom_name']='Enter UOM Name';
	}elseif(empty($pid)){
				$bt="select * from uom_master where uom_name='".dbInput($dataArray['uom_name'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['uom_name']='Uom Allready Exist...';
				}
		}

//print_r($errorArray);

	if(empty($errorArray)){
		
		if(isset($pid) && $pid>0){

		 $upd  ="UPDATE uom_master set uom_name='".dbInput($dataArray['uom_name'])."' ";
		 $upd .="where uom_master_id='".(int)dbInput($pid)."'";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' UOM Details Has Been Updated Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Update UOM Details , Please Try Later.';
					$msgType = 2;
				}
		}else{
				$insert  ="INSERT INTO uom_master (uom_name, factory_id)";
				$insert .="values('".dbInput(trim($dataArray['uom_name']))."', '".dbInput(trim($_SESSION['factory-id']))."' ) ";

				//echo $insert;
				$stmt = odbc_prepare($conn, $insert);
				if (odbc_execute($stmt)){ 
						$msgTxt = 'New UOM Added Successfully.';
						$msgType = 1;
				}else{
						$msgTxt = 'Sorry! Unable To Add New UOM Due To Some Reason. Please Try Later.';
						$msgType = 2;
					}
						
		}//isset id and id>0 else part ends here

				header('location:uom-master.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;

	}//empty error array check ends here
}//main post end here	

	   
	    ?>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">UOM Master</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                              <li><a href="#portlet_tab2" data-toggle="tab">List UOM</a></li>
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Add UOM</a></li>

                           </ul>

                      <!-- ADD FACTORY START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="pid" value="<?php echo $pid?>">                                        
                                    <div class="control-group">
                                       <label class="control-label">UOM Name</label>
                                       <div class="controls">
                                          <input type="text" name="uom_name" placeholder="" class="m-wrap large" value="<?php echo $dataArray['uom_name']?>" required/>
                                          <div style="color:#E10307"><?php echo $errorArray['uom_name']?></div>
                                       </div>
                                    </div>

                                                                        
                                    <div class="form-actions">
                                       <button type="submit" name="submit"  class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                                 <!-- ADD FACTORY ENDS -->  
                              </div>
                                 <!-- LIST FACTORY START -->  
                              <div class="tab-pane " id="portlet_tab2">
                                 <div class="portlet box red">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>Plant List </h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>uom ID</th>
											<th>uom Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
									<?php
									$sql="select * from uom_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['uom_id'].'</td>';
										echo '<td>'.$f['uom_name'].'</td>';																
									echo '<td>';
										echo '<a href="uom-master.php?pid='.$f['uom_master_id'].'" class="btn mini purple"><i class="icon-edit"></i> Edit</a>';
										echo '&nbsp;&nbsp;<a href="locaiton-master.php?delid='.$f['uom_master_id'].'" class="btn mini black"><i class="icon-trash"></i> Delete</a>';
									echo '</td>';
										$count++;
									}
									?>									</tbody>
								</table>
							</div>
						</div>
                              </div>
                                 <!-- LIST FACTORY ENDS -->  
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