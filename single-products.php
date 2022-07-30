<?php

get_header(); ?>

<?php
            // Start the Loop.
            while ( have_posts() ) : the_post();

                // Include the page content template.
                // get_template_part( 'content', 'page' );

                $post_id = get_the_ID();
                

                ?>

<div  class="container">

    <div id="primary" class="row single-product position-relative">

    
        
                <div class="col-lg-7">

                    <div class="product-imgs">
                        <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">
                            <?php
                                    $product_image_1 = get_field( "product_image_1" );
                                    $product_image_2 = get_field( "product_image_2" );
                                    $product_image_3 = get_field( "product_image_3" );
                                    $product_image_4 = get_field( "product_image_4" );

                                    if( $product_image_1 ) {
                                        ?>
                                        <div
                                            class="carousel__slide"
                                            data-src="<?php echo $product_image_1; ?>"
                                            data-fancybox="gallery"
                                        >
                                            <img src="<?php echo $product_image_1.'?tr=w-770'; ?>" />
                                        </div>
                                        <?php
                                        
                                    }

                                    if( $product_image_2 ) {
                                        ?>
                                        <div
                                            class="carousel__slide"
                                            data-src="<?php echo $product_image_2; ?>"
                                            data-fancybox="gallery"
                                        >
                                            <img src="<?php echo $product_image_2.'?tr=w-770'; ?>" />
                                        </div>
                                        <?php
                                        
                                    }

                                    if( $product_image_3 ) {
                                        ?>
                                        <div
                                            class="carousel__slide"
                                            data-src="<?php echo $product_image_3; ?>"
                                            data-fancybox="gallery"
                                        >
                                            <img src="<?php echo $product_image_3.'?tr=w-770'; ?>" />
                                        </div>
                                        <?php
                                        
                                    }

                                    if( $product_image_4 ) {
                                        ?>
                                        <div
                                            class="carousel__slide"
                                            data-src="<?php echo $product_image_4; ?>"
                                            data-fancybox="gallery"
                                        >
                                            <img src="<?php echo $product_image_4.'?tr=w-770'; ?>" />
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>

                            <div id="thumbCarousel" class="carousel max-w-xl mx-auto">
                                <?php
                                    if( $product_image_1 ) {
                                        ?>
                                            <div class="carousel__slide">
                                                <img class="panzoom__content" src="<?php echo $product_image_1.'?tr=w-176'; ?>" />
                                            </div>
                                        <?php
                                    }

                                    if( $product_image_2 ) {
                                        ?>
                                            <div class="carousel__slide">
                                                <img class="panzoom__content" src="<?php echo $product_image_2.'?tr=w-176'; ?>" />
                                            </div>
                                        <?php
                                    }
                                  
                                ?>
                            
                           
                            
                        </div>
                    </div>

                </div>
                <div class="col-lg-5">
                    <div class="content-wrapper">

                        <div class="f36 fw700 blue"><?php the_title(); ?></div>
                        <!-- <div class="f20 red fw600 mt-2"> -->
                            <?php
                            // print_r($post);
                                // $pumpType = get_field( "subtitle" );
                                // if( $pumpType ) {
                                //     echo $pumpType;
                                // }
                            ?>
                        <!-- </div> -->
                        <?php
                            if(get_the_excerpt()){
                        ?>
                            <div class="f14 black fw600 mt-3">DESCRIPTION:</div>
                            <div class="black mt-2 fw500">
                                <?php    
                                    the_excerpt();
                                ?>
                            </div>
                        <?php
                        }
                        ?>

                        <hr class="my-4">

                        <div class="pump-details">
                            <div class="row">
                            <?php
                                $design_standard = get_field( "design_standard" );
                                $capacity = get_field( "capacity" );
                                $head = get_field( "head" );
                                $pressure = get_field( "pressure" );
                                $temperature = get_field( "temperature" );
                                $pump_type = get_field( "pump_type" );
                                $max_operating_speed = get_field( "max_operating_speed" );
                                $flange_rating = get_field( "flange_rating" );
                                $material_casingimpeller = get_field( "material_casingimpeller" );
                                $options = get_field( "options" );
                                $sump_depth = get_field( "sump_depth" );

                                if( $design_standard ) {
                            ?>
                                    <div class="d-row d-flex black fw600">
                                        <p class="label">DESIGN STANDARD:</p>
                                        <p class="blue fw700 ms-3"><?php  echo $design_standard; ?></p>
                                    </div>
                            <?php
                                }
                                if( $capacity ) {
                            ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">CAPACITY:</p>
                                        <p class="blue fw700 ms-3"><?php  echo $capacity; ?>  m<sup>3</sup>/hr</p>
                                    </div>
                            <?php
                                }
                                if( $head ) {
                            ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">HEAD:</p>
                                        <p class="blue fw700 ms-3">Up to <?php  echo $head; ?>m</p>
                                    </div>
                            <?php
                                }
                                if( $pressure ) {
                                ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">PRESSURE:</p>
                                        <p class="blue fw700 ms-3"><?php  echo $pressure; ?> bar</p>
                                    </div>
                                <?php
                                }
                                if( $temperature ) {
                            ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">TEMERATURE:</p>
                                        <p class="blue fw700 ms-3">Up to <?php  echo $temperature; ?><sup>0</sup>C</p>
                                    </div>

                                    <?php
                                }
                                if( $sump_depth ) {
                            ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">SUMP DEPTH:</p>
                                        <p class="blue fw700 ms-3"><?php  echo $sump_depth; ?>m</p>
                                    </div>

                            <?php
                                }
                                if( $max_operating_speed ) {
                            ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">MAX OPERATING SPEED:</p>
                                        <p class="blue fw700 ms-3"><?php  echo $max_operating_speed; ?> rpm</p>
                                    </div>

                            <?php
                                }
                                if( $flange_rating ) {
                            ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">FLANGE RATING:</p>
                                        <p class="blue fw700 ms-3"><?php  echo $flange_rating; ?></p>
                                    </div>

                            <?php
                                }
                                if( $material_casingimpeller ) {
                            ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">MATERIAL (CASING / IMPELLER):</p>
                                        <p class="blue fw700 ms-3"><?php  echo $material_casingimpeller; ?></p>
                                    </div>

                            <?php
                                }
                                if( $options ) {
                            ?>

                                    <div class="d-row d-flex black fw600">
                                        <p class="label">OPTIONS:</p>
                                        <p class="blue fw700 ms-3"><?php  echo $options; ?></p>
                                    </div>

                            <?php
                                }
                            ?>
                            <?php
                                        $terms = get_the_terms( $post->ID, 'applications' );
                                        if ( !empty( $terms ) ){
                                            echo '<p class="f16 fw700 mt-2 mb-1 blue">RECOMMENDED APPLICATIONS:</p>';
                                            echo "<div class='apps-wrapper'>";
                                            foreach ($terms as $term) {
                                                // echo "$term->name <br>";
                                                $image = get_field('application_icon', 'category_'. $term->term_id);
                                                echo '<img src="'.$image.'" data-toggle="tooltip" data-bs-placement="bottom" title="'.$term->name.'" />';
                                            }
                                            echo '</div>';
                                        }
                                    ?>

                                   
                            </div>
        
                        </div>

                    </div>
                </div>

               
    </div><!-- #content -->

    <?php
        $rpost1 = get_field( "related_product_1" );
        $rpost2 = get_field( "related_product_2" );
        $rpost3 = get_field( "related_product_3" );
        $rpost4 = get_field( "related_product_4" );

        if($rpost1){
    ?>

        <div class="related-products py-5">

            <div class="f32 black mb-4 fw600">Related Products</div>
            <div class="row">
                <?php
                    
                        if( $rpost1 ) {
                            ?>
                            <div class="col-md-6 col-lg-3 mb-3" data-aos="fade-up">
                                <?php
                                // print_r($post);
                                    
                                // echo $pumpType;
                                // print_r($rpost1);
                                $rpost_id = $rpost1->ID;
                                ?>
                                    <div class="p-card">
                                        <div>
                                            <div class="" >
                                                <?php
                                                    $product_image = get_field( "product_image_1", $rpost_id1  );
                                                    if ( $product_image ): 
                                                ?>
                                                    <img class="w100p" src="<?php echo $product_image;?>">
                                                <?php endif; ?>
                            
                                            </div>
                                            <div class="details mt-3">
                                                    <?php
                                                        if($rpost1->post_title){
                                                            ?>
                                                            <div class="f24 fw600 black" ><?php echo $rpost1->post_title; ?></div>
                                                            <?php
                                                        }

                                                        // $subtitle = get_field( "subtitle", $rpost_id );

                                                        // if( $subtitle ) {
                                                        //     echo '<div class="f16 fw600 mt-2 subtitle red" >'.$subtitle.'</div>';
                                                        // }
                                                    ?>
                                            </div>
                                                <?php
                                                    $terms = get_the_terms( $rpost_id, 'applications' );
                                                    if ( !empty( $terms ) ){
                                                        echo '<p class="f12 fw500 mt-2 blue">RECOMMENDED Applications:</p>';
                                                        echo "<div class='apps-wrapper'>";
                                                        foreach ($terms as $term) {
                                                            // echo "$term->name <br>";
                                                            $image = get_field('application_icon', 'category_'. $term->term_id);
                                                            echo '<img src="'.$image.'" />';
                                                        }
                                                        echo '</div>';
                                                    }
                                                ?>
                                        </div>
                                        <div class="hover">
                                            <?php
                                                if($rpost1->post_excerpt){
                                                    ?>
                                                    <div class="fr-imp fw500 mt-2 excerpt" ><?php echo $rpost1->post_excerpt; ?></div>
                                                    <?php
                                                }
                                            ?>

                                            <a href="<?php echo get_permalink( $rpost_id ) ?>" class="btn btn-primary btn-grey">View Details</a>
                                        </div>
                                    </div>
                    
                            </div>
                            
                            <?php
                        }

                        if( $rpost2 ) {
                            ?>
                            <div class="col-md-6 col-lg-3 mb-3" data-aos="fade-up">
                                <?php
            
                                    $rpost_id2 = $rpost2->ID;
                                    ?>
                                    <div class="p-card">
                                        <div>
                                            <div class="" >
                                                <?php
                                                    $product_image = get_field( "product_image_1", $rpost_id2  );
                                                    if ( $product_image ): 
                                                ?>
                                                    <img class="w100p" src="<?php echo $product_image;?>">
                                                <?php endif; ?>
                            
                                            </div>
                                            <div class="details mt-3">
                                                    <?php
                                                        if($rpost2->post_title){
                                                            ?>
                                                            <div class="f24 fw600 black" ><?php echo $rpost2->post_title; ?></div>
                                                            <?php
                                                        }

                                                        // $subtitle2 = get_field( "subtitle", $rpost_id2 );

                                                        // if( $subtitle2 ) {
                                                        //     echo '<div class="f16 fw600 mt-2 subtitle red" >'.$subtitle2.'</div>';
                                                        // }
                                                    ?>
                                            </div>
                                                <?php
                                                    $terms = get_the_terms( $rpost_id2, 'applications' );
                                                    if ( !empty( $terms ) ){
                                                        echo '<p class="f12 fw500 mt-2 blue">RECOMMENDED Applications:</p>';
                                                        echo "<div class='apps-wrapper'>";
                                                        foreach ($terms as $term) {
                                                            // echo "$term->name <br>";
                                                            $image = get_field('application_icon', 'category_'. $term->term_id);
                                                            echo '<img src="'.$image.'" />';
                                                        }
                                                        echo '</div>';
                                                    }
                                                ?>
                                        </div>
                                        <div class="hover">
                                            <?php
                                                if($rpost2->post_excerpt){
                                                    ?>
                                                    <div class="fr-imp fw500 mt-2 excerpt" ><?php echo $rpost2->post_excerpt; ?></div>
                                                    <?php
                                                }
                                            ?>

                                            <a href="<?php echo get_permalink( $rpost_id2 ) ?>" class="btn btn-primary btn-grey">View Details</a>
                                        </div>
                                    </div>
                    
                            </div>
                                
                            <?php
                        }

                        if( $rpost3 ) {
                            ?>
                            <div class="col-md-6 col-lg-3 mb-3" data-aos="fade-up">
                                <?php
                        
                                    $rpost_id3 = $rpost3->ID;
                                    ?>
                                    <div class="p-card">
                                        <div>
                                            <div class="" >
                                                <?php
                                                    $product_image = get_field( "product_image_1", $rpost_id3  );
                                                    if ( $product_image ): 
                                                ?>
                                                    <img class="w100p" src="<?php echo $product_image;?>">
                                                <?php endif; ?>
                            
                                            </div>
                                            <div class="details mt-3">
                                                    <?php
                                                        if($rpost3->post_title){
                                                            ?>
                                                            <div class="f24 fw600 black" ><?php echo $rpost3->post_title; ?></div>
                                                            <?php
                                                        }
                        
                                                        // $subtitle2 = get_field( "subtitle", $rpost_id3 );
                        
                                                        // if( $subtitle2 ) {
                                                        //     echo '<div class="f16 fw600 mt-2 subtitle red" >'.$subtitle2.'</div>';
                                                        // }
                                                    ?>
                                            </div>
                                                <?php
                                                    $terms = get_the_terms( $rpost_id3, 'applications' );
                                                    if ( !empty( $terms ) ){
                                                        echo '<p class="f12 fw500 mt-2 blue">RECOMMENDED Applications:</p>';
                                                        echo "<div class='apps-wrapper'>";
                                                        foreach ($terms as $term) {
                                                            // echo "$term->name <br>";
                                                            $image = get_field('application_icon', 'category_'. $term->term_id);
                                                            echo '<img src="'.$image.'" />';
                                                        }
                                                        echo '</div>';
                                                    }
                                                ?>
                                        </div>
                                        <div class="hover">
                                            <?php
                                                if($rpost3->post_excerpt){
                                                    ?>
                                                    <div class="fr-imp fw500 mt-2 excerpt" ><?php echo $rpost3->post_excerpt; ?></div>
                                                    <?php
                                                }
                                            ?>

                                            <a href="<?php echo get_permalink( $rpost_id3 ) ?>" class="btn btn-primary btn-grey">View Details</a>
                                        </div>
                                    </div>
                        
                            </div>
                                
                            <?php
                        }

                        if( $rpost4 ) {
                            ?>
                            <div class="col-md-6 col-lg-3 mb-3" data-aos="fade-up">
                                <?php
                        
                                    $rpost_id4 = $rpost4->ID;
                                    ?>
                                    <div class="p-card">
                                        <div>
                                            <div class="" >
                                                <?php
                                                    $product_image = get_field( "product_image_1", $rpost_id4  );
                                                    if ( $product_image ): 
                                                ?>
                                                    <img class="w100p" src="<?php echo $product_image;?>">
                                                <?php endif; ?>
                            
                                            </div>
                                            <div class="details mt-3">
                                                    <?php
                                                        if($rpost4->post_title){
                                                            ?>
                                                            <div class="f24 fw600 black" ><?php echo $rpost4->post_title; ?></div>
                                                            <?php
                                                        }
                        
                                                        // $subtitle2 = get_field( "subtitle", $rpost_id4 );
                        
                                                        // if( $subtitle2 ) {
                                                        //     echo '<div class="f16 fw600 mt-2 subtitle red" >'.$subtitle2.'</div>';
                                                        // }
                                                    ?>
                                            </div>
                                                <?php
                                                    $terms = get_the_terms( $rpost_id4, 'applications' );
                                                    if ( !empty( $terms ) ){
                                                        echo '<p class="f12 fw500 mt-2 blue">RECOMMENDED Applications:</p>';
                                                        echo "<div class='apps-wrapper'>";
                                                        foreach ($terms as $term) {
                                                            // echo "$term->name <br>";
                                                            $image = get_field('application_icon', 'category_'. $term->term_id);
                                                            echo '<img src="'.$image.'" />';
                                                        }
                                                        echo '</div>';
                                                    }
                                                ?>
                                        </div>
                                        <div class="hover">
                                            <?php
                                                if($rpost1->post_excerpt){
                                                    ?>
                                                    <div class="fr-imp fw500 mt-2 excerpt" ><?php echo $rpost4->post_excerpt; ?></div>
                                                    <?php
                                                }
                                            ?>

                                            <a href="<?php echo get_permalink( $rpost_id4 ) ?>" class="btn btn-primary btn-grey">View Details</a>
                                        </div>
                                    </div>
                        
                            </div>
                                
                            <?php
                        }
        
                        ?>
            </div>
        </div>

    <?php } ?>
</div><!-- #main-content -->

 

<?php

endwhile;

get_footer();