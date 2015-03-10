<?php get_head(); ?>

<style>
    .btn-success {
        color: #5cb85c;
        background-color: #5cb85c;
        border: #4cae4c solid 2px !important;
        background: transparent;
    }
</style>

<div id="layerslider" class="hero slider-full" style="width:100%;height:600px;">
    <div class="ls-slide" data-ls="transition2d:1;timeshift:0;">
        <div class="ls-l" style="top:215px;left:70px;white-space: nowrap;z-index:20" data-ls="offsetxin:-50;delayin:200;offsetxout:-50;">
            <h2 class="ls-title">Seleção e <br>Recrutamento</h2>
            <p class="ls-text">Temos como objetivo estabelecer uma autêntica parceria com os clientes, <br/>visando, através de sólidas metodologias, técnicas
                e aperfeiçoamento, <br/>assegurar o desenvolvimento e a excelência profissional.</p>
            <a href="<?php echo SITE; ?>/a-parceria" class="btn btn-success">Saiba mais</a>
        </div>
        <img class="ls-l" style="top:50px;left:220px;white-space: nowrap;z-index:10" data-ls="offsetxin:50;delayin:400;offsetxout:50;" src="<?php echo SITE; ?>/static/img/hero-slider-2.png" alt="">
    </div>
    <div class="ls-slide" data-ls="transition2d:1;timeshift:0;">
        <div class="ls-l" style="top:215px;left:70px;white-space: nowrap;z-index:20" data-ls="offsetxin:-50;delayin:200;offsetxout:-50;">
            <h2 class="ls-title">Conheça nossas <br>Oportunidades</h2>
            <p class="ls-text">Cadastre seu currículum</p>
            <a href="http://www.vagas.com.br/parceriaconsult" class="btn btn-success">Saiba mais</a>
        </div>
        <img class="ls-l" style="top:50px;left:220px;white-space: nowrap;z-index:10" data-ls="offsetxin:50;delayin:400;offsetxout:50;" src="<?php echo SITE; ?>/static/img/hero-slider-1.png" alt="">
    </div>
</div>

<!--
<div id="layerslider" class="hero slider-full" style="width:100%;height:600px;">
    <div class="ls-slide" data-ls="transition2d:1;timeshift:0;">
        <div class="ls-l" style="top:215px;left:70px;white-space: nowrap;z-index:20" data-ls="offsetxin:-50;delayin:200;offsetxout:-50;">
            <h2 class="ls-title">Seleção e <br>Recrutamento</h2>
            <p class="ls-text">Temos como objetivo estabelecer uma autêntica parceria com os clientes, <br/>visando, através de sólidas metodologias, técnicas
                e aperfeiçoamento, <br/>assegurar o desenvolvimento e a excelência profissional.</p>
            <a href="<?php echo SITE; ?>/a-parceria" class="btn btn-outline btn-outline-success">Saiba mais</a>
        </div>
        <img class="ls-l" style="top:50px;left:220px;white-space: nowrap;z-index:10" data-ls="offsetxin:50;delayin:400;offsetxout:50;" src="<?php echo SITE; ?>/static/img/hero-slider-2.png" alt="">
    </div>
    <div class="ls-slide" data-ls="transition2d:1;timeshift:0;">
        <div class="ls-l" style="top:215px;left:70px;white-space: nowrap;z-index:20" data-ls="offsetxin:-50;delayin:200;offsetxout:-50;">
            <h2 class="ls-title">Conheça nossas <br>Oportunidades</h2>
            <p class="ls-text">Cadastre seu currículum</p>
            <a href="http://www.vagas.com.br/parceriaconsult" class="btn btn-outline btn-outline-success">Saiba mais</a>
        </div>
        <img class="ls-l" style="top:50px;left:220px;white-space: nowrap;z-index:10" data-ls="offsetxin:50;delayin:400;offsetxout:50;" src="<?php echo SITE; ?>/static/img/hero-slider-1.png" alt="">
    </div>
</div>-->

<section class="pag-section pag-section-nopadding section-shadow">
    <div class='container'>
        <div class='row'>
            <a href="<?php echo SITE; ?>/qualidade" class='col-sm-3 painel-mini'>
                <div class="painel-mini-title">Qualidade</div>
                <div class="painel-mini-text">Sabemos que quando uma empresa procura uma prestadora de serviços é porque necessita de maior eficiência...</div>
            </a>
            <a href="<?php echo SITE; ?>/assessoria" class='col-sm-3 painel-mini'>
                <div class="painel-mini-title">Assessoria</div>
                <div class="painel-mini-text">O diferencial da Parceria é que desenvolvemos para cada cliente um projeto para suprir as suas necessidades.</div>
            </a>
            <a href="<?php echo SITE; ?>/lei-do-estagio" class='col-sm-3 painel-mini'>
                <div class="painel-mini-title">Lei do Estágio</div>
                <div class="painel-mini-text">Dispõe sobre o estágio de estudantes; altera a redação do art. 428 da Consolidação das Leis do Trabalho – CLT...</div>
            </a>
            <a href="<?php echo SITE; ?>/servicos" class='col-sm-3 painel-mini'>
                <div class="painel-mini-title">Serviços</div>
                <div class="painel-mini-text">Conheça todos os tipos de serviços que nos da Parceria Consult podemos oferecer para o seu crescimento.</div>
            </a>
        </div>
    </div>
</section>

