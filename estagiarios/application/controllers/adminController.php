<?php

Class Admin extends Controller {

    public function __construct() {

        $this->get_smarty();
        $this->run();
    }

    public function index() {
        $this->index_action();
    }

    public function index_action() {
        $this->welcome();
    }

    public function sair() {

        session_destroy();
        echo "<script>window.location='/" . LANGUAGE . "/login'</script>";
        exit();
    }

    public function welcome() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {
            $vars = $this->dados();

            $vars["page_reference"] = "welcome";
            $vars["page_internal"] = "";
            $vars["pagina"] = "Área Restrita - Bem-vindo!";

            $this->view("admin/welcome", $vars);
        }
    }

    public function alterar_senha() {
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {
            $vars = $this->dados();

            if ($_POST) {

                $senha_atual = $_POST["senha_atual"];
                $senha_nova = $_POST["senha_nova"];
                $senha_repetir = $_POST["senha_repetir"];

                if ($senha_atual == "") {
                    $vars["erro"] = "Senha atual requerida!";
                } else if ($senha_nova == "") {
                    $vars["erro"] = "Nova senha requerida!";
                } else if ($senha_repetir == "") {
                    $vars["erro"] = "Repetir senha requerida!";
                } else if ($this->senhaMd5($senha_atual) != $_SESSION["SENHA"]) {
                    $vars["erro"] = "Senha atual não confere!";
                } else if ($senha_nova != $senha_repetir) {
                    $vars["erro"] = "Senhas digitadas diferentes!";
                } else {
                    $model = new Admin_Model();
                    if ($model->update_senha($_SESSION["CODCADASTRO"], $this->senhaMd5($senha_nova))) {
                        echo "<script>alert(' Senha atualizada com sucesso, sua sessão será encerrada! ')</script>";
                        $this->sair();
                        exit();
                    }
                }
            }

            $vars["page_reference"] = "alterar-senha";
            $vars["page_internal"] = "";
            $vars["pagina"] = "Área Restrita - Alterar Senha!";

            $this->view("admin/alterar_senha", $vars);
        }
    }

    public function empresas_entidades_lista_estagiarios_session() {
        $model = new Admin_Model();

        $papeis[] = "GESTOR";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();
            $_SESSION["CODEMPRESA_CONFIG"] = strtoupper($arr[0]);

            echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades-lista-estagiarios'</script>";
            exit();
        }
    }

    public function empresas_entidades() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {
            $vars = $this->dados();

            if ($_POST) {
                $vars["search"] = $_POST["search"];
                $search = $_POST["search"];
            } else {
                $search = null;
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "empresas-entidades";
            $vars["page_search"] = true;
            $vars["pagina"] = "Área Restrita - Lista de Empresas/Entidades!";
            $vars["lista_cadastro"] = $model->get_lista_cadastro_entidade($search);

            $this->view("admin/empresas_entidades", $vars);
        }
    }

    public function pdf_relacao_empresas() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {
            $vars = $this->dados();

            if ($_POST) {
                $vars["search"] = $_POST["search"];
                $search = $_POST["search"];
            } else {
                $search = null;
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "empresas-entidades";
            $vars["page_search"] = true;
            $vars["pagina"] = "Área Restrita - Lista de Empresas/Entidades!";
            $vars["lista_cadastro"] = $model->get_lista_cadastro_entidade($search);

            $html = $this->view_pdf("pdf/pdf_relacao_empresas", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            $mpdf->Output();

            exit();
        }
    }

    public function cadastrar_empresa_entidade() {

        $papeis[] = "MASTER";
        $model = new Admin_Model();

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {
            $vars = $this->dados();

            if ($_POST) {

                foreach ($_POST as $nome => $valor) {
                    ( $nome == "email") ? $vars["email_cadastro"] = $valor : $vars[$nome] = $valor;
                }

                $numeros = 0;
                $str = "";

                while ($numeros < 51) {
                    $guid_ddd = "ddd_{$numeros}";
                    $guid_tel = "tel_{$numeros}";
                    $guid_ramal = "ramal_{$numeros}";

                    if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                        ($numeros == 0 ) ? $str .= "<div class='row datagrid'>" : $str .= "<div class='row datagrid'><br/>";
                        $str .= "<div class='col col-sm-2'>";
                        $str .= "<input type='text' class='form-control' id='ddd_{$numeros}' name='ddd_{$numeros}' maxlength='4' value='" . $_POST[$guid_ddd] . "' placeholder='DDD' onkeypress='return formataNumDV(event, this, 2);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-3'>";
                        $str .= "<input type='text' class='form-control' id='tel_{$numeros}' name='tel_{$numeros}' maxlength='10' value='" . $_POST[$guid_tel] . "' placeholder='Telefone ou celular' onkeypress='return formataNumDV(event, this, 9);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-7'>";
                        $str .= "<input type='text' class='form-control' id='ramal_{$numeros}' name='ramal_{$numeros}' maxlength='100' value='" . $_POST[$guid_ramal] . "' placeholder='Informações adicionais'/>    ";
                        $str .= "</div>";
                        $str .= "</div>";
                    }

                    $numeros++;
                }

                $vars["datagrid"] = $str;

                #cadastro
                $dados_cadastro['CODCADASTRO'] = $this->getPrimarykey();
                $dados_cadastro['TIPO_CONTA'] = "pj";
                $dados_cadastro['NOME_RAZAO_SOCIAL'] = trim($this->trata_nome($_POST["nome_empresa"]));

                $iniciais = $this->iniciais($_POST["nome_empresa"]);
                $check = true;

                $i = 1;
                while ($check) {
                    if ($model->existe_iniciais($iniciais . $i)) {
                        $check = true;
                    } else {
                        $iniciais = $iniciais . $i;
                        $check = false;
                    }
                    $i++;
                }

                $dados_cadastro['ID'] = trim($iniciais);
                $dados_cadastro['CPF_CNPJ'] = trim($this->limpaCnpj($_POST["cnpj"]));
                $dados_cadastro['EMAIL'] = trim($_POST["email"]);
                $dados_cadastro['PAPEL'] = "EMPRESA_ENTIDADE;GESTOR;";
                $dados_cadastro['NASCIMENTO_FUNDACAO'] = $_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"];
                $dados_cadastro['STATUS'] = 1;
                $dados_cadastro['OWNER'] = $_SESSION["CODCADASTRO"];

                $site = trim(strtolower($_POST["site"]));
                ( $site == "") ? $validar_site = false : $validar_site = true;

                #endereco
                $dados_endereco['CODENDERECO'] = $this->getPrimarykey();
                $dados_endereco['CEP'] = trim($_POST["cep"]);
                $dados_endereco['LOGRADOURO'] = trim($_POST["logradouro"]);
                $dados_endereco['NUMERO'] = trim($_POST["numero"]);
                $dados_endereco['COMPLEMENTO'] = trim($_POST["complemento"]);
                $dados_endereco['BAIRRO'] = trim($_POST["bairro"]);
                $dados_endereco['CIDADE'] = trim($_POST["cidade"]);
                $dados_endereco['UF'] = trim(mb_strtoupper($_POST["estado"], "UTF-8"));
                $dados_endereco['STATUS'] = 1;

                #endereco relacionado ao cadastro
                $dados_cadastro_rel_endereco['CODENDERECO'] = $dados_endereco['CODENDERECO'];
                $dados_cadastro_rel_endereco['CODCADASTRO'] = $dados_cadastro['CODCADASTRO'];

                if ($dados_cadastro['NOME_RAZAO_SOCIAL'] == "") {
                    $vars["erro"] = "* Nome da Empresa/Entidade requerido";
                } else if (!$this->validaCNPJ($dados_cadastro['CPF_CNPJ'])) {
                    $vars["erro"] = "* CNPJ inválido";
                } /*else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $dados_cadastro['EMAIL'])) {
                    $vars["erro"] = "E-mail inválido";
                } */else if ($model->existe_cadastro($dados_cadastro['CPF_CNPJ'])) {
                    $vars["erro"] = "Empresa já cadastrada!";
                } else if (strlen($_POST["dia"]) != 2) {
                    $vars["erro"] = "* Dia de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["mes"]) != 2) {
                    $vars["erro"] = "* Mês de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["ano"]) != 4) {
                    $vars["erro"] = "* Ano de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["ddd_0"]) != 2 && $_POST["tel_0"] == "") {
                    $vars["erro"] = "* Telefone requerido";
                } else if (strlen($dados_endereco['CEP']) != 9) {
                    $vars["erro"] = "* CEP requerido ou inválido!";
                } else if ($dados_endereco['LOGRADOURO'] == "") {
                    $vars["erro"] = "* Logradouro requerido!";
                } else if ($dados_endereco['NUMERO'] == "") {
                    $vars["erro"] = "* Número requerido!";
                } else if ($dados_endereco['BAIRRO'] == "") {
                    $vars["erro"] = "* Bairro requerido!";
                } else if ($dados_endereco['CIDADE'] == "") {
                    $vars["erro"] = "* Cidade requerida!";
                } else if (strlen($dados_endereco['UF']) != 2) {
                    $vars["erro"] = "* UF requerida ou inválido!";
                }

                if ($validar_site && $vars["erro"] == "") {
                    $dados_cadastro['SITE'] = trim($site);
                    if (!preg_match('/^(https|http)?:\/\/(www\.)?[-a-z0-9+]{2,128}\.[a-z]{2,4}(\.[a-z]{2,4})?(\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*)?$/i', $site)) {
                        $vars["erro"] = "* Site informado inválido!";
                    }
                }

                if ($vars["erro"] == "") {

                    if ($model->insert_cadastro_empresa_entidade($dados_cadastro)) {

                        $model->insert_endereco($dados_endereco);
                        $model->insert_cadastro_rel_endereco($dados_cadastro_rel_endereco);

                        $cadastro_rel_administradores['CODEMPRESA_ENTIDADE'] = $dados_cadastro['CODCADASTRO'];
                        $cadastro_rel_administradores['CODCADASTRO'] = $dados_cadastro['CODCADASTRO'];

                        $model->insert_cadastro_rel_administradores($cadastro_rel_administradores);

                        $numeros = 0;

                        while ($numeros < 51) {

                            $guid_ddd = "ddd_{$numeros}";
                            $guid_tel = "tel_{$numeros}";
                            $guid_ramal = "ramal_{$numeros}";

                            if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                                $dados_cadastro_rel_telefone['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $numeros));
                                $dados_cadastro_rel_telefone['CODCADASTRO'] = $dados_cadastro['CODCADASTRO'];

                                $model->insert_cadastro_rel_telefone($dados_cadastro_rel_telefone);

                                $dados_telefone['CODTELEFONE'] = $dados_cadastro_rel_telefone['CODTELEFONE'];
                                $dados_telefone['DDD'] = $_POST[$guid_ddd];

                                $tel = str_replace("-", "", $_POST[$guid_tel]);
                                $tel = str_replace(".", "", $_POST[$guid_tel]);
                                $dados_telefone['TELEFONE'] = $tel;

                                $dados_telefone['RAMAL'] = $_POST[$guid_ramal];
                                $dados_telefone['STATUS'] = 1;

                                $model->insert_telefone($dados_telefone);
                            }
                            $numeros++;
                        }

                        echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades'</script>";
                        exit();
                    } else {
                        $vars["erro"] = "* Ocorreu um erro inesperado ao tentar realizar este cadastro!";
                    }
                }
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "empresas-entidades";
            $vars["pagina"] = "Área Restrita - Cadastro de Empresas/Entidades!";

            $this->view("admin/empresas_entidades_cadastrar", $vars);
        }
    }

    public function editar_empresa_entidade() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars = $this->dados();

            $arr = $this->array_url();
            $codcadastro = strtoupper($arr[1]);

            if ($_POST) {

                foreach ($_POST as $nome => $valor) {
                    $nome = strtolower($nome);
                    if ($nome != "papel") {
                        ( $nome == "email") ? $vars["email_cadastro"] = $valor : $vars[$nome] = $valor;
                    }
                }

                $numeros = 0;
                $str = "";

                while ($numeros < 51) {
                    $guid_ddd = "ddd_{$numeros}";
                    $guid_tel = "tel_{$numeros}";
                    $guid_ramal = "ramal_{$numeros}";

                    if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                        ($numeros == 0 ) ? $str .= "<br/><div class='row datagrid'>" : $str .= "<div class='row datagrid'>";
                        $str .= "<div class='col col-sm-2'>";
                        $str .= "<input type='text' class='form-control' id='ddd_{$numeros}' name='ddd_{$numeros}' maxlength='4' value='" . $_POST[$guid_ddd] . "' placeholder='DDD' onkeypress='return formataNumDV(event, this, 2);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-3'>";
                        $str .= "<input type='text' class='form-control' id='tel_{$numeros}' name='tel_{$numeros}' maxlength='10' value='" . $_POST[$guid_tel] . "' placeholder='Telefone ou celular' onkeypress='return formataNumDV(event, this, 9);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-7'>";
                        $str .= "<input type='text' class='form-control' id='ramal_{$numeros}' name='ramal_{$numeros}' maxlength='100' value='" . $_POST[$guid_ramal] . "' placeholder='Informações adicionais'/>    ";
                        $str .= "</div>";
                        $str .= "</div>";
                    }

                    $numeros++;
                }

                $vars["datagrid"] = $str;

                #cadastro
                $dados_cadastro['CODCADASTRO'] = $codcadastro;
                $dados_cadastro['TIPO_CONTA'] = "pj";
                $dados_cadastro['NOME_RAZAO_SOCIAL'] = trim($this->trata_nome($_POST["nome_empresa"]));
                $dados_cadastro['EMAIL'] = trim($_POST["email"]);
                $dados_cadastro['NASCIMENTO_FUNDACAO'] = $_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"];

                $site = trim(strtolower($_POST["site"]));
                ( $site == "") ? $validar_site = false : $validar_site = true;

                #endereco
                $dados_endereco['CODENDERECO'] = $this->getPrimarykey();
                $dados_endereco['CEP'] = trim($_POST["cep"]);
                $dados_endereco['LOGRADOURO'] = trim($_POST["logradouro"]);
                $dados_endereco['NUMERO'] = trim($_POST["numero"]);
                $dados_endereco['COMPLEMENTO'] = trim($_POST["complemento"]);
                $dados_endereco['BAIRRO'] = trim($_POST["bairro"]);
                $dados_endereco['CIDADE'] = trim($_POST["cidade"]);
                $dados_endereco['UF'] = trim(mb_strtoupper($_POST["estado"], "UTF-8"));
                $dados_endereco['STATUS'] = 1;

                #endereco relacionado ao cadastro
                $dados_cadastro_rel_endereco['CODENDERECO'] = $dados_endereco['CODENDERECO'];
                $dados_cadastro_rel_endereco['CODCADASTRO'] = $dados_cadastro['CODCADASTRO'];

                if ($dados_cadastro['NOME_RAZAO_SOCIAL'] == "") {
                    $vars["erro"] = "* Nome da Empresa/Entidade requerido";
                } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $dados_cadastro['EMAIL'])) {
                    $vars["erro"] = "E-mail inválido";
                } else if (strlen($_POST["dia"]) != 2) {
                    $vars["erro"] = "* Dia de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["mes"]) != 2) {
                    $vars["erro"] = "* Mês de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["ano"]) != 4) {
                    $vars["erro"] = "* Ano de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["ddd_0"]) != 2 && $_POST["tel_0"] == "") {
                    $vars["erro"] = "* Telefone requerido";
                } else if (strlen($dados_endereco['CEP']) != 9) {
                    $vars["erro"] = "* CEP requerido ou inválido!";
                } else if ($dados_endereco['LOGRADOURO'] == "") {
                    $vars["erro"] = "* Logradouro requerido!";
                } else if ($dados_endereco['NUMERO'] == "") {
                    $vars["erro"] = "* Número requerido!";
                } else if ($dados_endereco['BAIRRO'] == "") {
                    $vars["erro"] = "* Bairro requerido!";
                } else if ($dados_endereco['CIDADE'] == "") {
                    $vars["erro"] = "* Cidade requerida!";
                } else if (strlen($dados_endereco['UF']) != 2) {
                    $vars["erro"] = "* UF requerida ou inválido!";
                }

                if ($validar_site && $vars["erro"] == "") {
                    $dados_cadastro['SITE'] = trim($site);
                    if (!preg_match('/^(https|http)?:\/\/(www\.)?[-a-z0-9+]{2,128}\.[a-z]{2,4}(\.[a-z]{2,4})?(\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*)?$/i', $site)) {
                        $vars["erro"] = "* Site informado inválido!";
                    }
                }

                if ($vars["erro"] == "") {

                    $cadastro_rel_endereco = $model->get_cods_cadastro_rel_endereco($codcadastro);
                    $model->delete_endereco($cadastro_rel_endereco->CODENDERECO);
                    $model->delete_cadastro_rel_endereco($codcadastro);

                    $cadastro_rel_telefone = $model->get_cods_cadastro_rel_telefone($codcadastro);

                    if ($cadastro_rel_telefone) {
                        foreach ($cadastro_rel_telefone as $obj) {
                            $model->delete_telefone($obj->CODTELEFONE);
                        }
                    }
                    $model->delete_cadastro_rel_telefone($codcadastro);

                    if ($model->update_cadastro_empresa_entidade($dados_cadastro, $codcadastro)) {

                        $model->insert_endereco($dados_endereco);
                        $model->insert_cadastro_rel_endereco($dados_cadastro_rel_endereco);

                        $numeros = 0;

                        while ($numeros < 51) {

                            $guid_ddd = "ddd_{$numeros}";
                            $guid_tel = "tel_{$numeros}";
                            $guid_ramal = "ramal_{$numeros}";

                            if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                                $dados_cadastro_rel_telefone['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $numeros));
                                $dados_cadastro_rel_telefone['CODCADASTRO'] = $dados_cadastro['CODCADASTRO'];

                                $model->insert_cadastro_rel_telefone($dados_cadastro_rel_telefone);

                                $dados_telefone['CODTELEFONE'] = $dados_cadastro_rel_telefone['CODTELEFONE'];
                                $dados_telefone['DDD'] = $_POST[$guid_ddd];

                                $tel = str_replace("-", "", $_POST[$guid_tel]);
                                $tel = str_replace(".", "", $_POST[$guid_tel]);
                                $dados_telefone['TELEFONE'] = $tel;

                                $dados_telefone['RAMAL'] = $_POST[$guid_ramal];
                                $dados_telefone['STATUS'] = 1;

                                $model->insert_telefone($dados_telefone);
                            }
                            $numeros++;
                        }

                        echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades'</script>";
                        exit();
                    } else {
                        $vars["erro"] = "* Ocorreu um erro inesperado ao tentar realizar este cadastro!";
                    }
                }
            } else {

                $empresa_entidade = $model->get_cadastro($codcadastro);
                $vars["empresa_entidade"] = $empresa_entidade;


                $vars["dia"] = $empresa_entidade->DIA;
                $vars["mes"] = $empresa_entidade->MES;
                $vars["ano"] = $empresa_entidade->ANO;

                $vars["telefones"] = $model->get_telefones($codcadastro);

                foreach ($model->get_enderecos($codcadastro) as $endereco) {

                    $vars["cep"] = $endereco->CEP;
                    $vars["logradouro"] = $endereco->LOGRADOURO;
                    $vars["numero"] = $endereco->NUMERO;
                    $vars["complemento"] = $endereco->COMPLEMENTO;
                    $vars["estado"] = $endereco->UF;
                    $vars["cidade"] = $endereco->CIDADE;
                    $vars["bairro"] = $endereco->BAIRRO;
                }
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "empresas-entidades";
            $vars["pagina"] = "Área Restrita - Editar Empresa/Entidade!";

            $this->view("admin/empresas_entidades_editar", $vars);
        }
    }

    public function delete_empresa_entidade() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();
            $codcadastro = strtoupper($arr[1]);

            $model->delete_cadastro_entidade($codcadastro);

            $cadastro_rel_endereco = $model->get_cods_cadastro_rel_endereco($codcadastro);
            $model->delete_endereco($cadastro_rel_endereco->CODENDERECO);
            $model->delete_cadastro_rel_endereco($codcadastro);

            $cadastro_rel_telefone = $model->get_cods_cadastro_rel_telefone($codcadastro);

            if ($cadastro_rel_telefone) {
                foreach ($cadastro_rel_telefone as $obj) {
                    $model->delete_telefone($obj->CODTELEFONE);
                }
            }

            $model->delete_cadastro_rel_telefone($codcadastro);
            echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades'</script>";
            exit();
        }
    }

    public function status_estagiario_empresa_entidade() {

        $model = new Admin_Model();
        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();
            $codcadastro = strtoupper($arr[0]);
            (boolean) $status = $arr[1];
            $codempresa_entidade = strtoupper($arr[2]);


            ( $status ) ? $dados["STATUS"] = 0 : $dados["STATUS"] = 1;

            $model->update_cadastro_estagiario_empresa_entidade($dados, $codcadastro, $codempresa_entidade);
            echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades-lista-estagiarios'</script>";
            exit();
        }
    }

    public function status_administrador_empresa_entidade() {

        $model = new Admin_Model();
        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();
            $codcadastro = strtoupper($arr[0]);
            (boolean) $status = $arr[1];
            $codempresa_entidade = strtoupper($arr[2]);

            ( $status ) ? $dados["STATUS"] = 0 : $dados["STATUS"] = 1;

            $model->update_cadastro_administrador_empresa_entidade($dados, $codcadastro, $codempresa_entidade);
            echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades-lista-administradores'</script>";
            exit();
        }
    }

    public function status_dados_complementares() {

        $model = new Admin_Model();
        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();
            $codestagiario = strtoupper($arr[0]);
            (boolean) $status = $arr[1];
            $codempresa = strtoupper($arr[2]);
            $coddadoscomplementares = strtoupper($arr[3]);

            ( $status ) ? $dados["STATUS"] = 0 : $dados["STATUS"] = 1;

            $model->update_dados_complementares($dados, $coddadoscomplementares);
            echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[2]}/'</script>";
            exit();
        }
    }

    public function termo_dados_complementares() {

        $model = new Admin_Model();
        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();
            $codestagiario = strtoupper($arr[0]);
            (boolean) $status = $arr[1];
            $codempresa = strtoupper($arr[2]);
            $coddadoscomplementares = strtoupper($arr[3]);

            ( $status ) ? $dados["TERMO_ENTREGUE"] = 0 : $dados["TERMO_ENTREGUE"] = 1;

            $model->update_dados_complementares($dados, $coddadoscomplementares);
            echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[2]}/'</script>";
            exit();
        }
    }

    public function status_empresa_entidade() {

        $model = new Admin_Model();
        $papeis[] = "MASTER";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();
            $codcadastro = strtoupper($arr[1]);
            (boolean) $status = $arr[3];

            ( $status ) ? $dados["STATUS"] = 0 : $dados["STATUS"] = 1;

            $model->update_cadastro_empresa_entidade($dados, $codcadastro);
            echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades'</script>";
            exit();
        }
    }

    public function adicionar_solicitacao() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars = $this->dados();

            $codcadastro = $_SESSION["CODCADASTRO"];

            $empresa_entidade = $model->get_cadastro($codcadastro);
            $vars["empresa_entidade"] = $empresa_entidade;

            $vars["dia"] = $empresa_entidade->DIA;
            $vars["mes"] = $empresa_entidade->MES;
            $vars["ano"] = $empresa_entidade->ANO;

            $vars["telefones"] = $model->get_telefones($codcadastro);

            foreach ($model->get_enderecos($codcadastro) as $endereco) {

                $vars["cep"] = $endereco->CEP;
                $vars["logradouro"] = $endereco->LOGRADOURO;
                $vars["numero"] = $endereco->NUMERO;
                $vars["complemento"] = $endereco->COMPLEMENTO;
                $vars["estado"] = $endereco->UF;
                $vars["cidade"] = $endereco->CIDADE;
                $vars["bairro"] = $endereco->BAIRRO;
            }

            if ($_POST) {

                $solicitacao['CODSOLICITACAOESTAGIO'] = $this->getPrimarykey();
                $solicitacao['CODCADASTRO'] = $codcadastro;

                $solicitacao['SEXO'] = $view_solicitacao->SEXO = addslashes(trim($_POST["qual_sexo"]));
                $solicitacao['FAIXA_ETARIA_INICIAL'] = $view_solicitacao->FAIXA_ETARIA_INICIAL = addslashes(trim($_POST["idade_inicial"]));
                $solicitacao['FAIXA_ETARIA_FINAL'] = $view_solicitacao->FAIXA_ETARIA_FINAL = addslashes(trim($_POST["idade_final"]));
                $solicitacao['EST_CIVIL'] = $view_solicitacao->EST_CIVIL = addslashes(trim($_POST["estado_civil"]));
                $solicitacao['IS_IDIOMA'] = $view_solicitacao->IS_IDIOMA = addslashes(trim($_POST["open_idioma"]));

                if ($view_solicitacao->IS_IDIOMA == "S") {
                    $i = 0;
                    while ($i < 101) {
                        $key = "idioma_{$i}";
                        if ($_POST[$key] != "") {
                            $idiomas[$i] = addslashes(trim($_POST[$key]));
                        }
                        $i++;
                    }
                }

                $solicitacao['IS_INFORMATICA'] = $view_solicitacao->IS_INFORMATICA = addslashes(trim($_POST["open_informatica"]));

                if ($view_solicitacao->IS_INFORMATICA == "S") {
                    $i = 0;
                    while ($i < 101) {
                        $key = "informatica_{$i}";
                        if ($_POST[$key] != "") {
                            $informaticas[$i] = addslashes(trim($_POST[$key]));
                        }
                        $i++;
                    }
                }

                $i = 0;
                while ($i < 101) {
                    $keyCurso = "curso_{$i}";
                    $keyPeriodo = "periodo_{$i}";
                    $keyNivel = "nivel_{$i}";
                    if ($_POST[$keyCurso] != "") {
                        $cursos[$i] = addslashes(trim($_POST[$keyCurso]));
                        $periodos[$i] = addslashes(trim($_POST[$keyPeriodo]));
                        $niveis[$i] = addslashes(trim($_POST[$keyNivel]));
                    }
                    $i++;
                }

                $solicitacao['DEMAIS_REQUISITOS'] = $view_solicitacao->DEMAIS_REQUISITOS = stripslashes(addslashes(trim($_POST["outros_requisitos"])));
                $solicitacao['DURACAO'] = $view_solicitacao->DURACAO = addslashes(trim($_POST["duracao_estagio"]));
                $solicitacao['HORARIO_DE'] = $view_solicitacao->HORARIO_DE = addslashes(trim($_POST["horario_inicio"]));
                $solicitacao['HORARIO_ATE'] = $view_solicitacao->HORARIO_ATE = addslashes(trim($_POST["horario_fim"]));
                $solicitacao['HORARIO_MES'] = $view_solicitacao->HORARIO_MES = addslashes(trim($_POST["horas_mes"]));
                $solicitacao['EFETIVACAO'] = $view_solicitacao->EFETIVACAO = addslashes(trim($_POST["efetivacao"]));
                $solicitacao['N_VAGAS'] = $view_solicitacao->N_VAGAS = addslashes(trim($_POST["n_vagas"]));
                $solicitacao['BOLSA_AUXILIO'] = $view_solicitacao->BOLSA_AUXILIO = addslashes(trim($_POST["auxilio_bolsa"]));
                $solicitacao['BOLSA_VALOR'] = $view_solicitacao->BOLSA_VALOR = addslashes(trim($_POST["valor_bolsa"]));
                $solicitacao['BOLSA_BENEFICIOS'] = $view_solicitacao->BOLSA_BENEFICIOS = addslashes(trim($_POST["beneficios"]));
                $solicitacao['VALE_REFEICAO'] = $view_solicitacao->VALE_REFEICAO = addslashes(trim($_POST["vale_refeicao"]));
                $solicitacao['VALE_TRANSPORTE'] = $view_solicitacao->VALE_TRANSPORTE = addslashes(trim($_POST["vale_transporte"]));
                $solicitacao['ASS_MEDICA'] = $view_solicitacao->ASS_MEDICA = addslashes(trim($_POST["a_medica"]));

                $enderecos['CODENDERECO'] = $this->getPrimarykey();
                $enderecos['CEP'] = $view_solicitacao->CEP = addslashes(trim($_POST["cep"]));
                $enderecos['LOGRADOURO'] = $view_solicitacao->LOGRADOURO = addslashes(trim($_POST["logradouro"]));
                $enderecos['NUMERO'] = $view_solicitacao->NUMERO = addslashes(trim($_POST["numero"]));
                $enderecos['COMPLEMENTO'] = $view_solicitacao->COMPLEMENTO = addslashes(trim($_POST["complemento"]));
                $enderecos['BAIRRO'] = $view_solicitacao->BAIRRO = addslashes(trim($_POST["bairro"]));
                $enderecos['CIDADE'] = $view_solicitacao->CIDADE = addslashes(trim($_POST["cidade"]));
                $enderecos['UF'] = $view_solicitacao->UF = addslashes(trim($_POST["estado"]));
                $enderecos['STATUS'] = 1;

                $solicitacao['SUPERVISOR_NOME'] = $view_solicitacao->SUPERVISOR_NOME = addslashes(trim($_POST["nome_supervisor"]));
                $solicitacao['SUPERVISOR_CARGO'] = $view_solicitacao->SUPERVISOR_CARGO = addslashes(trim($_POST["cargo_supervisor"]));
                $solicitacao['SUPERVISOR_EMAIL'] = $view_solicitacao->SUPERVISOR_EMAIL = addslashes(trim($_POST["email_supervisor"]));

                $i = 0;
                while ($i < 101) {
                    $keyDDD = "ddd_{$i}";
                    $keyTelefone = "tel_{$i}";
                    $keyRamal = "ramal_{$i}";
                    if ($_POST[$keyDDD] != "" && $_POST[$keyTelefone] != "") {
                        $ddds[$i] = addslashes(trim($_POST[$keyDDD]));
                        $telefoness[$i] = addslashes(trim($_POST[$keyTelefone]));
                        $ramais[$i] = addslashes(trim($_POST[$keyRamal]));
                    }
                    $i++;
                }

                $i = 0;
                while ($i < 101) {
                    $key = "beneficios_{$i}";
                    if ($_POST[$key] != "") {
                        $beneficios[$i] = addslashes(trim($_POST[$key]));
                    }
                    $i++;
                }

                $solicitacao['ATIVIDADES'] = $view_solicitacao->ATIVIDADES = stripslashes(addslashes(trim($_POST["atividades"])));
                $solicitacao['ETAPAS'] = $view_solicitacao->ETAPAS = stripslashes(addslashes(trim($_POST["etapas_seletivas"])));
                $solicitacao['METODO'] = $view_solicitacao->METODO = stripslashes(addslashes(trim($_POST["outros_comentarios"])));

                if (is_array($telefoness)) {
                    $vars["telefoness"] = $telefoness;
                    $vars["ddds"] = $ddds;
                    $vars["ramais"] = $ramais;
                } else {
                    $vars["telefoness"] = false;
                    $vars["ddds"] = false;
                    $vars["ramais"] = false;
                }

                if (is_array($informaticas)) {
                    $vars["informaticas"] = $informaticas;
                } else {
                    $vars["informaticas"] = false;
                }

                if (is_array($idiomas)) {
                    $vars["idiomas"] = $idiomas;
                } else {
                    $vars["idiomas"] = false;
                }

                if (is_array($beneficios)) {
                    $vars["beneficios"] = $beneficios;
                } else {
                    $vars["beneficios"] = false;
                }

                if (is_array($cursos)) {
                    $vars["cursos"] = $cursos;
                    $vars["periodos"] = $periodos;
                    $vars["niveis"] = $niveis;
                } else {
                    $vars["cursos"] = false;
                    $vars["periodos"] = false;
                    $vars["niveis"] = false;
                }


                $vars["solicitacao"] = $view_solicitacao;

                if ($model->insert_solicitacao_estagio($solicitacao)) {

                    if (is_array($cursos)) {
                        for ($i = 0; $i < sizeof($cursos); $i++) {
                            $C['CODCURSO'] = strtoupper(md5($this->getPrimarykey() . $i));
                            $C['CODSOLICITACAOESTAGIO'] = $solicitacao['CODSOLICITACAOESTAGIO'];
                            $C['CURSO'] = $cursos[$i];
                            $C['PERIODO'] = $periodos[$i];
                            $C['GRAU'] = $niveis[$i];
                            $C['ORDEM'] = $i;
                            $model->insert_solicitacao_estagio_and_cursos($C);
                        }
                    }

                    if (is_array($beneficios)) {
                        for ($i = 0; $i < sizeof($beneficios); $i++) {
                            $B['CODBENEFICIO'] = strtoupper(md5($this->getPrimarykey() . $i));
                            $B['CODSOLICITACAOESTAGIO'] = $solicitacao['CODSOLICITACAOESTAGIO'];
                            $B['BENEFICIO'] = $beneficios[$i];
                            $B['ORDEM'] = $i;
                            $model->insert_solicitacao_estagio_and_beneficios($B);
                        }
                    }

                    if (is_array($idiomas)) {
                        for ($i = 0; $i < sizeof($idiomas); $i++) {
                            $I['CODIDIOMA'] = strtoupper(md5($this->getPrimarykey() . $i));
                            $I['CODSOLICITACAOESTAGIO'] = $solicitacao['CODSOLICITACAOESTAGIO'];
                            $I['IDIOMA'] = $beneficios[$i];
                            $I['ORDEM'] = $i;
                            $model->insert_solicitacao_estagio_and_idiomas($I);
                        }
                    }

                    if (is_array($informaticas)) {
                        for ($i = 0; $i < sizeof($informaticas); $i++) {
                            $IN['CODINFORMATICA'] = strtoupper(md5($this->getPrimarykey() . $i));
                            $IN['CODSOLICITACAOESTAGIO'] = $solicitacao['CODSOLICITACAOESTAGIO'];
                            $IN['INFORMATICA'] = $beneficios[$i];
                            $IN['ORDEM'] = $i;
                            $model->insert_solicitacao_estagio_and_informatica($IN);
                        }
                    }

                    #endereco relacionado ao cadastro
                    $solicitacao_estagio_rel_enderecos['CODENDERECO'] = $enderecos['CODENDERECO'];
                    $solicitacao_estagio_rel_enderecos['CODSOLICITACAOESTAGIO'] = $solicitacao['CODSOLICITACAOESTAGIO'];

                    $model->insert_endereco($enderecos);
                    $model->insert_solicitacao_estagio_rel_enderecos($solicitacao_estagio_rel_enderecos);

                    if (is_array($telefoness)) {
                        for ($i = 0; $i < sizeof($telefoness); $i++) {

                            $solicitacao_estagio_rel_telefones['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $i));
                            $solicitacao_estagio_rel_telefones['CODSOLICITACAOESTAGIO'] = $solicitacao['CODSOLICITACAOESTAGIO'];
                            $model->insert_solicitacao_estagio_rel_telefones($solicitacao_estagio_rel_telefones);

                            $dados_telefone['CODTELEFONE'] = $solicitacao_estagio_rel_telefones['CODTELEFONE'];
                            $dados_telefone['DDD'] = $ddds[$i];

                            $tel = str_replace("-", "", $telefoness[$i]);
                            $tel = str_replace(".", "", $telefoness[$i]);
                            $dados_telefone['TELEFONE'] = $tel;

                            $dados_telefone['RAMAL'] = $ramais[$i];
                            $dados_telefone['STATUS'] = 1;

                            $model->insert_telefone($dados_telefone);
                        }
                    }


                    $quebra_linha = "\n";
                    $emailsender = EMAIL_DISPATCHER;
                    $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                    $emaildesitnatario = $_POST["email"];
                    $nomedesitnatario = EMAIL_RH;
                    $comcopia = EMAIL_RH;
                    $assunto = "Serviço de alerta de solicitação de estagiários em " . $this->getTimestamp();
                    $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                    $vars["nome_razao_social"] = $_SESSION["NOME_RAZAO_SOCIAL"];
                    $vars["cnpj"] = $this->formataCnpj($_SESSION["CPF_CNPJ"]);
                    $vars["email"] = $_SESSION["EMAIL"];
                    $vars["site"] = $_SESSION["SITE"];

                    $mensagemHTML = $this->view_email("emails/solicitacao_vagas", $vars);

                    $headers = "MIME-Version: 1.1{$quebra_linha}";
                    $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                    $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "Cc: {$comcopia}{$quebra_linha}";
                    $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "X-Mailer: PHP/" . phpversion();

                    mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);
                    mail("marta@parceriaconsult.com.br", $assunto, $mensagemHTML, $headers, $emailsender);
                    mail("estagio@parceriaconsult.com.br", $assunto, $mensagemHTML, $headers, $emailsender);
                    mail("michel@parceriaconsult.com.br", $assunto, $mensagemHTML, $headers, $emailsender);
                    mail("comercial@parceriaconsult.com.br", $assunto, $mensagemHTML, $headers, $emailsender);

                    echo "<script>window.location='/" . LANGUAGE . "/admin/lista-solicitacoes'</script>";
                    exit();
                }
            }

            $vars["pagina"] = "Área Restrita - Lista de Solicitações!";
            $vars["page"] = "lista-solicitacoes";
            $vars["page_internal"] = "lista-solicitacoes";

            $this->view("admin/lista_solicitacoes_adicionar", $vars);
        }
    }

    public function lista_solicitacoes() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars = $this->dados();

            $codcadastro = $_SESSION["CODCADASTRO"];
            $vars["codempresa"] = $codcadastro;

            if ($_SESSION["PAPEL"] == "MASTER") {
                $solicitacoes = $model->get_solicitacao_estagio();
            } else if ($_SESSION["PAPEL"] == "EMPRESA_ENTIDADE") {
                $solicitacoes = $model->get_solicitacao_estagio($codcadastro);
            }

            if ($solicitacoes) {
                $vars["solicitacoes"] = $solicitacoes;
            }

            $vars["pagina"] = "Área Restrita - Lista de Solicitações!";
            $vars["page"] = "lista-solicitacoes";
            $vars["page_internal"] = "lista-solicitacoes";

            $this->view("admin/lista_solicitacoes", $vars);
        }
    }

    public function delete_solicitacao_estagio() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();

            $codsolicitacaoestagio = strtoupper($arr[0]);
            $vars["codsolicitacaoestagio"] = $arr[0];

            $model->delete_solicitacao_estagio($codsolicitacaoestagio);

            echo "<script>window.location='/" . LANGUAGE . "/admin/lista-solicitacoes'</script>";
            exit();
        }
    }

    public function hide_solicitacao_estagio() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();

            $codsolicitacaoestagio = strtoupper($arr[0]);
            $dados["OCULTAR"] = 1;


            $model->update_solicitacao_estagio($dados, $codsolicitacaoestagio);

            echo "<script>window.location='/" . LANGUAGE . "/admin/lista-solicitacoes'</script>";
            exit();
        }
    }

    public function empresas_entidades_visualizar_cadastro() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars = $this->dados();

            $codcadastro = $_SESSION["CODCADASTRO"];


            if ($_POST) {

                foreach ($_POST as $nome => $valor) {
                    $vars[$nome] = $valor;
                }


                $numeros = 0;
                $str = "";

                while ($numeros < 51) {
                    $guid_ddd = "ddd_{$numeros}";
                    $guid_tel = "tel_{$numeros}";
                    $guid_ramal = "ramal_{$numeros}";

                    if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                        ($numeros == 0 ) ? $str .= "<br/><div class='row datagrid'>" : $str .= "<div class='row datagrid'>";
                        $str .= "<div class='col col-sm-2'>";
                        $str .= "<input type='text' class='form-control' id='ddd_{$numeros}' name='ddd_{$numeros}' maxlength='4' value='" . $_POST[$guid_ddd] . "' placeholder='DDD' onkeypress='return formataNumDV(event, this, 2);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-3'>";
                        $str .= "<input type='text' class='form-control' id='tel_{$numeros}' name='tel_{$numeros}' maxlength='10' value='" . $_POST[$guid_tel] . "' placeholder='Telefone ou celular' onkeypress='return formataNumDV(event, this, 9);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-7'>";
                        $str .= "<input type='text' class='form-control' id='ramal_{$numeros}' name='ramal_{$numeros}' maxlength='100' value='" . $_POST[$guid_ramal] . "' placeholder='Informações adicionais'/>    ";
                        $str .= "</div>";
                        $str .= "</div>";
                    }

                    $numeros++;
                }

                $vars["datagrid"] = $str;

                #cadastro
                $dados_cadastro['CODCADASTRO'] = $codcadastro;
                $dados_cadastro['TIPO_CONTA'] = "pj";
                $dados_cadastro['NOME_RAZAO_SOCIAL'] = $this->trata_nome($_POST["nome_empresa"]);
                $dados_cadastro['NASCIMENTO_FUNDACAO'] = $_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"];

                #endereco
                $dados_endereco['CODENDERECO'] = $this->getPrimarykey();
                $dados_endereco['CEP'] = $_POST["cep"];
                $dados_endereco['LOGRADOURO'] = $_POST["logradouro"];
                $dados_endereco['NUMERO'] = $_POST["numero"];
                $dados_endereco['COMPLEMENTO'] = $_POST["complemento"];
                $dados_endereco['BAIRRO'] = $_POST["bairro"];
                $dados_endereco['CIDADE'] = $_POST["cidade"];
                $dados_endereco['UF'] = strtoupper($_POST["estado"]);
                $dados_endereco['STATUS'] = 1;

                #endereco relacionado ao cadastro
                $dados_cadastro_rel_endereco['CODENDERECO'] = $dados_endereco['CODENDERECO'];
                $dados_cadastro_rel_endereco['CODCADASTRO'] = $dados_cadastro['CODCADASTRO'];

                if ($dados_cadastro['NOME_RAZAO_SOCIAL'] == "") {
                    $vars["erro"] = "* Nome da Empresa/Entidade requerido";
                } else if (strlen($_POST["dia"]) != 2) {
                    $vars["erro"] = "* Dia de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["mes"]) != 2) {
                    $vars["erro"] = "* Mês de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["ano"]) != 4) {
                    $vars["erro"] = "* Ano de Abertura/Fundação requerido ou inválido";
                } else if (strlen($_POST["ddd_0"]) != 2 && $_POST["tel_0"] == "") {
                    $vars["erro"] = "* Telefone requerido";
                } else if (strlen($dados_endereco['CEP']) != 9) {
                    $vars["erro"] = "* CEP requerido ou inválido!";
                } else if ($dados_endereco['LOGRADOURO'] == "") {
                    $vars["erro"] = "* Logradouro requerido!";
                } else if ($dados_endereco['NUMERO'] == "") {
                    $vars["erro"] = "* Número requerido!";
                } else if ($dados_endereco['BAIRRO'] == "") {
                    $vars["erro"] = "* Bairro requerido!";
                } else if ($dados_endereco['CIDADE'] == "") {
                    $vars["erro"] = "* Cidade requerida!";
                } else if (strlen($dados_endereco['UF']) != 2) {
                    $vars["erro"] = "* UF requerida ou inválido!";
                }

                if ($vars["erro"] == "") {

                    $cadastro_rel_endereco = $model->get_cods_cadastro_rel_endereco($codcadastro);
                    $model->delete_endereco($cadastro_rel_endereco->CODENDERECO);
                    $model->delete_cadastro_rel_endereco($codcadastro);

                    $cadastro_rel_telefone = $model->get_cods_cadastro_rel_telefone($codcadastro);

                    if ($cadastro_rel_telefone) {
                        foreach ($cadastro_rel_telefone as $obj) {
                            $model->delete_telefone($obj->CODTELEFONE);
                        }
                    }
                    $model->delete_cadastro_rel_telefone($codcadastro);

                    if ($model->update_cadastro_empresa_entidade($dados_cadastro, $codcadastro)) {

                        $model->insert_endereco($dados_endereco);
                        $model->insert_cadastro_rel_endereco($dados_cadastro_rel_endereco);

                        $numeros = 0;

                        while ($numeros < 51) {

                            $guid_ddd = "ddd_{$numeros}";
                            $guid_tel = "tel_{$numeros}";
                            $guid_ramal = "ramal_{$numeros}";

                            if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                                $dados_cadastro_rel_telefone['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $numeros));
                                $dados_cadastro_rel_telefone['CODCADASTRO'] = $dados_cadastro['CODCADASTRO'];

                                $model->insert_cadastro_rel_telefone($dados_cadastro_rel_telefone);

                                $dados_telefone['CODTELEFONE'] = $dados_cadastro_rel_telefone['CODTELEFONE'];
                                $dados_telefone['DDD'] = $_POST[$guid_ddd];
                                $dados_telefone['TELEFONE'] = $_POST[$guid_tel];
                                $dados_telefone['RAMAL'] = $_POST[$guid_ramal];
                                $dados_telefone['STATUS'] = 1;

                                $model->insert_telefone($dados_telefone);
                            }
                            $numeros++;
                        }

                        echo "<script>alert('" . utf8_decode("Registros atualizados com sucesso!") . "')</script>";
                        echo "<script>window.location='/" . LANGUAGE . "/admin/welcome'</script>";
                        exit();
                    } else {
                        $vars["erro"] = "* Ocorreu um erro inesperado ao tentar realizar este cadastro!";
                    }
                }
            } else {

                $empresa_entidade = $model->get_cadastro($codcadastro);
                $vars["empresa_entidade"] = $empresa_entidade;


                $vars["dia"] = $empresa_entidade->DIA;
                $vars["mes"] = $empresa_entidade->MES;
                $vars["ano"] = $empresa_entidade->ANO;

                $vars["telefones"] = $model->get_telefones($codcadastro);

                foreach ($model->get_enderecos($codcadastro) as $endereco) {

                    $vars["cep"] = $endereco->CEP;
                    $vars["logradouro"] = $endereco->LOGRADOURO;
                    $vars["numero"] = $endereco->NUMERO;
                    $vars["complemento"] = $endereco->COMPLEMENTO;
                    $vars["estado"] = $endereco->UF;
                    $vars["cidade"] = $endereco->CIDADE;
                    $vars["bairro"] = $endereco->BAIRRO;
                }
            }

            $vars["pagina"] = "Área Restrita - Editar Empresa/Entidade!";
            $vars["page"] = "empresas-entidades-visualizar-cadastro";

            $this->view("admin/empresas_entidades_editar", $vars);
        }
    }

    public function empresas_entidades_lista_estagiarios() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["page_search"] = true;
            $vars["pagina"] = "Lista de Estagiarios Empresa/Entidade!";

            if ($_POST["search"] != "") {
                $search = $_POST["search"];
                $vars["search"] = $_POST["search"];
            } else {
                $search = null;
            }

            if ($_SESSION["PAPEL"] == "MASTER") {
                $cadastro = $model->get_lista_cadastro_entidade_estagiarios(null, null, $search);
                $vars["lista_estagiarios"] = $cadastro;
            } else if ($_SESSION["PAPEL"] == "EMPRESA_ENTIDADE") {
                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
                $vars["lista_estagiarios"] = $cadastro;
            } else if ($_SESSION["PAPEL"] == "GESTOR") {
                #$_SESSION["CODEMPRESA_CONFIG"]
                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
                $vars["lista_estagiarios"] = $cadastro;
            } else if ($_SESSION["PAPEL"] == "ESTAGIARIO") {
                #$_SESSION["CODEMPRESA_CONFIG"]
                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
                $vars["lista_estagiarios"] = $cadastro;
            }

            if ($_SESSION["PAPEL"] == "GESTOR") {
                $vars["info_empresa"] = $model->get_cadastro($_SESSION["CODEMPRESA_CONFIG"]);
            } else {
                $vars["info_empresa"] = false;
            }

            $this->view("admin/empresas_entidades_lista_estagiarios", $vars);
        }
    }

    public function pdf_relacao_estagiarios() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["page_search"] = true;
            $vars["pagina"] = "Lista de Estagiarios Empresa/Entidade!";

            if ($_POST["search"] != "") {
                $search = $_POST["search"];
                $vars["search"] = $_POST["search"];
            } else {
                $search = null;
            }

            if ($_SESSION["PAPEL"] == "MASTER") {
                $cadastro = $model->get_lista_cadastro_entidade_estagiarios(null, null, $search);
                $vars["lista_estagiarios"] = $cadastro;
            } else if ($_SESSION["PAPEL"] == "EMPRESA_ENTIDADE") {
                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
                $vars["lista_estagiarios"] = $cadastro;
            } else if ($_SESSION["PAPEL"] == "GESTOR") {
                #$_SESSION["CODEMPRESA_CONFIG"]
                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
                $vars["lista_estagiarios"] = $cadastro;
            } else if ($_SESSION["PAPEL"] == "ESTAGIARIO") {
                #$_SESSION["CODEMPRESA_CONFIG"]
                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
                $vars["lista_estagiarios"] = $cadastro;
            }

            $arr_obj = array();
            if ($vars["lista_estagiarios"]) {
                $i = 1;
                foreach ($vars["lista_estagiarios"] as $obj) {
                    $obj->STG_CODCADASTRO;
                    $obj->ADM_CODCADASTRO;
                    $obj->EMP_CODCADASTRO;

                    $elements = $model->get_dados_complementares($obj->STG_CODCADASTRO, $obj->EMP_CODCADASTRO, null, TRUE);
                    foreach ($elements as $element) {
                        $obj->STG_TERMO_ENTREGUE = $element->TERMO_ENTREGUE;
                    }

                    $arr_obj[] = $obj;
                    $i++;
                }
                $vars["lista_estagiarios"] = $arr_obj;
            }

            if ($_SESSION["PAPEL"] == "GESTOR") {
                $vars["info_empresa"] = $model->get_cadastro($_SESSION["CODEMPRESA_CONFIG"]);
            } else {
                $vars["info_empresa"] = false;
            }

            $html = $this->view_pdf("pdf/pdf_relacao_estagiarios", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            $mpdf->Output();

            exit();
        }
    }

    public function empresas_entidades_lista_administradores() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "administradores-empresas-entidades";
            $vars["page_search"] = true;
            $vars["pagina"] = "Lista de Administradores Empresa/Entidade!";

            if ($_POST["search"] != "") {
                $search = $_POST["search"];
                $vars["search"] = $_POST["search"];
            } else {
                $search = null;
            }

            if ($_SESSION["PAPEL"] == "MASTER") {
                $cadastro = $model->get_lista_cadastro_entidade_administradores(null, $search);
                $vars["lista_cadastro"] = $cadastro;
            } else if ($_SESSION["PAPEL"] == "EMPRESA_ENTIDADE") {
                $cadastro = $model->get_lista_cadastro_entidade_administradores($_SESSION["CODCADASTRO"], $search);
                $vars["lista_cadastro"] = $cadastro;
            }

            $this->view("admin/empresas_entidades_lista_administradores", $vars);
        }
    }

    public function cadastrar_administrador_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {


            $arr = $this->array_url();

            $codcadastro = strtoupper($arr[0]);

            $administrador = $model->get_administrador($codcadastro);
            $vars["administrador"] = $administrador;

            if ($administrador) {
                foreach ($administrador as $nome => $valor) {
                    $nome = strtolower($nome);
                    if ($nome != "papel") {
                        ( $nome == "email") ? $vars["email_cadastro"] = $valor : $vars[$nome] = $valor;
                    }
                }
            }




            $empresa = $model->get_cadastro($administrador->CODEMPRESA_ENTIDADE);
            $vars["empresa"] = $empresa;

            $telefones = $model->get_telefones($administrador->CODCADASTRO);

            if ($telefones) {
                $vars["telefones"] = $telefones;
            }

            $enderecos = $model->get_enderecos($administrador->CODCADASTRO);

            if ($enderecos) {

                foreach ($enderecos as $endereco) {

                    $vars["cep"] = $endereco->CEP;
                    $vars["logradouro"] = $endereco->LOGRADOURO;
                    $vars["numero"] = $endereco->NUMERO;
                    $vars["complemento"] = $endereco->COMPLEMENTO;
                    $vars["estado"] = $endereco->UF;
                    $vars["cidade"] = $endereco->CIDADE;
                    $vars["bairro"] = $endereco->BAIRRO;
                }
            }

            if ($_POST) {

                foreach ($_POST as $nome => $valor) {
                    ( $nome == "email") ? $vars["email_cadastro"] = $valor : $vars[$nome] = $valor;
                }

                if (!substr_count($administrador->PAPEL, 'GESTOR')) {
                    $dados_cadastro['PAPEL'] = "{$administrador->PAPEL}GESTOR;";
                }

                $numeros = 0;
                $str = "";

                while ($numeros < 51) {
                    $guid_ddd = "ddd_{$numeros}";
                    $guid_tel = "tel_{$numeros}";
                    $guid_ramal = "ramal_{$numeros}";

                    if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                        ($numeros == 0 ) ? $str .= "<div class='row datagrid'>" : $str .= "<div class='row datagrid'><br/>";
                        $str .= "<div class='col col-sm-2'>";
                        $str .= "<input type='text' class='form-control' id='ddd_{$numeros}' name='ddd_{$numeros}' maxlength='4' value='" . $_POST[$guid_ddd] . "' placeholder='DDD' onkeypress='return formataNumDV(event, this, 2);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-3'>";
                        $str .= "<input type='text' class='form-control' id='tel_{$numeros}' name='tel_{$numeros}' maxlength='10' value='" . $_POST[$guid_tel] . "' placeholder='Telefone ou celular' onkeypress='return formataNumDV(event, this, 9);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-7'>";
                        $str .= "<input type='text' class='form-control' id='ramal_{$numeros}' name='ramal_{$numeros}' maxlength='100' value='" . $_POST[$guid_ramal] . "' placeholder='Informações adicionais'/>    ";
                        $str .= "</div>";
                        $str .= "</div>";
                    }

                    $numeros++;
                }

                $vars["datagrid"] = $str;

                $dados_cadastro['TIPO_CONTA'] = "pf";
                $dados_cadastro['NOME_RAZAO_SOCIAL'] = trim($this->trata_nome($_POST["nome_empresa"]));
                $dados_cadastro['EMAIL'] = $_POST["email"];
                $dados_cadastro['NASCIMENTO_FUNDACAO'] = $_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"];
                $dados_cadastro['STATUS'] = 1;
                $dados_cadastro['SEXO'] = $_POST["sexo"];
                $dados_cadastro['CARGO'] = $_POST["cargo"];

                #endereco
                $dados_endereco['CODENDERECO'] = $this->getPrimarykey();
                $dados_endereco['CEP'] = trim($_POST["cep"]);
                $dados_endereco['LOGRADOURO'] = trim($_POST["logradouro"]);
                $dados_endereco['NUMERO'] = trim($_POST["numero"]);
                $dados_endereco['COMPLEMENTO'] = trim($_POST["complemento"]);
                $dados_endereco['BAIRRO'] = trim($_POST["bairro"]);
                $dados_endereco['CIDADE'] = trim($_POST["cidade"]);
                $dados_endereco['UF'] = trim(strtoupper($_POST["estado"]));
                $dados_endereco['STATUS'] = 1;

                #endereco relacionado ao cadastro
                $dados_cadastro_rel_endereco['CODENDERECO'] = $dados_endereco['CODENDERECO'];
                $dados_cadastro_rel_endereco['CODCADASTRO'] = $codcadastro;

                if ($dados_cadastro['NOME_RAZAO_SOCIAL'] == "") {
                    $vars["erro"] = "* <b>Nome</b> do Administrador requerido";
                } /*else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $dados_cadastro['EMAIL'])) {
                    $vars["erro"] = "<b>E-mail</b> inválido";
                } */else if (strlen($_POST["dia"]) != 2) {
                    $vars["erro"] = "* <b>Dia do nascimento</b> requerido ou inválido";
                } else if (strlen($_POST["mes"]) != 2) {
                    $vars["erro"] = "* <b>Mês do nascimento</b> requerido ou inválido";
                } else if (strlen($_POST["ano"]) != 4) {
                    $vars["erro"] = "* <b>Ano do nascimento</b> requerido ou inválido";
                } else if (strlen($dados_cadastro['CARGO']) == "") {
                    $vars["erro"] = "* <b>Cargo</b> requerido!";
                } else if (strlen($_POST["ddd_0"]) != 2 && $_POST["tel_0"] == "") {
                    $vars["erro"] = "* <b>Telefone</b> requerido";
                } /* else if (strlen($dados_endereco['CEP']) != 9) {
                  $vars["erro"] = "* <b>CEP</b> requerido ou inválido!";
                  } else if ($dados_endereco['LOGRADOURO'] == "") {
                  $vars["erro"] = "* <b>Logradouro</b> requerido!";
                  } else if ($dados_endereco['NUMERO'] == "") {
                  $vars["erro"] = "* <b>Número</b> requerido!";
                  } else if ($dados_endereco['BAIRRO'] == "") {
                  $vars["erro"] = "* <b>Bairro</b> requerido!";
                  } else if ($dados_endereco['CIDADE'] == "") {
                  $vars["erro"] = "* <b>Cidade</b> requerida!";
                  } else if (strlen($dados_endereco['UF']) != 2) {
                  $vars["erro"] = "* <b>UF</b> requerida ou inválido!";
                  } */

                $test_id = $model->get_cadastro($codcadastro);

                if ($test_id) {
                    if ($test_id->ID == "") {


                        $iniciais = $this->iniciais($_POST["nome_empresa"]);
                        $check = true;

                        $i = 1;
                        while ($check) {
                            if ($model->existe_iniciais($iniciais . $i)) {
                                $check = true;
                            } else {
                                $iniciais = $iniciais . $i;
                                $check = false;
                            }
                            $i++;
                        }

                        $dados_cadastro['ID'] = trim($iniciais);
                    }
                }

                if ($vars["erro"] == "") {

                    $cadastro_rel_endereco = $model->get_cods_cadastro_rel_endereco($codcadastro);
                    $model->delete_endereco($cadastro_rel_endereco->CODENDERECO);
                    $model->delete_cadastro_rel_endereco($codcadastro);

                    $cadastro_rel_telefone = $model->get_cods_cadastro_rel_telefone($codcadastro);

                    if ($cadastro_rel_telefone) {
                        foreach ($cadastro_rel_telefone as $obj) {
                            $model->delete_telefone($obj->CODTELEFONE);
                        }
                    }
                    $model->delete_cadastro_rel_telefone($codcadastro);

                    if ($model->update_cadastro_empresa_entidade($dados_cadastro, $codcadastro)) {

                        $model->insert_endereco($dados_endereco);
                        $model->insert_cadastro_rel_endereco($dados_cadastro_rel_endereco);

                        $numeros = 0;

                        while ($numeros < 51) {

                            $guid_ddd = "ddd_{$numeros}";
                            $guid_tel = "tel_{$numeros}";
                            $guid_ramal = "ramal_{$numeros}";

                            if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                                $dados_cadastro_rel_telefone['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $numeros));
                                $dados_cadastro_rel_telefone['CODCADASTRO'] = $codcadastro;

                                $model->insert_cadastro_rel_telefone($dados_cadastro_rel_telefone);

                                $dados_telefone['CODTELEFONE'] = $dados_cadastro_rel_telefone['CODTELEFONE'];
                                $dados_telefone['DDD'] = $_POST[$guid_ddd];

                                $tel = str_replace("-", "", $_POST[$guid_tel]);
                                $tel = str_replace(".", "", $_POST[$guid_tel]);
                                $dados_telefone['TELEFONE'] = $tel;

                                $dados_telefone['RAMAL'] = $_POST[$guid_ramal];
                                $dados_telefone['STATUS'] = 1;

                                $model->insert_telefone($dados_telefone);
                            }
                            $numeros++;
                        }

                        $quebra_linha = "\n";
                        $emailsender = EMAIL_DISPATCHER;
                        $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                        $emaildesitnatario = $_POST["email"];
                        $nomedesitnatario = EMAIL_RH;
                        $comcopia = EMAIL_RH;
                        $assunto = "Serviço de alerta de atualização de ficha de administrador em " . $this->getTimestamp();
                        $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                        foreach ($model->get_cadastro($codcadastro) as $nm => $vl) {
                            $vars[strtolower($nm)] = $vl;
                        }
                        $vars["gettimestamp"] = $this->getTimestamp();

                        $mensagemHTML = $this->view_email("emails/update_administrador", $vars);

                        $headers = "MIME-Version: 1.1{$quebra_linha}";
                        $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                        $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "Cc: {$comcopia}{$quebra_linha}";
                        $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "X-Mailer: PHP/" . phpversion();

                        mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);

//                        echo "<script>alert('* Administrador criado com sucesso!')</script>";
                        echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades-lista-administradores/'</script>";
                        exit();
                    } else {
                        $vars["erro"] = "* Ocorreu um erro inesperado ao tentar realizar este cadastro!";
                    }
                }
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "administradores-empresas-entidades";
            $vars["pagina"] = "Cadastro de Administradores Empresas/Entidades!";

            $this->view("admin/empresa_entidade_cadastrar_administrador_continue", $vars);
        }
    }

    public function cadastrar_estagiario_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {


            $arr = $this->array_url();

            $codcadastro = strtoupper($arr[0]);
            $empresa_ativa = strtoupper($arr[1]);

            if ($_SESSION["PAPEL"] == "GESTOR") {
                $codadministrador = $_SESSION["CODCADASTRO"];
            } else {
                $codadministrador = $_POST["codadministrador"];
            }

            $estagiario = $model->get_estagiario($codcadastro, $empresa_ativa);
            $vars["meu_administrador"] = $estagiario->CODADMINISTRADOR;

            $vars["bancos"] = $model->get_bancos();

            if ($estagiario) {

                foreach ($estagiario as $nome => $valor) {
                    $nome = strtolower($nome);
                    if ($nome != "papel") {
                        ( $nome == "email") ? $vars["email_cadastro"] = $valor : $vars[$nome] = $valor;
                    }
                }
            }

            $empresa = $model->get_cadastro($estagiario->CODEMPRESA_ENTIDADE);
            $vars["empresa"] = $empresa;

            $telefones = $model->get_telefones($estagiario->CODCADASTRO);

            if ($telefones) {
                $vars["telefones"] = $telefones;
            }

            $enderecos = $model->get_enderecos($estagiario->CODCADASTRO);

            if ($enderecos) {

                foreach ($enderecos as $endereco) {

                    $vars["cep"] = $endereco->CEP;
                    $vars["logradouro"] = $endereco->LOGRADOURO;
                    $vars["numero"] = $endereco->NUMERO;
                    $vars["complemento"] = $endereco->COMPLEMENTO;
                    $vars["estado"] = $endereco->UF;
                    $vars["cidade"] = $endereco->CIDADE;
                    $vars["bairro"] = $endereco->BAIRRO;
                }
            }

            if ($model->existe_conta_bancaria($codcadastro)) {
                $cb = $model->get_conta_bancaria($codcadastro);
                $vars["conta_bancaria_atual"] = $cb;

                $vars["agencia"] = $cb->AGECIA;
                $vars["agencia_digito"] = $cb->AGECIA_DIGITO;
                $vars["cc"] = $cb->CC;
            }

            if ($_POST) {

                foreach ($_POST as $nome => $valor) {
                    ( $nome == "email") ? $vars["email_cadastro"] = $valor : $vars[$nome] = $valor;
                }

                if (!substr_count($estagiario->PAPEL, 'ESTAGIARIO')) {
                    $dados_cadastro['PAPEL'] = "{$estagiario->PAPEL}ESTAGIARIO;";
                }

                $numeros = 0;
                $str = "";

                while ($numeros < 51) {
                    $guid_ddd = "ddd_{$numeros}";
                    $guid_tel = "tel_{$numeros}";
                    $guid_ramal = "ramal_{$numeros}";

                    if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                        ($numeros == 0 ) ? $str .= "<div class='row datagrid'>" : $str .= "<div class='row datagrid'><br/>";
                        $str .= "<div class='col col-sm-2'>";
                        $str .= "<input type='text' class='form-control' id='ddd_{$numeros}' name='ddd_{$numeros}' maxlength='4' value='" . $_POST[$guid_ddd] . "' placeholder='DDD' onkeypress='return formataNumDV(event, this, 2);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-3'>";
                        $str .= "<input type='text' class='form-control' id='tel_{$numeros}' name='tel_{$numeros}' maxlength='10' value='" . $_POST[$guid_tel] . "' placeholder='Telefone ou celular' onkeypress='return formataNumDV(event, this, 9);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-7'>";
                        $str .= "<input type='text' class='form-control' id='ramal_{$numeros}' name='ramal_{$numeros}' maxlength='100' value='" . $_POST[$guid_ramal] . "' placeholder='Informações adicionais'/>    ";
                        $str .= "</div>";
                        $str .= "</div>";
                    }

                    $numeros++;
                }

                $vars["datagrid"] = $str;

                $dados_cadastro['TIPO_CONTA'] = "pf";
                $dados_cadastro['NOME_RAZAO_SOCIAL'] = $this->trata_nome($_POST["nome_empresa"]);
                $dados_cadastro['EMAIL'] = $_POST["email"];
                $dados_cadastro['NASCIMENTO_FUNDACAO'] = $_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"];
                $dados_cadastro['STATUS'] = 1;
                $dados_cadastro['SEXO'] = $_POST["sexo"];

                #endereco
                $dados_endereco['CODENDERECO'] = $this->getPrimarykey();
                $dados_endereco['CEP'] = $_POST["cep"];
                $dados_endereco['LOGRADOURO'] = $_POST["logradouro"];
                $dados_endereco['NUMERO'] = $_POST["numero"];
                $dados_endereco['COMPLEMENTO'] = $_POST["complemento"];
                $dados_endereco['BAIRRO'] = $_POST["bairro"];
                $dados_endereco['CIDADE'] = $_POST["cidade"];
                $dados_endereco['UF'] = strtoupper($_POST["estado"]);
                $dados_endereco['STATUS'] = 1;

                #endereco relacionado ao cadastro
                $dados_cadastro_rel_endereco['CODENDERECO'] = $dados_endereco['CODENDERECO'];
                $dados_cadastro_rel_endereco['CODCADASTRO'] = $codcadastro;

                #dados bancarios
                $codbanco = $_POST["codbanco"];
                $agencia = $_POST["agencia"];
                $agencia_digito = $_POST["agencia_digito"];
                $cc = $_POST["cc"];

                if ($dados_cadastro['NOME_RAZAO_SOCIAL'] == "") {
                    $vars["erro"] = "* Nome <strong>estagiário</strong> requerido";
                } else if (strlen($codadministrador) != 32) {
                    $vars["erro"] = "* Para atualizar <strong>Estagiário</strong> é necessário indicar um Responsável pela ficha!";
                } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $dados_cadastro['EMAIL'])) {
                    $vars["erro"] = "* <strong>E-mail</strong> inválido!";
                } else if (strlen($_POST["dia"]) != 2) {
                    $vars["erro"] = "* <strong>Dia do nascimento</strong> requerido ou inválido!";
                } else if (strlen($_POST["mes"]) != 2) {
                    $vars["erro"] = "* <strong>Mês do nascimento</strong> requerido ou inválido!";
                } else if (strlen($_POST["ano"]) != 4) {
                    $vars["erro"] = "* <strong>Ano do nascimento</strong> requerido ou inválido!";
                } else if (strlen($_POST["ddd_0"]) != 2 && $_POST["tel_0"] == "") {
                    $vars["erro"] = "* <strong>Telefone</strong> requerido!";
                } /* else if ($codbanco == "") {
                  $vars["erro"] = "* <strong>Banco</strong> requerido!";
                  } else if ($agencia == "") {
                  $vars["erro"] = "* <strong>Agência</strong> requerida!";
                  } else if ($cc == "") {
                  $vars["erro"] = "* <strong>Conta corrente</strong> requerida!";
                  } */ else if (strlen($dados_endereco['CEP']) != 9) {
                    $vars["erro"] = "* <strong>CEP</strong> requerido ou inválido!";
                } else if ($dados_endereco['LOGRADOURO'] == "") {
                    $vars["erro"] = "* <strong>Logradouro</strong> requerido!";
                } else if ($dados_endereco['NUMERO'] == "") {
                    $vars["erro"] = "* <strong>Número</strong>strong> requerido!";
                } else if ($dados_endereco['BAIRRO'] == "") {
                    $vars["erro"] = "* <strong>Bairro</strong> requerido!";
                } else if ($dados_endereco['CIDADE'] == "") {
                    $vars["erro"] = "* <strong>Cidade</strong> requerida!";
                } else if (strlen($dados_endereco['UF']) != 2) {
                    $vars["erro"] = "* <strong>UF</strong> requerida ou inválido!";
                }

                $test_id = $model->get_cadastro($codcadastro);

                if ($test_id) {
                    if ($test_id->ID == "") {


                        $iniciais = $this->iniciais($_POST["nome_empresa"]);
                        $check = true;

                        $i = 1;
                        while ($check) {
                            if ($model->existe_iniciais($iniciais . $i)) {
                                $check = true;
                            } else {
                                $iniciais = $iniciais . $i;
                                $check = false;
                            }
                            $i++;
                        }

                        $dados_cadastro['ID'] = trim($iniciais);
                    }
                }

                if ($vars["erro"] == "") {

                    $cadastro_rel_endereco = $model->get_cods_cadastro_rel_endereco($codcadastro);
                    $model->delete_endereco($cadastro_rel_endereco->CODENDERECO);
                    $model->delete_cadastro_rel_endereco($codcadastro);

                    $cadastro_rel_telefone = $model->get_cods_cadastro_rel_telefone($codcadastro);

                    if ($cadastro_rel_telefone) {
                        foreach ($cadastro_rel_telefone as $obj) {
                            $model->delete_telefone($obj->CODTELEFONE);
                        }
                    }
                    $model->delete_cadastro_rel_telefone($codcadastro);

                    if ($model->update_cadastro_empresa_entidade($dados_cadastro, $codcadastro)) {

                        $model->insert_endereco($dados_endereco);
                        $model->insert_cadastro_rel_endereco($dados_cadastro_rel_endereco);

                        $model->update_cadastro_estagiario_rel_administrador($codadministrador, $codcadastro, $empresa_ativa);

                        if ($model->existe_conta_bancaria($codcadastro)) {
                            $conta_bancaria_atual = $model->get_conta_bancaria($codcadastro);
                            $model->delete_conta_bancaria($conta_bancaria_atual->CODCONTA);
                            $model->delete_cadastro_rel_conta_bancaria($conta_bancaria_atual->CODCONTA, $conta_bancaria_atual->CODCADASTRO);
                        }

                        $conta_bancaria["CODCONTA"] = $this->getPrimarykey();
                        $conta_bancaria["CODBANCO"] = (int) $codbanco;
                        $conta_bancaria["AGECIA"] = $agencia;
                        $conta_bancaria["AGECIA_DIGITO"] = $agencia_digito;
                        $conta_bancaria["CC"] = $cc;
                        $conta_bancaria["STATUS"] = 1;

                        $cadastro_rel_conta_bancaria["CODCONTA"] = $conta_bancaria["CODCONTA"];
                        $cadastro_rel_conta_bancaria["CODCADASTRO"] = $codcadastro;

                        $model->insert_conta_bancaria($conta_bancaria);
                        $model->insert_cadastro_rel_conta_bancaria($cadastro_rel_conta_bancaria);

                        $numeros = 0;

                        while ($numeros < 51) {

                            $guid_ddd = "ddd_{$numeros}";
                            $guid_tel = "tel_{$numeros}";
                            $guid_ramal = "ramal_{$numeros}";

                            if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                                $dados_cadastro_rel_telefone['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $numeros));
                                $dados_cadastro_rel_telefone['CODCADASTRO'] = $codcadastro;

                                $model->insert_cadastro_rel_telefone($dados_cadastro_rel_telefone);

                                $dados_telefone['CODTELEFONE'] = $dados_cadastro_rel_telefone['CODTELEFONE'];
                                $dados_telefone['DDD'] = $_POST[$guid_ddd];

                                $tel = str_replace("-", "", $_POST[$guid_tel]);
                                $tel = str_replace(".", "", $_POST[$guid_tel]);
                                $dados_telefone['TELEFONE'] = $tel;

                                $dados_telefone['RAMAL'] = $_POST[$guid_ramal];
                                $dados_telefone['STATUS'] = 1;

                                $model->insert_telefone($dados_telefone);
                            }
                            $numeros++;
                        }

                        $quebra_linha = "\n";
                        $emailsender = EMAIL_DISPATCHER;
                        $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                        $emaildesitnatario = $_POST["email"];
                        $nomedesitnatario = EMAIL_RH;
                        $comcopia = EMAIL_RH;
                        $assunto = "Serviço de alerta de atualização de ficha de estagiário em " . $this->getTimestamp();
                        $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                        foreach ($model->get_cadastro($codcadastro) as $nm => $vl) {
                            $vars[strtolower($nm)] = $vl;
                        }
                        $vars["gettimestamp"] = $this->getTimestamp();

                        $mensagemHTML = $this->view_email("emails/update_estagiario", $vars);

                        $headers = "MIME-Version: 1.1{$quebra_linha}";
                        $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                        $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "Cc: {$comcopia}{$quebra_linha}";
                        $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "X-Mailer: PHP/" . phpversion();

                        mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);

                        echo "<script>window.location='/" . LANGUAGE . "/admin/empresas-entidades-lista-estagiarios/'</script>";
                        exit();
                    } else {
                        $vars["erro"] = "* Ocorreu um erro inesperado ao tentar realizar este cadastro!";
                    }
                }
            }

            if ($_SESSION["PAPEL"] == "GESTOR") {
                $vars["info_empresa"] = $model->get_cadastro($_SESSION["CODEMPRESA_CONFIG"]);
            } else {
                $vars["info_empresa"] = false;
            }

            $vars["administradores"] = $model->get_administradores_empresa_entidade($estagiario->CODEMPRESA_ENTIDADE);
            $vars["codigo_administrador_atual"] = $estagiario->CODEMPRESA_ENTIDADE;

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Administradores Empresas/Entidades!";

            $this->view("admin/empresa_entidade_cadastrar_estagiario_continue", $vars);
        }
    }

    public function indicar_administrador_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        $vars["empresas_ativas"] = $model->get_lista_cadastro_ativas();

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            if ($_POST) {


                $empresa_ativa = strtoupper($_POST["empresa_ativa"]);
                $cpf = $this->limpaCpf($_POST["cpf"]);

                if ($empresa_ativa == "") {
                    $vars["erro"] = "* <strong>Empresa/Entidade</strong> requerida!";
                } else if (!$this->validaCPF($cpf)) {
                    $vars["erro"] = "* <strong>CPF</strong> requerida!";
                } else if ($model->existe_administrador_rel_empresa($cpf, $empresa_ativa)) {
                    $vars["erro"] = "* <strong>Administrador</strong> já cadastrado a esta empresa!";
                }

                foreach ($_POST as $nome => $valor) {
                    $vars[$nome] = $valor;
                }

                if ($vars["erro"] == "") {

                    if ($model->existe_cadastro($cpf)) {

                        $cadastro = $model->get_cadastro($cpf);
                        #administrador relacionado ao empresa
                        $cadastro_rel_administradores['CODEMPRESA_ENTIDADE'] = $empresa_ativa;
                        $cadastro_rel_administradores['CODCADASTRO'] = $cadastro->CODCADASTRO;

                        $model->insert_cadastro_rel_administradores($cadastro_rel_administradores);

                        echo "<script>window.location='/" . LANGUAGE . "/admin/cadastrar-administrador-empresa-entidade/" . strtolower($cadastro->CODCADASTRO) . "'</script>";
                        exit();
                    } else {

                        $cadastro["CODCADASTRO"] = $this->getPrimarykey();
                        $cadastro["CPF_CNPJ"] = $cpf;
                        $cadastro['OWNER'] = $empresa_ativa;

                        if ($model->insert_cadastro_pf_short($cadastro)) {

                            #administrador relacionado ao empresa
                            $cadastro_rel_administradores['CODEMPRESA_ENTIDADE'] = $empresa_ativa;
                            $cadastro_rel_administradores['CODCADASTRO'] = $cadastro["CODCADASTRO"];

                            $model->insert_cadastro_rel_administradores($cadastro_rel_administradores);


                            $quebra_linha = "\n";
                            $emailsender = EMAIL_DISPATCHER;
                            $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                            $emaildesitnatario = $_POST["email"];
                            $nomedesitnatario = EMAIL_RH;
                            $comcopia = EMAIL_RH;
                            $assunto = "Serviço de alerta de cadastro de novo administrador em " . $this->getTimestamp();
                            $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                            $vars["nome_razao_social"] = $_SESSION["NOME_RAZAO_SOCIAL"];
                            $vars["cnpj"] = $this->formataCnpj($_SESSION["CPF_CNPJ"]);
                            $vars["email"] = $_SESSION["EMAIL"];
                            $vars["site"] = $_SESSION["SITE"];
                            $vars["cpf"] = $this->formataCpf($cpf);

                            $mensagemHTML = $this->view_email("emails/cadastro_administrador", $vars);

                            $headers = "MIME-Version: 1.1{$quebra_linha}";
                            $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                            $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                            $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                            $headers .= "Cc: {$comcopia}{$quebra_linha}";
                            $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                            $headers .= "X-Mailer: PHP/" . phpversion();

                            mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);

                            echo "<script>window.location='/" . LANGUAGE . "/admin/cadastrar-administrador-empresa-entidade/" . strtolower($cadastro["CODCADASTRO"]) . "'</script>";
                            exit();
                        } else {
                            $vars["erro"] = "* <strong>Falha</strong> ao tentar realizar este cadastro!";
                        }
                    }
                }
            }


            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "administradores-empresas-entidades";
            $vars["pagina"] = "Cadastro de Administradores Empresas/Entidades!";

            $this->view("admin/empresa_entidade_cadastrar_administrador", $vars);
        }
    }

    public function adicionar_estagiario_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";

        if ($_SESSION["PAPEL"] == "GESTOR") {
            $vars["empresas_ativas"] = $model->get_lista_cadastro_ativas($_SESSION["CODCADASTRO"]);
        } else {
            $vars["empresas_ativas"] = $model->get_lista_cadastro_ativas();
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            if ($_POST) {

                $empresa_ativa = strtoupper($_POST["empresa_ativa"]);
                $cpf = $this->limpaCpf($_POST["cpf"]);
                $codadministrador = strtoupper($_POST["codadministrador"]);


                if ($empresa_ativa == "") {
                    $vars["erro"] = "* <strong>Empresa/Entidade</strong> requerida!";
                } else if (strlen($codadministrador) != 32) {
                    $vars["erro"] = "* Para cadastrar um <strong>Estagiário</strong> é necessário indicar um responsável pela ficha!";
                } else if (!$this->validaCPF($cpf)) {
                    $vars["erro"] = "* <strong>CPF</strong> requerida!";
                } else if ($model->existe_estagiario_rel_empresa($cpf, $empresa_ativa)) {
                    $vars["erro"] = "* <strong>Estagiário</strong> já cadastrado a esta empresa!";
                }

                foreach ($_POST as $nome => $valor) {
                    $vars[$nome] = $valor;
                }

                if ($vars["erro"] == "") {

                    if ($model->existe_cadastro($cpf)) {

                        $cadastro = $model->get_cadastro($cpf);

                        #administrador relacionado ao empresa
                        $estagiarios_rel_empresas['CODEMPRESA_ENTIDADE'] = $empresa_ativa;
                        $estagiarios_rel_empresas['CODCADASTRO'] = $cadastro->CODCADASTRO;

                        $model->insert_estagiarios_rel_empresas($estagiarios_rel_empresas);


                        $estagiarios_rel_administradores['CODADMINISTRADOR'] = $codadministrador;
                        $estagiarios_rel_administradores['CODCADASTRO'] = $cadastro->CODCADASTRO;

                        $model->insert_estagiarios_rel_administradores($estagiarios_rel_administradores);

                        echo "<script>window.location='/" . LANGUAGE . "/admin/cadastrar-estagiario-empresa-entidade/" . strtolower($cadastro->CODCADASTRO) . "/" . strtolower($empresa_ativa) . "'</script>";
                        exit();
                    } else {

                        $cadastro["CODCADASTRO"] = $this->getPrimarykey();
                        $cadastro["CPF_CNPJ"] = $cpf;
                        $cadastro["OWNER"] = $_SESSION["CODCADASTRO"];

                        if ($model->insert_cadastro_pf_short($cadastro)) {

                            #administrador relacionado ao empresa
                            $estagiarios_rel_empresas['CODEMPRESA_ENTIDADE'] = $empresa_ativa;
                            $estagiarios_rel_empresas['CODCADASTRO'] = $cadastro["CODCADASTRO"];

                            $model->insert_estagiarios_rel_empresas($estagiarios_rel_empresas);

                            $estagiarios_rel_administradores['CODADMINISTRADOR'] = $codadministrador;
                            $estagiarios_rel_administradores['CODCADASTRO'] = $cadastro["CODCADASTRO"];

                            $model->insert_estagiarios_rel_administradores($estagiarios_rel_administradores);

                            $quebra_linha = "\n";
                            $emailsender = EMAIL_DISPATCHER;
                            $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                            $emaildesitnatario = $_POST["email"];
                            $nomedesitnatario = EMAIL_RH;
                            $comcopia = EMAIL_RH;
                            $assunto = "Serviço de alerta de cadastro de novo estagiário em " . $this->getTimestamp();
                            $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                            $vars["cpf"] = $this->formataCpf($cpf);

                            $mensagemHTML = $this->view_email("emails/novo_estagiario", $vars);

                            $headers = "MIME-Version: 1.1{$quebra_linha}";
                            $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                            $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                            $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                            $headers .= "Cc: {$comcopia}{$quebra_linha}";
                            $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                            $headers .= "X-Mailer: PHP/" . phpversion();

                            mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);

                            echo "<script>window.location='/" . LANGUAGE . "/admin/cadastrar-estagiario-empresa-entidade/" . strtolower($cadastro["CODCADASTRO"]) . "/" . strtolower($empresa_ativa) . "'</script>";
                            exit();
                        } else {
                            $vars["erro"] = "* <strong>Falha</strong> ao tentar realizar este cadastro!";
                        }
                    }
                }
            }

            if ($_SESSION["PAPEL"] == "EMPRESA_ENTIDADE") {

                $vars["info_empresa"] = $model->get_cadastro($_SESSION["CODEMPRESA_CONFIG"]);
                $vars["administradores_empresa"] = $model->get_administradores_empresa_entidade($_SESSION["CODCADASTRO"]);
            } else if ($_SESSION["PAPEL"] == "GESTOR") {
                $vars["info_empresa"] = $model->get_cadastro($_SESSION["CODEMPRESA_CONFIG"]);
            } else {
                $vars["info_empresa"] = false;
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/empresa_entidade_cadastrar_estagiarios", $vars);
        }
    }

    public function lista_dados_complementares_estagiario_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];

        $vars["dados_complementares"] = $model->get_dados_complementares($codestagiario, $codempresa, null, FALSE);

        $vars["qntdd_dados_complementares"] = (int) $model->qntdd_dados_complementares($codestagiario, $codempresa, null);

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/empresa_entidade_lista_dados_complementares", $vars);
        }
    }

    public function delete_dados_complementares() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $model->delete_dados_complementares($coddadoscomplementares);
        echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[1]}/'</script>";
        exit();

    }

    public function editar_dados_complementares_estagiario_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];

        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);

        var_dump($dc); die();
        
        if ($dc) {
            foreach ($dc as $obj) {
                $vars["dados_complementares"] = $obj;
            }
        }


        foreach ($model->get_enderecos_instituicao($coddadoscomplementares) as $endereco) {

            $vars["cep"] = $endereco->CEP;
            $vars["logradouro"] = $endereco->LOGRADOURO;
            $vars["numero"] = $endereco->NUMERO;
            $vars["complemento"] = $endereco->COMPLEMENTO;
            $vars["estado"] = $endereco->UF;
            $vars["cidade"] = $endereco->CIDADE;
            $vars["bairro"] = $endereco->BAIRRO;
        }



        $vars["telefones"] = $model->get_telefones_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);

        $vars["erro"] = "";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);

            if ($_POST) {

                foreach ($_POST as $nome => $valor) {
                    ( $nome == "email") ? $vars["email_cadastro"] = $valor : $vars[$nome] = $valor;
                }

                $numeros = 0;
                $str = "";

                while ($numeros < 51) {
                    $guid_ddd = "ddd_{$numeros}";
                    $guid_tel = "tel_{$numeros}";
                    $guid_ramal = "ramal_{$numeros}";

                    if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                        ($numeros == 0 ) ? $str .= "<div class='row datagrid'>" : $str .= "<div class='row datagrid'><br/>";
                        $str .= "<div class='col col-sm-2'>";
                        $str .= "<input type='text' class='form-control' id='ddd_{$numeros}' name='ddd_{$numeros}' maxlength='4' value='" . $_POST[$guid_ddd] . "' placeholder='DDD' onkeypress='return formataNumDV(event, this, 2);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-3'>";
                        $str .= "<input type='text' class='form-control' id='tel_{$numeros}' name='tel_{$numeros}' maxlength='10' value='" . $_POST[$guid_tel] . "' placeholder='Telefone ou celular' onkeypress='return formataNumDV(event, this, 9);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-7'>";
                        $str .= "<input type='text' class='form-control' id='ramal_{$numeros}' name='ramal_{$numeros}' maxlength='100' value='" . $_POST[$guid_ramal] . "' placeholder='Informações adicionais'/>    ";
                        $str .= "</div>";
                        $str .= "</div>";
                    }

                    $numeros++;
                }

                $vars["datagrid"] = $str;


                $dados_complementares['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;
                $dados_complementares['DTA_INICIO'] = $this->formataDataForUSA($_POST["data_inicio"]);
                $dados_complementares['DTA_FIM'] = $this->formataDataForUSA($_POST["data_fim"]);
                $dados_complementares['BOLSA_VALOR'] = $this->limpaValorReal($_POST["bolsa"]);
                $dados_complementares['CARGA_HORARIA'] = $_POST["carga_horaria"];
                $dados_complementares['INTITUICAO_ENSINO'] = $_POST["instituicao_ensino"];
                $dados_complementares['CARGO'] = $_POST["cargo"];
                $dados_complementares['CURSO'] = $_POST["curso"];
                $dados_complementares['STATUS'] = 1;
                $dados_complementares['REPRESENTANTE_INTITUICAO'] = $_POST["representante_instituicao"];
                $dados_complementares['CARGO_REPRESENTANTE'] = $_POST["cargo_representante"];
                $dados_complementares['CTPS'] = $_POST["ctps"];
                $dados_complementares['SERIE'] = $_POST["serie"];
                $dados_complementares['CARGA_HORARIA_OBS'] = $_POST["carga_horaria_obs"];

                #endereco
                $dados_endereco['CODENDERECO'] = $this->getPrimarykey();
                $dados_endereco['CEP'] = trim($_POST["cep"]);
                $dados_endereco['LOGRADOURO'] = trim($_POST["logradouro"]);
                $dados_endereco['NUMERO'] = trim($_POST["numero"]);
                $dados_endereco['COMPLEMENTO'] = trim($_POST["complemento"]);
                $dados_endereco['BAIRRO'] = trim($_POST["bairro"]);
                $dados_endereco['CIDADE'] = trim($_POST["cidade"]);
                $dados_endereco['UF'] = trim(mb_strtoupper($_POST["estado"], "UTF-8"));
                $dados_endereco['STATUS'] = 1;

                #endereco relacionado ao cadastro
                $dados_complementares_rel_enderecos['CODENDERECO'] = $dados_endereco['CODENDERECO'];
                $dados_complementares_rel_enderecos['CODDADOSCOMPLEMENTARES'] = $dados_complementares['CODDADOSCOMPLEMENTARES'];

                $ddd = $_POST["ddd_0"];
                $tel = $_POST["tel_0"];

                if ($dados_complementares['DTA_INICIO'] == "" || $dados_complementares['DTA_FIM'] == "") {
                    $vars["erro"] = "* Início e fim do <strong>Estagiário</strong> requerido!";
                } else if ($dados_complementares['BOLSA_VALOR'] == "") {
                    $vars["erro"] = "* Valor da <strong>Bolsa</strong> requerido!";
                } else if ($dados_complementares['INTITUICAO_ENSINO'] == "") {
                    $vars["erro"] = "* Nome da <strong>Intituição de Ensino</strong> requerido!";
                } else if ($dados_complementares['REPRESENTANTE_INTITUICAO'] == "") {
                    $vars["erro"] = "* <strong>Representante da Intituição de Ensino</strong> requerido!";
                } else if ($dados_complementares['CARGO_REPRESENTANTE'] == "") {
                    $vars["erro"] = "* Cargo da <strong>Representante da Intituição de Ensino</strong> requerido!";
                } else if ($ddd == "" || $tel == "") {
                    $vars["erro"] = "* Telefones da <strong>Intituição de Ensino</strong> requerido!";
                } else if ($dados_complementares['CARGO'] == "") {
                    $vars["erro"] = "* Preencha o <strong>Cargo</strong> corretamente!";
                } else if ($dados_complementares['CURSO'] == "") {
                    $vars["erro"] = "* Preencha o <strong>Curso</strong> corretamente!";
                } else if ($dados_complementares['CTPS'] == "") {
                    $vars["erro"] = "* Preencha o <strong>CTPS</strong> corretamente!";
                } else if ($dados_complementares['SERIE'] == "") {
                    $vars["erro"] = "* Preencha a <strong>Série da CTPS</strong> corretamente!";
                } else if (strlen($dados_endereco['CEP']) != 9) {
                    $vars["erro"] = "* CEP <strong>da Insituição de Ensino</strong> requerido ou inválido!";
                } else if ($dados_endereco['LOGRADOURO'] == "") {
                    $vars["erro"] = "* Logradouro <strong>da Insituição de Ensino</strong> requerido!";
                } else if ($dados_endereco['NUMERO'] == "") {
                    $vars["erro"] = "* Número do endereço <strong>da Insituição de Ensino</strong> requerido!";
                } else if ($dados_endereco['BAIRRO'] == "") {
                    $vars["erro"] = "* Bairro <strong>da Insituição de Ensino</strong> requerido!";
                } else if ($dados_endereco['CIDADE'] == "") {
                    $vars["erro"] = "* Cidade <strong>da Insituição de Ensino</strong> requerida!";
                } else if (strlen($dados_endereco['UF']) != 2) {
                    $vars["erro"] = "* UF <strong>da Insituição de Ensino</strong> requerida ou inválido!";
                }



                if ($vars["erro"] == "") {

                    if ($model->update_dados_complementares($dados_complementares, $coddadoscomplementares)) {


                        $dados_complementares_cods_rel_endereco = $model->get_cods_dados_complementares_rel_endereco($coddadoscomplementares);
                        $model->delete_endereco($dados_complementares_cods_rel_endereco->CODENDERECO);
                        $model->delete_dados_complementares_rel_enderecos($coddadoscomplementares);

                        $model->insert_endereco($dados_endereco);
                        $model->insert_dados_complementares_rel_enderecos($dados_complementares_rel_enderecos);

                        $dc_rel_telefone = $model->get_cods_dados_complementares_rel_telefone($coddadoscomplementares);

                        if ($dc_rel_telefone) {
                            foreach ($dc_rel_telefone as $obj) {
                                $model->delete_telefone($obj->CODTELEFONE);
                            }
                        }
                        $model->delete_dados_complementares_rel_telefone($coddadoscomplementares);

                        $numeros = 0;

                        while ($numeros < 51) {

                            $guid_ddd = "ddd_{$numeros}";
                            $guid_tel = "tel_{$numeros}";
                            $guid_ramal = "ramal_{$numeros}";

                            if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                                $dados_dados_complementares_rel_telefones['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $numeros));
                                $dados_dados_complementares_rel_telefones['CODDADOSCOMPLEMENTARES'] = $dados_complementares['CODDADOSCOMPLEMENTARES'];

                                $model->insert_dados_complementares_rel_telefones($dados_dados_complementares_rel_telefones);

                                $dados_telefone['CODTELEFONE'] = $dados_dados_complementares_rel_telefones['CODTELEFONE'];
                                $dados_telefone['DDD'] = $_POST[$guid_ddd];

                                $tel = str_replace("-", "", $_POST[$guid_tel]);
                                $tel = str_replace(".", "", $_POST[$guid_tel]);
                                $dados_telefone['TELEFONE'] = $tel;

                                $dados_telefone['RAMAL'] = $_POST[$guid_ramal];
                                $dados_telefone['STATUS'] = 1;

                                $model->insert_telefone($dados_telefone);
                            }
                            $numeros++;
                        }

                        echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[1]}/'</script>";
                        exit();
                    } else {
                        $vars["erro"] = "* Ocorreu um <strong>Erro inesperado</strong> ao tentar criar os dados complementares!";
                    }
                }
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            if ($_SESSION["PAPEL"] == "EMPRESA_ENTIDADE" || $_SESSION["PAPEL"] == "GESTOR" || $_SESSION["PAPEL"] == "ESTAGIARIO") {
                $this->view("admin/empresa_entidade_dados_complementares_visualizar", $vars);
            } else {
                $this->view("admin/empresa_entidade_dados_complementares_editar", $vars);
            }
        }
    }

    public function visualizar_dados_complementares_estagiario_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];

        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);

        if ($dc) {
            foreach ($dc as $obj) {
                $vars["dados_complementares"] = $obj;
            }
        }


        foreach ($model->get_enderecos_instituicao($coddadoscomplementares) as $endereco) {

            $vars["cep"] = $endereco->CEP;
            $vars["logradouro"] = $endereco->LOGRADOURO;
            $vars["numero"] = $endereco->NUMERO;
            $vars["complemento"] = $endereco->COMPLEMENTO;
            $vars["estado"] = $endereco->UF;
            $vars["cidade"] = $endereco->CIDADE;
            $vars["bairro"] = $endereco->BAIRRO;
        }



        $vars["telefones"] = $model->get_telefones_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);

        $vars["erro"] = "";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);
            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/empresa_entidade_dados_complementares_visualizar", $vars);
        }
    }

    public function dados_complementares_renovar_estagio() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);

        $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $dc = $model->get_dados_complementares($codestagiario, $codempresa, NULL);

            if ($dc) {
                $old_dados_complementares = (Object) $old_dados_complementares;
                foreach ($dc as $obj) {
                    $old_dados_complementares = $obj;
                }
            }

            $dados_complementares['CODDADOSCOMPLEMENTARES'] = $this->getPrimarykey();
            $dados_complementares['DTA_INICIO'] = $old_dados_complementares->DTA_INICIO_USA_6_MESES;
            $dados_complementares['DTA_FIM'] = $old_dados_complementares->DTA_FIM_USA_6_MESES;
            $dados_complementares['BOLSA_VALOR'] = $this->limpaValorReal($old_dados_complementares->BOLSA_VALOR);
            $dados_complementares['CARGA_HORARIA'] = $old_dados_complementares->CARGA_HORARIA;
            $dados_complementares['INTITUICAO_ENSINO'] = $old_dados_complementares->INTITUICAO_ENSINO;
            $dados_complementares['CARGO'] = $old_dados_complementares->CARGO;
            $dados_complementares['CURSO'] = $old_dados_complementares->CURSO;
            $dados_complementares['STATUS'] = $old_dados_complementares->STATUS;
            $dados_complementares['REPRESENTANTE_INTITUICAO'] = $old_dados_complementares->REPRESENTANTE_INTITUICAO;
            $dados_complementares['CARGO_REPRESENTANTE'] = $old_dados_complementares->CARGO_REPRESENTANTE;
            $dados_complementares['CTPS'] = $old_dados_complementares->CTPS;
            $dados_complementares['SERIE'] = $old_dados_complementares->SERIE;
            $dados_complementares['CARGA_HORARIA_OBS'] = $old_dados_complementares->CARGA_HORARIA_OBS;

            foreach ($model->get_enderecos_instituicao($old_dados_complementares->CODDADOSCOMPLEMENTARES) as $endereco) {
                #endereco
                $dados_endereco['CODENDERECO'] = $this->getPrimarykey();
                $dados_endereco['CEP'] = $endereco->CEP;
                $dados_endereco['LOGRADOURO'] = $endereco->LOGRADOURO;
                $dados_endereco['NUMERO'] = $endereco->NUMERO;
                $dados_endereco['COMPLEMENTO'] = $endereco->COMPLEMENTO;
                $dados_endereco['BAIRRO'] = $endereco->BAIRRO;
                $dados_endereco['CIDADE'] = $endereco->CIDADE;
                $dados_endereco['UF'] = $endereco->UF;
                $dados_endereco['STATUS'] = 1;
            }

            $dados_complementares_rel_enderecos['CODENDERECO'] = $dados_endereco['CODENDERECO'];
            $dados_complementares_rel_enderecos['CODDADOSCOMPLEMENTARES'] = $dados_complementares['CODDADOSCOMPLEMENTARES'];

