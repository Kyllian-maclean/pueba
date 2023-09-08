<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('users.code','users.first_name','users.last_name','users.email','users.status','users.biometric_date','users.created_at','users.updated_at')
        ->get();
    }

    public function headings(): array
    {
        return [
            'Codigo Usuario',
            'Nombres',
            'Apellidos',
            'Correo Electronico',
            'Estado', 
            'Dato Biometrico',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }
    
}
