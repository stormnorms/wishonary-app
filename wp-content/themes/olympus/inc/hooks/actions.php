<?php
/**
 * Olympus theme actions
 *
 * @package olympus-wp
 */

/**
 * Theme setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function olympus_action_setup() {

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
	add_editor_style( array( olympus_font_url(), get_theme_file_uri( 'css/style-editor.css' ) ) );


	// Nav menus

	register_nav_menus( array(
		'primary'	 => esc_html__( 'Top primary menu', 'olympus' ),
		'fixed-left' => esc_html__( 'Fixed left menu', 'olympus' ),
		'user'		 => esc_html__( 'Top user menu', 'olympus' ),
	) );

	// Make Theme available for translation.
	load_theme_textdomain( 'olympus', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', olympus_font_url() ) );

	// Add theme support.
	add_theme_support( 'title-tag' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'editor-styles' );

	//set_post_thumbnail_size( 784, 420, true );
	add_image_size( 'crumina-full-width', 1038, 576, true );
	add_image_size( 'crumina-info-box', 110, 110, true );
	add_image_size( 'crumina-rtmedia-thumb', 370, 300, true );

	add_theme_support( 'custom-background' );
	add_theme_support( 'post-formats', array(
		'image',
		'video',
		'audio',
		'quote',
		'link',
		'gallery',
	) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comments__list',
		'gallery',
		'caption',
	) );
	add_theme_support( 'custom-logo', array(
		'flex-width' => true,
		'height'	 => 200,
	) );

	// Remove REST links from header.
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );

	// Loading translations
	load_theme_textdomain( 'olympus', get_template_directory() . '/languages/theme' );
	load_theme_textdomain( 'crum-ext-sign-form', get_template_directory() . '/languages/ext/sign-form' );
	load_theme_textdomain( 'crum-ext-ajax-blog', get_template_directory() . '/languages/ext/ajax-blog' );
	load_theme_textdomain( 'crum-ext-stunning-header', get_template_directory() . '/languages/ext/stunning-header' );
	load_theme_textdomain( 'crum-ext-post-share', get_template_directory() . '/languages/ext/post-share' );
	load_theme_textdomain( 'crum-ext-post-reaction', get_template_directory() . '/languages/ext/post-reaction' );
}

add_action( 'after_setup_theme', 'olympus_action_setup' );

/**
 * Add tags to allowedtags filter
 */
function olympus_action_extend_allowed_tags() {
	global $allowedtags;

	$allowedtags[ 'i' ]		 = array(
		'class' => array(),
	);
	$allowedtags[ 'br' ]	 = array(
		'class' => array(),
	);
	$allowedtags[ 'img' ]	 = array(
		'src'	 => array(),
		'alt'	 => array(),
		'width'	 => array(),
		'height' => array(),
		'class'	 => array(),
	);
	$allowedtags[ 'span' ]	 = array(
		'class'	 => array(),
		'style'	 => array(),
	);
	$allowedtags[ 'a' ]		 = array(
		'class'	 => array(),
		'href'	 => array(),
		'target' => array(),
	);
}

add_action( 'init', 'olympus_action_extend_allowed_tags' );

/**
 * Allow to upload SVG files to Wordpress Media Library.
 * @param array $mimes
 *
 * @return array
 */
function olympus_custom_upload_mimes( $mimes = array() ) {

	$mimes[ 'svg' ] = 'image/svg+xml';
	return $mimes;
}

add_action( 'upload_mimes', 'olympus_custom_upload_mimes' );

/**
 * Exclude kc Section Post type from search query
 */
function olympus_action_exclude_kc_section_search() {
	global $wp_post_types;
	if ( post_type_exists( 'kc-section' ) ) {
		$wp_post_types[ 'kc-section' ]->exclude_from_search = true;
	}
}

add_action( 'init', 'olympus_action_exclude_kc_section_search', 99 );

/**
 * Set custom user status
 */
function olympus_custom_user_status() {
	$user_ID = get_current_user_id();
	$status	 = filter_input( INPUT_POST, 'custom-user-status' );
	$nonce	 = filter_input( INPUT_POST, 'custom-user-status-nonce' );

	if ( !$status || !wp_verify_nonce( $nonce, 'custom-user-status' ) || !$user_ID ) {
		return;
	}

	update_user_meta( $user_ID, 'olympus-custom-user-status', $status );
}

