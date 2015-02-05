WordPress Starter Theme
===


Install
-------

[Optional shell script](https://github.com/ianregister/utilities/blob/master/wordpress.sh)


Getting Started
---------------

* `wp-config.php` needs `define( LOCAL, true );` to ensure Browser Sync is functional
* Set local hostname in `GruntFile.js`
* Change project title in `package.json`
* Ensure latest versions in `package.json`
* Confirm Browser Sync version in `footer.php`



Find & Replace
--------------

* `Beer`				project title
* `beer_`				namespace PHP and JS functions
* `whiskey-nonce`		nonce in PHP
* `WhiskeyNonce`		nonce variable in PHP 
* `GinAjax`				JS AJAX reference
* `TequilaApp`			JS app initialise



Structure
---------

* PHP template files `single.php`, `page.php`, `archive.php` all look for content in the `templates` directory

