(function($) {
    "use strict";

    // backtop functions
    $( '.backtotop' ).on( 'click', function () {
      $( 'html, body' ).animate( { scrollTop: 0 }, 800 );
      return false;
    });

    $( window ).on( 'scroll', function () {
      if ( $( this ).scrollTop() > 100 ) {
        $( '.backtotop' ).fadeIn( 1000, function() {
          $( 'span' , this ).fadeIn( 100 );
        });
      } else {
        $( '.backtotop' ).fadeOut( 1000, function() {
          $( 'span' , this ).fadeOut( 100 );
        });
      }
    });
    // end function backtop
    // menu top
    $('.mobile-menu .menu-item-has-children, .vertical-mega-mobile-menu .menu-item-has-children').prepend('<i class="fa fa-angle-down"></i>');

    $('.mobile-menu .menu-item-has-children > i, .vertical-mega-mobile-menu .menu-item-has-children > i').click(function(event) {
      $(this).parent().toggleClass('active');
    });

    $('#menu-toggle, .mobile-menu-container .close-menu').click(function(event) {
       $('.site').toggleClass('mobile-menu-active');
    });

    $('#mega-menu-toggle, .vertical-mega-mobile-menu .close-menu').click(function(event) {
       $('.site').toggleClass('vertical-mega-mobile-menu-active');
    });

    $('.site .overlay').click(function(event) {
        $('.site').removeClass('vertical-mega-mobile-menu-active');
    });

    $('.site .overlay').click(function(event) {
        $('.site').removeClass('mobile-menu-active');
    });

    // menu sidebar 
    var MenuChildren = $( '.sidebar .menu-item-has-children' );
    MenuChildren.children( 'a' ).after( '<div class="touch"><i class="fa fa-angle-down"></i></div>' );
    MenuChildren.on( 'click', '.touch', function(e) {
        e.stopPropagation();
        $( this ).parent( '.menu-item' ).toggleClass( 'active' );
    });

    // add product
    // Increase
    jQuery(document).on('click', '.qty-plus', function(e) {
      e.preventDefault();
      var quantityInput = jQuery(this).parents('.quantity').find('input.qty'),
        newValue = parseInt(quantityInput.val(), 10) + 1,
        maxValue = quantityInput.data('max') ? parseInt(quantityInput.data('min'), 10) : 9999999999;

      if ( newValue <= maxValue ) {
        quantityInput.val(newValue);
        quantityInput.change();
      }
    });

    // Decrease
    jQuery(document).on('click', '.qty-minus', function(e) {
      e.preventDefault();
      var quantityInput = jQuery(this).parents('.quantity').find('input.qty'),
        newValue = parseInt(quantityInput.val(), 10) - 1,
        minValue = quantityInput.data('min') ? parseInt(quantityInput.data('min'), 10) : 1;

      if ( newValue >= minValue ) {
        quantityInput.val(newValue);
        quantityInput.change();
      }
    });
    if ( rt_main.tooltip_on_off ) {
        $('.site-main').tooltip({
            track: true,
            items: '[data-tooltip]',
            content: function() {
                var tooltip_json = $(this).data( 'tooltip' );
                var title = $(this).parent( '.product_item' ).find('.rt_woocommerce-loop-product__title a').text();
                var price = $(this).parent( '.product_item' ).find('.price').html();
                var html = '';

                if ( rt_main.tooltip_image ) {
                    html += '<div class="tooltip_image"><img src="' + tooltip_json.image + '" alt=""></div>';
                }

                if ( rt_main.tooltip_title ) {
                    html +=  '<div class="tooltip_title">' + title + '</div>';
                }

                if ( rt_main.tooltip_price ) {
                    html += '<div class="tooltip_price">' + price + '</div>';
                }

                return html;
            }
        });
    }

})(jQuery);
(function($) {
    "use strict";
    if(typeof CloudZoom==='undefined') return;
    CloudZoom.quickStart();

    var direction = '';

    if (rt_main.thumbelina == 'vertical') {
        direction = 'vertical';
    }
    if (rt_main.thumbelina == 'horizontal') {
        direction = 'horizontal';
    }

    // Initialize the slider.
    $('.rt-woocommerce-product-gallery-nav').Thumbelina({
        orientation: direction,
        maxSpeed: 88,
        $bwdBut:$('.rt-woocommerce-product-gallery-nav .left'),
        $fwdBut:$('.rt-woocommerce-product-gallery-nav .right')
    });

    var thumb_height = $('.rt-woocommerce-product-thumbnail').innerHeight();

    $('.rt-woocommerce-product-gallery-nav').css({
        height: thumb_height,
    });

    $(window).resize(function(e) {
        var thumb_height = $('.rt-woocommerce-product-thumbnail').innerHeight();

        $('.rt-woocommerce-product-gallery-nav').css({
            height: thumb_height,
        });
    });

})(jQuery);
