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
 * Renders the content restricted to the membership in the my account area.
 *
 * @type \WC_Memberships_User_Membership $customer_membership User Membership object
 * @type \WP_Query $restricted_content Query results of posts and custom post types restricted to the membership
 * @type int $user_id The current user ID
 *
 * @version 1.13.0
 * @since 1.4.0
 */

if ( empty ( $restricted_content->posts ) ) 
{ 
	echo '<p>'  . esc_html_e( 'There is no content assigned to this membership.', 'woocommerce-memberships' ). '</p>';
}
else 
{
	foreach ( $restricted_content->posts as $member_post ) {
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

