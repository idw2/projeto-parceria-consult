<?php

set_time_limit(0);
header('Content-Type: application/json');
require("../../system/model.php");

Class Querys extends Model {
    
    public function limpaValorReal($valor){
        $valor = str_replace(",", "", $valor);
        $valor = str_replace(".", "", $valor);
        return $valor;
    }
    
    public function get_num_pedidos() {
        $query = $this->db->query("SELECT * FROM pedidos");
        $query->execute(); 
        return $query->rowCount();
    }
    
    public function insert_pedido(Array $dados){
        $this->_tabela = "pedidos";
        $this->insert($dados);
    }
    
    public function getPrimarykey(){
        return strtoupper(md5(uniqid(rand(), true)));
    }
    
    public function existe_codigo_bonus($codigo) {
        $query = $this->db->query("SELECT * FROM bonus WHERE CODIGO='{$codigo}'");
        $query->execute(); 
        return $query->rowCount();
    }
    
    public function insert_bonus(Array $dados){
        $this->_tabela = "bonus";
        $this->insert($dados);
    }
    
    public function get_enderecos($codendereco){
        $this->_tabela = "enderecos";
        $where = "CODENDERECO='{$codendereco}'";
        return $this->read($where);
    }
    
    public function insert_endereco(Array $dados){
        $this->_tabela = "enderecos";
        $this->insert($dados);
    }
    
    public function insert_pedidos_rel_enderecos(Array $dados){
        $this->_tabela = "pedidos_rel_enderecos";
        $this->insert($dados);
    }
    
    public function insert_compras(Array $dados){
        $this->_tabela = "compras";
        $this->insert($dados);
    }
    
    public function del_lista_desejos($client_hidden){
        $this->_tabela = "lista_desejos";
        $where = "CLIENT_HIDDEN='{$client_hidden}'";
        $this->delete($where);
    }
    
    public function get_lista_desejos($client_hidden) {
        $query = $this->db->query("SELECT 
                        produtos.CODPRODUTO, 
                        produtos.NOME, 
                        produtos.PESO, 
                        produtos.URL_AMIGAVEL, 
                        produtos.CATEGORIA as CATEG, 
                        (produtos.PESO*SUM(lista_desejos.QUANTIDADE)) as PESO_TOTAL, 
                        fotos.CROP80 as FOTO, 
                        CASE produtos.CATEGORIA 
                        WHEN 'aneis' THEN 'Anéis'
                        WHEN 'brincos' THEN 'Brinco'
                        WHEN 'colares' THEN 'Colares'
                        ELSE 'Pulseiras' 
                        END AS CATEGORIA, 
                        produtos.PRECO, 
                        produtos.REFERENCIA, 
                        (produtos.PRECO*SUM(lista_desejos.QUANTIDADE)) as TOTAL, 
                        SUM(lista_desejos.QUANTIDADE) as QUANTIDADE 
                    FROM produtos
                    INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
                    INNER JOIN fotos_rel_produtos ON fotos_rel_produtos.CODPRODUTO=produtos.CODPRODUTO
                    INNER JOIN fotos ON fotos_rel_produtos.CODFOTO=fotos.CODFOTO
                    WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}' 
                    AND fotos.DESTAQUE=1
                    GROUP BY produtos.CODPRODUTO
                    ORDER BY (produtos.NOME) ASC");
        
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }
    
    public function embalar_presente($client_hidden) {
        $query = $this->db->query("SELECT 
                        DISTINCT lista_desejos.EMBALAR_PRESENTE 
                    FROM produtos
                    INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
                    INNER JOIN fotos_rel_produtos ON fotos_rel_produtos.CODPRODUTO=produtos.CODPRODUTO
                    INNER JOIN fotos ON fotos_rel_produtos.CODFOTO=fotos.CODFOTO
                    WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}' 
                    AND fotos.DESTAQUE=1
                    GROUP BY produtos.CODPRODUTO
                    ORDER BY (produtos.NOME) ASC");
        
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->EMBALAR_PRESENTE;
            }
        } else {
            return false;
        }
    }
    
    public function get_compras($codpedido) {
        $query = $this->db->query("SELECT * FROM compras WHERE CODPEDIDO='{$codpedido}'");
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }
    
    public function get_cadastro($codcadastro) {
        $query = $this->db->query("SELECT * FROM cadastro WHERE CODCADASTRO='{$codcadastro}'");
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }
    }
    
    public function update_produtos($codproduto, $quantidade) {
       $query = $this->db->query("UPDATE produtos SET QUANTIDADE = (QUANTIDADE - {$quantidade}) WHERE CODPRODUTO='{$codproduto}'");
       return true;
    }
    
    public function pedido_finalizado($codpedido,$codcadastro) {
        $query = $this->db->prepare("SELECT * FROM `pedidos` WHERE CODPEDIDO=:CODPEDIDO AND CODCADASTRO=:CODCADASTRO AND STATUS=1");
        $query->bindParam(":CODPEDIDO", $codpedido, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }
    
    public function get_forma_pgto_pedido($codpedido, $codcadastro) {
        $query = $this->db->prepare("SELECT * FROM `pedidos` WHERE CODPEDIDO=:CODPEDIDO AND CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":CODPEDIDO", $codpedido, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        if($query->rowCount()){
            while( $rows = $query->fetch(PDO::FETCH_OBJ)){
                return $rows->FORMA_PGTO;
            }
            
        } else {
            return false;
        }
    }
        
    public function get_pedido($codpedido, $codcadastro) {
        $query = $this->db->prepare("SELECT * FROM `pedidos` WHERE CODPEDIDO=:CODPEDIDO AND CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":CODPEDIDO", $codpedido, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        if($query->rowCount()){
            $c = new Controller();
            while( $rows = $query->fetch(PDO::FETCH_OBJ)){
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->CODCADASTRO = strtolower($rows->CODCADASTRO);
                $rows->N_PEDIDO = $c->formataCodigopedido($rows->N_PEDIDO);
                $rows->TAXA_ENTREGA = $c->formataReais($rows->TAXA_ENTREGA);
                $rows->TOTAL_PARCIAL = $c->formataReais($rows->TOTAL_PARCIAL);
                $rows->TOTAL_MOIP = $rows->TOTAL_GERAL;
                $rows->TOTAL_PAYPAL = str_replace(".", "", $c->formataReais($rows->TOTAL_GERAL));
                $rows->TOTAL_PAYPAL = str_replace(",", ".", $rows->TOTAL_PAYPAL);
                $rows->TOTAL_GERAL = $c->formataReais($rows->TOTAL_GERAL);
                return $rows;
            }
            
        } else {
            return false;
        }
    } 
    
    public function saudacao() {
        $hora = (int)date("H"); 
        if( $hora >= 0 && $hora <12){
            return "Bom dia,";
        } else if( $hora >= 12 && $hora <18){
            return "Bom tarde,";
        } else {
            return "Bom noite,";
        } 
        
    }
    
    public function get_bonus($cupom) {
        $query = $this->db->query("SELECT * FROM bonus WHERE CODIGO='{$cupom}'");
        $query->execute();
        if($query->rowCount()){
            while( $rows = $query->fetch(PDO::FETCH_OBJ)){
                return $rows;
            }
        } else {
            return false;
        }
    }
    
    public function del_bonus($cupom){
        $this->_tabela = "bonus";
        $where = "CODIGO='{$cupom}'";
        $this->delete($where);
    }
    
}

