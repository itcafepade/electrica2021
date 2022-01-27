<template>
  <v-app>
    <div class="fluid">
      <div class="row">
        <div class="col pd-5">
          <div class="row">
            <!-- Generals -->
            <div
              class="col-sm-12 col-12 col-md-6 col-lg-3 col-xl-2"
              id="cardGenerales"
            >
              <div class="card shadow-sm bg-body rounded">
                <a
                  href="#cardGenerales"
                  class="text-dark card-header text-decoration-none"
                  @click="mostrarCard"
                  ><i class="bi bi-chevron-down"></i> Main Control</a
                >

                <div class="card-body" id="generales">
                  <div class="col" align="center" justify="center">
                    <div class="col">
                      <div class="text-center pt-0">
                        START
                        <div class="my-2">
                          <v-btn
                            color="success"
                            fab
                            x-large
                            dark
                            :disabled="!enableToStart"
                            @click="
                              simuladorIniciado = true;
                              enviarEvento('12');
                            "
                          >
                            START
                          </v-btn>
                        </div>
                        STOP
                        <div class="my-2">
                          <v-btn
                            color="error"
                            fab
                            x-large
                            dark
                            :disabled="!enableToStart"
                            @click="enviarEvento('13')"
                          >
                            STOP
                          </v-btn>
                        </div>
                        RESET
                        <div class="my-2">
                          <v-btn
                            color="blue"
                            fab
                            x-large
                            dark
                            :disabled="enableToReset"
                            @click="enviarEvento('14')"
                          >
                            RESET
                          </v-btn>
                        </div>
                        <div class="my-2">
                          <label for="inputSetPoint" class="form-label"
                            >Set Point(C)</label
                          >
                          <input
                            type="number"
                            id="inputSetPoint"
                            class="form-control"
                            min="0.00"
                            max="100.00"
                            step="0.01"
                            v-model="setPoint"
                            :disabled="!simuladorIniciado"
                            @keyup="enviarEvento('50')"
                          />
                          <br />
                          <label for="variableProceso" class="form-label"
                            >Process variable</label
                          >
                          <input
                            type="number"
                            id="variableProceso"
                            class="form-control"
                            value="0.00"
                            min="0.00"
                            max="100.00"
                            step=".01"
                            disabled
                            v-model="variableProceso"
                          />
                        </div>
                      </div>
                      <div class="my-2">
                        DISTURBANCE
                        <v-switch
                          v-model="switch1"
                          @click="actualizarIndicador"
                          :key="renderizarComponenteSwitch"
                          :disabled="!simuladorIniciado"
                        ></v-switch>
                      </div>
                      <div class="my-2">
                        Flow indicator
                        <br />
                        <svg
                          ref="indicador"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink"
                          viewBox="0 0 30 30"
                          style="
                            width: 5rem;
                            background: red;
                            border-radius: 10px;
                            border: solid 2px;
                          "
                        >
                          <path
                            d="M12.984375 2.9863281 A 1.0001 1.0001 0 0 0 12 4L8.7285156 4 A 2 2 0 0 0 7 3 A 2 2 0 0 0 5 5 A 2 2 0 0 0 7 7 A 2 2 0 0 0 8.7304688 6L12 6L12 9.1308594 A 4 4 0 0 0 10.361328 10L4 10L4 16L10.361328 16 A 4 4 0 0 0 13 17 A 4 4 0 0 0 15.638672 16L18 16C19.105 16 20 16.895 20 18L20 21L26 21L26 18C26 13.582 22.418 10 18 10L15.638672 10 A 4 4 0 0 0 14 9.1328125L14 6L17.271484 6 A 2 2 0 0 0 19 7 A 2 2 0 0 0 21 5 A 2 2 0 0 0 19 3 A 2 2 0 0 0 17.269531 4L14 4 A 1.0001 1.0001 0 0 0 12.984375 2.9863281 z M 23 23C23 23 21 25.895 21 27C21 28.105 21.895 29 23 29C24.105 29 25 28.105 25 27C25 25.895 23 23 23 23 z"
                            fill="#fff"
                          />
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Generals -->

            <!-- Variables -->
            <div
              class="col-sm-12 col-12 col-md-6 col-lg-4 col-xl-2"
              id="cardVariables"
            >
              <div class="card shadow-sm bg-body rounded">
                <a
                  href="#cardVariables"
                  class="text-dark card-header text-decoration-none"
                  @click="mostrarCard"
                  ><i class="bi bi-chevron-down"></i> Variables</a
                >
                <div class="card-body" id="variables">
                  <div class="row" align="center" justify="center">
                    <div class="col">
                      <div class="text-center">
                        <div class="my-2">
                          <h4>PID Gains</h4>
                          <hr />
                          <label for="outputHigh" class="form-label"
                            >Proportional Gain <br />
                            (Kc)</label
                          >
                          <input
                            type="number"
                            id="proportionalGain"
                            class="form-control"
                            min="0.00"
                            max="1000.00"
                            step=".01"
                            v-model="datoPID"
                            :disabled="!simuladorIniciado"
                            @keyup="enviarEvento('51')"
                          />
                          <br />
                          <label for="integralTime" class="form-label"
                            >Integral Time <br />(Ti, min)</label
                          >
                          <input
                            type="number"
                            id="integralTime"
                            class="form-control"
                            v-model="integralTime"
                            :disabled="!simuladorIniciado"
                            @keyup="enviarEvento('52')"
                            value="0.000"
                            min="0.000"
                            max="1000.00"
                            step=".001"
                          />
                          <br />
                          <label for="derivative" class="form-label"
                            >Derivative <br />(Td, min)</label
                          >
                          <input
                            type="number"
                            id="derivative"
                            class="form-control"
                            value="0.000"
                            min="0.000"
                            max="1000.00"
                            step=".001"
                            :disabled="!simuladorIniciado"
                            v-model="pidDerivativo"
                            @keyup="enviarEvento('53')"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Variables -->

            <!-- Charts -->
            <div
              class="col-sm-12 col-12 col-md-6 col-lg-5 col-xl-4"
              id="cardGraficos"
            >
              <div class="card shadow-sm bg-body rounded">
                <a
                  href="#cardGraficos"
                  class="text-dark card-header text-decoration-none"
                  @click="mostrarCard"
                  ><i class="bi bi-chevron-down"></i> Graphs</a
                >
                <div class="card-body m-0" id="graficos">
                  <h5>Water Temperature (C)</h5>
                  <div class="container">
                    <div class="row text-center">
                      <div class="col-md-12">
                        <vue-speedometer
                          :maxSegmentLabels="1"
                          :customSegmentStops="[0, 50, 75, 100]"
                          :segmentColors="['green', 'gold', 'red']"
                          needleColor="#5959ac"
                          :currentValueText="'\${value}C°'"
                          :value="temperatura"
                          :minValue="0"
                          :maxValue="100"
                          textColor="${textColor}"
                        />
                      </div>
                    </div>
                  </div>
                  <br />
                  <div v-if="datapoints.length > 0 || datapoints2.length > 0">
                    <h5>Graphics</h5>
                    <grafico
                      :data="data"
                      :options="options"
                      :key="renderizarComponente"
                    />
                    <grafico-salida
                      :data="data3"
                      :options="options3"
                      :key="renderizarComponente + 1"
                    />
                  </div>
                </div>
              </div>
            </div>
            <!-- Charts -->

            <!-- Transmisión -->
            <div
              class="col-sm-12 col-12 col-md-6 col-lg-5 col-xl-4"
              id="cardTransmision"
            >
              <div class="card shadow-sm bg-body rounded">
                <a
                  href="#cardTransmision"
                  class="text-dark card-header text-decoration-none"
                  @click="mostrarCard"
                  ><i class="bi bi-chevron-down"></i> Transmission</a
                >
                <div class="card-body mx-auto" id="transmision">
                  <div class="row">
                    <stream :mostrarControles="mostrarControles" />
                  </div>
                </div>
              </div>
            </div>
            <!-- Transmisión -->
          </div>
        </div>
      </div>
    </div>
  </v-app>
