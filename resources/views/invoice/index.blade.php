@extends('layouts.app')

@section('content')
<div class="row">
    @if (count($errors) > 0)
    <div class="col-md-12">
        <div class="alert alert-danger">
            <h5 class="text-center">input validation error</h5>
            <ol>
                @foreach ($errors->all() as $error)
                <li><strong> {{ $error }} </strong></li>
                @endforeach
            </ol>
        </div>
    </div>
    @endif
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Invoice List') }}
                    </div>
                    @can('invoice-access')
                    <div>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalInterim">Interim Invoice : {{ $caselist->where('is_ready', 1)->count() }}</button>
                        <span class="btn btn-info" data-toggle="modal" data-target="#modalProforma">Proforma Invoice : {{ $caselist->where('is_ready', 2)->count() }}</span>
                        <span class="btn btn-success">Final Invoice : {{ $caselist->where('is_ready', 3)->count() }}</span>
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable"><i class="fas fa-pen"></i> Create</button> -->
                    </div>

                    @endcan
                </div>

                <div class="table-responsive">
                    @if(auth()->user()->hasRole('admin'))
                    <form action="{{ route('invoice.laporan') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" autocomplete="off" placeholder="dd/mm/yyyy" name="from" id="from" class="form-control @error('from') is-invalid @enderror">
                                    @error('from')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" autocomplete="off" placeholder="dd/mm/yyyy" name="to" id="to" class="form-control @error('to') is-invalid @enderror">
                                    @error('to')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="all">All</option>
                                        <option value="1">Paid</option>
                                        <option value="0">Unpaid</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Laporan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                    <table class="table table-striped table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Detail</th>
                                <th>No</th>
                                <th>Insurance</th>
                                <th>Case</th>
                                <th>No Invoice</th>
                                <th>Type Invoice</th>
                                <th>Tanggal Invoice</th>
                                <th>Tanggal Jatuh Tempo</th>
                                <th>Bank</th>
                                <th>Tanggal Bayar</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice as $inv)
                            <tr>
                                <td></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $inv->member->name }}</td>
                                <td>{{ $inv->caselist->file_no }}</td>
                                <td>{{ $inv->no_invoice }}</td>
                                <td>{{ $inv->type_invoice == 1 ? 'Interim Invoice' : '' }}{{ $inv->type_invoice == 2 ? 'Proforma Invoice' : '' }} {{ $inv->type_invoice == 3 ? 'Final Invoice' : '' }}</td>
                                <td>{{ Carbon\Carbon::parse($inv->date_invoice)->format('d/m/Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($inv->due_date)->format('d/m/Y') }}</td>
                                <td>{{ $inv->bank->bank_name ?? 'Kosong' }}</td>
                                <td>{{ $inv->tanggal_invoice ? Carbon\Carbon::parse($inv->tanggal_invoice)->format('d/m/Y') : '' }}</td>
                                <td>@if($inv->caselist->currency == 'IDR') <strong>IDR.</strong> @else <i class="fas fa-dollar-sign"></i> @endif {{ number_format($inv->grand_total) }}</td>
                                <td>
                                    <span class="badge badge-{{ $inv->status_paid == 1 ? 'success' : 'danger' }} p-1">{{ $inv->status_paid == 1 ? 'Paid' : 'Unpaid' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button class="btn btn-info btn-sm text-white" data-toggle="modal" onclick="konfirmasi(this)" data-id="{{ $inv->id }}" data-target="#KonfirmasiModal"><i class="far fa-check-circle"></i></button>
                                        @if($inv->type_invoice == 2)
                                        <a href="{{ route('invoice.final', $inv->case_list_id) }}" class="btn btn-sm btn-primary" onclick="return confirm('Ubah ke Final Invoice ?')"><i class="fas fa-file-invoice"></i></a>
                                        @endif
                                        <a href="{{ route('invoice.pdf', $inv->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a>
                                        <form method="post" action="{{ route('invoice.destroy', $inv->id) }}" style="display: inline;">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Anda Yakin Ingin Menghapus Invoice?')" class="btn btn-sm btn-warning"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="KonfirmasiModal" role="dialog" aria-labelledby="KonfirmasiModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" style="overflow: auto;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="KonfirmasiModalTitle">Confirm Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <form action="" id="TheFormConfirm" method="post"></form>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tanggal Bayar</label>
                                <input type="text" autocomplete="off" placeholder="dd/mm/yyyy" value="" class="form-control" name="tanggal_invoice" id='tanggal_invoice'>
                                <input type="hidden" class="form-control" readonly name="id_invoice" id="id_invoice">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Bank">Bank</label>
                                <select class="form-control" name="bank" id="bank">
                                    @foreach($bank as $list)
                                    <option value="{{ $list->id }}">{{ $list->bank_name }} - {{ $list->currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status_invoice" id="status_invoice">
                                    <option value="1">Paid</option>
                                    <option value="0">Unpaid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="store()" data-primary>Save changes</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalProforma" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" style="overflow: auto;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Create Proforma Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">

                    <form action="{{ route('invoice.store') }}" method="post" id="TheHolyForm" class="TheHolyForm">
                        @csrf
                        <input type="hidden" name="type_invoice" value="2">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_case">No Case</label>
                                    <br>
                                    <select name="no_case" id="no_case_proforma" class="form-control" onchange="OnSelect(this)">
                                        {{-- <option selected disabled>-- Select Case --</option>
                                            @foreach($caselist as $data)
                                            <option value="{{ $data->id }}">{{ $data->file_no }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="claim_amount">Gross Adjusted</label>
                                    <input type="text" required id="claim_amount" class="form-control claim_amount" readonly>
                                    <span class="badge badge-info text-light" id="claim_amount_badge"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adjusted">Scale Fee</label>
                                    <input type="text" required id="adjusted" class="form-control adjusted" readonly>
                                    <span class="badge badge-success" id="ForAdjusted"></span>
                                    <span class="badge badge-info" id="ForCategory"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fee_based">Fee Based</label>
                                    <input type="text" required id="fee_based" name="fee_based" class="form-control fee_based" readonly>
                                </div>
                                <input type="hidden" name="fee_hidden" id="fee_hidden" class="fee_hidden">
                            </div>
                            <div class=" col-md-3">
                                <div class="form-group">
                                    <label for="">Expense</label>
                                    <input type="text" required id="expense" class="form-control expense" readonly name="expense">
                                    <span class="badge badge-info text-light" id="expense_badge"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Discount</label>
                                    <input type="number" required id="discount" value="0" class="form-control discount" name="discount">
                                    <span class="badge badge-primary"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Type</label>
                                    <select name="type" id="type" class="form-control" onchange="OnSelectType(this)">
                                        <option disabled selected>-- Type --</option>
                                        <option value="1">Nominal</option>
                                        <option value="2">Percent (%)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">PPN</label>
                                    <input type="text" required id="share" class="form-control share" readonly>
                                    <span class="badge badge-primary" id="ForPercent"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Total</label>
                                    <input type="text" required id="total" class="form-control total" name="total" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Date Invoice</label>
                                    <input type="text" autocomplete="off" placeholder="dd/mm/yyy" id="date_invoice" class="form-control date_invoice" name="date_invoice">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-primary text-light">
                                        <tr>
                                            <th>Member</th>
                                            <th>Member Share</th>
                                            <th>No Invoice</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="forLoop" class="forLoop">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-danger" onclick="Currency()">Currency</button> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="FormSubmit()" class="btn btn-primary" data-primary>Create</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInterim" role="dialog" aria-labelledby="modalInterimTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" style="overflow: auto;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInterimTitle">Create Interim Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{ route('invoice.storeInterim') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_case">No Case</label>
                                    <br>
                                    <select name="no_case_interim" id="no_case_interim" class="form-control" onchange="OnSelectInterim(this)">
                                        {{-- <option selected disabled>-- Select Case --</option>
                                            @foreach($caselist as $data)
                                            <option value="{{ $data->id }}">{{ $data->file_no }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Date Invoice</label>
                                    <input type="text" autocomplete="off" placeholder="dd/mm/yyyy" id="date_invoice" class="form-control date_invoice" name="date_invoice">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Professional Service</label>
                                    <input type="text" id="professional_service" class="form-control" name="professional_service" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Expense</label>
                                    <input type="text" required id="expense_interim" class="form-control" readonly>
                                    <span class="badge badge-info text-light" id="expense_badge"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">PPN</label>
                                    <input type="text" required id="share_interim" class="form-control" readonly>
                                    <span class="badge badge-primary" id="ForPercent"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Total</label>
                                    <input type="text" required id="total_interim" class="form-control" name="total" readonly>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="bg-primary text-light">
                                        <tr>
                                            <th>Member</th>
                                            <th>Member Share</th>
                                            <th>No Invoice</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="forLoopInterim">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-danger" onclick="Currency()">Currency</button> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" data-primary>Create</button>
            </div>
            </form>
        </div>
    </div>
</div>
<style>
    .modal- {
        overflow-y: scroll !important;
    }
</style>
@stop

@section('footer')
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $("#tanggal_invoice").datepicker({
            dateFormat: "dd/mm/yy"
        });

        $(".date_invoice").datepicker({
            dateFormat: "dd/mm/yy"
        });

        $("#from").datepicker({
            dateFormat: "dd/mm/yy"
        });

        $("#to").datepicker({
            dateFormat: "dd/mm/yy"
        });

    })


    function konfirmasi(id) {
        $('#id_invoice').val($(id).attr('data-id'))
    }

    function store() {
        $.ajax({
            url: '/api/invoice/post',
            data: {
                id: $('#id_invoice').val(),
                bank: $('#bank').val(),
                status: $('#status_invoice').val(),
                tanggal_invoice: $('#tanggal_invoice').val()
            },
            method: 'POST',
            type: 'POSt',
            success: function(data) {
                console.log(data)
                location.reload()
            }
        })
    }
    $(`#no_case_final`).select2({
        placeholder: 'Select File No',
        ajax: {
            url: `/api/autocomplete`,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $(`#no_case_interim`).select2({
        placeholder: 'Select File No',
        ajax: {
            url: `/api/autocomplete/interim`,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $(`#no_case_proforma`).select2({
        placeholder: 'Select File No',
        ajax: {
            url: `/api/autocomplete`,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    async function GetTheCaseList() {
        let resource = await fetch('/api/autocomplete').then(data => data.json())
        return resource
    }
    const shedString = (string, separator) => {
        const separatedArray = string.split(separator);
        const separatedString = separatedArray.join("");
        return separatedString;
    }
    const Currency = async function() {
        let resource = await fetch('/api/currency').then(data => data.json())
        let claim_amount = $('#claim_amount').val()
        let expense = $('#expense').val()
        claim_amount = parseInt(shedString(claim_amount, ','))
        expense = parseInt(shedString(expense, ','))
        console.log(claim_amount, expense)
        if ($('#ForAdjusted').html() == 'IDR') {
            console.log('IDR')
            console.info(claim_amount * resource.kurs, expense / resource.kurs)
            $('#claim_amount_badge').html(`IDR. ${formatter(claim_amount)} -> $ ${formatter(claim_amount / resource.kurs)}`)
            $('#expense_badge').html(`IDR. ${formatter(expense)} -> $ ${formatter(expense / resource.kurs)}`)
        }
        if ($('#ForAdjusted').html() == 'USD') {
            console.log('USD')
            console.info(claim_amount * resource.kurs, expense * resource.kurs)
            $('#claim_amount_badge').html(`$ ${formatter(claim_amount)} -> IDR. ${formatter(claim_amount * resource.kurs)}`)
            $('#expense_badge').html(`$ ${formatter(expense)} -> IDR. ${formatter(expense * resource.kurs)}`)
        }
    }
    const FormSubmit = function() {
        $('.TheHolyForm').submit()
    }
    const formatter = function(num) {
        var str = num.toString().replace("", ""),
            parts = false,
            output = [],
            i = 1,
            formatted = null;
        if (str.indexOf(".") > 0) {
            parts = str.split(".");
            str = parts[0];
        }
        str = str.split("").reverse();
        for (var j = 0, len = str.length; j < len; j++) {
            if (str[j] != ",") {
                output.push(str[j]);
                if (i % 3 == 0 && j < (len - 1)) {
                    output.push(",");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };

    const GetResource = function(id) {
        return fetch(`/api/caselist/${id}`)
            .then((data) => {
                if (!data.ok) {
                    throw data.statusText;
                }
                return data.json()
            })
    }
    const GetResourceInterim = function(id) {
        return fetch(`/api/interim/${id}`)
            .then((data) => {
                if (!data.ok) {
                    throw data.statusText;
                }
                return data.json()
            })
    }
    const OnSelectInterim = async function(q) {
        try {
            let data = await GetResourceInterim($(q).val())
            if (data.caselist.category == 1) {
                $('#ForCategory').html('Marine')
            } else {
                $('#ForCategory').html('Non Marine')
            }
            // console.log(data.caselist)
            let expense = $('#expense_interim').val(formatter(data.expense));
            let prof = parseInt(data.caselist.professional_service)
            let persen = (parseInt(data.expense) + prof) * 10 / 100
            let total = parseInt(persen) + parseInt(data.expense) + prof
            $('#share_interim').val(formatter(persen))
            $('#total_interim').val(formatter(total))
            $('#total_interim').val(formatter(total))
            $('#professional_service').val(formatter(prof))
            // $('#forLoop').html('')

            $.each(data.caselist.member, function() {
                $('#forLoopInterim').append(`<tr>` +
                    `<td id=` + this.member_insurance + `_dom>` + TheAjaxFunc(this.member_insurance) + `</td>` +
                    `<td>` + this.share + `</td>` +
                    `<td>` + `<input class="form-control" required name="no_invoice[]">` + `</td>` +
                    `<td>` + formatter(total * parseInt(this.share) / 100) + `</td>` +
                    `</tr>`)
            })
        } catch (err) {
            console.info(err)
            iziToast.error({
                title: 'Error',
                message: `${err}`,
                position: 'topRight',
            });
        }
    }
    const OnSelect = async function(q) {
        $('#claim_amount').val('')
        $('#adjusted').val('')
        $('#fee_based').val('')
        $('#fee_hidden').val('')
        $('#expense').val('')
        $('#share').val('')
        $('#total').val('')
        $('#forLoop').html('')
        $('#claim_amount_badge').html('')
        $('#expense_badge').html('')
        try {
            let data = await GetResource($(q).val())
            console.log(data)
            if (data.caselist.category == 1) {
                $('#ForCategory').html('Marine')
            } else {
                $('#ForCategory').html('Non Marine')
            }

            $('.claim_amount').val(formatter(data.sum.claim_amount))
            $('.adjusted').val(formatter(data.sum.adjusted))
            if (data.caselist.remark == null) {
                $('.fee_based').val(formatter(data.sum.fee))
                $('.fee_hidden').val(formatter(data.sum.fee))
            } else {
                if (data.caselist.currency == 'IDR') {
                    $('.fee_based').val(formatter(data.caselist.fee_idr))
                    // $('.fee_hidden').val(data.caselist.fee_idr)
                } else {
                    $('.fee_based').val(formatter(data.caselist.fee_usd))
                    // $('.fee_hidden').val(data.caselist.fee_usd)
                }

                // $(".fee_hidden").val(parseInt(data.sum.fee))
            }

            $('.expense').val(formatter(data.expense))
            $('.share').val(formatter(parseInt(data.sum.fee) + parseInt(data.caselist.expense.amount)))
            // 
            let sub_total = 0;
            if (data.caselist.remark == null) {
                sub_total = parseInt(data.sum.fee) + parseInt(data.expense)
            } else {
                if (data.caselist.currency == 'IDR') {
                    sub_total = parseInt(data.caselist.fee_idr) + parseInt(data.expense)
                } else {
                    sub_total = parseInt(data.caselist.fee_usd) + parseInt(data.expense)
                }
            }
            // let persen = parseInt(sub_total) * parseInt(data.caselist.insurance.ppn) / 100
            let persen = parseInt(sub_total) * 10 / 100
            // $('.ForPercent').html(`${data.caselist.insurance.name} - ${data.caselist.insurance.ppn}%`)
            $('.ForAdjusted').html(`${data.caselist.currency}`)
            $('.share').val(formatter(persen))
            let total = (parseInt(sub_total) + parseInt(persen))
            $('.total').val(formatter(total))
            // $('.forLoop').html('')
            if (data.interim == 0) {
                $('.TheInterim').addClass('d-none')
            } else {
                $('.TheInterim').removeClass('d-none')
                $('.TotalBeforeInterim').val(formatter(total + data.interim))
                $('.TheInterimField').val(formatter(data.interim))
            }

            $.each(data.caselist.member, function() {
                $('.forLoop').append(`<tr>` +
                    `<td id=` + this.member_insurance + `_dom>` + TheAjaxFunc(this.member_insurance) + `</td>` +
                    `<td>` + this.share + `</td>` +
                    `<td>` + `<input class="form-control" required name="no_invoice[]">` + `</td>` +
                    `<td>` + formatter(total * parseInt(this.share) / 100) + `</td>` +
                    `</tr>`)
            })
        } catch (err) {
            console.info(err.message)
            iziToast.error({
                title: 'Error',
                message: `${err}`,
                position: 'topRight',
            });
        }
    }

    const OnSelectType = async function(q) {
        $('#claim_amount').val('')
        $('#adjusted').val('')
        $('#fee_based').val('')
        $('#fee_hidden').val('')
        $('#expense').val('')
        $('#share').val('')
        $('#total').val('')
        $('#forLoop').html('')
        $('#claim_amount_badge').html('')
        $('#expense_badge').html('')
        try {
            let data = await GetResource($("#no_case_proforma").val())
            // console.log(data)
            if (data.caselist.category == 1) {
                $('#ForCategory').html('Marine')
            } else {
                $('#ForCategory').html('Non Marine')
            }

            $('.claim_amount').val(formatter(data.sum.claim_amount))
            $('.adjusted').val(formatter(data.sum.adjusted))
            if (data.caselist.remark == null) {
                $('.fee_based').val(formatter(data.sum.fee))
                $('.fee_hidden').val(formatter(data.sum.fee))
            } else {
                if (data.caselist.currency == 'IDR') {
                    $('.fee_based').val(formatter(data.caselist.fee_idr))
                } else {
                    $('.fee_based').val(formatter(data.caselist.fee_usd))
                }
            }

            let discount = $(".discount").val()
            let type = $(q).val();
            let sub_total = 0;
            let ppn = 0;
            let fee = parseFloat($(".fee_based").val().replace(/,/g, ''));
            if (type == 1) {
                let nominal = parseInt(fee - discount) + parseInt(data.expense);
                console.log(nominal)
                ppn = nominal * 10 / 100;
                sub_total = parseInt(nominal + ppn)
            } else {
                let disc = parseInt(fee * discount) / 100;
                let nominal = parseInt(fee - disc) + parseInt(data.expense);
                ppn = nominal * 10 / 100;
                sub_total = parseInt(nominal + ppn)
            }

            $('.expense').val(formatter(data.expense))
            $('.share').val(formatter(ppn))
            $('.ForAdjusted').html(`${data.caselist.currency}`)
            $('.share').val(formatter(ppn))
            let total = (parseInt(sub_total))
            $('.total').val(formatter(total))
            if (data.interim == 0) {
                $('.TheInterim').addClass('d-none')
            } else {
                $('.TheInterim').removeClass('d-none')
                $('.TotalBeforeInterim').val(formatter(total + data.interim))
                $('.TheInterimField').val(formatter(data.interim))
            }

            $.each(data.caselist.member, function() {
                $('.forLoop').append(`<tr>` +
                    `<td id=` + this.member_insurance + `_dom>` + TheAjaxFunc(this.member_insurance) + `</td>` +
                    `<td>` + this.share + `</td>` +
                    `<td>` + `<input class="form-control" required name="no_invoice[]">` + `</td>` +
                    `<td>` + formatter(total * parseInt(this.share) / 100) + `</td>` +
                    `</tr>`)
            })
        } catch (err) {
            console.info(err.message)
            iziToast.error({
                title: 'Error',
                message: `${err}`,
                position: 'topRight',
            });
        }
    }

    // $("#type").on('change', function() {
    //     let discount = $("#discount").val();
    //     let fee = parseFloat($("#fee_hidden").val().replace(/,/g, ''))
    //     let expense = parseFloat($("#expense").val().replace(/,/g, ''))

    //     if ($(this).val() == 1) {
    //         let nominal = parseInt(fee - discount) + expense;
    //         let ppn = nominal * 10 / 100;
    //         let subTotal = nominal + ppn;
    //         $("#share").val('')
    //         $("#share").val(formatter(ppn))
    //         $("#total").val('')
    //         $("#total").val(formatter(subTotal))
    //     }
    // })

    function FindTheInsurance(id) {
        return fetch(`/api/insurance/${id}`)
            .then(data => {
                if (!data.ok) {
                    throw data.statusText
                }
                return data.json()
            })
    }

    async function TheAjaxFunc(id) {
        let response = await FindTheInsurance(id)
        $(`#${id}_dom`).html(response.name)
    }

    $('#table').DataTable({
        responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [{
                className: 'dtr-control',
                responsivePriority: 1,
                targets: 0
            },
            {
                responsivePriority: 2,
                targets: 1
            }
        ]
    })
</script>
@stop