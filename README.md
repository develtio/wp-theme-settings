# Develtio - Theme settings
**Theme settings** boilerplate by develtio.com [develtio.com](https://develtio.com)

### Requirements:

* [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/)
* [ACF Builder](https://github.com/StoutLogic/acf-builder)
* [Develtio - Loader](https://github.com/develtio/wp-loader)

Structure
------------
```
src
├── acf
│   ├── options         # register option page
│   ├── components
│   ├── partials
│   └── fields
│       ├── options
│       ├── post-types
│       ├── taxonomies
│       ├── pages
│       └── other
├── post-types
└── taxonomies
```

Examples - ACF
------------

### Register options

`src/acf/options/theme.php`

```php
namespace Develtio\WP\ThemeSettings;

$parent = acf_add_options_page(
    [
        'page_title' => 'Theme settings',
        'menu_title' => 'Theme settings',
        'menu_slug' => 'options_theme',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-smiley',
        'redirect' => false,
        'position' => 5,
    ]
);

acf_add_options_sub_page(
    [
        'page_title' => 'Analytics',
        'menu_title' => 'Analytics',
        'parent_slug' => 'options_theme',
        'menu_slug' => $parent['menu_slug'] . '_analytics',
    ]
);
```

`src/acf/options/news.php`

```php
namespace Develtio\WP\ThemeSettings;

acf_add_options_page(
    [
        'page_title' => 'News settings',
        'menu_title' => 'News settings',
        'menu_slug' => 'options_news',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-smiley',
        'redirect' => false,
        'position' => 2,
        'parent_slug' => 'edit.php?post_type=news',
    ]
);
```

### Components

`src/acf/components/header.php`

```php
namespace Develtio\WP\ThemeSettings;

use StoutLogic\AcfBuilder\FieldsBuilder;

$fields = new FieldsBuilder('header');

$fields
    ->addText('title')
    ->addTextarea('description');

return $fields;
```

### Fields

`src/acf/fields/pages/template-home.php`

```php
namespace Develtio\WP\ThemeSettings;

use StoutLogic\AcfBuilder\FieldsBuilder;

$fields = new FieldsBuilder('template_home', ['title' => 'Template Home']);

$fields->setLocation('page_template', '==', 'views/template-home.blade.php');

$fields
    ->addTab('header')
    ->addGroup('header')
    ->addFields(Settings::getFieldPartial('components.header'))
    ->endGroup()
    ->addTab('cards')
    ->addText('cards_section_title')
    ->addRepeater('cards')
    ->addFields(Settings::getFieldPartial('components.card'))
    ->endRepeater();

return $fields;
```
