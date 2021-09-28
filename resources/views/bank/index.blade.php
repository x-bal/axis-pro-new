@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Bank List') }}
                    </div>
                    @can('bank-create')
                    <a href="{{ route('bank.create') }}" class="btn btn-primary"><i class="fas fa-pen"></i> Create</a>
                    @endcan
                </div>
                <div class="d-flex justify-content-start">
                    <div class="form-group">
                        <input name="kurs" id="kurs" type="kurs" value="{{ $kurs->kurs ?? 'Kosong' }}" class="form-control @error('kurs') is-invalid @enderror">

                        @error('kurs')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="ml-2 form-btn">
                        <button class="btn btn-primary" onclick="TheAjaxFunc()">Update Kurs</button>
                    </div>
                </div>
                <table class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bank Name</th>
                            <th>No Account</th>
                            <th>Currency</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banks as $bank)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bank->bank_name }}</td>
                            <td>{{ $bank->no_account }}</td>
                            <td>{{ $bank->currency }}</td>
                            <td>
                                @can('bank-edit')
                                <a href="{{ route('bank.edit', $bank->id) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('bank-delete')
                                <form action="{{ route('bank.destroy', $bank->id) }}" method="post" style="display: inline;" onclick="return confirm('Delete data?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    function TheAjaxFunc() {
        event.preventDefault()
        $.ajax({
            url: '/api/update/kurs',
            data: {
                'kurs': $('#kurs').val()
            },
            method: 'post',
            success: function(response) {
                console.log(response)
                if(response.kurs != null){
                    iziToast.error({
                    title: 'Error',
                    message: response.kurs[0],
                    position: 'topRight',
                });
                }else{
                    $('#kurs').val(response)
                    iziToast.success({
                        title: 'Success',
                        message: 'Updated',
                        position: 'topRight',
                    });
                }
            },
            error: function(error) {
                iziToast.error({
                    title: 'Error',
                    message: error.statusText,
                    position: 'topRight',
                });
            }
        })
    }
    $('.table').DataTable()
</script>
@stop