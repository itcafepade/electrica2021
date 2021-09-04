<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 divisor-izquierda pb-3">
        <!-- Reservar práctica -->
        <h4 class="pt-3">Registro de práctica</h4>

        <!-- Peticiones de prácticas -->
        <div v-if="usuarioActual.access == 'admin'">
          <a
            type="button"
            class="btn btn-info text-white mb-3"
            data-toggle="modal"
            data-target="#modalPeticiones"
          >
            <i class="bi bi-list-task"></i> Peticiones
          </a>
          <br />
        </div>

        <div class="modal fade" tabindex="-1" id="modalPeticiones">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Peticiones de prácticas</h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div v-if="eventosNoAutorizados.length > 0">
                  <div
                    class="card mt-1"
                    v-for="evento in eventosNoAutorizados"
                    :key="evento.id"
                  >
                    <div class="card-body m-0 p-0">
                      <div class="row m-0">
                        <div class="col-md-9 pt-2 m-0">
                          <p class="m-0">
                            <strong>Nombre:</strong> {{ evento.nombre }}
                          </p>
                          <p class="m-0">
                            <strong>Usuario:</strong> {{ evento.name }}
                          </p>
                          <p class="m-0">
                            <strong>Carnet:</strong> {{ evento.carnet }}
                          </p>
                          <p class="m-0">
                            <strong>Hora Final:</strong>
                            {{ formatoFecha(evento.fecha_inicio) }}
                          </p>
                          <p class="m-0">
                            <strong> Hora Final: </strong
                            >{{ formatoFecha(evento.fecha_final) }}
                          </p>
                        </div>
                        <div class="col-md-3">
                          <a
                            href="#"
                            title="Autorizar"
                            class="autorizar"
                            @click="autorizarEvento(evento)"
                            ><i
                              class="botones-peticiones bi bi-check-circle"
                            ></i
                          ></a>
                          <a
                            href="#"
                            title="Rechazar"
                            class="denegar"
                            @click="rechazarEvento(evento)"
                            ><i class="botones-peticiones bi bi-x-circle"></i
                          ></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="eventosNoAutorizados.length == 0">
                  <h6>
                    No se encontraron peticiones de prácticas por aprobar.
                  </h6>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary text-white"
                  data-dismiss="modal"
                >
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Peticiones de prácticas -->

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
        <v-dialog
          class="p-0 m-0"
          ref="dialogInicio"
          v-model="modalInicio"
          :return-value.sync="horaInicio"
          persistent
          width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              class="p-0 m-0"
              v-model="horaInicio"
              label=""
              prepend-icon="mdi-clock-time-four-outline"
              readonly
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-time-picker v-if="modalInicio" v-model="horaInicio" full-width>
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="modalInicio = false">
              Cancelar
            </v-btn>
            <v-btn
              text
              color="primary"
              @click="$refs.dialogInicio.save(horaInicio)"
            >
              Seleccionar
            </v-btn>
          </v-time-picker>
        </v-dialog>
        <!-- <input type="time" class="form-control mt-2" v-model="horaInicio" /> -->
        <label for="" class="pt-2">Hora final</label>
        <v-dialog
          class="p-0 m-0"
          ref="dialogFinal"
          v-model="modalFinal"
          :return-value.sync="horaFinal"
          persistent
          width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              class="p-0 m-0"
              v-model="horaFinal"
              label=""
              prepend-icon="mdi-clock-time-four-outline"
              readonly
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-time-picker v-if="modalFinal" v-model="horaFinal" full-width>
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="modalFinal = false">
              Cancelar
            </v-btn>
            <v-btn
              text
              color="primary"
              @click="$refs.dialogFinal.save(horaFinal)"
            >
              Seleccionar
            </v-btn>
          </v-time-picker>
        </v-dialog>
        <!-- <input type="time" class="form-control mt-2" v-model="horaFinal" /> -->
        <a href="#" class="btn btn-primary mt-3" @click="agregarNuevoEvento()">
          <i class="bi bi-arrow-bar-down"></i> Reservar
        </a>
        <a href="#" class="btn btn-secondary mt-3" @click="limpiarEvento()">
          <i class="bi bi-arrow-bar-down"></i> Limpiar
        </a>
        <a href="#" class="btn btn-danger mt-3" @click="eliminarReservacion()">
          <i class="bi bi-trash"></i> Eliminar
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
          <v-container>
            <v-sheet>
              <v-row>
                <!-- <i class="bi bi-circle-fill autorizar"></i> -->
                <v-checkbox
                  v-model="checkBoxAutorizadas"
                  color="green"
                  :label="`Autorizadas`"
                  @click="filtrarEventosPorEstado()"
                >
                </v-checkbox>
                <v-spacer></v-spacer>

                <v-checkbox
                  v-model="checkBoxPendientes"
                  color="orange"
                  :label="`Pendientes`"
                  @click="filtrarEventosPorEstado()"
                >
                </v-checkbox>
                <v-spacer></v-spacer>
                <v-checkbox
                  v-model="checkBoxRechazadas"
                  color="red"
                  label="Rechazadas"
                  @click="filtrarEventosPorEstado()"
                >
                </v-checkbox>
              </v-row>
            </v-sheet>
          </v-container>
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
import Evento from "../libs/evento";
import moment from "moment";
import Swal from "sweetalert2";

