<?php


class relacoes extends bd {
	
	private $emp;
	
	private $tb_rel;
	
	private $arr_rel;
	
	private $tb_a;
	
	private $arr_a;
	
	private $tb_b;
	
	private $arr_b;
	
	private $campo_chave_a;
	
	private $chave_a;
	
	private $campo_chave_b;
	
	private $chave_b;
	
	public $sql;
	
	private $trues;
	
	private $falses;
	
	public $ex;
	
	public $nex;
	
	public function gera_array(){
		$this->arr_a = parent::gera_array('*',$this->tb_a,'TRUE','1'); 
		$this->arr_rel = parent::gera_array($this->campo_chave_a.','.$this->campo_chave_b,$this->tb_rel,$this->campo_chave_a.'='.$this->campo_a,$this->campo_chave_b);
		
		foreach ($this->arr_a as $for_a){
			if (is_array($arr_rel[$for_a[$this->campo_chave_a]])){
				$this->trues[] = array(
					$this->campo_chave_a => iconv('iso-8859-1','utf-8',$for_a[$this->campo_chave_a]));
			} else {
				$this->falses[] = array(
					$this->campo_chave_a => iconv('iso-8859-1','utf-8',$for_a[$this->campo_chave_a]));
			}
		}
		$this->sql = parent::get_sql();
		echo "<pre>";
		print_r($this->trues);
		echo "</pre>";
		return $this->arr_a;
	}
	
	function relacoes($campo_a, $campo_b, $valor_a, $valor_b, $tabela_a, $tabela_b, $tb_relacao,$empresa = ''){
		$this->emp = (isset($_SESSION['empresa']))?$_SESSION['empresa']:$empresa;
		$this->campo_chave_a = $campo_a;
		$this->campo_chave_b = $campo_b;
		$this->campo_a = $valor_a;
		$this->campo_b = $valor_b;
		$this->tb_a = $tabela_a;
		$this->tb_b = $tabela_b;
		$this->tb_rel = $tb_relacao;
		echo "<script> SIGAME.nome_tb_rel ='".$this->tb_rel."'; SIGAME.nome_campo_a ='".$this->campo_chave_a."'; SIGAME.nome_campo_b ='".$this->campo_chave_b."'; SIGAME.valor_campo_a ='".$this->campo_a."'; SIGAME.valor_campo_b ='".$this->campo_b."';</script>";
	}
	
	function rel($campo_a, $campo_b, $valor_a, $valor_b, $tabela_rel, $empresa = ''){
		$this->emp = (isset($_SESSION['empresa']))?$_SESSION['empresa']:$empresa;
		$this->campo_chave_a = $campo_a;
		$this->campo_chave_b = $campo_b;
		$this->campo_a = $valor_a;
		$this->campo_b = $valor_b;
		$this->tb_a = $tabela_a;
		$this->tb_b = $tabela_b;
		$this->tb_rel = $tabela_rel;
	}
	
	function cria_relacao(){	
		$arr_ins = array($this->tb_rel.'@'.$this->campo_chave_a => $this->campo_a,$this->tb_rel.'@'.$this->campo_chave_b => $this->campo_b);
		$res = parent::insere($arr_ins);
		print_r($arr);
		$this->sql = parent::get_sql();
	}
	
	function destroi_relacao(){
		$empresa_fil = ($this->emp != 'null')?' AND idempresa = '.$this->emp:'';
		parent::send_sql('DELETE FROM '.$this->tb_rel.' WHERE '.$this->campo_chave_a.' = '.$this->campo_a.' AND '.$this->campo_chave_b.' = '.$this->campo_b.$empresa_fil);	
		$this->sql = parent::get_sql();
	}

	function gera_lista_existe($titulo){
		$bd = new bd();
		$rel_ex = $bd->gera_array($this->tb_rel.'.'.$this->campo_chave_a.','.$this->tb_rel.'.'.$this->campo_chave_b.',label',$this->tb_rel.' JOIN '.$this->tb_b.' ON '.$this->tb_rel.'.'.$this->campo_chave_b.'='.$this->tb_b.'.'.$this->campo_chave_b,$this->tb_rel.'.'.$this->campo_chave_a.'='.$this->campo_a);


		$this->ex = "<div class='workarea' style='display: table-cell'>";
		$this->ex .= "<h3> ".((isset($titulo))?$titulo:iconv('utf-8','iso-8859-1',"Relações existentes"))." </h3>";
		$this->ex .= "<ul id=\"ul1\" class=\"draglist\">";
		
		$i = 1;
		if(is_array($rel_ex)){
				foreach ($rel_ex as $ex){
				$this->ex .= "<li class=\"list2\" id=\"li2_".$i."\" value='".$ex[$this->campo_chave_b]."'> ".$ex['label']." </li>";
				$i++;
			}
		}
		$this->ex .= "</ul></div>";
		
		$this->trues = $rel_ex;
	}
	
	function gera_lista_nex($titulo){
		$string = '';
		if (count($rel_ex!=0)){
			foreach ($this->trues as $exs){
				$string .= ($string=='')?' NOT '.$this->campo_chave_b.'= '.$exs[$this->campo_chave_b]:' AND NOT '.$this->campo_chave_b.'= '.$exs[$this->campo_chave_b];
			}
		} else {
			$string = '';
		}
		//pre($string);
		$bd = new bd();
		$rel_nex = $bd->gera_array('*',$this->tb_b , $string,'1');
		//pre($rel_nex);
		$this->nex = "<div class='workarea' style='display:table-cell'>";
		$this->nex .= "<h3> ".((isset($titulo))?$titulo:iconv('utf-8','iso-8859-1',"Relações não existentes"))." </h3>";
		$this->nex .= "<ul id=\"ul2\" class=\"draglist\">";
		//pre($rel_nex);
		
		$i=1;
		if(is_array($rel_nex)){
			foreach ($rel_nex as $nex){
				$this->nex .= "<li class=\"list1\" id=\"li1_".$i."\" value='".$nex[$this->campo_chave_b]."'> ".$nex['label']."</li>";
				$i++;
			}
		}
		$this->nex .= "</ul></div>";
		
		
	}
	
	function gera_quadro(){
		echo include('includes/js/ddrop.php');
		$this->gera_lista_ex();
		$this->gera_lista_nex();
	}

}


?>