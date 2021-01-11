<template>
  <section class="page-section" id="contact">
    <div class="row justify-content-around d-flex m-4">
      <div class="col-md-5">
        <div class="card card-success">
          <div class="card-header">
            <h2 class="card-title">Crimes Rate In All Stations</h2>
          </div>
          <div class="card-body">
            <div class="canvas-container" style="width: 300px; height: 300px">
              <canvas id="crimeRate" width="100" height="100"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card card-success">
          <h2 class="card-header">Crimes Reported In All Wored</h2>
          <div class="card-body">
            <div class="canvas-container" style="height: 300px; width: 300px">
              <canvas id="typeAll" width="100" height="100"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-around d-flex m-4">
      <div class="col-md-5">
        <div class="card card-success">
          <h2 class="card-header">Crimes Reported In This Station</h2>
          <div class="card-body">
            <div class="canvas-container" style="height: 300px; width: 300px">
              <canvas id="typeStation" width="100" height="100"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card card-success">
          <h2 class="card-header">Missing People Reported So Far</h2>
          <div class="card-body">
            <div class="canvas-container" style="height: 300px; width: 300px">
              <canvas id="missingRatio" width="100" height="100"></canvas>
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
      crime_rates: [],
      type_station: [],
      type_all: [],
      still_missing: 0,
      found: 0,
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getResults() {
      axios.get("/api/charts_api").then((response) => {
        console.log(response.data.crime_rates);
      });
    },
    getLength(obj = null) {
      if (obj == null) return 0;
      return obj.length;
    },
  },
};
</script>
