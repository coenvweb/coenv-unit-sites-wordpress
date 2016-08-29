<?php

/*
 * Register widget areas and define format
 */

function coenv_base_sidebar_widgets() {

  $before_widget  = '<div class="small-12 collapse">';
  $before_widget_two_columns  = '<div class="small-6 columns">';
  $before_widget_three_columns  = '<div class="medium-4 columns">';
  $before_widget_four_columns  = '<div class="medium-3 small-6 columns">';
  $before_title   = '<h4>';
  $after_title  = '</h4>';
  $after_widget = '</div> <!-- end #%1$s -->';

  register_sidebar(array(
      'id' => 'sidebar-widgets',
      'name' => __('Sidebar / All', 'foundationpress'),
      'description' => __('Drag widgets to this container.', 'foundationpress'),
      'before_widget' => $before_widget,
      'after_widget' => $after_widget,
      'before_title' => $before_title,
      'after_title' => $after_title
  ));

  /**
   * Adds a widget area for each section.
   */

  // this will return only top-level pages
  $pages = get_pages('parent=0&sort_column=menu_order&sort_order=ASC');
  $pages_to_remove = coenv_base_menu_exclude();

  if ( empty( $pages ) ) {
    return false;
  }

  foreach( $pages as $page ) {
    // remove specific pages
    if( !in_array( $page->ID, $pages_to_remove ) ) {
      register_sidebar( array(
        'id' => 'sidebar-' . $page->ID,
        'name' => 'Sidebar / ' . $page->post_title,
        'description' => __('Drag widgets to this container.', 'foundationpress'),
        'before_widget' => $before_widget,
        'after_widget'  => $after_widget,
        'before_title'  => $before_title,
        'after_title' => $after_title
      ) );
    }
  }

  register_sidebar(array(
      'id' => 'homepage-twitter',
      'name' => __('Home / Twitter Sidebar', 'foundationpress'),
      'description' => __('Drag widgets to this container', 'foundationpress')
  ));
  register_sidebar(array(
      'id' => 'after-content',
      'name' => __('Body / After content', 'foundationpress'),
      'description' => __('Drag widgets to this container', 'foundationpress'),
      'before_widget' => $before_widget,
      'after_widget' => $after_widget,
      'before_title' => $before_title,
      'after_title' => $after_title     
  )); 
  register_sidebar(array(
      'id' => 'home-content',
      'name' => __('Home / Main Content after Feature', 'foundationpress'),
      'description' => __('Drag widgets to this container', 'foundationpress'),
      'before_widget' => $before_widget,
      'after_widget' => $after_widget,
      'before_title' => $before_title,
      'after_title' => $after_title     
  ));
  register_sidebar(array(
      'id' => 'home-columns',
      'name' => __('Home / After Main Content 3-Columns', 'foundationpress'),
      'description' => __('Drag widgets to this container', 'foundationpress'),
      'before_widget' => $before_widget_three_columns,
      'after_widget' => $after_widget,
      'before_title' => $before_title,
      'after_title' => $after_title     
  ));
  register_sidebar(array(
      'id' => 'hosted-events',
      'name' => __('Home / Hosted events', 'foundationpress'),
      'description' => __('Drag widgets to this container', 'foundationpress'),
      'before_widget' => $before_widget_four_columns,
      'after_widget' => $after_widget,
      'before_title' => $before_title,
      'after_title' => $after_title     
  ));


}

add_action( 'widgets_init', 'coenv_base_sidebar_widgets' );


/*
 * Faculty research areas
 */

class coenv_base_fac_cats extends WP_Widget {

     /**
      * Register widget with WordPress.
      */
     function __construct() {
          parent::__construct(
               'coenv_base_fac_cats', // Base ID
               __('Faculty category filter (COENV)', 'text_domain'), // Name
               array( 'description' => __( 'Allows filtering of faculty based on research area', 'text_domain' ), ) // Args
          );
     }
     

