import $ from 'jquery';
require('jquery-inview');
// import v8n from "v8n";

$(function() {

	let width = $(window).width();
	$(window).resize(function() {
		width = $(window).width();
		if (width > 767) $('.pinAd-phoneAdSP').hide();
	});

	$('.Lazyload').on('inview', function(event, isInView) {
		if (isInView) {
			$(this).addClass('scroll_on1');
		} else {
			$(this).removeClass('scroll_on1');
		}
	});

	let position = $(window).scrollTop();
	const firstBtn_position = $('.sec0-freeTalkButton').offset().top + 50;
	const contact_position = $('#contact').offset();
	$(window).scroll(function() {
		position = $(window).scrollTop();
		if (position > firstBtn_position && position < contact_position.top - 50) {
			// $('.pinAd').fadeIn();
			// if (width < 768) $('.pinAd-phoneAdSP').fadeIn();
			if (width < 768) {
				$('.pinAd-phoneAdSP').fadeIn()
			} else {
				$('.pinAd').fadeIn();
			};
		} else {
			$('.pinAd').fadeOut();
			$('.pinAd-phoneAdSP').fadeOut();
			// if (width < 768) $('.pinAd-phoneAdSP').fadeOut();
		}
	});

	$('.popBlock').click(function() {
		$(this).children('div').slideToggle();
	});

	// // form
	// $('.form-field').on('keyup', function() {
	// 	console.log($(this).val());
	// 	console.log($(this).attr('name'));
	// });

});
