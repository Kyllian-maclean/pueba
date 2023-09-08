<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\excusa;
use App\Models\Ficha;
use App\Models\User;
use App\Models\UserRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\PostTooLargeException;

class AprendizController extends Controller
{

    
    public function viewAsistences()
    {
        //usuario autenticado
        $user = auth()->user();
        $code = $user->code;

        $itemsPerPage = 10;
        $asistences = Asistencia::select('asistencias.*')
        ->where('user_id', $code)
        ->paginate($itemsPerPage);
    
        return view('asistences.indexAprendiz', compact('asistences','user'));
    }

    public function excusasIndex(){
        $user = auth()->user();
        $code = $user->code;

        $itemsPerPage = 10;
        $excusas = Excusa::select('excusas.id', 'excusas.aprendiz_id', 'excusas.instructor_id', 'excusas.date','excusas.estado','excusas.motivo', 'excusas.file_path',
            'users.first_name', 'users.last_name', 'users.email')
            ->join('users', 'users.code', '=', 'excusas.instructor_id')
            ->where('aprendiz_id', $code)
            ->paginate($itemsPerPage);
        
        return view('excusas.indexAprendizExcusas', compact('excusas','user'));
    }

    public function excusasCreate(){
        $user = auth()->user();

        $fichas = Ficha::select('fichas.code')
        ->join('students_fichas', 'students_fichas.ficha_id', '=', 'fichas.code')
        ->where('students_fichas.user_id', $user->code)
        ->get();

        $totalInstructors = [];
        //foreach para la variable fichas
        foreach($fichas as $ficha){
            $instructores = User::select('users.code', 'users.first_name', 'users.last_name', 'users.email')
            ->join('user_rols', 'user_rols.user_id', '=', 'users.code')
            ->join('instructors_fichas', 'instructors_fichas.user_id', '=', 'users.code')
            ->where('user_rols.rol_id', 2)
            ->where('instructors_fichas.ficha_id', $ficha->code)
            ->get();
            $totalInstructors [] = $instructores;
        }

        return view('excusas.createExcusas',compact('totalInstructors'));
    }

    public function excusasStore(Request $request)
    {
        try {
            if ($request->hasFile('file')) {

                //validar instructor
                $rolInstructor = UserRol::select('user_rols.rol_id')
                ->where('rol_id', 2)
                ->where('user_id', $request->input('instructor_id'))
                ->first();

                if($rolInstructor){
                    // Obtener el archivo PDF
                    $pdf = $request->file('file');

                    // Validar la extensión del archivo
                    if ($pdf->getClientOriginalExtension() !== 'pdf') {
                        return redirect()->route('excusas.create.index')->with('error', 'El archivo debe ser en formato PDF.');
                    }

                    // Validar si el archivo es válido
                    if (!$pdf->isValid()) {
                        return redirect()->route('excusas.create.index')->with('error', 'El archivo no es válido.');
                    }

                    $nombreArchivo = time() . '_' . $pdf->getClientOriginalName();
                    $pdf->storeAs('pdfs', $nombreArchivo, 'local');
                    
                    //aprendiz
                    $aprendiz = auth()->user();
                    // Guardar los datos de la excusa en la base de datos
                    $excusa = new Excusa();
                    $excusa->aprendiz_id = $aprendiz->code;
                    $excusa->instructor_id = $request->input('instructor_id');
                    $excusa->date = $request->input('date');
                    $excusa->file_path = $nombreArchivo;
                    $excusa->motivo = $request->input('motivo');
                    $excusa->save();

                    return redirect()->route('excusas.create.index')->with('success', 'Excusa guardada exitosamente.');
                }else{
                    return redirect()->route('excusas.create.index')->with('error', 'El instructor no existe.');
                }

            }

            return redirect()->route('excusas.create.index')->with('error', 'Excusa no se guardo .');
            // Obtener el archivo enviado desde el formulario
        } catch (PostTooLargeException $e) {
            return redirect()->route('excusas.create.index')->with('error', 'El archivo que intentas subir es demasiado grande.');
        }

    }

    public function descargarPDF($nombreArchivo)
    {
        $archivo = storage_path('app/pdfs/' . $nombreArchivo);

        if (Storage::exists('pdfs/' . $nombreArchivo)) {
            return response()->download($archivo);
        }

        return back()->with('error', 'El archivo PDF no se encontró.');
    }


}
