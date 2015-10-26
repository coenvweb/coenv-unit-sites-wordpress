<?php  
/**
 * Publication content
 */


$fields = get_fields();




?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>


		   		<?php if ( is_single() ) : ?>

			<div class="post-meta">
			<?php echo $publication_terms_str . $publication_years_str; ?>
			</div>
        <?php endif ?>
        <div class="faculty-title clearfix">
			<h2 class="article__title left">
			<?php if ( is_page() || is_single()) : ?>
				<?php the_title() ?>
			<?php else : ?>
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
			<?php endif ?>
			</h2>
		</div>


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
{
	foreach( $fields as $field_name => $value )
	{
		
		// get_field_object( $field_name, $post_id, $options )
		// - $value has already been loaded for us, no point to load it again in the get_field_object function
		$field = get_field_object($field_name, $post->id, array('load_value' => true));
if( $field['value'] ) {
		//echo '<a name="' . $field_name  . '" id="' . $field_name . '"></a>';
		echo '<div data-magellan-destination="' . $field_name . '">';
			echo '<h2>' . $field['label'] . '</h2>';

			if ($field_name == 'dataset_link') {
				$rows = get_field('dataset_link');
				if($rows) {
					foreach($rows as $row) {
						echo '<a class="button" href="' . $row['dataset_link_url'] . '" target="_blank">' . $row['dataset_link_title'] . '</a>';
					}
				}
			} else {
				echo $value;			
			}







		echo '</div>';
	}
	}
}

?>
	</section>
    <?php
    remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' );
	?>

</article><!-- .article -->