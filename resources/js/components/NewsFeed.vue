<template>
  <section class="page-section" id="portfolio">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">News feed</h2>
      </div>
      <div v-if="news_feed.length == 0" class="container">
        <div class="alert alert-secondary">
          <p class="lead">There are no news available.</p>
        </div>
      </div>
      <ul v-if="news_feed.length != 0" class="timeline">
        <li
          v-for="news in news_feed"
          v-bind:key="news.id"
          :class="news.id % 2 == 0 ? ' timeline-inverted' : ''"
        >
          <div class="timeline-image">
            <img
              class="rounded-circle img-fluid"
              v-bind:src="'/' + news.url"
              alt=""
            />
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="text-warning">{{ news.updated_at }}</h4>
              <h4 class="subheading">{{ news.title }}</h4>
            </div>
            <div class="timeline-body">
              <p class="text-muted">{{ news.article }}</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </section>
</template>
<script>
export default {
  data() {
    return {
      news_feed: [],
    };
  },
  mounted() {
    axios.get("/api/news_feed_api").then((response) => {
      this.news_feed = response.data.news;
    });
    window.Echo.channel("blogs").listen("BlogAdded", (e) => {
      this.news_feed = e.blogs;
    });
  },

  methods: {
    getData() {
      axios
        .get("/api/news_feed_api")
        .then(function (response) {
          let news_feed = response.data.news;
        })
        .catch(function (err) {
        });
    },
  },
};
</script>
