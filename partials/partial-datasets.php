<?php  
/**
 * Publication content
 */


$fields = get_fields();


?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header">
        <div class="article__meta">
   		<?php if ( is_single() ) : ?>
			<div class="blog-meta"><h5>
			<?php echo $publication_terms_str . $publication_years_str; ?>
			</h5></div>
			<div class="share clearfix right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
			data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
			data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="fi-share"></i>Share</a>
            </div>
        <?php endif ?>
        </div>
        <div class="faculty-title clearfix">
			<h1 class="article__title left">
			<?php if ( is_page() || is_single()) : ?>
				<?php the_title() ?>
			<?php else : ?>
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?>1111</a>
			<?php endif ?>
			</h1>
		</div>
		<div class="article__categories"><?php coenv_base_fac_terms($post->ID); ?></div>

	</header>
	<section class="article__content">
		<!--
		<div>
  			<dl data-magellan-expedition="fixed" class="sub-nav">
  				<?php

  				//if( $fields )
{
	//foreach( $fields as $field_name => $value )
	{
		// get_field_object( $field_name, $post_id, $options )
		// - $value has already been loaded for us, no point to load it again in the get_field_object function
		//$field = get_field_object($field_name, $post->id, array('load_value' => true));
		
		//echo '<dd data-magellan-arrival="' . $field_name  . '"><a href="#' . $field_name . '">' . $field['label'] . '</a></dd>';
		
	}
}
?>

  			</dl>
		</div>-->



















		<?php

/*
*  get all custom fields and dump for texting
*/


//var_dump( $fields ); 

/*
*  get all custom fields, loop through them and load the field object to create a label => value markup
*/

if( $fields )
$field = get_field_object('dataset_link', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '" id="dataset-links" style="float: right; width: 20rem; margin: 0 2rem; padding: 1rem; background-color: #f3f3f3;">';
			echo '<h3 style="margin-bottom: 1rem;">' . $field['label'] . '</h3>';
			$rows = get_field('dataset_link');
				if($rows) {
					foreach($rows as $row) {
						echo '<a class="button" href="' . $row['dataset_link_url'] . '" target="_blank" style="margin-right: 1rem;">' . $row['dataset_link_title'] . '</a>';
					}
				}
		echo '</div>';
}
{
	$field = get_field_object('dataset_overview', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}

$field = get_field_object('dataset_applications', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}

$field = get_field_object('dataset_about', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}

$field = get_field_object('dataset_data', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}

$field = get_field_object('dataset_funding', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}

$field = get_field_object('dataset_citation', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}

$field = get_field_object('dataset_updates', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}

$field = get_field_object('contact', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}

$field = get_field_object('dataset_reports', $post->id, array('load_value' => true));
if( $field['value'] ) {
		echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';
			echo $field['value'];
		echo '</div>';
}
}

?>
	</section>
    <?php
    remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' );
	?>

</article><!-- .article -->