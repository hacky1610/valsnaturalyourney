<?php
/**
 * Displays Header
 *
 */

?>
<div class="header-main hamzahshop-custom-header">
<div class="container">
<div class="header-content">
        <div class="row" >
		   <div class="col-lg-2 col-md-2 col-sm-0">
			</div> 
          <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="logo"> 
            <?php
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                      the_custom_logo();
            }else{
            ?>
            
               
                 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><img border="0" alt="" src="https://vals-natural-journey.de/wp-content/uploads/logo.jpg" width="600" height="250"></a>
             
             
                
             <?php }?>   
        
            
             </div>
          </div>
         <div class="col-lg-2 col-md-2 col-sm-0">
	
			</div> 
         
		 
         
        </div>


</div>    
</div>
</div>