<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRol;
use Illuminate\Support\Facades\Hash;
use App\Imports\UsersImport;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Validator;

class QrController extends Controller
{
    public function QrAprendiz(){
        
        $user = auth()->user();
        $code = auth()->user()->code;

        // Obtener los roles relacionados con el usuario
        $roles = User::select('user_rols.rol_id as rol_id')
        ->where('code', $code)
        ->join('user_rols', 'users.code', '=', 'user_rols.user_id')
        ->get();

        // Extraer los IDs de los roles y guardarlos en un array
        $userRoleIds = $roles->pluck('rol_id')->toArray();
        return view('users.aprendiz.QrCode', compact('user','userRoleIds'));
    }
}
