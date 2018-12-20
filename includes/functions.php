<?

	function pre($array){
		echo "<pre>";
			print_r($array);
		echo "</pre>";
	}
	
	function fre($array){
		$str = "<pre>";
		$str .=	print_r($array);
		$str .= "</pre>";
		return $str;
	}
	
	function loga($str){
		$bd = new bd();
		$bd->loga($str);
		return $bd->get_sql();
	}
###################################################################
# Encripta uma variável
#
# @param $var (string) -> Texto de entrada
#
# @return (string) -> Texto encriptado
###################################################################
	function encode($var) {
		$var = base64_encode($var);
		$var = base64_encode($var);
		$var = base64_encode($var);
		return $var;
	}

###################################################################
# Desencripta uma variável encriptada com a função encode()
#
# @param $var (string) -> Texto de entrada
#
# @return (string) -> Texto desencriptado
###################################################################
	function decode($var) {
		$var = base64_decode($var);
		$var = base64_decode($var);
		$var = base64_decode($var);
		return $var;
	}

###################################################################
# Transforma o valor em real ou o real em valor
#
# @param $valor -> Valor de entrada
#
# @return (string) -> Valor convertido
###################################################################
function valor2real($valor) {
	return number_format($valor, 2, ",", "");
}

function real2valor($valor) {
	 return str_replace(",", ".", $valor);
}

#################################################################
## $tipo mtn
## transforma a data do formato YYYY-MM-DD hh:ii em DD/MM/YYYY hh:ii
##
## $tipo ntm
## transforma a data do formato DD/MM/YYYY hh:ii em YYYY-MM-DD hh:ii
#################################################################
	function convdatahora($dataentra,$tipo){
		$dataarray = explode(" ", $dataentra);
		$hora = substr($dataarray[1], 0, 5);
		$dataentra = $dataarray[0];
	  if ($tipo == "mtn") {
		$datasentra = explode("-",$dataentra);
		$indice=2;
		while($indice != -1){
		  $datass[$indice] = $datasentra[$indice];
		  $indice--;
		}
		$datasaida=implode("/",$datass);
	  } elseif ($tipo == "ntm") {
		$datasentra = explode("/",$dataentra);
		$indice=2;
		while($indice != -1){
		  $datass[$indice] = $datasentra[$indice];
		  $indice--;
		}
		$datasaida = implode("-",$datass);
	  } else {
		$datasaida = "erro";
	  }
	  return $datasaida." às ".$hora;
	}
###################################################################
# Pega o último ID inserido
# @param $result (resource) -> Resultado da query de inserção
# @param $table_name (string) -> Nome da tabela
# @param $colum_name (string) -> Nome da coluna de id da tabela
#
# @return (int) último id inserido
###################################################################
	function sql_last_inserted_id($result, $table_name, $column_name) {
		$oid = pg_last_oid($result);
		$query_for_id = "SELECT $column_name FROM $table_name WHERE oid=$oid";
		$result_for_id = pg_query($query_for_id);
		if (pg_num_rows($result_for_id))
			$id = pg_fetch_array($result_for_id, 0, PGSQL_ASSOC);

		return $id[$column_name];
	}
#################################################################
## $tipo mtn
## transforma a data do formato YYYY-MM-DD em DD/MM/YYYY
##
## $tipo ntm
## transforma a data do formato DD/MM/YYYY em YYYY-MM-DD
#################################################################
	function convdata($dataentra,$tipo){
	  if ($tipo == "mtn") {
		$datasentra = explode("-",$dataentra);
		$indice=2;
		while($indice != -1){
		  $datass[$indice] = $datasentra[$indice];
		  $indice--;
		}
		$datasaida=implode("/",$datass);
	  } elseif ($tipo == "ntm") {
		$datasentra = explode("/",$dataentra);
		$indice=2;
		while($indice != -1){
		  $datass[$indice] = $datasentra[$indice];
		  $indice--;
		}
		$datasaida = implode("-",$datass);
	  } else {
		$datasaida = "erro";
	  }
	  return $datasaida;
	} 

	###################################################################
