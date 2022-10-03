<?php

add_action('wp_ajax_nopriv_filter', 'filter_ajax');
add_action('wp_ajax_filter', 'filter_ajax');

function filter_ajax(){
    $category = $_POST['category'];

    $args = array(
        'post_type' => 'produkte',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'tipi',
                'terms'    => $category,
                ),
            ),
    );

    // if(isset($category)){
    //     $args['category__in'] = array($category);
    // };

    $query = new WP_Query($args);

    if($query->have_posts()) :
        while($query->have_posts()) : $query->the_post();?>
         <option id="selection" value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>
         <?php

        endwhile;
        endif;
        wp_reset_postdata();

        die();
}