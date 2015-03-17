<!DOCTYPE html>
<head><!-- THEMESTORE.ORG -->
<meta charset="<?php bloginfo('charset'); ?>" />
<?php if( $pagename == "solicitacao-de-clientes" ){ ?>
<meta charset="UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<title><?php tj_custom_titles(); ?></title>
<?php tj_custom_description(); ?>
<?php tj_custom_keywords(); ?>
<?php tj_custom_canonical(); ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" class="main-style" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/colors/<?php echo get_option('blacklight_theme_stylesheet');?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/custom.css" />
<script src="http://parceriaconsult.com.br/index/wp-content/themes/blacklight/jquery.js"></script>

<script>
$(document).ready(function(){
$('a[href="http://www.vagas.com.br/parceriaconsult?url=http://www.parceriaconsult.com.br/index.asp"]').attr('href', "http://www.vagas.com.br/parceriaconsult");
});
</script>

<?php if( $pagename == "solicitacao-de-clientes" ){ ?> 
<script src="http://parceriaconsult.com.br/index/wp-content/themes/blacklight/validacao.js"></script>
<script src="http://parceriaconsult.com.br/index/wp-content/themes/blacklight/mask.js"></script>
<script src="http://parceriaconsult.com.br/index/wp-content/themes/blacklight/js_solicita.js"></script> 
<?php } ?>
<?php wp_head(); ?>
</head>
<?php if (is_home() || is_archive() || is_search() ) add_filter('img_caption_shortcode', create_function('$a, $b, $c','return $c;'), 10, 3); ?>
<body <?php body_class(); ?>>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50685413-4', 'parceriaconsult.com.br');
  ga('send', 'pageview');

</script>


    <span id="home-url" class="<?php bloginfo( 'template_url' ); ?>" style="display: none;" ></span>
<!-- #primary-nav -->
    <header>
    	<div class="inner-wrap">
        
        <div class="social"> <a href="https://www.facebook.com/pages/Parceria-Consultoria-Empresarial-Ltda/201838909894780" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/facebook.png" border="0"></a> <a href="https://plus.google.com/u/0/102554160270292862985/about?hl=pt-BR" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/google.png" border="0"></a> <a href="http://twitter.com/#!/parceriavagas" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/twitter.png" border="0"></a>
        </div>
        
                <div class="login">
                <font color="#FFFFFF">Login: </font><input type="text" name="login" style="width:126px"/>
                <font color="#FFFFFF">Senha: </font><input type="password" name="senha" style="width:126px"/>
                <input type="button" name="ir" class="login_ir" src="<?php bloginfo('template_directory'); ?>/images/ir.jpg"/>
                </div>
        
	        <?php if (get_option('blacklight_text_logo_enable') == 'on') { ?>
		        <div id="text-logo">
		            <h1 id="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
		            <p id="site-desc"><?php bloginfo('description'); ?></p>
		        </div> <!-- #text-logo -->
	        <?php } else { ?>
		        <a href="<?php bloginfo('url'); ?>"><?php $logo = (get_option('blacklight_logo') <> '') ? get_option('blacklight_logo') : get_bloginfo('template_directory').'/images/logo.png'; ?><img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>" id="logo"/></a>
	        <?php }?>
	        <?php if(get_option('blacklight_header_ad_enable') == 'on') { ?>
	        	<div class="header-ad">
	        		<?php echo get_option('blacklight_header_ad_code'); ?>
	        	</div><!-- .header-ad -->
	        <?php } else { ?>
	            <!--<div id="header-search">
					<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
						<input type="text" class="field" name="s" id="s" title="field" />
						<input class="submit btn" type="image" src="<?php bloginfo('template_directory'); ?>/images/ico-search.png" title="Go" alt="search" />
					</form>                
	            </div>--><!-- #header-search -->
            <?php } ?>
            <div class="clear"></div>
	        <nav id="secondary-nav">
				<?php $menuClass = 'nav';
				$menuID = 'secondary-navigation';
				$secondaryNav = '';
				if (function_exists('wp_nav_menu')) {
					$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-nav', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
				};
				if ($secondaryNav == '') { ?>
					<ul id="<?php echo $menuID; ?>" class="<?php echo $menuClass; ?>">
						<li class="first"><a href="<?php bloginfo('url'); ?>"><?php _e('Home', 'themejunkie') ?></a></li>					
						<?php show_categories_menu($menuClass,false,false); ?>
					</ul>
				<?php }	else echo($secondaryNav); ?>
			</nav><!-- #secondary-nav -->
		</div><!-- .inner-wrap -->
	</header> <!-- header-->
	<div class="clear"></div>
	<div id="wrapper">
    
    <IFRAME src="<?php bloginfo( 'template_url' ); ?>/lofslidernews" frameBorder=0 width=1020 height=300 scrolling=no></IFRAME>
