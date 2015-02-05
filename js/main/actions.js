initialize: function() {

	// Google Analytics
	this.bind('route', this._pageView);

	// Matches the date segment of the URL, passing it to this.open
	// http://stackoverflow.com/a/17321430
	this.route(/\d{4}(?:\/\d{2})*/, "blogArticleAction");

},

// Send data to GA 
_pageView: function() {
  var path = Backbone.history.fragment;
  ga('send', 'pageview', {page: "/" + path});
},

defaultAction:function ( page ) {
    if ( page ) {
    
		//body.removeClass('home');
        //Now we have a url lets get the data (ok, we're getting the view also by calling a PHP file or WP_Query)
        this.loadPageData( page, 'page' );
		// Rewrite title element
	    rewriteTitle();
    }

},
homeAction:function () {

	this.loadPageData( 'home', 'home' );
	//$('body').removeClass('default');
	//$('body').addClass('home');

	// Add title
    title.text( siteName + ' is ' + siteTagline );

},
loadPageData:function ( page, template ) {
    
	// Get fragment
	var fragment = Backbone.history.fragment;

    // Rewrite title element
    rewriteTitle();
    
    // Highlight active link
    activeLink();
        	
	// Give name to this data ie page-bikes to act as key
	var cachePage = 'cache-' + page;
	
	// If page content is in the cache then retrieve and use it!
	if ( data.data( cachePage ) ) {
			processPage( page, data.data( cachePage ) );
	}
	
	// Otherwise get in touch with the server and generate the page content
	// and don't get sweaty, there be more caching on them there server
	else {

	    $.ajax({
			type : 'GET',
			url : GinAjax.ajaxurl,
			data : {
				action : 'get_' + template,
				fragment : fragment,
				WhiskeyNonce : GinAjax.WhiskeyNonce
			},
			beforeSend : function(){
				loading();
			}, 
			dataType : 'text',
	        success:function ( response ) {
	        	// Use our shiny new data
				processPage( page, response );
				// Write to cache
	            data.data( cachePage, response );
	            // Lazy load images
	            showImages();	
	        },
	        error:function () {
	            //Missing data, load 404 page.
	            content.load(stateURL + 'templates/404.php');
	        }
	    });
	}

	function processPage( page, data ){
		// Add class for loading() function
		body.addClass('success');
        //Once we receive the data, insert into the content element.
        content.html( data );
		//Fire up Flexslider slideshow
		slideshow();
		//Drop downs for touch
		submenu();
		// Show images
		showImages();
		// Highlight active page
		activeLink();
		// Beam me up Scottie (well to top of the page anyway)
		pageScroll();
	}

}