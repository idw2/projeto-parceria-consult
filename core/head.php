<?php
if (isset($_GET['url']) && $_GET['url'] != "") {
    $page = $_GET['url'];
} else {
    $page = 'home';
};
?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <title>Joker Boilerplate</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta content="True" name="HandheldFriendly" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="viewport" content="width=device-width" />
        <link rel="shortcut icon" href="<?php echo SITE; ?>/static/img/favicon.png">

        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/entypo.min.css">
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/animate.min.css" />
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/flexslider.css" />
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/nivo-lightbox/nivo-lightbox.css" />
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/nivo-lightbox/themes/default/default.css" />
        
        <link rel="stylesheet" href="<?php echo SITE; ?>/static/css/style.css" />


        <script src="<?php echo SITE; ?>/static/js/modernizr.custom.js"></script>
        <!--[if IE 8]>
              <link href="css/ie8.css" rel="stylesheet" />
              <script src="js/respond.js"></script>	
        <![endif]-->
    </head>
    <body>

        <header id="header" class="navbar navbar-fixed-top navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a href="#" class="hamburger"><span></span></a>
                    <a class="brand" href="<?php echo SITE; ?>">Joker Boilerplate</a>
                </div>
                <nav class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="<?php echo set_active($page, 'home,'); ?>">
                            <a href="<?php echo SITE; ?>/">Home</a>
                        </li>
                        <li class="dropdown-hover <?php echo set_active($page, 'dropdown,dropdown/page-1'); ?>">
                            <a href="<?php echo SITE ?>/dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo SITE ?>/dropdown/page-1">Page 1</a></li>
                                <li><a href="<?php echo SITE ?>/dropdown/page-2">Page 2</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>