<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */
require_once(__DIR__.'/../../inc/MailChimp.php');
use \DrewM\MailChimp\MailChimp;
defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

	<form action="#" method="post" class="vnj_register_after_checkout">

	<input type="hidden" value="<?php echo $order->get_billing_email()?>" name="EMAIL">
	<input type="hidden" value="<?php echo $order->get_billing_first_name()?>" name="FNAME" >
	<input type="hidden" value="<?php echo $order->get_billing_country()?>" name="PAYS" >
	<input type="hidden" value="true" name="SENDMAIL">
	<input type="submit" value="Inscrivez-vous pour des conseils gratuits pour des cheveux en bonne santé" name="subscribe" id="mc-embedded-subscribe" class="button">
	<?php

	include 'wp-content/themes/hamzahshop/inc/MailChimpFunctions.php';

	#Register for newsletter if button is clicked
	if (isset($_POST["EMAIL"])) {

		$MailChimp = new MailChimp('20908b3fa54b62ed523a94cb430eab8f-us13');
		$mail = $_POST["EMAIL"];
		$fname = $_POST["FNAME"];
		$pays = $_POST["PAYS"];
		
		$result = AddToList($mail, $fname, $pays, "1ff12ab63e");

		echo "<p class='register_label'>Vous avez été enregistré!</p>";
	}
	
	#Register as customer 
	$mail = $order->get_billing_email();
	$fname = $order->get_billing_first_name();
	$pays =  WC()->countries->countries[$order->get_billing_country()];		

	$result = AddToList($mail, $fname, $pays, "978f47800f");
	
	
	
	#Ask customer if he got the ebook?
	if($order->get_payment_method() !== "bacs")
	{
		$downloadableItems = $order->get_items();
		foreach ($downloadableItems as $item)
		{
			if($item["product_id"] == 512)
			{
				#Send E Book
				SendMail($mail,"automations/b1d7c9c924/emails/964101d9d5/queue");
			}
			if($item["product_id"] == 881)
			{
				#Send Mp3
				SendMail($mail,"automations/1c31cdc3e6/emails/15b610e7e6/queue");
			}
			if($item["product_id"] == 1390)
			{
				#Send Creme
				SendMail($mail,"automations/a78c5fe40b/emails/be3e4bc5f5/queue");
			}
		}

		#Create group in Mailerlite and add user 
		include 'wp-content/themes/hamzahshop/inc/MailerLiteFunctions.php';
		$api = GetGroupApi();
		
		$items = $order->get_items();
		foreach ($items as $item)
		{
			$prodName =  $item->get_name();
			preg_match('/(.+) \(\d+\)/', $prodName, $matches, PREG_OFFSET_CAPTURE);
			if(count($matches) > 0)
			{
				$prodName = $matches[1][0];
			}

			$groupName = "Customer: $prodName";
			$id = AddGroup($api,$groupName);
			Register($api,$mail,$fname,$pays,$id);
		}
	}

?>
	</form>
</div>
