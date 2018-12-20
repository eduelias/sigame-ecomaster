<?php session_start(); header("Content-Type: text/html;charset=iso-8859-1");  ?>
<HTML>
<head>

<?php include('includes/class.php'); ?>
<?php
		$debug = false;
		$ebug = '';
?>
	<title> SIGAME - InfoHelp! </title>    
    <link href="templates/css/overlap.css" rel="stylesheet" type="text/css">
<!-- YUI -->   
    <!-- Core + Skin CSS -->
    <link rel="stylesheet" type="text/css" href="includes/yui/<?=YUI_VER?>/assets/yui.css">
    <link rel="stylesheet" type="text/css" href="includes/yui/<?=YUI_VER?>/build/menu/assets/skins/sam/menu.css">
	<link rel="stylesheet" type="text/css" href="includes/yui/<?=YUI_VER?>/build/datatable/assets/skins/sam/datatable.css">
    <link rel="stylesheet" type="text/css" href="includes/yui/<?=YUI_VER?>/build/container/assets/skins/sam/container.css">
    <link rel="stylesheet" type="text/css" href="includes/yui/<?=YUI_VER?>/build/treeview/assets/skins/sam/treeview.css">
    
    <!-- Dependencies --> 
    <script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/yahoo/yahoo<?=(JSMIN)?'-min':''?>.js"></script>	
	<script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/dom/dom<?=(JSMIN)?'-min':''?>.js"></script>
   
   	<script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/yahoo-dom-event/yahoo-dom-event.js"></script> 
  	<script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/event/event<?=(JSMIN)?'-min':''?>.js"></script>
    <script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/element/element-beta<?=(JSMIN)?'-min':''?>.js"></script>
    <script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/json/json<?=(JSMIN)?'-min':''?>.js"></script>
    <script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/connection/connection<?=(JSMIN)?'-min':''?>.js"></script>

 
    
    <!-- Source File -->   
	<script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/autocomplete/autocomplete<?=(JSMIN)?'-min':''?>.js"></script>   
	<script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/dragdrop/dragdrop<?=(JSMIN)?'-min':''?>.js"></script>
    <script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/treeview/treeview<?=((JSMIN)?'-min':'')?>.js" ></script>
	<script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/animation/animation<?=(JSMIN)?'-min':''?>.js"></script> 
   	<script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/container/container<?=(JSMIN)?'-min':''?>.js"></script>
	<script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/datasource/datasource-beta<?=(JSMIN)?'-min':''?>.js"></script>
    <script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/yuiloader/yuiloader-beta<?=(JSMIN)?'-min':''?>.js"></script>
    <script type="text/javascript" src="includes/yui/<?=YUI_VER?>/build/menu/menu<?=(JSMIN)?'-min':''?>.js"></script>
 
    
    
<!-- SPRY -->
<script src="includes/SpryAssets/textfieldvalidation/SpryValidationTextField.js" type="text/javascript"></script>
<link href="includes/SpryAssets/textfieldvalidation/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="includes/SpryAssets/radiovalidation/SpryValidationRadio.js" type="text/javascript"></script>
<link href="includes/SpryAssets/radiovalidation/SpryValidationRadio.css" rel="stylesheet" type="text/css">
<script src="includes/SpryAssets/selectvalidation/SpryValidationSelect.js" type="text/javascript"></script>
<link href="includes/SpryAssets/selectvalidation/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="includes/SpryAssets/passwordvalidation/SpryValidationPassword.js" type="text/javascript"></script>
<link href="includes/SpryAssets/passwordvalidation/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<script src="includes/SpryAssets/collapsiblepanel/SpryCollapsiblePanel.js" type="text/javascript"></script> 
<link href="includes/SpryAssets/collapsiblepanel/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css"

<!-- JAVASCRIPTS WBS -->  
	<script type="text/javascript" src="includes/js/pagina-min.js"></script>
    
    <script type="text/javascript" src="includes/js/iebug.js"></script>
    <script type="text/javascript" src="includes/js/javascript.js"></script>
    <script type="text/javascript" src="includes/js/json.js"></script>
    <script type="text/javascript" src="includes/js/x_core.js">

    </script>
   

<!-- PROPRIAS SIGAME -->
<link href="templates/css/forms.css" rel="stylesheet" type="text/css">
<link href="templates/css/tables.css" rel="stylesheet" type="text/css">
<link href="templates/css/main.css" rel="stylesheet" type="text/css">
<link href="templates/css/msgs.css" rel="stylesheet" type="text/css">
<link href="templates/css/overlap.css" rel="stylesheet" type="text/css">
<link href="templates/css/Spry_custom.css" rel="stylesheet" type="text/css">
<link href="templates/css/dragdrop.css" rel="stylesheet" type="text/css">

<style>
	body { margin:0; padding:0; font-size:12px; }
	#panel1 .bd {

    height: 300px;

}


