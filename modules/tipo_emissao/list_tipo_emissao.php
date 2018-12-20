<?php
	//Cria a página
	$em = new empresa();
	$result = $em->getEmissao($_GET['ID']);
	echo '<script> WBS.MID = "'.$_GET['ID'].'";  </script>';
	$str ="<script> WBS.IDs = new Array();\r\n";
	if (isset($_GET['ID'])){
		if (is_array($result)){
			foreach ($result as $k => $v){
				$aux = explode('_',$v['ID']);
				$str .= "WBS.IDs[".$aux[4]."] = true;\r\n";
			}
		} else if(count($result)==1){
			$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs[".$aux[4]."] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	}
	$padrao = "tipo_emissao";
	$pagina = new pagina($padrao, "Emiss&Otilde;es");
	$editar = ($login->permissoes(7,'editar'))?true:false;
	$deletar = ($login->permissoes(7,'deletar'))?true:false;
	$inserir = ($login->permissoes(7,'inserir'))?true:false;
	
	$id = $_GET['recordID'];
	$tabela = 'tb_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = "TRUE";
	$titulo = "Listagem de Tipos de Emissões";
	$campos = "tb_".$padrao.".id".$padrao." as id, tb_".$padrao.".*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addIDInsert('tipo_emissao'):'';
	($inserir)?$pagina->grid->addInsert(13):'';
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "600",($editar)?"'textbox'":"");
	($editar)?$pagina->grid->AddAcao("open_form", "13"):"";
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):"";
	$pagina->grid->full = false;
	$pagina->loadGrid('14');
	
	echo $str;
	$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
?>