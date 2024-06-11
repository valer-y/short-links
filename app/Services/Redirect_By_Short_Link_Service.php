<?php

namespace App\Services;

class Redirect_By_Short_Link_Service
{
    // check short-links url from CPT and redirects if matches with actual URL
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
                    wp_redirect( sanitize_url($this->count_openings($post_id, $current_url)) );
                }

            }
        }
    }

    // count openings with or without double click and save it to related meta-fields
    protected function count_openings($post_id, $current_url)
    {
            if( ! array_key_exists($current_url, $_SESSION)) {
                $_SESSION[$current_url] = 0;
            }

            if(array_key_exists($current_url, $_SESSION)) {

                $double_click_time_gap = time() - $_SESSION[$current_url];
                if($double_click_time_gap > SHORTLINKS_DOUBLE_CLICK_TIME ) {

                    $filtered_openings_initial_value = get_post_meta($post_id, 'filtered_openings', true);
                    update_post_meta($post_id, 'filtered_openings', ++$filtered_openings_initial_value);
                }

                $_SESSION[$current_url] = time();
            }

            $openings_initial_value = get_post_meta($post_id, 'openings', true);
            update_post_meta($post_id, 'openings', ++$openings_initial_value);

            return get_post_meta($post_id)['short_link_url'][0];
    }

    protected function filter_link( string $link) : string
    {
        return trim( rtrim($link, '/') );
    }
}