$model = new Querys();

$client_hidden = trim($_POST['CLIENT_HIDDEN']);
$codendereco = trim($_POST['CODENDERECO']);

$bonus = trim($_POST["BONUS"]);

$dados['CODPEDIDO'] = strtoupper(md5(uniqid(rand(), true)));
$dados['CODCADASTRO'] = trim($_POST['CODCADASTRO']);

$cliente = $model->get_cadastro($dados['CODCADASTRO']);

$dados['FORMA_PGTO'] = trim($_POST['FORMA_PGTO']);
$dados['N_PEDIDO'] = ((int)$model->get_num_pedidos() + 1);
$dados['FORMA_ENVIO'] = trim($_POST['FORMA_ENVIO']);

switch ($dados['FORMA_ENVIO']){
    case '41106': $dados['FORMA_ENVIO'] = "PAC" ; break;
    case '40010': $dados['FORMA_ENVIO'] = "SEDEX" ; break;
    case '40215': $dados['FORMA_ENVIO'] = "SEDEX 10" ; break;
    case '40290': $dados['FORMA_ENVIO'] = "SEDEX hoje" ; break;
    case '81019': $dados['FORMA_ENVIO'] = "e-SEDEX" ; break;
}

if( trim($_POST['TAXA_ENTREGA']) == "Gratis"){
    $dados['TAXA_ENTREGA'] = 0;
    $dados['FRETE_GRATIS'] = 1;
} else {
    $dados['TAXA_ENTREGA'] = $model->limpaValorReal(trim($_POST['TAXA_ENTREGA']));
    $dados['FRETE_GRATIS'] = 0;
}

