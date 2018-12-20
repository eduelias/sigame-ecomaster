<?
	//Cria a página
	$pagina = new pagina("usuario");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	$editar = ($login->permissoes(2,'editar'))?true:false;
	$deletar = ($login->permissoes(2,'deletar'))?true:false;
	
	//$id = $_GET['id'];
	$tabela = 'cfg_usuario';
	$idtabela = 'idusuario';
	//$cond = "TRUE GROUP BY grupos_has_modulos.idgrupos";

	//Seta o elemento grid na página
	$pagina->setGrid("*",$tabela,'TRUE',"Listagem de Usuários",$idtabela,$tabela);

	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna($idtabela, "ID", "string", "15", "", 'false');
	$pagina->grid->AddColuna('login', "Login", "string", "200","");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	($editar)?$pagina->grid->AddAcao("open_form", "3"):"";
	//$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php");
	//$pagina->grid->AddEvento("Excluir", "_excluir()");
	//$pagina->grid->AddColuna("checked", "ON", "truefalse", "1em", "","","false","YAHOO.widget.DataTable.formatSimNao");
	//Carrega o grid no array $pagina->data
	$pagina->loadGrid();
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
?>
