<template>
  <section class="page-section" id="contact">
    <div class="row justify-content-around d-flex m-4">
      <div class="col-md-10 my-4">
        <div class="card card-success">
          <div class="card-header">
            <h2 class="card-title">Crimes Rate In All Stations</h2>
          </div>
          <div class="card-body">
            <div class="canvas-container" style="width: 60vw; height: 30vh">
              <canvas id="crimeRate" width="100" height="100"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-around d-flex m-4">
      <div class="col-md-8">
        <div class="card card-success">
          <h2 class="card-header">Missing People Reported So Far</h2>
          <div class="card-body">
            <div class="canvas-container" style="height: 400px; width: 400px">
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
      still_missing: 0,
      found: 0,
      robberyData: [],
      homicideData: [],
      assaultData: [],
      burglaryData: [],
      othersData: [],
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getResults() {
      let vm = this;
      axios.get("/api/charts_api").then((response) => {
        vm.crime_rates = response.data.crime_rates;
        vm.type_station = response.data.type_station;
        vm.still_missing = response.data.still_missing;
        vm.found = response.data.found;

        let stations = Object.keys(vm.crime_rates);
        let crimes = Object.values(vm.crime_rates);
        stations.forEach(vm.getStationCrimes);
        var ctx = document.getElementById("crimeRate");
        var myChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: stations,
            datasets: [
              {
                label: "Robbery",
                backgroundColor: "#caf270",
                data: vm.robberyData,
                borderWidth: 1,
              },
              {
                label: "Homicide",
                backgroundColor: "#45c490",
                data: vm.homicideData,
                borderWidth: 1,
              },
              {
                label: "Assault",
                backgroundColor: "#008d93",
                data: vm.assaultData,
                borderWidth: 1,
              },
              {
                label: "Burglary",
                backgroundColor: "#2e5468",
                data: vm.burglaryData,
                borderWidth: 1,
              },
              {
                label: "Others",
                backgroundColor: "#000",
                data: vm.othersData,
                borderWidth: 1,
              },
            ],
          },
          options: {
            tooltips: {
              displayColors: true,
              callbacks: {
                mode: "x",
              },
            },
            scales: {
              xAxes: [
                {
                  stacked: true,
                  gridLines: {
                    display: false,
                  },
                },
              ],
              yAxes: [
                {
                  stacked: true,
                  ticks: {
                    beginAtZero: true,
                    stepSize: 1
                  },
                  type: "linear",
                },
              ],
            },
            responsive: true,
            maintainAspectRatio: false,
            legend: { position: "right" },
          },
        });

        var missing = vm.still_missing;
        var found = vm.found;
        var ctx = document.getElementById("missingRatio");
        var myChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: ["Still Missing " + missing, "Found " + found],
            datasets: [
              {
                label: "# of missing people",
                data: [missing, found],
                backgroundColor: [
                  "rgba(255, 99, 132, 0.6)",
                  "rgba(54, 162, 235, 0.6)",
                ],
                borderColor: [
                  "rgba(255, 99, 132, 1)",
                  "rgba(54, 162, 235, 1)",
                ],
                borderWidth: 1,
              },
            ],
          },
          options: {
            legend: { position: "right" },
          }
        });
      }).catch((error) => {
          console.log(error);
      });
    },
    getLength(obj = null) {
      if (obj == null) return 0;
      return obj.length;
    },
    getStationCrimes(item, index) {
      this.robberyData.push(this.getLength(this.crime_rates[item].robbery));
      this.homicideData.push(this.getLength(this.crime_rates[item].homicide));
      this.assaultData.push(this.getLength(this.crime_rates[item].assault));
      this.burglaryData.push(this.getLength(this.crime_rates[item].burglary));
      this.othersData.push(this.getLength(this.crime_rates[item].others));
    },
  },
};
</script>
