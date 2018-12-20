<?
	//Cria a página 
	$pagina = new pagina("empresas");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel('modules/permissoes/forms/pesq_grupos.php','Procurar'); 
	
	$editar = ($login->permissoes(19,'editar'))?true:false;
	$deletar = ($login->permissoes(19,'deletar'))?true:false;
	$inserir = ($login->permissoes(19,'inserir'))?true:false;
	
	//Seta o elemento grid na página
	$pagina->setGrid("*","tb_empresas",'TRUE',"",'idempresa','tb_empresas');
	($inserir)?$pagina->grid->addInsert(22):'';
	//$pagina->grid->addPesq('modules/permissoes/forms/pesq_grupos.php');
	
	//Adiciona as colunas açoes e eventos 
	//$pagina->grid->AddColuna("idempresa", "#", "string", "10", "", 'false');
	$pagina->grid->AddColuna("razao_social", "Razao", "string", "100",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna("nome_fantasia", "Fantasia", "string", "100",($editar)?"'textbox'":"");
	$pagina->grid->AddColuna("cnpj", "Label", "string", "300",($editar)?"'textbox'":"");
	
	//$pagina->grid->AddAcao("related", "modules/permissoes/index.php");
	($editar)?$pagina->grid->AddAcao("open_form","22"):"";
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):"";
	
	//define o tamanho da altura na qual haverá scroll
		$pagina->grid->full = false;
	//$pagina->grid->width = '100%';
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('cnpj','CNPJ')." ".$pagina->grid->addPesquisa('nome_fantasia','Nome'));
	//Carrega o grid no array $pagina->data, com número de rows
	$pagina->loadGrid(3);
	$pagina->imprime();
?>	