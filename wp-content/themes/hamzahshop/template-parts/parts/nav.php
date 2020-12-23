<?php
/**
 * Displays Main Navigation
 *
 */

include_once dirname( __FILE__ ) . '../../../inc/UiElements.php' ;

?>
<?php if ( wp_is_mobile() ) {?>
<!-- Mobile Menu Area start -->
<div class="mobile-menu-area">
	<div class="container">
		<div class="row">			
			<div class="col-4">
				<div class="mobile-menu">
					<nav id="dropdown">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container' 	 => '',      
							)
						);
						?>
						
					</nav>
				</div>					
			</div>
			<div class="col-8">
				<div class="MobileButtonBar">
					<?php 
					echo '<div class="col-sm-4 col-xs-4">'; 
					(new UiElements())->getCart(WC()->cart);
					echo '</div>';
					echo '<div class="col-sm-4 col-xs-4 mobile-account-button">';
					(new UiElements())->ShowAccountButton();
					echo '</div>';
					echo '<div class="col-sm-4 col-xs-4">';
					echo do_shortcode('[woocommerce_currency_switcher_drop_down_box]'); 
					echo '</div>';?>
					
				</div>
			</div>
		</div>		
	</div>
</div>
<!-- Mobile Menu Area end -->
<?php } else {?>
<!-- Desktop Menu Area start -->
<div class="mainmenu-area hidden-xs">
	<div id="sticker"> 
		<div class="vnj-container">
			<div class="row">   
				<div class="col-lg-10 col-md-10 col-sm-12">
					<div class="mainmenu">
					   <nav>
						   <ul id="nav">
								 <?php
									wp_nav_menu(
										array(
											'theme_location' => 'primary',
											'container' 	 => '',
											'items_wrap' => '%3$s'
										)
									);
								  ?>
						   </ul>  
					   </nav>  
					</div>        
				</div>
				 <div class="col-lg-2 col-md-2 hidden-sm toolbarContainer">
					 <?php
						echo '<div class="col-lg-3 col-md-3 col-sm-4 cart-container">'; 
						(new UiElements())->getCart(WC()->cart);
						echo '</div>';
						echo '<div class="col-lg-3 col-md-3 col-sm-4 account-container">';
						(new UiElements())->ShowAccountButton();
						echo '</div>';
						echo '<div class="col-lg-3 col-md-3 col-sm-4 currency-container">';
						echo do_shortcode('[woocommerce_currency_switcher_drop_down_box]'); 
						echo '</div>';?>
				</div>	
			</div>
		</div>
   
	</div>      
</div>
<!-- Desktop Menu Area end -->
<?php }?>

         