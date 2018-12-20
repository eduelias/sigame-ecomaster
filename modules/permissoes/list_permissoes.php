<?
	//Cria a página
	$pagina2 = new pagina("permissoes");
	$editar = ($login->permissoes(8,'editar'))?true:false;
	//Adiciona o cpanel no array $pagina2->data
	//$pagina2->addCpanel();
	
	$id_a = (isset($_GET['recordID']))?$_GET['recordID']:1;
	
	//$cond = "TRUE GROUP BY grupos_has_modulos.idgrupos";
	echo '<script> WBS.MasterKey = "idgrupos"; WBS.MasterID = '.$id_a.'; </script>';
	//Seta o elemento grid na página
	$pagina2->setGrid("ghm.idmodulos as idmodulos, m.label,ghm.editar as editar,ghm.inserir as inserir,ghm.deletar as deletar,m.modulo,g.label as lab","cfg_grupos_has_modulos ghm LEFT JOIN cfg_grupos g ON ghm.idgrupos = g.idgrupos RIGHT JOIN cfg_modulos m ON ghm.idmodulos = m.idmodulos",' ghm.idgrupos = '.$id_a.' ORDER BY label,ghm.idgrupos',"Permiss&otilde;es",'idmodulos','cfg_ghm');

	//Adiciona as colunas açoes e eventos  $campo, $label, $type,  $width, $editor = "", $classname = "", $sortable = "true", $formatter = "", $parser = 'String'
	$pagina2->grid->AddColuna("lab", "Grupo", "string", "90","",'','false');
	$pagina2->grid->AddColuna("label", "Modulo", "string", "300");
	//$pagina2->grid->AddColuna("idmodulos", "Modulo", "string", "8");
	($editar)?$pagina2->grid->AddColuna("inserir","<img src='images/edit_add.png' alt='Inserir'>","select", "20", "","","false","YAHOO.widget.DataTable.formatbool"):'';
	($editar)?$pagina2->grid->AddColuna("editar", "<img src='images/edit.gif' alt='Editar'>","select", "20", "","","false","YAHOO.widget.DataTable.formatbool"):'';
	($editar)?$pagina2->grid->AddColuna("deletar", "<img src='images/delete.gif' alt='Deletar'>","select", "20", "","","false","YAHOO.widget.DataTable.formatbool"):'';

	$pagina2->grid->sortedby= 'label';


	$pagina2->loadGrid(10);
	$pagina2->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");

?>