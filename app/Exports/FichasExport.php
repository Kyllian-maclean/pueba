<?php

namespace App\Exports;

use App\Models\Ficha;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FichasExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ficha::select('fichas.code','fichas.programa_formacion','fichas.created_at','fichas.updated_at')
        ->get();
    }

    public function headings(): array
    {
        return [
            'Codigo Ficha',
            'Nombre del Programa',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }
}
