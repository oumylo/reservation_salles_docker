<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Service\AnnulerReservationService;
use App\Service\AutorisationService;
use App\Service\CreerReservationService;
use App\Service\ReservationConsultationService;
use App\Service\ReservationValidationService;


class ReservationController
{
    public function __construct(
        private ReservationConsultationService $reservationConsultationService,
        private ReservationValidationService $validationService,
        private CreerReservationService $creerReservationService,
        private AnnulerReservationService $annulerReservationService,
        private AutorisationService $autorisationService
    ) {
    }

    public function index(): void
    {
        $this->autorisationService->exigerConnexion();

        $reservations = $this->reservationConsultationService->lister();

        $isAdmin = $this->autorisationService->estAdmin();

        require dirname(__DIR__, 2) . '/templates/reservation/index.php';
    }

    public function show(int $id): void
    {
        $this->autorisationService->exigerConnexion();

        $reservation = $this->reservationConsultationService->trouver($id);

        if ($reservation === null) {
            http_response_code(404);

            require dirname(__DIR__, 2) . '/templates/error/404.php';

            return;
        }

        require dirname(__DIR__, 2) . '/templates/reservation/show.php';
    }

    public function create(): void
    {
        $this->autorisationService->exigerAdmin();

        $errors = [];
        $data = [];

        $this->afficherFormulaire($data, $errors);
    }

    public function store(): void
    {
        $this->autorisationService->exigerAdmin();

        $data = $_POST;

        $result = $this->validationService->valider($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            $this->afficherFormulaire($data, $errors);

            return;
        }

        $validatedData = $result->data();

        $dto = new CreerReservationDTO(
            (int) $validatedData['salle_id'],
            $validatedData['responsable'],
            $validatedData['email'],
            $validatedData['motif'],
            new \DateTimeImmutable($validatedData['date_debut']),
            new \DateTimeImmutable($validatedData['date_fin'])
        );

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
        $this->autorisationService->exigerAdmin();

        try {
            $this->annulerReservationService->executer($id);

            header('Location: /reservations');

            exit;
        } catch (ReservationIntrouvableException $exception) {
            http_response_code(404);

            require dirname(__DIR__, 2) . '/templates/error/404.php';

            return;
        }
    }

    private function afficherFormulaire(array $data, array $errors): void
    {
        $salles = $this->reservationConsultationService->listerSalles();

        $action = '/reservations';

        require dirname(__DIR__, 2) . '/templates/reservation/form.php';
    }
}