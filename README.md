<p align="center">
    <a href="https://symfony.com" target="_blank">
        <img height="80" src="https://raw.githubusercontent.com/develtio/assets/master/logo/logo.svg">
    </a>
</p>

# Develtio - Theme settings
**Theme settings** boilerplate by develtio.com [develtio.com](https://develtio.com)

Installation
------------
```
composer create-project develtio/wp-theme-settings
```

Structure
------------
```
src
├── acf                     # ACF - Settings
│   ├── options             # Register options page
│   └── fields              # Fields: FieldsBuilder
│       ├── components      
│       ├── partials
│       ├── options
│       ├── post-types
│       ├── taxonomies
│       ├── pages
│       └── other
├── post-types              # Register post-types
└── taxonomies              # Register taxonomies
```

Examples - ACF
------------
### Requirements:

* [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/)
* [ACF Builder](https://github.com/StoutLogic/acf-builder)

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

Examples - Types
------------

### Register post-types

`src/post-types/blog.php`

```php
namespace Develtio\WP\ThemeSettings;

$postTypeArgs = function () {
    $labels = [
        'name' => _x('Blog', 'post type general name', 'develtio'),
        'singular_name' => _x('Blog', 'post type singular name', 'develtio'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 40,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'blog', 'with_front' => false],
    ];

    return $args;
};

register_post_type('blog', $postTypeArgs());
```

### Register taxonomies

`src/taxonomies/blog.php`

```php
namespace Develtio\WP\ThemeSettings;

$taxonomyArgs = function () {
    $labels = [
        'name' => _x('Blog categories', 'taxonomy general name', 'develtio'),
        'singular_name' => _x('Blog category', 'taxonomy singular name', 'develtio'),
    ];

    $args = [
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => false,
    ];
    return $args;
};

register_taxonomy('blog_cat', ['blog'], $taxonomyArgs());
```
