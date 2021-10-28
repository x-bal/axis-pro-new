@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-danger mt-5" id="spinner" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <canvas id="myChart1" width="500" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-danger mt-5" id="spinner2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <canvas id="myChart2" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class=" card-body bg-danger">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px;">{{ $satu }}</h1>
                            <span>Report 1</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-dark">
                    <span>Detail</span>
                    <a href="{{ route('report', 1) }}" class="float-right"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class=" card-body bg-primary">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px; ">{{ $dua }}</h1>
                            <span>Report 2</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-dark">
                    <span>Detail</span>
                    <a href="{{ route('report', 2) }}" class="float-right"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class=" card-body bg-success">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px;">{{ $tiga }}</h1>
                            <span>Report 3</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-dark">
                    <span>Detail</span>
                    <a href="{{ route('report', 3) }}" class="float-right"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class=" card-body bg-info">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px;">{{ $empat }}</h1>
                            <span>Report 4</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-dark">
                    <span>Detail</span>
                    <a href="{{ route('report', 4) }}" class="float-right"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class=" card-body bg-warning">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px;">{{ $lima }}</h1>
                            <span>Report 5</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-dark">
                    <span>Detail</span>
                    <a href="{{ route('report', 5) }}" class="float-right"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var total = []
    var bulan = []
    $(document).ready(function() {
        $.ajax({
            url: '/api/chart/caselist',
            success: async function(resource) {
                let label = [];
                let value = [];
                $.each(resource.policy, function() {
                    label.push(this.type_policy)
                    value.push(this.type_policy)
                })
                total = await fetch('/api/count/all/policy').then(data => data.json()) 
                // $.each(resource.caselist, async function() {
                //     if (label.includes(this.policy.type_policy)) {
                //         value[this.policy.id - 1] = await fetch(`/api/count/${this.policy.id}`).then(data => data.json())
                //     }
                //     total = value
                // })
                $('#spinner').addClass('d-none')
                var ctx = document.getElementById('myChart1').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            label: 'Type Policy',
                            backgroundColor: 'rgb(225, 116, 101)',
                            borderColor: 'rgb(255, 255, 255)',
                            data: total
                        }],
                        borderWidth: 10
                    }
                })
            }
        })
        $.ajax({
            url: '/api/chart/line/caselist/{{ auth()->user()->id }}',
            success: function(resource) {
                bulan = resource;
            }
        })
        setTimeout(function() {
            $('#spinner2').addClass('d-none')
            let chart2 = $('#myChart2');
            let myChart2 = new Chart(chart2, {
                type: 'line',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    datasets: [{
                        label: 'Bulan',
                        data: bulan,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
            })
        }, 1000)
    })
</script>
@stop