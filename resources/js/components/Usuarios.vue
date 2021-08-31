<template>
  <div class="row">
    <div class="col-md-3 divisor-izquierda pb-3">
      <!-- Reservación con archivo -->
      <h4 class="pt-3">Registro de Usuarios</h4>
      <!-- Descargar plantilla  -->
      <a href="/plantilla.csv" class="btn btn-success mb-3"
        ><i class="bi bi-file-earmark-medical"></i> Plantilla</a
      >
      <a
        href="#"
        class="btn btn-primary mb-3"
        data-toggle="modal"
        data-target="#exampleModal"
      >
        <i class="bi bi-person-plus-fill"></i> Registrar usuario
      </a>

      <!-- Descargar plantilla  -->
      <div class="input-group mb-3">
        <div class="custom-file">
          <input
            type="file"
            class="custom-file-input"
            accept=".csv"
            @change="ingresarArchivo"
          />
          <label class="custom-file-label">{{ nombreArchivo }}</label>
        </div>
      </div>
      <a href="#" class="btn btn-primary" @click="registrarUsuarios()">
        <i class="bi bi-calendar4-week"></i> Registrar por csv
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

    <!-- MODAL -->
    <div class="modal fade" tabindex="-1" id="exampleModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Registro de usuario</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="d-flex align-items-center" v-if="nuevoUsuarioCargando">
              <strong>Registrando...</strong>
              <div
                class="spinner-border ml-auto"
                role="status"
                style="width: 3rem; height: 3rem"
                aria-hidden="true"
              ></div>
            </div>
            <label for="">Carnet</label>
            <input
              type="number"
              class="form-control"
              placeholder="999999"
              v-model="nuevoUsuario.carnet.texto"
              @keyup="validarCampo('Carnet')"
              ref="nuevoUsuarioCarnet"
            />
            <label for="" class="pt-2">Correo</label>
            <input
              type="text"
              class="form-control"
              placeholder="usuario@itca.edu.sv"
              v-model="nuevoUsuario.correo.texto"
              @keyup="validarCampo('Correo')"
              ref="nuevoUsuarioCorreo"
            />
            <label for="" class="pt-2">Nombres</label>
            <input
              type="text"
              class="form-control"
              placeholder="José Roberto"
              v-model="nuevoUsuario.nombres.texto"
              @keyup="validarCampo('Nombres')"
              ref="nuevoUsuarioNombres"
            />
            <label for="" class="pt-2">Apellidos</label>
            <input
              type="text"
              class="form-control"
              placeholder="Marquez Hernandez"
              v-model="nuevoUsuario.apellidos.texto"
              @keyup="validarCampo('Apellidos')"
              ref="nuevoUsuarioApellidos"
            />
            <label for="" class="pt-2">Carrera</label>
            <input
              type="text"
              class="form-control"
              placeholder="Ing. Eléctrica"
              v-model="nuevoUsuario.carrera.texto"
              @keyup="validarCampo('Carrera')"
              ref="nuevoUsuarioCarrera"
            />
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cerrar
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="registrarNuevoUsuario()"
            >
              Registrar
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL -->
  </div>
</template>

<script>
import Archivo from "../libs/archivo";
import axios from "axios";
import Alerta from "../libs/alerta";
import Interfaz from "../libs/interfaz";

const archivo = new Archivo();
const interfaz = new Interfaz();
const alerta = new Alerta();

