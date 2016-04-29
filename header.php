<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php if (is_front_page()) {
      echo bloginfo( 'name' );
    } elseif ( is_category() ) {
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
    <meta name="description" content="We are dedicated to sustaining healthy marine and freshwater environments. Our faculty are recognized leaders in aquatic biology, sustainable fisheries management and aquatic resource conservation."></meta>
    
  <script src="//www.washington.edu/static/alert.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ; ?>/css/app.css?time=<?php echo time(); ?>" />
      
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri() ?>/assets/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri() ?>/assets/img/manifest.json">
    <meta name="msapplication-TileColor" content="#4b2e84">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri() ?>/assets/img/ms-icon-144x144.png">
    <meta name="theme-color" content="#4b2e84">
    <?php wp_head(); ?>
    <?php 
    $coenv_host = $_SERVER['HTTP_HOST'];
    $coenv_host_dev = strpos($coenv_host,'.dev');
    if (!$coenv_host_dev)  { ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-67450612-1', 'auto');
      ga('send', 'pageview');
    </script>
    <?php } ?>
  </head>
  <body <?php body_class(); ?>>
    
  
  <div class="skipnav"><a href="#main-col">Skip to main content</a> <a href="#footer">Skip to footer unit links</a></div>
  <?php do_action('foundationPress_after_body'); ?>
  
  <div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
  
  <?php do_action('foundationPress_layout_start'); ?>
  
  <nav class="tab-bar hide-for-medium-up">
    <div class="left-small mobile-logo-container">
        <a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>"><svg id="mobile-logo" width="73" height="49" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 73 49" xml:space="preserve">
              <path id="XMLID_14_" class="st0" d="M53.5,0c0,0.6,0,8.3,0,8.8c0.6,0,6.2,0,6.2,0l-6.9,25.8c0,0-8.5-34.2-8.6-34.6c-0.5,0-8.5,0-9,0
  c-0.1,0.5-9.3,34.6-9.3,34.6L19.5,8.8c0,0,5.9,0,6.5,0c0-0.6,0-8.3,0-8.8C25.3,0,0.6,0,0,0c0,0.6,0,8.3,0,8.8c0.6,0,5.7,0,5.7,0
  s9.9,39.7,10,40.2c0.5,0,13.5,0,13.9,0c0.1-0.5,6.6-25.3,6.6-25.3s6.2,24.8,6.3,25.3c0.5,0,13.5,0,13.9,0
  c0.1-0.5,10.6-40.2,10.6-40.2s5.1,0,5.7,0c0-0.6,0-8.3,0-8.8C72.3,0,54.1,0,53.5,0z"/> <span class="visuallyhidden">School of Aquatic and Fishery Sciences</span>
</svg>
</a>
    </div>
    <div class="middle tab-bar-section">
      <h1 class="title"><a href="<?php bloginfo('url') ?>" rel="home" title="Home"><?php bloginfo( 'name' ); ?></a></h1>
    </div>
    <div class="right-small">
      <a class="right-off-canvas-toggle menu-icon" ><span><i></i></span></a>
    </div>
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
                'exclude' => $exclude,
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
  <div class="full-header show-for-medium-up">
    <div class="row title-row">
    <div class="columns large-12">
    <ul class="title-area hide-for-small">
      <li class="name">
        <h1>
          <a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>">
            <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/logo-w.png" id="logo" alt="University of Washington W" height="108" width="158">
            <span><?php bloginfo('name') ?></span> 
          </a>
          </h1>
            <div class="units show-for-large-up">
                <a href="http://coenv.uw.edu" name="College of the Environment"><img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/logotype-college.png" alt="College of the Environment" class="right"></a><br />
                <a href="http://uw.edu" name="University of Washington"><img src="<?php echo get_bloginfo('template_directory'); ?>/assets/img/logotype-uw.png" alt="University of Washington" class="right uw-name"></a>
          </div> 
        </li>          
      </ul>
    </div>
  </div>
  </div>
  
        <div class="top-bar-container show-for-medium-up">
            <nav class="top-bar" data-topbar="">
                <div class="top-bar-section">
                    <ul id="menu-main-menu" class="top-bar-menu">
                    <?php
                      $exclude = implode(',',coenv_base_menu_exclude());
                      add_filter( 'page_css_class', 'add_parent_class', 10, 4 );
                      wp_list_pages( array(
                          'depth' => 3,
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
                </div>
            </nav>
        </div>

<?php if (!is_front_page()) : ?>
<div class="container">
<?php 
        $banner = coenv_banner();
        $banner_class = $banner ? 'has-banner' : '';
        $banner_class .= ' template-print';
        $coenv_post = get_post($id);
        $coenv_post_section = get_post(array_pop(get_post_ancestors($id)));
?>
    <?php 
        if (is_search()) {
          $banner_style = '';
        } elseif (($banner) && (!is_single())) {
            $banner_style = 'style="background-image: url(' . $banner['url'] . ')"';
        } elseif ($coenv_post->post_type == 'faculty' || $coenv_post->post_type == 'post') {
            $banner_style = 'style="background-image: url(' . $banner['url'] . ')"';
        } elseif ($coenv_post->post_type == 'post') {
            $banner_style = 'style="background-image: url(\'../uploads/sites/4/2014/08/SAFS_News.jpg\')"';
        }
     ?>
    <div class="section-row" <?php echo $banner_style; ?>>
      <div class="container-section-title">
        <?php 
        
        if (is_404()) {
          $section_title = '<h1>Not Found (404)</h1>';
        } elseif (is_search()) {
          $section_title = '<h1>Search Results</h1>';
        } elseif (!is_front_page() && !is_single() && ($coenv_post_section->ID == $coenv_post->ID)) {
          $section_title = '<h1><a href="/' . $coenv_post_section->post_name . '">' . $coenv_post_section->post_title . '</a></h1>';
        } elseif ($coenv_post->post_type == 'faculty') {
          $section_title = '<h2><a href="/faculty-research">Faculty &amp; Research</a></h2>';
        } elseif ($coenv_post->post_type == 'student_blog') {
          $section_title = '<h2><a href="/news-events/student-services-blog/">Student Services Blog</a></h2>';
        } elseif ($coenv_post->post_type == 'post') {
          $section_title = '<h2><a href="/news-events">News &amp; Events</a></h2>';
        } elseif ($coenv_post->post_title =='Archives') {
          $section_title = '';
        } else {
          $section_title = '<h1>' . $coenv_post->post_title . '</h1>';
        }
        echo $section_title;
        ?>
      </div>
    </div>

</div>
<?php endif; ?>
<?php do_action('foundationPress_after_header'); ?>