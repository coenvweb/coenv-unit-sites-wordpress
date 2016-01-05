<div class="course post-<?php the_ID() ?>">
    <?php
    $terms = wp_get_post_terms($post->ID, 'course_quarter', $args );
    $quarter =  $terms[0]->name;
    $rows = get_field('instructor(s)'); 
    echo '<h5>' . get_field('course_acronym') . ' | ' . $quarter . '</h5>';
    echo '<h4>' . get_the_title() . '</h4>';
    echo '<p>Credits: ' . get_field('number_of_credits') . ' | Meeting times: ' . get_field('class_meeting_times') . ' | Location: ' . get_field('location') . '</p>';
    if( have_rows('instructor(s)') ) {
        // loop through the rows of data
        while ( have_rows('instructor(s)') ) : the_row();

            // display a sub field value
        
        
        
        if (get_sub_field('instructor_link')) {
                echo '<a href="' . get_sub_field('instructor_link') . '>' . get_sub_field('instructor_name') . '</a> ';
            } else {
                echo get_sub_field('instructor_name') . ' ';
            }
        

        endwhile;

    }
    echo '<div class="course-description">' . get_field('course_description') . '</div>';
    echo '<div class="course-link"><a class="button" href="' . get_the_permalink() .'">See Details</a></div>';
    if (get_field('course_website') ) {
        echo '<div class="course-link"><a class="button" href="' . get_field('course_website') .'" target="_blank">View course website</a></div>';
    }
    ?>
</div>