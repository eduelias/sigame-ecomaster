/*========================================================================
	Objetivo		: Simula um teclado virtual
	Premissas		: Existir as imagens que representam o teclado
	Efeitos			: Incluir caracters nos textboxs ou mudar o status do
								teclado(CAPSLOCK,SHIFT)
	Entradas		: 
	Retorno			:
	Data - Autor	: 14/10/2002 - Vital - DRM
========================================================================*/


//Variavel para o teclado
var blnErro = false

function BrowserCheck() {
	var b = navigator.appName
	if (b=='Netscape') this.b = 'ns'
	else if (b=='Microsoft Internet Explorer') this.b = 'ie'
	else this.b = b
	this.version = navigator.appVersion
	this.v = parseInt(this.version)
	this.ns = (this.b=='ns' && this.v>=4)
	this.ns4 = (this.b=='ns' && this.v==4)
	this.ns5 = (this.b=='ns' && this.v==5)
	this.ie = (this.b=='ie' && this.v>=4)
	this.ie4 = (this.version.indexOf('MSIE 4')>0)
	this.ie5 = (this.version.indexOf('MSIE 5')>0)
	this.min = (this.ns||this.ie)
}

var is = new BrowserCheck()

function MostrarTeclado(intResize,blnOffLine)
{
	if (blnErro) TecladoVirtual(intResize,157,75,0,blnOffLine)
	else TecladoVirtual(intResize,157,75,0,blnOffLine)
}
function positionLayer(tabela)
{
	var areaWidth = (is.ns4 || is.ns5) ? window.innerWidth : document.body.scrollWidth;
	areaWidth = (areaWidth - tabela) / 2;
	if (areaWidth <  0 )areaWidth = 0;
	return areaWidth;
}



var objAryTeclado = new Array() //Representa o teclado
var objAryFont = new Array()		//Caractes possíveis para o teclado
var objAryCoord	= new Array()		//Coordenadas(x,y) dos caracters
var objAryStatus = new Array()	//Imagens das formas que o teclado pode assumir
var objAryCampos = new Array()	//Os campos que o teclado vai ser utilizado
var intCampoAtual = 0						//Indice do objeto(textbox) que estamos atualmente 


function CarregarCaractersTeclado()
{
	//Caracteres do teclado
	objAryFont[0] = new Array("'", unescape("%22"))
	objAryFont[1] = new Array(1,"!")
	objAryFont[2] = new Array(2,"@")
	objAryFont[3] = new Array(3,"#")
	objAryFont[4] = new Array(4,"$")
	objAryFont[5] = new Array(5,"%")
	objAryFont[6] = new Array(6,"¨")
	objAryFont[7] = new Array(7,"&")
	objAryFont[8] = new Array(8,"*")
	objAryFont[9] = new Array(9,"(")
	objAryFont[10] = new Array(0,")")
	objAryFont[11] = new Array("-","_")
	objAryFont[12] = new Array("=","+")
	objAryFont[13] = new Array("q","")
	objAryFont[14] = new Array("w","")
	objAryFont[15] = new Array("e","")
	objAryFont[16] = new Array("r","")
	objAryFont[17] = new Array("t","")
	objAryFont[18] = new Array("y","")
	objAryFont[19] = new Array("u","")
	objAryFont[20] = new Array("i","")
	objAryFont[21] = new Array("o","")
	objAryFont[22] = new Array("p","")
	objAryFont[23] = new Array("´","`")
	objAryFont[24] = new Array("[","{")
	objAryFont[25] = new Array("<-","")
	objAryFont[26] = new Array("a","")
	objAryFont[27] = new Array("s","")
	objAryFont[28] = new Array("d","")
	objAryFont[29] = new Array("f","")
	objAryFont[30] = new Array("g","")
	objAryFont[31] = new Array("h","")
	objAryFont[32] = new Array("j","")
	objAryFont[33] = new Array("k","")
	objAryFont[34] = new Array("l","")
	objAryFont[35] = new Array("ç","")
	objAryFont[36] = new Array("~","^")
	objAryFont[37] = new Array("]","}")
	objAryFont[38] = new Array("RET","")
	objAryFont[39] = new Array("\\","|")
	objAryFont[40] = new Array("z","")
	objAryFont[41] = new Array("x","")
	objAryFont[42] = new Array("c","")
	objAryFont[43] = new Array("v","")
	objAryFont[44] = new Array("b","")
	objAryFont[45] = new Array("n","")
	objAryFont[46] = new Array("m","")
	objAryFont[47] = new Array(",","<")
	objAryFont[48] = new Array(".",">")
	objAryFont[49] = new Array(";",":")
	objAryFont[50] = new Array("/","?")
	objAryFont[51] = new Array("RET","")
	objAryFont[52] = new Array("CAPS","")
	objAryFont[53] = new Array("CAPS","")
	objAryFont[54] = new Array("CAPS","")
	objAryFont[55] = new Array("SHIFT","")
	objAryFont[56] = new Array("SHIFT","")
	objAryFont[57] = new Array("SHIFT","")
	objAryFont[58] = new Array(" ","")
	objAryFont[59] = new Array(" ","")
	objAryFont[60] = new Array(" ","")
	objAryFont[61] = new Array(" ","")
	objAryFont[62] = new Array(" ","")
	objAryFont[63] = new Array(" ","")
	objAryFont[64] = new Array(" ","")
	
}

