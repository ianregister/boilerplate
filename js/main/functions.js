/* ==========================================================================
   Rewrite title elements except for home
   ========================================================================== */

function rewriteTitle(){
	// Get path
	var fragment = Backbone.history.fragment;
	// Split path into array
	var split = fragment.split('/');
	// And let's make it pretty by capitalising
	var niceTitle = split[0].charAt(0).toUpperCase() + split[0].substr(1);

	// Remove '-' from url path
	niceTitle = niceTitle.replace(/-/g , ' ');

    // Rewrite title tag element
    title.text(niceTitle + ' at ' + siteName);
}



/* ==========================================================================
   Select template ie view
   ========================================================================== */

/*
function action( page ) {
    return 'get_' + page;
}
*/



/* ==========================================================================
   Prevent default action on anchor elements if necessary 
   ========================================================================== */

$(document).on("click", "#site a.null", function(event) {
	event.preventDefault();
});




/* ==========================================================================
   Scroll to top
   ========================================================================== */

function pageScroll(){
	$('html, body').animate({ scrollTop: 0 }, 123);
}



/* ==========================================================================
   Scroll to top for Some page
   ========================================================================== */

$(document).on("click", "#site a.some-slug", function(event) {
	event.preventDefault();
	pageScroll();
});


/* ==========================================================================
   Scroll to <section> for Menu page
   ========================================================================== */

$(document).on("click", "#site a.scroll", function(event) {
	
	// Whoa, don't do anything crazy
	event.preventDefault();
	
	// Get section we want to scroll to
	var section = $(this).attr('href').split('/');
	
	// Get height from top of screen
	var destination = $( 'section.menu-' + section[2] ).offset().top;
	
	// Now scroll
	scrollToSection( destination );
	
	// Clear current active link
	$('.info-nav a').each(function() {
	    $(this).removeClass('active');
	});

	// Select link
    $('.info-nav').find('a[href="/menu/' + section[2] +'"]').addClass('active');	
	
});

// Scroll to top
function scrollToSection( section ){
	$('html,body').animate({scrollTop: section});
}


// TODO: fire this on Menu page only, make touch functional, don't keep running if already run
// Create the listener function
var detectScrollToTop = _.debounce(function(e) {

	// Does all the layout updating here
	var offset = $(window).scrollTop();

	if ( offset == 0 ) {
		setActiveLink();
	}
	
}, 50); // Maximum run of once per 50 milliseconds

// Add the event listener
window.addEventListener("scroll", detectScrollToTop, false);

// Clears current links and sets yummycakes to be highighted
function setActiveLink () {

	// Clear current active link
	$('.info-nav a').each(function() {
	    $(this).removeClass('active');
	});

	// Select link
    $('.info-nav').find('a[href="/menu/yummycakes"]').addClass('active');	


}



/* ==========================================================================
  Fire up Flexslider slideshow
   ========================================================================== */

function slideshow( thumbnails ) {

if ( thumbnails === false ) {
	$('.flexslider').flexslider({
		controlNav: true,
		useCSS: true,
		prevText: "",
		nextText: "",
		pauseOnAction: true,
		pauseOnHover: true,
		touch: true,
	    keyboard: true,
		slideshowSpeed: 5678,
		animationSpeed: 234,
		initDelay: 234
		});
}

else if ( thumbnails === true ) {

	  // The slider being synced must be initialized first
	  $('#thumbnails').flexslider({
	    controlNav: false,
		useCSS: true,
	    keyboard: false,
	    animationLoop: false,
	    slideshow: false,
		itemWidth: 140,
		itemMargin: 10,
	    asNavFor: '#carousel'
	  });
	   
	  $('#carousel').flexslider({
	    controlNav: false,
	    animationLoop: false,
	    slideshow: false,
		useCSS: true,
	    keyboard: false,
/* 		prevText: "", */
/* 		nextText: "", */
/* 		pauseOnAction: true, */
/* 		pauseOnHover: true, */
		touch: true,
/* 		slideshowSpeed: 5678, */
		animationSpeed: 100,
/* 		initDelay: 234 */
	    sync: "#thumbnails"
	  });
	  
	  $('#thumbnails li').removeAttr("style");
}
	// Prevent Flexslider controls being overridden by the app logic
	$('a.flex-next, a.flex-prev').attr('data-bypass','true');

	// Upgrade this puppy to keyboard control
	// Does something funny to forward and back commands.
	$(document).keydown(function(e){
	    if (e.keyCode === 37) { 
	       $('#carousel').flexslider("prev");
	       return false;
	    }
	    else if (e.keyCode === 39) { 
	       $('#carousel').flexslider("next");
	       return false;
	    }
	});

}