add_action( 'init', 'olympus_custom_user_status' );

/**
 * Register widget areas.
 */
function _action_olympus_widgets_init() {

	register_sidebar( array(
		'name'			 => esc_html__( 'Main Widget Area', 'olympus' ),
		'id'			 => 'sidebar-main',
		'description'	 => esc_html__( 'Appears in the right section of the site.', 'olympus' ),
		'before_widget'	 => '<div id="%1$s" class="widget ui-block %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="ui-block-title"><h6 class="title">',
		'after_title'	 => '</h6></div>',
	) );
	register_sidebar( array(
		'name'			 => esc_html__( 'Footer Widget Area', 'olympus' ),
		'id'			 => 'sidebar-footer',
		'description'	 => esc_html__( 'Appears in footer section. Every widget in own column ', 'olympus' ),
		'before_widget'	 => '<div class="columns_class_replace"><div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div></div>',
		'before_title'	 => '<h6 class="title">',
		'after_title'	 => '</h6>',
	) );

	$widget_list = array(
		'twitter',
		'instagram',
		'flickr',
		'banner',
		'latest-posts',
		'about-user',
		'about-company',
		'location'
	);

	foreach ( $widget_list as $widget_name ) {
		Olympus_Core::include_parent( "/inc/widgets/$widget_name/class-widget-$widget_name.php" );
		$widget_class = 'Olympus_Widget_' . Olympus_Core::dirname_to_classname( $widget_name );
		if ( class_exists( $widget_class ) ) {
			$regWdgt = 'register_' . 'widget';
			$regWdgt( $widget_class );
		}
	}
}

add_action( 'widgets_init', '_action_olympus_widgets_init' );

/**
 * Admin scripts and styles
 */
function olympus_action_admin_enqueue_scripts() {
	Olympus_Core::include_child_first( '/inc/static/admin.php' );
}

/**
 * Frontend scripts and styles
 */
function olympus_action_wp_enqueue_scripts() {
	Olympus_Core::include_parent( '/inc/static/frontend.php' );
	Olympus_Core::include_child_first( '/inc/static/inline-scripts.php' );
}

function olympus_action_wp_dequeue_scripts() {
	wp_dequeue_style( 'kc-general' );
}

if ( is_admin() ) {
	add_action( 'admin_enqueue_scripts', 'olympus_action_admin_enqueue_scripts' );
} else {
	add_action( 'wp_enqueue_scripts', 'olympus_action_wp_enqueue_scripts' );
	add_action( 'wp_enqueue_scripts', 'olympus_action_wp_dequeue_scripts', 10000 );
}

add_action( 'customize_controls_enqueue_scripts', '_action_olympus_customize_controls_enqueue_scripts' );

function _action_olympus_customize_controls_enqueue_scripts() {
	$theme_version = olympus_get_theme_version();

	wp_enqueue_style( 'olympus-customizer', get_template_directory_uri() . '/css/theme-customizer.css', array(), $theme_version );
}

/**
 * Adjust content width
 */
function olympus_action_adjust_content_width() {
	global $content_width;

	if ( function_exists( 'bp_current_component' ) && bp_current_component() ) {
		$content_width = 660;
	} else if ( is_home() || is_archive() ) {
		$content_width = 785;
	} elseif ( is_page() ) {
		$content_width = 1170;
	} elseif ( is_attachment() && wp_attachment_is_image() ) {
		$content_width = 810;
	} elseif ( empty( $content_width ) ) {
		$content_width = 750;
	}
}

add_action( 'template_redirect', 'olympus_action_adjust_content_width' );

/**
 * Ajax search
 */
add_action( 'wp_ajax_olympus_ajax_search', 'olympus_ajax_search' );
add_action( 'wp_ajax_nopriv_olympus_ajax_search', 'olympus_ajax_search' );

