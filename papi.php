
<?php
    include_once('including/all-include.php');
	$timestamp=date('Y-m-d H:i:s');
//print_r($_GET);

//	header('location:project-action-plan.php');
//	exit();

		 $ssql="select *  from project_action_plan where opportunity_id='".$_GET['pid']."'";
		$rss=odbc_exec($conn,$ssql);
		 $nrr=odbc_num_rows($rss);

if($nrr>0){
		$qrry="update project_action_plan set ".$_GET['id']." = '".$_GET['val']."', 
		added_by = '".$_SESSION['uid']."' , last_modified ='".$timestamp."'  where opportunity_id = '".$_GET['pid']."' ";
}else{
				$qrry="INSERT INTO project_action_plan(opportunity_id , ".$_GET['id']." , added_by , last_modified )";
				$qrry.="values('".$_GET['pid']."', '".$_GET['val']."', '".$_GET['pid']."', '".$timestamp."' ) ";
}
				//echo $qrry;
				$stmtt = odbc_prepare($conn, $qrry);
				if (odbc_execute($stmtt)){ 
						
				}
	

?>
