<?php
	pre($_GET);
	
	$rel = new relacoes($_GET['ca'],$_GET['cb'],$_GET['id1'],$_GET['id2'],$_GET['tb_rel'],$_GET['tb_b'],$_GET['emp']);
	$rel->rel($_GET['ca'],$_GET['cb'],$_GET['id1'],$_GET['id2'],$_GET['tb_rel'],$_GET['emp']);
	if ($_GET['act'] == 'ul1'){
		$rel->cria_relacao();
	} else {
		$rel->destroi_relacao();
	}
	echo $rel->sql;
?>