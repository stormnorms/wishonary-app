<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

class FW_Extension_Stunning_Header extends FW_Extension {

    protected function _init() {
        
    }

    public function render() {
        $prefix = $this->get_option_prefix();

        $content    = $this->get_option( "{$prefix}header-stunning-content", array(), 'settings' );
        $customizer = $this->get_option( "{$prefix}header-stunning-customizer", array(), 'customizer' );
        $ctype_visibility = $this->get_option_final( "header-stunning-visibility", 'default', array( 'final-source' => 'current-type' ) );

        $visible = $this->is_visible();
        $t = 5;
        if ( !$visible ) {
            return;
        }

        $classes = apply_filters( 'fw_ext_stunning_header_container_classes', array( 'crumina-stunning-header' ) );

        $bg_image_default = 'url(' . get_template_directory_uri() . '/images/header-stunning-1.png)';

        $customize_content = $this->get_option_final( 'header-stunning-customize/yes/header-stunning-customize-content', array() );
        if ( fw_akg( 'customize', $customize_content, 'no' ) === 'yes' && $ctype_visibility !== 'default' ) {
            $title_show       = fw_akg( 'yes/header-stunning-content-popup/stunning_title_show/show', $customize_content, 'yes' );
            $breadcrumbs_show = fw_akg( 'yes/header-stunning-content-popup/stunning_breadcrumbs_show', $customize_content, 'yes' );
            $title_text       = fw_akg( 'yes/header-stunning-content-popup/stunning_title_show/yes/title', $customize_content, '' );
            $text             = fw_akg( 'yes/header-stunning-content-popup/stunning_text', $customize_content, '' );
        } else {
            $title_show       = fw_akg( 'yes/stunning_title_show/show', $content, 'yes' );
            $breadcrumbs_show = fw_akg( 'yes/stunning_breadcrumbs_show', $content, 'yes' );
            $title_text       = fw_akg( 'yes/stunning_title_show/yes/title', $content, '' );
            $text             = fw_akg( 'yes/stunning_text', $content, '' );
        }

        $customize_styles = $this->get_option_final( 'header-stunning-customize/yes/header-stunning-customize-styles', array() );
        if ( fw_akg( 'customize', $customize_styles, 'no' ) === 'yes' && $ctype_visibility !== 'default' ) {
            $bottom_image    = fw_akg( 'yes/header-stunning-styles-popup/stunning_bottom_image/url', $customize_styles, '' );
            $text_align      = fw_akg( 'yes/header-stunning-styles-popup/stunning_text_align', $customize_styles, '' );
            $bg_animate      = fw_akg( 'yes/header-stunning-styles-popup/stunning_bg_animate_picker/stunning_bg_animate', $customize_styles, 'yes' );
            $bg_animate_type = fw_akg( 'yes/header-stunning-styles-popup/stunning_bg_animate_picker/yes/stunning_bg_animate_type', $customize_styles, 'fixed' );
            $bg_image        = fw_akg( 'yes/header-stunning-styles-popup/stunning_bg_image/data/css/background-image', $customize_styles, $bg_image_default );
        } else {
            $bottom_image    = fw_akg( 'yes/stunning_bottom_image/url', $customizer, '' );
            $text_align      = fw_akg( 'yes/stunning_text_align', $customizer, '' );
            $bg_animate      = fw_akg( 'yes/stunning_bg_animate_picker/stunning_bg_animate', $customizer, 'yes' );
            $bg_animate_type = fw_akg( 'yes/stunning_bg_animate_picker/yes/stunning_bg_animate_type', $customizer, 'fixed' );
            $bg_image        = fw_akg( 'data/css/background-image', fw_akg( 'yes/stunning_bg_image', $customizer, '' ), $bg_image_default );
        }

        //Add addit classes for container
        if ( 'yes' === $bg_animate ) {
            $classes[] = 'crumina-stunning-header--with-animation';
        }

        if ( $bottom_image ) {
            $classes[] = 'has-img-bottom';
        }

        $classes[] = $text_align;

        $this->get_view( 'stunning', compact( 'bg_image', 'title_show', 'title_text', 'breadcrumbs_show', 'text', 'bottom_image', 'bg_animate', 'classes', 'bg_animate_type' ), false );
    }
    
