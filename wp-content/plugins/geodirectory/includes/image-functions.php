<?php
/**
 * Post image functions.
 *
 * @since 2.0.0
 * @package GeoDirectory
 */

/**
 * Function for replace images tag src and class values.
 *
 * Check if $lazy_load is true then replace image tag class value
 * else replace only image src value.
 *
 * @since 2.0.0
 *
 * @param string $img_tag Image tag html.
 * @param bool $lazy_load Optional. Default true.
 * @return string $img_tag.
 */
function geodir_image_tag_ajaxify($img_tag,$lazy_load = true){

    
    $strip = array("src=","srcset=");
    $replace = array("src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAABCAQAAACC0sM2AAAADklEQVR42mP8X88wLAAAK5IBgMYCdqgAAAAASUVORK5CYII=' data-src=","data-srcset=");
    if($lazy_load){
        $strip[] = 'class="';
        $replace[] = 'class="geodir-lazy-load ';
    }
    $img_tag = str_replace($strip,$replace,$img_tag);

    return $img_tag;
}

/**
 * Function for get image src path by image object.
 *
 * @since 2.0.0
 *
 * @param object $image image object.
 * @param string $size Optional. Set image size. Default medium.
 * @return string $img_src Image path.
 */
function geodir_get_image_src($image, $size = 'medium'){
    $img_src = '';

    $meta = isset($image->metadata) ? maybe_unserialize($image->metadata) : '';
    $upload_dir = wp_upload_dir();
    if(isset($meta['sizes']) && $size){
        $img_url_basename = wp_basename($upload_dir['baseurl'].$image->file);
        if($img_url_basename && isset($meta['sizes'][$size]) && isset($meta['sizes'][$size]['file']) && $meta['sizes'][$size]['file']){
            $img_src = str_replace($img_url_basename, wp_basename($meta['sizes'][$size]['file']), $upload_dir['baseurl'].$image->file);
        }
    }

    // no sizes just return full size
    if(!$img_src){
        if(isset($image->file)){
	        if(substr( $image->file, 0, 4 ) === "http"){
		        $img_src = esc_url_raw( $image->file );
	        }else{
		        $img_src = $upload_dir['baseurl'].$image->file;
	        }
        }
    }

    return $img_src;
}

/**
 * Get the image tag.
 *
 * @since 2.0.0
 *
 * @param object $image Image data.
 * @param string $size Optional. Get the image size. Default medium.
 * @param string $align Optional. get the image alignment value. Default null.
 * @return string $html Image tag.
 */
function geodir_get_image_tag( $image, $size = 'medium',$align = '' ) {

    $meta = isset($image->metadata) ? maybe_unserialize($image->metadata) : '';
    $img_src = geodir_get_image_src($image, $size);
	$width = '';
	$height = '';
	if($size){
		$width = isset($meta['sizes'][$size]['width']) ? $meta['sizes'][$size]['width'] : '';
		$height = isset($meta['sizes'][$size]['height']) ? $meta['sizes'][$size]['height'] : '';
	}
    if(!$width){$width = isset($meta['width']) ? $meta['width'] : '';}
	if(!$height){$height = isset($meta['height']) ? $meta['height'] : '';}
    $hwstring = image_hwstring($width, $height);

    $id = isset($image->ID) ? esc_attr( $image->ID ) : 0;
    $title = isset( $image->title ) && $image->title ? 'title="' .  esc_attr( wp_strip_all_tags( $image->title ) ) . '" ' : '';
    $alt = isset( $image->caption ) && $image->caption ? esc_attr( wp_strip_all_tags($image->caption ) ) : 'image-'.$id;
    $class = 'align' . esc_attr($align) .' size-' . esc_attr($size) . ' geodir-image-' . $id;

    /**
     * Filters the value of the attachment's image tag class attribute.
     *
     * @since 2.0.0
     *
     * @param string       $class CSS class name or space-separated list of classes.
     * @param int          $id    Attachment ID.
     * @param string       $align Part of the class name for aligning the image.
     * @param string|array $size  Size of image. Image size or array of width and height values (in that order).
     *                            Default 'medium'.
     */
    $class = apply_filters( 'geodir_get_image_tag_class', $class, $id, $align, $size );

    $html = '<img src="' . esc_attr($img_src) . '" alt="' . esc_attr($alt) . '" ' . $title . $hwstring . 'class="' . $class . '" />';

    /**
     * Filters the HTML content for the image tag.
     *
     * @since 2.0.0
     *
     * @param string       $html  HTML content for the image.
     * @param int          $id    Attachment ID.
     * @param string       $alt   Alternate text.
     * @param string       $title Attachment title.
     * @param string       $align Part of the class name for aligning the image.
     * @param string|array $size  Size of image. Image size or array of width and height values (in that order).
     *                            Default 'medium'.
     */
    return apply_filters( 'geodir_get_image_tag', $html, $id, $alt, $title, $align, $size );
}

