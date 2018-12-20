<?php

	//Cria a página
	$pagina = new pagina("campos");
	//$pagina->setModulo(1);

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	
	$id = $_GET['recordID'];
	$tabela = 'frm_campo_formulario JOIN frm_formulario ON frm_formulario.idformulario = frm_campo_formulario.idformulario';
	$idtabela = 'idcampo_formulario';
	$cond = (isset($id))?'frm_campo_formulario.idformulario ='.$id:"TRUE";
	$titulo = (isset($id))?'Listando campos do form "':"Listagem de Campos";
	$editar = ($login->permissoes(1,'editar'))?true:false;
	$deletar = ($login->permissoes(1,'deletar'))?true:false;
	$inserir = ($login->permissoes(1,'inserir'))?true:false;
	//Seta o elemento grid na página
	$pagina->setGrid("frm_campo_formulario.idcampo_formulario as id, frm_campo_formulario.*,frm_formulario.*",$tabela,$cond,(isset($id))?'Listando campos do formulario de ID#'.$id:"Listagem de Campos",$idtabela,"frm_campo_formulario");
	($inserir)?$pagina->grid->addInsert(5):'';

	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('titulo', "Form", "string", "200","");
	$pagina->grid->AddColuna('label','Label',"string","100",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('tipo','Tipo',"string","60",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('tamanho','Px',"Number","30",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('tabela_master','Tb Principal',"string","120",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('tabela_master_campo','Campo chave',"string","110",($editar)?"'textbox'":"");
	//$pagina->grid->AddColuna('tabela_detalhe','Tb Det',"string","",($editar)?"'textbox'":"");
	//$pagina->grid->AddColuna('tabela_campo_detalhe','Campo lista',"string","",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('elname','Nome HTML',"string","100",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('elid','ID HTML',"string","130",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('style','estilo',"string","80",($editar)?"'textbox'":"");
	//$pagina->grid->AddColuna('js','JS',"string","10",($editar)?"'textbox'":"");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	(($editar)?$pagina->grid->AddAcao("open_form", "5"):'');
	$pagina->grid->height = '37em';
	//$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php");
	//$pagina->grid->AddEvento("Excluir", "_excluir()");
	//$pagina->grid->AddColuna("checked", "ON", "truefalse", "1em", "","","false","YAHOO.widget.DataTable.formatSimNao");
	//Carrega o grid no array $pagina->data
	$pagina->loadGrid('20');
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");



?>