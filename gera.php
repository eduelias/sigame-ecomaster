<?php

if (!headers_sent()){ header("Content-Type: text/html;charset=iso-8859-1"); }
$formid = "1";
if (isset($_GET['formid'])) {
  $formid = $_GET['formid'];
}

$id = (isset($_GET['id']))?$_GET['id']:0;

	$formulario = new form();
	$recordID = (isset($_GET['recordID']))?$_GET['recordID']:$id;
	$formulario->imprime($formid,$recordID);
	echo $formulario->spt;
?>