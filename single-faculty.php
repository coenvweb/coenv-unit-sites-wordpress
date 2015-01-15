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
                                    if ($faculty_email_address) {
                                        echo '<li class="email"><a href="' . $faculty_email_address . '">

<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

<path id="email-8-icon" d="M381.339,199.065c0,0-87.156-3.628-135.339,47.962c22.631-98.556,135.339-121.492,135.339-121.492v-30.29

	L472,162.301l-90.661,67.054V199.065z M68.978,232.351L246.001,97.183l46.868,35.781c8.265-6.265,21.454-13.641,32.543-19.223

	L246,53.147L40,210.091v201.014l118-110.575L68.978,232.351z M334.001,301.112L452,411.529V212.793L334.001,301.112z

	 M40.499,458.853h410.753l-205.26-192.021L40.499,458.853z"/>

</svg>

' .  $faculty_email_address . '</a></li>';
                                    }
                                    if( have_rows('phone_number') ) {
                                        echo '<li class="phone-numbers">';
                                        while ( have_rows('phone_number') ) : the_row();
                                            $phone = get_sub_field('number');
                                            echo '<li><a href=' . $phone . '><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<path id="mobile-phone-8-icon" d="M320.299,166.834c0,0-73.309,3.194-133.863,80.008C209.99,120.446,320.299,79.437,320.299,79.437
	V50l103.137,73.136l-103.137,73.135V166.834z M289.055,205.214V436.99c0,13.812-11.193,25.01-25,25.01h-150.49
	c-13.807,0-25-11.198-25-25.01V145.456c0-13.812,11.193-25.01,25-25.01h103.014c-13.945,15.546-25.961,32.732-35.75,51.45h-58.018
	v140.99h132v-89.598C267.197,214.897,278.953,209.15,289.055,205.214z M153.807,392.004h-30.996v24.51h30.996V392.004z
	 M153.807,347.693h-30.996v24.51h30.996V347.693z M204.309,392.004h-30.996v24.51h30.996V392.004z M204.309,347.693h-30.996v24.51
	h30.996V347.693z M254.811,392.004h-30.996v24.51h30.996V392.004z M254.811,347.693h-30.996v24.51h30.996V347.693z"/>
</svg>' . $phone . '</a></li>';
                                        endwhile;
                                        echo '</li>';
                                    }
                                    if( have_rows('locations') ) {
                                        echo '<li class="locations">';
                                        while ( have_rows('locations') ) : the_row();
                                            $building = urlencode(get_sub_field('building'));
                                            $room_number = get_sub_field('room_number');
                                            echo '<li><a href="http://washington.edu/maps/?' . $building . '" target="_blank"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><g id="home-2-icon">
	<path d="M462,250.775l-30.644,30.645L257.086,128.149L80.571,282.834L50,252.117L257.158,66.934L462,250.775z M257.122,165.188
		l157.098,136.1v143.779H100.023V302.369L257.122,165.188z M296.428,307.406h-78.855v92.928h78.855V307.406z"/>
</g></svg>' . $building . ' ' . $room_number . '</a></li>';
                                        endwhile;
                                        echo '</li>';
                                    }
                                    if ($faculty_twitter_url) {
                                        echo '<li class="faculty-twitter"><a href="' . $faculty_twitter_url . '">Twitter</a></li>';
                                    }
                                    if ($faculty_scival_url) {
                                        echo '<li class="faculty-scival"><a href="' . $faculty_scival_url . '"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

<path id="bar_chart_6_icon" d="M367.625,97.795l33.424,33.424l-17.061,16.654l-33.557-33.556L367.625,97.795z

	 M336.01,128.18l-17.703,17.013l33.803,33.802l17.566-17.148L336.01,128.18z M62.344,462h107.084V358.065H62.344V462z

	 M363.092,64.978l70.203,70.203L449.656,50L363.092,64.978z M339.504,462h108.133V241.533H339.504V462z M337.795,192.966

	l-33.91-33.911l-54.37,52.253l-47.869-45.256L67.632,299.57l32.968,32.423l99.658-99.653l49.362,46.704L337.795,192.966z

	 M200.923,462h108.136V308.723H200.923V462z"/>

</svg>SciVal</a></li>';
                                    }
                                    if ($faculty_cv) {
                                        echo '<li class="cv"><a href="' . $faculty_cv . '"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

<path id="text-file-4-icon" d="M339.527,370.312H171.505v-30h168.022V370.312z M339.495,314.896h-167.99v-30h167.99V314.896z

	 M339.495,259.562h-167.99v-30h167.99V259.562z M297.818,90v85.75h85.864V422H128.317V90H297.818 M322.818,50H88.317v412h335.365

	V150.75L322.818,50z"/>

</svg>Curriculum Vitae (CV)</a></li>';
                                    }
                                    if ($faculty_website_url) { ?>
                                        <li class="faculty-website"><a href="#" target="_blank"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

<path id="link-icon" d="M156.226,199.679c7.541-7.54,15.902-13.757,24.794-18.659c49.556-27.318,113.117-12.788,144.97,35.518

	l-38.547,38.547c-11.059-25.227-38.5-39.565-65.813-33.456c-10.282,2.3-20.054,7.427-28.039,15.413l-73.898,73.896

	c-22.433,22.433-22.432,58.936,0.002,81.369c22.433,22.433,58.935,22.433,81.368,0l22.78-22.779

	c20.71,8.217,42.938,11.508,64.862,9.863l-50.278,50.278c-43.105,43.105-112.991,43.105-156.096,0

	c-43.105-43.104-43.106-112.991-0.001-156.096L156.226,199.679z M273.574,82.33l-50.278,50.278

	c21.928-1.643,44.152,1.648,64.863,9.865l22.779-22.78c22.434-22.434,58.936-22.434,81.37,0c22.434,22.434,22.434,58.936,0,81.37

	l-73.897,73.895c-22.501,22.501-59.061,22.311-81.368,0c-5.202-5.201-9.694-11.678-12.484-18.04l-38.546,38.546

	c4.049,6.142,8.261,11.453,13.666,16.858c13.949,13.95,31.698,24.339,52.117,29.251c26.466,6.37,54.823,2.839,79.185-10.592

	c8.892-4.903,17.254-11.119,24.794-18.659l73.896-73.895c43.105-43.105,43.105-112.991,0.001-156.097

	C386.566,39.225,316.68,39.225,273.574,82.33z"/>

</svg>
Website</a></li>
                                    <?php } ?>
                                    </ul>		
                                </div>
                            <div class="columns large-8 right">
                            <header class="article__header">
                                <div class="faculty-title">
                                    <h1 class="article__title">
                                    <?php if ( is_page() || is_single()) : ?>
                                        <?php the_title() ?>
                                    <?php else : ?>
                                        <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
                                    <?php endif ?>
                                    </h1>
                                    <?php
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
                                    ?>
                                </div>
                            </header>
                            <section class="article__content">
                                <div class="article__categories">
                                    <h2>Research areas</h2>
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