		<?php 
	        $am='active';
	        $aa='active';
        include_once('including/all-include.php');
        include_once('including/header.php');
	    ?>

 <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

 <script>
$(document).ready(function(){
$("#week").hide();
$("#month").hide();


  $("#d").click(function(){
    $("#week").hide();
	$("#month").hide();
  });
  
  $("#w").click(function(){
    $("#week").show();
	$("#month").hide();
  });
  
  $("#m").click(function(){
	$("#month").show();
	$("#week").hide();
  });

  
});
</script>
           
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480">Asset Master</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                                <?php /*?><li><a href="#portlet_tab4" data-toggle="tab">Job Order</a></li><?php */?>
                                <li><a href="#portlet_tab3" data-toggle="tab">Maintenance Details</a></li>
                                <li><a href="#portlet_tab2" data-toggle="tab">Purchase Details</a></li>
								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Asset Details</a></li>			
                           </ul>

                      <!-- tab 1 asset details start --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="#" class="form-horizontal">
                                    <div class="control-group">
                                       <label class="control-label">Asset Code</label>
                                       <div class="controls">   
                                          <input class="m-wrap medium" type="text"   />
                                         
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Asset Name</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                         
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Asset Type</label>
                                       <div class="controls">
                                          <select class="medium m-wrap" tabindex="1">
                                             <?php
									$sql="select * from asset_type_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										echo '<option>'.$f['asset_type'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                  

                                    <div class="control-group">
                                       <label class="control-label">Plant / Building</label>
                                       <div class="controls">
                                          <select class="medium m-wrap" tabindex="1">
                                             <?php
									$sql="select * from plant_building_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										echo '<option>'.$f['plant_building_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>


                                    
                                    <div class="control-group">
                                       <label class="control-label">Department / Section </label>
                                       <div class="controls">
                                          <select class="medium m-wrap" tabindex="1">
                                             <?php
									$sql="select * from department_Section_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										echo '<option>'.$f['department_section_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>


                                    <div class="control-group">
                                       <label class="control-label">Asset Location </label>
                                       <div class="controls">
                                          <select class="medium m-wrap" tabindex="1">
                                             <?php
									$sql="select * from location_master where factory_id='".$_SESSION['factory-id']."' ";
									$rs=odbc_exec($conn,$sql);
										while($f = odbc_fetch_array($rs)){
										echo '<option>'.$f['location_name'].'</option>';
										}
									?>
                                          </select>
                                       </div>
                                    </div>
                                    
                                                                        
                               
                              <div class="control-group">
                                       <label class="control-label">Asset Kept Area</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                          
                                       </div>
                                    </div>
                                           
                                  <div class="control-group">
                                       <label class="control-label">Asset Description</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3"></textarea>
                                       </div>
                                    </div>
                                      
                                    <div class="control-group">
                                       <label class="control-label">Model Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                    
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Serial Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                    
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Aggreement Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                          
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Asset Condition</label>
                                       <div class="controls">
                                          <label class="radio">
                                          <input type="radio" name="optionsRadios1" value="option1" />
                                          Active
                                          </label>
                                          <label class="radio">
                                          <input type="radio" name="optionsRadios1" value="option2" checked />
                                          Deactive
                                          </label>  
                                          <label class="radio">
                                          <input type="radio" name="optionsRadios1" value="option2" />
                                          Scrap
                                          </label>  
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Safty Cautions</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3"></textarea>
                                       </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                                 <!-- tab 1, asset detail ends -->  
                              </div>
                                 <!-- tab 2, purchase detail-->  
                              <div class="tab-pane " id="portlet_tab2">
                                <form action="#" class="form-horizontal">
                                    <div class="control-group">
                                       <label class="control-label">Manufacturer Name</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                       </div>
                                    </div>
                                    
                                   <div class="control-group">
                                       <label class="control-label">Vendor Details</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3"></textarea>
                                       </div>
                                    </div>

									<div class="control-group">
                                       <label class="control-label">P.O Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                       </div>
                                    </div>

									<div class="control-group">
                                       <label class="control-label">Capax Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                       </div>
                                    </div>
                                    
                                    
									<div class="control-group">
                                       <label class="control-label">Invoice Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                       </div>
                                    </div>


									<div class="control-group">
                                       <label class="control-label">Purchase Cost</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap small" />
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Purchase Date</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">DD</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">MM</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">YY</option>
                                          </select>

                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Installation Date</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">DD</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">MM</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">YY</option>
                                          </select>

                                       </div>
                                    </div>
                                    
                                  <div class="control-group">
                                       <label class="control-label">Warranty Start</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">DD</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">MM</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">YY</option>
                                          </select>

                                       </div>
                                    </div>
                                   
                                    <div class="control-group">
                                       <label class="control-label">Warranty Ends</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">DD</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">MM</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">YY</option>
                                          </select>

                                       </div>
                                    </div>
                                        
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                              </div>
                                 <!-- tab 2 purchase details ends-->  
                                 
                                 <!-- tab 3, maintenance detail start-->  
                              <div class="tab-pane " id="portlet_tab3">
                                <div class="tab-pane " id="portlet_tab3">
                                 <div class="portlet box red">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>Add Maintenance Details</h4>
								<div class="tools">
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
								</div>
							</div>
							<div class="portlet-body">
								
                              
                           
                           <form action="#" class="form-horizontal">
                           
                            <div>&nbsp;</div>
                            
                            <div class="control-group" >
                                       <label class="control-label" >Maintenance Type</label>
                                       <div class="controls">
                                          <select class="medium m-wrap" tabindex="1">
                                             <option value="Category 1">Electrical</option>
                                          </select>
                                       </div>
                                    </div>
                                    
                                    
                                   <div class="control-group" >
                                       <label class="control-label" >Activation Date</label>
                                       <div class="controls">
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">DD</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">MM</option>
                                          </select>
                                          <select class="small m-wrap" tabindex="1">
                                             <option value="Category 1">YY</option>
                                          </select>

                                       </div>
                                    </div>
                                    
                                                                
                                    <div class="control-group">
                                       <label class="control-label">Recurrence of Schedule</label>
                                       <div class="controls">

                                          <label class="radio">
                                          <input type="radio" name="optionsRadios1" value="option1" id="d" />
                                          Daily
                                          </label>

                                          <label class="radio">
                                          <input type="radio" name="optionsRadios1" value="option1" id="w"/>
                                          Weekely
                                          </label>

                                          <label class="radio">
                                          <input type="radio" name="optionsRadios1" value="option2"  id="m" />
                                          Monthly
                                          </label>  
                                          
                                          <label class="radio">
                                          <input type="radio" name="optionsRadios1" value="option2" id="y"/>
                                          Yearly
                                          </label>  
                                       </div>
                                    </div>
                                    
                                 
                                 <div class="control-group" id="week">
                                       <label class="control-label">Select WeekDay</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1">
                                             <option value="Category 1">Sunday</option>
                                             <option value="Category 1">Monday</option>                                             
                                             <option value="Category 1">Tuesday</option>                                             
                                          </select>
                                       </div>
                                    </div>

									<div class="control-group" id="month">
                                       <label class="control-label">Month</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1">
                                             <option value="Category 1">Januarary</option>
                                             <option value="Category 1">Feburary</option>                                             
                                             <option value="Category 1">March</option>                                             
                                          </select>
                                       </div>
                                    <label class="control-label">Date</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1">
                                             <option value="Category 1">1</option>
                                             <option value="Category 1">2</option>                                             
                                             <option value="Category 1">3</option>                                             
                                          </select>
                                       </div>
                                    </div>
                     <div style="margin-left:8%;">               
                       <div class="btn-group">
						<a href="asset-master.php"><button class="btn green">Add Maintenance <i class="icon-plus"></i></button></a>
                        </div>
					</div>			
                                	</tbody>
								</table>
                                 </form>
							</div>
						</div>
                          
                                    
                                 
                               <table class="table table-striped table-hover table-bordered" >
									<thead>
										<tr>
											<th>Asset Code</th>
											<th>Asset Type</th>
											<th>Asset Name</th>
											<th>Plant/Building</th>
											<th>Dept</th>
											<th>Location</th>
                                            <th>Area</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                        </tr>
									</thead>
									<tbody>
										<tr class="">
											<td>H-001</td>
											<td>Server</td>
											<td>Domain Controler</td>
											<td>Head-Office</td>
											<td>IT</td>
											<td>First Floor</td>                                            
											<td>Server Room</td>   
											<td>HP DL 360 G9</td>											
                                            <td>HGH0058745</td>
                                         </tr>
									</tbody>
								</table>
                                
                           <hr>  
                                
                              </div>
                              </div>
                                 <!-- tab 3 maintenance details ends-->  
                                 
                                   <!-- tab 4, job order start-->  
                              <div class="tab-pane " id="portlet_tab4">
                                <form action="#" class="form-horizontal">
                                    <div class="control-group">
                                       <label class="control-label">job order details</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Asset Detail</label>
                                       <div class="controls">
                                          <input type="text" placeholder="large" class="m-wrap large" />
                                       </div>
                                    </div>

                                    
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                              </div>
                                 <!-- tab 4 job order ends-->  
                                 
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