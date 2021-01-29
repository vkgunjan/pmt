<?php 
	        $report='active';
	        $hc='active';

        include_once('including/all-include.php');
        include_once('including/header.php');


if(isset($_POST['submit-form'])){
	//print_r($_POST);
	
	$dataArray=array(
		'asset_type'			=> trim($_POST['asset_type']),
		'plant_building'		=> trim($_POST['plant_building']),
		'department_section'	=> trim($_POST['department_section']),
		'asset_location'		=> trim($_POST['asset_location'])
		);
	
	
	$sq="SELECT a. [asset_id]
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
	
	if(!empty($dataArray['asset_type'])){
		$sq.=" and a.asset_type = '".$dataArray['asset_type']."' ";
	}

	if(!empty($dataArray['plant_building'])){
		$sq.=" and a.plant_building = '".$dataArray['plant_building']."' ";
	}

	if(!empty($dataArray['department_section'])){
		$sq.=" and a.department_section = '".$dataArray['department_section']."' ";
	}

	if(!empty($dataArray['asset_location'])){
		$sq.=" and a.asset_location = '".$dataArray['asset_location']."' ";
	}
	
	
	//workorder_status='".$_POST['wo_status']."' ";

}

//echo $sq;
        ?>
            
<script>
	function submitform(){
		document.myform.submit();
	}
</script>
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Select Asset To Generate Breakdown / Unscheduled Work Order</h4>
							</div>
							<div class="portlet-body">

                  			<div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal">
                                    <input type="hidden" name="submit-form"  value="submit-form"> 
                                    
                                    <table border="1" width="100%">
                                    	<tr>
                                        	<td width="156">
                                               <b>Asset Type</b>
                                               <select   name="asset_type"  >
                                          <option value="">-Select-</option>
                                             <?php
									$sql="select * from asset_type_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										$selected=($f['asset_type_id']==$dataArray['asset_type'])?'selected':'';
										echo '<option value="'.$f['asset_type_id'].'"'.$selected.'>'.$f['asset_type'].'</option>';
										}
									?>
                                          </select>
                                            </td>
                                            
                                            <td width="177">
                                               <b>Plant / Building</b>
                                               <select  name="plant_building" >
                                       <option value="">-Select-</option>
                                             <?php
									$sql="select * from plant_building_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										$selected=($f['plant_building_id']==$dataArray['plant_building'])?'selected':'';
										echo '<option value="'.$f['plant_building_id'].'"'.$selected.'>'.$f['plant_building_name'].'</option>';
										}
									?>
                                          </select>
                                            </td>
                                           
                                            <td width="207">
                                             <b> Department / Section</b>
                                               <select name="department_section" >
                                   <option value="">-Select-</option>
                                             <?php
									$sql="select * from department_Section_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									$selected=($f['department_section_id']==$dataArray['department_section'])?'selected':'';
									echo '<option value="'.$f['department_section_id'].'"'.$selected.'>'.$f['department_section_name'].'</option>';
										
										}
									?>
                                          </select>
                                            </td>
                                      
                                      	<td width="186">
                                             <b> Asset Location </b>
                                               <select   name="asset_location" >
                                      <option value="">-Select-</option>
                                             <?php
									$sql="select * from location_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
									$selected=($f['location_master_id']==$dataArray['asset_location'])?'selected':'';
									echo '<option value="'.$f['location_master_id'].'"'.$selected.'>'.$f['location_name'].'</option>';

										}
									?>
                                          </select>
                                            </td>       
                                            
                                        <td width="150" valign="middle">
                                       &nbsp;&nbsp; <input type="submit" value="Show" > 
                                       <a href="breakdown-asset-selection.php"><input type="button" value="Reset" ></a>
                                        </td>
                                        </tr>
                                    </table>
       <?php
	
									$rs=odbc_exec($conn,$sq);
									//echo odbc_num_rows($rs);
									$count=1;
if(odbc_num_rows($rs)>0){
print '
 <table border="1" width="100%">
									<thead>
										
										<tr>
											<th>#</th>
                                            <th>Code</th>
											<th>Type</th>
											<th>Name</th>
											<th>Plant / Building	</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>Area</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                            <th>Condition</th>
                                            <th>Action</th>                                            
                                        </tr>
									</thead>
									<tbody>

';

									while($f = odbc_fetch_array($rs)){
										//print_r($f);
										echo '<tr>';
										echo '<td>'.$count.'</td>';
										echo '<td>'.$f['asset_code'].'</td>';
										echo '<td>'.$f['asset_type'].'</td>';										
										echo '<td>'.$f['asset_name'].'</td>';																
										echo '<td>'.$f['plant_building_name'].'</td>';	
										echo '<td>'.$f['department_section_name'].'</td>';
										echo '<td>'.$f['location_name'].'</td>';
										echo '<td>'.$f['asset_kept_area'].'</td>';
										echo '<td>'.$f['model_number'].'</td>';
										echo '<td>'.$f['serial_number'].'</td>';
										echo '<td>'.ucfirst($f['asset_condition']).'</td>';
									echo '<td>';
										//echo '<label class="radio">';

										$href='breakdown-asset-wo-selection.php';

										echo '<a href="'.$href.'?id='.$f['asset_id'].'">';
										echo '<input type="button"  value="Select">';
										echo '</a>';
										//echo '</label>';
										
									echo '</td>';
										$count++;
									}
								
}else{
//open listing of user generated breqkdown complaints....

}
									?>
       
									</tbody>
								</table>      
                                    

                        </div>  
                            		
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