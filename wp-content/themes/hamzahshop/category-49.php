<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package sparkling
 */

 get_header(); ?>

	 <div id="primary" class="content-area">
		 <main id="main" class="site-main" role="main">
			
			<?php 
	echo do_shortcode("[post_grid id='1384']");
 ?>


		 </main><!-- #main -->
	 </div><!-- #primary -->

	<?php
	//get_sidebar();
	get_footer();
