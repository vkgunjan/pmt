<?php 
      
        $cor='active';

        include_once('including/all-include.php');
        include_once('including/header.php');
        include('including/datetime.php');
        unset($_SESSION['working-active-asset']);
        $timestamp=date('Y-m-d H:i:s');
        $uid = $_SESSION['uid'];
?>




<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> -->
<div class="row-fluid">
               <div class="span12">
                  <div class="portlet box light-grey" id="form_wizard_1">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i> Catalogue Wizard - <span class="step-title">Step 1 of 4</span>
                        </h4>
                        <div class="tools hidden-phone">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="form-horizontal">
                           <div class="form-wizard">
                              <div class="navbar steps">
                                 <div class="navbar-inner">
                                    <ul class="row-fluid">
                                       <li class="span3">
                                          <a href="#tab1" data-toggle="tab" class="step active">
                                          <span class="number">1</span>
                                          <span class="desc"><i class="icon-ok"></i> Address Info</span>   
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab2" data-toggle="tab" class="step">
                                          <span class="number">2</span>
                                          <span class="desc"><i class="icon-ok"></i> Personal Info</span>   
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab3" data-toggle="tab" class="step">
                                          <span class="number">3</span>
                                          <span class="desc"><i class="icon-ok"></i> Catalogue Wizard</span>   
                                          </a>
                                       </li>
                                       <li class="span3">
                                          <a href="#tab4" data-toggle="tab" class="step">
                                          <span class="number">4</span>
                                          <span class="desc"><i class="icon-ok"></i> Confirm</span>   
                                          </a> 
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div id="bar" class="progress progress-success progress-striped">
                                 <div class="bar"></div>
                              </div>
                              <div class="tab-content">
                                 <div class="tab-pane active" id="tab1">
                                    <h3 class="block">Provide your Branch details</h3>
                                    <div class="control-group">
                                       <label class="control-label">City<span class="required">*</span></label>
                                       <div class="controls">
                                          <select class="chosen-with-diselect m-wrap span3" tabindex="-1" name="city" id="city" required>
                                             <option value="">- Select -</option>
                                             <?php
                                             $dt = "SELECT * from city_master order by city ASC";
                                             $dt_result = odbc_exec($conn, $dt);
                                             while($dtr = odbc_fetch_array($dt_result)) {
                                                /*$city = $dtr['city'];*/
                                                //$selected=($dtr['city']==$dataArray['city'])?'selected':'';
                                                echo '<option value = "'.$dtr['id'].'" '.$selected.'>'.$dtr['city'].'</option>';
                                             }
                                           ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                             <label class="control-label" for="State">State:</label>
                                             <div class="controls">
                                                <span class="text" name="state" id="state" style="font-weight: bold; color: red;"></span>
                                             </div>
                                          </div>
                                    <div class="control-group">
                                             <label class="control-label" for="territory">Territory:</label>
                                             <div class="controls">
                                                <span class="text" name="territory" id="territory" style="font-weight: bold; color: red;"></span>
                                             </div>
                                          </div>
                                 </div>
                                 <div class="tab-pane" id="tab2">
                                    <h3 class="block">Provide your Personal details</h3>
                                    <div class="control-group">
                                       <label class="control-label">Employee Code<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-briefcase"></i>
                                             <input class="span2 m-wrap " type="text" placeholder="Emp Code" id="emp_code" name="emp_code" required="required"> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Full Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-user"></i>
                                             <input class="span3 m-wrap " type="text" placeholder="Full Name" name="full_name" id="full_name"> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Email Address<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-envelope"></i>
                                             <input class="span4 m-wrap " type="text" name="email" id="email" placeholder="Email Address"> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Phone Number<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-phone"></i>
                                             <input class="span3 m-wrap " type="number" placeholder="Phone Number" name="contact" id="contact"> 
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Gender<span class="required">*</span></label>
                                       <div class="controls">
                                          <label class="radio">
                                          <input type="radio" name="gender" id="optionsRadios1" value="male" checked />
                                          Male
                                          </label>
                                          <!-- <div class="clearfix"></div> -->
                                          <label class="radio">
                                          <input type="radio" name="gender" id="optionsRadios1" value="female" />
                                          Female
                                          </label>  
                                       </div>
                                    </div>
                                    <div class="control-group">
                                    <label class="control-label">Required Date<span class="required">*</span></label>
                                    <div class="controls">
                                       <div class="input-append date date-picker" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                          <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="" name="required_date" id="required_date" style="height: 34px;"><span class="add-on"><i class="icon-calendar" ></i></span>
                                    </div>
                              </div>
                           </div>
                                    <div class="control-group">
                                       <label class="control-label">Address<span class="required">*</span></label>
                                       <div class="controls">
                                          <div class="input-icon left">
                                             <i class="icon-edit"></i>
                                             <input class="span6 m-wrap " type="text" name="address" id="address" placeholder="Complete Address with PIN No for Dispatch.."> 
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Remarks<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="span6 m-wrap" rows="3" name="remarks" placeholder="Kindly Put Your Relevent Remarks.."></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab3">
                                    <h3 class="block">Catalogue Selection</h3>
               
                  

                  <!-- <div class="control-group"> -->

                     <?php

               $sql = "SELECT * from cat_master";
               $rs=odbc_exec($conn,$sql);
               while($f = odbc_fetch_array($rs)){
               ?>

                     <div class="row-fluid span3">
                     <label class="checkbox line">
                                          <div class="checker" id="uniform-undefined"><span><input type="checkbox" value="<?php echo $f['cat_id']; ?>" name="catalogue_name[]" style="opacity: 0;" id="catalogue_name"></span></div> <?php echo $f['cat_title']; ?>
                     </label>

                     <div class="tile double bg-grey">
                        <div class="tile-body">
                                 <a href="<?php echo "assets/Cataloge Cover Pages/".$f['cat_img'].".jpg"; ?>" target="_blank">
                                 <img src="<?php echo "assets/Cataloge Cover Pages/".$f['cat_img'].".jpg"; ?>" alt="" style="height: 65px; border-radius: 100px;"></a>
                                 <h4><b><?php echo $f['cat_name']; ?></b></h4>
                                 <p>
                                    <?php echo $f['cat_desc']; ?>
                                 </p>
                        </div>
                        <div class="tile-object">
                                 <div class="name">
                                    <?php echo $f['cat_plant']; ?>
                                 </div>
                                 <div class="number">
                                    <?php echo date('d M, Y',strtotime(trim($f['cat_date'])))?>
                                 </div>
                        </div>
                     </div>
                     </div>

            <?php 

               }
            ?>
                     
                  <!-- </div> -->



                  



                                    
                                 </div>
                                 <div class="tab-pane" id="tab4">
                                    <h3 class="block">Details Confirmation</h3>
                                    <div class="form-horizontal form-view">
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="FullName">Name:</label>
                                             <div class="controls">
                                                <span class="text" id="f_name"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="State">State:</label>
                                             <div class="controls">
                                                <span class="text" id="state_name"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Email ID:</label>
                                             <div class="controls">
                                                <span class="text" id="e_mail"></span> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contact No:</label>
                                             <div class="controls">
                                                <span class="text bold" id="c_no"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->        
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Employee Code:</label>
                                             <div class="controls">
                                                <span class="text bold" id="e_code"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Required Date:</label>
                                             <div class="controls">                                                
                                                <span class="text bold" id="r_date"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->                               
                                    <h3 class="form-section">Information</h3>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                             <label class="control-label">Catalogue Selection:</label>
                                             <div class="controls">
                                                

                                                <span class="text" id="cat"><?php print_r($cat_array_1); ?></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">City:</label>
                                             <div class="controls">
                                                <span class="text" id="city_name"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">Territory:</label>
                                             <div class="controls">
                                                <span class="text" id="territory_name"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->           
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                             <label class="control-label">Address:</label>
                                             <div class="controls">
                                                <span class="text" id="add"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       <!--/span-->
                                    </div>
                                    
                                 </div>
                                 </div>
                              </div>
                              <div class="form-actions clearfix">
                                 <a href="javascript:;" class="btn button-previous">
                                 <i class="m-icon-swapleft"></i> Back 
                                 </a>
                                 <a href="javascript:;" class="btn blue button-next" id="continue" name="continue" type="submit">
                                 Continue <i class="m-icon-swapright m-icon-white"></i>
                                 </a>
                                 <button type="submit" name="submit" class="btn green button-submit">
                                 Submit <i class="m-icon-swapright m-icon-white"></i>
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>

