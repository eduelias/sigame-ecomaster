<script>
/*
     Initialize and render the MenuBar when its elements are ready 
     to be scripted.
*/

YAHOO.util.Event.onContentReady("productsandservices", function () {

    /*
         Instantiate a MenuBar:  The first argument passed to the 
         constructor is the id of the element in the page 
         representing the MenuBar; the second is an object literal 
         of configuration properties.
    */

    var oMenuBar = new YAHOO.widget.MenuBar("productsandservices", { 
                                                autosubmenudisplay: true, 
                                                hidedelay: 750, 
                                                lazyload: true });

    /*
         Call the "render" method with no arguments since the 
         markup for this MenuBar instance is already exists in 
         the page.
    */

    oMenuBar.render();
	oMenuBar.show();

});

</script>
<div class="yui-skin-sam">
<div id="productsandservices" class="yuimenubar yuimenubarnav" style="position:static;">
<?


//PEGA O MENU DO USUÁRIO LOGADO a = g_h_m, s = modulos, 
	 $banco = new bd();
		$user_menu = $banco->gera_array(" `m`.`POS` as `pos`, `m`.`imagem`,`a`.`idgrupos` AS `codgrp`,`a`.`idmodulos` AS `codpg`,`a`.`inicio` AS `inicio`,`s`.`label` AS `nomem`,`s`.`modulo` AS `arquivo`, `s`.`idmenu_sistema` AS `codmenu`,`s`.`idmodulos` AS `modulo`,`s`.`manutencao` AS `manutencao`,`s`.`novo` AS `novo`,`m`.`menu` AS `menu`,`m`.`imagem` AS `image`,
`s`.`cor` AS `cor`","((`cfg_grupos_has_modulos` `a` left join `cfg_modulos` `s` on((`a`.`idmodulos` = `s`.`idmodulos`))) left join `cfg_menu_sistema` `m` on((`s`.`idmenu_sistema` = `m`.`idmenu_sistema`)))","((`s`.`habilitado` = _latin1'S') and (`m`.`habilitado` = _latin1'S')) AND `idgrupos` = ".$_SESSION['grupo']." ORDER BY pos");
	//echo $banco->get_sql();
	//echo "<pre>"; print_r($user_menu); echo "</pre>";
		$tmpcod = 0;
		?>
		<div class="bd">
            <ul class="first-of-type"><?
		foreach($user_menu as $linha) {

			//CHECA SE VAI CRIAR NOVA CATEGORIA
			if ($linha['codmenu'] != $tmpcod) {
				
				//CHECA SE VAI FECHAR O BLOCO DA CATEGORIA
				if ($tmpcod != 0)
					echo "</li></div></div>
";
				
				$tmpcod = $linha['codmenu'];
?>                     
	    
                <li class="yuimenubaritem first-of-type"><a class="yuimenubaritemlabel" href="#<?=$linha['menu']?>"><div align="center"><img src="images/<?=$linha['imagem']?>" height='30px' /><br /><?=$linha['menu']?></div></a>
                                   <div id="<?=$linha['menu']?>" class="yuimenu"><div class="bd"><ul>
<? } 		

	//IMPRIME OS SUB-ITENS DO MENU
	?>
                   <li class="yuimenuitem"><a class="yuimenuitemlabel" href="index.php?f=<?=encode("modules/".$linha['arquivo']."/index.php")?>"><?=$linha['nomem']?></a>
                   <? include('modules/'.$linha['arquivo'].'/menu.php'); ?>
                   </li>

	<?
		}
	?>

    </ul>
    </div>
    </div>
    </div>
</div>
 
<?
		$tmpcod = 0;
		$k = 0; ?>