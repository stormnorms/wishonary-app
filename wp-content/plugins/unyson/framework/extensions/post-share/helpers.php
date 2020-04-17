<?php

if ( !defined( 'FW' ) ) {
    return;
}

/**
 * Generate html markup for social networks share buttons.
 *
 * @param $style string Style of social links
 */
function crumina_single_post_share_btns( $style = 'rounded' ) {

    wp_enqueue_script( 'sharer' );

    $btn_class = 'rounded' === $style ? 'btn btn-control has-i' : 'btn social-item';
    ?>
    <button class="<?php echo esc_attr( $btn_class ) ?> bg-facebook sharer" data-sharer="facebook"
            data-url="<?php the_permalink(); ?>"
			data-title="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>"
	>
        <i class="fa fa-facebook-f" aria-hidden="true"></i>
    </button>

    <button class="<?php echo esc_attr( $btn_class ) ?> bg-twitter sharer" data-sharer="twitter"
            data-url="<?php the_permalink(); ?>"
			data-title="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>"
	>
        <i class="fa fa-twitter" aria-hidden="true"></i>
    </button>

    <button class="<?php echo esc_attr( $btn_class ) ?> bg-google sharer" data-sharer="pocket"
			data-url="<?php the_permalink(); ?>"
			data-title="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>"
	>
		<i class="fa fa-get-pocket"></i>
    </button>
    <button class="<?php echo esc_attr( $btn_class ) ?> bg-green sharer" data-sharer="whatsapp"
			data-url="<?php the_permalink(); ?>"
			data-title="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>"
	>
		<i class="fa fa-whatsapp"></i>
    </button>
        <button class="<?php echo esc_attr( $btn_class ) ?> bg-facebook sharer" data-sharer="linkedin"
                data-url="<?php the_permalink( get_the_ID() );?>"
                data-title="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>"
    >
            <i class="fa fa-linkedin"></i>
        </button>
    <?php
}

/**
 * Generate html markup for social networks share buttons.
 *
 * @param $post_ID integer Post ID from loop
 */
function crumina_blog_post_share_btns( $post_ID ) {
    wp_enqueue_script( 'sharer' );

    if ( empty( $post_ID ) ) {
        $post_ID = get_the_ID();
    }
    ?>
    <span class="post-add-icon inline-items more">
        <?php echo olympus_svg_icon( 'olymp-share-icon' ); ?>
        <span><?php esc_html_e( 'Share', 'crum-ext-post-share' ); ?></span>
        <ul class="social_share_icons more-dropdown">
            <li>
                <button class="social__item sharer" data-sharer="twitter"
                        data-title="<?php echo esc_attr( get_the_title( $post_ID ) ); ?>"
                        data-url="<?php the_permalink( $post_ID ); ?>">
                    <i class="fa fa-twitter"></i>
                </button>
            </li>
            <li>
                <button class="social__item sharer" data-sharer="facebook"
                        data-title="<?php echo esc_attr( get_the_title( $post_ID ) ); ?>"
                        data-url="<?php the_permalink( $post_ID ); ?>"
                        data-image="<?php echo esc_attr( get_the_post_thumbnail_url( $post_ID, 'large' ) ); ?>">
                    <i class="fa fa-facebook-f"></i>
                </button>
            </li>
             <li>
                <button class="social__item sharer" data-sharer="pocket"
						data-title="<?php echo esc_attr( get_the_title( $post_ID ) ); ?>"
						data-url="<?php the_permalink( $post_ID ); ?>">
                    <i class="fa fa-get-pocket"></i>
                </button>
            </li>
            <li>
                <button class="social__item sharer" data-sharer="linkedin"
                        data-title="<?php echo esc_attr( get_the_title( $post_ID ) ); ?>"
                        data-url="<?php the_permalink( $post_ID ); ?>"
                        data-image="<?php echo esc_attr( get_the_post_thumbnail_url( $post_ID, 'large' ) ); ?>">
                    <i class="fa fa-linkedin"></i>
                </button>
            </li>
            <li>
                <button class="social__item sharer" data-sharer="telegram"
                        data-title="<?php echo esc_attr( get_the_title( $post_ID ) ); ?>"
                        data-url="<?php the_permalink( $post_ID ); ?>">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </li>
        </ul>
    </span>


    <?php
}