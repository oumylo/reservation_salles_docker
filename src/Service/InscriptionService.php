<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\InscriptionDTO;
use App\Exception\EmailDejaUtiliseException;
use App\Model\Responsable;
use App\Repository\ResponsableRepositoryInterface;

class InscriptionService implements InscriptionServiceInterface
{
    private const ROLE_PAR_DEFAUT = 'RESPONSABLE';

    public function __construct(
        private ResponsableRepositoryInterface $responsableRepository
    ) {
    }

    public function executer(InscriptionDTO $dto): Responsable
    {
        if ($this->responsableRepository->emailExiste($dto->email)) {
            throw new EmailDejaUtiliseException(
                'Un compte existe déjà avec cette adresse email.'
            );
        }

        $responsable = new Responsable();

        $responsable->fill([
            'nom' => $dto->nom,
            'email' => $dto->email,
            'password' => password_hash($dto->password, PASSWORD_DEFAULT),
            'role' => self::ROLE_PAR_DEFAUT,
        ]);

        return $this->responsableRepository->enregistrer($responsable);
    }
}