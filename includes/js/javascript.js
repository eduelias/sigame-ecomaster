function insert_br(el)
{
	var text = el.textContent;
	el.textContent = '';
	var normalized_Enters = text.replace(/\r|\n/g, "\r\n");
	var text_with_br = normalized_Enters.replace(/\r\n/g, "</p><p align='justify'>");
	el.textContent = text_with_br;
	//alert(text_with_br);
	return text_with_br;
}

SIGAME = {
	relacionador:'WWxjNWEyUlhlR3hqZVRsNVdsZDRhR1JIYkhaaWJrMTJZMjFXYzFsWFRuWmFXRTExWTBkb2R3PT0=',
	action:null,
	id:null,
	empresa:null,
	nome_campo_a:null,
	nome_campo_b:null,
	valor_campo_a:null,
	valor_campo_b:null,
	nome_tb_a:null,
	nome_tb_b:null,
	nome_tb_rel:null,
	set_action:function(action){
		this.action = action;	
	},
	set_id:function(id){
		this.valor_campo_b = id;
	},
	save:function(){
		var str = 'geraconteudo.php?file='+this.relacionador+'&ca='+this.nome_campo_a+'&id1='+this.valor_campo_a+'&cb='+this.nome_campo_b+'&id2='+this.valor_campo_b+'&tb_rel='+this.nome_tb_rel+'&emp='+this.empresa+'&act='+this.action;
		if (this.action=='ul1'){ 
			WBS.pagina._msg('alert','Relacionamento criado');
		} else {
			WBS.pagina._msg('alert','Relacionamento desfeito');
		}
		var trans = YAHOO.util.Connect.asyncRequest('GET', str, null)
	}
}

var mt = {
	_DataTable:null,
	_backup:null,
	load:function(oTable){
		//myDataTable = _backup;
	},
	save:function(){
	//	_backup = myDataTable;	
	}
}

function array_search(busca,oarray){
    //ve se determinado valor existe no array e retorna sua chave
    for(var i in oarray){
        if(oarray[i]==busca){return true;}
    }
    return false;
}

var divCentral = {	
	_opened:false,
	_arquivo:null,
	carrega:function(arquivo, oTable){
		WBS.test = oTable;
		this._arquivo = arquivo;
		var trans = YAHOO.util.Connect.asyncRequest('GET', 'geraconteudo.php?file='+arquivo, resultDiv)
	},
	on:function(o){
		//mt.save();
		document.getElementById('container').style.display = 'block';
		//
		WBS.panel2.setBody(o.responseText);
		WBS.panel2.show();
		//WBS.o = o;
		WBS.pagina.ExtraiScript(o.responseText);
		WBS.pagina._msg.off();
	},
		
	off:function(){
		//mt.load();
		YAHOO.util.Dom.setStyle(document.body,'overflow','auto');
		//document.getElementById('container').style.display = 'none';
		WBS.panel2.hide();
	}
}

var resultDiv = {
	success:divCentral.on, 
	failure:divCentral.off,
	scope:window,
	timeout:5000	
}

var loadform = {
	_div0:null,
	carregando:function(texto){
		WBS.wait.show();  
	},
	aparecer:function(texto){
		WBS.wait.show();
	},
	fundo:function(){
		WBS.wait.show();
	},
	socarrega:function(){
		WBS.wait.show();
	},
	off:function(texto) {
		WBS.wait.hide(); 
	},	
	sucesso:function(){
		setTimeout(function () { loadform.off() },1000);
	},
	sumir:function(){
		setTimeout(function() { loadform.off() }, 1000);	
	}
}

