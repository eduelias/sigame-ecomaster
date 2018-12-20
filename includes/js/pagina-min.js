
	if (typeof WBS == "undefined") {
		var WBS = {};
	}
	var tempNode = new Array();
	WBS.t2 = new Array();
	WBS.upTable = new Array();
	WBS.MasterEmp = 0;
	WBS.o = null;
	WBS.selectedIds = new Array();
	WBS.reloadGrids = function (o) {
		for (i=0; i<WBS.upTable.length; i++){
			if(WBS.upTable[i]) {
				WBS.upTable[i].reloadTable();
			}
		}
	}
	WBS.nxh = new Array();
	WBS.hiq = new Array();
	WBS.invhiq = new Array();
	
	WBS.hiq['empresa']= 'processo';
	WBS.hiq['processo']='atividade';
	WBS.hiq['atividade']='aspecto_ambiental';
	WBS.hiq['aspecto_ambiental']='imapcto';	
	WBS.hiq['impacto']='tipo_emissao';
	WBS.hiq['tipo_emissao']='destinacao_final';
	
	WBS.invhiq['processo']= 'empresa';
	WBS.invhiq['atividade']='processo';
	WBS.invhiq['aspecto_ambiental']='atividade';
	WBS.invhiq['impacto']='aspecto_ambiental';	
	WBS.invhiq['tipo_emissao']='impacto';
	WBS.invhiq['destinacao_final']='tipo_emissao';

	WBS.nxh[0]='processo';
	WBS.nxh[1]='atividade';
	WBS.nxh[2]='aspecto_ambiental';
	WBS.nxh[3]='impacto';	
	WBS.nxh[4]='tipo_emissao';
	WBS.nxh[5]='destinacao_final';
	
	WBS.updateMarks = function(){
	//	Dom.removeClass(Dom.getElementsByClassName('mark','tr','tbl'), 'mark');
	//	for (var recKey in WBS.IDs){
	//		if (YAHOO.lang.hasOwnProperty(WBS.IDs, recKey)){
	//			Dom.addClass(WBS.upTable.getTrEl(WBS.IDs[recKey]), 'mark');
	//		}
	//	}
	}
	
	WBS.IDRel = new Array(); 
	
	WBS.collapse = function (node){
		while (node.children.length) {
            treelateral._deleteNode(node.children[0]);
        }
		node.childrenRendered = false;
        node.dynamicLoadComplete = false;
        node.updateIcon();
	}
	
	WBS.sendForm = function(form, ccc) {
		window.status = 'Salvo. Renove a árvore para visualizar.';
		YAHOO.util.Connect.setForm(form);
		var cObj = YAHOO.util.Connect.asyncRequest(form.method, encodeURI(form.action), WBS.cbrefresh);
		//divCentral.off();
		
		if ( typeof ccc == 'undefined' ) {
			divCentral.off();
		}
		
		return false;
		
	}
	
	
	WBS.expand = function (node){
		//WBS.lbClick(node);
		//WBS.IDRel[node.data.tipo] = node.data.ID;
	}
	
	WBS.TlbClick = function (node){
		WBS.lastOpen = node;
		if (node.data.tipo == 'aspecto_ambiental') {
			WBS.IDRel[node.data.tipo] = node.data.ID;
			WBS.IDRel['last'] = node.data.ID;
			dataIds = node.data.ID;
			target = node.data.tipo;
			myTab.addTab(new YAHOO.widget.Tab({
				label: node.data.label,
				closer: true,
				dataSrc: "geraconteudo.php?f=WWxjNWEyUlhlR3hqZVRsMFlqSTFjR1JIT1hsWlZ6RnNZbTVTZGt3eWJIUmpSMFpxWkVjNWVreHVRbTlqUVQwOQ==&ID="+dataIds+"&tipo="+target+"&node="+node.id,
				cacheData: false,
				active: true
			}));
			myTab.removeTab(myTab.getTab(0));			
		}
	}
	
	WBS.lbClick = function (node){
		if (node.data.tipo != 'destinacao_final') {
		//	WBS.wait.show();
			WBS.IDRel[node.data.tipo] = node.data.ID;
			WBS.IDRel['last'] = node.data.ID;
			dataIds = node.data.ID;
			target = node.data.tipo;
			var sUrl = "geraconteudo.php?f=WWxjNWEyUlhlR3hqZVRsMFlqSlNabVJIVm5wa1IxVjJaRWRHYVZneWVIWlpWMUpzWTJrMWQyRklRVDA9&ID="+dataIds+"&tipo="+target+"&node="+node.id;
			YAHOO.util.Connect.asyncRequest('GET', sUrl, {
				success:function (o) {
					WBS.cen.setBody(o.responseText);
					WBS.cen.render();
					WBS.pagina.ExtraiScript(o.responseText);
					WBS.wait.hide();
				},
				failure:function(o){
					alert('ERRO');
				}
															   
															   });
		}
	/*	WBS.lastOpen = node;
		//if (node.data.tipo != 'destinacao_final') {
			WBS.IDRel[node.data.tipo] = node.data.ID;
			WBS.IDRel['last'] = node.data.ID;
			dataIds = node.data.ID;
			target = node.data.tipo;
			myTab.addTab(new YAHOO.widget.Tab({
				label: node.data.label,
				
				closer: true,
				id: node.data.ID,
				dataSrc: "geraconteudo.php?f=WWxjNWEyUlhlR3hqZVRsMFlqSlNabVJIVm5wa1IxVjJaRWRHYVZneWVIWlpWMUpzWTJrMWQyRklRVDA9&ID="+dataIds+"&tipo="+target+"&node="+node.id,
				cacheData: true,
				active: true
			}));
			myTab.removeTab(myTab.getTab(0));	
			//WBS.wait.hide();*/
	}
	
	WBS.loadNode = function (node){
		callback = {
			success: function (oResponse){ 
				var oResults = eval("(" + oResponse.responseText + ")");
				if((oResults.ResultSet.Result) && (oResults.ResultSet.Result.length)) {
					
					//Result is an array if more than one result, string otherwise
					if(YAHOO.lang.isArray(oResults.ResultSet.Result)) {
						for (var i=0, j=oResults.ResultSet.Result.length; i<j; i++) {
						tempNode = new YAHOO.widget.TextNode(oResults.ResultSet.Result[i], node, false, {id:oResults.ResultSet.Result[i]['ID'], tipo:oResults.ResultSet.Result[i]['tipo']});
						tempNode.labelStyle = oResults.ResultSet.Result[i]['estilo'];
						tempNode.isLeaf = oResults.ResultSet.Result[i]['leaf'];
						}
					} else {
					//there is only one result; comes as string:
						tempNode = new YAHOO.widget.TextNode(oResults.ResultSet.Result, node, false, {id:oResults.ResultSet.Result[i]['ID'], tipo:oResults.ResultSet.Result[i]['tipo']})
						tempNode.labelStyle = oResults.ResultSet.Result[i]['estilo'];
						tempNode.isLeaf = oResults.ResultSet.Result[i]['leaf'];
					}	
				}
			},
			failure: function(oResponse){
				alert('erro 126');	
			}
		}		
		
		var nodeLabel = encodeURI(node.label);
		var sUrl = "modules/mod_teste/hander.php?id=" + node.data['ID'] + "&tipo=" + node.data['tipo'];
		YAHOO.util.Connect.asyncRequest('GET', sUrl, callback);
	}

	WBS.addIDTree = function (o, tar, elTree) {
		WBS.wait.show();
		var RecordIds = o.getSelectedRows();
		var dataIds = new Array();
		var recordset = o.getRecordSet();
		
		for (i=0; i<RecordIds.length; i++){
			data = recordset.getRecord(RecordIds[i])
			dataIds.push(data._oData['id']);
			WBS.IDs[data._oData['id']] = true;

		}
		
		var target = tar;
		var _hande = {	 
			success: function(oResponse){ 
				node = elTree.getNodeByProperty('ID',WBS.MID);
				node.isLeaf = false;
				node.collapse();
				elTree.removeChildren(node);
				node.expand();
				o.unselectAllRows();
				o.refreshView();
				checkboxes = YAHOO.util.Dom.getElementsByClassName(YAHOO.widget.DataTable.CLASS_CHECKBOX, "input", o.getTbodyEl());	
				WBS.wait.hide();

			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].checked == true) {
					checkboxes[i].checked = false;
				}
			}
			//if (l) { 
			//	location.reload(); 
			//}
		},
		failure: function(o){  },
		timeout:1000
			
		}
		
		var dt = '';
		for (var i=0; i==WBS.IDRel.length; i++){
			dt += WBS.IDRel[WBS.nxh[i]]+'_';
		}
		var url = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&arr="+dataIds+"&tipo="+target+"&tabela=treeadd&keys="+WBS.IDRel['last'];
		//alert(url);
		YAHOO.util.Connect.asyncRequest('GET',url, _hande, null);		
	}
	
	WBS.callbackrefresh = function (o){
		WBS.reloadGrids(o);
		//WBS.upTable[0].onDataReturnInitializeTable(WBS.upTable[0].get('initialRequest',o.responseText));
	}
	
	WBS.cbrefresh = {
		success: function(o){
			if(WBS.upTable[0]){
				WBS.reloadGrids(o);
				//WBS.upTable[0].reloadTable();
				//alert('upd');
				//WBS.upTable[0].onDataReturnInitializeTable(WBS.upTable[0].get('initialRequest',o.responseText));
			} else {
				window.location = 'index.php';
			}
		},
		failure: function (o){
			alert('ERRO');
		}
	}
	
	WBS.pagina = function() {};
	WBS.findTable = new Array();
	
	[].indexOf || (Array.prototype.indexOf = function(v,n){
		  n = (n==null)?0:n; var m = this.length;
		  for(var i = n; i < m; i++)
			if(this[i] == v)
			   return i;
		  return -1;
		});

	WBS.pagina.prototype._grid = null;
	WBS.pagina.prototype._cpanel = null;
	WBS.pagina.prototype.oldtab = null;
	WBS.pagina.prototype._opentabs = new Array();
	WBS.ida = 0;
	WBS.pagina.cl = function (param) {
		var kar = param+' <span class="close">&nbsp;<img src="images/close.gif" alt="Fechar esta aba"></span>';
		return kar;
	}
	
	WBS.pagina.ExtraiScript = function(texto){
    var ini, pos_src, fim, codigo;
    var objScript = null;
    ini = texto.indexOf('<script', 0)
    while (ini!=-1){
        var objScript = document.createElement("script");
        //Busca se tem algum src a partir do inicio do script
        pos_src = texto.indexOf(' src', ini)
        ini = texto.indexOf('>', ini) + 1;

        //Verifica se este e um bloco de script ou include para um arquivo de scripts
        if (pos_src < ini && pos_src >=0){//Se encontrou um "src" dentro da tag script, esta e um include de um arquivo script
            //Marca como sendo o inicio do nome do arquivo para depois do src
            ini = pos_src + 4;
            //Procura pelo ponto do nome da extencao do arquivo e marca para depois dele
            fim = texto.indexOf('.', ini)+4;
            //Pega o nome do arquivo
            codigo = texto.substring(ini,fim);
            //Elimina do nome do arquivo os caracteres que possam ter sido pegos por engano
            codigo = codigo.replace("=","").replace(" ","").replace("\"","").replace("\"","").replace("\'","").replace("\'","").replace(">","");
            // Adiciona o arquivo de script ao objeto que sera adicionado ao documento
            objScript.src = codigo;
        }else{//Se nao encontrou um "src" dentro da tag script, esta e um bloco de codigo script
            // Procura o final do script
            fim = texto.indexOf('</script>', ini);
            // Extrai apenas o script
            codigo = texto.substring(ini,fim);
            // Adiciona o bloco de script ao objeto que sera adicionado ao documento
            objScript.text = codigo;
        }
	
        //Adiciona o script ao documento
       // document.getElementById('container').appendChild(objScript);
        // Procura a proxima tag de <script
        ini = texto.indexOf('<script', fim);
		eval(objScript.text);
		//Limpa o objeto de script
        objScript = null;
    }
	loadform.sucesso();
}

	WBS.pagina.complete = function (query){
	    oTable.sendRequest('datatable=yes&query=' + query + '&zip=' + Dom.get('dt_input_zip').value + queryString, 
        oTable.onDataReturnInitializeTable, oTable); 	
	}
	
	WBS.pagina.pesquisa = function (campos, tabelas, oForm, oTable){
		oForm = oForm.parentNode;
		var cond = '';
		var counter = 0;
		oTable = (!oTable)?WBS.upTable[0]:oTable;
		for (var i=1; i < oForm.elements.length-1; i++){
			if (oForm.elements[i].value != ''){
				if (counter != 0) { cond = cond+' AND '; }
				counter++;
				var str = oForm.elements[i].value;
				var pass = str.replace('*',"%25");
				pass = pass.replace('*','%25');
				pass = pass.replace('*','%25');
				pass = pass.replace('*','%25');
				//alert(pass);
				cond = cond+oForm.elements[i].id+" LIKE '"+pass+"'";
			}
		}
		if (counter == 0) { alert('Formulario em branco'); } else {
			var oDs = oTable.getDataSource();
       		oDs.sendRequest('?campos='+campos+'&obj=' + tabelas + '&condicao=' + cond +'&pagina=1&numregistro=15',  oTable.onDataReturnInitializeTable, oTable);
		}
	}
	
	WBS.pagina._msg = function(tipo, alerta){
		var msg = document.getElementById('msg');
		msg.innerHTML = alerta;
		msg.className="";
		YAHOO.util.Dom.addClass(msg, tipo);
		YAHOO.util.Dom.setStyle(msg, 'display', 'block');
		setTimeout('WBS.pagina._msg.off()',1300);
	}
	
	WBS.pagina._msg.static = function(tipo, alerta){
		var msg = document.getElementById('msg');
		msg.innerHTML = alerta;
		msg.className="";
		YAHOO.util.Dom.addClass(msg, tipo);
		YAHOO.util.Dom.setStyle(msg, 'display', 'block');
	}
	
	WBS.pagina._msg.off = function(){
		document.getElementById('msg').className = '';
		document.getElementById('msg').style.display = 'none';	
	}
	
	WBS.pagina.showForm = {
		_arquivoAcesso:null,
		_caption:null,
		_pan:null,
	
		init:function(arquivoAcesso, caption, pan) {
			//alert(pan);
			this._pan = pan;
			this._arquivoAcesso = arquivoAcesso;
			this._caption = caption;
			//alert(this._pan);
			var transaction = YAHOO.util.Connect.asyncRequest('GET', arquivoAcesso, WBS.pagina.resultShowForm, null); 
		},
		sucesso:function(o) {
			
			var captionContainer = YAHOO.util.Dom.getElementsByClassName("CollapsiblePanelTab", "div", this._pan);
			var contentContainer = YAHOO.util.Dom.getElementsByClassName("CollapsiblePanelContent", "div", this._pan);

			captionContainer.innerHTML = this._caption;
			contentContainer[0].innerHTML = o.responseText;
			//alert(this._pan);
			YAHOO.util.Dom.setStyle(document.getElementById(this._pan), "display" , "block");

		},
		falha:function(o) {
			alert("Houve um erro ao tentar abrir o conteudo");
		}
	};
	WBS.pagina.resultShowForm = {
		success: WBS.pagina.showForm.sucesso,
		failure: WBS.pagina.showForm.falha,
		scope: WBS.pagina.showForm
	};

	WBS.pagina._verDados = function(oData, elCell, oSelf, oRecord, sId, oTable) {
		var myDataTable = oTable;
		myDataTable.unselectAllRows();
		myDataTable.select(oSelf.parentNode);

		var id = sId;
	/*
		if (!WBS.pagina.prototype._opentabs[oData+id]){
			WBS.pagina.prototype._opentabs[oData+id] = true;
			if	(WBS.pagina.prototype._opentabs.indexOf(oData)<0){
				var newTab = new YAHOO.widget.Tab({
					label: WBS.pagina.cl('Detalhe: '+id),
					dataLoaded: true,
					dataSrc: 'geraconteudo.php?file='+oData+'&id='+id,
					cachedData: true,
					active: true 
				});
		
				tabView.addTab(newTab);
				
				YAHOO.util.Event.on(newTab.getElementsByClassName('close')[0], 'click', function (e, tab){																
					YAHOO.util.Event.preventDefault(e);
					var tab0 = tabView.getTab(0);
					if (WBS.pagina.oldtab == null) { WBS.pagina.oldtab = tab0; };
					tabView.set('activeTab', WBS.pagina.oldtab);
					WBS.pagina.prototype._opentabs[oData+id] = null;
					tabView.removeTab(tab);
					
				}, newTab);
				WBS.pagina.prototype._opentabs[oData+id] = tabView.getTabIndex(newTab);
			}
		}else{
			tabView.set('activeIndex',WBS.pagina.prototype._opentabs[oData+id]);
		}*/
		window.location = 'index.php?f='+oData+'&recordID='+sId;
	};	