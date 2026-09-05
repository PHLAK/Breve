<?php

declare(strict_types=1);

use DI\Container;
use Symfony\Component\Yaml\Yaml;

return [

    // -------------------------------------------------------------------------
    // Function bindings
    // -------------------------------------------------------------------------

    'tags_enabled' => function (Container $container): bool {
        return (bool) filter_var($container->get('tags_link'), FILTER_VALIDATE_BOOLEAN);
    },

    'authors_enabled' => function (Container $container): bool {
        return (bool) filter_var($container->get('authors_link'), FILTER_VALIDATE_BOOLEAN);
    },

    'posts_list_enabled' => function (Container $container): bool {
        return (bool) filter_var($container->get('posts_list_link'), FILTER_VALIDATE_BOOLEAN);
    },

    'redirects' => function (Container $container): array {
        /** @var string $redirectsFile */
        $redirectsFile = $container->get('redirects_file');

        /** @var array{pages?: array<string,string>, posts?: array<string,string>} $redirects */
        $redirects = file_exists($redirectsFile) ? Yaml::parseFile($redirectsFile) : [];

        return ['pages' => [], 'posts' => [], ...$redirects];
    },

    'theme_path' => function (Container $container): string {
        /** @var string|null $theme */
        $theme = $container->get('theme');

        return $theme ? sprintf('%s/%s', $container->get('themes_path'), $theme) : $container->get('resources_path');
    },
];