<section class="pag-section">
    <div class='container'>
        <div class='row'>
            <div class='col-sm-4'>
                <div class='panel panel-default'>
                    <div class='panel-heading'>NOVAS OPORTUNIDADES</div>
                    <div class='panel-body'>
                        <ul id="ticker" class='list-unstyled list-vagas' style="max-height: 280px;overflow: hidden;">
                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v582608</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>DESP. DE GERAÇÃO E TRANSMISSÃO</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Brasil</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 10/7 - 5 posições</a></p>
                            </li>
                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v594899</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>ASSISTENTE DE COBRANÇA</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 2/8 - 1 posição</a></p>
                            </li>
                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v594678</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>TÉCNICO EM METEOROLOGIA</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 2/8 - 1 posição</a></p>
                            </li>

                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v593846</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>ESTAGIO CIÊNCIAS ATUARIAIS / ESTATÍSTICA</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR - aberta em 31/7 - 1 posição</a></p>
                            </li>

                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v593827</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>COMPRADOR TÉCNICO</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 31/7 - 1 posição</a></p>
                            </li>

                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v593402</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>ASSISTENTE FINANCEIRO</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 31/7 - 1 posição</a></p>
                            </li>

                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v591610</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>ESTAGIÁRIO DE DIREITO TRIBUTÁRIO</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 26/7 - 1 posição</a></p>
                            </li>

                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v590092</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>SECRETÁRIA EXECUTIVA BILINGUE</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 24/7 - 1 posição</a></p>
                            </li>

                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v589882</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>ASSISTENTE CONTÁBEL</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Rio de Janeiro/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 24/7 - 1 posição</a></p>
                            </li>

                            <li>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><small>v589610</small></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank"><strong>TÉCNICO EM ELETRÔNICA</strong></a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">Barra Mansa/RJ/BR</a></p>
                                <p><a href='http://www.vagas.com.br/parceriaconsult' target="_blank">aberta em 23/7 - 2 posições</a></p>
                            </li>
                        </ul>

                        <a href='http://www.vagas.com.br/parceriaconsult' target="_blank" class='btn btn-gradient-primary btn-block'>Ver Todas as Vagas</a>
                    </div>
                </div>
            </div>
            <div class='col-sm-8'>
                <div class="section-title">
                    <h2>OBJETIVO DA PARCERIA</h2>
                    <p class="text-lg">Excelência para você e sua empresa</p>
                </div>
                <p class="text-md">Estabelecer uma autêntica parceria com os clientes, visando, através de sólidas metodologias, técnicas e aperfeiçoamento, assegurar o desenvolvimento e a excelência profissional.</p>
                <p class="text-md">Esta é a proposta de nossa empresa, cuja trajetória, ao longo de vários anos de atuação no mercado, solidificou-se com base no trabalho de uma equipe altamente capacitada, com vasta experiência em Recursos Humanos nas Áreas de Recrutamento, Seleção, Avaliação Psicológica, Treinamento, Trabalho Temporário e Terceirização de Serviços e Agente de Integração de Estagiários.</p>
                <p>
                    <a href='<?php echo SITE; ?>/servicos' class='btn btn-gradient-primary' style='margin-top: 30px'>Nossos serviços</a>
                    <a href='<?php echo SITE; ?>/solicitacao-de-proposta' class='btn btn-gradient-primary' style='margin-top: 30px'>Solicitação de proposta</a>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="pag-section pag-section-nopadding section-dark section-painel-wrap pag-section-neutral">
    <div class='container text-center'>
        <div class='row'>
            <div class='col-sm-12'>
                <div class='section-painel'>
                    <div>
                        <p class='title-lg-plus'>
                            Oportunidades <img src="<?php echo CDN; ?>/img/assets/logo-sebrae-branca.png" alt="SEBRAE" width='150'/>
                        </p>
                        <p class='title-lg-plus' style='margin-top: 50px'>
                            <a href='<?php echo SITE; ?>/oportunidades/sebrae' class='btn btn-gradient-primary'>Oportunidades</a> 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pag-section">
    <div class='container'>
        <div class='row'>
            <div class='col-sm-7'>
                <div class='section-title'>
                    <h2>Dicas Parceria</h2>
                    <p class='text-lg'>Para se preparar antes da entrevista</p>
                </div>
                <p class='text-md'><a href='<?php echo SITE; ?>/dicas#1'><strong>1. Informe-se:</strong></a> <br/>Mesmo que o anúncio da vaga responda a tudo que você gostaria de saber...</p>
                <p class='text-md'><a href='<?php echo SITE; ?>/dicas#2'><strong>2. Currículo:</strong></a> <br/>Revise e reveja seu currículo, tenha uma cópia dele consigo no momento...</p>
                <p class='text-md'><a href='<?php echo SITE; ?>/dicas#3'><strong>3. Evite emergências:</strong></a> <br/>Na véspera, durma bem e se alimente de forma segura.</p>
                <p>
                    <a href='<?php echo SITE; ?>/dicas' class='btn btn-outline' style='margin-top: 25px'>Mais dicas</a>
                </p>
            </div>
            <div class='col-sm-5'>
                <div class='section-title'>
                    <h2>Novidades</h2>
                    <p class='text-lg'>Atualizações recentes</p>
                </div>
                <ul class='list'>
                    <li>
                        <a href='<?php echo CDN; ?>/files/pdf/Avaliacao-Petrobras-Contrato-4600431770_BAD.pdf'>Avaliação Petrobras Contrato 4600431770 – BAD</a>
                    </li>
                    <li>
                        <a href='<?php echo CDN; ?>/files/pdf/Manual-do-Candidato_Analista-tecnico-I-PCD.pdf'>Manual do Candidato – Analista técnico I PCD</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>