<?php

/**
 * Member project fields
 */
$PIarr = get_field('project_pi');

?>
<li id="post-<?php the_ID() ?>" class="type-project row collapse">
    <div class="small-11 columns project-header">
        <div class="proj-meta">
            <span class="year"><?php echo get_field('year_awarded');?></span> | <?php echo coenv_base_proj_terms($post->ID, $page_link); ?> | 
            <ul class="pi-list">
                <?php
                foreach($PIarr as $pi) {
                    $piString = '<li class="pi">' . $pi['pi_first_name'] . ' ' . $pi['pi_last_name'];
                    if($pi['pi_type']) {
                        $piString .= ', ' . $pi['pi_type'];
                    }
                    $piString .= "</li>";
                    echo $piString;
                }
                ?>
            </ul>
        </div>
        <h2 class="project-title"><?php the_title(); ?></h3>
    </div>
    <div class="proj-expand small-1 columns">
        <i class="fi-plus"></i>
    </div>
    <div class="project-description small-12 columns slideout">
        
        <?php echo get_field('project_description'); ?>
    </div>
</li>
