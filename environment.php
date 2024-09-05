<?php
	if(! defined('ENVIRONMENT') )
	{
		$domain = strtolower($_SERVER['HTTP_HOST']);
		switch($domain) {
			case 'admin.prashanshabakery.com' : 						define('ENVIRONMENT', 'production'); 	break;
			case 'admin.prashanshabakery.com' : 						define('ENVIRONMENT', 'production'); 	break;
			case 'admin.prashanshabakery.com': 		define('ENVIRONMENT', 'staging'); 		break;
			default : 									define('ENVIRONMENT', 'development'); 	break;
		}
	}
?>