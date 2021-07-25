<template>
  <div class="container">
    <h4>Transmisión</h4>
    <hr class="featurette-divider" />
    <div class="row">
      <div class="col-12 div col-sm-12 col-md-4">
        <a href="#" class="btn btn-primary" @click="actualizarStream()">{{
          textoStream
        }}</a>
      </div>
      <div class="col-12 div col-sm-12 col-md-4">
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
      textoStream: "Iniciar transmisión",
      valorStream: false,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      const res = await axios.get(variable.urlSocket + "getStreamValue");
      if (!res.data.streaming) {
        this.textoStream = "Iniciar transmisión";
        return;
      }
      this.textoStream = "Cancelar transmisión";
    },
    actualizarStream() {
      const res = axios.post(variable.urlSocket + "setStreamValue");
      this.init();
    },
  },
};
</script>
