import moment from "moment";
import Alerta from "../libs/alerta"

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

        const eventosFiltrados = this.filtrarEventosPorFecha(eventos, fechaInicio);
        const validado = this.validarPorHora(eventosFiltrados, fechaInicio, fechaFinal);

        return validado;
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
            const fecha = new Date(el.start)
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
        const fechaInicioHora = parseInt(moment(fechaInicio).format("HH"))
        const fechaFinalHora = parseInt(moment(fechaFinal).format("HH"))

        let i = fechaInicioHora;
        let disponible = true;

        eventos.forEach(el => {
            const horaEvento = parseInt(moment(new Date(el.start)).format("HH"));
            for (i; i < fechaFinalHora; i++) {
                if (horaEvento == i) {
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
            const inicioEvento = moment(new Date(eventos[index].start).toISOString()).format("YYYY-MM-DDTHH:00");
            const finalEvento = moment(new Date(eventos[index].end).toISOString()).format("YYYY-MM-DDTHH:00");

            if (inicioEvento == fechaInicio && finalEvento == fechaFinal) {
                return index;
            }
        }

        return -1;
    }


    agregarNuevoEvento(eventos, usuarioActual, inicio, final) {
        const horaInicio = parseInt(moment(inicio).format(
            "HH"
        ));
        const horaFinal = parseInt(moment(final).format(
            "HH"
        ));

        if (horaInicio < horaFinal) {
            const eventoValidado = this.validarEvento(
                eventos,
                inicio,
                final
            );

            if (eventoValidado) {
                eventos.push({
                    name: `Práctica evaluada - ${usuarioActual.carnet}`,
                    carnet: usuarioActual.carnet,
                    start: inicio,
                    end: final,
                    color: "green",
                    timed: true,
                });

                // console.log(JSON.{stringify}(eventos));

                alerta.mensaje("Práctica agendada correctamente.", "success");
            } else {
                alerta.mensaje(
                    "Ya se encuentra una práctica en este horario.",
                    "info"
                );
            }

        } else {
            alerta.mensaje(
                "La hora de inicio no puede ser mayor que la final.",
                "error"
            );
        }
    }

    /**
     * Mapea el conjunto de eventos para que puedan ser mostrados en el componente.
     *
     * @param {Array} eventos
     * @returns
     */
    cargarEventos(eventos) {
        const arrayEventos = [];
        eventos.forEach((el) => {
            arrayEventos.push({
                id: el.id,
                name: el.nombre,
                carnet: el.carnet,
                start: moment(new Date(el.fecha_inicio)).format("YYYY-MM-DD HH:mm"),
                end: moment(new Date(el.fecha_final)).format("YYYY-MM-DD HH:mm"),
                color: "green",
                timed: true,
            });
        });
        return arrayEventos;
    }
}
