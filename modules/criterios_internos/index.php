<?php

	$pagina = new pagina("criterios_pertinentes");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	$editar = ($login->permissoes(17,'editar'))?true:false;
	$deletar = ($login->permissoes(17,'deletar'))?true:false;
	$inserir = ($login->permissoes(17,'inserir'))?true:false;
	
	$id = $_GET['recordID'];
	$tabela = 'tb_criterios_pertinentes';
	$idtabela = 'idcriterios_pertinentes';
	$cond = "NOT ".$idtabela." = 0";
	$titulo = "";
	$campos = "tb_criterios_pertinentes.idcriterios_pertinentes as id, tb_criterios_pertinentes.*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	//($inserir)?$pagina->grid->addIDInsert('processos'):'';
	($inserir)?$pagina->grid->addInsert(21):'';
	
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "600","'textbox'");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	($editar)?$pagina->grid->AddAcao("open_form", "21"):'';
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('14');
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idprocesso','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));
	//$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
	
?>

<h1> CRIT&Eacute;RIOS PERTINENTES </h1>
<hr>
<?php echo $str; ?>
<?php echo $pagina->head(); ?>
<?php echo $pagina->str_grid(); ?>
<?php echo $pagina->grid->script; ?>