
<?php

$ct='active'; 
$dc='active'; 
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
						$sql1 = "SELECT cat_plant from cat_master where cat_status = 1 group by cat_plant"; 	
						$ca = odbc_exec($conn, $sql1);
						$count =  1;					
						
						$cat_name = [];
						//print_r($array); exit;
						while($c = odbc_fetch_array($ca)){

						$cat_name[] = 	$c['cat_plant'];	//
						

							?>
								<li <?php echo $count==1 ? "class='active'" : ""; ?>><a href="#tab_<?php echo $count; ?>" data-toggle="tab"><?php echo $c['cat_plant']; ?></a></li>


<?php 						$count++;}


//print_r($c); exit;


				?>

								<!-- <li class="active"><a href="#tab_1_1" data-toggle="tab">SKD</a></li>
								<li><a href="#tab_1_2" data-toggle="tab">HSK</a></li>
								<li><a href="#tab_1_3" data-toggle="tab">DORA</a></li>
								<li><a href="#tab_1_4" data-toggle="tab">West Zone</a></li>
								<li><a href="#tab_1_6" data-toggle="tab">Special Category</a></li> -->
							</ul>
							<div class="tab-content">
								

									<?php
									for($i=0; $i<count($cat_name);$i++){


										
					$sql2 = "SELECT * from cat_master where cat_status = 1 and cat_plant = '".$cat_name[$i]."' order by cat_name asc";
				
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
                                          
                     
                     
                     <div class="tile double" style="background: <?php echo $child_data['cat_color']; ?>">
                      
                        
                        <div class="tile-body">
                          <div class="checker" id="uniform-undefined"><span><input type="checkbox" value="<?php echo $child_data['cat_id']; ?>" name="catalogue_name[]" style="opacity: 0;" id="<?php echo $child_data['cat_title']; ?>"></span></div>

							      <?php 

							                    if($child_data['cat_type'] == 'New'){
							                          echo '<span class="badge badge-important pull-right" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">'.$child_data["cat_type"].'</span>';                      
							                    }else if($child_data['cat_type'] == 'Promoted'){
							                          echo '<span class="badge badge-info pull-right" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">'.$child_data["cat_type"].'</span>';
							                    }else{
							                          echo '<span class="badge badge-success pull-right" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">'.$child_data["cat_type"].'</span>';
							                    }

							      ?>

                                <!-- <span class="badge badge-important pull-right"><?php echo $child_data['cat_type']; ?></span> -->
                                 <a href="<?php echo "assets/Cataloge Cover Pages/".$child_data['cat_img'].".jpg"; ?>" target="_blank">
                                 <img src="<?php echo "assets/Cataloge Cover Pages/".$child_data['cat_img'].".jpg"; ?>" alt="" style="height: 85px; border-radius: 100px;"></a>
                                 <h4 style="margin-top: 15px;"><b><?php echo $child_data['cat_name']; ?></b></h4>
                                 <p>
                                    <!-- <?php echo $child_data['cat_desc']; ?> -->
                                 </p>
                        </div>
                        <div class="tile-object">
                                 <div class="name">
                                    <?php echo $child_data['cat_plant']; ?>
                                 </div>
                                 <div class="number">
                                    <?php echo date('M, Y',strtotime(trim($child_data['cat_date'])))?>
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
		function sendmessageskd(catPlant,catImg,numid){
			var id = "contactskd"+numid;
			/*alert(id);*/
			 var contact = document.getElementById(id).value;
			 var url     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant + "/"+ catImg +".pdf";
		       var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
		       var url2 = "https://api.whatsapp.com/send?phone=91" + contact + "&text=" + sMsg;
               window.open(url2);
               //alert(url2);
		}
	</script>

		<script>
		function sendmessagehsk(catPlant,catImg,numid){
			var id = "contacthsk"+numid;
			/*alert(id);*/
			 var contact = document.getElementById(id).value;
			 var url     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant + "/"+ catImg +".pdf";
		       var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
		       var url2 = "https://api.whatsapp.com/send?phone=91" + contact + "&text=" + sMsg;
               window.open(url2);
               //alert(url2);
		}
	</script>

		<script>
		function sendmessagedora(catPlant,catImg,numid){
			var id = "contactdora"+numid;
			/*alert(id);*/
			 var contact = document.getElementById(id).value;
			 var url     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant + "/"+ catImg +".pdf";
		       var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
		       var url2 = "https://api.whatsapp.com/send?phone=91" + contact + "&text=" + sMsg;
               window.open(url2);
               //alert(url2);
		}
	</script>

		<script>
		function sendmessagewz(catPlant,catImg,numid){
			var id = "contactwz"+numid;
			/*alert(id);*/
			 var contact = document.getElementById(id).value;
			 var url     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant + "/"+ catImg +".pdf";
		       var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
		       var url2 = "https://api.whatsapp.com/send?phone=91" + contact + "&text=" + sMsg;
               window.open(url2);
               //alert(url2);
		}
	</script>
		<script>
		function sendmessagesc(catPlant,catImg,numid){
			var id = "contactsc"+numid;
			/*alert(id);*/
			 var contact = document.getElementById(id).value;
			 var url     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant + "/"+ catImg +".pdf";
		       var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
		       var url2 = "https://api.whatsapp.com/send?phone=91" + contact + "&text=" + sMsg;
               window.open(url2);
               //alert(url2);
		}
	</script>



    