
});
// TequilaApp declaration

// Let's fire her up, Scottie - constructor
new TequilaApp();

// Let jQuery own $ variable (we're in no-conflict mode anyway)
//Backbone.$ = root.jQuery

// Support crappy old browsers
Backbone.emulateHTTP = true;
Backbone.emulateJSON = true;

//Initiate a new history and controller class
Backbone.history.start({
    pushState:true,
    root:stateURL
    });

$('#site').on('click', 'a[href]:not([data-bypass])', function(event) {
	// Get the absolute anchor href.
	var href = { prop: $(this).prop("href"), attr: $(this).attr("href") };
	
	// Get the absolute root.
	//var root = location.protocol + "//" + location.host + stateURL;
	var host = location.protocol + "//" + location.host;
	var path = location.pathname;

	// Store current page in body element
	// Used to navigate back to previous, kinda history hack
	data.data('currentPath', path);
	
	// This is where we are in the site
	var historyPath = data.data('currentPath').split( '/' )[1];
	data.data('historyPath', historyPath);

    // This is where we're going in the site
	var clickedPath = Backbone.history.fragment.split('/')[1];
	data.data('clickedPath', clickedPath);
	
	// Ensure the root is part of the anchor href, meaning it's relative.
	// However this assumes all links on the root are relative, irrespective
	// whether or not we're in root or a directory
	if ( (href.prop.slice(0, host.length) === host) && (!event.metaKey) ) {
	  // Stop the default event to ensure the link will not cause a page
	  // refresh.
	  event.preventDefault();
	
	  // `Backbone.history.navigate` is sufficient for all Routers and will
	  // trigger the correct events. The Router's internal `navigate` method
	  // calls this anyways.  The fragment is sliced from the root.

	  Backbone.history.navigate(href.attr, true);
	}
});
