<?php 

function custom_code_in_head() {
    // Add your Google Tag Manager code
    echo '<!-- Google Tag Manager Head -->';
    echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NS2B6X4');</script>";
    
    // Add the custom redirection code
    echo "<script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(function () {
            // Normalize the path by removing trailing slash if it exists
            const path = window.location.pathname.replace(/\/$/, '');
            
            // Check if the current page is /free-trial
            if (path === '/free-trial') {
                // Get the session source from Google Analytics
                gtag('get', 'GA_MEASUREMENT_ID', 'session', function (sessionData) {
                    const sessionSource = sessionData && sessionData.source;

                    // Check if the session source is 'visual-studio'
                    if (sessionSource === 'visual-studio') {
                        // Redirect to the desired URL
                        window.location.href = '/free-trial-visual-studio';
                    }
                });
            }
        });
    </script>";
    echo '<!-- End Google Tag Manager Head -->';
}
add_action('wp_head', 'custom_code_in_head', 1);



function custom_code_in_bottom_head() {

	echo "<script> var _mtm = window._mtm = window._mtm || []; _mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'}); var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];g.async=true; g.src='https://cdn.matomo.cloud/incredibuildcn.matomo.cloud/container_ybzNzP2o.js'; s.parentNode.insertBefore(g,s);</script>";

    echo '<script src="https://cdn.userway.org/widget.js" data-account="prbt1ipXqE"></script>';
	
	echo '<!-- Start of incredibuildsoftwareltd Zendesk Widget script -->
	<script id="ze-snippet" src="
	https://static.zdassets.com/ekr/snippet.js?key=b95103f6-1389-446e-8cc9-46b10666516a">
	</script>
	<!-- End of incredibuildsoftwareltd Zendesk Widget script -->';


}
add_action('wp_head', 'custom_code_in_bottom_head');

function custom_code_after_body_open() {
    // Add your custom code, like GTM's noscript tag here
	echo '<!-- Google Tag Manager (noscript) -->';
	echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NS2B6X4"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
	echo '<!-- End Google Tag Manager (noscript) -->';
}
// Hook it into 'wp_body_open', which is available for modern themes.
add_action('wp_body_open', 'custom_code_after_body_open');


function custom_code_before_body_end() {
    // Add your custom code here
    echo '<!--6Sense-->';
	echo "<script>
		window._6si = window._6si || [];
		window._6si.push(['enableEventTracking', true]);
		window._6si.push(['setToken', '63a868fd2a3f7e6a91dc219e83d43da4']);
		window._6si.push(['setEndpoint', 'b.6sc.co']);
	
		
	
		(function() {
		  var gd = document.createElement('script');
		  gd.type = 'text/javascript';
		  gd.async = true;
		  gd.src = '//j.6sc.co/6si.min.js';
		  var s = document.getElementsByTagName('script')[0];
		  s.parentNode.insertBefore(gd, s);
		})();
	</script>";
}
add_action('wp_footer', 'custom_code_before_body_end');

