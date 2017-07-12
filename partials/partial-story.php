<?php 
if (get_field('story_link_url')) {
			$post_link_url = get_field('story_link_url');
			$post_link_target = ' target="_blank" ';
            $post_link = '<p><a class="button" href="' . $post_link_url . '"' . $post_link_target . '>' . get_field('story_source_name') . '</a></p>';
        } else {
        	$post_link_url = get_the_permalink();
            $post_link = '<a class="button left" href="' . $post_link_url . '">Read more</a>';
        } 
?>

<article class="story featured-story" id="story-<?php the_ID() ?>">

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="featured-thumbnail">
            <a href="<?php echo $post_link_url ?>" class="img" <?php if(isset($post_link_target)) {echo $post_link_target;} ?>>
                <?php the_post_thumbnail( 'large' ); ?>
            </a>
        </div>
    <?php endif ?>

    <div class="post-meta">
        <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time>
        <?php // Get categories
            if (!empty($terms)) {
                $terms_arr = array();

                foreach ($terms as &$term) {
                    if ($term->slug != 'uncategorized') {
                        $terms_arr[] = '<a href="/news-and-events/?tax=category&amp;term=' . $term->slug . '">' . $term->name . '</a>';
                    }
                }
                $terms_str = ' / ' . implode(', ', $terms_arr);

            } else {
                $terms_str = '';
            }
            $terms = "";
        ?>
        <?php echo $terms_str; ?>
    </div>

    <div class="content">
        <h3><a href="<?php echo $post_link_url ?>"><?php the_title() ?></a></h3>
        <p><?php the_advanced_excerpt('length=15&finish=sentence') ?></p>
        <?php if (is_page_template('templates/homepage.php')) : ?>
            <a href="<?php echo $post_link_url ?>" class="button">Read more »</a>
        <?php else : ?>
            <div class="blog-links right">
		<?php if(isset($rows)) {
            foreach($rows as $row) {
                if($row['blog_link_type'] == 'upload') {
                    echo '<a class="button" href="' . $row['blog_upload_file'] . '" target="_blank">' . $row['blog_file_link_text'] . '</a>';
                } elseif ($row['blog_link_type'] == 'link') {
                    echo '<a class="button" href="' . $row['blog_link_url'] . '" target="_blank">' . $row['blog_link_text'] . '</a>';
                } 
            }
        }; ?>
		</div>
        <?php endif ?>
    </div>

</article>