export default {
  data() {
    return {
      usuarios: [],
      usuario: {},
      texto: "",
      nombreArchivo: "Elige un archivo",
      nuevoUsuario: {
        carnet: {
          texto: "040119",
          validado: true,
        },
        correo: {
          texto: "leonel.lopez19@itca.edu.sv",
          validado: true,
        },
        nombres: {
          texto: "Leonel Antonio",
          validado: true,
        },
        apellidos: {
          texto: "López Valencia",
          validado: true,
        },
        carrera: {
          texto: "Ing. Eléctrica",
          validado: true,
        },
      },
      nuevoUsuarioCargando: false,
    };
  },
  methods: {
    async ingresarArchivo(e) {
      this.usuarios = [];
      var archivos = e.target.files || e.dataTransfer.files;
      if (!archivos.length) return;
      this.nombreArchivo = archivos[0].name;
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

      this.nombreArchivo = "Elige un archivo";
    },
    validarCampo(campo, input) {
      switch (campo) {
        case "Carnet": {
          const txtCarnet = this.$refs.nuevoUsuarioCarnet;
          if (this.nuevoUsuario.carnet.texto.length == 6) {
            this.nuevoUsuario.carnet.validado = true;
            interfaz.actualizarClase(txtCarnet, "is-invalid", "is-valid");
            break;
          }

          this.nuevoUsuario.carnet.validado = false;
          txtCarnet.classList.add("is-invalid");
          break;
        }
        case "Correo": {
          const regex = /^[a-zA-Z0-9._-]+@itca.edu.sv/;
          const txtCorreo = this.$refs.nuevoUsuarioCorreo;
          if (this.nuevoUsuario.correo.texto.match(regex)) {
            this.nuevoUsuario.correo.validado = true;
            interfaz.actualizarClase(txtCorreo, "is-invalid", "is-valid");
            break;
          }

          this.nuevoUsuario.correo.validado = false;
          txtCorreo.classList.add("is-invalid");
          break;
        }
        case "Nombres": {
          if (this.nuevoUsuario.nombres == undefined) {
            break;
          }

          const txtNombres = this.$refs.nuevoUsuarioNombres;
          if (this.nuevoUsuario.nombres.texto.length > 0) {
            this.nuevoUsuario.nombres.validado = true;
            interfaz.actualizarClase(txtNombres, "is-invalid", "is-valid");
            break;
          }

          this.nuevoUsuario.nombres.validado = false;
          txtNombres.classList.add("is-invalid");
          break;
        }
        case "Apellidos": {
          if (this.nuevoUsuario.apellidos.texto == undefined) {
            break;
          }

          const txtApellidos = this.$refs.nuevoUsuarioApellidos;
          if (this.nuevoUsuario.apellidos.texto.length > 0) {
            this.nuevoUsuario.apellidos.validado = true;
            interfaz.actualizarClase(txtApellidos, "is-invalid", "is-valid");
            break;
          }

          this.nuevoUsuario.apellidos.validado = true;
          txtApellidos.classList.add("is-invalid");
          break;
        }
        case "Carrera": {
          if (this.nuevoUsuario.carrera == undefined) {
            break;
          }

          const txtCarrera = this.$refs.nuevoUsuarioCarrera;
          if (this.nuevoUsuario.carrera.texto.length > 0) {
            this.nuevoUsuario.carrera.validado = true;
            interfaz.actualizarClase(txtCarrera, "is-invalid", "is-valid");
            break;
          }

          this.nuevoUsuario.carrera.validado = true;
          txtCarrera.classList.add("is-invalid");
          break;
        }
      }
    },
    async registrarNuevoUsuario() {
      if (
        !this.nuevoUsuario.carnet.validado &&
        !this.nuevoUsuario.correo.validado &&
        !this.nuevoUsuario.nombres.validado &&
        !this.nuevoUsuario.apellidos.validado &&
        !this.nuevoUsuario.carrera.validado
      ) {
        this.usuarios = [];
        this.nuevoUsuario = {};

        alerta.mensaje(
          "Verifique los campos que no han sido validados.",
          "error"
        );
        return;
      }

      this.nuevoUsuarioCargando = true;
      this.usuarios = [];
      this.usuarios.push({
        carnet: this.nuevoUsuario.carnet.texto,
        correo: this.nuevoUsuario.correo.texto,
        nombres: this.nuevoUsuario.nombres.texto,
        apellidos: this.nuevoUsuario.apellidos.texto,
        carrera: this.nuevoUsuario.carrera.texto,
      });
      const usuarios = JSON.parse(JSON.stringify(this.usuarios));

      const res = await axios
        .post("/registrarUsuarios", {
          usuarios: usuarios,
        })
        .catch((error) => {
          alerta.mensaje(error, "error");
        });

      if (res.data.mensaje == "exito") {
        alerta.mensaje("Usuario registrado correctamente.", "success");
      } else {
        alerta.mensaje(
          "Usuario no pudieron ser registrados correctamente.",
          "error"
        );
      }
      this.usuarios = [];
      this.nuevoUsuario.carnet.texto = "";
      this.nuevoUsuario.correo.texto = "";
      this.nuevoUsuario.nombres.texto = "";
      this.nuevoUsuario.apellidos.texto = "";
      this.nuevoUsuario.carrera.texto = "";
      this.nuevoUsuarioCargando = false;
    },
  },
};
</script>
