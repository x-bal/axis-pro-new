@extends('layouts.app')

@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-light" style="font-weight: bold;">DETAIL CASE / INSURANCE : {{ $caseList->insurance->name }} / FILE NO : {{ $caseList->file_no }} / INSTRUCTION DATE : {{ Carbon\Carbon::parse($caseList->instruction_date)->format('d/m/Y') }} // TANGGAL INVOICE : //</div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTabs">
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-assigment' ? 'active bg-primary text-white' : '' }} {{ !request()->get('page') ? 'active bg-primary text-white' : '' }}" href="?page=nav-assigment">Assigment Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-expense' ? 'active bg-primary text-white' : '' }}" href="?page=nav-expense">Expense</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-email' ? 'active bg-primary text-white' : '' }}" href="?page=nav-email">Email Transcript</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-file-survey' ? 'active bg-primary text-white' : '' }}" href="?page=nav-file-survey">File Survey</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-claim-document' ? 'active bg-primary text-white' : '' }}" href="?page=nav-claim-document">Claim Documents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-report-1' ? 'active bg-primary text-white' : '' }}" href="?page=nav-report-1">Report 1</a>
                    </li>
                    @if($caseList->ia_status == 1)
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-report-2' ? 'active bg-primary text-white' : '' }} {{ $caseList->ia_status == 1 ? '' : 'disabled' }}" href="{{ $caseList->ia_status == 1 ? '?page=nav-report-2' : '#' }}">Report 2</a>
                    </li>
                    @endif
                    @if($caseList->pr_status == 1)
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-report-3' ? 'active bg-primary text-white' : '' }} {{ $caseList->pr_status == 1 ? '' : 'disabled' }}" href="{{ $caseList->pr_status == 1 ? '?page=nav-report-3' : '#' }}">Report 3</a>
                    </li>
                    @endif
                    @if($caseList->pa_status == 1 || $caseList->ir_st_status == 1)
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-report-4' ? 'active bg-primary text-white' : '' }} {{ $caseList->pa_status == 1 || $caseList->ir_st_status == 1 ? '' : 'disabled' }}" href="{{ $caseList->pa_status == 1 || $caseList->ir_st_status == 1 ? '?page=nav-report-4' : '#' }}">Report 4</a>
                    </li>
                    @endif
                    @if($caseList->ir_status == 1)
                    <li class="nav-item">
                        <a class="nav-link nav-tab r5 {{ request()->get('page') == 'nav-report-5' ? 'active bg-primary text-white' : '' }} {{ $caseList->pa_status == 1 ? '' : 'disabled' }}" href="{{ $caseList->pa_status == 1 ? '?page=nav-report-5' : '#' }}">Report 5</a>
                    </li>
                    @endif
                </ul>

                <div class="tab-content">
                    @if(request()->get('page') == "nav-assigment" || !request()->get('page'))
                    <div class="tab-pane fade show active mt-3" id="nav-assigmnet" aria-labelledby="nav-assigmnet-tab">
                        <h5 class="mb-3">Assigment info</h5>

                        <table width="200" border="1" class="table table-bordered hurufkecil table-striped" style="font-size: 12px;">
                            <tbody>

                                <tr>
                                    <td width="12%">CURRENT STATUS</td>
                                    <td width="2%">:</td>
                                    <td width="31%">
                                        <select name="status" class="form-control" disabled>
                                            <option value="{{ $caseList->status->nama_status }}">{{ $caseList->status->nama_status }}</option>
                                        </select>
                                    </td>
                                    <td width="15%">INSURED</td>
                                    <td width="2%">:</td>
                                    <td width="38%">{{ $caseList->insurance->name }}</td>
                                </tr>
                                <tr>
                                    <td width="12%">FILE NO</td>
                                    <td width="2%">:</td>
                                    <td width="31%">{{ $caseList->file_no }}</td>
                                    <td width="15%">INSURED</td>
                                    <td width="2%">:</td>
                                    <td width="38%">{{ $caseList->insurance->name }}</td>
                                </tr>
                                <tr>
                                    <td>INITIAL ADJUSTER</td>
                                    <td>:</td>
                                    <td>{{ $caseList->adjuster->kode_adjuster }} ({{ $caseList->adjuster->nama_lengkap }})</td>
                                    <td>DOL</td>
                                    <td>:</td>
                                    <td>{{ Carbon\Carbon::parse($caseList->dol)->format('d-M-Y') }}</td>
                                </tr>
                                <tr>
                                    <td>INSURANCE</td>
                                    <td>:</td>
                                    <td>
                                        @foreach($caseList->member as $member)
                                        <p>{{ $caseList->insurance->name }} ({{ $member->share }})</p>
                                        @endforeach
                                    </td>
                                    <td>LOCATION RISK / PROJECT</td>
                                    <td>:</td>
                                    <td>{{ $caseList->risk_location }}</td>
                                </tr>
                                <tr>
                                    <td>BROKER</td>
                                    <td>:</td>
                                    <td><span class="bg-secondary p-2 text-light">{{ $caseList->broker->nama_broker }}</span> </td>
                                    <td>CAUSE OF LOSS</td>
                                    <td>:</td>
                                    <td>{{ $caseList->incident->type_incident }}</td>
                                </tr>
                                <tr>
                                    <td>TYPE OF BUSINESS</td>
                                    <td>:</td>
                                    <td>{{ $caseList->policy->type_policy }}</td>
                                    <td>LEADER POLICY</td>
                                    <td>:</td>
                                    <td>{{ $caseList->no_leader_policy }} | PERIOD BEGIN : {{ Carbon\Carbon::parse($caseList->begin)->format('d-M-Y') }} PERIOD END : {{ Carbon\Carbon::parse($caseList->end)->format('d-M-Y') }} <br> </td>
                                </tr>
                                <tr>
                                    <td>SURVEY DATE</td>
                                    <td>:</td>
                                    <td>{{ $caseList->survey_date }}</td>
                                    <td>LEADER CLAIM NO</td>
                                    <td>:</td>
                                    <td>{{ $caseList->leader_claim_no }}</td>
                                </tr>
                                <tr>
                                    <td>NOW UPDATE</td>
                                    <td>:</td>
                                    <td>{{ $caseList->now_update }}</td>
                                    <td>AGING (DAY)</td>
                                    <td>:</td>
                                    <td>
                                        {{ (int)Carbon\Carbon::parse($caseList->now_update)->format('Ymd') - (int)Carbon\Carbon::parse($caseList->instruction_date)->format('Ymd') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- <h5>Report Issue</h5>
                        <table width="100%" border="1" class="table table-bordered hurufkecil table-striped" style="font-size: 12px;">
                            <tbody>
                                <tr>
                                    <td colspan="2"><strong>IA</strong></td>
                                    <td width="10%">&nbsp;</td>
                                    <td width="10%">&nbsp;</td>
                                    <td colspan="4"><strong>IR</strong></td>
                                    <td width="6%">&nbsp;</td>
                                    <td width="7%">&nbsp;</td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="7%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="11%">&nbsp;</td>
                                    <td width="12%">&nbsp;</td>
                                    <td><strong>PR</strong></td>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><strong>1st</strong></td>
                                    <td colspan="2"><strong>2nd</strong></td>
                                    <td colspan="2"><strong>PA</strong></td>
                                    <td colspan="2"><strong>FR</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>DATE</strong></td>
                                    <td><strong>AMOUNT</strong></td>
                                    <td><strong>DATE</strong></td>
                                    <td><strong>AMOUNT</strong></td>
                                    <td width="8%"><strong>DATE</strong></td>
                                    <td width="8%"><strong>AMOUNT</strong></td>
                                    <td width="7%"><strong>DATE</strong></td>
                                    <td width="9%"><strong>AMOUNT</strong></td>
                                    <td><strong>DATE</strong></td>
                                    <td><strong>AMOUNT</strong></td>
                                    <td><strong>DATE</strong></td>
                                    <td><strong>AMOUNT</strong></td>
                                </tr>
                                <tr>
                                    <td>28/01/2021</td>
                                    <td>663,067.241</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>533.451.424.</td>
                                    <td>06/04/2021</td>
                                    <td>533.451.424</td>
                                </tr>
                            </tbody>
                        </table> -->
                    </div>
                    @endif

                    @if(request()->get('page') == "nav-expense")
                    <div class="tab-pane fade show active mt-3" id="nav-expense" aria-labelledby="nav-expense-tab">
                        <h5 class="mb-3">Expense list</h5>

                        <table width="200" border="0" class="table table-striped">
                            <form action="{{ route('expense.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <tbody>
                                    <tr>
                                        <td width="30%">Upload File</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="60%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                        <td>
                                            <input type="file" name="file_upload">
                                            <br>
                                            @error('file_upload')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success">Import</button>
                                        </td>
                                        <td>
                                            <a href="{{ route('expense.download') }}" class="btn btn-primary"><i class="fas fa-download"></i> Example Format</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>

                        <table width="100%" height="52" border="0" class="table tabelbelang table-bordered table-striped table-hover" style="font-size:12px;">
                            <tbody>
                                <tr>
                                    <td width="3%">No</td>
                                    <td width="15%">Name</td>
                                    <td width="9%">Category</td>

                                    <td width="10%">Date</td>
                                    <td width="53%">Amount</td>
                                </tr>
                                @php
                                $amount = 0;
                                @endphp

                                @foreach($caseList->expense as $expense)
                                <tr>
                                    <td height="25">{{ $loop->iteration }}</td>
                                    <td>{{ $expense->name }}</td>
                                    <td>{{ $expense->category_expense }}</td>
                                    <td>{{ Carbon\Carbon::parse($expense->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $caseList->currency == 'RP' ? 'Rp.' : '$' }} {{ number_format($expense->amount)  }}</td>
                                </tr>
                                @php
                                $amount += $expense->amount
                                @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">Total Amount : </td>
                                    <td>{{ $caseList->currency == 'RP' ? 'Rp.' : '$' }} {{ number_format($amount) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @endif

                    @if(request()->get('page') == "nav-email")
                    <div class="tab-pane fade show active mt-3" id="nav-email" aria-labelledby="nav-email-tab">
                        <h5 class="mb-3">Email Transcript</h5>
                        "******"
                    </div>
                    @endif

                    @if(request()->get('page') == "nav-file-survey")
                    <div class="tab-pane fade show active mt-3" id="nav-file-survey" aria-labelledby="nav-file-survey-tab">
                        <h5>File survey </h5>

                        <form action="{{ route('file-survey.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table width="658" border="0" class="table table-survey mt-3">
                                <tbody>
                                    <tr>
                                        <td width="197">File Upload</td>
                                        <td width="214">Time Upload</td>
                                        <td width="822">Add new</td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                        <td>
                                            <input type="file" name="file_upload[]">

                                            @error('file_upload')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="date" name="time_upload" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                            @error('time_upload')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td><button type="button" class="btn btn-success plus-survey"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td><input type="submit" class="btn btn-success" value="Upload"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>


                        <table width="265" border="0" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>No</td>
                                    <td>File Name</td>
                                    <td width="">Upload date</td>
                                    <td>File size</td>
                                    <td>Action</td>
                                </tr>
                                @foreach($caseList->filesurvey as $filesurvey)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ str_replace('files/file-survey/', '', $filesurvey->file_upload) }}</td>
                                    <td>{{ $filesurvey->time_upload }}</td>
                                    @php
                                    $name = str_replace('files/file-survey/', '', $filesurvey->file_upload);
                                    $file = explode('.',$filesurvey->file_upload);
                                    $ext = $file[1]
                                    @endphp
                                    <td>
                                        @if($ext == 'jpg' || $ext == 'jpeg' ||$ext == 'png')
                                        {{ number_format(filesize(public_path('files/file-survey/'. $name)) / 1048576,2)  }} MB
                                        @else
                                        {{ number_format(\Storage::size($filesurvey->file_upload) / 1048576,2 )}} MB
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('file-survey.show', $filesurvey->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if(request()->get('page') == "nav-claim-document")
                    <div class="tab-pane fade show active mt-3" id="nav-claim-document" aria-labelledby="nav-claim-document-tab">
                        <h5 class="mb-3">Claim Document </h5>

                        <form action="{{ route('claim-document.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table width="658" border="0" class="table table-claim">
                                <tbody>
                                    <tr>
                                        <td width="197">File Upload</td>
                                        <td width="214">Time Upload</td>
                                        <td width="822">Add new</td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                        <td>
                                            <input type="file" name="file_upload[]">
                                            @error('file_upload')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td><input type="date" name="time_upload" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-claim"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td><input type="submit" class="btn btn-success" value="Upload"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>

                        <table width="265" border="0" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="49">No</td>
                                    <td>File Name</td>
                                    <td>Upload date</td>
                                    <td>File size</td>
                                    <td width="280">Action</td>
                                </tr>
                                @foreach($caseList->claimdocuments as $claimdocument)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ str_replace('files/claim-document/', '', $claimdocument->file_upload) }}</td>
                                    <td>{{ $claimdocument->time_upload }}</td>
                                    <td> MB</td>
                                    <td><a href="{{ route('claim-document.show', $claimdocument->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if(request()->get('page') == "nav-report-1")
                    <div class="tab-pane fade show active mt-3" id="nav-report-1" aria-labelledby="nav-report-1-tab">
                        <h5 class="">Report 1 </h5>
                        <table>
                            <tr>
                                <td width="250">Survey Date</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::parse($caseList->survey_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td width="250">Limit</td>
                                <td> : </td>
                                <td>
                                    {{ Carbon\Carbon::parse($caseList->ia_limit)->format('d/m/Y')}} (7 Days)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->ia_limit)->addDay(1)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Now Date</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>You Have Exceed From Report 1</td>
                                <td> : </td>
                                @php
                                $exceed = (int)Carbon\Carbon::now()->format('Ymd') - (int)Carbon\Carbon::parse($caseList->ia_limit)->format('Ymd')
                                @endphp
                                <td>{{ $exceed >= 0 ? $exceed : 0 }} Days</td>
                            </tr>
                            <tr>
                                <td>Date Uploaded</td>
                                <td> : </td>
                                <td>{{ $caseList->ia_date != NULL ? Carbon\Carbon::parse($caseList->ia_date)->format('d/m/Y') : '-'}}</td>
                            </tr>
                        </table>

                        <form action="{{ route('report-satu.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table width="658" border="0" class="table table-1 mt-3">
                                <tbody>
                                    <tr>
                                        <td width="197">File Upload</td>
                                        <td width="214">Time Upload</td>
                                        <td width="822">Add new</td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                        <td>
                                            <input type="file" name="file_upload[]">@error('file_upload')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td><input type="date" name="time_upload" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-1"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td width="197">Ia Amount</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="ia_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->ia_amount ?? '' }}">
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><input type="submit" class="btn btn-success" value="Upload"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>

                        <table width="265" border="0" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="49">No</td>
                                    <td>File Name</td>
                                    <td>Upload date</td>
                                    <td>File size</td>
                                    <td width="280">Action</td>
                                </tr>
                                @foreach($caseList->reportsatu as $reportsatu)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ str_replace('files/report-satu/', '', $reportsatu->file_upload) }}</td>
                                    <td>{{ $reportsatu->time_upload }}</td>
                                    <td> MB</td>
                                    <td><a href="{{ route('report-satu.show', $reportsatu->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- <div class="row">
                            <div class="col-md-3">
                                <select name="status" class="form-control my-3">
                                    <option>OUTSTANDING</option>
                                    <option>CLOSED</option>
                                </select>
                            </div>
                        </div> -->

                    </div>
                    @endif

                    @if(request()->get('page') == "nav-report-2" && $caseList->ia_status == 1)
                    <div class="tab-pane fade show active mt-3" id="nav-report-2" aria-labelledby="nav-report-2-tab">
                        <h5 class="">Report 2 </h5>

                        <table>
                            <tr>
                                <td width="250">Last Update From Report 1</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::parse($caseList->ia_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td width="250">Limit</td>
                                <td> : </td>
                                <td>
                                    {{ Carbon\Carbon::parse($caseList->pr_limit)->format('d/m/Y')}} (14 Days)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->pr_limit)->addDay(1)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Now Date</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>You Have Exceed From Report 2</td>
                                <td> : </td>
                                @php
                                $exceed = (int)Carbon\Carbon::now()->format('Ymd') - (int)Carbon\Carbon::parse($caseList->pr_limit)->format('Ymd')
                                @endphp
                                <td>{{ $exceed >= 0 ? $exceed : 0 }} Days</td>
                            </tr>
                            <tr>
                                <td>Date Uploaded</td>
                                <td> : </td>
                                <td>{{ $caseList->pr_date ? Carbon\Carbon::parse($caseList->pr_date)->format('d/m/Y') : '-'}}</td>
                            </tr>
                        </table>

                        <form action="{{ route('report-dua.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table width="658" border="0" class="table table-2 mt-3">
                                <tbody>
                                    <tr>
                                        <td width="197">File Upload</td>
                                        <td width="214">Time Upload</td>
                                        <td width="822">Add new</td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                        <td>
                                            <input type="file" name="file_upload[]">

                                            @error('file_upload')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td><input type="date" name="time_upload" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-2"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td width="100">Pr Amount</td>
                                    <td width="100">Interim Report</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="pr_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->pr_amount ?? '' }}">
                                        </div>
                                        @error('pr_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <select name="ir_status" id="ir_status" class="form-control">
                                            <option {{ $caseList->ir_status == 0 ? 'selected' : '' }} value="0">No</option>
                                            <option {{ $caseList->ir_status == 1 ? 'selected' : '' }} value="1">Yes</option>
                                        </select>
                                        @error('ir_status')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                @if($caseList->ir_status == 0)
                                <tr>
                                    <td width="100">Date Complete</td>
                                    <td width="100">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <input type="date" name="date_complete" class="form-control" value="{{ $caseList->date_complete ?? '' }}">
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><input type="submit" class="btn btn-success" value="Upload"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>

                        <table width="265" border="0" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="49">No</td>
                                    <td>File Name</td>
                                    <td>Upload date</td>
                                    <td>File size</td>
                                    <td width="280">Action</td>
                                </tr>
                                @foreach($caseList->reportdua as $reportdua)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ str_replace('files/report-dua/', '', $reportdua->file_upload) }}</td>
                                    <td>{{ $reportdua->time_upload }}</td>
                                    <td> MB</td>
                                    <td><a href="{{ route('report-dua.show', $reportdua->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if(request()->get('page') == "nav-report-3" && $caseList->pr_status == 1)
                    <div class="tab-pane fade show active mt-3" id="nav-report-3" aria-labelledby="nav-report-3-tab">
                        <h5 class="">Report 3 </h5>

                        <h6>({{ $caseList->ir_status == 0 ? 'Propose Adjustment' : 'Interim Report'}})</h6>

                        <table>
                            <tr>
                                <td width="250">Last Update From Report 2</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::parse($caseList->pr_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td width="250">Limit</td>
                                <td> : </td>
                                <td>
                                    @if($caseList->ir_status == 0)
                                    {{ Carbon\Carbon::parse($caseList->pa_limit)->format('d/m/Y')}} (14 Days)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->pa_limit)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                    @else
                                    {{ Carbon\Carbon::parse($caseList->ir_st_limit)->format('d/m/Y')}} (14 Days)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->ir_st_limit)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Now Date</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>You Have Exceed From Report 3</td>
                                <td> : </td>
                                @if($caseList->ir_status == 0)
                                @php
                                $exceed = (int)Carbon\Carbon::now()->format('Ymd') - (int)Carbon\Carbon::parse($caseList->pa_limit)->addDay(1)->format('Ymd')
                                @endphp
                                @else
                                @php
                                $exceed = (int)Carbon\Carbon::now()->format('Ymd') - (int)Carbon\Carbon::parse($caseList->ir_st_limit)->addDay(1)->format('Ymd')
                                @endphp
                                @endif
                                <td>{{ $exceed >= 0 ? $exceed : 0 }} Days</td>
                            </tr>
                            <tr>
                                <td>Date Uploaded</td>
                                <td> : </td>
                                <td>
                                    @if($caseList->ir_status == 0)
                                    {{ $caseList->pa_date != NULL ? Carbon\Carbon::parse($caseList->pa_date)->format('d/m/Y') : '-'}}
                                    @else
                                    {{ $caseList->ir_st_date != NULL ? Carbon\Carbon::parse($caseList->ir_st_date)->format('d/m/Y') : '-'}}
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <form action="{{ route('report-tiga.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table width="658" border="0" class="table table-3 mt-3">
                                <tbody>
                                    <tr>
                                        <td width="197">File Upload</td>
                                        <td width="214">Time Upload</td>
                                        <td width="822">Add new</td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                        <td>
                                            <input type="file" name="file_upload[]">
                                            @error('file_upload')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td><input type="date" name="time_upload" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-3"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td>{{ $caseList->ir_status == 0 ? 'Pa Amount' : 'Ir St Amount' }}</td>
                                    <td>{{ $caseList->ir_status == 0 ? '' : 'Ir Nd Amount' }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if($caseList->ir_status == 1)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="ir_st_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->ir_st_amount ?? '' }}">
                                        </div>

                                        @error('ir_st_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                        @else

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="pa_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->pa_amount ?? '' }}">
                                        </div>

                                        @error('pa_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                        @endif
                                    </td>
                                    <td>
                                        @if($caseList->ir_status == 1)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="ir_nd_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->ir_st_amount ?? '' }}">
                                        </div>

                                        @error('ir_nd_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                        @endif
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                @if($caseList->ir_status == 1)
                                <tr>
                                    <td width="100">Date Complete</td>
                                    <td width="100">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <input type="date" name="date_complete" class="form-control" value="{{ $caseList->date_complete ?? '' }}">
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><input type="submit" class="btn btn-success" value="Upload"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>

                        <table width="265" border="0" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="49">No</td>
                                    <td>File Name</td>
                                    <td>Upload date</td>
                                    <td>File size</td>
                                    <td width="280">Action</td>
                                </tr>
                                @foreach($caseList->reporttiga as $reporttiga)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ str_replace('files/report-tiga/', '', $reporttiga->file_upload) }}</td>
                                    <td>{{ $reporttiga->time_upload }}</td>
                                    <td> MB</td>
                                    <td><a href="{{ route('report-tiga.show', $reporttiga->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if($caseList->pa_status == 1 || $caseList->ir_st_status == 1)
                    @if(request()->get('page') == "nav-report-4" )
                    <div class="tab-pane fade show active mt-3" id="nav-report-4" aria-labelledby="nav-report-4-tab">
                        <h5 class="">Report 4 </h5>

                        <h6>({{ $caseList->ir_status == 1 ? 'Propose Adjustment' : 'Final Report'}})</h6>

                        <table>
                            <tr>
                                <td width="250">Last Update From Report 3</td>
                                <td> : </td>
                                <td>{{ $caseList->ir_status == 0 ? Carbon\Carbon::parse($caseList->pa_date)->format('d/m/Y') :Carbon\Carbon::parse($caseList->ir_st_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td width="250">Limit</td>
                                <td> : </td>
                                <td>
                                    @if($caseList->ir_status == 0)
                                    {{ Carbon\Carbon::parse($caseList->fr_limit)->format('d/m/Y')}} (7 Days)
                                    @if((int)Carbon\Carbon::now()->format('Ymd') >= (int)Carbon\Carbon::parse($caseList->fr_limit)->addDay(1)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                    @else
                                    {{ Carbon\Carbon::parse($caseList->pa_limit)->format('d/m/Y')}} (7 Days)
                                    @if((int)Carbon\Carbon::now()->format('Ymd') >= (int)Carbon\Carbon::parse($caseList->pa_limit)->addDay(1)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Now Date</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>You Have Exceed From Report 4</td>
                                <td> : </td>
                                @if($caseList->ir_status == 0)
                                @php
                                $exceed = (int)Carbon\Carbon::now()->format('Ymd') -(int)Carbon\Carbon::parse($caseList->fr_limit)->addDay(1)->format('Ymd')
                                @endphp
                                @else
                                @php
                                $exceed = (int)Carbon\Carbon::now()->format('Ymd') -(int)Carbon\Carbon::parse($caseList->pa_limit)->addDay(1)->format('Ymd')
                                @endphp
                                @endif

                                <td>{{ $exceed >= 0 ? $exceed : 0 }} Days</td>
                            </tr>
                            <tr>
                                <td>Date Uploaded</td>
                                <td> : </td>
                                <td>
                                    @if($caseList->ir_status == 0)
                                    {{ $caseList->fr_date != NULL ? Carbon\Carbon::parse($caseList->fr_date)->format('d/m/Y') : '-'}}
                                    @else
                                    {{ $caseList->pa_date != NULL ? Carbon\Carbon::parse($caseList->pa_date)->format('d/m/Y') : '-'}}
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <form action="{{ route('report-empat.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table width="658" border="0" class="table table-4 mt-3">
                                <tbody>
                                    <tr>
                                        <td width="197">File Upload</td>
                                        <td width="214">Time Upload</td>
                                        <td width="822">Add new</td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                        <td>
                                            <input type="file" name="file_upload[]">
                                            @error('file_upload')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td><input type="date" name="time_upload" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-4"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td>{{ $caseList->ir_status == 0 ? 'Net Adjustment' : 'Pa Amount' }}</td>
                                    <td>{{ $caseList->ir_status == 0 ? 'Gross Adjustment' : '' }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if($caseList->ir_status == 1)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="pa_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->pa_amount ?? '' }}">
                                        </div>

                                        @error('pa_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="fr_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->fr_amount ?? '' }}">
                                        </div>

                                        @error('fr_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                        @endif
                                    </td>
                                    <td>
                                        @if($caseList->ir_status == 0)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="claim_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->claim_amount ?? '' }}">
                                        </div>

                                        @error('claim_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                        @else
                                        &nbsp;
                                        @endif
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><input type="submit" class="btn btn-success" value="Upload"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>

                        <table width="265" border="0" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="49">No</td>
                                    <td>File Name</td>
                                    <td>Upload date</td>
                                    <td>File size</td>
                                    <td width="280">Action</td>
                                </tr>
                                @foreach($caseList->reportempat as $reportempat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ str_replace('files/report-empat/', '', $reportempat->file_upload) }}</td>
                                    <td>{{ $reportempat->time_upload }}</td>
                                    <td> MB</td>
                                    <td><a href="{{ route('report-empat.show', $reportempat->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @endif

                    @if($caseList->ir_status == 1 && $caseList->pa_status == 1)
                    @if(request()->get('page') == "nav-report-5")
                    <div class="tab-pane fade show active mt-3" id="nav-report-5" aria-labelledby="nav-report-5-tab">
                        <h5 class="">Report 5 </h5>

                        <h6>(Final Report)</h6>

                        <table>
                            <tr>
                                <td width="250">Last Update From Report 4</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::parse($caseList->pa_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td width="250">Limit</td>
                                <td> : </td>
                                <td>
                                    {{ Carbon\Carbon::parse($caseList->fr_limit)->format('d/m/Y')}} (7 Days)
                                    @if((int)Carbon\Carbon::now()->format('Ymd') >= (int)Carbon\Carbon::parse($caseList->fr_limit)->addDay(1)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Now Date</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>You Have Exceed From Report 4</td>
                                <td> : </td>
                                @php
                                $exceed = (int)Carbon\Carbon::now()->format('Ymd') - (int)Carbon\Carbon::parse($caseList->fr_limit)->format('Ymd')
                                @endphp
                                <td>{{ $exceed >= 0 ? $exceed : 0 }} Days</td>
                            </tr>
                            <tr>
                                <td>Date Uploaded</td>
                                <td> : </td>
                                <td>
                                    {{ $caseList->fr_date != NULL ? Carbon\Carbon::parse($caseList->pa_date)->format('d/m/Y') : '-'}}
                                </td>
                            </tr>
                        </table>

                        <form action="{{ route('report-lima.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table width="658" border="0" class="table table-5 mt-3">
                                <tbody>
                                    <tr>
                                        <td width="197">File Upload</td>
                                        <td width="214">Time Upload</td>
                                        <td width="822">Add new</td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                        <td>
                                            <input type="file" name="file_upload[]">
                                            @error('file_upload')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td><input type="date" name="time_upload" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-5"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td>Net Adjustment</td>
                                    <td>Gross Adjustment</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="fr_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->fr_amount ?? '' }}">
                                        </div>

                                        @error('fr_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{ $caseList->currency == 'RP' ? 'Rp' : '$' }}</span>
                                            </div>
                                            <input type="number" name="claim_amount" class="form-control" aria-describedby="basic-addon1" value="{{ $caseList->claim_amount ?? '' }}">
                                        </div>

                                        @error('claim_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><input type="submit" class="btn btn-success" value="Upload"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>

                        <table width="265" border="0" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td width="49">No</td>
                                    <td>File Name</td>
                                    <td>Upload date</td>
                                    <td>File size</td>
                                    <td width="280">Action</td>
                                </tr>
                                @foreach($caseList->reportlima as $reportlima)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ str_replace('files/report-lima/', '', $reportlima->file_upload) }}</td>
                                    <td>{{ $reportlima->time_upload }}</td>
                                    <td> MB</td>
                                    <td><a href="{{ route('report-lima.show', $reportlima->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @endif
                </div>

                <div class="button mt-3">
                    <a href="{{ route('case-list.index') }}" class="btn btn-success">Kembali</a>
                    <a href="#" class="btn btn-primary">Cetak Invoice</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop



@section('footer')
<script src="https://code.jquery.com/jquery-1.7.2.min.js" integrity="sha256-R7aNzoy2gFrVs+pNJ6+SokH04ppcEqJ0yFLkNGoFALQ=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        let tr = `<tr>
                <td><input type="file" name="file_upload[]"></td>
                <td><input type="date" name="time_upload" class="form-control" id="" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"></td>
                <td><button type="button" class="btn btn-danger remove-survey"><i class="fas fa-times"></i></button></td>
            </tr>`;

        $(".plus-survey").on('click', function() {
            $(".table-survey").append(tr)
        })

        $(".plus-claim").on('click', function() {
            $(".table-claim").append(tr)
        })

        $(".plus-1").on('click', function() {
            $(".table-1").append(tr)
        })

        $(".plus-2").on('click', function() {
            $(".table-2").append(tr)
        })

        $(".plus-3").on('click', function() {
            $(".table-3").append(tr)
        })

        $(".plus-4").on('click', function() {
            $(".table-4").append(tr)
        })

        $(".plus-5").on('click', function() {
            $(".table-5").append(tr)
        })

        $(".remove-survey").live('click', function() {
            $(this).parent().parent().remove();
        })
        $(".remove-claim").live('click', function() {
            $(this).parent().parent().remove();
        })
        $(".remove-1").live('click', function() {
            $(this).parent().parent().remove();
        })
        $(".remove-2").live('click', function() {
            $(this).parent().parent().remove();
        })
        $(".remove-3").live('click', function() {
            $(this).parent().parent().remove();
        })
        $(".remove-4").live('click', function() {
            $(this).parent().parent().remove();
        })
        $(".remove-5").live('click', function() {
            $(this).parent().parent().remove();
        })
    })

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#ir_status").on('change', function() {
            let id = "{{ $caseList->id }}";
            let status = $(this).val();

            $.ajax({
                method: 'POST',
                type: 'POST',
                url: '/case-list/ir-status',
                data: {
                    id: id,
                    status: status,
                },
                success: function(result) {
                    iziToast.success({
                        title: 'Success',
                        message: result.message,
                        position: 'topRight',
                    });

                    if (result.case_list.ir_status == 1) {
                        $("#myTabs").append(`<li class="nav-item">
                        <a class="nav-link nav-tab r5 {{ request()->get('page') == 'nav-report-5' ? 'active bg-primary text-white' : '' }}" href="{{ $caseList->pa_status == 1 ? '?page=nav-report-5' : '#' }}">Report 5</a>
                    </li>`)
                    } else {
                        $(".r5").remove()
                    }
                }
            })
        });


        // $(".status").on('change', function() {
        //     let id = "{{ $caseList->id }}";
        //     let status = $(this).val();

        //     $.ajax({
        //         method: 'POST',
        //         type: 'POST',
        //         url: '/case-list/status',
        //         data: {
        //             id: id,
        //             status: status,
        //         },
        //         success: function(result) {
        //             iziToast.success({
        //                 title: 'Success',
        //                 message: result.message,
        //                 position: 'topRight',
        //             });
        //         }
        //     })
        // })
    })
</script>
@stop