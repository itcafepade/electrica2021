import Swal from "sweetalert2";

export default class Alerta {
    mensaje(titulo, icono) {
        Swal.fire({
            position: "top-end",
            icon: icono,
            title: titulo,
            showConfirmButton: false,
            timer: 1500,
        });
    }
}
