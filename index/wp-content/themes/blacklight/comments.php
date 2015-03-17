
				<div id="comments">

<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','theme junkie'); ?></p>
	<?php
		return;
	}
?>

<?php $comments_by_type = &separate_comments($comments); ?>    

<!-- You can start editing here. -->

<div id="comments-wrap">

<?php if ( have_comments() ) : ?>

	<?php if ( ! empty($comments_by_type['comment']) ) : ?>

	<h3><?php comments_number(__('No Responses','themejunkie'), __('One Response','themejunkie'), __('% Responses','themejunkie') );?> <?php _e('to','themejunkie'); ?> &#8220;<?php the_title(); ?>&#8221;</h3>

	<ol class="commentlist">
	<?php wp_list_comments('avatar_size=60&callback=custom_comment&type=comment'); ?>
	</ol>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
		<div class="clear"></div>
	</div>
 
	<?php endif; ?>
		
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
    		
        <h3 id="pings"><?php _e('Trackbacks/Pingbacks', 'themejunkie') ?></h3>
    
        <ol class="pinglist">
            <?php wp_list_comments('type=pings&callback=list_pings'); ?>
        </ol>
    	
	<?php endif; ?>

<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
		<p class="nocomments"><?php _e('No comments.','themejunkie'); ?></p>

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.','themejunkie'); ?></p>

	<?php endif; ?>

<?php endif; ?>

</div> <!-- end #comments-wrap -->

<div id="respond">
<div id="comment-form">
<?php if ('open' == $post->comment_status) : ?>


<h3><?php comment_form_title( __('Leave a Reply','themejunkie'), __('Leave a Reply to %s','themejunkie') ); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

<p><?php _e('You must be','themejunkie'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in','themejunkie'); ?></a> <?php _e('to post a comment.','themejunkie'); ?></p>

<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" onsubmit="if (url.value == '<?php _e('Website (optional)','themejunkie'); ?>') {url.value = '';}">

<?php if ( $user_ID ) : ?>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<p><?php _e('Logged in as','themejunkie'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out &raquo;','themejunkie'); ?></a></p>

<textarea rows="9" cols="10" name="comment" tabindex="4" onfocus="if (this.value == '<?php _e('Type your comment here…','themejunkie'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Type your comment here…','themejunkie'); ?>';}"><?php _e('Type your comment here…','themejunkie'); ?></textarea>
<p><button name="submit" type="submit" id="submit" class="submit-button" tabindex="5"><?php _e('Submit Comment', 'themejunkie') ?></button>

<?php else : ?>

<div class="form-left">
<input type="text" name="author" id="author" tabindex="1" value="<?php _e('Name (required)','themejunkie'); ?>" onfocus="if (this.value == '<?php _e('Name (required)','themejunkie'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Name (required)','themejunkie'); ?>';}" />
<input type="text" name="email" id="email" tabindex="2" value="<?php _e('Email (required)','themejunkie'); ?>" onfocus="if (this.value == '<?php _e('Email (required)','themejunkie'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Email (required)','themejunkie'); ?>';}" />
<input type="text" name="url" id="url" tabindex="3" value="<?php _e('Website (optional)','themejunkie'); ?>" onfocus="if (this.value == '<?php _e('Website (optional)','themejunkie'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Website (optional)','themejunkie'); ?>';}" />
<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

</div>
<div class="form-right">
<textarea rows="9" cols="10" name="comment" id="comment" tabindex="4" onfocus="if (this.value == '<?php _e('Type your comment here…','themejunkie'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Type your comment here…','themejunkie'); ?>';}"><?php _e('Type your comment here…','themejunkie'); ?></textarea>

<p><button name="submit" type="submit" id="submit" class="submit-button" tabindex="5"><?php _e('Submit Comment', 'themejunkie') ?></button>

</div>

<?php endif; // If logged in ?>

<?php comment_id_fields(); ?>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>


<?php endif; // if you delete this the sky will fall on your head ?>
<div class="clear"></div>
</div> <!-- end #comment-form -->
</div> <!-- end #respond -->

</div><!-- #comments -->