var ajaxForm = {
	myDataTable:null,
	subForm:function(form) {
		//this.myDataTable = oTable;
		//alert(oTable);
		//this.loading.on("Carregando", form);
		YAHOO.util.Connect.setForm(form);
		var cObj = YAHOO.util.Connect.asyncRequest(form.method, encodeURI(form.action), resultForm);
		//YAHOO.util.Event.addListener(cObj, 'successEvent', WBS.callbackrefresh(o), cObj);
		return false;
	},
	formSucesso:function(o) {
		var result = JSON.parse(o.responseText);
		if (result.erro == 0) {
			WBS.panel2.hide();
			var rSet = WBS.upTable[0].getDataSource();
			rSet.sendRequest(WBS.upTable[0]._configs.initialRequest.value, WBS.upTable[0].onDataReturnInitializeTable, WBS.upTable[0]);
			//YAHOO.util.Dom.addClass(this.loading._loading, "sucesso");
			//this.loading.off("Sucesso");
			WBS.pagina._msg('green','Inserido.');
		}
		else {
			YAHOO.util.Dom.addClass(this.loading._loading, "erro");
			this.loading.off("Erro");
		}
	},
	formErro:function(o) {
		YAHOO.util.Dom.addClass(this.loading._loading, "erro");
		this.loading.off("Erro");
	},
	loading:{
	_fundo:null,
	_loading:null,
	_intervalo:null,
	on:function(texto) {
		//pega a altura e largura da tela do usuário (exclui tamanho de barra de rolagem)
		var w = YAHOO.util.Dom.getViewportWidth();
		var h = YAHOO.util.Dom.getViewportHeight();

		//pega o scroll top
		var top = YAHOO.util.Event._getScrollTop();

		//pega a altura total do documento
		var docHeight = YAHOO.util.Dom.getDocumentHeight();
		var docWidth = YAHOO.util.Dom.getDocumentWidth();

		//elimina a barra de rolagem da tela
		YAHOO.util.Dom.addClass(document.body, "nooverflow");

		//cria a div escura de fundo
		this._fundo = document.body.appendChild(document.createElement("div"));

		YAHOO.util.Dom.setStyle(this._fundo, "filter", 'progid:DXImageTransform.Microsoft.Alpha(style=1,opacity=15)');

		this._loading = document.body.appendChild(document.createElement("div"));
		this._loading.id = 'loading';

		YAHOO.util.Dom.addClass(this._loading, "lform");

		//inclui o texto de carregamento na div
		this._loading.innerHTML = texto;

		//seta posição X e Y da div de acordo com o tamanho da tela do usuário
		YAHOO.util.Dom.setX(this._loading, (w/2)-50);
		YAHOO.util.Dom.setY(this._loading, ((h/2)+top)-25);

		//seta a classe "fundo" para o fundo transparente
		YAHOO.util.Dom.addClass(this._fundo, "fundo");
		//dá altura máxima do documento para o fundo
		YAHOO.util.Dom.setStyle(this._fundo, "height", docHeight+"px");
		YAHOO.util.Dom.setStyle(this._fundo, "width", docWidth+"px");

		},
		off:function(texto) {
			//inclui o texto de carregamento na div
			this._loading.innerHTML = texto;

			//timeout de 1 segundo para sumir com o loading para exibir o resultado (erro ou sucesso)
			setTimeout(function() {
				ajaxForm.loading._fundo.parentNode.removeChild(ajaxForm.loading._fundo);
				ajaxForm.loading._loading.parentNode.removeChild(ajaxForm.loading._loading);
				YAHOO.util.Dom.addClass(document.body, "autooverflow");
				YAHOO.util.Dom.setStyle("cPanel1", "display" , "block");
			}, 1000);
		}
	}
};

var resultForm = {
	success:ajaxForm.formSucesso, 
	failure:ajaxForm.formErro,
	scope:ajaxForm,
	timeout:5000
};

var cria_closes = function() {    
    tabView.on('contentReady', function() { // ensure Tabs exist before accessing
        YAHOO.util.Dom.batch(tabView.get('tabs'), function(tab) {
            YAHOO.util.Event.on(tab.getElementsByClassName('close')[0], 'click', handleClose, tab);
    	});
        
    	YAHOO.util.Event.on('add-tab', 'click', addTab, tabView, true);
  	});
    
    var handleClose = function(e, tab) {
        YAHOO.util.Event.preventDefault(e);
        tabView.removeTab(tab);
    };
};        

//********************************************************************* Resize Panel
YAHOO.namespace("example.container");

// BEGIN RESIZEPANEL SUBCLASS //
YAHOO.widget.ResizePanel = function(el, userConfig) {
	if (arguments.length > 0) {
		YAHOO.widget.ResizePanel.superclass.constructor.call(this, el, userConfig);
	}
}

YAHOO.widget.ResizePanel.CSS_PANEL_RESIZE = "yui-resizepanel";   
   
YAHOO.widget.ResizePanel.CSS_RESIZE_HANDLE = "resizehandle"; 


