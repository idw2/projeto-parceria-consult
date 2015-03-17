<?php

Class Index extends Controller {

    public function __construct() {
        
        $this->get_smarty();
        $this->run();
    }
    
    function index() {
        
        return false;             
    }

    function index_action() {

        if ($this->permitir_acesso_home($_SESSION["EMAIL"], $_SESSION["SENHA"], $papel)) {
            echo "<script>window.location='/" . LANGUAGE . "/admin/welcome'</script>";
        } else {
            $vars = $this->dados();
        
            $vars["pagina"] = "Área Restrita";
            $vars["page"] = "index";

            $this->view("admin/index", $vars);
        }
        
    }    

}
