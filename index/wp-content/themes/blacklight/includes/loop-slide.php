<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if(has_post_thumbnail()){?>
    	<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('featured-thumb', array('class' => 'entry-thumb')); ?></a>
    <?php }?>
    <div class="entry">
	    <h2 class="entry-title">
	        <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	    </h2>
	    <div class="entry-meta">
	        <?php the_time('M d,Y'); ?> - <?php _e('by','theme junkie'); ?> 
	        <span class="entry-author"><?php the_author_posts_link(); ?></span>
	        <span class="entry-comment"><?php comments_popup_link( __( '0', 'theme junkie' ), __( '1', 'theme junkie' ), __( '%', 'theme junkie' ) ); ?></span>
	    </div><!-- .entry-meta -->
	    <div class="entry-content">
	        <?php the_excerpt(); ?>           
	    </div> <!-- .entry-content -->
    </div><!-- .entry -->
</div> <!-- #post-<?php the_ID(); ?> -->