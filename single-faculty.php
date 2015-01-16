<?php get_header(); ?>
<div class="faculty-profile row">
	<?php //if (!is_front_page() && function_exists('bcn_display')): ?>
	<!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
	<?php //endif; ?>
	<div class="small-12 medium-12 columns right" role="main">
	<?php do_action('foundationPress_before_content'); ?>
			<?php do_action('foundationPress_post_before_entry_content'); ?>
			<div class="entry-content">

			<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php  

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
                        $faculty_pubs = $faculty_fields["selected_publications"];
                        $faculty_img = get_the_post_thumbnail($page->ID, 'med');
                        ?>
                        <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
                                <div class="columns large-4 faculty-info left">
                                    <?php echo $faculty_img; ?>
                                    <?php echo '<ul class="side-nav faculty_contact_fields">';
                                    $svg_arrow = '<svg class="arrow" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<path id="arrow-16-icon" d="M332.722,181.953v-54.964l129.229,129.012l-129.229,129.01v-54.964H50.049l147.899-148.094H332.722z"/>
</svg>';
                                    if ($faculty_email_address) {
                                        echo '<li class="email"><a href="mailto:' . $faculty_email_address . '" title="Email this faculty member">';
                                        get_template_part('assets/img/icons/inline', 'email-arrow.svg');
                                        echo $faculty_email_address . $svg_arrow . '</a></li>';
                                    }
                                    if( have_rows('phone_number')) {
                                        echo '<li class="phone-numbers">';
                                        while ( have_rows('phone_number') ) : the_row();
                                            $phone = get_sub_field('number');
                                            echo '<li><a href=tel:' . $phone . ' title="Call this faculty member">';
                                            get_template_part('assets/img/icons/inline', 'phone-arrow.svg');
                                            echo $phone . $svg_arrow . '</a></li>';
                                        endwhile;
                                        echo '</li>';
                                    }
                                    if( have_rows('locations')) {
                                        echo '<li class="locations">';
                                        while ( have_rows('locations') ) : the_row();
                                            $building = urlencode(get_sub_field('building'));
                                            $room_number = get_sub_field('room_number');
                                            echo '<li><a href="http://washington.edu/maps/?' . $building . '" target="_blank" title="Find this faculty member">';
                                            get_template_part('assets/img/icons/inline', 'home.svg');
                                            echo $building . ' ' . $room_number . $svg_arrow . '</a></li>';
                                        endwhile;
                                        echo '</li>';
                                    }
                                    if ($faculty_twitter_url) {
                                        echo '<li class="faculty-twitter"><a href="' . $faculty_twitter_url . '" title="See Twitter profile">Twitter' . $svg_arrow . '</a></li>';
                                    }
                                    if ($faculty_scival_url) {
                                        echo '<li class="faculty-scival"><a href="' . $faculty_scival_url . '" title="See SciVal profile">';
                                        get_template_part('assets/img/icons/inline', 'bar-chart.svg');
                                        echo 'SciVal' . $svg_arrow . '</a></li>';
                                    }
                                    if ($faculty_cv) {
                                        echo '<li class="cv"><a href="' . $faculty_cv . '" title="See CV">';
                                        get_template_part('assets/img/icons/inline', 'cv.svg');
                                        echo 'Curriculum Vitae (CV)' . $svg_arrow . '</a></li>';
                                    }
                                    if ($faculty_website_url) {
                                        echo '<li class="faculty-website"><a href="' . $faculty_cv . '" target="_blank" title="Website for this faculty member">';
                                        get_template_part('assets/img/icons/inline', 'link.svg');
                                        echo 'Website' . $svg_arrow . '</a></li>';
                                    } ?>
                                    </ul>		
                                </div>
                            <div class="columns large-8 right">
                            <header class="article__header">
                                <div class="faculty-title">
                                    <h1 class="article__title<?php if (count(get_field('job_titles' )) > 1) {echo ' multi-title ';} else {echo ' single-title';}  ?>">
                                    <?php if ( is_page() || is_single()) : ?>
                                        <?php the_title() ?>
                                    <?php else : ?>
                                        <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
                                    <?php endif ?>
                                    </h1>
                                    <?php
                                    if( have_rows('job_titles') ) {
                                        echo '<div class="job-titles">';
                                        echo '<ul>';
                                        while ( have_rows('job_titles') ) : the_row();
                                            echo '<li>';
                                            the_sub_field('job_title');
                                            echo '</li>';
                                        endwhile;
                                        echo '</ul>';
                                    }
                                    ?>
                                </div>
                            </header>
                            <section class="article__content">
                                <div class="article__categories">
                                    <h2>Research area<?php if (count(wp_get_post_terms($post->ID, 'research_areas' )) > 1) {echo 's';}; ?></h2>
                                    <?php coenv_base_fac_terms_lite($post->ID); ?>
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
                            </div>

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
</div>	
<?php get_footer(); ?>