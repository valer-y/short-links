<?php

namespace App;

use App\CPT\CPT_Short_Links;
use App\Services\Columns\Short_Links_Admin_Custom_Columns;
use App\Services\EnqueueScriptsService;
use App\Services\GetCurrentUrlService;
use App\Services\Metaboxes\Short_Links_Metabox;
use App\Services\RedirectByShortLinkService;


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

        //enqueue styles and scripts
        (new EnqueueScriptsService($version))->add_styles_scripts();

        // register CPT 'short-links'
        (new CPT_Short_Links());

        // create metabox for CPT 'short-links'
        (new Short_Links_Metabox()) ;

        // add custom columns fot CPT 'short-links' admin
        (new Short_Links_Admin_Custom_Columns());

        add_action('save_post', [$this, 'my_add_meta_on_short_links_creation'], 10, 3);

        $this->if_make_redirect();

        return $this;
    }

    public function my_add_meta_on_short_links_creation($post_id, $post, $update) {
        // Only add meta if it's a new post
        if ($update) {
            return;
        }

        // Check the post type to ensure it's the correct CPT
        if ($post->post_type !== 'short-links') {
            return;
        }

        // Check if the meta key already exists and add if it does not
        if (!add_post_meta($post_id, 'openings', '0', true)) {
            add_post_meta($post_id, 'openings', '0', true);
        }
    }

    public function if_make_redirect() : void
    {
        /**
         * get current page url and redirect with RedirectByShortLinkService class
         * @uses $current_url, \App\Services\GetCurrentUrlService, \App\Services\RedirectByShortLinkService
         */

        add_action('template_redirect', function () {
            $this->current_url = (new GetCurrentUrlService())->get_url();

            $redirect = new RedirectByShortLinkService();
            $redirect($this->current_url);

        });
    }

    public function flush_rewrite_rules() : void {
        global $wp_rewrite;
        $wp_rewrite->flush_rules( true );
    }

}
