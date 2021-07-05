@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="title-home">Manejo de Usuario</h2>
    <hr>
    <div class="row">
        <div class="col-md-3 divisor-izquierda pb-3">
            <!-- Reservación con archivo -->
            <h4 class="pt-3">Registro de Usuarios</h4>
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile01"
                        aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <button class="btn btn-primary"><i class="bi bi-calendar4-week"></i> Reservar</button>
            <!-- Reservación con archivo  -->

            <!-- Modificar usuario -->
            <h4 class="pt-5">Modificar usuario</h4>
            <label for="">Carnet</label>
            <input type="text" class="form-control" placeholder="">
            <label for="" class="pt-2">Nombres</label>
            <input type="text" class="form-control" placeholder="">
            <label for="" class="pt-2">Apellidos</label>
            <input type="text" class="form-control" placeholder="">
            <label for="" class="pt-2">Carrera</label>
            <input type="text" class="form-control" placeholder="">
            <button class="btn btn-primary mt-3"><i class="bi bi-arrow-bar-down"></i> Modificar</button>
            <!-- Modificar usuarios -->

        </div>
        <div class="col-md-1 d-sm-none d-none d-md-block d-lg-block d-lg-block">
            <hr class="vertical-line">
        </div>
        <div class="col-md-8">
            <h4 class="pt-3">Usuarios Registrados</h4>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Carnet</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>011519</td>
                        <td>Jose Carlos</td>
                        <td>Martinez Lopez </td>
                        <td>Ing. Electrica </td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square fs-3 action"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>011519</td>
                        <td>Jose Carlos</td>
                        <td>Martinez Lopez </td>
                        <td>Ing. Electrica </td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square fs-3 action"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>011519</td>
                        <td>Jose Carlos</td>
                        <td>Martinez Lopez </td>
                        <td>Ing. Electrica </td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square fs-3 action"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>011519</td>
                        <td>Jose Carlos</td>
                        <td>Martinez Lopez </td>
                        <td>Ing. Electrica </td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square fs-3 action"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>011519</td>
                        <td>Jose Carlos</td>
                        <td>Martinez Lopez </td>
                        <td>Ing. Electrica </td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square fs-3 action"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td>011519</td>
                        <td>Jose Carlos</td>
                        <td>Martinez Lopez </td>
                        <td>Ing. Electrica </td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square fs-3 action"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">7</th>
                        <td>011519</td>
                        <td>Jose Carlos</td>
                        <td>Martinez Lopez </td>
                        <td>Ing. Electrica </td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square fs-3 action"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
