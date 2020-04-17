<?php

/**
 * Wall Functions
 */
class Youzer_Wall_Functions  {

	function __construct( ) {
		
		// Edit Wall Filters.
		add_filter( 'bp_get_activity_show_filters_options', array( $this, 'edit_wall_filter' ) );

		// Get Live Preview Url.
		add_action( 'wp_ajax_yz_get_url_live_preview', array( $this, 'get_live_url_preview' ) );

		// Set Wall Posts Per Page.
		add_filter( 'bp_legacy_theme_ajax_querystring', array( $this, 'wall_posts_per_page' ) );

		// Set Activity Default Filter.
		add_filter( 'bp_after_has_activities_parse_args', array( $this, 'activity_default_filter' ) );

		// Set Post Elements Visibility
		add_filter( 'bp_activity_can_favorite', array( $this, 'set_likes_visibility' ) );
		add_filter( 'bp_activity_can_comment', array( $this, 'set_comments_visibility' ) );
		add_filter( 'bp_activity_user_can_delete', array( $this, 'set_delete_visibility' ) );
		add_filter( 'bp_activity_can_comment_reply', array( $this, 'set_replies_visibility' ) );

		// Embeds Options
		add_filter( 'bp_use_oembed_in_activity', array( $this, 'enable_posts_embeds' ) );
		add_filter( 'bp_use_embed_in_activity_replies', array( $this, 'enable_comments_embeds' ) );

		// Hide Private Users Posts.
		add_filter( 'bp_activity_get_where_conditions', array( $this, 'hide_private_users_posts' ), 10 );

		// Add Delete Post Tool
		add_filter( 'yz_activity_tools', array( $this, 'add_delete_activity_tool' ), 99, 2 );

		// Add Embeds Wrapper.
		add_filter( 'bp_embed_oembed_html',  array( $this, 'embed_videos_container' ), 10, 4 );

		// Allow Comments Without Content That Contains Attachment.
		add_filter( 'bp_activity_content_before_save',  array( $this, 'allow_comments_without_content' ), 10, 2 );

		// Hide Emoji From Content
		// add_filter( 'bp_init',  array( $this, 'hide_emojis_from_content' ) );

		// Display "Show Activity Tools Button". 
		add_action( 'bp_before_activity_entry_header',  array( $this, 'show_activity_tools_icon' ) );

	}

	/**
	 * Hide Emojis From Content.
	 */
	function hide_emojis_from_content() {
		
        // Hide Posts Emoji
        if ( 'off' == yz_option( 'yz_enable_posts_emoji', 'on' ) ) {
            add_filter( 'bp_get_activity_content_body', 'yz_remove_emoji' );
        }

        // Hide Comments Emoji
        if ( 'off' == yz_option( 'yz_enable_comments_emoji', 'on' ) ) {
            add_filter( 'bp_activity_comment_content', 'yz_remove_emoji' );
        }
    
	}
	
	/*
	 * Allow Comments Without Content That Contains Attachment.
	 **/
	function allow_comments_without_content( $content, $activity ) {

		if ( $activity->type == 'activity_comment' ) {
			$content = str_replace( '{{{yz_comment_attachment}}}', '', $content );
		}

		return $content;
	}

	/**
	 * Embeds Wrapper.
	 */
	function embed_videos_container( $html, $url, $attr, $rawattr ) {

		// Wrapped Providers.
		$providers = array( 'soundcloud.com', 'vimeo.com', 'youtube.com', 'youtu.be', 'dailymotion.com' );

		foreach ( $providers as $provider ) {
			if ( strpos( $url, $provider ) !== false ) {
				return '<div class="yz-embed-wrapper">' . $html . '</div>';	
			}
		}

	    return $html;
	}

	/**
	 * Add Delete Activity Tool.
	 */
	function add_delete_activity_tool( $tools, $post_id ) {
				
		$activity = new BP_Activity_Activity( $post_id );

		if ( ! bp_activity_user_can_delete( $activity ) ) {
			return $tools;
		}

		// Get Tool Data.
		$tools[] = array(
			'icon' => 'fas fa-trash-alt',
			'title' =>  __( 'Delete', 'youzer' ),
			'action' => 'delete-activity',
			'class' => array( 'yz-delete-tool', 'yz-delete-post' ),
			'attributes' => array( 'item-type' => 'activity', 'nonce' => wp_create_nonce( 'bp_activity_delete_link' ) )
		);

		return $tools;
	}


	/**
	 * Get Wall Posts Per page
	 */
	function wall_posts_per_page( $query ) {
		
		// Get Posts Per Page Number.
		if ( bp_is_activity_directory() ) {
			$posts_per_page = yz_option( 'yz_activity_wall_posts_per_page', 5 );
		} elseif( bp_is_user_activity() ) {
			$posts_per_page = yz_option( 'yz_profile_wall_posts_per_page', 5 );
		} elseif( bp_is_groups_component() ) {
			$posts_per_page = yz_option( 'yz_groups_wall_posts_per_page', 5 );
		} else {
			$posts_per_page = '';
		}

		if ( ! empty( $posts_per_page ) ) {

			if ( ! empty( $query ) ) {
		        $query .= '&';
		    }

			// Query String.
			$query .= 'per_page=' . $posts_per_page;

		}

		// echo $query;
		return $query;
	    
	}

	/**
	 * Set Activity Default Filter
	 */
	function activity_default_filter( $retval ) { 
	    
	    if ( ! isset( $retval['type'] ) || ( isset( $retval['type'] ) && $retval['type'] == 'null' ) )  {
		    $show_everything = $this->get_show_everything_filter();
	        $retval['action'] = $show_everything;    
	    }

	    return $retval;

	}

