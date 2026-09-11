<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleDTO;
use App\Exception\SalleAvecReservationsException;
use App\Exception\SalleNonTrouveeException;
use App\Service\AutorisationGuard;
use App\Service\AutorisationService;
use App\Service\CreerSalleService;
use App\Service\ModifierSalleService;
use App\Service\SalleConsultationService;
use App\Service\SalleValidationService;
use App\Service\SupprimerSalleService;
use App\Service\SalleStatistiqueService;
use App\Renderer\RendererInterface;

class SalleController extends AbstractController
{
    public function __construct(
        private SalleConsultationService $salleConsultationService,
        private SalleValidationService $validationService,
        private CreerSalleService $creerSalleService,
        private ModifierSalleService $modifierSalleService,
        private SupprimerSalleService $supprimerSalleService,
        private AutorisationService $autorisationService,
        private AutorisationGuard $autorisationGuard,
        private SalleStatistiqueService $salleStatistiqueService,
        RendererInterface $renderer
    ) {

     parent::__construct($renderer);
    }

    public function index(): void
    {
        $this->autorisationGuard->exigerConnexion();

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $salles = $this->salleConsultationService->lister($page);

        $isAdmin = $this->autorisationService->estAdmin();

        $sallesLesPlusUtilisees =
            $this->salleStatistiqueService->sallesLesPlusUtilisees();

        $this->renderView('salle/index', [
            'salles' => $salles,
            'isAdmin' => $isAdmin,
            'sallesLesPlusUtilisees' => $sallesLesPlusUtilisees,
        ]);
    }

    public function show(int $id): void
    {
        $this->autorisationGuard->exigerConnexion();

        $salle = $this->salleConsultationService->trouver($id);

        if ($salle === null) {
            http_response_code(404);

            $this->renderView('error/404');

            return;
        }

        $this->renderView('salle/show', [
            'salle' => $salle,
        ]);
    }

    public function create(): void
    {
        $this->autorisationGuard->exigerAdmin();

        $errors = [];
        $data = [];
        $salle = null;

        $this->renderView('salle/form', [
            'errors' => $errors,
            'data' => $data,
            'salle' => $salle,
        ]);
    }

    public function store(): void
    {
        $this->autorisationGuard->exigerAdmin();

        $data = $_POST;

        $data['active'] = isset($data['active']);
        $data['capacite'] = (int) ($data['capacite'] ?? 0);

        $result = $this->validationService->valider($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            $salle = null;

            $this->renderView('salle/form', [
                'errors' => $errors,
                'data' => $data,
                'salle' => $salle,
            ]);

            return;
        }

        $validatedData = $result->data();

        $dto = CreerSalleDTO::fromToErray($validatedData);

        $this->creerSalleService->executer($dto);

        header('Location: /salles');

        exit;
    }

    public function edit(int $id): void
    {
        $this->autorisationGuard->exigerAdmin();

        $salle = $this->salleConsultationService->trouver($id);

        if ($salle === null) {
            http_response_code(404);

            $this->renderView('error/404');

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

        $this->renderView('salle/form', [
            'errors' => $errors,
            'data' => $data,
            'salle' => $salle,
            'action' => $action,
        ]);
    }

    public function update(int $id): void
    {
        $this->autorisationGuard->exigerAdmin();

        $data = $_POST;

        $data['active'] = isset($data['active']);
        $data['capacite'] = (int) ($data['capacite'] ?? 0);

        $result = $this->validationService->valider($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            $action = '/salles/' . $id . '/edit';

            $this->renderView('salle/form', [
                'errors' => $errors,
                'data' => $data,
                'action' => $action,
            ]);

            return;
        }

        $validatedData = $result->data();

        $dto = CreerSalleDTO::fromToErray($validatedData);

        try {
            $this->modifierSalleService->executer($id, $dto);

            header('Location: /salles');

            exit;
        } catch (SalleNonTrouveeException $exception) {
            http_response_code(404);

            $this->renderView('error/404');

            return;
        }
    }

    public function delete(int $id): void
    {
        $this->autorisationGuard->exigerAdmin();

        try {
            $this->supprimerSalleService->executer($id);

            header('Location: /salles');

            exit;
        } catch (SalleNonTrouveeException $exception) {
            http_response_code(404);

            $this->renderView('error/404');

            return;
        } catch (SalleAvecReservationsException $exception) {
            $messageErreur = $exception->getMessage();

            $salles = $this->salleConsultationService->lister();

            $isAdmin = $this->autorisationService->estAdmin();

            $sallesLesPlusUtilisees =
                $this->salleStatistiqueService->sallesLesPlusUtilisees();

            $this->renderView('salle/index', [
                'salles' => $salles,
                'isAdmin' => $isAdmin,
                'sallesLesPlusUtilisees' => $sallesLesPlusUtilisees,
                'messageErreur' => $messageErreur,
            ]);

            return;
        }
    }
}