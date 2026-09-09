<?php

namespace Tests\Unit\Validation;

use App\Validation\SalleValidator;
use PHPUnit\Framework\TestCase;

final class SalleValidatorTest extends TestCase
{
    public function testCapaciteNegative(): void
    {
        $validator = new SalleValidator();

        $data = [
            'nom' => 'Salle B12',
            'batiment' => 'B',
            'capacite' => -10,
            'type' => 'cours',
            'active' => true,
        ];

        $resultat = $validator->validate($data);

        $this->assertFalse(
            $resultat->isValid()
        );

        $this->assertArrayHasKey(
            'capacite',
            $resultat->errors()
        );
    }

    public function testTypeSalleInconnu(): void
    {
    $validator = new SalleValidator();

    $data = [
        'nom' => 'Salle B12',
        'batiment' => 'B',
        'capacite' => 50,
        'type' => 'bibliotheque',
        'active' => true,
    ];

    $resultat = $validator->validate($data);

    $this->assertFalse(
        $resultat->isValid()
    );

    $this->assertArrayHasKey(
        'type',
        $resultat->errors()
    );

    }

    
}
