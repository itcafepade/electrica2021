@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12">
            <h2 class="title-home">Manejo de Usuario</h2>
            <hr>
            <div class="row">
                <div class="col-6 col-md-4 pr-0 offset-2 offset-md-4">
                    <input class="form-control" type="text" placeholder="Carnet">
                </div>
                <div class="col-4 pl-0">
                    <a class="btn btn-success" href="#">Buscar</a>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    Información de práctica
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 pt-2">
                            <h5 class="">Estudiante</h5>
                            <hr>
                            <p class="mb-1"> <strong>Carnet: </strong> 040119</p>
                            <p class="mb-1"> <strong>Nombre: </strong> Leonel López</p>
                            <p class="mb-1"> <strong>Hora Práctica: </strong> 5/7/2021 3:00 PM</p>
                            <p class="mb-1"> <strong>Carrera: </strong> Ing. Eléctrica</p>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8">
                            <h5 class=" pt-2">Actividad</h5>
                            <hr>
                            <div class="table-responsive-lg">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th>#</th>
                                        <th>Hora</th>
                                        <th>Acción</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>5/7/2021 3:01 PM</td>
                                            <td>Inicio de práctica evaluada</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>5/7/2021 3:01 PM</td>
                                            <td>Inicio de práctica evaluada</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>5/7/2021 3:01 PM</td>
                                            <td>Inicio de práctica evaluada</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>5/7/2021 3:01 PM</td>
                                            <td>Inicio de práctica evaluada</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>5/7/2021 3:01 PM</td>
                                            <td>Inicio de práctica evaluada</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
