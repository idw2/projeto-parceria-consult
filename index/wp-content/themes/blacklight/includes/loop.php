<div id="post-<?php the_ID(); ?>" class="entry-list <?php if($counter%2 == 0) { echo 'right-col'; } ?> <?php echo 'loop-'.$counter; ?>">

	<?php if (!is_category()) { ?>
		<span class="entry-cat">
		<?php $category = get_the_category();
			if (!empty($category)) { 
				$catlink = get_category_link( $category[0]->cat_ID );
				echo ('<a href="'.$catlink.'">'.$category[0]->cat_name.'</a>');
		}; ?>
		</span>
	<?php } ?>
    <a href="<?php the_permalink(); ?>" rel="bookmark">
        <?php if(has_post_thumbnail()){?>
        <?php the_post_thumbnail('entry-thumb', array('class' => 'entry-thumb')); ?>
        <?php }else{?>
        <?php }?>
    </a><!-- end. entry-thumb -->

    <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

    <div class="entry-meta">
            <?php the_time('M d,Y'); ?> - <?php _e('by','themejunkie'); ?> 
            <span class="entry-author"><?php the_author_posts_link(); ?></span>
            <span class="entry-comment"><?php comments_popup_link( __( '0', 'themejunkie' ), __( '1', 'themejunkie' ), __( '%', 'themejunkie' ) ); ?></span>
    </div><!-- .entry-meta -->

    <div class="entry-content">
        <?php the_excerpt(''); ?>
	</div> <!-- .entry-content -->

<?php if (get_option('blacklight_home_share_enable') == 'on') { ?>
	<div class="entry-share">
		<div class="btn-tweet">
		    <a href="http://twitter.com/share" class="twitter-share-button"
		    data-url="<?php the_permalink(); ?>"
		    data-via=""
		    data-text="<?php the_title(); ?>"
		    data-related=""
		    data-count="horizontal">Tweet</a>
		</div><!-- .btn-tweet -->
		<div class="btn-like">
		    <fb:like href="<?php the_permalink(); ?>" layout="button_count" show_faces="false" width="100" font=""></fb:like>
		</div><!-- .btn-like -->
		<div class="btn-plus">
			<g:plusone size="medium"></g:plusone>
		</div><!-- .btn-plus -->
	</div><!-- .entry-share -->
<?php } ?>
                       
</div> <!-- end #post-<?php the_ID(); ?> -->