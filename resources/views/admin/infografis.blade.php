@include('admin.modular.header')
<h1>Infografis</h1>
<hr>
<div class="row">

<div class="col-12 col-md-4 ">
    <h3>Permohonan Harian</h3><hr>
    <div  id="chart"></div>
</div>
<div class="col-12 col-md-4 ">
    <h3>Permohonan Bulanan</h3><hr>
    <div  id="chart2"></div>
</div>
<div class="col-12 col-md-4 ">
    <h3>Permohonan Tahunan</h3><hr>
    <div  id="chart3"></div>
</div>
<div class="col-12 col-md-4 ">
    <h3>Akses Pengguna Harian</h3><hr>
    <div  id="chart4"></div>
</div>
<div class="col-12 col-md-4 ">
    <h3>Akses Pengguna Bulanan</h3><hr>
    <div  id="chart5"></div>
</div>
<div class="col-12 col-md-4 ">
    <h3>Akses Pengguna Tahunan</h3><hr>
    <div  id="chart6"></div>
</div>


</div>

<style>
#chart {
  max-width: 650px;
  margin: 35px auto;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
 $( document ).ready(function() {
 var options = {
  chart: {
    type: 'bar',
    id:"permohonan_harian"
  },
  series: [{
    name: 'Permohonan',
    data: {{json_encode($permohonan_data_day)}}
  }],
  xaxis: {
    categories: {!! json_encode($permohonan_name_day) !!}
  },

}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();

var options = {
  chart: {
    type: 'bar',
    id:"permohonan_bulanan"
  },
  series: [{
    name: 'Permohonan',
    data: {{json_encode($permohonan_data_month)}}
  }],
  xaxis: {
    categories: {!! json_encode($permohonan_name_month) !!}
  }
}

var chart = new ApexCharts(document.querySelector("#chart2"), options);

chart.render();


var options = {
  chart: {
    type: 'bar',
    id:"permohonan_tahunan"
  
  },
  series: [{
    name: 'Permohonan',
    data: {{json_encode($permohonan_data_year)}}
  }],
  xaxis: {
    categories: {!! json_encode($permohonan_name_year) !!}
  }
}

var chart = new ApexCharts(document.querySelector("#chart3"), options);

chart.render();


var options = {
  chart: {
    type: 'line',
    id:"pengguna_harian"
  
  },
  series: [{
    name: 'Akses Pengguna',
    data: {{json_encode($pengguna_data_day)}}
  }],
  xaxis: {
    categories: {!! json_encode($pengguna_name_day) !!}
  }
}

var chart = new ApexCharts(document.querySelector("#chart4"), options);

chart.render();

var options = {
  chart: {
    type: 'line',
    id:"pengguna_bulanan"
  },
  series: [{
    name: 'Akses Pengguna',
    data: {{json_encode($pengguna_data_month)}}
  }],
  xaxis: {
    categories: {!! json_encode($pengguna_name_month) !!}
  }
}

var chart = new ApexCharts(document.querySelector("#chart5"), options);

chart.render();

var options = {
  chart: {
    type: 'line',
    id:"pengguna_tahunan"
  },
  series: [{
    name: 'Akses Pengguna',
    data: {{json_encode($pengguna_data_year)}}
  }],
  xaxis: {
    categories: {!! json_encode($pengguna_name_year) !!}
  }
}

var chart = new ApexCharts(document.querySelector("#chart6"), options);

chart.render();
});
</script>
@include('admin.modular.footer')