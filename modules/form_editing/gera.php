<?php
$formid = "1";
if (isset($_GET['formid'])) {
  $formid = $_GET['formid'];
}

	$formulario = new form();
	$recordID = (isset($_GET['recordID']))?$_GET['recordID']:0;
	$formulario->imprime($formid,$recordID);
?>


