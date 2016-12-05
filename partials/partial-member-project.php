<?php

/**
 * Member project fields
 */
$project_fields = get_fields();

?>
<li id="post-<?php the_ID() ?>" class="type-project row">
    <h2 class="small-12 columns project-title"><?php the_title(); ?></h2>
    <div class="small-6 columns">
        <span class="pi-label"></span> <?php echo get_field('project_pi'); ?>
    </div>
    <div class="small-6 columns">
        <?php echo coenv_base_proj_terms($post->ID, $page_link); ?>
    </div>
    <div class="project-description small-12 columns">
        <?php echo get_field('project_description'); ?>
    </div>
</li>
