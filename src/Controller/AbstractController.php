<?php

declare(strict_types=1);

namespace App\Controller;

use App\Renderer\RendererInterface;

abstract class AbstractController
{
    public function __construct(
        protected RendererInterface $renderer
    ) {
    }

    protected function renderView(
        string $view,
        array $data = []
    ): void {
        $this->renderer->render($view, $data);
    }
}