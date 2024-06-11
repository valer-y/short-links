<?php

namespace App\Services\Metaboxes;

class Short_Links_Meta
{
    public static function add_meta_on_short_links_creation($post_id, $post, $update) {
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

        if (!add_post_meta($post_id, 'filtered_openings', '0', true)) {
            add_post_meta($post_id, 'filtered_openings', '0', true);
        }
    }
}
