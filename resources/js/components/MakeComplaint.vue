<template>
    <section class="page-section" id="contact">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Complaints</h2>
            </div>
            <form
                @submit.prevent="complaints"
                id="contactForm"
                name="sentMessage"
                novalidate="novalidate"
            >
                <div class="row align-items-stretch mb-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select
                                class="custom-select"
                                id="inputGroupSelect01"
                                @change="onWoredaChange($event)"
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
                            <select
                                class="custom-select"
                                id="inputGroupSelect02"
                                v-model="station"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'station_id'
                                    )
                                }"
                                name="station"
                            >
                                <option disabled value=""
                                    >Choose station..</option
                                >
                            </select>
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.station_id"
                            >
                                {{ validationErrors.station_id[0] }}
                            </div>
                        </div>
                        <div>
                            <select
                                class="custom-select"
                                id="inputGroupSelect03"
                                v-model="crime"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'type'
                                    )
                                }"
                                name="crime"
                            >
                                <option disabled value=""
                                    >Choose crime type..</option
                                >
                                <option value="robbery">burglury</option>
                                <option value="assault">assault</option>
                                <option value="homicide">homicide</option>
                            </select>
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.type"
                            >
                                {{ validationErrors.type[0] }}
                            </div>
                        </div>
                        <br />
                        <div class="input-group">
                            <div class="custom-file">
                                <input
                                    type="file"
                                    :multiple="true"
                                    class="custom-file-input"
                                    id="customFileLang"
                                    v-on:change="onFileChange"
                                    :class="{
                                        'is-invalid': validationErrors.hasOwnProperty(
                                            'image'
                                        )
                                    }"
                                    name="image"
                                />
                                <label
                                    class="custom-file-label"
                                    for="customFileLang"
                                    >Upload image</label
                                >
                            </div>
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.image"
                            >
                                {{ validationErrors.image[0] }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-group-textarea mb-md-0">
                        <label for="message" style="color:white !important;">Remarks</label>
                            <textarea
                                class="form-control"
                                id="message"
                                placeholder="Remarks.."
                                required="required"
                                data-validation-required-message="Please enter a message."
                                v-model="remarks"
                                :class="{
                                    'is-invalid': validationErrors.hasOwnProperty(
                                        'details'
                                    )
                                }"
                                name="remarks"
                            ></textarea>
                            <div
                                class="invalid-feedback d-block"
                                v-if="validationErrors.details"
                            >
                                {{ validationErrors.details[0] }}
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
            woreda: "",
            station: "",
            crime: "",
            image: null,
            remarks: "",
            woredas: [],
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
        onWoredaChange(event) {
            let arr = JSON.parse(JSON.stringify(this.woredas));
            let woreda = this.woredas[event.target.value];
            $("#inputGroupSelect02").empty();
            $("#inputGroupSelect02").append(
                '<option disabled value="">Choose station..</option>'
            );
            jQuery.each(woreda, function(i, station) {
                $("#inputGroupSelect02 option:last").after(
                    `<option value="${station.id}">${station.name}</option>`
                );
            });
        },
        complaints(e) {
            e.preventDefault();
            let currentObj = this;

            let formData = new FormData();
            formData.append("station_id", this.station);
            formData.append("type", this.crime);
            formData.append("image", this.image);
            formData.append("details", this.remarks);
            axios
                .post("/api/complaints_api", formData)
                .then(function(response) {
                    currentObj
                        .$swal({
                            icon: "success",
                            title: "Hurray...",
                            text:
                                "You have successfully submitted your complaint.",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Show My Complaints."
                        })
                        .then(result => {
                            if (result.isConfirmed)
                                currentObj.$router.push("/api/my_complaints");
                            else {
                                // implement some logic
                            }
                        });
                })
                .catch(function(error) {
                    currentObj.$swal({
                        icon: "error",
                        title: "Oops...",
                        text: "An Error Occured."
                    });
                    currentObj.validationErrors = error.response.data.errors;
                });
        }
    }
};
</script>
