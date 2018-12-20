<?php
	//Cria a página
	$pagina = new pagina("ramos");
	$editar = ($login->permissoes(6,'editar'))?true:false;
	$deletar = ($login->permissoes(6,'deletar'))?true:false;
	$inserir = ($login->permissoes(6,'inserir'))?true:false;

	//Adiciona o cpanel no array $pagina->data
	$pagina->addCpanelOff("Pesquisar","AGUARDANDO PESQUISA");
	
	$id = $_GET['recordID'];
	$tabela = 'tb_ramo_empresa';
	$idtabela = 'idramo_empresa';
	$cond = "TRUE";
	$titulo = "Listagem de Ramos";
	$campos = "tb_ramo_empresa.idramo_empresa as id, tb_ramo_empresa.*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addInsert(10):'';
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "160",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('descricao','Desc',"string","250",($editar)?"'textbox'":"");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	($editar)?$pagina->grid->AddAcao("open_form", "10"):"";
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):"";

	$pagina->loadGrid('20');
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
?>