# Converte valores de minúsculo para maiúsculo e vice-versa
# @param $text (string) -> Texto de entrada
# @param $return (string) -> tipo de conversão
#                            'upper' converte texto para maiúsculo
#                            'lower' converte texto para minúsculo
#                            'plain' converte o texto para especiais
# @param $acento (bool) -> Retorna texto acentuado ou não
#
# @return (string) convertida para o padrão desejado
###################################################################
	function stringUpDown($text, $return, $acento = TRUE){
		$arrayLower=array('ç','â','ã','á','à','ä','é','è','ê','ë','í','ì','î','ï','ó','ò','ô','õ','ö','ú','ù','û','ü','ñ');
		$arrayLowerSimples=array('c','a','a','a','a','a','e','e','e','e','i','i','i','i','o','o','o','o','o','u','u','u','u','n');
		$arrayLowerHTML=array('&ccedil;','&acirc;','&atilde;','$aacute;','&agrave;','&auml;','&eacute;','&egrave;','&ecirc;','&euml;','&iacute;','&igrave;','&icirc;','&iuml;','&oacute;','&ograve;','&ocirc;','&otilde;','&ouml;','&uacute;','&ugrave;','&ucirc;','&uuml;','&ntilde;');
		$arrayUpper=array('Ç','Â','Ã','Á','À','Ä','É','È','Ê','Ë','Í','Ì','Î','Ï','Ó','Ò','Ô','Õ','Ö','Ú','Ù','Û','Ü','Ñ');
		$arrayUpperSimples=array('C','A','A','A','A','A','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','N');
		$arrayUpperHTML=array('&Ccedil;','&Acirc;','&Atilde;','&Aacute;','&Agrave;','&Auml;','&Eacute;','&Egrave;','&Ecirc;','&Euml;','&Iacute;','&Igrave;','&Icirc;','&Iuml;','&Oacute;','&Ograve;','&Ocirc;','&Otilde;','&Ouml;','&Uacute;','&Ugrave;','&Ucirc;','&Uuml;','&Ntilde;');


		if($return=='lower') {
			$text=strtolower($text);

			for($i=0;$i<count($arrayLower);$i++) {
				if ($acento == FALSE) {
					$text=str_replace($arrayLower[$i], $arrayLowerSimples[$i], $text);
					$text=str_replace($arrayLowerHTML[$i], $arrayLowerSimples[$i], $text);
					$text=str_replace($arrayUpper[$i], $arrayLowerSimples[$i], $text);
					$text=str_replace($arrayUpperHTML[$i], $arrayLowerSimples[$i], $text);
				}
				else {
					$text=str_replace($arrayUpper[$i], $arrayLowerHTML[$i], $text);
				}
			}
		}
		elseif($return=='upper') {
			$text=strtoupper($text);
			for($i=0;$i<count($arrayLower);$i++) {
				if ($acento == FALSE) {
					$text=str_replace($arrayLower[$i], $arrayUpperSimples[$i], $text);
					$text=str_replace($arrayLowerHTML[$i], $arrayUpperSimples[$i], $text);
					$text=str_replace($arrayUpper[$i], $arrayUpperSimples[$i], $text);
					$text=str_replace($arrayUpperHTML[$i], $arrayUpperSimples[$i], $text);
				}
				else {
					$text=str_replace($arrayLower[$i], $arrayUpperHTML[$i], $text);
				}
			}
		}
		elseif ($return=='plain') {
			$text=str_replace($arrayUpper[$i], $arrayUpperHTML[$i], $text);
			$text=str_replace($arrayLower[$i], $arrayLowerHTML[$i], $text);
		}
		return($text);
	}
			###################
			#   			  #	
			#	 Gera Abas	  #
			#				  #
			###################
	function showabas($pgid, $modulo) {
		$tb_1 = new bd();
		//$fil = 'seguranca.codpg = '.$pgid.' AND seguranca_submenu.codpg=seguranca.codpg';
		$fil = 'seguranca.codpg = '.$pgid.' ORDER BY posicao';
		//$lista = $tb_1->gera_array('nome,arquivo,sub_arquivo,posicao','seguranca_submenu, seguranca',$fil,'posicao');
		$lista = $tb_1->gera_array('seguranca.codpg,nome,arquivo,sub_arquivo,posicao,ajax','seguranca_submenu JOIN seguranca ON seguranca.codpg=seguranca_submenu.codpg',$fil,'posicao');
		$script = '<script type="text/javascript">';
		$i=0;
		foreach($lista as $list){
				$script .= "tabView.addTab(new YAHOO.widget.Tab({
				label: '".$list['nome']."',\r
				closer: false,
				id: ".$i.",
				dataSrc: 'geraconteudo.php?file=modulos/".$list['arquivo']."/".$list['sub_arquivo']."', \r\n";
				//cacheData: ".($list['ajax']=='S')?'true':'false'.", \r, \r
				if ($list['ajax'] == 'N') { $script .= "cacheData: true, \r"; } else { $script .= "cacheData: false, \r"; }
				if ($i == 0) { $script .= "active: true \r"; } else { $script .= "active: false \r"; }
				$script .= "}));\r\n";
				$i ++;
		}
		$script .= '</script>';
		echo $script;
	}
	
	function show_tree($id_parent) {
		global $menu;
	
		print "<ul>\n";
	
		foreach ($menu[$id_parent] as $id => $label) {
			if (isset($menu[$id])) {
				printf("<li><img src='images/folder.gif'/> %sn", $label);
				show_tree($id);
			} else {
				printf("<li><img src='images/file.gif'/> %sn", $label);
			}
		}
		print "</li></ul>n";
	}



