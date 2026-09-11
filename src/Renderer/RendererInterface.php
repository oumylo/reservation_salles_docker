<?php

declare(strict_types=1);

namespace App\Renderer;

interface RendererInterface
{
    public function render(string $view, array $data = []): void;
}