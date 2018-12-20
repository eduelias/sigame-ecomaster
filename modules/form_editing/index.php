<?php
if ($errorlogin) { echo "<script> window.location = 'error.php' ; </script>"; };
?>

<head>
<script>
	var senha;
	var usuario;
	function seta_pass(alfafa){
		senha = alfafa.value;
	}
	function checa_pass(alfa2){
		usuario = document.getElementById('login');
		alfa2.value = (senha == alfa2.value)?alfa2.value:'';
	}
</script>
<!-- YUI -->  
    <!-- Core + Skin CSS -->
    <link rel="stylesheet" type="text/css" href="includes/yui/2.5/build/menu/assets/skins/sam/menu.css">
    
    <!-- Dependencies --> 
    <script type="text/javascript" src="includes/yui/2.5/build/yahoo-dom-event/yahoo-dom-event.js"></script>
    <script type="text/javascript" src="includes/yui/2.5/build/container/container_core-min.js"></script>
    
    <!-- Source File -->
    <script type="text/javascript" src="includes/yui/2.5/build/menu/menu-min.js"></script>
    
    
<!-- SPRY -->
<script src="includes/SpryAssets/textfieldvalidation/SpryValidationTextField.js" type="text/javascript"></script>
<link href="includes/SpryAssets/textfieldvalidation/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="includes/SpryAssets/selectvalidation/SpryValidationSelect.js" type="text/javascript"></script>
<link href="includes/SpryAssets/selectvalidation/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="includes/SpryAssets/passwordvalidation/SpryValidationPassword.js" type="text/javascript"></script>
<link href="includes/SpryAssets/passwordvalidation/SpryValidationPassword.css" rel="stylesheet" type="text/css">



<!-- PRÓPRIAS SIGAME -->
<link href="templates/css/forms.css" rel="stylesheet" type="text/css">
<link href="templates/css/tables.css" rel="stylesheet" type="text/css">

<style>
	body { margin:0; padding:0; }
</style>

<title>SIGAME - InfoHelp!</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body class="yui-skin-sam" id="yahoo-com">
<?php
	$login = new login();
	$login->session($_SESSION);
	$login->checklogin();
?>
<div style="float:left"><?php //include('modules/form_editing/menu.php'); ?></div>
<?php
$f = $_GET['f_edit'];
if (isset($_GET['f_edit'])) { $f = $_GET['f_edit']; } else { $f = 'list_form.php'; }
include($f); 
?>
</body>
</html>