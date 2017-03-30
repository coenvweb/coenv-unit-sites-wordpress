<?php
/*
Template Name: Student Blog
*/
?>

<?php get_header(); ?>
<?php $blog_slug->slug; ?>
<div class="row">
	<div class="columns large-12 section-title right">
		<h1><a href="/students">Students</a></h1>
	</div>
	<?php //if (!is_front_page() && function_exists('bcn_display')): ?>
	<!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
	<?php //endif; ?>
	<div class="small-12 medium-8 columns" role="main" id="main-col">
			<div class="news clearfix">
				<div class="share right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
		data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
		data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
        </div>
		<h1 class="article__title">Student Blog</h1>
		<hr />
	<?php do_action('foundationPress_before_content'); ?>
	<?php do_action('foundationPress_post_before_entry_content'); ?>
	</ul>

		<!--
		<div class="share right" data-article-id="<?php //the_ID(); ?>" data-article-title="<?php //echo get_the_title(); ?>"
			data-article-shortlink="<?php //echo wp_get_shortlink(); ?>"
			data-article-permalink="<?php //echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
		</div>
	-->
		<?php
		$rows = get_field('blog_link');
		echo '<div class="blog-list-item">';
		echo '<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
		






		echo '<div class="blog-meta">';
		echo '<p>';
		echo get_the_date('M j, Y');
		echo ' / ';
		echo get_the_term_list( $post->ID, 'blog_category', '', ', ', '' );
		echo '</p>';
		echo '</div>';




		echo '<div class="post">';
		# The Loop
		while ( have_posts() ) : the_post();
		echo the_content();
		endwhile;
		echo '<div class="blog-links right">';
		if($rows) {
			foreach($rows as $row) {
				if($row['blog_link_type'] == 'upload') {
					echo '<a class="button" href="' . $row['blog_upload_file'] . '" target="_blank">' . $row['blog_file_link_text'] . '</a>';
				} elseif ($row['blog_link_type'] == 'link') {
					echo '<a class="button" href="' . $row['blog_link_url'] . '" target="_blank">' . $row['blog_link_text'] . '</a>';
				} 
			}
		}
		echo '</div>';
		echo '<a class="left" style="margin-right: 2rem;" href="' . get_the_permalink() . '">';

		if ( has_post_thumbnail() ) {
			$img_id = get_post_thumbnail_id($post->ID); // This gets just the ID of the img
			$image = wp_get_attachment_image_src($img_id, $optional_size); // Get URL of the image, and size can be set here too (same as with get_the_post_thumbnail, I think)
			$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);



			$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		echo '<a href="' . $large_image_url[0] . '" title="' . $alt_text . '">';





		the_post_thumbnail( 'medium' );
		echo '</a>';
}
		echo '</div>';
		echo '</div>';

		wp_reset_postdata();?>
	</div>
	<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
	<div id="after-content" class="after-content widget-area" role="complementary">
		<?php dynamic_sidebar( 'after-content' ); ?>
	</div><!-- #after-content -->
	<?php endif; ?>
	<a href="#" class="back-to-top">Back to Top</a>
	<?php do_action('foundationPress_after_content'); ?>

	</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>