<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></p>
<p><?php printf( 
    'Die Zugangsmethode zum Kurs BOOST LA POUSSE DE TES CHEVEUX hat sich geändert. Wir haben für dich ein neues Konto eingerichtet dein Username ist %1$s. Über diesen Link kannst du dich einloggen: %2$s', 
    '<strong>' . esc_html( $user_login ) . '</strong>',
     make_clickable( esc_url($user_login_uri ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
<?php

do_action( 'woocommerce_email_footer', $email );
