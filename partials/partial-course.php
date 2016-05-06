<div class="course post-<?php the_ID() ?>">
    <?php
    $terms = wp_get_post_terms($post->ID, 'course_quarter');
    $quarter =  $terms[0]->name;
    $rows = get_field('instructor(s)'); 
    echo '<h5>' . get_field('course_acronym') . ' | ' . $quarter . '</h5>';
    echo '<h4>' . get_the_title() . '</h4>';
    if( have_rows('instructor(s)') ) {
        // loop through the rows of data
        while ( have_rows('instructor(s)') ) : the_row();
        // display a sub field value
        if (get_sub_field('instructor_link')) {
                $instructors[] = '<a href="' . get_sub_field('instructor_link') . '">' . get_sub_field('instructor_name') . '</a> ';
            } else {
                $instructors[] = get_sub_field('instructor_name');
            }
        endwhile;
        echo '<p>Instructor(s): ' . implode(', ',$instructors);
    }
    echo '<p>Credits: ' . get_field('number_of_credits') . ' | Meeting times: ' . get_field('class_meeting_times') . ' | Location: ' . get_field('location') . '</p>';
    echo '<div class="course-description">' . get_field('course_description') . '</div>';
    if (get_field('course_website') ) {
        echo '<div class="course-link"><a class="button" href="' . get_field('course_website') .'" target="_blank">View course website</a></div>';
    }
    unset ($instructors)
    ?>
</div>