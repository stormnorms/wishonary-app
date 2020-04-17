<?php

/**
 * This template displays the ACADP listings in map view.
 *
 * @link    https://pluginsware.com
 * @since   1.0.0
 *
 * @package Advanced_Classifieds_And_Directory_Pro
 */
?>

<div class="acadp acadp-listings acadp-map-view">
	<?php if ( $can_show_header ) : ?>
		<!-- header here -->
        <?php if ( ! empty( $pre_content ) ) echo '<p>' . wp_kses_post( $pre_content ) . '</p>'; ?>
        
    	<div class="row acadp-no-margin">
        	<?php if ( $can_show_listings_count ) : ?>
    			<!-- total items count -->
    			<div class="pull-left text-muted">
    				<?php 
					$count = ( is_front_page() && is_home() ) ? $acadp_query->post_count : $acadp_query->found_posts;
					printf( esc_html__( "%d item(s) found", 'advanced-classifieds-and-directory-pro' ), $count );
					?>
				</div>
            <?php endif; ?>
        
    		<div class="btn-toolbar pull-right" role="toolbar">
            	<?php if ( $can_show_views_selector ) : ?> 
      				<!-- Views dropdown -->
      				<div class="btn-group" role="group">
                    	<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    						<?php esc_html_e( "View as", 'advanced-classifieds-and-directory-pro' ); ?> <span class="caret"></span>
  						</button>
                        <ul class="dropdown-menu">
                        	<?php
							$views = acadp_get_listings_view_options();
							
							foreach ( $views as $value => $label ) {
								$active_class = ( 'map' == $value ) ? ' active' : '';							
								printf( '<li class="acadp-no-margin%s"><a href="%s">%s</a></li>', $active_class, esc_url( add_query_arg( 'view', $value ) ), esc_html( $label ) );
							}
							?>
                        </ul>
       				</div>
                <?php endif; ?>
        
        		<?php if ( $can_show_orderby_dropdown ) : ?> 
       				<!-- Orderby dropdown -->
       				<div class="btn-group" role="group">
  						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    						<?php esc_html_e( "Sort by", 'advanced-classifieds-and-directory-pro' ); ?> <span class="caret"></span>
  						</button>
  						<ul class="dropdown-menu">
            				<?php
							$options = acadp_get_listings_orderby_options();
			
							foreach ( $options as $value => $label ) {
								$active_class = ( $value == $current_order ) ? ' active' : '';							
								printf( '<li class="acadp-no-margin%s"><a href="%s">%s</a></li>', $active_class, esc_url( add_query_arg( 'sort', $value ) ), esc_html( $label ) );
							}
							?>
  						</ul>
					</div>
                <?php endif; ?>
    		</div>
		</div>
    <?php endif; ?>
    
	<div class="acadp-divider"></div>
    
	<!-- the loop -->
    <div class="acadp-body acadp-map embed-responsive embed-responsive-16by9 acadp-margin-bottom" data-type="markerclusterer"> 
		<?php 
		while ( $acadp_query->have_posts() ) : 
			$acadp_query->the_post(); 
			$post_meta = get_post_meta( $post->ID ); 
			?>
    
    		<?php if ( ! empty( $post_meta['latitude'][0] ) && ! empty( $post_meta['longitude'][0] ) ) : ?>
        		<div class="marker" data-latitude="<?php echo esc_attr( $post_meta['latitude'][0] ); ?>" data-longitude="<?php echo esc_attr( $post_meta['longitude'][0] ); ?>">
            		<div <?php the_acadp_listing_entry_class( $post_meta, 'media' ); ?>>
                		<?php if ( $can_show_images ) : ?>
                        	<div class="media-left">
                				<a href="<?php the_permalink(); ?>"><?php the_acadp_listing_thumbnail( $post_meta ); ?></a> 
                            </div>     	
            			<?php endif; ?>
            
            			<div class="media-body">
                    		<div class="acadp-listings-title-block">
                    			<h3 class="acadp-no-margin"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            	<?php the_acadp_listing_labels( $post_meta ); ?>
                        	</div>
                        
                        	<?php
							$info = array();					
	
							if ( $can_show_date ) {
								$info[] = sprintf( esc_html__( 'Posted %s ago', 'advanced-classifieds-and-directory-pro' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
							}
						
							if ( $can_show_user ) {			
								$info[] = '<a href="' . esc_url( acadp_get_user_page_link( $post->post_author ) ) . '">' . get_the_author() . '</a>';
							}

							echo '<p class="acadp-no-margin"><small class="text-muted">' . implode( ' ' . esc_html__( "by", 'advanced-classifieds-and-directory-pro' ) . ' ', $info ) . '</small></p>';
							?>
                        	
                            <?php if ( ! empty( $listings_settings['excerpt_length'] ) && ! empty( $post->post_content ) ) : ?>
                                <p class="acadp-listings-desc"><?php echo wp_trim_words( $post->post_content, $listings_settings['excerpt_length'], '...' ); ?></p>
                            <?php endif; ?>
                        
                        	<?php
							$info = array();					
	
							if ( $can_show_category && $categories = wp_get_object_terms( $post->ID, 'acadp_categories' ) ) {
								$category_links = array();
								foreach ( $categories as $category ) {						
									$category_links[] = sprintf( '<a href="%s">%s</a>', esc_url( acadp_get_category_page_link( $category ) ), esc_html( $category->name ) );						
								}
								$info[] = sprintf( '<span class="glyphicon glyphicon-briefcase"></span>&nbsp;%s', implode( ', ', $category_links ) );
							}
				
							if ( $can_show_location && $location = wp_get_object_terms( $post->ID, 'acadp_locations' ) ) {
								$info[] = '<span class="glyphicon glyphicon-map-marker"></span>&nbsp;<a href="' . esc_url( acadp_get_location_page_link( $location[0] ) ) . '">' . esc_html( $location[0]->name ) . '</a>';
							}
						
							if ( 'acadp_favourite_listings' == $shortcode ) {
								$info[] = '<a href="' . esc_url( acadp_get_remove_favourites_page_link( $post->ID ) ) . '">' . esc_html__( 'Remove from favourites', 'advanced-classifieds-and-directory-pro' ) . '</a>';
							}
				
							if ( $can_show_views && ! empty( $post_meta['views'][0] ) ) {
								$info[] = sprintf( esc_html__( "%d views", 'advanced-classifieds-and-directory-pro' ), $post_meta['views'][0] );
							}

							echo '<p class="acadp-no-margin"><small>' . implode( ' / ', $info ) . '</small></p>';

							if ( $can_show_price && isset( $post_meta['price'] ) && $post_meta['price'][0] > 0 ) {
								$price = acadp_format_amount( $post_meta['price'][0] );						
								echo '<p class="lead acadp-listings-price">' . esc_html( acadp_currency_filter( $price ) ) . '</p>';
							}            		
                			?>
                            
                            <?php do_action( 'acadp_after_listing_content', $post->ID, 'map' ); ?>
                    	</div>
                	</div>
            	</div>
        	<?php endif; ?> 
               
  		<?php endwhile; ?>
    </div>
    <!-- end of the loop -->
    
    <!-- Use reset postdata to restore orginal query -->
    <?php wp_reset_postdata(); ?>
    
    <!-- pagination here -->
    <?php if ( $can_show_pagination ) the_acadp_pagination( $acadp_query->max_num_pages, "", $paged ); ?>
</div>

<?php the_acadp_social_sharing_buttons();