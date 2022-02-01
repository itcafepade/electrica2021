import moment from "moment";
import Alerta from "../libs/alerta";

const alerta = new Alerta();

export default class Evento {
    /**
     * Valida el nuevo evento que se está registrando, verificando la disponibilidad
     * en fechas y horas.
     *
     * @param {Array} eventos
     * @param {String} inicio
     * @param {String} final
     */
    validarEvento(eventos, inicio, final) {
        const fechaInicio = new Date(inicio);
        const fechaFinal = new Date(final);

        const eventosFiltrados = this.filtrarEventosPorFecha(
            eventos,
            fechaInicio
        );
        const horaValidado = this.validarPorHora(
            eventosFiltrados,
            fechaInicio,
            fechaFinal
        );
        const diaValidado = this.validarPorFechaActual(fechaInicio);

        let resultadoHora = {};
        let resultadoDia = {};
        if (!diaValidado) {
            resultadoDia = {
                estado: false,
                mensaje: "No es posible registrar prácticas a días anteriores."
            };
        } else {
            resultadoDia.estado = true;
        }

        if (!horaValidado) {
            resultadoHora = {
                estado: false,
                mensaje: "Ya se encuentra una práctica en este horario."
            };
        } else {
            resultadoHora.estado = true;
        }

        return {
            resultadoHora: resultadoHora,
            resultadoDia: resultadoDia
        };
    }

    /**
     * Verifica que la fecha sea igual o mayor que la actual.
     * Devuelve false si es menor y true si es igual o mayor.
     *
     * @param {Date} fechaInicio
     * @returns {Boolean}
     */
    validarPorFechaActual(fechaInicio) {
        const diaActual = parseInt(moment(new Date()).format("DD"));
        const diaEvento = parseInt(
            moment(fechaInicio.toISOString()).format("DD")
        );
        const mesActual = parseInt(moment(new Date()).format("MM"));
        const mesEvento = parseInt(
            moment(fechaInicio.toISOString()).format("MM")
        );

        console.log(mesActual, mesEvento);

        if (mesEvento > mesActual) {
            //Cuando es un mes mayor
            return true;
        } else if (mesEvento == mesActual) {
            //Cuando es el mismo mes
            if (diaEvento < diaActual) {
                return false;
            }
        }

        return true;
    }

    /**
     * Filtra los eventos disponibles por la fecha del nuevo evento.
     *
     * @param {Array} eventos
     * @param Date fechaInicio
     */

    filtrarEventosPorFecha(eventos, fechaInicio) {
        const fechaInicioConFormato = moment(fechaInicio.toISOString()).format(
            "YYYY-MM-DD"
        );

        let eventosFiltrados = [];

        eventos.forEach(el => {
            const fecha = new Date(el.start);
            const fechaAFiltrar = moment(fecha.toISOString()).format(
                "YYYY-MM-DD"
            );

            if (fechaAFiltrar == fechaInicioConFormato) {
                eventosFiltrados.push(el);
            }
        });

        return eventosFiltrados;
    }

    /**
     *
     * Filtra cada uno de los eventos por las horas que han sido asignadas
     * para verificar la disponibilidad del nuevo evento.
     *
     * @param {Array} eventos
     * @param Date fechaInicio
     * @param Date fechaFinal
     *
     */

    validarPorHora(eventos, fechaInicio, fechaFinal) {
        const fechaInicioHora = parseInt(moment(fechaInicio).format("HH"));
        const fechaFinalHora = parseInt(moment(fechaFinal).format("HH"));

        let i = fechaInicioHora;
        let disponible = true;

        eventos.forEach(el => {
            const horaEvento = parseInt(
                moment(new Date(el.start)).format("HH")
            );
            for (i = fechaInicioHora; i < fechaFinalHora; i++) {
                if (horaEvento == i && el.estado != "Rechazada") {
                    disponible = false;
                    return disponible;
                }
            }
        });

        return disponible;
    }

    /**
     * Obtiene el índice de un evento dependiendo de la fecha de inicio y fecha final,
     * caso contrario devuelve -1.
     *
     * @param {Array} eventos
     * @param Date fechaInicio
     * @param Date fechaFinal
     */
    obtenerIndiceEvento(eventos, fechaInicio, fechaFinal) {
        for (let index = 0; index < eventos.length; index++) {
            const inicioEvento = moment(
                new Date(eventos[index].start).toISOString()
            ).format("YYYY-MM-DDTHH:00");
            const finalEvento = moment(
                new Date(eventos[index].end).toISOString()
            ).format("YYYY-MM-DDTHH:00");

            if (inicioEvento == fechaInicio && finalEvento == fechaFinal) {
                return index;
            }
        }

        return -1;
    }

