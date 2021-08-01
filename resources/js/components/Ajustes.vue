<template>
  <div class="container">
    <h4>Transmisión</h4>
    <hr class="featurette-divider" />
    <div class="row">
      <div class="col-12 div col-sm-12 col-md-12">
        <a
          href="#"
          class="btn btn-primary mt-1"
          @click="actualizarStreamCam0()"
          >{{ textoStreamCam0 }}</a
        >
        <a
          href="#"
          class="btn btn-primary mt-1"
          @click="actualizarStreamCam1()"
          >{{ textoStreamCam1 }}</a
        >
      </div>
      <div class="col-12 div col-sm-12 col-md-12">
        <stream />
      </div>
    </div>
  </div>
</template>

<script>
import Variable from "../libs/variable";
import axios from "axios";

const variable = new Variable();

export default {
  data() {
    return {
      textoStreamCam0: "Iniciar transmisión Cámara 1",
      valorStreamCam0: false,
      textoStreamCam1: "Iniciar transmisión Cámara 2",
      valorStreamCam1: false,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      const res = await axios.get(variable.urlSocket + "getStreamValue");
      if (!JSON.parse(res.data.streamingCam0)) {
        this.textoStreamCam0 = "Iniciar transmisión cámara 1";
      } else {
        this.textoStreamCam0 = "Cerrar transmisión cámara 1";
      }

      if (!JSON.parse(res.data.streamingCam1)) {
        this.textoStreamCam1 = "Iniciar transmisión cámara 2";
      } else {
        this.textoStreamCam1 = "Cerrar transmisión cámara 2";
      }
    },
    actualizarStreamCam0() {
      const res = axios.post(variable.urlSocket + "setStreamValue", {
        camara: "camara0",
      });
      this.init();
    },
    actualizarStreamCam1() {
      const res = axios.post(variable.urlSocket + "setStreamValue", {
        camara: "camara1",
      });
      this.init();
    },
  },
};
</script>
