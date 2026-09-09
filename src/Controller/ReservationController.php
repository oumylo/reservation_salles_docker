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
        $errors = [];
        $data = [];

        $this->afficherFormulaire($data, $errors);
    }

 
    public function store(): void
    {
        
        $data = $_POST;

        $result = $this->validator->validate($data);

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

    private function afficherFormulaire( array $data, array $errors ): void {
      
        $salles = $this->salleRepository->lister();

        $action = '/reservations';

        require dirname(__DIR__, 2) . '/templates/reservation/form.php';
    }
}
