<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserRol;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        // Obtener las credenciales ingresadas por el usuario
        $credentials = $request->only('code', 'password', 'role');

        // Verificar si el usuario ya seleccionó un rol
        if (isset($credentials['role'])) {
            $selectedRole = $credentials['role'];
            unset($credentials['role']);
        } else {
            // Si el usuario no seleccionó un rol, redirigirlo a la vista de selección de rol
            return redirect()->route('login');
        }

        $user = User::where('code', $credentials["code"])
        ->where('status', "active")
        ->first();

        // Verificar si el usuario existe y la contraseña es válida
        if (!$user || !Hash::check($credentials["password"], $user->password)) {
            return redirect()->route('login')
                ->with('error', 'Credenciales inválidas.');
        }

       
        // Si se autentica correctamente, redirigir al usuario a la página correspondiente según el rol
        if ($selectedRole == "1") {
            $rol =  UserRol::where('rol_id', 1)
            ->where('user_id', $user["code"])
            ->exists();
            if($rol){
                auth::attempt($credentials);
                return redirect()->route('adminHome'); 
            }
            else{
                return redirect()->route('login')
                ->with('error', 'El usuario no tiene el rol seleccionado.');
            }
        } elseif ($selectedRole == "2") {
            $rol =  UserRol::where('rol_id', 2)
            ->where('user_id', $user["code"])
            ->exists();
            if($rol){
                auth::attempt($credentials);
                return redirect()->route('instructorHome'); 
            }else{
                return redirect()->route('login')
                ->with('error', 'El usuario no tiene el rol seleccionado.');
            }
        } elseif ($selectedRole == "3") {
            $rol =  UserRol::where('rol_id', 3)
            ->where('user_id', $user["code"])
            ->exists();
            if($rol){
                auth::attempt($credentials);
                return redirect()->route('studentHome'); 
            }else{
                return redirect()->route('login')
                ->with('error', 'El usuario no tiene el rol seleccionado.');
            }
        }else{
            return redirect()->route('login')
            ->with('error', 'El usuario no tiene el rol seleccionado.');
        }

    }

    // Agregar una nueva función para obtener las credenciales ingresadas por el usuario, incluyendo el rol seleccionado
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password', 'role');
    }

}