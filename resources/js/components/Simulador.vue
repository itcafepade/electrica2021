<template>
  <div class="row">
    <div class="col-md-4 pd-4">
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
          <div class="card">
            <div class="card-header">Variables</div>
            <div class="card-body">
              <v-app>
                <v-container fill-height fluid>
                  <v-row align="center" justify="center">
                    <v-col>
                      <div class="text-center">
                        INICIO
                        <div class="my-2">
                          <v-btn color="success" fab x-large dark>
                            INICIO
                          </v-btn>
                        </div>
                        STOP
                        <div class="my-2">
                          <v-btn color="error" fab x-large dark> PARAR </v-btn>
                        </div>
                        <div class="my-2">PERTURBACION</div>
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
                <v-container fill-height fluid>
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
    <div class="col-md-1 d-sm-none d-none d-md-block d-lg-block d-lg-block">
      <hr class="vertical-line" />
    </div>
    <div class="col-md-7 pd-7">
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
          <div class="card">
            <div class="card-header">Graficos</div>
            <div class="card-body">
              <canvas id="grafico1"></canvas>
              <canvas id="grafico2"></canvas>
              <br />
              <h5>Temperatura Agua</h5>
              <!-- <div class="container">
                <div class="gauge">
                  <ul class="meter">
                    <li class="low"></li>
                    <li class="normal"></li>
                    <li class="high"></li>
                  </ul>
                  <div class="dial">
                    <div class="inner">
                      <div class="arrow"></div>
                    </div>
                  </div>
                  <div class="value">0%</div>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-header">Graficos</div>
            <div class="card-body">
              <iframe
                src="https://www.youtube.com/embed/mGvYzzQb1_s"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Chart, registerables } from "chart.js";
//import informacion from "./Informacion.vue";

const DATA_COUNT = 6;
const labels = [];
for (let i = 0; i < DATA_COUNT; ++i) {
  labels.push(i.toString());
}
const datapoints = [31.5, 31.6, 31.7, 32.0, 31.1, 31.5];
const data = {
  labels: labels,
  datasets: [
    {
      label: "Process Variable",
      data: [31.1, 31.2, 31.3, 31.4, 31.5, 31.6],
      borderColor: "#FF6384",
      fill: false,
      cubicInterpolationMode: "monotone",
      tension: 0.4,
    },
    {
      label: "Setpoint",
      data: datapoints,
      borderColor: "#36A2EB",
      fill: false,
      tension: 0.4,
    },
  ],
};
const data2 = {
  labels: labels,
  datasets: [
    {
      label: "Process Variable",
      data: [31.1, 31.2, 31.3, 31.4, 31.5, 31.6],
      borderColor: "#FF6384",
      fill: false,
      cubicInterpolationMode: "monotone",
      tension: 0.4,
    },
  ],
};

Chart.register(...registerables);

export default {
  //components: { informacion },
  mounted() {
    const grafico1 = document.getElementById("grafico1");
    const grafico2 = document.getElementById("grafico2");
    new Chart(grafico1, {
      type: "line",
      data: data,
      options: {
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
      },
    });
    new Chart(grafico2, {
      type: "line",
      data: data2,
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: "Step True Interpolation",
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
      },
    });
  },
};

var dial = $(".dial .inner");
var gauge_value = $(".gauge .value");

function rotateDial() {
  var deg = 0;
  var value = Math.round(Math.random() * 100);
  deg = (value * 177.5) / 100;

  gauge_value.html(value + "%");

  dial.css({ transform: "rotate(" + deg + "deg)" });
  dial.css({ "-ms-transform": "rotate(" + deg + "deg)" });
  dial.css({ "-moz-transform": "rotate(" + deg + "deg)" });
  dial.css({ "-o-transform": "rotate(" + deg + "deg)" });
  dial.css({ "-webkit-transform": "rotate(" + deg + "deg)" });
}

setInterval(rotateDial, 2000);
</script>