YAHOO.extend(YAHOO.widget.ResizePanel, YAHOO.widget.Panel, {

    init: function(el, userConfig) {
    
        YAHOO.widget.ResizePanel.superclass.init.call(this, el);
    
        this.beforeInitEvent.fire(YAHOO.widget.ResizePanel);
        
        var Dom = YAHOO.util.Dom,
            Event = YAHOO.util.Event,
            oInnerElement = this.innerElement,
            oResizeHandle = document.createElement("DIV"),
            sResizeHandleId = this.id + "_resizehandle";
         
         oResizeHandle.id = sResizeHandleId;
         oResizeHandle.className = YAHOO.widget.ResizePanel.CSS_RESIZE_HANDLE;
    
        Dom.addClass(oInnerElement, YAHOO.widget.ResizePanel.CSS_PANEL_RESIZE);
    
        this.resizeHandle = oResizeHandle;
    
        function initResizeFunctionality() {
    
            var me = this,
                oHeader = this.header,
                oBody = this.body,
                oFooter = this.footer,
                nStartWidth,
                nStartHeight = '500px',
                aStartPos,
                nBodyBorderTopWidth,
                nBodyBorderBottomWidth,
                nBodyTopPadding,
                nBodyBottomPadding,
                nBodyOffset;
    
    
            oInnerElement.appendChild(oResizeHandle);
    
            this.ddResize = new YAHOO.util.DragDrop(sResizeHandleId, this.id);
    
            this.ddResize.setHandleElId(sResizeHandleId);
    
            this.ddResize.onMouseDown = function(e) {
    
                nStartWidth = oInnerElement.offsetWidth;
                nStartHeight = oInnerElement.offsetHeight;
    
                if (YAHOO.env.ua.ie && document.compatMode == "BackCompat") {
                
                    nBodyOffset = 0;
                
                }
                else {
    
                    nBodyBorderTopWidth = parseInt(Dom.getStyle(oBody, "borderTopWidth"), 10),
                    nBodyBorderBottomWidth = parseInt(Dom.getStyle(oBody, "borderBottomWidth"), 10),
                    nBodyTopPadding = parseInt(Dom.getStyle(oBody, "paddingTop"), 10),
                    nBodyBottomPadding = parseInt(Dom.getStyle(oBody, "paddingBottom"), 10),
                    
                    nBodyOffset = nBodyBorderTopWidth + nBodyBorderBottomWidth + nBodyTopPadding + nBodyBottomPadding;
                
                }
    
                me.cfg.setProperty("width", nStartWidth + "px");
		//		me.cfg.setProperty("height", nStartHeight + "px");
    
                aStartPos = [Event.getPageX(e), Event.getPageY(e)];
    
            };
            
            this.ddResize.onDrag = function(e) {
    
                var aNewPos = [Event.getPageX(e), Event.getPageY(e)],
                
                    nOffsetX = aNewPos[0] - aStartPos[0],
                    nOffsetY = aNewPos[1] - aStartPos[1],
                    
                    nNewWidth = Math.max(nStartWidth + nOffsetX, 10),
                    nNewHeight = Math.max(nStartHeight + nOffsetY, 10),
                    
                    nBodyHeight = (nNewHeight - (oFooter.offsetHeight + oHeader.offsetHeight + nBodyOffset));
    
                me.cfg.setProperty("width", nNewWidth + "px");
    
                if (nBodyHeight < 0) {
    
                    nBodyHeight = 0;
    
                }
    
                oBody.style.height =  nBodyHeight + "px";
    
            };
        
        }
    
    
        function onBeforeShow() {
    
           initResizeFunctionality.call(this);
    		
           this.unsubscribe("beforeShow", onBeforeShow);
    
        }
    
    
        function onBeforeRender() {
    
            if (!this.footer) {
    
                this.setFooter("");
    
            }
    
            if (this.cfg.getProperty("visible")) {
    
                initResizeFunctionality.call(this);
    
            }
            else {
    
                this.subscribe("beforeShow", onBeforeShow);
            
            }
            
            this.unsubscribe("beforeRender", onBeforeRender);
    
        }
    
    
        this.subscribe("beforeRender", onBeforeRender);
    
    
        if (userConfig) {
    
            this.cfg.applyConfig(userConfig, true);
    
        }
    
        this.initEvent.fire(YAHOO.widget.ResizePanel);
    
    },
    
    toString: function() {
    
        return "ResizePanel " + this.id;
    
    }

});

