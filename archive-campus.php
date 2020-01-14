<?php

  get_header();
  pageBanner(array(
    'title' => 'Our Campuses',
    'subtitle' => 'We have several conveniently located campuses.'
  ));
  ?>



  <div class="container container--narrow page-section">
    <!-- Displaying the campus names until google map issue is resolved. Delete once fixed.-->
    <?php
      while(have_posts()) {
      the_post(); ?>
      <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    <?php  } ?> <!-- Delete till here -->

    <div class="acf-map">
      <?php
        while(have_posts()) {
          the_post();
          $mapLocation = get_field('map_location');
        }
      ?>
      <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng=<?php echo $mapLocation['lng']; ?>">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php echo mapLocation['address']; ?>
      </div>
    </div>

</div><!-- container -->

<?php get_footer();

?>
