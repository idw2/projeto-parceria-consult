<?php

class Controller extends My_smarty {

    private $_params;
    private $_url;

    protected function view($nome, $vars = null) {
        if (is_array($vars) && count($vars) > 0) {
            extract($vars, EXTR_PREFIX_ALL, "view");
            return require_once( VIEWS . $nome . ".phtml");
            exit();
        }
    }
    
    protected function view_pdf($nome, $vars = null) {
        
        if (is_array($vars) && count($vars) > 0) {
            extract($vars, EXTR_PREFIX_ALL, "view");
            
            ob_start();
            require_once( VIEWS . $nome . ".phtml");
            $html = ob_get_clean();
            return $html;            
            exit();
        }
        
    }
    
    protected function view_email($nome, $vars = null) {
        if (is_array($vars) && count($vars) > 0) {
            extract($vars, EXTR_PREFIX_ALL, "view");
            ob_start();
            require_once( VIEWS . $nome . ".phtml");
            $html = ob_get_clean();
            return $html;
            exit();
        }
    }

    private function setURL() {
        $_GET["url"] = (isset($_GET["url"])) ? $_GET["url"] . "/" : "index/index_action";
        $this->_url = $_GET["url"];
    }

    public function array_url() {
        $separator = explode("/", $_GET["url"]);
        unset($separator[0], $separator[1], $separator[2]);
        if (sizeof($separator) != 0) {
            foreach ($separator as $name => $value) {
                if ($value != "") {
                    $arr[] = $value;
                }
            }
            return $arr;
        } else {
            return false;
        }
    }

    private function setParameters() {

        $separator = explode("/", $this->_url);
        unset($separator[0], $separator[1], $separator[2]);

        if (sizeof($separator) % 2 == 1) {
            array_pop($separator);
        }

        $count = 0;
        if (!empty($separator)) {
            foreach ($separator as $val) {
                ( $count % 2 == 0) ? $inds[] = $val : $values[] = $val;

                $count++;
            }
        } else {
            $inds = array();
            $values = array();
        }

        if ((count($inds) == count($values)) && (!empty($inds) && !empty($values))) {
            $this->_params = array_combine($inds, $values);
        } else {
            $this->_params = array();
        }
    }

    public function getParameters($name = null) {
        if ($name == null) {
            return $this->_params;
        } else {
            return $this->_params[$name];
        }
    }

    public function run() {

        $this->setURL();
        $this->setParameters();
    }

    public function getEndereco($cep) {

        $cep = str_replace("-", "", $cep);
        define('POSTURL', 'http://m.correios.com.br/movel/buscaCepConfirma.do');
        define('POSTVARS', 'cepEntrada=' . $cep . '&metodo=buscarCep');  // POST VARIABLES TO BE SENT

        $ch = curl_init(POSTURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, POSTVARS);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);  // DO NOT RETURN HTTP HEADERS
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
        $html = curl_exec($ch);

        phpQuery::newDocumentHTML($html, $charset = 'utf-8');

        $dados = array(
            'Logradouro' => trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
            'Bairro' => trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
            'Cidade/uf' => trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
            'Cep' => trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
        );

        $dados['Cidade/uf'] = explode('/', $dados['Cidade/uf']);
        $dados['Cidade'] = trim($dados['Cidade/uf'][0]);
        $dados['UF'] = trim($dados['Cidade/uf'][1]);
        unset($dados['Cidade/uf']);

        $dados["Logradouro"] = $dados["Logradouro"];
        $dados["Bairro"] = $dados["Bairro"];
        $dados["Cep"] = $dados["Cep"];
        $dados["Cidade"] = $dados["Cidade"];
        $dados["UF"] = $dados["UF"];

