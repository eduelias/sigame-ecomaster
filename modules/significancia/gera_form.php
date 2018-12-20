<?
if (!headers_sent()){ header("Content-Type: text/html;charset=utf-8"); }
	$bsig = new bd();
	$tabela = 'rel_significancia';
	$barr = $bsig->gera_array('*','tb_significancia_impactos',' NOT hist = "S"');
	//pre($_GET);
	//echo encode("modules/significancia/act.php");
?>
    <form action="modules/significancia/act.php" onsubmit="return WBS.sendForm(this, 'nao')" method="post">
    <fieldset>
    <legend> Signific&acirc;cias - NOTAS </legend>
    <table width="100%" border="0" style="border-collapse:collapse;">
    <?php foreach ($barr as $k => $v) { ?>
    <?php $opt = explode(',',$v['descricao']); ?>
	<tr><td><?=iconv('iso-8859-1','utf-8',$v['label'])?>: </td><td><select name="<?=$v['idsignificancia_impactos']?>" id='sig_nota<?=$k?>'>
    	<?php foreach($opt as $c => $val) { ?>
        	<option value="<?php echo 0+str_replace('(','',$val);?>"><?=iconv('iso-8859-1','utf-8',$val)?></option>
        <?php } ?>
			 <span class="textfieldRequiredMsg">"<?=MSG_REQ?>"</span><span class="textfieldInvalidFormatMsg"><?=MSG_INV?></span><br><?=iconv('iso-8859-1','utf-8',$v['descricao'])?></label>
			<script>
			var sig_nota<?=$k?> = new Spry.Widget.ValidationTextField("sig_nota<?=$k?>", "custom", {validateOn:["blur"], useCharacterMasking:true, pattern:"000", isRequired:"true", requiredClass:'required', invalidClass:'invalid', validClass:'valid', focusClass:'focus'}) </script>
            </select></td>
    
    <?php } ?><input type="hidden" name='impacto' value="<?=$_GET['id']?>">
	<input type="submit" value="Registrar">
    </table>