 
<script>
function show_msg(){
  
var msg = document.getElementById("msg").value;


 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("msg_history").innerHTML =
      this.responseText;
    }
  };
 
xhttp.open("GET","msg_history.php?msg="+msg,true);
  xhttp.send();
}
</script>



<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8" />
  <title>SAP Message History</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/css/metro.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="assets/css/style.css" rel="stylesheet" />
   <link href="assets/css/style_responsive.css" rel="stylesheet" />
   <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
   <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="assets/jquery-tags-input/jquery.tagsinput.css" />
   <link rel="stylesheet" type="text/css" href="assets/clockface/css/clockface.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <!-- <link rel="shortcut icon" href="favicon.ico" /> -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login" style="background-color: #fff !important;">
  <!-- BEGIN LOGO -->
  <!-- <br><br><br> -->
    <!-- <H2 align="center" style="color:#000000">SAMPLE MESSAGE SCREEN</H2> -->

  <!-- <div class="logo">
   <a href="index.php"> <img src="assets/img/logo-header.png" alt="ORIENT BELL LIMITED" /> </a>
  </div> -->

  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
 <div class="row-fluid">
               <div class="span8 offset2">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box">
                     
                     <div class="portlet-body form">
                      <div class="control-group" style="margin-top: 20px;">
                        <a href="#" class="icon-btn span2" style="background-color: #dff1de !important;">
                    <i class="icon-ok"></i>
                    <div><b>Correct</b></div>
                    <span class="badge badge-success">2</span>
                  </a>
                  <a href="#" class="icon-btn span2 pull-right" style="background-color: #f7dfdf !important;">
                    <i class="icon-remove"></i>
                    <div><b>In Correct</b></div>
                    <span class="badge badge-important">5</span>
                  </a>
                      </div>
                     	<!-- <div class="well" style="margin-top: 50px;">
                      
                                          <h4 id="sender"></b></h4>
                                          Sample Message
                                        </div> -->
                        <!-- BEGIN FORM-->
                        <!-- <div class="control-group" style="text-align: center;">
                              <label class="control-label" style="color: red;"><b><?php echo $msg; ?></b></label>
                              
                           </div> -->
                        <!-- <form action="#" class="form-horizontal" style="margin-top: 30px !important;" method="POST"> -->
                           
                           
                           <div class="control-group" style="margin-top: 140px;">
                              <label class="control-label">Message:</label>
                              <div class="controls">
                                 <textarea class="span12 m-wrap" rows="2" name="" id="msg" required="required"></textarea>
                              </div>
                           </div>
                           <div>
                              <!-- <button  name="send" id="send" class="btn green">Send</button>&nbsp;&nbsp; -->
                              <input type="button" class="btn green" value="Send"  onclick="show_msg();"/>&nbsp;&nbsp;
                              <a href="msg.php"><button type="submit" name="" class="btn red">Cancel</button></a>
                           </div>
                        <!-- </form> -->
                        <!-- END FORM-->
                        <br><br>
                        <div class="control-group" style="height: 290px;overflow-y: scroll;" >
                              <label class="control-label" id="msg" style="color: red;"><b>Hi this the sample text message.</b></label>
                          <div class="portlet">
                <div class="portlet-title">
                  
                  
                </div>
                <div id="message_history" class="portlet-body" style="margin-right: 20px;">
                  <h3>History</h3>
                  <div id="msg_history"><?php include('msg_history.php');?>
                    
                  </div> 
                 <!--  <h3>History</h3>
                 
                 <blockquote>
                   <?php echo load_msg(); ?>
                   <br>
                                     </blockquote>
                 <blockquote>
                   <i class="icon-user span1" style="margin-top: 10px; margin-left: 5px; font-size: 25px;"></i><p id="sender" style="margin-left: 55px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Duis mollis, est non commodo luctus, nisi erat porttitor ligula integer posuere erat a ante.erat a ante. Duis mollis, est non commodo luctus, nisi erat porttitor ligula integer posuere erat a ante.integer posuere erat a ante.erat a ante. Duis mollis, est non commodo luctus, nisi erat porttitor ligula integer posuere erat a ante.</p>
                   <small class="pull-right">Jan 10, 2020 10:30 AM</small>
                   <br>
                 </blockquote>
                 <blockquote>
                   <i class="icon-question-sign span1" style="margin-top: 10px; margin-left: 5px; font-size: 25px;"></i><p id="sender" style="margin-left: 55px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Duis mollis, est non commodo luctus, nisi erat porttitor ligula integer posuere erat a ante.erat a ante. Duis mollis, est non commodo luctus, nisi erat porttitor ligula integer posuere erat a ante.integer posuere erat a ante.erat a ante. Duis mollis, est non commodo luctus, nisi erat porttitor ligula integer posuere erat a ante.</p>
                   <small class="pull-right">Jan 10, 2020 10:30 AM</small>
                   <br>
                 </blockquote> -->
                </div>
              </div>
                              
                              
                              
                              
                              
                              
                           </div>           
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <!-- <div class="copyright">
       2019 &copy; Orient Bell Ltd. <br> Best Viewed in Chrome | Developed BY: OBL IT Department
  </div> -->
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.3.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  
  <script src="assets/uniform/jquery.uniform.min.js"></script> 
  <script src="assets/js/jquery.blockui.js"></script>
  <script type="text/javascript" src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> -->
  <script src="assets/js/app.js"></script>
  <script>
    jQuery(document).ready(function() {     
      App.initLogin();
    });
  </script>
  <script>
    $(document).ready(function(){
      $('#send').click(function(){
      var msg = $('#msg').val();
        $.ajax({
          type: 'POST',
          url: 'send.php',
          data: {msg:msg},
          dataType: 'json',
          success: function(response){
            var len = response.length;
                

                /*$("#tile_category").empty();*/
                /*$("#sender").append("<option>- Select -</option>");*/
                for( var i = 0; i<len; i++){
                    var msg = response[i]['msg'];
                    /*alert(msg);*/
                    
                    $("#sender").text(msg);
                     

                }
          }
        });
      });
    });
  </script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>