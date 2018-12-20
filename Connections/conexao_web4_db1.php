<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexao_web4_db1 = "localhost";
$database_conexao_web4_db1 = "web4_db1";
$username_conexao_web4_db1 = "web4_u1";
$password_conexao_web4_db1 = "web4_s1";
$conexao_web4_db1 = mysql_pconnect($hostname_conexao_web4_db1, $username_conexao_web4_db1, $password_conexao_web4_db1) or trigger_error(mysql_error(),E_USER_ERROR); 
?>