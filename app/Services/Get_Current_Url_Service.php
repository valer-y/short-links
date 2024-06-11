<?php

namespace App\Services;

class Get_Current_Url_Service
{
    protected string $current_url = '';

    public function get_current_page_url()
    {
        global $wp;
        $this->current_url = home_url($wp->request);
    }

    public function get_url()
    {
        $this->get_current_page_url();
        return $this->current_url;
    }

}
