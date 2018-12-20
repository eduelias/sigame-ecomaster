<?php

	$pagina = new pagina("criterios_pertinentes","Aspectos Legais");

	if (isset($_GET['id'])){
		echo '<script> WBS.MID = "'.$_GET['id'].'";  </script>';
		$em = new empresa();
		$ids = $_GET['id'];
		$result = $em->getCriterios($ids);
		$str ="<script> WBS.IDs = new Array();\r\n";
		
		if (is_array($result)){
			foreach ($result as $k => $v){
				foreach ($v as $v1){ 
					$str .= "WBS.IDs['".$_GET['id']."_".$v1['ID']."'] = true;\r\n";
				}
			}
		} else if (count($result) == 1) {
			$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs['".$_GET['id']."_".$v['ID']."'] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	}
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
	$campos = 'tb_criterios_pertinentes.idcriterios_pertinentes as ida, CONCAT(%27'.$_GET['id'].'_%27,'.$tabela.".".$idtabela.") as id, tb_criterios_pertinentes.*";

	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	($inserir)?$pagina->grid->addIDInsert('criterios_pertinentes'):'';
	//($inserir)?$pagina->grid->addInsert(21):'';
	
	//Adiciona as colunas açoes e eventos 
	$pagina->grid->AddColuna('id', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	$pagina->grid->AddColuna('ida', "", "checkbox", "", "", "","true","YAHOO.widget.DataTable.formatLegal");
	$pagina->grid->AddColuna('jurisdicao', 'Abrangencia', "", "", 'false');
//	$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('label', "Label", "string", "","'textbox'");

	$pagina->grid->full = false;
	$pagina->loadGrid('14');
	//$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idcriterios_pertinentes','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));

?>
<script> WBS.central =  new YAHOO.widget.Panel("central",{width:"500px", fixedcenter:true, close:false, draggable:false, zindex:91, modal:false, visible:false}); </script>
<?php echo $str; ?>
<?php echo $pagina->imprime(); ?>