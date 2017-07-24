<?php  
/**
 * An individual preview in search results
 */
?>
<div class="search-result" id="post-<?php the_ID() ?>">

    <div class="article__header">
        <h2 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h2>
    </div>

    <section class="article__content">
        <?php the_advanced_excerpt('length=30&finish=sentence') ?>
    </section>

</div>

