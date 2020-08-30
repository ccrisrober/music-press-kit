<div class="<?php echo esc_attr( $container ); ?>" id="content">

    <section>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="elementor-element elementor-element-6d38016">
                        <h2 class="text-center">Biography</h2>
                        <div class="elementor-element elementor-element-62ad9ee elementor-widget elementor-widget-divider" 
                            data-id="62ad9ee" data-element_type="widget" data-widget_type="divider.default">
                            <div class="elementor-widget-container">
                                <div class="elementor-divider">
                                    <span class="elementor-divider-separator"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <?php
                            $bio_text = bpk_get_option( "bpk_bio" );
                            if( $bio_text ) {
                                $bio_text = wpautop( $bio_text );
                                echo $bio_text;
                            }
                        ?>
                        <?php 
                            $signature_url = bpk_get_option( "bpk_signature" );
                            if( $signature_url ) { ?>
                        <div class="elementor-element elementor-element-587b59bf elementor-widget elementor-widget-image" 
                            data-id="587b59bf" data-element_type="widget" 
                            data-widget_type="image.default">
                            <div class="elementor-widget-container">
                                <div class="elementor-image text-center">
                                    <img width="220" height="75" 
                                        src="<?= $signature_url; ?>" class="attachment-full size-full" alt="">
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <div>
                <?php 
                    $contact_url = bpk_get_option("bpk_contact_url");
                    if( $contact_url ) {
                ?>
                    <div class="contact-button-container text-center">
                        <a class="btn-s uppercase btn btn-secondary with-ico rounded-0" 
                            href="mailto:<?= $contact_url; ?>" target="_blank" style="">
                            Contact Us <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php
    $track_image = bpk_get_option( "bpk_latest_track_image" );
    $track_spoty = bpk_get_option( "bpk_spotify_url" );
    if( $track_image && $track_spoty ) {
    ?>
    <section>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="elementor-element elementor-element-6d38016">
                        <h2 class="text-center">My latest tracks</h2>
                        <div class="elementor-element elementor-element-62ad9ee elementor-widget elementor-widget-divider" 
                            data-id="62ad9ee" data-element_type="widget" data-widget_type="divider.default">
                            <div class="elementor-widget-container">
                                <div class="elementor-divider">
                                    <span class="elementor-divider-separator"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row vertical-align">
                <div class="col-sm-6">
                    <img class="img-fluid" src="<?= $track_image; ?>" />
                </div>
                <div class="col-sm-6">
                    <iframe src="<?= $track_spoty; ?>" style="border: 0; width: 100%; height: 380px;" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php 
    $video_url = bpk_get_option( "bpk_latest_video" );
    if( $video_url ) {
?>
    <section>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="elementor-element elementor-element-6d38016">
                        <h2 class="text-center">Latest video</h2>
                        <div class="elementor-element elementor-element-62ad9ee elementor-widget elementor-widget-divider" 
                            data-id="62ad9ee" data-element_type="widget" data-widget_type="divider.default">
                            <div class="elementor-widget-container">
                                <div class="elementor-divider">
                                    <span class="elementor-divider-separator"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="embed-responsive embed-responsive-16by9">
                        <?php 
                            $matches = array( );
                            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
                        ?>
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $matches[ 1 ]; ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php $photo_gallery = bpk_get_option( 'bpk_photo_gallery' );
    if( $photo_gallery ) {
?>
    <section>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="elementor-element elementor-element-6d38016">
                        <h2 class="text-center">Photos</h2>
                        <div class="elementor-element elementor-element-62ad9ee elementor-widget elementor-widget-divider" 
                            data-id="62ad9ee" data-element_type="widget" data-widget_type="divider.default">
                            <div class="elementor-widget-container">
                                <div class="elementor-divider">
                                    <span class="elementor-divider-separator"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .gallery {
                            -webkit-column-count: 3;
                            -moz-column-count: 3;
                            column-count: 3;
                            -webkit-column-width: 33%;
                            -moz-column-width: 33%;
                            column-width: 33%; 
                        }
                            .gallery .pics {
                                -webkit-transition: all 350ms ease;
                                transition: all 350ms ease;
                            }
                            .gallery .animation {
                                -webkit-transform: scale(1);
                                -ms-transform: scale(1);
                                transform: scale(1);
                            }

                        @media (max-width: 450px) {
                            .gallery {
                                -webkit-column-count: 1;
                                -moz-column-count: 1;
                                column-count: 1;
                                -webkit-column-width: 100%;
                                -moz-column-width: 100%;
                                column-width: 100%;
                            }
                        }

                        @media (max-width: 400px) {
                            .btn.filter {
                                padding-left: 1.1rem;
                                padding-right: 1.1rem;
                            }
                        }
                    </style>
                    <div class="gallery" id="gallery">
                        <?php foreach( $photo_gallery as $photo ) { ?>
                            <!-- Grid column -->
                            <div class="mb-3 pics animation all 2">
                                <img class="img-fluid" src="<?= $photo ?>" alt="Card image cap">
                            </div>
                            <!-- Grid column -->
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php /*
    <section>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="elementor-element elementor-element-6d38016">
                        <h2 class="text-center">Representation</h2>
                        <div class="elementor-element elementor-element-62ad9ee elementor-widget elementor-widget-divider" 
                            data-id="62ad9ee" data-element_type="widget" data-widget_type="divider.default">
                            <div class="elementor-widget-container">
                                <div class="elementor-divider">
                                    <span class="elementor-divider-separator"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="card-body wow bounceInLeft">
                        <h3 class="uppercase white-color">Booking</h3>
                        <p class="mb-0">
                            <h3 class="uppercase opc-70 white-color">
                                Encargado Booking
                            </h3>
                            <a href="#">T+(34)202122</a><br>
                            <a href="mailto:booking@lethargus.com">booking@lethargus.com</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="card-body wow bounceInRight">
                        <h3 class="uppercase white-color">Booking</h3>
                        <p class="mb-0">
                            <h3 class="uppercase opc-70 white-color">
                                Encargado Booking
                            </h3>
                            <a href="#">T+(34)202122</a><br>
                            <a href="mailto:booking@lethargus.com">booking@lethargus.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    */
?>

</div><!-- #content -->

<section class="press-kit">
    <div class="background-img overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    $presskit_link = bpk_get_option( "bpk_press_kit" );
                    if( !$presskit_link )
                    {
                        $presskit_link = "#";
                    }
                ?>
                <div class="elementor-widget-wrap text-center">
                    <div class="elementor-element elementor-element-d838453 elementor-widget elementor-widget-heading" 
                        data-id="d838453" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                            <h2 class="elementor-heading-title uppercase elementor-size-default">
                                <a href="<?= $presskit_link; ?>">Download</a>
                            </h2>
                        </div>
                    </div>
                    <div class="elementor-element elementor-element-f540e86 elementor-widget elementor-widget-heading" 
                        data-id="f540e86" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                            <h2 class="elementor-heading-title uppercase elementor-size-default">THE PRESS KIT</h2>
                        </div>
                    </div>
                    <div class="elementor-element elementor-view-framed elementor-shape-circle elementor-widget elementor-widget-icon" 
                        data-id="84fbbf1" data-element_type="widget" data-widget_type="icon.default">
                        <div class="elementor-widget-container" style="margin: 30px 0 0 0;">
                            <div class="elementor-icon-wrapper">
                                <a class="elementor-icon elementor-animation-pulse" href="<?= $presskit_link; ?>" style="font-size: 50px; padding: 40px; background-color: rgba(255,255,255,.09);">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="elementor-element elementor-element-8f8ad20 elementor-widget elementor-widget-heading" 
                        data-id="8f8ad20" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container" style="margin: 50px 0 0 0;">
                            <h2 class="elementor-heading-title uppercase elementor-size-default" style="font-size: 12px;
                                    text-transform: uppercase;
                                    line-height: 2.3em;
                                    letter-spacing: 10px;">
                                PHOTOS - PRESS RELEASE - BIO
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
