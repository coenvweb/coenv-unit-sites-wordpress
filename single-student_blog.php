<?php
/*
Template Name: Student Blog
*/
?>

<?php get_header(); ?>
<div class="row page-content" id="main-col">
	<div class="columns" role="main">
		<div class="article__content">
			<div class="blog clearfix">

			<?php 
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					$terms = wp_get_post_terms( get_the_ID(), 'blog_category');
					$terms = wp_list_filter($terms, array('slug'=>'featured'),'NOT');
					$terms = wp_list_filter($terms, array('slug'=>'uncategorized'),'NOT');
					$rows = get_field('blog_link');
					$attach_id = get_post_thumbnail_id();
					$attach_id = str_replace('attachment_', '', $attach_id);
					$photo_title = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );
					$photo_alt = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );
					$photo_post = get_post($attach_id);
					$photo_caption = $photo_post->post_excerpt;
					$photo_url = $photo_post->guid;
					$photo_source = get_post_meta( $attach_id, '_credit_text', true );
					$photo_source_url = get_post_meta( $attach_id, '_credit_link', true );
					if (get_field('story_link_url')) {
						$post_link_url = get_field('story_link_url');
						$post_link_target = ' target="_blank" ';
			            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
		       		}
				?>

			<article class="blog-list-item post-<?php the_ID() ?> clearfix">
        		<header class="article__header">
        			<div class="columns small-12 article-meta">
	        			<p>
						<?php 
				        echo get_the_date('M j, Y');
						$termlist = '';
						foreach ($terms as $term) {
				            $termlist .= '<a href="/news-events/student-blog/?tax='. $term->taxonomy . '&term=' . $term->slug . '">' . $term->name . '</a>, ';
						}
						$termlist = rtrim($termlist,', ');
						//if ( !empty( $termlist ) ) {
							echo ' / ' . $termlist;
						//}
				        ?>
				        </p>
					</div>
					<!--<div class="small-2 right share" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>" data-article-shortlink="<?php echo wp_get_shortlink(); ?>" data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a></div>-->
        			<h2 class="small-12 left article__title"><a href="<?php echo $post_link_url; ?>" <?php echo $post_link_target; ?>><?php echo get_the_title(); ?></a></h2>
				</header>
				<div class="article__content">
					<?php echo the_content(); ?>
				</div>
				<div class="article__links">
					<?php
					if($rows) {
						foreach($rows as $row) {
							if($row['blog_link_type'] == 'upload') {
								echo '<a class="button" href="' . $row['blog_upload_file'] . '" target="_blank">' . $row['blog_file_link_text'] . '</a>';
							} elseif ($row['blog_link_type'] == 'link') {
								echo '<a class="button" href="' . $row['blog_link_url'] . '" target="_blank">' . $row['blog_link_text'] . '</a>';
							} 
						}
					} ?>
				</div>




			</article>
			<?php
				}
			}
			?>
	</div>
	  </div>		
	<?php if ( is_active_sidebar( 'after-content' ) ) { ?>
	<?php do_action('foundationPress_after_content'); ?>
	<ul class="widget-area after-content">
	<?php dynamic_sidebar("after-content"); ?>
	</ul>
	<?php } ?>
	<a href="#" class="back-to-top">Back to Top</a>
	<?php do_action('foundationPress_after_content'); ?>
	</div>
	<aside id="sidebar" class="columns show-for-medium-up">
	<?php
	if (!is_front_page()) {
		echo '<div class="coenv_base_subnav">';
		echo '<div class="section-title">';
		echo coenv_base_section_title($GLOBALS['post']->ID);
		echo '</div>';
		echo coenv_base_hierarchical_submenu($GLOBALS['post']->ID);
		echo '</div>';	
	}
	?>

	<?php dynamic_sidebar('sidebar-widgets'); ?>
	<?php
	$ancestor_id = coenv_base_get_ancestor('ID');
	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )) {
		dynamic_sidebar( $ancestor_id );
	}
	?>
	</aside>
</div>
<?php get_footer(); ?>