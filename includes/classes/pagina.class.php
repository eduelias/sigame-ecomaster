<?

	class pagina {

		public $paginaNome; // nome da página, referencia todos os objetos q serão criados, grid (myDataTable$paginaNome, tree$paginaNome)
		
		public $html; //Código html dos objetos - ainda não muito usado
		
		public $cpanel; // entrada do colapsible pannel;
		
		public $grid; //objeto grid
		
		public $filtro;
		
		public $head; // dados a serem impressos no cabeçalho da página
		
		public $data; //objeto que carrega todos os dados html para serem impressos com $pagina->imprime();
		
		public $titulo; //Objeto que formata o título da página - ainda não usado
		
		public $modulo; // Identificador do módulo. Ainda não usado - carregará permissões.
		
		public $formid; // Identificador de formulário. Ainda não usado - carrega dados dos formulário a serem impressos.
		
		public $tabs; // Carregador das tabs;
		
		public $cap_pesq; // Caption do cpanel de pesquisa.
		
		public $script; //public $data_head; // Objeto que carregará os dados da 'cabeça' da página. ** Mudou o nome de $data_head para script ** 
		
		public $includes; //public $links; // Objeto que carrega todos os arquivos JS carregados para esta página; - trocou nome de $links para $includes;
		
		public $oTree; // Objeto da classe tree
		 
		public $tree; // Elemento html da tree;
		
		public $scripts; //
		
		public function addTree($id){
			
			$this->includes[] = '<link rel="stylesheet" type="text/css" href="includes/yui/'.YUI_VER.'/build/treeview/assets/skins/sam/treeview.css">';
			$this->includes[] = '<script src = "includes/yui/'.YUI_VER.'/build/treeview/treeview'.((JSMIN)?'-min':'').'.js" ></script>';
			$this->tree[] = '<div id="tree_div'.$id.'"></div>';
			$this->oTree = new tree($id);
		}
		
		public function pagina($paginaNome, $titulo = '') {
			$this->titulo = (($titulo!='')?$titulo:$paginaNome);
			$this->paginaNome = (string) $paginaNome;
			$this->script[] = "<script  type=\"text/javascript\"> var pagina = new WBS.pagina; WBS.pagina.atual = '".$paginaNome."'; \r\n </script>";
			$this->head[] = "<h1 class='$paginaNome tit_pagina'>".$this->titulo."</h1><div style='width:600px'>&nbsp;</div>";
		}

		public function addTab($label,$content, $way = "true", $mod = ''){
			if (method_exists($this->tabs,addOnTab)) {
				$this->tabs->addTab($label,$content,$way);
			} else {	
				$this->tabs = new tabs($mod);
				$this->tabs->addTab($label,$content,$way);
			}
		}
		
		public function addPopup($trigger, $id = 'context', $lazyload = 'true', $itens){
			if (is_array($itens)) {
			$aux = '[';
				foreach ($itens as $tipo => $valor) {
					$aux .= "{ text: '".$valor['text']."', onclick: { fn: ".$valor['fn']."} },";
				}
				$sql = substr($sql,0,-1);
			$aux .= ']';
			} else { $aux = $itens; };
			$this->script[] = "<script> var oContextMenu = new YAHOO.widget.ContextMenu('".$id."', { trigger:'".$trigger."', lazyload:".$lazyload.", itemdata:".$aux." });";
			$this->script[] = 'oContextMenu.subscribe("triggerContextMenu", onTriggerContextMenu); </script>';
		}
		
		public function placeTabs($act = 0){
			$this->tabs->setActive($act);
			$this->tabs->show_tabs();
			
		}
		
		public function getTabs($act = 0){
		//	$this->tabs->setActive($act);
			//if (is_array($this->tabs->echodata)) {
				//foreach($this->tabs->echodata as $linha) {
					//$aux_tx .= $linha."\r\n";
					
				//}
			//}
			//return $aux_tx;
		}

		public function setGrid($campos, $obj, $condicao, $caption, $id, $alter_tab = '') {
			$aux = "<script> var loader = new YAHOO.util.YUILoader({base:'http://www.ipaservice.com.br/sigame/includes/yui/".YUI_VER."/build/',loadOptional:true}); \r\n				
				loader.addModule({
					name:'dtable',
					type:'js',
					fullpath:'http://www.ipaservice.com.br/sigame/includes/yui/".YUI_VER."/build/datatable/datatable-beta-min.js',
					varName:'YDT',
					requires:['yahoo','event','datasource']
				});
				loader.addModule({
					name:'formatter',
					type:'js',
					fullpath:'http://www.ipaservice.com.br/sigame/includes/js/formatters.js',
					varName:'FMT',
					requires:['yahoo','event','dtable']
				});
				loader.addModule({
					name:'overlap',
					type:'css',
					fullpath:'http://www.ipaservice.com.br/sigame/templates/css/overlap.css',
					varName:'OVL'
				});
				loader.require('formatter');
				if ((typeof myTab != 'undefined')&&(typeof YAHOO.widget.DataTable == 'undefined')) {
					myTab.subscribe('beforeContentChange', loader.insert);
				}
		</script>";
			//loga($aux);
			$this->includes[] = $aux;
			$this->includes[] = '<script type="text/javascript" src="includes/yui/2.5/build/datatable/datatable-beta.js"></script>';
			$this->includes[] = '<script type="text/javascript" src="includes/js/formatters.js"></script>';
			$this->caption = (isset($this->caption))?$this->caption:$caption;
			$this->grid = new geraGrid($campos, $obj, $condicao, iconv('utf-8','iso-8859-1',$this->caption), $id, $alter_tab);
			$this->grid->pagNome = $this->paginaNome;
		}
		
		public function loadGrid($rows = '15', $active = true) {
			$this->data[] = $this->grid->get_formatters();
			$this->data[] = $this->grid->imprimeGrid($this->paginaNome, $rows, $active);
			$this->data[] = $this->grid->script;
		}
		
		public function addCpanel($arquivo,$titulo) {
			$this->cpanel = "cp_".$this->paginaNome;
			
			$this->data[] = "<div id=\"".$this->cpanel."\" class=\"CollapsiblePanel\">
						 <div class=\"CollapsiblePanelTab\" tabindex=\"0\"><img src='images/view2.gif' border='no'>Pesquisar:</div>
						 <div class=\"CollapsiblePanelContent\"></div>
						 </div>";
			$this->script[] = "<script type=\"text/javascript\"> WBS.pagina._cpanel = new Spry.Widget.CollapsiblePanel(\"".$this->cpanel."\", {contentIsOpen:true, enableAnimation:false}); WBS.pagina.showForm.init('geraconteudo.php?file=".$arquivo."', '".$titulo."', '".$this->cpanel."'); </script> \r\n";
			
		}
		
		public function addCpanelOff($titulo, $content){
			$this->cpanel = "cp_".$this->paginaNome.$titulo;
			$this->head[] = "<div id=\"".$this->cpanel."\" class=\"CollapsiblePanel\">
							 <div class=\"CollapsiblePanelTab\" tabindex=\"0\"><img src='images/view2.gif' border='no' class='img_pesq'>".$titulo."</div>
							 <div class=\"CollapsiblePanelContent\"> ".$content."
							 </div>
							 </div>";
			$this->head[] = "<script type=\"text/javascript\"> WBS.pagina._cpanel = new Spry.Widget.CollapsiblePanel(\"".$this->cpanel."\", {contentIsOpen:false, enableAnimation:false});  </script> \r\n";
		}

		public function imprime() {
			if (is_array($this->includes)) {
				foreach($this->includes as $linha) {
					echo $linha."\r\n";
				}
			}
			if (is_array($this->head)) {
				foreach($this->head as $linha) {
					echo $linha."\r\n";
				}
			}
			if (is_array($this->data)) {
				foreach($this->data as $linha) {
					echo $linha."\r\n";
				}
			}
			if (is_array($this->script)) {
				foreach($this->script as $linha) {
					echo $linha."\r\n";
				}
			}
		}
		
		public function str_grid(){
			if (is_array($this->data)) {
				foreach($this->data as $linha) {
					$str_grid .= $linha."\r\n";
				}
			}
			return $str_grid;
		}
		
		public function head(){
			if (is_array($this->data_head)){
				foreach($this->data_head as $linha){
					echo $linha."\r\n";
				}
			}
		}

	}
	
	class node {
	
		public $parent_id;
	
		public $id;
		
		public $content;
		
		public $childs;
		
		public function getParent(){
			return $this->parent_id;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function getContent(){
			return $this->content;
		}
		
		public function node($parent_id,$id,$content){
			$this->parent_id = $parent_id;
			$this->id = $id;
			$this->content = $content;
		}

	}
	
	class tree {
	
		public $oTree;
		
		public $curr_id = 0;
		
		public $aux;
		
		public $start = true;
		
		public $data;
		
		public $id;
		
		public function tree($id){
			$this->id = $id;
		}
			
		public function addNode($parent_id,$content,$id = 'F'){
			$id = ($id == 'F')?$this->curr_id:$id;
			$this->oTree[$parent_id][] = new node($parent_id, $this->curr_id, $content);
			$this->curr_id++;
		}
		
		public function getNodes($parent_id){
			if (is_array($this->oTree[$parent_id])) {
				return $this->oTree[$parent_id];
			} else {
				return false;
			}
		}
		
		public function getJson($obj){	
			$b4 = new bd();
			$return = $b4->gera_array($obj['campos'],$obj['tabela'],$obj['condicao']);
			
			foreach ($return as $label => $valor){
				$return1[] = iconv('iso-8859-1','utf-8',$valor['campos']);
			}
			
			$returnValue['ResultSet']['Result'] = $return1;
			
			return $returnValue;
		}
		
		public function gera_tree($root){
			$this->data .= '<div id="tree_div'.$this->id.'"></div>';
			$this->data .= "<script> var tree".$this->id." = new YAHOO.widget.TreeView('tree_div".$this->id."');\r\n";
			$this->data .= "var root".$this->id." = tree".$this->id.".getRoot();";
			$this->data .= "tree".$this->id.".setDynamicLoad(loadNodeData);";
			$this->data .= "var processo = new YAHOO.widget.MenuNode({ID:0, tipo:'empresa', label:'PROCESSOS'}, root".$this->id.", true );";
			//$this->data .= 'root'.$this->id.'.expand();\r\n';
			$this->data .= "tree".$this->id.".subscribe('labelClick',function(node){ WBS.lbClick(node); });\r\n";
			$this->data .= "tree".$this->id.".subscribe('expand',function(node){ WBS.expand(node); });\r\n";
			$this->data .= "tree".$this->id.".subscribe('collapse',function(node){ WBS.collapse(node); });\r\n";
			
			$this->data .= "tree".$this->id.".draw(); \r\n";
			//$this->data .= "tree".$this->id.".draw(); \r\n";
			$this->data .= "";
			$this->data .="function loadNodeData(node, fnLoadComplete)  {
    
    //We'll create child nodes based on what we get back when we
    //use Connection Manager to pass the text label of the 
    //expanding node to the Yahoo!
    //Search \"related suggestions\" API.  Here, we're at the 
    //first part of the request -- we'll make the request to the
    //server.  In our Connection Manager success handler, we'll build our new children
    //and then return fnLoadComplete back to the tree.
    
    //Get the node's label and urlencode it; this is the word/s
    //on which we'll search for related words:
    var nodeLabel = encodeURI(node.label);
	WBS.node = node;
	 
    
    //prepare URL for XHR request:
    var sUrl = \"modules/mod_teste/hander.php?id=\" + node.data['ID'] + \"&tipo=\" + node.data['tipo'];
    
    //prepare our callback object
    var callback = {
    
        //if our XHR call is successful, we want to make use
        //of the returned data and create child nodes.
        success: function(oResponse) {
            var oResults = eval(\"(\" + oResponse.responseText + \")\");
			WBS.result = oResults;
            if((oResults.ResultSet.Result) && (oResults.ResultSet.Result.length)) {
                //Result is an array if more than one result, string otherwise
                if(YAHOO.lang.isArray(oResults.ResultSet.Result)) {
                    for (var i=0, j=oResults.ResultSet.Result.length; i<j; i++) {
                        tempNode[oResults.ResultSet.Result[i]['tipo']] = new YAHOO.widget.MenuNode(oResults.ResultSet.Result[i], node, false, {ID:oResults.ResultSet.Result[i]['ID'], tipo:oResults.ResultSet.Result[i]['tipo']});
						tempNode[oResults.ResultSet.Result[i]['tipo']].labelStyle = oResults.ResultSet.Result[i]['estilo'];
						tempNode[oResults.ResultSet.Result[i]['tipo']].isLeaf = oResults.ResultSet.Result[i]['leaf'];
					tempNode[oResults.ResultSet.Result[i]['tipo']].href = 'javascript:treelateral.getNodeByProperty(\'ID\',\''+oResults.ResultSet.Result[i]['ID']+'\').expand()';
                    }
                } else {
                    //there is only one result; comes as string:
                    tempNode[oResults.ResultSet.Result[i]['tipo']] = new YAHOO.widget.MenuNode(oResults.ResultSet.Result, node, false, {ID:oResults.ResultSet.Result[i]['ID'], tipo:oResults.ResultSet.Result[i]['tipo']})
					tempNode[oResults.ResultSet.Result[i]['tipo']].labelStyle = oResults.ResultSet.Result[i]['estilo'];
					tempNode[oResults.ResultSet.Result[i]['tipo']].isLeaf = oResults.ResultSet.Result[i]['leaf'];
					tempNode[oResults.ResultSet.Result[i]['tipo']].href = 'javascript:treelateral.getNodeByProperty(\'ID\',\"'+oResults.ResultSet.Result[i]['ID']+'\").expand()';
                }
            }
                                
            //When we're done creating child nodes, we execute the node's
            //loadComplete callback method which comes in via the argument
            //in the response object (we could also access it at node.loadComplete,
            //if necessary):
            oResponse.argument.fnLoadComplete();
        },
        
        //if our XHR call is not successful, we want to
        //fire the TreeView callback and let the Tree
        //proceed with its business.
        failure: function(oResponse) {
            YAHOO.log(\"Failed to process XHR transaction.\", \"info\", \"example\");
            oResponse.argument.fnLoadComplete();
        },
        
        //our handlers for the XHR response will need the same
        //argument information we got to loadNodeData, so
        //we'll pass those along:
        argument: {
            \"node\": node,
            \"fnLoadComplete\": fnLoadComplete
        },
        
        //timeout -- if more than 7 seconds go by, we'll abort
        //the transaction and assume there are no children:
        timeout: 7000
    };
    
    //With our callback object ready, it's now time to 
    //make our XHR call using Connection Manager's
    //asyncRequest method:
    YAHOO.util.Connect.asyncRequest('GET', sUrl, callback);
}



</script>";
			return $this->data;
		}
		
		public function gera_TextTree($root){
		
			$this->data .= '<div id="tree_div'.$this->id.'"></div>';
			$this->data .= "<script> var tree".$this->id." = new YAHOO.widget.TreeView('tree_div".$this->id."');\r\n";
			$this->data .= "var root".$this->id." = tree".$this->id.".getRoot();";
			$this->data .= "tree".$this->id.".setDynamicLoad(loadNodeData);";
			$this->data .= "var processo = new YAHOO.widget.TextNode({id:1, tipo:'empresa', label:'PROCESSOS'}, root".$this->id.", true );";
			//$this->data .= 'root'.$this->id.'.expand();\r\n';
			$this->data .= "tree".$this->id.".subscribe('labelClick',function(node){ WBS.TlbClick(node); });\r\n";
			//$this->data .= "tree".$this->id.".subscribe('expand',function(node){ WBS.Texpand(node); });\r\n";
			//$this->data .= "tree".$this->id.".subscribe('collapse',function(node){ WBS.Tcollapse(node); });\r\n";
			
			$this->data .= "tree".$this->id.".draw(); \r\n";
			//$this->data .= "tree".$this->id.".draw(); \r\n";
			$this->data .= "";
			$this->data .="function loadNodeData(node, fnLoadComplete)  {
    
    //We'll create child nodes based on what we get back when we
    //use Connection Manager to pass the text label of the 
    //expanding node to the Yahoo!
    //Search \"related suggestions\" API.  Here, we're at the 
    //first part of the request -- we'll make the request to the
    //server.  In our Connection Manager success handler, we'll build our new children
    //and then return fnLoadComplete back to the tree.
    
    //Get the node's label and urlencode it; this is the word/s
    //on which we'll search for related words:
    var nodeLabel = encodeURI(node.label);
	 
    
    //prepare URL for XHR request:
    var sUrl = \"modules/monitoramento/hander.php?id=\" + node.data['ID'] + \"&tipo=\" + node.data['tipo'];
    
    //prepare our callback object
    var callback = {
    
        //if our XHR call is successful, we want to make use
        //of the returned data and create child nodes.
        success: function(oResponse) {
            var oResults = eval(\"(\" + oResponse.responseText + \")\");
            if((oResults.ResultSet.Result) && (oResults.ResultSet.Result.length)) {
                //Result is an array if more than one result, string otherwise
                if(YAHOO.lang.isArray(oResults.ResultSet.Result)) {
                    for (var i=0, j=oResults.ResultSet.Result.length; i<j; i++) {
                        tempNode[oResults.ResultSet.Result[i]['tipo']] = new YAHOO.widget.TextNode(oResults.ResultSet.Result[i], node, false, {id:oResults.ResultSet.Result[i]['ID'], tipo:oResults.ResultSet.Result[i]['tipo']});
						tempNode[oResults.ResultSet.Result[i]['tipo']].labelStyle = oResults.ResultSet.Result[i]['estilo'];
						tempNode[oResults.ResultSet.Result[i]['tipo']].isLeaf = oResults.ResultSet.Result[i]['leaf'];
                    }
                } else {
                    //there is only one result; comes as string:
                    tempNode[oResults.ResultSet.Result[i]['tipo']] = new YAHOO.widget.TextNode(oResults.ResultSet.Result, node, false, {id:oResults.ResultSet.Result[i]['ID'], tipo:oResults.ResultSet.Result[i]['tipo']})
					tempNode[oResults.ResultSet.Result[i]['tipo']].labelStyle = oResults.ResultSet.Result[i]['estilo'];
					tempNode[oResults.ResultSet.Result[i]['tipo']].isLeaf = oResults.ResultSet.Result[i]['leaf'];
                }
            }
                                
            //When we're done creating child nodes, we execute the node's
            //loadComplete callback method which comes in via the argument
            //in the response object (we could also access it at node.loadComplete,
            //if necessary):
            oResponse.argument.fnLoadComplete();
        },
        
        //if our XHR call is not successful, we want to
        //fire the TreeView callback and let the Tree
        //proceed with its business.
        failure: function(oResponse) {
            YAHOO.log(\"Failed to process XHR transaction.\", \"info\", \"example\");
            oResponse.argument.fnLoadComplete();
        },
        
        //our handlers for the XHR response will need the same
        //argument information we got to loadNodeData, so
        //we'll pass those along:
        argument: {
            \"node\": node,
            \"fnLoadComplete\": fnLoadComplete
        },
        
        //timeout -- if more than 7 seconds go by, we'll abort
        //the transaction and assume there are no children:
        timeout: 7000
    };
    
    //With our callback object ready, it's now time to 
    //make our XHR call using Connection Manager's
    //asyncRequest method:
    YAHOO.util.Connect.asyncRequest('GET', sUrl, callback);
}



</script>";
			return $this->data;
		
		}
	
	}

?>