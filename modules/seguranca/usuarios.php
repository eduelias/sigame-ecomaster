<?php $_GET['formid']=3;?> 
<?php echo ($login->permissoes(2,'inserir'))?'<button onclick="JAVASCRIPT:divCentral.carrega(\'gera.php&formid=3\');" style="float:right;">INSERIR</button>':'';?>
<?php include('modules/seguranca/list_usuario.php'); ?>
