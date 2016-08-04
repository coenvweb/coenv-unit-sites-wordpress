<div class="course post-<?php the_ID() ?>">
    <?php
    $terms = wp_get_post_terms($post->ID, 'course_quarter');
    $categories = wp_get_post_terms($post->ID, 'course_category');
    foreach($categories as $category) {
        $course_categories[] = $category->name;
    }
    $quarter =  $terms[0]->name;
    $rows = get_field('instructor(s)');
    echo '<h1 class="course_title">' . get_the_title() . '</h1>';
    echo '<div class="course_details">';
        echo '<h2 class="course_acro">';
            echo get_field('course_acronym') . ' | ' . $quarter;
            if($course_categories) {
                echo '<span class="fulfillments">' . implode(', ', $course_categories) . '</span>';
            }
        echo '</h2>';
        echo '<ul class="course_meta">';
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
                echo '<li><span class="meta_label">Instructor(s):</span> ' . implode(', ',$instructors) . '</li>';
            }
            echo '<li><span class="meta_label">Credits:</span> ' . get_field('number_of_credits') . '</li>';
            echo '<li><span class="meta_label">Meeting times:</span> ' . get_field('class_meeting_times') . '</li>';
            echo '<li><span class="meta_label">Location:</span> ' . get_field('location') . '</li>';
        echo '</ul>';
    echo '</div>';
    echo '<div class="course-description">';
        echo get_field('course_description');
        if (get_field('course_website') ) {
            echo '<div class="course-link"><a class="button" href="' . get_field('course_website') .'" target="_blank">View course website</a></div>';
        }
    echo '</div>';
    unset ($instructors)
    ?>
</div>