function olympus_ajax_search() {
	//if "s" input is missing exit
	if ( empty( $_REQUEST[ 's' ] ) && empty( $_REQUEST[ 'bbp_search' ] ) )
		die();

	if ( !empty( $_REQUEST[ 'bbp_search' ] ) ) {
		$search_string = esc_html( $_REQUEST[ 'bbp_search' ] );
	} else {
		$search_string = esc_html( $_REQUEST[ 's' ] );
	}

	$output		 = "";
	$context	 = "any";
	$defaults	 = array(
		'numberposts'		 => 4,
		'posts_per_page'	 => 20,
		'post_type'			 => 'any',
		'post_status'		 => 'publish',
		'post_password'		 => '',
		'suppress_filters'	 => true,
		's'					 => $_REQUEST[ 's' ]
	);

	if ( isset( $_REQUEST[ 'context' ] ) && $_REQUEST[ 'context' ] != '' ) {
		$context				 = explode( ",", $_REQUEST[ 'context' ] );
		$defaults[ 'post_type' ] = $context;
	}

	$defaults = apply_filters( 'olympus_ajax_query_args', $defaults );

	$the_query	 = new WP_Query( $defaults );
	$posts		 = $the_query->get_posts();

	$members			 = array();
	$members[ 'total' ]	 = 0;
	$groups				 = array();
	$groups[ 'total' ]	 = 0;
	$forums				 = FALSE;


	if ( function_exists( 'bp_is_active' ) && ($context == "any" || in_array( "members", $context )) ) {
		$members = bp_core_get_users( array( 'search_terms' => $search_string, 'per_page' => $defaults[ 'numberposts' ], 'populate_extras' => false ) );
	}

	if ( function_exists( 'bp_is_active' ) && bp_is_active( "groups" ) && ($context == "any" || in_array( "groups", $context )) ) {
		$groups = groups_get_groups( array( 'search_terms' => $search_string, 'per_page' => $defaults[ 'numberposts' ], 'populate_extras' => false ) );
	}

	if ( class_exists( 'bbPress' ) && ($context == "any" || in_array( "forum", $context )) ) {
		$forums = olympus_bbp_get_replies( $search_string );
	}

	//if there are no posts, groups nor members
	if ( empty( $posts ) && $members[ 'total' ] == 0 && $groups[ 'total' ] == 0 && !$forums ) {
		?>
		<div class="inline-items">
			<div class="author-thumb">
				<img src="<?php echo get_theme_file_uri( '/images/post-no-image-thumb.png' ); ?>" width="40" height="40" alt="<?php esc_attr_e( 'No image', 'olympus' ); ?>">
			</div>

			<div class="notification-event-wrap">
				<div class="notification-event">
					<span class="h6 notification-friend">
						<?php echo esc_html__( "Sorry, we haven't found anything based on your criteria.", 'olympus' ); ?>
					</span>
					<span class="chat-message-item"><?php echo esc_html__( "Please try searching by different terms.", 'olympus' ); ?></span>
				</div>
			</div>
		</div>
		<?php
		die();
	}

	//if there are members
	if ( $members[ 'total' ] != 0 ) {
		?>
		<div class="ui-block-title ui-block-title-small">
			<h6 class="title"><?php echo esc_html__( "Members", 'olympus' ); ?></h6>
		</div>
		<?php
		foreach ( (array) $members[ 'users' ] as $member ) {
			$image_args	 = array(
				'item_id'	 => $member->ID,
				'width'		 => 80,
				'height'	 => 80
			);
			$image		 = olympus_get_avatar( $image_args );
			if ( $update		 = bp_get_user_meta( $member->ID, 'bp_latest_update', true ) ) {
				$latest_activity = olympus_char_trim( trim( strip_tags( bp_create_excerpt( $update[ 'content' ], 50, "..." ) ) ) );
			} else {
				$latest_activity = '';
			}
			?>
			<a href="<?php echo esc_url( bp_core_get_user_domain( $member->ID ) ); ?>" class="inline-items">
				<div class="author-thumb">
					<?php olympus_render( $image ); ?>
				</div>

				<div class="notification-event">
					<span class="h6 notification-friend">
						<?php echo esc_html( $member->display_name ); ?>
					</span>
					<?php if ( $latest_activity ) { ?>
						<span class="chat-message-item"><?php olympus_render( $latest_activity ); ?></span>
					<?php } ?>
				</div>
			</a>
		<?php } ?>
		<a href="<?php echo esc_url( bp_get_members_directory_permalink() ) . "?s=" . $search_string; ?>" class="btn btn-primary btn-sm"><?php echo esc_html__( 'View all members', 'olympus' ); ?></a>
		<?php
	}

	//if there are groups
	if ( $groups[ 'total' ] != 0 ) {
		?>
		<div class="ui-block-title ui-block-title-small">
			<h6 class="title"><?php echo esc_html__( "Groups", 'olympus' ); ?></h6>
		</div>
		<?php
		foreach ( (array) $groups[ 'groups' ] as $group ) {
			$image = '<img src="' . bp_core_fetch_avatar( array( 'item_id' => $group->id, 'object' => 'group', 'width' => 80, 'height' => 80, 'html' => false ) ) . '" class="olympus-rounded" alt="' . esc_attr( $group->name ) . '">';
			?>
			<a href="<?php echo esc_url( bp_get_group_permalink( $group ) ); ?>" class="inline-items">
				<div class="author-thumb">
					<?php olympus_render( $image ); ?>
				</div>

				<div class="notification-event">
					<span class="h6 notification-friend">
						<?php olympus_render( $group->name ); ?>
					</span>
				</div>
			</a>
		<?php } ?>
		<a href="<?php echo esc_url( bp_get_groups_directory_permalink() ) . "?s=" . $search_string; ?>" class="btn btn-primary btn-sm"><?php echo esc_html__( 'View group results', 'olympus' ); ?></a>
		<?php
	}

	//if there are posts
	if ( !empty( $posts ) ) {
		$post_type_str	 = array();
		$post_types		 = array();
		$post_type_obj	 = array();
		foreach ( $posts as $post ) {
			$post_types[ $post->post_type ][] = $post;
			if ( empty( $post_type_obj[ $post->post_type ] ) ) {
				$post_type_obj[ $post->post_type ] = get_post_type_object( $post->post_type );
			}
		}

		foreach ( $post_types as $ptype => $post_type ) {
			if ( isset( $post_type_obj[ $ptype ]->labels->name ) ) {
				?>
				<div class="ui-block-title ui-block-title-small">
					<h6 class="title"><?php echo esc_html( $post_type_obj[ $ptype ]->labels->name ); ?></h6>
				</div>
				<?php
			} else {
				?>
				<hr />
				<?php
			}
			$count = 0;
			foreach ( $post_type as $post ) {

				$post_type_str[ $post->post_type ] = $post->post_type;
				$count++;
				if ( $count > 4 ) {
					continue;
				}
				$format	 = get_post_format( $post->ID );
				if ( $img_id	 = get_post_thumbnail_id( $post->ID ) ) {
					$image = olympus_resize( $img_id, 80, 80, true );
					if ( !$image ) {
						$image = wp_get_attachment_image_src( $img_id );
					}
					$image = '<img src="' . $image . '" class="olympus-rounded" alt="' . esc_attr( $group->name ) . '">';
				} else {
					$image = '<img src="' . get_theme_file_uri( '/images/post-no-image-thumb.png' ) . '" width="40" height="40" alt="' . esc_attr__( 'No image', 'olympus' ) . '">';
				}

				$excerpt = "";

				if ( !empty( $post->post_content ) ) {
					$excerpt = $post->post_content;
					$excerpt = preg_replace( "/\[(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?/s", '', $excerpt );
					$excerpt = olympus_char_trim( trim( strip_tags( $excerpt ) ), 40, "..." );
				}

				$link	 = apply_filters( 'olympus_custom_url', get_permalink( $post->ID ) );
				$classes = "format-" . $format;
				?>

				<a href="<?php echo esc_url( $link ); ?>" class="inline-items <?php echo esc_attr( $classes ); ?>">
					<div class="author-thumb">
						<?php olympus_render( $image ); ?>
					</div>

					<div class="notification-event">
						<span class="h6 notification-friend">
							<?php echo get_the_title( $post->ID ); ?>
						</span>
						<span class="chat-message-item"><?php olympus_render( $excerpt ); ?></span>
					</div>
				</a>

				<?php
			}

			$search_str_posts = '';
			if ( !empty( $post_type_str ) ) {
				foreach ( $post_type_str as $ptype_str ) {
					$search_str_posts .= '&post_type[]=' . $ptype_str;
				}
			}
		}
		?>
		<a href="<?php echo esc_url( home_url( '/' ) . '?s=' . $search_string ) . $search_str_posts; ?>" class="btn btn-primary btn-sm"><?php echo esc_html__( 'Other results', 'olympus' ); ?></a>
		<?php
	}

	/* Forums topics search */
	if ( !empty( $forums ) ) {
		?>
		<div class="ui-block-title ui-block-title-small">
			<h6 class="title"><?php echo esc_html__( "Forums", 'olympus' ); ?></h6>
		</div>
		<?php
		$i = 0;
		foreach ( $forums as $fk => $forum ) {

			$i++;
			if ( $i <= 4 ) {
				?>
				<a href="<?php echo esc_url( $forum[ 'url' ] ); ?>" class="inline-items">
					<div class="author-thumb">
						<img src="<?php echo get_theme_file_uri( '/images/post-no-image-thumb.png' ); ?>" width="40" height="40" alt="<?php esc_attr_e( 'No image', 'olympus' ); ?>">
					</div>

					<div class="notification-event">
						<span class="h6 notification-friend">
							<?php olympus_render( $forum[ 'name' ] ); ?>
						</span>
					</div>
				</a>
				<?php
			}
		}
		?>
		<a href="<?php echo bbp_get_search_url() . "?bbp_search=" . $search_string; ?>" class="btn btn-primary btn-sm"><?php echo esc_html__( 'View forum results', 'olympus' ); ?></a>
		<?php
	}

	olympus_render( $output );
	die();
}

