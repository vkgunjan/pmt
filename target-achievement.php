<?php 
$um='active';
$uma='active';
include_once('including/all-include.php');
include_once('including/header.php');
$timestamp=date('Y-m-d H:i:s');

$delid=(int)$_REQUEST['delid'];		

$fy='2017-18';


$formType = ' Update Employee Target Vs Achievement ';

$btsel="select fullname from user_management where uid='".dbInput($delid)."'";
$rs=odbc_exec($conn,$btsel);
$f = odbc_fetch_array($rs);
//print_r($f);
$emp_name=$f['fullname'];

//print_r($_SESSION);
if(isset($delid) && $delid>0){

$tqry="select * from sales_target where target_for_uid='".dbInput($delid)."'";
$trs=odbc_exec($conn,$tqry);
$tf = odbc_fetch_array($trs);


		$targetArray=array(
			'apr_tgt'	=>	$tf['apr'],			
			'may_tgt'	=>	$tf['may'],
			'jun_tgt'	=>	$tf['jun'],			
			'jul_tgt'	=>	$tf['jul'],
			'aug_tgt'	=>	$tf['aug'],			
			'sep_tgt'	=>	$tf['sep'],
			'oct_tgt'	=>	$tf['oct'],			
			'nov_tgt'	=>	$tf['nov'],
			'dec_tgt'	=>	$tf['dec'],			
			'jan_tgt'	=>	$tf['jan'],
			'feb_tgt'	=>	$tf['feb'],			
			'mar_tgt'	=>	$tf['mar']
		);

$aqry="select * from sales_achievement where achievement_for_uid='".dbInput($delid)."'";
$ars=odbc_exec($conn,$aqry);
$af = odbc_fetch_array($ars);


		$achievementArray=array(
			'apr_ach'	=>	$af['apr'],			
			'may_ach'	=>	$af['may'],
			'jun_ach'	=>	$af['jun'],			
			'jul_ach'	=>	$af['jul'],
			'aug_ach'	=>	$af['aug'],			
			'sep_ach'	=>	$af['sep'],
			'oct_ach'	=>	$af['oct'],			
			'nov_ach'	=>	$af['nov'],
			'dec_ach'	=>	$af['dec'],
			'jan_ach'	=>	$af['jan'],
			'feb_ach'	=>	$af['feb'],			
			'mar_ach'	=>	$af['mar']
		);


}


