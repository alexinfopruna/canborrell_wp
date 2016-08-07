<?php
	function error_handler($errno, $errstr, $errfile, $errline, $errctx) {
                              error_log("ldldl");
	}

	set_error_handler("error_handler");
	//ini_set ('error_reporting', E_ALL);
	error_reporting(E_ALL);  
?>