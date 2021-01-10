<template>
  <section class="page-section bg-light" id="portfolio">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">wanted criminals</h2>
        <h3 class="section-subheading text-muted"></h3>
      </div>
      <div class="row justify-content-center">
        <div
          class="col-lg-3 col-sm-6 mb-4"
          v-for="wanted in wanted_criminal.data"
          v-bind:key="wanted.id"
        >
          <div class="portfolio-item">
            <a
              class="portfolio-link"
              v-on:click="
                showModal(
                  wanted.criminal.mugshot1,
                  wanted.criminal.name,
                  wanted.description
                )
              "
            >
              <div class="portfolio-hover">
                <div class="portfolio-hover-content">
                  <i class="fas fa-plus fa-3x"></i>
                </div>
              </div>
              <img
                class="img-fluid"
                v-bind:src="'/' + wanted.criminal.mugshot1"
              />
            </a>
            <div class="portfolio-caption">
              <div class="portfolio-caption-heading">
                {{ wanted.criminal.name }}
              </div>
              <div class="portfolio-caption-subheading text-muted">
                {{ wanted.description }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <pagination
          :data="wanted_criminal"
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
                  <p id="desc-missing" class="item-intro text-muted"></p>
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
      wanted_criminal: {},
      interval: undefined,
    };
  },
  mounted() {
    this.getResults();
    window.Echo.channel('wanted-criminals')
    .listen('WantedCriminalAdded', (e) => {
        this.wanted_criminal = e.wantedCriminals
    })
  },

  methods: {
    getResults(page = 1) {
      axios.get("/api/wanted_criminals_api?page=" + page).then((response) => {
        this.wanted_criminal = response.data.wanted_criminals;
      });
    },

    showModal(url, name, desc) {
      $("#name-missing").html(name);
      $("#desc-missing").html(desc);
      $("#img-missing").attr("src", "/" + url);
      $("#missingModal").modal();
    },
  },
};
</script>
