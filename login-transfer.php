 <?php

	if(!isset($_SESSION)){
		session_start();
	}

	include_once('including/connect.php');
	include_once('including/functions.php');	

	unset($_SESSION['backuid']);
	unset($_SESSION['uid']);
	unset($_SESSION['user_type']);
	unset($_SESSION['maintenance_type']);
	unset($_SESSION['fullname']);
	unset($_SESSION['factory-id']);
	unset($_SESSION['multi_location']);
	unset($_SESSION['login-factory']);
	unset($_SESSION['software-name']);

	unset($_SESSION['employee_territory']);
	unset($_SESSION['employee_department']);
	unset($_SESSION['emp_cka_mapping']);

	//include_once('including/all-include.php');
	//print_r($_SESSION);


if(isset($_GET['check']) && base64_decode($_GET['check'])=='true' ){
	
		$_SESSION['backuid']	=	$_GET['ODvalueID'];

if(isset($_GET['back']) && base64_decode($_GET['check'])=='true' ){
	
		 $ss="select * from user_management u where uid='".dbInput($_GET['ODvalueID'])."' and emp_status = 1";
}else{
		 $ss="select * from user_management u where uid='".dbInput($_GET['valueID'])."' and emp_status = 1";
}

	$c=odbc_exec($conn, $ss);
	$n=odbc_num_rows($c);
	$f=odbc_fetch_array($c);

	if(!$n){
		header('location:index.php?login-fail=true');
		exit;
	}
	
	
	
	$_SESSION['uid']					=	trim($f['uid']);
	
	$_SESSION['user_type']				=	trim($f['user_type']);
	$_SESSION['maintenance_type']		=	trim($f['maintenance_type']);
	$_SESSION['maintenance_type_name']	=	trim($f['maintenance_type_name']);
	$_SESSION['fullname']				=	trim($f['fullname']);
	$_SESSION['factory-id']				=	trim($f['factory_id']);
	$_SESSION['multi_location']			=	trim($f['multi_location']);
	$_SESSION['login-factory']			=	trim($f['factory_name']);

	$_SESSION['employee_territory'] = 		trim($f['employee_territory']);
	$_SESSION['employee_department'] = 		trim($f['employee_department']);
	
	$_SESSION['software-name']			=	trim('Pipeline Management Tool');
	

		if($f['employee_department']=='CKA'){
	
	 		$ckam="select * from cka_name_master where cka_mapped_with_emp='".trim($f['uid'])."' and emp_status = 1";
			$ckae=odbc_exec($conn, $ckam);
			$n=odbc_num_rows($ckae);
			$cnt=0;
			while($ff=odbc_fetch_array($ckae))
			{

				if($cnt==0){
					$emp_cka_mapping =$ff['cka_name_id'];
				}else{
					$emp_cka_mapping .=','.$ff['cka_name_id'];
				}
					$cnt++;							
			}
			//echo '<br><br>';
			//echo $emp_cka_mapping;
//			print_r($ckaf);
			$_SESSION['emp_cka_mapping'] = 		trim($emp_cka_mapping);

		}

	 		echo $vckam="select * from user_management where parent_id='".trim($f['uid'])."' and emp_status = 1 ";
			$vckae=odbc_exec($conn, $vckam);
			$vn=odbc_num_rows($vckae);
			$vcnt=0;
			while($vff=odbc_fetch_array($vckae))
			{

				if($vcnt==0){
					$vemp_cka_mapping =$vff['uid'];
				}else{
					$vemp_cka_mapping .=','.$vff['uid'];
				}
					$vcnt++;							
			}
			//echo '<br><br>';
			//echo $emp_cka_mapping;
//			print_r($ckaf);
if($f['uid']==2015){
//echo '<br><br><br>hello</br>';
	$gpsq="select uid from user_management where employee_department='GET' and uid <> '2015' and emp_status = 1 ";
	$gpscnt=0;
	$gpsexe=odbc_exec($conn, $gpsq);
	while($fr=odbc_fetch_array($gpsexe)){
		//$gpscnt=odbc_num_rows($fr);
		if($gpscnt==0){
			$myteam = $fr['uid'];		
		}else{
			$myteam .= ','.$fr['uid'];		
		}
		$gpscnt++;	
	}
//	$_SESSION['my_team_id'] = 	'2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2089,2094';
	$_SESSION['my_team_id'] = $myteam;
	
}elseif($f['uid']==2006){
//echo '<br><br><br>hello</br>';
	$gpsq="select uid from user_management where employee_department='PET' and uid <> '2006' and emp_status = 1";
	$gpscnt=0;
	$gpsexe=odbc_exec($conn, $gpsq);
	while($fr=odbc_fetch_array($gpsexe)){
		//$gpscnt=odbc_num_rows($fr);
		if($gpscnt==0){
			$myteam = $fr['uid'];		
		}else{
			$myteam .= ','.$fr['uid'];		
		}
		$gpscnt++;	
	}
//	$_SESSION['my_team_id'] = 	'2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2089,2094';
	$_SESSION['my_team_id'] = $myteam;
	
}elseif($f['uid']==2113){
//echo '<br><br><br>hello</br>';
	$gpsq="select uid from user_management where employee_department='SET' and uid <> '2113' and emp_status = 1";
	$gpscnt=0;
	$gpsexe=odbc_exec($conn, $gpsq);
	while($fr=odbc_fetch_array($gpsexe)){
		//$gpscnt=odbc_num_rows($fr);
		if($gpscnt==0){
			$myteam = $fr['uid'];		
		}else{
			$myteam .= ','.$fr['uid'];		
		}
		$gpscnt++;	
	}
//	$_SESSION['my_team_id'] = 	'2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2089,2094';
	$_SESSION['my_team_id'] = $myteam;
	
}elseif($f['uid']==2116){
//echo '<br><br><br>hello</br>';
	$gpsq="select uid from user_management where employee_department='CTU' and uid <> '2116' and emp_status = 1";
	$gpscnt=0;
	$gpsexe=odbc_exec($conn, $gpsq);
	while($fr=odbc_fetch_array($gpsexe)){
		//$gpscnt=odbc_num_rows($fr);
		if($gpscnt==0){
			$myteam = $fr['uid'];		
		}else{
			$myteam .= ','.$fr['uid'];		
		}
		$gpscnt++;	
	}
//	$_SESSION['my_team_id'] = 	'2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2089,2094';
	$_SESSION['my_team_id'] = $myteam;
	
}

else{
		$_SESSION['my_team_id'] = 		trim($vemp_cka_mapping);
}
		
	
	//print_r($_SESSION);
	
		header('location:list-all-lead.php');
		exit;

		//print_r($_SESSION);

	 
}		


	?>
