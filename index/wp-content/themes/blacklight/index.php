<?php get_header(); ?>

	<?php if((get_option('blacklight_news_ticker_enable') == 'off') && is_home() && !is_paged()){ ?>
		<div id="news-ticker">
		    <span class="text"><?php _e('Breaking News:','themejunkie'); ?></span>
		    <ul class="news">
		        <?php
		        query_posts( array(
		            'tag' => get_option('blacklight_news_ticker_tags'),
		            'showposts' => get_option('blacklight_news_ticker_num')
		        ));
		        if( have_posts() ) : while( have_posts() ) : the_post();
		            ?>
		            <li class="news-ticker">
		                <?php the_time('M d,Y'); ?> - <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themejunkie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a> -  <span class="headline-comment"><?php comments_popup_link( __( '0 Comment', 'themejunkie' ), __( '1 Comment', 'themejunkie' ), __( '% Comments', 'themejunkie' ) ); ?></span>
		            </li>
		            <?php endwhile; endif; wp_reset_query(); ?>
		    </ul><!-- .news -->
			<span class="headline-nav">
				<a class="headline-previous" href="#pre-headline">&larr;</a>
				<a class="headline-next" href="#next-headline">&rarr;</a>
			</span><!-- headline-nav -->
		    <div class="clear"></div>
		</div><!-- #news-ticker -->
	<?php } ?>
	    
	<?php if(!is_paged() && (get_option('blacklight_featured_slider_enable') == 'on')) : ?>
		<?php
		    $featured_tags = get_option('blacklight_featured_post_tags');
		    $featured_num = get_option('blacklight_featured_post_num');
		    if(!preg_match("/^\d*$/",$featured_num)){
		        $featured_num = 3;
		    }
		?>








	<?php endif; ?>
	
	<div id="content">
	    <?php if(!(!is_paged() && (get_option('blacklight_featured_slider_enable') == 'on'))) : ?>
			<?php get_template_part('includes/breadcrumbs'); ?>
	    <?php endif; ?>
		<article>
			<?php if (is_home() && !is_paged()) { ?>		
				<div class="heading">
		            <span class="heading-text"><?php _e('Latest Posts','themejunkie'); ?></span>
		        </div><!-- .heading -->
	        <?php } ?>
			<?php $counter = 1; if (have_posts()) : while ( have_posts() ) : the_post() ?>
		   		<?php include(TEMPLATEPATH. '/includes/loop.php'); ?>
				<?php if ($counter%2 == 0) { echo('<div class="clear"></div>'); } ?>
			<?php $counter ++; endwhile; ?>
		    <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
		        <div class="pagination">
		            <div class="left"><?php previous_posts_link(__('&larr; Newer Entries', 'themejunkie')) ?></div>
		            <div class="right"><?php next_posts_link(__('Older Entries &rarr;', 'themejunkie')) ?></div>
		            <div class="clear"></div>
		        </div> <!-- .pagination -->
		    <?php } ?>
	    </article><!-- article -->
		<?php else : ?>
		<?php endif; ?>
	    <?php get_sidebar(); ?>
	    <div class="clear"></div>
	</div><!-- #content -->

<?php get_footer(); ?>