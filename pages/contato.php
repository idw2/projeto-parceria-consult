<?php get_head(); ?>

<div class="page-hero">
    <div class="container">
        <div class="page-info">
            <ol class="breadcrumb">
                <li><a href="<?php echo SITE; ?>">Home</a></li>
                <li><a href="<?php echo SITE; ?>/contato">Contato</a></li>
            </ol>
        </div>
    </div>
</div>

<section class="pag-section" id="form">
    <div class='container'>
        <div class='row'>
            <div class="col-lg-12">
                <div class="section-title-centered">
                    <h2>Fale conosco</h2>
                    <p class="text-lg">Aguardamos seu contato</p>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-6 col-sm-push-6'>
                <form action="<?php echo SITE . '/form/enviar-contato.php'; ?>" class="ajax-form" method="post" novalidate>
                    <div class="form-group">
                        <input type="text" name="nome" class="form-control" placeholder="Seu nome *" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Seu email *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="empresa" class="form-control" placeholder="Empresa">
                    </div>
                    <div class="form-group">
                        <input type="text" name="site" class="form-control" placeholder="Site">
                    </div>
                    <div class="form-group">
                        <input type="tel" name="telefone" class="form-control mask_phone" placeholder="Telefone para contato">
                    </div>
                    <div class="form-group">
                        <select value="" name="perfil" class="form-control">
                            <option value="-">Qual o seu perfil?</option>
                            <option value="" disabled="">-</option>
                            <option value="Sou visitante">Sou visitante</option>
                            <option value="Sou candidato(a) a uma vaga oferecida">Sou candidato(a) a uma vaga oferecida</option>
                            <option value="Sou estudante não cadastrado">Sou estudante não cadastrado</option>
                            <option value="Sou estudante cadastrado">Sou estudante cadastrado</option>
                            <option value="Sou responsável por um(a) estudante cadastrado">Sou responsável por um(a) estudante cadastrado</option>
                            <option value="Já sou formado">Já sou formado</option>
                            <option value="Sou estagiário da Parceria">Sou estagiário da Parceria</option>
                            <option value="Sou de uma empresa parceira da Parceria">Sou de uma empresa parceira da Parceria</option>
                            <option value="Sou instituição de ensino cadastrada">Sou instituição de ensino cadastrada</option>
                            <option value="Sou instituição de ensino não cadastrada">Sou instituição de ensino não cadastrada</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="assunto" class="form-control">
                            <option value="-">Assunto</option>
                            <option value="" disabled="">-</option>
                            <option value="Dúvidas">Dúvidas</option>
                            <option value="Críticas">Críticas</option>
                            <option value="Sugestões">Sugestões</option>
                            <option value="Agradecimentos">Agradecimentos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="mensagem" class="form-control" placeholder="Mensagem *" required></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-gradient-primary">Enviar cotação</button>
                    </div>

                </form>
            </div>
            <div class='col-sm-6 col-sm-pull-6'>
                <img src="<?php echo CDN; ?>/img/predio-2.jpg">
            </div>

        </div>
    </div>
</section>
<div class="container">
    <hr>
</div>
<section class="pag-section">
    <div class='container'>
        <div class='row'>
            <div class="col-lg-12">
                <div class="section-title-centered">
                    <h2>Onde estamos</h2>
                    <p class="text-lg">Nossos escritórios</p>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-5'>
                <iframe src="https://maps.google.com.br/maps?wmode=transparent&amp;f=q&amp;source=s_q&amp;hl=pt-BR&amp;geocode=&amp;q=Centro+do+Rio+de+Janeiro+%E2%80%93+Rua+Uruguaiana+n%C2%BA+10,+sala+2206+&amp;aq=&amp;sll=-22.38124,-41.773721&amp;sspn=0.008185,0.013937&amp;ie=UTF8&amp;hq=&amp;hnear=R.+Uruguaiana,+10+-+Centro,+Rio+de+Janeiro,+20050-090&amp;t=m&amp;ll=-22.906301,-43.178673&amp;spn=0.018342,0.040426&amp;z=14&amp;iwloc=A&amp;output=embed" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="100%" height="250" style="margin-bottom: 25px;"></iframe>
            </div>
            <div class='col-sm-5'>
                <h3>Matriz</h3>
                <p class="text-lg">Rua Uruguaiana, 10 - Sala 2206<br>
                    Centro – Rio de Janeiro<br>
                    Cep.: 20050-090<br>
                    Tel: (21) 2224-9845<br>
                    Fax: (21) 2509-1158</p>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-5'>
                <iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3705.51524572735!2d-41.328051200000004!3d-21.760310999999998!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xbdd449b0fe2f77%3A0x1e4585fe83f035b6!2sR.+Primeiro+de+Maio%2C+69+-+Centro%2C+Campos+dos+Goytacazes+-+RJ!5e0!3m2!1spt-BR!2sbr!4v1417200885790" style="margin-bottom: 25px;"></iframe>
            </div>
            <div class='col-sm-5'>
                <h3>Filial</h3>
                <p class="text-lg">Rua Primeiro de Maio 69/71 Cond. Ouro Negro – Sala 104<br>
                    Centro – Campos do Goytacazes<br>
                    Cep.: 28035-145<br>
                    Tel.: (22) 2738-0407</p>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-5'>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3689.2707548444214!2d-41.7738957!3d-22.3811482!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9630626fcdc16f%3A0x22f48e62c890c0aa!2sRua+Dr.+Zamenhof%2C+213+-+Centro%2C+Maca%C3%A9+-+RJ!5e0!3m2!1spt-BR!2sbr!4v1417200957832" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="100%" height="250" style="margin-bottom: 25px;"></iframe>
            </div>
            <div class='col-sm-5'>
                <h3>Filial</h3>
                <p class="text-lg">Rua Dr. Zamenhoff, 213<br>
                    Imbetiba – Macaé<br>
                    Cep.: 27913-290<br>
                    Tel.: (22) 2759-2601</p>
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
        </div>
        <div class="container text-center">
            <img src="http://parceriaconsult.com.br/novo/static/img/footer-lines.png">
        </div>
    </section>
</script>

<?php get_footer(); ?>
