<?php
/*
Plugin Name: Plugin comment autogrow
Version: 1.0
Description: Makes the comment textarea expand in height automatically
Author: Alex Righetto
Author URI: https://github.com/alexrighetto
Plugin URI: https://github.com/alexrighetto/Plugin-textarea-autogrow
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
        die;
}

arcd_autogrow::init();

class arcd_autogrow {

	private static $needed;

	function init() {
		add_action( 'template_redirect', array( __CLASS__, 'add_script' ) );
		add_action( 'wp_footer', array( __CLASS__, 'init_script' ), 20 );
	}

	function add_script() {
		global $wp_query;

		self::$needed = is_singular() && 'open' == $wp_query->post->comment_status;

		if ( ! self::$needed )
			return;

		wp_enqueue_script( 'autosize', plugins_url( 'jquery.autosize.min.js', __FILE__ ), array( 'jquery' ), '2', true );
	}

	function init_script() {
		if ( ! self::$needed )
			return;

?>
<script type="text/javascript">
jQuery(document).ready(function($){ $('#comment').autosize(); });
</script>
<?php
	}
}
