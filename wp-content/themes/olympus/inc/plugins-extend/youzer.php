<?php
//Register Public Scripts .
add_action( 'wp_enqueue_scripts', '_action_olympus_yz_scripts', 999 );

function _action_olympus_yz_scripts() {

	global $Youzer, $post;

	if ( ! $Youzer ) {
		return;
	}

	$theme_version   = olympus_get_theme_version();
	$enqueued_styles = olympus_enqueued_styles_handle();

	/* ---------------------------------- */

	wp_enqueue_style( 'olympus-youzer', get_theme_file_uri( 'css/youzer/youzer.css' ), 'youzer', $theme_version );

	wp_enqueue_style( 'youzer-customization', get_template_directory_uri() . '/css/youzer-customization.css', false, $theme_version );

	if ( in_array( 'yz-profile', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-profile', get_theme_file_uri( 'css/youzer/yz-profile-style.css' ), 'yz-profile', $theme_version );
	}

	if ( in_array( 'yz-bp-uploader', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-bp-uploader', get_theme_file_uri( 'css/youzer/yz-bp-uploader.css' ), 'yz-bp-uploader', $theme_version );
	}

	if ( in_array( 'yz-iconpicker', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-iconpicker', get_theme_file_uri( 'css/youzer/yz-iconpicker.css' ), 'yz-iconpicker', $theme_version );
	}

	if ( in_array( 'yz-headers', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-headers', get_theme_file_uri( 'css/youzer/yz-headers.css' ), 'yz-headers', $theme_version );
	}

	if ( in_array( 'yz-woocommerce', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-woocommerce', get_theme_file_uri( 'css/youzer/yz-woocommerce.css' ), 'yz-woocommerce', $theme_version );
	}

	if ( in_array( 'yz-social', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-social', get_theme_file_uri( 'css/youzer/yz-social.css' ), 'yz-social', $theme_version );
	}

	if ( in_array( 'yz-wall', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-wall', get_theme_file_uri( 'css/youzer/yz-wall.css' ), 'yz-wall', $theme_version );
	}

	if ( in_array( 'yz-reviews', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-reviews', get_theme_file_uri( 'css/youzer/yz-reviews.css' ), 'yz-reviews', $theme_version );
	}

	if ( in_array( 'yz-mycred', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-mycred', get_theme_file_uri( 'css/youzer/yz-mycred.css' ), 'yz-mycred', $theme_version );
	}

	if ( in_array( 'yz-mycred', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-mycred', get_theme_file_uri( 'css/youzer/yz-mycred.css' ), 'yz-mycred', $theme_version );
	}

	if ( in_array( 'yz-bbpress', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-bbpress', get_theme_file_uri( 'css/youzer/yz-bbpress.css' ), 'yz-bbpress', $theme_version );
	}

	if ( in_array( 'yz-groups', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-groups', get_theme_file_uri( 'css/youzer/yz-groups.css' ), 'yz-groups', $theme_version );
	}

	if ( in_array( 'yz-directories', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-directories', get_theme_file_uri( 'css/youzer/yz-directories.css' ), 'yz-directories', $theme_version );
	}

	if ( in_array( 'yz-account', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-yz-account', get_theme_file_uri( 'css/youzer/yz-account-style.css' ), 'yz-account-css', $theme_version );
	}

	if ( in_array( 'logy-style', $enqueued_styles ) ) {
		wp_enqueue_style( 'olympus-logy-style', get_theme_file_uri( 'css/youzer/logy.css' ), 'logy-style', $theme_version );
	}

	/* Disable unused font from Youzer */
	wp_dequeue_style( 'yz-opensans' );
	wp_dequeue_style( 'yz-roboto' );
	wp_dequeue_style( 'yz-lato' );

	if ( has_shortcode( $post->post_content, 'youzer_members' ) ) {
		wp_enqueue_style( 'olympus-yz-directories', get_theme_file_uri( 'css/youzer/yz-directories.css' ), 'yz-directories', $theme_version );
	}
}

add_filter( 'yz_profile_navbar_menu_icon', '_action_olympus_yz_profile_icons', 10, 2 );
add_filter( 'yz_profile_tab_submenu_icons', '_action_olympus_yz_profile_icons', 10, 2 );

function _action_olympus_yz_profile_icons( $icon_html, $item ) {
	$icon = '';

	switch ( $icon_html ) {
		case '<i class="fas fa-globe"></i>':
			$icon = 'olymp-albums-icon';
			break;
		case '<i class="fas fa-address-card"></i>':
			$icon = 'olymp-newsfeed-icon';
			break;
		case '<i class="fas fa-info"></i>':
			$icon = 'olymp-status-icon';
			break;
		case '<i class="fas fa-handshake"></i>':
			$icon = 'olymp-happy-faces-icon';
			break;
		case '<i class="fas fa-users"></i>':
			$icon = 'olymp-groups-icon';
			break;
		case '<i class="fas fa-pencil-alt"></i>':
			$icon = 'olymp-blog-icon';
			break;
		case '<i class="far fa-comments"></i>':
			$icon = 'olymp-forum-icon';
			break;
		case '<i class="fas fa-globe-asia"></i>':
			$icon = 'olymp-albums-icon';
			break;
		case '<i class="fas fa-bookmark"></i>':
			$icon = 'olymp-manage-widgets-icon';
			break;
		case '<i class="fas fa-star"></i>':
			$icon = 'olymp-star-icon';
			break;
		case '<i class="fas fa-user-circle"></i>':
			$icon = 'olymp-thunder-icon';
			break;
		case '<i class="fas fa-at"></i>':
			$icon = 'olymp-add-to-conversation-icon';
			break;
		case '<i class="fas fa-heart"></i>':
			$icon = 'olymp-heart-icon';
			break;
		case '<i class="fas fa-eye-slash"></i>':
			$icon = 'olymp-unread-icon';
			break;
		case '<i class="fas fa-eye"></i>':
			$icon = 'olymp-read-icon';
			break;
		case '<i class="fas fa-trophy"></i>':
			$icon = 'olymp-trophy-icon';
			break;
		case '<i class="fas fa-paper-plane"></i>':
			$icon = 'olymp-friendships';
			break;
		case '<i class="fas fa-file-alt"></i>':
			$icon = 'olymp-friendships';
			break;
		case '<i class="fas fa-thumbs-up"></i>':
			$icon = 'olymp-heart-icon';
			break;
		case '<i class="fas fa-bell"></i>':
			$icon = 'olymp-add-to-conversation-icon';
			break;
		case '<i class="fas fa-edit"></i>':
			$icon = 'olymp-edit-icon';
			break;
		case '<i class="fas fa-bullhorn"></i>':
			$icon = 'olymp-pin-icon';
			break;
		case '<i class="fas fa-inbox"></i>':
			$icon = 'olymp-project-icon';
			break;
		case '<i class="fas fa-shopping-cart"></i>':
			$icon = 'olymp-shopping-bag-icon';
			break;
		case '<i class="far fa-credit-card"></i>':
			$icon = 'olymp-checkout-icon';
			break;
		case '<i class="fas fa-truck-moving"></i>':
			$icon = 'olymp-track-icon';
			break;
		case '<i class="fas fa-shopping-basket"></i>':
			$icon = 'olymp-orders-icon';
			break;
		case '<i class="fas fa-download"></i>':
			$icon = 'olymp-downloads-icon';
			break;
		case '<i class="fas fa-credit-card"></i>':
			$icon = 'olymp-payment-methods-icon';
			break;
		case '<i class="far fa-user-circle"></i>':
			$icon = 'olymp-account-icon';
			break;
		case '<i class="fas fa-rss"></i>':
			$icon = 'olymp-star-icon';
			break;
		case '<i class="fas fa-share"></i>':
			$icon = 'olymp-star-icon';
			break;
		case '<i class="fas fa-reply"></i>':
			$icon = 'olymp-read-icon';
			break;
		case '<i class="fas fa-photo-video"></i>':
			$icon = 'olymp-albums-icon';
			break;
		case '<i class="fas fa-envelope-open-text"></i>':
			$icon = 'olymp-chat-messages-icon';
			break;
		case '<i class="fas fa-image"></i>':
			$icon = 'olymp-photos-icon';
			break;
		case '<i class="fas fa-film"></i>':
			$icon = 'olymp-video-icon';
			break;
		case '<i class="fas fa-volume-up"></i>':
			$icon = 'olymp-headphones-icon';
			break;
		case '<i class="fas fa-file-import"></i>':
			$icon = 'olymp-downloads-icon';
			break;
		case '<i class="fas fa-history"></i>':
			$icon = 'olymp-clock-icon';
			break;

		default:
			return $icon_html;
			break;
	}

	ob_start();
	?>
	<svg class="olymp-menu-icon">
		<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#<?php echo esc_attr( $icon ); ?>"></use>
	</svg>
	<?php
	return ob_get_clean();
}

add_filter( 'youzer_edit_options', '_filter_olympus_yz_edit_options', 10, 2 );

function _filter_olympus_yz_edit_options( $option_value, $option_id ) {

	switch ( $option_id ) {
		case 'yz_enable_settings_copyright':
			$option_value = 'off';
			break;
		case 'yz_display_scrolltotop':
			$option_value = 'off';
			break;
	}

	return $option_value;
}