<?
 include('../../includes/class.php'); 

 $bd = new bd();
 $ids = explode('_',$_POST['ID']);
 $sql = 'UPDATE empresa_teste1.rel_ambiental SET idempresa = '.$_POST['idempresa'].', periodo = '.$_POST['periodo'].', periodo_max ='.$_POST['periodo_max'].' WHERE idprocesso = '.$ids[0].' AND idatividade = '.$ids[1].' AND idaspecto_ambiental = '.$ids[2].' AND idimpacto = '.$ids[3].' AND idtipo_emissao ='.$ids[4].' AND iddestinacao_final ='.$ids[5]; 
 
 echo $sql;
 $bd->send_sql($sql);
 $bd->loga($bd->get_sql());
 ?>