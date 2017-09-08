<?php  
/**
 * Intern content
 */

$image = get_the_post_thumbnail(get_the_ID(),'thumbnail');

if( !empty($image) ) {


}


?>
<div class="intern-list-item large-6 columns intern-list-item--<?php the_ID() ?> <?php if (is_singular()) { echo 'large-12'; }else{ echo 'large-6'; }?>" id="<?php the_ID() ?>">
	
	<a href="<?php the_permalink() ?>" class="intern-list-item-inner" title="<?php the_title() ?>">
        
		<?php echo $image; ?>

		<header class="intern-list-item-header">
			<h2 class="intern-list-item-title"><?php the_title() ?></h2>
      <h3 class="intern-list-item-school"><?php echo get_field('school') ?></h3>
			<h3 class="intern-list-item-project">Project: <?php echo get_field('project_title') ?></h3>
		</header>

	</a><!-- .Faculty-list-item-inner -->

</div><!-- .Faculty-list-item -->

<?php if (is_singular()) {
  echo '<div class="large-12 content">';
    the_content();
  echo '</div>';
} ?>
