<?php
/*Plugin Name: Create iGo Movie Post Type
Description: This plugin registers the 'movie' post type.
Version: 1.0
License: GPLv2
*/


function igo_create_post_type() {

    // set up labels
    $labels = array(
    'name' => 'Movies',
    'singular_name' => 'Movie',
    'add_new' => 'Add New Movie',
    'add_new_item' => 'Add New Movie',
    'edit_item' => 'Edit Movie',
    'new_item' => 'New Movie',
    'all_items' => 'All Movies',
    'view_item' => 'View Movie',
    'search_items' => 'Search Movies',
    'not_found' =>  'No Movies Found',
    'not_found_in_trash' => 'No Movies found in Trash',
    'parent_item_colon' => '',
    'menu_name' => 'Movies',
    );
    //register post type
    register_post_type( 'movie', array(
    'labels' => $labels,
    'has_archive' => true,
    'public' => true,
    'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
    'taxonomies' => array( 'post_tag', 'category' ),
    'exclude_from_search' => false,
    'capability_type' => 'post',
    'menu_icon'         => 'dashicons-video-alt3',
    'rewrite' => array( 'slug' => 'movies' ),
    )
    );

}
add_action( 'init', 'igo_create_post_type' );

/*get price from Advanced Custom Field  Custom Post Type 'movie' using post-id */
add_filter('woocommerce_get_price','reigel_woocommerce_get_price',20,2);
function reigel_woocommerce_get_price($price,$post){
    if ($post->post->post_type === 'movie')
        $price = get_post_meta($post->id, "price", true);
    return $price;
}








