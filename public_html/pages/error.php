<?php
if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }
?>
			<div class="row justify-content-center">
				<div class="col">
					<div class="alert alert-warning" style="margin-top:20px">
					 
					  <p><strong><i class="fas fa-exclamation-triangle"></i> WARNING!</strong><br/> Military Clearance Required. Top Secret Content</p>
					  <p class="small">You are strongly advised to use meny navigation on the left, or <strong>leave this page</strong> immediately!
					  <strong>Military Police</strong> already is checking your IP Adress: <?=$ip_address;?></p>					  
					</div>
				</div>
			</div>