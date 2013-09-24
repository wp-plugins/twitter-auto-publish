<?php
function twap_free_network_install($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				twap_install_free();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	twap_install_free();
}

function twap_install_free()
{
	
	global $current_user;
	get_currentuserinfo();
	if(get_option('xyz_credit_link')=="")
	{
		add_option("xyz_credit_link", '0');
	}


	add_option('xyz_twap_twconsumer_secret', '');
	add_option('xyz_twap_twconsumer_id','');
	add_option('xyz_twap_tw_id', '');
	add_option('xyz_twap_current_twappln_token', '');
	add_option('xyz_twap_twpost_permission', '1');
	add_option('xyz_twap_twpost_image_permission', '1');
	add_option('xyz_twap_twaccestok_secret', '');
	add_option('xyz_twap_twmessage', '{POST_TITLE} - {PERMALINK}');
	
	$version=get_option('xyz_twap_free_version');
	$currentversion=xyz_twap_plugin_get_version();
	update_option('xyz_twap_free_version', $currentversion);
	
	add_option('xyz_twap_include_pages', '0');
	add_option('xyz_twap_include_categories', 'All');
	add_option('xyz_twap_include_customposttypes', '');

}


register_activation_hook(XYZ_TWAP_PLUGIN_FILE,'twap_free_network_install');
?>