     /**
      * Front-end display of widget.
      *
      * @see WP_Widget::widget()
      *
      * @param array $args     Widget arguments.
      * @param array $instance Saved values from database.
      */
     public function widget( $args, $instance ) {
          $fac_cat = get_term_by( 'slug', (string) $_GET['fac-cat'], 'research_areas' );
          $fac_cat = $fac_cat->slug;
     
          echo $args['before_widget'];
          
          if ( ! empty( $instance['title'] ) ) {
               echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
          }
          if ( ! empty( $instance['textarea'] ) ) {
               echo $args['before_text'] . apply_filters( 'widget_text', $instance['textarea'] ). $args['after_text'];
          }
                    $cats_args  = array(
                      'orderby' => 'name',
                      'order' => 'ASC',
                      'taxonomy' => 'research_areas'
                      );
                    $cats = get_categories($cats_args);
                    if ($cats) {
                         echo '<ul class="fac-cats">';
                         if ($fac_cat):
                              echo '<li><a class="button" href="/faculty">All Research Areas</a></li>';
                         endif;
                         foreach($cats as $cat) { 
                              echo '<li><a class="button" href="/faculty/?fac-cat=' . $cat->slug . '">' . $cat->name . '</a></li>';
                         }
                         echo '</ul>';
                    }
          echo $args['after_widget'];
     }

     /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
     public function form( $instance ) {
      //var_dump($instance);

          if ( isset( $instance[ 'title' ] ) ) {
               $title = $instance[ 'title' ];
          }
          else {
               $title = __( 'Sort faculty by research area', 'text_domain' );
          }
          if ( isset( $instance[ 'textarea' ] ) ) {
               $textarea = $instance[ 'textarea' ];
          }
          else {
               $textarea = __( '', 'text_domain' );
          }
          
          ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
          </p>
          <p>
          <label for="<?php echo $this->get_field_id( 'textarea' ); ?>"><?php _e( 'Description:' ); ?></label> 
          <textarea class="widefat" id="<?php echo $this->get_field_id( 'textarea' ); ?>" name="<?php echo $this->get_field_name( 'textarea' ); ?>" type="text"><?php echo $textarea; ?></textarea>
          </p>
         
          <?php 
     }

     /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
     public function update( $new_instance, $old_instance ) {
          $instance = array();
          $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
          $instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? strip_tags( $new_instance['textarea'] ) : '';


          return $instance;
     }

} // class coenv_base_fac_cats

// register coenv_base_fac_cats widget
function register_coenv_base_fac_cats() {
    register_widget( 'coenv_base_fac_cats' );
}
add_action( 'widgets_init', 'register_coenv_base_fac_cats' );

/*
 * Sub-navigation
 */

class coenv_base_subnav extends WP_Widget {

     /**
      * Register widget with WordPress.
      */
     function __construct() {
          parent::__construct(
               'coenv_base_subnav', // Base ID
               __('Sub-navigation (COENV)', 'text_domain'), // Name
               array( 'description' => __( 'Sub-navigation for each section, usually placed in the sidebar.', 'text_domain' ), ) // Args
          );
     }
     

     /**
      * Front-end display of widget.
      *
      * @see WP_Widget::widget()
      *
      * @param array $args     Widget arguments.
      * @param array $instance Saved values from database.
      */
     public function widget( $args, $instance ) {
          if ($GLOBALS['post']->post_parent) {
            echo coenv_base_section_title($GLOBALS['post']->ID);
          }
          echo $args['before_widget'];

          echo coenv_base_hierarchical_submenu($GLOBALS['post']->ID);
          echo $args['after_widget'];
     } 
     /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
     public function form( $instance ) {
      //var_dump($instance);

      if ( isset( $instance[ 'title' ] ) ) {
           $title = $instance[ 'title' ];
      }
      ?>
      <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
      </p>
     
      <?php 
     } 

} 

function register_coenv_base_subnav() {
    register_widget( 'coenv_base_subnav' );
}
add_action( 'widgets_init', 'register_coenv_base_subnav' );


/**
 * Events Widget
 */
register_widget( 'CoEnv_Widget_Events' );
class CoEnv_Widget_Events extends WP_Widget {

  public function __construct() {
    $args = array(
      'classname' => 'widget widget-events',
      'description' => __( 'Display a short list of Trumba calendar events.', 'coenv' )
    );
 
    parent::__construct(
      'trumba_events', // base ID
      'Trumba Events', // name
      $args
    );
  }