function geodir_get_field_screenshot($field,$sizes = array('w'=>825,'h'=>430)){
	global $gd_post;
	$url = '';
	$width = isset($sizes['w']) ? absint($sizes['w']) : 825;
	$height = isset($sizes['h']) ? absint($sizes['h']) : 430;

	if(isset($gd_post->{$field}) && esc_url($gd_post->{$field})){
		$url = "https://wordpress.com/mshots/v1/".esc_url($gd_post->{$field})."?w=$width&h=$height";
	}
	
	return $url;
}


/**
 * Gets the post images.
 *
 * @since 1.0.0
 * @package GeoDirectory
 * @global object $wpdb WordPress Database object.
 * @param int $post_id The post ID.
 * @param string $img_size Optional. Thumbnail size.
 * @param bool $no_images Optional. Do you want to return the default image when no image is available? Default: false.
 * @param bool $add_featured Optional. Do you want to include featured images too? Default: true.
 * @param int|string $limit Optional. Number of images.
 * @return array|bool Returns images as an array. Each item is an object.
 */
function geodir_get_images( $post_id = 0, $limit = '', $logo = false, $revision_id = '', $types = array() , $fallback_types = array('logo','cat_default','cpt_default','listing_default',',website_screenshot') ){
    global $gd_post;

    $post_images = array();

	if ( ! empty( $types ) ) {
		$original_types = $types;

		// check for URL screenshots
		$has_screenshots = false;
		if(!empty($types)){
			foreach($types as $key => $val){
				if(stripos(strrev($val), "tohsneercs_") === 0){
					$field = str_replace("_screenshot","",$val);
					if(isset($gd_post->{$field}) && esc_url($gd_post->{$field})){
						$has_screenshots = true;
					}else{
						unset($types[$key]); // unset if an invalid screenshot type
					}
				}
			}
		}


		
		$types = geodir_post_has_image_types( $types, $post_id, $revision_id );
		if ( ! empty( $types ) ) {
			if($has_screenshots){

				foreach($types as $type){

					if($limit && count($post_images) >= $limit ){
						break;
					}

					$new_images = array();
					if(stripos(strrev($type), "tohsneercs_") === 0){
						$field = str_replace("_screenshot","",$type);
						if(isset($gd_post->{$field}) && esc_url($gd_post->{$field})){
							$image_src = geodir_get_field_screenshot($field);
							if($image_src){
								$image = new stdClass();
								$image->ID = 0;
								$image->post_id = $post_id;
								$image->user_id = 0;
								$image->title = sprintf( __('%s screenshot', 'geodirectory'), esc_attr($field) );
								$image->caption = '';
								$image->file = ltrim( $image_src, '/\\' );
								$image->mime_type = '';
								$image->menu_order = 0;
								$image->featured= 0;
								$image->is_approved = 1;
								$image->metadata = '';
								$image->type = esc_attr($field).'_screenshot';
								$new_images[] = $image;
							}
						}
					}else{
						$new_images = GeoDir_Media::get_attachments_by_type( $post_id, $type, $limit, $revision_id );
					}

					if(!empty($new_images)){
						foreach($new_images as $new_image){
							if($limit && count($post_images) >= $limit ){
								break;
							}
							array_push($post_images, $new_image);
						}
					}
				}

			}else{
				$post_images = GeoDir_Media::get_attachments_by_type( $post_id, $types, $limit, $revision_id );
			}
		}
    } else {
        $post_images = GeoDir_Media::get_post_images( $post_id, $limit, $revision_id );
    }

    if ( ! empty( $post_images ) ) {
        // wp_image_add_srcset_and_sizes( $image, $image_meta, $attachment_id );
        if ( $logo && geodir_post_has_image_types( 'logo', $post_id, $revision_id ) ) {
            $logo_image = GeoDir_Media::get_attachments_by_type( $post_id, 'logo', 1, $revision_id );
            if ( $logo_image ) {
                $post_images = $logo_image + $post_images;
            }
        }
    } elseif(!empty($fallback_types)) {

	    $fallback_image = new stdClass();

	    // fallback images
	    foreach($fallback_types as $fallback_type){
		    $default_img_id = 0;
		    //logo
			if ( $fallback_type == 'logo' && isset( $gd_post->logo ) && $gd_post->logo && geodir_post_has_image_types( 'logo', $post_id ) ) {
				$logo_image = GeoDir_Media::get_attachments_by_type( $post_id, 'logo', 1 );
				if ( $logo_image ) {
					$post_images = $logo_image;
					break;
				}
			}elseif($fallback_type == 'cat_default'){
			    $term_img = 0;
			    // cat image
			    if ( geodir_is_page('archive' ) ) {
				    if ( $term_id = get_queried_object_id() ) {
					    $term_img = get_term_meta( $term_id, 'ct_cat_default_img', true );
				    }
			    }

			    if ( empty( $term_img ) ) {
				    $default_term_id = geodir_get_post_meta( $post_id, 'default_category' );
				    if ( $default_term_id ) {
					    $term_img = get_term_meta( $default_term_id, 'ct_cat_default_img', true );
				    }
			    }

			    if ( ! empty( $term_img ) ) {
				    $default_img_id = $term_img['id'];

				    if ( $default_img_id == 'image' && ! empty( $term_img['src'] ) ) {
					    $image_src = geodir_file_relative_url( $term_img['src'], false );
					    $post_images = array();
					    $image = new stdClass();
					    $image->ID = 0;
					    $image->post_id = $post_id;
					    $image->user_id = 0;
					    $image->title = __( 'Placeholder image', 'geodirectory' );
					    $image->caption = '';
					    $image->file = '/' . ltrim( $image_src, '/\\' );
					    $image->mime_type = '';
					    $image->menu_order = 0;
					    $image->featured= 0;
					    $image->is_approved = 1;
					    $image->metadata = '';
					    $image->type = 'post_images';
					    $post_images[] = $image;
					    break;
				    }
			    }

		    }elseif($fallback_type == 'cpt_default'){
				// check for CPT default image
			    $cpt = geodir_get_current_posttype();
			    if ( $cpt ) {
				    $cpts = geodir_get_posttypes('array');
				    if ( ! empty( $cpts[$cpt]['default_image'] ) ) {
					    $default_img_id = absint( $cpts[$cpt]['default_image'] );
				    }
			    }
		    }elseif($fallback_type == 'listing_default'){
			    $listing_default_image_id = geodir_get_option( 'listing_default_image' );
			    if ( $listing_default_image_id ) {
				    $default_img_id = absint($listing_default_image_id);
			    }
		    }elseif(is_int($fallback_type)){
			    $default_img_id = absint($fallback_type);
		    }elseif(stripos(strrev($fallback_type), "tohsneercs_") === 0){ // screenshots

			    $field = str_replace("_screenshot","",$fallback_type);
				if(isset($gd_post->{$field}) && esc_url($gd_post->{$field})){
					$image_src = geodir_get_field_screenshot($field);
					if($image_src){
						$image = new stdClass();
						$image->ID = 0;
						$image->post_id = $post_id;
						$image->user_id = 0;
						$image->title = __( 'Placeholder image', 'geodirectory' );
						$image->caption = '';
						$image->file = ltrim( $image_src, '/\\' );
						$image->mime_type = '';
						$image->menu_order = 0;
						$image->featured= 0;
						$image->is_approved = 1;
						$image->metadata = '';
						$image->type = esc_attr($field).'_screenshot';
						$post_images[] = $image;
						break;
					}
				}
		    }



		    // default image
		    if ( $default_img_id ) {
			    $default_image_post = get_post( $default_img_id );

			    if ( $default_image_post ) {
				    $wp_upload_dir = wp_upload_dir();

				    $post_images = array();
				    $image = new stdClass();
				    $image->ID = 0;
				    $image->post_id = $default_image_post->ID;
				    $image->user_id = 0;
				    $image->title = !empty($default_image_post->post_title) ? $default_image_post->post_title : __( 'Placeholder image', 'geodirectory' );
				    $image->caption = !empty($default_image_post->post_excerpt) ? $default_image_post->post_excerpt : '';
				    $image->file = str_replace( $wp_upload_dir['basedir'], '', get_attached_file( $default_img_id ) );
				    $image->mime_type = $default_image_post->post_mime_type;
				    $image->menu_order = 0;
				    $image->featured = 0;
				    $image->is_approved = 1;
				    $image->metadata= wp_get_attachment_metadata( $default_img_id );
				    $image->type = 'post_images';
				    $post_images[] = $image;
				    break;
			    }
		    }

	    }

    }

    return $post_images;
}

