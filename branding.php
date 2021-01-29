<?php 
include_once('including/all-include.php');
        include_once('including/header.php');
        include('including/datetime.php');
        include('plant_function.php');
        $timestamp=date('Y-m-d H:i:s');
        $timestamp1=date('YmdHis');
        $uid = $_SESSION['uid'];
?>




<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> -->
            <div class="row-fluid">
          <div class="span12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box blue">
              <div class="portlet-title">
                <h4><i class="icon-edit"></i>Branding Request</h4>
                <div class="tools">
                  <a href="javascript:;" class="collapse"></a>
                  <a href="#portlet-config" data-toggle="modal" class="config"></a>
                  <a href="javascript:;" class="reload"></a>
                  <a href="javascript:;" class="remove"></a>
                </div>
              </div>
              <div class="portlet-body">
                <div class="clearfix">
                  <div class="btn-group">
                    <button id="sample_editable_1_new" class="btn green">
                    Add New Request <i class="icon-plus"></i>
                    </button>
                  </div>
                  <div class="btn-group pull-right">
                    <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="#">Print</a></li>
                      <li><a href="#">Save as PDF</a></li>
                      <li><a href="#">Export to Excel</a></li>
                    </ul>
                  </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                  <thead>
                    <tr>
                      <th>Dealer Code</th>
                      <th>Dealer Name</th>
                      <th>Sub Dealer</th>
                      <th>Address</th>
                      <th>City</th>
                      <th>State</th>
                      <th>Mobile No</th>
                      <th>Board Type</th>
                      <th>Inshop Branding</th>
                      <th>Created By</th>
                      <th>Manager Name</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="">
                      <td>C101427088203492</td>
                      <td>Sadhana Enterprises</td>
                      <td>Krishna Marble</td>
                      <td>Ram Nagar</td>
                      <td>Varanasi</td>
                      <td>U.P. East</td>
                      <td>9335054614</td>
                      <td>GSB</td>
                      <td>Yes</td>
                      <td>Vishal Dubey</td>
                      <td class="center">Neeraj Gupta</td>
                      <td><a class="edit" href="javascript:;">Edit</a></td>
                      <td><a class="delete" href="javascript:;">Delete</a></td>
                    </tr>
                    <tr class="">
                      <td>C101427088203492</td>
                      <td>Sadhana Enterprises</td>
                      <td>Krishna Marble</td>
                      <td>Ram Nagar</td>
                      <td>Varanasi</td>
                      <td>U.P. East</td>
                      <td>9335054614</td>
                      <td>GSB</td>
                      <td>Yes</td>
                      <td>Vishal Dubey</td>
                      <td class="center">Neeraj Gupta</td>
                      <td><a class="edit" href="javascript:;">Edit</a></td>
                      <td><a class="delete" href="javascript:;">Delete</a></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>
            </div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>


    <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
      $ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>
<script src="assets/js/jquery-1.8.3.min.js"></script> 
  <script src="assets/breakpoints/breakpoints.js"></script> 
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>    
  <script src="assets/js/jquery.blockui.js"></script>
  <script src="assets/js/jquery.cookie.js"></script>
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
  <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
  <script>
    jQuery(document).ready(function() {     
      // initiate layout and plugins
      App.setPage("table_editable");
      App.init();
    });
  </script>
