<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleDTO;
use App\Exception\SalleAvecReservationsException;
use App\Exception\SalleNonTrouveeException;
use App\Repository\SalleRepositoryInterface;
use App\Service\AutorisationService;
use App\Service\CreerSalleService;
use App\Service\SupprimerSalleService;
use App\Validation\SalleValidator;

class SalleController
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private SalleValidator $validator,
        private CreerSalleService $creerSalleService,
        private SupprimerSalleService $supprimerSalleService,
        private AutorisationService $autorisationService
    ) {
    }

    public function index(): void
    {
        $this->autorisationService->exigerConnexion();

        $salles = $this->salleRepository->lister();

        $isAdmin = $this->autorisationService->estAdmin();

        require dirname(__DIR__, 2) . '/templates/salle/index.php';
    }

    public function show(int $id): void
    {
        $this->autorisationService->exigerConnexion();

        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);

            require dirname(__DIR__, 2) . '/templates/error/404.php';

            return;
        }

        require dirname(__DIR__, 2) . '/templates/salle/show.php';
    }

    public function create(): void
    {
        $this->autorisationService->exigerAdmin();

        $errors = [];
        $data = [];
        $salle = null;

        require dirname(__DIR__, 2) . '/templates/salle/form.php';
    }

    public function store(): void
    {
        $this->autorisationService->exigerAdmin();

        $data = $_POST;

        $data['active'] = isset($data['active']);
        $data['capacite'] = (int) ($data['capacite'] ?? 0);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            $salle = null;

            require dirname(__DIR__, 2) . '/templates/salle/form.php';

            return;
        }

        $validatedData = $result->data();

        $dto = new CreerSalleDTO(
            $validatedData['nom'],
            $validatedData['batiment'],
            (int) $validatedData['capacite'],
            $validatedData['type'],
            $validatedData['active']
        );

        $this->creerSalleService->executer($dto);

        header('Location: /salles');

        exit;
    }

    public function edit(int $id): void
    {
        $this->autorisationService->exigerAdmin();

        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);

            require dirname(__DIR__, 2) . '/templates/error/404.php';

            return;
        }

        $errors = [];

        $data = [
            'nom' => $salle->nom,
            'batiment' => $salle->batiment,
            'capacite' => $salle->capacite,
            'type' => $salle->type,
            'active' => $salle->active,
        ];

        $action = '/salles/' . $id . '/edit';

        require dirname(__DIR__, 2) . '/templates/salle/form.php';
    }

    public function update(int $id): void
    {
        $this->autorisationService->exigerAdmin();

        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);

            require dirname(__DIR__, 2) . '/templates/error/404.php';

            return;
        }

        $data = $_POST;

        $data['active'] = isset($data['active']);
        $data['capacite'] = (int) ($data['capacite'] ?? 0);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            $action = '/salles/' . $id . '/edit';

            require dirname(__DIR__, 2) . '/templates/salle/form.php';

            return;
        }

        $validatedData = $result->data();

        $dto = new CreerSalleDTO(
            $validatedData['nom'],
            $validatedData['batiment'],
            (int) $validatedData['capacite'],
            $validatedData['type'],
            $validatedData['active']
        );

        $salle->fill([
            'nom' => $dto->nom,
            'batiment' => $dto->batiment,
            'capacite' => $dto->capacite,
            'type' => $dto->type,
            'active' => $dto->active,
        ]);

        $this->salleRepository->enregistrer($salle);

        header('Location: /salles');

        exit;
    }

    public function delete(int $id): void
    {
        $this->autorisationService->exigerAdmin();

        try {
            $this->supprimerSalleService->executer($id);

            header('Location: /salles');

            exit;
        } catch (SalleNonTrouveeException $exception) {
            http_response_code(404);

            require dirname(__DIR__, 2) . '/templates/error/404.php';

            return;
        } catch (SalleAvecReservationsException $exception) {
            $messageErreur = $exception->getMessage();

            $salles = $this->salleRepository->lister();

            $isAdmin = $this->autorisationService->estAdmin();

            require dirname(__DIR__, 2) . '/templates/salle/index.php';

            return;
        }
    }
}
