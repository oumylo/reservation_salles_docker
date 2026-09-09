<?php

namespace Tests\Unit\Validation;

use App\Validation\ReservationValidator;
use PHPUnit\Framework\TestCase;

final class ReservationValidatorTest extends TestCase
{
    public function testEmailInvalide(): void
    {
        $validator = new ReservationValidator();

        $data = [
            'salle_id' => 1,
            'responsable' => 'Awa Ndiaye',
            'email' => 'innnnnn',
            'motif' => 'Cours d\'architecture logicielle',
            'date_debut' => '2026-09-10 10:00:00',
            'date_fin' => '2026-09-10 12:00:00',
        ];

        $resultat = $validator->validate($data);

        $this->assertFalse(
            $resultat->isValid()
        );

        $this->assertArrayHasKey(
            'email',
            $resultat->errors()
        );
    }

    public function testResponsableVide(): void
    {
    $validator = new ReservationValidator();


    $data = [
        'salle_id' => 1,
        'responsable' => '',
        'email' => 'awa.ndiaye@universite.sn',
        'motif' => 'Cours d\'architecture logicielle',
        'date_debut' => '2026-09-10 10:00:00',
        'date_fin' => '2026-09-10 12:00:00',
    ];

    $resultat = $validator->validate($data);

    $this->assertFalse(
        $resultat->isValid()
    );

    $this->assertArrayHasKey(
        'responsable',
        $resultat->errors()
    );

    }

    public function testDateIncorrecte(): void
    {
    $validator = new ReservationValidator();


    $data = [
        'salle_id' => 1,
        'responsable' => 'Awa Ndiaye',
        'email' => 'awa.ndiaye@universite.sn',
        'motif' => 'Cours d\'architecture logicielle',
        'date_debut' => 'date-invalide',
        'date_fin' => '2026-09-10 12:00:00',
    ];

    $resultat = $validator->validate($data);

    $this->assertFalse(
        $resultat->isValid()
    );

    $this->assertArrayHasKey(
        'date_debut',
        $resultat->errors()
    );


}
}