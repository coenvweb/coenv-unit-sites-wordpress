<?php get_header(); ?>
<?php 
        $banner = coenv_banner();
        $banner_class = $banner ? 'has-banner' : '';
        $banner_class .= ' template-print';
?>
<div class="page-row"
    <?php if ( $banner ) {
            echo 'style="background-image: url(' . $banner['url'] . '); min-height: 200px;">';
            echo '<div class="teal-wedge">';
        }
     ?>
     <?php if (empty($banner)) {
            echo 'style="background-color: #4b2e83;">';
            echo '<div class="teal-wedge">';
     }
     ?>
    <div class="section-row row">
        <?php echo coenv_base_section_title($post->ID); ?>
        <?php 
        $title = get_the_title();
        $shortlink = wp_get_shortlink();
        ?>
        <div class="sharing right"><span class="share-text">Share</span> 
            <a href=<?php echo 'http://twitter.com/home?status=' . $title . ' ' . $shortlink . ' from @SMEAatUW" target="_blank">' ?>
               <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

<path id="twitter-5-icon" d="M256,90c91.742,0,166,74.244,166,166c0,91.741-74.245,166-166,166c-91.743,0-166-74.245-166-166

	C90,164.259,164.244,90,256,90 M256,50C142.229,50,50,142.229,50,256s92.229,206,206,206s206-92.229,206-206S369.771,50,256,50

	L256,50z M368.797,201.997c-7.712,3.42-15.999,5.732-24.697,6.771c8.876-5.322,15.696-13.748,18.906-23.79

	c-8.311,4.928-17.512,8.506-27.307,10.435c-7.843-8.357-19.02-13.579-31.387-13.579c-27.756,0-48.16,25.902-41.889,52.8

	c-35.736-1.793-67.423-18.913-88.63-44.928c-11.265,19.323-5.844,44.61,13.308,57.409c-7.049-0.223-13.682-2.158-19.478-5.379

	c-0.466,19.922,13.811,38.552,34.489,42.708c-6.052,1.646-12.681,2.023-19.419,0.735c5.472,17.084,21.354,29.516,40.17,29.862

	c-18.079,14.169-40.849,20.495-63.661,17.807c19.028,12.2,41.632,19.32,65.915,19.32c79.834,0,124.939-67.433,122.222-127.911

	C355.741,218.194,363.031,210.62,368.797,201.997z"/>

</svg>
</a>
            <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . ' from UW School of Marine and Environmental Affairs" target="_blank">'; ?>
               <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

<path id="facebook-circle-outline-icon" d="M256.417,90c44.34,0,86.026,17.267,117.38,48.62c31.354,31.354,48.62,73.04,48.62,117.38

	c0,44.34-17.267,86.026-48.62,117.38c-31.354,31.353-73.04,48.62-117.38,48.62s-86.026-17.268-117.38-48.62

	c-31.354-31.354-48.62-73.04-48.62-117.38c0-44.34,17.267-86.026,48.62-117.38C170.391,107.267,212.077,90,256.417,90 M256.417,50

	c-113.771,0-206,92.229-206,206s92.229,206,206,206s206-92.229,206-206S370.188,50,256.417,50L256.417,50z M228.111,218.133h-23.517

	v38.386h23.517v112.764h45.22V256.04h31.551l3.358-37.907h-34.909c0,0,0-14.155,0-21.593c0-8.938,1.801-12.477,10.438-12.477

	c6.957,0,24.471,0,24.471,0v-39.347c0,0-25.797,0-31.309,0c-33.649,0-48.82,14.814-48.82,43.186

	C228.111,212.614,228.111,218.133,228.111,218.133z"/>

</svg></a>
            <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article%20from%20the%20UW%20School%20of%20Marine%20and%20Environmental%20Affairs:%20' . $shortlink . '>'; ?>
         <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

<path id="email-10-icon" d="M256,90c44.34,0,86.026,17.267,117.38,48.62S422,211.659,422,256c0,44.34-17.267,86.026-48.62,117.38

	C342.026,404.732,300.34,422,256,422s-86.026-17.268-117.38-48.62C107.267,342.026,90,300.34,90,256

	c0-44.341,17.267-86.026,48.62-117.38S211.66,90,256,90 M256,50C142.229,50,50,142.229,50,256s92.229,206,206,206

	s206-92.229,206-206S369.771,50,256,50L256,50z M232.759,241.081 M213.419,248.356l-61.479-47.225v108.702L213.419,248.356z

	 M361.514,179.178h-208.85l104.342,80.152L361.514,179.178z M286.252,259.396l-29.255,22.437l-29.303-22.508l-75.498,75.498H361.68

	L286.252,259.396z M300.538,248.438l61.522,61.522V201.254L300.538,248.438z"/>

</svg></a>
        </div>
    </div>
    </div>
</div>

<div class="row">
	<?php //coenv_base_section_title($post->ID); ?>
	<?php //if (!is_front_page() && function_exists('bcn_display')): ?>
	<!--<div class="breadcrumbs"><?php //bcn_display(); ?></div>-->
	<?php //endif; ?>
	<div class="small-12 medium-8 columns right main" role="main">
	
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>" class="template-page">
			<?php do_action('foundationPress_page_before_entry_content'); ?>
			<div class="entry-content">

                <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

                    <header class="article__header">
                        <div class="article__meta">
                            <?php if ( !is_page() ) : ?>
                            <div class="post-info">
                                <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time> 
                                <?php $categories = get_the_category_list(' ') ?>
                                <?php if ( $categories ) : ?>
                                <div class="article__categories">
                                    | <?php echo $categories ?>
                                </div>
                            </div>
                            <?php endif ?> 
                        </div>
                        <?php endif ?>
                        <?php if ($GLOBALS['post']->post_parent) : ?>
                        <?php if ( is_page() || is_single()) : ?>
                            <h1 class="article__title"><?php the_title() ?></h1>
                        <?php else : ?>
                            <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
                        <?php endif ?>
                        <?php endif ?>

                    </header>

                    <section class="article__content">
                        <?php the_content() ?>
                    </section>
                    <?php remove_filter( 'the_title', 'wptexturize' );
                    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

                </article><!-- .article -->

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
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>