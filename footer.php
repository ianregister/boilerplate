	</section>
	<!-- /content -->

	<footer>
	
		<p>&copy; <?php the_date('Y'); ?> Beer. All rights reserved. Site by <a href="http://ianregister.com" title="Ian Register is a Melbourne based web developer" target="_blank">Ian Register</a>.</p>

	</footer>

</div>
<!-- End of #site -->

<!-- Hey, it's ok, we're not using jQuery or Backbone in the front end through plugins -->

<?php wp_footer(); ?>

<!-- Does this need to be before the CSS link? -->
<!--[if (gte IE 6)&(lte IE 8)]>
<script src="<?php echo get_template_directory_uri(); ?>/js/app/plugins/selectivizr.1.0.2.min.js"></script>
<![endif]-->

<script>
(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
e=o.createElement(i);r=o.getElementsByTagName(i)[0];
e.src='//www.google-analytics.com/analytics.js';
r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
ga('create','UA-XXXXXXXX-1');ga('send','pageview');
</script>

<?php if ( LOCAL ) : ?>
<script async src='//<?php echo($_SERVER['HTTP_HOST']); ?>:3000/browser-sync/browser-sync-client.1.9.1.js'></script>
<?php endif; ?>

</body>
</html>