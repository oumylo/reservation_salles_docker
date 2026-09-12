<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleBuilderInterface;
use App\Exception\SalleAvecReservationsException;
use App\Exception\SalleNonTrouveeException;
use App\Renderer\RendererInterface;
use App\Service\AutorisationServiceInterface;
use App\Service\CreerSalleServiceInterface;
use App\Service\ModifierSalleServiceInterface;
use App\Service\SalleConsultationServiceInterface;
use App\Service\SalleStatistiqueServiceInterface;
use App\Service\SupprimerSalleServiceInterface;
use App\Service\ValidationMessageInterface;
use App\Validation\SalleValidatorInterface;

final class SalleController extends AbstractController
{
    public function __construct(
        private SalleConsultationServiceInterface $salleConsultationService,
        private SalleValidatorInterface $validator,
        private ValidationMessageInterface $validationMessage,
        private CreerSalleBuilderInterface $builder,
        private CreerSalleServiceInterface $creerSalleService,
        private ModifierSalleServiceInterface $modifierSalleService,
        private SupprimerSalleServiceInterface $supprimerSalleService,
        private AutorisationServiceInterface $autorisationService,
        private SalleStatistiqueServiceInterface $salleStatistiqueService,
        RendererInterface $renderer
    ) {
        parent::__construct($renderer);
    }

    public function index(): void
    {
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
        $this->renderView('salle/form', [
            'errors' => [],
            'data' => [],
            'salle' => null,
        ]);
    }

    public function store(): void
    {
        $data = $_POST;

        $data['active'] = isset($data['active']);
        $data['capacite'] = (int) ($data['capacite'] ?? 0);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $this->afficherFormulaire(
                $result->data(),
                $this->messages($result->errors()),
                null
            );

            return;
        }

        $dto = $this->builder
            ->fromArray($result->data())
            ->build();

        $this->creerSalleService->executer($dto);

        header('Location: /salles');
        exit;
    }

    public function edit(int $id): void
    {
        $salle = $this->salleConsultationService->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            $this->renderView('error/404');

            return;
        }

        $data = [
            'nom' => $salle->nom,
            'batiment' => $salle->batiment,
            'capacite' => $salle->capacite,
            'type' => $salle->type,
            'active' => $salle->active,
        ];

        $this->afficherFormulaire($data, [], $salle);
    }

    public function update(int $id): void
    {
        $data = $_POST;

        $data['active'] = isset($data['active']);
        $data['capacite'] = (int) ($data['capacite'] ?? 0);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $salle = $this->salleConsultationService->trouver($id);

            $this->afficherFormulaire(
                $result->data(),
                $this->messages($result->errors()),
                $salle
            );

            return;
        }

        $dto = $this->builder
            ->fromArray($result->data())
            ->build();

        try {
            $this->modifierSalleService->executer($id, $dto);

            header('Location: /salles');
            exit;
        } catch (SalleNonTrouveeException) {
            http_response_code(404);
            $this->renderView('error/404');
        }
    }

    public function delete(int $id): void
    {
        try {
            $this->supprimerSalleService->executer($id);

            header('Location: /salles');
            exit;
        } catch (SalleNonTrouveeException) {
            http_response_code(404);
            $this->renderView('error/404');

            return;
        } catch (SalleAvecReservationsException $exception) {
            $salles = $this->salleConsultationService->lister();
            $isAdmin = $this->autorisationService->estAdmin();

            $sallesLesPlusUtilisees =
                $this->salleStatistiqueService->sallesLesPlusUtilisees();

            $this->renderView('salle/index', [
                'salles' => $salles,
                'isAdmin' => $isAdmin,
                'sallesLesPlusUtilisees' => $sallesLesPlusUtilisees,
                'messageErreur' => $exception->getMessage(),
            ]);
        }
    }

    private function afficherFormulaire(
        array $data,
        array $errors,
        mixed $salle
    ): void {
        $this->renderView('salle/form', [
            'errors' => $errors,
            'data' => $data,
            'salle' => $salle,
        ]);
    }

    private function messages(array $errors): array
    {
        $messages = [];

        foreach ($errors as $champ => $codes) {
            $messages[$champ] = $this->validationMessage->message(
                $champ,
                $codes
            );
        }

        return $messages;
    }
}