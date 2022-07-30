<?php
/**
* Template Name: Blogs

*/
    get_header();
?>

<div class="home-wrapper blogs" >
    

    <div class=" container pt-5">
        <p class="f32 fw600 black mb-3">Blogs</p>
        <div class="row align-items-center">
            <?php

                $currentPage =  get_query_var('paged');
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' =>-1,
                    'order' => 'DESC',
                    'paged' => $currentPage,
                    'post_status' => 'publish',
                );

                $query = new WP_Query($args);

                if($query->have_posts()) : 
                    
                    $counter = 0;
                    
                    while($query->have_posts()) : $counter++; $query->the_post();
                ?>
                <div class="col-lg-4 blog-single-card">
                    <a href="<?php the_permalink(); ?>">
                        <div class="" data-aos="fade-up">
                        
                            <?php
                            if (has_post_thumbnail( $post->ID ) ): ?>
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                                <img class="w100p" src="<?php echo $image[0];?>">
                            <?php endif; ?>
        
                        </div>
                        <div class="details mt-3">
                                <?php
                                    if(get_the_title()){
                                        ?>
                                        <div class="f24 fw600" data-aos="fade-up"><?php the_title(); ?></div>
                                        <?php
                                    }
                                ?><?php
                                    if(get_the_excerpt()){
                                        ?>
                                        <div class="fr-imp fw500 mt-2" data-aos="fade-up"><?php the_excerpt(); ?></div>
                                        <?php
                                    }
                                ?>
                        </div>
                    </a>
                </div>

                <?php endwhile;
                else: echo "";
                    endif; wp_reset_postdata(); ?>



                
        </div>
    </div>
   
    
   
</div>
    <?php
        get_footer();
    ?>


