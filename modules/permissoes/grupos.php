<button onclick="JAVASCRIPT:divCentral.carrega('gera.php&formid=1');" style="float:right;">Inserir grupo</button>
<table width="100%">
	<tr>
    	<td width="60%"><?php include('modules/seguranca/list_grupos.php'); ?></td>
        <td><?php include('modules/seguranca/forms/pesq_grupos.php'); ?></td>
    </tr>
</table>
<?php $_GET['src'] = (isset($_GET['src']))?$_GET['src']:'geraconteudo.php?file=modules/relations/dd_hander.php'; ?>
<?php include('modules/seguranca/grupo_tabs.php'); ?>