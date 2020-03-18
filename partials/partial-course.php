<?php

    $course_acronym = get_field('course_acronym');
    $credits = get_field('number_of_credits');
    $course_level = get_field('course_level');
    $course_active = get_field('active');
    $instructor = get_field('instructor');
    $instructors = '';
    $quarter = substr(get_field('quarter')->name, 0, 3);
    if ($quarter == 'All' || $quarter == 'TBD' || $quarter == '') {
        $quarter_class = 'Aut Win Spr Sum ' . $quarter;
    } else {
        $quarter_class = $quarter;
    }
    $years = get_field('course_year');
    print_r($years);
    if($years) {
        $full_year = $years->name;
    }
    $year = substr($full_year, 2);
    $terms = get_terms( array(
        'taxonomy' => 'course_year',
        'hide_empty' => false,
    ) );

    $term_list = '';
    foreach ($terms as $term) {
        $term_list .= $term->slug . ' ';
    }
    if (empty($full_year)) {
        $full_year = $term_list;
    }
    while ( have_rows('instructor') ) : the_row();
      if (!empty(get_sub_field('instructor_safs_faculty'))) {
            $instructor_post = get_sub_field('instructor_safs_faculty');
            $instructors .= '<a href="' . get_permalink($instructor_post->ID) . '">' . get_the_title($instructor_post->ID) . '</a>';
        } else {
            $instructors .= '<a href="' . get_sub_field('instructor_link') . '">' . get_sub_field('instructor_name') . '</a>';
        }
    endwhile;
    $prerequisites = get_field('prerequisites');
    $general_education_requirements = get_field('gen_ed_qualifications');
    $course_link = get_field('course_website');
    $myplan_link = get_field('myplan_link');
    $catalog_link = get_field('course_catalog_link');
    $time_schedule_link = get_field('time_schedule_link');
    $thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
    $thumb_img_src = $thumb_img[0];
    $research_areas = get_the_terms($post->ID,'research_areas');
    $term_list = '';
    $term_list_slugs = '';
    if(!empty($research_areas)) {
        $term_list .= '<ul class="topics">';
        foreach($research_areas as $research_area) {
            $term_list .= '<li class="tag">' . $research_area->name . '</li> ';
            $term_list_slugs .= $research_area->slug . ' ';
        }
        $term_list .= '</ul>';
    }
		if (!$thumb_img_src) {
		$thumb_img_src = get_template_directory_uri() . '/assets/img/blank-153x153.jpg';
		}
		echo '<div id="course-' . sanitize_title(get_the_title()) . '" class="filter-list-item accordion-title row read '.$term_list_slugs.' ' . $quarter_class . ' ' . $full_year . '" aria-label="Toggle more information" tabindex="0"><div class="course-header" aria-expanded="false" aria-controls="course-c-' . sanitize_title(get_the_title()) . '">';
    echo '<div class="quarter">' . $quarter;
    if (!empty($year)) {
        echo ' \'' . $year;
    }
    echo '</div>';
    echo '<div class="course-info ">';
    echo '<h4 class="acronym">' . $course_acronym . '</h4>';
    echo '<h3 class="course-name">' . get_the_title() . '</h3>';
    echo '</div></div>';
    echo '<div id="course-c-' . sanitize_title(get_the_title()) . '" class="additional-info medium-12 columns" style="display:none;" data-equalizer-watch>';
        echo '<div class="small-info"><div class="row">';
        if(!empty($credits)) {
            echo '<div class="columns medium-6"><p><span class="prompt">Credits:</span> ' . $credits . '</p></div>';
        }
        if(!empty($general_education_requirements)) {
            echo '<div class="columns medium-6"><p><span class="prompt">General Education:</span> ' . $general_education_requirements . '</p></div>';
        }
        echo '</div>';
        if(!empty($prerequisites)) {
            echo '<div class="row prerequisites"><div class="columns medium-12"><p><span class="prompt">Prerequisites:</span> ' . $prerequisites . '</p></div></div>';
        }
        if(!empty($instructors)) {
            echo '<div class="row instructors"><div class="columns medium-12"><p><span class="prompt">Instructor(s):</span> ' . $instructors . '</p></div></div>';
        }
    the_content();
    echo $term_list;
    if (empty($course_link) && empty($myplan_link) && empty($catalog_link) && empty($time_schedule_link)) {
        
    } else {
        echo '<div class="columns contact-info"><ul>';
        if (!empty($course_link)) : 
            echo '<li class="course-link"><a href="' . $course_link .'"><i class="fi-link"></i>Course Website</a></li>';
        endif;
        if (!empty($myplan_link)) : 
            echo '<li class="myplan-link"><a href="' . $myplan_link .'"><i class="fi-results-demographics"></i>MyPlan</a></li>';
        endif;
        if (!empty($catalog_link)) : 
            echo '<li class="catalog-link"><a href="' . $catalog_link .'"><i class="fi-results"></i>Course Catalog</a></li>';
        endif;
        if (!empty($time_schedule_link)) :
            echo '<li class="time-schedule-link"><a href="'. $time_schedule_link . '"><i class="fi-clock"></i>Time Schedule</a></li>';
        endif;
        echo '</ul></div>';
    }
    echo '</div></div></div><div class="course-spacer course-fake"></div>';
