<?php 
//include('includes/class.php'); 
if (!headers_sent()){ header("Content-Type: text/html;charset=utf-8"); }
$bd = new bd();
?>
<body>

<h1>
RELATÓRIO DE MONITORAMENTO
</h1>
<HR>
<fieldset>
<form method="POST" action="modules/monitoramento/send_relatorio.php" onsubmit="return WBS.sendForm(this, false)">
<legend> INSERIR NOVO REGISTRO </legend><table width="100%" border="0">

<input type="hidden" name="ID" value="<?=$_GET['id']?>" /></input>
<?php
	$id = explode('_',$_GET['id']);
	//pre($id);
	$res = $bd->gera_array('label','web4_db2.tb_tipo_emissao','idtipo_emissao = '.$id[4]);
	$bd->loga($bd->get_sql());
?>

<tr bgcolor="#FFFFCC"><td align="right"><label> RESIDUO: </label></td><td colspan="4" style="text-transform:uppercase" align="center"><?=$res[0]['label']?> </td>
	<td><input type="submit" value="inserir"></td></tr>
<tr><td align="right"><label> EMPRESA: </label></td><td><select name="idempresa">
<?php 
	$ids = explode('_',$_GET['id']);
	$std = $bd->gera_array('idempresa,periodo,periodo_max','empresa_teste1.rel_ambiental','idprocesso = '.$ids[0].' AND idatividade = '.$ids[1].' AND idaspecto_ambiental = '.$ids[2].' AND idimpacto = '.$ids[3].' AND idtipo_emissao ='.$ids[4].' AND iddestinacao_final ='.$ids[5]);
	$bd->loga($bd->get_sql());
	
	
	$rs = $bd->gera_array('idempresa,nome_fantasia','web4_db2.tb_empresas','TRUE');
	foreach ($rs as $k => $v){	?>
		<option value="<?=$v['idempresa']?>" <?=($v['idempresa']==$std[0]['idempresa'])?'SELECTED':'';?>><?=$v['nome_fantasia']?></option>
<?php } ?>
    </select></td><td align="right"> NF: </td>
    <td><input type="text" size="10" name="numnf"></td></tr>
<tr><td align="right"><label> QTDE: </label></td><td> <input type="text" size="10" name="qtde"></td><td align="right">DATA NF: </td>
<td><input type="text" name="datanf"></td></tr>
</form>
</table>
</fieldset>
<?
	//Cria a página
	$pagina = new pagina("rel_monitor");
	$padrao = 'rel_monitor';

	/*if (isset($_GET['ID'])){
		echo '<script> WBS.MID = "'.$_GET['ID'].'";  </script>';
		$em = new empresa();
		$result = $em->getImpacto($_GET['ID']);
		//pre($result);
		$str ="<script> WBS.IDs = new Array();\r\n";
		
		if (is_array($result)){
			foreach ($result as $k => $v){
				$aux = explode('_',$v['ID']);
				$str .= "WBS.IDs[".$aux[3]."] = true;\r\n";
			}
		} else if (count($result) == 1) {
			$aux = explode('_',$result['ID']);
			$str .= "WBS.IDs[".$aux[3]."] = true;\r\n";
		} else {
			$str .= "WBS.IDs[0] = true;\r\n";
		}
		$str .= '</script>';
	}*/
	//Adiciona o cpanel no array $pagina->data
	//$pagina->addCpanel();
	$editar = ($login->permissoes(10,'editar'))?true:false;
	$deletar = ($login->permissoes(10,'deletar'))?true:false;
	$inserir = ($login->permissoes(10,'inserir'))?true:false;
	
//	$id = $_GET['recordID'];
	$id = explode('_',$_GET['id']);
	$tabela = 'empresa_teste1.'.$padrao;
	$idtabela = 'empresa_teste1.id'.$padrao;
	$cond = " idprocesso = ".$id[0]." AND idatividade = ".$id[1]." AND idaspecto_ambiental = ".$id[2]." AND idimpacto = ".$id[3]." AND idtipo_emissao = ".$id[4]." AND iddestinacao_final = ".$id[5];
	//$titulo = "Listagem de ".$padrao."s";
	//$campos = "tb_".$padrao.".id".$padrao.' as id, CONCAT(%27'.$_GET[ID].'_%27, tb_'.$padrao.".id".$padrao.") as ida, tb_".$padrao.".*";
	$campos = "idempresa as ide, data_monitor, (select label from web4_db2.tb_tipo_emissao where idtipo_emissao = ".$id[4].") as residuo, (select nome_fantasia from web4_db2.tb_empresas where idempresa = ide) as empdestino, qtde, numnf";
	//Seta o elemento grid na página
	$pagina->setGrid($campos,$tabela,$cond,$titulo,$idtabela,$tabela);
	//($inserir)?$pagina->grid->addIDInsert('impacto'):'';
	//($inserir)?$pagina->grid->addInsert(16):'';
	//Adiciona as colunas açoes e eventos 
	//$pagina->grid->AddColuna('id', "", "checkbox", "20", "", "","true","YAHOO.widget.DataTable.formatCheckCond");
	//$pagina->grid->AddColuna('data_monitor', "", "checkbox", "20", "", "","true","YAHOO.widget.DataTable.formatHOTSig");
	//$pagina->grid->AddColuna('id', "ID", "Number", "", "", 'false');
	$pagina->grid->AddColuna('data_monitor', "DATA", "string", "100","");
	$pagina->grid->AddColuna('residuo','RESIDUO',"string","100","");
	$pagina->grid->AddColuna('empdestino','EMP DESTINO',"string","100","");
	$pagina->grid->AddColuna('qtde','QTDE',"string","100","");
	$pagina->grid->AddColuna('numnf','NF',"string","100","");
	//$pagina->grid->AddAcao("view", "modules/seguranca/modulo_has_menu.php");
	
	//$pagina->grid->AddAcao("listOut", encode("modules/criterios_pertinentes/list_criterios_pertinentes.php"), 'ida');
	//$pagina->grid->AddAcao("editById", encode("modules/significancia/gera_form.php"), 'ida');
	//($editar)?$pagina->grid->AddAcao("open_form","16"):"";
	//($editar)?$pagina->grid->AddAcao("open_form", "16"):'';
	//($deletar)?$pagina->grid->AddAcao("delete", "modules/form_editing/yui_exclui.php"):'';
	$pagina->grid->full = false;
	$pagina->loadGrid('10');
	//$pagina->addCpanelOff('Pesquisa',$pagina->grid->addPesquisa('idimpacto','ID', '1')." | ".$pagina->grid->addPesquisa('label','label', '3'));
	//$pagina->imprime();
	//include("modulos/permissao/template/listaacessogrp.php");
	echo $str; 
?>
<h1> HISTORICO DE MONITORAMENTO </h1>
<hr>
<?php echo $pagina->head(); ?>
<?php echo $pagina->str_grid(); ?>
<?php echo $pagina->grid->script; ?>
</body>