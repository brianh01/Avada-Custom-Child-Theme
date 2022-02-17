jQuery(document).ready(function ($){

    var width = $(window).width();

    // var menutext = $('body').find('.menu-text');
    // console.log( menutext );

    // if( width <= 1200 ) {
    //     menutext.each(function(){
    //      $(this).append('<button href="#" aria-expanded="false" class="fusion-open-submenu"></button>');
    //     });

    // }else {

    //     menutext.each(function(){
    //      $(this).remove();
    //     });
    // }

    //menu responsive
    $(window).resize(function() {
        var width = $(window).width();

        if( width <= 1295 ) {
            $('.fusion-mobile-menu-icons').insertAfter('.contact-us-btn');
            $('.fusion-header > .fusion-row .fusion-mobile-nav-holder').insertAfter('.fusion-header > .fusion-row');

        }else {
            $('.fusion-mobile-menu-icons').insertAfter('.fusion-main-menu');
            $('.fusion-header > .fusion-row .fusion-mobile-nav-holder').insertAfter('.fusion-header > .fusion-row > .fusion-main-menu');
        }



        //footer
        if( width <= 991 ){
            $('.footer-top #custom_html-5').insertAfter('#custom_html-6');
            $('.footer-bottom').insertAfter('.fusion-footer-widget-area .fusion-column-last');
        }else {
            $('.footer-top #custom_html-5').insertAfter('#nav_menu-2');
            $('.footer-bottom').insertAfter('.fusion-footer-widget-area .footer-top');

        }

    }).resize();

    //footer
    $('#custom_html-3, #custom_html-4, #nav_menu-2, #custom_html-5').wrapAll('<div class="footer-top"></div>');
    $('#nav_menu-6, #nav_menu-7, #nav_menu-5, #nav_menu-4').wrapAll('<div class="footer-bottom"></div>');

    //Insert Buttons Arrow
    $('.default-btn.w-arrow .fusion-button-text').append('<div class="arrow arrow--right"><span></span></div>');


    //Skin Services
    $(window).resize(function() {
        var width = $(window).width();

        if( width <= 991 ) {
            $('#skin-services .normal-height').insertBefore('#skin-services .first-column');
        }else {
            $('#skin-services .normal-height').insertAfter('#skin-services .first-column');
        }

    }).resize();

    //testimonials slider
    $(".testimonial-slider").slick({
        dots: true,
        variableWidth: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        responsive: [
            {
              breakpoint: 992,
              settings: {
                variableWidth: false,
              }
            },
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
    });

});

jQuery(function($) {
  // Handler for .ready() called. Put the Slick Slider etc. init code here.
  //off sale Slider
    $(window).resize(function() {
        var width = $(window).width();

        
            $(".off-sale > .fusion-builder-row").slick({
                dots: false,
                arrows: true,
                variableWidth: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    {
                      breakpoint: 992,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                      }
                    },
                    {
                      breakpoint: 481,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                  ]
            });
        

    }).resize();


    $('.addremoveToogle').click(function(){
        if( $(this).is(':contains("ADD")') ) {
          $(this).text("REMOVE").addClass("testaBooked");
        } else if( $(this).is(':contains("REMOVE")') ) {
          $(this).text("ADD").removeClass("testaBooked");
        }
    });

    $('.testabutton').click(function(){
		$('.testaSpecial-tab').hide();
		$('.datetimeSpecial-tab').show();
	});

	$('.returntoTab').click(function(){
		$('.datetimeSpecial-tab').hide();
		$('.testaSpecial-tab').show();
	});
	$('.datetimeButton').click(function(){
		$('.datetimeSpecial-tab').hide();
		$('.confirmationSpecial-tab').show();
	});
	
	//Book Now button trigger book now popup
    $('.book-btn').on('click', function(){
        //$('.ob-widget-btn').click();
    });
    
    // setTimeout(function(){
    //     $('.footer-top .fusion-checklist li.fusion-li-item:nth-child(1) .fusion-li-item-content').html('<a href="tel:+0738442259">07 3844 2259</a>');    
    // }, 3000);
    

})