( strlen($_POST['TICKET_DESCONTO']) == 6 )  ? $ticket = $model->get_bonus($_POST['TICKET_DESCONTO']) : $ticket = 0;
if( $ticket != 0){
    $dados['DESCONTO'] = $ticket->VALOR;
    $dados['CUPOM'] = strtoupper($_POST['TICKET_DESCONTO']);
    $model->del_bonus($_POST['TICKET_DESCONTO']);
}
    
    
$dados['TOTAL_GERAL'] = $model->limpaValorReal(trim($_POST['TOTAL_GERAL']));
$dados['TOTAL_PARCIAL'] = $model->limpaValorReal(trim($_POST['TOTAL_PARCIAL']));
$dados['IMPOSTOS'] = $model->limpaValorReal(trim($_POST['IMPOSTOS']));
$dados['EMBALAR_PRESENTE'] = (int)$model->embalar_presente($client_hidden);

$model->insert_pedido($dados);

$bonus_array["CODBONUS"] = $model->getPrimarykey();
$bonus_array["CODCADASTRO"] = $dados['CODCADASTRO'];
$bonus_array["CODIGO"] = substr($bonus_array["CODBONUS"], 0, 6);

$existe = ($model->existe_codigo_bonus($bonus["CODIGO"])) ? true : false;

while($existe){
    $codigo = $model->getPrimarykey();
    $codigo2 = $codigo{5};
    $existe = ($model->existe_codigo_bonus($codigo2)) ? true : false;        
}

$bonus_array["VALOR"] = $model->limpaValorReal($bonus);
$model->insert_bonus($bonus_array);

$persiste_endereco = array();
foreach($model->get_enderecos($codendereco) as $name => $valor){
    if($name != "CODENDERECO" && $name != "DTA"){
        $persiste_endereco[$name] = $valor;
    }    
}

$persiste_endereco['CODENDERECO'] = strtoupper(md5(uniqid(rand(), true)));

$model->insert_endereco($persiste_endereco);

$pedidos_rel_enderecos['CODENDERECO'] = $persiste_endereco['CODENDERECO'];
$pedidos_rel_enderecos['CODPEDIDO'] = $dados['CODPEDIDO'];

$model->insert_pedidos_rel_enderecos($pedidos_rel_enderecos);

$compra = array();

//echo sizeof($model->get_lista_desejos($client_hidden));

