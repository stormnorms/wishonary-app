<?php

class YZ_Custom_Tabs {

    public function __construct() {
		add_action( 'bp_init', array( $this, 'hide_custom_tab_sidebar' ) );
    }

    /**
     * Custom Tab Hide Sidebar
     */
    function hide_custom_tab_sidebar() {
        
        if ( ! bp_is_user() ) {
            return false;
        }

    	// Get Curren Tab Name.
    	$current_slug = $this->get_current_tab_name();

    	if ( ! yz_is_custom_tab( $current_slug ) ) {
    		return false;
    	}

		// Get Header Layout.
		$header_layout = yz_get_profile_layout();

        // Get Custom Tabs
        $data = $this->get_all_data( $current_slug );

		if ( 'yz-horizontal-layout' == $header_layout && 'false' == $data['display_sidebar'] ) {

			// Remove Old Structure.
	    	remove_action(
	    		'yz_profile_main_content',
	    		array( $this->youzer->profile, 'profile_main_content' )
	    	);

	    	// Add Wild Content.
			add_action( 'yz_profile_main_content', array( $this, 'tab' ) );

		}

    }
    
	/**
	 * Tab Core
	 */
	function tab() {

        // Hide sidebar if profile is private.
        if ( ! yz_display_profile() ) {
            yz_private_account_message();
            return false;
        }

        // Get Tab Content.
        echo '<div class="yz-tab yz-custom">';
        $this->tab_content();
        echo '</div>';

	}

	/**
	 * # Tab Content
	 */
	function tab_content() {

        // Get Custom Tabs
        $data = $this->get_all_data( $this->get_current_tab_name() );

        // Get Content
        $content = urldecode( $data['content'] );

        // Filter Content
        $content = yz_convert_content_tags( $content );
        
        // Display Widget.
        echo "<div class='yz-custom-tab'>";
        echo apply_filters( 'the_content', $content );
        echo "</div>";

	}

    /**
     * Get Custom Widget data.
     */
    function get_all_data( $tab_name ) {
        $tabs = yz_option( 'yz_custom_tabs' );
        return $tabs[ $tab_name ];
    }

    /**
     * Get Args.
     */
    function get_args() {

        // Get Custom Tabs
        $data = $this->get_all_data( $this->get_current_tab_name() );

		// Get Custom Tab Args.
		$args = array(
			'tab_name'    => 'custom',
			'tab_title'   => $data['title'],
            'tab_slug'	  => isset( $data['slug'] ) ? $data['slug'] : yz_get_custom_tab_slug( $data['title'] )
		);

		return $args;
    }

    /**
     * Get Current Tab name.
     */
    function get_current_tab_name() {

    	// Get Current Slug.
    	$current_slug = bp_current_action();

    	// Get Tab Name.
    	$tab_name = yz_get_tab_name_by_slug( $current_slug );

    	return $tab_name;

    }

    /**
     * Get Custom Tab data.
     */
    function get_tab_data( $tab_name, $data_type ) {
        $tabs = yz_option( 'yz_custom_tabs' );
        return $tabs[ $tab_name ][ $data_type ];
    }
}