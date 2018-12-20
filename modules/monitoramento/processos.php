<?php
	//Cria a página
		$em = new empresa();
		$result = $em->getProcessos();
		//pre($result);
		$str ="<script> WBS.IDs = new Array();\r\n";
		if (is_array($result)){
			foreach ($result as $k => $v){
				//$aux = explode('_',$v['ID']);
				$str .= "WBS.IDs[".$v['ID']."] = true;\r\n";
			}
		} else if (count($result)==1){
			//$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs[".$v['ID']."] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	$pagina = new pagina("processos");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	$editar = ($login->permissoes(16,'editar'))?true:false;
	$deletar = ($login->permissoes(16,'deletar'))?true:false;
	$inserir = ($login->permissoes(16,'inserir'))?true:false;
	
	$id = $_GET['recordID'];
	$tabela = 'empresa_teste1.rel_ambiental JOIN web4_db2.tb_processo ON empresa_teste1.rel_ambiental.idprocesso = web4_db2.tb_processo.idprocesso';
	$idtabela = 'empresa_teste1.rel_ambiental.idprocesso';
	$cond = "NOT ".$idtabela." = 0 AND NOT empresa_teste1.rel_ambiental.significancia = 0";
	$titulo = "";
	$campos = "empresa_teste1.rel_ambiental.idprocesso as id, empresa_teste1.rel_ambiental.*,web4_db2.tb_processo.label";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,'idprocesso','empresa_teste1.rel_ambiental');
	//($inserir)?$pagina->grid->addIDInsert('processos'):'';
	//($inserir)?$pagina->grid->addInsert(11):'';
	
	//Adiciona as colunas açoes e eventos 
	//$pagina->grid->AddColuna('id', "", "checkbox", "20", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	//$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "600","");
	$pagina->grid->AddColuna('significancia', "IMP", "string", "35","");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	//($editar)?$pagina->grid->AddAcao("open_form", "11"):'';
	//($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('14');
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idprocesso','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));
	//$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
?>
<?php echo $str; ?>
<?php echo $pagina->imprime(); ?>
