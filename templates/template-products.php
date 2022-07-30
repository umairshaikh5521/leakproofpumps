<?php
/**
* Template Name: Products

*/
    get_header();
?>

<div class="home-wrapper blogs" >

    <div class="banner banner2">
        <img class="bannerimg" src="https://ik.imagekit.io/lpp5521/home/banner.jpg" alt="Banner">
        <div class="container banner-details">
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-6 content" data-scroll-speed=".5" data-scroll>
                    <p class="red fw700">
                    OUR PRODUCTS
                    </p>
                    <p class="f32 fw600 black mw310">
                    Products that are reliable and efficient
                    </p>
                    Leak-Proof Pumps are installed in thousands of plants worldwide handling a wide variety of tough pumping challenges.
                    <div class="button-row mt-4">
                        <a href="#p-wrap" class="btn btn-primary me-3 display-inline-block">View Products</a>
                        
                    </div>
                </div>
                <div class="col-lg-7 img360" data-scroll-speed="1" data-scroll>
                    <img src="https://ik.imagekit.io/lpp5521/products/p-banner.png" alt="">
                </div>
            </div>

            <!-- <div class="img360" data-scroll-speed="2" data-scroll>
            </div> -->
        </div>
    </div>
    

    <div class=" container pt-5 mt-3 scroll-mt-5" id="p-wrap">
        <div class="row ">
            <div class="col-lg-3 position-relative">
                <div class="f-wrapper">
                    <p class="f32 fw600 black mb-4">Filters</p>
                    <form data-css-form="filter" id="filterForm" data-js-form="filter">
    
                        <div class="input-wrapper">
                            <input type="text" class="form-control" name="head"/>
                            <label for="">Head</label>
                        </div>
    
                        <div class="input-wrapper">
                            <input type="text" class="form-control" name="capacity"/>
                            <label for="">Capacity</label>
                        </div>
    
                        <div class="input-wrapper">
                            <select class="form-select fw600" name="pump_type" aria-label="Default select example">
                                <option value="">Select Pump Type</option>
                                <option value="metallic">Metallic</option>
                                <option value="non metallic">Non-Metallic</option>
                                <option value="api">API</option>
                            </select>
                            <label for="">Type</label>
                        </div>
    
                        <!-- <input type="text" name="max_capacity" placeholder="Max Capacity" /> -->
    
                        <br>
    
                        <button id="filterBtn" class="filterBtn btn btn-primary display-inline-block no-shadow">Apply filter</button>
                        <input type="hidden" name="action" value="filter">
                    </form>
                </div>

                <!-- <div id="response"> -->

               
            </div>
            <div class="col-lg-9 " >
                <div class="row" id="products-wrapper">
                <?php

                $pType = $_GET['pump_type'];

                    $currentPage =  get_query_var('paged');
                    $args = array(
                        'post_type' => 'products',
                        'posts_per_page' =>-1,
                        'order' => 'ASC',
                        'paged' => $currentPage,
                        'post_status' => 'publish',
                    );
                    $args['meta_query'][] = array();

                    if(!empty($pType)){
                        array_push($args['meta_query'] , array(
                            'key' => 'pump_type',
                            'value' => $pType, 
                            'compare' => '='
                            // 'type' => 'numeric'
                        ));
                    }
            

                    $query = new WP_Query($args);

                    if($query->have_posts()) : 
                        
                        $counter = 0;
                        
                        while($query->have_posts()) : $counter++; $query->the_post();
                    ?>
                    <div class="col-lg-4 blog-single-card">
                        <div class="p-card">
                            <div>
                                <div class="img-wrapper" >
                                    <?php
                                        $product_image = get_field( "product_image_1", $rpost_id  );
                                        if ( $product_image ): 
                                    ?>
                                        <img class="w100p" src="<?php echo $product_image.'?tr=w-350';?>">
                                    <?php endif; ?>
                
                                </div>
                                <div class="details mt-3">
                                        <?php
                                            if(get_the_title()){
                                                ?>
                                                <div class="f24 fw600" data-aos=""><?php the_title(); ?></div>
                                                <?php
                                            }

                                            // $pumpType = get_field( "subtitle" );

                                            // if( $pumpType ) {
                                            //     echo '<div class="f16 fw600 mt-2 subtitle red" data-aos="">'.$pumpType.'</div>';
                                            // }
                                        ?>
                                </div>
                                    <?php
                                        $terms = get_the_terms( $post->ID, 'applications' );
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
                                    if(get_the_excerpt()){
                                        ?>
                                        <div class="fr-imp fw500 mt-2 excerpt" data-aos=""><?php the_excerpt(); ?></div>
                                        <?php
                                    }
                                ?>

                                <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-grey">View Details</a>
                            </div>
                        </div>
                    </div>

                    <?php endwhile;
                    else: echo "";
                    endif; wp_reset_postdata(); ?>
                </div>
            </div>     
        </div>
    </div>
   
    
   
</div>
    <?php
        get_footer();
    ?>