/**
 * Check font awesome icon or not.
 *
 * @param string $icon Font awesome icon.
 * @return bool True if font awesome icon.
 */
function geodir_is_fa_icon( $icon ) {
	$return = false;
	if ( $icon != '' ) {
		$fa_icon = trim( $icon );
		if ( strpos( $fa_icon, 'fa fa-' ) === 0 || strpos( $fa_icon, 'fas fa-' ) === 0 || strpos( $fa_icon, 'far fa-' ) === 0 || strpos( $fa_icon, 'fab fa-' ) === 0 || strpos( $fa_icon, 'fa-' ) === 0 ) {
			$return = true;
		}
	}
	return apply_filters( 'geodir_is_fa_icon', $return, $icon  );
}

/**
 * Check icon url.
 *
 * @param string $icon Icon url.
 * @return bool True if icon url.
 */
function geodir_is_icon_url( $icon ) {
	$return = false;
	if ( $icon != '' ) {
		$icon = trim( $icon );
		if ( strpos( $icon, 'http://' ) === 0 || strpos( $icon, 'https://' ) === 0 ) {
			$return = true;
		}
	}
	return apply_filters( 'geodir_is_icon_url', $return, $icon  );
}

/**
 * Validate post image types.
 *
 * $since 2.0.0.65
 *
 * @param array $types Array of image types. Ex: logo, comment_images, post_images.
 * @param int $post_id Post ID.
 * @param int $revision_id Post revision ID. Default 0.
 * @return array Array of valid image types.
 */
function geodir_post_has_image_types( $types = array(), $post_id, $revision_id = 0 ) {
	if ( ! empty( $types ) ) {
		if ( is_scalar( $types ) ) {
			$image_types = array_map( 'trim', explode( ",", $types ) );
		} else {
			$image_types = $types;
		}
		$image_types = array_filter( array_unique( $image_types ) );

		if ( ! empty( $image_types ) ) {
			$post_type = get_post_type( $post_id );
			$package_id = geodir_get_post_package_id( $post_id, $post_type );

			$valid_types = array();
			foreach ( $image_types as $type ) {
				if ( in_array( $type, array( 'post_images', 'comment_images' ) ) ) {
					$valid_types[] = $type;
				} elseif(stripos(strrev($type), "tohsneercs_") === 0){
					$valid_types[] = $type;
				}elseif ( geodir_check_field_visibility( $package_id, $type, $post_type ) ) {
					$valid_types[] = $type;
				}
			}
			$image_types = $valid_types;
		}
	} else {
		$image_types = array();
	}

	return apply_filters( 'geodir_post_has_image_types', $image_types, $types, $post_id, $revision_id  );
}