  public function widget( $args, $instance ) {
    extract( $args );

    if (isset($instance['title'])) {
        $title = apply_filters( 'widget_title', $instance['title'] );
    } else {
        $title = null;
    }
    if (isset($instance['feed_url'])) {
        $feed_url = apply_filters( 'feed_url', $instance['feed_url'] );
    }
    if (isset($instance['events_url'])) {
        $events_url = apply_filters( 'events_url', $instance['events_url'] );
    } else {
        $events_url = null;
    }
    if (isset($instance['posts_per_page'])) {
        $posts_per_page = (int) $instance['posts_per_page'];
    } else {
        $posts_per_page = 3;
    }

    if ( !isset( $feed_url ) || empty( $feed_url ) ) {
      return;
    }

    // get cached XML from WP transient API
    $events_xml = get_transient( 'trumba_events_xml' );
    if ( $events_xml === false || $events_xml === '' ) {
      $events_xml = file_get_contents( $feed_url );
      set_transient( 'trumba_events_xml', $events_xml, 1 * MINUTE_IN_SECONDS );
    }
    
    $xml = new SimpleXmlElement($events_xml);
    
    $events = array();

    foreach ($xml->channel->item as $item) {     
      $events[] = array(
        'title' => $item->title,
        'date'  => $item->category,
        'url' => $item->link
      );
    }

    $events = array_slice( $events, 0, $posts_per_page );

    ?>
      <?php echo $before_widget; ?>
         <div class="widget-events">

            <?php if ( $title ) {
                echo $before_title;
                echo '<span><a href="' . $events_url . '" title="View More Events">' . $title . '</a></span>';
                echo $after_title;
                }
            ?>

      <ul class="event-list">

      <?php if ( count( $events ) ) : ?>

        <?php foreach ( $events as $key => $event ) : ?>


            <li class="" data-equalizer-watch>
                <?php
                $date = substr($event['date'], 0, -6);
                $date = strtotime($date);
                $date = date('l, M j, Y ', $date); ?>
                <a href="<?php echo $event['url'] ?>">
                    <div class="single-event">
                        <i class="fi-calendar"></i><p class="date"><?php echo $date ?></p>
                        <p class="title"><?php echo $event['title'] ?></p>
                    </div>
                </a>
            </li>

      

        <?php endforeach ?>

      <?php else : ?>

        <li><p class="title">No upcoming events.</p>
            <p class="small">Additional events can be found on the <a href="http://environment.washington.edu/alumni-and-community/calendar-events/" title="College of the Environment Calendar">College of the Environment Events Calendar</a>.</p></li>

      <?php endif;
          unset ($events);
          ?>
        
      </ul>
      </div>

      <?php echo $after_widget ?>
    
    <?php
  }

  public function form( $instance ) {

    $title = isset( $instance['title'] ) ? $instance['title'] : __( 'Events', 'coenv' );
    $feed_url = $instance['feed_url'];
    $events_url = $instance['events_url'];
    $posts_per_page = isset( $instance['posts_per_page'] ) ? (int) $instance['posts_per_page'] : 5;
 
    ?>
      <p>
        <label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_name( 'feed_url' ) ?>"><?php _e( 'Feed URL:' ) ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'feed_url' ) ?>" name="<?php echo $this->get_field_name( 'feed_url' ) ?>" value="<?php echo esc_attr( $feed_url ) ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_name( 'events_url' ) ?>"><?php _e( 'More link (URL):' ) ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'events_url' ) ?>" name="<?php echo $this->get_field_name( 'events_url' ) ?>" value="<?php echo esc_attr( $events_url ) ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_name( 'posts_per_page' ) ?>">Number of events to show: </label>
        <input name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" type="text" size="3" value="<?php echo $posts_per_page ?>" />
      </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['feed_url'] = strip_tags( $new_instance['feed_url'] );
    $instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
    $instance['events_url'] = strip_tags( $new_instance['events_url'] );
     
    return $instance;
  }

}

/*
 * Blog or news categories
 */

class coenv_base_blog_cats extends WP_Widget {

     /**
      * Register widget with WordPress.
      */
     function __construct() {
          parent::__construct(
               'coenv_base_blog_cats', // Base ID
               __('News/Blog category filter (COENV)', 'text_domain'), // Name
               array( 'description' => __( 'Allows filtering of blog posts base on blog category', 'text_domain' ), ) // Args
          );
     }
     

