<template>
  <div>
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
    <div v-if="banderaEventosAgregados == true">
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
      carnet: "010101",
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
      //Obtenemos el usuario
      let res = await axios.post("/api/obtenerPorCarnet", {
        carnet: this.carnet,
      });

      if (res.data.mensaje != "exito") {
        alerta.mensaje("Usuario no encontrado.", "error");
      }

      this.usuario = res.data.usuario[0];
      alerta.mensaje("Usuario encontrado.", "success");

      //Obtenemos las prácticas

      res = await axios
        .post("/api/practicaPorIdUsuario", {
          id: this.usuario.id,
        })
        .catch((error) => {
          console.log(error);
        });

      if (res.data.mensaje != "exito") {
        alerta.mensaje("La práctica no ha sido encontrada.", "error");
      }

      this.practicas = res.data.practicas;

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
