<?php
	if (isset($_GET['ID'])){
		$em = new empresa();
		$result = $em->getDestinacao($_GET['ID']);
		$str ="<script> WBS.IDs = new Array();\r\n";
		if (is_array($result)){
			foreach ($result as $k => $v){
				$aux = explode('_',$v['ID']);
				$str .= "WBS.IDs[".$aux[5]."] = true;\r\n";
			}
		} else if (count($result)==5){
			$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs[".$aux[5]."] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	}
		
	//Cria a página
	$padrao = "destinacao_final";
	$pagina = new pagina($padrao);
	$editar = ($login->permissoes(3,'editar'))?true:false;
	$deletar = ($login->permissoes(3,'deletar'))?true:false;
	$inserir = ($login->permissoes(3,'inserir'))?true:false;

	$id = $_GET['recordID'];
	$tabela = 'tb_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = " NOT ".$idtabela." = 0";
	$campos = "tb_".$padrao.".id".$padrao." as id, tb_".$padrao.".*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addIDInsert('destinacao_final'):'';
	($inserir)?$pagina->grid->addInsert(20):'';
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "800", ($editar)?"'textbox'":"",'false' , 'false');
	($deletar)?$pagina->grid->AddAcao("delete", "modules/form_editing/yui_exclui.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('20');
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('iddestinacao_final','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));
	echo "";
	
	//include("modulos/permissao/template/listaacessogrp.php");
?>
<?php echo $str; ?>
<?php echo $pagina->imprime(); ?>