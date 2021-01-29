
<?php


$gdoc='active'; 
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
?>



<div class="row-fluid profile">
					<div class="span12">
						<!--BEGIN TABS-->
						<div class="tabbable tabbable-custom">
							<ul class="nav nav-tabs">
	
				<?php 
						$sql1 = "SELECT get_dpt from get_doc_pdf where get_status = 1 group by get_dpt"; 	
						$ca = odbc_exec($conn, $sql1);
						$count =  1;					
						
						$get_dpt = [];
						//print_r($array); exit;
						while($c = odbc_fetch_array($ca)){

						$get_dpt[] = 	$c['get_dpt'];	//
						

							?>
								<li <?php echo $count==1 ? "class='active'" : ""; ?>><a href="#tab_<?php echo $count; ?>" data-toggle="tab"><?php echo strtoupper($c['get_dpt']); ?></a></li>


<?php 						$count++;}


//print_r($c); exit;


				?>

						
							</ul>
							<div class="tab-content">
								

									<?php
									for($i=0; $i<count($get_dpt);$i++){


										
					$sql2 = "SELECT * from get_doc_pdf where get_status = 1 and get_dpt = '".$get_dpt[$i]."' order by get_name asc";
				
				                     $rs=odbc_exec($conn,$sql2);
									 
						?>
						<div class="tab-pane row-fluid <?php echo $i+1==1 ? "active" : ""; ?>" id="tab_<?php echo $i+1; ?>">
						
						<?php 			 
									 
									 
				                    
				                     while($f = odbc_fetch_array($rs)){
										  $child_data = $f;
										  
										  
										 //echo "<pre>"; print_r($f); die;
										//  echo count($f);
										 // exit;
										  
										 

 ?>
	<div id="catList">
                      <div class="row-fluid span3">
                     <label class="checkbox line">
                                          
                     
                     
                     <div class="tile double ooicon" style="max-height: 90px;">
                      
                        
                        <div class="tile-body">
                          <!-- <div class="checker" id="uniform-undefined"></div> -->

							     
                                 <a href="<?php echo "assets/get_doc/".$child_data['get_dpt']."/".$child_data['get_pdf'].".pdf"; ?>" target="_blank">
                                 <img src="<?php echo "assets/get_doc/logo.png"; ?>" alt="" style="height: 40px;"></a>
                                 <h4 style="margin-top: 10px;"><b><a href="<?php echo "assets/get_doc/".$child_data['get_dpt']."/".$child_data['get_pdf'].".pdf"; ?>" target="_blank" style="text-decoration: none;"><?php echo $child_data['get_name']; ?></a></b></h4>
                                 <p>
                                    <!-- <?php echo $child_data['cat_desc']; ?> -->
                                 </p>
                        </div>
                        <div class="tile-object">
                                 <div class="name">
                                    <?php echo strtoupper($child_data['get_place']); ?>
                                 </div>
                                 <div class="number">
                                    <?php echo date('M, Y',strtotime(trim($child_data['get_date'])))?>
                                 </div>
                        </div>

                     </div>
                     </label>
                     </div>
                  </div>
	
	<?php  //print_r($child_data); 
	
	}	 ?>
	
	
	</div>
	
	<!--end tab-pane-->
			
	
<?php					
							             						
								               						}
								 
								            						?>
								<!--end tab-pane-->
								
							</div>
						</div>
						<!--END TABS-->
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

	<script src="assets/breakpoints/breakpoints.js"></script>       
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   <script src="assets/js/jquery.blockui.js"></script>
   <script src="assets/js/jquery.cookie.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="assets/js/excanvas.js"></script>
   <script src="assets/js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   
  
   <script src="assets/js/app.js"></script>  


	<script>
  $(document).ready(function(){
      var items = ["#9062aa", "#3fb4e9", "#6fc063", "#d94949", "#f8951e", "#7a564a", "#029688", "#2d2f79", "#e81f63"];
      var index = 0;
      var color;
      $(".ooicon").each(function() {
        if (index == items.length)
          index = 0;

        color = items[index];
        $(this).css('background', color);
        index++;
      });
  });
</script>



    