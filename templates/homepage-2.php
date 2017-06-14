<?php
/*
Template Name: Homepage Phase 2
*/

get_header();

$heroes = get_field('hero_area');

foreach($heroes as $hero) {
?>
    <div class="full-feature" style="background-image: url(<?=$hero['hero_image']?>)">
        <div class="row">
            <div class="large-12 homepage-features columns">
                <div class="boundless-1">
                    <p class="tag"><?=$hero['tag_text']?></p>
                </div>
                <h1 class="hero-statement"><?=$hero['hero_text']?></h1>
                <p><a class="button" href="<?=$hero['page_link']?>"><?=$hero['link_text']?></a></p>
            </div>
        </div>
    </div>          
<?php
}
?>

<div class="full-summary">
    <div class="row large-collapse">
        <div class="large-12 columns">
            <p class="summary">
                <?=get_field('summary_statement')?>
            </p>
        </div>
        <hr class="summary-divider">
    </div>
</div>

<div class="full-tiles">
    <div class="row">
        <?php
            $tiles = get_field('action_tiles');
            foreach($tiles as $tile) {
        ?>
                <div class="action-tile small-12 medium-4 columns">
                    <h2 class="action-title"><?=$tile['title']?></h2>
                    <p class="action-text"><?=$tile['description']?></p>
                    <a href="<?=$tile['page_link']?>" class="button"><?=$tile['link_text']?></a>
                </div>
        <?php
            }
        ?>
    </div>
</div>