<script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
      });
   </script>
   <script>
      $(document).ready(function(){
         $("#city").change(function(){
            var st = $('select#city').children("option:selected").val();

            $.ajax({
               url: 'fetch_state.php',
               type: 'post',
               data: {st:st},
               dataType: 'json',
               success:function(response){
                  var len = response.length;
                  $('#state').empty();
                  for(var i = 0; i<len; i++){
                     var state = response[i]['state'];
                     $("#state").text(state);
                     $("#state_name").text(state);
                  }
               }
            });
         });


         $("#city").change(function(){
            var st = $('select#city').children("option:selected").val();

            $.ajax({
               url: 'fetch_territory.php',
               type: 'post',
               data: {st:st},
               dataType: 'json',
               success:function(response){
                  var len = response.length;
                  $('#territory').empty();
                  for(var i = 0; i<len; i++){
                     var territory = response[i]['territory'];
                     $("#territory").text(territory);
                     $("#territory_name").text(territory);
                  }
               }
            });
         });

         $("#city").change(function(){
            var st = $('select#city').children("option:selected").val();

            $.ajax({
               url: 'fetch_name.php',
               type: 'post',
               data: {st:st},
               dataType: 'json',
               success:function(response){
                  var len = response.length;
                  $('#city_name').empty();
                  for(var i = 0; i<len; i++){
                     var city_name = response[i]['city'];
                     $("#city_name").text(city_name);
                     
                  }
               }
            });
         });

      });
   </script>

  <script>
   $(document).ready(function(){

      $('#full_name').keyup(function() {
      $('#f_name').text($(this).val());
      });

      $('#email').keyup(function() {
      $('#e_mail').text($(this).val());
      });

      $('#contact').keyup(function() {
      $('#c_no').text($(this).val());
      });

      $('#emp_code').change(function() {
        if(!$(this).val() || $(this).val() == ''){
          alert("Input Value");
          return false;
        }else{
          $('#e_code').text($(this).val());    
        }
      
      });

      $('#required_date').keyup(function() {
      $('#r_date').text($(this).val());
      });

      $('#address').keyup(function() {
      $('#add').text($(this).val());
      });

     

      $('#city').change(function() {
      var territory = $('#territory').val();
      $('#territory_name').text($(territory).val());
      });
  
   });
    </script>