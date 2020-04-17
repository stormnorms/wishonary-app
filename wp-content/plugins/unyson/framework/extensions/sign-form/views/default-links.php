<?php
/**
 * @var object $ext
 */
$user_ID = get_current_user_id();

if ( !$user_ID ) {
	return;
}

$use_buddypress = $ext->useBuddyPress();

if ( !$use_buddypress ) {
	return;
}
?>

<?php if ( bp_is_active( 'activity' ) ) { ?>
	<a href="<?php echo esc_url( bp_loggedin_user_domain() . bp_get_activity_slug() ); ?>" class="link-item">
		<svg class="link-item-icon olymp-newsfeed-icon"><use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-newsfeed-icon"></use></svg>
		<div class="title"><?php esc_html_e( 'Activity', 'crum-ext-sign-form' ); ?></div>
		<div class="sup-title"><?php esc_html_e( 'Review your activity!', 'crum-ext-sign-form' ); ?></div>
	</a>
<?php } ?>
<?php if ( bp_is_active( 'notifications' ) ) { ?>
	<a href="<?php echo bp_get_notifications_unread_permalink(); ?>" class="link-item">
		<svg class="link-item-icon olymp-thunder-icon"><use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-thunder-icon"></use></svg>
		<div class="title"><?php esc_html_e( 'Notifications', 'crum-ext-sign-form' ); ?></div>
		<div class="sup-title"><?php esc_html_e( 'Check out what\'s new!', 'crum-ext-sign-form' ); ?></div>
	</a>
<?php } ?>
<?php if ( class_exists( 'bbPress' ) && defined( 'BP_FORUMS_SLUG' ) ) { ?>
	<a href="<?php echo esc_url( bp_loggedin_user_domain() . BP_FORUMS_SLUG ); ?>" class="link-item">
		<svg class="link-item-icon olymp-chat---messages-icon"><use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-chat-messages-icon"></use></svg>
		<div class="title"><?php esc_html_e( 'Forums', 'crum-ext-sign-form' ); ?></div>
		<div class="sup-title"><?php esc_html_e( 'Start a new discussion!', 'crum-ext-sign-form' ); ?></div>
	</a>
<?php } ?>
<?php if ( bp_is_active( 'settings' ) ) { ?>
	<a href="<?php echo esc_url( bp_loggedin_user_domain() . bp_get_settings_slug() ); ?>" class="link-item">
		<svg class="link-item-icon olymp-settings-icon"><use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-settings-icon"></use></svg>
		<div class="title"><?php esc_html_e( 'Settings', 'crum-ext-sign-form' ); ?></div>
		<div class="sup-title"><?php esc_html_e( 'Manage your preferences!', 'crum-ext-sign-form' ); ?></div>
	</a>
<?php } ?>