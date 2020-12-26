
<div class="row justify-content-around d-flex">
    <div class="col-md-10">
        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h1 class="card-title">Crimes Rate In All Stations</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="canvas-container" style="width:60vw; height:30vh;">
                    <canvas id="crimeRate" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-around d-flex">
    <div class="col-md-5">
        <div class="card card-success">
            <h2 class="card-header">Crimes Reported In All Stations</h2>
            <div class="card-body">
                <div class="canvas-container" style="height:300px; width:300px;">
                    <canvas id="typeAll" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-success">
            <h2 class="card-header">Crimes Reported In This Station</h2>
            <div class="card-body">
                <div class="canvas-container" style="height:300px; width:300px;">
                    <canvas id="typeStation" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-success">
            <h2 class="card-header">Missing People Reported So Far</h2>
            <div class="card-body">
                <div class="canvas-container" style="height:300px; width:300px;">
                    <canvas id="missingRatio" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
@parent

<script>
    function getLength(obj = null) {
        if (obj == null)
            return 0;
        return obj.length;
    }
    var crime_rates = {!!json_encode($crime_rates)!!};
    var stations = Object.keys(crime_rates);
    var crimes = Object.values(crime_rates);

    var robberyData = [], homicideData = [], assaultData = [], burglaryData = [], narcoticsData =[];
    function getStationCrimes(item, index) {
        robberyData.push(getLength(crime_rates[item].robbery));
        homicideData.push(getLength(crime_rates[item].homicide));
        assaultData.push(getLength(crime_rates[item].assault));
        burglaryData.push(getLength(crime_rates[item].burglary));
        narcoticsData.push(getLength(crime_rates[item].narcotics));
    }
    stations.forEach(getStationCrimes);
    var ctx = document.getElementById('crimeRate');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: stations,
            datasets: [
                {
                    label: 'Robbery',
                    backgroundColor: "#caf270",
                    data: robberyData,
                    borderWidth: 1
                },
                {
                    label: 'Homicide',
                    backgroundColor: "#45c490",
                    data: homicideData,
                    borderWidth: 1
                },
                {
                    label: 'Assault',
                    backgroundColor: "#008d93",
                    data: assaultData,
                    borderWidth: 1
                },
                {
                    label: 'Burglary',
                    backgroundColor: "#2e5468",
                    data: burglaryData,
                    borderWidth: 1
                },
                {
                    label: 'Narcotics',
                    backgroundColor: "#000",
                    data: narcoticsData,
                    borderWidth: 1
                },
            ]
        },
        options: {
            tooltips: {
                displayColors: true,
                callbacks:{
                    mode: 'x',
                },
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    gridLines: {
                        display: false,
                    },
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    },
                    type: 'linear',
                }],
            },
            responsive:true,
            maintainAspectRatio: false,
            legend: { position: 'right' }
        },
    });
    function getLength(obj = null) {
        if (obj == null)
            return 0;
        return obj.length;
    }

    var by_type = {!!json_encode($type_all)!!};
    var type_list = Object.keys(by_type);
    var type_values = Object.values(by_type);
    var ctx = document.getElementById('typeAll');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: type_list,
            datasets: [
                {
                    label: 'Solved',
                    backgroundColor: "#caf270",
                    data: [getLength(type_values[0].solved), getLength(type_values[1].solved), getLength(type_values[2].solved), getLength(type_values[3].solved)],
                    borderWidth: 1
                },
                {
                    label: 'Under Investigation',
                    backgroundColor: "#45c490",
                    data: [getLength(type_values[0].under_investigation), getLength(type_values[1].under_investigation), getLength(type_values[2].under_investigation), getLength(type_values[3].under_investigation)],
                    borderWidth: 1
                },
                {
                    label: 'In Court',
                    backgroundColor: "#008d93",
                    data: [getLength(type_values[0].in_court), getLength(type_values[1].in_court), getLength(type_values[2].in_court), getLength(type_values[3].in_court)],
                    borderWidth: 1
                },
                {
                    label: 'Newly Reported',
                    backgroundColor: "#2e5468",
                    data: [getLength(type_values[0].new), getLength(type_values[1].new), getLength(type_values[2].new), getLength(type_values[3].new)],
                    borderWidth: 1
                },
            ]
        },
        options: {
            tooltips: {
                displayColors: true,
                callbacks:{
                    mode: 'x',
                },
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    gridLines: {
                        display: false,
                    },
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    },
                    type: 'linear',
                }],
            },
            responsive:true,
            maintainAspectRatio: false,
            legend: { position: 'bottom' }
        },
    });

    var by_type_st = {!!json_encode($type_station)!!};
    var type_list_st = Object.keys(by_type_st);
    var type_values_st = Object.values(by_type_st);
    var ctx = document.getElementById('typeStation');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: type_list_st,
            datasets: [
                {
                    label: 'Solved',
                    backgroundColor: "#caf270",
                    data: [getLength(type_values_st[0].solved), getLength(type_values_st[1].solved), getLength(type_values_st[2].solved), getLength(type_values_st[3].solved)],
                    borderWidth: 1
                },
                {
                    label: 'Under Investigation',
                    backgroundColor: "#45c490",
                    data: [getLength(type_values_st[0].under_investigation), getLength(type_values_st[1].under_investigation), getLength(type_values_st[2].under_investigation), getLength(type_values_st[3].under_investigation)],
                    borderWidth: 1
                },
                {
                    label: 'In Court',
                    backgroundColor: "#008d93",
                    data: [getLength(type_values_st[0].in_court), getLength(type_values_st[1].in_court), getLength(type_values_st[2].in_court), getLength(type_values_st[3].in_court)],
                    borderWidth: 1
                },
                {
                    label: 'Newly Reported',
                    backgroundColor: "#2e5468",
                    data: [getLength(type_values_st[0].new), getLength(type_values_st[1].new), getLength(type_values_st[2].new), getLength(type_values_st[3].new)],
                    borderWidth: 1
                },
            ]
        },
        options: {
            tooltips: {
                displayColors: true,
                callbacks:{
                    mode: 'x',
                },
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    gridLines: {
                        display: false,
                    },
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    },
                    type: 'linear',
                }],
            },
            responsive:true,
            maintainAspectRatio: false,
            legend: { position: 'bottom' }
        },
    });

    var missing = {{$still_missing}};
    var found = {{$found}};
    var ctx = document.getElementById('missingRatio');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Not Found', 'Found'],
            datasets: [{
                label: '# of missing people',
                data: [missing, found],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
    });
</script>
@stop
