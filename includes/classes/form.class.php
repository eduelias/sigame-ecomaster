<?php
class form extends bd {
	private $idformulario;
	private $titulo;
	private $style;
	private $method;
	private $action;
	private $cap_sub;
	private $cap_rest;
	private $js;
	public $spt;
	
	function get_script(){
		return $this->spt;
	}

	function prepara($matriz){
		$this->idcampo_formulario = $matriz['idcampo_formulario'];
		$this->idformulario = $matriz['idformulario'];
		$this->label = $matriz['label'];
		$this->tipo = $matriz['tipo'];
		$this->elname = $matriz['elname'];
		$this->elid = $matriz['elid'];
		$this->tamanho = $matriz['tamanho'];
		$this->cap_sub = $matriz['cap_submit'];
		$this->cap_rest = $matriz['cap_reset'];
		$this->tabela_master = $matriz['tabela_master'];
		$this->tabela_master_campo = $matriz['abela_master_campo'];
		$this->js = $matriz['js'];
		$this->style = $matriz['style'];
		$this->tabela_detalhe = $matriz['tabela_detalhe'];
		$this->tabela_campo_detalhe = $matriz['tabela_campo_detalhe'];
		$this->valor = $matriz['valor'];
	}	
	
	
	function imprime($form_id,$recordID){
		include('field.class.php');
		
		$row_tb_form_field = parent::gera_array('*','frm_formulario','idformulario ='.$form_id);
		
		$cap_submit = $row_tb_form_field[0]['cap_submit'];
		$cap_reset = $row_tb_form_field[0]['cap_reset'];
		echo "<form action='".$row_tb_form_field[0]['action']."' onSubmit='return WBS.sendForm(this)' method=".$row_tb_form_field[0]['method']." ".$row_tb_form_field[0]['js']." class='".$row_tb_form_field[0]['style']."' ><fieldset><legend>".$row_tb_form_field[0]['titulo']."</legend>";
	
		$tb = parent::gera_array('*','frm_campo_formulario','idformulario = '.$form_id);
		$i = 0;
		echo "<table width='100%' class='formtable'>";
		foreach($tb as $row_tb_form_field) {
			$field[$i] = new field();
			if ($recordID == '0'){

				$field[$i]->insere($row_tb_form_field['idcampo_formulario']);
				$this->spt .= $field[$i]->get_script();
			} else {

				$field[$i]->edita($row_tb_form_field['idcampo_formulario'],$recordID);
				$this->spt .= $field[$i]->get_script();
			}
			
			$i++;
		}
		//echo "</td></tr><tr><td colspan='".$i."' valign='bottom' align='right'>";
		
		echo "</table>";echo "<input type='submit' value='".$cap_submit."' class='b_submit'>";
		echo "<input type='reset' value='".$cap_reset."' class='b_reset'>";
	}

}

?>