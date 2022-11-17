<?php
#caminhos absolutos
$pastaInterna="cadastro-login/";
define('DIRPAGE',"http://{$_SERVER['HTTP_HOST']}/{$pastaInterna}");
(substr($_SERVER['DOCUMENT_ROOT'],-1)=='/')?$barra="":$barra="/";
define('DIRREQ',"{$_SERVER['DOCUMENT_ROOT']}{$barra}{$pastaInterna}");

#Atalhos
#define('DIRIMG',DIRPAGE.'img/');
define('DIRCSS',DIRPAGE.'lib/css/');
define('DIRJS',DIRPAGE.'lib/js/');

#Acesso ao banco de dados 
define('HOST',"localhost");
define('DB',"doador-rp");
define('USER',"root");
define('PASS',"");

#Outras informações
define("SITEKEY","SITEKEY EMITIDO PELO SITE DO GOOGLE CAPTCHA");
define("SECRETKEY","SECRETKEY EMITIDO PELO SITE DO GOOGLE CAPTCHA");
define("DOMAIN",$_SERVER["HTTP_HOST"]);

#Informações do servidor de email
#define("HOSTMAIL","MEU SERVIDOR DE EMAIL");
#define("USERMAIL","USUÁRIO DE DO EMAIL");
#define("PASSMAIL","SENHA DO EMAIL");

?>