<script>
  $(document).ready(function(){
   $("#cp").change(function(){
        var cat_id = $(this).val();
        /*alert(cat_id);*/
        $.ajax({
            url: 'fetch_size.php',
            type: 'post',
            data: {cat_id:cat_id},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                /*alert(len);*/

                $("#tile_category").empty();
                $("#tile_category").append("<option>- Select -</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['pr_product_group'];
                    var name = response[i]['pr_product_group'];
                    
                    $("#tile_category").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
        });
    });




    $("#tile_category").change(function(){
        var tile = $('select#tile_category').children("option:selected").val();
        var cp_id = $('select#cp').children("option:selected").val();
        /*alert(cat_id);*/
        $.ajax({
            url: 'fetch_category.php',
            type: 'post',
            data: {tile:tile, cp_id:cp_id},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                /*alert(len);*/

                $("#sku_size").empty();
                $("#sku_size").append("<option>- Select -</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['pr_sku_size'];
                    var name = response[i]['pr_sku_size'];
                    
                    $("#sku_size").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
        });
    });



    $("#sku_size").change(function(){
        var sk = $('select#sku_size').children("option:selected").val();
        var cp_id = $('select#cp').children("option:selected").val();
        /*alert(cat_id);*/
        $.ajax({
            url: 'fetch_price.php',
            type: 'post',
            data: {sk:sk, cp_id:cp_id},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                /*alert(len);*/

                $("#o_price").empty();
                
                for( var i = 0; i<len; i++){
                    var id = response[i]['pr_price'];
                    var name = response[i]['pr_price'];
                    /*alert(name);*/
                    
                    $("#o_price").val(name);

                }
            }
        });
    });

    $("#cp").change(function(){
        var st = $('select#cp').children("option:selected").val();
        /*var cp_id = $('select#cp').children("option:selected").val();*/
        /*alert(st);*/
        $.ajax({
            url: 'fetch_city.php',
            type: 'post',
            data: {st:st},
            dataType: 'json',
            success:function(response){

                var len = response.length;
                /*alert(len);*/

                $("#cp_city").empty();
                
                for( var i = 0; i<len; i++){
                    var city = response[i]['p_city'];
                    /*var name = response[i]['pr_price'];*/
                    /*alert(name);*/
                    
                    $("#cp_city").text(city);

                }
            }
        });
    });

    

     
  });
    
</script>
<script>
  $(document).ready(function(){
    function f_price(){
      var o_price = $('#o_price').val();
      var o_discount = $('#o_discount').val();
      var total_factory = (o_price-o_discount);
    $('#o_factory_price').val(total_factory);
    }
    $('#o_discount, #o_price').change(f_price);
    
  });
</script>
<script>
  $(document).ready(function(){
    function freight_total(){
    
      var o_weight = $('#o_weight').val();
      var o_area = $('#o_area').val();
      var o_freight = $('#o_freight').val();
      var total_freight = (o_freight/1000)*(o_weight/o_area).toFixed(2);
    $('#o_total_freight').val(total_freight);
    }
    $('#o_freight, #o_weight, #o_area').change(freight_total);
    
  });
</script>
<script>
  $(document).ready(function(){
    function ins_value(){
    
      var o_factory_price = $('#o_factory_price').val();
      var o_ins = $('#o_ins').val();
      var o_price = $('#o_price').val();
      var o_discount = $('#o_discount').val();
      var total_ins = (o_factory_price*o_ins/100).toFixed(2);
    $('#o_ins_value').val(total_ins);
    }
    $('#o_factory_price, #o_ins, #o_price, #o_discount').change(ins_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function gst_value(){
    
      var o_factory_price = $('#o_factory_price').val();
      var o_gst = $('#o_gst').val();
      var o_price = $('#o_price').val();
      var o_ins_value = $('#o_ins_value').val();
      var o_discount = $('#o_discount').val();
      var total_gst = ((parseFloat(o_factory_price)+parseFloat(o_ins_value))*(.18)).toFixed(2);
    $('#o_gst').val(total_gst);
    }
    $('#o_factory_price, #o_gst, #o_price, #o_discount, #o_ins, #o_ins_value').change(gst_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function cp_price(){
      var o_factory_price = $('#o_factory_price').val();
      var o_gst = $('select#o_gst').children("option:selected").val();
      /*var o_ins = $('select#o_ins').children("option:selected").val();*/
      var o_total_freight = $('#o_total_freight').val();
      var o_freight = $('#o_freight').val();
      var o_discount = $('#o_discount').val();
      var o_ins_value = $('#o_ins_value').val();
      var o_gst = $('#o_gst').val();
      var cp = (parseFloat(o_factory_price)+parseFloat(o_ins_value)+parseFloat(o_gst)+parseFloat(o_total_freight)).toFixed(2);
      $('#o_total').val(cp);
    }
      $('#o_factory_price, #o_gst, #o_ins, #o_total_freight, #o_freight, #o_discount,#o_area,#o_weight').change(cp_price);
    
  });
</script>

<script>
   $(document).ready(function(){
      
     $('#sku_size').change(function(){
         
         /*var category = $(this).val();*/
         var sku = $('select#sku_size').children("option:selected").val();
         /*alert(sku);*/ 
         $.ajax({
            url: "fetch_size.php",
            method:"POST",
            data:{sk:sku},
            dataType:"text",
            success:function(data){
            $('#o_price').text(data);
            }
         });
      });
   });
</script>

<!-- Competitor-1 script -->

<script>
  $(document).ready(function(){
    function c_price(){
      var c1_price = $('#c1_price').val();
      var c1_discount = $('#c1_discount').val();
      var c1_total_factory = (c1_price-c1_discount);
    $('#c1_factory_price').val(c1_total_factory);
    }
    $('#c1_discount, #c1_price').change(c_price);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c1_freight_total(){
    
      var c1_weight = $('#c1_weight').val();
      var c1_area = $('#c1_area').val();
      var c1_freight = $('#c1_freight').val();
      var total_freight = (c1_freight/1000)*(c1_weight/c1_area).toFixed(2);
    $('#c1_total_freight').val(total_freight);
    }
    $('#c1_freight, #c1_weight, #c1_area').change(c1_freight_total);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c1_ins_value(){
    
      var c1_factory_price = $('#c1_factory_price').val();
      var c1_ins = $('#c1_ins').val();
      var c1_price = $('#c1_price').val();
      var c1_discount = $('#c1_discount').val();
      var total_ins = (c1_factory_price*c1_ins/100).toFixed(2);
    $('#c1_ins_value').val(total_ins);
    }
    $('#c1_factory_price, #c1_ins, #c1_price, #c1_discount').change(c1_ins_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c1_gst_value(){
    
      var c1_factory_price = $('#c1_factory_price').val();
      var c1_gst = $('#c1_gst').val();
      var c1_price = $('#c1_price').val();
      var c1_discount = $('#c1_discount').val();
      var c1_ins_value = $('#c1_ins_value').val(); 
      var total_gst = ((parseFloat(c1_factory_price)+parseFloat(c1_ins_value))*(.18)).toFixed(2);
    $('#c1_gst').val(total_gst);
    }
    $('#c1_factory_price, #c1_gst, #c1_price, #c1_discount, #c1_ins, #c1_ins_value').change(c1_gst_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c1_cp_price(){
      var c1_factory_price = $('#c1_factory_price').val();
      var c1_gst = $('select#c1_gst').children("option:selected").val();
      /*var c1_ins = $('select#c1_ins').children("option:selected").val();*/
      var c1_total_freight = $('#c1_total_freight').val();
      var c1_freight = $('#c1_freight').val();
      var c1_discount = $('#c1_discount').val();
      var c1_ins_value = $('#c1_ins_value').val();
      var c1_gst = $('#c1_gst').val();
      var cp = (parseFloat(c1_factory_price)+parseFloat(c1_ins_value)+parseFloat(c1_gst)+parseFloat(c1_total_freight)).toFixed(2);
      $('#c1_total').val(cp);
    }
      $('#c1_factory_price, #c1_gst, #c1_ins, #c1_total_freight, #c1_freight, #c1_discount,#c1_area,#c1_weight').change(c1_cp_price);
    
  });
</script>

<!-- Competitor-2 script -->

<script>
  $(document).ready(function(){
    function d_price(){
      var c2_price = $('#c2_price').val();
      var c2_discount = $('#c2_discount').val();
      var c2_total_factory = (c2_price-c2_discount);
    $('#c2_factory_price').val(c2_total_factory);
    }
    $('#c2_discount, #c2_price').change(d_price);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c2_freight_total(){
    
      var c2_weight = $('#c2_weight').val();
      var c2_area = $('#c2_area').val();
      var c2_freight = $('#c2_freight').val();
      var total_freight = (c2_freight/1000)*(c2_weight/c2_area).toFixed(2);
    $('#c2_total_freight').val(total_freight);
    }
    $('#c2_freight, #c2_weight, #c2_area').change(c2_freight_total);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c2_ins_value(){
    
      var c2_factory_price = $('#c2_factory_price').val();
      var c2_ins = $('#c2_ins').val();
      var c2_price = $('#c2_price').val();
      var c2_discount = $('#c2_discount').val();
      var total_ins = (c2_factory_price*c2_ins/100).toFixed(2);
    $('#c2_ins_value').val(total_ins);
    }
    $('#c2_factory_price, #c2_ins, #c2_price, #c2_discount').change(c2_ins_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c2_gst_value(){
    
      var c2_factory_price = $('#c2_factory_price').val();
      var c2_gst = $('#c2_gst').val();
      var c2_price = $('#c2_price').val();
      var c2_discount = $('#c2_discount').val();
      var c2_ins_value = $('#c2_ins_value').val();
      var total_gst = ((parseFloat(c2_factory_price)+parseFloat(c2_ins_value))*(.18)).toFixed(2);
    $('#c2_gst').val(total_gst);
    }
    $('#c2_factory_price, #c2_gst, #c2_price, #c2_discount, #c2_ins, #c2_ins_value').change(c2_gst_value);
    
  });
</script>
<script>
  $(document).ready(function(){
    function c2_cp_price(){
      var c2_factory_price = $('#c2_factory_price').val();
      var c2_gst = $('select#c2_gst').children("option:selected").val();
      /*var c2_ins = $('select#c2_ins').children("option:selected").val();*/
      var c2_total_freight = $('#c2_total_freight').val();
      var c2_freight = $('#c2_freight').val();
      var c2_discount = $('#c2_discount').val();
      var c2_ins_value = $('#c2_ins_value').val();
      var c2_gst = $('#c2_gst').val();
      var cp = (parseFloat(c2_factory_price)+parseFloat(c2_ins_value)+parseFloat(c2_gst)+parseFloat(c2_total_freight)).toFixed(2);
      $('#c2_total').val(cp);
    }
      $('#c2_factory_price, #c2_gst, #c2_ins, #c2_total_freight, #c2_freight, #c2_discount,#c2_area,#c2_weight').change(c2_cp_price);
    
  });
</script>

  <!-- Competitor-2 script -->


  <script>
    $(document).ready(function(){
      function price_change(){
        var o_price = $('#o_price').val();
        /*alert(c2_price);*/
        if (o_price === '' || o_price === '0') {
          alert("OBL List Price can't be Zero or Empty");
          return false;
        }
      }
      $('#submit').click(price_change);
    });
  </script>

   <?php include_once('including/footer.php')?>
    <?php 

      if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
      $ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>

