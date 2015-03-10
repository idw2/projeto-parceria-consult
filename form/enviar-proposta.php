<?php

if (!isset($_POST))
    die;

//extract($_POST);

$destino = "ouvidoria@parceriaconsult.com.br, daniel@parceriaconsult.com.br";

$tipo_servico = $_POST['tipo_servico'];
$tempo_contrato = $_POST['tempo_contrato'];

$funcao = $_POST['funcao'];
$quantidade = $_POST['quantidade'];
$salario = $_POST['salario'];

$infos_funcionarios = array();

foreach ($funcao as $k => $v) {
    $infos_funcionarios[$k]['funcao'] = $funcao[$k];
    $infos_funcionarios[$k]['quantidade'] = $quantidade[$k];
    $infos_funcionarios[$k]['salario'] = $salario[$k];
}

$vt_valor = $_POST['vt_valor'];
$vt_dias = $_POST['vt_dias'];
$vt_quantidade = $_POST['vt_quantidade'];

$vr_valor = $_POST['vr_valor'];
$vr_dias = $_POST['vr_dias'];
$vr_desconto = $_POST['vr_desconto'];

$ass_med = $_POST['ass_med'];
$ass_odonto = $_POST['ass_odonto'];
$uniforme = $_POST['uniforme'];
$epi = $_POST['epi'];
$epi_val = $_POST['epi_val'];

$outros = $_POST['outros'];
$obs = $_POST['obs'];

$cliente_nome = $_POST['cliente_nome'];
$cliente_contato = $_POST['cliente_contato'];
$cliente_telefone = $_POST['cliente_telefone'];
$cliente_email = $_POST['cliente_email'];

$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: faleconosco@parceriaconsult.com.br\r\n"; // remetente
$headers .= "Return-Path: faleconosco@parceriaconsult.com.br\r\n";

$assunto = 'Solicitação de Propostas - ' . $cliente_nome;
$conteudo = "
  <html>
  <head>
    <title>Solicitação de Propostas</title>
  </head>
  <body>
  ---------------- INFORMAÇÕES DE SERVIÇO ----------------<br />  
  Tipo de serviço : $tipo_servico<br />
  Tempo de contrato (meses): $tempo_contrato<br />
    <br />
  ---------------- INFORMAÇÕES DOS FUNCIONÁRIOS ----------------<br />";

foreach ($infos_funcionarios as $k => $v) {
    $conteudo .= "-- " . ($k+1) . " -- <br />
  Função : ".$v['funcao']."<br />
  Quantidade : ".$v['quantidade']."<br />  
  Salário : R$ ".$v['salario']." <br><span></span>";
}



$conteudo .="
  --------------------------------<br />
  VT Valor: R$ $vt_valor<br />
  VT Dias : $vt_dias<br />
  VT Quantidade : $vt_quantidade<br />
  VR Valor : R$ $vr_valor<br />
  VR Dias : $vr_dias<br />  
  VR Desconto : $vr_desconto%<br />
  Assistência médica : R$ $ass_med<br />
  Assistência odontológica : R$ $ass_odonto<br />
  Uniforme : R$ $uniforme<br />
  EPI : $epi<br />
  EPI (valor): R$ $epi_val<br />
  Outros: $outros<br />
  Observações: $obs<br />
  <br />
  ---------------- DADOS DO CLIENTE ----------------<br />
  Cliente : $cliente_nome<br />
  Contato : $cliente_contato<br />
  Telefone : $cliente_telefone<br />
  Email : $cliente_email<br />
  </body>
  </html>
  ";

$envio = mail($destino, $assunto, $conteudo, $headers);

if ($envio) {
    $res = array('title' => 'Solicitação enviada com sucesso!', 'message'=>'Em breve entraremos em contato.');
    echo json_encode($res);
}
?>