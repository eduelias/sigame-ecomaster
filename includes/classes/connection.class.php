<?

	// Dados de conexão do Banco de Dados.

class conexao
{

    var $conn ;
	var $debug;

    function connect_wbs()
    {
		//$this->debug = new debug();
        $this->conn = ADONewConnection(WBS_TIPODB);
        if (!$this->conn) die("Connection failed");
        $this->conn->debug = false;
        $this->conn->Connect(WBS_SERVER, WBS_USER, WBS_PASSWORD, WBS_DB);
		//$this->debug['server'] = WBS_SERVER;
			//	$this->debug['user'] = WBS_USER;
					///	$this->debug['pass'] = WBS_PASSWORD;
							//	$this->debug['db'] = WBS_DB;
		

    } //function
    
     function connect_empresa()
    {
        $this->conn = ADONewConnection(WBS_TIPODB);
        if (!$this->conn) die("Connection failed");
        $this->conn->debug = false;
        $this->conn->Connect(WBS_SERVER, WBS_USER, WBS_PASSWORD, WBS_DB2);

    } //function
    
     function connect_ipa()
    {
        $this->conn = ADONewConnection(WBS_TIPODB);
        if (!$this->conn) die("Connection failed");
        $this->conn->debug = false;
        $this->conn->Connect(IPA_SERVER, IPA_USER, IPA_PASSWORD, IPA_DB);

    } //function
    
     function disconnect()
    {
        $this->conn->Close;

    } //function
	
	
	   function query_db ($query_db)
    {
         $result = $this->conn->Execute($query_db);
		//$this->debug->bug($query_db, 'conn');
		//$this->debug->bug($result, 'query res');
        return $result;
    } //function
	
	function get_all($conex) {
		$result = $this->conn->adodb_getall($conex);
		return $result;
	}
	
}


?>