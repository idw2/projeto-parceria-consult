<?php

class System {

    private $_url;
    public $controller;
    public $action;
    private $controller_url = CONTROLLERS;
    private $system_url = SYSTEM;
    private $models_url = MODELS;
    private $libraries_url = LIBRARIES;
    private $helpers_url = HELPERS;
    private $site = SITE;
    private $arquivos = array("model", "Smarty.class", "Smarty", "controller", "Admin_Model", "phpQuery-onefile", "MPDF57/mpdf", "PHPExcel/Classes/PHPExcel", "planilha", "GExtenso/GExtenso");

    public function __construct() {
        $this->setURL();
        $this->setSeparator();
        $this->loadControlls();
        //$this->setParameters();
    }

    private function setURL() {
        $_GET["url"] = (strlen($_GET["url"]) == 3 ) ? $_GET["url"] . "index/index_action/" : $_GET["url"] . "/";
        $this->_url = $_GET["url"];
    }

    private function setSeparator() {
        $separator = explode("/", $this->_url);
        $this->controller = $separator[1];
        $separator[2] = str_replace("-", "_", $separator[2]);
        $this->action = ( $separator[2] == null || $separator[2] == "index" ) ? $separator[2] = "index_action" : $separator[2];
    }

    private function loadControlls() {
        
        if (file_exists($this->controller_url . $this->controller . "Controller.php")) {
            $this->__autoload($this->arquivos);
            require_once( $this->controller_url . $this->controller . "Controller.php" );
        } else {
            
            
            echo "<script>window.location='//" . $this->site . "404.php'</script>";
            exit();
        }
    }

    public function __autoload(Array $files) {
        $size = sizeof($files);

        if ($size != 0) {
            foreach ($files as $filename) {
                if (file_exists($this->models_url . $filename . ".php")) {
                    require_once( $this->models_url . $filename . ".php" );
                } elseif (file_exists($this->system_url . $filename . ".php")) {
                    require_once( $this->system_url . $filename . ".php" );
                } elseif (file_exists($this->libraries_url . $filename . ".php")) {
                    require_once( $this->libraries_url . $filename . ".php" );
                } elseif (file_exists($this->helpers_url . $filename . ".php")) {
                    require_once( $this->helpers_url . $filename . ".php" );
                }
            }
        }
    }

}
