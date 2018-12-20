<?
	$alter_bd = new bd();
	$codpg = $_GET['id1'];
	$codgrp = $_GET['id2'];

	switch ($_GET['tabela']) {
		case 'treeadd':{
			$str = $_GET['arr'];
			$arr = explode(',',$str);
			pre($arr);
			$proc = new empresa();
			$ks = explode('_',$_GET['keys']);
			$ev = 'pre($proc->add'.$_GET["tipo"].'($ks, $arr));';
			eval($ev);
		} break;
		case 'cfg_grupos_has_modulos':{
			$js = new joinseguranca();
			if ($_GET['val']!='FALSE'){
				$result = $js->cria_acesso($codpg,$codgrp);	
				$js->get_sql();
			} else {
				$result = $js->retira_acesso($codpg,$codgrp);
			}
		}
		break;
		case 'cfg_ghm':{
			$_GET['tabela'] = 'cfg_grupos_has_modulos';
			$campos = array ('cond@'.$_GET['tabela'].'@'.$_GET['keyfield']=>$_GET['id'],'cond@'.$_GET['tabela'].'@'.$_GET['k2']=>$_GET['val2'],$_GET['tabela'].'@'.$_GET['field']=>$_GET['val']);
			print_r($campos);
			$alter_bd->altera($campos);
			echo $alter_bd->get_sql();
		}	
		break;
		default:{
			$campos = array ('cond@'.$_GET['tabela'].'@'.$_GET['keyfield']=>$_GET['id'],$_GET['tabela'].'@'.$_GET['field']=>iconv('utf-8','iso-8859-1',$_GET['val']));
			print_r($campos);
			$alter_bd->altera($campos);
			echo $alter_bd->get_sql();
		}
		
}
?>