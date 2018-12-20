var formater = {};

//evento que é executado ao alterar o valor de uma célula
var onCellEditOld = function(oArgs) {
	WBS.tea = oArgs
	var oldData = oArgs.oldData || "";	
	var newData = oArgs.newData || "";
	var TABELA = " ";
	var ID = " ";
	//$grid .= (WBS.debug.liveEditor)?"alert(oArgs.newData);\r\n":"";
	var alterar = oArgs.editor.column.key;
	var chaveee = oArgs.editor.record._oData+".$this->ID."; 
	var url = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&tabela="+TABELA+"&keyfield="+ID+"&id=\"+chaveee+\"&field=\"+alterar+\"&val=\"+encodeURIComponent(newData)";
	//$grid .= (WBS.debug.liveEditor)?"alert(url); \r\n":'';
	YAHOO.util.Connect.asyncRequest('GET',url, {success: function(o){ }, failure: function(o) {alert('falhou');} }, null); 
};

YAHOO.widget.DataTable.formatNeg = function(el, oRecord, oColumn, oData){
	var elTr = el.parentNode;
	if (oData < 0){	 
		YAHOO.util.Dom.setStyle(elTr,"background-color","#FFEEEE") 
	} else { 
		YAHOO.util.Dom.setStyle(elTr, "background-color","");
	}
	el.innerHTML = oData;
}

YAHOO.widget.DataTable.prototype.reloadTable = function (){
	var oTable = this;
	var oDs = oTable.getDataSource();
	var url2 = oTable._configs.initialRequest.value;
	oDs.sendRequest(url2, oTable.onDataReturnInitializeTable, oTable);  
}
/*
Event action para Salvar campos do tipo 'textbox';
*/
YAHOO.widget.DataTable.formatDropdown = function(el, oRecord, oColumn, oData) {
    var selectedValue = (YAHOO.lang.isValue(oData)) ? oData : oRecord.getData(oColumn.key);
    var options = (YAHOO.lang.isArray(oColumn.dropdownOptions)) ?
            oColumn.dropdownOptions : null;
	var oTable = this;
    var selectEl;
    var collection = el.getElementsByTagName("select");

	var id = parseInt(oRecord._oData[this._campochave]);
	var table = this._tablename;
	var campochave = this._campochave;
	var selectedValue = oData;

	var futuro;

	el.id = id;
    
    // Create the form element only once, so we can attach the onChange listener
    if(collection.length === 0) {
        // Create SELECT element
        selectEl = document.createElement("select");
        YAHOO.util.Dom.addClass(selectEl, YAHOO.widget.DataTable.CLASS_DROPDOWN);
        selectEl = el.appendChild(selectEl);

    selectEl = collection[0];

    // Update the form element
    if(selectEl) {
        // Clear out previous options
        selectEl.innerHTML = "";
        
        // We have options to populate
        if(options) {
            // Create OPTION elements
            for(var i=0; i<options.length; i++) {
                var option = options[i];
                var optionEl = document.createElement("option");
                optionEl.value = (YAHOO.lang.isValue(option.value)) ?
                        option.value : option;
                optionEl.innerHTML = (YAHOO.lang.isValue(option.text)) ?
                        option.text : option;
                optionEl = selectEl.appendChild(optionEl);
				if (option.text === oData){optionEl.selected = true }; //ALTERADA POR du7@msn.com
            }
        }
        // Selected value is our only option
        else {
            selectEl.innerHTML = "<option value=\"" + selectedValue + "\">" + selectedValue + "</option>";
        }
    }
    else {
        el.innerHTML = YAHOO.lang.isValue(oData) ? oData : "";
    }
	
	var alter_campo = option.field;
	_dropDown = function () {
		//alert(selectEl.value);
		var url = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&tabela="+table+"&id="+id+"&keyfield="+campochave+"&field="+alter_campo+"&val="+selectEl.value;
		
		YAHOO.util.Connect.asyncRequest('GET',url, {} , null);
	}
							
	// Add event listener
	YAHOO.util.Event.addListener(selectEl,"change", _dropDown , this);
    }
};

/**
 * Formats cells in Columns of type "checkbox" para S ou N.
 *
 * @method formatSimNao
 * @param elCell {HTMLElement} Table cell element.
 * @param oRecord {YAHOO.widget.Record} Record instance.
 * @param oColumn {YAHOO.widget.Column} Column instance.
 * @param oData {Object} Data value for the cell, or null
 * @static
 */
