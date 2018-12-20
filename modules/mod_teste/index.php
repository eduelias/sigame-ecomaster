<?php
	$pagina = new pagina('tree_teste', "Fluxo de processos");
	
	$pagina->addTree('lateral');
	
	$obj['campos'] = 'label';
	$obj['tabela'] = 'tb_processo';
	$obj['condicao'] = 'TRUE';
	$ec = $pagina->oTree->getJson($obj);
?>
<script>var loader = new YAHOO.util.YUILoader({base:"http://www.ipaservice.com.br/sigame/includes/yui/<?=YUI_VER?>/build/",loadOptional:true}); 		
				loader.addModule({
					name:'dtable',
					type:'js',
					fullpath:'http://www.ipaservice.com.br/sigame/includes/yui/<?=YUI_VER?>/build/datatable/datatable-beta-min.js',
					varName:'YDT',
					requires:['yahoo','event','datasource']
				});
				loader.addModule({
					name:'formatter',
					type:'js',
					fullpath:'http://www.ipaservice.com.br/sigame/includes/js/formatters.js',
					varName:'FMT',
					requires:['yahoo','event','dtable']
				});
				loader.addModule({
					name:'overlap',
					type:'css',
					fullpath:'http://www.ipaservice.com.br/sigame/templates/css/overlap.css',
					varName:'OVL'
				});
				loader.require('formatter');
				if (typeof YAHOO.widget.DataTable == 'undefined'){
						loader.insert();
				}
		</script>

<?php
//
  $pagina->imprime(); //echo encode('modules/mod_teste/tab_loader.php');
?> 
<?	
	$emp = new empresa();
	$emp->get_sql();
?>
<div id="layout" style="height:545"></div>
			<div id="LEFT">
			<?
                echo $pagina->oTree->gera_tree(0);
            ?>
            </div>
           <div id="CENTER">
           	<div id=
        	<?
				//$pagina->addTab(encode('modules/mod_teste/processos.php').'&recordID='.$_GET['recordID'],'Processos' , 'true');
				//$pagina->placeTabs(0);
			?>
			</div>


<script>
	WBS.cen =  new YAHOO.widget.Panel('CENTER', {close:false, draggable:false, height:'100%'});
	loader = new YAHOO.util.YUILoader({loadOptional:true, after:'overlap'});	
	loader.addModule({
		name:'overlap',
		type:'css',
		fullpath:'http://www.ipaservice.com.br/sigame/templates/css/overlap.css',
		varName:'OVL'
	});			
	loader.require('resize','layout','overlap');
	loader.insert();
	loader.onSuccess = function () {
		var layout = new YAHOO.widget.Layout('layout',{
		units:[
				{position:'left',body:'LEFT',scroll:true, resize:true, width:300,gutter:'2px', maxWidth: 400 },
				{position:'center',body:'CENTER',scroll:false, resize:true, width:600, gutter:'0px', minWidth: 500, maxWidth: 800 },
				{position:'bottom',body:'msg', height:20, gutter:'0px'}
			  ]
		});
		layout.render();
	}

</script>
