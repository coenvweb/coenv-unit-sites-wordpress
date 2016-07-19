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
$member_name = get_the_title();
?>
<li id="post-<?php the_ID() ?>" class="type-member row">
    <div class="member-info large-4 columns">
        <div class="member-line">
            <p class="member-name">
            <?php echo $member_name; ?>
            </p>
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
    </div>
    <div class="article__categories large-8 columns">
        <p>Research Areas</p>
        <?php coenv_base_mem_terms($post->ID); ?>
    </div>
    <?php
    /* Still needed? */
    remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' );
	?>
    <hr>
</li>
