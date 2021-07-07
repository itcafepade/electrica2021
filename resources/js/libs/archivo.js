export default class Archivo {

    async leerUsuariosDeArchivo(file) {
        let usuarios = [];

        try {
            let texto = await this.readFileAsync(file);
            usuarios = this.descomponerTextoCSV(texto); //Se asigna a la variable local para dibujarlos en la tabla
            return usuarios;
        } catch (err) {
            console.log(err);
        }
    }

    readFileAsync(file) {
        return new Promise((resolve, reject) => {
            let reader = new FileReader();

            reader.onload = () => {
                resolve(reader.result);
            };

            reader.onerror = reject;

            reader.readAsText(file);
        })
    }

    descomponerTextoCSV(texto) {
        const sinTitulo = texto.substring(32); // Se elimina la cabecera del archivo
        let textoConSaltos = sinTitulo.replaceAll("\n", ",");
        let textoConComas;
        let textoSinPrimeraComa = textoConSaltos.replace(",", "");
        if (textoSinPrimeraComa.search(";")) {
            //Si existen punto y coma como separación, se reemplazan por comas
            textoConComas = textoSinPrimeraComa.replaceAll(";", ",");
        } else {
            textoConComas = textoSinPrimeraComa; //Si el csv ya viene con comas
        }

        let campo = "";
        let comaAnterior = 0;
        let arrayUsuarios = [];
        let objetoUsuario = {};
        let contadorCampos = 1;
        let primerCampo = true;

        // console.log(textoConComas);
        for (let i = 0; i < textoConComas.length; i++) {
            //Cuando se encuentre una coma significa que el campo termina ahí,
            // entonces se debe cortar esa porción de texto
            // console.log('Campo: ' + i);
            if (textoConComas[i] == ",") {
                //Si es la primer campo, no hay que borrar la coma, porque no hay
                //Por esto se valida con una bandera para saber si es el primer campo de lo contrario
                //Para al else
                if (primerCampo) {
                    campo = textoConComas.substring(0, i);
                    primerCampo = false;
                } else {
                    //Se corta el string desde el anterior+1, porque anterior representa el valor de las comas
                    campo = textoConComas.substring(comaAnterior + 1, i);
                }

                //Dependiendo del valor de contadorCampos se asignará al objeto dependiendo de lo que represente
                //Si es un carnet, al campo carnet, etc.
                if (contadorCampos == 1) {
                    //Primer valor del objeto, Carnet
                    objetoUsuario.carnet = campo;
                } else if (contadorCampos == 2) {
                    //Segundo valor del objeto, Nombres
                    objetoUsuario.nombres = campo;
                    // console.log("Contador: " + contadorCampos);
                } else if (contadorCampos == 3) {
                    //Tercer valor del objeto, Apellidos
                    objetoUsuario.apellidos = campo;
                } else if (contadorCampos == 4) {
                    //Cuarto valor del objeto, Carrera
                    objetoUsuario.carrera = campo;
                    arrayUsuarios.push(objetoUsuario); // Se agregan a un array para luego convertirlo en un objeto
                    objetoUsuario = {};
                    contadorCampos = 0;
                }

                //Se asigna la coma actual como coma anterior
                comaAnterior = i;
                //Se suma al contador de Campos para validaciones del objeto
                contadorCampos += 1;
            }

        }
        return arrayUsuarios;
    }

}