$i=0;
foreach ($model->get_lista_desejos($client_hidden) as $compraObj){
    
    foreach( $compraObj as $name => $value ){
     
        ($name == "CATEGORIA") ? $compra[$name] = utf8_decode($value) : $compra[$name] = $value;
        
    }
    
    $compra['CODCOMPRA'] = strtoupper(md5(uniqid(rand(), true)));
    $compra['CODPEDIDO'] = $dados['CODPEDIDO'];
    
    $model->insert_compras($compra);
    $i++;
}

foreach( $model->get_compras($dados['CODPEDIDO']) as $compra ){
    
    $model->update_produtos($compra->CODPRODUTO, $compra->QUANTIDADE);
}

$model->del_lista_desejos($client_hidden);

$dados['CODPEDIDO'] = trim(strtolower($dados['CODPEDIDO']));




echo json_encode($dados);




$quebra_linha = "\n";
$emailsender = "maria@mariadebarro.com.br";
$nomeremetente = "Maria de Barro";
$emaildesitnatario = $cliente->EMAIL;
$assunto_texto = "Cupom de desconto Maria de Barro";
$assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

$link = "http://novo.mariadebarro.com.br/";

$mensagemHTML = "<pre><div style='font-size: 14px;'>
    <h3>Parabéns {$cliente->NOME},</h3>
    <div>Você tem um desconto de <strong>R$ {$_POST['BONUS']}</strong> para a sua próxima compra!<div><br/>
    <div>Para solicitar o desconto forneça o seguinte número de cupom:<div><br/>
    <div style='boder: 1px solid #000; padding: 3%'><h1>{$bonus_array['CODIGO']}</h1><div><br/>
    <div><a href='{$link}'><img src='{$link}web-files/img/logo.png' alt='Maria de Barro' title='Maria de Barro' border='0'/></a></div><br/>
    <div><strong>* Não responder a este e-mail</strong></div><br/>
    </div></pre>";

$headers = "MIME-Version: 1.1{$quebra_linha}";
$headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
$headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
$headers .= "Return-Path: {$emailsender}{$quebra_linha}";
$headers .= "Cc: {$comcopia}{$quebra_linha}";
$headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
$headers .= "X-Mailer: PHP/" . phpversion();

mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);


//$forma_pgto = $model->get_forma_pgto_pedido($codpedido, $codcadastro);
//$this->assign("forma_pgto", $forma_pgto);
//$this->assign("pedido", $model->get_pedido($codpedido, $codcadastro));
//$this->view_tpl("confirmacao");
//
//$quebra_linha = "\n";
//$emailsender = "maria@mariadebarro.com.br";
//$nomeremetente = "Maria de Barro";
//$emaildesitnatario = $cliente->EMAIL;
//$assunto_texto = "Compra aguardando confirmação de Pagamento";
//$assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";
//
//$link = "http://novo.mariadebarro.com.br/";
//
//$mensagemHTML = "<pre><div style='font-size: 14px;'>
//    <h3>{$model->saudacao()} {$cliente->NOME},</h3>
//    <div>Recentemente voc~e realizou compras <strong>R$ {$_POST['BONUS']}</strong> para a sua próxima compra!<div><br/>
//    <div>Para solicitar o desconto forneça o seguinte número de cupom:<div><br/>
//    <div style='boder: 1px solid #000; padding: 3%'><h1>{$bonus_array['CODIGO']}</h1><div><br/>
//    <div><a href='{$link}'><img src='{$link}web-files/img/logo.png' alt='Maria de Barro' title='Maria de Barro' border='0'/></a></div><br/>
//    <div><strong>* Não responder a este e-mail</strong></div><br/>
//    </div></pre>";
//
//$headers = "MIME-Version: 1.1{$quebra_linha}";
//$headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
//$headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
//$headers .= "Return-Path: {$emailsender}{$quebra_linha}";
//$headers .= "Cc: {$comcopia}{$quebra_linha}";
//$headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
//$headers .= "X-Mailer: PHP/" . phpversion();
//
//mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
//
//
