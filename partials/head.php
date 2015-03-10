<?php
$seo = new SEO();
$page = $seo->get_slug();
$title = $seo->get_title();
$description = $seo->get_description();
$author = SEO::author;
?>
<!DOCTYPE html>
<html class="no-js">
    <head>

        <title><?php echo $title; ?></title>
        <meta name="title" content="<?php echo $title; ?>">
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="author" content="<?php echo $author; ?>">

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="shortcut icon" href="<?php echo SITE; ?>/static/img/favicon.png">

        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/entypo.min.css">
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/animate.min.css" />
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/flexslider.css" />
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/plugins/layerslider/css/layerslider.css" />
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/nivo-lightbox/nivo-lightbox.css" />
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/nivo-lightbox/themes/default/default.css" />

        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/style.css" />


        <script src="<?php echo SITE; ?>/static/js/modernizr.custom.js"></script>
        <!--[if IE 8]>
              <link href="css/ie8.css" rel="stylesheet" />
              <script src="js/respond.js"></script>	
        <![endif]-->
    </head>
    <body class="<?php body_class(); ?>">
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-50685413-4', 'auto');
            ga('send', 'pageview');

        </script>

        <header id="header" class="navbar navbar-static-top navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a href="#" class="hamburger"><span></span></a>
                    <a class="brand" href="<?php echo SITE; ?>">Parceria Consult</a>
                </div>
                <nav class="collapse navbar-collapse">
                    <div class='navbar-row navbar-row-top'>
                        <ul class="navbar-right navbar-nav-top">
                            <li class="<?php echo set_active($page, 'solicitacao-de-proposta'); ?>">
                                <a href="<?php echo SITE; ?>/solicitacao-de-proposta" class='btn btn-gradient-primary btn-rounded'>Solicitação de proposta</a>
                            </li>
                            <li>
                                <a href="http://estagiarios.parceriaconsult.com.br" class='btn btn-gradient-primary btn-with-icon btn-rounded'><span class='btn-icon entypo-lock'></span> Área restrita</a>
                            </li>
                        </ul>
                    </div>
                    <div class='navbar-row'>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="<?php echo set_active($page, 'home'); ?>">
                                <a href="<?php echo SITE; ?>/">Home</a>
                            </li>
                            <li class="<?php echo set_active($page, 'a-parceria'); ?>">
                                <a href="<?php echo SITE; ?>/a-parceria">A Parceria</a>
                            </li>
                            <li class="dropdown-hover <?php echo set_active($page, 'servicos,dropdown/page-1'); ?>">
                                <a href="<?php echo SITE; ?>/servicos">Serviços</a>
                                <ul class="dropdown-menu">
                                    <li><a href='<?php echo SITE; ?>/servicos#trabalho-temporario'>Trabalho Temporário</a></li>
                                    <li><a href='<?php echo SITE; ?>/servicos#terceirizacao-de-servicos'>Terceirização de Serviços</a></li>
                                    <li><a href='<?php echo SITE; ?>/servicos#treinamento'>Treinamento</a></li>
                                    <li><a href='<?php echo SITE; ?>/servicos#recrutamento-e-selecao'>Recrutamento e Seleção</a></li>
                                    <li><a href='<?php echo SITE; ?>/servicos#agente-de-integracao-de-estagiario'>Agente de integração de estagiário</a></li>
                                    <li><a href='<?php echo SITE; ?>/servicos#avaliacao-de-potencial'>Avaliação de potencial</a></li>
                                </ul>
                            </li>
                            <li class="<?php echo set_active($page, 'cadastre-seu-curriculum'); ?>">
                                <a href="http://www.vagas.com.br/parceriaconsult" target="_blank">Cadastre seu Currículum</a>
                            </li>
                            <li class="<?php echo set_active($page, 'afiliados'); ?>">
                                <a href="<?php echo SITE; ?>/afiliados">Afiliados</a>
                            </li>
                            <li class="<?php echo set_active($page, 'contato'); ?>">
                                <a href="<?php echo SITE; ?>/contato">Contato</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <div class='content-wrapper'>