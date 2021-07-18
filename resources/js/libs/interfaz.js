export default class Interfaz {

    async mostrarObjeto(elemento, mostrar = true) {
        if (!mostrar) {
            elemento.classList.add("slideInUp");
            return true; //El objeto está oculto
        }

        elemento.classList.remove("slideInUp");
        elemento.classList.add("slideInDow");
        return false; //El objeto se está mostrando
    }

    actualizarClase(elemento, claseARemover, claseAAgregar) {
        elemento.classList.remove(claseAremover);
        elemento.classList.add(claseAAgregar);
    }
}
