<template>
  <section class="page-section" id="contact">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">My Complaints</h2>
      </div>
      <body>
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Type</th>
              <th>Description</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="my in my_complaints" v-bind:key="my.id">
              <td>{{ my.created_at }}</td>
              <td>{{ my.type }}</td>
              <td class="text-truncate" style="max-width: 160px">
                <span
                  data-toggle="tooltip"
                  data-placement="top"
                  :title="my.details"
                  >{{ my.details }}</span
                >
              </td>

              <td>{{ my.status == 'new' ? 'not solved' : my.status }}</td>
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
      my_complaints: [],
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getResults() {
      axios.get("/api/complaints_api").then((response) => {
        this.my_complaints = response.data.my_complaints;
        console.log(response.data.my_complaints);
      });
    },
  },
};
</script>
