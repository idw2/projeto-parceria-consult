<?php

$nome = $_POST["name"];
$email = $_POST["email"];
$telefone = $_POST["phone"];
$mensagem = $_POST["message"];


$html = "
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <style>
    .content-block{ font-family: arial, sans-serif; }
    .content-block h2{ float: left;width:100%; font-weight: 500; margin: 0 0 15px;}
    .content-block h3{ float: left;width:100%; font-weight: 500; margin: 0 0 15px;}
    .content-block p{ float: left;width:100%; margin-top: 0; line-height: 1.4;font-size: 12px; }
    .content-block strong{ display:inline-block; width: 100px }
    </style>
  </head>
  <body>
    <div style='max-width: 600px;margin:0 auto;' class='content-block'>
        <div class='group'>
          <p><strong>Nome: </strong>$nome</p>
          <p><strong>E-mail: </strong>$email</p>
          <p><strong>Telefone: </strong>$telefone</p>
          <p><strong>Mensagem: </strong></p>
          <p>$mensagem</p>
        </div>
    </div>
  </body>
</html>
";

echo $html;
