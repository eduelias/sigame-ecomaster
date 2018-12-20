<script type="text/javascript">
	var myTabs = new YAHOO.widget.TabView("demo");
</script> 
<?php 
	$inserir = $login->permissoes(8,'inserir'); 
?>
<div id="demo" class="yui-navset" style="background-color:EEFFEE">
    <ul class="yui-nav">
        <?=($inserir)?'<li class="selected"><a href="#tab1"><em>Módulos</em></a></li>':'';?>
    </ul>            
    <div class="yui-content">
        <div><?php ($inserir)?include('modules/relations/dd_hander.php'):''; ?></div>
    </div>
</div>
<?php $_GET[recordID] = (isset($_GET[recordID])?$_GET[recordID]:1); ?>
<script> 
		myTabs.addTab( new YAHOO.widget.Tab({
        label: 'Permissões',
        dataSrc: 'geraconteudo.php?file=modules/permissoes/list_permissoes.php&recordID=<?php echo $_GET[recordID]; ?>',
        cacheData: false
    }));
		myTabs.set('activeIndex',0);
</script>