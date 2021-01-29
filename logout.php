<?php
	include_once('including/all-include.php');
	
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
	
	unset($_SESSION['rootuser']);


header('location:index.php');
exit;

?>