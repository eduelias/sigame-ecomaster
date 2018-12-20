<?
 include('../../includes/class.php'); 

 $bd = new bd();
 $ids = explode('_',$_POST['ID']);
 $sql = 'INSERT INTO empresa_teste1.rel_monitor (idprocesso,idatividade,idaspecto_ambiental,idimpacto,idtipo_emissao,iddestinacao_final,idempresa,numnf,qtde,datanf,data_monitor) 
 VALUES 
 ('.$ids[0].','.$ids[1].','.$ids[2].','.$ids[3].','.$ids[4].','.$ids[5].',"'.$_POST['idempresa'].'",'.$_POST['numnf'].',"'.$_POST['qtde'].'","'.$_POST['datanf'].'","'.date('Y-m-d').'")';
 echo $sql;
 $bd->send_sql($sql);
 $bd->loga($bd->get_sql());

?>