/* Resize Panel CSS */

.yui-panel-container .yui-resizepanel .bd {

    overflow: auto;
    background-color: #fff;
}


/*
    PLEASE NOTE: It is necessary to toggle the "overflow" property 
    of the body element between "hidden" and "auto" in order to 
    prevent the scrollbars from remaining visible after the the 
    ResizePanel is hidden.  For more information on this issue, 
    read the comments in the "container-core.css" file.
*/

.yui-panel-container.hide-scrollbars .yui-resizepanel .bd {

    overflow: hidden;

}
.yui-skin-sam .yui-panel .bd {
	padding:0px;
	background-color:#FFFFFF;
}

.yui-skin-sam .yui-layout .yui-layout-unit div.yui-layout-bd {
	background-color:#FFFFFF;
}

.yui-skin-sam .yui-panel {
	background-color:#FFFFFF;
}

.yui-skin-sam .yui-layout .yui-layout-unit div.yui-layout-bd-nohd {
	background:#FFFFFF;
}

.yui-panel-container.show-scrollbars .yui-resizepanel .bd {

    overflow: auto;

}		


/*
    PLEASE NOTE: It is necessary to set the "overflow" property of
    the underlay element to "visible" in order for the 
    scrollbars on the body of a ResizePanel instance to be 
    visible.  By default the "overflow" property of the underlay 
    element is set to "auto" when a Panel is made visible on
    Gecko for Mac OS X to prevent scrollbars from poking through
    it on that browser + platform combintation.  For more 
    information on this issue, read the comments in the 
    "container-core.css" file.
*/

.yui-panel-container.show-scrollbars .underlay {

    overflow: visible;

}

.yui-resizepanel .resizehandle { 

     position: absolute; 
     width: 10px; 
     height: 10px; 
     right: 0;
     bottom: 0; 
     margin: 0; 
     padding: 0; 
     z-index: 1; 
     background: url(assets/img/corner_resize.gif) left bottom no-repeat;
     cursor: se-resize;

 }

</style>
<script>
		//var editor = new wsCTextEditor('textEditor', '', "100%", 30, true, false);
    	//WBS.wait.show();
