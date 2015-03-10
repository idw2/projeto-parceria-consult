<?php
	// ja ta tudo mastigado em funcoes.php
	require('funcoes.php');
	
	/* observe que algumas validações são necessário
	 * pois sobre hipótese alguma deve ser confiar no
	 * usuário, mas vou deixar isso por sua parte, caso
	 * queira validar o cnpj você pode dar uma olhada no
	 * meu artigo Validando url, e-mail, ip, CPF, CNPJ, cep, data e telefone com uma única função 
	 * http://tretasdanet.com/?art=d6ac955326
	*/
	$cnpj = $_POST['cnpj'];
	$captcha = $_POST['captcha'];
	$token = $_POST['viewstate'];
	
	$getHtmlCNPJ = getHtmlCNPJ($cnpj, $captcha, $token);
	if($getHtmlCNPJ)
	{
		$campos = parseHtmlCNPJ($getHtmlCNPJ);
		// evite <pre>, seja criativo e não preguiçoso como eu. srs
		echo '<pre>';
		print_r($campos);
		echo '</pre>';
	}
?>