jQuery(document).ready( function($) {


	/* ==========================================================================
	   Get site title
	   ========================================================================== */
	
	$.ajax({
		type : 'GET',
		url : ajaxurl, // just ajaxurl is ok, WP default
		data : {
			action : 'get_site_title',
			UE_Nonce : UE_Admin_Ajax.UE_Admin_Nonce
		},
		dataType : 'text',
	    success:function ( response ) {
	    	// Use our shiny new data
			$('.acf-site-title input').each(function() {
				// Ensure we've not already saved a value to the DB for this
				if ( $( this ).attr('value') === '' ) {
					$( this ).val(response);
				}
			});
	    },
	    error:function () {
	        //Missing data, load 404 page or display error message.
	    }
	});




	/* ==========================================================================
	   Get site tagline
	   ========================================================================== */


	
	$.ajax({
		type : 'GET',
		url : ajaxurl,
		data : {
			action : 'get_tagline',
			UE_Nonce : UE_Admin_Ajax.UE_Admin_Nonce
		},
		dataType : 'text',
	    success:function ( response ) {
	    	// Use our shiny new data
			$('.acf-tagline input').each(function() {
				// Ensure we've not already saved a value to the DB for this
				if ( $( this ).attr('value') === '' ) {
					$( this ).val(response);
				}
			});	
	    },
	    error:function () {
	        //Missing data, load 404 page or display error message.
	    }
	});


} );
