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
            $arr = $cart_item["data"]->category_ids;
            for($i = 0; $i < count($arr); $i++)
            {
                if($arr[$i]== 170)
                {
                    echo "<div class='alert alert-success' role='alert'>Vous voulez une dédicace pour votre enfant? Veuillez laisser son nom et votre message en commentaire.</div>";
                    return;
                }
            }
        }
    }

    function CreateCourseButton($userStartDate, $postId, $name, $days,$dateCurrent = Null)
    {
        if(!isset($dateCurrent))
        {
            $dateCurrent = new DateTime();
        }

        $postUri = get_site_url() . "/" . get_page_uri($postId);

        $interval = $dateCurrent->diff($userStartDate);

        $class = "btn btn-primary btn-lg course-button";
        $option = "";
        $name = "<h1>$name</h1>";
        $i = new DateInterval("P" . $days . "D");
        $userStartDate->add($i);
        if ($dateCurrent->getTimestamp() < $userStartDate->getTimestamp()) {
            $timeToCourse = ($dateCurrent->diff($userStartDate))->days;
            $class .= " disabled course-button-disabled";
            $option = "aria-disabled='true'";
            $name = "<h1>$name</h1><p>Disponible en $timeToCourse jours</p>";
        }

        return  sprintf("<a  href='%1\$s' target='_blank' class='%3\$s' role='button' %4\$s>%2\$s</a>", $postUri, $name, $class, $option);
    }
}