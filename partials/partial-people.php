<?php

/**
 * People fields
 */
$titles = get_field('job_titles');
$areas = get_field('areas_of_expertise');
$services = get_field('services');
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'person' ) ?>>
    <section class="article__content">
        <div class="people-header">
            <div class="people-meta row">
                <div class="head-left small-12 medium-6 columns ">
                    <div class="people-photo">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <ul class="person_contact">
                        <?php if(get_field('email')) { ?>
                            <li class="email"><a class="email" href="mailto:<?=get_field('email');?>"><?=get_field('email');?></a></li>
                        <?php  } ?>
                        <?php if(get_field('phone')) { ?>
                            <li class="phone"><a class="phone" href="tel:<?=get_field('phone');?>"><?=get_field('phone');?></a></li>
                        <?php  } ?>
                        <?php foreach($services as $service) { ?>
                            <li class="web_services <?=$service['service_name']?>">
                                <a class="<?=$service['service_name']?>" href="<?=$service['service_link']?>"><?=$service['service_name']?></a>
                            </li>
                        <?php } ?> 
                        <?php if(get_field('cirriculum_vitae')) { ?>
                            <li class="cv">
                                <a class="cv" href="<?=get_field('cirriculum_vitae')?>">Curriculum Vitae</a>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
                <div class="head-right small-12 medium-6 columns">
                    <h1 class="people-title article__title">
                        <?php if ( is_page() || is_single()) : ?>
                            <?php the_title() ?>
                            <?php if(get_field('credentials')) { ?>
                                <?php echo ", " . get_field('credentials'); ?>
                            <?php } ?>
                        <?php endif ?>
                    </h1>
                    <div class="titles">
                        <?php foreach($titles as $title) { ?>
                            <div class="job_title">
                                <?=$title['title'];?>
                                <span class="org"><?=$title['organization'];?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if(get_field('quote_or_mission')) { ?>
                        <div class="mission">
                            <?php the_field('quote_or_mission'); ?>
                        </div>
                    <?php } ?>
                    <?php if($areas) { ?>
                    <div class="expertise">
                        <h4 class="expertise_title">Areas of Expertise</h4>
                            <?php for($i = 0; $i < count($areas); $i++) { ?>
                                <?php $area = $areas[$i]; ?>
                                <span class="area"><?=$area['area'];?></span>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="people-content">
            <?php if(get_field('bio')) { ?>
                <div class="bio">
                    <h2>Bio</h2>
                    <?php echo get_field('bio'); ?>
                </div>
            <?php } ?>

            <?php if(get_field('research_interests')) { ?>
                <div class="research-interests">
                    <h2>Research Interests</h2>
                    <?php echo get_field('research_interests'); ?>
                </div>
            <?php } ?>

            <?php if(get_field('current_projects')) { ?>
                <div class="current-projects">
                    <h2>Select Current Projects</h2>
                    <ul class="projects">
                    <?php foreach(get_field('current_projects') as $project) { ?>
                        <li class="project">
                            <a href="<?=$project['project_link']?>"><?=$project['project_name']?></a>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <?php if(get_field('recent_publications')) { ?>
                <div class="recent-pubs">
                    <h2>Recent Publications</h2>
                    <?php foreach(get_field('recent_publications') as $pub) { ?>
                        <p class="pub">
                            <?php echo $pub['citation']; ?>
                        </p>
                    <?php } ?>
                </div>
            <?php } ?>
       </div>
    </section>
</article><!-- .article -->
