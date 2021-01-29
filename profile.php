<?php 
$um='active';
$uma='active';
include_once('including/all-include.php');
include_once('including/header.php');
$timestamp=date('Y-m-d H:i:s');
$pid=(int)$_REQUEST['pid'];
$territoryId = $_SESSION['employee_territory'];
$uid = $_SESSION['uid'];

//print_r($_SESSION);
//print_r($_POST);

//echo '<br><br>';


//exit;



	
/*$formType = 'Change Password';*/


//print_r($_POST);
if(isset($_POST['submit'])){

		
	$dataArray=array(
					
					'currentpassword'						  =>	trim(dbOutput($_POST['currentpassword'])),					
					'password'						        =>	trim(dbOutput($_POST['password'])),
					'confirmpassword'				      =>	trim(dbOutput($_POST['confirmpassword']))
				);


	
	if(EmptyCheck($dataArray['currentpassword'])){
		 $errorArray['currentpassword']='Enter Current Password';
	}else{
		$bt="select *  from user_management where uid='".dbInput($_SESSION['uid'])."' and password='".dbInput($dataArray['password'])."'";
				$rs=odbc_exec($conn,$bt);
				if(odbc_num_rows($rs)>0){
					$errorArray['currentpassword']='Wrong Password Entered...';
				}
		}



	if(empty($dataArray['password'])){
		 $errorArray['password']='Enter New Password';
	}elseif(strlen($dataArray['password']) < 4 ){
		 $errorArray['password']='Password length should be greater then 3 characters';
	}


	if(empty($dataArray['confirmpassword']) ){
		 $errorArray['confirmpassword']='Enter Confirm Password';
	}elseif($dataArray['confirmpassword']!=$dataArray['password']){
		 $errorArray['confirmpassword']='Confirm Password Doesn\'t Matched';
	}

	


//print_r($errorArray);

	if(empty($errorArray)){
		
		 $upd  ="UPDATE user_management set password='".dbInput($dataArray['confirmpassword'])."' ";
		 $upd .="where uid='".dbInput($_SESSION['uid'])."' ";
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Password Changed Successfully.';
					$msgType = 1;
				}else{
					$msgTxt = 'Sorry! Unable To Change Password, Please Try Later.';
					$msgType = 2;
				}

				header('Location:profile.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;

		}
	
}//main post end here	

?>

