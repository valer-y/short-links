<?php
/**
 * Plugin Name:     Short Links Test
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     short-links-test
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Short_Links_Test
 */

defined('ABSPATH') || exit;

defined('SHORTLINKS_ROOT_ABS') || define('SHORTLINKS_ROOT_ABS', dirname(__DIR__, 2));
defined('SHORTLINKS_ETRYPOINT') || define('SHORTLINKS_ETRYPOINT', SHORTLINKS_ROOT_ABS . '/short-links.php');
defined('SHORTLINKS_ROOT_URL') || define('SHORTLINKS_ROOT_URL', plugin_dir_url(__FILE__));
defined('SHORTLINKS_ASSETS_URL') || define('SHORTLINKS_ASSETS_URL', SHORTLINKS_ROOT_URL . '/assets');
defined('DOUBLE_CLICK_TIME') || define('DOUBLE_CLICK_TIME', 2 * MINUTE_IN_SECONDS);

require_once "vendor/autoload.php";