YAHOO.widget.DataTable.formatSimNao = function(elCell, oRecord, oColumn, oData) {
 	var selectedValue = oData;
	var opt = oColumn.selected;
	var sel = document.createElement('input');
	sel.type = 'checkbox';
	var _tablename = this._tablename;
	var id = parseInt(oRecord._oData[this._campochave]);
	elCell.innerHTML = '';
	elCell.appendChild(sel);
	
	if(selectedValue != 'false'){
		sel.checked = true;	
	} 	
	
	var _hande = {	
		success: function(o){ WBS.pagina._msg('alerta','Altera&ccedil;&atilde;o feita!') },
		failure: function(o){  },
		timeout:1000
	}
		
	YAHOO.util.Event.addListener(sel, 'click', function(e, oSelf){
		var alter_campo = oColumn.key;
		var id1 = id;
		//alert('e');
		var value = (sel.checked)? oData:"FALSE";

		var url = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&tabela="+_tablename+"&id1="+id1+"&id2="+WBS.pagina.idgeral+"&field="+alter_campo+"&val="+value;
		YAHOO.util.Connect.asyncRequest('GET',url, _hande, null);															
	}, sel);	
};

/**
 * Formats cells in Columns of type "select" para imagens.
 *
 * @method formatSelect
 * @param elCell {HTMLElement} Table cell element.
 * @param oRecord {YAHOO.widget.Record} Record instance.
 * @param oColumn {YAHOO.widget.Column} Column instance.
 * @param oData {Object} Data value for the cell, or null
 * @static
 */
YAHOO.widget.DataTable.formatSelectSim = function(elCell, oRecord, oColumn, oData) {
	var id = parseInt(oRecord._oData[this._campochave]);
	var table = this._tablename;
	var campochave = this._campochave;
	var selectedValue = oData;
	var alter_campo = oColumn.key;
	var opt = oColumn.selectOptions;
	var sel = document.createElement('img');

	if (opt) {
		for (var i=0;i<opt.length;i++){
			var option = opt.substr(i,1);
			
			if(selectedValue === 'S'){
				sel.src = 'images/sim.gif';
				sel.value = 'N';
			} else {
				sel.src = 'images/nao.gif';	
				sel.value = 'S';
			}
		}
	}
 		if (!elCell.firstChild) { elCell.appendChild(sel); }

var _hande = {	
		success: function(o){ 
			sel.value = (sel.value === 'S')?'N':'S';
			sel.src = (sel.value === 'N')?'images/sim.gif':'images/nao.gif';
			//WBS.pagina._msg('alerta','Altera&ccedil;&atilde;o feita!')
		},
		failure: function(o){  },
		timeout:1000
	}
	
	YAHOO.util.Event.addListener(sel, 'click', function(e, oSelf){
		
		var url = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&tabela="+table+"&id="+id+"&keyfield="+campochave+"&field="+alter_campo+"&val="+elCell.firstChild.value;
		//alert(url);
		YAHOO.util.Connect.asyncRequest('GET',url, _hande, null);															
	}, elCell);
};

/**
	BOLINHA FORMATTER (1/0)
*/
YAHOO.widget.DataTable.formatbool = function(elCell, oRecord, oColumn, oData){
	var ON = '';
	var OFF = '';
	// ON = 'on.png';
	//OFF = 'off.png';
	 ON = 'button_ok.png';
	OFF = 'no.png';
	var id = parseInt(oRecord._oData[this._campochave]);
	var table = this._tablename;
	var campochave = this._campochave;
	var selectedValue = oData;
	var alter_campo = oColumn.key;
	var futuro;
	var oTable = this;
	elCell.id = id;
	//alert(this._campochave)
	//alert(oData+' '+id+' '+alter_campo);
	if(oData != '0'){
		elCell.innerHTML = '<img src="images/'+ON+'">';
		YAHOO.util.Dom.setStyle(elCell,'text-align','center');
		futuro = '0';
	} else {
		elCell.innerHTML = '<img src="images/'+OFF+'">';
		YAHOO.util.Dom.setStyle(elCell,'text-align','center');
		futuro = '1';
	}
	
	YAHOO.util.Event.addListener(elCell.lastChild, 'click', function(e, oSelf){
		if (id == elCell.id){
			oRecord._oData[alter_campo] = futuro;
			if(futuro === '1'){
				oSelf.src = "images/"+ON;
				futuro = '0';
			} else {
				oSelf.src="images/"+OFF;
				futuro = '1';
			}
			
			var _hande = {	
				success: function(o){  },
				failure: function(o){  },
				timeout:1000
			}
		
			var url = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&tabela="+table+"&id="+id+"&keyfield="+campochave+"&field="+alter_campo+"&val="+oRecord._oData[alter_campo]+"&k2="+WBS.MasterKey+"&val2="+WBS.MasterID;
	
			YAHOO.util.Connect.asyncRequest('GET',url, _hande, null);		
		}
	}, elCell.lastChild);
}

