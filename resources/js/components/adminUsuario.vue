<template>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-4">
          <label for="">Nombre</label>
          <input type="text" v-model="user.name" class="form-control" />
        </div>
        <div class="col-md-4">
          <label for="">Correo</label>
          <input
            type="text"
            v-model="user.email"
            class="form-control mb-3"
            disabled
          />
        </div>
        <div class="col-md-4">
          <label for="">Contraseña</label>
          <input type="password" v-model="user.password" class="form-control" />
        </div>
      </div>
      <a href="#" class="btn btn-primary" @click="updateUser()">Modificar</a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Correo</th>
          <th scope="col">Nombre</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <th scope="row">{{ user.id }}</th>
          <td>{{ user.email }}</td>
          <td>{{ user.name }}</td>
          <td>
            <a href="#" class="btn btn-warning" @click="editUser(user)">
              <i class="bi bi-pencil"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Alerta from "../libs/alerta";

const alerta = new Alerta();

export default {
  data() {
    return {
      users: [],
      user: {
        password: "",
      },
    };
  },

  mounted() {
    this.init();
  },

  methods: {
    async init() {
      const res = await axios.get(`/api/user`).catch((error) => {
        alerta.mensaje("No fue posible recuperar los datos.", "error");
      });

      if (res && res.data.users) {
        this.users = res.data.users;
      }
    },

    editUser(user) {
      this.user = user;
    },

    async updateUser() {
      if (
        this.user.password == "" ||
        !this.user.password ||
        this.user.password.length < 8
      ) {
        alerta.mensaje(
          "Debes asignar una contraseña y debe contener al menos 8 carácteres.",
          "error"
        );
        return;
      }

      if (!this.user.email) {
        alerta.mensaje(
          "Debes seleccionar el usuario para modificarlo.",
          "error"
        );
        return;
      }

      const res = await axios
        .put(`/api/user/${this.user.id}`, this.user)
        .catch((error) => {
          alerta.mensaje("No fue posible recuperar los datos.", "error");
        });

      if (res && res.data.mensaje == "exito") {
        alerta.mensaje("Registro modificado exitosamente.", "success");
      }

      this.user = {
        password: "",
        name: "",
        email: "",
      };
    },
  },
};
</script>

<style>
</style>
