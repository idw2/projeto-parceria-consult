<?php

Class Login extends Controller {

    public function __construct() {

        $this->get_smarty();
        $this->run();
    }

    function index() {
        return false;
    }

    function index_action() {

        $vars = $this->dados();

        $model = new Admin_Model();

        $vars["pagina"] = "Login";
        $vars["page"] = "index";
        $vars["erro"] = "";
        $vars["erro_primeiro_acesso"] == "";

        if ($_POST) {

            foreach ($_POST as $name => $value) {
                $vars[$name] = $value;
            }

            if ($_POST["actionType"] == "primeiro_acesso") {

                $cpf_cnpj_radio = $_POST["cpf_cnpj_radio"];
                $cnpj = $_POST["cnpj"];
                $cpf = $_POST["cpf"];

                if ($cpf_cnpj_radio == "CPF") {
                    $cpf = $this->limpaCpf($cpf);
                } else {
                    $cnpj = $this->limpaCnpj($cnpj);
                }

                if (!$this->validaCNPJ($cnpj) && $cpf_cnpj_radio == "CNPJ") {
                    $vars["erro_primeiro_acesso"] = "* <strong>CNPJ</strong> inválido!";
                } else if (!$this->validaCPF($cpf) && $cpf_cnpj_radio == "CPF") {
                    $vars["erro_primeiro_acesso"] = "* <strong>CPF</strong> inválido!";
                } else if ($model->existe_cadastro($cnpj) == 0 && $cpf_cnpj_radio == "CNPJ") {
                    $vars["erro_primeiro_acesso"] = "* <strong>CNPJ</strong> não cadastrado!";
                } else if ($model->existe_cadastro($cpf) == 0 && $cpf_cnpj_radio == "CPF") {
                    $vars["erro_primeiro_acesso"] = "* <strong>CPF</strong> não cadastrado!";
                }

                if ($vars["erro_primeiro_acesso"] == "" && $cpf_cnpj_radio == "CNPJ") {

                    $qntdd = $model->existe_quantos_primeiro_acesso($cnpj);

                    if ($qntdd) {

                        $cadastro = $model->get_cadastro($cnpj);
                        if (strlen($cadastro->SENHA) == 32) {
                            $vars["erro_primeiro_acesso"] = "* <strong>CNPJ</strong> já realizou o primeiro acesso!";
                        } else {
                            echo "<script>window.location='/" . LANGUAGE . "/login/primeiro-acesso/" . strtolower($cadastro->CODCADASTRO) . "'</script>";
                            exit();
                        }
                    } else {
                        $vars["erro_primeiro_acesso"] = "* <strong>CNPJ</strong> já realizou o primeiro acesso!";
                    }
                } else {

                    $qntdd = $model->existe_quantos_primeiro_acesso($cpf);

                    if ($qntdd) {

                        $cadastro = $model->get_cadastro($cpf);
                        if (strlen($cadastro->SENHA) == 32) {
                            $vars["erro_primeiro_acesso"] = "* <strong>CPF</strong> já realizou o primeiro acesso!";
                        } else {
                            foreach ($model->get_dados_conta($cpf) as $name => $value) {
                                if ($name == "PAPEL") {
                                    $_SESSION["N_PAPEL"] = $value;
                                    $loop = explode(";", $value);
                                    $elimina = (sizeof($loop) - 1 );
                                    unset($loop[$elimina]);
                                    if (in_array('MASTER', $loop)) {
                                        $value = "MASTER";
                                    } else if (in_array('EMPRESA_ENTIDADE', $loop)) {
                                        $value = "EMPRESA_ENTIDADE";
                                    } else if (in_array('GESTOR', $loop)) {
                                        $value = "GESTOR";
                                    } else if (in_array('ESTAGIARIO', $loop)) {
                                        $value = "ESTAGIARIO";
                                    }
                                }
                                $_SESSION[$name] = $value;
                            }
                            echo "<script>window.location='/" . LANGUAGE . "/login/primeiro-acesso/" . strtolower($cadastro->CODCADASTRO) . "'</script>";
                            exit();
                        }
                    } else {
                        $vars["erro_primeiro_acesso"] = "* <strong>CPF</strong> já realizou o primeiro acesso!";
                    }
                }
            } else {

                $id = trim(strtoupper($_POST["id"]));
                $email = trim(strtolower($_POST["id"]));
                $senha = $_POST["senha"];

                foreach ($_POST as $name => $value) {
                    $vars[$name] = $value;
                }

                if ($id == "" && $senha == "") {
                    $vars["erro"] = "* <strong>Preencha</strong> todos os campos!";
                } else if ($model->existe_id($id) == 0 && $model->existe_email($email) == 0) {
                    $vars["erro"] = "ID ou E-mail não encontrado!";
                } else {

                    if ($model->existe_cadastro($id) || $model->existe_cadastro($email)) {

                        $senha = $this->senhaMd5($senha);
                        if ($model->confere_senha_login($email, $id, $senha)) {
                            if ($model->testa_status($id, $senha) || $model->testa_status($email, $senha)) {

                                $getDados = $model->get_dados_conta($id);
                                if(!$getDados){
                                    $getDados = $model->get_dados_conta($email);
                                }
                                
                                foreach ($getDados as $name => $value) {
                                    if ($name == "PAPEL") {
                                        $_SESSION["N_PAPEL"] = $value;
                                        $loop = explode(";", $value);
                                        $elimina = (sizeof($loop) - 1 );
                                        unset($loop[$elimina]);
                                        if (in_array('MASTER', $loop)) {
                                            $value = "MASTER";
                                        } else if (in_array('EMPRESA_ENTIDADE', $loop)) {
                                            $value = "EMPRESA_ENTIDADE";
                                        } else if (in_array('GESTOR', $loop)) {
                                            $value = "GESTOR";
                                        } else if (in_array('ESTAGIARIO', $loop)) {
                                            $value = "ESTAGIARIO";
                                        }
                                    }
                                    $_SESSION[$name] = $value;
                                }

                                echo "<script>window.location='/" . LANGUAGE . "/admin/welcome'</script>";
                                exit();
                            } else {
                                $vars["erro"] = "* <strong>Acesso negado</strong>, entre em contato com o administrador!";
                            }
                        } else {
                            $vars["erro"] = "* <strong>Senha</strong> não confere!";
                        }
                    } else {
                        $vars["erro"] = "* <strong>ID</strong> inexistente!";
                    }
                }
            }
        }


        $this->view("admin/index", $vars);
    }

    public function primeiro_acesso() {

        $model = new Admin_Model();
        $arr = $this->array_url();

        $codcadastro = strtoupper($arr[0]);
        $cadastro = $model->get_dados_conta($codcadastro);

        $vars["cadastro"] = $cadastro;

        if ($_POST) {

            $senha_atual = $_POST["senha_atual"];
            $senha_nova = $_POST["senha_nova"];
            $senha_repetir = $_POST["senha_repetir"];
            $lembrete = $_POST["lembrete"];

            if ($senha_nova == "") {
                $vars["erro"] = "* <strong>Definir</strong> senha requerida!";
            } else if ($senha_repetir == "") {
                $vars["erro"] = "* <strong>Repetir</strong> senha requerida!";
            } else if ($senha_nova != $senha_repetir) {
                $vars["erro"] = "* <strong>Senhas</strong> digitadas diferentes!";
            } else if ($lembrete == "") {
                $vars["erro"] = "* <strong>Lembrete</strong> de senha requerido!";
            } else {

                if ($model->update_senha($codcadastro, $this->senhaMd5($senha_nova), $lembrete)) {

                    foreach ($model->get_dados_conta($codcadastro) as $name => $value) {
                        if ($name == "PAPEL") {
                            $_SESSION["N_PAPEL"] = $value;
                            $loop = explode(";", $value);
                            $elimina = (sizeof($loop) - 1 );
                            unset($loop[$elimina]);
                            if (in_array('MASTER', $loop)) {
                                $value = "MASTER";
                            } else if (in_array('EMPRESA_ENTIDADE', $loop)) {
                                $value = "EMPRESA_ENTIDADE";
                            } else if (in_array('GESTOR', $loop)) {
                                $value = "GESTOR";
                            } else if (in_array('ESTAGIARIO', $loop)) {
                                $value = "ESTAGIARIO";
                            }
                        }
                        $_SESSION[$name] = $value;
                    }

                    echo "<script>alert('" . utf8_decode("* Senha definida com sucesso!") . "')</script>";
                    echo "<script>window.location='/" . LANGUAGE . "/admin/welcome'</script>";
                    exit();
                }
            }
        }

        $vars["pagina"] = "Primeiro Acesso - Alterar Senha!";
        $vars["page"] = "primeiro-acesso";

        $this->view("admin/primeiro_acesso", $vars);
    }

    public function alterar_papel() {

        $model = new Admin_Model();
        $papeis[] = "MASTER";
        $papeis[] = "EMPRESA_ENTIDADE";
        $papeis[] = "GESTOR";
        $papeis[] = "ESTAGIARIO";

        if ($this->permitir_acesso($_SESSION["ID"], $_SESSION["SENHA"], $papeis)) {

            $arr = $this->array_url();

            if ($arr[0] == "administrador-do-site") {
                $_SESSION["PAPEL"] = "MASTER";
            } else if ($arr[0] == "administrador-de-empresa-entidade") {
                $_SESSION["PAPEL"] = "EMPRESA_ENTIDADE";
            } else if ($arr[0] == "administrador-de-estagiarios") {
                $_SESSION["PAPEL"] = "GESTOR";
            } else if ($arr[0] == "estagiario") {
                $_SESSION["PAPEL"] = "ESTAGIARIO";
            }
        }

        echo "<script>alert('" . utf8_decode("* Papel alterado com sucesso!") . "')</script>";
        echo "<script>window.location='/" . LANGUAGE . "/admin/welcome'</script>";
        exit();
    }

}
