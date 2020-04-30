<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $first_name) ); ?></p>
<?php 
echo "La méthode d'accès au Challenge BOOST LA POUSSE DE TES CHEVEUX a changé. Désormais, vous devez vous connecter en utilisant cette adresse : " . make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) . ". <br/>" ;
echo 'Etape 1: Votre nom d\'utilisateur est <strong>' . esc_html( $user_login ) . '</strong>. <br/>' ;
echo "Etape 2: Entrez votre mot de passe. Si vous avez oublié votre mot de passe, vous pouvez le réinitialiser en cliquant  <a href='" . esc_url($user_login_uri ) .  "' > ici</a> <br/>
Etape 3: Vous pouvez maintenant vous connecter avec votre nom d'utilisateur et votre mot de passe. Désormais, vous devez vous connecter en utilisant cette adresse : <a href='https://vals-natural-journey.de/mon-compte/members-area/4615/my-membership-content/' > ici</a> ou en vous rendant sur ma page d’accueil sous la tab cours." ;
echo "<p> Gros Bisous <br/>
Valérie</p>";
do_action( 'woocommerce_email_footer', $email );
