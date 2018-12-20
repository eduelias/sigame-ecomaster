<?php
	//Cria a página
	
		$em = new empresa();
		$result = $em->getProcessos();
		//pre($result);
		echo '<script> WBS.MID = 0; </script>';
		$str ="<script> WBS.IDs = new Array();\r\n";
		if (is_array($result)){
			foreach ($result as $k => $v){
				//$aux = explode('_',$v['ID']);
				$str .= "WBS.IDs[".$v['ID']."] = true;\r\n";
			}
		} else if (count($result)==1){
			//$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs[".$v['ID']."] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	$pagina = new pagina("processos","Listagem de Processos");

	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	$editar = ($login->permissoes(5,'editar'))?true:false;
	$deletar = ($login->permissoes(5,'deletar'))?true:false;
	$inserir = ($login->permissoes(5,'inserir'))?true:false;
	
	$id = $_GET['recordID'];
	$tabela = 'tb_processo';
	$idtabela = 'idprocesso';
	$cond = "NOT ".$idtabela." = 0";
	$titulo = "";
	$campos = "tb_processo.idprocesso as id, tb_processo.*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	
	($inserir)?$pagina->grid->addIDInsert('processos'):'';
	($inserir)?$pagina->grid->addInsert(11):'';
	
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "600","'textbox'");
	($editar)?$pagina->grid->AddAcao("open_form", "11"):'';
	($deletar)?$pagina->grid->AddAcao("delete", "modulos/permissao/excluiarquivo.php"):'';
	$pagina->grid->tamanho = 1280; 
	$pagina->loadGrid('12');
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idprocesso','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));
?>
<?php echo $str; ?>
<?php echo $pagina->imprime(); ?>