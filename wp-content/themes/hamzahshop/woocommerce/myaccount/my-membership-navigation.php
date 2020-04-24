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
 * Renders the tab sections on My Account page for a customer membership.
 *
 * @version 1.12.0
 * @since 1.9.0
 */
/*
Reason: Spalten header sind hardcoded
*/
$members_area          = wc_memberships()->get_frontend_instance()->get_members_area_instance();
$customer_membership   = $members_area->get_members_area_user_membership();
$membership_plan       = $customer_membership ? $customer_membership->get_plan() : null;
$members_area_sections = $membership_plan ? $members_area->get_members_area_navigation_items( $membership_plan ) : null;

if ( ! empty( $members_area_sections ) && is_array( $members_area_sections ) ) :



endif;
