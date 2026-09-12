<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ConnexionBuilderInterface;
use App\DTO\InscriptionBuilderInterface;
use App\Exception\AuthentificationException;
use App\Exception\EmailDejaUtiliseException;
use App\Renderer\RendererInterface;
use App\Service\AuthentificationServiceInterface;
use App\Service\InscriptionServiceInterface;
use App\Validation\ConnexionValidatorInterface;
use App\Validation\InscriptionValidatorInterface;

final class AuthController extends AbstractController
{
    public function __construct(
        private ConnexionValidatorInterface $validator,
        private ConnexionBuilderInterface $builder,
        private AuthentificationServiceInterface $authentificationService,
        private InscriptionValidatorInterface $inscriptionValidator,
        private InscriptionBuilderInterface $inscriptionBuilder,
        private InscriptionServiceInterface $inscriptionService,
        RendererInterface $renderer
    ) {
        parent::__construct($renderer);
    }

    public function login(): void
    {
        $this->renderView('auth/login', [
            'errors' => [],
            'data' => [],
        ]);
    }

    public function authenticate(): void
    {
        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $this->renderView('auth/login', [
                'errors' => $result->errors(),
                'data' => $result->data(),
            ]);

            return;
        }

        $dto = $this->builder
            ->fromArray($result->data())
            ->build();

        try {
            $this->authentificationService->connecter($dto);

            header('Location: /salles');
            exit;
        } catch (AuthentificationException $exception) {
            $this->renderView('auth/login', [
                'errors' => [
                    'authentification' => $exception->getMessage(),
                ],
                'data' => $result->data(),
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

    public function register(): void
    {
        $this->renderView('auth/register', [
            'errors' => [],
            'data' => [],
        ]);
    }

    public function storeRegister(): void
    {
        $data = $_POST;

        $result = $this->inscriptionValidator->validate($data);

        if (!$result->isValid()) {
            $this->renderView('auth/register', [
                'errors' => $result->errors(),
                'data' => $result->data(),
            ]);

            return;
        }

        $dto = $this->inscriptionBuilder
            ->fromArray($result->data())
            ->build();

        try {
            $this->inscriptionService->executer($dto);

            header('Location: /login');
            exit;
        } catch (EmailDejaUtiliseException $exception) {
            $this->renderView('auth/register', [
                'errors' => [
                    'email' => [$exception->getMessage()],
                ],
                'data' => $result->data(),
            ]);
        }
    }
}