<?php
	//Cria a página
	$padrao = "nao_conformidade";
	$pagina = new pagina($padrao);
	$editar = ($login->permissoes(9,'editar'))?true:false;
	$deletar = ($login->permissoes(9,'deletar'))?true:false;
	$inserir = ($login->permissoes(9,'inserir'))?true:false;

	//Adiciona o cpanel no array $pagina->data
	$pagina->addCpanelOff('Pesquisar','AGUARDANDO PESQUISA');
	
	$id = $_GET['recordID'];
	$tabela = 'tb_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = "TRUE";
	//$titulo = "Listagem de ".$padrao."s";
	$campos = "tb_".$padrao.".id".$padrao." as id, tb_".$padrao.".*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addInsert(15):'';
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "160",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('descricao','Desc',"string","250",($editar)?"'textbox'":"");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	($editar)?$pagina->grid->AddAcao("open_form", "15"):'';
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):'';

	$pagina->loadGrid('20');
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
?>