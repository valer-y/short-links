<?php

namespace App\Services;

class Set_Session_Service
{
    public static function session() {

        if( ! isset($_SESSION) ) {
            session_start();

            if( ! array_key_exists('session_id', $_SESSION)) {
                $_SESSION['session_id'] = time();
            }
        }

        // destroy expired session
        if(time() - $_SESSION['session_id'] > SHORTLINKS_SESSION_LIVE_TIME) {
            session_destroy();
        }

    }
}
