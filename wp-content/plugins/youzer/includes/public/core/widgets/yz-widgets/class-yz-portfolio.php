<?php

class YZ_Portfolio {

    /**
     * # Content.
     */
    function widget() {

        $portfolio_photos = yz_data( 'youzer_portfolio' );

        if ( empty( $portfolio_photos ) ) {
            return;
        }

        ?>

    	<ul class="yz-portfolio-content">

    	<?php

            foreach ( $portfolio_photos as $photo ) :

            // Get Photo Url.
            $photo_path = yz_get_file_url( $photo );

            // If Photo Link is not available replace it with Photo Source Link
            $photo_link  = ! empty( $photo['link'] ) ? $photo['link'] : $photo_path;

    	?>

		<li>
            <figure class="yz-project-item">
                <div class="yz-projet-img" style="background-image: url(<?php echo $photo_path; ?>)" ></div>
				<figcaption class="yz-pf-buttons">
                        <a class="yz-pf-url" href="<?php echo esc_url( $photo_link ); ?>" target="_blank" ><i class="fas fa-link"></i></a>
                        <a class="yz-pf-zoom"><i class="fas fa-search"></i></a>
                        <a class="yz-lightbox-img" href="<?php echo $photo_path; ?>" data-lightbox="yz-portfolio" <?php if ( ! empty( $photo_title ) ) { echo "data-title='" . $esc_attr( $photo['title'] ) . "'"; } ?>></a>
				</figcaption>
			</figure>
		</li>

    	<?php endforeach;?>

    	</ul>

    	<?php
    }

}