function MapearTeclado(intPosVertInicialOrig,intPosHozInicialOrig,intDesloca,intFator,blnOffLine)
{

	intPosVertInicialOrig = parseInt(intPosVertInicialOrig+Math.round(Math.random()*intFator))				//Posição vertical do teclado(inicial+aleatorio)
	intPosHozInicialOrig  = parseInt(intPosHozInicialOrig+intDesloca+Math.round(Math.random()*intFator))//Posição horizontal do teclado(inicial+aleatorio)


	//Mapea o Teclado conforme a posição atual calculada
	var	intLarguraHozTcl = 19
	var	intLarguraVerTcl = 22

	var intPosVertInicial = intPosVertInicialOrig
	var intPosHozInicial = intPosHozInicialOrig
	var intPosVertInicialOld = intPosVertInicialOrig
	var intX1,intY1,intX2,intY2

	for (var intIndex=0;intIndex<65;intIndex++)
	{
		intX1 = intPosVertInicial
		intY1 = intPosHozInicial
		intX2 = parseInt(intPosVertInicial+parseInt(intLarguraVerTcl-2))
		intY2 = parseInt(intPosHozInicial+parseInt(intLarguraHozTcl-2))

		objAryCoord[intIndex] = new Array(intX1,intY1,intX2,intY2,objAryFont[intIndex][0],objAryFont[intIndex][1])

		intPosVertInicial+=22

		if ((parseInt(intIndex+1)%13)==0 && intIndex != 0) 
		{
			intPosHozInicial+=19
			intPosVertInicial = intPosVertInicialOld
		}	
	}
	//Mostra o teclado na página
	EscreverTeclado(intPosVertInicialOrig,intPosHozInicialOrig,blnOffLine)
}

//Altera o status do teclado NORMAL,SHIFT,CAPSLOCK,SHIT-CAPSLOCK
function AlterarStatus(strTecla)
{
	
	switch(strTecla)
	{
		case "CAPS":
			if (objAryStatus[0][0]) //NORMAL
			{
				TrocarTeclado(1)
				objAryStatus[0][0] = false
				objAryStatus[1][0] = true
				return true			
			}
			if (objAryStatus[2][0]) //SHIFT
			{
				if (document.imgTeclado.complete)
				{
					TrocarTeclado(3)
					objAryStatus[3][0] = true
					objAryStatus[2][0] = false
					return true
				}
				else
				{
					alert("Imagem carregando.Um momento")
					return false
				}	
			}
			if (objAryStatus[3][0]) //CAPS - SHIFT
			{
				if (document.imgTeclado.complete)
				{
					TrocarTeclado(2)
					objAryStatus[2][0] = true
					objAryStatus[3][0] = false
					return true
				}
				else
				{
					alert("Imagem carregando.Um momento")
					return false
				}	
					
			}
			else
			{
				TrocarTeclado(0)
				objAryStatus[0][0] = true
				objAryStatus[1][0] = false
				return true
			}	
			break
		case "SHIFT":
			if (objAryStatus[0][0]) //Normal
			{
				TrocarTeclado(2)
				objAryStatus[0][0] = false
				objAryStatus[2][0] = true
				return true
			}
			if (objAryStatus[1][0]) //CAPS
			{
				TrocarTeclado(3)
				objAryStatus[3][0] = true
				objAryStatus[1][0] = false
				return true
			}
			if (objAryStatus[3][0]) //CAPS - SHIFT
			{
				TrocarTeclado(1)
				objAryStatus[1][0] = true
				objAryStatus[3][0] = false
				return true
			}
			else
			{
				TrocarTeclado(0) //NORMAL
				objAryStatus[0][0] = true
				objAryStatus[2][0] = false
				return true
			}	
			break
	}
	return true
}

//Troca a imagem
function TrocarTeclado(intIndex)
{
	document.imgTeclado.src = objAryTeclado[intIndex].src
	return true
}

