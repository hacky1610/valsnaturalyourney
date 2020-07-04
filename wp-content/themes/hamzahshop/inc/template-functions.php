<?php
require_once('MailChimp.php');
use \DrewM\MailChimp\MailChimp;

/**
 * hamzahshop_custom_product_search.
 *
 * @since 1.0.0
 */
function hamzahshop_custom_product_search(){	
	?>
	
		<?php if ( class_exists( 'WooCommerce' ) ) :?>
	<div class="col-lg-5 col-md-5 col-sm-8">
	<div id="search-category">
		<form class="search-box" action="<?php echo esc_url(get_permalink( wc_get_page_id( 'shop' ) )); ?>" method="post">
			<div class="search-categories">
				<div class="search-cat">
					<?php 
					$args = array(
					'taxonomy' => 'producttype',
					'orderby' => 'name',
					'show_count' => '0',
					'pad_counts' => '0',
					'hierarchical' => '1',
					'title_li' => '',
					'hide_empty' => '0',
					
					);
					$all_categories = get_categories( $args );
					?>
<select class="category-items" name="category">
<option><?php esc_html_e('All types','hamzahshop') ?></option>
<?php foreach( $all_categories as $category ) { ?>
<option value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_attr($category->cat_name); ?></option>
<?php } ?>
</select>
				</div>
			</div>
		
				<input type="search" name="s" id="text-search" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_html_e('Search here...','hamzahshop') ?>" />

			<button id="btn-search-category" type="submit">
				<i class="icon-search"></i>
			</button>
			<input type="hidden" name="post_type" value="product" />
		</form>
	</div>
	</div>
	<?php endif;?>
	
	<?php
}

function hamzahshop_key_breadcrumb() {
	if ( is_front_page() || is_home() ) {
		return;
	}
	if ( ! function_exists( 'breadcrumb_trail' ) ) {
		require_once trailingslashit( get_template_directory() ) . 'vendors/breadcrumbs/breadcrumbs.php';
	}

	$breadcrumb_args = array(
		'container'   => 'div',
		'show_browse' => false,
	);

	breadcrumb_trail( $breadcrumb_args );
}

function hamzahshop_custom_min_cart(){ 
	if ( class_exists( 'WooCommerce' ) ) {?>
	<ul class="header-r-cart">
		<li>
			<a class="cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
			<?php 
					$count = esc_attr(WC()->cart->get_cart_contents_count());
					if($count > 0) {
						echo $count ;
					}
				?>
			</a>
		</li>
	</ul><?php
	}
}

function sharonne_language_switcher(){ 
	$translations = pll_the_languages(array('raw'=>1));	
	?>
	<div class="sharonne_language_switcher">		
		<?php 
			foreach ($translations as $lang){
				echo '<a href="' . $lang['url'] . '">';
				echo '<img src="/wp-content/uploads/' . $lang['slug'] . '.png" >';
				echo '</a>';
			}
		?>
	</div>
	<?php 
}

function vnj_checkout_register(){ 
	?>
	<p class="form-row form-row-wide create-account woocommerce-validated">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="vnj_register" type="checkbox" name="vnj_register_check" value="1"> <span>Register?</span>
		</label>
	</p>
	<?php 
}

function sharonne_account_button(){ 
	echo '<div class="sharonne_account_container">';
	$myAccountUri = get_site_url() ."/mon-compte";
	if (is_user_logged_in()) { ?>
		<div class="btn-group">
			<button class="btn dropdown-toggle user-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span  class="fas fa-user"></span>
			</button>
			<ul class="dropdown-menu">
				<li><a href="<?php echo $myAccountUri; ?>">Mon compte</a></li>
				<li><a href="<?php echo  getCourseOverViewUri(); ?>"><?php echo esc_html__( 'My courses', 'hamzahshop' ); ?></a></li>
				<li><a href="<?php echo wp_logout_url(get_permalink()); ?>">Se déconnecter</a></li>
  			</ul>
		</div>
      <?php } else 	{?>
      	<div class="btn-group">
			<button class="btn dropdown-toggle user-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span  class="fas fa-user"></span>
			</button>
			<ul class="dropdown-menu">
				<li><a href="<?php echo $myAccountUri; ?>">Se connecter</a></li>
  			</ul>
		</div>
      <?php
		}
	echo '</div>';
}

function getLangFromUri($uri){ 
	if(strpos($uri, '/de/') !== false)
	{
		return "de";
	}
	elseif(strpos($uri, '/fr/') !== false)
	{
		return "fr";
	}
	else
	{
		return "en";
	}			
}

