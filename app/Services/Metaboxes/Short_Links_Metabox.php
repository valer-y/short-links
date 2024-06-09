<?php

namespace App\Services\Metaboxes;

class Short_Links_Metabox
{
    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_short_link_metabox']);
        add_action('save_post', [$this, 'save_metabox'], 10, 2);
    }

    public function add_short_link_metabox() {
        add_meta_box(
            'short_link_details',
            __('Link info', 'short-links'),
            array($this, 'render_short_link_metabox'),
            'short-links',
            'normal',
            'default'
        );
    }

    public function save_metabox($post_id, $post)
    {
        $link = $_POST['short_link_url'] ?? null;
        $nonce = $_POST['_link_field_wpnonce'] ?? null;
        $post_type = get_post_type_object($post->post_type);

        /** prevent from saving if:
         * - not verified nonce
         * - user have no capabilities
         * - autosave in progress
         */
        if( (!isset($nonce) && !wp_verify_nonce($nonce, 'short_link_field')) &&
            (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) &&
            (!current_user_can($post_type->cap->edit_post, $post_id))
        ) {
            return $post_id;
        }

        if(is_null($link)) {
            delete_post_meta($post_id, 'short_link_url');
        } else {
            update_post_meta($post_id, 'short_link_url', sanitize_url($link));
        }
    }

    public function render_short_link_metabox($post) {

        $link = get_post_meta($post->ID, 'short_link_url', true);

        wp_nonce_field('short_link_field', '_link_field_wpnonce');

        echo <<<HTML
            <label for="short_link_url"><?php //_e('Short Link URL:', 'short-links'); ?></label>
            <input type="url" id="short_link_url" name="short_link_url" value="{$link}" style="width: 100%;" />
        HTML;
    }

}
