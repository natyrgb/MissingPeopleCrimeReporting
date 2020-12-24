<template>
  <section class="page-section" id="contact">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">Login</h2>
      </div>
      <div class="row h-100 justify-content-center align-items-center">
        <div class="col-10 col-md-8 col-lg-6">
          <form
            @submit.prevent="login"
            name="sentMessage"
            novalidate="novalidate"
            action="#"
          >
            <div class="form-group">
              <input
                v-model="form.email"
                type="text"
                placeholder="Your Email"
                class="form-control"
                :class="{
                  'is-invalid': form.errors.has('email'),
                }"
                name="email"
              />
              <has-error :form="form" field="email"></has-error>
              <p class="help-block text-danger"></p>
            </div>

            <div class="form-group">
              <input
                v-model="form.password"
                type="password"
                placeholder="Your Password"
                class="form-control"
                :class="{
                  'is-invalid': form.errors.has('password'),
                }"
                name="password"
              />
              <has-error :form="form" field="password"></has-error>
              <p class="help-block text-danger"></p>
            </div>
            <br />

            <div class="text-center">
              <button
                class="btn btn-primary btn-xl text-uppercase"
                id="submitbutton"
                type="submit"
              >
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        email: "",
        password: "",
      }),
    };
  },

  methods: {
    login() {
      var currentObj = this;
      let email = this.form.email;
      let password = this.form.password;
      this.$store
        .dispatch("login", { email, password })
        .then(() => this.$router.push("/api/news_feed"))
        .catch((err) => {
            currentObj.$swal({
                icon: 'error',
                title: 'Oops...',
                text: err.response.data.message
            })
            currentObj.form.errors = err.response.data.errors
        });
    },
  },
};
</script>
