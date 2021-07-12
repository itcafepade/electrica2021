<template>
  <canvas ref="grafico"></canvas>
</template>

<script>
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

export default {
  props: {
    data: {},
    options: {},
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      const grafico = this.$refs.grafico;

      new Chart(grafico, {
        type: "line",
        data: this.data,
        options: this.options,
      });
    },
  },
};
</script>
