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
    async agregarNuevoEvento(eventos, usuarioActual, inicio, final, agregando, idSeleccionado = 0) {
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

                const evento = {
                    id: idSeleccionado,
                    nombre: `Practica evaluada - ${usuarioActual.carnet}`,
                    id_usuario: usuarioActual.id,
                    fecha_inicio: inicio,
                    fecha_final: final,
                };

                if (agregando) { //Creando nueva práctica

                    const res = await axios.post("api/horario", evento);

                    if (res.data.mensaje == 'exito') {
                        alerta.mensaje('Registro de práctica exitosa.', 'success');
                    } else {
                        alerta.mensaje('Error: No se pudo registrar la práctica.', 'error');
                    }
                } else { //Modificando una práctica

                    const res = await axios.put("api/horario/" +
                        idSeleccionado, evento);

                    if (res.data.mensaje == 'exito') {
                        alerta.mensaje('Modificación de práctica exitosa.', 'success');
                    } else {
                        alerta.mensaje('Error: No se pudo modificar la práctica.', 'error');
                    }
                }

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

    /**
     *  Consulta la api de Horarios y retorna los datos
     * @returns {Array} eventos
     */
    async obtenerEventos() {
        let res = await axios.get('api/horario');

        const eventos = res.data.eventos;

        return eventos;
    }

    /**
     *  Realiza la petición para eliminar un horario de la BD
     * @param {Integer} id
     */
    async eliminarEvento(id) {
        let res = await axios.delete('api/horario/' + id);

        if (res.data.mensaje == 'exito') {
            alerta.mensaje('Eliminación de práctica exitosa.', 'success');
        } else {
            alerta.mensaje('Error: No se pudo eliminar la práctica.', 'error');
        }
    }
}
