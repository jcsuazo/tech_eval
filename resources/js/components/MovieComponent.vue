<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Movies Table</h3>
            <div class="card-tools">
              <button
                class="btn btn-success"
                data-toggle="modal"
                data-target="#addNew"
                @click="newModal"
              >
                Add New Movies
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
                  <th>title</th>
                  <th>imdb_number</th>
                  <th>year</th>
                  <th>poster</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="movie in movies.data" :key="movie.id">
                  <td>{{movie.id}}</td>
                  <td>{{movie.title}}</td>
                  <td>{{movie.imdb_number}}</td>
                  <td>{{movie.year}}</td>
                  <td>{{movie.poster}}</td>
                  <td>
                    <a href="#" @click="editModal(movie)">
                      <i class="fas fa-edit text-primary"></i>
                    </a>
                    /
                    <a href="#" @click="deleteMovie(movie.id)">
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
    <!-- title
    imdb_number
    poster-->
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
            <h5 class="modal-title" id="addNewTitle" v-if="editMode">Update movie's Info</h5>
            <h5 class="modal-title" id="addNewTitle" v-if="!editMode">Add New movie</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateMovie() : createMovie()">
            <div class="modal-body">
              <!-- title -->
              <div class="form-group">
                <input
                  v-model="form.title"
                  type="text"
                  name="title"
                  class="form-control"
                  placeholder="Enter movie title"
                  :class="{ 'is-invalid': form.errors.has('title') }"
                />
                <has-error :form="form" field="title"></has-error>
              </div>
              <!-- imdb number -->
              <div class="form-group">
                <input
                  v-model="form.imdb_number"
                  type="text"
                  name="imdb_number"
                  class="form-control"
                  placeholder="Enter Movie imdb number"
                  :class="{ 'is-invalid': form.errors.has('imdb_number') }"
                />
                <has-error :form="form" field="imdb_number"></has-error>
              </div>
              <!-- poster -->
              <div class="form-group">
                <input
                  @change="addPoster"
                  type="file"
                  name="poster"
                  class="form-control"
                  placeholder="Enter User poster image"
                  ref="fileInput"
                  :class="{ 'is-invalid': form.errors.has('poster') }"
                />
                <has-error :form="form" field="poster"></has-error>
              </div>
              <!-- EMAIL -->
              <div class="form-group">
                <input
                  v-model="form.year"
                  type="text"
                  name="year"
                  class="form-control"
                  placeholder="Enter User year"
                  :class="{ 'is-invalid': form.errors.has('year') }"
                />
                <has-error :form="form" field="year"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>

              <button type="submit" class="btn btn-success" v-if="editMode">Update Movie</button>
              <button type="submit" class="btn btn-primary" v-if="!editMode">Add New Movie</button>
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
      movies: {},
      form: new Form({
        id: "",
        title: "",
        imdb_number: "",
        poster: "",
        year: ""
      })
    };
  },
  methods: {
    addPoster(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      reader.onload = file => {
        this.form.poster = reader.result;
      };
      reader.readAsDataURL(file);
    },
    updateMovie() {
      this.form.put("api/movie/" + this.form.id).then(data => {
        this.loadMovies();
        $("#addNew").modal("hide");
        toast.fire({
          type: "success",
          title: "Movie Updated successfully"
        });
      });
    },
    deleteMovie(id) {
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
          this.form.delete("api/movie/" + id).then(data => {
            if (result.value) {
              swal.fire("Deleted!", "Your movie has been deleted.", "success");
            }
            this.loadMovies();
          });
        });
    },
    createMovie() {
      this.form.post("/api/movie").then(({ data }) => {
        $("#addNew").modal("hide");
        toast.fire({
          type: "success",
          title: "Movie Created successfully"
        });
        this.loadMovies();
      });
    },
    editModal(movie) {
      this.editMode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(movie);
    },
    newModal() {
      const input = this.$refs.fileInput;
      input.type = "text";
      input.type = "file";
      this.editMode = false;
      this.form.reset();

      $("#addNew").modal("show");
    },
    loadMovies() {
      axios.get("api/movie").then(({ data }) => {
        console.log(data);
        this.movies = data;
      });
    }
  },
  mounted() {
    console.log("Component mounted.");
  },
  created() {
    this.loadMovies();
  }
};
</script>
