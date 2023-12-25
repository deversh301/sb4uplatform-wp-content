jQuery(document).ready(function($){
	"use strict";
	var careerup_upload;
	var careerup_selector;

	function careerup_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		careerup_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( careerup_upload ) {
			careerup_upload.open();
			return;
		} else {
			// Create the media frame.
			careerup_upload = wp.media.frames.careerup_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			careerup_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = careerup_upload.state().get('selection').first();

				careerup_upload.close();
				careerup_selector.find('.upload_image').val(attachment.attributes.url).change();
				if ( attachment.attributes.type == 'image' ) {
					careerup_selector.find('.careerup_screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		careerup_upload.open();
	}

	function careerup_remove_file(selector) {
		selector.find('.careerup_screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').on('click', '.careerup_upload_image_action .remove-image', function(event) {
		careerup_remove_file( $(this).parent().parent() );
	});

	$('body').on('click', '.careerup_upload_image_action .add-image', function(event) {
		careerup_add_file(event, $(this).parent().parent());
	});

});