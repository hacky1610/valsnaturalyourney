<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $first_name) ); ?></p>
<p><?php echo  
    "Le mode d'accès au cours <strong>BOOST LA POUSSE DE TES CHEVEUX</strong> a changé. 
    Nous avons créé un nouveau compte pour vous. Votre nom d'utilisateur est <strong>" . esc_html( $user_login ) . "</strong>. 
    Il ne vous reste plus qu'à changer votre mot de passe. Pour cela, vous avez besoin de <a href='" . esc_url($user_login_uri ) .  "' > ici</a> cliquez.
    Ensuite, vous pouvez vous connecter pour voir votre cours"
     ?></p>
     <p>Aimer Valérie</p>
<?php

do_action( 'woocommerce_email_footer', $email );
