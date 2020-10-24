<?php

namespace Develtio\WP\ThemeSettings;

use Develtio\WP\Loader\GroupLoader;
use Develtio\WP\Loader\TypesLoader;
use Develtio\WP\Loader\SampleLoader;
use Develtio\WP\Loader\FieldsBuilderLoader;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Settings
{
    public function init(): void
    {
        $this->removeAcfDashboard();
        $this->loadTypes();
        $this->loadFields();

        (new Custom())->init();
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

    private function loadTypes(): void
    {
        $gl = new GroupLoader();
        $gl->add(new TypesLoader(__DIR__ . '/post-types/*.php'));
        $gl->add(new TypesLoader(__DIR__ . '/taxonomies/*.php'));
        $gl->run();
    }

    private function loadFields(): void
    {
        $gl = new GroupLoader();
        $gl->add(new SampleLoader(__DIR__ . '/acf/options/*.php'));
        $gl->add(new FieldsBuilderLoader(__DIR__ . '/acf/fields/**/*.php'));
        $gl->run();
    }

    public static function getFieldPartial(string $partial): FieldsBuilder
    {
        $partial = str_replace('.', '/', $partial);

        return include(__DIR__ . "/acf/{$partial}.php");
    }
}