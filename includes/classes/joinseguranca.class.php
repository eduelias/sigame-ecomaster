<?
	class joinseguranca {
		private $sql;
	
		function gera_array($p1,$p2,$id,$p4){
			$bseg = new bd();
			$seguranca = $bseg->gera_array('*','modulos','TRUE','1');
			$acesso = $bseg->gera_array('idmodulos,idgrupos','grupos_has_modulos','idgrupos='.$id,'idmodulos');
			foreach ($seguranca as $seg){
				if (is_array($acesso[$seg['idmodulos']])){
					$seguranca2[] = array(
						'idmodulos' => iconv('iso-8859-1','utf-8',$seg['idmodulos']),
						'nomem' => iconv('iso-8859-1','utf-8', $seg['nomem']),
						'modulos' => iconv('iso-8859-1','utf-8',$seg['modulo']),
						'idmenu_sistema' => iconv('iso-8859-1','utf-8',$seg['idmenu_sistema']),
						'checked' => $acesso[$seg['idmodulos']]['idgrupos']);
				} else {
					$seguranca2[] = array(
						'idmodulos' => iconv('iso-8859-1','utf-8',$seg['idmodulos']),
						'nomem' => iconv('iso-8859-1','utf-8',$seg['nomem']),
						'modulos' => iconv('iso-8859-1','utf-8',$seg['modulo']),
						'idmenu_sistema' => iconv('iso-8859-1','utf-8',$seg['idmenu_sistema']),
						'checked' => 'false');
				}
			}
			return $seguranca2;
			$this->sql = $bseg->get_sql();
			$i = 0;
			foreach ($seguranca as $seg) {
				if ($i > 0) { $sef[] = $seguranca[$i-1]; };
				$i++;
			};
		}
		
		function get_sql(){
			echo $this->sql;
		}
		
		function cria_acesso($codpg,$codgrp){
			$bseg = new bd();
			$arr = array('grupos_has_modulos@idmodulos' => $codpg,'grupos_has_modulos@idgrupos' => $codgrp);
			$res = $bseg->insere($arr);
			print_r($arr);
			$this->sql = $bseg->get_sql();
		}
		
		function retira_acesso($codpg,$codgrp){
			$bseg = new bd();
			$res = $bseg->send_sql('DELETE FROM grupos_has_modulos WHERE idmodulos = '.$codpg.' AND idgrupos = '.$codgrp);	$this->sql = $bseg->get_sql();
		}
	}
?>