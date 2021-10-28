<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="file_no">File No</label>
            <div class="input-group-append">
                <input name="file_no" id="file_no" type="text" autofocus value="{{ old('file_no') }}" class="form-control @error('file_no') is-invalid @enderror">
                <span class="input-group-text" id="basic-addon2">JAK</span>
            </div>
            <!--<select name="file_no" id="file_no" class="form-control @error('file_no') is-invalid @enderror">-->
            <!--    <option disabled selected>Select File No</option>-->
            <!--    @foreach($file_no as $data)-->
            <!--    <option @if($caseList->file_no == $data) selected @endif value="{{ $data }}">{{ $data }}</option>-->
            <!--    @endforeach-->
            <!--</select>-->

            @error('file_no')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="insurance">Insurance</label>
            <select name="insurance" autocomplete="on" id="insurance" class="form-control @error('insurance') is-invalid @enderror">
                <option disabled selected>Select Insurance</option>
                @foreach($client as $data)
                <option @if($data->id == $caseList->insurance_id) selected @endif value="{{ $data->id }}">{{ $data->brand }} - {{ $data->name }}</option>
                @endforeach
            </select>
            @error('insurance')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="adjuster">Adjuster</label>
            <select name="adjuster" id="adjuster" class="form-control @error('adjuster') is-invalid @enderror">
                <option disabled selected>Select Adjuster</option>
                @foreach($user as $data)
                <option @if($data->id == $caseList->adjuster_id) selected @endif value="{{ $data->id }}">{{ $data->nama_lengkap }}</option>
                @endforeach
            </select>
            @error('adjuster')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" type="text" class="form-control @error('category') is-invalid @enderror">
                <option disabled selected>Select Category</option>
                <option {{ $caseList->category == 1 ? 'selected' : '' }} value="1">Marine</option>
                <option {{ $caseList->category == 2 ? 'selected' : '' }} value="2">Non Marine</option>
            </select>
            @error('category')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="insured">Insured</label>
            <input type="text" id="insured" value="{{ $caseList->insured ?? old('insured') }}" name="insured" class="form-control @error('insured') is-invalid @enderror">
            @error('insured')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="dol">Dol</label>
            <input type="date" value="{{ $caseList->dol ?? old('dol') }}" id="dol" name="dol" class="form-control @error('dol') is-invalid @enderror">
            @error('dol')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="risk_location">Risk Location</label>
            <input type="text" id="risk_location" value="{{ $caseList->risk_location ?? old('risk_location') }}" name="risk_location" class="form-control @error('risk_location') is-invalid @enderror">
            @error('risk_location')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="currency">Currency</label>
            <select class="form-control @error('currency') is-invalid @enderror" name="currency" id="currency">
                <option disabled selected>Select Currency</option>
                <option @if($caseList->currency == 'IDR') selected @endif value="IDR">IDR</option>
                <option @if($caseList->currency == 'USD') selected @endif value="USD">USD</option>
            </select>
            @error('currency')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="broker">Broker</label>
            <select class="form-control @error('broker') is-invalid @enderror" name="broker" id="broker">
                <option disabled selected>Select Broker</option>
                @foreach($broker as $data)
                <option @if($data->id == $caseList->broker_id) selected @endif value="{{ $data->id }}">{{ $data->nama_broker }} - {{ $data->alamat_broker }}</option>
                @endforeach
            </select>
            @error('broker')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="incident">Incident</label>
            <select class="form-control @error('incident') is-invalid @enderror incident" name="incident" id="incident">
                <option disabled selected>Select Incident</option>
                @foreach($incident as $data)
                <option @if($data->id == $caseList->incident_id) selected @endif value="{{ $data->id }}">{{ $data->type_incident }}</option>
                @endforeach
            </select>
            @error('incident')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="policy">Policy</label>
            <select class="form-control @error('policy') is-invalid @enderror" name="policy" id="policy">
                <option disabled selected>Select Policy</option>
                @foreach($policy as $data)
                <option @if($data->id == $caseList->policy_id) selected @endif value="{{ $data->id }}">{{ $data->type_policy }}</option>
                @endforeach
            </select>
            @error('policy')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="no_leader_policy">No Leader Policy </label>
            <input class="form-control @error('no_leader_policy') is-invalid @enderror" value="{{ $caseList->no_leader_policy ?? old('no_leader_policy') }}" name="no_leader_policy" id="no_leader_policy" type="text">
            @error('no_leader_policy')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="begin">Begin</label>
            <input class="form-control @error('begin') is-invalid @enderror" value="{{ $caseList->begin ?? old('begin')}}" name="begin" id="begin" type="date">
            @error('begin')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="end">End</label>
            <input class="form-control @error('end') is-invalid @enderror" value="{{ $caseList->end ?? old('end') }}" name="end" id="end" type="date">
            @error('end')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="instruction_date">Instruction Date</label>
            <input class="form-control @error('instruction_date') is-invalid @enderror" value="{{ $caseList->instruction_date ?? old('instruction_date') }}" name="instruction_date" id="instruction_date" type="date">
            @error('instruction_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="survey_date">Survey Date</label>
            <input class="form-control @error('survey_date') is-invalid @enderror" value="{{ $caseList->survey_date ?? old('survey_date') }}" name="survey_date" id="survey_date" type="date">

            @error('survey_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="leader_claim_no">Leader Claim No</label>
            <input class="form-control @error('leader_claim_no') is-invalid @enderror" value="{{ $caseList->leader_claim_no ?? old('leader_claim_no') }}" name="leader_claim_no" id="leader_claim_no" type="text">
            @error('leader_claim_no')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="file_penunjukan">File Penunjukan</label>
            <input type="file" class="form-control @error('file_penunjukan') is-invalid @enderror" id="file_penunjukan" name="file_penunjukan">
            @error('file_penunjukan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="document_policy">Copy Polis</label>
            <input type="text" class="form-control @error('document_policy') is-invalid @enderror" id="document_policy" value="{{ $caseList->document_policy ?? old('document_policy') }}" name="document_policy">
            @error('document_policy')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group d-none" id="cyc">
            <label for="conveyance">Conveyance</label>
            <input class="form-control @error('conveyance') is-invalid @enderror" value="{{ $caseList->conveyance ?? old('conveyance') }}" name="conveyance" id="conveyance" type="text">
            @error('conveyance')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group d-none" id="lol">
            <label for="location_of_loss">Location Of Loss</label>
            <input class="form-control @error('location_of_loss') is-invalid @enderror" value="{{ $caseList->location_of_loss ?? old('location_of_loss') }}" name="location_of_loss" id="location_of_loss" type="text">
            @error('location_of_loss')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

</div>
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">LEADER / MEMBER <span id="total" name="total" class="badge badge-primary">{{ $caseList->member->sum('share') }}</span><strong>%</strong></label>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Member Share</th>
                            <th>Status</th>
                            <th class="text-center">
                                <a onclick="AddForm()" class="btn btn-sm btn-outline-success" id="add">Add Member</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="dynamic_form">
                        @foreach($caseList->member as $row)
                        <tr>
                            <td>
                                <div class="form-group">
                                    <select name="member[{{ $row->id }}]" id="member_{{ $row->id }}" class="form-control">
                                        @foreach($client as $data)
                                        <option @if($data->id == $row->member_insurance) selected @endif value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group-prepend">
                                        <input type="number" name="percent[{{ $row->id }}]" value="{{ $row->share ?? '' }}" oninput="LetMeHereToCount(this)" class="form-control percent">
                                        <span class="input-group-text" id="basic-addon3">%</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select name="status[{{ $row->id }}]" id="status" class="form-control">
                                        <option @if($row->is_leader) selected @endif value="LEADER">LEADER</option>
                                        <option @if(!$row->is_leader) selected @endif value="MEMBER">MEMBER</option>
                                    </select>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a onclick="DeleteForm(this)" class="btn btn-sm btn-outline-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <script>
                            setTimeout(function() {
                                $('#member_{{ $row->id }}').select2()
                            }, 500)
                        </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('#category').on('change', function() {
        if ($(this).val() == 1) {
            $('#cyc').removeClass('d-none')
            $('#lol').addClass('d-none')
        }
        if ($(this).val() == 2) {
            $('#lol').removeClass('d-none')
            $('#cyc').addClass('d-none')
        }
    })
    async function GetTheLastOfCaseList() {
        try {
            let data = await fetch('/api/caselist/file_no/last').then(data => {
                if (!data.ok) {
                    throw data.statusText
                }
                return data.json()
            })
            $('#file_no').val(data)
        } catch (error) {
            iziToast.error({
                title: 'Error',
                message: error.message,
                position: 'topRight',
            });
        }
    }
    async function GetTheCaseListWhenItOnEdit(id) {
        try {
            let data = await fetch(`/api/caselist/file_no/edit/${id}`).then(data => {
                if (!data.ok) {
                    throw data.statusText
                }
                return data.json()
            })
            $('#file_no').val(data)
        } catch (error) {
            iziToast.error({
                title: 'Error',
                message: error.message,
                position: 'topRight',
            });
        }
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

    function rupiah(e) {
        e.value = formatter(e.value)
    }

    setTimeout(function() {
        $('#incident').select2();
        $('#policy').select2();
        $('#broker').select2();
        $('#adjuster').select2();
        $('#insurance').select2();
        // $('#file_no').select2({
        //     tags: true
        // })
    }, 1000)

    function form_dinamic() {
        let index = $('#dynamic_form tr').length + 1
        let template = `
                <tr>
                    <td>
                    <div class="form-group">
                        <select name="member[${index}]" id="member_${index}" class="form-control">
                                @foreach($client as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="input-group-prepend">
                                <input type="number" name="percent[${index}]" oninput="LetMeHereToCount(this)" class="form-control percent">
                                <span class="input-group-text" id="basic-addon3">%</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="status[${index}]" id="status" class="form-control">
                                <option value="LEADER">LEADER</option>
                                <option value="MEMBER">MEMBER</option>
                            </select>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a onclick="DeleteForm(this)" class="btn btn-sm btn-outline-danger">Delete</a>
                        </div>
                    </td>
            </tr>
    `
        $('#dynamic_form').append(template)

        setTimeout(function() {
            $(`#member_${index}`).select2();
        }, 500)
    }

    function LetMeHereToCount(qr) {
        let input = $(qr).val()
        let coll = document.querySelectorAll('.percent')
        let total = 0
        for (let i = 0; i < coll.length; i++) {
            let ele = coll[i]
            total += parseInt(ele.value)
        }
        if (total > 100) {
            $('#submit_case_list').addClass('disabled')
            $('#submit_case_list').attr('disabled')
            $('#add').addClass('disabled')
            $('#total').html(total)
        } else {
            $('#submit_case_list').removeClass('disabled')
            $('#submit_case_list').removeAttr('disabled')
            $('#add').removeClass('disabled')
            $('#total').html(total)
        }
    }

    function AddForm() {
        event.preventDefault()
        form_dinamic()
    }

    function DeleteForm(qr) {
        event.preventDefault()
        let number = $(qr).parent().parent().parent().children().children()[1].childNodes[1].childNodes[1].value
        $(qr).parent().parent().parent().remove()
        LetMeHereToCount(number)
    }
</script>