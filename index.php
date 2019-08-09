<?php
  get_header(); // This template tag tells WP to get the header.php file and include it in the current theme file.
  if( have_posts() ):
    while( have_posts() ) :
      the_post(); ?>
      <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?><a></h1>
      <p><?php the_excerpt(); ?></h1>
    <?php endwhile;
  else:
    echo "No posts found";
  endif;
  get_footer(); // This template tag tells WP to get the footer.php file and include it in the current theme file.
?>
