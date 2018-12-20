<?php

	//Cria a página
	$pagina = new pagina("campos");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	
	$id = $_GET['recordID'];
	$tabela = 'frm_formulario';
	$idtabela = 'idformulario';
	$cond = "TRUE";
	$titulo = "Listagem de Formulários";
	$editar = ($login->permissoes(1,'editar'))?true:false;
	$deletar = ($login->permissoes(1,'deletar'))?true:false;
	$inserir = ($login->permissoes(1,'inserir'))?true:false;

	//Seta o elemento grid na página
	$pagina->setGrid("frm_formulario.idformulario as id, frm_formulario.*",$tabela,$cond,(isset($id))?'Listando campos do formulario de ID#'.$id:"Listagem de Formul&aacute;rios",$idtabela,$tabela);
	($inserir)?$pagina->grid->addInsert(4):'';
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id',"ID",'integer','10','','');
	$pagina->grid->AddColuna('nome', "Form Name", "string", "80",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('titulo', "Legenda", "string", "180",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('method', "M&eacute;todo", "string", "40",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('action', "A&ccedil;&atilde;o", "string", "200",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('style', "Estilo", "string", "50",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('js', "JScript", "string", "20",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('cap_submit', "Bt Submit", "string", "180",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('cap_reset', "Bt Reset", "string", "180",($editar)?"'textbox'":"");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	$pagina->grid->AddAcao("view", "modules/form_editing/campos.php");
	($editar)?$pagina->grid->AddAcao("open_form", "4"):'';
	$pagina->grid->height = '35.1em';
	//$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php");
	//$pagina->grid->AddEvento("Excluir", "_excluir()");
	//$pagina->grid->AddColuna("checked", "ON", "truefalse", "1", "","","false","YAHOO.widget.DataTable.formatSimNao");
	//Carrega o grid no array $pagina->data
	$pagina->loadGrid();
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");



?>