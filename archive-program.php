<?php

  get_header();
  pageBanner(array(
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone. Browse our award winning programs.'
  ))
  ?>

  <div class="container container--narrow page-section"><p>Testing No.3</p>
    <ul class="link-list min-list">
      <?php
        while(have_posts()) {
          the_post(); ?>
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></li>
        <?php }
      echo paginate_links();
      ?>
    </ul>

</div><!-- container -->

<?php get_footer();

?>
