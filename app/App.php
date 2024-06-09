<?php

namespace App;

use App\Services\EnqueueScriptsService;
use App\Services\GetCurrentUrlService;


class App extends Singleton
{
    protected string $current_url = '';

    /**
     * initialize plugin's scripts and styles
     * @uses \App\Services\EnqueueScriptsService
     */

    public function init($version = '0.1.0') : Singleton
    {
        register_activation_hook(SHORTLINKS_ETRYPOINT, array($this, 'flush_rewrite_rules'));

        /** enqueue styles and scripts */
        (new EnqueueScriptsService($version))->add_styles_scripts();

        $this->get_page_url();

        return $this;
    }

    public function get_page_url() : void
    {
        /**
         * get current page url and store it
         * @uses $current_url, \App\Services\GetCurrentUrlService
         */

        add_action('template_redirect', function () {
            $this->current_url = (new GetCurrentUrlService())->get_url();
        });
    }

    public function flush_rewrite_rules() : void {
        global $wp_rewrite;
        $wp_rewrite->flush_rules( true );
    }

}
