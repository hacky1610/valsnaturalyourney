<?php
include_once dirname( __FILE__ ) . '/UiElements.php' ;
include_once dirname( __FILE__ ) . '/Mailerlite.php' ;
include_once dirname( __FILE__ ) . '/MailerliteApi.php' ;

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
			$courseUri = $uiElements->getCourseOverViewUri();
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
			error_log("Call MailerLiteAddToAllGroup");
			require_once(__DIR__ . '/MailerLiteFunctions.php');

			$api = GetGroupApi();
			$api->limit(5000);

			MoveToAllGroup($api);
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
			$mailerlite->NewMembership($plan,$args);
			
		}
		add_action('wc_memberships_user_membership_saved', 'NewMembership', 10, 2);

		// Order complated
		//https://businessbloomer.com/woocommerce-easily-get-order-info-total-items-etc-from-order-object/
		function OrderCompleted($id)
		{
			$order = wc_get_order($id);

			// Now you have access to (see above)...

			if ($order) {
				$user = $order->get_user();
				$fname = $order->get_billing_first_name();
				$country = $order->get_billing_country();

				#Create group in Mailerlite and add user 
				include 'MailerLiteFunctions.php';
				$api = GetGroupApi();

				$items = $order->get_items();
				foreach ($items as $item) {
					$prodName =  $item->get_name();
					preg_match('/(.+) \(\d+\)/', $prodName, $matches, PREG_OFFSET_CAPTURE);
					if (count($matches) > 0) {
						$prodName = $matches[1][0];
					}

					$groupName = "Customer: $prodName";
					$id = AddGroup($api, $groupName);
					Register($api, $order->get_billing_email(), $fname, $country, $id);
				}
			}
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
			return new DateTime('2020-07-05T08:00:00.012345Z');
		}

		function GetSTOPStartDate()
		{
			$membership = GetMembership(GetMemberships(),6000);
			return new DateTime($membership->get_local_start_date());
		}

		function GetMemberships()
		{
			$currentUserId = get_current_user_id();
			return wc_memberships_get_user_active_memberships($currentUserId);
		}

		function displayChildCourses()
		{
			$container = "<div class='course-container'>" . CreateCourseButton(GetBoostStartDate(), 5647, "la semaine 2", 7) . CreateCourseButton(GetBoostStartDate(), 5696, "la semaine 3", 14) . "</div>";
			return $container;
		}
		add_shortcode('displayChildCourses', 'displayChildCourses');

		function displayWeek1And3()
		{
			$container = "<div class='course-container'>" . CreateCourseButton(GetBoostStartDate(), 4910, "la semaine 1", 0) . CreateCourseButton(GetBoostStartDate(), 5696, "la semaine 3", 14) . "</div>";
			return $container;
		}
		add_shortcode('displayWeek1And3', 'displayWeek1And3');


		function displayWeek1And2()
		{
			$container = "<div class='course-container'>" . CreateCourseButton(GetBoostStartDate(), 4910, "la semaine 1", 0) . CreateCourseButton(GetBoostStartDate(), 5647, "la semaine 2", 7) . "</div>";
			return $container;
		}

		add_shortcode('displayWeek1And2', 'displayWeek1And2');

		function MyIsAdmin()
		{
			$user = get_userdata( get_current_user_id());
			$user_roles = $user->roles;

			if ( in_array( 'administrator', $user_roles, true ) ) {
				return true;
			}
			else
			{
				return false;
			}
		}

		function hideDays()
		{
			if(MyIsAdmin() == false)
			{
				$dateCurrent = new DateTime();

				$interval = $dateCurrent->diff(GetSTOPStartDate());
				$content = "";
				$day = $interval->d +2;
				for ($i = $day; $i <= 21; $i++) {
					$content .= "#day$i {display: none;}";
				}
	
				$html = "";
				$html .= '<style id="wcn_style_sheet" type="text/css">';
				$html .= $content;
				$html .= '</style>';
				echo $html;

				if($day <= 5)
				{
					return "<h1 class='aligncenter'>Le jour $day est visible demain</h1>";
				}
				else
				{
					return "";
				}
			}
		}
		add_shortcode('hideDays', 'hideDays');

		function CreateCourseButton($userStartDate, $postId, $name, $days)
		{
			$postUri = get_site_url() . "/" . get_page_uri($postId);
			$dateCurrent = new DateTime();

			$interval = $dateCurrent->diff($userStartDate);

			$class = "btn btn-primary btn-lg course-button";
			$option = "";
			$name = "<h1>$name</h1>";
			$i = new DateInterval("P7D");
			$userStartDate->add($i);
			if ($dateCurrent->getTimestamp() < $userStartDate->getTimestamp()) {
				$timeToCourse = ($dateCurrent->diff($userStartDate))->days;
				$class .= " disabled course-button-disabled";
				$option = "aria-disabled='true'";
				$name = "<h1>$name</h1><p>Disponible en $timeToCourse jours</p>";
			}

			return  sprintf("<a  href='%1\$s' target='_blank' class='%3\$s' role='button' %4\$s>%2\$s</a>", $postUri, $name, $class, $option);
		}

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
		function my_custom_sales_badge() {
			$siteUri = get_site_url();
		    $img = '<img class="sales-badge" width="75px" height="30px" src="' . $siteUri .'/wp-content/uploads/icons/sale-christmas.png"></img>';
		    return $img;
		}

		add_filter('woocommerce_before_order_notes', 'before_order_comment');
		function before_order_comment() {

			$uiElements = new UiElements();

			$uiElements->ShowShakeComment(WC()->cart->get_cart() );
		}


		
