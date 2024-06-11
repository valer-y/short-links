<?php

namespace App\Services;

class RedirectByShortLinkService
{

    /**
     * check short-links url from CPT and redirects if matches with actual URL
     */

    public function __invoke( string $current_url = '') : void
    {
        $short_links = new \WP_Query(
            [
                'post_type' => 'short-links'
            ]
        );

        if($short_links->have_posts()) {
            while ($short_links->have_posts()) {
                $short_links->the_post();

                if($this->filter_link(get_the_permalink()) === $this->filter_link($current_url)) {

                    $post_id = get_the_ID();
                    $redirection_url = get_post_meta($post_id)['short_link_url'][0];

                    if(array_key_exists($current_url, $_SESSION)) {

                        $double_click_time_gap = time() - $_SESSION[$current_url];
                        if($double_click_time_gap > DOUBLE_CLICK_TIME ) {
                            var_dump($double_click_time_gap);
                            die(); //##
                        }

                    }
                    $_SESSION[$current_url] = time();
//
//                    var_dump($_SESSION);
//                    die();

                    $openings_initial_value = get_post_meta($post_id, 'openings', true);
                    update_post_meta($post_id, 'openings', ++$openings_initial_value);

                    wp_redirect( sanitize_url($redirection_url) );
                }
            }
        }
    }

    protected function filter_link( string $link) : string
    {
        return rtrim($link, '/');
    }
}
