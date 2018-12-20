<?PHP
 include('../../includes/class.php'); 
 $debug = false;
?>
<pre>
<?php
	$ed = 0;
	$bd = new bd();
	foreach ($_POST as $chave=>$valor) {
		$duplas = explode('@',$chave);
		$ed = ($duplas[0] == 'cond')?1:$ed;
		$_POST[$chave] = iconv('utf-8','iso-8859-1',$valor);
	}
	
	if (isset($_POST['cfg_usuario@senha'])){
		$_POST['cfg_usuario@senha'] = md5($_POST['cfg_usuario@login'].$_POST['cfg_usuario@senha']);
	}
	
	if ($ed == 1) {
		$ebug['act.php'] = ($debug)?'Editando ...<hr>':'';
		$bd->altera($_POST);
	} else {
		$ebug['act.php'] = ($debug)?'Inserindo ...<hr>':'';
		$bd->insere($_POST);
	}
	$ebug['act.php'] = ($debug)?$bd->get_sql():'';
	print_r($ebug);
?></pre>
<script>
	<?=($debug)?'':'history.back()'?>
</script>