if(isset($_POST['submit'])){
//	echo '<pre>';
//	print_r($_POST);

		$targetArray=array(
			'apr_tgt'	=>	$_POST['apr_tgt'],			
			'may_tgt'	=>	$_POST['may_tgt'],
			'jun_tgt'	=>	$_POST['jun_tgt'],			
			'jul_tgt'	=>	$_POST['jul_tgt'],
			'aug_tgt'	=>	$_POST['aug_tgt'],			
			'sep_tgt'	=>	$_POST['sep_tgt'],
			'oct_tgt'	=>	$_POST['oct_tgt'],			
			'nov_tgt'	=>	$_POST['nov_tgt'],
			'dec_tgt'	=>	$_POST['dec_tgt'],			
			'jan_tgt'	=>	$_POST['jan_tgt'],
			'feb_tgt'	=>	$_POST['feb_tgt'],			
			'mar_tgt'	=>	$_POST['mar_tgt']
		);


		$achievementArray=array(
			'apr_ach'	=>	$_POST['apr_ach'],			
			'may_ach'	=>	$_POST['may_ach'],
			'jun_ach'	=>	$_POST['jun_ach'],			
			'jul_ach'	=>	$_POST['jul_ach'],
			'aug_ach'	=>	$_POST['aug_ach'],			
			'sep_ach'	=>	$_POST['sep_ach'],
			'oct_ach'	=>	$_POST['oct_ach'],			
			'nov_ach'	=>	$_POST['nov_ach'],
			'dec_ach'	=>	$_POST['dec_ach'],
			'jan_ach'	=>	$_POST['jan_ach'],
			'feb_ach'	=>	$_POST['feb_ach'],			
			'mar_ach'	=>	$_POST['mar_ach']
		);
//echo 'submitted';
//print_r($_POST);

$tgt_chk="select target_for_uid from sales_target where target_for_uid='".dbInput($delid)."'";
$tchk=odbc_exec($conn,$tgt_chk);
if(odbc_num_rows($tchk)>0){
	
	$upd  ="UPDATE sales_target set 
 		apr='".dbInput($targetArray['apr_tgt'])."',  may='".dbInput($targetArray['may_tgt'])."', jun='".dbInput($targetArray['jun_tgt'])."',  
		jul='".dbInput($targetArray['jul_tgt'])."', aug='".dbInput($targetArray['aug_tgt'])."',  sep='".dbInput($targetArray['sep_tgt'])."', 
		oct='".dbInput($targetArray['oct_tgt'])."',  nov='".dbInput($targetArray['nov_tgt'])."', dec='".dbInput($targetArray['nov_tgt'])."',  
		jan='".dbInput($targetArray['jan_tgt'])."',  feb='".dbInput($targetArray['feb_tgt'])."', mar='".dbInput($targetArray['mar_tgt'])."',
   	    modified_by= '".dbInput($_SESSION['uid'])."'  where target_for_uid='".(int)dbInput($delid)."'  ";
}
else{
	
	$upd  ="INSERT into sales_target (target_for_uid, apr, may, jun, jul, aug, sep, oct, nov, dec, jan, feb, mar,modified_by) 
			values(
			'".dbInput($delid)."',	
			'".dbInput($targetArray['apr_tgt'])."',  '".dbInput($targetArray['may_tgt'])."', '".dbInput($targetArray['jan_tgt'])."',  
			'".dbInput($targetArray['jul_tgt'])."', '".dbInput($targetArray['aug_tgt'])."',  '".dbInput($targetArray['sep_tgt'])."', 
			'".dbInput($targetArray['oct_tgt'])."',  '".dbInput($targetArray['nov_tgt'])."', '".dbInput($targetArray['nov_tgt'])."',  
			'".dbInput($targetArray['jan_tgt'])."',  '".dbInput($targetArray['feb_tgt'])."', '".dbInput($targetArray['mar_tgt'])."', 
			'".dbInput($_SESSION['uid'])."' )
			 ";
}

		
		//echo $upd;		
		$stmt = odbc_prepare($conn, $upd);
				if (odbc_execute($stmt)){ 
					$msgTxt = ' Target / Achievement Details Has Been Updated Successfully.';
					$msgType = 1;

				}else{
					$msgTxt = 'Sorry! Unable To Update Target / Achievement Details, Please Try Later.';
					$msgType = 2;
				}



$ach_chk="select achievement_for_uid from sales_achievement where achievement_for_uid='".dbInput($delid)."'";
$achk=odbc_exec($conn,$ach_chk);
if(odbc_num_rows($achk)>0){
	
	$upd_ach  ="UPDATE sales_achievement set 
 apr='".dbInput($achievementArray['apr_ach'])."',  may='".dbInput($achievementArray['may_ach'])."', jun='".dbInput($achievementArray['jun_ach'])."',  
jul='".dbInput($achievementArray['jul_ach'])."', aug='".dbInput($achievementArray['aug_ach'])."',  sep='".dbInput($achievementArray['sep_ach'])."', 
oct='".dbInput($achievementArray['oct_ach'])."',  nov='".dbInput($achievementArray['nov_ach'])."', dec='".dbInput($achievementArray['dec_ach'])."',  
jan='".dbInput($achievementArray['jan_ach'])."',  feb='".dbInput($achievementArray['feb_ach'])."', mar='".dbInput($achievementArray['mar_ach'])."',
modified_by='".dbInput($_SESSION['uid'])."' where achievement_for_uid='".(int)dbInput($delid)."'  ";
}
else{
	
	$upd_ach  ="INSERT into sales_achievement (achievement_for_uid, apr, may, jun, jul, aug, sep, oct, nov, dec, jan, feb,mar,modified_by) 
	values(
		'".dbInput($delid)."',
		'".dbInput($achievementArray['apr_ach'])."',  '".dbInput($achievementArray['may_ach'])."', '".dbInput($achievementArray['jun_ach'])."',  
		'".dbInput($achievementArray['jul_ach'])."', '".dbInput($achievementArray['aug_ach'])."',  '".dbInput($achievementArray['sep_ach'])."', 
		'".dbInput($achievementArray['oct_ach'])."',  '".dbInput($achievementArray['nov_ach'])."', '".dbInput($achievementArray['dec_ach'])."',  
		'".dbInput($achievementArray['jan_ach'])."',  '".dbInput($achievementArray['feb_ach'])."', '".dbInput($achievementArray['mar_ach'])."',
		'".dbInput($_SESSION['uid'])."'
		) ";
}
		 
		//echo $upd_ach;
				
		$stmt_ach = odbc_prepare($conn, $upd_ach);
				if (odbc_execute($stmt_ach)){ 
					$msgTxt = ' Target / Achievement Details Has Been Updated Successfully.';
					$msgType = 1;

				}else{
					$msgTxt = 'Sorry! Unable To Update Target / Achievement Details, Please Try Later.';
					$msgType = 2;
				}



				header('Location:target-achievement.php?msgType=' . $msgType . '&msgTxt=' . base64_encode($msgTxt));
				exit;

}


?>

 <script src="assets/js/jquery-1.11.3.min.js"></script>
 
 <script>
