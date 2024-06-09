<?php

namespace App;

class App extends Singleton
{
    protected function __construct()
    {
        parent::__construct();
    }

    /**
     * initialize plugin's scripts and styles
     */
    public function init() : Singleton
    {
        $instance = self::get_instance();

        register_activation_hook(SHORTLINKS_ETRYPOINT, array($this, 'flush_rewrite_rules'));
        $this->add_styles_scripts();

        return $instance;
    }

    public function flush_rewrite_rules() : void {
        global $wp_rewrite;
        $wp_rewrite->flush_rules( true );
    }

    public function add_styles_scripts() : void
    {
        add_action( 'admin_enqueue_scripts', array( $this, 'plugin_style_scripts') );
    }

    public function plugin_style_scripts () : void
    {
        $this->admin_style_scripts();
        $this->front_style_scripts();
    }

    public function admin_style_scripts() : void
    {
        wp_enqueue_style('shortlinks_admin_style', SHORTLINKS_ASSETS_URL . "/admin/css/style.css", [], '1.0');
    }

    public function front_style_scripts() : void
    {
        /** TODO: add front styles and scripts if needed **/
    }
}
