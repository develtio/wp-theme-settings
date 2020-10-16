<?php

namespace Develtio\WP\ThemeSettings;

class Settings
{
    public function init(): void
    {
        $this->removeImageSizes();
        $this->removeAdminMenuItems();
        $this->addMimeTypes();
        $this->removeGutenberg();
        $this->removeAdminBarStyles();
        $this->removeAcfDashboard();
    }

    private function removeImageSizes(): void
    {
        add_filter(
            'intermediate_image_sizes_advanced',
            function ($sizes) {
                unset($sizes['medium']);
                unset($sizes['medium_large']);
                unset($sizes['large']);

                return $sizes;
            }
        );
    }

    private function removeAdminMenuItems(): void
    {
        add_action('admin_menu', function () {
            remove_menu_page('edit.php');
            remove_menu_page('edit-comments.php');
        });
    }

    private function addMimeTypes(): void
    {
        add_filter('upload_mimes', function ($mimes) {
            $mimes['svg'] = 'image/svg+xml';

            return $mimes;
        });
    }

    private function removeGutenberg(): void
    {
        add_filter('use_block_editor_for_post', '__return_false');
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_style('wp-block-library');
        });
    }

    private function removeAdminBarStyles(): void
    {
        add_action('get_header', function () {
            remove_action('wp_head', '_admin_bar_bump_cb');
        });
    }

    private function removeAcfDashboard(): void
    {
        add_filter('acf/settings/show_admin', '__return_false');
        add_action('current_screen', function () {
            $screen = get_current_screen();

            if ($screen && $screen->post_type === 'acf-field-group') {
                wp_redirect(admin_url());
                exit();
            }
        });
    }
}