/**
 * Additional profile fields
 */
function olympus_additional_profile_fields() {
	return array(
		'box' => array(
			'title'		 => false,
			'type'		 => 'group',
			'attr'		 => array( 'class' => 'unyson-user-profile-option' ),
			'options'	 => array(
				'profile-thumb' => array(
					'type'			 => 'upload',
					'images_only'	 => true,
					'label'			 => esc_html__( 'Profile thumbnail', 'olympus' ),
				),
			),
		),
	);
}

function olympus_action_additional_profile_fields( $user ) {
	$data = (array) get_the_author_meta( 'additional-profile-fields', $user->ID );

	echo fw()->backend->render_options( olympus_additional_profile_fields(), $data );
}

function olympus_action_save_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	return update_user_meta( $user_id, 'additional-profile-fields', fw_get_options_values_from_input( olympus_additional_profile_fields() ) );
}

if ( defined( 'ABSPATH' ) ) {
	add_action( 'show_user_profile', 'olympus_action_additional_profile_fields' );
	add_action( 'edit_user_profile', 'olympus_action_additional_profile_fields' );
	add_action( 'personal_options_update', 'olympus_action_save_profile_fields' );
	add_action( 'edit_user_profile_update', 'olympus_action_save_profile_fields' );
}

/**
 * Flush out the transients used in fw_theme_categorized_blog.
 * @internal
 */
