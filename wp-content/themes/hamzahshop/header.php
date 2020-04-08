<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HamzahShop
 */



 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="profile" href="http://gmpg.org/xfn/11">-->
<link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/hamzahshop/favico.ico">
<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script
  src="https://code.jquery.com/ui/1.9.1/jquery-ui.js"
  integrity="sha256-tXuytmakTtXe6NCDgoePBXiKe1gB+VA3xRvyBs/sq94="
  crossorigin="anonymous"></script>
<script src="https://vals-natural-journey.de/wp-content/themes/hamzahshop/assets/js/bootstrap-notify.js"></script>
<script src="https://vals-natural-journey.de/wp-content/themes/hamzahshop/assets/js/vnj.js"></script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N2FLW6R');</script>
<!-- End Google Tag Manager -->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N2FLW6R"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
   <header>
        <div class="header-top">
            <div class="container">
                <div class="header-container">
                   <?php get_template_part( 'template-parts/parts/top-bar'); ?>
                </div>    
            </div>
        </div>
      
                 
                
          <?php get_template_part( 'template-parts/parts/header'); ?>
          
        <?php get_template_part( 'template-parts/parts/nav'); ?>
    </header>
	<?php if ( is_front_page() ) : ?>          
        <?php dynamic_sidebar( 'slider' ); ?>
    <?php endif; 

	
	?>     