/*
function slideshow( page ) {

	var autoplay;

	// Set slideshow to cycle automatically or not ( Styling + Media is not )
	if ( page === 'styling-and-media' ) {
		autoplay = false;
	} else {
		autoplay = true;
	}
	
	// Fire up flexslider
	$('.flexslider').flexslider({
		controlNav: false,
	    slideshow: autoplay,
		useCSS: true,
		prevText: "",
		nextText: "",
		pauseOnAction: true,
		pauseOnHover: true,
		touch: true,
	    keyboard: true,
		slideshowSpeed: 4000,
		animationSpeed: 234,
		initDelay: 0
		});
	  
	// Prevent Flexslider controls being overridden by the app logic
	$('a.flex-next, a.flex-prev').attr('data-bypass','true');

}
*/



/* ==========================================================================
   Fire up Dropit plugin for touch screens
   ========================================================================== */

// Not entirely sure if this does anything other than add some classes
// More to the point it closes the dropdown on touch screens...
// ...so possibly there's a smarter way homeboy

function submenu() {
	if (Modernizr.touch) { 

		$('.menu').dropit();
	
	}
}



/* ==========================================================================
   Highlight active link and / or parent menu item
   ========================================================================== */

function activeLink(){

	// Clear current active link
	$('nav a').each(function() {
	    $(this).removeClass('active');
	});

	// Get path
	var fragment = Backbone.history.fragment;
    $('#logo-and-nav').find('a[href="/'+fragment+'"]').addClass('active');	

	// Split path into array
	var split = fragment.split('/');
	
	// Check if link page has children, if so highlight top level
    if ( split.length > 1 ){
		// Find parent of current link
	    $('#logo-and-nav').find('a[href="/'+fragment+'"]').parentsUntil('ul.menu').children('a').addClass('active');
    }



}



/* ==========================================================================
   Loading page
   ========================================================================== */

function loading(){

	// Remove success class from a previous ajax request during initial load
	body.removeClass('success');

	// If ajax request hasn't given success response within 500ms show loading page
	setTimeout(testSuccess, 500);

	function testSuccess(){
		if ( !body.hasClass('success') ){
			// Load in our loading page
			$('#content').load(stateURL + themeDir + 'templates/loading.php');
		}
	}
					
}


/* ==========================================================================
   Fire up unveil lazyload plugin with bonus retina image loader
   ========================================================================== */

function showImages(){
	// Sizzle up some images
	var images = $("img.unveil");
	
	// Let's see 'em
	images.unveil(0, function() {
		$(this).load(function() {
			this.style.opacity = 1;
		});
	});
	
	// Edge case, browser window transferred to retina screen
	$(window).resize(_.debounce(function(){
	    images.unveil();
	}, 500));
}


// Get Viewport (and perhaps some browser capabilities?)
// ================================================================================================

var a, viewport = {
    getWinWidth: function() {
        this.width = 0;
        if (window.innerWidth)
            this.width = window.innerWidth-18;
        else if (document.documentElement && document.documentElement.clientWidth)
            this.width = document.documentElement.clientWidth;
        else if (document.body && document.body.clientWidth)
            this.width = document.body.clientWidth
    },
    getWinHeight: function() {
        this.height = 0;
        if (window.innerHeight)
            this.height = window.innerHeight-18;
        else if (document.documentElement && document.documentElement.clientHeight)
            this.height = document.documentElement.clientHeight;
        else if (document.body && document.body.clientHeight)
            this.height = document.body.clientHeight
    },
    getScrollX: function() {
        this.scrollX = 0;
        if (typeof window.pageXOffset == "number")
            this.scrollX = window.pageXOffset;
        else if (document.documentElement && document.documentElement.scrollLeft)
            this.scrollX = document.documentElement.scrollLeft;
        else if (document.body && document.body.scrollLeft)
            this.scrollX = document.body.scrollLeft;
        else if (window.scrollX)
            this.scrollX = window.scrollX
    },
    getScrollY: function() {
        this.scrollY = 0;
        if (typeof window.pageYOffset ==
        "number")
            this.scrollY = window.pageYOffset;
        else if (document.documentElement && document.documentElement.scrollTop)
            this.scrollY = document.documentElement.scrollTop;
        else if (document.body && document.body.scrollTop)
            this.scrollY = document.body.scrollTop;
        else if (window.scrollY)
            this.scrollY = window.scrollY
    },
    getAll: function() {
        this.getWinWidth();
        this.getWinHeight();
        this.getScrollX();
        this.getScrollY()
    }
}


/* ==========================================================================
   Query form validation
   ========================================================================== */

var form = $('#beer-contact-form');
var inputs = $('#beer-contact-form input');


// Bind the submit event to the form
form.submit(function(event){ 

    // Stop the form from submitting
    event.preventDefault();

	// Set valid boolean
	var valid = true;

	// Check for validation errors
	inputs.each(function() {
		if( $(this).hasClass('error') ){
			valid = false;
		}
	});

	// Submit form
	if ( valid === true ) {
	
	    // Get the form data
	    var data = $(this).serialize();
	
		// Send data and get response
		sidebarForm(data);

	}

});


