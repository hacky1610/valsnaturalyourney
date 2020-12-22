<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UiElements {

    function __construct(){
    }

    function ShowAccountButton()
        {
            echo '<div class="sharonne_account_container">';
            $myAccountUri = get_site_url() . "/mon-compte";
            if (is_user_logged_in()) { ?>
        <div class="btn-group">
            <button class="btn dropdown-toggle user-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fas fa-user"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $myAccountUri; ?>">Mon compte</a></li>
                <li><a href="<?php echo  getCourseOverViewUri(); ?>"><?php echo esc_html__('My courses', 'hamzahshop'); ?></a></li>
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

}