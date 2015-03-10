<?php

if (!isset($_POST))
    die;

extract($_POST);

$destino = "ouvidoria@parceriaconsult.com.br, daniel@parceriaconsult.com.br";

$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: faleconosco@parceriaconsult.com.br\r\n"; // remetente
$headers .= "Return-Path: faleconosco@parceriaconsult.com.br\r\n";

$assunto = 'Contato via site - ' . $nome;
$conteudo = "
  <html>
  <head>
    <title>Contato via site</title>
  </head>
  <body>
    <p><strong>Nome:</strong> $nome </p>
    <p><strong>Email:</strong> $email </p>
    <p><strong>Empresa:</strong> $empresa </p>
    <p><strong>Site:</strong> $site </p>
    <p><strong>Telefone para contato:</strong> $telefone </p>
    <p><strong>Perfil:</strong> $perfil </p>
    <p><strong>Assunto:</strong> $assunto </p>
    <p><strong>Mensagem:</strong> </p>
    <p>$mensagem</p>
  </body>
  </html>
  ";

$envio = mail($destino, $assunto, $conteudo, $headers);

if ($envio) {
    $res = array('title' => 'Mensagem enviada com sucesso!', 'message'=>'Em breve entraremos em contato.');
    echo json_encode($res);
}
?>