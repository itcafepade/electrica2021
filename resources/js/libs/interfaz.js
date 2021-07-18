export default class Interfaz {
    /**
     *  Oculta o muestra el objeto que se envíe por parámetro.
     *
     * @param {DomElement} elemento
     * @param {String} ref
     * @param {Object} objeto
     * @param {DomElement} icono
     * @returns {Boolean}
     */
    mostrarObjeto(elemento, objeto, icono) {
        if (!objeto.estado) {
            $(elemento).slideUp("slow");
            $(elemento).hide(1000);

            this.actualizarClase(icono, "bi-chevron-down", "bi-chevron-up");

            return true;
        }

        $(elemento).slideDown("slow");
        $(elemento).show();
        this.actualizarClase(icono, "bi-chevron-up", "bi-chevron-down");

        return false;
    }

    /**
     * Modifica un elemento del DOM quitando una clase y agregandole otra.
     *
     * @param {DomElement} elemento
     * @param {String} claseARemover
     * @param {String} claseAAgregar
     */
    actualizarClase(elemento, claseARemover, claseAAgregar) {
        elemento.classList.remove(claseARemover);
        elemento.classList.add(claseAAgregar);

    }
}