/**
	BOLINHA FORMATTER
*/
YAHOO.widget.DataTable.formatdot = function(elCell, oRecord, oColumn, oData){
	var id = parseInt(oRecord._oData[this._campochave]);
	var table = this._tablename;
	var campochave = this._campochave;
	var selectedValue = oData;
	var alter_campo = oColumn.key;
	var futuro;
	var oTable = this;
	elCell.id = id;
	//alert(oData+' '+id+' '+alter_campo);
	if(oData != 'N'){
		elCell.innerHTML = '<img src="images/sim.gif">';
		YAHOO.util.Dom.setStyle(elCell,'text-align','center');
		futuro = 'N';
	} else {
		elCell.innerHTML = '<img src="images/nao.gif">';
		YAHOO.util.Dom.setStyle(elCell,'text-align','center');
		futuro = 'S';
	}
	
	YAHOO.util.Event.addListener(elCell.lastChild, 'click', function(e, oSelf){
		if (id == elCell.id){
			
			oRecord._oData[alter_campo] = futuro;
			if(futuro === 'S'){
				oSelf.src = "images/sim.gif";
				futuro = 'N';
			} else {
				oSelf.src="images/nao.gif";
				futuro = 'S';
			}
			
			var _hande = {	
				success: function(o){  },
				failure: function(o){  },
				timeout:1000
			}
		
			var url = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&tabela="+table+"&id="+id+"&keyfield="+campochave+"&field="+alter_campo+"&val="+oRecord._oData[alter_campo];
	
			YAHOO.util.Connect.asyncRequest('GET',url, _hande, null);		
		}
	}, elCell.lastChild);
}

/**
 * Formats cells in Columns of type "select".
 *
 * @method formatSelect
 * @param elCell {HTMLElement} Table cell element.
 * @param oRecord {YAHOO.widget.Record} Record instance.
 * @param oColumn {YAHOO.widget.Column} Column instance.
 * @param oData {Object} Data value for the cell, or null
 * @static
 */
YAHOO.widget.DataTable.formatSelect= function(elCell, oRecord, oColumn, oData) {
	var id = parseInt(oRecord._oData[this._campochave]);
	var table = this._tablename;
	var campochave = this._campochave;
	var selectedValue = oData;
	var alter_campo = oColumn.key;
	var futuro;
	var oTable = this;
	elCell.id = id;
	
	if(oData === 'S'){
		elCell.innerHTML = '<img src="images/sim.gif">';
		
		futuro = 'N';
	} else {
		elCell.innerHTML = '<img src="images/nao.gif">';
		futuro = 'S';
	}
	
	YAHOO.util.Event.addListener(elCell.lastChild, 'click', function(e, oSelf){
		if (id == elCell.id){
			
			oRecord._oData[alter_campo] = futuro;
			if(futuro === 'S'){
				oSelf.src = "images/sim.gif";
				futuro = 'N';
			} else {
				oSelf.src="images/nao.gif";
				futuro = 'S';
			}
			
			var _hande = {	
				success: function(o){  },
				failure: function(o){  },
				timeout:1000
			}
		
			var url = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&tabela="+table+"&id="+id+"&keyfield="+campochave+"&field="+alter_campo+"&val="+oRecord._oData[alter_campo];
	
			YAHOO.util.Connect.asyncRequest('GET',url, _hande, null);		
		}
	}, elCell.lastChild);
};