//Responde a interação do usuário com o teclado virtual 
function ManipularTeclado(evnt)
{
	var blnImg = false
	var blnRet = false
	
	if(navigator.appName == 'Netscape')
	{
		if (evnt.target.name == "imgTeclado" || evnt.target == "javascript:void(13)")
		{
			blnImg = true
		}
		else
		{
			return true
		}
	}
	else
	{
		if(window.event.srcElement.tagName == "IMG")
		{
			blnImg = true
		}
	}
	
	if(blnImg)
	{
		
		if(navigator.appName == 'Netscape')
		{
			var x  = parseFloat(parseInt(evnt.pageX)) 
			var y  = parseFloat(parseInt(evnt.pageY)) 

		}
		else
		{
			var x  = parseFloat(parseInt(event.x) + parseFloat(document.body.scrollLeft))
			var y  = parseFloat(parseInt(event.y) + parseFloat(document.body.scrollTop))
		}	

		for (var intIndex=0;intIndex<objAryCoord.length;intIndex++)
		{
			if ((x >= objAryCoord[intIndex][0] && x <= objAryCoord[intIndex][2]) && (y >= objAryCoord[intIndex][1] && y <= objAryCoord[intIndex][3]))
			{
				switch (objAryCoord[intIndex][4])
				{
					case "<-":
						eval("document.forms[0]."+objAryCampos[intCampoAtual][0]+".value=document.forms[0]."+objAryCampos[intCampoAtual][0]+".value.substring(0,parseInt(document.forms[0]."+objAryCampos[intCampoAtual][0]+".value.length)-1)")
						break

					case "RET":
						AtualizaObj();
						setTimeout("eval('document.forms[0]."+objAryCampos[intCampoAtual][0]+".focus()');",10)
						blnRet = true;
						break

					case "CAPS":
						AlterarStatus("CAPS") 	
						break

					case "SHIFT":
						AlterarStatus("SHIFT")
						break
					
					default:	

							if (objAryStatus[0][0]) //Normal
							{	
								AtualizarValor(objAryCoord[intIndex][4])
							}
									
							if (objAryStatus[1][0] && isNaN(objAryCoord[intIndex][4]))
							{
								AtualizarValor(objAryCoord[intIndex][4].toUpperCase())
							}

							if (objAryStatus[1][0] && !isNaN(objAryCoord[intIndex][4]))
							{
								AtualizarValor(objAryCoord[intIndex][4])
							}

							if (objAryStatus[2][0])
							{
								if (objAryCoord[intIndex][5] != "")
								{
									AtualizarValor(objAryCoord[intIndex][5])
								}
								else
								{
									if (isNaN(objAryCoord[intIndex][4]))
									{
										AtualizarValor(objAryCoord[intIndex][4].toUpperCase())
									}
									else //Números
									{
										AtualizarValor(objAryCoord[intIndex][4])
									}
								}	
								AlterarStatus("SHIFT")
							}

							if (objAryStatus[3][0])
							{
								if (objAryCoord[intIndex][5] != "")
								{
									AtualizarValor(objAryCoord[intIndex][5])
								}
								else
								{
									if (isNaN(objAryCoord[intIndex][4]))
									{
										AtualizarValor(objAryCoord[intIndex][4].toUpperCase())
									}
									else //Números
									{
										AtualizarValor(objAryCoord[intIndex][4])
									}
								}	
								AlterarStatus("SHIFT")
							}

				}//switch
			}
		}	
	}
	
	if (!blnRet){
		setTimeout("eval('document.forms[0]." + objAryCampos[intCampoAtual][0] + ".focus()')",10);
	}
	return false
}

//Adiciona o valor para o campo atual muda o foco
function AtualizarValor(strValor)
{
	switch(objAryCampos[intCampoAtual][2])
	{
		case "A": //Alfanumérico
			if(eval("document.forms[0]."+objAryCampos[intCampoAtual][0]+".value.length") < parseInt(objAryCampos[intCampoAtual][1]))
			{
				if (escape(strValor)=="%27")
				{
					eval("document.forms[0]."+objAryCampos[intCampoAtual][0]+".value+=\""+strValor+"\"")
				}
				else
				{
				  var objTargetField = new Object(eval("document.forms[0]."+objAryCampos[intCampoAtual][0]));
				  objTargetField.value += strValor;
				}	
			}	
			if(eval("document.forms[0]."+objAryCampos[intCampoAtual][0]+".value.length") == parseInt(objAryCampos[intCampoAtual][1]))
			{
				AtualizaObj()
				setTimeout("eval('document.forms[0]."+objAryCampos[intCampoAtual][0]+".focus()');",10)
			}
			break
		
		case "N": //Numerico
				if (eval("parseInt(document.forms[0]."+objAryCampos[intCampoAtual][0]+".value.length)") < parseInt(objAryCampos[intCampoAtual][1]))
				{
					if (escape(strValor)=="%27")
					{
						eval("document.forms[0]."+objAryCampos[intCampoAtual][0]+".value+=ValidarNum(\"" + strValor + "\")")
					}
					else
					{
				    var objTargetField = new Object(eval("document.forms[0]."+objAryCampos[intCampoAtual][0]));
				    objTargetField.value += ValidarNum(eval("'" + strValor + "'"));
					}	
				}	
				
				if (eval("parseInt(document.forms[0]."+objAryCampos[intCampoAtual][0]+".value.length)") == parseInt(objAryCampos[intCampoAtual][1]))
				{
					AtualizaObj()
					setTimeout("eval('document.forms[0]."+objAryCampos[intCampoAtual][0]+".focus()');",10)
				}
				break
	}
	return true
}

