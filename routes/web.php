<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FichasController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AprendizController;
use App\Http\Controllers\QrController;


Route::redirect('/', '/login')->name('index');
Route::redirect('/home', '/login')->name('index');


// Rutas del controlador de usuarios con middleware aplicado
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/profile', [UserController::class, 'viewProfile'])->name('users.admin.profile');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/users/{user}/inactivate', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::get('exportar-usuarios/',  [UserController::class, 'exportarUsuarios'])->name('exportar.usuarios');
    Route::post('importar-usuarios', [UserController::class, 'importarUsuarios'])->name('importar.usuarios');
    Route::post('/updatesPassword', [UserController::class, 'updatesPassword'])->name('updatesPassword');


});

// Rutas del controlador de fichas con middleware aplicado
Route::middleware(['auth'])->group(function () {
    Route::get('/fichas', [FichasController::class, 'index'])->name('fichas.index');
    Route::get('/fichas/create', [FichasController::class, 'create'])->name('fichas.create');
    Route::post('/fichas', [FichasController::class, 'store'])->name('fichas.store');
    Route::get('/fichas/edit/{ficha}', [FichasController::class, 'edit'])->name('fichas.edit');
    Route::put('/fichas/{ficha}', [FichasController::class, 'update'])->name('fichas.update');
    Route::put('/fichas/{ficha}/inactivate', [FichasController::class, 'destroy'])->name('fichas.destroy');
    Route::put('/fichas/{ficha}/activate', [FichasController::class, 'activate'])->name('fichas.activate');
    Route::get('/fichas/{ficha}', [FichasController::class, 'viewOne'])->name('fichas.view');
    Route::get('/fichas/{ficha}/vinculate/students', [FichasController::class, 'showAttachStudentForm'])->name('fichas.vinculate.students');
    Route::get('/fichas/{ficha}/vinculate/instructor', [FichasController::class, 'showAttachInstructorForm'])->name('fichas.vinculate.instructor');
    Route::post('/fichas/{ficha}/vinculate/students', [FichasController::class, 'attachStudent'])->name('fichas.vinculate.students.post');
    Route::post('/fichas/{ficha}/vinculate/instructor', [FichasController::class, 'attachInstructor'])->name('fichas.vinculate.instructor.post');
    Route::post('/fichas/{ficha}/desvinculate/students/{studentId}', [FichasController::class, 'desattachStudent'])->name('fichas.desvinculate.students');
    Route::post('/fichas/{ficha}/desvinculate/instructor/{instructorId}', [FichasController::class, 'desattachInstructor'])->name('fichas.desvinculate.instructor');
    Route::get('exportar-fichas/',  [FichasController::class, 'exportFichas'])->name('exportar.fichas');
    Route::post('importar-fichas', [FichasController::class, 'importarFichas'])->name('importar.fichas');
    
});

// Rutas del controlador de instructor con middleware aplicado
Route::middleware(['auth'])->group(function () {
    Route::get('/fichas/instructor/index', [InstructorController::class, 'indexFichasInstructor'])->name('fichas.instructor.index');
    Route::get('/fichas/instructor/{ficha}', [InstructorController::class, 'viewOneFicha'])->name('fichas.instructor.view');
    Route::get('/fichas/instructor/asistencias/{user}/{ficha}', [InstructorController::class, 'viewAsistences'])->name('fichas.instructor.asistences');
    Route::post('/fichas/instructor/asistence{user}/{ficha}', [InstructorController::class, 'createAsistence'])->name('fichas.instructor.asistence');
    Route::get('/users/instructor/profile', [UserController::class, 'viewProfileInstructor'])->name('users.instructor.profile');
    Route::get('/excusas/instructor/index', [InstructorController::class, 'viewExcusas'])->name('excusas.instructor.index');
    Route::post('/excusas/instructor/aprobar{excusa}', [InstructorController::class, 'aprobarExcusa'])->name('fichas.instructor.aprobar');
    Route::post('/excusas/instructor/rechazar{excusa}', [InstructorController::class, 'rechazarExcusa'])->name('fichas.instructor.rechazar');
    Route::get('exportar-asistencias/{code}/{ficha}',  [InstructorController::class, 'exportarAsistencias'])->name('exportar.asistencias');
    Route::get('/fichas/instructor/{ficha}/marcar', [InstructorController::class, 'marcarasistencia'])->name('fichas.instructor.marcar');
    Route::post('/fichas/instructor/asistenceQr', [InstructorController::class, 'createAsistenceQr'])->name('fichas.instructor.asistenceQr');

});

// Rutas del controlador de aprendiz con middleware aplicado
Route::middleware(['auth'])->group(function () {
    Route::get('/fichas/aprendiz/index', [AprendizController::class, 'viewAsistences'])->name('asistences.aprendiz.index');
    Route::get('/users/aprendiz/profile', [UserController::class, 'viewProfileAprendiz'])->name('users.aprendiz.profile');
    Route::get('/users/aprendiz/excusas', [AprendizController::class, 'excusasIndex'])->name('excusas.aprendiz.index');
    Route::get('/users/create/excusas', [AprendizController::class, 'excusasCreate'])->name('excusas.create.index');
    Route::post('/users/create/excusas', [AprendizController::class, 'excusasStore'])->name('excusas.store.index');
    Route::get('/descargar-pdf/{nombreArchivo}',[AprendizController::class, 'descargarPDF'])->name('descargar.pdf');
    Route::get('/users/aprendiz/QrCode', [QrController::class, 'QrAprendiz'])->name('users.aprendiz.QrCode');

});


// Rutas de autenticación generadas automáticamente por Auth::routes()
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('adminHome');
    Route::get('/instructor', [App\Http\Controllers\HomeController::class, 'indexInstructor'])->name('instructorHome');
    Route::get('/aprendiz', [App\Http\Controllers\HomeController::class, 'indexStudent'])->name('studentHome');
});