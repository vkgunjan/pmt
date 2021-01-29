<?php
			 include_once('including/all-include.php');

					$lq="top_five_account";
					$le=odbc_exec($conn,$lq);
					while($lv=odbc_fetch_array($le)){
						echo '<pre>';
						print_r($lv);
					}
					
					

setcookie("test-cookie", "hello cookie", time() + (86400 * 30), "/");

print_r($_COOKIE);

				
					
					
					
?>