/**
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
    var markup = "<a href='#' id='add-tab'><img src='images/view.gif' alt='Ver Dados' title='Ver Dados' border='0'/></a>";
    elCell.innerHTML = markup;
	var viewfile = this._viewFile;
	var oTable = this;
	YAHOO.util.Event.addListener(elCell.firstChild, "click", function (e, oSelf) { 
				WBS.MasterId = id;
				WBS.pagina._verDados(viewfile, oData, oSelf, oRecord, id, oTable) } , elCell);
};

/**
 * Formats cells in Columns of type "edit".
 *
 * @method formatEdit
 * @param elCell {HTMLElement} Table cell element.
 * @param oRecord {YAHOO.widget.Record} Record instance.
 * @param oColumn {YAHOO.widget.Column} Column instance.
 * @param oData {Object} Data value for the cell, or null
 * @static
 */
YAHOO.widget.DataTable.formatEdit = function(elCell, oRecord, oColumn, oData) {
    var markup = "<img src='images/edit.gif' alt='Editar Dados' title='Editar Dados' />";
    elCell.innerHTML = markup;
	var fEdit = this._editFile;
	var oTable = this;
	
	var id = parseInt(oRecord._oData[this._campochave]);
	
    YAHOO.util.Event.addListener(elCell.firstChild, "click", function(e, oSelf) {
			oTable.select(oSelf.parentNode);
			WBS.pagina._msg.static('info','Aguarde, conectando...');
			divCentral.carrega(fEdit+'&id='+id);
	}
	, elCell);
};

YAHOO.widget.DataTable.formatEdit_off = function(elCell, oRecord, oColumn, oData) {
    var markup = "<img src='images/edit.gif' alt='Editar Dados' title='Editar Dados' />";
    elCell.innerHTML = markup;
	var fEdit = this._editFile;
	var oTable = this;
	
	var id = parseInt(oRecord._oData[this._campochave]);
	
    YAHOO.util.Event.addListener(elCell.firstChild, "click", function(e, oSelf) {
			oTable.select(oSelf.parentNode);
			window.location = 'index.php?f='+fEdit+'&recordID='+id;
			//divCentral.carrega(fEdit+'&id='+id);
	}
	, elCell);
};

YAHOO.widget.DataTable.formatRelation = function(elCell, oRecord, oColumn, oData) {
	var id = parseInt(oRecord._oData[this._campochave]);
	//alert(id);
    var markup = "<a href='#' id='add-tab'><img src='images/view.gif' alt='Ver Dados' title='Ver Dados' border='0'/></a>";
    elCell.innerHTML = markup;
	var viewfile = this._viewFile;
	var oTable = this;
	YAHOO.util.Event.addListener(elCell.firstChild, "click", function (e, oSelf) { 
				WBS.MasterId = id;
				WBS.pagina._verDados(viewfile, oData, oSelf, oRecord, id, oTable) } , elCell);
};

YAHOO.widget.DataTable.formatImagem = function (elCell, oRecord, oColumn, oData){
	var markup = "<img src='images/"+oData+"'>";
	//alert(markup);
	classname = YAHOO.widget.DataTable.CLASS_STRING;
	elCell.innerHTML = markup;
}

/**
 * Formats cells in Columns of type "delete".
 *
 * @method formatDelete
 * @param elCell {HTMLElement} Table cell element.
 * @param oRecord {YAHOO.widget.Record} Record instance.
 * @param oColumn {YAHOO.widget.Column} Column instance.
 * @param oData {Object} Data value for the cell, or null
 * @static
 */
YAHOO.widget.DataTable.formatDelete = function(elCell, oRecord, oColumn, oData) {
    var markup = "<img src='images/delete.gif' alt='Excluir Dados' title='Excluir Dados' />";
	var tablename = this._tablename;
	var deleteFile = this._deleteFile;
	var oTable = this;
	elCell.innerHTML = markup;
	var campochave = this._campochave;
	var idd = parseInt(oRecord._oData[this._campochave]);
	

    YAHOO.util.Event.addListener(elCell.firstChild, "click", function(e, oSelf) { 
		var request;
		if (idd != WBS.ida){	
			if (confirm("Deseja realmente excluir este registro?")) {
				var id = idd;
				var url1 = "geraconteudo.php?f="+deleteFile+"&table="+tablename+"&id="+id+"&keyfield="+campochave;
				YAHOO.util.Connect.asyncRequest('GET',url1,  {
																	 success: function (o) {
																		oTable.reloadTable();
																	 },
																	 failure: function (o) {
																		 alert('FAIO');
																	 }
																	 }, null);
				WBS.ida = idd;
			}
		}
	}, elCell);
};

