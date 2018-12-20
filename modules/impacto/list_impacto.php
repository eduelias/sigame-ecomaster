<?php
	//Cria a página
	$pagina = new pagina("impacto");
	$padrao = 'impacto';
$bd = new bd();
	if (isset($_GET['ID'])){
		echo '<script> WBS.MID = "'.$_GET['ID'].'";  </script>';
		$em = new empresa();
		$result = $em->getImpacto($_GET['ID']);
		$str ="<script> WBS.IDs = new Array();\r\n";
		
		if (is_array($result)){
			foreach ($result as $k => $v){
				$aux = explode('_',$v['ID']);
				$str .= "WBS.IDs[".$aux[3]."] = true;\r\n";
			}
		} else if (count($result) == 1) {
			$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs[".$aux[3]."] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	}
	$editar = ($login->permissoes(10,'editar'))?true:false;
	$deletar = ($login->permissoes(10,'deletar'))?true:false;
	$inserir = ($login->permissoes(10,'inserir'))?true:false;
	
	$ids = explode('_',$_GET['ID']);
	$tabela = 'web4_db2.tb_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = "NOT ".$idtabela." = 0";
	//$titulo = "Listagem de ".$padrao."s";
	$campos = "web4_db2.tb_".$padrao.".id".$padrao.' as id, CONCAT(%27'.$_GET[ID].'_%27, web4_db2.tb_'.$padrao.".id".$padrao.") as ida, web4_db2.tb_".$padrao.'.*, (select MAX(significancia) from empresa'.$BDEMPRESA.'.rel_ambiental where idprocesso = '.$ids[0].' AND idatividade = '.$ids[1].' AND idaspecto_ambiental = '.$ids[2].' AND idimpacto = id) as XX';
	
	$result = $bd->gera_array('idsignificancia_impactos as isi, abrev as label','web4_db2.tb_significancia_impactos as tsi','true');
$counter = count($result);
foreach ($result as $k => $v){
	$campos.= ',(select pontuacao from empresa_teste1.tb_significancia_pontuacao as tsp where  idprocesso = '.$ids[0].' AND idatividade = '.$ids[1].' AND idaspecto_ambiental = '.$ids[2].' AND idimpacto = id and tsp.idsignificancia_impactos = '.$v['isi'].') as `SIG'.$v['isi'].'`';
}

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addIDInsert('impacto'):'';
	($inserir)?$pagina->grid->addInsert(16):'';
	
	//Adiciona as colunas açoes e eventos 
	
	$pagina->grid->AddColuna('id', "", "checkbox", "20", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	$pagina->grid->AddColuna('XX', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatAlerta");
	$pagina->grid->AddAcao("editById", encode("modules/significancia/gera_form.php"), 'ida');
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "400","");
	foreach ($result as $k => $v){
		$pagina->grid->AddColuna('SIG'.$v['isi'],$v['label'],"","30");
	}
	$pagina->grid->AddColuna('XX', "Total", "string", "25","");
	
	$pagina->grid->AddAcao("listOut", encode("modules/criterios_pertinentes/list_criterios_pertinentes.php"), 'ida');
	
	($editar)?$pagina->grid->AddAcao("open_form","16"):"";
	($deletar)?$pagina->grid->AddAcao("delete", "modules/form_editing/yui_exclui.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('12');
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idimpacto','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));
	echo $str; 
?>
<?php echo $pagina->imprime(); ?>