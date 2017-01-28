<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">

	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();?>

                    <div itemscope="" itemtype="http://schema.org/Product" id="product-<?php echo get_the_ID(); ?>" class="post-<?php echo get_the_ID(); ?> product type-product status-publish has-post-thumbnail product_cat-comedy product_cat-movies first instock sale shipping-taxable purchasable product-type-simple">

                        <div class="images">
                            <a href="<?php

                            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'small' );
                            echo esc_url($large_image_url[0]);

                            ?>" itemprop="image" class="woocommerce-main-image zoom" title="" data-rel="prettyPhoto"><img src="<?php

                                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'small' );
                                echo esc_url($large_image_url[0]);

                                ?>" class="attachment-shop_single size-shop_single wp-post-image" alt="cd_5_angle" title="cd_5_angle" >
                            </a>
                        </div>

                        <div class="summary entry-summary">

                            <h1 itemprop="name" class="product_title entry-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>></h1>

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

                            <div class="add-to-cart-btn">
                                <?php add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 20 ); ?>
                            </div>

                        </div><!-- .summary -->

                    </div>

<?php
			endwhile;

			the_posts_pagination( array(
				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->

	</div><!-- #primary -->
    <?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
