<?php

namespace App\Imports;

use App\Models\Ficha;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class FichasImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!in_array('codigo_ficha',$row)){
            return null;
        }

        $existingFicha = Ficha::where('code', $row['codigo_ficha'])->first();
    
        if($existingFicha){
            return $existingFicha;
        }

        return new Ficha([
            'code' => $row['codigo_ficha'], // Utilizar el valor de la celda en el archivo Excel
            'programa_formacion' => $row['nombre_del_programa'],

        ]);
    }
}