//(function(){var B=YAHOO.widget.DataTable,A=YAHOO.util.Dom;B.prototype._setColumnWidth=function(I,D,J){I=this.getColumn(I);if(I){J=J||"hidden";if(!B._bStylesheetFallback){var N;if(!B._elStylesheet){N=document.createElement("style");N.type="text/css";B._elStylesheet=document.getElementsByTagName("head").item(0).appendChild(N)}if(B._elStylesheet){N=B._elStylesheet;var M=".yui-dt-col-"+I.getId();var K=B._oStylesheetRules[M];if(!K){if(N.styleSheet&&N.styleSheet.addRule){N.styleSheet.addRule(M,"overflow:"+J);N.styleSheet.addRule(M,"width:"+D);K=N.styleSheet.rules[N.styleSheet.rules.length-1]}else{if(N.sheet&&N.sheet.insertRule){N.sheet.insertRule(M+" {overflow:"+J+";width:"+D+";}",N.sheet.cssRules.length);K=N.sheet.cssRules[N.sheet.cssRules.length-1]}else{B._bStylesheetFallback=true}}B._oStylesheetRules[M]=K}else{K.style.overflow=J;K.style.width=D}return }B._bStylesheetFallback=true}if(B._bStylesheetFallback){if(D=="auto"){D=""}var C=this._elTbody?this._elTbody.rows.length:0;if(!this._aFallbackColResizer[C]){var H,G,F;var L=["var colIdx=oColumn.getKeyIndex();","oColumn.getThEl().firstChild.style.width="];for(H=C-1,G=2;H>=0;--H){L[G++]="this._elTbody.rows[";L[G++]=H;L[G++]="].cells[colIdx].firstChild.style.width=";L[G++]="this._elTbody.rows[";L[G++]=H;L[G++]="].cells[colIdx].style.width="}L[G]="sWidth;";L[G+1]="oColumn.getThEl().firstChild.style.overflow=";for(H=C-1,F=G+2;H>=0;--H){L[F++]="this._elTbody.rows[";L[F++]=H;L[F++]="].cells[colIdx].firstChild.style.overflow=";L[F++]="this._elTbody.rows[";L[F++]=H;L[F++]="].cells[colIdx].style.overflow="}L[F]="sOverflow;";this._aFallbackColResizer[C]=new Function("oColumn","sWidth","sOverflow",L.join(""))}var E=this._aFallbackColResizer[C];if(E){E.call(this,I,D,J);return }}}else{}};B.prototype._syncColWidths=function(){var J=this.get("scrollable");if(this._elTbody.rows.length>0){var M=this._oColumnSet.keys,C=this.getFirstTrEl();if(M&&C&&(C.cells.length===M.length)){var O=false;if(J&&(YAHOO.env.ua.gecko||YAHOO.env.ua.opera)){O=true;if(this.get("width")){this._elTheadContainer.style.width="";this._elTbodyContainer.style.width=""}else{this._elContainer.style.width=""}}var I,L,F=C.cells.length;for(I=0;I<F;I++){L=M[I];if(!L.width){this._setColumnWidth(L,"auto","visible")}}for(I=0;I<F;I++){L=M[I];var H=0;var E="hidden";if(!L.width){var G=L.getThEl();var K=C.cells[I];if(J){var N=(G.offsetWidth>K.offsetWidth)?G.firstChild:K.firstChild;if(G.offsetWidth!==K.offsetWidth||N.offsetWidth<L.minWidth){H=Math.max(0,L.minWidth,N.offsetWidth-(parseInt(A.getStyle(N,"paddingLeft"),10)|0)-(parseInt(A.getStyle(N,"paddingRight"),10)|0))}}else{if(K.offsetWidth<L.minWidth){E=K.offsetWidth?"visible":"hidden";H=Math.max(0,L.minWidth,K.offsetWidth-(parseInt(A.getStyle(K,"paddingLeft"),10)|0)-(parseInt(A.getStyle(K,"paddingRight"),10)|0))}}}else{H=L.width}if(L.hidden){L._nLastWidth=H;this._setColumnWidth(L,"1px","hidden")}else{if(H){this._setColumnWidth(L,H+"px",E)}}}if(O){var D=this.get("width");this._elTheadContainer.style.width=D;this._elTbodyContainer.style.width=D}}}this._syncScrollPadding()}})(); 
//(function(){var A=YAHOO.util,B=YAHOO.env.ua,E=A.Event,C=A.Dom,D=YAHOO.widget.DataTable;D.prototype._initTheadEls=function(){var X,V,T,Z,I,M;if(!this._elThead){Z=this._elThead=document.createElement("thead");I=this._elA11yThead=document.createElement("thead");M=[Z,I];E.addListener(Z,"focus",this._onTheadFocus,this);E.addListener(Z,"keydown",this._onTheadKeydown,this);E.addListener(Z,"mouseover",this._onTableMouseover,this);E.addListener(Z,"mouseout",this._onTableMouseout,this);E.addListener(Z,"mousedown",this._onTableMousedown,this);E.addListener(Z,"mouseup",this._onTableMouseup,this);E.addListener(Z,"click",this._onTheadClick,this);E.addListener(Z.parentNode,"dblclick",this._onTableDblclick,this);this._elTheadContainer.firstChild.appendChild(I);this._elTbodyContainer.firstChild.appendChild(Z)}else{Z=this._elThead;I=this._elA11yThead;M=[Z,I];for(X=0;X<M.length;X++){for(V=M[X].rows.length-1;V>-1;V--){E.purgeElement(M[X].rows[V],true);M[X].removeChild(M[X].rows[V])}}}var N,d=this._oColumnSet;var H=d.tree;var L,P;for(T=0;T<M.length;T++){for(X=0;X<H.length;X++){var U=M[T].appendChild(document.createElement("tr"));P=(T===1)?this._sId+"-hdrow"+X+"-a11y":this._sId+"-hdrow"+X;U.id=P;for(V=0;V<H[X].length;V++){N=H[X][V];L=U.appendChild(document.createElement("th"));if(T===0){N._elTh=L}P=(T===1)?this._sId+"-th"+N.getId()+"-a11y":this._sId+"-th"+N.getId();L.id=P;L.yuiCellIndex=V;this._initThEl(L,N,X,V,(T===1))}if(T===0){if(X===0){C.addClass(U,D.CLASS_FIRST)}if(X===(H.length-1)){C.addClass(U,D.CLASS_LAST)}}}if(T===0){var R=d.headers[0];var J=d.headers[d.headers.length-1];for(X=0;X<R.length;X++){C.addClass(C.get(this._sId+"-th"+R[X]),D.CLASS_FIRST)}for(X=0;X<J.length;X++){C.addClass(C.get(this._sId+"-th"+J[X]),D.CLASS_LAST)}var Q=(A.DD)?true:false;var c=false;if(this._oConfigs.draggableColumns){for(X=0;X<this._oColumnSet.tree[0].length;X++){N=this._oColumnSet.tree[0][X];if(Q){L=N.getThEl();C.addClass(L,D.CLASS_DRAGGABLE);var O=D._initColumnDragTargetEl();N._dd=new YAHOO.widget.ColumnDD(this,N,L,O)}else{c=true}}}for(X=0;X<this._oColumnSet.keys.length;X++){N=this._oColumnSet.keys[X];if(N.resizeable){if(Q){L=N.getThEl();C.addClass(L,D.CLASS_RESIZEABLE);var G=L.firstChild;var F=G.appendChild(document.createElement("div"));F.id=this._sId+"-colresizer"+N.getId();N._elResizer=F;C.addClass(F,D.CLASS_RESIZER);var e=D._initColumnResizerProxyEl();N._ddResizer=new YAHOO.util.ColumnResizer(this,N,L,F.id,e);var W=function(f){E.stopPropagation(f)};E.addListener(F,"click",W)}else{c=true}}}if(c){}}else{}}for(var a=0,Y=this._oColumnSet.keys.length;a<Y;a++){if(this._oColumnSet.keys[a].hidden){var b=this._oColumnSet.keys[a];var S=b.getThEl();b._nLastWidth=S.offsetWidth-(parseInt(C.getStyle(S,"paddingLeft"),10)|0)-(parseInt(C.getStyle(S,"paddingRight"),10)|0);this._setColumnWidth(b.getKeyIndex(),"1px")}}if(B.webkit&&B.webkit<420){var K=this;setTimeout(function(){K._elThead.style.display=""},0);this._elThead.style.display="none"}}})(); 

