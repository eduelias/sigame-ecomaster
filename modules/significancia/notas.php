<?
include('../../includes/class.php'); 
$bd = new bd();
$idstr = $_GET['ID'];
$idarr = explode('_',$idstr);

$sql = 'select ra.idprocesso as idp, idatividade as ida, idaspecto_ambiental as idaa, idimpacto as idi, CONCAT(ra.idprocesso,"_",idatividade,"_",idaspecto_ambiental,"_",idimpacto) as ID';
$sqa = 'ra.idprocesso as idp, idatividade as ida, idaspecto_ambiental as idaa, idimpacto as idi, CONCAT(ra.idprocesso,"_",idatividade,"_",idaspecto_ambiental,"_",idimpacto) as ID';


$result = $bd->gera_array('idsignificancia_impactos as isi, label','web4_db2.tb_significancia_impactos as tsi','true');

foreach ($result as $k => $v){
	$sqa .= ',(select CONCAT("<td>'.iconv('iso-8859-1','utf-8',$v['label']).':</td><td>",pontuacao,"</td>") from empresa_teste1.tb_significancia_pontuacao as tsp where tsp.idprocesso = idp and tsp.idatividade = ida and tsp.idaspecto_ambiental = idaa and tsp.idimpacto = idi and tsp.idsignificancia_impactos = '.$v['isi'].') as `SIG'.$v['isi'].'`';
}
$sqa .= ',(select SUM(pontuacao) as sssssss from empresa_teste1.tb_significancia_pontuacao as tsp where tsp.idprocesso = idp and tsp.idatividade = ida and tsp.idaspecto_ambiental = idaa and tsp.idimpacto = idi) as SOMA';
$sql .= ' from empresa_teste1.rel_ambiental as ra HAVING idp = 3 AND ida = 12 AND idaa = 413 AND idi <> 0';


$rs = $bd->gera_array($sqa,'empresa_teste1.rel_ambiental as ra ','TRUE HAVING idp = '.$idarr[0].' AND ida = '.$idarr[1].' AND idaa = '.$idarr[2].'  AND idi ='.$idarr[3].' ');
	$json = new Services_JSON();
	$data = $json->encode($rs);
//echo $bd->get_sql();
	echo $data;
?>
	