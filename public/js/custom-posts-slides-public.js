(function( $ ) {
	'use strict';

	jQuery(document).ready(function() {
		var elem = document.querySelector('.flickity-carousel');
		var flkty = new Flickity(elem, {
			"pageDots": false, 
			"draggable": false,
			"accessibility": false,
			"prevNextButtons": false,
			on:{
				ready:function(){
					console.log('init Flickity')
				}
			}
		});
		flkty.on('change', function() {
			//
		});
		$('.custom-nav.next').click(function(){
			flkty.next();
		})
		$('.custom-nav.prev').click(function(){
			flkty.previous();
		})
		
	});

})( jQuery );
