<?php

	$pagina = new pagina("criterios_pertinentes", "Leis, Normas e Definições");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	$editar = ($login->permissoes(17,'editar'))?true:false;
	$deletar = ($login->permissoes(17,'deletar'))?true:false;
	$inserir = ($login->permissoes(17,'inserir'))?true:false;
	
	$id = $_GET['recordID'];
	$tabela = 'tb_criterios_pertinentes';
	$idtabela = 'idcriterios_pertinentes';
	$cond = "NOT ".$idtabela." = 0";
	$titulo = "";
	$campos = "tb_criterios_pertinentes.idcriterios_pertinentes as id, tb_criterios_pertinentes.*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	//($inserir)?$pagina->grid->addIDInsert('processos'):'';
	($inserir)?$pagina->grid->addInsert(21):'';
	
	//Adiciona as colunas açoes e eventos 
	
	$pagina->grid->AddColuna('jurisdicao', 'Abrangencia', "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "600","'textbox'");
	$pagina->grid->AddColuna('id', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatLegal");
	($editar)?$pagina->grid->AddAcao("open_form", "21"):'';
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('14');
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idcriterios_pertinentes','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));

	
?>
<script> WBS.central =  new YAHOO.widget.Panel("central",{width:"500px", fixedcenter:true, close:false, draggable:false, zindex:91, modal:false, visible:false}); </script>
<?php echo $str; ?>
<?php $pagina->imprime(); ?>