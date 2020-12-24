<template>
  <section class="page-section" id="contact">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">Register</h2>
      </div>
      <form
        @submit.prevent="register"
        name="sentMessage"
        novalidate="novalidate"
        action="#"
        class="needs-validation"
      >
        <div class="row align-items-stretch mb-5">
          <div class="col-md-6">
            <div class="form-group">
              <input
                v-model="form.name"
                type="text"
                placeholder=" Your Name"
                class="form-control"
                :class="{
                  'is-invalid': validationErrors.hasOwnProperty('name'),
                }"
                name="name"
              />
              <div class="invalid-feedback d-block" v-if="validationErrors.name">{{validationErrors.name[0]}}</div>
            </div>
            <div class="form-group">
              <input
                v-model="form.email"
                type="text"
                placeholder="Your Email"
                class="form-control"
                :class="{
                  'is-invalid': validationErrors.hasOwnProperty('email'),
                }"
                name="email"
              />
              <div class="invalid-feedback d-block" v-if="validationErrors.email">{{validationErrors.email[0]}}</div>
            </div>
            <div class="form-group mb-md-0">
              <input
                v-model="form.phone"
                type="tel"
                placeholder="Your Phone"
                class="form-control"
                :class="{
                  'is-invalid': validationErrors.hasOwnProperty('phone'),
                }"
                name="phone"
              />
              <div class="invalid-feedback d-block" v-if="validationErrors.phone">{{validationErrors.phone[0]}}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input
                v-model="form.woreda"
                type="number"
                placeholder="Your Woreda"
                class="form-control"
                :class="{
                  'is-invalid': validationErrors.hasOwnProperty('woreda'),
                }"
                name="woreda"
              />
              <div class="invalid-feedback d-block" v-if="validationErrors.woreda">{{validationErrors.woreda[0]}}</div>
            </div>
            <div class="form-group">
              <input
                v-model="form.password"
                type="password"
                placeholder="Your Password"
                class="form-control"
                :class="{
                  'is-invalid': validationErrors.hasOwnProperty('password'),
                }"
                name="password"
              />
              <div class="invalid-feedback d-block" v-if="validationErrors.password">{{validationErrors.password[0]}}</div>
            </div>
            <div class="form-group">
              <input
                v-model="form.password_confirmation"
                type="password"
                placeholder="Confirm password"
                class="form-control"
                :class="{
                  'is-invalid': validationErrors.hasOwnProperty('password'),
                }"
                name="password_confirmation"
              />
            </div>
          </div>
        </div>
        <div class="text-center">
          <div id="success"></div>
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
  </section>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        name: "",
        email: "",
        phone: "",
        woreda: "",
        password: "",
        password_confirmation: "",
      }),
      validationErrors: {}
    };
  },

  methods: {
    register() {
      var currentObj = this;
      let data = {}
      data.name = this.form.name;
      data.email = this.form.email;
      data.phone = this.form.phone;
      data.woreda = this.form.woreda;
      data.password = this.form.password;
      data.password_confirmation = this.form.password_confirmation;
      this.$store
        .dispatch("register", data)
        .then(() => this.$router.push("/api/news_feed"))
        .catch((err) => {
            currentObj.$swal({
                icon: 'error',
                title: 'Oops...',
                text: err.response.data.message
            })
            currentObj.validationErrors = err.response.data.errors
            $('.invalid-feedback').show()
        });
    },
  },
};
</script>
