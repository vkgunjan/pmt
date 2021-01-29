
<?php
	
   include('including/all-include.php');
   /*var_dump($_REQUEST);*/
   $cat = $_POST['skey'];
   
   
   
   if(empty($cat)){
    $sql =" SELECT * from cat_master_pdf where cat_status = 1 order by cat_name asc";
   }else {
    $sql =" SELECT * from cat_master_pdf where cat_status = 1 and cat_name like '%".$_POST['skey']."%' ";
   }
   /*$sql = "SELECT * from product_master where p_id = $cp";*/
   $result = odbc_exec($conn, $sql);
   
   
while( $f = odbc_fetch_array($result) ){ 
 $count=1; 
  ?>
  <div class="row-fluid portfolio-block">
                    <div class="span5 portfolio-text" >
                      <a href="<?php echo "assets/latest_catalogue/".$f['plant']."/".$f['cat_img'].".jpg"; ?>" target="_blank"><img id="catPlant" src="<?php echo "assets/latest_catalogue/".$f['plant']."/".$f['cat_img'].".jpg"; ?>" alt="" style="max-width: 100px; max-height: 100px;"/></a>
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
                    <div class="span2">
                      <a href="<?php echo "assets/latest_catalogue/".$f['plant']."/".$f['cat_img'].".pdf"; ?>" class="icon-btn span12" target="_blank">
                    <i class="icon-download-alt"></i>
                    <div><?php echo round((filesize("assets/latest_catalogue/".$f['plant']."/".$f['cat_img'].".pdf")/1048576),2); ?> MB</div>
                  </a>        
                        
                    </div>
                  </div>
 <?php $count++; } ?>

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

<?php

/*echo $output;*/
// encoding array to json format


   

// encoding array to json format
// echo json_encode($users_arr);

//    $output = '<option value="">- Select -</option>';
//    while($f = odbc_fetch_array($result)){
//       $pr_group = $f['pr_product_group'];

//    	/*$output .= '<option value="'.$f["pr_product_group"].'">'.$f["pr_product_group"].'</option>';*/
//    }
//    echo json_decode($pr_group);
?>



  
