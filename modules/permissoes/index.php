<?php include('modules/permissoes/list_grupos.php'); ?>
    <?php
        $inserir = $login->permissoes(8,'inserir'); 
        $_GET['recordID'] = (isset($_GET['recordID'])?$_GET['recordID']:1);
        ($inserir)?$pagina->addTab(encode('modules/relations/dd_hander.php').'&recordID='.$_GET['recordID'],'Modulos',true):'';
        $pagina->addTab(encode('modules/permissoes/list_permissoes.php').'&recordID='.$_GET['recordID'],'Permissões' ,false);
        
    ?>


        <?php echo $pagina->imprime(); ?>

        <?php 	echo $pagina->placeTabs(0);   ?>
<?php $_GET['src'] = (isset($_GET['src']))?$_GET['src']:'geraconteudo.php?file=modules/relations/dd_hander.php'; ?>