//            echo "<br><br><br>";
//
//            var_dump($old_dados_complementares);
//            echo "<br><br><br>";
//            
//            var_dump($dados_complementares);
//            echo "<br><br><br>";
//            
//            var_dump($dados_endereco);
//            echo "<br><br><br>";
//            
//            var_dump($dados_complementares_rel_enderecos);

            $vars["telefones"] = $model->get_telefones_dados_complementares($codestagiario, $codempresa, $old_dados_complementares->CODDADOSCOMPLEMENTARES);

//            die();

            if ($model->insert_dados_complementares($dados_complementares)) {

                $cadastro_rel_dados_complementares['CODDADOSCOMPLEMENTARES'] = $dados_complementares['CODDADOSCOMPLEMENTARES'];
                $cadastro_rel_dados_complementares['CODCADASTRO'] = $codestagiario;

                $model->insert_cadastro_rel_dados_complementares($cadastro_rel_dados_complementares);

                $model->insert_endereco($dados_endereco);
                $model->insert_dados_complementares_rel_enderecos($dados_complementares_rel_enderecos);

                $numeros = 0;

                foreach ($vars["telefones"] as $telefone) {

                    $dados_dados_complementares_rel_telefones['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $numeros));
                    $dados_dados_complementares_rel_telefones['CODDADOSCOMPLEMENTARES'] = $dados_complementares['CODDADOSCOMPLEMENTARES'];

                    $model->insert_dados_complementares_rel_telefones($dados_dados_complementares_rel_telefones);

                    $dados_telefone['CODTELEFONE'] = $dados_dados_complementares_rel_telefones['CODTELEFONE'];
                    $dados_telefone['DDD'] = $telefone->DDD;
                    $dados_telefone['TELEFONE'] = $telefone->TELEFONE;

                    $dados_telefone['RAMAL'] = $telefone->RAMAL;
                    $dados_telefone['STATUS'] = $telefone->STATUS;

                    $model->insert_telefone($dados_telefone);
                    $numeros++;
                }

                $quebra_linha = "\n";
                $emailsender = EMAIL_DISPATCHER;
                $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                $emaildesitnatario = $_POST["email"];
                $nomedesitnatario = EMAIL_RH;
                $comcopia = EMAIL_RH;
                $assunto = "Serviço de alerta de renovação de bolsa de estágio " . $this->getTimestamp();
                $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                $mensagemHTML = $this->view_email("emails/dados_complementares", $vars);

                $headers = "MIME-Version: 1.1{$quebra_linha}";
                $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                $headers .= "Cc: {$comcopia}{$quebra_linha}";
                $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                $headers .= "X-Mailer: PHP/" . phpversion();

                mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);


                echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[1]}/'</script>";
                exit();
            }
        }
    }

    public function dados_complementares_estagiario_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];

        $vars["erro"] = "";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);

            if ($_POST) {

                foreach ($_POST as $nome => $valor) {
                    ( $nome == "email") ? $vars["email_cadastro"] = $valor : $vars[$nome] = $valor;
                }

                $numeros = 0;
                $str = "";

                while ($numeros < 51) {
                    $guid_ddd = "ddd_{$numeros}";
                    $guid_tel = "tel_{$numeros}";
                    $guid_ramal = "ramal_{$numeros}";

                    if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                        ($numeros == 0 ) ? $str .= "<div class='row datagrid'>" : $str .= "<div class='row datagrid'><br/>";
                        $str .= "<div class='col col-sm-2'>";
                        $str .= "<input type='text' class='form-control' id='ddd_{$numeros}' name='ddd_{$numeros}' maxlength='4' value='" . $_POST[$guid_ddd] . "' placeholder='DDD' onkeypress='return formataNumDV(event, this, 2);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-3'>";
                        $str .= "<input type='text' class='form-control' id='tel_{$numeros}' name='tel_{$numeros}' maxlength='10' value='" . $_POST[$guid_tel] . "' placeholder='Telefone ou celular' onkeypress='return formataNumDV(event, this, 9);'/>";
                        $str .= "</div>";
                        $str .= "<div class='col col-sm-7'>";
                        $str .= "<input type='text' class='form-control' id='ramal_{$numeros}' name='ramal_{$numeros}' maxlength='100' value='" . $_POST[$guid_ramal] . "' placeholder='Informações adicionais'/>    ";
                        $str .= "</div>";
                        $str .= "</div>";
                    }

                    $numeros++;
                }

                $vars["datagrid"] = $str;


                $dados_complementares['CODDADOSCOMPLEMENTARES'] = $this->getPrimarykey();
                $dados_complementares['DTA_INICIO'] = $this->formataDataForUSA($_POST["data_inicio"]);
                $dados_complementares['DTA_FIM'] = $this->formataDataForUSA($_POST["data_fim"]);
                $dados_complementares['BOLSA_VALOR'] = $this->limpaValorReal($_POST["bolsa"]);
                $dados_complementares['CARGA_HORARIA'] = $_POST["carga_horaria"];
                $dados_complementares['INTITUICAO_ENSINO'] = $_POST["instituicao_ensino"];
                $dados_complementares['CARGO'] = $_POST["cargo"];
                $dados_complementares['CURSO'] = $_POST["curso"];
                $dados_complementares['STATUS'] = 1;
                ($_POST["data_desligamento"] != "") ? $dados_complementares['DTA_DESLIGAMENTO'] = $_POST["data_desligamento"] : null;
                $dados_complementares['REPRESENTANTE_INTITUICAO'] = $_POST["representante_instituicao"];
                $dados_complementares['CARGO_REPRESENTANTE'] = $_POST["cargo_representante"];
                $dados_complementares['CTPS'] = $_POST["ctps"];
                $dados_complementares['SERIE'] = $_POST["serie"];
                $dados_complementares['CARGA_HORARIA_OBS'] = $_POST["carga_horaria_obs"];

                $ddd = $_POST["ddd_0"];
                $tel = $_POST["tel_0"];

                #endereco
                $dados_endereco['CODENDERECO'] = $this->getPrimarykey();
                $dados_endereco['CEP'] = trim($_POST["cep"]);
                $dados_endereco['LOGRADOURO'] = trim($_POST["logradouro"]);
                $dados_endereco['NUMERO'] = trim($_POST["numero"]);
                $dados_endereco['COMPLEMENTO'] = trim($_POST["complemento"]);
                $dados_endereco['BAIRRO'] = trim($_POST["bairro"]);
                $dados_endereco['CIDADE'] = trim($_POST["cidade"]);
                $dados_endereco['UF'] = trim(mb_strtoupper($_POST["estado"], "UTF-8"));
                $dados_endereco['STATUS'] = 1;

                #endereco relacionado ao cadastro
                $dados_complementares_rel_enderecos['CODENDERECO'] = $dados_endereco['CODENDERECO'];
                $dados_complementares_rel_enderecos['CODDADOSCOMPLEMENTARES'] = $dados_complementares['CODDADOSCOMPLEMENTARES'];

                if ($dados_complementares['DTA_INICIO'] == "" || $dados_complementares['DTA_FIM'] == "") {
                    $vars["erro"] = "* Início e fim do <strong>Estagiário</strong> requerido!";
                } else if ($dados_complementares['BOLSA_VALOR'] == "") {
                    $vars["erro"] = "* Valor da <strong>Bolsa</strong> requerido!";
                } else if ($dados_complementares['INTITUICAO_ENSINO'] == "") {
                    $vars["erro"] = "* Nome da <strong>Intituição de Ensino</strong> requerido!";
                } else if ($dados_complementares['REPRESENTANTE_INTITUICAO'] == "") {
                    $vars["erro"] = "* <strong>Representante da Intituição de Ensino</strong> requerido!";
                } else if ($dados_complementares['CARGO_REPRESENTANTE'] == "") {
                    $vars["erro"] = "* Cargo da <strong>Representante da Intituição de Ensino</strong> requerido!";
                } else if ($ddd == "" || $tel == "") {
                    $vars["erro"] = "* Telefones da <strong>Intituição de Ensino</strong> requerido!";
                } else if ($dados_complementares['CARGO'] == "") {
                    $vars["erro"] = "* Preencha o <strong>Cargo</strong> corretamente!";
                } else if ($dados_complementares['CURSO'] == "") {
                    $vars["erro"] = "* Preencha o <strong>Curso</strong> corretamente!";
                } else if ($dados_complementares['CTPS'] == "") {
                    $vars["erro"] = "* Preencha o <strong>CTPS</strong> corretamente!";
                } else if ($dados_complementares['SERIE'] == "") {
                    $vars["erro"] = "* Preencha a <strong>Série da CTPS</strong> corretamente!";
                } else if (strlen($dados_endereco['CEP']) != 9) {
                    $vars["erro"] = "* CEP <strong>da Insituição de Ensino</strong> requerido ou inválido!";
                } else if ($dados_endereco['LOGRADOURO'] == "") {
                    $vars["erro"] = "* Logradouro <strong>da Insituição de Ensino</strong> requerido!";
                } else if ($dados_endereco['NUMERO'] == "") {
                    $vars["erro"] = "* Número do endereço <strong>da Insituição de Ensino</strong> requerido!";
                } else if ($dados_endereco['BAIRRO'] == "") {
                    $vars["erro"] = "* Bairro <strong>da Insituição de Ensino</strong> requerido!";
                } else if ($dados_endereco['CIDADE'] == "") {
                    $vars["erro"] = "* Cidade <strong>da Insituição de Ensino</strong> requerida!";
                } else if (strlen($dados_endereco['UF']) != 2) {
                    $vars["erro"] = "* UF <strong>da Insituição de Ensino</strong> requerida ou inválido!";
                }

                if ($vars["erro"] == "") {

                    if ($model->insert_dados_complementares($dados_complementares)) {

                        $cadastro_rel_dados_complementares['CODDADOSCOMPLEMENTARES'] = $dados_complementares['CODDADOSCOMPLEMENTARES'];
                        $cadastro_rel_dados_complementares['CODCADASTRO'] = $codestagiario;

                        $model->insert_cadastro_rel_dados_complementares($cadastro_rel_dados_complementares);

                        $model->insert_endereco($dados_endereco);
                        $model->insert_dados_complementares_rel_enderecos($dados_complementares_rel_enderecos);

                        $numeros = 0;

                        while ($numeros < 51) {

                            $guid_ddd = "ddd_{$numeros}";
                            $guid_tel = "tel_{$numeros}";
                            $guid_ramal = "ramal_{$numeros}";

                            if (strlen($_POST[$guid_ddd]) == 2 && $_POST[$guid_tel] != "") {

                                $dados_dados_complementares_rel_telefones['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $numeros));
                                $dados_dados_complementares_rel_telefones['CODDADOSCOMPLEMENTARES'] = $dados_complementares['CODDADOSCOMPLEMENTARES'];

                                $model->insert_dados_complementares_rel_telefones($dados_dados_complementares_rel_telefones);

                                $dados_telefone['CODTELEFONE'] = $dados_dados_complementares_rel_telefones['CODTELEFONE'];
                                $dados_telefone['DDD'] = $_POST[$guid_ddd];

                                $tel = str_replace("-", "", $_POST[$guid_tel]);
                                $tel = str_replace(".", "", $_POST[$guid_tel]);
                                $dados_telefone['TELEFONE'] = $tel;

                                $dados_telefone['RAMAL'] = $_POST[$guid_ramal];
                                $dados_telefone['STATUS'] = 1;

                                $model->insert_telefone($dados_telefone);
                            }
                            $numeros++;
                        }

                        $quebra_linha = "\n";
                        $emailsender = EMAIL_DISPATCHER;
                        $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                        $emaildesitnatario = $_POST["email"];
                        $nomedesitnatario = EMAIL_RH;
                        $comcopia = EMAIL_RH;
                        $assunto = "Serviço de alerta de cadastro de bolsa de estágio " . $this->getTimestamp();
                        $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                        $mensagemHTML = $this->view_email("emails/dados_complementares", $vars);

                        $headers = "MIME-Version: 1.1{$quebra_linha}";
                        $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                        $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "Cc: {$comcopia}{$quebra_linha}";
                        $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "X-Mailer: PHP/" . phpversion();

                        mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);

                        echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[1]}/'</script>";
                        exit();
                    } else {
                        $vars["erro"] = "* Ocorreu um <strong>Erro inesperado</strong> ao tentar criar os dados complementares!";
                    }
                }
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/empresa_entidade_dados_complementares", $vars);
        }
    }

    public function lista_avaliar_estagiario_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/lista_empresa_entidade_avaliacao", $vars);
        }
    }

    public function avaliar_estagiario_empresa_entidade() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];


        if ($model->existe_avaliacao($coddadoscomplementares)) {
            $vars["avaliacao"] = $model->get_avaliacao($coddadoscomplementares);
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);

            if ($_POST) {

                foreach ($_POST as $key => $value) {
                    $key = strtoupper($key);
                    $dados[$key] = addslashes($value);
                    $model->update_avaliacao($dados, $coddadoscomplementares);
                }

                if ($model->existe_avaliacao($coddadoscomplementares)) {
                    $dados['STATUS'] = 1;
                } else {
                    $dados['CODAVALIACAO'] = $this->getPrimarykey();
                    $dados['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;
                    $dados['STATUS'] = 1;
                    $model->insert_avaliacao($dados);
                }


                echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[1]}/'</script>";
                exit();
            }

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/empresa_entidade_avaliacao", $vars);
        }
    }

    public function pdf_avaliacao() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];


        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);
        if ($dc) {
            $vars["dados_complementares"] = $dc;
        }

        if ($model->existe_avaliacao($coddadoscomplementares)) {
            $vars["avaliacao"] = $model->get_avaliacao($coddadoscomplementares);
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {


            $estagiario_empresa = $model->get_estagiario_view($codestagiario, $codempresa);
            $vars["estagiario_empresa"] = $estagiario_empresa;


            $empresa_endereco = $model->get_enderecos($codempresa);

            if ($empresa_endereco) {
                foreach ($empresa_endereco as $endereco) {

                    $vars["EMP_CEP"] = $endereco->CEP;
                    $vars["EMP_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["EMP_NUMERO"] = $endereco->NUMERO;
                    $vars["EMP_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["EMP_UF"] = $endereco->UF;
                    $vars["EMP_CIDADE"] = $endereco->CIDADE;
                    $vars["EMP_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $vars["telefones_supervisor"] = $model->get_telefones($estagiario_empresa->ADM_CODCADASTRO);

            $html = $this->view_pdf("pdf/avaliacao", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            //Colocando o rodape
            //$mpdf->SetFooter('{DATE j/m/Y H:i}|Página {PAGENO} de {nb}|www.parceriaconsult.com.br');
            $mpdf->Output();

            exit;

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            //$this->view("admin/empresa_entidade_avaliacao", $vars);
        }
    }
    
    public function pdf_lista_nomes_estagiario() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codempresa = strtoupper($arr[0]);
        $vars["codempresa"] = $codempresa;
        
        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $nomes = $model->get_nome_estagiario($codempresa);
            $empresa = $model->get_cadastro($codempresa);
            $vars["empresa"] = $empresa;
            
            if($nomes){
                $vars["nomes_estagiarios"] = $nomes;
            }

            $html = $this->view_pdf("pdf/pdf_nomes_estagiarios", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            //Colocando o rodape
            //$mpdf->SetFooter('{DATE j/m/Y H:i}|Página {PAGENO} de {nb}|www.parceriaconsult.com.br');
            $mpdf->Output();
            exit;
        }
    }

    public function pdf_ficha_desligamento() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];


        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);
        if ($dc) {
            $vars["dados_complementares"] = $dc;
        }

        if ($model->existe_ficha_desligamento($coddadoscomplementares)) {

            $vars["ficha_desligamento"] = $model->get_ficha_desligamento($coddadoscomplementares);
        } else {
            $fdl['CODFICHADESLIGAMENTO'] = $this->getPrimarykey();
            $fdl['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;

            $model->insert_ficha_desligamento($fdl);
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {


            $estagiario_empresa = $model->get_estagiario_view($codestagiario, $codempresa);
            $vars["estagiario_empresa"] = $estagiario_empresa;


            $empresa_endereco = $model->get_enderecos($codempresa);

            if ($empresa_endereco) {
                foreach ($empresa_endereco as $endereco) {

                    $vars["EMP_CEP"] = $endereco->CEP;
                    $vars["EMP_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["EMP_NUMERO"] = $endereco->NUMERO;
                    $vars["EMP_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["EMP_UF"] = $endereco->UF;
                    $vars["EMP_CIDADE"] = $endereco->CIDADE;
                    $vars["EMP_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $vars["telefones_supervisor"] = $model->get_telefones($estagiario_empresa->ADM_CODCADASTRO);

            $html = $this->view_pdf("pdf/ficha_desligamento", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            //Colocando o rodape
            //$mpdf->SetFooter('{DATE j/m/Y H:i}|Página {PAGENO} de {nb}|www.parceriaconsult.com.br');
            $mpdf->Output();

            exit;

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            //$this->view("admin/empresa_entidade_avaliacao", $vars);
        }
    }

    public function pdf_questionario_estagiario() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];


        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);
        if ($dc) {
            $vars["dados_complementares"] = $dc;
        }

        if ($model->existe_questionario_estagiario($coddadoscomplementares)) {

            $vars["questionario_estagiario"] = $model->get_questionario_estagiario($coddadoscomplementares);
        } else {
            $fdl['CODQUESTIONARIOESTAGIARIO'] = $this->getPrimarykey();
            $fdl['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;

            $model->insert_questionario_estagiario($fdl);
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {


            $estagiario_empresa = $model->get_estagiario_view($codestagiario, $codempresa);
            $vars["estagiario_empresa"] = $estagiario_empresa;


            $empresa_endereco = $model->get_enderecos($codempresa);

            if ($empresa_endereco) {
                foreach ($empresa_endereco as $endereco) {

                    $vars["EMP_CEP"] = $endereco->CEP;
                    $vars["EMP_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["EMP_NUMERO"] = $endereco->NUMERO;
                    $vars["EMP_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["EMP_UF"] = $endereco->UF;
                    $vars["EMP_CIDADE"] = $endereco->CIDADE;
                    $vars["EMP_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $vars["telefones_supervisor"] = $model->get_telefones($estagiario_empresa->ADM_CODCADASTRO);

            $html = $this->view_pdf("pdf/questionario_estagiario", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            //Colocando o rodape
            //$mpdf->SetFooter('{DATE j/m/Y H:i}|Página {PAGENO} de {nb}|www.parceriaconsult.com.br');
            $mpdf->Output();

            exit;

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            //$this->view("admin/empresa_entidade_avaliacao", $vars);
        }
    }

    public function ficha_desligamento() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];


        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);
        if ($dc) {
            $vars["dados_complementares"] = $dc;
        }

        if ($model->existe_ficha_desligamento($coddadoscomplementares)) {

            $vars["ficha_desligamento"] = $model->get_ficha_desligamento($coddadoscomplementares);
        } else {
            $fdl['CODFICHADESLIGAMENTO'] = $this->getPrimarykey();
            $fdl['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;

            $model->insert_ficha_desligamento($fdl);
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            if ($_POST) {

                $fx["DESCREVA_ATIVIDADES"] = stripslashes($_POST["DESCREVA_ATIVIDADES"]);
                $fx["DESCREVA_OBSTACULOS"] = stripslashes($_POST["DESCREVA_OBSTACULOS"]);
                $fx["DESCREVA_PONTOS_POSITIVOS"] = stripslashes($_POST["DESCREVA_PONTOS_POSITIVOS"]);
                $fx["DESCREVA_NOTA"] = stripslashes($_POST["DESCREVA_NOTA"]);
                $fx["DESCREVA_RELACIONAMENTO_CHEFE"] = stripslashes($_POST["DESCREVA_RELACIONAMENTO_CHEFE"]);
                $fx["DESCREVA_SE_VOLTARIA"] = stripslashes($_POST["DESCREVA_SE_VOLTARIA"]);
                $fx["DESCREVA_RECEBEU_BOLSA"] = stripslashes($_POST["DESCREVA_RECEBEU_BOLSA"]);
                $fx["DESCREVA_MOTIVO_DESLIGAMENTO"] = stripslashes($_POST["DESCREVA_MOTIVO_DESLIGAMENTO"]);
                $fx["DESCREVA_AGENTE_INTEGRACAO"] = stripslashes($_POST["DESCREVA_AGENTE_INTEGRACAO"]);

                if ($model->update_ficha_desligamento($fx, $coddadoscomplementares)) {

                    $quebra_linha = "\n";
                    $emailsender = EMAIL_DISPATCHER;
                    $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                    $emaildesitnatario = $_POST["email"];
                    $nomedesitnatario = EMAIL_RH;
                    $comcopia = EMAIL_RH;
                    $assunto = "Serviço de alerta de ficha de desligamento de bolsa de estágio " . $this->getTimestamp();
                    $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                    $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);
                    $mensagemHTML = $this->view_email("emails/dados_complementares", $vars);

                    $headers = "MIME-Version: 1.1{$quebra_linha}";
                    $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                    $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "Cc: {$comcopia}{$quebra_linha}";
                    $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "X-Mailer: PHP/" . phpversion();

                    mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);

                    echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[1]}/'</script>";
                    exit();
                } else {
                    $vars["erro"] = "Ocorreu um erro inesperado e não foi possível atualizar esta ficha de desligamento";
                }
            }


            $estagiario_empresa = $model->get_estagiario_view($codestagiario, $codempresa);
            $vars["estagiario_empresa"] = $estagiario_empresa;


            $empresa_endereco = $model->get_enderecos($codempresa);

            if ($empresa_endereco) {
                foreach ($empresa_endereco as $endereco) {

                    $vars["EMP_CEP"] = $endereco->CEP;
                    $vars["EMP_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["EMP_NUMERO"] = $endereco->NUMERO;
                    $vars["EMP_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["EMP_UF"] = $endereco->UF;
                    $vars["EMP_CIDADE"] = $endereco->CIDADE;
                    $vars["EMP_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $vars["telefones_supervisor"] = $model->get_telefones($estagiario_empresa->ADM_CODCADASTRO);

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/ficha_desligamento", $vars);
        }
    }

    public function questionario_estagiario() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];


        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);
        if ($dc) {
            $vars["dados_complementares"] = $dc;
        }

        if ($model->existe_questionario_estagiario($coddadoscomplementares)) {

            $vars["questionario_estagiario"] = $model->get_questionario_estagiario($coddadoscomplementares);
        } else {
            $fdl['CODQUESTIONARIOESTAGIARIO'] = $this->getPrimarykey();
            $fdl['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;

            $model->insert_questionario_estagiario($fdl);
        }

        # echo aqui; die();

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            if ($_POST) {


                $fx["COPIA_TERMO"] = stripslashes($_POST["COPIA_TERMO"]);
                $fx["COPIA_TERMO_DESC"] = stripslashes($_POST["COPIA_TERMO_DESC"]);
                $fx["TEM_RECEBIDO"] = stripslashes($_POST["TEM_RECEBIDO"]);
                $fx["TEM_RECEBIDO_DESC"] = stripslashes($_POST["TEM_RECEBIDO_DESC"]);
                $fx["HORARIO_INTERFERINDO"] = stripslashes($_POST["HORARIO_INTERFERINDO"]);
                $fx["HORARIO_INTERFERINDO_DESC"] = stripslashes($_POST["HORARIO_INTERFERINDO_DESC"]);
                $fx["ATIVIDADES_DESC"] = stripslashes($_POST["ATIVIDADES_DESC"]);
                $fx["ENCONTRANDO_DIFICULDADE"] = stripslashes($_POST["ENCONTRANDO_DIFICULDADE"]);
                $fx["ENCONTRANDO_DIFICULDADE_DESC"] = stripslashes($_POST["ENCONTRANDO_DIFICULDADE_DESC"]);
                $fx["RELACIONADA_CURSO"] = stripslashes($_POST["RELACIONADA_CURSO"]);
                $fx["RELACIONADA_CURSO_DESC"] = stripslashes($_POST["RELACIONADA_CURSO_DESC"]);
                $fx["ACOMPANHAMENTO_ATIVIDADES"] = stripslashes($_POST["ACOMPANHAMENTO_ATIVIDADES"]);
                $fx["ACOMPANHAMENTO_ATIVIDADES_DESC"] = stripslashes($_POST["ACOMPANHAMENTO_ATIVIDADES_DESC"]);
                $fx["GOSTANDO_ATIVIDADES"] = stripslashes($_POST["GOSTANDO_ATIVIDADES"]);
                $fx["GOSTANDO_ATIVIDADES_DESC"] = stripslashes($_POST["GOSTANDO_ATIVIDADES_DESC"]);
                $fx["ATRIBUIR_NOTA"] = stripslashes($_POST["ATRIBUIR_NOTA"]);
                $fx["ATRIBUIR_NOTA_DESC"] = stripslashes($_POST["ATRIBUIR_NOTA_DESC"]);
                $fx["DUVIDA_ESTAGIO"] = stripslashes($_POST["DUVIDA_ESTAGIO"]);
                $fx["DUVIDA_ESTAGIO_DESC"] = stripslashes($_POST["DUVIDA_ESTAGIO_DESC"]);
                $fx["CRITICAR_DESC"] = stripslashes($_POST["CRITICAR_DESC"]);
                $fx["PARCERIA_DESC"] = stripslashes($_POST["PARCERIA_DESC"]);

                foreach ($fx as $name => $value) {
                    $fx[$name] = trim($value);
                }


                if ($model->update_questionario_estagiario($fx, $coddadoscomplementares)) {

                    $quebra_linha = "\n";
                    $emailsender = EMAIL_DISPATCHER;
                    $nomeremetente = "=?UTF-8?B?" . base64_encode("Disparo automático") . "?=";
                    $emaildesitnatario = $_POST["email"];
                    $nomedesitnatario = EMAIL_RH;
                    $comcopia = EMAIL_RH;
                    $assunto = "Serviço de alerta de ficha de questionário de estagiário " . $this->getTimestamp();
                    $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                    $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);
                    $mensagemHTML = $this->view_email("emails/dados_complementares", $vars);

                    $headers = "MIME-Version: 1.1{$quebra_linha}";
                    $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                    $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "Return-Path: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "Cc: {$comcopia}{$quebra_linha}";
                    $headers .= "Reply-To: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "X-Mailer: PHP/" . phpversion();

                    mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, $emailsender);

                    echo "<script>window.location='/" . LANGUAGE . "/admin/lista-dados-complementares-estagiario-empresa-entidade/{$arr[0]}/{$arr[1]}/'</script>";
                    exit();
                } else {
                    $vars["erro"] = "Ocorreu um erro inesperado e não foi possível atualizar esta ficha de desligamento";
                }
            }


            $estagiario_empresa = $model->get_estagiario_view($codestagiario, $codempresa);
            $vars["estagiario_empresa"] = $estagiario_empresa;


            $empresa_endereco = $model->get_enderecos($codempresa);

            if ($empresa_endereco) {
                foreach ($empresa_endereco as $endereco) {

                    $vars["EMP_CEP"] = $endereco->CEP;
                    $vars["EMP_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["EMP_NUMERO"] = $endereco->NUMERO;
                    $vars["EMP_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["EMP_UF"] = $endereco->UF;
                    $vars["EMP_CIDADE"] = $endereco->CIDADE;
                    $vars["EMP_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $vars["telefones_supervisor"] = $model->get_telefones($estagiario_empresa->ADM_CODCADASTRO);

            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-empresas-entidades";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/questionario_estagiario", $vars);
        }
    }

    public function pdf_acordo_cooperacao_termo_compromisso_estagio() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];


        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);
        
        if ($dc) {
            $vars["dados_complementares"] = $dc;
        }
        
        if ($model->existe_avaliacao($coddadoscomplementares)) {
            $vars["avaliacao"] = $model->get_avaliacao($coddadoscomplementares);
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {


            $estagiario_empresa = $model->get_estagiario_view($codestagiario, $codempresa);
            $vars["estagiario_empresa"] = $estagiario_empresa;


            
            
            $empresa_endereco = $model->get_enderecos($codempresa);

            if ($empresa_endereco) {
                foreach ($empresa_endereco as $endereco) {

                    $vars["EMP_CEP"] = $endereco->CEP;
                    $vars["EMP_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["EMP_NUMERO"] = $endereco->NUMERO;
                    $vars["EMP_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["EMP_UF"] = $endereco->UF;
                    $vars["EMP_CIDADE"] = $endereco->CIDADE;
                    $vars["EMP_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $empresa_endereco_stg = $model->get_enderecos($codestagiario);

            if ($empresa_endereco_stg) {
                foreach ($empresa_endereco_stg as $endereco) {

                    $vars["STG_CEP"] = $endereco->CEP;
                    $vars["STG_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["STG_NUMERO"] = $endereco->NUMERO;
                    $vars["STG_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["STG_UF"] = $endereco->UF;
                    $vars["STG_CIDADE"] = $endereco->CIDADE;
                    $vars["STG_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $empresa_endereco_instituicao = $model->get_enderecos_instituicao($coddadoscomplementares);

            if ($empresa_endereco_instituicao) {
                foreach ($empresa_endereco_instituicao as $endereco) {

                    $vars["INST_CEP"] = $endereco->CEP;
                    $vars["INST_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["INST_NUMERO"] = $endereco->NUMERO;
                    $vars["INST_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["INST_UF"] = $endereco->UF;
                    $vars["INST_CIDADE"] = $endereco->CIDADE;
                    $vars["INST_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $vars["telefones_supervisor"] = $model->get_telefones($estagiario_empresa->ADM_CODCADASTRO);

            $html = $this->view_pdf("pdf/pdf_acordo_cooperacao_termo_compromisso_estagio", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            //Colocando o rodape
            //$mpdf->SetFooter('{DATE j/m/Y H:i}|Página {PAGENO} de {nb}|www.parceriaconsult.com.br');
            $mpdf->Output();

            exit();
        }
    }

    public function pdf_termo_aditivo_estagio() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();

        $codestagiario = strtoupper($arr[0]);
        $codempresa = strtoupper($arr[1]);
        $coddadoscomplementares = strtoupper($arr[2]);

        $vars["codestagiario"] = $arr[0];
        $vars["codempresa"] = $arr[1];
        $vars["coddadoscomplementares"] = $arr[2];


        $dc = $model->get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares);
        if ($dc) {
            $vars["dados_complementares"] = $dc;
        }

        if ($model->existe_avaliacao($coddadoscomplementares)) {
            $vars["avaliacao"] = $model->get_avaliacao($coddadoscomplementares);
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {


            $estagiario_empresa = $model->get_estagiario_view($codestagiario, $codempresa);
            $vars["estagiario_empresa"] = $estagiario_empresa;


            $empresa_endereco = $model->get_enderecos($codempresa);

            if ($empresa_endereco) {
                foreach ($empresa_endereco as $endereco) {

                    $vars["EMP_CEP"] = $endereco->CEP;
                    $vars["EMP_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["EMP_NUMERO"] = $endereco->NUMERO;
                    $vars["EMP_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["EMP_UF"] = $endereco->UF;
                    $vars["EMP_CIDADE"] = $endereco->CIDADE;
                    $vars["EMP_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $empresa_endereco_stg = $model->get_enderecos($codestagiario);

            if ($empresa_endereco_stg) {
                foreach ($empresa_endereco_stg as $endereco) {

                    $vars["STG_CEP"] = $endereco->CEP;
                    $vars["STG_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["STG_NUMERO"] = $endereco->NUMERO;
                    $vars["STG_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["STG_UF"] = $endereco->UF;
                    $vars["STG_CIDADE"] = $endereco->CIDADE;
                    $vars["STG_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $empresa_endereco_instituicao = $model->get_enderecos_instituicao($coddadoscomplementares);

            if ($empresa_endereco_instituicao) {
                foreach ($empresa_endereco_instituicao as $endereco) {

                    $vars["INST_CEP"] = $endereco->CEP;
                    $vars["INST_LOGRADOURO"] = $endereco->LOGRADOURO;
                    $vars["INST_NUMERO"] = $endereco->NUMERO;
                    $vars["INST_COMPLEMENTO"] = $endereco->COMPLEMENTO;
                    $vars["INST_UF"] = $endereco->UF;
                    $vars["INST_CIDADE"] = $endereco->CIDADE;
                    $vars["INST_BAIRRO"] = $endereco->BAIRRO;
                }
            }

            $vars["telefones_supervisor"] = $model->get_telefones($estagiario_empresa->ADM_CODCADASTRO);

            $html = $this->view_pdf("pdf/pdf_termo_aditivo_estagio", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            //Colocando o rodape
            //$mpdf->SetFooter('{DATE j/m/Y H:i}|Página {PAGENO} de {nb}|www.parceriaconsult.com.br');
            $mpdf->Output();

            exit();
        }
    }

    public function pdf_solicitacao_estagiario() {

        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars = $this->dados();

            $codcadastro = $_SESSION["CODCADASTRO"];

            $arr = $this->array_url();

            $codsolicitacaoestagio = strtoupper($arr[0]);
            $vars["codsolicitacaoestagio"] = $arr[0];

//            $empresa_entidade = $model->get_cadastro($codcadastro);
//            $vars["empresa_entidade"] = $empresa_entidade;
//
//            $vars["telefones"] = $model->get_telefones($codcadastro);
//
//            foreach ($model->get_enderecos($codcadastro) as $endereco) {
//
//                $vars["cep"] = $endereco->CEP;
//                $vars["logradouro"] = $endereco->LOGRADOURO;
//                $vars["numero"] = $endereco->NUMERO;
//                $vars["complemento"] = $endereco->COMPLEMENTO;
//                $vars["estado"] = $endereco->UF;
//                $vars["cidade"] = $endereco->CIDADE;
//                $vars["bairro"] = $endereco->BAIRRO;
//            }


            $mySolicitacao = $model->get_solicitacao($codsolicitacaoestagio);
            $myTelefones = $model->get_solicitacao_telefones($codsolicitacaoestagio);
            $myEnderecos = $model->get_solicitacao_enderecos($codsolicitacaoestagio);
            $myBeneficios = $model->get_solicitacao_benficios($codsolicitacaoestagio);
            $myCursos = $model->get_solicitacao_cursos($codsolicitacaoestagio);
            $myInformatica = $model->get_solicitacao_informatica($codsolicitacaoestagio);
            $myIdiomas = $model->get_solicitacao_idiomas($codsolicitacaoestagio);



            if ($mySolicitacao) {
                $mySolicitacao->BOLSA_VALOR = $this->formataReais($mySolicitacao->BOLSA_VALOR);

                $solicitante = $model->get_cadastro($mySolicitacao->CODCADASTRO);
                $emp_endereco = $model->get_enderecos($mySolicitacao->CODCADASTRO);
                $emp_telefones = $model->get_telefones($mySolicitacao->CODCADASTRO);

                if ($emp_telefones) {

                    $str = "";
                    foreach ($emp_telefones as $obj) {

                        $str .= "({$obj->DDD}) {$obj->TELEFONE}";
                        if ($obj->RAMAL != "") {
                            $str .= " - {$obj->RAMAL}.";
                        }
                        $str .= "<br/>";
                    }

                    $vars["EMP_TELS"] = $str;
                }

                if ($emp_endereco) {
                    foreach ($emp_endereco as $obj) {
                        $vars["EMP_CODENDERECO"] = $obj->CODENDERECO;
                        $vars["EMP_LOGRADOURO"] = $obj->LOGRADOURO;
                        $vars["EMP_NUMERO"] = $obj->NUMERO;
                        $vars["EMP_BAIRRO"] = $obj->BAIRRO;
                        $vars["EMP_CEP"] = $obj->CEP;
                        $vars["EMP_COMPLEMENTO"] = $obj->COMPLEMENTO;
                        $vars["EMP_CIDADE"] = $obj->CIDADE;
                        $vars["EMP_UF"] = $obj->UF;
                    }
                }

                $vars["solicitante"] = $solicitante;
                $vars["solicitacao"] = $mySolicitacao;
            } else {
                $vars["solicitacao"] = false;
            }

            if ($myTelefones) {
                $vars["telefoness"] = $myTelefones;
            } else {
                $vars["telefoness"] = false;
            }

            if ($myEnderecos) {
                $vars["cep"] = $myEnderecos->CEP;
                $vars["logradouro"] = $myEnderecos->LOGRADOURO;
                $vars["numero"] = $myEnderecos->NUMERO;
                $vars["complemento"] = $myEnderecos->COMPLEMENTO;
                $vars["estado"] = $myEnderecos->UF;
                $vars["cidade"] = $myEnderecos->CIDADE;
                $vars["bairro"] = $myEnderecos->BAIRRO;
            } else {
                $vars["cep"] = "";
                $vars["logradouro"] = "";
                $vars["numero"] = "";
                $vars["complemento"] = "";
                $vars["estado"] = "";
                $vars["cidade"] = "";
                $vars["bairro"] = "";
            }

            if ($myBeneficios) {
                $vars["beneficios"] = $myBeneficios;
            } else {
                $vars["beneficios"] = false;
            }

            if ($myCursos) {
                $vars["cursos"] = $myCursos;
            } else {
                $vars["cursos"] = false;
            }

            if ($myInformatica) {
                $vars["informaticas"] = $myInformatica;
            } else {
                $vars["informaticas"] = false;
            }

            if ($myIdiomas) {
                $vars["idiomas"] = $myIdiomas;
            } else {
                $vars["idiomas"] = false;
            }

            $html = $this->view_pdf("pdf/pdf_solicitacao_estagiario", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            $mpdf->Output();

            exit();
        }
    }

    public function lista_documentos_estagiario() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";


        $arr = $this->array_url();
        $codestagiario = $arr[0];
        $codempresa = $arr[1];

        $arquivos = $model->get_arquivos($codestagiario);

        if ($arquivos) {
            $vars["arquivos"] = $arquivos;
        } else {
            $vars["arquivos"] = NULL;
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $vars["estagiario_empresa"] = $model->get_estagiario_view($codestagiario, $codempresa);

//            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//
//                $foto = $_FILES["myfile"];
//                $folder = $this->getPrimarykey();
//
//                $path = str_replace("\\", "/", DIR) . "/web-files/upload/" . $folder;
//
//                $extensao = strtolower(pathinfo($foto["name"], PATHINFO_EXTENSION));
//
//                $filename = $this->getPrimarykey() . "." . $extensao;
//
//
//                $dados['CODARQUIVO'] = $this->getPrimarykey();
//                $dados['CODCADASTRO'] = $vars["codcadastro"];
//                $dados['DIRETORIO_RAIZ'] = $path;
//                $dados['ARQUIVO_RAIZ'] = $path . "/" . $filename;
//                $dados['NOME_IMAGEM_ORIGINAL'] = $foto["name"];
//                $dados['NOME_IMAGEM'] = $filename;
//                $dados['TIPO_ARQUIVO'] = $foto["type"];
//                $dados['TAMANHO_ARQUIVO'] = $foto["size"];
//                $dados['EXTENSAO'] = $extensao;
//                $dados['LINK'] = "/web-files/upload/{$folder}/{$filename}";
//
//                $model->insert_files($dados);
//
//
//                $dados['DATA'] = gmDate("d/m/Y Hhi");
//
//                if (!is_dir($path)) {
//                    mkdir($path, null, true);
//                }
//
//                $caminho_imagem = $path . "\\" . $filename;
//                move_uploaded_file($foto["tmp_name"], $caminho_imagem);
//
//                header('Content-Type: application/json');
//                echo json_encode($dados);
//
//                die();
//            }


            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-upload-documentos";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/upload_documento_admin", $vars);
        }
    }

    public function upload_documento() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";


        $arquivos = $model->get_arquivos($vars["codcadastro"]);

        if ($arquivos) {
            $vars["arquivos"] = $arquivos;
        } else {
            $vars["arquivos"] = NULL;
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $foto = $_FILES["myfile"];
                $folder = $this->getPrimarykey();

                $path = str_replace("\\", "/", DIR) . "/web-files/upload/" . $folder;

                $extensao = strtolower(pathinfo($foto["name"], PATHINFO_EXTENSION));

                $filename = $this->getPrimarykey() . "." . $extensao;


                $dados['CODARQUIVO'] = $this->getPrimarykey();
                $dados['CODCADASTRO'] = $vars["codcadastro"];
                $dados['DIRETORIO_RAIZ'] = $path;
                $dados['ARQUIVO_RAIZ'] = $path . "/" . $filename;
                $dados['NOME_IMAGEM_ORIGINAL'] = $foto["name"];
                $dados['NOME_IMAGEM'] = $filename;
                $dados['TIPO_ARQUIVO'] = $foto["type"];
                $dados['TAMANHO_ARQUIVO'] = $foto["size"];
                $dados['EXTENSAO'] = $extensao;
                $dados['LINK'] = "/web-files/upload/{$folder}/{$filename}";

                $model->insert_files($dados);


                $dados['DATA'] = gmDate("d/m/Y Hhi");

                if (!is_dir($path)) {
                    mkdir($path, null, true);
                }

                $caminho_imagem = $path . "\\" . $filename;
                move_uploaded_file($foto["tmp_name"], $caminho_imagem);

                header('Content-Type: application/json');
                echo json_encode($dados);

                die();
            }


            $vars["page_reference"] = "empresas-entidades";
            $vars["page_internal"] = "estagiarios-upload-documentos";
            $vars["pagina"] = "Cadastro de Estagiários Empresas/Entidades!";

            $this->view("admin/upload_documento", $vars);
        }
    }

    public function delete_arquivo() {

        $vars = $this->dados();
        $model = new Admin_Model();

        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        $arr = $this->array_url();
        $codarquivo = $arr[0];

        $arquivos = $model->get_arquivos($vars["codcadastro"], $codarquivo);
        $arquivo = (Object) $arquivo;
        if ($arquivos) {
            $arquivo = $arquivos[0];
        }

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            if (file_exists($arquivo->ARQUIVO_RAIZ)) {
                @unlink($arquivo->ARQUIVO_RAIZ);
            }

            if (file_exists($arquivo->DIRETORIO_RAIZ)) {
                @rmdir($arquivo->DIRETORIO_RAIZ);
            }

            $model->delete_arquivo($codarquivo);

            header('Content-Type: application/json');
            $dados['CODARQUIVO'] = $codarquivo;
            echo json_encode($dados);

            die();
        }
    }

}
