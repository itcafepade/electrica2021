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
                  ><i class="bi bi-chevron-down"></i> Generals</a
                >

                <div class="card-body" id="generales">
                  <div class="col" align="center" justify="center">
                    <div class="col">
                      <div class="text-center pt-0">
                        START
                        <div class="my-2">
                          <v-btn color="success" fab x-large dark>
                            START
                          </v-btn>
                        </div>
                        STOP
                        <div class="my-2">
                          <v-btn color="error" fab x-large dark> STOP </v-btn>
                        </div>
                        <div class="my-2">
                          PERTURBATION
                          <v-switch v-model="switch1"></v-switch>
                        </div>
                        <div class="my-2">
                          <label for="inputSetPoint" class="form-label"
                            >Set Point(C)</label
                          >
                          <input
                            type="number"
                            id="inputSetPoint"
                            class="form-control"
                            value="0.00"
                            min="0.00"
                            max="100.00"
                            step=".01"
                          />
                          <br />
                          <label for="variableProceso" class="form-label"
                            >Process variable(C)</label
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
                          />
                        </div>
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
                            background: green;
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
                      <div class="my-2">
                        <a
                          href="#cambiarIndicador"
                          ref="btnIndicador"
                          @click="actualizarIndicador"
                          class="btn btn-info text-white text-decoration-none"
                        >
                          Flow indicator
                        </a>
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
                          <h4>Output High</h4>
                          <hr />
                          <label for="outputHigh" class="form-label"
                            >PID Data</label
                          >
                          <input
                            type="number"
                            id="outputHigh"
                            class="form-control"
                            value="500.00"
                            min="0.00"
                            step=".01"
                          />
                          <br />
                          <!-- <label for="outputLow" class="form-label"
                            >Output Low</label
                          >
                          <input
                            type="number"
                            id="outputLow"
                            class="form-control"
                            value="500.00"
                          />
                          <br /> -->
                          <label for="kcal" class="form-label">kcal/min</label>
                          <input
                            type="number"
                            id="kcal"
                            class="form-control"
                            value="500.00"
                            min="0.00"
                            step=".01"
                          />
                        </div>
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
                            value="0.00"
                            min="0.00"
                            max="1000.00"
                            step=".01"
                          />
                          <br />
                          <!-- <label for="integralTimeTi" class="form-label"
                            >Integral Time <br />
                            (Ti, min)</label
                          >
                          <input
                            type="number"
                            id="integralTimeTi"
                            class="form-control"
                            value="0.000"
                            min="0.000"
                            max="1000.00"
                            step=".001"
                          />
                          <br /> -->
                          <label for="integralTime" class="form-label"
                            >Integral</label
                          >
                          <input
                            type="number"
                            id="integralTime"
                            class="form-control"
                            value="0.000"
                            min="0.000"
                            max="1000.00"
                            step=".001"
                          />
                          <br />
                          <label for="derivative" class="form-label"
                            >Derivative</label
                          >
                          <input
                            type="number"
                            id="derivative"
                            class="form-control"
                            value="0.000"
                            min="0.000"
                            max="1000.00"
                            step=".001"
                          />
                          <br />
                          <label for="heater" class="form-label">Heater</label>
                          <input
                            type="number"
                            id="heater"
                            class="form-control"
                            value="0"
                            min="0"
                            max="1023"
                            step="1"
                          />
                          <br />
                          <label for="refresh" class="form-label"
                            >Refresh</label
                          >
                          <input
                            type="number"
                            id="refresh"
                            class="form-control"
                            value="0.1"
                            min="0.1"
                            max="30"
                            step=".1"
                          />
                          <br />
                          <label for="tempTanque2" class="form-label"
                            >Water temperature in tank 2</label
                          >
                          <input
                            type="number"
                            id="tempTanque2"
                            class="form-control"
                            value="0.00"
                            step=".01"
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
                  ><i class="bi bi-chevron-down"></i> Charts</a
                >
                <div class="card-body m-0" id="graficos">
                  <div v-if="datapoints.length > 0">
                    <grafico
                      :data="data"
                      :options="options"
                      :key="renderizarComponente"
                    />
                    <grafico :data="data" :options="options" />
                    <a href="#" @click="actualizarGrafica()"
                      >Actualizar gráfica</a
                    >
                  </div>
                  <br />
                  <h5>Water temperature</h5>
                  <input
                    type="number"
                    name=""
                    id=""
                    value="0.00"
                    step=".01"
                    v-model="temperaturaValor"
                    class="form-control"
                  />
                  <div class="container">
                    <div class="row text-center">
                      <div class="col-md-12">
                        <vue-speedometer
                          :maxSegmentLabels="1"
                          :customSegmentStops="[0, 50, 75, 100]"
                          :segmentColors="['green', 'gold', 'red']"
                          needleColor="#5959ac"
                          :currentValueText="'\${value}C°'"
                          :value="temperaturaValor"
                          :minValue="0"
                          :maxValue="100"
                          textColor="${textColor}"
                        />
                      </div>
                    </div>
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
                  ><i class="bi bi-chevron-down"></i> Streaming</a
                >
                <div class="card-body mx-auto" id="transmision">
                  <div class="row">
                    <stream :mostrarControles="mostrarControles" />
                  </div>
                  <div class="row">
                    <h5 class="pt-3">Simulation</h5>
                  </div>

                  <input
                    type="number"
                    v-model="nivelTanque1"
                    class="form-control"
                    step="0.01"
                    @change="modificarTanque()"
                  />
                  <input
                    type="number"
                    v-model="nivelTanque2"
                    class="form-control"
                    step="0.01"
                    @change="modificarTanque()"
                  />
                  <div class="row">
                    <div class="col">
                      <p>Tank 1</p>
                      <div class="water-tank1">
                        <div class="liquid1">
                          <svg class="water" viewBox="0 0 400 200">
                            <defs>
                              <linearGradient
                                id="waterGradient"
                                x1="0%"
                                y1="0%"
                                x2="0%"
                                y2="100%"
                              >
                                <stop offset="0" style="stop-color: #29abe2" />
                                <stop
                                  offset="0.1643"
                                  style="stop-color: #28a6e3"
                                />
                                <stop
                                  offset="0.3574"
                                  style="stop-color: #2496e6"
                                />
                                <stop
                                  offset="0.5431"
                                  style="stop-color: #1e7dea"
                                />
                                <stop
                                  offset="0.7168"
                                  style="stop-color: #1559f0"
                                />
                                <stop
                                  offset="0.874"
                                  style="stop-color: #0b2cf7"
                                />
                                <stop offset="1" style="stop-color: #0000ff" />
                              </linearGradient>
                            </defs>
                            <path
                              fill="url(#waterGradient)"
                              d="M 0,0 v 100 h 200 v -100
                                c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
                                c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
                                c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
                                c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5"
                            />
                          </svg>
                        </div>
                        <div ref="val1" class="val text-center">
                          <strong>{{ nivelTanque1 }}</strong>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <p>Tank 2</p>
                      <div class="water-tank2">
                        <div class="liquid2">
                          <svg class="water" viewBox="0 0 400 200">
                            <defs>
                              <linearGradient
                                id="waterGradient2"
                                x1="0%"
                                y1="0%"
                                x2="0%"
                                y2="100%"
                              >
                                <stop offset="0" style="stop-color: #29abe2" />
                                <stop
                                  offset="0.1643"
                                  style="stop-color: #28a6e3"
                                />
                                <stop
                                  offset="0.3574"
                                  style="stop-color: #2496e6"
                                />
                                <stop
                                  offset="0.5431"
                                  style="stop-color: #1e7dea"
                                />
                                <stop
                                  offset="0.7168"
                                  style="stop-color: #1559f0"
                                />
                                <stop
                                  offset="0.874"
                                  style="stop-color: #0b2cf7"
                                />
                                <stop offset="1" style="stop-color: #0000ff" />
                              </linearGradient>
                            </defs>
                            <path
                              fill="url(#waterGradient2)"
                              d="M 0,0 v 100 h 200 v -100
                                 c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
                                 c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
                                 c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
                                 c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5"
                            />
                          </svg>
                        </div>
                        <div ref="val2" class="val text-center">
                          <strong>{{ nivelTanque2 }}</strong>
                        </div>
                      </div>
                    </div>
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
import VueSpeedometer from "vue-speedometer";
import grafico from "./Grafico.vue";
import Interfaz from "../libs/interfaz";
// import stream from "./Stream.vue";

