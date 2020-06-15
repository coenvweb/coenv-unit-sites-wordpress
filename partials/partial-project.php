<?php

/**
 * Project fields
 */

function pi_to_front($a, $b) {
    if($a['name'] == 'Principal Investigator') {
        return -1;
    }
    if($a['name'] == 'NW CASC Fellow') {
        return -1;
    }
    return 1;
}

$project_type = get_field('project_type');


$url_base = "/science/projects";

//Taxonomies
$topics = wp_get_post_terms(get_the_id(), 'topic');
$states = wp_get_post_terms(get_the_id(), 'state');
$funding_years = wp_get_post_terms(get_the_id(), 'funding-year');
$terms_str = '';

if (!empty($topics)) {
    $topics_arr = array();

    foreach ($topics as &$term) {
        if ($term->slug != 'uncategorized') {
            $topics_arr[] = '<a href="'.$url_base.'/?topic=' . $term->slug . '">' . $term->name . '</a>';
        }   
    }
        $topics_str = implode(', ', $topics_arr);

} else {
    $topics_str = '';
}
$terms = "";      

if (!empty($states)) {
    $states_arr = array();

    foreach ($states as &$term) {
        if ($term->slug != 'uncategorized') {
            $states_arr[] = '<a href="'.$url_base.'/?states=' . $term->slug . '">' . $term->name . '</a>';
        }   
    }
        $states_str = implode(', ', $states_arr);

} else {
    $states_str = '';
}
$terms = "";   

if (!empty($funding_years)) {
    $funding_years_arr = array();

    foreach ($funding_years as &$term) {
        if ($term->slug != 'uncategorized') {
            $funding_years_arr[] = '<a href="'.$url_base.'/?funding_years=' . $term->slug . '">' . $term->name . '</a>';
        }   
    }
        $funding_years_str = implode(', ', $funding_years_arr);

} else {
    $funding_years_str = '';
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

usort($gators_sorted, 'pi_to_front');

//Intro text
$intro = get_field('intro_text');

?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'project' ) ?>>
    <header class="article__header columns">
        <div class="article__meta">
			 <div class="post-info">
            <?php the_field('project_status'); ?> | 
            <?php if (!empty($topics_str)) {
                echo $topics_str;
            } ?>
           <br />
           <?php if (!empty($states_str)) {
                echo 'States: ' . $states_str;
            } ?>
           <?php if (!empty($funding_years_str)) {
                echo '| Funding years: ' . $funding_years_str;
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
            <ul class="investigators">
                <?php foreach($gators_sorted as $type) { ?>
                    <?php if($type['name'] != 'Cooperator/Partner') { ?>
                        <h3 class="gator_type"><?=$type['name']?><?=(count($type) > 2 ? 's' : '')?></h3>
                        <?php unset($type['name']);
                        foreach($type as $gator) { ?>
                            <li class="gator">
                                <?php echo implode(', ', array_filter($gator)); ?>
                            </li>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </ul>
            <div class="project-meta">
                <!--
                <?php if($nccwsc) { ?>}
                    <div class="meta-row">
                        <label for="nccwsc">
                            NCCWSC Link
                        </label>
                        <div class="value" id="nccwsc">
                            <a href="<?=$nccwsc?>">Project Page</a>
                        </div>
                    </div>
                <?php } ?>
                -->
                <?php if($partners) { ?>
                    <div class="meta-row">
                        <label for="funding">
                            Partner<?=(count($partners) > 1 ? 's' : '')?>
                        </label>
                        <ul class="value" id="funding">
                            <?php 
                            foreach($partners as $partner) { ?>
                                <li class="$partner"><?=$partner['$partner']?></li>
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
            <?php if($nccwsc) { ?>
                <a href="<?=$nccwsc?>" class="button">Data and Products</a>
            <?php } if($story_map_link) { ?>
                <a href="<?=$story_map_link?>" class="button">Story Map</a>
            <?php } ?>
            
        </div>
    </section>
</article><!-- .article -->