<template>
  <admin-layout>
    <template #header>
      <h1 class="m-0">Technician</h1>
    </template>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Technician</h3>
                <div
                  class="card-tools"
                  v-if="
                    $page.props.auth.hasRole.admin ||
                    $page.props.auth.hasRole.user
                  "
                >
                  <button
                    type="button"
                    class="btn btn-info text-uppercase"
                    style="letter-spacing: 0.1em"
                    @click="openModal"
                  >
                    Create
                  </button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th class="text-capitalize">Name</th>
                      <th class="text-capitalize">E-mail</th>
                      <th class="text-capitalize">Username</th>
                      <th class="text-capitalize">Phone</th>
                      <th class="text-capitalize">Address</th>
                      <th class="text-capitalize">Specialist</th>
                      <th class="text-capitalize">Certification</th>
                      <th
                        class="text-capitalize text-right"
                        v-if="$page.props.auth.hasRole.admin"
                      >
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in users.data" :key="index">
                      <td class="text-capitalize">{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.username }}</td>
                      <td>{{ user.phone }}</td>
                      <td>{{ user.address }}</td>
                      <td>{{ user.spesialis }}</td>
                      <td>{{ user.certification }}</td>
                      <td
                        class="text-right"
                        v-if="
                          $page.props.auth.hasRole.admin ||
                          $page.props.auth.hasRole.user
                        "
                      >
                        <button
                          class="btn btn-success text-uppercase"
                          style="letter-spacing: 0.1em"
                          @click="editModal(user)"
                        >
                          Edit
                        </button>
                        <button
                          class="btn btn-danger text-uppercase ml-1"
                          style="letter-spacing: 0.1em"
                          @click="deleteUser(user)"
                        >
                          Delete
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
                <pagination :links="users.links"></pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{ formTitle }}</h4>
            <button
              type="button"
              class="close"
              @click="closeModal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body overflow-hidden">
            <div class="d-flex flex-column h4">
              <span
                >Preview: <span class="text-capitalize">{{ form.name }}</span>
              </span>
              <span class="mt-2"
                >Preview E-mail:
                <span class="text-capitalize">{{ form.email }}</span>
              </span>
            </div>
            <div class="card card-primary">
              <form @submit.prevent="checkMode">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name" class="h4">Name</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Name"
                      v-model="form.name"
                      :class="{ 'is-invalid': form.errors.name }"
                      autofocus="autofocus"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.name }"
                  >
                    {{ form.errors.name }}
                  </div>

                  <div class="form-group">
                    <label for="email" class="h4">E-mail</label>
                    <input
                      type="email"
                      class="form-control"
                      placeholder="E-mail Address"
                      v-model="form.email"
                      :class="{ 'is-invalid': form.errors.email }"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.email }"
                  >
                    {{ form.errors.email }}
                  </div>
                  <div class="form-group">
                    <label for="phone" class="h4">Phone</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Phone"
                      v-model="form.phone"
                      :class="{ 'is-invalid': form.errors.phone }"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.phone }"
                  >
                    {{ form.errors.phone }}
                  </div>

                  <div class="form-group">
                    <label for="address" class="h4">Address</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Address"
                      v-model="form.address"
                      :class="{ 'is-invalid': form.errors.address }"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.address }"
                  >
                    {{ form.errors.address }}
                  </div>
                  <div class="form-group">
                    <label for="username" class="h4">Username</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Username"
                      v-model="form.username"
                      :class="{ 'is-invalid': form.errors.username }"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.username }"
                  >
                    {{ form.errors.username }}
                  </div>
                  <div class="form-group">
                    <label for="specialization" class="h4"
                      >Specialization</label
                    >
                    <select v-model="form.specialist" class="form-control">
                      <option disabled value="">
                        Please select specialization
                      </option>
                      <option value="1">Mesin</option>
                      <option value="2">Software</option>
                      <option value="3">Elektronik</option>
                      <option value="4">Repair</option>
                      <option value="5">Furniture</option>
                    </select>
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.specialist }"
                  >
                    {{ form.errors.specialist }}
                  </div>
                  <div class="form-group">
                    <label for="description" class="h4">Description</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Technician description"
                      v-model="form.description"
                      :class="{ 'is-invalid': form.errors.description }"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.description }"
                  >
                    {{ form.errors.description }}
                  </div>
                  <div class="form-group">
                    <label for="certification" class="h4">Certification</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Certification"
                      v-model="form.certification"
                      :class="{ 'is-invalid': form.errors.certification }"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.certification }"
                  >
                    {{ form.errors.certification }}
                  </div>
                </div>

                <div class="modal-footer justify-content-between">
                  <button
                    type="button"
                    class="btn btn-danger text-uppercase"
                    style="letter-spacing: 0.1em"
                    @click="closeModal"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    class="btn btn-info text-uppercase"
                    style="letter-spacing: 0.1em"
                    :disabled="
                      !form.name ||
                      !form.phone ||
                      !form.email ||
                      !form.username ||
                      !form.specialist ||
                      !form.address ||
                      !form.description ||
                      !form.certification ||
                      form.processing
                    "
                  >
                    {{ buttonTxt }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <td><a href = 'delete/{{ $user->user_id }}'>Delete</a></td> -->
  </admin-layout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout";
import Pagination from "@/Components/Pagination";
export default {
  props: ["roles", "users"],
  components: {
    AdminLayout,
    Pagination,
  },
  data() {
    return {
      editedIndex: -1,
      editMode: false,
      form: this.$inertia.form({
        id: "",
        specialist: "",
        name: "",
        email: "",
        phone: "",
        username: "",
        address: "",
        description: "",
        certification: "",
      }),
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Create New Technician"
        : "Edit Current Technician";
    },
    buttonTxt() {
      return this.editedIndex === -1 ? "Create" : "Edit";
    },
    checkMode() {
      return this.editMode === false ? this.createUser : this.editUser;
    },
  },
  methods: {
    editModal(user) {
      this.editMode = true;
      $("#modal-lg").modal("show");
      this.editedIndex = this.users.data.indexOf(user);
      this.form.name = user.name;
      this.form.email = user.email;
      this.form.phone = user.phone;
      this.form.address = user.address;
      this.form.username = user.username;
      this.form.specialist = user.spesialis;
      this.form.description = user.desc;
      this.form.certification = user.certification;
      this.form.id = user.user_id;
    },
    openModal() {
      this.editedIndex = -1;
      $("#modal-lg").modal("show");
    },
    closeModal() {
      this.form.clearErrors();
      this.editMode = false;
      this.form.reset();
      $("#modal-lg").modal("hide");
    },
    createUser() {
      this.form.post(this.route("admin.technician.store"), {
        preserveScroll: true,
        onSuccess: () => {
          this.closeModal();
          Toast.fire({
            icon: "success",
            title: "New Technician created!",
          });
        },
      });
    },
    editUser() {
      this.form.patch(this.route("admin.technician.update", this.form), {
        preserveScroll: true,
        onSuccess: () => {
          Toast.fire({
            icon: "success",
            title: "Technician has been updated!",
          });
          this.closeModal();
        },
      });
    },
    deleteUser(user) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form.delete(
            this.route("admin.technician.destroy", user.user_id),
            {
              preserveScroll: true,
              onSuccess: () => {
                Swal.fire(
                  "Deleted!",
                  "Technician has been deleted.",
                  "success"
                );
              },
            }
          );
        }
      });
    },
  },
};
</script>

