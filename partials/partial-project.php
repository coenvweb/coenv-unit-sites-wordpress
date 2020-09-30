<?php

/**
 * Project fields
 */

function pi_to_front($a, $b) {
    if($a['name'] == 'Principal Investigator') {
        return -1;
    }
    return 1;
}

$project_type = get_field('project_type');


$url_base = "/science/projects";

//Taxonomies
$project_topic = wp_get_post_terms(get_the_id(), 'project_topic');
$project_region = wp_get_post_terms(get_the_id(), 'project_region');
$project_years = wp_get_post_terms(get_the_id(), 'project_year');
$terms_str = '';

if (!empty($project_topic)) {
    $project_topic_arr = array();

    foreach ($project_topic as &$term) {
        if ($term->slug != 'uncategorized') {
            $project_topic_arr[] = '<a href="'.$url_base.'/?topic=' . $term->slug . '">' . $term->name . '</a>';
        }   
    }
        $project_topic_str = implode(', ', $project_topic_arr);

} else {
    $project_topic_str = '';
}
$terms = "";      

if (!empty($project_region)) {
    $project_region_arr = array();

    foreach ($project_region as &$term) {
        if ($term->slug != 'uncategorized') {
            $project_region_arr[] = '<a href="'.$url_base.'/?project_region=' . $term->slug . '">' . $term->name . '</a>';
        }   
    }
        $project_region_str = implode(', ', $project_region_arr);

} else {
    $project_region_str = '';
}
$terms = "";   

if (!empty($project_years)) {
    $project_years_arr = array();

    foreach ($project_years as &$term) {
        if ($term->slug != 'uncategorized') {
            $project_years_arr[] = '<a href="'.$url_base.'/?project_years=' . $term->slug . '">' . $term->name . '</a>';
        }   
    }
        $project_years_str = implode(', ', $project_years_arr);

} else {
    $project_years_str = '';
}
$terms = "";  

//Featured Image
$img = get_the_post_thumbnail_url(get_the_id(), 'large');
$img_id = get_post_thumbnail_id(get_the_id());
$meta = get_post_meta($img_id, '_wp_attachment_image_alt', true );

//ACF Fields
$gators = get_field('investigators');
$partners = get_field('partners');
$funding_agencies = get_field('funders');
$sci_themes = get_field('science_themes');
$status = get_field('project_status');
$data_link = get_field('data_link');
$story_map_link = get_field('story_map_link');

//Break investigators into parts
$gators_sorted = array();
if (!empty($gators)) {
    foreach($gators as $gator) {
        $type = $gator['type'];
        unset($gator['type']);
        if($gator['email']) {
            $gator['email'] = '<a href="mailto:'.$gator['email'].'">'.$gator['email'].'</a>';
        }
        if(array_key_exists($type, $gators_sorted)) {
            $gators_sorted[$type][] = $gator;
        } else {
            $gators_sorted[$type] = array( 'name' => $type, $gator );
        }
    }
}

usort($gators_sorted, 'pi_to_front');

//Intro text
$intro = get_field('intro_text');

?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'project' ) ?>>
    <header class="article__header columns">
        <div class="article__meta">
			 <div class="post-info">
            <?php if (!empty($project_topic_str)) {
                echo 'Topic' . (count($project_region) > 1 ? 's: ' : ': ') . $project_topic_str;
            } ?>
           <?php if (!empty($project_region_str)) {
                echo 'Region' . (count($project_region) > 1 ? 's: ' : ': ') . $project_region_str;
            } ?>
           <?php if (!empty($project_years_str)) {
                echo '| Year' . (count($project_years) > 1 ? 's: ' : ': ') . $project_years_str;
            } ?>
        </div>
        </div>
		<h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
	</header>
    <section class="article__content">
        <?php if($intro) { ?>
            <p class="intro">
                <?=$intro?>
            </p>
        <?php } ?>
        <div class="side-panel small-12 medium-4 columns right">
            <img class="project-preview-img" src="<?=$img?>" alt="<?=$meta?>" />
                <?php foreach($gators_sorted as $type) { ?>
                    <div class="project-meta">
                        <?php if($type['name'] != 'Cooperator/Partner') { ?>
                            <div class="meta-row">
                            <label for="investigators" class="gator_type"><?=$type['name']?><?=(count($type) > 2 ? 's' : '')?></label>
                            <?php unset($type['name']);
                            foreach($type as $gator) { ?>
                                <ul class="investigators">
                                    <li class="gator">
                                        <?php echo implode(', ', array_filter($gator)); ?>
                                    </li>
                                </ul>
                            <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <div class="project-meta">
                <?php if($partners) { ?>
                    <div class="meta-row">
                        <label for="partners">
                            Partner<?=(count($partners) > 1 ? 's' : '')?>
                        </label>
                        <ul class="value" id="partners">
                            <?php 
                            foreach($partners as $partner) { ?>
                                <li class="$partner"><?=$partner['partner']?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                
                <?php if($funding_agencies) { ?>
                    <div class="meta-row">
                        <label for="funding">
                            Funding Agenc<?=(count($funding_agencies) > 1 ? 'ies' : 'y')?>
                        </label>
                        <ul class="value" id="funding">
                            <?php 
                            foreach($funding_agencies as $agency) { ?>
                                <li class="agency"><?=$agency['funder_name']?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <?php if($status) { ?>
                    <div class="meta-row">
                        <label for="status">
                            Project Status
                        </label>
                        <div class="value" id="status">
                            <?=$status?>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="content small-12 medium-8 columns">
            <?php the_content(); ?>
            
        </div>
    </section>
</article><!-- .article -->