###################################################################
# Gera uma String randomica com tamanho igual ao parametro passado
# @param $num (int) ->tamanho da string de retorno
#
# @return (string) string randomica
###################################################################



function topocategoria($catego) {
	$query="SELECT * FROM categoria WHERE id_categoria='$catego'";
	$query = mysql_query($query);
	if (mysql_num_rows($query)) {
		$id_sub = mysql_result($query, 0, "id_subcategoria");
		topocategoria($id_sub);
		if ($id_sub == "0") {
			echo mysql_result($query, 0, "categoria");
		}
		else {
			echo " > ".mysql_result($query, 0, "categoria");
		}
	}
}

function gera_str_rand($num) {
	$sConso = 'bcdfghjkmaeunpqrstv23456789wxyzbcdfghjkmnpqrstvwxyzaeu';
	$str = '';

	$y = strlen($sConso)-1; //conta o nº de caracteres da variável $sConso

	for($x = 0; $x < $num; $x++) {
		$rand = rand(0,$y); //Funçao rand() - gera um valor randômico
		$str .= substr($sConso,$rand,1); // substr() - retorna parte de uma string
	}
	return $str; 
}

function gera_img_check($str) {
	$hora = date("H:i");

	$img = imagecreatetruecolor(120, 50);

	$azulzinho = imagecolorallocate($img, 227, 238, 242);

	$cinza = imagecolorallocate($img, 200, 200, 200);

	imagefill($img, 0, 0, $azulzinho);

	$black = imagecolorallocate($img, 0, 0, 0);
	$black2 = imagecolorallocatealpha($img, 0, 0, 0, 110);
	
	$xpos = -25;

	for ($i = 0; $i < 5; $i++) {
		$cor = imagecolorallocate($img, rand(0,256), rand(0,256), rand(0,256));
		imageline ( $img, 0, rand(0,50), 110, rand(0,50), $cor);
	}
	for ($i = 0; $i < strlen($str); $i++) {
		$xpos += 30;
		imagettftext($img, rand(20,25), 0, $xpos, rand(25,35), $black, "include/".rand(1,7).".ttf", substr($str, $i, 1));
	}
	
	imagejpeg($img, "img/tmp/".encode($str).".jpg", 90);
	imagedestroy($img);
}

