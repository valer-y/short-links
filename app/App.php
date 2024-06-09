<?php

namespace App;

use App\CPT\CPT_Short_Links;
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

        /** register CPT 'short-links' */
        (new CPT_Short_Links());

        $this->get_page_url();

        return $this;
    }


    public static function short_links_pt()
    {
        register_post_type('short-links',
            array(
                'public' => false,
                'has_archive' => false,
                'label' => 'Short Link',
                'supports' => ['title']
            ));
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
