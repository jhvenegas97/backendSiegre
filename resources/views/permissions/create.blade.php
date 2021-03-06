@section('title', 'Administrador - Crear Permiso')
@extends('layouts.layoutAdmin')


@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="text-center">
                <h3>Crear Nuevo Permiso</h3>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Algo salió mal, contacta a los administradores de SIEGRE.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
    <div class="row">
        <div class="mb-3 flex-column">
            <label for="state" class="col-12 col-form-label text-md-start">{{ __('Nombre') }}</label>
            {!! Form::text('name', null, array('placeholder' => 'Nombre','class' => 'form-control')) !!}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-3">
            <a class="btn btn-primary btn-new" href="{{ route('permissions.index') }}">Regresar</a>
            <button type="submit" class="btn btn-primary btn-new">Guardar cambios</button>
        </div>
    </div>
    {!! Form::close() !!}

</div>

@endsection
