<?php
/*
function calcula_frete($servico, $CEPorigem, $CEPdestino, $peso, $altura = '2', $largura = '11', $comprimento = '16', $valor = '0') {
    ////////////////////////////////////////////////
    // Código dos Serviços dos Correios
    // 41106 PAC
    // 40010 SEDEX
    // 40045 SEDEX a Cobrar
    // 40215 SEDEX 10
    ////////////////////////////////////////////////
    // URL do WebService
    $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=" . $CEPorigem . "&sCepDestino=" . $CEPdestino . "&nVlPeso=" . $peso . "&nCdFormato=1&nVlComprimento=" . $comprimento . "&nVlAltura=" . $altura . "&nVlLargura=" . $largura . "&sCdMaoPropria=n&nVlValorDeclarado=" . $valor . "&sCdAvisoRecebimento=n&nCdServico=" . $servico . "&nVlDiametro=0&StrRetorno=xml";
    // Carrega o XML de Retorno
    $xml = simplexml_load_file($correios);
    // Verifica se não há erros
    
    
    var_dump($xml);
    
    if ($xml->cServico->Erro == '0') {
        return $xml->cServico->Valor;
    } else {
        return false;
    }
}

echo calcula_frete($_POST["forma_envio"],$_POST["cep_remetente"],$_POST["cep_destinatario"],$_POST["total_peso"]);
*/
header('Content-Type: application/json');
require("../../system/helpers/RsCorreios.php");
require("../../system/model.php");

Class QuerysReload extends Model {

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
    
    
    public function get_total_geral($client_hidden) {
        
        $query = $this->db->query("SELECT 
            produtos.PRECO*SUM(lista_desejos.QUANTIDADE) as TOTAL  
        FROM produtos
        INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
        WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}'");
        
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->TOTAL = $this->formataReais($rows->TOTAL);
            }
        } else {
            return false;
        }
    }
    
    public function calcula_imposto($percentual, $sobre_valor) {
        $query = $this->db->query("SELECT SUM(ROUND({$sobre_valor}/{$percentual})-{$sobre_valor}) AS IMPOSTO;");
        $query->execute(); 
        
        if( $query->rowCount() ){
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->IMPOSTO = $c->formataReais($rows->IMPOSTO);
                return $rows;
            }            
        } else {
            return false;
        }
        
    }
    
}



$frete = new RsCorreios();

//var_dump($_POST); return;
$frete->setValue('sCepOrigem', $_POST["cep_remetente"]);
$frete->setValue('sCepDestino', $_POST["cep_destinatario"]);
$frete->setValue('nVlPeso', $_POST["total_peso"]);
$frete->setValue('nVlComprimento', '16');
$frete->setValue('nVlAltura', '2');
$frete->setValue('nVlLargura', '11');
$frete->setValue('nCdServico', $_POST["forma_envio"]);

$frete->getDiametro();

$result = $frete->getFrete();

$model = new QuerysReload();
//Retornamos a mensagem de erro caso haja alguma falha
if ($result['erro'] != 0) {
    //$resultadoFrete = $result['msg_erro'];
    
    $total_geral = $_POST["total_geral"];
    $total_geral = str_replace(".", "", $total_geral);
    $total_geral = str_replace(",", "", $total_geral);
    
    $total_impostos = trim($_POST["total_impostos"]);
    $total_impostos = str_replace(".", "", $total_impostos);
    $total_impostos = str_replace(",", "", $total_impostos);

    $valor = 0;
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    
    $soma = ((int)$total_geral + (int)$valor + (int)$total_impostos);
    
    $dados["soma"] = $model->formataReais($soma);
    $dados["frete"] = "0,00";
    $dados["msg_erro"] = "Serviço indisponível para esta Localidade!";
    //$dados["msg_erro"] = $result['msg_erro'];
    //print_r($dados);
    echo json_encode($dados);
}
else {
    
    $resultadoFrete = "Código do Serviço: " . $result['servico_codigo'] . "\n";
    $resultadoFrete .= "Valor do Frete: R$ " . $result['valor'] . "\n";
    $resultadoFrete .= "Prazo de Entrega: " . $result['prazo_entrega'] . " dias\n";
    $resultadoFrete .= "Valor p/ Mão Própria: R$ " . $result['mao_propria'] . "\n";
    $resultadoFrete .= "Valor Aviso de Recebimento: R$ " . $result['aviso_recebimento'] . "\n";
    $resultadoFrete .= "Valor Declarado: R$ " . $result['valor_declarado'] . "\n";
    $resultadoFrete .= "Entrega Domiciliar: " . $result['en_domiciliar'] . "\n";
    $resultadoFrete .= "Entrega Sábado: " . $result['en_sabado'] . "\n";
    
    
    $total_geral = trim($_POST["total_geral"]);
    $total_geral = str_replace(".", "", $total_geral);
    $total_geral = str_replace(",", "", $total_geral);
    
    $total_impostos = trim($_POST["total_impostos"]);
    $total_impostos = str_replace(".", "", $total_impostos);
    $total_impostos = str_replace(",", "", $total_impostos);
    
    $valor = $result['valor'];
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    
    if((int)$total_geral >= 15000){ 
        $soma = ((int)$total_geral + (int)$total_impostos);
    } else {
        $soma = ((int)$total_geral + (int)$valor + (int)$total_impostos);
    }
    

    $dados["soma"] = $model->formataReais($soma);
    $dados["frete"] = ((int)$total_geral >= 15000) ? "Gratis" : $model->formataReais($valor);
    $dados["msg_erro"] = ((int)$total_geral >= 15000) ? "Para esta compra o frete é Gratis" : "";
    
    //print_r($dados);
    
    echo json_encode($dados);
}


//echo $resultadoFrete;


?>