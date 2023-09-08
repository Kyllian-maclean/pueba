<?php

namespace App\Exports;

use App\Models\Asistencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AsistencesExport implements  FromCollection, WithHeadings
{
    protected $asistencias;
    //constructor
    public function __construct($asistencias)
    {
        $this->asistencias = $asistencias;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Obtén los datos del modelo Asistencia
        return $this->asistencias;
    }

    public function headings(): array
    {
        return [
            ' Código Aprendiz',
            ' Fecha',
        ];
    }

}