     /**
      * Front-end display of widget.
      *
      * @see WP_Widget::widget()
      *
      * @param array $args     Widget arguments.
      * @param array $instance Saved values from database.
      */
     public function widget( $args, $instance ) {
          $blog_cat = get_term_by( 'slug', (string) $_GET['term'], 'category' );
          $blog_cat = $blog_cat->slug;
     
          echo $args['before_widget'];
          
          if ( ! empty( $instance['title'] ) ) {
               echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
          }
          if ( ! empty( $instance['textarea'] ) ) {
               echo $args['before_text'] . apply_filters( 'widget_text', $instance['textarea'] ). $args['after_text'];
          }
            $cats_args  = array(
              'orderby' => 'name',
              'order' => 'ASC',
              'taxonomy' => 'category'
              );
            $cats = get_categories($cats_args);
            if ($cats) {
                 echo '<ul class="blog-cats inline-list">';
                 if ($blog_cat) {
                 echo '<li><a class="cats unchecked" href="/about/news/">All News</a></li>';
                 }
                 foreach($cats as $cat) { 
                     $slug = $cat->slug;
                     if ($slug == $blog_cat) {
                         $check = 'active';
                     } else {
                         $check = '';
                     }

                     if ($slug !== 'uncategorized') {

                         echo '<li><a class="cats ' . $check . '" href="/about/news/?tax=category&term=' . $cat->slug . '">';
                         echo $cat->name;
                         echo '</a></li>';
                     }
                 }
                 echo '</ul>';
            }
          echo $args['after_widget'];
     }

     /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
     public function form( $instance ) {
      //var_dump($instance);

          if ( isset( $instance[ 'title' ] ) ) {
               $title = $instance[ 'title' ];
          }
          else {
               $title = __( 'Blog or News Categories (list)', 'text_domain' );
          }
          if ( isset( $instance[ 'textarea' ] ) ) {
               $textarea = $instance[ 'textarea' ];
          }
          else {
               $textarea = __( '', 'text_domain' );
          }
          
          ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
          </p>
          <p>
          <label for="<?php echo $this->get_field_id( 'textarea' ); ?>"><?php _e( 'Description:' ); ?></label> 
          <textarea class="widefat" id="<?php echo $this->get_field_id( 'textarea' ); ?>" name="<?php echo $this->get_field_name( 'textarea' ); ?>" type="text"><?php echo $textarea; ?></textarea>
          </p>
         
          <?php 
     }

     /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
     public function update( $new_instance, $old_instance ) {
          $instance = array();
          $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
          $instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? strip_tags( $new_instance['textarea'] ) : '';


          return $instance;
     }

} 



function register_coenv_base_blog_cats() {
    register_widget( 'coenv_base_blog_cats' );
}
add_action( 'widgets_init', 'register_coenv_base_blog_cats' );

/*
 * Placeholder for date-based archive for custom post types
 */

class coenv_base_index_dates extends WP_Widget {

     /**
      * Register widget with WordPress.
      */
     function __construct() {
          parent::__construct(
               'coenv_base_index_dates', // Base ID
               __('Filter by date (COENV)', 'text_domain'), // Name
               array( 'description' => __( 'Allows filtering of indexes (faculty, news, blog post, etc.) by date', 'text_domain' ), ) // Args
          );
     }
     

     /**
      * Front-end display of widget.
      *
      * @see WP_Widget::widget()
      *
      * @param array $args     Widget arguments.
      * @param array $instance Saved values from database.
      */
     public function widget( $args, $instance ) {
          if(isset($_GET['coenv-year'])){
            $coenv_year = (int) urlencode(htmlentities($_GET['coenv-year']));
            $coenv_month = (int) urlencode(htmlentities($_GET['coenv-month']));
            // Month needs an offset because php and WordPress calculate dates differently.
            $coenv_date = date('F Y',mktime(10,0,0,$coenv_month+1,0,$coenv_year));
          } else {
              $coenv_year = $coenv_month = $coenv_date = null;
          }
          echo $args['before_widget'];
          
          if ( ! empty( $instance['title'] ) ) {
               echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
          }
          if ( ! empty( $instance['textarea'] ) ) {
               echo $args['before_text'] . apply_filters( 'widget_text', $instance['textarea'] ). $args['after_text'];
          }

            $counter = 0;
            $ref_month = ''; 
            $monthly = new WP_Query(array('posts_per_page' => -1, 'post_type'   => $post_type));
            echo '<ul class="select-category">';
            if( $monthly->have_posts() ) : 
                while( $monthly->have_posts() ) : $monthly->the_post();
                    if( get_the_date('mY') != $ref_month ) { 
                        $month_num = get_the_date('m');
                        $month_str = get_the_date('F');
                        $year_num = get_the_date('Y');
                        if ($year_num == $coenv_year && $month_num == $coenv_month) {
                         $selected = ' selected="selected"';
                        } else {
                            $selected = ''; 
                        }
                        echo '<li><a href="about/news/?coenv-year=' . $year_num . '&coenv-month=' . $month_num  . '"' . $selected . '>' . $month_str . ' ' . $year_num . '</a></li>';
                       // echo "\n".get_the_date('F Y');
                        $ref_month = get_the_date('mY');
                        $counter = 0;
                    }   
                endwhile;
            endif;
            echo '</select>';
            wp_reset_postdata();
            wp_reset_query();

          echo $args['after_widget'];
     }