// Send form data to PHP processor function getQuery() in ajax.php
function processForm(data) {

    $.ajax({

		type : 'POST',
		url : TequilaApp.ajaxurl,
		data : {
			action : 'get_query',
			data : data,
			WhiskeyNonce : GinAjax.WhiskeyNonce
		},
		beforeSend : function(){
		}, 
        success:function (response) {

			$('#beer-contact-form-response').html(response);
			$('#beer-contact-form').slideUp('slow',function(){
					$('#beer-contact-form-thanks').fadeIn();
			});

        },
        error:function () {

			$('#beer-contact-form').slideUp('slow',function(){
					$('#beer-contact-form-error').fadeIn();
			});

        }
    });
}



/* ==========================================================================
   Get site title
   ========================================================================== */

function siteTitle() {

	var temp = null;

	$.ajax({
        async : false,
		type : 'GET',
		url : GinAjax.ajaxurl, // just ajaxurl is ok, WP default
		data : {
			action : 'get_site_title',
			WhiskeyNonce : GinAjax.WhiskeyNonce
		},
		dataType : 'text',
	    success:function ( response ) {
	    	temp = response;
	    },
	    error:function () {
	        //Missing data, load 404 page or display error message.
	    }
	});
	
	return temp;

}



/* ==========================================================================
   Get site tagline
   ========================================================================== */

function siteTagline() {

	var temp = null;

	$.ajax({
        async : false,
		type : 'GET',
		url : GinAjax.ajaxurl,
		data : {
			action : 'get_tagline',
			WhiskeyNonce : GinAjax.WhiskeyNonce
		},
		dataType : 'text',
	    success:function ( response ) {
	    	temp = response;
	    },
	    error:function () {
	        //Missing data, load 404 page or display error message.
	    }
	});

	return temp;

}




/* ==========================================================================
   Google Maps API
   ========================================================================== */

function initializeMap() {

	var canvas = $('.map-canvas');
	var latitude = canvas.attr('data-latitude');
	var longitude = canvas.attr('data-longitude');
    var location = new google.maps.LatLng(latitude, longitude);

    var mapOptions = {
        center: location,
        zoom: 14,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };        

    var map = new google.maps.Map(document.getElementById("home-map"), mapOptions);

	// Create marker for main map location
	
	// TODO	
	// This needs to display optionally toggled on/off in WP backend
/*
    var marker = new google.maps.Marker({
        position: location,
        map: map,
        // Needs be a backend ajax query using admin nonce not frontend nonce
        //title: siteTitle()
        title: ''
    });        
*/

	// Create array to store each "room" location
	var places = [];
	
	// Get all "room" location data
	$('.map-marker').each( function(){
		
		places.push([ 
			$(this).attr('data-title') ,
			$(this).attr('data-latitude') ,
			$(this).attr('data-longitude'),
			$(this).attr('data-address'),
			$(this).attr('data-url'),
			$(this).find('.map-room-features').html()
		]);
		
	});

	// Initialise info window variable explicitly
	var infoWindow;

	// Go!!
	setMarkers(map, places);
	
	infoWindow = new google.maps.InfoWindow({
		content: "Loading..."
	});

	

}

function setMarkers(map, locations) {

	// TODO 
	// Does z index need be user selectable?

	// Add markers to the map
	for (var i = 0; i < locations.length; i++) {
		var location = locations[i];
		
		var mapLatLng = new google.maps.LatLng(location[1], location[2]);
		var marker = new google.maps.Marker({
		    position: mapLatLng,
		    map: map,
		    title: location[0],
		    html: '<div class="map-info-window"><p class="map-info-window-title">' + location[0] + '</p><p>' + location[3] + '</br><a href="' + location[4] + '">Read More</a></p><span class="single-room-info">' + location[5] + '</span></div>'
		    //zIndex: location[3]
		});
		
		
		// Add content to info window
		google.maps.event.addListener(marker, "click", function () {
		    infoWindow.setContent(this.html);
		    infoWindow.open(map, this);
		});	
			
	}

}


function maps() {

	if (window.google && google.maps) {
	    // Map script is already loaded
	    initializeMap();
	} else {
		// Problem!
	}    

}



/* ==========================================================================
   Actions after window resize
   ========================================================================== */

$(window).resize(_.debounce(function(){

	// Reload Google Map & recentre (TODO deprecated iframe version only?)
    initializeMap();
    
}, 345));



/* ==========================================================================
   Sticky / Fixed nav
   - quick n dirty
   – redo so that font doesn't get anti-aliased with JS @font-face clash
   - animate transition
   
   Maybe upgrade to this bad boy
   http://wicky.nillia.ms/headroom.js/
   ========================================================================== */

function fixedNav() {
	
	// Check if we are mobile nav or full nav
	var mobile = $('.menu-toggle').css('display');
	
	var nav = $( 'nav' );
	var offset = nav.offset();
	
	$(window).scroll(function() {
	
		if ( ( $('body').scrollTop() > offset.top ) && ( mobile === 'none' ) ){
		    $( 'header' ).addClass('fixed');
		} else {
			$( 'header' ).removeClass('fixed');
		}    
	
	});
	

}




}); // End jQuery
