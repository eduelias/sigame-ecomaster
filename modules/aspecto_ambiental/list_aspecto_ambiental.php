<?php
	$cond = false;
	if (isset($_GET['ID'])){
		echo '<script> WBS.MID = "'.$_GET['ID'].'";  </script>';
		$em = new empresa();
		$result = $em->getAspecto($_GET['ID']);
		$cond = true;
		$str ="<script> WBS.IDs = new Array();\r\n";
		
		if (is_array($result)){
			foreach ($result as $k => $v){
				$aux = explode('_',$v['ID']);
				$str .= "WBS.IDs[".$aux[2]."] = true;\r\n";
			}
		} else if (count($result)==1){
			$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs[".$aux[2]."] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	}
	//Cria a página
	$pagina = new pagina("aspecto_ambiental","Aspectos ambientais");
	$padrao = 'aspecto_ambiental';

	$editar = ($login->permissoes(11,'editar'))?true:false;
	$deletar = ($login->permissoes(11,'deletar'))?true:false;
	$inserir = ($login->permissoes(11,'inserir'))?true:false;
	
	$id = $_GET['recordID'];
	$tabela = 'tb_'.$padrao;
	$idtabela = 'id'.$padrao;
	$cond = "NOT ".$idtabela." = 0";
	$campos = "tb_".$padrao.".id".$padrao." as id, tb_".$padrao.".*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addIDInsert($padrao):'';
	($inserir)?$pagina->grid->addInsert(18):'';
		
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "650","'textbox'");
	($editar)?$pagina->grid->AddAcao("open_form", "18"):'';
	($deletar)?$pagina->grid->AddAcao("delete", "modules/form_editing/yui_exclui.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('12');
	$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idaspecto_ambiental','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));

?>
<?php echo $str; ?>
<?php echo $pagina->imprime(); ?>