        curl_close($ch);
        return $dados;
    }

    public function getPrimarykey() {
        return strtoupper(md5(uniqid(rand(), true)));
    }

    public function senhaMd5($senha) {
        return strtoupper(md5($senha));
    }

    public function url_amigavel($name) {

        $name = strtolower(trim($name));
        $name = str_replace("/", " ", $name);
        $name = str_replace("'", " ", $name);
        $name = str_replace('"', " ", $name);
        $name = str_replace("-", " ", $name);
        $name = str_replace(";", " ", $name);
        $name = str_replace(",", " ", $name);
        $name = str_replace("á", "a", $name);
        $name = str_replace("ã", "a", $name);
        $name = str_replace("â", "a", $name);
        $name = str_replace("à", "a", $name);
        $name = str_replace("é", "e", $name);
        $name = str_replace("ê", "e", $name);
        $name = str_replace("í", "i", $name);
        $name = str_replace("ó", "o", $name);
        $name = str_replace("õ", "o", $name);
        $name = str_replace("ô", "o", $name);
        $name = str_replace("ú", "u", $name);
        $name = str_replace("ç", "c", $name);
        $name = preg_replace("/\s{2,}/", " ", $name);
        $name = str_replace(" ", "-", $name);
        return $name;
    }

    public function iniciais($nome) {
        $nome = str_replace("-", "", $nome);
        $nome = str_replace("/", "", $nome);
        $nome = preg_replace("/\s{2,}/", " ", $nome);
        $n = explode(" ", $nome);
        $iniciais = "";

        foreach ($n as $in => $value) {
            if ($value != "") {
                $vl = mb_strtoupper($value, "UTF-8");
                if (mb_strlen($vl, "UTF-8") > 2) {
                    $iniciais .= $vl{0};
                }
            }
        }

        return preg_replace('/([A-Za-z])\1/', '\1', $iniciais);
    }

    public function trata_nome($nome) {
        $n = explode(" ", $nome);
        $newname = "";

        foreach ($n as $in => $value) {
            
            if (mb_strlen($value, "UTF-8") <= 2) {
                $newname .= mb_strtolower($value, "UTF-8") . " ";
            } else {
                $vl = mb_strtoupper($value{0}, "UTF-8");
                $vl2 = mb_strtolower(substr($value, 1), "UTF-8");
                $newname .= $vl . $vl2 . " ";
            }
        }

        $newname = str_replace("S/a", "S/A", $newname);
        $newname = str_replace("s/A", "S/A", $newname);
        $newname = str_replace("s/a", "S/A", $newname);
        $newname = str_replace("S/A", "S/A", $newname);
        $newname = str_replace("S.A", "S/A", $newname);
        $newname = str_replace("s.A", "S/A", $newname);
        $newname = str_replace("S.a", "S/A", $newname);
        $newname = str_replace("s.a", "S/A", $newname);
        
        return trim($newname);
    }

    public function permitir_acesso($email_or_id, $senha, Array $papeis = null) {

        $model = new Admin_Model();


        if ($model->confere_senha($email_or_id, $senha)) {


            if (is_array($papeis)) {

                if (!in_array($_SESSION["PAPEL"], $papeis)) {
                    echo "<script>window.location='/403.php'</script>";
                    exit();
                } 

            }            
           return true;
        } else {
            echo "<script>window.location='/403.php'</script>";
            exit();
        }
    }

    public function permitir_acesso_home($email, $senha, $papel = null) {

        $model = new Admin_Model();
        if ($model->confere_senha($email, $senha, $papel)) {
            return true;
        }
    }

    public function saudacao() {
        $hora = (int) date("H");
        if ($hora >= 0 && $hora < 12) {
            return "Bom dia";
        } else if ($hora >= 12 && $hora < 18) {
            return "Boa tarde";
        } else {
            return "Boa noite";
        }
    }

    public function formataReais($valorReal) {
        $size = strlen($valorReal);
        $result = null;
        if ($size >= 9) {
            //9.999.999,99                                                                         
            if ($size == 9) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -9, 1);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            } elseif ($size == 10) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -10, 2);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            } elseif ($size == 11) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -11, 3);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            }
            return $result;
        } elseif ($size == 8) {
            //999.999,99                                                                           
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -8, 3);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 7) {
            //99.999,99                                                                            
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -7, 2);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 6) {
            //9.999,99                                                                             
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -6, 1);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 5) {
            //999,99                                                                               
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 4) {
            //99,99                                                                                
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -4, 2);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 3) {
            //9,99                                                                                 
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -3, 1);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 2) {
            //0,99                                                                                 
            $p1 = substr($valorReal, -2);
            $result = "0," . $p1;
            return $result;
        }

        return false;
    }

    public function formataCodigopedido($codigo) {
        switch (strlen($codigo)) {
            case 1: $codigo = "000000000{$codigo}";
                break;
            case 2: $codigo = "00000000{$codigo}";
                break;
            case 3: $codigo = "0000000{$codigo}";
                break;
            case 4: $codigo = "000000{$codigo}";
                break;
            case 5: $codigo = "00000{$codigo}";
                break;
            case 6: $codigo = "0000{$codigo}";
                break;
            case 7: $codigo = "000{$codigo}";
                break;
            case 8: $codigo = "00{$codigo}";
                break;
            case 9: $codigo = "0{$codigo}";
                break;
        }
        return $codigo;
    }

    public function limpaValorReal($valor) {
        $valor = str_replace(",", "", $valor);
        $valor = str_replace(".", "", $valor);
        return $valor;
    }

    /*
     * Tranforma datas do padrao Americano(2000-01-01) para o padrao brasileiro(01-01-2000)        
     */

    public function formataDataForBrazil($data) {
        $dtaFormatada = $data;
        $pieces = explode("-", $dtaFormatada);
        $pieces[0];
        $pieces[1];
        $pieces[2];
        $newDate = $pieces[2] . "/" . $pieces[1] . "/" . $pieces[0];
        return $newDate;
    }

    /*
     * Tranforma datas do padrao brasileiro(01-01-2000) para o padrao Americano(2000-01-01)        
     */

    public function formataDataForUSA($data) {
        $dtaFormatada = $data;
        $pieces = explode("/", $dtaFormatada);
        $pieces[0];
        $pieces[1];
        $pieces[2];
        $newDate = $pieces[2] . "-" . $pieces[1] . "-" . $pieces[0];
        return $newDate;
    }

    public function limpaCodigopedido($codigo) {
        return (int) $codigo;
    }

    public function dados() {

        $dados["facebook"] = FACEBOOK;
        $dados["twitter"] = TWITTER;
        $dados["google_plus"] = GOOGLE_PLUS;
        $dados["language"] = LANGUAGE;

        $loop = explode(";", $_SESSION["N_PAPEL"]);
        $elimina = (sizeof($loop) - 1 );
        unset($loop[$elimina]);

        if (sizeof($loop) > 1 && $_SESSION["PAPEL"] != "MASTER") {

            $dados["open_papeis"] = true;

            if (in_array('MASTER', $loop)) {
                $dados["is_master"] = "MASTER";
            }
            if (in_array('EMPRESA_ENTIDADE', $loop)) {
                $dados["is_empresa_entidade"] = "EMPRESA_ENTIDADE";
            }
            if (in_array('GESTOR', $loop)) {
                $dados["is_gestor"] = "GESTOR";
            }
            if (in_array('ESTAGIARIO', $loop)) {
                $dados["is_estagiario"] = "ESTAGIARIO";
            }
            
        } else {
            $dados["open_papeis"] = false;
        }

        if ($_SESSION["PAPEL"] == "GESTOR") {

            $model = new Admin_Model();
            $minhas_empresas = $model->get_cod_empresas_administrador($_SESSION["CODCADASTRO"]);

            if ($minhas_empresas) {
                foreach ($minhas_empresas as $obj) {

                    $obj_emp[] = $model->get_cadastro($obj->CODEMPRESA_ENTIDADE);
                }
                $dados["minhas_empresas_administraveis"] = $obj_emp;
            }
        }

        if (sizeof($_SESSION) > 0) {
            foreach ($_SESSION as $name => $value) {
                $name = strtolower($name);
                $dados[$name] = $value;
            }
        }
        
       # var_dump($dados);

        $dados["saudacao"] = $this->saudacao();

        return $dados;
    }

    public function validaCPF($cpf) {
        $cpf = $this->limpaCpf($cpf);

        // Verifiva se o n˙mero digitado contÈm todos os digitos                                   
        $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

        // Verifica se nenhuma das sequÍncias abaixo foi digitada, caso seja, retorna falso        
        // if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            return false;
        } else {   // Calcula os n˙meros para verificar se o CPF È verdadeiro                             
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    public function validaCNPJ($cnpj) {

        $cnpj = $this->limpaCpf($cnpj);

        if (strlen($cnpj) <> 14 || $cnpj == '00000000000000' || $cnpj == '11111111111111' || $cnpj == '22222222222222' || $cnpj == '33333333333333' || $cnpj == '44444444444444' || $cnpj == '55555555555555' || $cnpj == '66666666666666' || $cnpj == '77777777777777' || $cnpj == '88888888888888' || $cnpj == '99999999999999')
            return false;

        $soma = 0;

        $soma += ($cnpj[0] * 5);
        $soma += ($cnpj[1] * 4);
        $soma += ($cnpj[2] * 3);
        $soma += ($cnpj[3] * 2);
        $soma += ($cnpj[4] * 9);
        $soma += ($cnpj[5] * 8);
        $soma += ($cnpj[6] * 7);
        $soma += ($cnpj[7] * 6);
        $soma += ($cnpj[8] * 5);
        $soma += ($cnpj[9] * 4);
        $soma += ($cnpj[10] * 3);
        $soma += ($cnpj[11] * 2);

        $d1 = $soma % 11;
        $d1 = $d1 < 2 ? 0 : 11 - $d1;

        $soma = 0;
        $soma += ($cnpj[0] * 6);
        $soma += ($cnpj[1] * 5);
        $soma += ($cnpj[2] * 4);
        $soma += ($cnpj[3] * 3);
        $soma += ($cnpj[4] * 2);
        $soma += ($cnpj[5] * 9);
        $soma += ($cnpj[6] * 8);
        $soma += ($cnpj[7] * 7);
        $soma += ($cnpj[8] * 6);
        $soma += ($cnpj[9] * 5);
        $soma += ($cnpj[10] * 4);
        $soma += ($cnpj[11] * 3);
        $soma += ($cnpj[12] * 2);


        $d2 = $soma % 11;
        $d2 = $d2 < 2 ? 0 : 11 - $d2;

        if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Limpa cpf                                                                                   
     */

    public function limpaCpf($cpf) {
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        return $cpf;
    }

    /*
     * Limpa cpf                                                                                   
     */

    public function limpaCnpj($cnpj) {
        $cnpj = str_replace(".", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace("/", "", $cnpj);
        return $cnpj;
    }

    public function formataCpf($cpf) {
        $p1 = substr($cpf, -2);
        $p2 = substr($cpf, -5, 3);
        $p3 = substr($cpf, -8, 3);
        $p4 = substr($cpf, -11, 3);
        $result = "{$p4}.{$p3}.{$p2}-{$p1}";
        return $result;
    }

    public function formataCnpj($cnpj) {
        $p1 = substr($cnpj, -2);
        $p2 = substr($cnpj, -6, 4);
        $p3 = substr($cnpj, -9, 3);
        $p4 = substr($cnpj, -12, 3);
        $p5 = substr($cnpj, -14, 2);
        $result = "{$p5}.{$p4}.{$p3}/{$p2}-{$p1}";
        return $result;
    }
    
    public function adiantaDatas($date, $intervalo, $dia_mes_or_ano) {
        #DAY
        #MONTH
        #YEAR
        $query = "SELECT DATE_ADD(  '{$date}', INTERVAL {$intervalo}  {$dia_mes_or_ano} ) as NEWDTA;";
        $model = new Model();
        
        
        $obj = $model->read_query($query);
        return $obj->NEWDTA;
        
    }
    
    public function getTimestamp() {
        
        $model = new Model();
        return $model->getCurrent_date();
    }

}
