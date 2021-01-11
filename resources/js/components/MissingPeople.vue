<template>
  <section class="page-section bg-light" id="portfolio">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">missing people</h2>
        <h3 class="section-subheading text-muted"></h3>
      </div>
      <div class="row justify-content-center">
        <div
          class="col-lg-3 col-sm-6 mb-4"
          v-for="missing in missing_people.data"
          v-bind:key="missing.id"
        >
          <div class="portfolio-item">
            <a
              class="portfolio-link"
              v-on:click="
                showModal(
                  missing.attachment.url,
                  missing.name,
                  missing.description
                )
              "
            >
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-plus fa-3x"></i>
                </div>
              </div>
              <img class="img-fluid" v-bind:src="'/'+missing.attachment.url" />
            </a>
            <div class="portfolio-caption">
              <div class="portfolio-caption-heading">{{ missing.name }}</div>
              <div class="portfolio-caption-subheading text-muted">
                {{ missing.description }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <pagination
          :data="missing_people"
          @pagination-change-page="getResults"
        ></pagination>
      </div>
    </div>
    <div
      class="portfolio-modal modal fade"
      id="missingModal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="close-modal" data-dismiss="modal">
            <img src="/assets/img/close-icon.svg" alt="Close modal" />
          </div>
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="modal-body">
                  <!-- Project Details Go Here-->
                  <h2 id="name-missing" class="text-uppercase">Project Name</h2>
                  <p id="desc-missing" class="item-intro text-muted">
                    Lorem ipsum dolor sit amet consectetur.
                  </p>
                  <img
                    id="img-missing"
                    class="img-fluid d-block mx-auto"
                    src="/assets/img/portfolio/01-full.jpg"
                    alt=""
                  />
                  <p></p>
                  <button
                    class="btn btn-primary"
                    data-dismiss="modal"
                    type="button"
                  >
                    <i class="fas fa-times mr-1"></i>
                    Close Project
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      missing_people: {},
      interval: undefined,
    };
  },
  mounted() {
    this.getResults();
    window.Echo.channel('missing-people')
    .listen('MissingPersonAdded', (e) => {
        this.missing_people = e.missingPeople
    })
  },

  methods: {
    display_data() {
      console.log(this.data);
    },
    getResults(page = 1) {
      axios
        .get("/api/missing_people_for_guest?page=" + page)
        .then((response) => {
          console.log(response.data.missing_people);
          this.missing_people = response.data.missing_people;
        });
    },

    showModal(url, name, desc) {
      $("#name-missing").html(name);
      $("#desc-missing").html(desc);
      $("#img-missing").attr("src", '/'+url);
      $("#missingModal").modal();
    },
  },
};
</script>
