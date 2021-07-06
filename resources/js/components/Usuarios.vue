<template>
  <div class="row">
    <div class="col-md-3 divisor-izquierda pb-3">
      <!-- Reservación con archivo -->
      <h4 class="pt-3">Registro de Usuarios</h4>
      <div class="input-group mb-3">
        <div class="custom-file">
          <input
            type="file"
            class="custom-file-input"
            accept=".csv"
            @change="ingresarArchivo"
          />
          <label class="custom-file-label">Choose file</label>
        </div>
      </div>
      <button class="btn btn-primary">
        <i class="bi bi-calendar4-week"></i> Reservar
      </button>
      <!-- Reservación con archivo  -->

      <!-- Modificar usuario -->
      <h4 class="pt-5">Modificar usuario</h4>
      <label for="">Carnet</label>
      <input type="text" class="form-control" placeholder="" />
      <label for="" class="pt-2">Nombres</label>
      <input type="text" class="form-control" placeholder="" />
      <label for="" class="pt-2">Apellidos</label>
      <input type="text" class="form-control" placeholder="" />
      <label for="" class="pt-2">Carrera</label>
      <input type="text" class="form-control" placeholder="" />
      <button class="btn btn-primary mt-3">
        <i class="bi bi-arrow-bar-down"></i> Modificar
      </button>
      <!-- Modificar usuarios -->
    </div>
    <div class="col-md-1 d-sm-none d-none d-md-block d-lg-block d-lg-block">
      <hr class="vertical-line" />
    </div>
    <div class="col-md-8">
      <h4 class="pt-3">Usuarios Registrados</h4>
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <!-- <th scope="col">#</th> -->
            <th scope="col">Carnet</th>
            <th scope="col">Nombres</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Carrera</th>
            <th scope="col">Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="usuario in usuarios" :key="usuario.carnet">
            <td>{{ usuario.carnet }}</td>
            <td>{{ usuario.nombres }}</td>
            <td>{{ usuario.apellidos }}</td>
            <td>{{ usuario.carrera }}</td>
            <td>
              <a href="#"><i class="bi bi-pencil-square fs-3 action"></i></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      usuarios: "",
      usuario: {},
      texto: "",
    };
  },
  methods: {
    ingresarArchivo(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.leerUsuariosDeArchivo(files[0]);
    },
    leerUsuariosDeArchivo(file) {
      let texto = "";
      let promise = new Promise((resolve, reject) => {
        var reader = new FileReader();
        reader.onload = (e) => {
          resolve((texto = reader.result));
        };
        reader.readAsText(file);
      });

      promise.then(
        (result) => {
          const sinTitulo = texto.substring(32); // Se elimina la cabecera del archivo
          let textoConSaltos = sinTitulo.replaceAll("\n", ",");
          let textoConComas;
          let textoSinPrimeraComa = textoConSaltos.replace(",", "");
          if (textoSinPrimeraComa.search(";")) {
            //Si existen punto y coma como separación, se reemplazan por comas
            textoConComas = textoSinPrimeraComa.replaceAll(";", ",");
          } else {
            textoConComas = textoSinPrimeraComa; //Si el csv ya viene con comas
          }

          let campo = "";
          let comaAnterior = 0;
          let arrayUsuarios = [];
          let objetoUsuario = {};
          let contadorCampos = 1;
          let primerCampo = true;

          for (let i = 0; i < textoConComas.length; i++) {
            //Cuando se encuentre una coma significa que el campo termina ahí,
            // entonces se debe cortar esa porción de texto
            if (textoConComas[i] == ",") {
              //Si es la primer campo, no hay que borrar la coma, porque no hay
              //Por esto se valida con una bandera para saber si es el primer campo de lo contrario
              //Para al else
              if (primerCampo) {
                campo = textoConComas.substring(0, i);
                primerCampo = false;
              } else {
                //Se corta el string desde el anterior+1, porque anterior representa el valor de las comas
                campo = textoConComas.substring(comaAnterior + 1, i);
              }

              //Dependiendo del valor de contadorCampos se asignará al objeto dependiendo de lo que represente
              //Si es un carnet, al campo carnet, etc.
              if (contadorCampos == 1) {
                //Primer valor del objeto, Carnet
                objetoUsuario.carnet = campo;
              } else if (contadorCampos == 2) {
                //Segundo valor del objeto, Nombres
                objetoUsuario.nombres = campo;
                // console.log("Contador: " + contadorCampos);
              } else if (contadorCampos == 3) {
                //Tercer valor del objeto, Apellidos
                objetoUsuario.apellidos = campo;
              } else if (contadorCampos == 4) {
                //Cuarto valor del objeto, Carrera
                objetoUsuario.carrera = campo;
                arrayUsuarios.push(objetoUsuario); // Se agregan a un array para luego convertirlo en un objeto
                objetoUsuario = {};
                contadorCampos = 0;
              }

              //Se asigna la coma actual como coma anterior
              comaAnterior = i;
              //Se suma al contador de Campos para validaciones del objeto
              contadorCampos += 1;
            }
          }
          this.usuarios = arrayUsuarios; //Se asigna a la variable local para dibujarlos en la tabla
        },
        (error) => {
          console.log(error);
        }
      );
    },
  },
};
</script>
