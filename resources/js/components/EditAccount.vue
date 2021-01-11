<template>
    <section class="page-section" id="contact">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Edit Account Information</h2>
            </div>
            <form
                @submit.prevent="update"
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
                                class="form-control"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'name'
                                    )
                                }"
                                name="name"
                            />
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.name"
                            >
                                {{ validationErrors.name[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <input
                                v-model="form.email"
                                type="text"
                                placeholder="Your Email"
                                class="form-control"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'email'
                                    )
                                }"
                                name="email"
                            />
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.email"
                            >
                                {{ validationErrors.email[0] }}
                            </div>
                        </div>
                        <div class="form-group mb-md-0">
                            <input
                                v-model="form.phone"
                                type="tel"
                                placeholder="Your Phone"
                                class="form-control"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'phone'
                                    )
                                }"
                                name="phone"
                            />
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.phone"
                            >
                                {{ validationErrors.phone[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputGroupSelect01" style="color:white;">Woreda</label>
                            <select
                                class="custom-select"
                                id="inputGroupSelect01"
                                v-model="form.woreda"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'woreda'
                                    )
                                }"
                                name="woreda"
                            >
                                <option disabled value=""
                                    >Choose woreda..</option
                                >
                            </select>
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.woreda"
                            >
                                {{ validationErrors.woreda[0] }}
                            </div>
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.woreda"
                            >
                                {{ validationErrors.woreda[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input
                                v-model="form.password"
                                type="password"
                                placeholder="New Password(Optional)"
                                class="form-control"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'password'
                                    )
                                }"
                                name="password"
                            />
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.password"
                            >
                                {{ validationErrors.password[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Confirm New Password(Optional)"
                                class="form-control"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'password'
                                    )
                                }"
                                name="password_confirmation"
                            />
                        </div>
                        <div class="form-group">
                            <input
                                v-model="form.old_password"
                                type="password"
                                placeholder="Old Password"
                                class="form-control"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'old_password'
                                    )
                                }"
                                name="old_password"
                                required
                            />
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.old_password"
                            >
                                {{ validationErrors.old_password[0] }}
                            </div>
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
    created() {
        this.getWoredas();
        this.fillForm();
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem('user')),
            form: new Form({
                name: "",
                email: "",
                phone: "",
                woreda: "",
                password: "",
                password_confirmation: "",
                old_password: ""
            }),
            validationErrors: {},
        };
    },

    methods: {
        getWoredas() {
            let vm = this;
            axios
                .get("/api/get_woredas")
                .then(function(response) {
                    let x = response.data;
                    jQuery.each(x, function(i, woreda) {
                        $("#inputGroupSelect01 option:last").after(
                            `<option value="${i}">${i}</option>`
                        );
                    });
                    vm.woredas = JSON.parse(JSON.stringify(response.data));
                })
                .catch(function(err) {
                });
        },
        fillForm() {
            this.form.name = this.user.name
            this.form.email = this.user.email
            this.form.phone = this.user.phone
            this.form.woreda = this.user.woreda
        },
        update() {
            var currentObj = this;
            let data = {};
            data.name = this.form.name;
            data.email = this.form.email;
            data.phone = this.form.phone;
            data.woreda = this.form.woreda;
            data.password = this.form.password;
            data.password_confirmation = this.form.password_confirmation;
            data.old_password = this.form.old_password;
            axios.post('/api/update_account', data)
                .then((response) => {
                    currentObj.$swal({
                        icon: "success",
                        title: "Awesome..",
                        text: "You have successfully updated your user information."
                    });
                    localStorage.setItem('user', JSON.stringify(response.data.user))
                    currentObj.form.password = ""
                    currentObj.form.password_confirmation = ""
                    currentObj.form.old_password = ""
                    $(".invalid-feedback").html('');
                    currentObj.validationErrors = {}
                    currentObj.$forceUpdate();
                })
                .catch((err) => {
                    if(err.response.status == 422)
                        currentObj.$swal({
                            icon: "error",
                            title: "Oops...",
                            text: err.response.data.message
                        });
                    else
                        currentObj.$swal({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong with our system... Contact our support staff if the problem persists."
                        });
                    currentObj.validationErrors = err.response.data.errors;
                    $(".invalid-feedback").show();
                });
        }
    }
};
</script>
