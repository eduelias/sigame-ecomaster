<?
/*
+--------------------------------------------------------------
|  SIGAME
+--------------------------------------------------------------

*/
//BANCO DE DADOSerror_reporting(E_ALL); # report all errors
#error_reporting(E_ALL); # report all errors
#ini_set("display_errors", "0"); # but do not echo the errors
#define('ADODB_ERROR_LOG_TYPE',3);
#define('ADODB_ERROR_LOG_DEST','C:/errors.log');
#include('adodb/adodb-errorhandler.inc.php');
//Java Script MINIMOS?
define("JSMIN",true);
$BDEMPRESA = '_teste1';
define ("YUI_VER", "2.5");
// BANCO DE DADOS WBS
define("WBS_SERVER", "localhost");
define("WBS_DB", "web4_db2");
define("WBS_USER", "maxx");
define("WBS_PASSWORD", "maxx@123");
define("WBS_DB2", "empresa_teste1");

//CONFIGURACAO DE VARIAVEIS

// DEFINE DIRETORIOS DO SIGAME
define("C_IS_WINDOWS", false);
define("C_DIR", (C_IS_WINDOWS ? "\\" : "/"));
define("C_DIR_SISTEMA", "sigame");
define("C_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"].C_DIR.C_DIR_SISTEMA.C_DIR);
define("C_PATH_INCLUDE", C_PATH_ROOT."includes".C_DIR);
define("C_PATH_TEMPLATE", C_PATH_ROOT."template".C_DIR);
define("C_PATH_MODULES", C_PATH_ROOT."modules".C_DIR);
define("C_PATH_LANGUAGES", C_PATH_ROOT."languages".C_DIR);
define("C_PATH_CSS", C_PATH_TEMPLATE."css".C_DIR);
define("C_PATH_JS", C_PATH_TEMPLATE."js".C_DIR);
define("C_PATH_IMAGES", C_PATH_TEMPLATE."images".C_DIR);
define("C_PATH_CLASS", C_PATH_INCLUDE."classes".C_DIR);
define("C_PATH_MSGS", C_PATH_LANGUAGES."msgs".C_DIR);

include(C_PATH_ROOT.'adodb/adodb.inc.php');
define("WBS_TIPODB", "mysql");
$conn_db = ADONewConnection(WBS_TIPODB);

//session_start();

define("MSG_REQ","<img src='images/delete.gif' border=0 style='margin-bottom:-4px'>");
define("MSG_ERRO","<img src='images/delete.gif' border=0 style='margin-bottom:-4px'>");
define("MSG_INV","?");
?>