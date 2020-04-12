<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_relatedProducts = false;

$currentLang = getLangFromUri($_SERVER['REQUEST_URI']);
foreach ( $related_products as $related_product ) {
	if($currentLang ===  getLangFromUri($related_product->get_permalink()))
	{
		$show_relatedProducts = true;
	}
}

if ( $show_relatedProducts ) : ?>

	<section class="related products">

		<h2><?php esc_html_e( 'Related products', 'woocommerce' ); ?></h2>
		<?php woocommerce_product_loop_start();
			foreach ( $related_products as $related_product ) :
			$class_methods =  get_class_methods($related_product);
			if(sizeof($related_product->category_ids) >= 1) //Nur wenn das Produkt in mindestens einer Kategorie is
			{
				if($related_product->category_ids[0] != 21) //Nur Produkte die nicht in Uncatogorized Categorie sind
				{
					//Nur Produkte der gleichenSprache zeigen
					if($currentLang ===  getLangFromUri($related_product->get_permalink()))
					{

						$post_object = get_post( $related_product->get_id() );
						setup_postdata( $GLOBALS['post'] =& $post_object );	
						wc_get_template_part( 'content', 'product' ); 
					}
				}
			}
			endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>

<?php endif;

wp_reset_postdata();
