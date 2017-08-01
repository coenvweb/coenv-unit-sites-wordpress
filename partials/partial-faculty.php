<?php  

/**
* Faculty fields
*/
$faculty_fields = get_fields();
$faculty_email_address = str_replace('u.washington.edu','uw.edu',$faculty_fields["email_address"]);
if(function_exists('eae_encode_emails')){
$faculty_email_address = eae_encode_emails($faculty_email_address);
}
$faculty_website_url = $faculty_fields["website_url"];
$faculty_scival_url  = $faculty_fields["scival_url"];
$faculty_twitter_url = $faculty_fields["twitter_url"];
$faculty_fname = $faculty_fields["first_name"];
$faculty_lname = $faculty_fields["last_name"];
$faculty_name = $faculty_fname . ' ' . $faculty_lname;
$faculty_cv = $faculty_fields["curriculum_vitae"];
$faculty_pubs = $faculty_fields["selected_publications"];
$faculty_img = get_the_post_thumbnail(get_the_ID(), 'med');
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
    <div class="row">
        <div class="faculty-image left columns small-3 large-4">
            <?php echo $faculty_img; ?>
        </div>
        <div class="columns small-9 large-8 right faculty-name">
        <header class="article__header">
            <div class="faculty-title">
                <h1 class="article__title single-title">
                <?php if ( is_page() || is_single()) : ?>
                    <?php the_title() ?>
                <?php else : ?>
                    <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
                <?php endif ?>
                </h1>
                <?php
                if( have_rows('job_titles') ) {
                    while ( have_rows('job_titles') ) : the_row();
                        echo '<p class="job-titles">';
                        the_sub_field('job_title');
                        echo '</p>';
                    endwhile;
                }
                ?>
            </div>
        </header>
        </div>
    </div>
    <div class="columns medium-12 large-4 faculty-info left">
        <?php echo '<ul class="side-nav faculty_contact_fields">';
        if ($faculty_email_address) {
            echo '<li class="email"><a href="mailto:' . eae_encode_emails($faculty_email_address) . '" title="Email this faculty member">';
            get_template_part('assets/img/icons/inline', 'email-arrow.svg');
            echo $faculty_email_address . '</a></li>';
        }
        if( have_rows('phone_number')) {
            echo '<li class="phone-numbers">';
            while ( have_rows('phone_number') ) : the_row();
                $phone = get_sub_field('number');
                echo '<li><a href=tel:+1' . $phone . ' title="Call this faculty member">';
                get_template_part('assets/img/icons/inline', 'phone-arrow.svg');
                echo $phone . '</a></li>';
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
                echo $building . ' ' . $room_number . '</a></li>';
            endwhile;
            echo '</li>';
        }
        if ($faculty_twitter_url) {
            echo '<li class="faculty-twitter"><a href="' . $faculty_twitter_url . '" title="See Twitter profile">Twitter' . $svg_arrow . '</a></li>';
        }
        if ($faculty_scival_url) {
            echo '<li class="faculty-scival"><a href="' . $faculty_scival_url . '" title="See SciVal profile">';
            get_template_part('assets/img/icons/inline', 'bar-chart.svg');
            echo 'SciVal</a></li>';
        }
        if ($faculty_cv) {
            echo '<li class="cv"><a href="' . $faculty_cv . '" title="See CV">';
            get_template_part('assets/img/icons/inline', 'cv.svg');
            echo 'Curriculum Vitae (CV)</a></li>';
        }
        if ($faculty_website_url) {
            echo '<li class="faculty-website"><a href="' . $faculty_website_url . '" target="_blank" title="Website for this faculty member">';
            get_template_part('assets/img/icons/inline', 'link.svg');
            echo 'Website</a></li>';
        } ?>
        </ul>		
    </div>
<div class="columns large-8 medium-12 right">
<section class="article__content">
    <?php the_content() ?>
    <?php if ($faculty_pubs): ?>
    <div class="faculty-pubs">
        <h2>Selected publications</h3>
        <?php echo $faculty_pubs; ?>
    </div>
    <?php endif; ?>
</section>
</div>