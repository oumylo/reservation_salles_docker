<?php

namespace Tests\Integration;

use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\ReservationRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ReservationRepositoryTest extends TestCase
{
    private Salle $salle;
    private Reservation $reservation;

    protected function setUp(): void
    {
        parent::setUp();

        require dirname(__DIR__, 2) . '/config/database.php';

        $this->salle = new Salle();

        $this->salle->nom = 'Salle Conflit Test';
        $this->salle->batiment = 'Batiment Test';
        $this->salle->capacite = 30;
        $this->salle->type = 'cours';
        $this->salle->active = true;

        $this->salle->save();

     
        $this->reservation = new Reservation();

        $this->reservation->salle_id = $this->salle->id;
        $this->reservation->responsable = 'Responsable Test';
        $this->reservation->email = 'conflit@example.com';
        $this->reservation->motif = 'Cours de programmation';
        $this->reservation->date_debut = '2030-02-10 10:00:00';
        $this->reservation->date_fin = '2030-02-10 12:00:00';
        $this->reservation->statut = 'confirmée';

        $this->reservation->save();
    }

    protected function tearDown(): void
    {
      
        $this->reservation->delete();
        $this->salle->delete();

        parent::tearDown();
    }

    public function testRechercheChevauchement(): void
    {
        $repository = new ReservationRepository();

        $conflit = $repository->rechercherConflit(
            $this->salle->id,
            new DateTimeImmutable('2030-02-10 11:00:00'),
            new DateTimeImmutable('2030-02-10 13:00:00')
        );

        $this->assertTrue($conflit);
    }

    public function testReservationVoisineSansChevauchement(): void
    {
        $repository = new ReservationRepository();

        $conflit = $repository->rechercherConflit(
            $this->salle->id,
            new DateTimeImmutable('2030-02-10 12:00:00'),
            new DateTimeImmutable('2030-02-10 14:00:00')
        );

        $this->assertFalse($conflit);
    }

  
public function testAnnulationReservation(): void
{
    $repository = new ReservationRepository();

    $this->assertSame('confirmée', $this->reservation->statut );

    $resultat = $repository->annuler( $this->reservation->id );

    
    $this->assertTrue($resultat);

    $reservationActualisee = Reservation::find( $this->reservation->id);

    $this->assertSame( 'annulée',  $reservationActualisee->statut );
}

}
