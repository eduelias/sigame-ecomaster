<?PHP
 include('../../includes/class.php'); 
 $debug = false;
?>

<?	
	($debug)?pre($_POST):0;
	$aux = explode('_',$_POST['impacto']);
	array_pop($_POST);
	
	$bd = new bd();
	$sum = 0;
	foreach ($_POST as $k => $v){
		$sql[] = 'DELETE FROM empresa_teste1.tb_significancia_pontuacao WHERE idprocesso = '.$aux[0].' AND idatividade = '.$aux[1].' AND idaspecto_ambiental ='.$aux[2].' AND idimpacto = '.$aux[3].' AND idsignificancia_impactos ='.$k;
		$sq = 'INSERT INTO empresa_teste1.tb_significancia_pontuacao (idprocesso,idatividade,idaspecto_ambiental,idimpacto,idsignificancia_impactos, pontuacao, data) values ("'.$aux[0].'","'.$aux[1].'","'.$aux[2].'","'.$aux[3].'","'.$k.'", "'.$v.'", "'.date('Y-m-d').'")';
		
		$sql[] = 'INSERT INTO empresa_teste1.tb_significancia_pontuacao (idprocesso,idatividade,idaspecto_ambiental,idimpacto,idsignificancia_impactos, pontuacao, data) values ("'.$aux[0].'","'.$aux[1].'","'.$aux[2].'","'.$aux[3].'","'.$k.'", "'.$v.'", "'.date('Y-m-d').'")';
		//$sql[] = $sq;
		$bd->send_sql('INSERT INTO `web4_db2`.`tb_log` (`SQL`) VALUES ("'.$sq.'");');
		$sum += $v;
	}
		$v = $aux;
		$sql[] = 'UPDATE empresa_teste1.rel_ambiental SET significancia = '.$sum.' WHERE idprocesso = '.$v[0].' AND idatividade = '.$v[1].' AND idaspecto_ambiental = '.$v[2].' AND idimpacto = '.$v[3];
	echo $sum;
	pre($sql);
	foreach($sql as $k => $v){
		$bd->send_sql('INSERT INTO `web4_db2`.`tb_log` (`SQL`) VALUES ("'.$v.'");');
		($debug)?pre($v):$bd->send_sql($v);
	}
	

?>