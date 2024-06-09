<?php

require_once "Config/constants.php";

require_once SHORTLINKS_ROOT_ABS . "/vendor/autoload.php";

use App\App;

if(class_exists('App\App')) {
    App::get_instance()->init();
}
