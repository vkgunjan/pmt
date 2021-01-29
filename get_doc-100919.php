
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
								<li class="active"><a href="#tab_1_1" data-toggle="tab">Central Accounts</a></li>
								<li><a href="#tab_1_2" data-toggle="tab">State Accounts</a></li>
								<li><a href="#tab_1_3" data-toggle="tab">PSU</a></li>
								
							</ul>
							<div class="tab-content">
								
								<!--end tab-pane-->
								<div class="tab-pane row-fluid active" id="tab_1_1">
									<div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span>Central Accounts Documents</span>
										</div>

										
										
												<!-- <input id="search" type="text" placeholder="Search..." style="width: 20%; margin-top: 15px; margin-left: 45%; border-radius: 20px;"> -->
										
											
										
										
										<div class="pull-right">
											<a href="add-opportunity.php" class="btn icn-only green">Add New Opportunity <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
									</div>
									<!--end add-portfolio-->
									<?php

				                     $sql = "SELECT * from get_doc_pdf where get_status = 1 and get_dpt = 'central' order by get_name asc";
				                     $rs=odbc_exec($conn,$sql);
				                     $num_id=0;
				                     while($f = odbc_fetch_array($rs)){
				                     	$num_id++;
				                     ?>


									<div class="row-fluid portfolio-block">
										<div class="span5 portfolio-text" >
											<a href="<?php echo "assets/get_doc/pdf.png"; ?>" target="_blank"><img id="catPlant" src="<?php echo "assets/get_doc/pdf.png"; ?>" alt="" style="max-width: 60px; max-height: 60px;padding: 15px;"/></a>
											<div class="portfolio-text-info" style="margin-left: 130px;">
												<h4 id="catImg"><?php echo $f['get_name']; ?></h4>
												<p><?php echo $f['get_desc']; ?></p>
											</div>
										</div>
										<div class="span5" style="overflow:hidden;">
											<div class="portfolio-info span3">
												Department
												<span><h5><?php echo $f['get_dpt']; ?></h5></span>
											</div>
											<div class="portfolio-info span4">
												Release Date
												<span><h5><?php echo date('M, Y',strtotime(trim($f['get_date'])))?></h5></span>
											</div>
											<div class="portfolio-info span5" style="padding-left:0px;">
												<br>
												<input type="number" name = "contact" id="contactskd<?php echo $num_id ?>" placeholder="Contact No." style="width: 150px;" required>
												
												<img src="assets/img/share1.png" alt="" id="sendMsg" onclick="sendmessageskd(<?php echo '\''.$f['get_dpt'].'\',\''.$f['get_pdf'].'\','.$num_id; ?>)" style="max-width: 20px; margin-bottom: 10px; margin-left:5px; cursor:pointer;">

											</div>
										</div>
										<div onclick="downskd(<?php echo '\''.$f['get_dpt'].'\',\''.$f['get_pdf'].'\''?>)" class="span2">
											<a href="<?php echo "assets/get_doc/central/".$f['get_pdf'].".pdf"; ?>" class="icon-btn span12" target="_blank">
										<i class="icon-download-alt"></i>
										<div><?php echo round((filesize("assets/get_doc/central/".$f['get_pdf'].".pdf")/1048576),2); ?> MB</div>
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
											<span>State Accounts Documents</span>
										</div>
										<div class="pull-right">
											<a href="add-opportunity.php" class="btn icn-only green">Add New Opportunity <i class="m-icon-swapright m-icon-white"></i></a>								
										</div> 
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
											<a href="<?php echo "assets/latest_catalogue/HSK/".$f['cat_img'].".jpg"; ?>" target="_blank"><img src="<?php echo "assets/latest_catalogue/HSK/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
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
											<span>PSU Documents</span>
										</div>
										<div class="pull-right">
											<a href="add-opportunity.php" class="btn icn-only green">Add New Opportunity <i class="m-icon-swapright m-icon-white"></i></a>									
										</div>
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
											<a href="<?php echo "assets/latest_catalogue/dora/".$f['cat_img'].".jpg"; ?>" target="_blank"><img src="<?php echo "assets/latest_catalogue/dora/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
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


    