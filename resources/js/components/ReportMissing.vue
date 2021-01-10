<template>
    <section class="page-section" id="contact">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">
                    Report missing person
                </h2>
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
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'name'
                                    )
                                }"
                            />
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.name"
                            >
                                {{ validationErrors.name[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <select
                                class="custom-select"
                                id="inputGroupSelect01"
                                v-model="woreda"
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
                        </div>

                        <div class="form-group">
                            <input
                                type="file"
                                class="form-file-control"
                                @change="onFileChange"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'image'
                                    )
                                }"
                            />
                        </div>
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.image"
                            >
                                {{ validationErrors.image[0] }}
                            </div>

                        <div>
                            <label for="date" style="color:white !important;">Date of Missing</label>
                            <input
                                v-model="date"
                                id="date"
                                type="date"
                                name="date"
                                class="form-control"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'date'
                                    )
                                }"
                            />
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.date"
                            >
                                {{ validationErrors.date[0] }}
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="col-md-6">
                        <div class="form-group form-group-textarea mb-md-0">
                        <label for="description" style="color:white !important;">Description</label>
                            <textarea
                                v-model="description"
                                class="form-control"
                                name="description"
                                placeholder="Description.."
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'description'
                                    )
                                }"
                            >
                            ></textarea
                            >
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.description"
                            >
                                {{ validationErrors.description[0] }}
                            </div>
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
export default {
    created() {
        this.getWoredas();
    },
    data() {
        return {
            name: "",
            woreda: "",
            image: null,
            date: "",
            description: "",
            validationErrors: {}
        };
    },

    methods: {
        onFileChange(e) {
            this.image = e.target.files[0];
        },
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
                    vm.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: err.response.data.message
                    });
                    vm.validationErrors = err.response.data.errors;
                });
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
                .then(function(response) {
                    currentObj
                        .$swal({
                            icon: "success",
                            title: "Success",
                            text:
                                "You have successfully reported your complaint.",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Show My Missing Reports."
                        })
                        .then(result => {
                            if (result.isConfirmed)
                                currentObj.$router.push(
                                    "/api/my_missing_people"
                                );
                        });
                })
                .catch(error => {
                    currentObj.validationErrors = error.response.data.errors;
                });
        }
    }
};
</script>
