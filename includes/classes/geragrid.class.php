<?
	/** 
	 * Cria um elemento de datagrid no corpo do documento HTML
	 * Utiliza a biblioteca javascript Yahoo YUI
	 *
	 */
	class geraGrid {

		/**
		 * nome da classe do objeto que sera listado na tabela
		 */
		public $obj;
		/**
		 * condição inicial da pesquisa no objeto
		 */
		public $condicao;
		/**
		 * array de objetos do tipo coluna
		 */
		public $coluna;
		/**
		 * título da tabela
		 */
		public $caption;
		/**
		 * nome do campo de ID da tabela
		 */
		public $ID;
		/**
		 * array $sortedby(colKey => "", dir => "ASC")
		 */
		public $sortedby;
		/**
		 * dados para preencher a tabela (formato json)
		 */
		public $data;
		/**
		 * nome do arquivo "ver dados"
		 */
		public $viewFile;
		/**
		 * nome do arquivo "alterar dados"
		 */
		public $editFile;
		/**
		 * nome do arquivo "deletar dados"
		 */
		public $deleteFile;
		
		public $full = true; //full screen;
		
		public $alter_tab;

		public $masterTable;
		
		public $detailTable;
		
		public $etq_file;
		
		public $modulo;
		
		public $wrelative;
		
		public $width;
		
		public $height;
		
		public $scrollable;
		
		public $barra;
		
		public $pagNome;
		
		public $fmts; // Guarda o javascript dos formatadores
		
		public $script; // usando para guardar o script de busca (ainda com BUG)
		
		public $referencia; //referencia ao nome Javascript do Grid gerado.
		
		public function setModulo($mod){
			$this->modulo = $mod;
		}
		
		public function setMD($master,$detail) {
			$this->masterTable = $master;
			$this->detailTalbe = $detail;
		}
		
		public function addFuncao($tipo, $arquivo, $params = ''){
		

			switch ($tipo) {
				case 'panel':{			
					$this->arquivo = encode($arquivo);
					if (is_array($params)){
						$this->comando = $this->arquivo;
						foreach ($params as $k => $v){
							$this->comando .= '&'.$k.'='.$v;
						}
					}
					$this->barra_superior .= '$this->barra .= "<img src=\''.(($params['imagem'])?$params['imagem']:'images/inserir.gif\'').' class=\'dt_insert\' style=\'height:24px; 	cursor:pointer;\' onclick=\'JAVASCRIPT:divCentral.carrega(\\\\\"".$this->comando."\\\\\",$tbb)\'>";';
				}break;
				case 'addIDTree':{
					//nesse caso, tipo = type, arquivo = objeto tree;
					$this->barra_superior .=  "<img src=".(($params['imagem'])?$params['imagem']:"'images/addmult.png'")." class='dt_insert' style='height:24px; cursor:pointer;' onclick='JAVASCRIPT:WBS.addIDTree(myDataTable".$tipo.",\\\"".$tipo."\\\",".$arquivo.")'>";
				}break;
				default:{
				
				}break;
			}
		}
		
		public function addInsert($formid){
			$this->aux3 = encode("gera.php");
			$this->aux3 .= "&formid=".$formid;
			$this->barra_superior = '$this->barra .= "<img src=\'images/inserir.gif\' class=\'dt_insert\' style=\'height:24px; 	cursor:pointer;\' onclick=\'JAVASCRIPT:divCentral.carrega(\\\\\"".$this->aux3."\\\\\",$tbb)\'>";';
		}
		
		public function addIDInsert($type, $tree = 'treelateral'){
			$this->barra .= "<img src='images/addmult.png' class='dt_insert' style='height:24px; cursor:pointer;' onclick='JAVASCRIPT:WBS.addIDTree(myDataTable".$type.",\\\"".$type."\\\",".$tree.")'>";
		}
		
		public function addPesq($aquivo){
			$this->barra .= "<img src='images/BotConsulta.gif' class='dt_pesq' onclick='JAVASCRIPT:divCentral.carrega(\\\"".$aquivo."\\\")'>";
		}
	
	   /**
		* constroi uma nova instância de grid
		*
		* @param    string     $obj    nome do objeto que será listado
		* @param    string     $condicao    condição inicial da pesquisa no objeto
		* @param    string     $caption    título da tabela
		* @param    int     $id    nome do campo de ID da tabela
		* 
		* 
		*/
		public function geraGrid($campos, $obj, $condicao, $caption, $id, $alter_tab) {
			$this->fmts = '<script> if (typeof YAHOO.widget.DataTable == "undefined") { loader.insert(); } </script>';
			$this->campos = (string) $campos;
			$this->alter_tab = (string) $alter_tab;
			$this->obj = (string) $obj;
			$this->condicao = (string) $condicao;
			$this->caption = (string) $caption;
			$this->ID = (string) $id;
		}
		

	   /**
		* adiciona uma coluna ao grid
		*
		* @param    string     $campo    nome do campo da coluna na tabela
		* @param    string     $label    título do campo que será impresso no grid
		* @param    string     $type    tipo do campo
		* @param    string     $width    tamanho da coluna na tabela
		* @param    string     $classname    nome da classe a ser aplicada na coluna
		* @param    bool     $sortable    se coluna é sorteável ou não (true ou false)
		* @param    string     $formatter    nome da função que formata a coluna
		* 
		*/
		public function AddColuna($campo, $label, $type,  $width, $editor = "", $classname = "", $sortable = "true", $formatter = "", $parser = 'String') {
			$col = new coluna($campo, iconv('utf-8','iso-8859-1',$label), $type, $width, $editor, $classname, $sortable, $formatter, $parser);
			$this->coluna[] = $col;
		}
		
	   /**
		* adiciona uma ação ao grid
		*
		* @param    string     $acao    nome da ação a ser adicionada à tabela.
		*                               Valores válidos:
		*                               "view" -> para chamar "ver dados"
		*                               "edit" -> para chamar "editar dados"
		*                               "delete" -> para chamar "excluir dados"
		*
		* @param    string     $file    nome do arquivo que executará a função
		*                               indicada pela ação
		* 
		*/
		public function AddAcao($acao, $file, $id = '') {
			if ($id == '') { $id = $this->ID; }
			$tamanho = '18';
			switch($acao) {
				case "view":
					$this->fmts .= '<script>/**
						 * Formats cells in Columns of type "view".
						 *
						 * @method formatView
						 * @param elCell {HTMLElement} Table cell element.
						 * @param oRecord {YAHOO.widget.Record} Record instance.
						 * @param oColumn {YAHOO.widget.Column} Column instance.
						 * @param oData {Object} Data value for the cell, or null
						 * @static
						 */						 
						YAHOO.widget.DataTable.formatView = function(elCell, oRecord, oColumn, oData) {
							var id = parseInt(oRecord._oData[this._campochave]);
							//alert(id);
							var markup = "<a href=\'#\' id=\'add-tab\'><img src=\'images/view.gif\' alt=\'Ver Dados\' title=\'Ver Dados\' border=\'0\'/></a>";
							elCell.innerHTML = markup;
							var viewfile = this._viewFile;
							var oTable = this;
							YAHOO.util.Event.addListener(elCell.firstChild, "click", function (e, oSelf) { 
										WBS.MasterId = id;
										WBS.pagina._verDados(viewfile, oData, oSelf, oRecord, id, oTable) } , elCell);
						};</script>';
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formatView");
					$this->viewFile = encode($file);
				break;
				case "related":
					$this->fmts .= '<script> YAHOO.widget.DataTable.formatRelation = function(elCell, oRecord, oColumn, oData) {
					var id = parseInt(oRecord._oData[this._campochave]);
					//alert(id);
					var markup = "<a href=\'#\' id=\'add-tab\'><img src=\'images/view.gif\' alt=\'Ver Dados\' title=\'Ver Dados\' border=\'0\'/></a>";
					elCell.innerHTML = markup;
					var viewfile = this._viewFile;
					var oTable = this;
					YAHOO.util.Event.addListener(elCell.firstChild, "click", function (e, oSelf) { 
								WBS.MasterId = id;
								WBS.pagina._verDados(viewfile, oData, oSelf, oRecord, id, oTable) } , elCell);
					};</script>';
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formatRelation");
					$this->viewFile = encode($file);
				break;
				case "imagem":{
					$this->fmts .= '<script>
					YAHOO.widget.DataTable.formatImagem = function (elCell, oRecord, oColumn, oData){
						var markup = "<img src=\'images/"+oData+"\'>";
						//alert(markup);
						classname = YAHOO.widget.DataTable.CLASS_STRING;
						elCell.innerHTML = markup;
					}</script>';
				}break;	
				case "edit":{
					$this->fmts .= "<script>
					/**
						 * Formats cells in Columns of type \"edit\".
						 *
						 * @method formatEdit
						 * @param elCell {HTMLElement} Table cell element.
						 * @param oRecord {YAHOO.widget.Record} Record instance.
						 * @param oColumn {YAHOO.widget.Column} Column instance.
						 * @param oData {Object} Data value for the cell, or null
						 * @static
						 */
						YAHOO.widget.DataTable.formatEdit = function(elCell, oRecord, oColumn, oData) {
							var markup = \"<img src='images/edit.gif' alt='Editar Dados' title='Editar Dados' />\";
							elCell.innerHTML = markup;
							var fEdit = this._editFile;
							var oTable = this;
							
							var id = parseInt(oRecord._oData[this._campochave]);
							
							YAHOO.util.Event.addListener(elCell.firstChild, \"click\", function(e, oSelf) {
									oTable.select(oSelf.parentNode);
									WBS.pagina._msg.static('info','Aguarde, conectando...');
									divCentral.carrega(fEdit+'&id='+id);
							}
							, elCell);
						};</script>";
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formatEdit");
					$this->editFile = $file; }
				break;
				case "editById":
					$this->fmts .= "<script>
									/**
									 * Formats cells in Columns of type \"editById\".
									 *
									 * @method formatEdit
									 * @param elCell {HTMLElement} Table cell element.
									 * @param oRecord {YAHOO.widget.Record} Record instance.
									 * @param oColumn {YAHOO.widget.Column} Column instance.
									 * @param oData {Object} Data value for the cell, or null
									 * @static
									 */
									YAHOO.widget.DataTable.formatEditByID = function(elCell, oRecord, oColumn, oData) {
										var markup = \"<div class='icon-unlocked'></div>\";
										if (WBS.IDs){
											if (WBS.IDs[WBS.RowID]){
												elCell.innerHTML = markup;
												
											} else {
												elCell.innerHTML = '';
											}
										
										
											var fEdit = this._editIdFile;
											var oTable = this;
											
											var id = oData;
									
											YAHOO.util.Event.addListener(elCell.firstChild, \"click\", function(e, oSelf) {
													oTable.select(oSelf.parentNode);
													WBS.pagina._msg.static('info','Aguarde, conectando...');
													divCentral.carrega(fEdit+'&id='+id);
											}
											, elCell);
										}		
									};
									</script>";
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formatEditByID");
					$this->editIdFile = $file;
				break;
				case "editByIdOpen":{
					$this->fmts .= "<script>
					YAHOO.widget.DataTable.formatEditByIDU = function(elCell, oRecord, oColumn, oData) {
						var markup = \"<div class='icon-unlocked'></div>\";	
						elCell.innerHTML = markup;
						
							var fEdit = this._editIdFile;
							var oTable = this;
							
							var id = oData;
							WBS.RowID = 0;
							YAHOO.util.Event.addListener(elCell, \"click\", function(e, oSelf) {
									oTable.select(oSelf.parentNode);
									WBS.pagina._msg.static('info','Aguarde, conectando...');
									divCentral.carrega(fEdit+'&id='+id);
							}
							, elCell);
					};

					</script>";
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formatEditByIDU");
					$this->editIdFile = $file;
				} break;
				case "listOut":{
					$this->fmts .= "<script>
					YAHOO.widget.DataTable.formateditLegislacao = function(elCell, oRecord, oColumn, oData) {
						if ((WBS.IDs) && (WBS.IDs[WBS.RowID])) {
							elCell.innerHTML = \"<div class='icon-traco'>&nbsp;</div>\";
					
						
							var fOut = this._listOut;
							var oTable = this;
							
							var id = oData;
					
							YAHOO.util.Event.addListener(elCell, \"click\", function(e, oSelf) {
									WBS.panel2.modal = false;
									WBS.panel2.render(document.body)
									oTable.select(oSelf.parentNode);
									WBS.pagina._msg.static('info','Aguarde, conectando...');
									divCentral.carrega(fOut+'&id='+id);
							}
							, elCell);
						} else {
							elCell.innerHTML = '';
						}
					};
					</script>";
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formateditLegislacao");
					$this->listOut = $file;
				} break;
				case "open_form":{
						$this->fmts .= "<script>
						/** * Formats cells in Columns of type \"edit\".
						 *
						 * @method formatEdit
						 * @param elCell {HTMLElement} Table cell element.
						 * @param oRecord {YAHOO.widget.Record} Record instance.
						 * @param oColumn {YAHOO.widget.Column} Column instance.
						 * @param oData {Object} Data value for the cell, or null
						 * @static
						 */
						YAHOO.widget.DataTable.formatEdit = function(elCell, oRecord, oColumn, oData) {
							var markup = \"<img src='images/edit.gif' alt='Editar Dados' title='Editar Dados' />\";
							elCell.innerHTML = markup;
							var fEdit = this._editFile;
							var oTable = this;
							
							var id = parseInt(oRecord._oData[this._campochave]);
							
							YAHOO.util.Event.addListener(elCell.firstChild, \"click\", function(e, oSelf) {
									oTable.select(oSelf.parentNode);
									WBS.pagina._msg.static('info','Aguarde, conectando...');
									divCentral.carrega(fEdit+'&id='+id);
							}
							, elCell);
						};</script>";
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formatEdit");
					$this->editFile = encode("gera.php")."&formid=".$file;
				} break;
				case "edit_off":{
					$this->fmts .= "<script>
					YAHOO.widget.DataTable.formatEdit_off = function(elCell, oRecord, oColumn, oData) {
						var markup = \"<img src='images/edit.gif' alt='Editar Dados' title='Editar Dados' />\";
						elCell.innerHTML = markup;
						var fEdit = this._editFile;
						var oTable = this;
						
						var id = parseInt(oRecord._oData[this._campochave]);
						
						YAHOO.util.Event.addListener(elCell.firstChild, \"click\", function(e, oSelf) {
								oTable.select(oSelf.parentNode);
								window.location = 'index.php?f='+fEdit+'&recordID='+id;
								//divCentral.carrega(fEdit+'&id='+id);
						}
						, elCell);
					};</script>";
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formatEdit_off");
					$this->editFile = encode($file);
				} break;
				case "delete":
					$this->AddColuna($id, "", "string", $tamanho, '', "", "false" ,"YAHOO.widget.DataTable.formatDelete");
					$this->deleteFile = encode($file);
				break;
				case "etiquetas":
					$this->AddColuna($id, "", "Number", $tamanho, '', '', "false", "YAHOO.widget.DataTable.formatEtiquetas");
					$this->etq_file = $file;
				case "dot":
					$this->AddColuna($id, $file, "Number", $tamanho, "","","false","YAHOO.widget.DataTable.formatdot");
				break;
				case "negativo":
					$this->AddColuna($id, $file, "Number", $tamanho, "","","false","YAHOO.widget.DataTable.formatNeg");
				break;
			}
		}

	   /**
		* adiciona uma evento pra ser executado nos itens selecionados no grid 
		*
		* @param    string     $text    Texto com o nome da ação a ser executada
		*
		* @param    string     $value   nome da função javascript que será executada
		*                               ao chamar este evento
		*
		* @param	string	   $img     Avatar à ser mostrado no pool de eventos
		* 
		*/
		public function AddEvento($text, $value) {
			$e = new evento;
			$e->settext($text);
			$e->setvalue($value);
			$this->eventos[] = $e;
		}
		
		public function get_formatters(){
			return $this->fmts;
		}

	   /**
		* retorna o código HTML do grid para ser impresso na tela 
		*
		* @param    string     $pagNome    Nome da página onde o grid será impresso
    	* @return   string     $grid 	   código HTML do grid gerado
		* 
		*/
		public function imprimeGrid($pagNome, $rowsperpage = '15', $active) {
			$this->pagNome = $pagNome;
			$tbb = 'myDataTable'.$pagNome;
			$maior = 0;
			$this->totalw = 0;
			foreach ($this->coluna as $ln){
				$this->totalw += $ln->getwidth();
				$maior = (($maior < $ln->getwidth())?$ln->getwidth():$maior);
			}
	
			$this->totalw -= $maior;
			$maior = ($this->tamanho)?$this->tamanho:1024;
			$this->fact = ($maior-177) - ($this->totalw);
			$this->pagNome = $pagNome;
			//div onde vai ficar a tabela
			$grid = "";
			$grid .= "<center><div id=\"".$pagNome."\" class='yui-skin-sam' style='overflow:none'></div></center>";
			//inicia o script e já começa a colocar os headers das colunas
			$grid .= "<script>\r\n
					if (typeof YAHOO.widget.DataTable == 'undefined') {
						loader.insert();
					}
			  var myColumnHeaders = [\r\n";

			//povoa os headers das colunas 	editor:\"".$linha->geteditor()."\",
			foreach($this->coluna as $linha) {
				if ($this->full) { $fator = (($linha->getwidth() != $maior)?$linha->getwidth():$this->fact); } else { $fator = $linha->getwidth(); };
				
			    $grid .= "{key:\"".$linha->getcampo()."\", resizeable:true, type:'".$linha->gettype()."', label:\"".$linha->getlabel()."\", ".($linha->getwidth()!=""?" width:".($fator).",":"")."className:\"".$linha->getclassname()."\", ".($linha->geteditor()!=""?" editor:".$linha->geteditor().", ":"")."\r\n".($linha->getformatter()!=""?"formatter:".$linha->getformatter().', ':"")."sortable:".$linha->getsortable()."},"; 
			}

			//retira a última vírgula que sobra
			$grid = substr($grid, 0, -1);
			$grid .= "];\r\n";

			//Coloca o conteúdo
			

			$grid .= "var myDataSource".$pagNome." = new YAHOO.util.DataSource('./geradadostogrid.php');\r\n";
			$grid .= "myDataSource".$pagNome.".responseType = YAHOO.util.DataSource.TYPE_JSON;\r\n";
			$grid .= "myDataSource".$pagNome.".subscribe('requestEvent',WBS.wait.show);\r\n";
			$grid .= "myDataSource".$pagNome.".subscribe('responseParseEvent',WBS.wait.hide);\r\n";
			$grid .= "myDataSource".$pagNome.".responseSchema = { resultsList: 'records', fields: [\r\n";
			//$grid .= "\"ID\",";
			foreach($this->coluna as $linha) {
			    $grid .= "\"".$linha->getcampo()."\",";
			}
			//retira a última vírgula que sobra
			$grid = substr($grid, 0, -1);
			$grid .= "\r\n] };\r\n";
			//echo $this->sortedby;
			//seta as configurações do grid
			eval($this->barra_superior);
			$grid .= "var myConfigs".$pagNome." = {\r\n";
			$grid .= "caption: \"".$this->barra."\",";
			$grid .= "sortedBy: {key:\"".$this->sortedby."\", dir:\"asc\"},\r\n" ;
			$grid .= "paginator: new YAHOO.widget.Paginator({rowsPerPage: ".$rowsperpage.",\r\n pageLinks: 5,\r\n firstPageLinkLabel: '<img src=\"images/actions16/2leftarrow.png\">', previousPageLinkLabel: '<img src=\"images/actions16/1leftarrow.png\">', nextPageLinkLabel:'<img src=\"images/actions16/1rightarrow.png\">', lastPageLinkLabel: '<img src=\"images/actions16/2rightarrow.png\">'}),\r\n";
			$grid .= "".((isset($this->width)||isset($this->height))?'scrollable: true,':'scrollable: true,')."\r\n" ;
			$grid .= ((isset($this->width))?"width:'".$this->width."',\r\n":'');
			$grid .= ((isset($this->height))?"height:'".$this->height."',\r\n":'');

			$grid .= "initialRequest:'?campos=".$this->campos."&obj=".$this->obj."&condicao=".$this->condicao."&pagina=1&numregistro=15'\r\n";
			$grid .= "}\r\n";			
			
			$this->referencia = 'myDataTable'.$this->pagNome;
			$grid .= "myDataTable".$pagNome." = new YAHOO.widget.DataTable(\"".$pagNome."\",myColumnHeaders,myDataSource".$pagNome.",myConfigs".$pagNome.");\r\n";
			//$grid .= "WBS.oTable = myDataTable".$pagNome;
			//Seta a propriedade _IDfield do grid
			$grid .= ($this->masterTable!='')?"myDataTable".$pagNome."._masterTable = myDataTable".$this->masterTable.";\r\n":'';
			$grid .= ($this->detailTable!='')?"myDataTable".$pagNome."._masterTable = myDataTable".$this->detailTable.";\r\n":'';
			$grid .= "myDataTable".$pagNome."._IDfield = \"".$this->ID."\";\r\n";
			if ($this->viewFile) {
				$grid .= "myDataTable".$pagNome."._viewFile = \"".$this->viewFile."\";\r\n";
			}
			if ($this->editFile) {
				$grid .= "myDataTable".$pagNome."._editFile = \"".$this->editFile."\";\r\n";
			}
			if ($this->editIdFile) {
				$grid .= "myDataTable".$pagNome."._editIdFile = \"".$this->editIdFile."\";\r\n";
			}
			if ($this->listOut) {
				$grid .= "myDataTable".$pagNome."._listOut= \"".$this->listOut."\";\r\n";
			}
			if ($this->alter_tab) {
				$grid .= "myDataTable".$pagNome."._tablename = \"".$this->alter_tab."\";\r\n";
				$grid .= "myDataTable".$pagNome."._campochave = \"".$this->ID."\";\r\n";
			}
			if ($this->deleteFile) {
				$grid .= "myDataTable".$pagNome."._deleteFile = \"".$this->deleteFile."\";\r\n"; 
				$grid .= "myDataTable".$pagNome."._tablename = \"".$this->alter_tab."\";\r\n";
				$grid .= "myDataTable".$pagNome."._campochave = \"".$this->ID."\";\r\n";
			}	
			
			$grid .= "myDataTable".$pagNome.".subscribe(\"rowClickEvent\", myDataTable".$pagNome.".onEventSelectRowCheck);\r\n";
			$grid .= "myDataTable".$pagNome.".subscribe(\"rowMouseoverEvent\", myDataTable".$pagNome.".onEventHighlightRow)\r\n";
			$grid .= "myDataTable".$pagNome.".subscribe(\"rowMouseoutEvent\", myDataTable".$pagNome.".onEventUnhighlightRow);\r\n";
			$grid .= "myDataTable".$pagNome.".subscribe(\"rowSelectEvent\", myDataTable".$pagNome.".onEventCheckCheckbox);\r\n";
			$grid .= "myDataTable".$pagNome.".subscribe(\"rowUnselectEvent\", myDataTable".$pagNome.".onEventUncheckCheckbox);\r\n";
			$grid .= "myDataTable".$pagNome.".subscribe(\"renderEvent\", WBS.updateMarks);\r\n";
			$grid .= "myDataTable".$pagNome.".subscribe(\"cellDblclickEvent\", myDataTable".$pagNome.".onEventShowCellEditor)\r\n"; 
			$grid .= ($active)?"WBS.upTable.push(myDataTable".$pagNome."); \r\n":'';

	//evento que é executado ao alterar o valor de uma célula
	$grid .= "var onCellEdit = function(oArgs) {\r\n";
	$grid .= "WBS.tea = oArgs\r\n;";
	$grid .= "var oldData = oArgs.oldData || \"\";\r\n";	
	$grid .= "var newId = oArgs.newData || \"\";\r\n";
	$grid .= "var alterar = (oArgs.editor.column.editorOptions != null)?oArgs.editor.column.editorOptions.dropdownOptions[newId].field:oArgs.editor.column.key; \r\n"; 
	$grid .= "var chaveee = oArgs.editor.record._oData.".$this->ID."; \r\n";
	$grid .= "var url = \"geraconteudo.php?file=".encode("onaltera.php")."&tabela=".$this->alter_tab."&keyfield=".$this->ID."&id=\"+chaveee+\"&field=\"+alterar+\"&val=\"+encodeURIComponent(newId); \r\n";

	$grid .= "YAHOO.util.Connect.asyncRequest('GET',url, {success: function(o){ 
		myDataTable".$pagNome.".reloadTable()";
	$grid .= "}, failure: function(o) {alert('falhou');} }, null); \r\n";
	$grid .= "oArgs.editor.cell.innerHTML = oArgs.editor.column.editorOptions.dropdownOptions[newId].text; \r\n";	

	$grid .= "}\r\n";
	$grid .= "myDataTable".$pagNome.".subscribe(\"editorSaveEvent\", onCellEdit);\r\n";

	$grid .= "</script>\r\n";
	return $grid;
	//echo $grid;
		}
		
		public function addPesquisa($campo, $elId, $leng = '1'){
			$grid .= "<label> ".$elId.": <input type='text' id='pq_".$elId."'></label> | <button onclick=\"WBS.pagina.pesq(document.getElementById('pq_".$elId."').text);\">Pesquisar</button>";
			//$grid2 =
			
			loga('"<script>  WBS.pagina.pesq = function (query) {													');	 
			loga('	 myDataSource".$this->pagNome.".sendRequest(\'?campos=".$this->campos."&obj=".$this->obj			');	 
			loga('	 ."&condicao=".$this->obj.".".$campo.\' LIKE "%25\'+query+\'%25"&pagina=1&numregistro=15", 		');	 
			loga('	  myDataTable'.$this->pagNome.'.onDataReturnInitializeTable, myDataTable'.$this->pagNome.')		');	 
			loga('	alert("w"); };  ');	 
			
			loga($grid2);	
			   
			$grid2 .= "var oACDS".$this->pagNome.$campo." = new YAHOO.widget.DS_JSFunction(WBS.pagina.".$this->pagNome.$campo."); \r\n";
			$grid2 .= "oACDS".$this->pagNome.$campo.".queryMatchcontains = true;\r\n";
			$grid2 .= "var oAutoComp".$this->pagNome.$campo." = new YAHOO.widget.AutoComplete('pq_".$elId."','".$this->pagNome."',oACDS".$this->pagNome.$campo.");";
			$grid2 .= "oAutoComp".$this->pagNome.$campo.".minQueryLength = ".$leng."; \r\n</script> \r\n";
			loga($grid2);
			$this->script = $grid2;
			return $grid;
			
		}
	}

	/** 
	 * Adiciona uma coluna ao datagrid
	 *
	 */
	class coluna {

		/** 
		 * identificador do campo no objeto
		 */
		private $campo;
		/** 
		 * identificador do editor do campo
		 */
		private $editor;
		/** 
		 * funçao para retornar valor do campo no objeto
		 */
		private $funcao;
		/** 
		 * label do título do grid
		 */
		private $label;
		/** 
		 * tipo do conteúdo (number, string, date)
		 */
		private $type;
		/** 
		 * tamanho da coluna
		 */
		private $width;
		/** 
		 * nome de classe específica para a coluna
		 */
		private $classname;
		/** 
		 * (true ou false) => se é sorteável ou não [tem que tratar como string senão retorna t ou f]
		 */
		private $sortable;
		/** 
		 * função que vai formatar o valor do campo
		 */
		private $formatter;
		/** 
		 * função que vai parsear o valor do campo
		 */
		 private $parser;
		/** 
		 * seta o valor do atributo campo
		 * @param string $campo
		 */
		function setcampo($campo) {
			$this->campo = (string) $campo;
		}
		/** 
		 * seta o valor do atributo campo
		 * @param string $campo
		 */
		function setparser($parser) {
			$this->parser = (string) $parser;
		}
		/** 
		 * seta o valor do atributo campo
		 * @param string $campo
		 */
		function seteditor($editor) {
			$this->editor = (string) $editor;
		}
		
		/** 
		 * seta o valor do atributo funcao
		 * @param string $funcao
		 */
		function setfuncao($funcao) {
			$this->funcao = (string) $funcao;
		}
		/** 
		 * seta o valor do atributo label
		 * @param string $label
		 */
		function setlabel($label) {
			$this->label = (string) $label;
		}
		/** 
		 * seta o valor do atributo type
		 * @param string $type
		 */
		function settype($type) {
			$this->type = (string) $type;
		}
		/** 
		 * seta o valor do atributo width
		 * @param string $width
		 */
		function setwidth($width) {
			$this->width = (string) $width;     
		}
		/** 
		 * seta o valor do atributo classname
		 * @param string $classname
		 */
		function setclassname($classname) {
			$this->classname = (string) $classname;
		}
		/** 
		 * seta o valor do atributo sortable
		 * @param string $sortable
		 */
		function setsortable($sortable) {
			$this->sortable = (string) $sortable;
		}
		/** 
		 * seta o valor do atributo formatter
		 * @param string $formatter
		 */
		function setformatter($formatter) {
			$this->formatter = (string) $formatter;
		}

		/** 
		 * pega o valor do atributo campo
		 */
		function getcampo() {
			return (string) $this->campo;
		}
		/** 
		 * pega o valor do atributo campo
		*/
		function getparser() {
			return (string) $this->parser;
		}
		/** 
		 * pega o valor do atributo funcao
		 */
		function getfuncao() {
			return (string) $this->funcao;
		}
		/** 
		 * pega o valor do atributo label
		 */
		function getlabel() {
			return (string) $this->label;
		}
		/** 
		 * pega o valor do atributo editor
		 */
		function geteditor() {
			return (string) $this->editor;
		}
		/** 
		 * pega o valor do atributo type
		 */
		function gettype() {
			return (string) $this->type;
		}
		/** 
		 * pega o valor do atributo width
		 */
		function getwidth() {
			return (string) $this->width;
		}
		/** 
		 * pega o valor do atributo classname
		 */
		function getclassname() {
			return (string) $this->classname;
		}
		/** 
		 * pega o valor do atributo sortable
		 */
		function getsortable() {
			return (string) $this->sortable;
		}
		/** 
		 * pega o valor do atributo formatter
		 */
		function getformatter() {
			return (string) $this->formatter;
		}

	   /**
		* constrói um objeto coluna
		*
		* @param    string     $campo    nome do campo da coluna na tabela
		* @param    string     $label    título do campo que será impresso no grid
		* @param    string     $type    tipo do campo
		* @param    string     $width    tamanho da coluna na tabela
		* @param    string     $classname    nome da classe a ser aplicada na coluna
		* @param    bool     $sortable    se coluna é sorteável ou não (true ou false)
		* @param    string     $formatter    nome da função que formata a coluna
		* 
		*/
		function coluna($campo, $label, $type, $width, $editor, $classname, $sortable, $formatter, $parser) {
			$this->setparser(($type != 'checkbox')?"YAHOO.util.DataSource.parse".$type:'YAHOO.util.DataSource.parseNumber');
			$this->seteditor($editor);
			$this->setcampo($campo);
			$this->setlabel($label);
			$this->settype($type);
			$this->setwidth($width);
			$this->setclassname($classname);
			$this->setsortable($sortable);
			$this->setformatter($formatter);
		}
	}


	/** 
	 * Adiciona um evento ao datagrid
	 * Eventos aparecem abaixo do datagrid como um select e são executados
	 * a todos os elementos selecionados por checkbox na tabela.
	 *
	 */
	class evento {

		/** 
		 * texto que vai ser exibido no option
		 */
		private $text;
		/** 
		 * value do option: função js que será executada
		 */
		private $value;

		/** 
		 * seta o valor do atributo text
		 * @param string $text
		 */
		function settext($text) {
			$this->text = (string) $text;
		}
		/** 
		 * seta o valor do atributo value
		 * @param string $value
		 */
		function setvalue($value) {
			$this->value = (string) $value;
		}

		/** 
		 * pega o valor do atributo text
		 */
		function gettext() {
			return (string) $this->text;
		}
		/** 
		 * pega o valor do atributo value
		 */
		function getvalue() {
			return (string) $this->value;
		}

	}

?>