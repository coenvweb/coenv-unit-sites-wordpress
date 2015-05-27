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
      echo bloginfo( 'name' );
    } ?></title>

    <meta name="title" content="<?php bloginfo('name'); ?>">
    <meta name="description" content="<?php
    wp_reset_query();   
    if (have_posts()) : while(have_posts()) the_post();
        if (is_singular('faculty')) {
            $advancedExcerpt = strip_tags(get_field('biography'));
        } elseif (is_page_template( 'faculty.php' )) {    
            $advancedExcerpt = 'Our world-class faculty are at the center of our work at The UW' . bloginfo('name');
        } elseif (is_singular()&&is_front_page()==false ) {
            $advancedExcerpt = strip_tags(get_the_excerpt());
        } else {
            $advancedExcerpt = get_option('meta_description');
        }
        endif;
    echo $advancedExcerpt ?>">
    
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
    <?php
    $post = get_queried_object();
        $post_title = get_the_title().' | ' . get_bloginfo( 'name' );
    $post_description = $advancedExcerpt;
    $post_link = get_permalink();
  if ( has_post_thumbnail( $post->ID ) ) {
    $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $post_image = $thumb_src[0];
  } elseif ( $banner ) {
    $post_image = $banner['url'];
  } else {
    $post_image = get_template_directory_uri().'/assets/img/icons/logo-1200x1200.png';
  }
  
  ?>
  <meta property="og:title" content="<?php echo $post_title ?>" />
  <meta property="og:description" content="<?php echo $post_description ?>" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="<?php echo $post_link ?>" />
  <meta property="og:image" content="<?php echo $post_image ?>" />
  <meta property="og:site_name" content="<?php bloginfo('name') ?>" />

  <script>
  /*
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-21836351-1', 'auto');
    ga('send', 'pageview');
  */
  </script>
  </head>
  <body <?php body_class($banner_class); ?>>
  
  <div class="skipnav"><a href="#main-col">Skip to main content</a> <a href="#footer">Skip to footer unit links</a></div>
  <?php do_action('foundationPress_after_body'); ?>
  
  <div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
  
  <?php do_action('foundationPress_layout_start'); ?>
  
  <nav class="tab-bar show-for-small-only">
    <section class="left-small mobile-logo">
        <a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>">
          <svg id="logo" width="108" height="73" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 108 73" enable-background="new 0 0 108 73" height="73px" width="108px" xml:space="preserve">
              <path d="M79.343,0.112c0,0.858,0,12.238,0,13.098c0.856,0,9.206,0,9.206,0L78.271,51.461
                c0,0-12.577-50.636-12.756-51.349c-0.687,0-12.626,0-13.303,0c-0.188,0.696-13.796,51.352-13.796,51.352L28.95,13.21
                c0,0,8.726,0,9.585,0c0-0.859,0-12.239,0-13.098c-0.919,0-37.532,0-38.451,0c0,0.858,0,12.238,0,13.098c0.851,0,8.52,0,8.52,0
                s14.703,58.809,14.88,59.522c0.708,0,19.942,0,20.639,0c0.183-0.697,9.852-37.454,9.852-37.454s9.188,36.747,9.364,37.454
                c0.707,0,19.941,0,20.639,0C84.164,72.03,99.635,13.21,99.635,13.21s7.6,0,8.449,0c0-0.859,0-12.239,0-13.098
                C107.176,0.112,80.251,0.112,79.343,0.112z"></path>
          </svg>
        </a>
    </section>
    <section class="middle tab-bar-section">

            <h1 class="title"><a href=""><?php bloginfo( 'name' ); ?></a></h1>
    </section>
    <section class="right-small">
      <a class="right-off-canvas-toggle menu-icon" ><span></span></a>
    </section>
  </nav>

  <aside class="right-off-canvas-menu">
    <nav class="mobile-menu">
            <?php
            echo '<ul class="off-canvas-list"><li>';
            get_search_form();
            echo '</li></ul>';
            
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
  <div class="banner-container"> 
  <div class="title-row">
      <div class="purple-wedges show-for-medium-up left medium-2">
          <div class="purple-wedge-dk"></div>
          <div class="purple-wedge-lt"></div>
      </div>
      <div class="name large-2 show-for-medium-up left">
        <a class="logo" href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>">
          <!--[if gte IE 9]><!-->
          <svg id="logo" width="130" height="100" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 108 73" xml:space="preserve">
            <path d="M79.343,0.112c0,0.858,0,12.238,0,13.098c0.856,0,9.206,0,9.206,0L78.271,51.461
            c0,0-12.577-50.636-12.756-51.349c-0.687,0-12.626,0-13.303,0c-0.188,0.696-13.796,51.352-13.796,51.352L28.95,13.21
            c0,0,8.726,0,9.585,0c0-0.859,0-12.239,0-13.098c-0.919,0-37.532,0-38.451,0c0,0.858,0,12.238,0,13.098c0.851,0,8.52,0,8.52,0
            s14.703,58.809,14.88,59.522c0.708,0,19.942,0,20.639,0c0.183-0.697,9.852-37.454,9.852-37.454s9.188,36.747,9.364,37.454
            c0.707,0,19.941,0,20.639,0C84.164,72.03,99.635,13.21,99.635,13.21s7.6,0,8.449,0c0-0.859,0-12.239,0-13.098
            C107.176,0.112,80.251,0.112,79.343,0.112z"/>
          </svg>
          <!--<![endif]-->
          <!--[if lte IE 8]>
          <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/W.png" id="logo">
          <!--<![endif]-->
        </a>
      </div>
      <div class="logotype large-9 show-for-medium-up left">

        <div id="unit-college-uw" class="centered">
          <h1 class="left"><a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>"><?php bloginfo('name') ?></a></h1>
          <div class="units show-for-large-up">
            <ul>
              <li><a href="http://coenv.uw.edu" name="UW College of the Environment"><img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/College-of-the-Environment.png" class="college-name" width="215" height="12"></a></li>
              <li><a href="http://uw.edu" name="University of Washington"><img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/UW-Tagline.png" class="uw-name"></a></li>
            </ul>
          </div>
        </div>
      </div>
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
    <?php if (($banner) && (!is_single())) {
            echo '<div class="page-row mini section-wrapper" style="background-image: url(' . $banner['url'] . ');">';
            echo '<div class="section-title-wrapper">';
        }
     ?>
     <?php if ( (empty($banner)) || (is_single()) ) {
            echo '<div class="page-row mini section-wrapper" style="background-image: url(' . $banner['url'] . ');">';
            echo '<div class="section-title-wrapper">';
     }
     ?>
    <div class="section-row row">
        <div class="columns large-8 section-title"><?php echo coenv_base_section_title($post->ID); ?></div>
    </div>
    </div>
</div>
<?php endif; ?>
<?php do_action('foundationPress_after_header'); ?>