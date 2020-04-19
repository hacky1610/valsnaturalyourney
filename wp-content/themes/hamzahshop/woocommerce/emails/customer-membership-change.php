<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></p>
<p>Die Zugangsmethode zum Kurs BOOST LA POUSSE DE TES CHEVEUX hat sich geändert. 
Ab jetzt können sie sich über diese Adresse einloggen: <?php echo make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ;?></p>

<?php

do_action( 'woocommerce_email_footer', $email );
