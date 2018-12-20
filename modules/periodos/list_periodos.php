<?

//pre($_GET);
$bd = new bd();
$ids = explode('_',$_GET['ID']);

$res = $bd->gera_array('periodo,periodo_max,idempresa','empresa_teste1.rel_ambiental','idprocesso = '.$ids[0].' AND idatividade = '.$ids[1].' AND idaspecto_ambiental = '.$ids[2].' AND idimpacto = '.$ids[3].' AND idtipo_emissao = '.$ids[4].' AND iddestinacao_final = '.$ids[5]);

pre($rs);

pre($empresa);
?>
<h1>PADR&Otilde;ES DE MONITORAMENTO</h1>
<hr>
<form action="modules/periodos/act.php" method="post" onSubmit="return WBS.sendForm(this,false)">
<table border="0" width="100%">
<input type="hidden" name="ID" value="<?=$_GET['ID']?>"
<tr><td align="right"><label> EMPRESA: </label></td><td><select name="idempresa">
<?php 
	
	$rs = $bd->gera_array('idempresa,nome_fantasia','web4_db2.tb_empresas','TRUE');
	foreach ($rs as $k => $v){	?>
		<option value="<?=$v['idempresa']?>" <?=($v['idempresa']==$res[0]['idempresa'])?'SELECTED':'';?>><?=$v['nome_fantasia']?></option>
<?php } ?>
    </select></td><td align="right"><label> PERIODO: </label></td><td><select name="periodo">
    <?php $campo = 'periodo'; ?>
		<option value="1" <?=(1==$res[0][$campo])?'SELECTED':'';?>> DI&Aacute;RIO </option>
        <option value="7" <?=(7==$res[0][$campo])?'SELECTED':'';?>> SEMANAL </option>
        <OPTION value="15" <?=(15==$res[0][$campo])?'SELECTED':'';?>> QUINZENAL </OPTION>
        <option value="30" <?=(30==$res[0][$campo])?'SELECTED':'';?>> MENSAL </option>
        <option value="60" <?=(60==$res[0][$campo])?'SELECTED':'';?>> BIMESTRAL </option>
        <option value="90" <?=(90==$res[0][$campo])?'SELECTED':'';?>> TRIMESTRAL </option>
        <option value="180" <?=(180==$res[0][$campo])?'SELECTED':'';?>> SEMESTRAL </option>
        <option value="365" <?=(365==$res[0][$campo])?'SELECTED':'';?>> ANUAL </option>
        <OPTION value="730" <?=(730==$res[0][$campo])?'SELECTED':'';?>> BIENAL </OPTION>
    </select></td><td align="right"><label> PERIODO MAXIMO: </label></td><td><select name="periodo_max">
    <?php $campo = 'periodo_max'; ?>
		<option value="1" <?=(1==$res[0][$campo])?'SELECTED':'';?>> 1 DIA </option>
        <option value="5" <?=(5==$res[0][$campo])?'SELECTED':'';?>> 5 DIAS </option>
        <OPTION value="10" <?=(10==$res[0][$campo])?'SELECTED':'';?>> 10 DIAS </OPTION>
        <option value="15" <?=(15==$res[0][$campo])?'SELECTED':'';?>> 15 DIAS</option>
        <option value="20" <?=(20==$res[0][$campo])?'SELECTED':'';?>> 20 DIAS </option>
        <option value="25" <?=(25==$res[0][$campo])?'SELECTED':'';?>> 25 DIAS </option>
        <option value="30" <?=(30==$res[0][$campo])?'SELECTED':'';?>> 30 DIAS </option>
    </select></td></tr>
    <TR><TD colspan="6" align="center"><input type="submit" value="REGISTRAR"></TD></TR>
</table>