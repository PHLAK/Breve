<?php

declare(strict_types=1);

namespace App\Functions;

use DI\Attribute\Inject;
use DOMDocument;
use DOMException;
use Twig\Markup;

class Svg extends ViewFunction
{
    public string $name = 'svg';

    #[Inject('icons_path')]
    private string $iconsPath;

    /**
     * @param array<string> $classes
     *
     * @throws DOMException
     */
    public function __invoke(string $icon, array $classes = []): Markup
    {
        $contents = (string) file_get_contents(sprintf('%s/%s.svg', $this->iconsPath, $icon));

        $svg = empty($classes) ? $contents : $this->addClassAttribute($contents, $classes);

        return new Markup(trim($svg), 'UTF-8');
    }

    /**
     * @param array<string> $classes
     *
     * @throws DOMException
     */
    private function addClassAttribute(string $svg, array $classes)
    {
        $dom = new DOMDocument;
        $dom->loadXML($svg);

        foreach ($dom->getElementsByTagName('svg') as $element) {
            $element->setAttribute('class', implode(' ', $classes));
        }

        return $dom->saveXML(options: LIBXML_NOXMLDECL);
    }
}
