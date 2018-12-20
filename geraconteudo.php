<?php 
include('includes/class.php');
		session_start();
		$login = new login();
		$login->session($_SESSION);
		$login->checklogin();
		$load = (isset($_GET['file'])?decode($_GET['file']):decode($_GET['f']));
		
include($load);
?>
