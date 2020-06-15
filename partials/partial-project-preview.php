<?php
    $img = get_the_post_thumbnail_url(get_the_id(), 'large');
    $img_id = get_post_thumbnail_id(get_the_id());
    $meta = wp_get_attachment_metadata($img_id);
?>

<div class="project columns">
    <a href="<?php echo get_the_permalink();?>">
        <div class="project-wrap">
            <?php if (isset($img)) { ?> 
                <img class="project-preview-img large-4 left" src="<?=$img?>" alt="<?=isset($meta->title) ? $meta->title : ''?>" />
            <?php }; ?>
            <?php if (isset($title)) { ?> 
            <div class="project-info columns large-8 right">
                <div class="post-content post-meta article__meta post-info">
                    <div class="project-status large-3 columns"><?php the_field('project_status'); ?></div><div class="topics">
                    <?php // Get categories
                        $terms = wp_get_post_terms(get_the_id(), 'topic');
                      $url_base = "/science/projects";
                        if (!empty($terms)) {
                            $terms_arr = array();

                            foreach ($terms as &$term) {
                                if ($term->slug != 'uncategorized') {
                                    $terms_arr[] = '<a href="'.$url_base.'/?topic=' . $term->slug . '">' . $term->name . '</a>';
                                }
                            }
                            $terms_str = implode(', ', $terms_arr);

                        } else {
                            $terms_str = '';
                        }
                        $terms = "";
                    ?>
                    <?php if (!empty($terms_str)) {
                        echo $terms_str;
                    } ?>
                    </div>
                </div>
                <a href="<?php echo get_the_permalink();?>">
                <h2 class="project-preview-header"><?php echo get_the_title(); ?></h2>
                </a>
            </div>
            <?php }; ?>
        </div>
    </a>
</div>
