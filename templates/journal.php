<?php
/*
  Template Name: Journal
*/

$journal_date = get_field('journal_date', 'option');
$journal_volume = get_field('journal_volume', 'option');
$journal_issue = get_field('journal_issue', 'option');
$journal_cover = get_field('journal_cover', 'option');

?>
<?php get_header(); ?>
<div class="row">
    <?php //coenv_base_section_title($post->ID); ?>
    <?php //if (!is_front_page() && function_exists('bcn_display')): ?>
    <!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
    <?php //endif; ?>
    <div class="small-12 medium-8 columns" role="main" id="main-col">
    <?php do_action('foundationPress_before_content'); ?>
    <?php dynamic_sidebar("before-content"); ?>
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
            <?php do_action('foundationPress_page_before_entry_content'); ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            <footer>
                <?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>
                <p><?php the_tags(); ?></p>
            </footer>
        </article>
    <?php endwhile;?>
    <?php if ( is_active_sidebar( 'after-content' ) ) : ?>
        <div id="after-content" class="before-content widget-area" role="complementary">
            <?php dynamic_sidebar( 'after-content' ); ?>
        </div><!-- #after-content -->
    <?php endif; ?>
    <a href="#" class="back-to-top">Back to Top</a>
    <?php do_action('foundationPress_before_content'); ?>

    </div>
    <aside id="sidebar" class="small-12 medium-4 large-3 columns">
        <div class="widget journal-info">
            <h3>Current Issue</h3>

            <div class="journal-cover">
                <img class="" src="<?php echo $journal_cover['url']; ?>" alt="<?php echo $journal_cover['alt']; ?>" />
            </div>

            <ul class="journal-meta">
                <li class="journal-date"><span class="meta-label">Published: </span><?php echo $journal_date; ?></li>
                <li class="journal-volume"><span class="meta-label">Volume: </span><?php echo $journal_volume; ?></li>
                <li class="journal-issue"><span class="meta-label">Issue: </span><?php echo $journal_issue; ?></li>
            </ul>

        </div>

        <div class="widget journal-articles">
            <h3>Recent Articles</h3>
            <?php
                $rss = fetch_feed('http://rss.sciencedirect.com/publication/science/00335894');
                if(!is_wp_error($rss)) {
                    // Figure out how many total items there are, but limit it to 5. 
                    $maxitems = $rss->get_item_quantity( 15 ); 

                    // Build an array of all the items, starting with element 0 (first element).
                    $rss_items = $rss->get_items( 0, $maxitems );
                }

                ?>
                <ul class="article-list">
                    <?php if ( $maxitems == 0 ) : ?>
                        <li>There are currently no recent articles.</li>
                    <?php else : ?>
                        <?php // Loop through each feed item and display each item as a hyperlink. ?>
                        <?php foreach ( $rss_items as $item ) : 
                        ?>
                            <li>
                                <a href="<?php echo esc_url( $item->get_permalink() ); ?>">
                                    <?php echo esc_html( $item->get_title() ); ?> (<?php echo $item->get_date('j F Y'); ?>)
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
        </div>
        <?php
        $ancestor_id = coenv_base_get_ancestor('ID');
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )):

            dynamic_sidebar( $ancestor_id );
        endif;
        ?>
    </aside>
</div>
<?php get_footer(); ?>
