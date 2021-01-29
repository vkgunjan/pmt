
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
								<li class="active"><a href="#tab_1_1" data-toggle="tab">SKD</a></li>
								<li><a href="#tab_1_2" data-toggle="tab">HSK</a></li>
								<li><a href="#tab_1_3" data-toggle="tab">DORA</a></li>
								<li><a href="#tab_1_4" data-toggle="tab">West Zone</a></li>
								<li><a href="#tab_1_6" data-toggle="tab">Special Category</a></li>
							</ul>
							<div class="tab-content">
								
								<!--end tab-pane-->
								<div class="tab-pane row-fluid active" id="tab_1_1">
									<div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span>SKD Catalogue</span>
										</div>
										<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'SKD' order by cat_date desc";
				                     $rs=odbc_exec($conn,$sql);
				                     while($f = odbc_fetch_array($rs)){
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/SKD/".$f['cat_img'].".jpg"; ?>" target="_blank"><img src="<?php echo "assets/latest_catalogue/SKD/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_desc']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span3">
												Plant
												<span><h5><?php echo $f['cat_plant']; ?></h5></span>
											</div>
											<div class="portfolio-info span4">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<div class="portfolio-info span5">
												Contact No
												<input type="number" name="contact" placeholder="Contact No. to Share" id="contact" style="width: 150px;">
												<a href="https://api.whatsapp.com/send?phone=918800250606&text=You can find the links below to view/download the catalogue designed for you:
 <?php echo "http://localhost:8080/vikash/pmt/assets/latest_catalogue/SKD/".$f['cat_img'].".pdf"; ?>" target="_blank">
												<img src="assets/img/share1.png" alt="" style="max-width: 20px; margin-bottom: 10px; margin-left:5px;"></a>
												
											</div>
										</div>
										<div class="span2">
											<a href="<?php echo "assets/latest_catalogue/SKD/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
										<i class="icon-download-alt"></i>
										<div><?php echo round((filesize("assets/latest_catalogue/SKD/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
									</a>				
												
										</div>
									</div>
									<!--end row-fluid-->
									
									<?php 
               						
               						}

            						?>

									<!--end row-fluid-->
								</div>
								<!--end tab-pane-->
								<div class="tab-pane row-fluid" id="tab_1_2">
									<div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span>HSK Catalogue</span>
										</div>
										<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'HSK' order by cat_date desc";
				                     $rs=odbc_exec($conn,$sql);
				                     while($f = odbc_fetch_array($rs)){
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/HSK/".$f['cat_img'].".jpg"; ?>" target="_blank"><img src="<?php echo "assets/latest_catalogue/HSK/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_desc']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span6">
												Plant
												<span><h5><?php echo $f['cat_plant']; ?></h5></span>
											</div>
											<div class="portfolio-info" style="margin-left: 150px;">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<!-- <div class="portfolio-info">
												Earns
												<span>$37.240</span>
											</div> -->
										</div>
										<div class="span2">
											<a href="<?php echo "assets/latest_catalogue/HSK/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
										<i class="icon-download-alt"></i>
										<div><?php echo round((filesize("assets/latest_catalogue/HSK/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
									</a>								
										</div>
									</div>
									<!--end row-fluid-->
									
									<?php 
               						
               						}

            						?>

									<!--end row-fluid-->
								</div>
								<!--end tab-pane-->
								<div class="tab-pane row-fluid" id="tab_1_3">
									<div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span>DORA Catalogue</span>
										</div>
										<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'dora' order by cat_date desc";
				                     $rs=odbc_exec($conn,$sql);
				                     while($f = odbc_fetch_array($rs)){
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/dora/".$f['cat_img'].".jpg"; ?>" target="_blank"><img src="<?php echo "assets/latest_catalogue/dora/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_desc']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span6">
												Plant
												<span><h5><?php echo $f['cat_plant']; ?></h5></span>
											</div>
											<div class="portfolio-info" style="margin-left: 150px;">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<!-- <div class="portfolio-info">
												Earns
												<span>$37.240</span>
											</div> -->
										</div>
										<div class="span2">
											<a href="<?php echo "assets/latest_catalogue/DORA/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
										<i class="icon-download-alt"></i>
										<div><?php echo round((filesize("assets/latest_catalogue/DORA/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
									</a>								
										</div>
									</div>
									<!--end row-fluid-->
									
									<?php 
               						
               						}

            						?>

									<!--end row-fluid-->
								</div>
								<div class="tab-pane row-fluid" id="tab_1_4">
									<div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span>West Zone Catalogue</span>
										</div>
										<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'west zone' order by cat_date desc";
				                     $rs=odbc_exec($conn,$sql);
				                     while($f = odbc_fetch_array($rs)){
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/west_zone/".$f['cat_img'].".jpg"; ?>" target="_blank"><img src="<?php echo "assets/latest_catalogue/west_zone/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_desc']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span6">
												Plant
												<span><h5><?php echo $f['cat_plant']; ?></h5></span>
											</div>
											<div class="portfolio-info" style="margin-left: 150px;">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<!-- <div class="portfolio-info">
												Earns
												<span>$37.240</span>
											</div> -->
										</div>
										<div class="span2">
											<a href="<?php echo "assets/latest_catalogue/west_zone/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
										<i class="icon-download-alt"></i>
										<div><?php echo round((filesize("assets/latest_catalogue/west_zone/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
									</a>								
										</div>
									</div>
									<!--end row-fluid-->
									
									<?php 
               						
               						}

            						?>

									<!--end row-fluid-->
								</div>
								<div class="tab-pane row-fluid" id="tab_1_6">
									<div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span>Special Category</span>
										</div>
										<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'special category' order by cat_date desc";
				                     $rs=odbc_exec($conn,$sql);
				                     while($f = odbc_fetch_array($rs)){
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/special_cat/".$f['cat_img'].".jpg"; ?>" target="_blank"><img src="<?php echo "assets/latest_catalogue/special_cat/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_desc']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span6">
												Plant
												<span><h5><?php echo $f['cat_plant']; ?></h5></span>
											</div>
											<div class="portfolio-info" style="margin-left: 150px;">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<!-- <div class="portfolio-info">
												Earns
												<span>$37.240</span>
											</div> -->
										</div>
										<div class="span2">
											<a href="<?php echo "assets/latest_catalogue/special_cat/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
										<i class="icon-download-alt"></i>
										<div><?php echo round((filesize("assets/latest_catalogue/special_cat/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
									</a>								
										</div>
									</div>
									<!--end row-fluid-->
									
									<?php 
               						
               						}

            						?>

									<!--end row-fluid-->
								</div>
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

   <script>
   $(document).ready(function(){

      $('#contact').keyup(function() {
      	$('#add').text($(this).val());
      var no = $(this).val();
      
      });

      function sendWhatsapp(){
    	var no 		= $(this).val();
        var url     = "<?php echo "http://localhost:8080/vikash/pmt/assets/latest_catalogue/SKD/".$f['cat_img'].".pdf"; ?>";
        var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
        var whatsapp_url = "https://api.whatsapp.com/send?phone=91" + no + "&text=" + sMsg;
        window.location.href = whatsapp_url;
        
    }
    });
  
    </script>



    