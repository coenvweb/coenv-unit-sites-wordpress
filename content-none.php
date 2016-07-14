<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */
?>

<header class="page-header">
	<h1 class="page-title"><?php _e( 'Nothing Found', 'FoundationPress' ); ?></h1>
</header>

<div class="page-content">
	<?php if ( is_search() ) : ?>

	<p><?php _e( 'Sorry, but there are no results for your search terms. Please try again with some different keywords.', 'FoundationPress' ); ?></p>

	<?php else : ?>

	<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'FoundationPress' ); ?></p>
	<?php get_search_form(); ?>

	<?php endif; ?>
</div>
