<?php

declare(strict_types=1);

namespace App\Renderer;

class JsonRenderer implements RendererInterface
{
    public function render(string $view, array $data = []): void
    {
  
        header('Content-Type: application/json; charset=UTF-8');

        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}