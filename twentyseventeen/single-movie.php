<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <?php woocommerce_breadcrumb(); ?>
                		<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();?>

                    <div itemscope="" itemtype="http://schema.org/Product" id="product-<?php echo get_the_ID(); ?>" class="post-<?php echo get_the_ID(); ?> product type-product status-publish has-post-thumbnail product_cat-comedy product_cat-movies first instock sale shipping-taxable purchasable product-type-simple">



                        <div class="images">
                            <a href="<?php

                            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
                            echo esc_url($large_image_url[0]);

                            ?>" itemprop="image" class="woocommerce-main-image zoom" title="" data-rel="prettyPhoto"><img src="<?php

                                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
                                echo esc_url($large_image_url[0]);

                                ?>"  width="300px"  height="300px" class="attachment-shop_single size-shop_single wp-post-image" alt="cd_5_angle" title="cd_5_angle" >
                            </a>
                        </div>


                        <div class="summary entry-summary">

                            <h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>

                            <div class="product_meta">

                                <span class="posted_in">Categories:

                                    <?php
                                    $cats = wp_get_post_categories( $post->ID, array('fields' => 'all') );
                                    foreach( $cats as $cat ){
                                        $term_slug = $cat->name;
                                        $term_link = get_term_link($term_slug, 'category');
                                        echo '<a href="'. $term_link  . '?post_type=movie' . '" rel="tag">'. $term_slug .'  </a>';
                                    }
                                    ?>

                            </div>


                            <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">

                                <p class="price"> <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><strong>Price: </strong>$</span><?php echo get_post_meta($post->ID,'price', true) ?></span></ins></p>

                                <meta itemprop="price" content="<?php echo get_post_meta($post->ID,'price', true) ?>">
                                <meta itemprop="priceCurrency" content="USD">
                                <link itemprop="availability" href="http://schema.org/InStock">

                            </div>
                            <div itemprop="description">
                                <?php the_excerpt(); ?>
                            </div>


                            <form class="cart" method="post" enctype="multipart/form-data">

                                <div class="quantity">
                                    <input step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric" type="number">
                                </div>

                                <input name="add-to-cart" value="<?php echo get_the_ID(); ?>" type="hidden">

                                <button type="submit" class="single_add_to_cart_button button alt">Add to cart</button>

                            </form>

                        </div><!-- .summary -->

                        <div class="woocommerce-tabs wc-tabs-wrapper">

                            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab" id="tab-description" style="display: block;">

                                <h2>Product Description</h2>
                                <?php echo get_the_content(); ?>
                                <div class="clear"></div>
                                </div>
                            </div>
                        </div>



                    <meta itemprop="url" content="<?php echo esc_url(get_permalink()); ?>">



                    </div>
        <?php get_sidebar(); ?>
        <?php   // If comments are open or we have at least one comment, load up the comment template.
         if ( comments_open() || get_comments_number() ) :
        comments_template();
        endif;

        the_post_navigation( array(
        'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
        'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
        ) );



         endwhile; ?>

            </main><!-- #main -->

        </div><!-- #primary -->

    </div><!-- .wrap -->

<?php get_footer(); ?>
