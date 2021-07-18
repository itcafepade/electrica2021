<template>
  <div class="row">
    <div class="col pd-5">
      <div class="row">
        <div class="col-sm-12 col-12 col-md-6 col-lg-3 col-xl-2">
          <div class="card">
            <div class="card-header">
              <a
                href="#"
                class="text-dark"
                @click="mostrarCard"
                id="cardVariables"
                ><i class="bi bi-chevron-down"></i
              ></a>
              Variables
            </div>
            <div
              class="card-body wow"
              data-wow-delay="0ms"
              data-wow-duration="500ms"
              data-wow-offset="0"
              id="variables"
            >
              <v-app>
                <v-container>
                  <v-row align="center" justify="center">
                    <v-col>
                      <div class="text-center">
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
                    </v-col>
                  </v-row>
                </v-container>
              </v-app>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-12 col-md-6 col-lg-4 col-xl-2">
          <div class="card">
            <div class="card-header">Variables</div>
            <div class="card-body">
              <v-app>
                <v-container>
                  <v-row align="center" justify="center">
                    <v-col>
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
                            >Proportional Gain(Kc)</label
                          >
                          <input
                            type="number"
                            id="proportionalGain"
                            class="form-control"
                            value="1.000"
                          />
                          <br />
                          <label for="integralTimeTi" class="form-label"
                            >Integral Time (Ti, min)</label
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
                    </v-col>
                  </v-row>
                </v-container>
              </v-app>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-12 col-md-6 col-lg-5 col-xl-4">
          <div class="card">
            <div class="card-header">Graficos</div>
            <div class="card-body m-0">
              <div v-if="datapoints.length > 0">
                <grafico
                  :data="data"
                  :options="options"
                  :key="renderizarComponente"
                />
                <grafico :data="data" :options="options" />
                <a href="#" @click="actualizarGrafica()">Actualizar gráfica</a>
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
                      :customSegmentStops="[0, 50, 100]"
                      :segmentColors="['green', 'gold']"
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
        <div class="col-sm-12 col-12 col-md-6 col-lg-5 col-xl-4">
          <div class="card">
            <div class="card-header">Directo</div>
            <div class="card-body mx-auto">
              <iframe
                src="https://www.youtube.com/embed/mGvYzzQb1_s"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
              ></iframe>
              <h5>Simulación</h5>
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
                            <stop offset="0.1643" style="stop-color: #28a6e3" />
                            <stop offset="0.3574" style="stop-color: #2496e6" />
                            <stop offset="0.5431" style="stop-color: #1e7dea" />
                            <stop offset="0.7168" style="stop-color: #1559f0" />
                            <stop offset="0.874" style="stop-color: #0b2cf7" />
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
                            <stop offset="0.1643" style="stop-color: #28a6e3" />
                            <stop offset="0.3574" style="stop-color: #2496e6" />
                            <stop offset="0.5431" style="stop-color: #1e7dea" />
                            <stop offset="0.7168" style="stop-color: #1559f0" />
                            <stop offset="0.874" style="stop-color: #0b2cf7" />
                            <stop offset="1" style="stop-color: #0000ff" />
                          </linearGradient>
                        </defs>
                        <path
                          fill="url(#waterGradient2)"
                          d="
        M 0,0 v 100 h 200 v -100
        c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
        c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
        c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
        c -10,0 -15,5 -25,5 c -10,0 -15,-5 -25,-5
      "
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
      </div>
    </div>
    <!-- <div class="col-md-1 d-sm-none d-none d-md-block d-lg-block d-lg-block">
      <hr class="vertical-line" />
    </div> -->
  </div>
</template>

<script>
import VueSpeedometer from "vue-speedometer";
import grafico from "./Grafico.vue";
import Interfaz from "../libs/interfaz";

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
        variables: {
          nombre: "variables",
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
    ///Codigo Tanque
    // console.log("holasdgfdgfg");
    // console.log(this.$refs.['iniciar']);
    ///Codigo Tanque
  },
  methods: {
    init() {
      let DATA_COUNT = 6;
      for (let i = 0; i < DATA_COUNT; ++i) {
        this.labels.push(i.toString());
      }

      this.datapoints = [31.5, 31.6, 31.7, 32.0, 31.1, 31.5];

      console.log(this.datapoints);

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

      console.log(JSON.parse(JSON.stringify(this.data)));

      this.modificarTanque();
    },
    actualizarGrafica() {
      this.data.datasets[0].data = [36, 37, 31, 35];
      console.log(this.data.datasets[0].data);

      this.renderizarComponente += 1;
    },
    mostrarCard(e) {
      const card =
        e.target.parentNode.parentNode.parentNode.querySelector(".card-body");

      const ref = card.getAttribute("id");

      if (ref == this.animacionesOcultas.variables.nombre) {
        if (!this.animacionesOcultas.variables.estado) {
          $(card).slideUp("slow");
          $(card).hide(1000);

          this.animacionesOcultas.variables.estado = true;
          return;
        }

        $(card).slideDown("slow");
        $(card).show();

        this.animacionesOcultas.variables.estado = false;
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

