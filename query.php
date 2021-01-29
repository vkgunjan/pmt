<?php

if(trim($_SESSION['user_type'])=='management') {
			$sp_ap="SELECT  COUNT(*) as totalsample,  sum(obl_sale_forecast_inr) as project  FROM opportunity where [sampling_status] ='2' ";

			}else{
			$sp_ap="SELECT  COUNT(*) as totalsample,  sum(obl_sale_forecast_inr) as project  FROM opportunity where [sampling_status]='2' and created_by='".$_SESSION['uid']."' ";
			
			
			}
					$qtapp_exe=odbc_exec($conn,$sp_ap);
					$spl_appp=odbc_fetch_array($qtapp_exe);
					
					if($spl_appp['totalsample']>0){
						$sppp_app=$spl_appp['project']/$spl_appp['totalsample'];
					}else{
						$sppp_app=0;
					}



if(trim($_SESSION['user_type'])=='management') {
			$sp_app="SELECT  COUNT(*) as totalsample,  sum(obl_sale_forecast_inr) as project  FROM opportunity where [sampling_status] ='2' ";

			}else{
			$sp_app="SELECT  COUNT(*) as totalsample,  sum(obl_sale_forecast_inr) as project  FROM opportunity where [sampling_status]='2' and created_by='".$_SESSION['uid']."' ";
			
			
			}
					$spapp_exe=odbc_exec($conn,$sp_app);
					$spp_app=odbc_fetch_array($spapp_exe);
					
					if($spp_app['totalsample']>0){
						$spl_app=$spp_app['project']/$spp_app['totalsample'];
					}else{
						$spl_app=0;
					}





?>