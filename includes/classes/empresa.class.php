<?

	class empresa extends bd{
	
		public $bgeral = 'web4_db2';
	
		public $empresa = 'teste1';
		
		public $tb_empresa;
	
		public $banco;
		
		public $processo;
		
		public $tb_processo;
		
		public $id_processo;
		
		public $atividade;
		
		public $aspecto_ambiental;
		
		public $impacto;
		
		public $emissao;
		
		public $destinacao_final;
		
		private $retorno;
		
		public $hierarquia;
		
		public $index = array(0=>'processo',1=>'atividade',2=>'aspecto_ambiental',3=>'impacto',4=>'tipo_emissao',5=>'destinacao_final');
		
		public function removeById($id){
			$aux = explode('_',$id);
			$sql = 'DELETE FROM `empresa_teste1`.`rel_ambiental` WHERE ';
			foreach ($aux as $k => $v){
				$sql .= 'id'.$this->index[$k].' = '.$aux[$k].' AND ';
			}
			$sql .= ' TRUE';
			echo $sql;
			parent::send_sql($sql);
		}
		public function get_sql(){
			return parent::get_sql();
		}
		
		public function removecriterio($id){
			$aux = explode('_',$id);
			$sql = 'DELETE FROM `empresa_teste1`.`rel_arvore_has_criterio` WHERE ';
			foreach ($aux as $k => $v){
				$sql .= 'id'.$this->index[$k].' = '.$aux[$k].' AND ';
			}
			$sql .= ' TRUE';
			echo $sql;
			parent::send_sql($sql);
		}
		
		public function getIcon($sig){
			switch (true) {
				case ($sig == 0) : {
					return 0;
				}break;
				case ($sig <= 100) : {
					return 'icon-boneco';
				}break;
				case (($sig >= 100) && ($sig <= 150)) : {
					return 'icon-alert';
				}break;
				case ($sig >= 150): {
					return 'icon-x';
				}break;
				default : {
					return 'icon-x';
				}break;
			}
		}
		
		public function getHierarquia(){
			$hierarquia['processo'] = 'empresa';
			$hierarquia['atividade'] = 'processo';
			$hierarquia['aspecto_ambiental'] = 'atividade';
			$hierarquia['impacto'] = 'aspecto_ambiental';
			$hierarquia['tipo_emissao'] = 'impacto';
			$hierarquia['destinacao_final'] = 'tipo_emissao';
			$hierarquia['periodos'] = 'destinacao_final';
			@$this->hierarquia = array_flip($hierarquia);
			return $this->hierarquia;
		}
		
		public function getaux_emissao($id = 0){
		$labs[0] = 'Impactos';
		$labs[1] = 'Destinação final';
		$labs[2] = 'Critérios pertinentes';
		$ico[0] = '';
		$ico[1] = '';
		$ico[2] = '';
		$aux[0] = 'impacto';
		$aux[1] = 'destinacao_final';
		$aux[2] = 'criterios_pertinentes';
		
		foreach ($labs as $k => $v){
			$this->aux_em[] = array('label'=>$v, 'tipo'=>$aux[$k], 'ID'=>$v['ID'], 'estilo' => $ico[$k], 'leaf'=>false);
		}
		 //pre($this->aux_em);
		return $this->aux_em;
		}
		
		public function getProcessos($empresa = 'teste1'){
			$this->empresa = $empresa;
			$this->banco = 'empresa_'.$empresa;
			$this->tb_processo = $this->bgeral.'.tb_processo';
			$this->tb_empresa = $this->banco.'.rel_ambiental';
			$result = parent::gera_array('DISTINCT('.$this->tb_processo.'.label) as label, MAX('.$this->tb_empresa.'.significancia) as sig,'.$this->tb_processo.'.idprocesso as ID',$this->tb_processo.' JOIN '.$this->tb_empresa.' ON '.$this->tb_processo.'.idprocesso = '.$this->tb_empresa.'.idprocesso','TRUE GROUP BY label');
			
			if (is_array($result)){
				foreach ($result as $chave => $val){
					$child = parent::gera_array('idatividade',$this->tb_empresa,' idprocesso = '.$val['ID'].' AND NOT idatividade = 0');
					$icons = $this->getIcon($val['sig']);
					$leaf = (is_array($child))?false:true;
					$this->processo[] = array('label'=>'PROCESSO: '.$val['label'], 'tipo'=>'processo', 'ID'=>$val['ID'], 'estilo' => $icons, 'leaf'=>$leaf);
				}
			}
			//echo parent::get_sql();
			//return parent::get_sql();
			return $this->processo;
		}
		
		public function getAtividade($id_proc){
			$this->id_processo = $id_proc;
			$this->banco = 'empresa_'.$this->empresa;
			$this->tb_empresa = $this->banco.'.rel_ambiental';
			$this->tb_atividade = $this->bgeral.'.tb_atividade';
			$result = parent::gera_array('DISTINCT('.$this->tb_atividade.'.label) as label, MAX('.$this->tb_empresa.'.significancia) as sig,'.$this->tb_atividade.'.idatividade as ID',$this->tb_atividade.' JOIN '.$this->tb_empresa.' ON '.$this->tb_atividade.'.idatividade = '.$this->tb_empresa.'.idatividade', $this->tb_empresa.'.idprocesso = '.$id_proc.' GROUP BY label');
			if (is_array($result)){
				foreach ($result as $chave => $val){
					$child = parent::gera_array('idaspecto_ambiental',$this->tb_empresa,'idprocesso = '.$this->id_processo.' AND idatividade = '.$val['ID'].' AND NOT idaspecto_ambiental = 0');
					$icons = $this->getIcon($val['sig']);
					$leaf = (is_array($child))?false:true;
					$this->atividade[] = array('label'=>'ATIVIDADE: '.$val['label'], 'tipo'=>'atividade', 'ID'=>$id_proc.'_'.$val['ID'], 'estilo'=>$icons, 'leaf'=>$leaf);
				}
			}
			return $this->atividade;
		}
		
		public function getAspecto($ids){
			$funcao = 'aspecto_ambiental';
			$id_arr = explode('_',$ids);
			$this->id_processo = $id_arr[0];
			$this->id_atividade = $id_arr[1];
			$this->banco = 'empresa_'.$this->empresa;
			$this->tb_empresa = $this->banco.'.rel_ambiental';
			$this->tb_detalhe = $this->bgeral.'.tb_'.$funcao;
			$result = parent::gera_array('DISTINCT('.$this->tb_detalhe.'.label) as label, MAX('.$this->tb_empresa.'.significancia) as sig,'.$this->tb_detalhe.'.id'.$funcao.' as ID',$this->tb_detalhe.' JOIN '.$this->tb_empresa.' ON '.$this->tb_detalhe.'.id'.$funcao.' = '.$this->tb_empresa.'.id'.$funcao, $this->tb_empresa.'.idprocesso = '.$this->id_processo.' AND '.$this->tb_empresa.'.idatividade = '.$this->id_atividade.' GROUP BY label');
			if (is_array($result)){
				foreach ($result as $chave => $val){
					$child = parent::gera_array('idimpacto',$this->tb_empresa,'idprocesso = '.$this->id_processo.' AND idatividade = '.$this->id_atividade.' AND idaspecto_ambiental = '.$val['ID'].' AND NOT idimpacto = 0');
					$icons = $this->getIcon($val['sig']);
					$leaf = (is_array($child))?false:true;
					$this->retorno[] = array('label'=>'ASPECTO: '.$val['label'], 'tipo'=>'aspecto_ambiental', 'ID'=>$this->id_processo.'_'.$this->id_atividade.'_'.$val['ID'], 'estilo'=>$icons, 'leaf'=>$leaf);
				}
			}
			//echo parent::get_sql();
			return $this->retorno;
		}
		
		public function getImpacto($ids){
			$funcao = 'impacto';
			$id_arr = explode('_',$ids);
			$this->id_processo = $id_arr[0];
			$this->id_atividade = $id_arr[1];
			$this->id_aspecto = $id_arr[2];
			$this->banco = 'empresa_'.$this->empresa;
			$this->tb_empresa = $this->banco.'.rel_ambiental';
			$this->tb_detalhe = $this->bgeral.'.tb_'.$funcao;
			$result = parent::gera_array('DISTINCT('.$this->tb_detalhe.'.label) as label, MAX('.$this->tb_empresa.'.significancia) as sig,'.$this->tb_detalhe.'.id'.$funcao.' as ID',$this->tb_detalhe.' JOIN '.$this->tb_empresa.' ON '.$this->tb_detalhe.'.id'.$funcao.' = '.$this->tb_empresa.'.id'.$funcao, $this->tb_empresa.'.idprocesso = '.$this->id_processo.' AND '.$this->tb_empresa.'.idatividade = '.$this->id_atividade.' AND '.$this->tb_empresa.'.idaspecto_ambiental = '.$this->id_aspecto.' GROUP BY label');
			if (is_array($result)){
				//pre($result);
				foreach ($result as $chave => $val){
				$icons = $this->getIcon($val['sig']);
					$child = parent::gera_array('idtipo_emissao',$this->tb_empresa,'idprocesso = '.$this->id_processo.' AND idatividade = '.$this->id_atividade.' AND idaspecto_ambiental = '.$this->id_aspecto.' AND idimpacto = '.$val['ID'].' AND NOT idtipo_emissao = 0');
					$leaf = (is_array($child))?false:true;
					//$leaf = false;
					$this->retorno[] = array('label'=>'IMPACTO: '.$val['label'], 'tipo'=>'impacto', 'ID'=>$this->id_processo.'_'.$this->id_atividade.'_'.$this->id_aspecto.'_'.$val['ID'], 'estilo'=>$icons, 'leaf'=>$leaf);
				}
			}
			//return parent::get_sql();
			return $this->retorno;
		}
		
		public function getEmissao($ids){
			$funcao = 'tipo_emissao';
			$id_arr = explode('_',$ids);
			$this->id_processo = $id_arr[0];
			$this->id_atividade = $id_arr[1];
			$this->id_aspecto = $id_arr[2];
			$this->id_impacto = $id_arr[3];
			$this->banco = 'empresa_'.$this->empresa;
			$this->tb_empresa = $this->banco.'.rel_ambiental';
			$this->tb_detalhe = $this->bgeral.'.tb_'.$funcao;
			$result = parent::gera_array('DISTINCT('.$this->tb_detalhe.'.label) as label,'.$this->tb_detalhe.'.id'.$funcao.' as ID',$this->tb_detalhe.' JOIN '.$this->tb_empresa.' ON '.$this->tb_detalhe.'.id'.$funcao.' = '.$this->tb_empresa.'.id'.$funcao, $this->tb_empresa.'.idprocesso = '.$this->id_processo.' AND '.$this->tb_empresa.'.idatividade = '.$this->id_atividade.' AND '.$this->tb_empresa.'.idaspecto_ambiental = '.$this->id_aspecto.' AND '.$this->tb_empresa.'.idimpacto ='.$this->id_impacto);
			if (is_array($result)){
				foreach ($result as $chave => $val){
					$child = parent::gera_array('iddestinacao_final',$this->tb_empresa,'idprocesso = '.$this->id_processo.' AND idatividade = '.$this->id_atividade.' AND idaspecto_ambiental = '.$this->id_aspecto.' AND idimpacto = '.$this->id_impacto.' AND idtipo_emissao = '.$val['ID'].' AND NOT iddestinacao_final = 0');
					$leaf = (is_array($child))?false:true;
					$this->retorno[] = array('label'=>'EMISSAO: '.$val['label'], 'tipo'=>$funcao, 'ID'=>$this->id_processo.'_'.$this->id_atividade.'_'.$this->id_aspecto.'_'.$this->id_impacto.'_'.$val['ID'], 'estilo'=>$icons, 'leaf'=>$leaf);
				}
			}
			//return parent::get_sql();
			return $this->retorno;
		}
		
		public function getDestinacao($ids){
			$funcao = 'destinacao_final';
			$id_arr = explode('_',$ids);
			$this->id_processo = $id_arr[0];
			$this->id_atividade = $id_arr[1];
			$this->id_aspecto = $id_arr[2];
			$this->id_impacto = $id_arr[3];
			$this->id_emissao = $id_arr[4];
			$this->banco = 'empresa_'.$this->empresa;
			$this->tb_empresa = $this->banco.'.rel_ambiental';
			$this->tb_detalhe = $this->bgeral.'.tb_'.$funcao;
			$result = parent::gera_array('DISTINCT('.$this->tb_detalhe.'.label) as label,'.$this->tb_detalhe.'.id'.$funcao.' as ID',$this->tb_detalhe.' JOIN '.$this->tb_empresa.' ON '.$this->tb_detalhe.'.id'.$funcao.' = '.$this->tb_empresa.'.id'.$funcao, $this->tb_empresa.'.idprocesso = '.$this->id_processo.' AND '.$this->tb_empresa.'.idatividade = '.$this->id_atividade.' AND '.$this->tb_empresa.'.idaspecto_ambiental = '.$this->id_aspecto.' AND '.$this->tb_empresa.'.idimpacto ='.$this->id_impacto.' AND '.$this->tb_empresa.'.idtipo_emissao = '.$this->id_emissao);
			if (is_array($result)){
				foreach ($result as $chave => $val){
					$this->retorno[] = array('label'=>'DESTINO: '.$val['label'], 'tipo'=>$funcao, 'ID'=>$this->id_processo.'_'.$this->id_atividade.'_'.$this->id_aspecto.'_'.$this->id_impacto.'_'.$this->id_emissao.'_'.$val['ID'], 'estilo'=>$icons, 'leaf'=>true);
				}
			}
			//return parent::get_sql();
			return $this->retorno;
		}
		
		public function getCriterios($arra){
			$funcao = 'criterios_pertinentes';
			$ids = iconv('utf-8','iso-8859-1',$arra);
			$id_arr = explode('_',$ids);
			//pre($id_arr);
			$this->id_processo = $id_arr[0];
			$this->id_atividade = $id_arr[1];
			$this->id_aspecto = $id_arr[2];
			$this->id_impacto = $id_arr[3];
			$this->id_emissao = $id_arr[4];
			$this->banco = 'empresa_'.$this->empresa;
			$this->tb_empresa = $this->banco.'.rel_arvore_has_criterio';
			$this->tb_detalhe = $this->bgeral.'.tb_'.$funcao;
			
			$campos = 'DISTINCT('.$this->tb_detalhe.'.label) as label, '.$this->tb_detalhe.'.descricao ,'.$this->tb_detalhe.'.id'.$funcao.' as ID';
			$tabelas = $this->tb_detalhe.' JOIN '.$this->tb_empresa.' ON '.$this->tb_detalhe.'.id'.$funcao.' = '.$this->tb_empresa.'.id'.$funcao;
			
			$cond = $this->tb_empresa.'.idprocesso = '.$this->id_processo;
			if ($this->id_atividade) { $cond .= ' AND '.$this->tb_empresa.'.idatividade = '.$this->id_atividade;	}
			if ($this->id_aspecto) { $cond .= ' AND '.$this->tb_empresa.'.idaspecto_ambiental = '.$this->id_aspecto; }
			if ($this->id_impacto) { $cond .=' AND '.$this->tb_empresa.'.idimpacto ='.$this->id_impacto; }
			if ($this->id_emissao) { $cond .=' AND '.$this->tb_empresa.'.idtipo_emissao = '.$this->id_emissao; }
			$sql = 'SELECT '.$campos.' FROM '.$tabelas.' WHERE '.$cond;
			
			
			//parent::send_sql('INSERT INTO `web4_db2`.`tb_log` (`SQL`) VALUES ("'.$sql.'");');
			$result = parent::gera_array($campos,$tabelas,$cond);
			if (is_array($result)){
				foreach ($result as $chave => $val){
					$this->retorno[] = array($chave=>$val);
				}
			}
			//return parent::get_sql();
			return $this->retorno;
		}
		
		public function addprocessos($nil, $array){
			$anter = false;
			$procs = $this->getProcessos();
			if (is_array($procs)){
				foreach ($procs as $item => $vals){
					$pr_id[$vals['ID']] = $vals['ID'];
					$anter = true;
				}
			}
			$str = 'INSERT INTO `empresa_teste1`.`rel_ambiental` (`idprocesso`) VALUES ';
			foreach ($array as $chave => $valor){
				if ($anter){
					if (!in_array($valor, $pr_id)){
						$str .= '('.$valor.'),';
					}
				} else { 
						$str .= '('.$valor.'),';
				}
			}
			$str = substr($str,0,-1);
			$bd = new bd();
			$bd->send_sql($str);
			return $bd->get_sql();
		}
			
		public function addatividade($id, $array){
			$str = 'INSERT INTO `empresa_teste1`.`rel_ambiental` (`idprocesso`,`idatividade`) VALUES ';
			foreach ($array as $chave => $valor){
					$str .= '('.$id[0].','.$valor.'),';
			}
			$str = substr($str,0,-1);
			$bd = new bd();
			$bd->send_sql($str);
			return $bd->get_sql(); 
		}
		
		public function addaspecto_ambiental($id, $array){
			$str = 'INSERT INTO `empresa_teste1`.`rel_ambiental` (`idprocesso`,`idatividade`,`idaspecto_ambiental`) VALUES ';
			foreach ($array as $chave => $valor){
					$str .= '('.$id[0].','.$id[1].','.$valor.'),';
			}
			$str = substr($str,0,-1);
			$bd = new bd();
			$bd->send_sql($str);
			return $bd->get_sql(); 
		}
			
		public function addimpacto($id, $array){
			$str = 'INSERT INTO `empresa_teste1`.`rel_ambiental` (`idprocesso`,`idatividade`,`idaspecto_ambiental`,`idimpacto`) VALUES ';
			foreach ($array as $chave => $valor){
					$str .= '('.$id[0].','.$id[1].','.$id[2].','.$valor.'),';
			}
			$str = substr($str,0,-1);
			$bd = new bd();
			$bd->send_sql($str);
			return $bd->get_sql(); 
		}
		
		public function addtipo_emissao($id, $array){
			$bd = new bd();
			$result = $bd->gera_array('significancia','empresa_teste1.rel_ambiental','idprocesso = '.$id[0].' AND idatividade = '.$id[1].' AND idaspecto_ambiental = '.$id[2].' AND idimpacto = '.$id[3]);
			$bd->loga($bd->get_sql());
			$acc = 0;
			foreach ($result as $k=>$v){
				$acc = ($v['significancia']>>$acc)?$v['significancia']:$acc;
			}
			
		//	$sql = 'DELETE FROM `empresa_teste1`.`rel_ambiental` where idprocesso = '.$id[0].' AND idatividade = '.$id[1].' AND idaspecto_ambiental = '.$id[2].' AND idimpacto = '.$id[3].' AND idtipo_emissao = 0 LIMIT 1';
		//	$bd->send_sql($sql);
			
			$str = 'INSERT INTO `empresa_teste1`.`rel_ambiental` (`idprocesso`,`idatividade`,`idaspecto_ambiental`,`idimpacto`,`idtipo_emissao`,`significancia`) VALUES ';
			foreach ($array as $chave => $valor){
					$str .= '('.$id[0].','.$id[1].','.$id[2].','.$id[3].','.$valor.','.$acc.'),';
			}
			$str = substr($str,0,-1);
			
			$bd->send_sql($str);
			return $bd->get_sql(); 
		}
		
		public function adddestinacao_final($id, $array){			
			$bd = new bd();
			$result = $bd->gera_array('significancia','empresa_teste1.rel_ambiental','idprocesso = '.$id[0].' AND idatividade = '.$id[1].' AND idaspecto_ambiental = '.$id[2].' AND idimpacto = '.$id[3].' AND idtipo_emissao ='.$id[4]);
			$bd->loga($bd->get_sql());
			$acc = 0;
			foreach ($result as $k=>$v){
				$acc = ($v['significancia']>>$acc)?$v['significancia']:$acc;
			}
			
		//	$sql = 'DELETE FROM `empresa_teste1`.`rel_ambiental` where idprocesso = '.$id[0].' AND idatividade = '.$id[1].' AND idaspecto_ambiental = '.$id[2].' AND idimpacto = '.$id[3].' AND idtipo_emissao = '.$id[4].' AND iddestinacao_final = 0 LIMIT 1';
			
		//	$bd->send_sql($sql);
									
			$str = 'INSERT INTO `empresa_teste1`.`rel_ambiental` (`idprocesso`,`idatividade`,`idaspecto_ambiental`,`idimpacto`,`idtipo_emissao`, `iddestinacao_final`,`significancia`) VALUES ';
			foreach ($array as $chave => $valor){
					$str .= '('.$id[0].','.$id[1].','.$id[2].','.$id[3].','.$id[4].','.$valor.','.$acc.'),';
			}
			$str = substr($str,0,-1);

			$bd->send_sql($str);
			return $bd->get_sql(); 
		}
		
		
		public function addcriterios_pertinentes($id, $array){	
			$bd = new bd();		
			
			$str = 'INSERT INTO `empresa_teste1`.`rel_arvore_has_criterio` (`idprocesso`,`idatividade`,`idaspecto_ambiental`,`idimpacto`, `idcriterios_pertinentes`,`data_inicio`) VALUES ';
			foreach ($array as $chave => $valor){
				$id = explode('_',$valor);
				$str .= '('.$id[0].','.(($id[1])?$id[1]:'0').','.(($id[2])?$id[2]:'0').','.(($id[3])?$id[3]:'0').','.(($id[4])?$id[4]:'0').',"'.date('Y-m-d').'"),';
			}
			
			$str = substr($str,0,-1);
			//$bd->send_sql('INSERT INTO `web4_db2`.`tb_log` (`SQL`) VALUES ("'.$str.'");');
			echo $str;
			$bd->send_sql($str);
			return $bd->get_sql(); 
			//return $str;
		}
	}

?>