<?php
	//Cria a página
	$padrao = "significancia_impactos";
	$pagina = new pagina($padrao,"Signific&Acirc;ncias");
	$editar = ($login->permissoes(15,'editar'))?true:false;
	$deletar = ($login->permissoes(15,'deletar'))?true:false;
	$inserir = ($login->permissoes(15,'inserir'))?true:false;

	
	$id = $_GET['recordID'];
	$tabela = 'tb_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = "TRUE";
	$titulo = "Listagem de Tipos de Emissões";
	$campos = "tb_".$padrao.".id".$padrao." as id, tb_".$padrao.".*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addInsert(19):'';

	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "500",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('abrev', "Abrev.", "string", "50",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna('descricao','Desc',"string","300",($editar)?"'textbox'":"");

	($editar)?$pagina->grid->AddAcao("open_form", "19"):"";
	($deletar)?$pagina->grid->AddAcao("delete", "modules/form_editing/yui_exclui.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('14');
	$pagina->imprime();
?>