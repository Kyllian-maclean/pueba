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

class UserController extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        $perPage = 10; // Número de registros por página
        $users = User::paginate($perPage); // Recuperar los usuarios paginados

        return view('users.admin.index', compact('users'));
    }   


    // Mostrar el formulario para crear un nuevo usuario
    public function create()
    {
        return view('users.admin.create');
    }

    // Almacenar un nuevo producto en la base de datos
    public function store(Request $request)
    {
        try {
            User::create($request->all());

            if($request->aprendiz == "on"){
                UserRol::create([
                    'user_id' => $request->code,
                    'rol_id' => 3,
                ]);
            }
            if($request->instructor == "on"){
                UserRol::create([
                    'user_id' => $request->code,
                    'rol_id' => 2,
                ]);
            }
            if($request->admin == "on"){
                UserRol::create([
                    'user_id' => $request->code,
                    'rol_id' => 1,
                ]);
            }

        } catch (QueryException $e) {
            // Mostrar alerta SweetAlert2 en caso de clave primaria duplicada
            return redirect()->back()->with('error', 'Ya existe un usuario con ese código o correo.');
        }
    
        return redirect()->route('users.index');
    }

    // Mostrar el formulario para editar un usuario existente
    public function edit($code)
    {
        // Buscar el usuario por su código
        $user = User::where('code', $code)->first();
    
        // Obtener los roles relacionados con el usuario
        $roles = User::select('user_rols.rol_id as rol_id')
            ->where('code', $code)
            ->join('user_rols', 'users.code', '=', 'user_rols.user_id')
            ->get();
    
        // Extraer los IDs de los roles y guardarlos en un array
        $userRoleIds = $roles->pluck('rol_id')->toArray();
    
        // Pasar los IDs de los roles y el usuario a la vista
        return view('users.admin.edit', compact('user', 'userRoleIds'));
    }

    // Actualizar un usuario en la base de datos
    public function update(Request $request, User $user)
    {
        try {
            $user->update($request->all());

            if($request->aprendiz == "on"){
                // Validar si ya existe el rol "Aprendiz" para el usuario
                $userRolExists = UserRol::where('user_id', $request->code)
                    ->where('rol_id', 3)
                    ->exists();

                if (!$userRolExists) {
                    // Si no existe, crear la asociación
                    UserRol::create([
                        'user_id' => $request->code,
                        'rol_id' => 3,
                    ]);
                }
            }else{
                //eliminar rol si existe
                UserRol::where('user_id', $request->code)->where('rol_id', 3)->delete();
            }

            if($request->instructor == "on"){
                // Validar si ya existe el rol "instructor" para el usuario
                $userRolExists = UserRol::where('user_id', $request->code)
                    ->where('rol_id', 2)
                    ->exists();

                if (!$userRolExists) {
                    // Si no existe, crear la asociación
                    UserRol::create([
                        'user_id' => $request->code,
                        'rol_id' => 2,
                    ]);
                }
            }else{
                //eliminar rol si existe
                UserRol::where('user_id', $request->code)->where('rol_id', 2)->delete();
            }

            if($request->admin == "on"){
                // Validar si ya existe el rol "admin" para el usuario
                $userRolExists = UserRol::where('user_id', $request->code)
                    ->where('rol_id', 1)
                    ->exists();

                if (!$userRolExists) {
                    // Si no existe, crear la asociación
                    UserRol::create([
                        'user_id' => $request->code,
                        'rol_id' => 1,
                    ]);
                }
            }else{
                //eliminar rol si existe
                UserRol::where('user_id', $request->code)->where('rol_id', 1)->delete();
            }

        }catch (QueryException $e) {
            return redirect()->back()->with('error', 'Ya existe un usuario con ese código o correo.');
        }
        return redirect()->route('users.index');
    }

    // Inactivar un usuario
    public function destroy(User $user)
    {
        $user->update([
            'status' => 'inactive'
        ]);

        return redirect()->route('users.index');
    }

    // Activar un usuario
    public function activate(User $user)
    {
        $user->update([
            'status' => 'active'
        ]);

        return redirect()->route('users.index');
    }

    public function viewProfile(){
        
        $user = auth()->user();
        $code = auth()->user()->code;

        // Obtener los roles relacionados con el usuario
        $roles = User::select('user_rols.rol_id as rol_id')
        ->where('code', $code)
        ->join('user_rols', 'users.code', '=', 'user_rols.user_id')
        ->get();

        // Extraer los IDs de los roles y guardarlos en un array
        $userRoleIds = $roles->pluck('rol_id')->toArray();
        return view('users.admin.profile', compact('user','userRoleIds'));
    }

    public function viewProfileInstructor(){
        
        $user = auth()->user();
        $code = auth()->user()->code;

        // Obtener los roles relacionados con el usuario
        $roles = User::select('user_rols.rol_id as rol_id')
        ->where('code', $code)
        ->join('user_rols', 'users.code', '=', 'user_rols.user_id')
        ->get();

        // Extraer los IDs de los roles y guardarlos en un array
        $userRoleIds = $roles->pluck('rol_id')->toArray();
        return view('users.instructor.profile', compact('user','userRoleIds'));
    }

    public function viewProfileAprendiz(){
        
        $user = auth()->user();
        $code = auth()->user()->code;

        // Obtener los roles relacionados con el usuario
        $roles = User::select('user_rols.rol_id as rol_id')
        ->where('code', $code)
        ->join('user_rols', 'users.code', '=', 'user_rols.user_id')
        ->get();

        // Extraer los IDs de los roles y guardarlos en un array
        $userRoleIds = $roles->pluck('rol_id')->toArray();
        return view('users.aprendiz.profile', compact('user','userRoleIds'));
    }


    public function updatesPassword(Request $request)
{
    if($request->input('newPassword') != $request->input('confirmation')){
        return redirect()->back()->with('error', 'La confirmación de contraseña no coincide.');
    }
    if($request->input('newPassword') == $request->input('currentPassword')){
        return redirect()->back()->with('error', 'La nueva contraseña debe ser diferente de la contraseña actual.');
    }
    //validar que existan mayusculas, minusculas y numeros en la nueva contraseña
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $request->input('newPassword'))) {
        return redirect()->back()->with('error', 'La contraseña debe contener al menos una letra minúscula, una letra mayúscula y un número.');
    }

    if(strlen($request->input('newPassword')) < 8){
        return redirect()->back()->with('error', 'La contraseña debe tener al menos 8 caracteres.');
    }
    
    $currentPassword = $request->input('currentPassword');
    if (!Hash::check($currentPassword, auth()->user()->password)) {
        return redirect()->back()->with('error', 'Contraseña actual incorrecta');
    }

    $newPassword = $request->input('newPassword');
    $user = auth()->user();
    $user = User::where('code', $user->code)->first(); // Obtén el usuario por su código
    $user->password = Hash::make($newPassword);
    $user->save();

    return redirect()->route('users.admin.profile')->with('success', 'Contraseña actualizada correctamente');
}


    public function exportarUsuarios()
{

    // Exporta los datos utilizando la clase AsistenciasExport
    return Excel::download(new UsersExport(), 'usuarios.xlsx');

}

public function importarUsuarios(Request $request)
{
    $validator = Validator::make($request->all(), [
        'archivo' => 'required|mimes:xls,xlsx|max:2048', // Añade la regla de validación para los tipos de archivo permitidos
    ]);

    if ($validator->fails()) {
        return redirect()->back()->with("error","Archivo no es valido");
    }

    $archivo = $request->file('archivo');

    try{
        Excel::import(new UsersImport(), $archivo);
    }
    catch(QueryException $e){
        return redirect()->back()->with("error","Dato ingresado no valido");
    }


    return redirect()->route('users.index')->with('success', 'Usuarios importados exitosamente.');
}

    
}
