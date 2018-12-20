<?php
	if (isset($_GET['ID'])){
		echo '<script> WBS.MID = "'.$_GET['ID'].'";  </script>';
		$em = new empresa();
		$result = $em->getAtividade($_GET['ID']);
		$str ="<script> WBS.IDs = new Array();\r\n";
		if (is_array($result)){
			foreach ($result as $k => $v){
				$aux = explode('_',$v['ID']);
				$str .= "WBS.IDs[".$aux[1]."] = true;\r\n";
			}
		} else if (count($result)==1){
			$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs[".$aux[1]."] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	}
		
	//Cria a página
	$padrao = "atividade";
	$pagina = new pagina($padrao,'ATIVIDADES');
	$editar = ($login->permissoes(3,'editar'))?true:false;
	$deletar = ($login->permissoes(3,'deletar'))?true:false;
	$inserir = ($login->permissoes(3,'inserir'))?true:false;

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanelOff('Pesquisar','AGUARDANDO PESQUISA');
	
	$id = $_GET['recordID'];
	$tabela = 'tb_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = " NOT ".$idtabela." = 0";
	//$titulo = "Listagem de ".$padrao."s";
	$campos = "tb_".$padrao.".id".$padrao." as id, tb_".$padrao.".*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addIDInsert('atividade'):'';
	($inserir)?$pagina->grid->addInsert(12):'';
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "700", ($editar)?"'textbox'":"",'false' , 'false');
	//$pagina->grid->AddColuna('descricao','Desc',"string","250",($editar)?"'textbox'":"");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	//$pagina->grid->AddAcao("edit_off", "modules/seguranca/usuarios.php&formid=3");
	//$pagina->grid->AddColuna('id', "", "hidden", "", "", "","true","YAHOO.widget.DataTable.formatMark");
	($editar)?$pagina->grid->AddAcao("open_form", "12"):'';
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('12');
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idatividade','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));
	//echo encode("modules/mod_teste/remover.php");
	
	//include("modulos/permissao/template/listaacessogrp.php");
	
?>
<?php echo $str; ?>
<?php echo $pagina->imprime(); ?>