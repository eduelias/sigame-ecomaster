<script>
	WBS.pagina.idgeral = <? echo $_GET['recordID']; ?>;
</script>
<?
	//Cria a página
	$pagina = new pagina("listaAcesso");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	$id = $_GET['recordID'];
	echo '<h1>Editando Grupo ID#'.$id.'</h1>';
	
	$cond = "TRUE GROUP BY grupos_has_modulos.idgrupos";

	//Seta o elemento grid na página
	$pagina->setGrid("*","joinseguranca",$id,"Permiss&otilde;es",'idmodulos','grupos_has_modulos');

	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna("idmodulos", "Modulo", "string", "2em", "", 'false');
	$pagina->grid->AddColuna("modulos", "Página", "string", "20em","");
	$pagina->grid->AddColuna("nomem", "Nome", "string", "20em","");
	$pagina->grid->AddColuna("checked", "ON", "truefalse", "1em", "","","false","YAHOO.widget.DataTable.formatSimNao");
	//Carrega o grid no array $pagina->data
	$pagina->loadGrid();
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
?>