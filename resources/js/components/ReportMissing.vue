<template>
  <section class="page-section" id="contact">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">Report missing person</h2>
      </div>
      <form
        @submit.prevent="missing_person"
        name="sentMessage"
        novalidate="novalidate"
        action="#"
      >
        <div class="row align-items-stretch mb-5">
          <div class="col-md-6">
            <div class="form-group">
              <input
                v-model="name"
                type="text"
                placeholder=" Missing person's Name"
                class="form-control"
                name="name"
                :class="{
                  'is-invalid': errors.get('name'),
                }"
              />
              <p class="help-block text-danger">{{ errors.get("name") }}</p>
            </div>

            <div class="form-group">
              <input
                v-model="woreda"
                type="number"
                placeholder="Choose Woreda"
                class="form-control"
                name="woreda"
                :class="{
                  'is-invalid': errors.get('woreda'),
                }"
              />
              <p class="help-block text-danger">{{ errors.get("woreda") }}</p>
            </div>
            <div class="form-group">
              <input
                type="file"
                class="form-file-control"
                @change="onFileChange"
                :class="{
                  'is-invalid': errors.get('image'),
                }"
              />
            </div>
            <p class="help-block text-danger">{{ errors.get("image") }}</p>

            <div>
              <input
                v-model="date"
                type="date"
                name="date"
                class="form-control"
                :class="{
                  'is-invalid': errors.get('date'),
                }"
              />
              <p class="help-block text-danger">{{ errors.get("date") }}</p>
            </div>
          </div>
          <br />
          <div class="col-md-6">
            <div class="form-group form-group-textarea mb-md-0">
              <textarea
                v-model="description"
                class="form-control"
                name="description"
                placeholder="Description.."
                :class="{
                  'is-invalid': errors.get('description'),
                }"
              >
                            ></textarea
              >
              <p class="help-block text-danger">
                {{ errors.get("description") }}
              </p>
            </div>
          </div>
        </div>
        <div class="text-center">
          <div id="success"></div>
          <button
            class="btn btn-primary btn-xl text-uppercase"
            id="sendMessageButton"
            type="submit"
          >
            Submit
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
class Errors {
  constructor() {
    this.errors = {};
  }

  get(field) {
    if (this.errors[field]) {
      return this.errors[field][0];
    }
  }
  record(errors) {
    this.errors = errors.errors;
  }
}
export default {
  data() {
    return {
      name: "",
      woreda: "",
      image: null,
      date: "",
      description: "",
      errors: new Errors(),
    };
  },

  methods: {
    onFileChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    missing_person(e) {
      e.preventDefault();
      var currentObj = this;

      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("woreda", this.woreda);
      formData.append("image", this.image);
      formData.append("date", this.date);
      formData.append("description", this.description);
      axios
        .post("/api/missings_api", formData)
        .then(function (response) {
          currentObj.success = response.data.success;
          currentObj
            .$swal({
              icon: "success",
              title: "Success",
              text: "You have successfully reported your complaint.",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Show My Missing Reports.",
            })
            .then((result) => {
              if (result.isConfirmed)
                currentObj.$router.push("/api/my_missing_people");
              else {
                // implement some logic
              }
            });
        })
        .catch((error) => {
          this.errors.record(error.response.data);
        });
    },
  },
};
</script>
