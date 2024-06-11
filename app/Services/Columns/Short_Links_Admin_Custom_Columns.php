<?php

namespace App\Services\Columns;

class Short_Links_Admin_Custom_Columns
{
    public function __construct()
    {
        add_action('manage_short-links_posts_columns', [$this, 'custom_short_links_columns']);
        add_action('manage_short-links_posts_custom_column', [$this, 'custom_columns'], 10, 2);
        add_filter('manage_edit-short-links_sortable_columns', [$this, 'custom_columns_sort']);
    }

    public function custom_short_links_columns($columns)
    {
        $title = $columns['title'];
        $date = $columns['date'];


        $columns['title'] = $title;
        $columns['page_url'] = esc_html__('Page URL', 'short-links');
        $columns['full_link'] = esc_html__('Full Link', 'short-links');
        $columns['clicks'] = esc_html__('Clicks', 'short-links');
        $columns['filtered_clicks'] = esc_html__('Filtered Clicks', 'short-links');
        $columns['date'] = $date;


        return $columns;
    }

    public function custom_columns($column, $post_id)
    {
        $page_url = get_the_permalink($post_id);
        $full_link = get_post_meta($post_id, 'short_link_url', true);
        $clicks = get_post_meta($post_id, 'openings', true);
        $filtered_clicks = 1;

        switch ($column) {
            case 'page_url':
                esc_html_e($page_url);
                break;
            case 'full_link':
                esc_html_e($full_link);
                break;
            case 'clicks':
                esc_html_e($clicks);
                break;
            case 'filtered_clicks':
                esc_html_e($filtered_clicks);
            default:
                break;
        }
    }

    public function custom_columns_sort($columns)
    {
        $columns['page_url'] = 'page_url';
        $columns['full_link'] = 'full_link';
        $columns['clicks'] = 'clicks';
        $columns['filtered_clicks'] = 'filtered_clicks';

        return $columns;
    }
}
