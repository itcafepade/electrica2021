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
    validarEvento(eventos, inicio, final, idSeleccionado = 0) {
        const fechaInicio = new Date(inicio);
        const fechaFinal = new Date(final);

        const eventosFiltrados = this.filtrarEventosPorFecha(
            eventos,
            fechaInicio
        );

        const validado = this.validarEventoFechaHoraMinuto(
            eventosFiltrados,
            fechaInicio,
            fechaFinal,
            idSeleccionado
        );

        return validado;
    }

    /**
     * Filtra los eventos disponibles filtrando la fecha del nuevo evento.
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

            if (
                fechaAFiltrar == fechaInicioConFormato &&
                el.estado != "Rechazada"
            ) {
                eventosFiltrados.push(el);
            }
        });

        return eventosFiltrados;
    }

    /**
     *
     * Verifica que los horarios no sean iguales
     *
     * @param {Array} eventos
     * @param Date fechaInicio
     * @param Date fechaFinal
     *
     */
    validarEventoFechaHoraMinuto(
        eventos,
        fechaInicio,
        fechaFinal,
        idSeleccionado = 0
    ) {
        // Formato: 202202041001 -> 2022-02-04T10:01
        let fechaInicioFormato = parseInt(
            moment(fechaInicio).format("YYYYMMDDHHmm")
        );
        let fechaFinalFormato = parseInt(
            moment(fechaFinal).format("YYYYMMDDHHmm")
        );
        const fechaInicioH = parseInt(moment(fechaInicio).format("HH"));
        const fechaInicioM = parseInt(moment(fechaInicio).format("mm"));
        const fechaFinalH = parseInt(moment(fechaFinal).format("HH"));
        const fechaFinalM = parseInt(moment(fechaFinal).format("mm"));

        let validado = true;

        // La fecha final es menor que la de inicio
        if (fechaFinalFormato < fechaInicioFormato) {
            alerta.mensaje(
                "La hora y fecha del inicio de tu práctica no pueden ser mayores que la final.",
                "info"
            );
            validado = false;
            return validado;
        }

        // Sin eventos por validar
        if (eventos.length == 0) {
            // console.log("Sin eventos por evaluar");
            return validado;
        }

        eventos.forEach(evento => {
            const eventoFechaInicio = parseInt(
                moment(evento.start).format("YYYYMMDDHHmm")
            );
            const eventoFechaFinal = parseInt(
                moment(evento.end).format("YYYYMMDDHHmm")
            );
            const eventoInicioH = parseInt(moment(evento.start).format("HH"));
            const eventoInicioM = parseInt(moment(evento.start).format("mm"));
            const eventoFinalH = parseInt(moment(evento.end).format("HH"));
            const eventoFinalM = parseInt(moment(evento.end).format("mm"));

            /**
             * La fecha de inicio se encuentra en el rango de la fecha de inicio
             * y fecha final de un evento
             **/

            if (
                fechaInicioFormato >= eventoFechaInicio &&
                fechaInicioFormato <= eventoFechaFinal &&
                evento.id != idSeleccionado
            ) {
                alerta.mensaje("Verifica la disponibilidad de horario", "info");
                validado = false;
                return validado;
            }

            /**
             * La fecha final se encuentra en el rango de la fecha de inicio
             * y fecha final de un evento
             **/
            if (
                fechaFinalFormato >= eventoFechaInicio &&
                fechaFinalFormato <= eventoFechaFinal &&
                evento.id != idSeleccionado
            ) {
                alerta.mensaje(
                    "Verifica la disponibilidad de horario.",
                    "info"
                );
                validado = false;
                return validado;
            }

            /**
             *
             **/
            if (
                fechaFinalFormato >= eventoFechaInicio &&
                fechaFinalFormato <= eventoFechaFinal &&
                evento.id != idSeleccionado
            ) {
                alerta.mensaje(
                    "Verifica la disponibilidad de horario.",
                    "info"
                );
                validado = false;
                return validado;
            }

            // Si las horas son iguales
            if (eventoInicioH == fechaInicioH && evento.id != idSeleccionado) {
                // console.log("Horas iguales", fechaInicioM, fechaFinalM);
                // Verificando que los minutos de la hora de inicio
                // no estén reservados por otro evento
                if (
                    fechaInicioM >= eventoInicioM ||
                    fechaInicioM <= eventoFinalM
                ) {
                    alerta.mensaje(
                        "Verifica la disponibilidad de horario.",
                        "info"
                    );
                    // console.log("Minutos inicio");
                    validado = false;
                    return validado;
                }

                // Verificando que los minutos de la hora final
                // no estén reservados por otro evento
                if (
                    fechaFinalM <= eventoInicioM ||
                    fechaFinalM >= eventoFinalM
                ) {
                    alerta.mensaje(
                        "Verifica la disponibilidad de horario.",
                        "info"
                    );
                    validado = false;
                    return validado;
                }
            }
        });

        return validado;
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
        selectedEvent
    ) {
        const idSeleccionado = selectedEvent.id;

        const eventoValidado = this.validarEvento(
            eventos,
            inicio,
            final,
            idSeleccionado
        );

        if (!eventoValidado) {
            return;
        }

        let evento = {
            id: idSeleccionado,
            nombre: `${usuarioActual.carnet} - Práctica evaluada`,
            fecha_inicio: inicio,
            fecha_final: final
        };

        if (!agregando) {
            evento.nombre = `${selectedEvent.carnet} - Práctica evaluada`;

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

        // console.log("Nuevo", evento);

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

    // -----------------------------------------------------------------------
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

        if (fechaInicioHora == fechaFinalHora) {
            return false;
        }

        eventos.forEach(el => {
            const horaEvento = parseInt(
                moment(new Date(el.start)).format("HH")
            );
            for (i = fechaInicioHora; i <= fechaFinalHora; i++) {
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
            ).format("YYYY-MM-DDTHH:mm");
            const finalEvento = moment(
                new Date(eventos[index].end).toISOString()
            ).format("YYYY-MM-DDTHH:mm");

            if (inicioEvento == fechaInicio && finalEvento == fechaFinal) {
                return index;
            }
        }

        return -1;
    }
}
