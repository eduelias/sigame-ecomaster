showForm = {
	_arquivoAcesso:null,
	_caption:null,

	init:function(arquivoAcesso, caption) {
		this._arquivoAcesso = arquivoAcesso;
		this._caption = caption;
		var transaction = YAHOO.util.Connect.asyncRequest('GET', arquivoAcesso, resultShowForm, null); 
	},
	sucesso:function(o) {

		var captionContainer = YAHOO.util.Dom.getElementsByClassName("CollapsiblePanelTab", "div", "cPanel1");
		var contentContainer = YAHOO.util.Dom.getElementsByClassName("CollapsiblePanelContent", "div", "cPanel1");

		captionContainer[0].innerHTML = this._caption;
		contentContainer[0].innerHTML = o.responseText;
		YAHOO.util.Dom.setStyle("cPanel1", "display" , "block");

	},
	falha:function(o) {
		alert('ERRO');
	}
};

resultShowForm = {
	success: showForm.sucesso,
	failure: showForm.falha,
	scope: showForm
};