const alerta = new Alerta();
const evento = new Evento();

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
    events: [],
    usuarioActual: {},
    fecha: "",
    horaInicio: "",
    horaFinal: "",
    eventosNoAutorizados: [],
    checkBoxAutorizadas: true,
    checkBoxPendientes: true,
    checkBoxRechazadas: false,
    modalInicio: false,
    modalFinal: false,
  }),
  mounted() {
    this.$refs.calendar.checkChange();
    this.init();
  },
  methods: {
    async init() {
      let res = await axios.get("/usuarioActual");
      this.usuarioActual = res.data;

      const eventos = await evento.obtenerEventos();
      this.events = evento.cargarEventos(
        eventos.eventos,
        this.checkBoxAutorizadas,
        this.checkBoxPendientes,
        this.checkBoxRechazadas
      );

      this.eventosNoAutorizados = eventos.eventosNoAutorizados;
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
    async agregarNuevoEvento() {
      let inicio = new Date(`${this.fecha}T${this.horaInicio}`);
      let final = new Date(`${this.fecha}T${this.horaFinal}`);

      const inicioEnPunto = moment(inicio.toISOString()).format(
        "YYYY-MM-DDTHH:00"
      );
      const finalEnPunto = moment(final.toISOString()).format(
        "YYYY-MM-DDTHH:00"
      );

      console.log(inicioEnPunto);

      if (this.editando) {
        // Modificando evento existente
        const indice = this.events.findIndex((el) => el == this.selectedEvent);

        this.events.splice(indice, 1); //Eliminando el evento del array
      } else {
        //Nuevo Evento
        this.agregando = true;
      }

      evento.agregarNuevoEvento(
        this.events,
        this.usuarioActual,
        inicioEnPunto,
        finalEnPunto,
        this.agregando,
        this.selectedEvent.id
      );

      this.horaInicio = "";
      this.horaFinal = "";
      this.fecha = "";
      this.editando = false;
      this.agregando = false;
      this.selectedEvent = {};
      this.init();
      //   const eventos = await evento.obtenerEventos();
      //   this.events = evento.cargarEventos(
      //     eventos.eventos,
      //     this.checkBoxAutorizadas,
      //     this.checkBoxPendientes,
      //     this.checkBoxRechazadas
      //   );
    },
    editarEvento({ nativeEvent, event }) {
      this.editando = true;
      this.selectedEvent = event;
      //   console.log(event);
      const inicio = new Date(event.start);
      const final = new Date(event.end);

      this.fecha = moment(inicio.toISOString()).format("YYYY-MM-DD");

      this.horaInicio = moment(inicio.toISOString()).format("HH:00");
      this.horaFinal = moment(final.toISOString()).format("HH:00");
    },
    async eliminarReservacion() {
      if (this.editando && this.selectedEvent != {}) {
        if (
          this.usuarioActual.carnet == this.selectedEvent.carnet ||
          this.usuarioActual.access == "admin"
        ) {
          const res = await Swal.fire({
            title: "Eliminar práctica",
            text: "Esta acción es irreversible.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confimar",
          });

          if (res.isConfirmed) {
            const index = this.events.findIndex(
              (el) => el == this.selectedEvent
            );

            // this.events.splice(index, 1);
            evento.eliminarEvento(this.selectedEvent.id);
            // alerta.mensaje("Eliminado.", "success");
            const eventos = await evento.obtenerEventos();
            this.events = evento.cargarEventos(
              eventos.eventos,
              this.checkBoxAutorizadas,
              this.checkBoxPendientes,
              this.checkBoxRechazadas
            );
          }
        } else {
          alerta.mensaje(
            "No es posible eliminar prácticas que no has registrado.",
            "error"
          );
        }
      } else {
        alerta.mensaje("No hay un evento para eliminar.", "info");
      }
      this.editando = false;
      this.selectedEvent = {};
      this.fecha = "";
      this.horaInicio = "";
      this.horaFinal = "";
    },
    formatoFecha(fecha) {
      return moment(new Date(fecha)).format("D MMMM YYYY, h:mm a");
    },
    async autorizarEvento(evento) {
      const res = await axios.post("api/horario/modificarEstado", {
        id: evento.id,
        estado: "Autorizada",
        color: "green",
      });

      if (res.data.mensaje != "exito") {
        alerta.mensaje("El horario no pudo ser autorizado", "error");
        return;
      }

      alerta.mensaje("Horario autorizado.", "success");
      this.init();
    },
    async rechazarEvento(evento) {
      const res = await axios.post("api/horario/modificarEstado", {
        id: evento.id,
        estado: "Rechazada",
        color: "red",
      });

      if (res.data.mensaje != "exito") {
        alerta.mensaje("El horario no pudo ser autorizado", "error");
        return;
      }

      alerta.mensaje("Horario rechazado.", "info");
      this.init();
    },
    async filtrarEventosPorEstado() {
      const eventos = await evento.obtenerEventos();
      this.events = evento.cargarEventos(
        eventos.eventos,
        this.checkBoxAutorizadas,
        this.checkBoxPendientes,
        this.checkBoxRechazadas
      );
    },
    limpiarEvento() {
      this.fecha = "";
      this.horaInicio = "";
      this.horaFinal = "";
    },
  },
};
</script>

<style>
.botones-peticiones {
  font-size: 1.6em;
}

.v-sheet {
  z-index: 0;
}
</style>
