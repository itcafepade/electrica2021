<template>
  <div>
    <div class="row">
      <div class="col-6 col-md-4 pr-0 offset-2 offset-md-4">
        <input
          class="form-control"
          type="text"
          placeholder="Carnet"
          v-model="carnet"
        />
      </div>
      <div class="col-4 pl-0">
        <a class="btn btn-success" href="#">Buscar</a>
      </div>
    </div>
    <div class="card mt-4">
      <div class="card-header">Información de práctica</div>
      <practica />
    </div>
  </div>
</template>

<script>
import practica from "./Practica.vue";
export default {
  components: { practica },
  data() {
    return { carnet };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {},
  },
};
</script>
