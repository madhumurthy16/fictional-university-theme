<?php

  require get_theme_file_path('/inc/search-route.php');
  
  // Add a custom field to JSON data
  function university_custom_rest() {
    register_rest_field('post', 'authorName', array(
      'get_callback' => function() {return get_the_author();}
    ));
  }

  add_action('rest_api_init', 'university_custom_rest');

  function pageBanner($args = NULL) { // NULL makes the arguments optional for this function. If nothing is passed it will not throw an error.
    if(!$args['title']) {
      $args['title'] = get_the_title();
    }

    if(!$args['subtitle']) {
      $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if(!$args['photo']) {
      if(get_field('page_banner_background_image')) {
        $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
      }
      else {
        $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
    }
    ?>

    <div class="page-banner">
      <div class="page-banner__bg-image"
        style="background-image: url(<?php echo $args['photo'] ?>);">
      </div>
        <div class="page-banner__content container container--narrow">
          <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
          <div class="page-banner__intro">
            <p><?php echo $args['subtitle'] ?></p>
          </div>
        </div>
    </div>

  <?php }

  function university_files() {
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyCH3pZ5cUH45ECKJckIEw2vaCE7Hp_wWjg', NULL, '1.0' , true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
    wp_localize_script('main-university-js', 'universityData', array(
      'root_url' => get_site_url()
    ));
  }

  add_action('wp_enqueue_scripts', 'university_files');

  function university_features() {
    /*register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two'); */
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
  }

  add_action('after_setup_theme', 'university_features');

  function university_post_types() {

    //  Campus Post Type

      register_post_type('campus', array(
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'campuses'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
        'name' => 'Campuses',
        'add_new_item' => 'Add New Campus',
        'edit_item' => 'Edit Campus',
        'all_items' => 'All Campuses',
        'singular_name' => 'Campus'
      ),
      'menu_icon' => 'dashicons-location-alt'
      ));

    // Event Post Type
      register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
        'name' => 'Events',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'all_items' => 'All Events',
        'singular_name' => 'Event'
      ),
      'menu_icon' => 'dashicons-calendar'
      ));

      // Program Post Type
      register_post_type('program', array(
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'programs'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
        'name' => 'Programs',
        'add_new_item' => 'Add New program',
        'edit_item' => 'Edit program',
        'all_items' => 'All Programs',
        'singular_name' => 'Program'
      ),
      'menu_icon' => 'dashicons-awards'
      ));

      // Professor Post Type
      register_post_type('professor', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'public' => true,
        'labels' => array(
        'name' => 'Professors',
        'add_new_item' => 'Add New professor',
        'edit_item' => 'Edit professor',
        'all_items' => 'All Professors',
        'singular_name' => 'Professor'
      ),
      'menu_icon' => 'dashicons-welcome-learn-more'
      ));

    }

add_action( 'init', 'university_post_types' );

function university_adjust_queries($query) {
  if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()) {
    $query->set('posts_per_page', -1);
  }

  if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }

  if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key','event_date');
    $query->set('orderby','meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
}

add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api) {
  $api['key'] = 'AIzaSyCH3pZ5cUH45ECKJckIEw2vaCE7Hp_wWjg';
  return $api;
}
add_filter('acf/fields/google_map/api', 'universityMapKey');
