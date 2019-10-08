<?php
  get_header();
  if( have_posts() ):
    while( have_posts() ) :
      the_post();
      pageBanner();
      ?>


  <div class="container container--narrow page-section">
  <?php
    $theParent = wp_get_post_parent_ID(get_the_ID()); //  $theParent -> holds the ID of the current pages parent page.

    if($theParent) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php echo the_title(); ?></span></p>
      </div>
    <?php
    } ?>

    <?php
    $testArray = get_pages(array(  // $testArray is '0' if the current page has no children. Otherwise it holds the list of current pages.
      'child_of' => get_the_ID()
    ));

    // if the current page has a parent or if it is a parent display the list of child menu links.
    if($theParent or $testArray) { ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
      <ul class="min-list">

        <?php

          if($theParent) {
            // If $theParent is not '0', we are on a child page. Then $findChildrenOf will hold its parent's ID. We then get the children of that parent ID in wp_list_pages().
            $findChildrenOf = $theParent;
          }
          else { // If $theParent holds zero, we are on a parent page. We then use get_the_ID() fn. to get the ID of the current page. Then $findChildrenOf will hold the parent page ID. We then get the children of that parent ID in wp_list_pages().
            $findChildrenOf = get_the_ID();
          }

          wp_list_pages(array(
            'title_li' => NULL,
            'sort_column' => 'menu_order',
            'child_of' => $findChildrenOf
          ));
        ?>

      </ul>
    </div>
  <?php } ?>
  <div class="generic-content">
    <p><?php the_content(); ?></h1>
  </div>

</div>

  <?php endwhile;
endif;
get_footer();
?>
