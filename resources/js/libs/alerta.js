import Swal from "sweetalert2";

export default class Alerta {

    /**
     * Muestra una alerta al usuario
     * @param {String} titulo
     * @param {String} icono
     */
    mensaje(titulo, icono = 'info', tiempo = 1500) {
        Swal.fire({
            position: "top-end",
            icon: icono,
            title: titulo,
            showConfirmButton: false,
            timer: tiempo,
        });
    }

    /**
     *  Muestra una alerta al usuario para preguntarle acerca de la siguiente acción,
     *  devuelve verdadero si se desea continuar, en caso contrario devuelve falso
     * @param {String} titulo
     * @param {String} texto
     * @param {icono} icono
     */
    async pregunta(titulo, texto, icono) {
        let confirmacion;

        Swal.fire({
            title: titulo,
            text: texto,
            icon: icono,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confimar'
        }).then((result) => {
            if (result.isConfirmed) {
                confirmacion = true;
            } else {
                confirmacion = false;
            }
        })

        return confirmacion;
    }
}
