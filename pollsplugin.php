<?php
/*
Plugin Name: Polls Plugin
Description: Create beautifull Polls for your site the easy way.
Author: arsennolan
Version: 1.0.0
*/

global $wpdb;

define('SP_VERSION',	'1.1');
define('SP_DIR',		dirname(__FILE__).'/');
define('SP_FILE',		__FILE__);
define('SP_URL',		get_bloginfo('url').'/wp-content/plugins/polls-plugin/');

define('SP_TABLE',		$wpdb->get_blog_prefix().'sp_polls');

if(!function_exists('add_action' )){
	echo 'Error';
	exit;
}

require('lib/polls.php');
require('lib/admin.php');

add_shortcode('poll', 'simplyPoll');

register_activation_hook(__FILE__, 'sp_main_install');

if(is_admin()){
	global $spAdmin;
	$spAdmin = new EasyPolls();
}

function simplyPoll($args){	
	
	global $simplyPoll;
	
	$simplyPoll = new SimplyPoll();
	return $simplyPoll->displayPoll($args);
	
}

function sp_main_install() {
	global $wpdb;
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".SP_TABLE."` (
					`id` INT NOT NULL AUTO_INCREMENT ,
					`question` VARCHAR( 512 ) NOT NULL ,
					`answers` TEXT NOT NULL ,
					`added` INT NOT NULL ,
					`active` INT NOT NULL ,
					`totalvotes` INT NOT NULL ,
					`updated` INT NOT NULL ,
					PRIMARY KEY (  `id` )
				) ENGINE = MYISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;");
}
define ('PS_PLUGIN_BASE_DIR', WP_PLUGIN_DIR, true);