function random_array($min, $max, $num){
   $range = $max-(1+$min);
   // if num is bigger than the potential range, barf.
   // note that this will likely get a little slow as $num
   // approaches $range, esp. for large values of $num and $range
   if($num > $range){
     return false;
   }
   // set up a place to hold the return value
   $ret = Array();
   // fill the array
   while(count($ret) < $num){
     $a = false; // just declare it outside of the do-while scope
     // generate a number that's not already in the array
     // (use do-while so the rand() happens at least once)
     do{
         $a = rand($min, $max);
     }while(in_array($a, $ret));
     // stick the new number at the end of the array
     $ret[] = $a;
   }
   return $ret;
}

function dir_list($dir)
{
  $dl = array();
  if ($hd = opendir($dir))
  {
    while ($sz = readdir($hd)) { if (preg_match("/^\./",$sz)==0) $dl[] = $sz; }
    closedir($hd);
  }
  sort($dl);
  return $dl;
}
	function geradata() {
		$english_month = date("m");
		return "Juiz de Fora, " . date("d") . " de " . getmes($english_month) . " de " . date("Y");
	}
	function getmes($num) {
		$array['01'] = "Janeiro";
		$array['02'] = "Fevereiro";
		$array['03'] = "Março";
		$array['04'] = "Abril";
		$array['05'] = "Maio";
		$array['06'] = "Junho";
		$array['07'] = "Julho";
		$array['08'] = "Agosto";
		$array['09'] = "Setembro";
		$array['10'] = "Outubro";
		$array['11'] = "Novembro";
		$array['12'] = "Dezembro";
		return $array[$num];
	}



function CalculaCPF($CampoNumero) {
  $RecebeCPF=$CampoNumero;

//Retirar todos os caracteres que nao sejam 0-9

  $s="";
  for ($x=1; $x<=strlen($RecebeCPF); $x=$x+1) {

    $ch=substr($RecebeCPF,$x-1,1);
    if (ord($ch)>=48 && ord($ch)<=57) {

      $s=$s.$ch;
    } 
  } 

  $RecebeCPF=$s;

  if (strlen($RecebeCPF)!=11) {

    return false;
  }
    else
  if (($RecebeCPF=="00000000000") || ($RecebeCPF=="11111111111") || ($RecebeCPF=="22222222222") || ($RecebeCPF=="33333333333") || ($RecebeCPF=="44444444444") || ($RecebeCPF=="55555555555") || ($RecebeCPF=="6666666666") || ($RecebeCPF=="77777777777") || ($RecebeCPF=="88888888888") || ($RecebeCPF=="99999999999")) {
    $then;
    return false;
  }
    else {
    $Numero[1]=intval(substr($RecebeCPF,1-1,1));
    $Numero[2]=intval(substr($RecebeCPF,2-1,1));
    $Numero[3]=intval(substr($RecebeCPF,3-1,1));
    $Numero[4]=intval(substr($RecebeCPF,4-1,1));
    $Numero[5]=intval(substr($RecebeCPF,5-1,1));
    $Numero[6]=intval(substr($RecebeCPF,6-1,1));
    $Numero[7]=intval(substr($RecebeCPF,7-1,1));
    $Numero[8]=intval(substr($RecebeCPF,8-1,1));
    $Numero[9]=intval(substr($RecebeCPF,9-1,1));
    $Numero[10]=intval(substr($RecebeCPF,10-1,1));
    $Numero[11]=intval(substr($RecebeCPF,11-1,1));
    $soma=10*$Numero[1]+9*$Numero[2]+8*$Numero[3]+7*$Numero[4]+6*$Numero[5]+5*$Numero[6]+4*$Numero[7]+3*$Numero[8]+2*$Numero[9];

    $soma=$soma-(11*(intval($soma/11)));

    if ($soma==0 || $soma==1) {

      $resultado1=0;
    }
      else {

      $resultado1=11-$soma;
    } 
    if ($resultado1==$Numero[10]) {
	$soma=$Numero[1]*11+$Numero[2]*10+$Numero[3]*9+$Numero[4]*8+$Numero[5]*7+$Numero[6]*6+$Numero[7]*5+$Numero[8]*4+$Numero[9]*3+$Numero[10]*2;

      $soma=$soma-(11*(intval($soma/11)));

      if ($soma==0 || $soma==1) {

        $resultado2=0;
      }
      else {

        $resultado2=11-$soma;
	  } 
      if ($resultado2==$Numero[11]) {

	return true;	
      }
        else {
	return false;	
      } 
    }
      else {
	return false;	
    } 
  } 
} 
	  //|///////////////////////////////////////////////////////////|
      //| |
      //| funcao para calcular cnpj |
      //| |
      //|///////////////////////////////////////////////////////////|

