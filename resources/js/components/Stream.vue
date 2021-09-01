<template>
  <div class="container-fluid">
    <div class="row">
      <button href="#" class="btn btn-danger" id="desconectar">
        Desconectar
      </button>
      <button class="btn btn-primary" style="display: none" id="conectar">
        Conectar
      </button>
    </div>
    <div class="row">
      <div class="col-md-6 m-0 p-0">
        <h6 class="pb-0 mb-0 pt-3">Cámara 1</h6>
        <video
          ref="imgStreamCam0"
          width="100%"
          height="100%"
          preload="metadata"
          poster="/imgs/transmision.png"
          class="img-fluid"
        ></video>
      </div>
      <div class="col-md-6 m-0 p-0 pb-5 mb-5">
        <h6 class="pb-0 mb-0 pt-3">Cámara 2</h6>
        <video
          ref="imgStreamCam1"
          width="100%"
          height="100%"
          preload="metadata"
          poster="/imgs/transmision.png"
          class="img-fluid"
        ></video>
      </div>
    </div>
  </div>
</template>

<script>
const io = require("socket.io-client");
import Alerta from "../libs/alerta";
import Variable from "../libs/variable";
import axios from "axios";
import { DatasetController } from "chart.js";

// const variable.urlSocket = "http://192.168.1.24:3000/";
const variable = new Variable();
// console.log(variable.constructor.urlSocket);
const alerta = new Alerta();

export default {
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      const socket = io.connect(variable.urlSocket, {
        reconnection: false,
      });

      $("#desconectar").click(() => {
        document
          .getElementById("desconectar")
          .setAttribute("style", "display:none");
        document
          .getElementById("conectar")
          .setAttribute("style", "display:block");

        socket.disconnect();
      });

      $("#conectar").click(() => {
        document
          .getElementById("desconectar")
          .setAttribute("style", "display:block");
        document
          .getElementById("conectar")
          .setAttribute("style", "display:none");

        socket.connect();
      });

      socket.on("connect", () => {
        console.log("cliente reconectado");
      });

      socket.on("disconnect", () => {
        this.$refs.imgStreamCam0.poster = "/imgs/transmision.png";
        this.$refs.imgStreamCam1.poster = "/imgs/transmision.png";
        console.log("cliente desconectado del servidor");
      });

      socket.on("image-wCap", (image) => {
        this.$refs.imgStreamCam0.poster = `data:image/webpp;base64,${image}`;
      });

      socket.on("image-wCap1", (image) => {
        this.$refs.imgStreamCam1.poster = `data:image/webpp;base64,${image}`;
      });

      socket.on("streamingCam0", (streaming) => {
        if (!JSON.parse(streaming)) {
          alerta.mensaje(
            "La transmisión de la cámara 1 ha iniciado.",
            "success"
          );
        } else {
          alerta.mensaje("La transmisión de la cámara 1 ha terminado.", "info");
          this.$refs.imgStreamCam0.poster = "/imgs/transmision.png";
        }
      });

      socket.on("streamingCam1", (streaming) => {
        if (!JSON.parse(streaming)) {
          alerta.mensaje(
            "La transmisión de la cámara 2 ha iniciado.",
            "success"
          );
        } else {
          alerta.mensaje("La transmisión de la cámara 2 ha terminado.", "info");
          this.$refs.imgStreamCam1.poster = "/imgs/transmision.png";
        }
      });

      const res = await axios.get(variable.urlSocket + "getStreamValue");
      if (!res.data.streamingCam0) {
        this.$refs.imgStreamCam0.poster = "/imgs/transmision.png";
        alerta.mensaje(
          "No hay una transmisión de la cámara 1 por mostrar.",
          "info"
        );
      } else {
        alerta.mensaje(
          "Te has conectado a la transmisión de la cámara 1.",
          "success"
        );
      }

      if (!res.data.streamingCam1) {
        this.$refs.imgStreamCam1.poster = "/imgs/transmision.png";
        alerta.mensaje(
          "No hay una transmisión de la cámara 2 por mostrar.",
          "info"
        );
      } else {
        alerta.mensaje(
          "Te has conectado a la transmisión de la cámara 2.",
          "success"
        );
      }
    },
  },
};
</script>