/**
 * Overridable custom event handler to check the checkboxes of the selected rows
 *
 * @method onEventCheckCheckbox
 * @param oArgs.event {HTMLEvent} Event object.
 * @param oArgs.target {HTMLElement} Target element.
 */
YAHOO.widget.DataTable.prototype.onEventCheckCheckbox = function(oArgs) {
	
	var elTarget;
	var elTag;

	if (YAHOO.lang.isArray(oArgs.el)) {
		elTarget = oArgs.els[0];
	}
	else {
		elTarget = oArgs.el;
	}
	
    elTag = elTarget.tagName.toLowerCase();
	
    // Traverse up the DOM to find the row
    while(elTag != "tr") {
        // Bail out
        if(elTag == "body") {
            return;
        }
        // Maybe it's the parent
        elTarget = elTarget.parentNode;
        elTag = elTarget.tagName.toLowerCase();
    }

	var checkboxes = YAHOO.util.Dom.getElementsByClassName( YAHOO.widget.DataTable.CLASS_CHECKBOX, "input", elTarget);

	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].checked = "true";
	}
};

/**
 * Overridable custom event handler to uncheck the checkboxes of the selected rows
 *
 * @method onEventUncheckCheckbox
 * @param oArgs.event {HTMLEvent} Event object.
 * @param oArgs.target {HTMLElement} Target element.
 */
YAHOO.widget.DataTable.prototype.onEventUncheckCheckbox = function(oArgs) {
	var sel;
	var elTarget;
	var elTag;
	var checkboxes = new Array();
	WBS.arg = oArgs;
	if (YAHOO.lang.isArray(oArgs.el)) {
		
		for (var j = 0; j < oArgs.els.length; j++) {
			
			elTarget = oArgs.el[j];
		    elTag = elTarget.tagName.toLowerCase();

			// Traverse up the DOM to find the row
			while(elTag != "tr") {
				// Bail out
				if(elTag == "body") {
					return;
				}
				// Maybe it's the parent
				elTarget = elTarget.parentNode;
				elTag = elTarget.tagName.toLowerCase();
			}
		
			checkboxes = YAHOO.util.Dom.getElementsByClassName(YAHOO.widget.DataTable.CLASS_CHECKBOX, "input", elTarget);
		
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].checked == true) {
					checkboxes[i].checked = false;
				}
			}
		}
	}
	else {
		elTarget = oArgs.el;
		elTag = elTarget.tagName.toLowerCase();

// Traverse up the DOM to find the row
		while(elTag != "tr") {
			// Bail out
			if(elTag == "body") {
				return;
			}
			// Maybe it's the parent
			elTarget = elTarget.parentNode;
			elTag = elTarget.tagName.toLowerCase();
		}
	
		checkboxes = YAHOO.util.Dom.getElementsByClassName(YAHOO.widget.DataTable.CLASS_CHECKBOX, "input", elTarget);
	
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].checked == true) {
				checkboxes[i].checked = false;

			}
		}
	}

};

/**
 * Formats a  element.
 *
 * @method DataTable.format
 * @param el {HTMLElement} The element to format with markup.
 * @param oRecord {YAHOO.widget.Record} Record instance.
 * @param oColumn {YAHOO.widget.Column} Column instance.
 * @param oData {Object | Boolean} Data value for the cell. Can be a simple
 * Boolean to indicate whether  is checked or not. Can be object literal
 * {checked:bBoolean, label:sLabel}. Other forms of oData require a custom
 * formatter.
 * @static
 */
YAHOO.widget.DataTable.formatCheckCond = function(el, oRecord, oColumn, oData) {
  var bChecked;
  var elSelRows = this.getSelectedRows();
  var elId = oRecord._sId;
  if (array_search(elId,elSelRows)){
	  bChecked = 'checked'
  }
  else {
	  bChecked = '';
  }
  
  
  var elTr = el.parentNode;
  if (WBS.IDs[oData]) { 
	el.innerHTML = 'OK';
	YAHOO.util.Dom.setStyle(elTr,"background-color","#FF0000");
  } else {
	  YAHOO.util.Dom.setStyle(elTr,"background-color","");
	 el.innerHTML = "<input type=\"checkbox\"" + bChecked +" class=\"" + YAHOO.widget.DataTable.CLASS_CHECKBOX + "\" id="+oData+">";
  }
			
};

