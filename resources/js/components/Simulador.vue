<template>
  <v-app>
    <div class="fluid">
      <div class="row">
        <div class="col pd-5">
          <div class="row">
            <!-- Generales -->
            <div
              class="col-sm-12 col-12 col-md-6 col-lg-3 col-xl-2"
              id="cardGenerales"
            >
              <div class="card shadow-sm bg-body rounded">
                <a
                  href="#cardGenerales"
                  class="text-dark card-header text-decoration-none"
                  @click="mostrarCard"
                  ><i class="bi bi-chevron-down"></i> Generales</a
                >

                <div class="card-body" id="generales">
                  <div class="col" align="center" justify="center">
                    <div class="col">
                      <div class="text-center pt-0">
                        INICIO
                        <div class="my-2">
                          <v-btn color="success" fab x-large dark>
                            INICIO
                          </v-btn>
                        </div>
                        PARAR
                        <div class="my-2">
                          <v-btn color="error" fab x-large dark> PARAR </v-btn>
                        </div>
                        <div class="my-2">
                          PERTURBACION
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
                            value="32"
                          />
                          <br />
                          <label for="variableProceso" class="form-label"
                            >Variable Proceso(C)</label
                          >
                          <input
                            type="number"
                            id="variableProceso"
                            class="form-control"
                            value="32"
                            disabled
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Generales -->

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
                            >Datos PID</label
                          >
                          <input
                            type="number"
                            id="outputHigh"
                            class="form-control"
                            value="500.00"
                          />
                          <br />
                          <label for="outputLow" class="form-label"
                            >Output Low</label
                          >
                          <input
                            type="number"
                            id="outputLow"
                            class="form-control"
                            value="500.00"
                          />
                          <br />
                          <label for="kcal" class="form-label">kcal/min</label>
                          <input
                            type="number"
                            id="kcal"
                            class="form-control"
                            value="500.00"
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
                            value="1.000"
                          />
                          <br />
                          <label for="integralTimeTi" class="form-label"
                            >Integral Time <br />
                            (Ti, min)</label
                          >
                          <input
                            type="number"
                            id="integralTimeTi"
                            class="form-control"
                            value="0.010"
                          />
                          <br />
                          <label for="integralTime" class="form-label"
                            >Integral Time</label
                          >
                          <input
                            type="number"
                            id="integralTime"
                            class="form-control"
                            value="0.010"
                          />
                          <br />
                          <label for="tempTanque2" class="form-label"
                            >Temperatura de agua en Tanque 2</label
                          >
                          <input
                            type="number"
                            id="tempTanque2"
                            class="form-control"
                            value="25"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Variables -->

            <!-- Gráficos -->
            <div
              class="col-sm-12 col-12 col-md-6 col-lg-5 col-xl-4"
              id="cardGraficos"
            >
              <div class="card shadow-sm bg-body rounded">
                <a
                  href="#cardGraficos"
                  class="text-dark card-header text-decoration-none"
                  @click="mostrarCard"
                  ><i class="bi bi-chevron-down"></i> Gráficos</a
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
                  <h5>Temperatura Agua</h5>
                  <input
                    type="text"
                    name=""
                    id=""
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
            <!-- Gráficos -->

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
                  ><i class="bi bi-chevron-down"></i> Transmisión</a
                >
                <div class="card-body mx-auto" id="transmision">
                  <div class="row">
                    <stream />
                  </div>
                  <h5 class="pt-3">Simulación</h5>
                  <input
                    type="number"
                    v-model="nivelTanque1"
                    class="form-control"
                    @change="modificarTanque()"
                  />
                  <input
                    type="number"
                    v-model="nivelTanque2"
                    @change="modificarTanque()"
                    class="form-control"
                  />
                  <div class="row">
                    <div class="col">
                      <p>Tanque 1</p>
                      <div class="water-tank1">
                        <div class="liquid1">
                          <svg class="water" viewBox="0 0 200 100">
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
                      <p>Tanque 2</p>
                      <div class="water-tank2">
                        <div class="liquid2">
                          <svg class="water" viewBox="0 0 200 100">
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
      nivelTanque1: 0,
      nivelTanque2: 0,
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

      this.actualizarComponente++;
    },
  },
};
</script>

