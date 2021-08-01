<template>
  <div class="acciones">
    <div class="row">
      <div class="col-6 col-md-4 pr-0 offset-2 offset-md-4">
        <input
          class="form-control"
          type="text"
          placeholder="Carnet"
          v-model="carnet"
        />
      </div>
      <div class="col-4 pl-0">
        <a class="btn btn-success" href="#" @click="buscarPorCarnet()"
          >Buscar</a
        >
      </div>
    </div>
    <div v-if="banderaEventosAgregados">
      <practica
        :key="actualizarPractica"
        :usuario="usuario"
        :practicas="practicas"
      />
    </div>
  </div>
</template>

<script>
import practica from "./Practica.vue";
import Alerta from "../libs/alerta";

const alerta = new Alerta();

export default {
  components: { practica },
  data() {
    return {
      carnet: "",
      usuario: [],
      actualizarPractica: 0,
      practicas: [],
      banderaEventosAgregados: false,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {},
    async buscarPorCarnet() {
      this.usuario = [];
      this.practicas = [];
      this.banderaEventosAgregados = false;

      //Obtenemos el usuario
      let res = await axios.post("/api/obtenerPorCarnet", {
        carnet: this.carnet,
      });

      if (res.data.mensaje != "exito") {
        alerta.mensaje("Usuario no encontrado.", "error");
      }

      this.usuario = res.data.usuario[0];

      //Obtenemos las prácticas
      res = await axios
        .post("/api/practicaPorIdUsuario", {
          id: this.usuario.id,
        })
        .catch((error) => {
          console.log(error);
          alerta.mensaje(
            "No se pudo obtener la información del usuario.",
            "error",
            2000
          );
        });

      this.practicas = res.data.practicas;

      if (this.practicas.length == 0) {
        alerta.mensaje(
          "Se encontró al usuario pero aún no tiene registros por mostrar.",
          "info"
        );
      }

      //Obtenemos los eventos realizados en las practicas
      for (let index = 0; index < this.practicas.length; index++) {
        res = await axios
          .post("/api/historialPorIdUsuario", {
            id: this.practicas[index].id,
          })
          .catch((error) => {
            console.log(error);
          });

        this.practicas[index].eventos = res.data.historial;
      }

      this.banderaEventosAgregados = true;
    },
  },
};
</script>

<style>
.acciones {
  min-height: 100%;
}
</style>
