<?php
//
//phpinfo();
//exit();

header ('Content-type: text/html; charset=UTF-8');
session_start();

define("DIR", getcwd());
define("LANGUAGE", substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
define("SITE", "estagiarios.parceriaconsult.com.br/");
define("CONTROLLERS", "application/controllers/");
define("VIEWS", "application/views/");
define("MODELS", "application/models/");
define("LIBRARIES", "libraries/");
define("SYSTEM", "system/");
define("HELPERS", "system/helpers/");
define("TITLE", "Cadastro de Estagiários");
define("LOGO", "web-files/img/logo.png");
define("CEP_REMETENTE", "20050-090");

define("URL_RETORNO", "http://" . SITE . LANGUAGE . "/mensagem/retorno");
define("URL_CANCELAMENTO", "http://" . SITE . LANGUAGE . "/mensagem/cancelamento");
define("URL_NOTIFICACAO", "http://" . SITE . LANGUAGE . "/mensagem/notificacao");

define("FACEBOOK", "https://www.facebook.com/pages/Parceria-Consultoria-Empresarial-Ltda/201838909894780");
define("TWITTER", "https://twitter.com/parceriavagas");
define("GOOGLE_PLUS", "https://plus.google.com/u/0/102554160270292862985/about?hl=pt-BR");


define("OG_TITLE", "Sistema - daniel@parceriaconsult.com.br");
define("OG_TYPE", "product");
define("OG_SITE_NAME", "parceriaconsult.com.br");
define("OG_DESCRIPITION", "");
define("OG_EMAIL", "daniel@parceriaconsult.com.br");
define("OG_PHONE_NUMBER", "21 22249845");
define("OG_STREET_ADDRESS", "Centro do Rio de Janeiro – Rua Uruguaiana nº 10, sala 2206 | Tel: (21) 2224-9845 Fax: (21) 2509-1158");
define("OG_LOCALITY", "Rio de Janeiro");
define("OG_REGION", "Rio de Janeiro — Capital");
define("OG_COUNTRY_NAME", "Brasil");
define("OG_POSTAL_CODE", "20050-090");

define("EMAIL_RH", "marta@parceriaconsult.com.br");
define("EMAIL_DISPATCHER", "no-reply@parceriaconsult.com.br");
define("ALIAS", "");

if($_SESSION){
    foreach( $_SESSION as $name => $valor){
        define($name, $valor);
    }
}



if ( $_GET["url"] == "" ) {
    $_GET["url"] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . "/index/index_action/";
}


if (!isset($_GET["url"])) {
    echo "<script>window.location='http://" . SITE . LANGUAGE . "/'</script>";
} else if (strlen($_GET["url"]) == 2) {
    echo "<script>window.location='http://" . SITE . LANGUAGE . "/'</script>";
} else if (strtolower($_GET["url"]) == "admin") {
    echo "<script>window.location='http://" . SITE . LANGUAGE . "/admin/'</script>";
}

require_once( SYSTEM . "system.php");
$start = new System();
$controller = $start->controller;
$action = $start->action;


$app = new $controller();

if (method_exists($controller, $action)) {
    $app->$action();
} else {
    echo "<script>window.location='//" . SITE . "404.php'</script>";
    exit();
}
