<?php

 //pre($_GET);
 
 $emp = new empresa();
 $bdado = new bd();
 
 //pre($emp->getAtividade($_GET['ID']));
 
 $h = $emp->getHierarquia(); //troca do tipo vindo pro próximo nível;
 $nivel = $h[$_GET['tipo']];
 //$nivel = ($nivel=='processos')?'processo':$nivel;
 $tabela = 'tb_'.$nivel;
 $id_f = 'id'.$nivel;
 $campos = $id_f.',label,descricao';
 //pre($bdado->gera_array($campos,$tabela,'true'));
 
 //pre($nivel);
 include('modules/'.$nivel.'/list_'.$nivel.'.php');
 
 
 echo $bdado->get_sql();
?>


