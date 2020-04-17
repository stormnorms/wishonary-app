<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GeoDirectory Search widget.
 *
 * @since 1.0.0
 */
class GeoDir_Widget_Recently_Viewed extends WP_Super_Duper {

	public function __construct() {

		$options = array(
			'textdomain'    => GEODIRECTORY_TEXTDOMAIN,
			'block-icon'    => 'admin-site',
			'block-category'=> 'widgets',
			'block-keywords'=> "['Recently Viewed','geodir']",
			'class_name'    => __CLASS__,
			'base_id'       => 'gd_recently_viewed',
			'name'          => __('GD > Recently Viewed','geodirectory'), // the name of the widget.
			'widget_ops'    => array(
				'classname'   => 'geodir-recently-viewed', // widget class
				'description' => esc_html__('Shows the GeoDirectory Most Recently Viewed Listings.','geodirectory'),
				'geodirectory' => true,
			),
		);

		parent::__construct( $options );

		add_action('wp_footer', array( $this, 'geodir_recently_viewed_posts' ));

	}

	/**
	 * Set the arguments later.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function set_arguments(){

		$widget_args = array();

		$widget_args['title'] = array(
			'title' => __('Title:', 'geodirectory'),
			'desc' => __('The Recently Viewed widget title.', 'geodirectory'),
			'type' => 'text',
			'placeholder' => __( 'Recently Viewed', 'geodirectory' ),
			'default'  => '',
			'desc_tip' => true,
			'advanced' => false,
		);

		$widget_args['post_limit'] = array(
			'title' => __('Posts to show:', 'geodirectory'),
			'desc' => __('The number of posts to show by default. (max 50)', 'geodirectory'),
			'type' => 'number',
			'default'  => '5',
			'desc_tip' => true,
			'advanced' => true
		);

		$widget_args['layout'] = array(
			'title' => __('Layout:', 'geodirectory'),
			'desc' => __('How the listings should laid out by default.', 'geodirectory'),
			'type' => 'select',
			'options'   =>  array(
				"gridview_onehalf"        =>  __('Grid View (Two Columns)', 'geodirectory'),
				"gridview_onethird"        =>  __('Grid View (Three Columns)', 'geodirectory'),
				"gridview_onefourth"        =>  __('Grid View (Four Columns)', 'geodirectory'),
				"gridview_onefifth"        =>  __('Grid View (Five Columns)', 'geodirectory'),
				"list"        =>  __('List view', 'geodirectory'),
			),
			'default'  => 'h3',
			'desc_tip' => true,
			'advanced' => true
		);

		$get_posts = geodir_get_posttypes('options-plural');

		$widget_args['post_type'] = array(
			'title' => __('Post Type:', 'geodirectory'),
			'desc' => __('The custom post types to show. Only used when there are multiple CPTs.', 'geodirectory'),
			'type' => 'select',
			'options'   =>  $get_posts,
			'default'  => '',
			'desc_tip' => true,
			'advanced' => true
		);

		$widget_args['enqueue_slider']  = array(
			'title' => __('Enqueue Slider Script:', 'geodirectory'),
			'desc' => __('This is only needed if your archive items are using a image slider.', 'geodirectory'),
			'type' => 'checkbox',
			'desc_tip' => true,
			'value'  => '1',
			'default'  => 0,
			'advanced' => true
		);

		return $widget_args;
	}

	/**
	 * Outputs the map widget on the front-end.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args
	 * @param array $widget_args
	 * @param string $content
	 *
	 * @return mixed|string
	 */
	public function output($args = array(), $widget_args = array(),$content = ''){
		global $geodir_recently_viewed_count;
		// if block demo return empty to show placeholder text
		if($this->is_block_content_call()){
			return '';
		}

		if(empty($geodir_recently_viewed_count)){
			$geodir_recently_viewed_count = 1;
		}else{
			$geodir_recently_viewed_count++;
		}

		$post_page_limit = !empty( $args['post_limit'] ) ? $args['post_limit'] : '5';
		$layout = !empty( $args['layout'] ) ? $args['layout'] : 'list';
		$post_type = !empty( $args['post_type'] ) ? $args['post_type'] : 'all_post';
		$enqueue_slider = !empty( $args['enqueue_slider'] ) ? true : false;

		ob_start();

		if($enqueue_slider ){
			// enqueue flexslider JS
			GeoDir_Frontend_Scripts::enqueue_script( 'jquery-flexslider' );
		}
		?>
		<div class="geodir-recently-reviewed">
			<div class="recently-reviewed-content recently-reviewed-content-<?php echo absint($geodir_recently_viewed_count); ?>"></div>
			<div class="recently-reviewed-loader" style="display: none;text-align: center;"><i class="fas fa-sync fa-spin fa-2x"></i></div>
		</div>

		<script type="text/javascript">
			jQuery( document ).ready(function() {
				if(!geodir_is_localstorage()){return;}
				jQuery('.recently-reviewed-loader').show();

				var recently_viewed = localStorage.getItem("gd_recently_viewed");
				var data = {
					'action': 'geodir_recently_viewed_listings',
					'viewed_post_id' : recently_viewed,
					'list_per_page' :'<?php echo $post_page_limit; ?>' ,
					'layout' : '<?php echo $layout; ?>',
					'post_type':'<?php echo $post_type; ?>'
				};

				jQuery.post(geodir_params.ajax_url, data, function(response) {
					jQuery('.geodir-recently-reviewed .recently-reviewed-content-<?php echo absint($geodir_recently_viewed_count); ?>').html(response);
					jQuery('.recently-reviewed-loader').hide();
					init_read_more();
					geodir_init_lazy_load();
					geodir_refresh_business_hours();
					// init any sliders
					geodir_init_flexslider();

				});
			});
		</script>

		<?php
		return ob_get_clean();
	}

