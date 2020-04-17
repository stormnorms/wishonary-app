<?php 
class WebinarSysteemUserPages {
	/**
	* Register new post tyoe for creating webinar user profile pages
	* 
	* @return
	*/
	static function init() {
		register_post_type('wpws_page', array(
      'labels' => array(
        'name' => __('WPWS Page', WebinarSysteem::$lang_slug) ,
        'singular_name' => __('WPWS Page', WebinarSysteem::$lang_slug)
      ),
      'public' => true,      
      'has_archive' => false,
      'show_ui' => false,
      'show_in_menu' => false,
      'rewrite' => false,
      'show_in_nav_menus' => false,
      'can_export' => false,
      'publicly_queryable' => true,
      'exclude_from_search' => true
    ));
	}
	
	/**
	* Create Default Unsubscribe page
	* 
	* @return
	*/  
	static function createUnSubscribePage() {
		remove_all_actions('pre_post_update');
        remove_all_actions('save_post');
        remove_all_actions('wp_insert_post');	
		$id = wp_insert_post(array(
		'post_status' => 'publish',
		'post_type' => 'wpws_page',
		'post_author' => 1,
		'post_content' => __('You are now unsubscribed', WebinarSysteem::$lang_slug),
		'post_title' => __('Webinar Subscription', WebinarSysteem::$lang_slug),
		'post_name' => 'webinar-unsubscribe'
		));
		
		flush_rewrite_rules();
		
		return ((int)$id > 0) ? (int)$id : false;
	}

	/**
	* Create Default Unsubscribe page
	* 
	* @return
	*/ 
	static function createWebinarOverviewPage() {
		remove_all_actions('pre_post_update');
    	remove_all_actions('save_post');
    	remove_all_actions('wp_insert_post');	
		$id = wp_insert_post(array(
		'post_status' => 'publish',
		'post_type' => 'wpws_page',
		'post_author' => 1,
		'post_content' => '[wpws_overview]',
		'post_title' => __('Webinar Overview', WebinarSysteem::$lang_slug),
		'post_name' => 'webinar-overview'
		));
		
		flush_rewrite_rules();
		
		return ((int)$id > 0) ? (int)$id : false;
	}

	/**
	* Unsubscribe an attendee from a webinae
	* 
	* @return
	*/
	static function userProfile() {
		if(isset($_GET['id']) && isset($_GET['action']) && isset($_GET['data'])){
			global $wpdb;
			$email = self::encrypt_decrypt( $_GET['data'], 'd' );
			if($_GET['action'] == 'unsubscribe' || $_GET['action'] == 'wpws-unsubscribe') {
				 $process = $wpdb->delete(WSWEB_DB_TABLE_PREFIX . 'subscribers', array('email' => ((string) $email), 'webinar_id' => ((int) $_GET['id'])));	
			}
		}
	}
	
	/**
	* Set page content for unsubscribe and overview links
	* @param undefined $page_content
	* 
	* @return
	*/
	static function setPageContent($page_content = '[wpws_unsubscribe]') {
		global $post;
		if ($post == null || $page_content == null) {
		    return null;
        }
			if(isset($_GET['action']) && ($_GET['action'] === 'unsubscribe' || $_GET['action'] === 'wpws-unsubscribe')) {
				$page_content = '[wpws_unsubscribe]';
				if(strpos($page_content, '[wpws_unsubscribe]') !== false) {
					$content = '';
					$content = '<p><strong>'.__('You are now unsubscribed', WebinarSysteem::$lang_slug).' </strong></p>';
					return str_replace('[wpws_unsubscribe]', trim($content), $page_content);
				} else {
					return $page_content;
				}
			}
			else if($post->post_name === 'webinar-overview') {
				$page_content = '[wpws_overview]';
				if(isset($_GET['action']) && ($_GET['action'] === 'overview' || $_GET['action'] === 'wpws-overview') && isset($_GET['data'])) {
				$email = self::encrypt_decrypt($_GET['data'], 'd');
				
				if(strpos($page_content, '[wpws_overview]') !== false) {
					$content = static::getOverviewContent($email);
					return str_replace('[wpws_overview]', trim($content), $page_content);
				} else {
					return $page_content;
				}	
				} else {
					if(strpos($page_content, '[wpws_overview]') !== false) {
					$content = '';
					$content = '<p><strong>'. __('To see which webinars you are registered to, please open the link \'manage profile\' from the registration confirmation email message', WebinarSysteem::$lang_slug).' </strong></p>';
					return str_replace('[wpws_overview]', trim($content), $page_content);
					}
				}
			} else {
				return $page_content;
			}
		
	}
	
