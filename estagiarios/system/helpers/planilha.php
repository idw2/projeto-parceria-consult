<?php

Class Planilha extends Controller {

    public $estagiario = NULL;
    public $mae = NULL;
    public $pai = NULL;
    public $cpf = NULL;
    public $rg = NULL;
    public $endereco = NULL;
    public $numero = NULL;
    public $complemento = NULL;
    public $bairro = NULL;
    public $banco = NULL;
    public $agencia = NULL;
    public $conta = NULL;
    public $instituicao = NULL;
    public $curso = NULL;
    public $bolsa = NULL;
    public $carga = NULL;
    public $admissao = NULL;
    public $prorrogacao = NULL;
    public $cliente = NULL;
    public $cnpj = NULL;

    public function getEstagiario() {
        return $this->estagiario;
    }

    public function getMae() {
        return $this->mae;
    }

    public function getPai() {
        return $this->pai;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getRg() {
        return $this->rg;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getBanco() {
        return $this->banco;
    }

    public function getAgencia() {
        return $this->agencia;
    }

    public function getConta() {
        return $this->conta;
    }

    public function getInstituicao() {
        return $this->instituicao;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function getBolsa() {
        return $this->bolsa;
    }

    public function getCarga() {
        return $this->carga;
    }

    public function getAdmissao() {
        return $this->admissao;
    }

    public function getProrrogacao() {
        return $this->prorrogacao;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function setEstagiario($estagiario) {
        $this->estagiario = $this->trata_nome($estagiario);
    }

    public function setMae($mae) {
        $this->mae = $this->trata_nome($mae);
    }

    public function setPai($pai) {
        $this->pai = $this->trata_nome($pai);
    }

    public function setCpf($cpf) {
        $this->cpf = $this->limpaCpf($cpf);
    }

    public function setRg($rg) {
        $this->rg = $rg;
    }

    public function setEndereco($endereco) {
        $this->endereco = $this->trata_nome($endereco);
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setComplemento($complemento) {
        $this->complemento = $this->trata_nome($complemento);
    }

    public function setBairro($bairro) {
        $this->bairro = $this->trata_nome($bairro);
    }

    public function setBanco($banco) {
        $this->banco = $banco;
    }

    public function setAgencia($agencia) {
        $this->agencia = $agencia;
    }

    public function setConta($conta) {
        $this->conta = $conta;
    }

    public function setInstituicao($instituicao) {
        $this->instituicao = $this->trata_nome($instituicao);
    }

    public function setCurso($curso) {
        $this->curso = $this->trata_nome($curso);
    }

    public function setBolsa($bolsa) {
        $this->bolsa = $this->limpaValorReal($bolsa);
    }

    public function setCarga($carga) {
        $this->carga = $carga;
    }

    public function setAdmissao($admissao) {
        $this->admissao = $admissao;
    }

    public function setProrrogacao($prorrogacao) {
        $this->prorrogacao = $prorrogacao;
    }

    public function setCliente($cliente) {
        $this->cliente = $this->trata_nome($cliente);
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $this->limpaCnpj($cnpj);
    }

}