/**
 * Formats a  element.
 *
 * @method DataTable.format
 * @param el {HTMLElement} The element to format with markup.
 * @param oRecord {YAHOO.widget.Record} Record instance.
 * @param oColumn {YAHOO.widget.Column} Column instance.
 * @param oData {Object | Boolean} Data value for the cell. Can be a simple
 * Boolean to indicate whether  is checked or not. Can be object literal
 * {checked:bBoolean, label:sLabel}. Other forms of oData require a custom
 * formatter.
 * @static
 */
YAHOO.widget.DataTable.formatCheck = function(el, oRecord, oColumn, oData) {
  var bChecked;
  var elSelRows = this.getSelectedRows();
  var elId = oRecord._sId;
  if (array_search(elId,elSelRows)){
	  bChecked = 'checked'
  }
  else {
	  bChecked = '';
  }
  el.innerHTML = "<input type=\"checkbox\"" + bChecked +" class=\"" + YAHOO.widget.DataTable.CLASS_CHECKBOX + "\" id="+oData+">";
			
};

/**
 * Override event handler to manage selection according to desktop paradigm following checkboxes
 *
 * @method onEventSelectRow
 * @param oArgs.event {HTMLEvent} Event object.
 * @param oArgs.target {HTMLElement} Target element.
 */
YAHOO.widget.DataTable.prototype.onEventSelectRowCheck = function(oArgs) {
    var sMode = this.get("selectionMode");
    if ((sMode == "singlecell") || (sMode == "cellblock") || (sMode == "cellrange")) {
        return;
    }
    var evt = oArgs.event;
    var elTarget = oArgs.target;
	WBS.rec = oArgs;
    var bSHIFT = evt.shiftKey;
    var bCTRL = true; //evt.ctrlKey || ((nheavigator.userAgent.toLowerCase().indexOf("mac") != -1) && evt.metaKey);
	//bCTRL = (oArgs.ind)?true:bCTRL;
    var i;
    //var nAnchorPos;

    // Validate target row
    var elTargetRow = this.getTrEl(elTarget);
    if(elTargetRow) {
        var nAnchorRecordIndex, nAnchorTrIndex;
        var allRows = this._elTbody.rows;
        var oTargetRecord = this.getRecord(elTargetRow);
		
        var nTargetRecordIndex = this._oRecordSet.getRecordIndex(oTargetRecord);
        var nTargetTrIndex = this.getTrIndex(elTargetRow);

        var oAnchorRecord = this._oAnchorRecord;
	
        if(oAnchorRecord) {
            nAnchorRecordIndex = this._oRecordSet.getRecordIndex(oAnchorRecord);
            nAnchorTrIndex = this.getTrIndex(oAnchorRecord);
            if(nAnchorTrIndex === null) {
                if(nAnchorRecordIndex < this.getRecordIndex(this.getFirstTrEl())) {
                    nAnchorTrIndex = 0;
                }
                else {
                    nAnchorTrIndex = this.getRecordIndex(this.getLastTrEl());
                }
            }
        }

        // Both SHIFT and CTRL
        if((sMode != "single") && bSHIFT && bCTRL) {
            // Validate anchor
            if(oAnchorRecord) {
                if(this.isSelected(oAnchorRecord)) {
                    // Select all rows between anchor row and target row, including target row
                    if(nAnchorRecordIndex < nTargetRecordIndex) {
                        for(i=nAnchorRecordIndex+1; i<=nTargetRecordIndex; i++) {
                            if(!this.isSelected(i)) {
                                this.selectRow(i);
								//WBS.selectedIds.push(oTargetRecord);
                            }
                        }
                    }
                    // Select all rows between target row and anchor row, including target row
                    else {
                        for(i=nAnchorRecordIndex-1; i>=nTargetRecordIndex; i--) {
                            if(!this.isSelected(i)) {
                                this.selectRow(i);
								//WBS.selectedIds.push(oTargetRecord);
                            }
                        }
                    }
                }
                else {
                    // Unselect all rows between anchor row and target row
                    if(nAnchorRecordIndex < nTargetRecordIndex) {
                        for(i=nAnchorRecordIndex+1; i<=nTargetRecordIndex-1; i++) {
                            if(this.isSelected(i)) {
                                this.unselectRow(i);
								//WBS.selectedIds.
                            }
                        }
                    }
                    // Unselect all rows between target row and anchor row
                    else {
                        for(i=nTargetRecordIndex+1; i<=nAnchorRecordIndex-1; i++) {
                            if(this.isSelected(i)) {
                                this.unselectRow(i);
                            }
                        }
                    }
                    // Select the target row
                    this.selectRow(oTargetRecord);
                }
            }
            // Invalid anchor
            else {
                // Set anchor
                this._oAnchorRecord = oTargetRecord;

                // Toggle selection of target
                if(this.isSelected(oTargetRecord)) {
                    this.unselectRow(oTargetRecord);
                }
                else {
                    this.selectRow(oTargetRecord);
                }
            }
        }
        // Only SHIFT
        else if((sMode != "single") && bSHIFT) {
            this.unselectAllRows();

            // Validate anchor
            if(oAnchorRecord) {
                // Select all rows between anchor row and target row,
                // including the anchor row and target row
                if(nAnchorRecordIndex < nTargetRecordIndex) {
                    for(i=nAnchorRecordIndex; i<=nTargetRecordIndex; i++) {
                        this.selectRow(i);
                    }
                }
                // Select all rows between target row and anchor row,
                // including the target row and anchor row
                else {
                    for(i=nAnchorRecordIndex; i>=nTargetRecordIndex; i--) {
                        this.selectRow(i);
                    }
                }
            }
            // Invalid anchor
            else {
                // Set anchor
                this._oAnchorRecord = oTargetRecord;

                // Select target row only
                this.selectRow(oTargetRecord);
            }
        }
        // Only CTRL
        else if((sMode != "single") && bCTRL) {
            // Set anchor
            this._oAnchorRecord = oTargetRecord;

            // Toggle selection of target
            if(this.isSelected(oTargetRecord)) {
                this.unselectRow(oTargetRecord);
            }
            else {
                this.selectRow(oTargetRecord);
            }
        }
        // Neither SHIFT nor CTRL and "single" mode
        else if(sMode == "single") {
            this.unselectAllRows();
            this.selectRow(oTargetRecord);
        }
        // Neither SHIFT nor CTRL
        else {
            // Set anchor
            this._oAnchorRecord = oTargetRecord;

            // Select only target
            this.unselectAllRows();
            this.selectRow(oTargetRecord);
        }

        // Clear any selections that are a byproduct of the click or dblclick
        var sel;
        if(window.getSelection) {
        	sel = window.getSelection();
        }
        else if(document.getSelection) {
        	sel = document.getSelection();
        }
        else if(document.selection) {
        	sel = document.selection;
        }
        if(sel) {
            if(sel.empty) {
                sel.empty();
            }
            else if (sel.removeAllRanges) {
                sel.removeAllRanges();
            }
            else if(sel.collapse) {
                sel.collapse();
            }
        }
    }
    else {
    }
};