	static function getOverviewContent($email='') {
		global $wpdb;
		$table = WSWEB_DB_TABLE_PREFIX.'subscribers';

		$webinar_data = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT id, webinar_id from {$table} where email=%s",
				$email
			)
		);

		$content = '';
		$content .= '<input id="subscriber_email" type="hidden" value="'.$email.'"/>';
		$content .= '<table>';
		$content .= '<tr>';
		$content .= '<th>'. __('Webinar Title',  WebinarSysteem::$lang_slug) .'</th>';
		$content .= '<th>'. __('Webinar Time',  WebinarSysteem::$lang_slug) .'</th>';
		$content .= '<th>'. __('Webinar Action',  WebinarSysteem::$lang_slug) .'</th>';
		$content .= '</tr>';
		if(!empty($webinar_data)) {
		foreach($webinar_data as $data) {
			$wb_timezone=get_post_meta($data->webinar_id, '_wswebinar_timezoneidentifier', true);
	    	$wp_date_format = WebinarSysteem::get_wp_datetime_formats(WebinarSysteem::$WP_DATE_FORMAT);
	    	$wp_time_format = WebinarSysteem::get_wp_datetime_formats(WebinarSysteem::$WP_TIME_FORMAT);
	    	
	    	if (empty($wb_timezone)) {
                $timezone_string = get_option('timezone_string');
                $wpoffset=get_option('gmt_offset');
                $gmt_offset= WebinarSysteemDateTime::format_timezone( ( $wpoffset > 0) ? '+'.$wpoffset : $wpoffset );
                $wb_timezone = (!empty($timezone_string)) ? $timezone_string : 'UTC'.$gmt_offset.'';
        	}
        
			if (WebinarSysteem::is_recurring_webinar($data->webinar_id)) {
                $attendee = WebinarSysteemAttendees::get_attendee_by_email($email, $data->webinar_id);
                $time = $attendee->exact_time;
                $wb_time = date($wp_time_format, strtotime($time));
                $wb_date = date($wp_date_format, strtotime($time));
	    	} else {
                $data_hour = get_post_meta($data->webinar_id, '_wswebinar_gener_hour', true);
                $data_min = get_post_meta($data->webinar_id, '_wswebinar_gener_min', true);
                $wb_time = date($wp_time_format, strtotime($data_hour . ':' . $data_min));
                $gener_date = get_post_meta($data->webinar_id, '_wswebinar_gener_date', true);
                $wb_date = date($wp_date_format, strtotime($gener_date));
	    	}
			
			$content .= '<tr id="data_'.$data->webinar_id.'">';
			$content .= '<td>'.get_the_title($data->webinar_id).'</td>';
			$content .= '<td>'.$wb_date.'&nbsp;'.$wb_time.'&nbsp;'.$wb_timezone.'</td>';
			$content .= '<td><button id="'.$data->webinar_id.'" class="webinar-delete">'.__('Unsubscribe', WebinarSysteem::$lang_slug ).'</button></td>';
			$content .= '</tr>';
		}	
		} else {
			$content .= '<tr><td colspan="3" style="text-align:center;">'.__('You haven\'t subscribed to any webinars yet:(', WebinarSysteem::$lang_slug).'</td></tr>';
		}
		
		$content .= '</table>';
		
		return $content;
	}
	
	/*function setWindowTitle( $title, $separator, $separator_location = 'right') {
		$title_parts = explode(" $separator ", $title);
		if($separator_location === 'right') {
      	// first part
      	$title_parts[0] = $this->setPageTitle($title_parts[0]);
    	} else {
      	// last part
      	$last_index = count($title_parts) - 1;
      	$title_parts[$last_index] = $this->setPageTitle($title_parts[$last_index]);
    	}
    return implode(" $separator ", $title_parts);
	}
	
	function setPageTitle($page_title = '') {
		global $post;
	}*/
	
	/**
	* Encrypt or decrypt the private data
	* @param undefined $string
	* @param undefined $action
	* 
	* @return
	*/
	static function encrypt_decrypt($string, $action ='e') {
		$secret_key = 'my_simple_secret_key';
    	$secret_iv = 'my_simple_secret_iv';
 
    	$output = false;
    	$encrypt_method = "AES-256-CBC";
    	$key = hash( 'sha256', $secret_key );
    	$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    	if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    	}
    	else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    	}
 
    return $output;
	}
	
	static function get_email_management_url($email) {
		$data = array();
		$encrypted = self::encrypt_decrypt($email, 'e');
		$data['data'] = $encrypted;
		$post = get_option('_wswebinar_overview');
		return self::getSubscriptionUrl($post, 'wpws-overview', $data);
	}
	
	static function get_unsubscribe_url($wbnid, $email) {
		$encrypted = self::encrypt_decrypt($email, 'e');
		$data = array(
		'id'=>$wbnid,
		'data'=>$encrypted
		);
		$post = get_option('_wswebinar_unsubscribe');
		return self::getSubscriptionUrl($post, 'wpws-unsubscribe', $data);
	}
	
	static function getSubscriptionUrl($post=null, $action=null, $data) {
		$url = get_permalink($post);
		if($action=='wpws-unsubscribe'){
			$params = array(
			'action='.$action,
			'id='.$data['id'],
			'data='.$data['data']
			);
		}
		else if($action=='wpws-overview') {
			$params = array(
			'action='.$action,
			'data='.$data['data']
			);
		}
		if(!empty($data)) {
			
		$url .= (parse_url($url,PHP_URL_QUERY) ? '&' : '?').join('&', $params);
		}
		return $url;
	}
	
	static function getWPWSPages() {
    return get_posts(array(
      'name' => 'webinar-unsubscribe',
      'post_type' => 'wpws_page'
    ));
	}	
	
	static function getAllPages(){
		$all_pages = array_merge(
			static::getWPWSPages(),
			get_pages()
		);
		
		$pages = array();
		foreach($all_pages as $page) {
			$pages[] = static::getPageData($page);
		}
		return $pages;
	}
	
	static function getPageData($page) {
		return array(
		'id' => $page->ID,
		'title' => $page->post_title
		);
	}
	
	/**
	* Unsubscribe attendee on Overview page using AJAX function
	* 
	* @return
	*/
	static function unSubscribeAttendee() {
		$return = array('error' => FALSE);
		if( !isset($_POST['wbnId']) || empty($_POST['wbnId']) ){
			$return['error'] = TRUE;
		} else {
			global $wpdb;
			$wbnId = $_POST['wbnId'];
			$email = $_POST['email'];
			$process = $wpdb->delete(WSWEB_DB_TABLE_PREFIX . 'subscribers', array('email' => ((string) $email), 'webinar_id' => ((int) $wbnId)));	
			if(!$process){
				$return['error'] = TRUE;
			}
		}
		echo json_encode($return);
		wp_die();
	}
}
?>