    /**
     * Crea o modifica un evento dependiendo el valor que tenga agregando,
     * además de agregarse al array que luego será mostrado al cliente.
     *
     * @param {Array} eventos
     * @param {Object} usuarioActual
     * @param {Date} inicio
     * @param {Date} final
     * @param {Boolean} agregando
     */
    async agregarNuevoEvento(
        eventos,
        usuarioActual,
        inicio,
        final,
        agregando,
        idSeleccionado = 0
    ) {
        const horaInicio = parseInt(moment(inicio).format("HH"));
        const horaFinal = parseInt(moment(final).format("HH"));

        if (horaInicio > horaFinal) {
            alerta.mensaje(
                "La hora de inicio no puede ser mayor que la final.",
                "error"
            );
            return;
        }

        const eventoValidado = this.validarEvento(eventos, inicio, final);

        if (!eventoValidado.resultadoDia.estado) {
            alerta.mensaje(eventoValidado.resultadoDia.mensaje, "info");
            return;
        }

        if (!eventoValidado.resultadoHora.estado) {
            alerta.mensaje(eventoValidado.resultadoHora.mensaje, "info");
            return;
        }

        let evento = {
            id: idSeleccionado,
            nombre: `Practica evaluada - ${usuarioActual.carnet}`,
            id_usuario: usuarioActual.id,
            fecha_inicio: inicio,
            fecha_final: final
        };

        if (!agregando) {
            const res = await axios.put(
                "api/horario/" + idSeleccionado,
                evento
            );

            if (res.data.mensaje == "exito") {
                alerta.mensaje("Modificación de práctica exitosa.", "success");
            } else {
                alerta.mensaje(
                    "Error: No se pudo modificar la práctica.",
                    "error"
                );
            }
            return;
        }

        let res = await axios.post("/api/horario/verificarPracticasPorDia", {
            carnet: usuarioActual.carnet,
            fecha: moment(new Date(inicio)).format("YYYY-MM-DD")
        });

        if (
            parseInt(res.data.numeroPracticas) >= 1 &&
            usuarioActual.access != "admin"
        ) {
            await setTimeout(() => {
                alerta.mensaje(
                    `Solo es posible reservar una práctica diaria.\n
                    Tu práctica será almacenada pero deberá ser autorizada por un docente.`,
                    "info",
                    2000
                );
            }, 2500);
        }

        res = await axios.post("api/horario", evento);

        if (res.data.mensaje == "exito") {
            alerta.mensaje("Registro de práctica exitosa.", "success");
        } else {
            alerta.mensaje("Error: No se pudo registrar la práctica.", "error");
        }
    }

    /**
     * Mapea el conjunto de eventos para que puedan ser mostrados en el componente.
     *
     * @param {Array} eventos
     * @returns
     */
    cargarEventos(
        eventos,
        eventosAutorizados = true,
        eventosPendientes = true,
        eventosRechazados = false
    ) {
        let arrayEventos = [];
        eventos.forEach(el => {
            if (el.estado == "Autorizada" && eventosAutorizados) {
                arrayEventos = this.agregarEvento(el, arrayEventos);
            }

            if (el.estado == "Pendiente" && eventosPendientes) {
                arrayEventos = this.agregarEvento(el, arrayEventos);
            }

            if (el.estado == "Rechazada" && eventosRechazados) {
                arrayEventos = this.agregarEvento(el, arrayEventos);
            }
        });
        return arrayEventos;
    }

    /**
     *  Inserta en el array el evento especificado.
     *
     * @param {Object} evento
     * @param {Array} array
     * @returns
     */
    agregarEvento(evento, array) {
        array.push({
            id: evento.id,
            name: evento.nombre,
            carnet: evento.carnet,
            start: moment(new Date(evento.fecha_inicio)).format(
                "YYYY-MM-DD HH:mm"
            ),
            end: moment(new Date(evento.fecha_final)).format(
                "YYYY-MM-DD HH:mm"
            ),
            color: evento.color,
            estado: evento.estado,
            timed: true
        });

        return array;
    }

    /**
     *  Consulta la api de Horarios y retorna los eventos encontrados
     * @returns {Array} eventos
     */
    async obtenerEventos() {
        let res = await axios.get("api/horario");

        const eventos = res.data;

        return eventos;
    }

    /**
     *  Realiza la petición para eliminar un horario de la BD
     * @param {Integer} id
     */
    async eliminarEvento(id) {
        try {
            let res = await axios.delete("api/horario/" + id);

            if (res.data.mensaje == "exito") {
                alerta.mensaje("Eliminación de práctica exitosa.", "success");
            } else {
                alerta.mensaje(
                    "Error: No se pudo eliminar la práctica.",
                    "error"
                );
            }
        } catch (error) {
            alerta.mensaje("No es posible eliminar la práctica.", "error");
        }
    }
}
