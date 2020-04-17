<?php

require_once YZ_PUBLIC_CORE . 'widgets/yz-widgets/class-yz-infos-boxes.php';

/**
 * Profile Structure Settings.
 */
function yz_profile_structure_settings() {

    // Profile Structure Script
    wp_enqueue_script( 'yz-profile-structure', YZ_AA . 'js/yz-profile-structure.min.js', array( 'jquery' ), false, true );
    wp_localize_script( 'yz-profile-structure', 'Yz_Profile_Structure', array( 
		'show_wg' => __( 'Show Widget', 'youzer' ),
        'move_wg' => __( 'This widget cannot be moved to the other side.', 'youzer' ),
		'hide_wg' => __( 'Hide Widget', 'youzer' )
	) );

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'msg_type' => 'info',
            'type'     => 'msgBox',
            'title'    => __( 'info', 'youzer' ),
            'id'       => 'yz_msgbox_profile_structure',
            'msg'      => __( 'You have to know that theses widgets <strong>( Email, Website, Address, Phone Number, Recent Posts , Keep In Touch )</strong> can\'t be moved to the <strong>"Main Widgets"</strong> column.', 'youzer' )
        )
    );

    // Profile Widgets
	echo '<div class="yz-profile-structure yz-cs-content">';

	$default_widgets = youzer_widgets();
	
	// Get Main Widegts
	$main_widgets = yz_profile_main_widgets_area( $default_widgets );

	// Get Sidebar Widegts
	yz_profile_sidebar_widgets_area( $default_widgets, $main_widgets );

	echo '<input type="hidden" name="yz_profile_stucture" value="true">';
	echo '</div>';
}

/**
 * # Main Widgets Area.
 */
function yz_profile_main_widgets_area( $default_widget ) {

	// Create New Empty List
	$main_widgets_list = array();

	// Get Current Main Widgets
	$profile_main_widgets = yz_options( 'yz_profile_main_widgets' );

	?>

	<div class="yz-profile-wg yz-main-wgs">
		<div class="yz-wgs-inner-content">
			<h2 class="yz-profile-wg-title"><?php _e( 'Main Widgets', 'youzer' ); ?></h2>
			<ul id="yz-profile-main-widgets" data-widgets-type="main_widgets">

			<?php

			foreach ( $profile_main_widgets as $widget_name => $visibility ) {
				
				$args = yz_get_profile_widget_args( $widget_name );				

				// $widget_status = $widget[ $widget_name ];
				$widget_class  = ( 'invisible' == $visibility ) ? 'yz-hidden-wg' : null;
				$icon_title    = ( 'visible' == $visibility ) ? __( 'Hide Widget', 'youzer' ) : __( 'Show Widget', 'youzer' );

				if ( $args['id'] == 'ad' ) {
					$ads = yz_option( 'yz_ads' );
    				$args['name'] = sprintf( '%1s <span class="yz-ad-flag">%2s</span>', $ads[ $widget_name ]['title'], __( 'ad', 'youzer' ) );
    			}

				// Print Widget
				yz_profile_structure_template( array(
					'icon_title' => $icon_title,
					'id'	=> $widget_name,
					'icon'	=> $args['icon'],
					'name'	=> $args['name'],
					'class'	=> $widget_class,
					'status' => $visibility,
					'input_name' => "yz_profile_main_widgets[$widget_name]",
				) );

				// Fill "$main_widgets_list" Variable with the current list of widgets
				array_push( $main_widgets_list, $widget_name );

			}

			?>

			</ul>
		</div>
	</div>

	<?php

	return  $main_widgets_list;

}

/**
 * # Sidebar Widgets Area.
 */
function yz_profile_sidebar_widgets_area( $default_widgets,$main_widgets_list ) {

	// Get Current Sidebar Widgets
	$profile_sidebar_widgets = yz_options( 'yz_profile_sidebar_widgets' );

	// List of Unsortable Widgets
	$unsortable_widgets = array( 'recent_posts', 'social_networks', 'address', 'email', 'phone', 'website' );

	?>

	<div class="yz-profile-wg yz-sidebar-wgs">
		<h2 class="yz-profile-wg-title"><?php _e( 'Sidebar Widgets', 'youzer' ); ?></h2>
		<ul id="yz-profile-sidebar-widgets" data-widgets-type="sidebar_widgets">

		<?php

		foreach ( $profile_sidebar_widgets as $widget_name => $visibility ) {

			$args = yz_get_profile_widget_args( $widget_name );

			$widget_class  = $visibility == 'invisible' ? 'yz-hidden-wg' : null;
			$widget_class .= in_array( $widget_name, $unsortable_widgets ) ? ' yz_unsortable' : null;
			$icon_title    = $visibility == 'visible' ? __( 'Hide Widget', 'youzer' ) : __( 'Show Widget', 'youzer' );

			if ( $args['id'] == 'ad' ) {
				$ads = yz_option( 'yz_ads' );
				$args['name'] = sprintf( '%1s <span class="yz-ad-flag">%2s</span>', $ads[ $widget_name ]['title'], __( 'ad', 'youzer' ) );
			}

			// Print Widget
			yz_profile_structure_template( array(
				'icon_title'	=> $icon_title,
				'id'	=> $widget_name,
				'icon'	=> $args['icon'],
				'name'	=> $args['name'],
				'class'	=> $widget_class,
				'status'	=> $visibility,
				'input_name'	=> "yz_profile_sidebar_widgets[$widget_name]",
			) );

		}

		?>

		</ul>
	</div>

	<?php

}

/**
 * Profile Structure Template.
 */
function yz_profile_structure_template( $args ) {

	?>

	<li class="<?php echo $args['class']; ?>" data-widget-name="<?php echo $args['id']; ?>">
		<h3 data-hidden="<?php _e( 'hidden', 'youzer' ); ?>">
			<i class="<?php echo $args['icon']; ?>"></i>
			<?php echo $args['name']; ?>
		</h3>
		<a class="yz-hide-wg" title="<?php echo $args['icon_title']; ?>"></a>
		<input class="yz_profile_widget" type="hidden" name="<?php echo $args['input_name']; ?>" value="<?php echo !empty( $args['status'] ) ? $args['status'] : 'visible'; ?>">
	</li>

	<?php
}

/**
 * Get User Class.
 */
// function yz_get_profile_widget_class( $widgets, $widget_name ) {

// 	if ( isset( $widgets[ $widget_name ] ) ) {
// 		include_once YZ_PUBLIC_CORE . 'widgets/yz-widgets/class-yz-' . $widgets[ $widget_name ]['file'] . '.php';
// 		$class = new $widgets[ $widget_name ]['class']();
// 	} else {
// 		if ( false !== strpos( $widget_name, 'yz_custom_widget_' ) ) {
// 			include_once YZ_PUBLIC_CORE . 'widgets/yz-widgets/class-yz-custom-widgets.php';
// 			$class = new YZ_Custom_Widgets( $widget_name );
// 		} elseif ( false !== strpos( $widget_name, 'yz_ad_' ) ) {
// 			include_once YZ_PUBLIC_CORE . 'widgets/yz-widgets/class-yz-ads.php';
// 			$class = new YZ_Ads( $widget_name );

// 		}

// 	}

// 	return $class;

// }