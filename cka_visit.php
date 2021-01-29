
<?php
include_once('including/all-include.php');
$timestamp=date('Y-m-d H:i:s');
//$lead_id=$_GET['pid'];

//print_r($_GET);
//exit;

if(isset($_POST['cka_name_id'])){
		$uid = $_SESSION['uid'];
		$cka_name_id=$_POST['cka_name_id'];
		$arch_name=$_POST['arch_name'];
      	$arch_designation=$_POST['arch_designation'];
      	$arch_contact_no=$_POST['arch_contact_no'];
      	$arch_email_id=$_POST['arch_email_id'];
      	$arch_visit_date=$_POST['arch_visit_date'];
      	$arch_visit_remarks=$_POST['arch_visit_remarks'];

      	/*print_r($_POST);
      	exit;*/
	
	/*$_SESSION['cka_name_id']=$cka_name_id;*/	
	
$insert  ="INSERT INTO cka_visit(cka_id, arch_name, arch_designation,arch_contact_no, arch_email_id,arch_visit_date,arch_visit_remarks, arch_added_by,arch_updated_on,arch_status)";
				$insert .="values('".$cka_name_id."', '".$arch_name."', '".$arch_designation."', '".$arch_contact_no."', '".$arch_email_id."',  '".$arch_visit_date."',   '".$arch_visit_remarks."', '".$_SESSION['uid']."',  '".$timestamp."','1' ) ";

			//	echo $insert;
				$stmt = odbc_exec($conn, $insert);
				

}
?>



	                                   
<?php 



//echo 'hello';
//print_r($_GET);
if(isset($_POST['cka_name_id']) && $_POST['cka_name_id'] > 0 ){
/*alert($_POST['cka']);*/
 $ssql="select * from cka_visit where cka_id='".$_POST['cka_name_id']."' ";	
}else{
 $ssql="select * from cka_visit where cka_id='".$_POST['cka_list_id']."'";	
}
$rs=odbc_exec($conn,$ssql);
 $vp=odbc_num_rows($rs);

//$_SESSION['atc']=$vv;

$output = '<table class="table table-striped table-bordered table-hover" >

		<tr>
        <th>Architect Name</th>
        <th>Designation</th>
        <th>Contact No</th>
        <th>Email ID</th>
        <th>Visit Date</th>
        <th>Remarks</th>
        <th>Updated By</th>
        <th>Update On</th>
	   
        </tr>';

while($f = odbc_fetch_array($rs)){
//print_r($f);

$output .= '<tr align="center">';
$output .= '<td>'.$f['arch_name'].'</td>';
$output .= '<td>'.$f['arch_designation'].'</td>';
$output .= '<td>'.$f['arch_contact_no'].'</td>';
$output .= '<td>'.$f['arch_email_id'].'</td>';
$output .= '<td>'.date('d-m-Y',strtotime(trim($f['arch_visit_date']))).'</td>';
$output .= '<td>'.$f['arch_visit_remarks'].'</td>';
$eq1="select fullname from user_management where uid='".$f['arch_added_by']."' ";
$eqe1=odbc_exec($conn,$eq1);
$eqf1=odbc_fetch_array($eqe1);
$output .= '<td>'.$eqf1['fullname'].'</td>';
$output .= '<td>'.date('d-m-Y',strtotime(trim($f['arch_updated_on']))).'</td>';
$output .= '</tr>';
}

$output .= '</table>';


echo $output;

?>
