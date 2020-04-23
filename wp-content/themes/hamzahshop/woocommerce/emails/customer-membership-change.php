<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $first_name) ); ?></p>
<?php 
echo "Le mode d'accès au cours <strong>BOOST LA POUSSE DE TES CHEVEUX</strong> a changé. 
A partir de maintenant, vous devez vous connecter en utilisant cette adresse : " . make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) . ". </br>" ;
echo 'Votre nom d utilisateur est <strong>' . esc_html( $user_login ) . '</strong>. ' ;
echo "Si vous avez oublié votre mot de passe, vous pouvez <a href='" . esc_url($user_login_uri ) .  "' > here</a> reset" ;
echo "<p> Aimer Valérie</p>";
do_action( 'woocommerce_email_footer', $email );
