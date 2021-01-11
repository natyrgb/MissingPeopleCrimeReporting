<template>
  <section class="page-section" id="contact">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">missing person</h2>
      </div>
      <body>
        <table class="table-responsive">
          <thead>
            <tr>
              <th>Date</th>
              <th>Name</th>
              <th>Description</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="my in my_missing_person" v-bind:key="my.id">
              <td>{{ my.time }}</td>
              <td>{{ my.name }}</td>
              <td class="text-truncate" style="max-width: 160px">
                <span
                  data-toggle="tooltip"
                  data-placement="top"
                  :title="my.description"
                  >{{ my.description }}</span
                >
              </td>
              <td>{{ my.status }}</td>
              <td>
                <input
                  class="btn btn-secondary btn-sm"
                  type="button"
                  value="Found"
                  v-on:click="found(my.id)"
                />
              </td>
            </tr>
          </tbody>
        </table>
      </body>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      my_missing_person: [],
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getResults() {
      axios.get("/api/missings_api").then((response) => {
          console.log(response.data);
        this.my_missing_person = response.data.my_missing;
      });
    },
    found(id) {
      axios.get("/api/mark_missing_found/" + id).then((response) => {
        this.my_missing_person = response.data.my_missing;
      });
    },
  },
};
</script>

