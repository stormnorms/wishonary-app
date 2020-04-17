<?php

if ( !defined( 'FW' ) )
    die( 'Forbidden' );
/**
 * @var WP_Post $item
 * @var string $title
 * @var array $attributes
 * @var object $args
 * @var int $depth
 */
if ( fw()->extensions->get( 'megamenu' )->show_icon() ) {
	$meta      = fw_ext_mega_menu_get_meta( $item->ID, "icon" );
	$icon      = olympus_prepare_megamenu_icon_params( $meta );
	$data_icon = '';
	if ( $icon['type'] === 'custom-upload' && ! empty( $icon['url'] ) ) {
		$file_parts = pathinfo( $icon['url'] );
		if ( 'svg' === $file_parts['extension'] ) {
			$data_icon = olympus_embed_custom_svg( $icon['url'], 'menu-item-icon menu-item-icon-img' );
		} else {
			$data_icon = fw_html_tag( 'img', array(
				'class' => 'menu-item-icon menu-item-icon-img',
				'src'   => $icon['url'],
				'alt'   => ''
			), false );
		}
	}

	if ( $icon['type'] === 'icon-font' && ! empty( $icon['icon-class'] ) ) {
		$data_icon = fw_html_tag( 'i', array( 'class' => 'menu-item-icon ' . $icon['icon-class'] ), true );
	}

	$title = $data_icon . $title;
}


olympus_render($args->before);
$label             = '';
$item->description = trim( $item->description );
if ( !empty( $item->description ) ) {
	$label = fw_html_tag( 'div', array( 'class' => 'menu-item-description' ), $item->description );
}
/* If empty link in item - we will print title item instead link */
if ( empty( $attributes[ 'href' ] ) || $attributes[ 'href' ] === 'http://' || $attributes[ 'href' ] === 'http://#' || $attributes[ 'href' ] === 'https://' || $attributes[ 'href' ] === 'https://#' ) {
    echo '<div class="megamenu-item-info">';
    if ( $depth > 0 && true !== fw_ext_mega_menu_get_meta( $item, 'title-off' ) ) {
        echo fw_html_tag( 'h6', array( 'class' => 'column-tittle' ), $title );
    }
    echo '</div>';
} else {
    if ( true === fw_ext_mega_menu_get_meta( $item, 'title-off' ) ) {
	     olympus_render ( $label );
    } else {
	    echo fw_html_tag( 'a', $attributes, $args->link_before . $title . $label . $args->link_after );
    }

}
olympus_render($args->after);
