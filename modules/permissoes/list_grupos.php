<?
	//Cria a página
	$pagina = new pagina("Grupos", "Controle de Permiss&otilde;es");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel('modules/permissoes/forms/pesq_grupos.php','Procurar'); 
	
	$editar = ($login->permissoes(8,'editar'))?true:false;
	$deletar = ($login->permissoes(8,'deletar'))?true:false;
	$inserir = ($login->permissoes(8,'inserir'))?true:false;
	
	//Seta o elemento grid na página
	$pagina->setGrid("*","cfg_grupos",'TRUE',"",'idgrupos','cfg_grupos');
	($inserir)?$pagina->grid->addInsert(1):'';
	//$pagina->grid->addPesq('modules/permissoes/forms/pesq_grupos.php');
	
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna("idgrupos", "#", "string", "10", "", 'false');
	$pagina->grid->AddColuna("grupo", "ID Str", "string", "100",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna("label", "Label", "string", "300",($editar)?"'textbox'":"");
	$pagina->grid->AddAcao("related", "modules/permissoes/index.php");
	($editar)?$pagina->grid->AddAcao("open_form","1"):"";
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):"";
	
	//define o tamanho da altura na qual haverá scroll
	$pagina->grid->height = '10.1em';
	//$pagina->grid->width = '100%';
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idgrupos','ID')." ".$pagina->grid->addPesquisa('Label','label'));
	//Carrega o grid no array $pagina->data, com número de rows
	$pagina->loadGrid(3);
?>	