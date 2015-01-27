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
            //$exclude = implode(',',coenv_base_menu_exclude());
            wp_list_pages( array(
                'depth' => 0,
                'walker' => new top_bar_mobile_walker(),
                'title_li' => false,
                'sort_column' => 'menu_order, post_title',
                'post_type'    => 'page',
               // 'exclude' => '$exclude',
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
                      wp_reset_query();
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
<div class="page-row <?php if (is_single()) {echo 'mini';} ?>"
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
            <?php get_template_part('assets/img/icons/inline', 'twitter-circle.svg'); ?></a>
            <a href=<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $shortlink . '&p[images][0]=&p[title]=' . $title . '%20from%20' . $site_name .'" target="_blank">'; ?>
            <?php get_template_part('assets/img/icons/inline', 'facebook-circle.svg'); ?></a>
            <a href=<?php echo 'mailto:?subject=' . $title . '&body=Check%20out%20this%20article%20from%20the%20' . $site_name .':%20' . $shortlink . '>'; ?>
            <?php get_template_part('assets/img/icons/inline', 'email-circle.svg'); ?></a>
        </div>
    </div>
    </div>
</div>
<?php endif; ?>
  <?php do_action('foundationPress_after_header'); ?>
  
