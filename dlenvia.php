<?php

if(isset($_REQUEST["solicita_back"])){
  $destino = "ouvidoria@parceriaconsult.com.br, daniel@parceriaconsult.com.br";

  $tipo_servico = $_POST['tipo_servico'];
  $tempo_contrato = $_POST['tempo_contrato'];

  $funcao_1 = $_POST['funcao_1'];
  $quantidade_1 = $_POST['quantidade_1'];
  $salario_1 = $_POST['salario_1'];

  $funcao_2 = $_POST['funcao_2'];
  $quantidade_2 = $_POST['quantidade_2'];
  $salario_2 = $_POST['salario_2'];

  $funcao_3 = $_POST['funcao_3'];
  $quantidade_3 = $_POST['quantidade_3'];
  $salario_3 = $_POST['salario_3'];

  $funcao_4 = $_POST['funcao_4'];
  $quantidade_4 = $_POST['quantidade_4'];
  $salario_4 = $_POST['salario_4'];

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

  $assunto = 'Solicitação de Propostas';
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
  ---------------- INFORMAÇÕES DOS FUNCIONÁRIOS ----------------<br />
  -- 1 -- <br />
  Função : $funcao_1<br />
  Quantidade : $quantidade_1<br />  
  Salário : R$ $salario_1 <br><span></span>";

  if(($_POST["funcao_2"]!="") || ($_POST["quantidade_2"]!="") || ($_POST["salario_2"]!="")){
  $conteudo .="
    -- 2 -- <br />
    Função : $funcao_2<br />
    Quantidade : $quantidade_2<br />  
    Salário : R$ $salario_2<br />
  ";
  }

  if(($_POST["funcao_3"]!="") || ($_POST["quantidade_3"]!="") || ($_POST["salario_3"]!="")){
  $conteudo .="
    -- 3 -- <br />
    Função : $funcao_3<br />
    Quantidade : $quantidade_3<br />  
    Salário : R$ $salario_3<br />
  ";
  }

  if(($_POST["funcao_4"]!="") || ($_POST["quantidade_4"]!="") || ($_POST["salario_4"]!="")){
  $conteudo .="
    -- 4 -- <br />
    Função : $funcao_4<br />
    Quantidade : $quantidade_4<br />  
    Salário : R$ $salario_4<br />
  ";
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

  if($envio){
        echo "<script>location.href='http://parceriaconsult.com.br/index/index.php/solicitacao-enviada/'</script>";
  }
}
?>