<?php

Class Ajax extends Controller {

    public function __construct() {

        $this->get_smarty();
        $this->run();
    }

    public function index() {
        return false;
    }

    public function index_action() {

        return false;
    }

    public function consultar_cep() {
        header('Content-Type: application/json');
        echo json_encode($this->getEndereco($_GET["cep"]));
    }

    public function get_administradores() {

        $codempresa = $_GET["codempresa"];

        $model = new Admin_Model();

        $administradores = $model->get_administradores_empresa_entidade(strtoupper($codempresa));

        if ($administradores) {
            $option = "";
            foreach ($administradores as $obj) {
                $option .= "<option value='{$obj->CODCADASTRO}'>{$obj->NOME}</option>";
            }
            print($option);
        } else {
            return false;
        }
    }

    public function get_nom_estagiarios() {

        $codempresa = strtoupper($_GET["codempresa"]);
        $model = new Admin_Model();

        $nomes = $model->get_nome_estagiario($codempresa);

        if ($nomes) {

            echo "<div class='panel panel-default'>";
            echo "<div class='panel-heading'>";

            echo "<div class='row'>";
            echo "<div class='col col-sm-6'></div>";
            echo "<div class='col col-sm-6' style='text-align: right'>";
            echo "<strong>Ações: </strong>";
            echo "<a target='_blank' href='/pt/admin/pdf-lista-nomes-estagiario/" . strtolower($codempresa) ."'><img src='/web-files/img/pdf-3.png' alt='PDF - Lista de Nomes de Estágiários' title='PDF - Lista de Nomes de Estágiários' border='0'></a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Nomes dos Estagiários</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $i = 1;
            foreach ($nomes as $nome) {
                (strlen((string) $i) == 1) ? $n = "0{$i}" : $n = $i;
                echo "<tr>";
                echo "<td>{$n} - {$nome->NOME}</td>";
                echo "</tr>";
                $i++;
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            
        } else {
            echo "* Nenhum Estagiário Ligado a esta Empresa!";
        }


//        $administradores = $model->get_administradores_empresa_entidade(strtoupper($codempresa));
//
//        if ($administradores) {
//            $option = "";
//            foreach ($administradores as $obj) {
//                $option .= "<option value='{$obj->CODCADASTRO}'>{$obj->NOME}</option>";
//            }
//            print($option);
//        } else {
//            return false;
//        }
    }

    public function rotina1() {
        // activar Error reporting
        die();
        error_reporting(E_ALL);

// carregar a classe PHPExcel
        //require_once 'Classes/PHPExcel.php';
// iniciar o objecto para leitura
// definir a abertura do ficheiro em modo só de leitura
        $objReader = new PHPExcel_Reader_Excel5();
        $objReader->setReadDataOnly(true);

        // echo getcwd();  
        // exit();
        $objPHPExcel = $objReader->load("E:\home\parceriaconsult\Web\estagiarios\web-files\ESTAGIARIOS.xls");
        $objPHPExcel->setActiveSheetIndex(0);

        //echo "<table border='1'>";
// navegar na linha

        $model = new Admin_Model();
        $i = 0;
        for ($linha = 4; $linha <= 207; $linha++) {
            // echo "<tr>";
            // navegar nas colunas da respectiva linha

            $planilha = new Planilha();

            for ($coluna = 0; $coluna < 20; $coluna++) {

                switch ($coluna) {
                    case 0: $planilha->setEstagiario($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 1: $planilha->setMae($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 2: $planilha->setPai($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 3: $planilha->setCpf($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 4: $planilha->setRg($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 5: $planilha->setEndereco($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 6: $planilha->setNumero($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 7: $planilha->setComplemento($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 8: $planilha->setBairro($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 9: $planilha->setBanco($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 10: $planilha->setAgencia($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 11: $planilha->setConta($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 12: $planilha->setInstituicao($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 13: $planilha->setCurso($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 14: $planilha->setBolsa($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 15: $planilha->setCarga($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 16:
                        $dataAdminissao = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue();
                        if ($dataAdminissao != "") {
                            $planilha->setAdmissao(PHPExcel_Style_NumberFormat::ToFormattedString($dataAdminissao, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2));
                        }
                        break;
                    case 17:
                        $dataProrrogacao = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue();
                        if ($dataProrrogacao != "") {
                            $planilha->setProrrogacao(PHPExcel_Style_NumberFormat::ToFormattedString($dataProrrogacao, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2));
                        } else {
                            $planilha->setProrrogacao($this->adiantaDatas(PHPExcel_Style_NumberFormat::ToFormattedString($dataAdminissao, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2), 6, "MONTH"));
                        }
                        break;
                    case 18: $planilha->setCliente($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                    case 19: $planilha->setCnpj($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue());
                        break;
                }
            }

            #var_dump($planilha);  die();

            $instituicao = $model->get_cadastro($planilha->getCnpj());
            $codcadastro = strtoupper(md5($this->getPrimarykey() . $linha . $coluna));
            $codendereco = strtoupper(md5($this->getPrimarykey() . $codcadastro));
            $codtelefone = strtoupper(md5($this->getPrimarykey() . $codendereco));
            $codconta = strtoupper(md5($this->getPrimarykey() . $codtelefone));
            $coddadoscomplementares = strtoupper(md5($this->getPrimarykey() . $codconta));
            $codinstituicao = $instituicao->CODCADASTRO;
            $codadministrador = "71F8F8E9B09606EE49C65E9CC20F5927";

            $estagiario['CODCADASTRO'] = $codcadastro;
            $estagiario['TIPO_CONTA'] = "pf";
            $estagiario['NOME_RAZAO_SOCIAL'] = $planilha->getEstagiario();
            $estagiario['NOM_MAE'] = $planilha->getMae();
            $estagiario['NOM_PAI'] = $planilha->getPai();
            $estagiario['CPF_CNPJ'] = $planilha->getCpf();
            $estagiario['RG'] = $planilha->getRg();
            $estagiario['PAPEL'] = "ESTAGIARIO;";
            $estagiario['STATUS'] = 1;
            $estagiario['OWNER'] = "71F8F8E9B09606EE49C65E9CC20F5927";

            $model->insert_cadastro_planilha($estagiario);

            $estagiarios_rel_administradores['CODCADASTRO'] = $codcadastro;
            $estagiarios_rel_administradores['CODADMINISTRADOR'] = $codadministrador;

            $model->insert_estagiarios_rel_administradores($estagiarios_rel_administradores);

            $estagiarios_rel_empresas['CODCADASTRO'] = $codcadastro;
            $estagiarios_rel_empresas['CODEMPRESA_ENTIDADE'] = $codinstituicao;

            $model->insert_estagiarios_rel_empresas($estagiarios_rel_empresas);

            $cadastro_rel_enderecos['CODENDERECO'] = $codendereco;
            $cadastro_rel_enderecos['CODCADASTRO'] = $codcadastro;

            $model->insert_cadastro_rel_endereco($cadastro_rel_enderecos);

            $enderecos['CODENDERECO'] = $codendereco;
            $enderecos['CEP'] = "00000-000";
            $enderecos['LOGRADOURO'] = $planilha->getEndereco();
            $enderecos['NUMERO'] = $planilha->getNumero();
            $enderecos['COMPLEMENTO'] = $planilha->getComplemento();
            $enderecos['UF'] = "RJ";
            $enderecos['CIDADE'] = "Rio de Janeiro";
            $enderecos['BAIRRO'] = $planilha->getBairro();
            $enderecos['STATUS'] = 1;

            $model->insert_endereco($enderecos);

            $cadastro_rel_telefones['CODTELEFONE'] = $codtelefone;
            $cadastro_rel_telefones['CODCADASTRO'] = $codcadastro;

            $model->insert_cadastro_rel_telefone($cadastro_rel_telefones);

            $telefones['CODTELEFONE'] = $codtelefone;
            $telefones['DDD'] = "21";
            $telefones['TELEFONE'] = "0000-0000";
            $telefones['RAMAL'] = "";
            $telefones['STATUS'] = "";

            $model->insert_telefone($telefones);

            $cadastro_rel_contas['CODCONTA'] = $codconta;
            $cadastro_rel_contas['CODCADASTRO'] = $codcadastro;

            $model->insert_cadastro_rel_conta_bancaria($cadastro_rel_contas);

            if ($planilha->getBanco() == "BRADESCO") {
                $banco = "237";
            } else if ($planilha->getBanco() == "ITAU") {
                $banco = "341";
            } else {
                $banco = "";
            }

            if (substr_count($planilha->getAgencia(), '-') == 1) {
                $ag = explode("-", $planilha->getAgencia());
                $agencia = $ag[0];
                $agencia_digito = $ag[1];
            } else {
                $agencia = ($planilha->getAgencia() != 0) ? $planilha->getAgencia() : "";
                $agencia_digito = "";
            }

            $contas['CODCONTA'] = $codconta;
            $contas['CODBANCO'] = $banco;
            $contas['AGECIA'] = $agencia;
            $contas['AGECIA_DIGITO'] = $agencia_digito;
            $contas['CC'] = ($planilha->getConta() != 0) ? $planilha->getConta() : "";
            $contas['STATUS'] = 1;


            $model->insert_conta_bancaria($contas);

            $dados_complementares['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;
            $dados_complementares['CODCADASTRO'] = $codcadastro;

            $model->insert_cadastro_rel_dados_complementares($dados_complementares);

            $dados_complementares_rel_enderecos['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;
            $dados_complementares_rel_enderecos['CODENDERECO'] = strtoupper(md5($this->getPrimarykey() . $coddadoscomplementares));

            $model->insert_dados_complementares_rel_enderecos($dados_complementares_rel_enderecos);

            $enderecos2['CODENDERECO'] = $dados_complementares_rel_enderecos['CODENDERECO'];
            $enderecos2['CEP'] = "00000-000";
            $enderecos2['LOGRADOURO'] = $planilha->getEndereco();
            $enderecos2['NUMERO'] = $planilha->getNumero();
            $enderecos2['COMPLEMENTO'] = $planilha->getComplemento();
            $enderecos2['UF'] = "RJ";
            $enderecos2['CIDADE'] = "Rio de Janeiro";
            $enderecos2['BAIRRO'] = $planilha->getBairro();
            $enderecos2['STATUS'] = 1;

            $model->insert_endereco($enderecos2);

            $dados_complementares_rel_telefones['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;
            $dados_complementares_rel_telefones['CODTELEFONE'] = strtoupper(md5($this->getPrimarykey() . $coddadoscomplementares));

            $model->insert_dados_complementares_rel_telefones($dados_complementares_rel_telefones);

            $telefones2['CODTELEFONE'] = $dados_complementares_rel_telefones['CODTELEFONE'];
            $telefones2['DDD'] = "21";
            $telefones2['TELEFONE'] = "0000-0000";
            $telefones2['RAMAL'] = "";
            $telefones2['STATUS'] = "";

            $model->insert_telefone($telefones2);


            $dados_complementares2['CODDADOSCOMPLEMENTARES'] = $coddadoscomplementares;
            $dados_complementares2['DTA_INICIO'] = $planilha->getAdmissao();
            $dados_complementares2['DTA_FIM'] = $planilha->getProrrogacao();
            $dados_complementares2['BOLSA_VALOR'] = $this->limpaValorReal($planilha->getBolsa());
            $dados_complementares2['CARGA_HORARIA'] = $coddadoscomplementares;
            $dados_complementares2['INTITUICAO_ENSINO'] = $planilha->getInstituicao();
            $dados_complementares2['CARGO'] = "";
            $dados_complementares2['CURSO'] = $planilha->getCurso();
            $dados_complementares2['REPRESENTANTE_INTITUICAO'] = "";
            $dados_complementares2['CARGO_REPRESENTANTE'] = "";
            $dados_complementares2['CTPS'] = "";
            $dados_complementares2['SERIE'] = "";
            $dados_complementares2['STATUS'] = "1";

            $model->insert_dados_complementares($dados_complementares2);
            $i++;
            echo "{$i}: registro<br/>";

            #var_dump($contas); die();

            unset($planilha);
        }
        //echo "</table>";
    }

}
