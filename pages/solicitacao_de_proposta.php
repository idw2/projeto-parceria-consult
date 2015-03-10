<?php get_head(); ?>

<div class="page-hero">
    <div class="container">
        <div class="page-info">
            <ol class="breadcrumb">
                <li><a href="<?php echo SITE; ?>">Home</a></li>
                <li><a>Solicitação de proposta</a></li>
            </ol>
        </div>
    </div>
</div>

<section class="pag-section" id='form'>
    <div class='container'>
        <div class='row'>
            <div class="col-lg-12">
                <div class="section-title-centered">
                    <h2>Solicitação de proposta</h2>
                    <p class="text-lg">Aguardamos seu contato</p>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-7 col-sm-offset-2'>
                <form id="form" action="<?php echo SITE . '/form/enviar-proposta.php'; ?>" class="ajax-form form" method="post" novalidate>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="section-title">
                                <!--<h2><span class="entypo-cog" style="margin-right: 6px;"></span> Informações de serviço</h2>-->
                                <h2>Informações de serviço</h2>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <fieldset class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Tipo de serviço</label>
                                <select name="tipo_servico" id="tipo_servico" class="form-control">
                                    <option value="CLT" selected="">CLT</option>
                                    <option value="Temporario">Temporário</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Tempo de contrato</label>
                                <input name="tempo_contrato" id="temp_contrato" type="text" class="form-control" placeholder="Em meses" required>
                            </div>
                        </div>
                    </fieldset>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="section-title">
                                <!--<h2><span class="entypo-user" style="margin-right: 6px;"></span> Informações dos funcionários</h2>-->
                                <h2>Informações dos funcionários</h2>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <fieldset class="row info-funcionarios">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Função</label>
                                <input name="funcao[]" id="funcao" type="text" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Quantidade</label>
                                <input name="quantidade[]" id="qntd" type="tel" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Salário</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="salario[]" id="salario" class="form-control mask-dinheiro" data-add="R$ " type="tel" required="">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <a href="#" class="btn btn-dark" data-before=".info-funcionarios">+ Incluir</a>
<!--                    <fieldset class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <input name="funcao_2" id="funcao2" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <input name="quantidade_2" id="qntd2" type="tel" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="salario_2" id="salario2" class="form-control mask-dinheiro" data-add="R$ " type="tel">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <input name="funcao_3" id="funcao3" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <input name="quantidade_3" id="qntd3" type="tel" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="salario_3" id="salario3" class="form-control mask-dinheiro" data-add="R$ " type="tel">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <input name="funcao_4" id="funcao4" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <input name="quantidade_4" id="qntd4" type="tel" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="salario_4" id="salario4" class="form-control mask-dinheiro" type="tel">
                                </div>
                            </div>
                        </div>
                    </fieldset>-->


                    <hr>


                    <fieldset class="row">
                        <div class="col-xs-12">
                            <label>Vale Transporte</label>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="vt_valor" class="form-control mask-dinheiro" id="vt_valor" type="text" placeholder="" maxlength="10" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <input name="vt_dias" class="form-control" id="vt_dias" type="text" placeholder="Dias" maxlength="3" required="">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <input name="vt_quantidade" class="form-control"  id="vt_quantidade" type="text" placeholder="Quantidade" maxlength="3" required="">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="row">
                        <div class="col-xs-12">
                            <label>Vale Refeição</label>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="vr_valor" class="form-control mask-dinheiro" id="vr_valor" type="text" placeholder="" maxlength="10" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <input name="vr_dias" class="form-control" id="vr_dias" type="text" placeholder="Dias" maxlength="3" required="">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="vr_desconto" class="form-control"  id="vr_desconto" type="text" placeholder="Desconto" data-add="R$ " maxlength="3" required="">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <hr>

                    <fieldset class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Assistência Médica</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="ass_med" class="form-control mask-dinheiro" id="assist_med" type="text" placeholder="" maxlength="10" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Assistência Odontológica</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="ass_odonto" class="form-control mask-dinheiro" id="assist_odont" type="text" placeholder="" maxlength="10" required="">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <hr>

                    <fieldset class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Uniforme</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="uniforme" class="form-control mask-dinheiro" id="uniform" type="text" placeholder="" maxlength="10">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="row">
                        <div class="col-xs-12">
                            <label>EPI</label>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <select name="epi" id="epi" class="form-control">
                                    <option value="nao" selected>Não</option>
                                    <option value="sim">Sim</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input name="epi_val" class="form-control mask-dinheiro" id="epi_val" type="text" placeholder="" maxlength="10">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Outros</label>
                                <input name="outros" class="form-control" id="outros" type="text">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Observações</label>
                                <textarea name="obs" id="obs" class="form-control" placeholder="Especificar"></textarea>
                            </div>
                        </div>
                    </fieldset>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="section-title">
                                <!--<h2><span class="entypo-user" style="margin-right: 6px;"></span> Informações dos funcionários</h2>-->
                                <h2>Dados do cliente</h2>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <fieldset class="row">
                        <div class="col-xs-7">
                            <div class="form-group">
                                <label>Cliente</label>
                                <input name="cliente_nome" id="cliente" class="form-control" type="text" required="">
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Contato</label>
                                <input name="cliente_contato" id="contato" class="form-control" type="text" required="">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input name="cliente_telefone" id="telefone" class="form-control" type="tel" required="">
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="cliente_email" id="replyto" class="form-control" type="email" required="">
                            </div>
                        </div>
                    </fieldset>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-gradient-primary">Enviar formulário</button>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class='col-sm-3 hide-sm'>
                <img src="<?php echo CDN; ?>/img/lines.png">
            </div>
        </div>
    </div>
</section>

<script id="tpt-form-response" type="text/x-handlebars-template">
    <section class="pag-section" style="padding-bottom: 0;">
        <div class='container'>
            <div class='row'>
                <div class="col-lg-12 text-center">
                    <div class="painel painel-lg">
                    <h2 class='painel-title'>{{title}}</h2>
                    <p class="text-lg">{{message}}</p>
                </div>
            </div>
        </div>
    </section>
</script>

<?php get_footer(); ?>
