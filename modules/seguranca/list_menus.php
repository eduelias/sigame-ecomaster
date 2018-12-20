<?php
	//Cria a página
	$padrao = "menu_sistema";
	$pagina = new pagina($padrao);
	
	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	
	$id = $_GET['recordID'];
	$tabela = 'cfg_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = "TRUE";
	$titulo = "Listagem de Menus do Sistema";
	$campos = "cfg_".$padrao.".id".$padrao." as id, cfg_".$padrao.".*";
	$editar = ($login->permissoes(2,'editar'))?true:false;
	$deletar = ($login->permissoes(2,'deletar'))?true:false;
	$inserir = ($login->permissoes(2,'inserir'))?true:false;
	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addInsert(9):'';

	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('POS', "Pos", "string", "16",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('menu', "Label", "string", "160",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna("imagem", "&nbsp;Imagem", "imagem", "50", "","","false","YAHOO.widget.DataTable.formatImagem");
	($editar)?$pagina->grid->AddColuna("habilitado", "Hab", "select", "21", "","","false","YAHOO.widget.DataTable.formatdot"):'';
	$pagina->grid->AddAcao("view", "modules/seguranca/modulos.php");
	($editar)?$pagina->grid->AddAcao("open_form", "9"):'';
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):'';

	$pagina->loadGrid('20');
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
?>