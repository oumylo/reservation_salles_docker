<?php

namespace Tests\Unit\Service;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use App\Service\CreerSalleService;
use PHPUnit\Framework\TestCase;

final class CreerSalleServiceTest extends TestCase
{
    public function testCreeEtEnregistreUneSalleDepuisLeDto(): void
    {
        $repository = $this->createMock(SalleRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('enregistrer')
            ->with($this->callback(function (Salle $salle): bool {
                return $salle->nom === 'Salle B12'
                    && $salle->batiment === 'B'
                    && $salle->capacite === 50
                    && $salle->type === 'cours'
                    && $salle->active === true;
            }))
            ->willReturnCallback(static fn (Salle $salle): Salle => $salle);

        $service = new CreerSalleService($repository);
        $salle = $service->executer(new CreerSalleDTO(
            'Salle B12',
            'B',
            50,
            'cours',
            true
        ));

        $this->assertInstanceOf(Salle::class, $salle);
    }
}