<div class="full-news">
    <div class="row">
        <div class="medium-6 small-12 home-news-section columns">
            <div class="home-news-header">
                <h2 class="left'">News &amp; Events</h2>
                <div class="more-news right show-for-large-up"><a class="button" href="/news-and-events/">All News &amp; Events</a></div>
            </div>

            <?php
            $news_args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 4
            );

            $wp_query = new WP_Query( $news_args );
            if ( $wp_query->have_posts() ) {
                $sticky = false;
                while ( $wp_query->have_posts() ) {

                    $wp_query->the_post();
                    if(is_sticky()) {
                        $sticky = true;
                    }
                    // Link field display
                    if (get_field('story_link_url')) {
                        $post_link_url = get_field('story_link_url');
                        if ( !strpos( $post_link_url, 'cig.uw' ) ) {
                            $post_link_target = ' target="_blank" ';
                        } else {
                            $post_link_target = '';
                        }
                        $source_link = '<a href="' . $post_link_url . '" target="_blank">' . get_field('story_source_name') . '</a>';
                        $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
                    } else {
                        $post_link_url = get_the_permalink();
                        $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
                    }

                    // Get categories
                    $more_terms = wp_get_post_terms( get_the_id(), 'category' );

                    if (!empty($more_terms)) {
                        $more_terms_arr = array();
                        foreach ($more_terms as &$term) {
                            if ( $term->slug != 'uncategorized') {
                                $more_terms_arr[] = '<a href="/about/news/category/' . $term->slug . '">' . $term->name . '</a>';
                            }
                        }
                    }
                    if (!empty($more_terms_arr)) {
                        $more_terms_str = '<span class="terms"> | ' . implode(', ', $more_terms_arr) . '</span>';
                    } else {
                        $more_terms_str = '';
                    }

                    if($sticky) { ?>
                        <div class="featured-item">
                            <?php if ( has_post_thumbnail() ) { ?>
                                <div class="featured-thumbnail">
                                    <a href="<?php echo $post_link_url; ?>" class="img" <?php echo $post_link_target; ?>> 
                                    <?php the_post_thumbnail('home_news'); ?>
                                    </a>
                                </div>

                            <?php } ?>
                            <div class="post-meta">
                                <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date('M j, Y'); ?></time> 
                                <?php echo $more_terms_str; ?>
                                <div class="sharer right">
                                    <?php
                                        $title = rawurlencode(get_the_title());
                                        $shortlink = rawurlencode($post_link_url);
                                        $site_name = rawurlencode(get_bloginfo('name'));
                                        $twitter = get_option('twitter');
                                    ?>
                                    <a href=<?php echo 'http://twitter.com/home?status=' . $title . '%20' . $shortlink . ' target="_blank">' ?>
                                    <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
                                    <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . '" target="_blank">'; ?>
                                    <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
                                    <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article:%20' . $shortlink . '>'; ?>
                                    <?php get_template_part('assets/img/icons/inline', 'email-circle.svg'); ?></a>
                                </div>
                            </div>
                            <div class="post-content">
                                <h3 class="feature-title"><a href="<?php echo $post_link_url ?>" <?php echo $post_link_target; ?>><?=get_the_title()?></a></h3>
                                <p class="feature-excerpt">
                                    <?php echo the_advanced_excerpt( 'length=15&finish=sentence' ); ?>
                                </p>
                                <div><?=$post_link?></div>
                            </div>
                        </div>

                        <?php break;
                    } else {
                        ?>
                        <div class="small-news">
                            <div class="post-meta">
                                <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s'); ?>"><?php echo get_the_date('M j, Y'); ?></time> 
                                <?php echo $more_terms_str; ?>
                                <div class="sharer right">
                                    <?php
                                        $title = rawurlencode(get_the_title());
                                        $shortlink = rawurlencode($post_link_url);
                                        $site_name = rawurlencode(get_bloginfo('name'));
                                        $twitter = get_option('twitter');
                                    ?>
                                    <a href=<?php echo 'http://twitter.com/home?status=' . $title . '%20' . $shortlink . ' target="_blank">' ?>
                                    <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
                                    <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . '" target="_blank">'; ?>
                                    <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
                                    <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article:%20' . $shortlink . '>'; ?>
                                    <?php get_template_part('assets/img/icons/inline', 'email-circle.svg'); ?></a>
                                </div>
                            </div>
                            <h3><a href="<?php echo $post_link_url ?>" <?php echo $post_link_target; ?>><?php echo get_the_title(); ?></a></h3>
                            <div><?php echo $post_link; ?></div>
                        </div>
                        <?php
                    }
                }
            }
            wp_reset_postdata();
            wp_reset_query(); 
            ?>
            </div>
            <div class="medium-6 small-12 columns social-tiles">
                <?php
                    $people_tile = get_field('people_tile')[0];
                    $people_args = array(
                        'post_type' => 'people',
                        'post_status' => 'publish',
                        'posts_per_page' => -1
                    );
                    $people_query = new WP_Query($people_args);
                    $person = array_rand($people_query->posts);
                    $person = $people_query->posts[$person];
                    $title = get_field('job_titles', $person)[0];
                ?>
                <div class="people-tile small-12" style="background-image: url(<?=$people_tile['tile_image']?>)">
                   <div class="tile-wrapper">
                        <a href="<?=get_permalink($person)?>">
                            <?php if(get_the_post_thumbnail_url($person->ID, 'thumbnail')) { ?>
                                <img class="round-tile-img" src="<?=get_the_post_thumbnail_url($person->ID, 'thumbnail')?>" alt="<?=$person->post_title?>" />
                            <?php } else { ?>
                                <img class="round-tile-img" src="<?php echo get_template_directory_uri() . '/assets/img/blank-153x153.jpg' ?>" alt="Person not photographed" />
                            <?php } ?>
                        </a>
                        <h3 class="tile-title">
                            <a href="<?=get_permalink($person)?>">
                                Meet <?=$person->post_title?>
                                <br>
                                <?=$title['title']?>, <?=$title['organization'] ?>
                            </a>
                        </h3>
                        <a href="<?=$people_tile['tile_link']?>" class="button tile-button"><?=$people_tile['tile_link_text']?></a>
                    </div> 
                </div>
                <?php
                    $mail_tile = get_field('email_tile')[0];
                    $tile_image_src = $mail_tile['tile_image']['url'];
                    $tile_image_alt = $mail_tile['tile_image']['alt'];
                ?>
               <div class="small-12 mail-tile" style="background-image: url(<?=$mail_tile['tile_background_image']?>)">
                   <div class="tile-wrapper">
                        <img class="tile-img" src="<?=$tile_image_src?>" alt="<?=$tile_image_alt?>" />
                        <h3 class="tile-title">
                            <a href="<?=$mail_tile['tile_link_url']?>"><?=$mail_tile['tile_title']?></a>
                        </h3>
                        <a href="<?=$mail_tile['tile_link_url']?>" class="button tile-button"><?=$mail_tile['tile_link_text']?></a>
                    </div>
                </div> 
                <?php
                    $twitter_tile = get_field('twitter_tile')[0];
                ?>
                <div class="smedia">
                    <div class="small-6 medium-12 large-6 twitter-tile" style="background-image: url(<?=$twitter_tile['tile_background_image']?>)">
                        <div class="tile-wrapper">
                            <?php if($twitter_tile['tile_link_url'] && $twitter_tile['tile_link_text'] && $twitter_tile['tile_title']) { ?>
                                <img class="tile-img" src="<?=get_template_directory_uri()?>/assets/img/twitter-logo.png" alt="Twitter Logo" />
                                <h3 class="tile-title">
                                    <a href="<?=$twitter_tile['tile_link_url']?>"><?=$twitter_tile['tile_title']?></a>
                                </h3>
                                <a href="<?=$twitter_tile['tile_link_url']?>" class="button tile-button"><?=$twitter_tile['tile_link_text']?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                        $facebook_tile = get_field('facebook_tile')[0];
                    ?>
                   <div class="small-6 medium-12 large-6 facebook-tile" style="background-image: url(<?=$facebook_tile['tile_background_image']?>)">
                        <div class="tile-wrapper">
                            <?php if($facebook_tile['tile_link_url'] && $facebook_tile['tile_link_text'] && $facebook_tile['tile_title']) { ?>
                                <img class="tile-img" src="<?=get_template_directory_uri()?>/assets/img/facebook-like.png" alt="Facebook Like Icon" />
                                <h3 class="tile-title">
                                    <a href="<?=$facebook_tile['tile_link_url']?>"><?=$facebook_tile['tile_title']?></a>
                                </h3>
                                <a href="<?=$facebook_tile['tile_link_url']?>" class="button tile-button"><?=$facebook_tile['tile_link_text']?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php if(have_rows('statistics')) { ?>
    <div class="full-stats">
        <div class="row">
            <div class="small-12 columns">
                <div class="large-12">
                    <h2>Stats &amp; Info</h2>
                    <div class="row stats">
                        <?php while(have_rows('statistics')): the_row(); ?>
                        <div class="large-4 medium-4 small-12 columns">
                            <div class="stat-value"><?php echo get_sub_field('value'); ?></div>
                            <div class="stat-label"><?php echo get_sub_field('label'); ?></div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php while(have_rows('statistics_link')): the_row(); ?>
                        <div class="large-12 text-center"><a class="button" href="<?php echo get_sub_field('link_url'); ?>"><?php echo get_sub_field('link_text'); ?></a></div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<?php get_footer(); ?>
