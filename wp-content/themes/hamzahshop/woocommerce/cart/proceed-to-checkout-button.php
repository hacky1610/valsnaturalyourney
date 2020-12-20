<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * VNJ: Add warning - no shipping to non EU
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="alert alert-warning" style="font-size: 17px" role="alert"><b>Attention!</b> En raison du Corona Virus, il n'est actuellement pas possible d'envoyer des colis en dehors de l'Europe. Les frontières sont encore fermées. </div>
<a href="<?php echo esc_url( wc_get_checkout_url() );?>" class="checkout-button button alt wc-forward">
Payer
</a>

