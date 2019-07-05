<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>
            <div class="card-tools">
              <button
                class="btn btn-success"
                data-toggle="modal"
                data-target="#addNew"
                @click="newModal"
              >
                Add New
                <i class="fas fa-user-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>id</th>
                  <th>nomber</th>
                  <th>apellido</th>
                  <th>Correo</th>
                  <th>tipo de usuario</th>
                  <th>edad</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users.data" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.last_name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.role}}</td>
                  <td>{{user.age}}</td>
                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fas fa-edit text-primary"></i>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fas fa-trash text-danger"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewTitle" v-if="editMode">Update User's Info</h5>
            <h5 class="modal-title" id="addNewTitle" v-if="!editMode">Add New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateUser() : createUser()">
            <div class="modal-body">
              <!-- NAME -->
              <div class="form-group">
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  class="form-control"
                  placeholder="Enter User Name"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <!-- Last Name -->
              <div class="form-group">
                <input
                  v-model="form.last_name"
                  type="text"
                  name="last_name"
                  class="form-control"
                  placeholder="Enter User Last Name"
                  :class="{ 'is-invalid': form.errors.has('last_name') }"
                />
                <has-error :form="form" field="last_name"></has-error>
              </div>
              <!-- EMAIL -->
              <div class="form-group">
                <input
                  v-model="form.email"
                  type="email"
                  name="email"
                  class="form-control"
                  placeholder="Enter User email"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>
              <!-- Password -->
              <div class="form-group">
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  class="form-control"
                  placeholder="Enter Password"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
              <!-- Role -->
              <div class="form-group">
                <select
                  name="role"
                  v-model="form.role"
                  id="role"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('role') }"
                >
                  <option value>Select User Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">Standard User</option>
                </select>
                <has-error :form="form" field="role"></has-error>
              </div>
              <!-- Age -->
              <div class="form-group">
                <input
                  v-model="form.age"
                  type="number"
                  name="age"
                  class="form-control"
                  placeholder="Enter User Age"
                  :class="{ 'is-invalid': form.errors.has('age') }"
                />
                <has-error :form="form" field="age"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>

              <button type="submit" class="btn btn-success" v-if="editMode">Update User</button>
              <button type="submit" class="btn btn-primary" v-if="!editMode">Add New User</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editMode: false,
      users: {},
      form: new Form({
        id: "",
        name: "",
        last_name: "",
        role: "",
        age: "",
        email: "",
        password: ""
      })
    };
  },
  methods: {
    updateUser() {
      this.form.put("api/user/" + this.form.id).then(data => {
        this.loadUsers();
        $("#addNew").modal("hide");
        toast.fire({
          type: "success",
          title: "User Updated successfully"
        });
      });
    },
    deleteUser(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          this.form.delete("api/user/" + id).then(data => {
            if (result.value) {
              swal.fire("Deleted!", "Your user has been deleted.", "success");
            }
            this.loadUsers();
          });
        });
    },
    createUser() {
      this.form.post("/api/user").then(({ data }) => {
        $("#addNew").modal("hide");
        toast.fire({
          type: "success",
          title: "User Created successfully"
        });
        this.loadUsers();
      });
    },
    editModal(user) {
      this.editMode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    newModal() {
      this.editMode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    loadUsers() {
      axios.get("api/user").then(({ data }) => {
        this.users = data;
      });
    }
  },
  mounted() {
    console.log("Component mounted.");
  },
  created() {
    this.loadUsers();
  }
};
</script>
