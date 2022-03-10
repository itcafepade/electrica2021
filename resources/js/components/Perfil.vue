<template>
  <div class="row" v-if="usuarioActual">
    <div class="row">
      <div class="col-md-12"><b>Nombre:</b> {{ usuarioActual.name }}</div>
      <div class="col-md-12"><b>Correo:</b> {{ usuarioActual.email }}</div>
      <div class="col-md-12"><b>Carrera:</b> {{ usuarioActual.carrera }}</div>
      <div class="col-md-4">
        <b>Contraseña:</b>
        <input
          :type="showPassword"
          class="form-control"
          v-model="usuarioActual.password"
        />
        <a href="#" @click="showHidePassword">Mostrar constraseña</a>
      </div>
    </div>
    <div class="col-md-12 text-center">
      <a href="#" class="btn btn-primary" @click="updateUsuarioActual"
        >Actualizar</a
      >
    </div>
  </div>
</template>

<script>
import Alerta from "../libs/alerta";

const alerta = new Alerta();

export default {
  data() {
    return {
      usuarioActual: {},
      showPassword: "password",
    };
  },

  mounted() {
    this.init();
  },

  methods: {
    async init() {
      let res = await axios.get("/usuarioActual");

      console.log(res.data.name);
      if (res) {
        this.usuarioActual = res.data;
      }
    },

    showHidePassword() {
      this.showPassword = this.showPassword == "password" ? "text" : "password";
    },

    async updateUsuarioActual() {
      if (
        this.usuarioActual.password == "" ||
        !this.usuarioActual.password ||
        this.usuarioActual.password.length < 8
      ) {
        alerta.mensaje(
          "Debes asignar una contraseña y debe contener al menos 8 carácteres.",
          "error"
        );
        return;
      }

      const res = await axios
        .put(`/api/user/${this.usuarioActual.id}`, this.usuarioActual)
        .catch((error) => {
          alerta.mensaje("No fue posible actualizar los datos.", "error");
        });

      if (res && res.data.mensaje == "exito") {
        alerta.mensaje("Registro modificado exitosamente.", "success");
      }

      setTimeout(() => {
        window.location = "/home";
      }, 3000);
    },
  },
};
</script>

<style>
</style>
