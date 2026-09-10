<?php

namespace Tests\Unit\Service;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\CreerReservationService;
use PHPUnit\Framework\TestCase;


final class FakeSalleRepository implements SalleRepositoryInterface
{
    private array $salles = [];

    public function ajouter(Salle $salle): void
    {
        $this->salles[$salle->id] = $salle;
    }

    public function lister(): array
    {
        return array_values($this->salles);
    }

    public function trouver(int $id): ?Salle
    {
        return $this->salles[$id] ?? null;
    }

    public function enregistrer(Salle $salle): Salle
    {
        $this->salles[$salle->id] = $salle;

        return $salle;
    }

        public function supprimer(int $id): bool
    {
        return false;
    }
}


final class FakeReservationRepository implements ReservationRepositoryInterface
{
    private array $reservations = [];

    private bool $conflit = false;

    public function definirConflit(bool $conflit): void
    {
        $this->conflit = $conflit;
    }


    public function lister(): array
    {
        return array_values($this->reservations);
    }

    public function trouver(int $id): ?Reservation
    {
        return $this->reservations[$id] ?? null;
    }

        public function existePourSalle(int $salleId): bool
    {
        return false;
    }
   
    public function rechercherConflit(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin
    ): bool {
        return $this->conflit;
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        $this->reservations[] = $reservation;

        return $reservation;
    }

    public function annuler(int $id): bool
    {
        return false;
    }
}



final class CreerReservationServiceTest extends TestCase
{
    private FakeSalleRepository $salleRepository;

    private FakeReservationRepository $reservationRepository;

    private CreerReservationService $service;


    protected function setUp(): void
    {
        parent::setUp();

        $this->salleRepository = new FakeSalleRepository();

        $this->reservationRepository = new FakeReservationRepository();

        $this->service = new CreerReservationService(
            $this->salleRepository,
            $this->reservationRepository
        );
    }

