<?
	header('Content-type: text/html; charset=utf-8');

	include("../../includes/class.php");


	//$login = new login();
	//$login->session($_SESSION);
	//$login->checklogin();
	//pre($_GET);
	
	$tipo = $_GET['tipo'];
	$id = $_GET['id'];

	$emp = new empresa();
	
	switch ($tipo) {
		case 'empresa': {
			$return = $emp->getProcessos();
		}break;
		case 'processo':{
			$return = $emp->getAtividade($id);
		}break;
		case 'atividade':{
			$return = $emp->getAspecto($id);
		}break;
		case 'aspecto_ambiental':{
			$return = 0; //$emp->getImpacto($id); //missao($id);
		}break;
		case 'impacto':{
			$return = $emp->getEmissao($id);
		}break;
		case 'tipo_emissao':{
			$return = $emp->getDestinacao($id);
		}break;
		case 'destinacao':{
			$return = 0; //emp->getAuditoria($id);
		}break;
		default: {;} break;
	}
	

	if (is_array($return)) {
		foreach ($return as $label => $valor){
			$return1[] = array("label"=>iconv('iso-8859-1','utf-8',$valor['label']),'ID'=>$valor['ID'],'tipo'=>$valor['tipo'], 'estilo'=> 'tree '.$valor['tipo'].' '.$valor['estilo'], 'leaf'=>$valor['leaf']);
		}
	} else {
		$return1 = 0;
	}
	
	$returnValue['ResultSet']['Result'] = $return1;
	
	$json = new Services_JSON();
	$data = $json->encode($returnValue);
	
	echo $data;
?>