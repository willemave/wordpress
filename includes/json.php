<?php 
	$data = array();
	$data['service_id'] = '123456789';
	$data['email'] = $_GET['email'];
	echo $_GET['jsoncallback'] . '('. json_encode($data). ')';
 ?>