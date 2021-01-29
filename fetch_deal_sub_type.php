<?php 
	session_start();
	include('including/connect.php');
	$territoryId = $_SESSION['employee_territory'];

	$dealType = $_GET['deal'];
	$project = $_GET['project'];
	$account = $_GET['cust'];
	$arch = $_GET['arch'];
	$contact = $_GET['contact'];
	$archi = $_GET['archi'];

	

	

	if($dealType!=""){
		
		$query = "SELECT * from deal_sub_type WHERE deal_type_id = $dealType";
		$result = odbc_exec($conn, $query);
		$output = '';
		echo '<option>-Select-</option>';
		while($row = odbc_fetch_array($result)){
			$output .= '<option value = "'.$row['deal_sub_type_id'].'">'.$row['deal_sub_type'].'</option>';
		}

		echo $output;
	}

	

	if($project!=""){
		
		$query = "SELECT * from project_sub_type_master WHERE project_type_id = $project";
		$result = odbc_exec($conn, $query);
		$output = '';
		/*echo '<option>-Select-</option>';*/
		while($row = odbc_fetch_array($result)){
			$output .= '<option value = "'.$row['project_sub_type_id'].'">'.$row['project_sub_type'].'</option>';
		}

		echo $output;
	}

	if($account!=""){
		
		if($account == 13){
			$query = "SELECT * from cka_name_master WHERE account_type = $account and cka_status = 1 and cka_territory = $territoryId order by cka_name asc";
		$result = odbc_exec($conn, $query);
		$output = '';
		echo '<option>-Select-</option>';
		while($row = odbc_fetch_array($result)){
			$output .= '<option value = "'.$row['cka_name_id'].'">'.$row['cka_name'].'</option>';
		}
		}else{
		$query = "SELECT * from cka_name_master WHERE account_type = $account and cka_status = 1 order by cka_name asc";
		$result = odbc_exec($conn, $query);
		$output = '';
		echo '<option>-Select-</option>';
		while($row = odbc_fetch_array($result)){
			$output .= '<option value = "'.$row['cka_name_id'].'">'.$row['cka_name'].'</option>';
		}	
		}

		echo $output;
	}



	if($arch!=""){
		
		$query = "SELECT cka_id, arch_name from cka_visit where cka_id = $arch";
		$result = odbc_exec($conn, $query);
		$output = '';
		echo '<option value="">-Select-</option>';
		while($row = odbc_fetch_array($result)){
			$output .= '<option value = "'.$row['arch_name'].'">'.$row['arch_name'].'</option>';
		}

		echo $output;
	}

	if($contact!="" && $archi!=""){
		
		$query = "SELECT cka_id, arch_name, arch_contact_no from cka_visit where arch_name = '".$contact."' and cka_id = $archi";
		$result = odbc_exec($conn, $query);
		$output = '';
		/*echo '<option>-Select-</option>';*/
		while($row = odbc_fetch_array($result)){
			$output .= $row['arch_contact_no'];
		}

		echo $output;
	}


	
	
	
?>