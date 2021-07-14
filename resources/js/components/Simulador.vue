<template>
  <div class="row">
    <div class="col-md-5 pd-5">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">Variables</div>
            <div class="card-body">
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
        <div class="col">
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
      </div>
    </div>
    <!-- <div class="col-md-1 d-sm-none d-none d-md-block d-lg-block d-lg-block">
      <hr class="vertical-line" />
    </div> -->
    <div class="col-md-7 pd-7">
      <div class="row">
        <div class="col">
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
        <div class="col">
          <div class="card">
            <div class="card-header">Graficos</div>
            <div class="card-body mx-auto test">
              <h5 class="text-info">En Vivo</h5>
              <iframe
                src="https://www.youtube.com/embed/mGvYzzQb1_s"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
              ></iframe>
              <h5>Simulación</h5>
              <input type="number" name="" id="txtNumero" />
              <button id="iniciar" class="btn btn-primary">Iniciar</button>
              <button id="parar" class="btn btn-primary">parar</button>
              <div class="row">
                <div class="col">
                  <p>Tanque 1</p>
                  <div id="tanque1" :class="[$style.tanque]"></div>
                </div>
                <div class="col">
                  <p>Tanque 2</p>
                  <div id="tanque2" :class="[$style.tanque]"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueSpeedometer from "vue-speedometer";
import grafico from "./Grafico.vue";
// let btnIniciar = document.getElementById("iniciar");
// let btnParar = document.getElementById("parar");
// let tanque1 = document.getElementById("tanque1");
// let tanque2 = document.getElementById("tanque2");

// btnIniciar.addEventListener("click", function () {
//   tanque1.style.animation = "fill 7s ease-in-out infinite";
// });

// btnParar.addEventListener("click", function () {
//   tanque1.style.animation = "";
// });

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
    },
    actualizarGrafica() {
      this.data.datasets[0].data = [36, 37, 31, 35];
      console.log(this.data.datasets[0].data);

      this.renderizarComponente += 1;
    },
  },
};
</script>

<style module>
.tanque {
  width: 150px;
  height: 150px;
  border: 10px solid #ccc;
  border-radius: 10px;
  line-height: 150px;
  text-align: center;
  color: #ddd;
  font-size: 25px;
  font-weight: 600;
  text-transform: uppercase;
  position: relative;
  overflow: hidden;
  background-color: black;
  margin: auto;
}
@keyframes fill {
  from {
    top: 250px;
    transform: translateX(-50%) rotate(0deg);
  }
  to {
    top: -50px;
    transform: translateX(-50%) rotate(360deg);
  }
}
.tanque:before {
  content: "";
  position: absolute;
  width: 400px;
  height: 400px;
  background: #00acee;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 40%;
  /* animation: fill 7s ease-in-out infinite; */
  z-index: 1;
}
</style>