<!DOCTYPE html>
<html <?php language_attributes(); ?>>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php bloginfo( 'name' ); ?></title>

    <?php wp_head(); ?>

  </head>

  <body id="page-top" <?php body_class(); ?>>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
          <?php if ( function_exists( 'the_custom_logo' ) ) {
            the_custom_logo();
          } ?></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <?php wp_nav_menu(
            array(
              'theme_location' => 'header_menu',
              'menu_id'        => 'header-menu',
              'container'      => false,
              'depth'          => 1,
              'menu_class'     => 'navbar-nav ml-auto',
              'walker'         => new OnePage_NavWalker()
            )
          ); ?>
        </div>
      </div>
    </nav>
