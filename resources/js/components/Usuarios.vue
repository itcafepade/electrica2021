<template>
  <div class="row">
    <div class="col-md-3 divisor-izquierda pb-3">
      <!-- Reservación con archivo -->
      <h4 class="pt-3">Registro de Usuarios</h4>
      <!-- Descargar plantilla  -->
      <a href="/plantilla.csv" class="btn btn-success mb-3"
        ><i class="bi bi-file-earmark-medical"></i> Plantilla</a
      >
      <!-- Descargar plantilla  -->
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
      <a href="#" class="btn btn-primary" @click="registrarUsuarios()">
        <i class="bi bi-calendar4-week"></i> Reservar
      </a>
      <!-- Reservación con archivo  -->

      <!-- Modificar usuario -->
      <h4 class="pt-5">Modificar usuario</h4>
      <label for="">Carnet</label>
      <input type="text" class="form-control" v-model="usuario.carnet" />
      <label for="" class="pt-2">Nombres</label>
      <input type="text" class="form-control" v-model="usuario.nombres" />
      <label for="" class="pt-2">Apellidos</label>
      <input type="text" class="form-control" v-model="usuario.apellidos" />
      <label for="" class="pt-2">Carrera</label>
      <input type="text" class="form-control" v-model="usuario.carrera" />
      <a
        href="#"
        class="btn btn-secondary mt-3"
        @click="limpiarInputsModificar"
      >
        <i class="bi bi-arrow-bar-down"></i> Limpiar
      </a>
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
            <th scope="col">Correo</th>
            <th scope="col">Nombres</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Carrera</th>
            <th scope="col">Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="usuario in usuarios" :key="usuario.carnet">
            <td>{{ usuario.carnet }}</td>
            <td>{{ usuario.correo }}</td>
            <td>{{ usuario.nombres }}</td>
            <td>{{ usuario.apellidos }}</td>
            <td>{{ usuario.carrera }}</td>
            <td>
              <a href="#"
                ><i
                  class="bi bi-pencil-square fs-3 action"
                  @click="modificarUsuario(usuario)"
                ></i
              ></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import Archivo from "../libs/archivo";
import axios from "axios";
import Alerta from "../libs/alerta";

const archivo = new Archivo();
const alerta = new Alerta();

export default {
  data() {
    return {
      usuarios: [],
      usuario: {},
      texto: "",
    };
  },
  methods: {
    async ingresarArchivo(e) {
      this.usuarios = [];
      var archivos = e.target.files || e.dataTransfer.files;
      if (!archivos.length) return;
      this.usuarios = await archivo.leerUsuariosDeArchivo(archivos[0]);
    },
    modificarUsuario(usuario) {
      this.usuario = usuario;
    },
    limpiarInputsModificar() {
      this.usuario = {};
    },
    async registrarUsuarios() {
      if (this.usuarios.length > 0) {
        const usuarios = JSON.parse(JSON.stringify(this.usuarios));

        const res = await axios
          .post("/registrarUsuarios", {
            usuarios: usuarios,
          })
          .catch((error) => {
            alerta.mensaje(error, "error");
          });

        if (res.data.mensaje == "exito") {
          alerta.mensaje("Usuarios registrados correctamente.", "success");
        } else {
          alerta.mensaje(
            "Usuarios no pudieron ser registrados correctamente.",
            "error"
          );
        }
      } else {
        alerta.mensaje("Aún no ha ingresado un archivo con usuarios.", "error");
      }
    },
  },
};
</script>