	/**
	 * Wall Show Everything filter.
	 */
	function get_show_everything_filter() {

		// Init Array.
		$filter_actions = array();

	  	// Get Allowed Post Types.
	  	$unallowed_post_types = $this->get_unallowed_post_types();

	  	// Get Context.
	  	$context = bp_activity_get_current_context();

	  	// Get Actions By Context
		foreach ( bp_activity_get_actions() as $component_actions ) {
			foreach ( $component_actions as $component_action ) {
				if ( in_array( $context, (array) $component_action['context'], true ) || empty( $component_action['context'] ) ) {
					$context_actions[] = $component_action;
				}
			}
		}

		// Get Context Actions Keys
		$context_actions = wp_list_pluck( $context_actions, 'key' );

		foreach ( $context_actions as $action ) {
			if ( ! in_array( $action, $unallowed_post_types ) ) {
				$filter_actions[] = $action;
			}
		}

		$filter_actions = apply_filters( 'yz_wall_show_everything_filter_actions', $filter_actions );

	  	// Get Post Allowed Actions.
	  	return implode( ',' , $filter_actions );

	}

	/**
	 * Wall Filter Bar.
	 */
	function edit_wall_filter( $filters ) {

		// Unset Unwanted Filters.
		foreach ( $this->get_unallowed_post_types() as $filter ) {

			if ( isset( $filters[ $filter ] ) ) {
				unset( $filters[ $filter ] );
			}

			if ( $filter == 'friendship_accepted' ) {
				if ( isset( $filters['friendship_accepted,friendship_created'] ) ) {
					unset( $filters['friendship_accepted,friendship_created'] );
				}
			}

		}

		return $filters;
	}

	/**
	 * Get Wall Post Types Visibility.
	 */
	function get_unallowed_post_types() {

		$types = yz_option( 'yz_unallowed_activities' );

		if ( empty( $types ) ) {
			$types = array();
		}

		foreach ( array( 'group_details_updated', 'update_avatar', 'updated_profile', 'activity_comment' ) as $type ) {
			$types[] = $type;
		}

		return apply_filters( 'yz_wall_post_types_visibility', $types );
	}

	/**
	 * Enable/Disable Wall Posts Likes
	 */
	function set_likes_visibility() {
		// Get Likes Visibility
		return 'on' == yz_option( 'yz_enable_wall_posts_likes', 'on' ) ? true : false;
	}

	/**
	 * Enable/Disable Wall Posts Comments
	 */
	function set_comments_visibility() {
		// Get Comments Visibility
		return 'on' == yz_option( 'yz_enable_wall_posts_comments', 'on' ) ? true : false;
	}

	/**
	 * Enable/Disable Wall Posts Comments Reply
	 */
	function set_replies_visibility() {
		// Get Replies Visibility
		return 'on' == yz_option( 'yz_enable_wall_posts_reply', 'on' ) ? true : false;
	}

	/**
	 * Enable/Disable Wall Posts Delete Button
	 */
	function set_delete_visibility( $can_delete ) {

		// Get Delete Button Visibility
		if ( $can_delete && 'on' == yz_option( 'yz_enable_wall_posts_deletion', 'on' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Enable Wall Posts Embeds
	 */
	function enable_posts_embeds() {
		return 'on' == yz_option( 'yz_enable_wall_posts_embeds', 'on' ) ? true : false;
	}

	/**
	 * Enable Wall Comments Embeds
	 */
	function enable_comments_embeds() {
		return 'on' == yz_option( 'yz_enable_wall_comments_embeds', 'on' ) ? true : false;
	}
		
	/**
	 * Wall - Hide Private Users Posts
	 */
	function hide_private_users_posts( $where ) {

		// If Private Profile Not Allowed Show Default Query or is an admin show all activities.
	    if (  is_super_admin( bp_loggedin_user_id() ) || 'off' == yz_option( 'yz_allow_private_profiles', 'off' ) ) {
			return $where;
	    }

	    // Get List of Private Users.
	    $private_users = yz_get_private_user_profiles();

	    // Check if there's no private users.
	    if ( ! empty( $private_users ) ) {
		    // Add Where Statment.
		    $where['hide_private_users'] = 'a.user_id NOT IN(' . implode( ',', $private_users ) . ')';
	    }

	    return $where;
	}

	/** 
	 * Get Url Live Preview
	 */
	function get_live_url_preview() {

		include_once YZ_PUBLIC_CORE . "functions/live-preview/classes/LinkPreview.php";

		SetUp::init();

		$data = json_decode( urldecode( base64_decode( $_POST['data'] ) ) );

		$text = $data->text;
		$imageAmount = $data->imageAmount;
		$text = str_replace( '\n', ' ', $text );
		$header = "";

		$linkPreview = new LinkPreview();
		$answer = $linkPreview->crawl( $text, $imageAmount, $header );

		echo $answer;

		SetUp::finish();

		die();
	}

	/**
	 * Add Activity 
	 */
	function show_activity_tools_icon() {

		if ( ! apply_filters( 'yz_display_activity_tools', is_user_logged_in() ) ) {
			return;
		}
		
		?>

		<div class="yz-show-item-tools">
			<?php echo apply_filters( 'yz_activity_tools_icon', '<i class="fas fa-ellipsis-h"></i>' ); ?>
		</div>
		
		<?php

	}
}

$functions = new Youzer_Wall_Functions();