$(document).ready(function(){
$("#mt").hide();

  $("#mgr").click(function(){
    $("#mt").hide();
  });

  $("#mgt").click(function(){
    $("#mt").hide();
  });

 $("#a").click(function(){
    $("#mt").hide();
  });
  
   $("#g").click(function(){
    $("#mt").show();
  });

  
});
</script>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue tabbable">
                     <div class="portlet-title">
                        <h4>
                           <i class="icon-reorder"></i>
                           <span class="hidden-480"><?php echo $formType?></span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                        <div class="tabbable portlet-tabs">
                           <ul class="nav nav-tabs">
                              <li class="active"><a href="#portlet_tab1" data-toggle="tab">Target Vs Achievement</a></li>

                           </ul>

                      <!-- ADD user START --> 
                           <div class="tab-content">
                              <div class="tab-pane active" id="portlet_tab1">
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post" class="form-horizontal">
                                <input type="hidden" name="delid" value="<?php echo $delid?>">                                        
                                 
                <div class="control-group">
                  <table class="table-striped table-hover table-bordered" width="50%">
                        <tr align="center">
                            <td colspan="3">
                            	<h4> Employee Name: <?php echo $emp_name?></h4>
                             </td>
                        </tr>
                        
                         <tr align="center">       
                            <td colspan="3">
                            	<h4> Target Vs Achievement for FY - (<?php echo $fy?>) </h4>
                             </td>
                        </tr>
    
                        <tr align="center">
                            <th>Month</th><th>Target (In INR)</th> <th>Achievement ( In INR)</th>  
                        </tr>
    

        <tr align="center">
            <td>April </td> 
            <td><input type="number"  style="width:100px;" name="apr_tgt" value="<?php echo $targetArray['apr_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="apr_ach" value="<?php echo $achievementArray['apr_ach']?>"/></td>
        </tr>

        <tr align="center">
            <td>May </td> 
            <td><input type="number"  style="width:100px;" name="may_tgt" value="<?php echo $targetArray['may_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="may_ach" value="<?php echo $achievementArray['may_ach']?>"/></td>
        </tr>

        <tr align="center">
            <td>June </td> 
            <td><input type="number"  style="width:100px;" name="jun_tgt" value="<?php echo $targetArray['jun_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="jun_ach" value="<?php echo $achievementArray['jun_ach']?>"/></td>

        </tr>

        <tr align="center">
            <td>July </td> 
            <td><input type="number"  style="width:100px;" name="jul_tgt" value="<?php echo $targetArray['jul_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="jul_ach" value="<?php echo $achievementArray['jul_ach']?>"/></td>
        </tr>

        <tr align="center">
            <td>August </td> 
            <td><input type="number"  style="width:100px;" name="aug_tgt" value="<?php echo $targetArray['aug_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="aug_ach" value="<?php echo $achievementArray['aug_ach']?>"/></td>
        </tr>

        <tr align="center">
            <td>September </td> 
            <td><input type="number"  style="width:100px;" name="sep_tgt" value="<?php echo $targetArray['sep_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="sep_ach" value="<?php echo $achievementArray['sep_ach']?>"/></td>
        </tr>

        <tr align="center">
            <td>October </td>
            <td><input type="number"  style="width:100px;" name="oct_tgt" value="<?php echo $targetArray['oct_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="oct_ach" value="<?php echo $achievementArray['oct_ach']?>"/></td>
        </tr>

        <tr align="center">
            <td>November </td> 
            <td><input type="number"  style="width:100px;" name="nov_tgt" value="<?php echo $targetArray['nov_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="nov_ach" value="<?php echo $achievementArray['nov_ach']?>"/></td>
        </tr>

        <tr align="center">
            <td>December </td> 
            <td><input type="number"  style="width:100px;" name="dec_tgt" value="<?php echo $targetArray['dec_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="dec_ach" value="<?php echo $achievementArray['dec_ach']?>"/></td>
        </tr>

                          <tr align="center">
            <td>January </td> 
            <td><input type="number"  style="width:100px;" name="jan_tgt" value="<?php echo $targetArray['jan_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="jan_ach" value="<?php echo $achievementArray['jan_ach']?>"/></td>
            
        </tr>

        <tr align="center">
            <td>February </td>
            <td><input type="number"  style="width:100px;" name="feb_tgt" value="<?php echo $targetArray['feb_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="feb_ach" value="<?php echo $achievementArray['feb_ach']?>"/></td>
        </tr>

        <tr align="center">
            <td>March </td> 
            <td><input type="number"  style="width:100px;" name="mar_tgt" value="<?php echo $targetArray['mar_tgt']?>"/></td> 
            <td><input type="number"  style="width:100px;" name="mar_ach" value="<?php echo $achievementArray['mar_ach']?>"/></td>
        </tr>

                  
                    </table>
                   </div>
                </div>  
                                 
            
                                    <div class="form-actions">
                                       <button type="submit" name="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <a href="user-management.php"><button type="button" class="btn">Back</button></a>
                                    </div>
                                 </form>
                                 <!-- ADD user ENDS -->  
                              </div>
                                
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
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