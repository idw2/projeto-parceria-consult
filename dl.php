<style>
  fieldset{
    display:inline-block;
    margin: 6px 2px;
    width: 100%;
    text-align:left;
  }
  form {text-align:center;padding: 0 12px;}
  form p{line-height: 0 !important;margin: 0 !important}
  fieldset.n{width:auto;}
  fieldset.n label{width:auto;}
  label{float: left;width: 230px;line-height:30px;font-size: 12px;}
  input[type=text],input[type=email],textarea{
    background: none repeat scroll 0 0 #FCFCFC;
    color: #666666;
    margin: 0 5px 10px 0;
    padding: 5px 7px;
    width:200px;
  }
  fieldset.n input{width:175px}
  #Submit{
    background: url("images/alert-overlay.png") repeat-x scroll 0 0 #343434;
    border-color: -moz-use-text-color -moz-use-text-color rgba(0, 0, 0, 0.25);
    border-radius: 4px 4px 4px 4px;
    border-style: none none solid;
    border-width: medium medium 1px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    color: #FFFFFF !important;
    cursor: pointer;
    display: inline-block;
    font-weight: bold;
    padding: 8px 10px !important;
    position: relative;
    text-decoration: none;
    text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.25);
  }
</style>

<form id="solicita_form" method="post" action="dlenvia.php">
  
  <center><h3>Informações de serviço</h3></center><br />
  <hr>
  <fieldset>
    <label>Tipo de serviço:</label>
    <select name="tipo_servico" id="tipo_servico">
      <option value="CLT" selected>CLT</option>
      <option value="Temporario">Temporário</option>
    </select>
  </fieldset><br />
  <fieldset>
    <label>Tempo de contrato (em meses):</label>
    <input name="tempo_contrato" id="temp_contrato" type="text" width="200" required/>
  </fieldset><br />
  <center><h3>Informações dos funcionários</h3></center><br />
  <hr>
  <fieldset class="n">
    <label>Função:</label>
    <input name="funcao_1" id="funcao1" type="text" width="150" required/><br />
    <input name="funcao_2" id="funcao2" type="text" width="150"/><br />
    <input name="funcao_3" id="funcao3" type="text" width="150"/><br />
    <input name="funcao_4" id="funcao4" type="text" width="150"/>
  </fieldset>
  <fieldset class="n">
    <label>Quantidade:</label>
    <input name="quantidade_1" id="qntd1" type="text" width="150" required/><br />
    <input name="quantidade_2" id="qntd2" type="text" width="150"/><br />
    <input name="quantidade_3" id="qntd3" type="text" width="150"/><br />
    <input name="quantidade_4" id="qntd4" type="text" width="150"/>
  </fieldset>
  <fieldset class="n">
    <label>Salário: R$</label>
    <input name="salario_1" id="salario1" class="numeros" type="text" width="150" required/><br />
    <input name="salario_2" id="salario2" type="text" width="150"/><br />
    <input name="salario_3" id="salario3" type="text" width="150"/><br />
    <input name="salario_4" id="salario4" type="text" width="150"/>
  </fieldset><br />
  <hr>
  <fieldset>
    <label>VT:</label>
    <input name="vt_valor" style="width:100px" id="vt_valor" type="text" placeholder="Valor (R$)" width="60" maxlength="10" required/>
    <input name="vt_dias" style="width:100px" id="vt_dias" type="text" placeholder="Dias" width="60" maxlength="3" required/>
    <input name="vt_quantidade" style="width:100px" id="vt_quantidade" type="text" placeholder="Quantidade" width="60" maxlength="3" required/>
  </fieldset><br />
  <fieldset>
    <label>VR:</label>
    <input name="vr_valor" style="width:100px" id="vr_valor" type="text" placeholder="Valor (R$)" width="60" maxlength="10" required/>
    <input name="vr_dias" style="width:100px" id="vr_dias" type="text" placeholder="Dias" maxlength="3" width="60" required/>
    <input name="vr_desconto" style="width:100px" id="vr_desconto" type="text" placeholder="Desconto (%)" maxlength="3" width="60" required/>
  </fieldset><br />
  <fieldset>
    <label>Assistência médica: R$</label>
    <input name="ass_med" id="assist_med" type="text" width="200" required/>
  </fieldset><br />
  <fieldset>
    <label>Assistência odontológica: R$</label>
    <input name="ass_odonto" id="assist_odont" type="text" width="200" required/>
  </fieldset><br />
  <fieldset>
    <label>Uniforme: R$</label>
    <input name="uniforme" id="uniform" type="text" width="200"/>
  </fieldset><br />
  <fieldset>
    <label>EPI</label>
    <select name="epi" id="epi">
      <option value="sim" selected>Sim</option>
      <option value="nao" selected>Não</option>
    </select>
  </fieldset>  
  <fieldset>  
    <label>R$</label>
    <input name="epi_val" id="epi_val" type="text" width="200"/>
  </fieldset><br />
  <fieldset>
    <label>Outros:</label>
    <input name="outros" id="outros" type="text" width="200"/>
  </fieldset>
  <fieldset>
    <label>Observações:</label>
    <textarea name="obs" id="obs" width="400" placeholder="Especificar"></textarea>
  </fieldset><br />
  
  <center><h3>Dados do cliente</h3></center><br />
  <hr>
  <fieldset>
    <label>Cliente</label>
    <input name="cliente_nome" id="cliente" type="text" width="200" required/>
  </fieldset><br />
  <fieldset>
    <label>Contato</label>
    <input name="cliente_contato" id="contato" type="text" width="200" required/>
  </fieldset>
  <fieldset><br />
    <label>Telefone</label>
    <input name="cliente_telefone" id="telefone" type="text" width="200" required/>
  </fieldset><br />
  <fieldset>
    <label>E-mail</label>
    <input name="cliente_email" id="replyto" type="email" width="200" required/>
  </fieldset><br />
  <hr>
  <fieldset>
    <center><input name="solicita_back" id="Submit" type="submit" value="enviar"/></center>
  </fieldset>
  
</form>