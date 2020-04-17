<?php

add_action( 'wp_enqueue_scripts', function () {
	$css	 = '';
	$olympus = Olympus_Options::get_instance();

	// Root colors
	$primary_accent_color	 = get_option( 'primary-accent-color', '#ff5e3a' );
	$primary_color_darken	 = olympus_luminance( $primary_accent_color, -0.1 );

	$secondary_accent_color	 = get_option( 'secondary-accent-color', '#38a9ff' );
	$secondary_color_darken	 = olympus_luminance( $secondary_accent_color, -0.1 );

	if ( $primary_accent_color ) {
		$css .= "html:root {--primary-accent-color: {$primary_accent_color};}";
	}
	if ( $primary_color_darken ) {
		$css .= "html:root {--primary-color-darken: {$primary_color_darken};}";
	}
	if ( $secondary_accent_color ) {
		$css .= "html:root {--secondary-accent-color: {$secondary_accent_color};}";
	}
	if ( $secondary_color_darken ) {
		$css .= "html:root {--secondary-color-darken: {$secondary_color_darken};}";
	}

	// Logo size
	$logo_max_height = get_option( 'custom-logo-height', '' );
	if ( $logo_max_height ) {
		$css .= ".header--standard .logo .img-wrap img {max-height:{$logo_max_height}px;}";
	}

	// Header social styles
	$header_social_bg_color			 = $olympus->get_option( 'header_social_bg_color', '#3f4257', $olympus::SOURCE_CUSTOMIZER );
	$header_social_form_bg_color	 = $olympus->get_option( 'header_social_form_bg_color', '#494c62', $olympus::SOURCE_CUSTOMIZER );
	$header_social_form_text_color	 = $olympus->get_option( 'header_social_form_text_color', '#9a9fbf', $olympus::SOURCE_CUSTOMIZER );
	$header_social_title_color		 = $olympus->get_option( 'header_social_title_color', '#ffffff', $olympus::SOURCE_CUSTOMIZER );

	if ( $header_social_bg_color ) {
		$css .= "#site-header {background-color:{$header_social_bg_color};}";
	}

	if ( $header_social_form_bg_color ) {
		$css .= "#site-header .search-bar .form-group.with-button button {background-color:{$header_social_form_bg_color};}";
		$css .= "#site-header .search-bar.w-search {background-color:{$header_social_form_bg_color};}";
	}

	if ( $header_social_title_color ) {
		$css .= "#site-header .page-title > * {color:{$header_social_title_color};}";
		$css .= "#site-header .control-icon {fill:{$header_social_title_color};}";
		$css .= "#site-header .control-block .author-title {color:{$header_social_title_color};}";
	}

	if ( $header_social_form_text_color ) {
		$css .= "#site-header .search-bar .form-group.with-button input {color:{$header_social_form_text_color};}";
		$css .= "#site-header .search-bar .form-group.with-button input::placeholder {color:{$header_social_form_text_color};}";
		$css .= "#site-header .search-bar .form-group.with-button button {fill:{$header_social_form_text_color};}";
		$css .= "#site-header .control-block .author-subtitle {color:{$header_social_form_text_color};}";
	}

	// Header general styles
	$header_general_bg_color	 = $olympus->get_option( 'header_general_bg_color', '#ffffff', $olympus::SOURCE_CUSTOMIZER );
	$header_general_logo_color	 = $olympus->get_option( 'header_general_logo_color', '#3f4257', $olympus::SOURCE_CUSTOMIZER );
	$header_general_cart_color	 = $olympus->get_option( 'header_general_cart_color', '#9a9fbf', $olympus::SOURCE_CUSTOMIZER );

	if ( $header_general_bg_color ) {
		$css .= "#header--standard {background-color:{$header_general_bg_color};}";
		$css .= "#header--standard .primary-menu {background-color:{$header_general_bg_color};}";
	}

	if ( $header_general_logo_color ) {
		$css .= "#header--standard .logo {color:{$header_general_logo_color};}";
	}

	if ( $header_general_cart_color ) {
		$css .= "#header--standard .shoping-cart .count-product {color:{$header_general_logo_color};}";
		$css .= "#header--standard li.cart-menulocation a {fill:{$header_general_logo_color};}";
		$css .= "#header--standard .primary-menu-menu > li > a > .indicator {color:{$header_general_logo_color};}";
	}

	// Footer styles
	$footer_text_color	 = $olympus->get_option( 'footer_text_color', '', $olympus::SOURCE_CUSTOMIZER );
	$footer_title_color	 = $olympus->get_option( 'footer_title_color', '', $olympus::SOURCE_CUSTOMIZER );
	$footer_link_color	 = $olympus->get_option( 'footer_link_color', '', $olympus::SOURCE_CUSTOMIZER );
	$footer_bg_image	 = olympus_akg( 'data/css/background-image', $olympus->get_option( 'footer_bg_image', '', $olympus::SOURCE_CUSTOMIZER ), '' );
	$footer_bg_cover	 = $olympus->get_option( 'footer_bg_cover', '', $olympus::SOURCE_CUSTOMIZER );
	$footer_bg_color	 = $olympus->get_option( 'footer_bg_color', '', $olympus::SOURCE_CUSTOMIZER );

	if ( $footer_text_color ) {
		$css .= "#footer {color:{$footer_text_color};}";
	}
	if ( $footer_bg_color ) {
		$css .= "#footer {background-color:{$footer_bg_color};}";
	}
	if ( $footer_bg_image ) {
		$css .= "#footer {background-image: {$footer_bg_image};}";

		if ( $footer_bg_cover ) {
			$css .= "#footer {background-size: cover;}";
		}
	}
	if ( $footer_title_color ) {
		$css .= "#footer .socials .soc-item {color:{$footer_title_color};}";
		$css .= "#footer .socials .soc-item:hover {color:{$footer_title_color}; opacity: 0.8;}";
		$css .= "#footer .logo-title {color:{$footer_title_color};}";
		$css .= "#footer .sub-title {color:{$footer_title_color};}";
		$css .= "#footer .title {color:{$footer_title_color};}";

		$css .= "#footer h1 {color:{$footer_title_color};}";
		$css .= "#footer h2 {color:{$footer_title_color};}";
		$css .= "#footer h3 {color:{$footer_title_color};}";
		$css .= "#footer h4 {color:{$footer_title_color};}";
		$css .= "#footer h5 {color:{$footer_title_color};}";
		$css .= "#footer h6 {color:{$footer_title_color};}";
	}
	if ( $footer_link_color ) {
		$css .= "#footer a {color:{$footer_link_color};}";
		$css .= "#footer a:hover {color:{$footer_link_color}; opacity: 0.8;}";
	}

	//Back to top btn
	$totop_bg_color		 = $olympus->get_option( 'totop_bg_color', array(), $olympus::SOURCE_CUSTOMIZER );
	$totop_icon_color	 = $olympus->get_option( 'totop_icon_color', array(), $olympus::SOURCE_CUSTOMIZER );
	if ( $totop_bg_color ) {
		$css .= "#back-to-top {background-color:{$totop_bg_color};}";
	}
	if ( $totop_icon_color ) {
		$css .= "#back-to-top {fill:{$totop_icon_color};}";
	}

	// Font styles
	$css .= olympus_generate_font_styles( 'h1' );
	$css .= olympus_generate_font_styles( 'h2' );
	$css .= olympus_generate_font_styles( 'h3' );
	$css .= olympus_generate_font_styles( 'h4' );
	$css .= olympus_generate_font_styles( 'h5' );
	$css .= olympus_generate_font_styles( 'h6' );
	$css .= olympus_generate_font_styles( 'body' );
	$css .= olympus_generate_font_styles( 'nav' );

	// Customize general design
	$general_body_bg_color = olympus_general_body_bg_color();

	if ( !empty( $general_body_bg_color ) ) {
		$css .= "body.olympus-theme.bg-custom-color {background-color: " . $general_body_bg_color . ";}";
	}

	$general_body_bg_image = olympus_general_body_bg_image();

	if ( !empty( $general_body_bg_image[ 'background-image' ] ) ) {
		$css .= "body.olympus-theme.bg-custom-image {background-image: url(" . $general_body_bg_image[ 'background-image' ] . ");}";
	}

	if ( !empty( $general_body_bg_image[ 'background-position' ] ) ) {
		$css .= "body.olympus-theme.bg-custom-image {background-position: " . $general_body_bg_image[ 'background-position' ] . ";}";
	}

	if ( !empty( $general_body_bg_image[ 'background-size' ] ) ) {
		$css .= "body.olympus-theme.bg-custom-image {background-size: " . $general_body_bg_image[ 'background-size' ] . ";}";
	}

	if ( !empty( $general_body_bg_image[ 'background-repeat' ] ) ) {
		$css .= "body.olympus-theme.bg-custom-image {background-repeat: " . $general_body_bg_image[ 'background-repeat' ] . ";}";
	}

	if ( !empty( $general_body_bg_image[ 'background-attachment' ] ) ) {
		$css .= "body.olympus-theme.bg-custom-image {background-attachment: " . $general_body_bg_image[ 'background-attachment' ] . ";}";
	}

	// Grid bg
	$post_thumb_bg_color = get_option( 'post-thumb-bg-color', '#ffffff' );

	if ( $post_thumb_bg_color ) {
		$css .= ".may-contain-custom-bg .ui-block {background-color: {$post_thumb_bg_color}}";
	}

	//Side panel bg
	$side_panel_bg_color = get_option( 'side-panel-bg-color', '#ffffff' );
	if ( $side_panel_bg_color ) {
		$css .= ".fixed-sidebar-left {background-color: {$side_panel_bg_color}}";
	}

	wp_add_inline_style( 'olympus-main', $css );
}, 9999 );
