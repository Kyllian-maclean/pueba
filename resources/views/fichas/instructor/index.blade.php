@extends('index_instructor')

@section('content')
    <h1>Listado de Fichas</h1>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fichas as $ficha)
                @if ($ficha instanceof \App\Models\Ficha)
                    <tr>
                        <td>{{ $ficha->code }}</td>
                        <td>{{ $ficha->programa_formacion }}</td>
                        <td>{{ $ficha->status }}</td>
                        <td>
                            <a href="{{ route('fichas.instructor.view', $ficha->code) }}" class="btn btn-primary">Visualizar</a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection