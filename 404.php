<?php get_header(); ?>
<div class="row page-content" id="main-col">
	<div class="columns small-12" role="main" style="width: 100% !important;">
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="entry-content">
				<div class="article__content">
				<form role="search" method="get" class="search-form" action="http://fish.uw.edu/">
					  <div class="field-wrap">
						<label for="s">Search Field</label>
					    <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search this site">
					    <button type="submit"><i class="fi-magnifying-glass"></i><span>Search</span></button>
					  </div>
					</form>
					<?php if ($wp_query->found_posts): ?>
					<div class="panel">
						<div class="left"><?php echo $wp_query->found_posts; ?> results for <strong>"<?php echo get_search_query(); ?>"</strong></div>
					</div>
					<?php endif; ?>
				<div class="error">
					<p class="bottom"><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'FoundationPress'); ?></p>
				</div>
				<p><?php _e('Please try the following:', 'FoundationPress'); ?></p>
				<ul> 
					<li><?php _e('Check your spelling', 'FoundationPress'); ?></li>
					<li><?php printf(__('Return to the <a href="%s">home page</a>', 'FoundationPress'), home_url()); ?></li>
					<li><?php _e('Click the <a href="javascript:history.back()">Back</a> button', 'FoundationPress'); ?></li>
                    <li><?php _e('Search the site', 'FoundationPress'); ?></li>
				</ul>
        </div>
			</div>
		</article>
	<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
		<div id="after-content" class="before-content widget-area" role="complementary">
			<?php dynamic_sidebar( 'after-content' ); ?>
		</div><!-- #after-content -->
	<?php endif; ?>
	<a href="#" class="back-to-top">Back to Top</a>
	<?php do_action('foundationPress_before_content'); ?>
	</div>
</div>
<?php get_footer(); ?>