//Atualiza o objeto que esta com o foco
function AtualizaObj()
{
	if (arguments.length > 0)
	{
		intCampoAtual = arguments[0]
	}
	else
	{
		if (parseInt(parseInt(objAryCampos.length)-1) == parseInt(intCampoAtual))
		{
			intCampoAtual	= 0
		}
		else
		{
			intCampoAtual = parseInt(intCampoAtual)+1
		}
	}	
}

function EscreverTeclado(intPosVertInicialOrig,intPosHozInicialOrig,blnOffLine)
{
	//Imprime o teclado na página conforme o navegador
	if(navigator.appName == 'Netscape')
	{
			window.captureEvents(Event.CLICK | Event.MOUSEDOWN | Event.MOUSEUP)
			
			if (parseFloat(navigator.appVersion.split(" ")[0]) < 5)
			{
				if (!blnOffLine)
				{
					//document.writeln('<STYLE type="text/css">#posicaotcl { position:absolute; left:'+intPosVertInicialOrig+'; top:'+intPosHozInicialOrig+';}</STYLE>')
					document.writeln('<layer id="posicaotcl" left="'+intPosVertInicialOrig+'" top="'+intPosHozInicialOrig+'" ><A HREF="javascript:void(13)"><img name="imgTeclado" border="0" src="'+objAryStatus[0][1]+'"></A></layer>')
				}
				else
				{
					var objLyr = document.posicaotcl
					objLyr.top = intPosHozInicialOrig
					objLyr.left = intPosVertInicialOrig
				}
			}		
			else //Netscape > 5.0
			{	
				if (!blnOffLine)
				{
					document.writeln('<layer id="posicaotcl" style="position:absolute; left:'+intPosVertInicialOrig+'; top:'+intPosHozInicialOrig+';" ><a href="javascript:void(13)"><img name="imgTeclado" border="0" src="'+objAryStatus[0][1]+'"></a></layer>')
				}	
				else
				{
					//document.posicaotcl.top = intPosHozInicialOrig
					//document.posicaotcl.left = intPosVertInicialOrig
				}	
			}	

			window.onmousedown = ManipularTeclado
	}
	else
	{
		//IE
		if (!blnOffLine)
		{
			document.writeln('<div id=divTeclado style="cursor:hand;width:284;height:93;position:absolute; left:'+intPosVertInicialOrig+'; top:'+intPosHozInicialOrig+'" ><img name="imgTeclado" border="0" src="'+objAryStatus[0][1]+'"></div>')
		}
		else
		{
			divTeclado.style.top = intPosHozInicialOrig
			divTeclado.style.left = intPosVertInicialOrig
		}	
		document.imgTeclado.onmousedown = ManipularTeclado
		document.imgTeclado.ondblclick = ManipularTeclado

	}
}	
//Adiciona os campos nos quais o teclado vai ser usuado
//Formato da entrada para um campo Nome%Tamanho%Tipo
function CarregarCampos()
{
	for(intIndex=0;intIndex<arguments.length;intIndex++)
	{
		objAryCampos[intIndex] = new Array(arguments[intIndex].split("%")[0],arguments[intIndex].split("%")[1],arguments[intIndex].split("%")[2])
	}	
}

//Carrega as imagens do teclado
function CarregarImagens()
{
	var blnSel 
	for(intIndex=0;intIndex<arguments.length;intIndex++)
	{
		//Imgens que representa os status do Teclado
		if (intIndex == 0) blnSel = true
		else blnSel = false
		objAryStatus[intIndex] = new Array(blnSel,arguments[intIndex])
	}	

	//Carrega as imagens do Teclado no cliente
	for (var intIndex=0;intIndex<objAryStatus.length;intIndex++)
	{
		objAryTeclado[intIndex] = new Image() 
		objAryTeclado[intIndex].src = objAryStatus[intIndex][1]
	}
}

//Validar Números
function ValidarNum(intVal)
{
	if(isNaN(intVal) || intVal == " ")
	  return "";
	else
	  return intVal;
}

function TecladoVirtual(intPosVertInicial,intPosHozInicial,intDeslocamento,intFatorCorrecao,blnOffLine)
{
	CarregarCaractersTeclado()
	MapearTeclado(intPosVertInicial,intPosHozInicial,intDeslocamento,intFatorCorrecao,blnOffLine)
}