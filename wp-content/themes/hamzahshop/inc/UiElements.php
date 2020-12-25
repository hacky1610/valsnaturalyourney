<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UiElements {

    private $siteUri;
    function __construct(){
        $this->siteUri = get_site_url();
    }

    function ShowAccountButton()
    {
        echo '<div class="sharonne_account_container">';
        $myAccountUri = $this->siteUri . "/mon-compte";
        if (is_user_logged_in()) { ?>
        <div class="btn-group">
            <button class="btn dropdown-toggle user-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fas fa-user"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $myAccountUri; ?>">Mon compte</a></li>
                <li><a href="<?php echo $this->getCourseOverViewUri(); ?>"><?php echo esc_html__('My courses', 'hamzahshop'); ?></a></li>
                <li><a href="<?php echo wp_logout_url(get_permalink()); ?>">Se déconnecter</a></li>
            </ul>
        </div>
        <?php } else { ?>
        <div class="btn-group">
            <button class="btn dropdown-toggle user-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="fas fa-user"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $myAccountUri; ?>">Se connecter</a></li>
            </ul>
        </div>
        <?php
        }

    }

    function getCourseOverViewUri()
    {
        return  $this->siteUri . "/mon-compte/members-area";
    }

    
    function vnj_checkout_register()
    {?>
        <p class="form-row form-row-wide create-account woocommerce-validated">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="vnj_register" type="checkbox"    name="vnj_register_check" value="1"> <span>Register?</span>
            </label>
        </p>
    <?php
    }

    function getCart($woocommerCart)
    {?>
        <ul class="header-r-cart">
            <li>
                <a class="cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
                    <?php
                    $count = esc_attr($woocommerCart->get_cart_contents_count());
                    if ($count > 0) {
                        echo $count;
                    }
                    ?>
                </a>
            </li>
        </ul>
    <?php
    }

    function ShowShakeComment($cartArray)
    {
        foreach ( $cartArray as $cart_item_key => $cart_item ) 
        {
            foreach($cart_item["data"]->category_ids as $id);
            {
                echo $id;
            }
        }
    }
}