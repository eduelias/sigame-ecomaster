<?php
class field extends bd{
	private $idcampo_formulario;
	private $idformulario;
	private $label;
	private $tipo;
	private $elname;
	private $elid;
	private $tamanho;
	private $tabela_master;
	private $tabela_master_campo;
	private $js;
	private $style;
	private $tabela_detalhe;
	private $tabela_campo_detalhe;
	private $tipos;	
	private $valor;
	private $required = false;
	private $pattern;
	private $tabela;
	private $options;
	private $spt;
	private $dica;

	
	function get_script(){
		return $this->spt;
	}
	
	function script($string){
		$this->spt .= $string;
	}

	function preenche(){
		$this->tabela = $this->tabela_master;
		if($this->valor <> 'Label') { $this->valor = ($this->label==$this->valor)?"checked='checked'":$this->valor; }
		$this->tipos = array(
			"text"=>"
			<label><input type='text' name='".$this->tabela."@".$this->elname."' id='".$this->elid."' ".$this->js." value='".htmlentities($this->valor,ENT_QUOTES)."' size='".$this->tamanho."' class=".$this->style.">
			 <span class=\"textfieldRequiredMsg\">".MSG_REQ."</span><span class=\"textfieldInvalidFormatMsg\">".MSG_INV."</span><br>".$this->dica."</label>
			<script>
			var ".$this->elname." = new Spry.Widget.ValidationTextField(\"".$this->elid."\", \"custom\", {validateOn:[\"blur\"], useCharacterMasking:true, pattern:\"".$this->pattern."\", isRequired:".$this->required.", requiredClass:'required', invalidClass:'invalid', validClass:'valid', focusClass:'focus'}) </script>",
			
			"login"=>"
			<input type='text' name='".$this->tabela."@".$this->elname."' id='".$this->elid."' onblur='JAVASCRIPT:seta_pass(this);' value='".htmlentities($this->valor,ENT_QUOTES)."' size='".$this->tamanho."' class=".$this->style."><span class=\"textfieldRequiredMsg\">".MSG_REQ."</span>
			<script>
			var ".$this->elname." = new Spry.Widget.ValidationTextField(\"".$this->elid."\", \"custom\", {validateOn:[\"blur\"], useCharacterMasking:true, pattern:\"".$this->pattern."\", isRequired:".$this->required.", requiredClass:'required', invalidClass:'invalid', validClass:'valid', focusClass:'focus'}) </script>",
			
			"calendar"=>
			'<br><br><BR><BR><div id="'.$this->elid.'Container"></div>
			<label id="text_'.$this->elId.'"><input type="hidden" name="'.$this->tabela."@".$this->elname.'" id="text_'.$this->elid.'" value="'.(($this->valor=="0000-00-00")?'':$this->valor).'"/><span class="textfieldRequiredMsg">'.MSG_REQ.'</span><span class="textfieldInvalidFormatMsg">'.MSG_INV.'</span></label>
			<script>function handleSelect(type,args,obj) {
		var dates = args[0];
		var date = dates[0];
		var year = date[0], month = date[1], day = date[2];

		var txtDate1 = document.getElementById("text_'.$this->elid.'");
		txtDate1.value = year+ "-" +month+ "-" +day;
	}
	WBS.cal1 = new YAHOO.widget.Calendar("'.$this->elid.'Container", {title:"'.$this->label.'", selected:"'.date('m/d/Y',strtotime($this->valor)).'"});
	WBS.cal1.selectEvent.subscribe(handleSelect, WBS.cal1, true);
	WBS.cal1.render();
	var '.$this->elname.' = new Spry.Widget.ValidationTextField("text_'.$this->elid.'", "custom", {validateOn:["blur"], useCharacterMasking:true, pattern:"'.$this->pattern.'", isRequired:'.$this->required.'})
	</script>',
			
			"required"=>"
			<span id=\"".$this->elid."\"><label>".$this->label.":
			<input type='text' name='".$this->tabela."@".$this->elname."' id='".$this->elid."' ".$this->js." value='".$this->valor."' size=".$this->tamanho." class=".$this->style.">
			</label> <span class=\"textfieldRequiredMsg\">Precisa de um valor!</span></span>
			<script>
			var ".$this->elname." = new Spry.Widget.ValidationTextField(\"".$this->elid."\", \"none\", {validateOn:[\"blur\"]}) </script>",
			
			"textarea"=>
			"<label><br>
			<textarea  name='".$this->tabela."@".$this->elname."' id='".$this->elid."' ".$this->js." cols=".$this->tamanho." rows=".($this->tamanho/5)." class=".$this->style.">".$this->valor."</textarea>
			</label>",
			
			"submit"=>"<input type='submit' value='".$this->label."' class='submit ".$this->style."'>
			</label>",
			
			"password"=>"<label id='".$this->elid."'>Digite:<br>
			<input type='password' onblur='JAVASCRIPT:seta_pass(this);' size=".$this->tamanho." class=".$this->style."></label>
			
			<label id='".$this->elid."'>Confirme:<br>
			<input type='password' name='".$this->tabela."@".$this->elname."' onblur='JAVASCRIPT:checa_pass(this);' size=".$this->tamanho." class=".$this->style.">
			<span class=\"passwordRequiredMsg\">".MSG_ERRO."</span></label>
			
			
			<script> var v".$this->elid." = new Spry.Widget.ValidationPassword(\"".$this->elid."\", {maxChars:8, validateOn:[\"blur\", \"change\"], requiredClass:'required', invalidClass:'invalid', validClass:'valid', focusClass:'focus'}); </script>",
			
			"password_log"=>
			"<input type='password' name='".$this->tabela."@".$this->elname."' ".$this->js." size=".$this->tamanho." class=".$this->style."><span class=\"passwordRequiredMsg\">".MSG_ERRO."</span><script> var v".$this->elid." = new Spry.Widget.ValidationPassword(\"".$this->elid."\", {validateOn:[\"blur\"], requiredClass:'required', invalidClass:'invalid', validClass:'valid', focusClass:'focus'}); </script>",
			
			"hidden"=>
			"<input type='hidden' name='cond@".$this->tabela_master."@".$this->campo."' id='".$this->elid."' ".$this->js." value='".$this->valor."' size=".$this->tamanho." class=".$this->style.">
			</label>",
			
			"radio"=>
			"<label>".$this->label.": 
			<input type='radio' name='".$this->tabela."@".$this->elname."' id='".$this->elid."' ".$this->js." ".$this->valor." class='radio ".$this->style."' value=".$this->tamanho.">
			</label>",
			
			"enum"=>$this->enum."<script>
			var ".$this->elname." = new Spry.Widget.ValidationRadio(\"".$this->elid."\", {isRequired:".$this->required.", requiredClass:'required', invalidClass:'invalid', validClass:'valid', focusClass:'focus', validateOn:['blur','change']}) </script>",
			
			"radio_init"=>
			"<fieldset><caption>".$this->campo."</caption>
				<label>".$this->label.": 
					<input type='radio' name=".$this->tabela."@'".$this->elname."' id='".$this->elid."' ".$this->js." ".$this->valor." class=".$this->style." value=".$this->tamanho.">
				</label>",
			
			"radio_endit"=>
			"	<label>".$this->label.": 
					<input type='radio' name='".$this->tabela."@".$this->elname."' id='".$this->elid."' ".$this->js." ".$this->valor." class=".$this->style.">
				</label>
			  </fieldset>",
			
			"select"=>
			"<label id=\"".$this->elid."\">
			<select name='".$this->tabela."@".$this->elname."' id='".$this->elid."' ".$this->js." class=".$this->style.">".$this->options."</select><br>".$this->dica."
			</label><script type=\"text/javascript\">
			var ".$this->elname." = new Spry.Widget.ValidationSelect(\"".$this->elid."\", {invalidValue:\"".$this->pattern."\", validateOn:[\"blur\"], requiredClass:'required', invalidClass:'invalid', validClass:'valid', focusClass:'focus'});</script>",
			
			"file"=>
			"<label>".$this->label.":
			<input type='file' name='".$this->tabela."@".$this->elname."' id='".$this->elid."' ".$this->js." value='".$this->valor."' size=".$this->tamanho." class=".$this->style.">
			</label>",
			
			"checkbox"=>
			"<label>".$this->label.":
			<input type='checkbox' name='".$this->tabela."@".$this->elname."' id='".$this->elid."' ".$this->js." class=".$this->style." ".$this->value." value=".$this->tabela_campo_detalhe.">
			</label>"
		);
	}
		// 
	function detalha($master,$m_field,$detalhe,$d_field,$valor = '0'){
		$array = parent::gera_array('*',$detalhe,"TRUE");
		$ech ='';
		
		foreach ($array as $row_tb_form_field=>$val){
			$sel = ($val[$this->elname] === $valor)?"SELECTED":"";
			//pre($val);
			$ech .= "<option value='".$val[$this->elname]."' ".$sel.">".$val[$d_field]."</option>\n";
		}
		return (string) $ech;
	}

	function prepara_opt($valor){
		$this->options = ($this->tipo == "select")?$this->detalha($this->tabela_master,$this->campo,$this->tabela_detalhe,$this->tabela_campo_detalhe, $valor):'';
	}
	
	function prepara($matriz){
		$this->required = $matriz['required'];
		$this->pattern = $matriz['pattern'];
		$this->idcampo_formulario = $matriz['idcampo_formulario'];
		$this->idformulario = $matriz['idformulario'];
		$this->label = $matriz['label'];
		$this->tipo = $matriz['tipo'];
		$this->elname = $matriz['elname'];
		$this->elid = $matriz['elid'];
		$this->tamanho = $matriz['tamanho'];
		$this->tabela_master = $matriz['tabela_master'];
		$this->campo = $matriz['tabela_master_campo'];
		$this->js = $matriz['js'];
		$this->style = $matriz['style'];
		$this->tabela_detalhe = $matriz['tabela_detalhe'];
		$this->tabela_campo_detalhe = $matriz['tabela_campo_detalhe'];
		$this->valor = $matriz['valor'];
		$this->dica = $matriz['dica'];
	}	
	
	function enumera($result){
		if(is_array($result)){
			$row=$result['fields']['Type'];
			$options=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row));
		}
		//pre($result);
		$this->enum = "";
		foreach($options as $opt){
			$selected = ($this->valor == $opt)?" checked=\"checked\" ":"";
			$this->enum .= " 
					<input type='radio' name='".$this->tabela_master."@".$this->elname."' id='".$this->elid."' ".$this->js." class='radio ".$this->style."' ".$selected." value='".$opt."'>".$opt;
		}
		//$this->enum .= "";
	}
	
	function prepara_enum(){
		$query_tb_form_field = "SHOW COLUMNS FROM ".$this->tabela_master." LIKE '".$this->elname."'";
		parent::send_sql($query_tb_form_field);
		$result = parent::get_raw();
		//echo $query_tb_form_field;
		//pre($result);
		$this->enumera($result);
	}
	
	function insere($campo_id){
		$row_tb_form_field = parent::gera_array('*','frm_campo_formulario','idcampo_formulario ='.$campo_id);
		$this->prepara($row_tb_form_field[0]);
		switch ($row_tb_form_field[0]['tipo']) {
			case 'enum': {
				$this->prepara_enum(); 
				$this->preenche();
				echo "<tr width='100%' id='".$this->elid."'><td style='padding:5px;' class='td_lab'>".$this->label.": </td><td style='padding:5px;' class='td_field'><li id='".$this->elid."'>".$this->tipos[$row_tb_form_field[0]['tipo']]."</li></td></tr>";
			} break;
			case 'select':{
				$this->prepara_opt($row[0][$this->elname]); 
				$this->preenche();
				echo "<tr width='100%' id='".$this->elid."'><td style='padding:5px;'  class='td_lab'>".$this->label.": </td><td style='padding:5px;' class='td_field'><li id='".$this->elid."'>".$this->tipos[$row_tb_form_field[0]['tipo']]."</li></td></tr>";
			} break;
			case 'hidden':{

			} break;
			case 'submit':{
				$this->preenche();
				echo "<li id='".$this->elid."'>".$this->tipos[$row_tb_form_field[0]['tipo']]."</li>";
			} break;
			default: {
				$this->preenche();	
				echo "<tr width='100%'id='".$this->elid."'><td style='padding:5px;' class='td_lab'>".$this->label.": </td><td style='padding:5px;' class='td_field'><li id='".$this->elid."'>".$this->tipos[$row_tb_form_field[0]['tipo']]."</li></td></tr>";
			}
		}	
	}
	
	function edita($campo_id,$recordID){
		$row_tb_form_field = parent::gera_array('*','frm_campo_formulario','idcampo_formulario='.$campo_id);
		
		$this->prepara($row_tb_form_field[0]);
				
		$row = parent::gera_array($this->elname,$this->tabela_master,$this->campo.' = "'.$recordID.'" LIMIT 1');
		$this->valor = $row[0][$this->elname];
		//echo parent::get_sql();
		switch ($row_tb_form_field[0]['tipo']) {
			case 'enum': {
				$this->prepara_enum(); 
				$this->preenche();
				echo "<tr width='100%' id='".$this->elid."'>
						<td class='td_lab'>".$this->label.": </td>
						<td class='td_field'>
							<li id='".$this->elid."'>".$this->tipos[$row_tb_form_field[0]['tipo']]."</li>
						</td>
					</tr>";
			} break;
			case 'select':{
				$this->prepara_opt($row[0][$this->elname]); 
				$this->preenche();
				echo "<tr width='100%' id='".$this->elid."'>
						<td class='td_lab'>".$this->label.": </td>
						<td class='td_field'>
							<li id='".$this->elid."'>".$this->tipos[$row_tb_form_field[0]['tipo']]."</li>
						</td>
					</tr>";
			} break;
			case 'hidden':{
				$this->valor = $recordID;
				$this->preenche();
				echo $this->tipos[$row_tb_form_field[0]['tipo']];
			} break;
			case 'submit':{
				$this->preenche();
				echo "<li id='".$this->elid."'>".$this->tipos[$row_tb_form_field[0]['tipo']]."</li>";
			} break;
			default: {
				$this->preenche();	
				echo "<tr width='100%'id='".$this->elid."'>
						<td class='td_lab'>".$this->label.": </td>
						<td class='td_field'>
							<li id='".$this->elid."'>".$this->tipos[$row_tb_form_field[0]['tipo']]."</li>
						</td>
					</tr>";
			}
		}
	}

}

?>