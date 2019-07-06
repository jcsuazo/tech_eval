<template>
  <div class="mt-5">
    <div class="row">
      <div class="col-12">
        <div class="card card-solid">
          <div class="card-body pb-0">
            <div class="row d-flex align-items-stretch">
              <div
                class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch"
                v-for="movie in movies.data"
                :key="movie.id"
              >
                <div class="card bg-light">
                  <div class="card-header text-muted border-bottom-0">{{movie.title}}</div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-12 text-center">
                        <img :src="'/img/profile/'+movie.poster" alt class="movieImage" />
                      </div>
                      <div class="col-12 mt-2">
                        <p class="text-muted h5">
                          <b>title:</b>
                          {{movie.title}}
                        </p>
                        <p class="text-muted h5">
                          <b>IMDB number:</b>
                          {{movie.imdb_number}}
                        </p>
                        <p class="text-muted h5">
                          <b>Year:</b>
                          {{movie.year}}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      <a href="#" class="btn btn-sm btn-primary" @click="editModal(movie)">
                        <i class="fas fa-user nav-link"></i>
                        <span class="h5">Edit movie</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
              <ul class="pagination justify-content-end m-0">
                <pagination :data="movies" @pagination-change-page="getResults"></pagination>
              </ul>
            </nav>
          </div>
          <!-- /.card-footer -->
        </div>
      </div>
      <!-- MODAL -->
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
              <h5 class="modal-title" id="addNewTitle">Update movie's Info</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="updateMovie()">
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

                <button type="submit" class="btn btn-success">Update Movie</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
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
    getResults(page = 1) {
      axios.get("api/movie?page=" + page).then(response => {
        this.movies = response.data;
      });
    },
    addPoster(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      if (file["size"] < 2111775) {
        reader.onload = file => {
          this.form.poster = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        swal.fire({
          type: "error",
          title: "Oops...",
          text: "The image need to be 2mb or less"
        });
        const input = this.$refs.fileInput;
        input.type = "text";
        input.type = "file";
      }
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
    editModal(movie) {
      const input = this.$refs.fileInput;
      input.type = "text";
      input.type = "file";
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(movie);
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
