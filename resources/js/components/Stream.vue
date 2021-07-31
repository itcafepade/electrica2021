<template>
  <video ref="imgStream" width="100%" height="100%" preload="metadata"></video>
</template>

<script>
const io = require("socket.io-client");
import Alerta from "../libs/alerta";
import Variable from "../libs/variable";
import axios from "axios";

// const variable.urlSocket = "http://192.168.1.24:3000/";
const variable = new Variable();
// console.log(variable.constructor.urlSocket);
const alerta = new Alerta();
const socket = io.connect(variable.urlSocket);

export default {
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      socket.on("image", (image) => {
        // console.log("typeof" + image);
        this.$refs.imgStream.poster = `data:image/jpeg;base64,${image}`;
        // console.log("New image");
      });

      socket.on("streaming", (streaming) => {
        if (!JSON.parse(streaming)) {
          alerta.mensaje("La transmisión ha terminado.", "info");
          this.$refs.imgStream.poster = "/imgs/logo.png";
        } else {
          alerta.mensaje("La transmisión ha iniciado.", "success");
        }
      });

      const res = await axios.get(variable.urlSocket + "getStreamValue");
      if (!res.data.streaming) {
        this.$refs.imgStream.poster = "/imgs/logo.png";
        alerta.mensaje("No hay una transmisión por mostrar.", "info");
        return;
      }
      alerta.mensaje("Te has conectado a la transmisión.", "success");
    },
  },
};
</script>
