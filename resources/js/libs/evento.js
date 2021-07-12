import moment from "moment";

export default class Evento {

    /**
     * Valida el nuevo evento que se está registrando, verificando la disponibilidad
     * en fechas y horas.
     *
     * @param {*} eventos
     * @param {*} inicio
     * @param {*} final
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
     * @param {*} eventos
     * @param {*} fechaInicio
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
     * @param {*} eventos
     * @param {*} fechaInicio
     * @param {*} fechaFinal
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
}
