<?php
$user_ID         = get_current_user_id();
$olympus         = Olympus_Options::get_instance();
$show_users_menu = $olympus->get_option( 'top-panel-users-menu', 'yes' );

if ( !$user_ID || $show_users_menu !== 'yes' ) {
    return false;
}

$current_user        = wp_get_current_user();
$current_user_status = get_user_meta( $user_ID, 'olympus-custom-user-status', true );

if ( current_user_can( 'read' ) ) {
    $profile_url = get_edit_profile_url( $user_ID );
} elseif ( is_multisite() ) {
    $profile_url = get_dashboard_url( $user_ID, 'profile.php' );
} else {
    $profile_url = false;
}
?>

<div id="author-page" class="author-page author vcard inline-items">
    <a href="<?php echo get_author_posts_url( $user_ID ); ?>" class="author-thumb">
        <?php echo get_avatar( $user_ID, 36 ); ?>
        <span class="icon-status online"></span>
    </a>

    <div class="author-name fn more">
        <div class="author-title">
            <?php olympus_render( $current_user->display_name ); ?> <svg class="olymp-dropdown-arrow-icon"><use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-dropdown-arrow-icon"></use></svg>
        </div>
        <span class="author-subtitle"><?php echo esc_html( $current_user_status ); ?></span>
		<div class="more-dropdown more-with-triangle">
			<div id="author-page-inner" class="mCustomScrollbar">

				<div class="ui-block-title ui-block-title-small">
					<h6 class="title"><?php esc_html_e( 'Your account', 'olympus' ) ?></h6>
				</div>

			    <?php
			    $menu_args = array(
				    'theme_location' => 'user',
				    'menu_class'     => 'menu account-settings',
				    'container'      => false,
				    'link_before'    => '',
				    'link_after'     => '',
				    'depth'          => 3,
				    'fallback_cb'    => 'olympus_bp_menu',
			    );

			    if ( class_exists( 'Olympus_Mega_Menu_Custom_Walker' ) ) {
				    $menu_args[ 'walker' ] = new Olympus_Mega_Menu_Custom_Walker();
			    }

			    wp_nav_menu( $menu_args );
			    ?>

			</div>

		</div>
    </div>
</div>
