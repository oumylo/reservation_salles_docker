<?php

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;

class ReservationController
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository,
        private ReservationValidator $validator,
        private CreerReservationService $creerReservationService,
        private AnnulerReservationService $annulerReservationService
    ) {
    }

    public function index(): void
    {
        $reservations = $this->reservationRepository->lister();

        require dirname(__DIR__, 2) . '/templates/reservation/index.php';
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationRepository->trouver($id);

        if ($reservation === null) {
            http_response_code(404);
            require dirname(__DIR__, 2) . '/templates/error/404.php';
            return;
        }

        require dirname(__DIR__, 2) . '/templates/reservation/show.php';
    }

  
    public function create(): void
    {
        $salles = $this->salleRepository->lister();

        $errors = [];
        $data = [];

        require dirname(__DIR__, 2) . '/templates/reservation/form.php';
    }

    public function store(): void
    {
        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

            $salles = $this->salleRepository->lister();

            require dirname(__DIR__, 2) . '/templates/reservation/form.php';
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

        } catch (SalleIndisponibleException $e) {
            $errors = [
                'date_debut' => $e->getMessage()
            ];

            $data = $validatedData;
            $salles = $this->salleRepository->lister();

            require dirname(__DIR__, 2) . '/templates/reservation/form.php';
        }
    }


    public function cancel(int $id): void
    {
        try {
            $this->annulerReservationService->executer($id);

            header('Location: /reservations');
            exit;

        } catch (ReservationIntrouvableException $e) {
            http_response_code(404);
            require dirname(__DIR__, 2) . '/templates/error/404.php';
        }
    }
}