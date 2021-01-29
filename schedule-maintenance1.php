<?php 
	        $am='active';
	        $la='active';
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
                          <h4><i class="icon-edit"></i>Generate Maintenance Schedule & Job Order </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">

								<li class="active"><a href="#portlet_tab1" data-toggle="tab">Create Maintenance Schedule</a></li>			
                           </ul>

                      <!-- tab 1 asset details start --> 
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

                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="#" class="form-horizontal">
                           
                                   <div class="control-group">
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
                                     
                                     
                                    
                                    <hr>
                                    
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                                 <!-- tab 1, asset detail ends -->  
                              </div>
                                 
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
            </div>
				<!-- END PAGE CONTENT -->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		2013 &copy; Metronic by keenthemes.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<script src="assets/breakpoints/breakpoints.js"></script>	
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>		
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("table_editable");
			App.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