function olympus_action_theme_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'olympus_theme_category_count' );
}

add_action( 'edit_category', 'olympus_action_theme_category_transient_flusher' );
add_action( 'save_post', 'olympus_action_theme_category_transient_flusher' );

add_action( 'crumina_body_start', '_action_olympus_tracking_scripts' );
add_action( 'crumina_body_start_landing', '_action_olympus_tracking_scripts' );

function _action_olympus_tracking_scripts() {
	$olympus			 = Olympus_Options::get_instance();
	?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'olympus' ); ?></a>
	<?php
	$tracking_scripts	 = $olympus->get_option( 'tracking_scripts', array(), $olympus::SOURCE_SETTINGS );

	if ( is_array( $tracking_scripts ) ) {
		foreach ( $tracking_scripts as $item ) {
			if ( isset( $item[ 'script' ] ) ) {
				olympus_render( $item[ 'script' ] );
			}
		}
	}
}

add_action( 'crumina_body_start', '_action_olympus_add_left_panel' );

function _action_olympus_add_left_panel() {

	if ( olympus_is_left_panel_visible() ) {
		get_template_part( 'templates/sidebar/fixed', 'left' );
	}
}

add_action( 'crumina_body_start', '_action_olympus_add_header' );

function _action_olympus_add_header() {

	if ( olympus_is_top_user_panel_visible() ) {
		get_template_part( 'templates/header/general', 'social' );
	}

	if ( olympus_is_top_menu_panel_visible() ) {
		get_template_part( 'templates/header/general', 'menu' );
	}
}

