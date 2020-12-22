<template>
  <div class="row justify-content-center">

        <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
    <div class="col-md-12">
     <form @submit.prevent="agregar">
      <h3 style="font-weight:bold;">Agregar usuarios</h3>
      <input type="text" class="form-control mb-2"
        placeholder="Nombre del usuario" v-model="contact.name">
      <input type="text" class="form-control mb-2"
        placeholder="Correo del usuario" v-model="contact.email">
      <button class="btn btn-primary" @click="saveOrUpdate()" type="submit">Agregar</button>
    </form>
      <h1 style="font-weight:bold;">Lista de usuarios</h1>
      <div class="d-flex justify-content-center" v-if="loading">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <table class="table table-striped table-bordered" v-else>
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th colspan="2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contact in contacts" :key="contact.id">
            <td>{{ contact.name }}</td>
            <td>{{ contact.email }}</td>
            <td>
              <button
                type="button"
                class="btn btn-primary"
                @click="showModal(contact.id)"
                data-toggle="modal"
                data-target="#contactModal"
              >
                Editar
              </button>
              <button
                type="button"
                class="btn btn-danger"
                @click="destroy(contact.id)"
              >
                Borrar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>


<script>
import axios from "axios";

export default {
  data() {
    return {
      loading: true,
    validationErrors: '',

      modal: {
        title: "",
        ok: "",
      },

      contact: {
        id: null,
        name: "",
        email: "",
      },

    };
  },

  mounted() {
    this.getLists();
  },


  methods: {
    getById(id) {
      axios.get(`http://127.0.0.1:8000/contacts/${id}`).then((response) => {
        this.contact = response.data;
        this.modal = {
          title: `Update contact - ${this.contact.name}`,
          ok: "Update",
        };
      });
    },

    getLists() {
      axios
        .get("http://127.0.0.1:8000/contacts")
        .then((response) => (this.contacts = response.data))
        .then(() => (this.loading = false));
    },

    showModal(id) {
      this.contact = { id: null, name: "", email: "" };
      if (id) {
        this.getById(id);
      } else {
        this.modal = { title: "Nuevo contacto", ok: "guardar" };
      }
    },

    destroy(id) {
      if (confirm(`Do you really want to delete ?`)) {
        this.loading = true;
        axios
          .delete(`http://127.0.0.1:8000/contacts/${id}`)
          .then((response) => {
            if (response.data) {
              this.getLists();
            }
          });
      }
    },

    saveOrUpdate() {
      this.loading = true;
      if (!this.contact.id) {
        axios
          .post("http://127.0.0.1:8000/contacts", this.contact)
          .then((response) => {
            if (response.data) {
              this.getLists();
            }
          }).catch(error => {
     if (error.response.status == 422){
       this.validationErrors = error.response.data.errors;
      }});
      } else {
        axios
          .put(
            `http://127.0.0.1:8000/contacts/${this.contact.id}`,
            this.contact
          )
          .then((response) => {
            if (response.data) {
              this.getLists();
            }
          });
      }
    },
  },
};
</script>
