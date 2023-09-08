@extends('index_aprendiz')

@section('content')

<a href="{{ route('excusas.aprendiz.index') }}" class="btn btn-success">Volver</a>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Formulario de Excusa') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('excusas.store.index') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="instructor_id" class="col-md-4 col-form-label text-md-right">{{ __('ID del Instructor') }}</label>
                            <div class="col-md-6">
                                <select id="instructor_id" class="form-control" name="instructor_id" required>
                                    @foreach ($totalInstructors as $instructorsForFicha)
                                        @foreach ($instructorsForFicha as $instructor)
                                            <option value="{{ $instructor->code }}">{{ $instructor->code }} - {{$instructor->first_name}} {{$instructor->last_name}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }}</label>
                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control" name="date" required>
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label for="motivo" class="col-md-4 col-form-label text-md-right">{{ __('Motivo') }}</label>
                            <div class="col-md-6">
                                <textarea id="motivo" type="date" class="form-control" name="motivo" required></textarea>
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Archivo de Excusa') }}</label>
                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control-file" name="file" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar Excusa') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonText: 'Cerrar'
    });
</script>
@endif
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            confirmButtonText: 'Cerrar'
        });
    </script>
@endif
@endsection
