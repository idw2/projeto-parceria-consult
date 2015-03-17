<?php get_header(); ?>

	<div id="content">
		<?php get_template_part('includes/breadcrumbs'); ?>
	    <article>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
				<div class="entry">
					<?php the_content(''); ?>
					<?php edit_post_link('('.__('Edit', 'themejunkie').')', '', ''); ?>
		  		</div><!-- .entry -->
		    	<?php if(get_option('blacklight_show_page_comments') == 'on') { ?>
			  		<?php comments_template(); ?>
			  	<?php } ?>
			<?php endwhile; ?>
			<?php else : ?>
			<?php endif; ?>
	    </article><!-- article -->
	    <?php get_sidebar(); ?>
	    <div class="clear"></div>
	</div> <!-- #content-->

<?php get_footer(); ?>