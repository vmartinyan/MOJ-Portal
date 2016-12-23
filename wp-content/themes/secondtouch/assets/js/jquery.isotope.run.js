/* Portfolio Sorting */


jQuery(document).ready(function () {
	(function ($) {
		var container = $('.works-list');
		var $sorting_buttons = $('.sort-panel .filter a');
		container.imagesLoaded(function () {

			container.isotope( {
				itemSelector : '.project',
				layoutMode : 'fitRows',
				resizable : false
			} );
		} );

		$($sorting_buttons).click(function () {
			var selector = $(this).attr('data-filter');


			$(this).parent().parent().find('> li.active').removeClass('active');


			$(this).parent().addClass('active');


			container.isotope( {
				filter : selector
			} );

			return false;
		} );




		$sorting_buttons.each( function(){

			var selector = $(this).attr('data-filter');
			var count = container.find(selector).length;

			if (count == 0){
				$(this).css('display','none');
			} else {
				$(this).css('display','inline-block');
			}

		});



	} )(jQuery);
} );

