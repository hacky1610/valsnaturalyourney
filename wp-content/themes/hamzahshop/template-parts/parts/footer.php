<div class="modal" tabindex="-1" role="dialog" id="vnj-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="vnj-modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="vnj-modal-text"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<?php
/**
 * Displays Footer
 *
 */

?>

<?php if (  is_active_sidebar( 'footer-top' ) ) { ?>
<!--Service Area Start-->
<div class="service-area">
    <div class="container">
        <div class="service-padding">
            <div class="row">
                 <?php dynamic_sidebar( 'footer-top' ); ?>
            </div>
        </div>    
    </div>
</div>
<?php }?>

<!--End of Service Area-->

<?php if (  is_active_sidebar( 'footer' ) ) { ?>
<!--Footer Widget Area Start-->
<div class="footer-widget-area">
    <div class="container">
        <div class="footer-widget-padding"> 
            <div class="row">
           	 <?php dynamic_sidebar( 'footer' ); ?>
            </div>
        </div>     
    </div>
</div>
<!--End of Footer Widget Area-->
<?php }?>

<!-- Facebook Pixel Code
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '454141548722862');
  fbq('track', 'PageView');
</script> -->
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=454141548722862&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code  -->

 <!--Footer Area Start-->
<footer class="footer">
    <div class="container">
        <div class="footer-padding">   
            <div class="row">
                <div class="col-md-12">	  
					<div>
                        <?php 
						$siteAddress = $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
						$iconsource = $siteAddress . "/wp-content/uploads/icons/";
						?>
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<a href="<?php echo $siteAddress?>" class="author vnj-center">Vals Natural Journey</a>
						<div class="vnj-social-media-icons vnj-center"> 
						
							<a target="_blank" href="https://www.facebook.com/valsnaturaljourney/" >
								<img border="0" title="Facebook" src="<?php echo $iconsource . 'facebook_icon.png' ?>">
							</a>
							<a target="_blank" href="https://www.youtube.com/channel/UCDzD020Pf41D1lk_4ox_cvg" >
								<img border="0" title="Youtube" src="<?php echo $iconsource . 'youtube_icon.png' ?>">
							</a>
							<a target="_blank" href="https://www.instagram.com/valerie_hackbarth/" >
								<img border="0" title="Instagram" src="<?php echo $iconsource . 'instagram_icon.png' ?>">
							</a>
							</a>
							<a target="_blank" href="<?php echo ${$siteAddress . esc_html_e( '/contact', 'hamzahshop' )};  ?>" >
								<img border="0" title="Contact" src="<?php echo $iconsource . 'mail_icon.png' ?>">
							</a>
							<a target="_blank" href="https://www.pinterest.co.uk/valeriehackbarth/">
								<img border="0" title="Contact" src="<?php echo $iconsource . 'pinterest_icon.png' ?>">
							</a>

						</div>

						<div class="vnj-center">		
							<a href="<?php echo ${$siteAddress . esc_html_e( '/mon-compte', 'hamzahshop' )};  ?>"><?php esc_html_e( 'Mon compte', 'hamzahshop' ); ?></a>
						</div>

						<div class="vnj-center">
							<a href="<?php echo ${$siteAddress . esc_html_e( '/politique-modele-de-confidentialite', 'hamzahshop' )};  ?>"><?php esc_html_e( 'Politique modèle de confidentialité', 'hamzahshop' ); ?> </a> 
							(<a href="<?php echo $siteAddress . '/datenschutzerklaerung' ?>">Datenschutzerklärung</a>)
						</div>
						<div class="vnj-center">	
							<a href="<?php echo ${$siteAddress . esc_html_e( '/agb', 'hamzahshop' )};  ?>"><?php esc_html_e( 'AGB', 'hamzahshop' ); ?> </a> |					
							<a href="<?php echo ${$siteAddress . esc_html_e( '/impressum', 'hamzahshop' )};  ?>"><?php esc_html_e( 'Impressum', 'hamzahshop' ); ?></a> 
						</div>
						<div class="vnj-center">	
							<a class="gaoo-opt-out google-analytics-opt-out" href="javascript:gaoop_analytics_optout();"><?php esc_html_e( 'Cliquez ici pour optout google analytics', 'hamzahshop' ); ?></a>
						</div>
						
					</div>  
                </div>
            </div>
        </div>    
    </div>
</footer>





<!--End of Footer Area-->