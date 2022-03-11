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

      <div class="container mt-3 mb-3 pb-3">
        <div class="row">
          <a href="#" class="btn btn-primary" @click="updateUser()"
            >Modificar</a
          >
        </div>
      </div>

      <hr />
      <div class="row">
        <!-- Roles -->
        <div class="col-md-4">
          <label for="">Roles disponibles</label>
          <select
            v-model="roleSeleccionado"
            class="form-control"
            @change="changeRole"
          >
            <option :value="role.text" v-for="role in roles" :key="role.text">
              {{ role.text }}
            </option>
          </select>
        </div>
        <!-- Roles -->
        <!-- Buscar -->
        <div class="col-md-4">
          <label for="">Buscar</label>
          <input
            type="text"
            v-model="search"
            class="form-control mb-3"
            @keyup="searchUser()"
          />
        </div>
        <!-- Buscar -->
      </div>
    </div>
    <div class="containerTable w-100">
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
      roleSeleccionado: "Todos",
      roles: [
        { text: "Todos" },
        { text: "Administrador" },
        { text: "Estudiante" },
      ],
      searchTimeOut: "",
      search: "",
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

    async changeRole() {
      const res = await axios
        .post(`/api/user/getByRole`, {
          role: this.roleSeleccionado,
        })
        .catch((error) => {
          alerta.mensaje("No fue posible recuperar los datos.", "error");
        });

      if (res && res.data.mensaje == "exito") {
        this.users = res.data.users;
      }
    },

    async searchUser() {
      window.clearTimeout(this.searchTimeOut);

      this.searchTimeOut = setTimeout(async () => {
        const res = await axios
          .post(`/api/user/search`, {
            search: this.search,
          })
          .catch((error) => {
            alerta.mensaje("No fue posible recuperar los datos.", "error");
          });

        if (res && res.data.mensaje == "exito") {
          this.users = res.data.users;
        }
      }, 750);
    },
  },
};
</script>

<style>
.containerTable {
  height: 400px;
  overflow-y: scroll;
}
</style>
