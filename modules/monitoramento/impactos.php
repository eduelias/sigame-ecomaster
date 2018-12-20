<?php
	//Cria a página
	$pagina = new pagina("impacto","Monitoramento");
	$padrao = 'impacto';
	//pre($_GET);
	if (isset($_GET['ID'])){
		echo '<script> WBS.MID = "'.$_GET['ID'].'";  </script>';
		$em = new empresa();
		$result = $em->getImpacto($_GET['ID']);
		//pre($result);
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
	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	$editar = ($login->permissoes(16,'editar'))?true:false;
	$deletar = ($login->permissoes(16,'deletar'))?true:false;
	$inserir = ($login->permissoes(16,'inserir'))?true:false;
	
	//$tabela = "empresa_teste1.rel_ambiental JOIN web4_db2.tb_impacto ON empresa_teste1.rel_ambiental.idimpacto = web4_db2.tb_impacto.idimpacto JOIN web4_db2.tb_tipo_emissao ON empresa_teste1.rel_ambiental.idtipo_emissao = web4_db2.tb_tipo_emissao.idtipo_emissao JOIN web4_db2.tb_destinacao_final ON empresa_teste1.rel_ambiental.iddestinacao_final = web4_db2.tb_destinacao_final.iddestinacao_final";
	$tabela = 'empresa_teste1.rel_ambiental';
	$idtabela = 'empresa_teste1.rel_ambiental.idimpacto';
	$cond = "NOT ".$idtabela." = 0 AND idaspecto_ambiental = ".$aux[2]." AND NOT idtipo_emissao = 0 AND NOT iddestinacao_final = 0 AND NOT empresa_teste1.rel_ambiental.significancia = 0";
	//$cond = 'TRUE';
	$titulo = "";
	$campos = 'CONCAT(%27'.$_GET[ID].'_%27,empresa_teste1.rel_ambiental.idimpacto,%27_%27,empresa_teste1.rel_ambiental.idtipo_emissao,%27_%27,empresa_teste1.rel_ambiental.iddestinacao_final) as idaaa, empresa_teste1.rel_ambiental.idimpacto as id, empresa_teste1.rel_ambiental.significancia as sigi, empresa_teste1.rel_ambiental.idtipo_emissao as idte, empresa_teste1.rel_ambiental.iddestinacao_final as iddf,(select web4_db2.tb_processo.label as processo from web4_db2.tb_processo where idprocesso= '.$aux[0].') as processo, (select web4_db2.tb_atividade.label from web4_db2.tb_atividade where idatividade = '.$aux[1].') as atividade, (select web4_db2.tb_aspecto_ambiental.label as aspecto_ambiental from web4_db2.tb_aspecto_ambiental where idaspecto_ambiental = '.$aux[2].') as aspecto, (select web4_db2.tb_impacto.label as impacto from web4_db2.tb_impacto where idimpacto = id) as impacto, (select web4_db2.tb_tipo_emissao.label from web4_db2.tb_tipo_emissao where web4_db2.tb_tipo_emissao.idtipo_emissao = idte) as telabel, (select web4_db2.tb_destinacao_final.label from web4_db2.tb_destinacao_final where web4_db2.tb_destinacao_final.iddestinacao_final = `iddf`) as dflabel';
	//$campos = "tb_".$padrao.".id".$padrao.' as id, CONCAT(%27'.$_GET[ID].'_%27, tb_'.$padrao.".id".$padrao.") as ida, tb_".$padrao.".*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	//($inserir)?$pagina->grid->addIDInsert('impacto'):'';
	//($inserir)?$pagina->grid->addInsert(16):'';
	//Adiciona as colunas açoes e eventos 
	//$pagina->grid->AddColuna('id', "", "checkbox", "20", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	//$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('sigi', " ", "string", "20", "","","false","YAHOO.widget.DataTable.formatSig");
	$pagina->grid->AddColuna('processo', "PROCESSO", "string", "100","");
	$pagina->grid->AddColuna('atividade', "ATIVIDADE", "string", "100","");
	$pagina->grid->AddColuna('aspecto', "ASPECTO", "string", "200","");
	$pagina->grid->AddColuna('impacto', "IMPACTO", "string", "130","");
	$pagina->grid->AddColuna('telabel', "EMISSAO", "string", "90","");
	$pagina->grid->AddColuna('dflabel', "DESTINACAO FINAL", "string", "90","");
	$pagina->grid->AddColuna('sigi', "Valor", "string", "40","");
	$pagina->grid->AddAcao("editByIdOpen", encode("modules/monitoramento/form_destinacao.php"), 'idaaa');
	//$pagina->grid->AddColuna('idaa','Desc',"string","50","'textbox'");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	
	//$pagina->grid->AddAcao("editById", encode("modules/significancia/gera_form.php"), 'ida');
	//($editar)?$pagina->grid->AddAcao("open_form","16"):"";
	//($editar)?$pagina->grid->AddAcao("open_form", "16"):'';
	//($deletar)?$pagina->grid->AddAcao("delete", "modules/form_editing/yui_exclui.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('10');
	//$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idimpacto','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));
	//$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
	echo $str; 
?>
<?php echo $pagina->imprime(); ?>
