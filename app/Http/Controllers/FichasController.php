<?php

namespace App\Http\Controllers;
use App\Models\Ficha;
use App\Models\User;
use App\Models\UserRol;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FichasExport;
use Illuminate\Support\Facades\Validator;
use App\Imports\FichasImport;



class FichasController extends Controller
{
    
// Listar todas las fichas
public function index()
{
    $perPage = 10; // Número de registros por página   
    $fichas = Ficha::paginate($perPage); // Recuperar las fichas paginadas

    return view('fichas.admin.index', compact('fichas'));
}

// Mostrar el formulario para crear una nueva ficha
public function create()
{
    return view('fichas.admin.create');
}

// Almacenar una nueva ficha en la base de datos
public function store(Request $request)
{
    try {
        Ficha::create($request->all());

    } catch (QueryException $e) {
        return redirect()->back()->with('error', 'Ya existe una ficha con ese código.');
    }

    return redirect()->route('fichas.index');
}

// Mostrar el formulario para editar una ficha existente
public function edit($code)
{
    // Buscar la ficha por su código
    $ficha = Ficha::where('code', $code)->first();

    return view('fichas.admin.edit', compact('ficha'));
}

// Actualizar una ficha en la base de datos
public function update(Request $request, Ficha $ficha)
{
    try {
        $ficha->update($request->all());

        // Agrega aquí la lógica para actualizar las relaciones con los roles, similar al código anterior

    } catch (QueryException $e) {
        return redirect()->back()->with('error', 'Ya existe una ficha con ese código.');
    }
    return redirect()->route('fichas.index');
}

// Inactivar una ficha
public function destroy($code)
{
    // Buscar la ficha por su código
    $ficha = Ficha::where('code', $code)->first();

    $ficha->update([
        'status' => 'inactive'
    ]);

    return redirect()->route('fichas.index');
}

// Activar una ficha
public function activate($code)
{
    // Buscar la ficha por su código
    $ficha = Ficha::where('code', $code)->first();

    $ficha->update([
        'status' => 'active'
    ]);

    return redirect()->route('fichas.index');
}

public function viewOne($code)
{
    // Buscar la ficha por su código
    $ficha = Ficha::where('code', $code)->first();

    // Consulta para obtener usuarios con rol_id igual a 3
    $students = $ficha->students;
    
    // Consulta para obtener usuarios con rol_id igual a 3
    $instructors = $ficha->instructors;

    return view('fichas.admin.view', compact('ficha', 'students', 'instructors'));
}

 // Método para mostrar la vista de vinculación de estudiante
 public function showAttachStudentForm(Ficha $ficha)
 {
     return view('fichas.admin.vinculateStudent', compact('ficha'));
 }

 // Método para vincular un estudiante a una ficha

 public function attachStudent(Request $request, Ficha $ficha)
{
    try{
        $studentId = $request->input('student_id');

        // Buscar el estudiante por su id
        $student = User::find($studentId);
    
        // Verificar si el estudiante existe
        if ($student) {
            // Validar si tiene el id_rol 3 en la tabla userRol
            if ($userRol = UserRol::where('user_id', $student->code)->where('rol_id', 3)->first()) {
                // Vincular el estudiante a la ficha a través de la tabla pivote
                $ficha->students()->attach($student);
    
                return redirect()->route('fichas.view', ['ficha' => $ficha])
                                ->with('success', 'Estudiante vinculado correctamente a la ficha.');
            } else {
                return redirect()->route('fichas.view', ['ficha' => $ficha])
                                ->with('error', 'El usuario no tiene el rol de aprendiz.');
            }
        } else {
            return redirect()->route('fichas.view', ['ficha' => $ficha])
                            ->with('error', 'El usuario no existe.');
        }
    }catch(QueryException $e){
        return redirect()->route('fichas.view', ['ficha' => $ficha])
                            ->with('error', 'El usuario ya está vinculado a la ficha.');
    }
    
}

public function desattachStudent(Ficha $ficha ,$studentId)
{
    // Buscar el estudiante por su id
    $student = User::find($studentId);

    if ($student) {
        // Desvincular el estudiante de la ficha a través de la tabla pivote
        $ficha->students()->detach($student);

        return redirect()->route('fichas.view', ['ficha' => $ficha])
            ->with('success', 'Estudiante desvinculado correctamente de la ficha.');
    } else {
        return redirect()->route('fichas.view', ['ficha' => $ficha])
            ->with('error', 'El usuario no existe.');
    }
}

public function showAttachInstructorForm(Ficha $ficha)
 {
     return view('fichas.admin.vinculateInstructor', compact('ficha'));
 }

 // Método para vincular un instructor a una ficha

 public function attachInstructor(Request $request, Ficha $ficha)
{
    try{
        $instructor_id = $request->input('instructor_id');

        // Buscar el instructor por su id
        $instructor = User::find($instructor_id);
    
        // Verificar si el instructor existe
        if ($instructor) {
            // Validar si tiene el id_rol 3 en la tabla userRol
            if ($userRol = UserRol::where('user_id', $instructor->code)->where('rol_id', 2)->first()) {
                // Vincular el instructor a la ficha a través de la tabla pivote
                $ficha->instructors()->attach($instructor);
    
                return redirect()->route('fichas.view', ['ficha' => $ficha])
                                ->with('success', 'instructor vinculado correctamente a la ficha.');
            } else {
                return redirect()->route('fichas.view', ['ficha' => $ficha])
                                ->with('error', 'El usuario no tiene el rol de instructor.');
            }
        } else {
            return redirect()->route('fichas.view', ['ficha' => $ficha])
                            ->with('error', 'El usuario no existe.');
        }
    }catch(QueryException $e){
        return redirect()->route('fichas.view', ['ficha' => $ficha])
                            ->with('error', 'El usuario ya está vinculado a la ficha.');
    }
    
}

public function desattachInstructor(Ficha $ficha ,$instructorId)
{
    // Buscar el instructor por su id
    $instructor = User::find($instructorId);

    if ($instructor) {
        // Desvincular el instructor de la ficha a través de la tabla pivote
        $ficha->instructors()->detach($instructor);

        return redirect()->route('fichas.view', ['ficha' => $ficha])
            ->with('success', 'instructor desvinculado correctamente de la ficha.');
    } else {
        return redirect()->route('fichas.view', ['ficha' => $ficha])
            ->with('error', 'El usuario no existe.');
    }
}

public function exportFichas()
{
    return Excel::download(new FichasExport, 'fichas.xlsx');
}

public function importarFichas(Request $request)
{
    $validator = Validator::make($request->all(), [
        'archivo' => 'required|mimes:xls,xlsx|max:2048', // Añade la regla de validación para los tipos de archivo permitidos
    ]);

    if ($validator->fails()) {
        return redirect()->back()->with("error","Archivo no es valido");
    }

    $archivo = $request->file('archivo');

    try{
        Excel::import(new FichasImport(), $archivo);
    }
    catch(QueryException $e){
        return redirect()->back()->with("error","Dato ingresado no valido");
    }

    

    return redirect()->route('fichas.index')->with('success', 'Fichas importadas exitosamente.');
}


}
