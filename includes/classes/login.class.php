<?
/** 
 * Efetua um login por sess�o atrav�s de dados de uma tabela
 * A senha deve estar encriptada em MD5 para funcionar.
 * 
 * 
 * @category   
 * @package     login
 * @author      Kico Zaninetti <kicozaninetti@gmail.com>
 * @copyright   2005 Kico Zaninetti
 * @license     http://www.opensource.org/licenses/bsd-license.php
 */

/** 
 * Efetua um login por sess�o atrav�s de dados de uma tabela
 *
 */
class login  extends conexao{
	
	
	/** 
	 * Nome da tabela no MySQL onde ser� feita a consulta do usu�rio e senha
	 */
	private $tabela; //char

	/** 
	 * Nome do campo onde ser� checado o usu�rio a efetuar login
	 */
	private $campousuario; //char

	/** 
	 * Nome do campo onde ser� checada a senha do usu�rio
	 */
	private $camposenha; //char

	/** 
	 * Nome do campo de ID da tabela em quest�o
	 */
	private $campoid; //char

	/** 
	 * Usu�rio passado por formul�rio ou sess�o
	 */
	private $login; //char

	/** 
	 * Senha passada por formul�rio ou sess�o
	 */
	private $senha; //char

	/** 
	 * Valor do ID retornado se o login foi efetuado com sucesso
	 */
	private $id; //int
	
	var $conn;
	
		
		

###############################################################################
# M�todos para setar valores aos atributos
###############################################################################


	/** 
	 * Metodo para setar o valor ao atributo usuario
	 * 
	 * @param string $usuario
	 */
	function setusuario($usuario) {
	
		$this->usuario = (string) $usuario;
	
	}

	/** 
	 * Metodo para setar o valor ao atributo senha
	 * 
	 * @param string $senha
	 */
	function setsenha($senha) {
	
		$this->senha = (string) $senha;
	
	}


###############################################################################
# M�todos para pegar os valores dos atributos
###############################################################################

	/** 
	 * Metodo para pegar o valor do atributo usuario
	 *
	 * @return string usuario
	 */
	function getusuario() {
		return (string) $this->usuario;
	}

	/** 
	 * Metodo para pegar o valor do atributo senha
	 *
	 * @return string senha
	 */
	function getsenha() {
		return (string) $this->senha;
	}

	/** 
	 * Metodo para pegar o valor do atributo tabela
	 *
	 * @return string tabela
	 */
	function gettabela() {
		return (string) $this->tabela;
	}

	/** 
	 * Metodo para pegar o valor do atributo id
	 *
	 * @return int id
	 */
	function getid() {
		return (int) $this->id;
	}

	/** 
	 * Metodo para pegar o valor do atributo campoid
	 *
	 * @return string campoid
	 */
	function getcampoid() {
		return (string) $this->campoid;
	}

###############################################################################
# M�todos usuais da classe
###############################################################################

	/** 
	 * Metodo para setar os dados de um objeto a partir de um array
	 * @param array $array    Normalmente utilizado os arrays:
	 *  				      $_POST => para formul�rio
	 *        				  $_SESSION => para sess�o j� existente
	 *
	 */
	function form($array) {
		foreach($array as $chave=>$valor) {
			$aux = explode('@',$chave);
			$this->tabela = $aux[0];
			$this->$aux[1] = $valor;
		}		
	}
	
	function session($array) {
		foreach($array as $chave=>$valor) {
			$this->$chave = $valor;
		}
		
	}

	/** 
	 * Faz a checagem se o usu�rio est� permitido de logar no sistema
	 * 
	 * @return bool TRUE ou FALSE se o usu�rio est� logado
	 *
	 */
	function checklogin() {

		parent::connect_wbs();
		$sql = "SELECT idusuario,idgrupos FROM cfg_usuario WHERE login = '".$this->usuario."' AND senha = '".$this->senha."'";
		$result = parent::query_db($sql);
		
		parent::disconnect();

		if ($result->RecordCount() > 0) {
			$this->id = $result->fields[0];
			$_SESSION["tabela"] = $this->tabela;
			$_SESSION["campousuario"] = 'login';
			$_SESSION["camposenha"] = 'senha';
			$_SESSION["campoid"] = 'idusuario';
			$_SESSION["usuario"] = $this->usuario;
			$_SESSION["senha"] = $this->senha;
			$_SESSION["id"] = $this->id;
			$_SESSION['swidth'] = $this->swidth;
			$_SESSION["logado"] = 1;
			$_SESSION["grupo"] = $result->fields['idgrupos'];
			$this->grupo = $result->fields['idgrupos'];
			return true;
		}
		else {
			if (!$this->idsorteio) {
				echo $sql;/*	echo "<script>window.location = 'modules/errors/index.php?errologin=1';	</script>";*/
			}
			else {
				return false;
			}
		}
	}
	
	function permissoes($modulo,$acao){
		$result = false;
		if (isset($_SESSION['grupo'])){
			parent::connect_wbs();
			$sql = "SELECT ".$acao." FROM cfg_grupos_has_modulos WHERE idgrupos = '".$_SESSION['grupo']."' AND idmodulos = '".$modulo."'";
			$ado = parent::query_db($sql);
			$result = ($ado->fields[$acao])?true:false;
		}
		return $result;
	}

	/** 
	 * Metodo para encriptar a senha no padr�o MD5
	 * 
	 */
	function encodesenha() {
		$this->setsenha(md5($this->usuario.$this->senha));
	}
	
}
?>