<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $first_name) ); ?></p>
<p><?php echo  
    "La méthode d'accès au <strong>BOOST LA POUSSE DE TES CHEVEUX</strong> a changé. 
    Nous avons créé un nouveau compte pour vous. Votre nom d'utilisateur est <strong>" . esc_html( $user_login ) . "</strong>. 
    Il ne vous reste plus qu'à changer votre mot de passe. Pour ce faire : <br/>
    Etape 1: vous devez cliquer <a href='" . esc_url($user_login_uri ) .  "' > ici</a>.<br/>
    Etape 2: Lorsque la page apparaît, un mot de passe est déjà entré dans une case. Vous pouvez supprimer ce mot de passe en cliquant sur la case.<br/>
    Etape 3: Entrer votre propre mot de passe en créent un nouveau mot de passe . Ensuite, vous devez confirmer l'entrée. <br/>
    Etape 4: Vous pouvez maintenant vous connecter avec votre nom d'utilisateur et votre nouveau mot de passe. <br/>
    Désormais, vous devez vous connecter en utilisant cette adresse :  <a href='https://vals-natural-journey.de/mon-compte/members-area/4615/my-membership-content/' > ici</a> ou en vous rendant sur ma page d’accueil sous la tab cours."
     ?></p>
     <p>Gros Bisous <br/>Valérie</p>
<?php

do_action( 'woocommerce_email_footer', $email );
