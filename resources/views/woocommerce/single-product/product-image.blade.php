<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
  return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
  'woocommerce_single_product_image_gallery_classes',
  array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
    'woocommerce-product-gallery--columns-' . absint( $columns ),
    'images',
  )
);
?>

<?php
  global $product;

  $attachment_ids = $product->get_gallery_image_ids();
  $image_links[] = get_the_post_thumbnail_url('', 'large');
  $product_inc = 1;

  foreach( $attachment_ids as $attachment_id ) {
    //$image_links[] = wp_get_attachment_url( $attachment_id );
    $image_links[] = wp_get_attachment_image_url($attachment_id, 'large');

  }
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">

  <!-- Product Carousel -->
  <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-inner">
            <?php
            foreach( $image_links as $image_link_url ) { ?>
              <div class="carousel-item <?php echo ($product_inc==1)?'active':''; ?>">
                  <?php echo '<img class="prod-card-img d-block" src="'.$image_link_url.'" />'; ?>
                </div>
                <?php $product_inc++;
            }
        ?>
    </div>
  <?php if ($product_inc > 2) { ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"  data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"  data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  <?php } ?>
  </div>
</div>
