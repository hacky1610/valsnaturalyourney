<?php
/**
 * WooCommerce Memberships
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Memberships to newer
 * versions in the future. If you wish to customize WooCommerce Memberships for your
 * needs please refer to https://docs.woocommerce.com/document/woocommerce-memberships/ for more information.
 *
 * @author    SkyVerge
 * @copyright Copyright (c) 2014-2020, SkyVerge, Inc. (info@skyverge.com)
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

/**
 * Renders a section on My Account page to list customer memberships.
 *
 * @type \WC_Memberships_User_Membership[] $customer_memberships array of user membership objects
 * @type int $user_id the current user ID
 *
 * @version 1.13.0
 * @since 1.0.0
 */
global $post;

if ( ! empty( $customer_memberships ) ) : ?>
<style>
.woocommerce-MyAccount-navigation {
	display:none;
}
</style>
<?php
foreach($customer_memberships as $customer_membership)
{
	foreach ( $customer_membership->get_plan()->get_restricted_content()->posts as $member_post ) {

		if ( ! $member_post instanceof \WP_Post ) {
			continue;
		}
		$link =  get_permalink( $member_post->ID );
		echo "<div>";
		echo "<h2><a href='" . $link. "'>" . get_the_title( $member_post->ID ) . "</a></h2>";
		echo '<a href="' .  $link . '" title="' . esc_attr( $_post->post_title ) . '">';
		echo get_the_post_thumbnail($member_post->ID,array( 500, 500));
		echo '</a>';
		echo "<p class='goToCourse'><a href='" . $link . "'>Aller au cours</a></p>";
		
		echo "</div>";
	} 
}
?>

	<?php

else :

	?>
	<p>
		<?php

		/**
		 * Filters the text for non members in My Account area.
		 *
		 * @since 1.9.0
		 *
		 * @param string $no_memberships_text the text displayed to users without memberships
		 * @param int $user_id the current user
		 */
		echo (string) apply_filters( 'wc_memberships_my_memberships_no_memberships_text', __( "Looks like you don't have a membership yet!", 'woocommerce-memberships' ), $user_id );

		?>
	</p>
	<?php

endif;
