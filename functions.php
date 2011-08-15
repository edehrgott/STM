<?php
/*
 * STM child functions.php
 *
 */
// theme requires jQuery - need to enqueue here even though called in parent theme because of fancybox calls here
wp_enqueue_script('jquery');

if ( !is_admin() ) { //superfish scripts aren't needed for admin area
	// added by ed for fancybox
	wp_register_script('fancybox', get_stylesheet_directory_uri() . '/fancybox/jquery.fancybox-1.3.1.pack.js' );
	wp_register_script('fancybox-easing', get_stylesheet_directory_uri() . '/fancybox/jquery.easing-1.3.pack.js' );
	wp_register_script('fancybox-local', get_stylesheet_directory_uri() . '/fancybox/fancybox_local.js' ); // added by ed for jquery popup compatability
	// enqueue the scripts
	wp_enqueue_script('fancybox');
	wp_enqueue_script('fancybox-easing');
	wp_enqueue_script('fancybox-local');
}

// simple replace filter to add ID attribute to the <a> occurence for the calendar popup in wp_page_menu - added by Ed 
function add_menu_cal_id($a_id) {
	return preg_replace('<a href="http://html/calendar.html">', 'a href="/html/calendar.html" id="cal_popup" title="My Calendar"', $a_id, 1);
}
add_filter('wp_nav_menu','add_menu_cal_id');

// overriding function to change header image size
if ( !function_exists('tpSunrise_customisetheme_setup') ):
    //Any theme customisations contained in this function
    function tpSunrise_customisetheme_setup() {
        //Define default header image
	  if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	  // No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	  if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/tpSunrise_joy.jpg' );
	  
        
        //Define the width and height of our header image
        define( 'HEADER_IMAGE_WIDTH', apply_filters( 'tpSunrise_header_image_width', 588 ) ); //size overridden
        define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'tpSunrise_header_image_height', 125 ) ); //size overridden
	  
	  // We'll be using post thumbnails for custom header images on posts and pages.
	  // We want them to be 940 pixels wide by 200 pixels tall.
	  // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	  set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );	
        
        //Don't forget this, it adds the functionality to the admin menu
        add_custom_image_header( '', 'tpSunrise_customisetheme_admin_header_style' );
        
        //Set some custom header images, add as many as you like
        //%s is a placeholder for your theme directory
        $customHeaders = array (
                //Image 1
                'joy' => array (
                'url' => '%s/images/tpSunrise_joy.jpg',
                'thumbnail_url' => '%s/images/tpSunrise_joy_thumb.jpg',
                'description' => __( 'Joy', 'tpSunrise' )
            ),
                //Image 2
                'desert' => array (
                'url' => '%s/images/tpSunrise_farm.jpg',
                'thumbnail_url' => '%s/images/tpSunrise_farm_thumb.jpg',
                'description' => __( 'Farm', 'tpSunrise' )
            ),
                //Image 3
                'sunrise' => array (
                'url' => '%s/images/tpSunrise_sunrise.jpg',
                'thumbnail_url' => '%s/images/tpSunrise_sunrise_thumb.jpg',
                'description' => __( 'Sunrise', 'tpSunrise' )
            )
        );
        //Register the images 
        register_default_headers($customHeaders);
    }
endif;

?>
