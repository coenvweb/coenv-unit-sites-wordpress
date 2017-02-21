<?php  

/**
 * Member fields
 */
$member_fields = get_fields();
$member_email_address = str_replace('u.washington.edu','uw.edu',$member_fields["email_address"]);
$member_website_url = $member_fields["website_url"];
$member_department = $member_fields["home_department"];
$member_number = $member_fields["phone_number"];
$member_title = $member_fields["job_titles"];
$member_lname = $member_fields["last_name"];
$member_description = $member_fields["description"];
$member_name = get_the_title();
$member_photo = get_the_post_thumbnail();
?>
<li id="post-<?php the_ID() ?>" class="type-member row">
    <div class="member-info large-6 columns">
        <div class="member-line">
            <h3 class="member-name">
            <?php echo $member_name; ?>
            </h3>
        </div>
		<div class="member-photo">
            <?php
                if($member_photo) {
                    echo $member_photo;
                } else {
                    echo "<img src='" . get_template_directory_uri() . "/assets/img/member_placeholder.jpg' alt='member image' />";
                }
            ?>
        </div>
        <ul class="member-titles">
        <?php
        if( have_rows('job_titles') ) {
            while ( have_rows('job_titles') ) : the_row();
                echo "<li>";
                    the_sub_field('job_title');
                echo "</li>";
            endwhile;
        }
        ?>
        </ul>
        
        <?php
        if( $member_department ) { ?>
            <div class="member-department"><?php echo $member_department ?></div>
        <?php } ?>
        <div class="member-contact">
            <?php if ($member_email_address) { ?>
                <a class="email" href="mailto:<?php echo $member_email_address; ?>" target="_blank"><i class="fi-mail"></i></a>
            <?php } ?>
            <?php if ($member_number) { ?>
                <a class="phone_number" href="tel:<?php echo $member_number; ?>" target="_blank"><i class="fi-telephone"></i></a>
            <?php } ?>
            <?php if ($member_website_url) { ?>
                <a class="member-website" href="<?php echo $member_website_url; ?>" target="_blank"><i class="fi-web"></i></a>
            <?php } ?>
        </div>
    </div>
    <div class="article__categories large-6 columns">
        <p>Research Areas</p>
        <?php coenv_base_mem_terms($post->ID); ?>
    </div>
    <div class="desc">
        <?php echo $member_description; ?>
    </div>
    <?php
    /* Still needed? */
    remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' );
	?>
    <hr>
</li>
