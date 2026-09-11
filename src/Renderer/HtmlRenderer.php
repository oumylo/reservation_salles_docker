<?php

declare(strict_types=1);

namespace App\Renderer;

class HtmlRenderer implements RendererInterface
{
    public function render(string $view, array $data = []): void
    {

        extract($data);

        ob_start();

        require dirname(__DIR__, 2)
            . '/templates/'
            . $view
            . '.php';

        $content = ob_get_clean();

        require dirname(__DIR__, 2)
            . '/templates/layout/base.php';
    }
}