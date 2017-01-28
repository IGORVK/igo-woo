<?php
/**
 * Plugin Name: iGo display WooCommerce products and categories/subcategories separately in archive pages
 * Plugin URI: http://github.com/IGORVK
 * Description: Display products and catgeories / subcategories as two separate lists in product archive pages
 * Version: 1.0
 * Author: Igor Khaletskyy
 * Author URI: http://wp.medi-com.info
 *
 *
 */


function igo_product_cats_css() {

    /* register the stylesheet */
    wp_register_style( 'igo_product_cats_css', esc_url(get_template_directory_uri() . '/igo-separate-products-categories-in-archives/css/style.css' ));

    /* enqueue the stylsheet */
    wp_enqueue_style( 'igo_product_cats_css' );

}

add_action( 'wp_enqueue_scripts', 'igo_product_cats_css' );





function igo_product_subcategories( $args = array() ) {


    $parentid = get_queried_object_id();

    $args = array(
        'parent' => $parentid
    );

    $terms = get_terms( 'product_cat', $args );

    if ( $terms ) {

        echo '<ul class="product-cats">';

        foreach ( $terms as $term ) {

            echo '<li class="category">';

            woocommerce_subcategory_thumbnail( $term );

            echo '<h2>';
            echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
            echo $term->name;
            echo '</a>';
            echo '</h2>';

            echo '</li>';


        }

        echo '</ul>';

    }

}
add_action( 'woocommerce_before_shop_loop', 'igo_product_subcategories', 50 );
