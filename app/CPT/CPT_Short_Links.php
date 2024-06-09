<?php

namespace App\CPT;

use App\Contracts;

if (!class_exists('App\CPT\CPT_Short_Links')) {

    class CPT_Short_Links implements Contracts\CPT_Interface {

        public function __construct() {

            add_action('init', array($this, 'register_post_type'));
        }

        public function register_post_type() {
            $args = array(
                'label'                 => __('Short Links', 'short-links'),
                'description'           => __('A custom post type for short links', 'short-links'),
                'labels'                => $this->labels(),
                'supports'              => array('title'),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => false,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
            );

            register_post_type('short-links', $args);
        }

        public function labels() : array
        {
            return  array(
                'name'                  => _x('Short Links', 'Post Type General Name', 'short-links'),
                'singular_name'         => _x('Short Link', 'Post Type Singular Name', 'short-links'),
                'menu_name'             => __('Short Links', 'short-links'),
                'name_admin_bar'        => __('Short Link', 'short-links'),
                'archives'              => __('Short Link Archives', 'short-links'),
                'attributes'            => __('Short Link Attributes', 'short-links'),
                'parent_item_colon'     => __('Parent Short Link:', 'short-links'),
                'all_items'             => __('All Short Links', 'short-links'),
                'add_new_item'          => __('Add New Short Link', 'short-links'),
                'add_new'               => __('Add New', 'short-links'),
                'new_item'              => __('New Short Link', 'short-links'),
                'edit_item'             => __('Edit Short Link', 'short-links'),
                'update_item'           => __('Update Short Link', 'short-links'),
                'view_item'             => __('View Short Link', 'short-links'),
                'view_items'            => __('View Short Links', 'short-links'),
                'search_items'          => __('Search Short Link', 'short-links'),
                'not_found'             => __('Not found', 'short-links'),
                'not_found_in_trash'    => __('Not found in Trash', 'short-links'),
                'featured_image'        => __('Featured Image', 'short-links'),
                'set_featured_image'    => __('Set featured image', 'short-links'),
                'remove_featured_image' => __('Remove featured image', 'short-links'),
                'use_featured_image'    => __('Use as featured image', 'short-links'),
                'insert_into_item'      => __('Insert into short link', 'short-links'),
                'uploaded_to_this_item' => __('Uploaded to this short link', 'short-links'),
                'items_list'            => __('Short Links list', 'short-links'),
                'items_list_navigation' => __('Short Links list navigation', 'short-links'),
                'filter_items_list'     => __('Filter short links list', 'short-links'),
            );
        }

    }

}
