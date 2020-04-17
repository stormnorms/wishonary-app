<?php
$olympus = Olympus_Options::get_instance();

if ( !olympus_is_left_panel_visible() ) {
    return;
}

$menu_items = array();
$menu_name  = 'fixed-left';
$locations  = get_nav_menu_locations();

if ( $locations && isset( $locations[ $menu_name ] ) ) {
    $menu       = wp_get_nav_menu_object( $locations[ $menu_name ] );
    $menu_items = wp_get_nav_menu_items( $menu );
}
?>
<div id="fixed-sidebar-left" class="fixed-sidebar left">

    <a href="#" class="side-menu-open js-sidebar-open">
        <svg class="olymp-menu-icon" data-toggle="tooltip" data-placement="right" data-original-title="<?php esc_attr_e( 'Open menu', 'olympus' ); ?>">
        	<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-menu-icon"></use>
        </svg>
        <svg class="olymp-close-icon" data-toggle="tooltip" data-placement="right" data-original-title="<?php esc_attr_e( 'Close menu', 'olympus' ); ?>">
        	<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-close-icon"></use>
        </svg>
    </a>

    <div class="fixed-sidebar-left sidebar--small" id="sidebar-left">

        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <ul class="left-menu">
                <?php
                if ( !empty( $menu_items ) ) {
                    foreach ( $menu_items as $idx => $item ) {
                        ?>
                        <?php
                        $meta = fw_ext_mega_menu_get_meta( $item->ID, "icon" );
                        $icon = olympus_prepare_megamenu_icon_params( $meta );

                        if ( $icon[ 'type' ] === 'custom-upload' && !empty( $icon[ 'url' ] ) ) {
                            $file_parts = pathinfo( $icon[ 'url' ] );
                            if ( 'svg' === $file_parts[ 'extension' ] ) {
                                $data_icon = olympus_embed_custom_svg( $icon[ 'url' ], 'left-menu-icon' );
                            } else {
                                $data_icon = '<img src="' . esc_attr( $icon[ 'url' ] ) . '" alt="' . esc_attr( $item->title ) . '" class="left-menu-icon" />';
                            }
                            $menu_items[ $idx ]->icon = $data_icon;
                        } elseif ( $icon[ 'type' ] === 'icon-font' && !empty( $icon[ 'icon-class' ] ) ) {
                            $menu_items[ $idx ]->icon = '<i  class="left-menu-icon ' . esc_attr( $icon[ 'icon-class' ] ) . '"></i>';
                        } else {
                            $menu_items[ $idx ]->icon = olympus_svg_icon( 'olymp-star-icon', 'left-menu-icon' );
                        }
                        ?>

                        <li>
                            <a href="<?php echo esc_attr( $item->url ); ?>">
								<span data-toggle="tooltip" data-placement="right" data-original-title="<?php echo esc_attr( $item->title ); ?>" >
									<?php olympus_render( $item->icon ); ?>
								</span>
							</a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <ul class="left-menu">
                <?php
                if ( !empty( $menu_items ) ) {
                    foreach ( $menu_items as $item ) {
                        ?>
                        <li>
                            <a href="<?php echo esc_attr( $item->url ); ?>">
                                <?php olympus_render( $item->icon ); ?>
                                <span class="left-menu-title"><?php echo esc_html( $item->title ); ?></span>
                            </a>
                        </li>
                        <?php
                    }
                } else {
                    olympus_menu_fallback( esc_html__( 'Left Menu Panel', 'olympus' ) );
                }
                ?>
            </ul>
        </div>
    </div>
</div>
