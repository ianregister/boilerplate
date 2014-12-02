jQuery(document).ready(function($){

// Let's get app-ing
// Target element is "#content"
// ================================================================================================

// Note: this only works if main.js is last script on page
var rootDir  = $("script[src]").next().attr("src").split('?')[0].split('/').slice(0, -4).join('/')+'/';

// Set root (come on make this programmatic hey)
var stateURL = '/';
var themeDir = 'wp-content/themes/beer/';
var siteName = 'Beer';
var siteTagline = '';
var title = $('title');
var body = $('body');

// Set element to hold state data
var data = $('#site');

// Main content element
var content = $('#content');

// Unhide site
body.removeClass('hidden');

// Define and declare the app
var TequilaApp = Backbone.Router.extend({

