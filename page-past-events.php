<?php

  get_header();
  pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.'
  ));
  ?>

  <div class="container container--narrow page-section">
    <?php
      $today = date('Ymd');
      $pastEvents = new WP_Query(array(
        'posts_per_page' => '1',
        'paged' => get_query_var('paged', 1), //get_query_var() gets all sorts of information from the pages URL. In this case from the past events page URL.
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key' => 'event_date',
            'compare' => '<',
            'value' => $today,
            'type' => 'numeric'
          )
        )
      ));

      while($pastEvents -> have_posts()) {
        $pastEvents -> the_post();
        get_template_part('template-parts/content-event');
      }
      echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
      ));
    ?>
</div><!-- container -->

<?php get_footer();

?>
