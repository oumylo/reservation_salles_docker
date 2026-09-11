<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Service\AnnulerReservationService;
use App\Service\AutorisationGuard;
use App\Service\AutorisationService;
use App\Service\CreerReservationService;
use App\Service\ReservationConsultationService;
use App\Service\ReservationValidationService;
use App\Renderer\RendererInterface;



class ReservationController extends AbstractController
{
    public function __construct(
        private ReservationConsultationService $reservationConsultationService,
        private ReservationValidationService $validationService,
        private CreerReservationService $creerReservationService,
        private AnnulerReservationService $annulerReservationService,
        private AutorisationService $autorisationService,
        private AutorisationGuard $autorisationGuard,
         RendererInterface $renderer
    ) {

         parent::__construct($renderer);
    }

    public function index(): void
    {
        $this->autorisationGuard->exigerConnexion();

        $reservations = $this->reservationConsultationService->lister();

        $isAdmin = $this->autorisationService->estAdmin();

        $this->renderView('reservation/index', [
            'reservations' => $reservations,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function show(int $id): void
    {
        $this->autorisationGuard->exigerConnexion();

        $reservation =
            $this->reservationConsultationService->trouver($id);

        if ($reservation === null) {
            http_response_code(404);

            $this->renderView('error/404');

            return;
        }

        $this->renderView('reservation/show', [
            'reservation' => $reservation,
        ]);
    }

    public function create(): void
    {
        $this->autorisationGuard->exigerAdmin();

        $errors = [];
        $data = [];

        $this->afficherFormulaire($data, $errors);
    }

    public function store(): void
    {
        $this->autorisationGuard->exigerAdmin();

        $data = $_POST;

        $result = $this->validationService->valider($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            $this->afficherFormulaire($data, $errors);

            return;
        }

        $validatedData = $result->data();

        $dto = CreerReservationDTO::fromToErray($validatedData);

        try {
            $this->creerReservationService->executer($dto);

            header('Location: /reservations');

            exit;
        } catch (SalleIndisponibleException $exception) {
            $errors = [
                'date_debut' => $exception->getMessage()
            ];

            $data = $validatedData;

            $this->afficherFormulaire($data, $errors);
        }
    }

    public function cancel(int $id): void
    {
        $this->autorisationGuard->exigerAdmin();

        try {
            $this->annulerReservationService->executer($id);

            header('Location: /reservations');

            exit;
        } catch (ReservationIntrouvableException $exception) {
            http_response_code(404);

            $this->renderView('error/404');

            return;
        }
    }

    private function afficherFormulaire(
        array $data,
        array $errors
    ): void {
        $salles =
            $this->reservationConsultationService->listerSalles();

        $action = '/reservations';

        $this->renderView('reservation/form', [
            'salles' => $salles,
            'action' => $action,
            'data' => $data,
            'errors' => $errors,
        ]);
    }
}