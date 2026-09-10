<?php

namespace App\Controller;

use App\DTO\ConnexionDTO;
use App\Exception\AuthentificationException;
use App\Service\AuthentificationServiceInterface;
use App\Validation\ConnexionValidator;

class AuthController
{
    public function __construct(
        private ConnexionValidator $validator,
        private AuthentificationServiceInterface $authentificationService,
        
        
    ) {
    }

    public function login(): void
    {
        $errors = [];
        $data = [];

        require dirname(__DIR__, 2) . '/templates/auth/login.php';
    }

    public function authenticate(): void
    {
        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            require dirname(__DIR__, 2) . '/templates/auth/login.php';

            return;
        }

        $validatedData = $result->data();

        $dto = new ConnexionDTO(
            $validatedData['email'],
            $validatedData['password']
        );

        try {
            $this->authentificationService->connecter($dto);

            header('Location: /salles');
            exit;
        } catch (AuthentificationException $exception) {
            $errors = [
                'authentification' => $exception->getMessage()
            ];

            $data = $validatedData;

            require dirname(__DIR__, 2) . '/templates/auth/login.php';
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
