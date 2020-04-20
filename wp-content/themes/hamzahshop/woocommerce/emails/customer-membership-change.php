<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $first_name) ); ?></p>
<?php 
echo "Die Zugangsmethode zum Kurs <strong>BOOST LA POUSSE DE TES CHEVEUX</strong> hat sich geändert. 
Ab jetzt müssen sie sich über diese Adresse einloggen: " . make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) . ". </br>";
echo  'Dein Username ist <strong>' . esc_html( $user_login ) . '</strong>. ';
echo "Wenn du dein Paswort vergessen hast, dann kannst du es <a href='" . esc_url($user_login_uri ) .  "' >hier</a> zurücksetzen";
echo "<p>Liebe Grüße Valérie</p>";
do_action( 'woocommerce_email_footer', $email );
