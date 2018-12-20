<?
	
	include("includes/class.php");
	header("Content-Type: text/html;charset=iso-8859-1");
	
	//pre($_POST);
	
	session_start(); 
	session_register(array('SID'=>md5($_POST['usuario'].$_POST['senha'])));
	//print_r($_POST);
	$login = new login();
	$login->form($_POST);
	$login->encodesenha();
	
	echo $login->getusuario;

	$login->checklogin();
	//print_r($_SESSION);
	//include('index.php');
	echo "<script>window.location= 'index.php';</script>";
	
?>