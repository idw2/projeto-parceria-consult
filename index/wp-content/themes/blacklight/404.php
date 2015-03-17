<?php get_header(); ?>

	<div id="content">
		<?php get_template_part('includes/breadcrumbs'); ?>
	    <article>
	        <h1 class="page-title"><?php _e('404 Page','themejunkie'); ?></h1>
	        <div class="entry">
	            <?php the_post(); ?>
	            <p><?php _e('The page you\'ve requested <strong>can not be displayed</strong>. It appears you\'ve missed your intended destination, either through a bad or outdated link, or a typo in the page you were hoping to reach.','themejunkie') ?></p>
	        </div><!-- .entry -->
	    </article><!-- article -->
	    <?php get_sidebar(); ?>
	    <div class="clear"></div>
	</div><!-- #content -->
	
<?php get_footer(); ?>