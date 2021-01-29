<?php 
	       
	        $bdm='active';

        include_once('including/all-include.php');
        include_once('including/header.php');


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
                 <a href="breakdown-asset-selection.php" class="btn red" style="margin-top:-10px;"> 
                 <i class="icon-calendar"></i> Generate Breakdown/Unscheduled Work Order</a>
				 <?php } ?>
                 
                
                                   
                                    <a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
								</div>
							</div>
							<div class="portlet-body">

                  			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                         <div style="width:100%;" >   

                                     <b> From Date</b>
                                
                                          <select  name="from_date"  style="width:60px;">
												<?php 
                                                    for($x=1; $x<=31; $x++){
                                                        //$selected=($_POST['installation_dd']==$x || date('d')==$x? 'selected' : '');
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
														 $selected=($_POST['installation_mm']==$x || date('m')==$x ? 'selected' : '');
														 echo '<option value='.$x.' '.$selected.'>'.$monthArray[$x].'</option>';
													  }	
											  ?>
                                          </select>
                                          <select  name="from_year" style="width:70px;">
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
                         	<select name="maintenance_type" style="width:140px;">
                                       		<option value="all">All</option>
                                             <?php
							if(trim($_SESSION['user_type'])=='engineer')
								$ssql="select * from maintenance_type_master where factory_id='".$_SESSION['factory-id']."' and maintenance_type_id='".$_SESSION['maintenance_type']."'";
							else
								$ssql="select * from maintenance_type_master where factory_id='".$_SESSION['factory-id']."' ";	
									$rs=odbc_exec($conn,$ssql);
										while($f = odbc_fetch_array($rs)){
										echo '<option value="'.$f['maintenance_type_id'].'">'.$f['maintenance_type'].'</option>';
										}
									?>
                                          </select>
                            	 &nbsp;&nbsp;
                                    <button type="submit" name="submit" class="btn green" style="margin-top:-10px;">Refresh&nbsp; 
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
											<th>Asset Name</th>
											<th>Maintenance Type</th> 
											<th>Recurrence Type</th>                                            
                                            <th>Status</th>                                            
										    <th>Action</th>                                            
										    <th>Work Order</th>                                                                                        
                                        </tr>
									</thead>

                                    <tbody>
 								<?php
									$rs=odbc_exec($conn,$sql);
									//echo odbc_num_rows($rs);
									$count=1;
									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.date('d-m-Y',strtotime($f['schedule_generated_date'])).'</td>';										
										echo '<td>'.strtoupper($f['asset_code']).'</td>';																
										echo '<td>'.ucfirst($f['asset_name']).'</td>';	
										echo '<td>'.$f['maintenance_type'].'</td>';
										echo '<td>'.ucfirst($f['recurrence_schedule']).'</td>';
										echo '<td>P</td>';
										echo '<td>
											<a href="#" class="btn mini red"><i class="icon-trash"></i> Re-Schedule</a>
										</td>';
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