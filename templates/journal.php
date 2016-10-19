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
    <div class="small-12 medium-8 columns" role="main" id="main-col">
    <?php dynamic_sidebar("before-content"); ?>
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
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

            <div class="journal-articles">
            <?php
                if( have_rows('journal_articles', 'options') ) {

                    echo '<h3>Recent Journal Articles</h3>';
                    echo '<ul class="article-list">';
                        while ( have_rows('journal_articles', 'options') ) : the_row();

                            $title = get_sub_field('article_title');
                            $link = get_sub_field('article_link');
                            echo '<a href="'.$link.'"><li>'.$title.'</li></a>';

                        endwhile;
                    echo '</ul>';
                }
            ?>
            </div>
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
