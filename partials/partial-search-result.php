<?php  
/**
 * An individual preview in search results
 */
?>
<div class="search-result" id="post-<?php the_ID() ?>">

    <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>

    <section class="article__content">
        <?php the_advanced_excerpt('length=30&finish=sentence') ?>
    </section>

</div>

