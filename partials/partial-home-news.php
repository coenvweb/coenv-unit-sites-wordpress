<?php
$posted[] = get_the_id();
if (get_field('story_link_url')) {
	$post_link_url = get_field('story_link_url');
	$post_link_target = 'target="_blank"';
	$post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
} else {
	$post_link_url = get_the_permalink();
	$post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
}
$terms = wp_get_post_terms(get_the_id(), 'category');
if ( !empty($terms) ) {
	$terms_list = array();
	foreach ( $terms as &$term ) {
		if ( $term->slug != 'uncategorized' ) {
			$terms_list[] = '<li><a href="/news-events/category/' . $term->slug . '">' . $term->name . '</a></li>';
		}
	}  
}
?>

<div class="small-news col-1">
	<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>

	<span class="show-for-medium-up"><?php strip_tags(the_advanced_excerpt('length=15&finish=sentence'),''); ?></span>

	<div class="post-meta clearfix row show-for-medium-up">
		<time class="article__time columns small-12 medium-5 left" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date( 'M j, Y' ); ?></time>
		<?php if ( !empty($terms ) ) { ?>
		<ul class="terms right columns small-12 medium-7 right text-right">
			<?php echo implode(", ", $terms_list); ?>
		</ul>
		<?php } ?>
	</div>
</div>

