<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!in_array('correo_electronico',$row)){
            return null;
        }

        $existingUser = User::where('email', $row['correo_electronico'])->first();

        if($existingUser){
            return $existingUser;
        }
    

        if(in_array('codigo_usuario',$row)){
            return null;
        }
    
        $existingUser = User::where('code', $row['codigo_usuario'])->first();
            
        if($existingUser){
            return $existingUser;
        }

        return new User([
            'code' => $row['codigo_usuario'], // Utilizar el valor de la celda en el archivo Excel
            'first_name' => $row['nombres'],
            'last_name' => $row['apellidos'],
            'email' => $row['correo_electronico'],
            'status' => $row['estado'],
            'password' => Hash::make($row['contrasena']), // Utilizar el valor de la celda en el archivo Excel
        ]);
    }
}
