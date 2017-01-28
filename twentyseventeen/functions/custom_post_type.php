<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * @package iGo
 */
/*function igo_films_cpt() {
    $labels = array(
        'name' => _x('Films', 'post type general name'),
        'singular_name' => _x('Film', 'post type singular name'),
        'add_new' => _x('Add New', 'Film'),
        'add_new_item' => __('Add New Film'),
        'edit_item' => __('Edit Film'),
        'new_item' => __('New Film'),
        'all_items' => __('All Films'),
        'view_item' => __('View Film'),
        'search_items' => __('Search Films'),
        'not_found' =>  __('No films found'),
        'not_found_in_trash' => __('No films found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => __('Films')

    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon'         => 'dashicons-video-alt3',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );
    register_post_type('film',$args);
}
add_action( 'init', 'igo_films_cpt' );*/

function movies_cpt() {

// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Movies', 'Post Type General Name', 'twentyseventeen' ),
        'singular_name'       => _x( 'Movie', 'Post Type Singular Name', 'twentyseventeen' ),
        'menu_name'           => __( 'Movies', 'twentyseventeen' ),
        'parent_item_colon'   => __( 'Parent Movie', 'twentyseventeen' ),
        'all_items'           => __( 'All Movies', 'twentyseventeen' ),
        'view_item'           => __( 'View Movie', 'twentyseventeen' ),
        'add_new_item'        => __( 'Add New Movie', 'twentyseventeen' ),
        'add_new'             => __( 'Add New', 'twentyseventeen' ),
        'edit_item'           => __( 'Edit Movie', 'twentyseventeen' ),
        'update_item'         => __( 'Update Movie', 'twentyseventeen' ),
        'search_items'        => __( 'Search Movie', 'twentyseventeen' ),
        'not_found'           => __( 'Not Found', 'twentyseventeen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentyseventeen' ),
    );

// Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'movies', 'twentyseventeen' ),
        'description'         => __( 'Movie news and reviews', 'twentyseventeen' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon'         => 'dashicons-video-alt3',

        // This is where we add taxonomies to our CPT
        'taxonomies'          => array( 'category' ),
    );

    // Registering your Custom Post Type
    register_post_type( 'movies', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action( 'init', 'movies_cpt', 0 );


add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
    if( is_category() ) {
        $post_type = get_query_var('post_type');
        if($post_type)
            $post_type = $post_type;
        else
            $post_type = array('nav_menu_item', 'post', 'movies'); // don't forget nav_menu_item to allow menus to work!
        $query->set('post_type',$post_type);
        return $query;
    }
}


add_filter('woocommerce_get_price','reigel_woocommerce_get_price',20,2);
function reigel_woocommerce_get_price($price,$post){
    if ($post->post->post_type === 'movies')
        $price = get_post_meta($post->id, "price", true);
    return $price;
}


add_filter('the_content','rei_add_to_cart_button', 20,1);
function rei_add_to_cart_button($content){
    global $post;
    if ($post->post_type !== 'post') {return $content; }

    ob_start();
    ?>
    <form action="" method="post">
        <input name="add-to-cart" type="hidden" value="<?php echo $post->ID ?>" />
        <input name="quantity" type="number" value="1" min="1"  />
        <input name="submit" type="submit" value="Add to cart" />
    </form>
    <?php

    return $content . ob_get_clean();
}





