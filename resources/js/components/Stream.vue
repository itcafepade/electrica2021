<template>
  <div class="container-fluid">
    <div class="container" v-if="mostrarControl">
      <div v-if="streamingCam0 || streamingCam1">
        <button class="btn btn-danger" @click="cambiarControl()" ref="control">
          Desconectar
        </button>
      </div>
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
import Interfaz from "../libs/interfaz";

const variable = new Variable();
const alerta = new Alerta();
const interfaz = new Interfaz();
let socket;

export default {
  data() {
    return {
      streamingCam0: false,
      streamingCam1: false,
      mostrarControl: this.mostrarControles,
    };
  },
  props: { mostrarControles: Boolean },
  mounted() {
    console.log(this.mostrarControles);
    this.init();
  },
  methods: {
    async init() {
      /**
       *
       * SOCKET.IO
       *
       */
      socket = io.connect(variable.urlSocket, {
        reconnection: false,
      });

      socket.on("connect", () => {
        console.log("cliente reconectado");
      });

      socket.on("disconnect", () => {
        this.$refs.imgStreamCam0.poster = "/imgs/transmision.png";
        this.$refs.imgStreamCam1.poster = "/imgs/transmision.png";
        console.log("Cliente desconectado del servidor");
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

      /**
       *
       * SOCKET.IO
       *
       */

      const res = await axios.get(variable.urlSocket + "getStreamValue");

      this.streamingCam0 = res.data.streamingCam0;
      console.log("Streaming cam 0: " + res.data.streamingCam0);
      this.streamingCam1 = res.data.streamingCam1;
      console.log("Streaming cam 1: " + res.data.streamingCam1);

      if (!this.streamingCam0) {
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

      if (!this.streamingCam1) {
        this.$refs.imgStreamCam1.poster = "/imgs/transmision.png";
        setTimeout(() => {
          alerta.mensaje(
            "No hay una transmisión de la cámara 2 por mostrar.",
            "info"
          );
        }, 2000);
      } else {
        alerta.mensaje(
          "Te has conectado a la transmisión de la cámara 2.",
          "success"
        );
      }

      this.inicializarValorStream();
    },
    cambiarControl() {
      if (!this.streamingCam0 || !this.streamingCam1) {
        this.$refs.control.setAttribute("style", "display: none");
        return;
      }

      this.$refs.control.setAttribute("style", "display: block");

      if (localStorage.getItem("estado") == "conectado") {
        interfaz.actualizarClase(
          this.$refs.control,
          "btn-danger",
          "btn-primary"
        );

        this.$refs.control.innerText = "Conectar";
        socket.disconnect();
        localStorage.setItem("estado", "desconectado");

        return;
      }

      this.$refs.control.innerText = "Desconectar";
      interfaz.actualizarClase(this.$refs.control, "btn-primary", "btn-danger");
      socket.connect();
      localStorage.setItem("estado", "conectado");
    },

    inicializarValorStream() {
      if (localStorage.getItem("estado") == null) {
        if (!this.streamingCam0 || !this.streamingCam1) {
          localStorage.setItem("estado", "desconectado");
        } else {
          localStorage.setItem("estado", "conectado");
        }
      }

      setTimeout(() => {
        if (this.$refs.control) {
          this.$refs.control.setAttribute("style", "display: block");

          if (localStorage.getItem("estado") == "conectado") {
            this.$refs.control.innerText = "Desconectar";
            interfaz.actualizarClase(
              this.$refs.control,
              "btn-primary",
              "btn-danger"
            );
            socket.connect();
          } else {
            interfaz.actualizarClase(
              this.$refs.control,
              "btn-danger",
              "btn-primary"
            );

            this.$refs.control.innerText = "Conectar";
            socket.disconnect();
          }
        }
      }, 20);
    },
  },
};
</script>