function CalculaCNPJ($CampoNumero) {

  $RecebeCNPJ=${"CampoNumero"};

  $s="";
  for ($x=1; $x<=strlen($RecebeCNPJ); $x=$x+1) {

    $ch=substr($RecebeCNPJ,$x-1,1);
    if (ord($ch)>=48 && ord($ch)<=57) {

      $s=$s.$ch;
    } 
  } 

  $RecebeCNPJ=$s;

  if (strlen($RecebeCNPJ)!=14) {

	return false;	
}
    else
  if (($RecebeCNPJ=="00000000000000") || ($RecebeCNPJ=="11111111111111") || ($RecebeCNPJ=="22222222222222") || ($RecebeCNPJ=="33333333333333") || ($RecebeCNPJ=="44444444444444") || ($RecebeCNPJ=="55555555555555") || ($RecebeCNPJ=="66666666666666") || ($RecebeCNPJ=="77777777777777") || ($RecebeCNPJ=="88888888888888") || ($RecebeCNPJ=="99999999999999")) {
    $then;
	return false;	
  }
    else {

    $Numero[1]=intval(substr($RecebeCNPJ,1-1,1));
    $Numero[2]=intval(substr($RecebeCNPJ,2-1,1));
    $Numero[3]=intval(substr($RecebeCNPJ,3-1,1));
    $Numero[4]=intval(substr($RecebeCNPJ,4-1,1));
    $Numero[5]=intval(substr($RecebeCNPJ,5-1,1));
    $Numero[6]=intval(substr($RecebeCNPJ,6-1,1));
    $Numero[7]=intval(substr($RecebeCNPJ,7-1,1));
    $Numero[8]=intval(substr($RecebeCNPJ,8-1,1));
    $Numero[9]=intval(substr($RecebeCNPJ,9-1,1));
    $Numero[10]=intval(substr($RecebeCNPJ,10-1,1));
    $Numero[11]=intval(substr($RecebeCNPJ,11-1,1));
    $Numero[12]=intval(substr($RecebeCNPJ,12-1,1));
    $Numero[13]=intval(substr($RecebeCNPJ,13-1,1));
    $Numero[14]=intval(substr($RecebeCNPJ,14-1,1));

    $soma=$Numero[1]*5+$Numero[2]*4+$Numero[3]*3+$Numero[4]*2+$Numero[5]*9+$Numero[6]*8+$Numero[7]*7+$Numero[8]*6+$Numero[9]*5+$Numero[10]*4+$Numero[11]*3+$Numero[12]*2;

    $soma=$soma-(11*(intval($soma/11)));

    if ($soma==0 || $soma==1) {
      $resultado1=0;
    }
      else {

      $resultado1=11-$soma;
    } 

    if ($resultado1==$Numero[13]) {

      $soma=$Numero[1]*6+$Numero[2]*5+$Numero[3]*4+$Numero[4]*3+$Numero[5]*2+$Numero[6]*9+$Numero[7]*8+$Numero[8]*7+$Numero[9]*6+$Numero[10]*5+$Numero[11]*4+$Numero[12]*3+$Numero[13]*2;
      $soma=$soma-(11*(intval($soma/11)));
      if ($soma==0 || $soma==1) {
        $resultado2=0;
      }
        else {

        $resultado2=11-$soma;
      } 

      if ($resultado2==$Numero[14]) {
	return true;	
      }
        else {

	return false;	
      } 
    }
      else {
	return false;	
    } 
  } 
}



?>