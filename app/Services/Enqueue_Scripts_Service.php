<?php

namespace App\Services;

class Enqueue_Scripts_Service
{
    protected string $version = '';

    public function __construct($version)
    {
        $this->version = $version;
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
        /* TODO: add front styles and scripts if needed */
    }
}
