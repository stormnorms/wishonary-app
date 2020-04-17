<?php
/**
 * Class Olympus_Options
 */
class Olympus_Options extends Olympus_Singleton {
	const SOURCE_SETTINGS = 'get_settings_option';
	const SOURCE_CUSTOMIZER = 'get_customizer_option';
	const SOURCE_POST = 'get_post_option';
	const SOURCE_TAXONOMY = 'get_taxonomy_option';
	/**
	 * Class instance
	 *
	 * @var Olympus_Options
	 */
	protected static $instance;

	/**
	 * Bloom_Logo constructor.
	 */
	protected final function __construct() {

	}

    /**
	 * Get blog option.
	 *
	 * @param string $option_id option name.
	 * @param mixed $default_value default value if option_id not found.
	 * @param string $source source to get option.
	 *
	 * @param array $atts
	 *
	 * @return mixed
	 */
	public function get_option( $option_id, $default_value, $source = self::SOURCE_SETTINGS, $atts = array() ) {
		return $this->$source( $option_id, $default_value, $atts );
	}
	/**
	 * Get option first from metabox, them from customizer.
	 *
	 * @param string $option_id option name.
	 * @param mixed $default_value default value if option_id not found.
	 * @param string $source source to get option.
	 *
	 * @param array $atts
	 *
	 * @return mixed
	 */
	public function get_option_final( $option_id, $default_value,
                                      $atts = array(
        'final-source' => 'settings'
    ) ) {
        $option = '';
        if ( is_singular() ) {
            $option = $this->get_option( $option_id, 'default', Olympus_Options::SOURCE_POST );
        } elseif ( is_archive() ) {
            $option = $this->get_option( $option_id, 'default', Olympus_Options::SOURCE_TAXONOMY );
        }
        if ( empty( $option ) || (isset( $option[ 'type' ] ) ? $option[ 'type' ] === 'default' : $option === 'default') ) {

            switch ( $atts[ 'final-source' ] ) {
                case 'customizer':
                    $source = Olympus_Options::SOURCE_CUSTOMIZER;
                    break;
                case 'current-type':
                    if ( is_singular() ) {
                        $source = Olympus_Options::SOURCE_POST;
                    } elseif ( is_archive() ) {
                        $source = Olympus_Options::SOURCE_TAXONOMY;
                    } else {
                        $source = Olympus_Options::SOURCE_SETTINGS;
                    }
                    break;
                default:
                    $source = Olympus_Options::SOURCE_SETTINGS;
                    break;
            }

            $option = $this->get_option( $option_id, $default_value, $source );
        }
        return $option;
    }

	/**
	 * Helper for getting page id with no ID's (buddypress, etc)
	 *
	 * @param        $page_slug
	 * @param string $slug_page_type
	 *
	 * @return mixed
	 */
	private function get_id_by_slug( $page_slug, $slug_page_type = 'page' ) {
		$find_page = get_page_by_path( $page_slug, OBJECT, $slug_page_type );
		if ( $find_page ) {
			return $find_page->ID;
		} else {
			return null;
		}
	}
    /**
	 * Get settings options
	 *
	 * @param string $option_id option name.
	 * @param mixed $default_value default value if option_id not found.
	 *
	 * @return mixed
	 */
	private function get_settings_option( $option_id, $default_value, $atts ) {
		return function_exists( 'fw_get_db_settings_option' ) ? fw_get_db_settings_option( $option_id, $default_value ) : $default_value;
	}

	/**
	 * Get customizer options
	 *
	 * @param string $option_id option name.
	 * @param mixed $default_value default value if option_id not found.
	 *
	 * @return mixed
	 */
	private function get_customizer_option( $option_id, $default_value, $atts  ) {
		return function_exists( 'fw_get_db_customizer_option' ) ? fw_get_db_customizer_option( $option_id, $default_value ) : $default_value;
	}

	/**
	 * Get options from post
	 *
	 * @param string $option_id option name.
	 * @param mixed $default_value default value if option_id not found.
	 *
	 * @param $atts
	 *
	 * @return mixed
	 */
	private function get_post_option( $option_id, $default_value, $atts ) {
		if ( ! isset( $atts['post_id'] ) ) {
			global $post;
			$atts['post_id'] = get_the_ID();
			if ( $atts['post_id'] == 0 ) {
				$atts['post_id'] = $this->get_id_by_slug( $post->post_name );
			}
		}
		return function_exists( 'fw_get_db_post_option' ) ? fw_get_db_post_option( $atts['post_id'], $option_id, $default_value ) : $default_value;
	}

	/**
	 * Get options from taxonomy
	 *
	 * @param string $option_id option name.
	 * @param mixed $default_value default value if option_id not found.
	 *
	 * @return mixed
	 */
	private function get_taxonomy_option( $option_id, $default_value, $atts ) {
        $obj = get_queried_object();
        if ( !isset( $atts[ 'term_id' ] ) ) {
            if ( isset( $obj->term_id ) ) {
                $atts[ 'term_id' ] = $obj->term_id;
            } else {
                return $default_value;
            }
        }
        if ( !isset( $atts[ 'taxonomy' ] ) ) {
            if ( isset( $obj->taxonomy ) ) {
                $atts[ 'taxonomy' ] = $obj->taxonomy;
            } else {
                return $default_value;
            }
        }
        return function_exists( 'fw_get_db_term_option' ) ? fw_get_db_term_option( $atts[ 'term_id' ], $atts[ 'taxonomy' ], $option_id, $default_value ) : $default_value;
    }

}