     /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
     public function form( $instance ) {
      //var_dump($instance);

          if ( isset( $instance[ 'title' ] ) ) {
               $title = $instance[ 'title' ];
          }
          else {
               $title = __( 'Categories', 'text_domain' );
          }
          if ( isset( $instance[ 'textarea' ] ) ) {
               $textarea = $instance[ 'textarea' ];
          }
          else {
               $textarea = __( '', 'text_domain' );
          }
          
          ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
          </p>
          <p>
          <label for="<?php echo $this->get_field_id( 'textarea' ); ?>"><?php _e( 'Description:' ); ?></label> 
          <textarea class="widefat" id="<?php echo $this->get_field_id( 'textarea' ); ?>" name="<?php echo $this->get_field_name( 'textarea' ); ?>" type="text"><?php echo $textarea; ?></textarea>
          </p>
         
          <?php 
     }

     /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
     public function update( $new_instance, $old_instance ) {
          $instance = array();
          $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
          $instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? strip_tags( $new_instance['textarea'] ) : '';


          return $instance;
     }

} 


function register_coenv_base_index_dates() {
    register_widget( 'coenv_base_index_dates' );
}
add_action( 'widgets_init', 'register_coenv_base_index_dates' );

/**
 * Social Links Widget
 */

class CoEnv_Widget_Social extends WP_Widget {
 
  function __construct() {
    $args = array(
      'classname' => 'widget-social',
      'description' => __( 'Display social media links from the General Settings', 'coenv' )
    );
 
    parent::__construct(
      'social_links', // base ID
      'Social Media Links', // name
      $args
    );
  }
 
  public function form( $instance ) {
 
    if ( isset( $instance['title'] ) ) {
      $title = $instance['title'];
    } else {
      $title = __( 'Get Connected', 'coenv' );
    }
 
    ?>
      <p>
        <label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
      </p>
    <?php
  }
 
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
     
    return $instance;
  }
 
  public function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters( 'widget_title', $instance['title'] );
 
    echo $before_widget;
    
        if (!is_front_page()) {
            echo $before_title . '<span>' . $title . '</span>' . $after_title;
        }
        ?>
        
    <ul>
        <?php if (get_option('facebook')) { ?><a href="<?php echo get_option('facebook'); ?>" title="Become a fan of <?php bloginfo('name'); ?> on Facebook" target="_blank" rel="nofollow"><li><i class="fi-social-facebook"><span>Facebook</span></i></li></a><?php } ?>
        <?php if (get_option('twitter')) { ?><a href="https://twitter.com/<?php echo get_option('twitter'); ?>" title="Follow <?php bloginfo('name'); ?> on Twitter" target="_blank" rel="nofollow"><li><i class="fi-social-twitter"><span>Twitter</span></i></li></a><?php } ?>
        <?php if (get_option('youtube')) { ?><a href="<?php echo get_option('youtube'); ?>" title="<?php bloginfo('name'); ?> YouTube Channel" target="_blank" rel="nofollow"><li><i class="fi-social-youtube"><span>YouTube</span></i></li></a><?php } ?>
        <?php if (get_option('linkedin')) { ?><a href="<?php echo get_option('linkedin'); ?>" title="<?php bloginfo('name'); ?> LinkedIn Group" target="_blank" rel="nofollow"><li><i class="fi-social-linkedin"><span>LinkedIn</span></i></li></a><?php } ?>
        <?php if (get_option('email_newsletter')) { ?><a href="<?php echo get_option('email_newsletter'); ?>" title="Subscribe to the <?php bloginfo('name'); ?>'s Email Newsletter" target="_blank" rel="nofollow"><li><i class="fi-at-sign"><span>Email Newsletter</span></i></li></a><?php } ?>
        <a href="<?php echo get_bloginfo('url').'/feeds'; ?>" title="<?php bloginfo('name'); ?> RSS Feeds"><li><i class="fi-rss"><span>RSS</span></i></li></a>
      </ul>
 
    <?php
    echo $after_widget;
  }
}