	/**
	 * Added reviewed posts on local storage.
	 *
	 * Check if is_single page then added reviewed on local storage.
	 *
	 * @since 2.0.0
	 */
	public function geodir_recently_viewed_posts() {

		if( is_single() ){

			$get_post_id = get_the_ID();
			$get_post_type = get_post_type($get_post_id);
			$gd_post_types = geodir_get_posttypes();

			if( !empty( $get_post_type ) && in_array( $get_post_type,$gd_post_types )) {
				?>
				<script type="text/javascript">
					jQuery( document ).ready(function($) {

						if(!geodir_is_localstorage()){return;}

						function gdrv_is_not_empty(obj) {
							for(var key in obj) {
								if(obj.hasOwnProperty(key))
									return true;
							}
							return false;
						}

						//localStorage.removeItem("gd_recently_viewed");

						var post_id = '<?php echo $get_post_id; ?>',
							post_type = '<?php echo $get_post_type; ?>',
							reviewed_arr = {},
							recently_reviewed = JSON.parse(localStorage.getItem('gd_recently_viewed'));

						if( null != recently_reviewed ) {

							if(gdrv_is_not_empty(recently_reviewed)) {

								if ( post_type in recently_reviewed ) {

									var temp_post_arr = [];

									if( recently_reviewed[post_type].length > 0 ) {
										temp_post_arr = recently_reviewed[post_type];
									}

									if(jQuery.inArray(post_id, temp_post_arr) === -1) {
										temp_post_arr.push(post_id);
									}

									// limit to 50 per CPT
									if(temp_post_arr.length > 50){
										temp_post_arr = temp_post_arr.slice(-50);
									}

									recently_reviewed[post_type] = temp_post_arr;

								} else{
									recently_reviewed[post_type] = [post_id];
								}

							} else{
								recently_reviewed[post_type] = [post_id];
							}

							localStorage.setItem("gd_recently_viewed", JSON.stringify(recently_reviewed));

						} else{
							reviewed_arr[post_type] = [post_id];
							localStorage.setItem("gd_recently_viewed", JSON.stringify(reviewed_arr));
						}
					});
				</script>
				<?php
			}

		}

	}
}