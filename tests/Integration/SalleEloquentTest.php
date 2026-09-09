<?php

namespace Tests\Integration;

use App\Model\Reservation;
use App\Model\Salle;
use PHPUnit\Framework\TestCase;

class SalleEloquentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        require dirname(__DIR__, 2) . '/config/database.php';
    }

    public function testCreationSalleAvecEloquent(): void
    {
        $salle = new Salle();

        $salle->nom = 'Salle Test Integration';
        $salle->batiment = 'Batiment Test';
        $salle->capacite = 30;
        $salle->type = 'cours';
        $salle->active = true;

        $salle->save();

        $this->assertNotNull($salle->id);

        $this->assertSame( 'Salle Test Integration',  $salle->nom );

        $this->assertSame( 'Batiment Test',  $salle->batiment );

        $this->assertSame( 30, $salle->capacite );

        $salle->delete();
    }

    public function testRelationSalleReservations(): void
    {
      
        $salle = new Salle();

        $salle->nom = 'Salle Relation Test';
        $salle->batiment = 'Batiment Test';
        $salle->capacite = 40;
        $salle->type = 'cours';
        $salle->active = true;

        $salle->save();

        $reservation1 = new Reservation();

        $reservation1->salle_id = $salle->id;
        $reservation1->responsable = 'Responsable Test';
        $reservation1->email = 'test1@example.com';
        $reservation1->motif = 'Cours de programmation';
        $reservation1->date_debut = '2030-01-10 10:00:00';
        $reservation1->date_fin = '2030-01-10 12:00:00';
        $reservation1->statut = 'confirmée';

        $reservation1->save();

       
        $reservation2 = new Reservation();

        $reservation2->salle_id = $salle->id;
        $reservation2->responsable = 'Autre Responsable';
        $reservation2->email = 'test2@example.com';
        $reservation2->motif = 'Travaux pratiques';
        $reservation2->date_debut = '2030-01-10 14:00:00';
        $reservation2->date_fin = '2030-01-10 16:00:00';
        $reservation2->statut = 'confirmée';

        $reservation2->save();

      
        $reservations = $salle->reservations;

      
        $this->assertCount(2, $reservations);

        $this->assertSame(  $salle->id,  $reservations[0]->salle_id  );

        $this->assertSame( $salle->id,  $reservations[1]->salle_id);


        $reservation1->delete();
        $reservation2->delete();
        $salle->delete();
    }
}
