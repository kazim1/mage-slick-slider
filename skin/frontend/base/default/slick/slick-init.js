/**
 * initializing all slider in this file.
 */

jQuery(function($) {

	if(typeof(registered_slick_sliders) != 'undefined') {
		registered_slick_sliders.forEach(function(slider) {
			try {
				$(slider.ele).slick(slider.params);
			} catch(e) {
				console.log('Error initializing slick slider: ', slider.ele);
				console.error(e);
			}
		});
	}
	
});
