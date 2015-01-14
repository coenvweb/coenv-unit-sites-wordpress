<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
  <head>
    <meta charset="utf-8" />
    <meta name='robots' content='noindex,follow' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php if ( is_category() ) {
      echo 'Category Archive for &quot;'; single_cat_title(); echo '&quot; | '; bloginfo( 'name' );
    } elseif ( is_tag() ) {
      echo 'Tag Archive for &quot;'; single_tag_title(); echo '&quot; | '; bloginfo( 'name' );
    } elseif ( is_archive() ) {
      wp_title(''); echo ' Archive | '; bloginfo( 'name' );
    } elseif ( is_search() ) {
      echo 'Search for &quot;'.esc_html($s).'&quot; | '; bloginfo( 'name' );
    } elseif ( is_home() || is_front_page() ) {
      bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
    }  elseif ( is_404() ) {
      echo 'Error 404 Not Found | '; bloginfo( 'name' );
    } elseif ( is_single() ) {
      wp_title('');
    } else {
      echo wp_title( ' | ', 'false', 'right' ); bloginfo( 'name' );
    } ?></title>
    
  <script src="//www.washington.edu/static/alert.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ; ?>/css/app.css" />
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/icons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/icons/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/icons/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/icons/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon.png">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/foundation-icons/foundation-icons.css">
    <!--<script type="text/javascript" src="//use.typekit.net/dyq8fxo.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>-->

  
    <?php wp_head(); ?>
      
    <?php 
        $banner = coenv_banner();
        $banner_class = $banner ? 'has-banner' : '';
        $banner_class .= ' template-print';
    ?>
  </head>
  <body <?php body_class($banner_class); ?>>
  
  <div class="skipnav"><a href="#main-col">Skip to main content</a> <a href="#footer">Skip to footer unit links</a></div>
  <?php do_action('foundationPress_after_body'); ?>
  
  <div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
  
  <?php do_action('foundationPress_layout_start'); ?>
  
  <nav class="tab-bar show-for-small-only">
    <section class="right-small">
      <a class="right-off-canvas-toggle menu-icon" ><span></span></a>
    </section>
    <section class="middle tab-bar-section">
      
      <h1 class="title"><?php bloginfo( 'name' ); ?></h1>

    </section>
  </nav>

  <aside class="right-off-canvas-menu">
    <nav class="mobile-menu">
            <?php
            
            add_filter( 'page_css_class', 'add_parent_class', 10, 4 );
            $exclude = implode(',',coenv_base_menu_exclude());
            wp_list_pages( array(
                'depth' => 0,
                'walker' => new top_bar_mobile_walker(),
                'title_li' => false,
                'sort_column' => 'menu_order, post_title',
                'post_type'    => 'page',
                'exclude' => '$exclude',
            ) );
            remove_filter( 'page_css_class', 'add_parent_class', 10, 4 );
            ?>
    </nav>
    <?php foundationPress_mobile_off_canvas(); ?>
  </aside>
  <nav id="top-nav" class="show-for-medium-up">
    <div class="row">
      <div class="top-menu normal-top-menu">
        <?php wp_nav_menu(array(
          'theme_location' => 'uw-links',
          'depth' => 1,
          'menu_id' => 'menu-university',
          'container' => false,
          'fallback_cb' => false
        )) ?> 
        
          <?php wp_nav_menu(array(
          'theme_location' => 'top-links', 
          'depth' => 1,
          'menu_id' => 'menu-top',
          'container' => false, 
          'walker' => new CoEnv_Top_Menu_Walker(),
          'fallback_cb' => false
        )); ?>

        <?php get_search_form() ?>

        <?php wp_nav_menu(array(
          'theme_location' => 'top-buttons', 
          'depth' => 1, 
          'menu_id' => 'menu-buttons',
          'container' => false,
          'fallback_cb' => false
        )); ?>

      </div><!-- .top-menu -->
    </div><!-- .row -->
  </nav><!-- #top-nav -->
  
  <div class="row title-row">
    <div>
    <ul class="title-area show-for-medium-up">
      <li class="name">
        <h1>
          <a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>">
            <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/W.png" id="logo">
            <span><?php bloginfo('name') ?></span> 
          </a>
          </h1>
            <div class="units show-for-large-up">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/slash.png" class="slash left">
                <a href="http://coenv.uw.edu" name="UW College of the Environment"><img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/College-of-the-Environment.png" class="right"></a><br />
                <a href="http://uw.edu" name="University of Washington"><img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/UW-Tagline.png" class="right uw-name"></a>
          </div> 
        </li>          
      </ul>
    </div>
  </div>
  
        <div class="top-bar-container show-for-medium-up">
            <nav class="top-bar" data-topbar="">
                <section class="top-bar-section">
                    <ul id="menu-main-menu" class="top-bar-menu">
                    <?php
                      $exclude = implode(',',coenv_base_menu_exclude());
                      add_filter( 'page_css_class', 'add_parent_class', 10, 4 );
                      wp_list_pages( array(
                          'depth' => 0,
                          'walker' => new top_bar_new_walker(),
                          'title_li' => false,
                          'sort_column' => 'menu_order, post_title',
                          'post_type'    => 'page',
                          'exclude' => $exclude,
                      ) );
                      remove_filter( 'page_css_class', 'add_parent_class', 10, 4 );
                      ?>
                    </ul>
                </section>
            </nav>
        </div>
      

<?php if (!is_front_page()) : ?>
<section class="container" role="document">
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
        $title = rawurlencode(get_the_title());
        $shortlink = rawurlencode(wp_get_shortlink());
        $site_name = rawurlencode(get_bloginfo('name'));
        $twitter = get_option('twitter');
        ?>
        <div class="sharing right"><span class="share-text">Share</span> 
            <a href=<?php echo 'http://twitter.com/home?status=' . $title . '%20' . $shortlink . '%20from%20' . $twitter . ' target="_blank">' ?>
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
            <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . '%20from%20' . $site_name .'" target="_blank">'; ?>
               <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">

<path id="facebook-circle-outline-icon" d="M256.417,90c44.34,0,86.026,17.267,117.38,48.62c31.354,31.354,48.62,73.04,48.62,117.38

	c0,44.34-17.267,86.026-48.62,117.38c-31.354,31.353-73.04,48.62-117.38,48.62s-86.026-17.268-117.38-48.62

	c-31.354-31.354-48.62-73.04-48.62-117.38c0-44.34,17.267-86.026,48.62-117.38C170.391,107.267,212.077,90,256.417,90 M256.417,50

	c-113.771,0-206,92.229-206,206s92.229,206,206,206s206-92.229,206-206S370.188,50,256.417,50L256.417,50z M228.111,218.133h-23.517

	v38.386h23.517v112.764h45.22V256.04h31.551l3.358-37.907h-34.909c0,0,0-14.155,0-21.593c0-8.938,1.801-12.477,10.438-12.477

	c6.957,0,24.471,0,24.471,0v-39.347c0,0-25.797,0-31.309,0c-33.649,0-48.82,14.814-48.82,43.186

	C228.111,212.614,228.111,218.133,228.111,218.133z"/>

</svg></a>
            <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article%20from%20the%20' . $site_name .':%20' . $shortlink . '>'; ?>
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
<?php endif; ?>
  <?php do_action('foundationPress_after_header'); ?>
  
