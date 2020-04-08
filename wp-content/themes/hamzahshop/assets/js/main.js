(function ($) {
 "use strict";


/*----------------------------
    jQuery MeanMenu
------------------------------ */
	if( $('nav#dropdown').length){
    $('nav#dropdown').meanmenu();
	}

	   
/*--------------------------
    ScrollUp
---------------------------- */	
	$.scrollUp({
        scrollText: '<i class="fa fa-arrow-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    }); 
	
	
	/*--------------------------
    Check if visible
---------------------------- */	
	 $.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
	
	var setElementsVisible = function(){
		  $('.product').each(function(i, el) {
			var el = $(el);
			if (el.visible(true)) {
			  el.addClass('come-in'); 
			} 
		  });
	};
    
	$(window).scroll(function(event) {
  		setElementsVisible();
	});
	
		
	$( document ).ready(function() {
			setElementsVisible();
		
			 $("[href]").each(function() {
				if (this.href === window.location.href) {
					$(this).addClass("active");
			}
    });
	});

 /*--------------------------
    Sticky Js 
---------------------------- */ 
	if($(".mainmenu-area").length){
    $(".mainmenu-area").sticky({topSpacing:0});
	}
    // Quantity buttons
	if($('div.quantity').length || $('td.quantity').length){
    $( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );

    // Target quantity inputs on product pages
    $( 'input.qty:not(.product-quantity input.qty)' ).each( function() {
        var min = parseFloat( $( this ).attr( 'min' ) );

        if ( min && min > 0 && parseFloat( $( this ).val() ) < min ) {
            $( this ).val( min );
        }
    });

    $( document ).on( 'click', '.plus, .minus', function() {

        // Get values
        var $qty        = $( this ).closest( '.quantity' ).find( '.qty' ),
            currentVal  = parseFloat( $qty.val() ),
            max         = parseFloat( $qty.attr( 'max' ) ),
            min         = parseFloat( $qty.attr( 'min' ) ),
            step        = $qty.attr( 'step' );

        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

        // Change the value
        if ( $( this ).is( '.plus' ) ) {

            if ( max && ( max === currentVal || currentVal > max ) ) {
                $qty.val( max );
            } else {
                $qty.val( currentVal + parseFloat( step ) );
            }

        } else {

            if ( min && ( min === currentVal || currentVal < min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( currentVal - parseFloat( step ) );
            }

        }

        // Trigger change event
        $qty.trigger( 'change' );
    });
	}
	if($('.woocommerce table.shop_table.shipping p select').length){
    /* end add quanitity button */
    var calc_shipping_dropdown = $('.woocommerce table.shop_table.shipping p select');
    if($.isFunction(calc_shipping_dropdown.select2)) {
        calc_shipping_dropdown.select2();
    }
	}
	
	
	function resizeHeaderOnScroll() {
		const distanceY = window.pageYOffset || document.documentElement.scrollTop,
		shrinkOn = 200;
		var navbar = document.getElementById('nav');
		var mainmenu = document.getElementsByClassName('mainmenu-area')[0];
		var cartContainer = document.getElementsByClassName('cart-container')[0];
		var headerCart = document.getElementsByClassName('header-r-cart')[0];
		var accountContainer = document.getElementsByClassName('account-container')[0];
        var currency = document.getElementsByClassName('currency-container')[0];
        
        if(mainmenu == undefined){
            return;
        }
		  
		if (distanceY > shrinkOn) {
				mainmenu.classList.add("mainmenu-area-small");
				cartContainer.classList.add("cart-container-small");
				headerCart.classList.add("header-r-cart-small");
				accountContainer.classList.add("account-container-small");
				currency.classList.add("currency-container-small");
				for (var i = 0, len = navbar.children.length; i < len; i++) {
					navbar.children[i].firstElementChild.classList.add("vnj-small");
				}
		} else {
				mainmenu.classList.remove("mainmenu-area-small");
				cartContainer.classList.remove("cart-container-small");
				headerCart.classList.remove("header-r-cart-small");
                currency.classList.remove("currency-container-small");
				accountContainer.classList.remove("account-container-small");
				for (var i = 0, len = navbar.children.length; i < len; i++) {
					navbar.children[i].firstElementChild.classList.remove("vnj-small");
				}
		}
	}

	window.addEventListener('scroll', resizeHeaderOnScroll);

})(jQuery); 