</template>

<script>
const io = require("socket.io-client");
import VueSpeedometer from "vue-speedometer";
import grafico from "./Grafico.vue";
import Interfaz from "../libs/interfaz";
import Alerta from "../libs/alerta";
import Variable from "../libs/variable";
// import stream from "./Stream.vue";

const ui = new Interfaz();
const alerta = new Alerta();
const variable = new Variable();
let socket;

export default {
  components: { VueSpeedometer, grafico },
  data() {
    return {
      cambiarIndicador: 0,
      mostrarControles: true,
      switch1: false,
      temperaturaValor: 0,
      renderizarComponente: 0,
      labels: [],
      datapoints: [],
      datapoints2: [],
      datapoints3: [],
      data: {},
      data2: {},
      data3: {},
      options: {},
      options2: {},
      options3: {},
      animacionesOcultas: {
        generales: {
          nombre: "generales",
          estado: false,
        },
        variables: {
          nombre: "variables",
          estado: false,
        },
        graficos: {
          nombre: "graficos",
          estado: false,
        },
        transmision: {
          nombre: "transmision",
          estado: false,
        },
      },
      nivelTanque1: 0.0,
      nivelTanque2: 0.0,
      actualizarComponente: 0,
      variableProceso: 32,
      setPoint: 32,
      datoPID: 10,
      integralTime: 0.01,
      temperatura: 25,
      pidDerivativo: 100,
      cicloCalentador: 20,
      timeOutEntrenador: 0,
      simuladorIniciado: false,
      intervalLecturas: "",
      renderizarComponenteSwitch: 0,
      leerValores: false,
      leerFinalizado: false,
      enableToStart: false,
      enableToReset: false,
    };
  },
  mounted() {
    this.init();
  },
  watch: {
    simuladorIniciado(val) {
      if (val) {
        this.switch1 = false;
      }
    },
  },
  methods: {
    init() {
      let DATA_COUNT = 30;
      for (let i = 0; i < DATA_COUNT; ++i) {
        this.labels.push(i.toString());
      }

      this.datapoints = [];
      this.datapoints2 = [];
      this.datapoints3 = [];

      this.options = {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: "Process Variable and Set Point",
          },
        },

        interaction: {
          intersect: false,
        },
        scales: {
          x: {
            display: true,
            title: {
              display: true,
            },
          },
          y: {
            display: true,
            title: {
              display: true,
              text: "Value",
            },
            suggestedMin: 31.85,
            suggestedMax: 32.1,
          },
        },
      };

      this.data = {
        labels: this.labels,
        datasets: [
          {
            label: "Set Point (SP)",
            data: this.datapoints,
            borderColor: "#FF6384",
            fill: false,
            cubicInterpolationMode: "monotone",
            tension: 0.4,
          },
          {
            label: "Process Variable (PV)",
            data: this.datapoints2,
            borderColor: "#0078b9",
            fill: false,
            cubicInterpolationMode: "monotone",
            tension: 0.4,
          },
        ],
      };

      this.options2 = {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: "Controller Output (%)",
          },
        },

        interaction: {
          intersect: false,
        },
        scales: {
          x: {
            display: true,
            title: {
              display: true,
            },
          },
          y: {
            display: true,
            title: {
              display: true,
              text: "Value",
            },
            suggestedMin: 31.85,
            suggestedMax: 32.1,
          },
        },
      };

      this.data2 = {
        labels: this.labels,
        datasets: [
          {
            label: "Ciclo de trabajo del controlador",
            data: this.datapoints2,
            borderColor: "#FF6384",
            fill: false,
            cubicInterpolationMode: "monotone",
            tension: 0.4,
          },
        ],
      };

      this.options3 = {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: "Controller Output (%)",
          },
        },

        interaction: {
          intersect: false,
        },
        scales: {
          x: {
            display: true,
            title: {
              display: true,
            },
          },
          y: {
            display: true,
            title: {
              display: true,
              text: "Value",
            },
            suggestedMin: 31.85,
            suggestedMax: 32.1,
          },
        },
      };

      this.data3 = {
        labels: this.labels,
        datasets: [
          {
            label: "Ciclo de trabajo del controlador",
            data: this.datapoints3,
            borderColor: "#FF6384",
            fill: false,
            cubicInterpolationMode: "monotone",
            tension: 0.4,
          },
        ],
      };
      this.modificarTanque();
    },

    actualizarGrafica(index, valor) {
      if (valor) {
        if (this.data.datasets[index].data.length == 30) {
          this.data.datasets[index].data.shift();
        }
        this.data.labels = [];

        let DATA_COUNT = this.datapoints3.length;

        for (let i = 1; i < DATA_COUNT; ++i) {
          this.data.labels.push(i.toString());
        }

        this.data.datasets[index].data.push(valor);
        // console.log(this.data.datasets[index].data);
        // this.renderizarComponente += 1;
      }
    },

    actualizarGraficaSalida(valor) {
      //   console.log("Salida: " + valor);
      if (valor) {
        if (this.data3.datasets[0].data.length == 30) {
          this.data3.datasets[0].data.shift();
        }
        this.data3.labels = [];

        let DATA_COUNT = this.datapoints3.length;
        // console.log(this.datapoints2.length);

        for (let i = 1; i < DATA_COUNT; ++i) {
          this.data3.labels.push(i.toString());
        }

        this.data3.datasets[0].data.push(valor);
        this.renderizarComponente += 1;
      }
    },

    mostrarCard(e) {
      const icono = e.target.parentNode.parentNode.querySelector(".bi");
      const card = e.target.parentNode.parentNode.querySelector(".card-body");

      const ref = card.getAttribute("id");

      if (ref == this.animacionesOcultas.variables.nombre) {
        let estado = ui.mostrarObjeto(
          card,
          this.animacionesOcultas.variables,
          icono
        );

        this.animacionesOcultas.variables.estado = estado;
      }

      if (ref == this.animacionesOcultas.generales.nombre) {
        const estado = ui.mostrarObjeto(
          card,
          this.animacionesOcultas.generales,
          icono
        );

        this.animacionesOcultas.generales.estado = estado;
      }

      if (ref == this.animacionesOcultas.graficos.nombre) {
        const estado = ui.mostrarObjeto(
          card,
          this.animacionesOcultas.graficos,
          icono
        );

        this.animacionesOcultas.graficos.estado = estado;
      }

      if (ref == this.animacionesOcultas.transmision.nombre) {
        const estado = ui.mostrarObjeto(
          card,
          this.animacionesOcultas.transmision,
          icono
        );

        this.animacionesOcultas.transmision.estado = estado;
      }
    },

    modificarTanque() {
      // console.log("Valor modificado");
      //   this.nivelTanque1 = 20;
      //   this.nivelTanque2 = 100;

      //   this.$refs.val1.innerHTML = "<strong>" + this.nivelTanque1 + "</strong>";
      //   this.$refs.val2.innerHTML = "<strong>" + this.nivelTanque2 + "</strong>";

      let rootElement1 = document.documentElement;
      rootElement1.style.setProperty(
        "--top1",
        "calc(100% - " + this.nivelTanque1 + "%)"
      );
      let rootElement2 = document.documentElement;
      rootElement2.style.setProperty(
        "--top2",
        "calc(100% - " + this.nivelTanque2 + "%)"
      );

      //   this.nivelTanque1 = this.nivelTanque1 + " mL";
      //   this.nivelTanque2 = this.nivelTanque2 + " mL";

      this.actualizarComponente++;
    },

    actualizarIndicador() {
      if (!this.simuladorIniciado) {
        this.switch1 = false;
        this.renderizarComponenteSwitch++;
        alerta.mensaje(
          "Debes iniciar el entrenador antes de continuar.",
          "error"
        );
        return;
      }

      if (this.cambiarIndicador == 0) {
        this.cambiarIndicador = 1;
        this.enviarEvento("10");
      } else {
        this.cambiarIndicador = 0;
        this.enviarEvento("11");
      }
    },

    async enviarEvento(valor = 0) {
      window.clearTimeout(this.timeOutEntrenador);

      this.timeOutEntrenador = setTimeout(async () => {
        let valores = {
          primerValor: valor,
          segundoValor: "-1",
        };

        if (!this.enableToStart && valor != "14") {
          alerta.mensaje(
            "Debes reiniciar el entrenador antes de iniciar.",
            "error"
          );
          return;
        }

        if (this.enableToStart && !this.simuladorIniciado && valor != "12") {
          alerta.mensaje(
            "Debes iniciar el entrenador antes de continuar.",
            "error"
          );
          return;
        }

        let valido = true;
        switch (valor) {
          case "50":
            this.leerValores = false;
            valores.segundoValor = this.setPoint;

            if (
              !valores.segundoValor ||
              valores.segundoValor < 0 ||
              valores.segundoValor > 100
            ) {
              valido = false;
            }
            break;
          case "51":
            this.leerValores = false;
            valores.segundoValor = this.datoPID;

            if (
              !valores.segundoValor ||
              valores.segundoValor < 0 ||
              valores.segundoValor > 100
            ) {
              valido = false;
            }

            break;
          case "52":
            this.leerValores = false;
            valores.segundoValor = this.integralTime;

            if (
              !valores.segundoValor ||
              valores.segundoValor < 0 ||
              valores.segundoValor > 100
            ) {
              valido = false;
            }
            break;
          case "53":
            this.leerValores = false;
            valores.segundoValor = this.pidDerivativo;

            if (
              !valores.segundoValor ||
              valores.segundoValor < 0 ||
              valores.segundoValor > 1000
            ) {
              valido = false;
            }
            break;
          default:
            valores.segundoValor = "-1";
            break;
        }

        if (!valido && this.simuladorIniciado) {
          alerta.mensaje("Debes ingresar un valor válido.", "error");
          return;
        }

        const res = await axios
          .post("/api/enviarEvento", valores)
          .catch((error) => {
            // console.log("No se pudo actualizar el valor.");
            alerta.mensaje("El Entrenador no pudo ser actualizado.", "error");
          });

        if (res.data.message == "success") {
          alerta.mensaje("Entrenador actualizado correctamente.", "success");
          // console.log("Valor actualizado correctamente.");
        }

        const opt = valores.primerValor;
        switch (opt) {
          case "10": // Inicar perturbación
            this.$refs.indicador.setAttribute(
              "style",
              "width: 5rem;background: green;border-radius: 10px;border: solid 2px;"
            );
            alerta.mensaje("Perturbación iniciada correctamente.", "success");
            this.leerValores = true;
            // this.iniciarLecturas();
            break;
          case "11": // Detener perturbación
            this.$refs.indicador.setAttribute(
              "style",
              "width: 5rem;background: red;border-radius: 10px;border: solid 2px;"
            );
            alerta.mensaje("Perturbación detenida correctamente.", "success");
            this.leerValores = true;
            // this.iniciarLecturas();
            break;
          case "12": //Iniciar
            alerta.mensaje("Entrenador iniciado correctamente.", "success");
            this.leerValores = true;
            // this.enableToStart = false;
            this.iniciarLecturas();
            break;
          case "13": //Parar
            alerta.mensaje("Entrenador detenido correctamente.", "success");
            this.leerValores = false;
            this.enableToReset = false;
            this.enableToStart = false;
            // this.enableToStart = true;
            break;
          case "14": //Reiniciar
            alerta.mensaje("Entrenador reiniciado correctamente.", "success");
            this.init();
            this.enableToReset = true;
            this.enableToStart = true;
            this.leerValores = true;
            // this.iniciarLecturas();
            break;
          case "20":
            this.leerValores = true;
            // this.iniciarLecturas();
            break;
          case "21":
            // console.log("21: " + res.data.lectura);
            this.actualizarGraficaSalida(parseFloat(res.data.lectura));
            // this.actualizarGraficaSalida(parseFloat(this.prueba + 1));
            // this.iniciarLecturas();
            break;
          case "22":
            // console.log("22: " + res.data.lectura);
            // this.temperatura = parseFloat(17);
            this.temperatura = parseFloat(res.data.lectura);
            // this.iniciarLecturas();
            break;
          case "23":
            console.log("23", res.data.lectura);
            this.actualizarGrafica(0, parseFloat(res.data.lectura));
            this.actualizarGrafica(1, parseFloat(this.setPoint).toFixed(2));
            this.renderizarComponente += 1;
            // this.iniciarLecturas();
            break;
          case "24":
            //   valores.primerValor = 24;
            break;
          case "25":
            //   valores.primerValor = 25;
            break;
          case "26":
            //   valores.primerValor = 26;
            break;
          case "50":
            this.leerValores = true;
            // this.iniciarLecturas();
            break;
          case "51":
            this.leerValores = true;
            // this.iniciarLecturas();
            break;
          case "52":
            this.leerValores = true;
            // console.log("52: " + res.data.lectura);
            // this.iniciarLecturas();
            break;
          case "53":
            this.leerValores = true;
            // this.iniciarLecturas();
            break;
        }
      }, 500);
    },

    async iniciarLecturas(value = "21") {
      if (value == "21") {
        await this.enviarEvento("21");
        value = "22";
      } else if (value == "22") {
        await this.enviarEvento("22");
        value = "23";
      } else {
        await this.enviarEvento("23");
        value = "21";
      }

      if (this.leerValores) {
        await setTimeout(() => {
          this.iniciarLecturas(value);
        }, 1500);
      }
    },

    clearAllIntervals() {
      this.leerValores = false;
    },
  },
};
</script>

<style>
.speedometer {
  width: 300px;
  height: 200px !important;
}
</style>

