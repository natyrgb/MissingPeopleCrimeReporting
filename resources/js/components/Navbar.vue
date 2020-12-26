<template>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <button
        class="navbar-toggler navbar-toggler-right"
        type="button"
        data-toggle="collapse"
        data-target="#navbarResponsive"
        aria-controls="navbarResponsive"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        Menu
        <i class="fas fa-bars ml-1"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item">
            <router-link class="nav-link js-scroll-trigger" to="/api/home"
              >Home</router-link
            >
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdownMenuLink"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              News Feed
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <router-link class="dropdown-item" to="/api/news_feed"
                >News Feed</router-link
              >
              <router-link class="dropdown-item" to="/api/missing_people"
                >Missing people</router-link
              >
              <router-link class="dropdown-item" to="/api/wanted_criminals"
                >Wanted criminals</router-link
              >
              <a class="dropdown-item" href="#">Crime stats</a>
            </div>
          </li>

          <li v-if="isLoggedIn" class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdownMenuLink"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Make Report
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <router-link class="dropdown-item" to="/api/make_complaint"
                >Make complaints</router-link
              >
              <router-link class="dropdown-item" to="/api/report_missing"
                >Report missing person</router-link
              >
            </div>
          </li>
          <li v-if="isLoggedIn" class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdownMenuLink"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              My Reports
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <router-link class="dropdown-item" to="/api/my_complaints"
                >Complaints</router-link
              >
              <router-link class="dropdown-item" to="/api/my_missing_people"
                >Missing people</router-link
              >
            </div>
          </li>
          <li v-if="isLoggedIn" id="logout" class="nav-item">
            <a class="nav-link js-scroll-trigger" @click="logout" style="cursor: pointer;"
              >Logout</a>
          </li>

          <li v-if="!isLoggedIn" id="login" class="nav-item">
            <router-link class="nav-link js-scroll-trigger" to="/api/login"
              >Login</router-link
            >
          </li>
          <li v-if="!isLoggedIn" class="nav-item" id="register">
            <router-link
                class="nav-link js-scroll-trigger"
                to="/api/register"
                >Register Here!</router-link
            >
        </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  computed: {
    isLoggedIn : function(){ return this.$store.getters.isLoggedIn }
  },
  methods: {
    logout: function () {
      this.$store.dispatch("logout").then(() => {
        this.$router.push("/api/login");
      });
    },
  },
};
</script>
