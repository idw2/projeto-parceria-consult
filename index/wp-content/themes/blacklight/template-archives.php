<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

	<div id="content">
		<?php get_template_part('includes/breadcrumbs'); ?>
	    <article>
	        <h1 class="page-title"><?php the_title(); ?></h1>
	        <div class="entry">	        
		        <?php if ( have_posts() ) { the_post(); ?>
		            <?php the_content(); ?>
		        <?php } ?>
		        <!-- Recent Posts -->
		        <h4><?php _e('Recent 50 Posts', 'themejunkie'); ?>:</h4>
		        <ul>
		            <?php wp_get_archives('type=postbypost&limit=50&format=custom&before=<li>&after=</li>'); ?>
		        </ul>
		        <!-- Post Categoryies -->
		        <h4><?php _e('Post Categories', 'themejunkie'); ?>:</h4>
		        <ul>
		            <?php wp_list_categories('title_li='); ?>
		        </ul>
		        <!-- Monthly Archives -->
		        <h4><?php _e('Monthly Archives', 'themejunkie'); ?>:</h4>
		        <ul>
		            <?php wp_get_archives('type=monthly'); ?>
		        </ul>
	    	</div> <!-- .entry -->
	    </article><!-- article -->
	
	    <?php get_sidebar(); ?>
	    <div class="clear"></div>
	</div><!-- #content -->

<?php get_footer(); ?>
