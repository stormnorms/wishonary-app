<?php

/**
 * Scripts to include on front pages
 *
 * @package olympus-wp
 */
$theme_version = olympus_get_theme_version();

/* ==============
 * REGISTER
 * 3-rd party plugins
  =============== */

wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/css/swiper.min.css', false, '4.2.6' );

wp_enqueue_script( 'swiper-js', get_template_directory_uri() . '/js/plugins/swiper.min.js', array( 'jquery' ), '4.2.6', true );

//wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/plugins/waypoints.js', array( 'jquery' ), null, true );

wp_register_script( 'count-to', get_template_directory_uri() . '/js/plugins/jquery.countTo.js', array( 'jquery' ), null, true );

wp_enqueue_script( 'magnific-popup-js', get_template_directory_uri() . '/js/plugins/magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );

wp_enqueue_style( 'magnific-popup-css', get_template_directory_uri() . '/css/magnific-popup.css', false, '1.1.0' );

wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/plugins/perfect-scrollbar.min.js', array( 'jquery' ), '4.2.6', true );

wp_register_script( 'isotope', get_template_directory_uri() . '/js/plugins/isotope.pkgd.js', array( 'imagesloaded' ), '3.0.4', true );

wp_register_script( 'jquery-mousewheel', get_template_directory_uri() . '/js/plugins/jquery-mousewheel.js', array( 'jquery' ), '3.1.13', true );

wp_register_script( 'jquery-match-height', get_template_directory_uri() . '/js/plugins/jquery-match-height.js', array( 'jquery' ), '0.7.0', true );

wp_register_script( 'ico-moon', get_template_directory_uri() . '/js/plugins/ico-moon.js', array( 'jquery' ), '1.2.3', true );

wp_register_script( 'bootstrap-select', get_template_directory_uri() . '/js/plugins/bootstrap-select.js', array( 'jquery' ), '1.2.3', true );

wp_register_script( 'scroll-to-fixed', get_template_directory_uri() . '/js/plugins/scroll-to-fixed.js', array( 'jquery' ), '1.0.0', true );

wp_register_script( 'material-forms', get_template_directory_uri() . '/js/plugins/material-forms.js', array( 'jquery' ), '1.0.0', true );

wp_register_script( 'smooth-scroll', get_template_directory_uri() . '/js/plugins/smooth-scroll.js', array( 'jquery' ), '2.1.5', true );

wp_register_script( 'reframe', get_template_directory_uri() . '/js/plugins/reframe.js', array( 'jquery' ), '2.2.1', true );

/* ======================
 *  THEME CSS COMPONENTS
  ==================== */
//Unyson
if ( function_exists( 'fw' ) ) {
    fw()->backend->option_type( 'icon-v2' )->packs_loader->enqueue_frontend_css();
    wp_dequeue_style( 'fw-option-type-icon-v2-pack-font-awesome' );
}

//Font awesome
wp_enqueue_style( 'yz-icons', get_template_directory_uri() . '/css/fontawesome.all.min.css', array(), '5.12.1' );

// Bootstrap.
wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/Bootstrap/dist/css/bootstrap.css', array(), '4.0.0' );

// Small JS plugins css
wp_register_style( 'olympus-js-plugins', get_template_directory_uri() . '/css/theme-js-plugins.css', false, $theme_version );

// Add font, used in the main stylesheet.
wp_enqueue_style( 'olympus-theme-font', olympus_font_url(), array(), $theme_version );

wp_register_style( 'olympus-widgets', get_template_directory_uri() . '/css/widgets.css', array(), '5.0.6' );

// Theme.
wp_enqueue_style( 'olympus-main', get_template_directory_uri() . '/css/main.css', array( 'olympus-widgets', 'olympus-js-plugins' ), $theme_version );


/* ======================
 *  THEME JS COMPONENTS
  ==================== */
if ( is_singular() ) {
    wp_enqueue_script( 'comment-reply' );
}

wp_register_script( 'olympus-mega-menu', get_template_directory_uri() . '/js/crum-mega-menu.js', array( 'jquery' ), $theme_version, true );

wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/Bootstrap/dist/js/bootstrap.bundle.js', array( 'jquery' ), '4.0.0', true );

wp_enqueue_script( 'jquery-scroll-to', get_template_directory_uri() . '/js/plugins/jquery.scrollTo.min.js', array( 'jquery', 'olympus-mega-menu' ), '2.1.2', true );

wp_enqueue_script( 'olympus-main', get_template_directory_uri() . '/js/theme-main.js', array( 'reframe', 'smooth-scroll', 'material-forms', 'scroll-to-fixed', 'bootstrap-select', 'ico-moon', 'jquery-match-height', 'olympus-mega-menu', 'jquery-mousewheel', 'password-strength-meter' ), $theme_version, true );
wp_localize_script( 'olympus-main', 'themeOptions', array(
    'ajaxUrl' => admin_url( 'admin-ajax.php' )
) );

/* ======================
 *  Plugins customization
  ==================== */

if ( ! class_exists( 'Youzer' ) && function_exists( 'is_bbpress' ) ) {
	if ( is_bbpress() || is_singular() || is_search() ) {
		wp_enqueue_style( 'ol-bbpress', get_theme_file_uri( 'css/bbp-customization.css' ), array( 'bbp-default' ), $theme_version );
	}
}