add_action( 'admin_menu', '_action_olympus_add_about_page' );

function _action_olympus_add_about_page() {
	add_theme_page( esc_html__( 'Welcome to Olympus', 'olympus' ), esc_html__( 'About', 'olympus' ), 'administrator', olympus_get_page_welcome_slug(), function() {
		get_template_part( 'templates/admin/about' );
	} );
}

add_action( 'after_setup_theme', '_action_olympus_remove_unyson_filters' );

function _action_olympus_remove_unyson_filters() {
//Sidebar filters
	$rm_fltr = 'remove_filter';
	$rm_fltr( 'posts_where', '_filter_fw_ext_sidebars_title_like_posts_where', 10 );

//Megamenu filters
	$rm_fltr( 'wp_nav_menu_args', '_filter_fw_ext_mega_menu_wp_nav_menu_args' );
	$rm_fltr( 'walker_nav_menu_start_el', '_filter_fw_ext_mega_menu_walker_nav_menu_start_el', 10 );
	$rm_fltr( 'nav_menu_description', 'strip_tags' );
}

add_action( 'upgrader_process_complete', '_action_olympus_set_redirect_after_update', 10, 2 );

function _action_olympus_set_redirect_after_update( $upgrader, $params ) {

	if ( !isset( $params[ 'themes' ] ) ) {
		return;
	}

	if ( !in_array( 'olympus', $params[ 'themes' ] ) ) {
		return;
	}

	olympus_disable_unyson_extension( 'crumina-addons' );
	olympus_set_youzer_content_width();

	olympus_page_welcome_set_redirect();
}

//Rename demo user
add_action( 'wp_ajax_olympus_rename_demo_user', '_action_olympus_rename_demo_user' );

function _action_olympus_rename_demo_user() {
	$user_id = get_current_user_id();

	if ( !$user_id ) {
		return;
	}

	$old = '/crumina';
	$new = '/' . get_userdata( $user_id )->user_nicename;

	global $wpdb;
	$wpdb->query( "UPDATE {$wpdb->postmeta} SET meta_value=REPLACE(meta_value, '{$old}', '{$new}') WHERE meta_key='_menu_item_url' AND meta_value LIKE '%{$old}%'" );
}

add_action( 'current_screen', '_action_olympus_page_welcome_redirect', 11 );

function _action_olympus_page_welcome_redirect() {
	$redirect = get_transient( '_olympus_page_welcome_redirect' );

	if ( !$redirect ) {
		return;
	}

	delete_transient( '_olympus_page_welcome_redirect' );

	wp_redirect( admin_url( 'themes.php?page=' . rawurlencode( olympus_get_page_welcome_slug() ) ) );
	exit;
}

add_action( 'wp_ajax_olympus_notifications_mark_read_all', '_action_olympus_notifications_mark_read_all' );

function _action_olympus_notifications_mark_read_all() {
	check_ajax_referer( 'bp-notifications-mark-read-all' );

	$user_id = get_current_user_id();

	if ( !function_exists( 'bp_is_active' ) || !class_exists( 'BP_Notifications_Notification' ) || !$user_id ) {
		wp_send_json_error( esc_html__( 'BuddyPress must be installed!', 'olympus' ) );
	}

	if ( !bp_is_active( 'notifications' ) ) {
		wp_send_json_error( esc_html__( 'Notifications module is disabled!', 'olympus' ) );
	}

	BP_Notifications_Notification::mark_all_for_user( $user_id, 0 );
	wp_send_json_success();
}

add_action('current_screen', 'olympus_disable_crumina_license_wc');

/**
 * Disable wc registered to crumina website
 */
function olympus_disable_crumina_license_wc( $current_screen ) {
	if ( 'update-core'== $current_screen->base || 'wpbakery-page-builder_page_vc-updater'== $current_screen->base ) {
		$license = get_option( 'wpb_js_js_composer_purchase_code' );
		if ( $license == '123e69ee-4bf1-4ed1-b206-c6176dcfaf58' ) {
			delete_option( 'wpb_js_js_composer_purchase_code' );
		}
	}
}