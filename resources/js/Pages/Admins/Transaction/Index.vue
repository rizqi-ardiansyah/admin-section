<template>
  <admin-layout>
    <template #header>
      <h1 class="m-0">Transaction</h1>
    </template>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Transaction</h3>
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
                      <th class="text-capitalize">Customer</th>
                      <th class="text-capitalize">Technician</th>
                      <th class="text-capitalize">Damage rate</th>
                      <th class="text-capitalize">Description</th>
                      <th class="text-capitalize">Price</th>
                      <th class="text-capitalize">Status</th>
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
                      <td class="text-capitalize">{{ user.user_name }}</td>
                      <td>{{ user.tech_name }}</td>
                      <td>{{ user.level }}</td>
                      <td>{{ user.desc }}</td>
                      <td>{{ user.price }}</td>
                      <td>{{ user.status }}</td>
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
            <div class="card card-primary">
              <form @submit.prevent="checkMode">
                <div class="card-body">
                  <div class="form-group">
                    <label for="customer" class="h4">Customer</label>
                    <select class="form-control" v-model="form.customer">
                      <option selected disabled value="">
                        Please select customer
                      </option>
                      <option
                        v-for="(user, index) in cust_name.data"
                        :key="index"
                        v-bind:value="user.cust_id"
                      >
                        {{ user.name }}
                      </option>
                    </select>
                  </div>

                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.customer }"
                  >
                    {{ form.errors.customer }}
                  </div>

                  <div class="form-group">
                    <label for="technician" class="h4">Technician</label>
                    <select class="form-control" v-model="form.technician">
                      <option selected disabled value="">
                        Please select technician
                      </option>
                      <option
                        v-for="(user, index) in technician_name.data"
                        :key="index"
                        v-bind:value="user.technician_id"
                      >
                        {{ user.name }} = {{ user.spesialis }}
                      </option>
                    </select>
                  </div>

                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.technician }"
                  >
                    {{ form.errors.technician }}
                  </div>

                  <div class="form-group">
                    <label for="desc" class="h4">Description</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Item damage description"
                      v-model="form.desc"
                      :class="{ 'is-invalid': form.errors.desc }"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.desc }"
                  >
                    {{ form.errors.desc }}
                  </div>
                  <div class="form-group">
                    <label for="status" class="h4">Status</label>
                    <select v-model="form.status" class="form-control">
                      <option selected disabled value="">
                        Please select status
                      </option>
                      <option value="Pickup">Pickup</option>
                      <option value="Order">Order</option>
                      <option value="On Service">On Service</option>
                      <option value="Complete">Complete</option>
                    </select>
                  </div>
                </div>
                <div
                  class="invalid-feedback mb-3"
                  :class="{ 'd-block': form.errors.status }"
                >
                  {{ form.errors.status }}
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
                      !form.customer ||
                      !form.technician ||
                      !form.desc ||
                      !form.status ||
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
  </admin-layout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout";
import Pagination from "@/Components/Pagination";
export default {
  props: ["roles", "users", "cust_name", "technician_name"],
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
        customer: "",
        technician: "",
        desc: "",
        status: "",
      }),
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Create New Transaction"
        : "Edit Current Transaction";
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
      this.form.customer = user.user_name;
      this.form.technician = user.tech_name;
      this.form.desc = user.desc;
      this.form.status = user.status;
      this.form.id = user.trans_id;
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
      this.form.post(this.route("admin.transaction.store"), {
        preserveScroll: true,
        onSuccess: () => {
          this.closeModal();
          Toast.fire({
            icon: "success",
            title: "New Transaction created!",
          });
        },
      });
    },
    editUser() {
      this.form.patch(this.route("admin.transaction.update", this.form), {
        preserveScroll: true,
        onSuccess: () => {
          Toast.fire({
            icon: "success",
            title: "Transaction has been updated!",
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
            this.route("admin.transaction.destroy", user.trans_id),
            {
              preserveScroll: true,
              onSuccess: () => {
                Swal.fire(
                  "Deleted!",
                  "Transaction has been deleted.",
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

