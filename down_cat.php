
<?php

$ct='active'; 
$dc='active'; 
include_once('including/all-include.php');
include_once('including/header.php');
include('including/datetime.php');
$timestamp=date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
?>

<?php 
	$s = "SELECT
					upper(c.plant) as [PlantName],
					s.zone as Zone,
					t.territory_name as [Territory],
					(select top 1 state from city_master where territory_id = u.employee_territory) as [State],
					--d.state as [State],
					u.emp_code as [EmployeeCode],
					u.fullname as [UserName], 
					c.cat_name as [CatalogueName], 
					c.cat_url as [CatalogueUrl], 
					c.contact as [ContactNo], 
					case 
					when c.source = 'CD' Then 'Catalogue Download' 
					when c.source = 'WS' Then 'Whatsapp Share' 
					Else '' End as Source, 
					c.send_date as [SendDate] from click_log c
					inner join user_management u on u.uid = c.user_id
					inner join territory_master t on t.territory_id = u.employee_territory
					inner join state_master s on s.state_id = (select top 1 state_id from city_master where territory_id = u.employee_territory)
					order by c.send_date desc";

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
								<li><a href="#tab_1_7" data-toggle="tab">Old Version</a></li>
							</ul>
							<div class="tab-content">
								
								<!--end tab-pane-->
								<div class="tab-pane row-fluid active" id="tab_1_1">
									<div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span>SKD Catalogue</span>
										</div>

										
										
												<!-- <input id="search" type="text" placeholder="Search..." style="width: 20%; margin-top: 15px; margin-left: 45%; border-radius: 20px;"> -->
										
										<?php 
										if (trim($_SESSION['employee_department'])=='obtbadmin' || trim($_SESSION['user_type'])=='management') {
											?>
											<div class="pull-right">
											<a href="export_cat_share.php?val=<?php echo base64_encode($s); ?>" class="btn icn-only green">Export Details <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
										<?php
										}else {
											echo '<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>';
										}

										 ?>	
										
										
										<!-- <div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div> -->
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'SKD' order by cat_name asc";
				                     $rs=odbc_exec($conn,$sql);
				                     $num_id=0;
				                     while($f = odbc_fetch_array($rs)){
				                     	$num_id++;
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text" >
											<a href="<?php echo "assets/latest_catalogue/SKD/".$f['cat_img'].".jpg"; ?>" target="_blank"><div id="tooltip"><img id="catPlant" src="<?php echo "assets/latest_catalogue/SKD/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a><span id="tooltipimage"><img src="<?php echo "assets/latest_catalogue/SKD/".$f['cat_img'].".jpg"; ?>"/>
												<h5 style="text-align: center;"><b><?php echo $f['cat_name']; ?> | <?php echo $f['cat_category']; ?></b></h5>
												
											</span>
										</div>

											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4 id="catImg"><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_size']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span3">
												Category
												<span><h5><?php echo $f['cat_category']; ?></h5></span>
											</div>
											<div class="portfolio-info span4">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<div class="portfolio-info span5" style="padding-left:0px;">
												<br>
												<input type="number" name = "contact" id="contactskd<?php echo $num_id ?>" placeholder="Contact No." style="width: 150px;" required>
												
												<img src="assets/img/share1.png" alt="" id="sendMsg" onclick="sendmessageskd(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\','.$num_id; ?>)" style="max-width: 20px; margin-bottom: 10px; margin-left:5px; cursor:pointer;">

											</div>
										</div>
										<div onclick="downskd(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\''?>)" class="span2">
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
										<?php 
										if (trim($_SESSION['employee_department'])=='obtbadmin' || trim($_SESSION['user_type'])=='management') {
											?>
											<div class="pull-right">
											<a href="export_cat_share.php?val=<?php echo base64_encode($s); ?>" class="btn icn-only green">Export Details <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
										<?php
										}else {
											echo '<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>';
										}

										 ?>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'HSK' order by cat_name asc";
				                     $rs=odbc_exec($conn,$sql);
				                     $num_id = 0;
				                     while($f = odbc_fetch_array($rs)){
				                     	$num_id++;
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/HSK/".$f['cat_img'].".jpg"; ?>" target="_blank"><div id="tooltip"><img id="catPlant" src="<?php echo "assets/latest_catalogue/HSK/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a><span id="tooltipimage"><img src="<?php echo "assets/latest_catalogue/HSK/".$f['cat_img'].".jpg"; ?>"/>
												<h5 style="text-align: center;"><b><?php echo $f['cat_name']; ?> | <?php echo $f['cat_category']; ?></b></h5>
												
											</span>
										</div>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_size']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span3">
												Category
												<span><h5><?php echo $f['cat_category']; ?></h5></span>
											</div>
											<div class="portfolio-info span4">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<div class="portfolio-info span5" style="padding-left:0px;">
												<br>
												<input type="number" name = "contact" id="contacthsk<?php echo $num_id ?>" placeholder="Contact No." style="width: 150px;" required>
												
												<img src="assets/img/share1.png" alt="" id="sendMsg" onclick="sendmessagehsk(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\','.$num_id; ?>)" style="max-width: 20px; margin-bottom: 10px; margin-left:5px; cursor:pointer;">

											</div>
										</div>
										<div onclick="downhsk(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\''?>)" class="span2">
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
										<?php 
										if (trim($_SESSION['employee_department'])=='obtbadmin' || trim($_SESSION['user_type'])=='management') {
											?>
											<div class="pull-right">
											<a href="export_cat_share.php?val=<?php echo base64_encode($s); ?>" class="btn icn-only green">Export Details <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
										<?php
										}else {
											echo '<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>';
										}

										 ?>	
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'dora' order by cat_name asc";
				                     $rs=odbc_exec($conn,$sql);
				                     $num_id=0;
				                     while($f = odbc_fetch_array($rs)){
				                     $num_id++;
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/dora/".$f['cat_img'].".jpg"; ?>" target="_blank"><div id="tooltip"><img id="catPlant" src="<?php echo "assets/latest_catalogue/dora/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a><span id="tooltipimage"><img src="<?php echo "assets/latest_catalogue/dora/".$f['cat_img'].".jpg"; ?>"/>
												<h5 style="text-align: center;"><b><?php echo $f['cat_name']; ?> | <?php echo $f['cat_category']; ?></b></h5>
												
											</span>
										</div>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_size']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span3">
												Category
												<span><h5><?php echo $f['cat_category']; ?></h5></span>
											</div>
											<div class="portfolio-info span4">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<div class="portfolio-info span5" style="padding-left:0px;">
												<br>
												<input type="number" name = "contact" id="contactdora<?php echo $num_id ?>" placeholder="Contact No." style="width: 150px;" required>
												
												<img src="assets/img/share1.png" alt="" id="sendMsg" onclick="sendmessagedora(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\','.$num_id; ?>)" style="max-width: 20px; margin-bottom: 10px; margin-left:5px; cursor:pointer;">

											</div>
										</div>
										<div onclick="downdora(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\''?>)" class="span2">
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
										<?php 
										if (trim($_SESSION['employee_department'])=='obtbadmin' || trim($_SESSION['user_type'])=='management') {
											?>
											<div class="pull-right">
											<a href="export_cat_share.php?val=<?php echo base64_encode($s); ?>" class="btn icn-only green">Export Details <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
										<?php
										}else {
											echo '<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>';
										}

										 ?>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'west zone' order by cat_name asc";
				                     $rs=odbc_exec($conn,$sql);
				                     $num_id=0;
				                     while($f = odbc_fetch_array($rs)){
				                     $num_id++;
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/west_zone/".$f['cat_img'].".jpg"; ?>" target="_blank"><div id="tooltip"><img id="catPlant" src="<?php echo "assets/latest_catalogue/west_zone/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a><span id="tooltipimage"><img src="<?php echo "assets/latest_catalogue/west_zone/".$f['cat_img'].".jpg"; ?>"/>
												<h5 style="text-align: center;"><b><?php echo $f['cat_name']; ?> | <?php echo $f['cat_category']; ?></b></h5>
												
											</span>
										</div>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_size']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span3">
												Category
												<span><h5><?php echo $f['cat_category']; ?></h5></span>
											</div>
											<div class="portfolio-info span4">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<div class="portfolio-info span5" style="padding-left:0px;">
												<br>
												<input type="number" name = "contact" id="contactwz<?php echo $num_id ?>" placeholder="Contact No." style="width: 150px;" required>
												
												<img src="assets/img/share1.png" alt="" id="sendMsg" onclick="sendmessagewz(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\','.$num_id; ?>)" style="max-width: 20px; margin-bottom: 10px; margin-left:5px; cursor:pointer;">

											</div>
										</div>
										<div onclick="downwz(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\''?>)" class="span2">
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
										<?php 
										if (trim($_SESSION['employee_department'])=='obtbadmin' || trim($_SESSION['user_type'])=='management') {
											?>
											<div class="pull-right">
											<a href="export_cat_share.php?val=<?php echo base64_encode($s); ?>" class="btn icn-only green">Export Details <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
										<?php
										}else {
											echo '<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>';
										}

										 ?>	
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'special category' order by cat_name asc";
				                     $rs=odbc_exec($conn,$sql);
				                     $num_id=0;
				                     while($f = odbc_fetch_array($rs)){
				                     $num_id++;
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text">
											<a href="<?php echo "assets/latest_catalogue/special_category/".$f['cat_img'].".jpg"; ?>" target="_blank"><div id="tooltip"><img id="catPlant" src="<?php echo "assets/latest_catalogue/special_category/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a><span id="tooltipimage"><img src="<?php echo "assets/latest_catalogue/special_category/".$f['cat_img'].".jpg"; ?>"/>
												<h5 style="text-align: center;"><b><?php echo $f['cat_name']; ?> | <?php echo $f['cat_category']; ?></b></h5>
												
											</span>
										</div>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_size']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span3">
												Category
												<span><h5><?php echo $f['cat_category']; ?></h5></span>
											</div>
											<div class="portfolio-info span4">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<div class="portfolio-info span5" style="padding-left:0px;">
												<br>
												<input type="number" name = "contact" id="contactsc<?php echo $num_id ?>" placeholder="Contact No." style="width: 150px;" required>
												
												<img src="assets/img/share1.png" alt="" id="sendMsg" onclick="sendmessagesc(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\','.$num_id; ?>)" style="max-width: 20px; margin-bottom: 10px; margin-left:5px; cursor:pointer;">

											</div>
										</div>
										<div onclick="downsc(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\''?>)" class="span2">
											<a href="<?php echo "assets/latest_catalogue/special_category/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
										<i class="icon-download-alt"></i>
										<div><?php echo round((filesize("assets/latest_catalogue/special_category/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
									</a>								
										</div>
									</div>
									<!--end row-fluid-->
									
									<?php 
               						
               						}

            						?>

									<!--end row-fluid-->
								</div>
								<div class="tab-pane row-fluid" id="tab_1_7">
									<div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span>Old Version Catalogue</span>
										</div>
										<?php 
										if (trim($_SESSION['employee_department'])=='obtbadmin' || trim($_SESSION['user_type'])=='management') {
											?>
											<div class="pull-right">
											<a href="export_cat_share.php?val=<?php echo base64_encode($s); ?>" class="btn icn-only green">Export Details <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
										<?php
										}else {
											echo '<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>';
										}

										 ?>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = 'DISC' order by cat_name asc";
				                     $rs=odbc_exec($conn,$sql);
				                     $num_id=0;
				                     while($f = odbc_fetch_array($rs)){
				                     	$num_id++;
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text" >
											<a href="<?php echo "assets/latest_catalogue/DISC/".$f['cat_img'].".jpg"; ?>" target="_blank"><div id="tooltip"><img id="catPlant" src="<?php echo "assets/latest_catalogue/DISC/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a><span id="tooltipimage"><img src="<?php echo "assets/latest_catalogue/DISC/".$f['cat_img'].".jpg"; ?>"/>
												<h5 style="text-align: center;"><b><?php echo $f['cat_name']; ?> | <?php echo $f['cat_category']; ?></b></h5>
												
											</span>
										</div>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4 id="catImg"><?php echo $f['cat_name']; ?></h4>
												<p><?php echo $f['cat_size']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span3">
												Category
												<span><h5><?php echo $f['cat_category']; ?></h5></span>
											</div>
											<div class="portfolio-info span4">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['cat_date'])))?></h5></span>
											</div>
											<div class="portfolio-info span5" style="padding-left:0px;">
												<br>
												<input type="number" name = "contact" id="contactdisc<?php echo $num_id ?>" placeholder="Contact No." style="width: 150px;" required>
												
												<img src="assets/img/share1.png" alt="" id="sendMsg" onclick="sendmessagedisc(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\','.$num_id; ?>)" style="max-width: 20px; margin-bottom: 10px; margin-left:5px; cursor:pointer;">
											
											</div>
										</div>
										<div onclick="downdisc(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\''?>)" class="span2">
											<a href="<?php echo "assets/latest_catalogue/DISC/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
										<i class="icon-download-alt"></i>
										<div><?php echo round((filesize("assets/latest_catalogue/DISC/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
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
		function sendmessageskd(catPlant,catImg,numid){
			var id = "contactskd"+numid;
			/*alert(id);*/
			 var contact = document.getElementById(id).value;
			 var url     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant + "/"+ catImg +".pdf";
		       var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
		       var url2 = "https://api.whatsapp.com/send?phone=91" + contact + "&text=" + sMsg;
               window.open(url2);
         	
         		    $.ajax({
		            url: "cat_click.php",
		            type:"POST",
		            data:{url:url,contact:contact,catPlant:catPlant,catImg:catImg},
		            dataType:"json",
		            success:function(data){
            
            		}
         });
         	
		}

		function downskd(catPlant1,catImg1){
			var url1     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant1 + "/"+ catImg1 +".pdf";
			/*alert(url1);*/
			$.ajax({
				url: "cat_click.php",
				type: "POST",
				data: {url1:url1,catPlant1:catPlant1,catImg1:catImg1},
				dataType:"json",
				success:function(data){

				}
			});
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
               $.ajax({
		            url: "cat_click.php",
		            type:"POST",
		            data:{url:url,contact:contact,catPlant:catPlant,catImg:catImg},
		            dataType:"json",
		            success:function(data){
            
            		}
         });
		}
		function downhsk(catPlant1,catImg1){
			var url1     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant1 + "/"+ catImg1 +".pdf";
			/*alert(url1);*/
			$.ajax({
				url: "cat_click.php",
				type: "POST",
				data: {url1:url1,catPlant1:catPlant1,catImg1:catImg1},
				dataType:"json",
				success:function(data){

				}
			});
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
               $.ajax({
		            url: "cat_click.php",
		            type:"POST",
		            data:{url:url,contact:contact,catPlant:catPlant,catImg:catImg},
		            dataType:"json",
		            success:function(data){
            
            		}
         });
		}
		function downdora(catPlant1,catImg1){
			var url1     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant1 + "/"+ catImg1 +".pdf";
			/*alert(url1);*/
			$.ajax({
				url: "cat_click.php",
				type: "POST",
				data: {url1:url1,catPlant1:catPlant1,catImg1:catImg1},
				dataType:"json",
				success:function(data){

				}
			});
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
               $.ajax({
		            url: "cat_click.php",
		            type:"POST",
		            data:{url:url,contact:contact,catPlant:catPlant,catImg:catImg},
		            dataType:"json",
		            success:function(data){
            
            		}
         });
		}
		function downwz(catPlant1,catImg1){
			var url1     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant1 + "/"+ catImg1 +".pdf";
			/*alert(url1);*/
			$.ajax({
				url: "cat_click.php",
				type: "POST",
				data: {url1:url1,catPlant1:catPlant1,catImg1:catImg1},
				dataType:"json",
				success:function(data){

				}
			});
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
               $.ajax({
		            url: "cat_click.php",
		            type:"POST",
		            data:{url:url,contact:contact,catPlant:catPlant,catImg:catImg},
		            dataType:"json",
		            success:function(data){
            
            		}
         });
		}

		function downsc(catPlant1,catImg1){
			var url1     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant1 + "/"+ catImg1 +".pdf";
			/*alert(url1);*/
			$.ajax({
				url: "cat_click.php",
				type: "POST",
				data: {url1:url1,catPlant1:catPlant1,catImg1:catImg1},
				dataType:"json",
				success:function(data){

				}
			});
		}
	</script>

<script>
		function sendmessagedisc(catPlant,catImg,numid){
			var id = "contactdisc"+numid;
			/*alert(id);*/
			 var contact = document.getElementById(id).value;
			 var url     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant + "/"+ catImg +".pdf";
		       var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
		       var url2 = "https://api.whatsapp.com/send?phone=91" + contact + "&text=" + sMsg;
               window.open(url2);
               //alert(url2);
               $.ajax({
		            url: "cat_click.php",
		            type:"POST",
		            data:{url:url,contact:contact,catPlant:catPlant,catImg:catImg},
		            dataType:"json",
		            success:function(data){
            
            		}
         });
		}
		function downdisc(catPlant1,catImg1){
			var url1     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant1 + "/"+ catImg1 +".pdf";
			/*alert(url1);*/
			$.ajax({
				url: "cat_click.php",
				type: "POST",
				data: {url1:url1,catPlant1:catPlant1,catImg1:catImg1},
				dataType:"json",
				success:function(data){

				}
			});
		}
</script>


    