<?php get_head(); ?>

<div class="page-hero" style="background-image: url(http://placehold.it/1500x350)">
    <div class="container">
        <div class="page-info">
            <h2 class="page-info-title">Page Contact</h2>
            <p class="page-info-subtitle">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
        </div>
    </div>
</div>

<section class="pag-section section-primary-condensed">
    <div class='container'>
        <div class='row'>
            <div class='col-lg-12'>
                <!--<h2>Home Theater</h2>-->
                <p class="text-lg text-center">
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium
                </p>
            </div>
        </div>
    </div>
</section>

<section class="pag-section">
    <div class='container'>
        <div class='row'>
            <div class='col-sm-6 col-sm-push-6'>
                <form id="form-contact" action="<?php echo SITE . '/form/send-contact.php' ; ?>" class="ajax-form" method="post" novalidate="novalidate">
                    <div class="form-group">
                        <label for="name" class="input-required">Seu nome</label>
                        <input type="text" name="name" class="form-control" placeholder="Nome" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="input-required">Seu email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@servidor.com.br" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="tel" name="phone" class="form-control mask_phone" placeholder="(00) 0000-0000">
                    </div>
                    <div class="form-group">
                        <label for="loja">Loja</label>
                        <select name="loja" class="form-control">
                            <option value="Loja Grajaú" selected>Loja Grajaú</option>
                            <option value="Loja Campos">Loja Campos</option>
                            <option value="Loja Nova">Loja Nova</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Assunto</label>
                        <input type="text" name="name" class="form-control" placeholder="Assunto do contato">
                    </div>
                    <div class="form-group">
                        <label for="message" class="input-required">Mensagem</label>
                        <textarea name="message" class="form-control" placeholder="Em que podemos ajudar?" required></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-rounded">Enviar cotação</button>
                    </div>
                        
                </form>
            </div>
            <div class='col-sm-6 col-sm-pull-6'>
                <img src="http://placehold.it/500x600">
            </div>

        </div>
    </div>
</section>

<script id="tpt-form-response" type="text/template">
    <div class="painel">
        <h2 class='painel-title'>Mensagem enviada com sucesso!</h2>
        <p class="text-lg">Em breve entraremos em contato.</p>
    </div>
</script>

<?php get_footer(); ?>
