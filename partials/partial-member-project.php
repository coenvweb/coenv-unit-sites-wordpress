<?php

/**
 * Member project fields
 */
$PIarr = get_field('project_pi');

?>
<li id="post-<?php the_ID() ?>" class="type-project row collapse">
    <h3 class="small-11 columns project-title"><?php the_title(); ?></h3>
    <div class="proj-expand small-1 columns">
        <i class="fi-plus"></i>
    </div>
    <div class="small-12 large-6 columns">
        <span class="pi-label">PI<?=(count($PIarr) > 1 ? 's' : '')?>: </span>
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
    <div class="small-12 large-6 columns">
        <?php echo coenv_base_proj_terms($post->ID, $page_link); ?>
    </div>
    <div class="project-description small-12 columns slideout">
        <?php echo get_field('project_description'); ?>
    </div>
</li>
