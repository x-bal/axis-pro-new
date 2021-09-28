@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-danger mt-5" id="spinner" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <canvas id="myChart1" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card">
                <div class=" card-body bg-danger">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px;">4</h1>
                            <span>Report 1</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span>Detail</span>
                    <span class="float-right"><i class="fas fa-arrow-circle-right"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class=" card-body bg-primary">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px; ">4</h1>
                            <span>Report 2</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span>Detail</span>
                    <span class="float-right"><i class="fas fa-arrow-circle-right"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class=" card-body bg-success">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px;">4</h1>
                            <span>Report 3</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span>Detail</span>
                    <span class="float-right"><i class="fas fa-arrow-circle-right"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class=" card-body bg-info">
                    <i class="fas fa-file-alt fa-4x text-white"></i>
                    <div class="float-right">
                        <div class="text-white">
                            <h1 style="font-size: 50px; font-weight: bold; margin-left: 30px; margin-bottom: -10px;">4</h1>
                            <span>Report 4</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span>Detail</span>
                    <span class="float-right"><i class="fas fa-arrow-circle-right"></i></span>
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
    $(document).ready(function() {
        $.ajax({
            url: '/api/chart/caselist',
            success: function(resource) {
                let label = [];
                let value = [];
                $.each(resource.policy, function() {
                    label.push(this.type_policy)
                    value.push(this.type_policy)
                })
                $.each(resource.caselist, async function() {
                    if (label.includes(this.policy.type_policy)) {
                        value[this.policy.id - 1] = await fetch(`/api/count/${this.policy.id}`).then(data => data.json())
                    }
                    total = value
                })
                setTimeout(function() {
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
                            }]
                        }
                    })
                }, 1000)
                console.clear()
            }
        })
    })
</script>
@stop