    public function get_option_prefix() {
        $prefix = '';
        if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
            $prefix = 'woocommerce_';
        } elseif ( function_exists( 'tribe_is_event_query' ) && tribe_is_event_query() ) {
            $prefix = 'events_';
        } elseif ( function_exists( 'bp_current_component' ) && bp_current_component() ) {
            $prefix = 'buddypress_';
        } elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
            $prefix = 'bbpress_';
        }
        
        return $prefix;
    }
    
    public function is_visible() {
        $prefix = $this->get_option_prefix();
         $visibility = $this->get_option( "{$prefix}header-stunning-visibility", 'yes', 'settings' );

        $ctype_visibility = $this->get_option_final( "header-stunning-visibility", 'default', array( 'final-source' => 'current-type' ) );

        if ( $ctype_visibility !== 'default' ) {
            $visibility = $ctype_visibility;
        }

        $visibility = apply_filters( 'fw_ext_stunning_header_visibility', $visibility );

        return $visibility === 'yes' ? true : false;
    }

    public function get_option( $option_id, $default_value = '', $source = 'settings', $atts = array() ) {
        $obj = get_queried_object();

        switch ( $source ) {
            case 'settings':
                return fw_get_db_settings_option( $option_id, $default_value );
            case 'customizer':
                return fw_get_db_customizer_option( $option_id, $default_value );
            case 'post':
                if ( isset( $atts[ 'ID' ] ) ) {
                    $atts[ 'ID' ] = (int) $atts[ 'ID' ];
                } else if ( isset( $obj->ID ) ) {
                    $atts[ 'ID' ] = $obj->ID;
                } else {
                    return $default_value;
                }
                return fw_get_db_post_option( $atts[ 'ID' ], $option_id, $default_value );
            case 'taxonomy':
                if ( isset( $atts[ 'term_id' ] ) ) {
                    $atts[ 'term_id' ] = (int) $atts[ 'term_id' ];
                } else if ( isset( $obj->term_id ) ) {
                    $atts[ 'term_id' ] = $obj->term_id;
                } else {
                    return $default_value;
                }

                if ( isset( $atts[ 'taxonomy' ] ) ) {
                    $atts[ 'taxonomy' ] = (string) $atts[ 'taxonomy' ];
                } else if ( isset( $obj->taxonomy ) ) {
                    $atts[ 'taxonomy' ] = $obj->taxonomy;
                } else {
                    return $default_value;
                }
                return fw_get_db_term_option( $atts[ 'term_id' ], $atts[ 'taxonomy' ], $option_id, $default_value );
            default:
                return $default_value;
        }
    }

    public function get_option_final( $option_id, $default_value = '', $atts = array( 'final-source' => 'settings' ) ) {
        $option = '';

        if ( is_singular() ) {
            $option = $this->get_option( $option_id, 'default', 'post' );
        } elseif ( is_archive() ) {
            $option = $this->get_option( $option_id, 'default', 'taxonomy' );
        }

        //Fix for WooCommerce
        if ( function_exists( 'is_shop' ) && is_shop() ) {
            $shop_id = wc_get_page_id( 'shop' );

            if ( $shop_id > 0 ) {
                $option = $this->get_option( $option_id, 'default', 'post', array(
                    'ID' => $shop_id
                        ) );
            }
        }

        if ( empty( $option ) || ($option === 'default') ) {
            switch ( $atts[ 'final-source' ] ) {
                case 'customizer':
                    $source = 'customizer_option';
                    break;
                case 'current-type':
                    if ( is_singular() ) {
                        $source = 'post';
                    } elseif ( is_archive() ) {
                        $source = 'taxonomy';
                    } else {
                        $source = 'settings';
                    }
                    break;
                default:
                    $source = 'settings';
                    break;
            }

            $option = $this->get_option( $option_id, $default_value, $source );
        }

        return $option;
    }

    /**
     * @param string $name View file name (without .php) from <extension>/views directory
     * @param  array $view_variables Keys will be variables names within view
     * @param   bool $return In some cases, for memory saving reasons, you can disable the use of output buffering
     * @return string HTML
     */
    final public function get_view( $name, $view_variables = array(), $return = true ) {
        $full_path = $this->locate_path( '/views/' . $name . '.php' );

        if ( !$full_path ) {
            trigger_error( 'Extension view not found: ' . $name, E_USER_WARNING );
            return;
        }

        return fw_render_view( $full_path, $view_variables, $return );
    }

    public static function customizerScripts() {
        $ext = fw_ext( 'stunning-header' );
        wp_enqueue_style( 'crumina-stunning-header-customizer', $ext->locate_URI( '/static/css/stunning-header-customizer.css' ), array(), $ext->manifest->get_version() );
    }

}
