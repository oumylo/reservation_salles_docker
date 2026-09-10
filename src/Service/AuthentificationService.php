<?php

namespace App\Service;

use App\DTO\ConnexionDTO;
use App\Exception\AuthentificationException;
use App\Model\Responsable;
use App\Repository\ResponsableRepositoryInterface;

class AuthentificationService implements AuthentificationServiceInterface
{
    public function __construct(
        private ResponsableRepositoryInterface $responsableRepository
    ) {
    }

    public function connecter(ConnexionDTO $dto): Responsable
    {
        $responsable = $this->responsableRepository
            ->trouverParEmail($dto->email);

        if ($responsable === null) {
            throw new AuthentificationException(
                'Email ou mot de passe incorrect.'
            );
        }

        if (!password_verify(
            $dto->password,
            $responsable->password
        )) {
            throw new AuthentificationException(
                'Email ou mot de passe incorrect.'
            );
        }

        session_regenerate_id(true);

        $_SESSION['responsable_id'] = $responsable->id;
        $_SESSION['responsable_nom'] = $responsable->nom;
        $_SESSION['responsable_email'] = $responsable->email;
        $_SESSION['responsable_role'] = $responsable->role;

        return $responsable;
    }
}
