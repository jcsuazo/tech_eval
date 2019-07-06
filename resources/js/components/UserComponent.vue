<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-6">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img
                class="profile-user-img img-fluid img-circle"
                src="/img/user/project.png"
                alt="User profile picture"
              />
            </div>

            <h3 class="profile-username text-center">{{user.name}}</h3>

            <p class="text-muted text-center">{{user.email}}</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Apellido</b>
                <a class="float-right">{{user.last_name}}</a>
              </li>
              <li class="list-group-item">
                <b>Tipo de usuario</b>
                <a class="float-right">{{user.role}}</a>
              </li>
              <li class="list-group-item">
                <b>Edad</b>
                <a class="float-right">{{user.age}}</a>
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block">
              <b>Follow</b>
            </a>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <div class="col-6">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">id</th>
                  <th>title</th>
                  <th>imdb number</th>
                  <th style="width: 40px">year</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="movie in movies" :key="movie.id">
                  <td>{{movie.id}}</td>
                  <td>{{movie.title}}</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-danger">55%</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <li class="page-item">
                <a class="page-link" href="#">«</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">3</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">»</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["userid"],
  data() {
    return {
      editMode: false,
      user: {},
      movies: {},
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
  created() {
    axios.get("/api/user/" + this.userid).then(({ data }) => {
      this.user = data.user;
      this.movies = data.favorite_movies;
    });
  }
  //   methods: {
  //     updateUser() {
  //       this.form.put("api/user/" + this.form.id).then(data => {
  //         this.loadUsers();
  //         $("#addNew").modal("hide");
  //         toast.fire({
  //           type: "success",
  //           title: "User Updated successfully"
  //         });
  //       });
  //     },
  //     deleteUser(id) {
  //       swal
  //         .fire({
  //           title: "Are you sure?",
  //           text: "You won't be able to revert this!",
  //           type: "warning",
  //           showCancelButton: true,
  //           confirmButtonColor: "#3085d6",
  //           cancelButtonColor: "#d33",
  //           confirmButtonText: "Yes, delete it!"
  //         })
  //         .then(result => {
  //           this.form.delete("api/user/" + id).then(data => {
  //             if (result.value) {
  //               swal.fire("Deleted!", "Your user has been deleted.", "success");
  //             }
  //             this.loadUsers();
  //           });
  //         });
  //     },
  //     createUser() {
  //       this.form.post("/api/user").then(({ data }) => {
  //         $("#addNew").modal("hide");
  //         toast.fire({
  //           type: "success",
  //           title: "User Created successfully"
  //         });
  //         this.loadUsers();
  //       });
  //     },
  //     editModal(user) {
  //       this.editMode = true;
  //       this.form.reset();
  //       $("#addNew").modal("show");
  //       this.form.fill(user);
  //     },
  //     newModal() {
  //       this.editMode = false;
  //       this.form.reset();
  //       $("#addNew").modal("show");
  //     },
  //     loadUsers() {
  //       axios.get("api/user").then(({ data }) => {
  //         this.users = data;
  //       });
  //     }
  //   },
  //   mounted() {
  //     console.log("Component mounted.");
  //   },
};
</script>
