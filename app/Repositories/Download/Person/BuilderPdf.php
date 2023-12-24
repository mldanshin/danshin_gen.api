<?php

namespace App\Repositories\Download\Person;

use App\Models\Download\People\Person as PersonModel;
use App\Repositories\Download\PDF;

final class BuilderPdf extends BuilderAbstract
{
    public function create(string $pathDirectory, PersonModel $person): string
    {
        $pdf = new PDF();

        $func = fn() => $pdf->createCard($person);

        $path = $pathDirectory . "danshin_genealogy_person_{$person->id}.pdf";

        $pdf->createFile(
            $func,
            $path
        );

        return $path;
    }
}