/**
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function hamzahshop_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Subtitles',
			'slug'      => 'subtitles',
			'required'  => false,
		),
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'name'      => 'YITH WooCommerce Brands Add-On',
			'slug'      => 'yith-woocommerce-brands-add-on',
			'required'  => false,
		),
		array(
			'name'      => 'Unlimited Logo Carousel',
			'slug'      => 'unlimited-logo-carousel',
			'required'  => false,
		)
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'hamzahshop',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

function getCourseOverViewUri()
{
	return get_site_url() ."/mon-compte/members-area";
}

function write_log ( $log )  {
	if ( is_array( $log ) || is_object( $log ) ) {
	   error_log( print_r( $log, true ) );
	} else {
	   error_log( $log );
	}
 }

function custom_menu_links( $items, $args ) {
	if (is_user_logged_in()) {
		$items .= '<li><a href="'. getCourseOverViewUri() .'">' . esc_html__( 'My courses', 'hamzahshop' ) .'</a></li>';  
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'custom_menu_links', 10, 2 );

function wpse_lost_password_redirect() {
    wp_redirect(getCourseOverViewUri()); 
    exit;
}
add_action('after_password_reset', 'wpse_lost_password_redirect');

// Scheduled Action Hook
function MailerLiteAddToAllGroup( ) {
	error_log("Call MailerLiteAddToAllGroup");
    require_once(__DIR__.'/MailerLiteFunctions.php');
    
	$api = GetGroupApi();
	$api->limit(5000);
	
	MoveToAllGroup($api);
}

function InitTaskScheduler() {
    if ( ! wp_next_scheduled( 'MailerLiteGroupSync' ) ) {
		write_log("Init Schedule Event");
        wp_schedule_event( time(), 'hourly', 'MailerLiteGroupSync' );
    }
}
add_action( 'MailerLiteGroupSync', 'MailerLiteAddToAllGroup' );
InitTaskScheduler();

// Membership saved
function NewMembership($plan, $args) {
	preg_match('/(.+)\(\d+\)/', 'CHALLENGE  « BOOST LA POUSSE DE TES CHEVEUX » (38)', $matches, PREG_OFFSET_CAPTURE);

}
add_action( 'wc_memberships_user_membership_saved', 'NewMembership',10,2 );

// Order complated
//https://businessbloomer.com/woocommerce-easily-get-order-info-total-items-etc-from-order-object/
function OrderCompleted($id) {
	$order = wc_get_order( $id );
  
	// Now you have access to (see above)...
	
	if ( $order ) {
		$user = $order->get_user();
		$fname = $order->get_billing_first_name();
		$country = $order->get_billing_country();
	
		#Create group in Mailerlite and add user 
		include 'MailerLiteFunctions.php';
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
			Register($api,$order->get_billing_email(),$fname,$country,$id);
		}
	
	}
}
add_action( 'woocommerce_order_status_completed', 'OrderCompleted',10,1 );

function GetMembership($memberships,$id)
{
	foreach($memberships as $membership)
	{
		if($membership->get_plan_id() == $id)
		{
			return $membership;
		}
	}
	return null;
}

function GetBoostStartDate()
{
	return new DateTime('2020-07-05T08:00:00.012345Z');
}

function GetMemberships()
{
	$currentUserId = get_current_user_id();
	return wc_memberships_get_user_active_memberships($currentUserId);
}

function displayChildCourses() {
	$container = "<div class='course-container'>" . CreateCourseButton(GetBoostStartDate(),5647,"la semaine 2",7) . CreateCourseButton(GetBoostStartDate(),5696,"la semaine 3",14) . "</div>";
	return $container;
}
add_shortcode('displayChildCourses', 'displayChildCourses');

function displayWeek1And3() {
	$container = "<div class='course-container'>" . CreateCourseButton(GetBoostStartDate(),4910,"la semaine 1",0) . CreateCourseButton(GetBoostStartDate(),5696,"la semaine 3",14) . "</div>";
	return $container;
}
add_shortcode('displayWeek1And3', 'displayWeek1And3');


function displayWeek1And2() {
	$container = "<div class='course-container'>" . CreateCourseButton(GetBoostStartDate(),4910,"la semaine 1",0) . CreateCourseButton(GetBoostStartDate(),5647,"la semaine 2",7) . "</div>";
	return $container;
}

add_shortcode('displayWeek1And2', 'displayWeek1And2');

function CreateCourseButton($userStartDate,$postId,$name,$days)
{
	$postUri = get_site_url() . "/" . get_page_uri($postId);
	$dateCurrent = new DateTime();

	$interval = $dateCurrent->diff($userStartDate);

	$class = "btn btn-primary btn-lg course-button";
	$option = "";
	$name = "<h1>$name</h1>";
	$i = new DateInterval("P7D");
	$userStartDate->add($i);
	if($dateCurrent->getTimestamp() < $userStartDate->getTimestamp())
	{
		$timeToCourse = ($dateCurrent->diff($userStartDate))->days;
		$class .= " disabled"; 
		$option = "aria-disabled='true'";
		$name = "<h1>$name</h1><p>Disponible en $timeToCourse jours</p>";
	}

	return  sprintf("<a  href='%1\$s' target='_blank' class='%3\$s' role='button' %4\$s>%2\$s</a>",$postUri,$name,$class,$option);

}




