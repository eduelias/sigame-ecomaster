<?php
	$pagina = new pagina('tree_teste');
	
	$pagina->addTree('lateral');
	
	$obj['campos'] = 'label';
	$obj['tabela'] = 'tb_processo';
	$obj['condicao'] = 'TRUE';
	$ec = $pagina->oTree->getJson($obj);
?>

<?	
	$emp = new empresa();
	$emp->get_sql();
?>
<style type="text/css">
.mark { background-color:#990000; }
/* Remove row striping, column borders, and sort highlighting */
.yui-skin-sam tr.yui-dt-odd,
.yui-skin-sam tr.yui-dt-odd td.yui-dt-asc,
.yui-skin-sam tr.yui-dt-odd td.yui-dt-desc,
.yui-skin-sam tr.yui-dt-even td.yui-dt-asc,
.yui-skin-sam tr.yui-dt-even td.yui-dt-desc {
    background-color: '';
}
.yui-skin-sam .yui-dt tbody td {
    border-bottom: 1px solid #ddd;
}
.yui-skin-sam .yui-dt thead th {
    border-bottom: 1px solid #7f7f7f;
}
.yui-skin-sam .yui-dt tr.yui-dt-last td,
.yui-skin-sam .yui-dt th,
.yui-skin-sam .yui-dt td {
    border: none;
}

.tree { display: block; text-decoration:none; color:#000000}
.processo { color:#0033FF; text-transform:uppercase}
.atividade {color:#3366FF}
.aspecto_ambiental { color:#5588FF;}
.impacto { color:#6699FF; }
.tipo_emissao { color:#77AAFF; }
.destinacao_final{ }
.icon-locked { display:block; height: 17px; padding-left: 15px; background: transparent url(images/msg_icos.png) 0 -1px no-repeat; }
.td_icon-locked { display:block; height: 22px; padding-left: 15px; background: transparent url(images/msg_icos.png) 0 5px no-repeat; }
.icon-unlocked { display:block; height: 22px; padding-left: 15px; padding-top:1px; text-decoration:none; background: transparent url(images/msg_icos.png) 0 -36px no-repeat; }
.icon-info { display:block; height: 22px; padding-left: 20px; background: transparent url(images/msg_icos.png) 0 -72px no-repeat; }
.icon-x { display:block; height: 22px; padding-left: 20px; background: transparent url(images/msg_icos.png) 0 -108px no-repeat; }
.icon-boneco { display:block; height: 22px; padding-left: 20px; background: transparent url(images/msg_icos.png) 0 -144px no-repeat; }
.icon-alert { display:block; height: 22px; padding-left: 20px; background: transparent url(images/msg_icos.png) 0 -180px no-repeat; }
.icon-traco { display:block; height: 22px; padding-left: 20px; background: transparent url(images/msg_icos.png) 0 -216px no-repeat; }
.htmlnodelabel { margin-left: 20px; }
</style>
<table width="100%" cellpadding="0" cellspacing="0" style="border:#000000 thin solid; border-collapse:collapse;">
<tr>
        <td align="left" width="30%" valign="top">
			<?
                echo $pagina->oTree->gera_tree(0);
            ?>
        </td>
        <td width="70%" align="justify" valign="top">
        	<?
				$pagina->addTab(encode('modules/mod_teste/processos.php').'&recordID='.$_GET['recordID'],'Processos' ,false);
				echo $pagina->getTabs(0);
			?>
        </td>
    </tr>
</table>
<?php
  //echo encode('modules/mod_teste/tab_loader.php');
?> 

