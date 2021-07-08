<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 divisor-izquierda pb-3">
        <!-- Reservar práctica -->
        <h4 class="pt-3">Registro de práctica</h4>
        <label for="">Carnet</label>
        <input
          type="text"
          class="form-control"
          disabled
          v-model="usuarioActual.carnet"
        />
        <label for="" class="pt-2">Fecha</label>
        <input type="date" class="form-control" v-model="fecha" />
        <label for="" class="pt-2">Hora Inicio</label>
        <input type="time" class="form-control mt-2" v-model="horaInicio" />
        <label for="" class="pt-2">Hora final</label>
        <input type="time" class="form-control mt-2" v-model="horaFinal" />
        <a href="#" class="btn btn-primary mt-3" @click="agregarNuevoEvento()">
          <i class="bi bi-arrow-bar-down"></i> Reservar
        </a>
        <a href="#" class="btn btn-danger mt-3" @click="eliminarReservacion()">
          <i class="bi bi-trash"></i> Eliminar reservación
        </a>
        <!-- Reservar práctica -->
      </div>
      <div class="col-md-1 d-sm-none d-none d-md-block d-lg-block d-lg-block">
        <hr class="vertical-line" />
      </div>

      <!-- Calendario -->
      <div class="col-md-8">
        <v-app>
          <v-sheet height="64">
            <v-toolbar flat>
              <v-btn
                outlined
                class="mr-4"
                color="grey darken-2"
                @click="setToday"
              >
                Hoy
              </v-btn>
              <v-btn fab text small color="grey darken-2" @click="prev">
                <v-icon small> mdi-chevron-left </v-icon>
              </v-btn>
              <v-btn fab text small color="grey darken-2" @click="next">
                <v-icon small> mdi-chevron-right </v-icon>
              </v-btn>
              <v-toolbar-title v-if="$refs.calendar">
                {{ $refs.calendar.title }}
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-menu bottom right>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    outlined
                    color="grey darken-2"
                    v-bind="attrs"
                    v-on="on"
                  >
                    <span>{{ typeToLabel[type] }}</span>
                    <v-icon right> mdi-menu-down </v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item @click="type = 'day'">
                    <v-list-item-title>Día</v-list-item-title>
                  </v-list-item>
                  <v-list-item @click="type = 'week'">
                    <v-list-item-title>Semana</v-list-item-title>
                  </v-list-item>
                  <v-list-item @click="type = 'month'">
                    <v-list-item-title>Mes</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </v-toolbar>
          </v-sheet>
          <v-sheet height="600">
            <v-calendar
              locale="es"
              ref="calendar"
              v-model="focus"
              color="primary"
              :events="events"
              :type="type"
              @click:more="viewDay"
              @click:date="viewDay"
              @click:event="editarEvento"
            ></v-calendar>
          </v-sheet>
        </v-app>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";
import Alerta from "../libs/alerta";
import moment from "moment";

const alerta = new Alerta();

export default {
  data: () => ({
    focus: "",
    type: "month",
    typeToLabel: {
      month: "Mes",
      week: "Semana",
      day: "Día",
    },
    selectedEvent: {},
    // selectedElement: null,
    // selectedOpen: false,
    events: [],
    usuarioActual: {},
    fecha: "",
    horaInicio: "",
    horaFinal: "",
  }),
  mounted() {
    this.$refs.calendar.checkChange();
    this.init();
  },
  methods: {
    async init() {
      const res = await axios.get("/usuarioActual");
      this.usuarioActual = res.data;
      //   this.events.push({
      //     name: `Práctica evaluada - ${this.usuarioActual.carnet}`,
      //     start: "15:00",
      //     end: "16:00",
      //     color: "green",
      //     timed: `15:00`,
      //   });
    },
    viewDay({ date }) {
      this.focus = date;
      this.type = "day";
    },
    setToday() {
      this.focus = "";
    },
    prev() {
      this.$refs.calendar.prev();
    },
    next() {
      this.$refs.calendar.next();
    },
    agregarNuevoEvento() {
      const inicio = new Date(`${this.fecha}T${this.horaInicio}`);
      const final = new Date(`${this.fecha}T${this.horaFinal}`);
      if (this.editando) {
        // Modificando evento existente
      } else {
        //Nuevo Evento
        this.agregando = true;

        if (inicio.getHours() < final.getHours()) {
          this.events.push({
            name: `Práctica evaluada - ${this.usuarioActual.carnet}`,
            start: inicio,
            end: final,
            color: "green",
            timed: `${inicio.getHours()}:00`,
          });
          console.log(this.events);
          alerta.mensaje("Práctica agendada correctamente.", "success");
        } else {
          alerta.mensaje(
            "La hora de inicio no puede ser mayor que la final.",
            "error"
          );
        }

        this.horaInicio = "";
        this.horaFinal = "";
        this.fecha = "";
        this.editando = false;
        this.selectedEvent = {};
      }
    },
    editarEvento({ nativeEvent, event }) {
      this.editando = true;
      this.selectedEvent = event;
      //   console.log(event);
      const inicio = new Date(event.start);
      const final = new Date(event.end);

      this.fecha = moment(inicio.toISOString()).format("YYYY-MM-DD");

      this.horaInicio = moment(inicio.toISOString()).format("HH:mm");
      this.horaFinal = moment(final.toISOString()).format("HH:mm");
    },
    eliminarReservacion() {
      if (this.editando && this.selectedEvent != {}) {
        const index = this.events.findIndex((el) => el == this.selectedEvent);
        this.events.splice(index, 1);
        alerta.mensaje("Eliminado.", "success");
      } else {
        alerta.mensaje("No hay un evento para eliminar.", "info");
      }
      this.editando = false;
      this.selectedEvent = {};
      this.fecha = "";
      this.horaInicio = "";
      this.horaFinal = "";
    },
  },
};
</script>