<?php 
  $u_sql = "SELECT 
            u.uid, 
            u.user_type,
            u.emp_code, 
            u.fullname, 
            u.email, 
            u.contact, 
            t.fullname as [manager_name], 
            r.territory_name, 
            u.employee_department, 
            u.u_address,
            u.added_date,
            u.last_login,
            u.emp_status from user_management u

            left join user_management t on t.uid = u.parent_id
            left outer join territory_master r on r.territory_id = u.employee_territory
            where u.uid = '$uid'";
              $u_result = odbc_exec($conn, $u_sql);
                        while($g = odbc_fetch_array($u_result)){
                          $u_name = $g['fullname'];
                          $u_territory = $g['territory_name'];
                          $u_mail = $g['email'];
                          $u_manager = $g['manager_name'];
                          $u_department = $g['employee_department'];
                          $u_address = $g['u_address'];
                          $u_added_date = $g['added_date'];
                          $u_last_login = $g['last_login'];
                          $u_contact = $g['contact'];
                        }
            ?>

 <!-- <script src="assets/js/jquery-1.11.3.min.js"></script> -->
 


            <!-- BEGIN PAGE CONTENT-->
          <div class="row-fluid profile">
          <div class="span12">
            <!--BEGIN TABS-->
            <div class="tabbable tabbable-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1_1" data-toggle="tab">Profile Overview</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane row-fluid active" id="tab_1_1">
                  <form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post">
                  <ul class="unstyled profile-nav span3">
                    <li><img src="assets/img/user5.png" alt="" style="height: 160px; margin-left: 90px;margin-top: 10px; width: 160px; border-radius:100px !important; " /></li>
                    <br><br>
                    <li><div class="control-group">
                         <label class="control-label">Current Password</label>
                         <div class="controls">
                          <input type="password"  name="currentpassword" class="m-wrap large" value="<?php echo $dataArray['currentpassword']?>" required/>
                          <div style="color:#CB0205"><?php echo $errorArray['currentpassword']?></div>
                         </div>
                        </div> 
                    </li>
                    <li><div class="control-group">
                         <label class="control-label">New Password</label>
                         <div class="controls">
                          <input type="password"  name="password" class="m-wrap large" value="<?php echo $dataArray['password']?>" required/>
                          <div style="color:#CB0205"><?php echo $errorArray['password']?></div>
                         </div>
                        </div> 
                    </li>
                    <li><div class="control-group">
                         <label class="control-label">Confirm Password</label>
                         <div class="controls">
                          <input type="password"  name="confirmpassword" class="m-wrap large" value="<?php echo $dataArray['confirmpassword']?>" required/>
                          <div style="color:#CB0205"><?php echo $errorArray['confirmpassword']?></div>
                         </div>
                        </div> 
                    </li>
                    <div class="submit-btn">
                                  <button type="submit" name="submit" class="btn green"><i class="icon-key"></i> Update Password</button>
                                  <!-- <button type="button" class="btn">Cancel</button> -->
                                </div>
                  </ul>
                </form>
                  <div class="span9">
                    <div class="row-fluid">
                      <div class="span8 profile-info">
                        <h1 title="My Name"><?php echo $u_name; ?></h1>
                        <p title="My Manager"><b>Manager: </b><?php echo $u_manager; ?></p>
                        <p title="My Address"><b>Address: </b><?php echo $u_address; ?></p>
                        <p title="My Email"><a href="#"><?php echo $u_mail; ?></a></p>
                        <ul class="unstyled inline">
                          <li title="My Territory"><i class="icon-map-marker"></i> <?php echo $u_territory; ?></li>
                          <li title="Added On"><i class="icon-calendar"></i> <?php echo date('F j, Y',strtotime(trim($u_added_date))); ?></li>
                          <li title="My Department"><i class="icon-briefcase"></i> <?php echo $u_department; ?></li>
                          <li title="Last Login"><i class="icon-edit"></i> <?php echo date('F j, Y, g:i A',strtotime(trim($u_last_login))); ?></li>
                          <li title="My Contact"><i class="icon-phone"></i> +91 - <?php echo $u_contact; ?></li>
                        </ul>
                      </div>
                      <!--end span8-->
                      <div class="span4">
                        <div class="portlet sale-summary">
                          <div class="portlet-title">
                            <h4>Deal Summary</h4>
                            <div class="tools">
                              <a class="reload" href="javascript:;"></a>
                            </div>
                          </div>
                          <ul class="unstyled">
                            <li>
                              <?php 
                              $s_query = "SELECT sum(obl_sale_forecast_inr) as project_tile_daily_amount 
                              from opportunity 
                              where convert(date,added_date) = convert(date,GETDATE()) and created_by = '$uid'";
                              $s_result = odbc_exec($conn, $s_query);
                              $s_total=1;
                              while ($s = odbc_fetch_array($s_result)) {
                              $s_total_sale = $s['project_tile_daily_amount'];
                              $s_total++;
                              }
                               ?>
                              <span class="sale-info">TODAY's DEAL <i class="icon-bullhorn"></i></span> 
                              <span class="sale-num"><?php echo round(trim($s_total_sale, 0),0); ?></span>
                            </li>
                            <li>
                              <?php 
                              $w_query = "SELECT sum(obl_sale_forecast_inr) as project_tile_weekly_amount from opportunity where added_date BETWEEN convert(date,GETDATE()-7) AND convert(date,GETDATE()) and created_by = '$uid'";
                              $w_result = odbc_exec($conn, $w_query);
                              $w_total=1;
                              while ($w = odbc_fetch_array($w_result)) {
                              $weekly_sale = $w['project_tile_weekly_amount'];
                              $w_total++;
                              }
                               ?>
                              <span class="sale-info">WEEKLY DEAL <i class="icon-shopping-cart"></i></span> 
                              <span class="sale-num"><?php echo round(trim($weekly_sale, 0),0); ?></span>
                            </li>
                            <li>
                              <?php 
                              $t_query = "SELECT sum(obl_sale_forecast_inr) as project_tile_total_amount from opportunity where  created_by = '$uid'";
                              $t_result = odbc_exec($conn, $t_query);
                              $t_total = 1;
                              while ($t = odbc_fetch_array($t_result)) {
                               $t_total_sum = $t['project_tile_total_amount'];
                              $t_total++;
                              }
                               ?>
                              <span class="sale-info">TOTAL PIPELINE</span>&nbsp;(In Lacs)
                              <span class="sale-num"><?php echo round(trim($t_total_sum/100000,0),0); ?></span>
                            </li>
                            <!-- <li>
                              <span class="sale-info">EARNS</span> 
                              <span class="sale-num">$37.990</span>
                            </li> -->
                          </ul>
                        </div>
                      </div>
                      <!--end span4-->
                    </div>
                    <!--end row-fluid-->
                    <br>
                    <div class="tabbable tabbable-custom tabbable-custom-profile">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1_11" data-toggle="tab">Customers</a></li>
                        <li class=""><a href="#tab_1_22" data-toggle="tab">Feeds</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_11">
                          <div class="portlet-body" style="display: block;">
                            <table class="table table-striped table-bordered table-advance table-hover" id="sample_1">
                              <thead>
                                <tr>
                                  <th width="5%;"><i class="icon-filter"></i></th>
                                  <th width="30%;"><i class="icon-briefcase"></i> My Account</th>
                                  <th width="15%;"><i class="icon-tag"></i> Account Type</th>
                                  <th width="10%;"><i class="icon-bookmark"></i> Projects</th>
                                  <th width="15%;"><i class=" icon-bullhorn"></i> Sale (INR in Lacs)</th>
                                  <th width="15%;"><i class="icon-shopping-cart"></i> Sale (SQMT)</th>
                                  <th width="10%;"><i class="icon-info-sign"></i> Category</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                $r_sql = "SELECT
                                          c.cka_name,

                                          CASE
                                          when d.deal_type = 'Specifier Engagement Team (SET)' then 'SET'
                                          when d.deal_type = 'Private Enterprise Team (PET)' then 'PET'
                                          when d.deal_type = 'Government Enterprise Team (GET)' then 'GET'
                                          ELSE 'Retail'
                                          END AS deal_type_name,

                                          count(o.project_name) as [project_count],
                                          sum(o.obl_sale_forecast_inr) as [total_sale],
                                          sum(try_convert(decimal(18,0),project_tile_potential_sqm)) as total_sqmt,
                                          c.cka_category
                                          from opportunity o
                                          inner join cka_name_master c on c.cka_name_id = o.cka_name_id
                                          left join deal_type d on d.deal_type_id = o.deal_type";

                                          if(trim($_SESSION['user_type'])=='management') {
                                            $r_sql.="  where 1=1 group by c.cka_name,c.cka_category,d.deal_type order by cka_name asc ";
                                          }else{

                                              if($_SESSION['employee_department']=='GET' || $_SESSION['employee_department']=='PET' || $_SESSION['employee_department']=='SET' || $_SESSION['employee_department']=='CTU' || $_SESSION['employee_department']=='Retail'){
                                                  
                                                  if($_SESSION['user_type']=='manager'){
                                                  $r_sql.=" where 1=1 
                                                    and ( ";

                                                    $ex=explode(",",$_SESSION['my_team_id']);
                                                      $xcnt=0;
                                                    foreach ($ex as $vx){
                                                    //echo $vx;
                                                      if($xcnt==0)
                                                        $r_sql.=" o.created_by = '".$vx."' or o.created_by='".$_SESSION['uid']."'";
                                                      else
                                                        $r_sql .=" or o.created_by = '".$vx."' ";
                                                      $xcnt++;
                                                    }
                                                    $r_sql.=" )  group by c.cka_name,c.cka_category,d.deal_type order by cka_name asc ";
                                                  }else{
                                                    $r_sql.=" where o.created_by='".$_SESSION['uid']."' group by c.cka_name,c.cka_category,d.deal_type order by cka_name asc
                                                     "; 
                                                  }

                                              }
                                            
                                          }


                                $r_result = odbc_exec($conn, $r_sql);
                                $count = 1;
                                          while($f = odbc_fetch_array($r_result)){
                                            
                                ?>
                                <tr>
                                  <td><?php echo $count ;?></td>
                                  <td><a href="list-all-lead.php?account_name=<?php echo $f['cka_name']; ?>&show_result=Search"><?php echo $f['cka_name']; ?></a></td>
                                  <td><?php echo $f['deal_type_name']; ?></td>
                                  <td><a href="list-all-lead.php?account_name=<?php echo $f['cka_name']; ?>&show_result=Search"><?php echo $f['project_count']; ?></a></td>
                                  <td title="<?php echo $f['total_sale']; ?>"><?php echo number_format(trim($f['total_sale']/100000),0); ?></td>
                                  <td title="<?php echo $f['total_sqmt']; ?>"><?php echo $f['total_sqmt']; ?></td>
                                  <td style="text-align: center;"><a href="list-all-lead.php?account_name=<?php echo $f['cka_name']; ?>&show_result=Search"><?php echo $f['cka_category']; ?></a></td>
                                </tr>

                                <?php 
                                    $count ++; 
                                          }
                                         
                                 ?>
                                
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!--tab-pane-->
                        <div class="tab-pane" id="tab_1_22">
                          <div class="tab-pane active" id="tab_1_1_1">
                            <div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
                              <ul class="feeds">
                                <li>
                                  <div class="col1">
                                    <div class="cont">
                                      <div class="cont-col1">
                                        <div class="label label-success">               
                                          <i class="icon-bell"></i>
                                        </div>
                                      </div>
                                      <div class="cont-col2">
                                        <div class="desc">
                                          <?php 
                                          $d_query = "SELECT 
                                          current_stage as total_discussion
                                          from opportunity where current_stage = 2 and status != 'lost' and created_by = '$uid'";
                                          $d_result = odbc_exec($conn, $d_query);
                                          $d_total_sum = odbc_num_rows($d_result)
                                          /*$d_total = 1;
                                          while ($d = odbc_fetch_array($d_result)) {
                                           $d_total_sum = $d['total_discussion'];
                                          $d_total++;
                                          }*/
                                           ?>
                                          You have <?php echo $d_total_sum; ?> pending Leads in Discussion Phase.
                                          <a href="list-all-lead.php?sales_phase=Discussion&show_result=Search"><span class="label label-important label-mini">
                                          Take action 
                                          <i class="icon-share-alt"></i>
                                          </span></a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col2">
                                    <div class="date">
                                      Just now
                                    </div>
                                  </div>
                                </li>
                                <!-- <li>
                                  <div class="col1">
                                    <div class="cont">
                                      <div class="cont-col1">
                                        <div class="label label-success">               
                                          <i class="icon-bell"></i>
                                        </div>
                                      </div>
                                      <div class="cont-col2">
                                        <div class="desc">
                                          <?php 
                                          $d_query = "SELECT 
                                          count(current_stage) as total_discussion
                                          from opportunity where current_stage = 2 and created_by = '$uid'";
                                          $d_result = odbc_exec($conn, $d_query);
                                          $d_total = 1;
                                          while ($d = odbc_fetch_array($d_result)) {
                                           $d_total_sum = $d['total_discussion'];
                                          $d_total++;
                                          }
                                           ?>
                                          You have <?php echo $d_total_sum; ?> pending tasks.
                                          <a href="list-all-lead.php?sales_phase=Discussion&show_result=Search"><span class="label label-important label-mini">
                                          Take action 
                                          <i class="icon-share-alt"></i>
                                          </span></a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col2">
                                    <div class="date">
                                      Just now
                                    </div>
                                  </div>
                                </li> -->
                              </ul>
                            </div>
                          </div>
                        </div>
                        <!--tab-pane-->
                      </div>
                    </div>
                  </div>
                  <!--end span9-->
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
   <!-- END CONTAINER -->
   <?php include_once('including/footer.php')?>
   <?php 

   if(isset($_GET['msgTxt']) && isset($_GET['msgType'])){
			$ms=base64_decode($_GET['msgTxt']);
                echo '<script>alert(\''.$ms.'\');</script>';
            }
   ?>