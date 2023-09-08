<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\excusa;
use App\Models\Ficha;
use App\Models\User;
use App\Exports\AsistencesExport;
use Maatwebsite\Excel\Facades\Excel;


class InstructorController extends Controller
{
    public function indexFichasInstructor()
{   
    $perPage = 10; // Número de registros por página   
    $fichas = Ficha::select('fichas.*')
    ->join('instructors_fichas', 'fichas.code', '=', 'instructors_fichas.ficha_id')
    ->where('instructors_fichas.user_id', auth()->user()->code)
    ->where('fichas.status', 'active')
    ->paginate(10);

    return view('fichas.instructor.index', compact('fichas'));
}

public function viewOneFicha($code)
{
    // Buscar la ficha por su código
    $ficha = Ficha::where('code', $code)->first();

    // Consulta para obtener usuarios con rol_id igual a 3
    $students = $ficha->students;

    return view('fichas.instructor.view', compact('ficha', 'students'));
}
public function createAsistence($code, Ficha $ficha)
{
    date_default_timezone_set('America/Bogota');

    $user = User::where('code', $code)
    ->where('status', 'active')
    ->first();

    if (!$user) {
        return redirect()->route('fichas.instructor.view', ['ficha' => $ficha])->with('error', 'El usuario no existe o no está activo.');
    }

    $date = date('Y-m-d H:i:s');
    Asistencia::create([
        'user_id' => (int)$code,
        'date' => $date
    ]);

    return redirect()->route('fichas.instructor.view', ['ficha' => $ficha])->with('success', 'Asistencia registrada con éxito.');
}

public function viewAsistences($code,Ficha $ficha)
{
    $itemsPerPage = 10;
    $asistences = Asistencia::select('asistencias.*')
    ->where('user_id', $code)
    ->paginate($itemsPerPage);
    $user = User::where('code', $code)->first();

    return view('fichas.instructor.asistences', compact('asistences','user','ficha'));
}

public function viewExcusas(){
    $user = auth()->user();
    $excusas = excusa::select('excusas.id', 'excusas.aprendiz_id', 'excusas.instructor_id', 'excusas.date','excusas.estado','excusas.motivo', 'excusas.file_path',
            'users.first_name', 'users.last_name', 'users.code')
    ->join('users', 'excusas.aprendiz_id', '=', 'users.code')
    ->where('excusas.instructor_id', $user->code)
    ->paginate(10);

    return view('excusas.indexInstructorExcusas', compact('excusas'));

}

public function aprobarExcusa(Excusa $excusa){
    $excusa->estado = 'Aprobado';
    $excusa->save();

    return redirect()->route('excusas.instructor.index')->with('success', 'Excusa aprobada con éxito.');

}

public function rechazarExcusa(Excusa $excusa){
    $excusa->estado = 'Rechazado';
    $excusa->save();

    return redirect()->route('excusas.instructor.index')->with('success', 'Excusa rechazada con éxito.');
}

public function exportarAsistencias($code, Ficha $ficha)
{
    // Obtén los datos del usuario y las asistencias
    $asistencias = Asistencia::select('asistencias.user_id', 'asistencias.date')
        ->where('user_id', $code)
        ->get();

    $user = User::where('code', $code)->first();

    // Crea un nombre de archivo para el archivo de Excel
    $nombreArchivo = 'asistencias_' . $user->code . '.xlsx';

    // Exporta los datos utilizando la clase AsistenciasExport
    return Excel::download(new AsistencesExport($asistencias), $nombreArchivo);

}
}