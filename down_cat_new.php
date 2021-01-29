
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
            $sql1 = "SELECT plant from plant_master_new where status = 1";   
            $ca = odbc_exec($conn, $sql1);
            $count =  1;         
            $cat_name = [];
            //print_r($array); exit;
            while($c = odbc_fetch_array($ca)){
            $cat_name[] =   $c['plant'];  //
            
            ?>

            <li <?php echo $count==1 ? "class='inner_tab active'" : "class='inner_tab'"; ?> ><a class="inner_toggle" href="#tab_<?php echo $count; ?>" data-toggle="tab"><?php echo $c['plant']; ?></a></li>

            <?php $count++;} ?>
							</ul>
							<div class="tab-content">
							
							<?php

                  for($i=0; $i<count($cat_name);$i++){  
                  $sql2 = "SELECT * from cat_master_pdf where cat_status = 1 and cat_plant = '".$cat_name[$i]."' order by cat_name asc";
                  $rs=odbc_exec($conn,$sql2);
                  ?>

              <div class="tab-pane row-fluid <?php echo $i+1==1 ? "active" : ""; ?>" id="tab_<?php echo $i+1; ?>">
            <div class="row-fluid add-portfolio">
										<div class="pull-left">
											<span><?php echo $cat_name[$i]; ?></span>
										</div>
								<input id="search" name="search" type="text" placeholder="Search..." style="width: 20%; margin-top: 15px; margin-left: 45%; border-radius: 20px;">
										
										<div class="pull-right">
											<a href="catalogue-order.php" class="btn icn-only green">Order New Catalogue <i class="m-icon-swapright m-icon-white"></i></a> 									
										</div>
									</div>
                  <?php
                  $num_id=0;        
                  while($f = odbc_fetch_array($rs)){
                  $child_data = $f;
                  $num_id++;
                  ?>	
								<!--end tab-pane-->
								<!-- <div class="tab-pane row-fluid active" id="tab_1_1"> -->
									
									<!--end add-portfolio-->
									
	
									<!-- <div id="result"></div> -->
									<div class="row-fluid portfolio-block">
                    <div class="span5 portfolio-text" >
                      <a href="<?php echo "assets/latest_catalogue/".$f['plant']."/".$f['cat_img'].".jpg"; ?>" target="_blank"><img id="" src="<?php echo "assets/latest_catalogue/".$f['plant']."/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
                      <div class="portfolio-text-info" style="margin-left: 130px;">
                        <h4 id=""><?php echo $f['cat_name']; ?></h4>
                        <p><?php echo $f['cat_size']; ?></p>
                      </div>
                    </div>
                    <!-- <span class="hidden" id="catPlant"></span> -->
                    <input type="hidden" id="catImg" value="<?php echo $f['cat_img']; ?>">
                    <input type="hidden" id="catPlant" value="<?php echo $f['plant']; ?>">
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
                        
                        <img src="assets/img/share1.png" alt="" id="sendMsg" onclick="sendmessageskd(<?php echo '\''.$f['plant'].'\',\''.$f['cat_img'].'\','.$num_id ?>)" style="max-width: 20px; margin-bottom: 10px; margin-left:5px; cursor:pointer;">

                      </div>
                    </div>
                    <div class="span2">
                      <a href="<?php echo "assets/latest_catalogue/".$f['plant']."/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
                    <i class="icon-download-alt"></i>
                    <div><?php echo round((filesize("assets/latest_catalogue/".$f['plant']."/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
                  </a>        
                        
                    </div>
                  </div>
                  <?php } ?>

									</div> 
									<!--end row-fluid-->
									
								 	<?php 
								               						
								               						}
								
								            						?>

									<!--end row-fluid-->
								</div>

								<!--end tab-pane-->
								
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
			alert(id);
			 var contact = document.getElementById(id).value;
			 var url     = "http://pmt.orientapps.com/pmt/assets/latest_catalogue/" + catPlant + "/"+ catImg +".pdf";
		       var sMsg    = encodeURIComponent( "You can find the links below to view/download the catalogue designed for you: " + url );
		       var url2 = "https://api.whatsapp.com/send?phone=91" + contact + "&text=" + sMsg;
               window.open(url2);
               //alert(url2);
		}
	</script>

<!-- 		<script>
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
}
	</script> -->
	<script>
		$(document).ready(function(){
			$('#search').keyup(function(){
				
				var cat = $(this).val();
				$.ajax({
					url: "fetch_cat.php",
		            method:"POST",
		            data:{cat:cat},
		            dataType:"text",
		            success:function(response){
		            $('#result').html(response);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert(errorThrown);
				}
			});
			});
		});
	</script>


    