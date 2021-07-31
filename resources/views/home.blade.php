@extends('layouts.app')

@section('content')
<div class="container">
    @auth
    <div class="row">
        @if(auth()->user()->access == 'admin')
        <div class="col-md-12">
            <h2 class="title-section">Administración</h2>
            <hr class="featurette-divider">
            <div class="row pb-3">
                <div class="col-md-6 col-2 col-lg-4 col-sm-12 col-12 pt-3">
                    <a href=" {{ url('/horarios') }}"
                        class="botones-inicio btn btn-block btn-white btn-sm p-3 shadow btn-hover">
                        <h4 class="text-left fs-4 title-home"><i class="bi bi-calendar3"></i> Horarios</h4>
                        <p class="text-left fw-lighter description-home">
                            Manejo de horarios para la realización de las prácticas
                        </p>
                    </a>
                </div>
                <div class="col-md-6 col-2 col-lg-4 col-sm-12 col-12 pt-3 ">
                    <a href=" {{ url('/acciones') }}"
                        class="botones-inicio btn btn-block btn-white btn-sm p-3 shadow btn-hover">
                        <h4 class="text-left fs-4 title-home"><i class="bi bi-hdd-stack-fill"></i> Control de Acciones
                        </h4>
                        <p class="text-left fw-lighter description-home">
                            Acciones realizadas en el simulador durante las prácticas
                        </p>
                    </a>
                </div>
                <div class="col-md-6 col-2 col-lg-4 col-sm-12 col-12 pt-3 ">
                    <a href=" {{ url('/usuarios') }}"
                        class="botones-inicio btn btn-block btn-white btn-sm p-3 shadow btn-hover">
                        <h4 class="text-left fs-4 title-home"><i class="bi bi-person-fill"></i> Manejo de Usuarios</h4>
                        <p class="text-left fw-lighter description-home">
                            Administración de usuarios para la utilizacion del simulador
                        </p>
                    </a>
                </div>
                <div class="col-md-6 col-2 col-lg-4 col-sm-12 col-12 pt-3 ">
                    <a href=" {{ url('/ajustes') }}"
                        class="botones-inicio btn btn-block btn-white btn-sm p-3 shadow btn-hover">
                        <h4 class="text-left fs-4 title-home"><i class="bi bi-gear-fill"></i> Ajustes</h4>
                        <p class="text-left fw-lighter description-home">
                            Administración de distintas funciones del sistema
                        </p>
                    </a>
                </div>
            </div>

        </div>
        @endif
    </div>
    @endauth

    <h2 class="pt-3 title-section">Actividad</h2>
    <hr class="featurette-divider">
    <div class="row pb-5 mb-5">
        <div class="col-md-6 col-2 col-lg-4 col-sm-12 col-12 pt-3">
            <a href=" {{ url('/horarios') }}"
                class="botones-inicio btn btn-block btn-white btn-sm p-3 shadow btn-hover">
                <h3 class="text-left fs-4 title-home"><i class="bi bi-calendar3"></i> Horarios</h3>
                <p class="text-left fw-lighter description-home">
                    Maneja tus horarios para la realizacion de las practicas
                </p>
            </a>
        </div>
        <div class="col-md-6 col-2 col-lg-4 col-sm-12 col-12 pt-3">
            <a href=" {{ url('/simulador') }}"
                class="botones-inicio btn btn-block btn-white btn-sm p-3 shadow btn-hover">
                <h3 class="text-left fs-4 title-home"><i class="bi bi-cpu-fill"></i> Simulador</h3>
                <p class="text-left fw-lighter description-home">
                    Realiza tus praticas utilizando el simulador
                </p>
            </a>
        </div>
    </div>
</div>
@endsection
