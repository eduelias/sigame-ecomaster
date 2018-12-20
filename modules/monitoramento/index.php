<?php
	$pagina = new pagina('tree_monitor', 'Monitoramento');
	
	$pagina->addTree('monitor');
	
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

</style><?php
  //echo encode('modules/mod_teste/tab_loader.php');
  $pagina->imprime();
?> 
<div id="layout" style="height:550px;"></div>
			<div id="LEFT"><?
                echo $pagina->oTree->gera_TextTree(0);
            ?></div>
        	<div id="CENTER"<?
				$pagina->addTab(encode('modules/monitoramento/processos.php').'&recordID='.$_GET['recordID'],'Processos' ,false);
				echo $pagina->placeTabs(0);
			?></div>


<script>
	loader = new YAHOO.util.YUILoader({loadOptional:true});				
	loader.require('resize','layout');
	loader.insert();
	loader.onSuccess = function () {
		var layout = new YAHOO.widget.Layout('layout',{
		units:[
				{position:'left',body:'LEFT',scroll:true, resize:true, width:300,gutter:'2px', maxWidth: 400 },
				{position:'center',body:'CENTER',scroll:true, resize:true, width:600, gutter:'2px', minWidth: 500, maxWidth: 800 },
				{position:'bottom',body:'msg', height:20, gutter:'2px'}
			  ]
		});
		layout.render();
	}

</script>
