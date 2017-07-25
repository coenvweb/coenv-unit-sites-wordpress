<?php  

/**
 * PI fields
 */
$faculty_fields = get_fields();
$faculty_twitter_url = $faculty_fields["twitter_url"];
$faculty_fname = $faculty_fields["first_name"];
$faculty_lname = $faculty_fields["last_name"];
$faculty_name = $faculty_fname . ' ' . $faculty_lname;
$faculty_cv_link = $faculty_fields["curriculum_vitae_link"];
$faculty_cv_file = $faculty_fields["curriculum_vitae_file"];
$faculty_pubs = $faculty_fields["selected_publications"];
$faculty_img = get_the_post_thumbnail($page->ID, 'med');
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
	<header class="article__header">
		<div class="article__meta">
        </div>
		<div class="faculty-title">
			<h1 class="article__title">
			<?php if ( is_page() || is_single()) : ?>
				<?php the_title() ?>
			<?php else : ?>
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
			<?php endif ?>
			</h1>	
		</div>
	</header>
	<section class="article__content">
		<div class="faculty-info right">
			<?php echo $faculty_img; ?>
			<p class="faculty-name"><?php echo $faculty_name; ?></p>
			<?php echo '<ul class="faculty_contact_fields">';
			if( have_rows('job_titles') ) {
				echo '<li class="job-titles">';
				echo '<ul>';
				while ( have_rows('job_titles') ) : the_row();
					echo '<li>';
					the_sub_field('job_title');
					echo '</li>';
				endwhile;
				echo '</ul>';
			}
			if( have_rows('email') ) {
				echo '<li class="emails">';
				echo '<ul>';
				while ( have_rows('email') ) : the_row();
					echo '<li>';
                $address = str_replace('u.washington.edu','uw.edu',get_sub_field('address'));
                echo '<a href="mailto:' . $address . '">' . $address . '</a>';
					echo '</li>';
				endwhile;
				echo '</ul>';
			}
			if( have_rows('phone_number') ) {
				echo '<li class="phone-numbers">';
				echo '<ul>';
				while ( have_rows('phone_number') ) : the_row();
					echo '<li>';
					the_sub_field('number');
					echo '</li>';
				endwhile;
				echo '</ul>';
				echo '</li>';
			}
			if( have_rows('locations') ) { ?>
				<li class="locations">
					<ul>
					<?php while ( have_rows('locations') ) : the_row();
						echo '<li class="location">';
						the_sub_field('location');
						echo '</li>';
					endwhile; ?>
					</ul>
				</li>
			<?php }
			if (!empty($faculty_twitter_url)) {
				echo '<li class="faculty-twitter"><a href="' . $faculty_twitter_url . '">Twitter</a></li>';
			}
			if (!empty($faculty_cv_link)) {
				echo '<li class="cv"><a href="' . $faculty_cv_link . '">Curriculum Vitae (CV)</a></li>';
			}
            if (!empty($faculty_cv_file)) {
				echo '<li class="cv"><a href="' . $faculty_cv_file . '">Curriculum Vitae (CV)</a></li>';
			}
			if( have_rows('links') ) { ?>
				<li class="links">
					<ul>
					<?php while ( have_rows('links') ) : the_row();
						echo '<li class="cv"><a href="' . the_sub_field('link_url') . '">' . the_sub_field('link_label') . '</a></li>';
					endwhile; ?>
					</ul>
				</li>
			<?php } ?>
			</ul>		
		</div>
		<div class="article__categories">
			<h2>Research areas</h2>
			<?php coenv_base_fac_terms($post->ID); ?>
		</div>
		<?php the_content() ?>
		<?php if ($faculty_pubs): ?>
		<div class="faculty-pubs">
			<h2>Selected publications</h3>
			<?php echo $faculty_pubs; ?>
		</div>
		<?php endif; ?>
	</section>
    <?php
    /* Still needed? */
    remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' );
	?>

</article><!-- .article -->