</script>
<script>
	var senha;
	var usuario;
	function seta_pass(alfafa){
		WBS.login = alfafa;
		senha = alfafa.value;
	}
	
	function checa_pass(alfa2){
		WBS.login.value = (senha == alfa2.value)?alfa2.value:'';
		alfa2.value = (senha == alfa2.value)?alfa2.value:'';
	}
</script>
<script type="text/javascript">
var loading = false;
//var tabView = new YAHOO.widget.TabView({id: 'demo'});
var table_aux;
var ida;

//############################################################ ONLOAD DA PAGINA
YAHOO.util.Event.addListener(window, "load", function() {
	setTimeout('WBS.wait.hide()',1000);
}, null);

function off(param){
	tabView.removeTab(tabView.getTab(param));
}

WBS.panel2 = new YAHOO.widget.ResizePanel("panel2", {effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.4}, constraintoviewport:true, fixedcenter:false, visible:false, draggable:true, close:true, modal:false, zindex:30, width:'550px'} );
WBS.panel2.setHeader("Conteúdo");
WBS.panel2.setBody('Erro no carregamento.');
WBS.panel2.setFooter('Editando dados.');

WBS.wait =  new YAHOO.widget.Panel("wait",{width:"230px", fixedcenter:true, close:false, draggable:false, zindex:90, modal:true, visible:true});
WBS.wait.setHeader("Carregando ...");   
WBS.wait.setBody('<img src="images/<?=$pgo[0]['cor']?>_load.gif" />');  

</script>

</head>
<body id="yahoo-com" class="yui-skin-sam">
<div id="central"></div>
<?php if (isset($_SESSION['grupo'])){ ?>
	<?php
		$login = new login();
		$login->session($_SESSION);
		$login->checklogin();
    ?>
	<div id="topo" class="topo">

        <a href="logout.php"><img src="images/sair.gif" border="0" class="close"/></a>
    </div>
      
<div id="container" style="display:none"></div>
	<div style="z-index:100"> <?php  include('menu.php'); ?> </div>
<div id="msg" style=""></div>
	<?php

		$load = decode($_GET['f']);
		$f = (isset($_GET['f'])?$load:'modules/form_editing/list_form.php');
		include($f); 
		$ebug['file'] = $f;
		$ebug['sessão'] =  $_SESSION;
    ?>
    <?php } else { // se não está logado, mostra o formulario '6' -> login ?>
		<?php $_GET['formid'] = 6; ?>
        <div align="center" style="width: 500px; height: 300px;top: 50%;left: 50%;margin-top: -150px;margin-left: -250px;position: absolute;border: 0px solid black;">
		<fieldset><img src='images/siglogo.png' border="no" alt="Digite seu nome de usuário e senha abaixo">
		<?php include('gera.php'); ?><br>&nbsp;</fieldset></div>
    <?php }; ?>
<script>
WBS.wait.render(document.body);
WBS.panel2.render(document.body); 
WBS.panel2.hideEvent.subscribe(function () { //compatibilidade com FF2 -> retira BUG visual
	document.getElementById('container').style.display = 'none'														  
});
WBS.panel2.changeBodyEvent.subscribe( function (bodyContent) { WBS.ExtraiScript(bodyContent);} );
//var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
</script>
<?=($debug)?'DEBUG<hr>':''?>
<?=($debug)?pre($ebug):''?>
</body>
<script>
	/*if (document.getElementById('id_width')){
		var fdw = document.getElementById('id_width');
		fdw.innerHTML = '<input type="hidden" name="cfg_usuario@swidth" value="" id="wid">';
		fw = document.getElementById('wid');
		fw.value = document.body.clientWidth;
	}*/
</script>
</HTML>