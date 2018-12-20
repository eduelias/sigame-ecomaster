<?php
	//Cria a página
	$padrao = "modulos";
	$pagina = new pagina($padrao);
	$editar = ($login->permissoes(8,'editar'))?true:false;
	$deletar = ($login->permissoes(8,'deletar'))?true:false;
	$inserir = ($login->permissoes(8,'inserir'))?true:false;
	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	
	$id = $_GET['recordID'];
	$tabela = 'cfg_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = (isset($id))?"cfg_menu_sistema.idmenu_sistema = ".$id." ":"TRUE";
	//$titulo = "Listagem de ".$padrao;
	$campos = "cfg_".$padrao.".id".$padrao." as id, cfg_".$padrao.".*, cfg_menu_sistema.menu as menu, cfg_menu_sistema.idmenu_sistema as idmenu";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela." JOIN cfg_menu_sistema ON ".$tabela.".idmenu_sistema = cfg_menu_sistema.idmenu_sistema" ,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addInsert(8):'';

	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "160",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('menu','Menu',"string","250","");
	$pagina->grid->AddColuna('modulo','Nome',"string","90",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('cor','Cor',"string","90",($editar)?"'textbox'":"");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	($editar)?$pagina->grid->AddAcao("open_form", "8"):"";
	//$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php");

	$pagina->loadGrid('20');
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
?>