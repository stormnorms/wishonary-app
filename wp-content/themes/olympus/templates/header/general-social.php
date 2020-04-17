<?php
/**
 * The template for displaying one of theme headers
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package olympus
 */
$olympus	 = Olympus_Options::get_instance();
$show_search = $olympus->get_option( 'top-panel-search', 'yes' );
?>

<header class="header <?php echo (!is_user_logged_in()) ? 'header--logout' : ''; ?>" id="site-header">
    <div class="header-content-wrapper">

		<?php if ( $show_search === 'yes' ) { ?>
			<form id="top-search-form" action="<?php echo home_url( '/' ); ?>" method="GET" class="search-bar w-search notification-list friend-requests">
				<div class="form-group with-button">
					<div class="selectize-control form-control js-user-search multi">
						<div class="selectize-input items not-full has-options">
							<input type="text" autocomplete="off" name="s" id="s" value="<?php echo filter_input( INPUT_GET, 's' ); ?>" placeholder="<?php esc_attr_e( 'Search here people or pages...', 'olympus' ); ?>">
						</div>
						<div class="selectize-dropdown multi form-control js-user-search mCustomScrollbar">
							<div class="selectize-dropdown-content"></div>
						</div>
					</div>
					<button>
						<svg class="olymp-search-loupe">
							<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-magnifying-glass-icon"></use>
						</svg>
						<svg class="olymp-search-spinner" width="135" height="135" viewBox="0 0 135 135" xmlns="http://www.w3.org/2000/svg">
							<path d="M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z">
								<animateTransform
									attributeName="transform"
									type="rotate"
									from="0 67 67"
									to="-360 67 67"
									dur="2.5s"
									repeatCount="indefinite"/>
							</path>
							<path d="M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z">
								<animateTransform
									attributeName="transform"
									type="rotate"
									from="0 67 67"
									to="360 67 67"
									dur="8s"
									repeatCount="indefinite"/>
							</path>
						</svg>
					</button>
				</div>
			</form>
		<?php } ?>

		<?php if ( is_user_logged_in() ) { ?>
			<div id="notification-panel-top" class="control-block">
				<?php get_template_part( 'templates/user/notifications' ); ?>
			</div>
			<div id="notification-panel-bottom" class="notification-panel-bottom">
				<div class="control-block"></div>
			</div>
		<?php } else if ( function_exists( 'crumina_get_reg_form_html' ) ) { ?>
			<a href="#" class="side-menu-open" data-toggle="modal" data-target="#registration-login-form-popup">
				<svg class="olymp-login-icon olymp-menu-icon">
					<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-login-icon"></use>
				</svg>
			</a>
		<?php } ?>

        <div class="fixed-sidebar right">
            <a href="#" class="side-menu-open js-sidebar-open">
                <i class="user-icon far fa-user" data-toggle="tooltip" data-placement="left" data-original-title="<?php esc_attr_e( 'Open menu', 'olympus' ); ?>"></i>
                <svg class="olymp-close-icon" data-toggle="tooltip" data-placement="left" data-original-title="<?php esc_attr_e( 'Close menu', 'olympus' ); ?>">
					<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-close-icon"></use>
                </svg>
            </a>
            <div class="fixed-sidebar-right" id="sidebar-right">

                <div id="profile-panel-responsive" class="mCustomScrollbar ps ps--theme_default" data-mcs-theme="dark">

                </div>

            </div>
        </div>

    </div>

</header>