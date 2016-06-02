<?php 
get_header();

/**
 * Faculty fields
 */
$faculty_fields = get_fields();
$faculty_email_address = str_replace('u.washington.edu','uw.edu',$faculty_fields["email_address"]);
$faculty_website_url = $faculty_fields["website_url"];
$faculty_scival_url  = $faculty_fields["scival_url"];
$faculty_twitter_url = $faculty_fields["twitter_url"];
$faculty_advising = $faculty_fields["faculty_advising"];
$faculty_fname = $faculty_fields["first_name"];
$faculty_lname = $faculty_fields["last_name"];
$faculty_name = $faculty_fname . ' ' . $faculty_lname;
$faculty_cv = $faculty_fields["curriculum_vitae"];
$faculty_img = get_the_post_thumbnail($page->ID, 'med');
?>

<div class="row page-content" id="main-col">



	<aside id="sidebar" class="columns">
	<div class="faculty-info right">
	<?php echo $faculty_img; ?>
	<div class="show-for-small-only faculty__header">
		<h1 class="article__title"><?php the_title(); ?></h1>
			<?php if( have_rows('job_titles') ) { ?>
			<ul class="job-titles">
			<?php while ( have_rows('job_titles') ) : the_row(); ?>
				<li><?php the_sub_field('job_title'); ?></li>
			<?php endwhile; ?>
			</ul>
			<?php } ?>
	</div>
	<ul class="faculty_contact_fields">

	<?php 

	if ($faculty_email_address) {
	echo '<li class="email"><a href="mailto:' . $faculty_email_address . '">' .  $faculty_email_address . '</a></li>';
	}
	if( have_rows('phone_number') ) {
	while ( have_rows('phone_number') ) : the_row();
		echo '<li class="phone-numbers">';
			echo '<a href="tel:' . get_sub_field('number') . '">' . get_sub_field('number') . '</a>';
		echo '</li>';
	endwhile;
	}
	if( have_rows('locations') ) {
	while ( have_rows('locations') ) : the_row();
	if (get_sub_field('room_number')):
	echo '<li class="location"><a href="http://washington.edu/maps/?';
	the_sub_field('building');
	echo  '" target="_blank">';
	the_sub_field('building');
	echo ' ';
	the_sub_field('room_number');
	echo '</a>';
	echo '</li>';
	endif;
	endwhile; ?>

<?php 
}
// check for rows (parent repeater)
if( have_rows('online_services') ) { ?>
<?php while( have_rows('online_services') ): the_row(); ?>

<?php  while( have_rows('online_service_select') ): the_row(); ?>
<?php
$field = get_sub_field_object('online_service_name');
//var_dump($field);
$value = get_sub_field('online_service_name');
$service_label = $field['choices'][ $value ];
$service_class = str_replace(' ', '-', strtolower($service_label)) ;
?>

<?php if ( get_sub_field('online_service_url') ) { ?>
<li class="<?php echo $service_class; ?>"><a href="<?php the_sub_field('online_service_url'); ?>" target="_blank"><?php echo $service_label; ?></a></li>
<?php } ?>

<?php endwhile; ?>

<?php endwhile; ?>

<?php } ?>
<?php 
if ($faculty_twitter_url) {
echo '<li class="faculty-twitter"><a href="' . $faculty_twitter_url . '">Twitter</a></li>';
}
if ($faculty_scival_url) {
echo '<li class="faculty-scival"><a href="' . $faculty_scival_url . '">SciVal</a></li>';
}
if ($faculty_cv) {
echo '<li class="cv"><a href="' . $faculty_cv . '">Curriculum Vitae (CV)</a></li>';
}
if ($faculty_website_url) { ?>
<li class="faculty-website"><a href="<?php echo $faculty_website_url; ?>" target="_blank">Visit <?php echo coenv_base_apostophe_fname($faculty_fname); ?> website</a></li>
<?php } ?>
</ul>		
</div>
</aside>






	<div class="columns" role="main">
		<div class="article__header faculty__header show-for-medium-up">
			<h1 class="article__title"><?php the_title(); ?></h1>
			<?php if( have_rows('job_titles') ) { ?>
			<ul class="job-titles">
			<?php while ( have_rows('job_titles') ) : the_row(); ?>
				<li><?php the_sub_field('job_title'); ?></li>
			<?php endwhile; ?>
			</ul>
			<?php } ?>
		</div>
		<div class="entry-content left">

		<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post() ?>
			<div class="article__categories">
				<h2>Research areas</h2>
				<?php coenv_base_fac_terms($post->ID); ?>
			</div>
			<div class="article__content">
			<?php the_content(); ?>
			<?php if( have_rows( 'selected_pubs' ) ) { ?>
				<div class="faculty-pubs">
					<h2>Selected publications</h3>
					<ul>
						<?php while ( have_rows( 'selected_pubs' ) ) : the_row(); ?>
						<li><?php echo the_sub_field( 'publication' ); ?></li>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php } ?>
			</div>

<?php endwhile ?>
<?php endif ?>
</div>

<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
<div id="after-content" class="after-content widget-area" role="complementary">
<?php dynamic_sidebar( 'after-content' ); ?>
</div><!-- #after-content -->
<?php endif; ?>
</article>	
<?php do_action('foundationPress_after_content'); ?>
</div>

</div>	
<?php get_footer(); ?>