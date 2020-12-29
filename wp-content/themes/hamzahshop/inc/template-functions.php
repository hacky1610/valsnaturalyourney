<?php
include_once dirname(__FILE__) . '/UiElements.php';
include_once dirname(__FILE__) . '/Mailerlite.php';
include_once dirname(__FILE__) . '/MailerliteApi.php';

function sharonne_language_switcher()
{
    $translations = pll_the_languages(array('raw' => 1));
    ?>
	<div class="sharonne_language_switcher">
		<?php
foreach ($translations as $lang) {
        echo '<a href="' . $lang['url'] . '">';
        echo '<img src="/wp-content/uploads/' . $lang['slug'] . '.png" >';
        echo '</a>';
    }
    ?>
	</div>
<?php
}

function getLangFromUri($uri)
{
    if (strpos($uri, '/de/') !== false) {
        return "de";
    } elseif (strpos($uri, '/fr/') !== false) {
        return "fr";
    } else {
        return "en";
    }
}

function write_log($log)
{
    if (is_array($log) || is_object($log)) {
        error_log(print_r($log, true));
    } else {
        error_log($log);
    }
}

function custom_menu_links($items, $args)
{
    $uiElements = new UiElements();
    $courseUri  = $uiElements->getCourseOverViewUri();
    if (is_user_logged_in()) {
        $items .= '<li><a href="' . $courseUri . '">' . esc_html__('My courses', 'hamzahshop') . '</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'custom_menu_links', 10, 2);

function wpse_lost_password_redirect()
{
    wp_redirect(getCourseOverViewUri());
    exit;
}
add_action('after_password_reset', 'wpse_lost_password_redirect');

// Scheduled Action Hook
function MailerLiteAddToAllGroup()
{
    $mailerlite = new Mailerlite(MailerliteApi::GetApi());
    $mailerlite->MoveToAllGroup();
    write_log("MoveToAllGroup was called");
}

function InitTaskScheduler()
{
    if (!wp_next_scheduled('MailerLiteGroupSync')) {
        write_log("Init Schedule Event");
        wp_schedule_event(time(), 'hourly', 'MailerLiteGroupSync');
    }
}
add_action('MailerLiteGroupSync', 'MailerLiteAddToAllGroup');
InitTaskScheduler();

// New Membership (via Admin or Product sell)
function NewMembership($plan, $args)
{
    $mailerlite = new Mailerlite(MailerliteApi::GetApi());
    $mailerlite->NewMembership($plan, $args);

}
add_action('wc_memberships_user_membership_saved', 'NewMembership', 10, 2);

// Order complated
//https://businessbloomer.com/woocommerce-easily-get-order-info-total-items-etc-from-order-object/
function OrderCompleted($id)
{
    $mailerlite = new Mailerlite(MailerliteApi::GetApi());
    $mailerlite->OrderCompleted($id);
}
add_action('woocommerce_order_status_completed', 'OrderCompleted', 10, 1);

function GetMembership($memberships, $id)
{
    foreach ($memberships as $membership) {
        if ($membership->get_plan_id() == $id) {
            return $membership;
        }
    }
    return null;
}

function GetBoostStartDate()
{
    return new DateTime('2020-12-27T08:00:00.012345Z');
}

function GetSTOPStartDate()
{
    $membership = GetMembership(GetMemberships(), 6000);
    return new DateTime($membership->get_local_start_date());
}

function GetMemberships()
{
    $currentUserId = get_current_user_id();
    return wc_memberships_get_user_active_memberships($currentUserId);
}

function displayChildCourses()
{
    $ui = new UiElements();
    $container = "<div class='course-container'>" . $ui->CreateCourseButton(GetBoostStartDate(), 5647, "la semaine 2", 7) . $ui->CreateCourseButton(GetBoostStartDate(), 5696, "la semaine 3", 14) . "</div>";
    return $container;
}
add_shortcode('displayChildCourses', 'displayChildCourses');

function displayWeek1And3()
{
    $ui = new UiElements();
    $container = "<div class='course-container'>" . $ui->CreateCourseButton(GetBoostStartDate(), 4910, "la semaine 1", 0) . $ui->CreateCourseButton(GetBoostStartDate(), 5696, "la semaine 3", 14) . "</div>";
    return $container;
}
add_shortcode('displayWeek1And3', 'displayWeek1And3');

function displayWeek1And2()
{
    $ui = new UiElements();
    $container = "<div class='course-container'>" . $ui->CreateCourseButton(GetBoostStartDate(), 4910, "la semaine 1", 0) . $ui->CreateCourseButton(GetBoostStartDate(), 5647, "la semaine 2", 7) . "</div>";
    return $container;
}

add_shortcode('displayWeek1And2', 'displayWeek1And2');

function MyIsAdmin()
{
    $user       = get_userdata(get_current_user_id());
    $user_roles = $user->roles;

    if (in_array('administrator', $user_roles, true)) {
        return true;
    } else {
        return false;
    }
}

function hideDays()
{
    if (MyIsAdmin() == false) {
        $dateCurrent = new DateTime();

        $interval = $dateCurrent->diff(GetSTOPStartDate());
        $content  = "";
        $day      = $interval->d + 2;
        for ($i = $day; $i <= 21; $i++) {
            $content .= "#day$i {display: none;}";
        }

        $html = "";
        $html .= '<style id="wcn_style_sheet" type="text/css">';
        $html .= $content;
        $html .= '</style>';
        echo $html;

        if ($day <= 5) {
            return "<h1 class='aligncenter'>Le jour $day est visible demain</h1>";
        } else {
            return "";
        }
    }
}
add_shortcode('hideDays', 'hideDays');


add_action('woocommerce_order_status_changed', 'ts_auto_complete_virtual');

function ts_auto_complete_virtual($order_id)
{

    if (!$order_id) {
        return;
    }

    global $product;
    $order = wc_get_order($order_id);

    if ($order->data['status'] == 'processing') {

        $virtual_order = null;

        if (count($order->get_items()) > 0) {

            foreach ($order->get_items() as $item) {

                if ('line_item' == $item['type']) {

                    $_product = $order->get_product_from_item($item);

                    if (!$_product->is_virtual()) {
                        // once we find one non-virtual product, break out of the loop
                        $virtual_order = false;
                        break;
                    } else {
                        $virtual_order = true;
                    }
                }
            }
        }

        // if all are virtual products, mark as completed
        if ($virtual_order) {
            $order->update_status('completed');
        }
    }
}

add_filter('woocommerce_sale_flash', 'my_custom_sales_badge');
function my_custom_sales_badge()
{
    $siteUri = get_site_url();
    $img     = '<img class="sales-badge" width="75px" height="30px" src="' . $siteUri . '/wp-content/uploads/icons/sale-christmas.png"></img>';
    return $img;
}

add_filter('woocommerce_before_order_notes', 'before_order_comment');
function before_order_comment()
{

    $uiElements = new UiElements();

    $uiElements->ShowShakeComment(WC()->cart->get_cart());
}