/**
 * Formats cells in Columns of type "choose".
 *
 * @method formatDelete
 * @param elCell {HTMLElement} Table cell element.
 * @param oRecord {YAHOO.widget.Record} Record instance.
 * @param oColumn {YAHOO.widget.Column} Column instance.
 * @param oData {Object} Data value for the cell, or null
 * @static
 */
YAHOO.widget.DataTable.formatChoose = function(elCell, oRecord, oColumn, oData) {
    var markup = "<img src='images/edit_add.gif' alt='Incluir este' title='Incluir Dados' width='17px' />";
	var tablename = this._tablename;
	var oTable = this._masterTable;
	WBS.upTable[0] = this._masterTable;
	elCell.innerHTML = markup;
	var campochave = this._campochave;
	var id = parseInt(oData);
	var id2 = WBS.MasterId;
    YAHOO.util.Event.addListener(elCell.firstChild, "click", function(e, oSelf) { 
		var request;
		if (confirm("Deseja realmente incluir este registro?")) {
			var url1 = "geraconteudo.php?f=WWpJMWFHSklVbXhqYlVWMVkwZG9kdz09&tabela="+tablename+"&id="+id+"&field="+campochave+'&id2='+id2;
			YAHOO.util.Connect.asyncRequest('GET',url1,  {
				 success: function (o) {
						oTable.reloadTable();																 
				 },
				 failure: function (o) {
					 alert('FAIO');
				 }
			 }, null);
		}
	}, elCell);
};
