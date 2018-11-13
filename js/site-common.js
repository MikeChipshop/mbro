jQuery(document).ready(function( $ ) {

	// Append target class to HTML for mobile

	$(document).on('resize, ready', function() {
	 // Add class if screen size equals
	 var $window = $(window),
	 $html = $('body');

	 function resize() {
		$html.removeClass('desktop');

		if ($window.width() < 550) {
		  return $html.addClass('mobile');
		} else {
		  return $html.addClass('desktop');
		}
	  }
	  $window.resize(resize).trigger('resize');


	});

	// Load video in case study popup
	$('.mb_case-study-thumb-item').click(function(e) {
  		var embed = $(this).data('videocode');
		$('.mb_popup-video').html('<iframe id="mb_vimeo-hero" src="https://player.vimeo.com/video/'+embed+'?loop=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
		$('.mb_popup-video-wrap').addClass('open');
	});
	$('.mb_close-popup').click(function() {
		$('.mb_popup-video-wrap').removeClass('open');
	});

	// Scroll Nav

	$(document).on('ready', function() {
		$(".desktop .mb_scroll-down button").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_intro").offset().top -84
			}, 1000);
		});
		$(".desktop .mb_work-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_work").offset().top -84
			}, 1000);
		});
		$(".desktop .mb_about-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_about").offset().top -84
			}, 1000);
		});
		$(".desktop .mb_studio-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_studio").offset().top -84
			}, 1000);
		});
		$(".desktop .mb_news-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_news").offset().top -84
			}, 1000);
		});
		$(".desktop .mb_contact-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_contact").offset().top -84
			}, 1000);
		});
		$(".desktop .mb_intro-scroll").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_contact").offset().top -84
			}, 1000);
		});

		// Scroll nav on mobile

		$(".mobile .mb_scroll-down button").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_intro").offset().top -1
			}, 1000);
		});
		$(".mobile .mb_work-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_work").offset().top -1
			}, 1000);
		});
		$(".mobile .mb_about-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_about").offset().top -1
			}, 1000);
		});
		$(".mobile .mb_studio-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_studio").offset().top -1
			}, 1000);
		});
		$(".mobile .mb_news-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_news").offset().top -1
			}, 1000);
		});
		$(".mobile .mb_contact-click").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_contact").offset().top -1
			}, 1000);
		});
		$(".mobile .mb_intro-scroll").click(function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#mb_contact").offset().top -84
			}, 1000);
		});
	});
	// 'Work' thumbs

	$(".mb_rearrange-loop").click(function(e) {
		e.preventDefault();
		var slugcat = $(this).data('slug');
		$( ".mb_home-work-videos li" ).hide(400);
		$( ".mb_home-work-videos li."+slugcat).show(400);
	});
	$(".mb_rearrange-loop-news").click(function(e) {
		e.preventDefault();
		$( ".mb_home-work-videos li" ).hide(400);
		$( ".mb_home-work-videos li.category-news").show(400);
		$( ".mb_home-work-videos li.category-case-study").show(400);
	});

	$(".mb_rearrange-loop-news-index").click(function(e) {
		e.preventDefault();
		var slugcat = $(this).data('slug');
		$( ".mb_home-work-videos li" ).hide(400);
		$( ".mb_home-work-videos li."+slugcat).show(400);
	});

	// Read mores

	$(".mb_read-more-button button").click(function() {
		$( ".mb_read-more-button button" ).toggleClass('active');
		$( ".mb_read-more-content" ).toggle(400);
	});

	// Testimonial Slider

	$('.mb_home-testimonials').slick({
		autoplay: true,
		arrows: false,
		autoplaySpeed: 5000
	});

	// "Studio" background

	$('.mb_home-pos-background').slick({
		autoplay: true,
		arrows: false,
		autoplaySpeed: 5000,
		fade: true
	});

	// Mobile menu stuff
	$(".mb_mobile-nav-logo button").click(function() {
		$( "body" ).toggleClass('mb_mobile-menu-open');
	});
	$(".mb_mobile-navigation nav a").click(function() {
		$( "body" ).removeClass('mb_mobile-menu-open');
	});

	// Filters dropdown
	$(".mb_home-work-showcase button").click(function() {
		$( "body" ).toggleClass('mb_filters-open');
		$(".mb_home-work-filters").toggle(500);
	});
	/*$(".mb_filters-open .mb_home-work-showcase button").click(function() {
		$( "body" ).removeClass('mb_filters-open');
		$(".mb_home-work-filters").hide(500);
	});*/

	$(document).on("click", ".mobile .mb_home-work-filters a", function(){
    	$( "body" ).removeClass('mb_filters-open');
		$(".mb_home-work-filters").hide(500);
	});


	/* $(".mb_home-work-filters a").click(function() {
		$( "body" ).removeClass('mb_filters-open');
		$(".mb_home-work-filters").hide(500);
	}); */

	//Animated "Services", Studio section
	$(".mb_service-section").click(function() {
		$(".mb_service-section ul").hide(300);
		$(".mb_service-section button").removeClass('mb_section-active');
		$(this).children('ul').toggle(300);
		$(this).children('button').toggleClass('mb_section-active');
	});

	// Video settings and controls

	/* Setup video player */
	var iframe = document.querySelector('#mb_vimeo-hero');
	var player = new Vimeo.Player(iframe);

	/* Hide overlay bar on auto play */
	player.on('play', function() {
		console.log('played the video!');
		setTimeout(function () {
			$(".mb_video-overlay-bar").addClass("hide");
		}, 3000);
	});

	/* Turn off volume on auto play */
	player.ready().then(function() {
		console.log('player ready!');
		player.setVolume(0).then(function(volume) {});
		player.play().then(function() {});
	});

	// Mute Controls
	$(document).on("click", ".mb_mute",function(ev){
        if(this.className.search("mb_hero-unmuted") === -1){
			player.setVolume(1).then(function(volume) {});
            $(".mb_mute").addClass("mb_hero-unmuted");
        }else{
			player.setVolume(0).then(function(volume) {});
			//$("#mb_vimeo-hero").vimeo("setVolume", 0);
            $(".mb_mute").removeClass("mb_hero-unmuted");
        }
    });

	// Header top animations
	var stickyTop = $('.mb_global-header').offset().top - 60;

	$(window).on( 'scroll', function(){
		if ($(window).scrollTop() >= stickyTop) {
			$('body').addClass('mb_sticky-top');
		} else {
			$('body').removeClass('mb_sticky-top');
		}
	});
	var stickyTop2 = $('.mb_global-header').offset().top - 300;

	$(window).on( 'scroll', function(){
		if ($(window).scrollTop() >= stickyTop2) {
			$('body').addClass('mb_sticky-nav');
		} else {
			$('body').removeClass('mb_sticky-nav');
		}
	});


});

//<iframe id="" src="https://player.vimeo.com/video/'+ embed +'?loop=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
