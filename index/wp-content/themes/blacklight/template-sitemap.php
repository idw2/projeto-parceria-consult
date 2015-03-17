<?php
/*
Template Name: Sitemap
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
	        <!-- Pages -->
	        <h4><?php _e( 'Pages', 'themejunkie' ); ?>:</h4>
	        <ul>
	            <?php wp_list_pages( 'depth=0&sort_column=menu_order&title_li=' ); ?>
	        </ul>
	        <!-- Categories -->
	        <h4><?php _e('Categories', 'themejunkie'); ?>:</h4>
	        <ul>
	            <?php wp_list_categories('title_li=&show_count=true'); ?>
	        </ul>
	        <!-- Posts per category -->
	        <h4><?php _e( 'Posts per category', 'themejunkie' ); ?>:</h4>
	        <?php
	            $cats = get_categories();
	            foreach ( $cats as $cat ) {
	                query_posts( 'cat=' . $cat->cat_ID );
	       ?>
	        <h4><?php echo $cat->cat_name; ?></h4>
	        <ul>
		        <?php while ( have_posts() ) { the_post(); ?>
		            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> - <?php _e( 'Comments', 'themejunkie' ); ?> (<?php echo $post->comment_count; ?>)</li>
		        <?php }  ?>
	        </ul>
	        <?php } ?>
	        </div><!-- .entry -->
	    </article><!-- article -->
	    <?php get_sidebar(); ?>
	    <div class="clear"></div>
	</div><!-- #content -->

<?php get_footer(); ?>