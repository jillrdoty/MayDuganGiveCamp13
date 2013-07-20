<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package MayDuganGiveCamp13
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'maydugangivecamp13_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'maydugangivecamp13' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'maydugangivecamp13' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'maydugangivecamp13' ), 'MayDuganGiveCamp13', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>

	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/modernizr.js"></script>

	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/main.js"></script>

<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
		mathiasbynens.be/notes/async-analytics-snippet -->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-42539651-1', 'maydugancenter.org');
		ga('send', 'pageview');
	</script>

	<script>
		window.fbAsyncInit = function () {
			// init the FB JS SDK
			FB.init({
				appId: 'xxx', // App ID from the App Dashboard
				channelUrl: '//www.maydugancenter.org/channel.html', // Channel File for x-domain communication
				status: true, // check the login status upon init?
				cookie: true, // set sessions cookies to allow your server to access the session?
				xfbml: true  // parse XFBML tags on this page?
			});

			// Additional initialization code such as adding Event Listeners goes here

		};

		// Load the SDK's source Asynchronously
		// Note that the debug version is being actively developed and might 
		// contain some type checks that are overly strict. 
		// Please report such bugs using the bugs tool.
		(function (d, debug) {
			var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) { return; }
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
			ref.parentNode.insertBefore(js, ref);
		}(document, /*debug*/ false));
	</script>

</body>
</html>