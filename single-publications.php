<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 columns" role="main">
	
	<?php do_action('foundationPress_before_content'); ?>
			<?php do_action('foundationPress_post_before_entry_content'); ?>
			<div class="entry-content">
				<h1 class="article__title"><a href="/resources/publications/" title="<?php the_title_attribute(); ?>">Publications</a></h2>
			<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php  
/**
 * Publication content
 */

// Publication themes list
$publication_terms = wp_get_post_terms($post->ID, 'publication_theme');
if (!empty($publication_terms)) {
	$publication_terms_arr = array();
	foreach ($publication_terms as &$term) {
		$publication_terms_arr[] = '<a href="/resources/publications/?tax=publication_theme&term=' . $term->slug . '">' . $term->name . '</a>';
	}
	$publication_terms_str = implode(', ', $publication_terms_arr) . ' | ';
	$publication_terms = "";
} else {
	$publication_terms_str = '';	
}

// Publication year list
$publication_years = wp_get_post_terms($post->ID, 'publication_year');
if (!empty($publication_years)) {
	$publication_in_press = get_field('in_press');
	if ($publication_in_press[0] !== '1') {
		$publication_years_arr = array();
		foreach ($publication_years as &$year) {
			$publication_years_arr[] = '<a href="/resources/publications/?tax=publication_year&term=' . $year->slug . '">' . $year->name . '</a>';
		}
		$publication_years_str = implode(', ', $publication_years_arr);
	} else {
		$publication_years_str = '<a href="/resources/publications/?tax=publication_year&term=in-press">In press</a>';	
	}
} else {
	$publication_years_str = '';	
}
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<div class="faculty-title clearfix">
			<h2 class="article__title left">
			<?php if ( is_page() || is_single()) : ?>
				<?php the_title() ?>
			<?php else : ?>
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
			<?php endif ?>
			</h2>
		</div>

	<header class="article__header">
        <div class="article__meta row">
   		<?php if ( is_single() ) : ?>
			<div class="post-meta columns small-12">
			<?php echo $publication_terms_str . $publication_years_str; ?>
			</div>
        <?php endif ?>
        </div>

	</header>

	<section class="article__content">
		<?php
		$publication_link = get_field('publication_link');
		$citation = get_field('publication_citation');
		$abstract = get_field('publication_abstract');
		$publink = get_field('publication_link');
		if (!empty($citation)) {
			echo '<div class="citation"><h3>Citation</h3>' . $citation . '</div>';
		}
		if (!empty($abstract)) {
			echo '<hr /><div class="abstract"><h3>Abstract</h3>';
			echo get_field('publication_abstract');
			echo '</div>';
		}
		?>
		<div class="publication_link">
		<hr />
		<?php if (!empty($publication_link)) { ?>
			<a class="button" href="<?php echo $publication_link; ?>" target="_blank">Download this publication</a>
		<?php } else { ?>
			<a class="button" href="mailto:<?php echo antispambot("cig@uw.edu") ?>?subject=<?php the_title() ?>">Contact us for access to this publication</a>
		<?php } ?>
		</div>
	</section>
    <?php
    remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' );
	?>

</article><!-- .article -->

					<?php endwhile ?>

			<?php endif ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>
				<p><?php the_tags(); ?></p>
			</footer>
			<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
				<div id="after-content" class="after-content widget-area" role="complementary">
					<?php dynamic_sidebar( 'after-content' ); ?>
				</div><!-- #after-content -->
			<?php endif; ?>
		</article>	
	<?php do_action('foundationPress_after_content'); ?>

	</div>
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>
