<?php

namespace App\Controller;

use App\DTO\CreerSalleDTO;
use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidator;

class SalleController
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private SalleValidator $validator
    ) {
    }

    public function index(): void
    {
        $salles = $this->salleRepository->lister();

        require dirname(__DIR__, 2) . '/templates/salle/index.php';
    }

    public function show(int $id): void
    {
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
        $errors = [];
        $data = [];

        require dirname(__DIR__, 2) . '/templates/salle/form.php';
    }


    public function edit(int $id): void
    {
        
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            require dirname(__DIR__, 2) . '/templates/error/404.php';
            return;
        }

        $data = [
            'nom' => $salle->nom,
            'batiment' => $salle->batiment,
            'capacite' => $salle->capacite,
            'type' => $salle->type,
            'active' => $salle->active,
        ];

    
        $errors = [];

        $title = 'Modifier une salle';

        require dirname(__DIR__, 2) . '/templates/salle/form.php';
    }


    public function update(int $id): void
    {
        
        $salle = $this->salleRepository->trouver($id);

        
        if ($salle === null) {
            http_response_code(404);
            require dirname(__DIR__, 2) . '/templates/error/404.php';
            return;
        }

        $data = $_POST;

        $data['active'] = isset($data['active']);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();
            $title = 'Modifier une salle';

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

        $salle->nom = $dto->nom;
        $salle->batiment = $dto->batiment;
        $salle->capacite = $dto->capacite;
        $salle->type = $dto->type;
        $salle->active = $dto->active;

        $this->salleRepository->enregistrer($salle);

        header('Location: /salles');
        exit;
    }


    public function store(): void
    {
       
        $data = $_POST;

        $data['active'] = isset($data['active']);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = $result->data();

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

        $salle = new \App\Model\Salle();

        $salle->nom = $dto->nom;
        $salle->batiment = $dto->batiment;
        $salle->capacite = $dto->capacite;
        $salle->type = $dto->type;
        $salle->active = $dto->active;

        $this->salleRepository->enregistrer($salle);

        header('Location: /salles');
        exit;
    }
}
