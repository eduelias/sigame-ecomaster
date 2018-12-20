<?
	header('Content-type: text/html; charset=utf-8');

	include("includes/class.php");


	//$login = new login();
	//$login->session($_SESSION);
	//$login->checklogin();

	/////////////////////////////////////////
	// PEGA TODOS OS DADOS DO USUÁRIO LOGADO
	/////////////////////////////////////////
	//$bd = new bd();
	//$userlogged = $bd->gera_array('*','vendedor','codvend ='.$login->getid());
	/////////////////////////////////////////
	$campos = ($_GET[campos]=='')?'*':str_replace(array("\\"), "", $_GET[campos]);
	
	$obj = $_GET[obj];
	// Search condition
	$condicao = $_GET[condicao];
	$condicao=str_replace(array("<", ">", "\\", "/", "?"), "", $condicao);
	
	// Pag num
	$pagina = $_GET[pagina];
	// Records returned
	$numregistro = (int) $_GET[numregistro];
	// Sorted?
	$sort = $_GET['sort'];
	// Sort dir?
	$dir = $_GET['dir'];

	//print_r($_GET);
	if (method_exists($obj,gera_array)) {
		$bb = new $obj;
		//echo 'OBJ';
	} else {
		$bb = new bd(); 
		//echo 'BD';
	};

	$in = ($pagina-1)*$numregistro;

	$lista = $bb->gera_array($campos,$obj,$condicao,'1'); 
	//$bb->loga($bb->get_sql());
	if (is_array($lista)) {
		foreach ($lista as $keu=>$value){
			foreach ($value as $k=>$v) {
				$lista[$keu][$k] = iconv('iso-8859-1','utf-8',$v);
			}
		}
	} else { echo $bb->get_sql(); }
	
	if (count($lista)<1){
		$returnValue = array(
			'error'=>0,
			'recordsReturned'=>0,
			'totalRecords'=>0,
			'startIndex'=>0,
			'records'=>0
    	);
	} else {
	    $returnValue = array(
			'error'=>0,
			'recordsReturned'=>sizeof($lista),
			'totalRecords'=>sizeof($lista),
			'startIndex'=>$in,
			'records'=>$lista
    	);
	}
	
	$json = new Services_JSON();
	$data = $json->encode($returnValue);
	
	echo $data;
?>