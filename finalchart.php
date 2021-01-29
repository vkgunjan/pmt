if(trim($_SESSION['user_type'])=='management') {
		  $hsqa="SELECT t.stage_name as opportunityname, COUNT(*) as no, sum(o.obl_sale_forecast_inr) as project, sum(o.won_po_value) as won_po_value FROM opportunity o
				 left join pmt_current_stage t on t.stage_id = o.current_stage
  
				 where o.status<>'lost' and o.state_id is not null GROUP BY t.stage_name";
	}else{
			//$headersql="SELECT count(*) as headercnt,sum(obl_sale_forecast_inr) as fcast, current_stage FROM [opportunity]   
			//			where created_by='".$_SESSION['uid']."' and [status]='open' group by current_stage  ";

		//vineet start
		$hsqa="SELECT count(*) as no,sum(d.obl_sale_forecast_inr) as project, sum(d.won_po_value) as won_po_value, t.stage_name as opportunityname FROM [opportunity] d
left join cka_name_master a on a.cka_name_id = d.cka_name_id
left join pmt_current_stage t on t.stage_id = d.current_stage
 ";


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

						$hsqa .=" )and d.status <> 'lost' group by t.stage_name ";
					}

				//echo $sql;
			}

			if($_SESSION['employee_department']=='BD' || $_SESSION['employee_department']=='GPS'){
					
					if($_SESSION['user_type']=='manager'){
					$hsqa.=" where d.status<>'lost' and d.state_id is not null 
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
						$hsqa.="  where d.status<>'lost' and d.state_id is not null and d.created_by='".$_SESSION['uid']."' 
						group by t.stage_name ";	
					}

			}
		
	}

		//vineet ends
	}