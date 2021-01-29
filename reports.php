<?php 
   $rp='active';

        include_once('including/all-include.php');
        include_once('including/header.php');
      unset($_SESSION['working-active-asset']);

?>  







                 <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Pipeline Summary Report</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="export_summary.php" method="POST" class="horizontal-form">
                                    <!-- <h3 class="form-section">Pipeline Summary Report</h3> -->
                                    <div class="row-fluid">
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="firstName">Account Name</label>
                                             <div class="controls">
                                                <input type="text" name="account_name" value="<?php echo $_POST['account_name']?>" style="width:200px; background-color:<?php echo (!empty($_POST['account_name']))?'#d6f5d6':'' ?>"/>
                                                <!-- <span class="help-block">This is inline help</span> -->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="lastName">Lead ID</label>
                                             <div class="controls">
                                                <input type="text" name="lead_id" value="<?php echo $_POST['lead_id']?>" style="width:200px; background-color:<?php echo (!empty($_POST['lead_id']))?'#d6f5d6':'' ?>"/>
                                                <!-- <span class="help-block">This field has error.</span> -->
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Territory</label>
                                             <div class="controls">
                                                <select name="territory" style="width:200px; background-color:<?php echo (!empty($_POST['territory']))?'#d6f5d6':'' ?>" >
                                                   <option value="">-All-</option>
                                                <?php
                                                   $sql="select * from territory_master";
                                                   $rs=odbc_exec($conn,$sql);
                                                   while($f = odbc_fetch_array($rs)){
                                                   $selected=($f['territory_id']==$_POST['territory'])?'selected':'';
                                                   echo '<option value="'.$f['territory_id'].'"'.$selected.'>'.$f['territory_name'].'</option>';
                                                   }
                                                ?>
                                                </select>
                                                <!-- <span class="help-block">Select your gender.</span> -->
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Lead Source</label>
                                             <div class="controls">
                                                <select name="lead_source" style="width:200px; background-color:<?php echo (!empty($_POST['lead_source']))?'#d6f5d6':'' ?> ">
                                                      <option value="">-All-</option>
                                                      <option value="PMT" <?php echo ($_POST['lead_source']=='PMT')?'selected':''?>>PMT</option>    
                                                      <option value="Marketing" <?php echo ($_POST['lead_source']=='Marketing')?'selected':''?>>Marketing</option>      
                                                      <option value="99AC" <?php echo ($_POST['lead_source']=='99AC')?'selected':''?>>99 Acres</option>
                                                      
                                           </select>
                                                <!-- <span class="help-block">Select your gender.</span> -->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Tiling Date</label>
                                             <div class="controls">
                                                <input class="m-wrap m-ctrl-medium date-range" size="16" type="text"  name="tile_stage_date" value="<?php echo $_POST['tile_stage_date']?>" style="background-color:<?php echo (!empty($_POST['tile_stage_date']))?'#d6f5d6':'#FFF' ?>"/>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Generated Date</label>
                                             <div class="controls">
                                                <input class="m-wrap m-ctrl-medium date-range" size="16" type="text"  name="generated_date" value="<?php echo $_POST['generated_date']?>" style="background-color:<?php echo (!empty($_POST['generated_date']))?'#d6f5d6':'#FFF' ?>"/>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Generated By</label>
                                             <div class="controls">
                                                <input type="text"  name="generated_by" value="<?php echo $_POST['generated_by']?>" style="width:200px; background-color:<?php echo (!empty($_POST['generated_by']))?'#d6f5d6':'' ?> "/>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">City</label>
                                             <div class="controls">
                                                <input type="text"   name="city" value="<?php echo $_POST['city']?>" style="width:200px; background-color:<?php echo (!empty($_POST['city']))?'#d6f5d6':'' ?>" />
                                             </div>
                                          </div>
                                       </div>

                                       <!--/span-->
                                    </div>
                                    <!--/row-->        
                                    
                                    <!--/row--> 
                                <div class="form-actions" style="padding-left: 10px !important;">
                                 
                                       <input type="submit" name="download" class="btn blue" value="Download">
                                       <a href="reports.php"><button type="button" class="btn">Reset</button></a>
                                    </div>
                                 </form>
                                 <!-- END FORM-->    
                                    
               
                     

                        <!-- <a href="export_summary.php?val=<?php echo base64_encode($sql); ?>"><button class="btn blue">Download</button></a> -->

                              </div>
                           </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                     </div>

                  </div>
                  </div>
                  </div>


                     <?php include_once('including/footer.php')?>
      <?php 

   if(isset($_POST['msgTxt']) && isset($_POST['msgType'])){
         $ms=base64_decode($_POST['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>