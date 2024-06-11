<?php

namespace App;

use App\CPT\CPT_Short_Links;
use App\Services\Columns\Short_Links_Admin_Custom_Columns;
use App\Services\Enqueue_Scripts_Service;
use App\Services\Get_Current_Url_Service;
use App\Services\Metaboxes\Short_Links_Meta;
use App\Services\Metaboxes\Short_Links_Metabox;
use App\Services\Redirect_By_Short_Link_Service;
use App\Services\Set_Session_Service;


class App extends Singleton
{
    protected string $current_url = '';

    /**
     * initialize plugin's scripts and styles
     * @uses \App\Services\Enqueue_Scripts_Service
     */
    public function init($version = '0.1.0') : Singleton
    {
        register_activation_hook(SHORTLINKS_ETRYPOINT, array($this, 'flush_rewrite_rules'));

        //enqueue styles and scripts
        (new Enqueue_Scripts_Service($version))->add_styles_scripts();

        // register CPT 'short-links'
        (new CPT_Short_Links());

        // create metabox for CPT 'short-links'
        (new Short_Links_Metabox()) ;

        // add custom columns for CPT 'short-links' admin
        (new Short_Links_Admin_Custom_Columns());

        // add meta-fields CPT 'short-links'
        add_action('save_post', [Short_Links_Meta::class, 'add_meta_on_short_links_creation'], 10, 3);

        // create or destroy $_SESSION
        add_action( 'init', [Set_Session_Service::class, 'session'] );

        $this->if_make_redirect();

        return $this;
    }


    public function if_make_redirect() : void
    {
        /**
         * get current page url and redirect with RedirectByShortLinkService class
         * @uses $current_url, \App\Services\Get_Current_Url_Service, \App\Services\Redirect_By_Short_Link_Service
         */

        add_action('template_redirect', function () {
            $this->current_url = (new Get_Current_Url_Service())->get_url();

            $redirect = new Redirect_By_Short_Link_Service();
            $redirect($this->current_url);

        });
    }

    public function flush_rewrite_rules() : void {
        global $wp_rewrite;
        $wp_rewrite->flush_rules( true );
    }

}
