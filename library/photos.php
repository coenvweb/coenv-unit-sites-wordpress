<?php
/**
 * Adds divs around all inline images (for excerpts)
 **/
function breezer_addDivToImage( $content ) {

   // A regular expression of what to look for.
   $pattern = '/(<img([^>]*)>)/i';
   // What to replace it with. $1 refers to the content in the first 'capture group', in parentheses above
   $replacement = '<div class="myphoto">$1</div>';

   // run preg_replace() on the $content
   $content = preg_replace( $pattern, $replacement, $content );

   // return the processed content
   return $content;
}
if (is_archive()):
	add_filter( 'the_content', 'breezer_addDivToImage' );
endif;

/**
 * Add custom media metadata fields
 *
 * Be sure to sanitize your data before saving it
 * http://codex.wordpress.org/Data_Validation
 *
 * @param $form_fields An array of fields included in the attachment form
 * @param $post The attachment record in the database
 * @return $form_fields The final array of form fields to use
 */
function add_image_attachment_fields_to_edit( $form_fields, $post ) {		
	// Add a Credit field
	$form_fields["credit_text"] = array(
		"label" => __("Credit"),
		"input" => "text", // this is default if "input" is omitted
		"value" => esc_attr( get_post_meta($post->ID, "_credit_text", true) ),
		"helps" => __("The owner of the image."),
	);
	
	// Add a Credit field
	$form_fields["credit_link"] = array(
		"label" => __("Credit URL"),
		"input" => "text", // this is default if "input" is omitted
		"value" => esc_url( get_post_meta($post->ID, "_credit_link", true) ),
		"helps" => __("Attribution link to the image source or owners website."),
	);
	
	return $form_fields;
}
add_filter("attachment_fields_to_edit", "add_image_attachment_fields_to_edit", null, 2);

/**
 * Save custom media metadata fields
 *
 * Be sure to validate your data before saving it
 * http://codex.wordpress.org/Data_Validation
 *
 * @param $post The $post data for the attachment
 * @param $attachment The $attachment part of the form $_POST ($_POST[attachments][postID])
 * @return $post
 */
function add_image_attachment_fields_to_save( $post, $attachment ) {
	if ( isset( $attachment['credit_text'] ) )
		update_post_meta( $post['ID'], '_credit_text', esc_attr($attachment['credit_text']) );
		
	if ( isset( $attachment['credit_link'] ) )
		update_post_meta( $post['ID'], '_credit_link', esc_url($attachment['credit_link']) );

	return $post;
}
add_filter("attachment_fields_to_save", "add_image_attachment_fields_to_save", null , 2);

/**
 * Improves the caption shortcode with HTML5 figure & figcaption; microdata & wai-aria attributes
 * 
 * @param  string $val     Empty
 * @param  array  $attr    Shortcode attributes
 * @param  string $content Shortcode content
 * @return string          Shortcode output
 */
function jk_img_caption_shortcode_filter($val, $attr, $content = null) {

	extract(shortcode_atts(array(
		'id'      => '',
		'align'   => 'aligncenter',
		'width'   => '',
		'caption' => ''
	), $attr));
	
	// No caption, no dice... But why width? 
	if ( 1 > (int) $width || empty($caption) )
		return $val;
 
	if ( $id )
		$id = esc_attr( $id );
		$attach_id = str_replace('attachment_', '', $id);
		$photo_source = get_post_meta( $attach_id, '_credit_text', true );
		$photo_source_url = get_post_meta( $attach_id, '_credit_link', true );

		// Extract the thumbnail size and add to classes
		extract( shortcode_atts( array(
		    'id' => '', 'align' => 'alignnone', 'width' => '', 'caption' => ''
		), $attr) );

		if ( 1 > (int) $width || empty($caption) ) return $content;

		if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

		// set the initial class output
		$class = 'wp-caption';
		// use a preg match to catch the img class attribute
		preg_match('/<img.*class[ \t]*=[ \t]*["\']([^"\']*)["\'][^>]+>/', $content, $matches);
		$class_attr = isset($matches[1]) && $matches[1] ? $matches[1] : false;
		// if the class attribute is not empty get an array of all classes
		if ( $class_attr ) {
			foreach ( explode(' ', $class_attr) as $aclass ) {
				if ( strpos($aclass, 'size-') === 0 || strpos($aclass, 'inline') === 0 ) $class .= ' ' . $aclass;
			}
		}

		$class .= ' ' . esc_attr($align);

        $container = '';
        if(strpos($class, 'inline')) {
            $container = "style='width: " . (0 + (int) $width) . "px'";
        }
	

	$figure_out = '<figure id="' . $id . '" aria-describedby="figcaption_' . $id . '" class="' . $class . '" itemscope itemtype="http://schema.org/ImageObject" '.$container.'><div class="figure-img" style="width: ' . (0 + (int) $width) . 'px" >' . do_shortcode( $content ) . $photo_source_div . '</div><figcaption id="figcaption_'. $id . '" class="wp-caption-text" itemprop="description">';
	
    	
    $figure_out .= $caption;
    if ( $photo_source ) {
		if (!empty($photo_source_url)) {
			$figure_out .= '<p><em>Image courtesy of <a href="' . $photo_source_url . '" target="blank">' . $photo_source . '</a></em></p>';
		} else { 
			$figure_out .= '<p><em>Image courtesy of ' . $photo_source . '</em></p>';
		}
	}
	$figure_out .= '</figcaption></figure>';
	return $figure_out;
	
}
add_filter( 'img_caption_shortcode', 'jk_img_caption_shortcode_filter', 10, 3 );

// add custom image sizes
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'med-sidecap', 350 ); //(cropped)
	add_image_size( 'large-sidecap', 435 ); //(cropped)
    add_image_size( 'lrg_sq', '360', '360', true );
}
add_filter('image_size_names_choose', 'my_image_sizes');
function my_image_sizes($sizes) {
	$addsizes = array(
		"med-sidecap" => __( "Medium (1/3 right caption)"),
		"large-sidecap" => __( "Large (1/2 right caption)")
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}
?>