const ui = new Interfaz();

export default {
  components: { VueSpeedometer, grafico },
  data() {
    return {
      cambiarIndicador: 0,
      mostrarControles: true,
      switch1: true,
      temperaturaValor: 0,
      renderizarComponente: 0,
      labels: [],
      datapoints: [],
      data: {},
      options: {},
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
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      let DATA_COUNT = 6;
      for (let i = 0; i < DATA_COUNT; ++i) {
        this.labels.push(i.toString());
      }

      this.datapoints = [31.5, 31.6, 31.7, 32.0, 31.1, 31.5];

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
            label: "Process Variable",
            data: this.datapoints,
            borderColor: "#FF6384",
            fill: false,
            cubicInterpolationMode: "monotone",
            tension: 0.4,
          },
        ],
      };

      this.modificarTanque();
    },
    actualizarGrafica() {
      this.data.datasets[0].data = [36, 37, 31, 35];

      this.renderizarComponente += 1;
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
      console.log("Valor modificado");
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
      if (this.cambiarIndicador == 0) {
        this.$refs.indicador.setAttribute(
          "style",
          "width: 5rem;background: red;border-radius: 10px;border: solid 2px;"
        );
        this.cambiarIndicador = 1;
      } else {
        this.$refs.indicador.setAttribute(
          "style",
          "width: 5rem;background: green;border-radius: 10px;border: solid 2px;"
        );
        this.cambiarIndicador = 0;
      }
    },
  },
};
</script>

