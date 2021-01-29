<?php


 

          if(trim($_SESSION['user_type'])=='management') {
		  $hsqa="select count(*) as no, t.stage_name as opportunityname from opportunity d
					left join pmt_current_stage t on t.stage_id = d.current_stage
					where year(d.added_date) = '2017' and d.status <> 'lost' group by t.stage_name";
	}else{
			
		$hsqa="select count(*) as no, t.stage_name from opportunity 
		left join pmt_current_stage t on t.stage_id = d.current_stage 
		left join cka_name_master a on a.cka_name_id = d.cka_name_id 
		where year(d.added_date) = '2017'";


    if(trim($_SESSION['user_type'])=='management') {
		$hsqa.="  where d.status<>'lost' group by t.stage_name";
	}else{

			if($_SESSION['employee_department']=='Retail'){
				$hsqa.=" where d.deal_type='Retail' 
						and d.territory in (".$_SESSION['employee_territory'].") 
						group by t.stage_name ";
			}


			if($_SESSION['employee_department']=='CKA'){

					if($_SESSION['user_type']=='manager'){
					
					$hsqa.=" where d.status<>'lost' 
						and ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$hsqa .="a.cka_mapped_with_emp = '".$vx."' ";
							else
								$hsqa .=" or a.cka_mapped_with_emp = '".$vx."' ";
							$xcnt++;
						}
						$hsqa .=" )group by t.stage_name ";
					}else{
						$hsqa.=" where ( d.deal_type='CKA') and ( ";

						$ex=explode(",",$_SESSION['emp_cka_mapping']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$hsqa .="d.cka_name_id = '".$vx."' ";
							else
								$hsqa .=" or d.cka_name_id = '".$vx."' ";
							$xcnt++;
						}

						$hsqa .=" )group by t.stage_name ";
					}

				//echo $sql;
			}

			if($_SESSION['employee_department']=='BD' || $_SESSION['employee_department']=='GPS'){
					
					if($_SESSION['user_type']=='manager'){
					$hsqa.=" where d.status<>'lost' 
						and ( ";

						$ex=explode(",",$_SESSION['my_team_id']);
							$xcnt=0;
						foreach ($ex as $vx){
						//echo $vx;
							if($xcnt==0)
								$hsqa .="d.created_by = '".$vx."' or d.created_by='".$_SESSION['uid']."' ";
							else
								$hsqa .=" or d.created_by = '".$vx."' ";
							$xcnt++;
						}
						$hsqa .=" )group by t.stage_name ";
					}else{
						$hsqa.="  where d.created_by='".$_SESSION['uid']."' 
						group by t.stage_name ";	
					}

			}
		
	}

	
	}

					
					$yearprevious=odbc_exec($conn,$hsqa);
					
			?>