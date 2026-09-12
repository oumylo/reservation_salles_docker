<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationBuilderInterface;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Renderer\RendererInterface;
use App\Service\AnnulerReservationServiceInterface;
use App\Service\AutorisationServiceInterface;
use App\Service\CreerReservationServiceInterface;
use App\Service\ReservationConsultationServiceInterface;
use App\Service\ValidationMessageInterface;
use App\Validation\ReservationValidatorInterface;

final class ReservationController extends AbstractController
{
    public function __construct(
        private ReservationConsultationServiceInterface $reservationConsultationService,
        private ReservationValidatorInterface $validator,
        private ValidationMessageInterface $validationMessage,
        private CreerReservationBuilderInterface $builder,
        private CreerReservationServiceInterface $creerReservationService,
        private AnnulerReservationServiceInterface $annulerReservationService,
        private AutorisationServiceInterface $autorisationService,
        RendererInterface $renderer
    ) {
        parent::__construct($renderer);
    }

    public function index(): void
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $reservations = $this->reservationConsultationService->lister($page);
        $isAdmin = $this->autorisationService->estAdmin();

        $this->renderView('reservation/index', [
            'reservations' => $reservations,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationConsultationService->trouver($id);

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
        $this->afficherFormulaire([], []);
    }

    public function store(): void
    {
        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $this->afficherFormulaire(
                $result->data(),
                $this->messages($result->errors())
            );

            return;
        }

        $dto = $this->builder
            ->fromArray($result->data())
            ->build();

        try {
            $this->creerReservationService->executer($dto);

            header('Location: /reservations');
            exit;
        } catch (SalleIndisponibleException $exception) {
            $this->afficherFormulaire(
                $result->data(),
                ['date_debut' => $exception->getMessage()]
            );
        }
    }

    public function cancel(int $id): void
    {
        try {
            $this->annulerReservationService->executer($id);

            header('Location: /reservations');
            exit;
        } catch (ReservationIntrouvableException) {
            http_response_code(404);
            $this->renderView('error/404');
        }
    }

    private function afficherFormulaire(
        array $data,
        array $errors
    ): void {
        $this->renderView('reservation/form', [
            'salles' => $this->reservationConsultationService->listerSalles(),
            'action' => '/reservations',
            'data' => $data,
            'errors' => $errors,
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