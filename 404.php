<?php get_header(); ?>

<div class="page-row mini">
    <div class="black-wedge light"></div><div class="black-wedge"></div>
    <div class="header-white show-for-medium-up"></div>
    <div class="header-title-container show-for-medium-up">
        <div class="page-title-row row">
            <div class="page-title"><h1><span>404 File Not Found</span></h1></div>
        </div>
    </div>
</div>

<div class="row">
	<div class="small-12 medium-8 columns 404" role="main" id="main-col">
	
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <div class="entry-content">
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
            <?php get_search_form(); ?>
			</div>
		</article>

	</div>
</div>
<?php get_footer(); ?>
