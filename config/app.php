<?php

declare(strict_types=1);

use function DI\env;

return [

    /**
     * Enable application debugging and display error messages.
     *
     * !!!  WARNING  !!!  WARNING  !!!  WARNING  !!!  WARNING  !!!  WARNING  !!!
     * It is recommended that debug remains OFF unless troubleshooting an issue.
     * Leaving this enabled WILL cause leakage of sensitive server information.
     *
     * Default value: false
     */
    'debug' => env('APP_DEBUG', false),

    /**
     * The base URL used for rewriting local (relative) image URLs in rendered
     * Markdown content. When set, relative image paths will be prefixed with
     * this URL. When set to null, local image URLs will be left as-is.
     *
     * Default value: null
     */
    'base_url' => env('BASE_URL', null),

    /**
     * The application language.
     *
     * Defualt value: 'en'
     */
    'language' => env('APP_LANGUAGE', 'en'),

    /**
     * The title of your blog. This will be displayed in the browser tab/title
     * bar along with the current path.
     *
     * Default value: 'Yet another amazing blog'
     */
    'site_title' => env('SITE_TITLE', 'Yet another amazing blog'),

    /**
     * Meta tag description text.
     *
     * Default value: 'Yet another amazing blog, published with Breve.'
     */
    'meta_description' => env('META_DESCRIPTION', 'Yet another amazing blog, published with Breve.'),

    /**
     * Custom theme ID. Specifies the cutsom application theme to use.
     *
     * Default value: null
     */
    'theme' => env('THEME', null),

    /**
     * Whether or not post pagination is enabled.
     *
     * Default value: true
     */
    'pagination' => env('PAGINATION', true),

    /**
     * The number of posts to display per page when pagination is enabled.
     *
     * Default value: 10
     */
    'posts_per_page' => env('POSTS_PER_PAGE', 10),

    /**
     * Show the post title in the posts list.
     *
     * Default value: true
     */
    'posts_show_title' => env('POSTS_SHOW_TITLE', true),

    /**
     * Show the post metadata (e.g. published, author, tags) in the posts list.
     *
     * Default value: true
     */
    'posts_show_metadata' => env('POSTS_SHOW_METADATA', true),

    /**
     * Show the featured image in the posts list.
     *
     * Default value: true
     */
    'posts_show_image' => env('POSTS_SHOW_IMAGE', true),

    /**
     * Show the post excerpt or body in the posts list.
     *
     * Default value: true
     */
    'posts_show_excerpt' => env('POSTS_SHOW_EXCERPT', true),

    /**
     * Show the "Read More" link in the posts list.
     *
     * Default value: true
     */
    'posts_show_read_more' => env('POSTS_SHOW_READ_MORE', true),

    /**
     * Controls the vertical sizing of featured post images. When set to 'full'
     * images will be displayed at their full height. Any other value will be
     * used as the constrained image height. Examples: 10rem, 400px, etc.
     *
     * Default value: 'full'
     */
    'featured_image_height' => env('FEATURED_IMAGE_HEIGHT', 'full'),

    /**
     * Whether or not to show the "Tags" navigation link.
     *
     * Default value: true
     */
    'tags_link' => env('TAGS_LINK', true),

    /**
     * Whether or not to show the "Authors" navigation link.
     *
     * Default value: false
     */
    'authors_link' => env('AUTHORS_LINK', false),

    /**
     * Enable fuzzy matching in search results for typo tolerance.
     *
     * Default value: false
     */
    'fuzzy_search' => env('FUZZY_SEARCH', false),

    /**
     * Default date format. For additional info on date formatting see:
     * https://www.php.net/manual/en/function.date.php.
     *
     * Default value: 'Y-m-d H:i:s'
     */
    'date_format' => env('DATE_FORMAT', 'Y-m-d H:i:s'),

    /**
     * The Shiki theme ID used for syntax highlighting in rendered code blocks.
     * See https://shiki.style/themes for a list of themes to choose from.
     *
     * Default value: 'catppuccin-frappe'
     */
    'shiki_theme_id' => env('SHIKI_THEME_ID', 'catppuccin-frappe'),

    /**
     * Timezone used for date formatting. For a list of supported timezones see:
     * https://www.php.net/manual/en/timezones.php.
     *
     * Default value: The server's timezone
     */
    'timezone' => env('TIMEZONE', date_default_timezone_get()),

];
