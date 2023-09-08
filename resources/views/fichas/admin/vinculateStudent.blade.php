@extends('index') <!-- Suponiendo que estás utilizando una plantilla de Blade llamada 'app.blade.php' que carga los estilos de Bootstrap -->

@section('content')
<div class="container">
    <a href="{{ route('fichas.view', ['ficha' => $ficha]) }}" id="btnBack" class="btn btn-primary">Retroceder</a>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Vincular Estudiante a Ficha') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('fichas.vinculate.students.post', ['ficha' => $ficha]) }}">
                        @csrf <!-- Agrega el campo CSRF token para protección contra ataques CSRF -->

                        <div class="form-group">
                            <label for="student_id">Codigo del aprendiz</label>
                            <input type="text" name="student_id" id="student_id" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Vincular Aprendiz</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
