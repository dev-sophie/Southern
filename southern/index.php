<?php get_header(); ?>

<!-- Intro Header -->
<header class="masthead">
  <div class="intro-body">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h1 class="brand-heading">Grayscale</h1>
          <p class="intro-text">A free, responsive, one page Bootstrap theme.
            <br>Created by Start Bootstrap.</p>
            <a href="#about" class="btn btn-circle js-scroll-trigger">
            <i class="fa fa-angle-double-down animated"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- About Section -->
<section id="about" class="content-section text-center">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <h2>About Grayscale</h2>
        <p>Grayscale is a free Bootstrap theme created by Start Bootstrap. It can be yours right now, simply download the template on
          <a href="http://startbootstrap.com/template-overviews/grayscale/">the preview page</a>. The theme is open source, and you can use it for any purpose, personal or commercial.</p>
        <p>This theme features stock photos by
          <a href="http://gratisography.com/">Gratisography</a>
          along with a custom Google Maps skin courtesy of
          <a href="http://snazzymaps.com/">Snazzy Maps</a>.</p>
        <p>Grayscale includes full HTML, CSS, and custom JavaScript files along with SASS and LESS files for easy customization!</p>
      </div>
    </div>
  </div>
</section>

<!-- Download Section -->
<section id="download" class="download-section content-section text-center">
  <div class="container">
    <div class="col-lg-8 mx-auto">
      <h2>Download Grayscale</h2>
      <p>You can download Grayscale for free on the preview page at Start Bootstrap.</p>
      <a href="http://startbootstrap.com/template-overviews/grayscale/" class="btn btn-default btn-lg">Visit Download Page</a>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="content-section text-center">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <h2>Contact Start Bootstrap</h2>
        <p>Feel free to leave us a comment on the
          <a href="http://startbootstrap.com/template-overviews/grayscale/">Grayscale template overview page</a>
          on Start Bootstrap to give some feedback about this theme!</p>
        <ul class="list-inline banner-social-buttons">
          <li class="list-inline-item">
            <a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg">
              <i class="fa fa-twitter fa-fw"></i>
              <span class="network-name">Twitter</span>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="https://github.com/BlackrockDigital/startbootstrap" class="btn btn-default btn-lg">
              <i class="fa fa-github fa-fw"></i>
              <span class="network-name">Github</span>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="https://plus.google.com/+Startbootstrap/posts" class="btn btn-default btn-lg">
              <i class="fa fa-google-plus fa-fw"></i>
              <span class="network-name">Google+</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php
$location = 'header_menu';

if ( has_nav_menu( $location ) ){
  // Get data of the menu in the location
  $locations = get_nav_menu_locations();
  $menu = get_term( $locations[$location], 'nav_menu' );

  // Get post ids of items in the menu
  $items = wp_get_nav_menu_items( $menu->term_id );

  foreach ( $items as $item ) {
    $ids[] = get_post_meta( $item->ID, '_menu_item_object_id', true );
  }

  if ( isset( $ids ) ){
    $args = array(
      'posts_per_page' => 6,
      'post_type' => array( 'page' ),
      'post__in' => $ids,
      'orderby' => 'post__in'
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ){
      while ( $query->have_posts() ) : $query->the_post(); ?>

      <section id="<?php echo $post->post_name ?>" class="content-section text-center">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <h2><?php the_title(); ?></h2>
              <p><?php the_content(); ?></p>
            </div>
          </div>
        </div>
      </section>

      <?php endwhile;
    }

    wp_reset_query();
  }
}
?>

<?php get_footer(); ?>
