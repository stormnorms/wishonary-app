<?php

class YZ_Slideshow {

    /**
     * # Content.
     */
    function widget() {

        // Get Slides.
        $slides = yz_data( 'youzer_slideshow' );

        if ( empty( $slides ) ) {
            return;
        }

        // Load Carousel CSS and JS.
        wp_enqueue_style( 'yz-carousel-css', YZ_PA . 'css/owl.carousel.min.css', array(), YZ_Version );
        wp_enqueue_script( 'yz-carousel-js', YZ_PA . 'js/owl.carousel.min.js', array( 'jquery' ), YZ_Version, true );
        wp_enqueue_script( 'yz-slider', YZ_PA . 'js/yz-slider.min.js', array( 'jquery' ), YZ_Version, true );

        // Get Slides Height Option
        $height_option = yz_option( 'yz_slideshow_height_type', 'fixed' );

        ?>

        <ul class="yz-slider yz-slides-<?php echo $height_option; ?>-height">

        <?php

            foreach ( $slides as $slide ) :

            // Get Slide Image Url
            $slide_url = yz_get_file_url( $slide );

            // Check Slide Image Existence
            if ( ! yz_is_image_exists( $slide_url ) ) {
                continue;
            }

    	?>

		<li class="yz-slideshow-item">
            <?php if ( 'auto' == $height_option ) : ?>
            <img src="<?php echo $slide_url; ?>" alt="" >
            <?php else : ?>
            <div class="yz-slideshow-img" style="background-image: url(<?php echo $slide_url; ?>)" ></div>
            <?php endif; ?>
        </li>

        <?php endforeach; ?>

    	</ul>

    	<?php

    }

}