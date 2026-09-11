<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ConnexionDTO;
use App\Exception\AuthentificationException;
use App\Service\AuthentificationServiceInterface;
use App\Validation\ConnexionValidator;
use App\Renderer\RendererInterface;

class AuthController extends AbstractController
{
    public function __construct(
        private ConnexionValidator $validator,
        private AuthentificationServiceInterface $authentificationService,
        RendererInterface $renderer
    ) {

        parent::__construct($renderer);
    }

    public function login(): void
    {
        $errors = [];
        $data = [];

        $this->renderView('auth/login', [
            'errors' => $errors,
            'data' => $data,
        ]);
    }

    public function authenticate(): void
    {
        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            $this->renderView('auth/login', [
                'errors' => $errors,
                'data' => $data,
            ]);

            return;
        }

        $validatedData = $result->data();

        $dto = ConnexionDTO::fromToErray($validatedData);

        try {
            $this->authentificationService->connecter($dto);

            header('Location: /salles');

            exit;
        } catch (AuthentificationException $exception) {
            $errors = [
                'authentification' => $exception->getMessage()
            ];

            $data = $validatedData;

            $this->renderView('auth/login', [
                'errors' => $errors,
                'data' => $data,
            ]);
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: /login');

        exit;
    }
}