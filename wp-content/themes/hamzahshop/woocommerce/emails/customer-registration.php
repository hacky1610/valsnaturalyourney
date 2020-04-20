<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $first_name) ); ?></p>
<p><?php echo  
    "Die Zugangsmethode zum Kurs <strong>BOOST LA POUSSE DE TES CHEVEUX</strong> hat sich geändert. 
    Wir haben für dich ein neues Konto eingerichtet. Dein Username ist <strong>" . esc_html( $user_login ) . "</strong>. 
    Du musst jetzt nur noch dein Passwort ändern. Dafür musst du  <a href='" . esc_url($user_login_uri ) .  "' >hier</a> clicken.
    Danach kannst du dich einloggen um dein Kurs zu sehen "
     ?></p>
     <p>Liebe Grüße Valérie</p>
<?php

do_action( 'woocommerce_email_footer', $email );
