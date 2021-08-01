<template>
  <div>
    <div v-for="practica in practicas" :key="practica.id">
      <div class="card mt-2">
        <div class="card-header">Información de práctica</div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-12 col-md-4">
              <h5 class="pt-2">Estudiante</h5>
              <hr />
              <div v-if="usuario">
                <p class="mb-1">
                  <strong>Carnet: </strong> {{ usuario.carnet }}
                </p>
                <p class="mb-1"><strong>Nombre: </strong> {{ usuario.name }}</p>
                <p class="mb-1">
                  <strong>Hora Práctica: </strong>
                  {{ asignarHora(practica.fecha_inicio) }}
                </p>
                <p class="mb-1">
                  <strong>Carrera: </strong> {{ usuario.carrera }}
                </p>
                <p class="mb-1">
                  <strong>Estado: </strong
                  ><i class="bi bi-circle-fill autorizar"></i>
                  {{ practica.estado }}
                </p>
              </div>
            </div>
            <div class="col-12 col-sm-12 col-md-8">
              <h5 class="pt-2">Actividad</h5>
              <hr />
              <div class="table-responsive-lg">
                <table class="table table-striped table-hover">
                  <thead>
                    <!-- <th>#</th> -->
                    <th>Hora</th>
                    <th>Acción</th>
                  </thead>
                  <tbody v-if="practica.eventos">
                    <tr v-for="evento in practica.eventos" :key="evento.id">
                      <!-- <td>{{ historial.id }}</td> -->
                      <td>
                        {{ fechaAccionConFormato(evento.fecha) }}
                      </td>
                      <td>
                        {{ evento.accion }}
                      </td>
                    </tr>
                    <td
                      colspan="3"
                      class="text-center"
                      v-if="practica.eventos.length == 0"
                    >
                      No se encontraron registros de esta práctica.
                    </td>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";

moment.locale("es");

export default {
  data() {
    return {
      contador: 1,
    };
  },
  props: {
    practicas: [],
    horaInicio: "",
    usuario: {},
  },
  mounted() {},
  methods: {
    asignarHora(fecha) {
      this.contador = 1;
      return moment(new Date(fecha)).format("LLLL");
    },
    fechaAccionConFormato(fecha) {
      return moment(new Date(fecha)).format("hh:mm:ss A");
    },
  },
};
</script>