    public function testReservationValide(): void
    {
        $salle = new Salle();

        $salle->id = 1;
        $salle->nom = 'Salle B12';
        $salle->batiment = 'B';
        $salle->capacite = 50;
        $salle->type = 'cours';
        $salle->active = true;

        $this->salleRepository->ajouter($salle);

        $dateDebut = new \DateTimeImmutable( 'tomorrow 10:00:00' );

        $dateFin = new \DateTimeImmutable( 'tomorrow 12:00:00' );


        $dto = new CreerReservationDTO(
            salleId: 1,
            responsable: 'Awa Ndiaye',
            email: 'awa.ndiaye@universite.sn',
            motif: 'Cours d\'architecture logicielle',
            dateDebut: $dateDebut,
            dateFin: $dateFin
        );

        $reservation = $this->service->executer($dto);

        $this->assertInstanceOf( Reservation::class, $reservation );

        $this->assertSame(
            1,
            $reservation->salle_id
        );

        $this->assertSame('Awa Ndiaye', $reservation->responsable);

        $this->assertSame('awa.ndiaye@universite.sn',$reservation->email  );

        $this->assertSame( 'Cours d\'architecture logicielle', $reservation->motif  );

        $this->assertSame( 'confirmée', $reservation->statut );

        $this->assertEquals(  $dateDebut, $reservation->date_debut );

        $this->assertEquals( $dateFin,  $reservation->date_fin );
    }

public function testSalleInexistante(): void
{
   
    $dateDebut = new \DateTimeImmutable('tomorrow 10:00:00');

    $dateFin = new \DateTimeImmutable('tomorrow 12:00:00' );

    $dto = new CreerReservationDTO(
        salleId: 999,
        responsable: 'Awa Ndiaye',
        email: 'awa.ndiaye@universite.sn',
        motif: 'Cours d\'architecture logicielle',
        dateDebut: $dateDebut,
        dateFin: $dateFin
    );

    $this->expectException( \App\Exception\SalleIndisponibleException::class );

    $this->expectExceptionMessage( 'La salle demandée n\'existe pas.');

    $this->service->executer($dto);
}


public function testSalleInactive(): void
{
    $salle = new Salle();

    $salle->id = 2;
    $salle->nom = 'Salle C15';
    $salle->batiment = 'C';
    $salle->capacite = 40;
    $salle->type = 'cours';
    $salle->active = false;

    $this->salleRepository->ajouter($salle);

    $dateDebut = new \DateTimeImmutable( 'tomorrow 10:00:00' );

    $dateFin = new \DateTimeImmutable( 'tomorrow 12:00:00');

    $dto = new CreerReservationDTO(
        salleId: 2,
        responsable: 'Awa Ndiaye',
        email: 'awa.ndiaye@universite.sn',
        motif: 'Cours d\'architecture logicielle',
        dateDebut: $dateDebut,
        dateFin: $dateFin
    );

    $this->expectException( \App\Exception\SalleIndisponibleException::class );

    $this->expectExceptionMessage( 'La salle demandée est inactive.' );

    $this->service->executer($dto);
}


public function testDateFinAvantDateDebut(): void
{
    $salle = new Salle();

    $salle->id = 3;
    $salle->nom = 'Salle D20';
    $salle->batiment = 'D';
    $salle->capacite = 30;
    $salle->type = 'cours';
    $salle->active = true;

    $this->salleRepository->ajouter($salle);

    $dateDebut = new \DateTimeImmutable( 'tomorrow 14:00:00');

    $dateFin = new \DateTimeImmutable( 'tomorrow 12:00:00' );

    $dto = new CreerReservationDTO(
        salleId: 3,
        responsable: 'Awa Ndiaye',
        email: 'awa.ndiaye@universite.sn',
        motif: 'Cours d\'architecture logicielle',
        dateDebut: $dateDebut,
        dateFin: $dateFin
    );

    $this->expectException(
        \App\Exception\SalleIndisponibleException::class
    );

    $this->expectExceptionMessage( 'La date de début doit précéder la date de fin.');

    $this->service->executer($dto);
}

public function testDureeSuperieureAQuatreHeures(): void
{
    $salle = new Salle();

    $salle->id = 4;
    $salle->nom = 'Salle E10';
    $salle->batiment = 'E';
    $salle->capacite = 60;
    $salle->type = 'cours';
    $salle->active = true;

    $this->salleRepository->ajouter($salle);

    $dateDebut = new \DateTimeImmutable('tomorrow 08:00:00' );

    $dateFin = new \DateTimeImmutable( 'tomorrow 14:00:00' );

    $dto = new CreerReservationDTO(
        salleId: 4,
        responsable: 'Awa Ndiaye',
        email: 'awa.ndiaye@universite.sn',
        motif: 'Cours d\'architecture logicielle',
        dateDebut: $dateDebut,
        dateFin: $dateFin
    );

    $this->expectException( \App\Exception\SalleIndisponibleException::class);

    $this->expectExceptionMessage( 'La durée de réservation ne peut pas dépasser quatre heures.');

    $this->service->executer($dto);
}

public function testDatePassee(): void
{
    $salle = new Salle();

    $salle->id = 5;
    $salle->nom = 'Salle F05';
    $salle->batiment = 'F';
    $salle->capacite = 35;
    $salle->type = 'cours';
    $salle->active = true;

    $this->salleRepository->ajouter($salle);

    $dateDebut = new \DateTimeImmutable( 'yesterday 10:00:00');

    $dateFin = new \DateTimeImmutable( 'yesterday 12:00:00');

    $dto = new CreerReservationDTO(
        salleId: 5,
        responsable: 'Awa Ndiaye',
        email: 'awa.ndiaye@universite.sn',
        motif: 'Cours d\'architecture logicielle',
        dateDebut: $dateDebut,
        dateFin: $dateFin
    );

    $this->expectException(
        \App\Exception\SalleIndisponibleException::class
    );

    $this->expectExceptionMessage(
        'La date de début doit être dans le futur.'
    );

    $this->service->executer($dto);
}


public function testConflitAvecReservationExistante(): void
{
    $salle = new Salle();

    $salle->id = 6;
    $salle->nom = 'Salle G10';
    $salle->batiment = 'G';
    $salle->capacite = 50;
    $salle->type = 'cours';
    $salle->active = true;

    $this->salleRepository->ajouter($salle);

    $this->reservationRepository->definirConflit(true);

    $dateDebut = new \DateTimeImmutable(
        'tomorrow 11:30:00'
    );

    $dateFin = new \DateTimeImmutable(
        'tomorrow 13:00:00'
    );

    $dto = new CreerReservationDTO(
        salleId: 6,
        responsable: 'Awa Ndiaye',
        email: 'awa.ndiaye@universite.sn',
        motif: 'Cours d\'architecture logicielle',
        dateDebut: $dateDebut,
        dateFin: $dateFin
    );

    $this->expectException(
        \App\Exception\SalleIndisponibleException::class
    );

    $this->expectExceptionMessage(
        'La salle est déjà réservée pour cette période.'
    );

    $this->service->executer($dto);
}

public function testReservationVoisineSansChevauchement(): void
{
    $salle = new Salle();

    $salle->id = 7;
    $salle->nom = 'Salle H15';
    $salle->batiment = 'H';
    $salle->capacite = 40;
    $salle->type = 'cours';
    $salle->active = true;

    $this->salleRepository->ajouter($salle);

    $this->reservationRepository->definirConflit(false);

    $dateDebut = new \DateTimeImmutable(
        'tomorrow 12:00:00'
    );

    $dateFin = new \DateTimeImmutable(
        'tomorrow 14:00:00'
    );

    $dto = new CreerReservationDTO(
        salleId: 7,
        responsable: 'Awa Ndiaye',
        email: 'awa.ndiaye@universite.sn',
        motif: 'Cours d\'architecture logicielle',
        dateDebut: $dateDebut,
        dateFin: $dateFin
    );

    $reservation = $this->service->executer($dto);

    $this->assertInstanceOf(
        Reservation::class,
        $reservation
    );

    $this->assertSame(
        7,
        $reservation->salle_id
    );

    $this->assertSame(
        'confirmée',
        $reservation->statut
    );
}


}