function register_coenv_widget_social() {
    register_widget( 'CoEnv_Widget_Social' );
}

add_action( 'widgets_init', 'register_coenv_widget_social' );


/**
 * Course Archive Widget
 */

class coenv_course_archive extends WP_Widget {
 
  function __construct() {
    $args = array(
      'classname' => 'widget-course-archive',
      'description' => __( 'Display archived course quarters', 'coenv' )
    );
 
    parent::__construct(
      'course-archive', // base ID
      'Course Archive Links', // name
      $args
    );
  }
 
  public function form( $instance ) {
 
    if ( isset( $instance['title'] ) ) {
      $title = $instance['title'];
    } else {
      $title = __( 'Course Archive', 'coenv' );
    }
 
    ?>
      <p>
        <label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
      </p>
    <?php
  }
 
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
     
    return $instance;
  }
 
  public function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters( 'widget_title', $instance['title'] );
 
    echo "<div class='show-for-medium-up'>";
        echo $before_widget;
        
            if (!is_front_page()) {
                echo '<h4 class="course_archive">' . $title . '</h4>';
            }
            if (get_query_var('course_quarter')) {
                $coenv_cat_1 = 'course_quarter';
                $coenv_cat_term_1 = get_query_var('course_quarter');
            } else {
                $current_quarters = get_field('quarter_to_display');
                $qtr_term_0 = get_term_by('id', $current_quarters[0], 'course_quarter');
                $coenv_cat_term_1 = $qtr_term_0->slug;
            }
            $old_cats = $GLOBALS['old_cats'];
            $old_cats_ids = array();
            foreach ($old_cats as $old_cat) {
                $old_cats_ids[] = $old_cat->term_id;
            }
            $old_cats_ids = array_reverse($old_cats_ids);
            $old_cats_ids = array_splice($old_cats_ids, 1);
            $old_cats_ids = (implode(',',$old_cats_ids));

            coenv_base_cat_filter('course_quarter',$coenv_cat_term_1)
            ?>

        <?php
        echo $after_widget;
    echo "</div>";
  }
}

function register_coenv_course_archive() {
    register_widget( 'coenv_course_archive' );
}

add_action( 'widgets_init', 'register_coenv_course_archive' );

// unregister all default WP Widgets
function unregister_default_wp_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Nav_Menu_Widget');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);






  /**
    * Stats and info widget
    */

class coenv_base_stats extends WP_Widget {

     
     function __construct() {
          parent::__construct(
               'coenv_base_stats', // Base ID
               __('Stats & Info', 'text_domain'), // Name
               array( 'description' => __( 'Statistics and information for the CIG homepage', 'text_domain' ), ) // Args
          );
     }
     

     /**
      * Front-end display of widget.
      *
      * @see WP_Widget::widget()
      *
      * @param array $args     Widget arguments.
      * @param array $instance Saved values from database.
      */
     public function widget( $args, $instance ) {
     
          echo $args['before_widget'];
          
          if ( ! empty( $instance['title'] ) ) {
               echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
          }
          echo '<div class="large-12">';
          echo '<div class="row">';
          echo '<div class="large-4 columns" style="text-align: center; text-transform:uppercase; font-size: 2rem;">56<br />Projects in 2014</div>';
          echo '<div class="large-4 columns" style="text-align: center; text-transform:uppercase; font-size: 2rem;">163<br />Partners in the Field</div>';
          echo '<div class="large-4 columns" style="text-align: center; text-transform:uppercase; font-size: 2rem;">1,295<br />Papers Published</div>';
          echo '</div>';
          echo '<div class="row" style="text-align: center;">';
          echo '<div class="large-12"><a class="button">Learn More About Our Partners</a></div>';
          echo '</div>';
          echo '</div>';

          echo $args['after_widget'];
     }

     /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
     public function form( $instance ) {
      //var_dump($instance);

          if ( isset( $instance[ 'title' ] ) ) {
               $title = $instance[ 'title' ];
          }
          else {
               $title = __( 'Stats & Info', 'text_domain' );
          }
          ?>
          <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
          </p>
         
          <?php 
     }

     /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
     public function update( $new_instance, $old_instance ) {
          $instance = array();
          $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';


          return $instance;
     }

} 
function register_coenv_base_stats() {
    register_widget( 'coenv_base_stats' );
}
add_action( 'widgets_init', 'register_coenv_base_stats' );
