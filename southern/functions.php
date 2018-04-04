<?php

// Include style sheet and script files
function load_scripts(){

	// Load jQuery and Bootstrap JavaScript
	wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array( 'jquery' ), '4.0.0', true );

	// Load theme scripts
	wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/assets/js/jquery.easing.min.js', array(), '1.0', true );
	wp_enqueue_script( 'southern-js', get_template_directory_uri() . '/assets/js/southern.js', array(), '1.0', true );
	
	// Load theme styles
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/assets/css/bootstrap-custom.css', array(), '4.0.0', 'all' );
	wp_enqueue_style( 'southern-style', get_stylesheet_uri() );

	// Font Awesome
	wp_enqueue_script( 'font-awesome', 'https://use.fontawesome.com/releases/v5.0.8/js/all.js', array(), '5.0.8' );

	// Google Fonts
	wp_enqueue_style( 'google-font-lora', 'https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic', array() );
	wp_enqueue_style( 'google-font-cabin', 'https://fonts.googleapis.com/css?family=Cabin:700', array() );

	// Text typing effect
	wp_enqueue_script( 'typewriter', get_template_directory_uri() . '/assets/js/typewriter.js', array(), '20171214' );

	// Parallax
	wp_enqueue_script( 'parallax', get_template_directory_uri() . '/assets/js/parallax.min.js', array(), '1.5.0' );

}
add_action( 'wp_enqueue_scripts', 'load_scripts' );

// Load Custom-NavWalker extension to use Bootstrap menu style and replace links by anchors
require_once get_template_directory() . '/inc/onepage-navwalker.php';

// Register required plugins using TGM_Plugin_Activation class
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

function southern_register_required_plugins() {

	$plugins = array(

		array(
			'name'      => 'Gutenberg',
			'slug'      => 'gutenberg',
			'required'  => true
		),
		array(
			'name'      => 'Caspian GoogleAnalytics',
			'slug'      => 'caspian-googleanalytics',
			'required'  => false
		)

	);

	$config = array(
		'id'           => 'southern',              // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => ''                       // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'southern_register_required_plugins' );

// Main configuration
function configure(){

	// Register menus
	register_nav_menus(
		array(
			'header_menu'	=> 'Header Menu',
			'footer_menu'   => 'Footer Menu'
		)
	);

	// Add theme support for wide images (Gutenberg)
	add_theme_support( 'gutenberg',
		array(
			'wide-images' => true
		)
	);

	// Add theme support for custom background
	$defaults = array(
		'default-color'          => '#000000',
		'default-repeat'         => 'no-repeat',
		'default-position-x'     => 'center',
	    'default-position-y'	 => 'center',
	    'default-size'           => 'auto',
		'default-attachment'     => 'scroll'
	);
	add_theme_support( 'custom-background', $defaults );

}
add_action( 'after_setup_theme', 'configure', 0 );

// Add theme support for custom logo
function southern_custom_logo_setup() {
    $defaults = array(
        'height'      => 50,
        'flex-height' => false,
        'flex-width'  => true
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'southern_custom_logo_setup' );
