<?php

defined('SHORTLINKS_ROOT_ABS') || define('SHORTLINKS_ROOT_ABS', dirname(__DIR__, 2));
defined('SHORTLINKS_ETRYPOINT') || define('SHORTLINKS_ETRYPOINT', SHORTLINKS_ROOT_ABS . '/short-links.php');
defined('SHORTLINKS_ROOT_URL') || define('SHORTLINKS_ROOT_URL', plugin_dir_url(SHORTLINKS_ETRYPOINT));
defined('SHORTLINKS_ASSETS_URL') || define('SHORTLINKS_ASSETS_URL', SHORTLINKS_ROOT_URL . '/assets');
