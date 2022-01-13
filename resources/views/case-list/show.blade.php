@extends('layouts.app')

@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-light" style="font-weight: bold; background-color: #193C8F !important;">DETAIL CASE / INSURANCE : {{ $caseList->insurance->name }} / FILE NO : {{ $caseList->file_no }} / INSTRUCTION DATE : {{ Carbon\Carbon::parse($caseList->instruction_date)->format('d/m/Y') }}</div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTabs">
                    <li class="nav-item">
                        <a class="nav-link nav-tab {{ request()->get('page') == 'nav-assignment' ? 'active bg-primary text-white' : '' }} {{ !request()->get('page') ? 'active bg-primary text-white' : '' }}" href="?page=nav-assignment">Assignment Info</a>
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
                    @if($caseList->ir_status == 1 && $caseList->pa_status == 1)
                    <li class="nav-item">
                        <a class="nav-link nav-tab r5 {{ request()->get('page') == 'nav-report-5' ? 'active bg-primary text-white' : '' }} {{ $caseList->pa_status == 1 ? '' : 'disabled' }}" href="{{ $caseList->pa_status == 1 ? '?page=nav-report-5' : '#' }}">Report 5</a>
                    </li>
                    @endif
                </ul>

                <div class="tab-content">
                    @if(request()->get('page') == "nav-assignment" || !request()->get('page'))
                    <div class="tab-pane fade show active mt-3" id="nav-assigmnet" aria-labelledby="nav-assigmnet-tab">
                        <h5 class="mb-3">Assignment info</h5>
                        <table class="mb-3">
                            <tbody>
                                <tr>
                                    <td width="200px">History Last Update</td>
                                    <td>:</td>
                                    <td>{{ $caseList->history->nama_lengkap ?? 'null' }} - {{ $caseList->history->email ?? 'null' }}</td>
                                </tr>
                                <tr>
                                    <td>History Date</td>
                                    <td>:</td>
                                    <td>{{ Carbon\Carbon::parse($caseList->history_date)->format('d/m/y H:i:s') }} - {{ Carbon\Carbon::parse($caseList->history_date)->diffForHumans() }}</td>
                                </tr>
                            </tbody>
                        </table>
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
                                    <td>{{ Carbon\Carbon::parse($caseList->dol)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>INSURANCE</td>
                                    <td>:</td>
                                    <td>
                                        @foreach($caseList->member as $member)
                                        <p>{{ App\Models\Client::find($member->member_insurance)->name ?? 'Kosong' }} ({{ $member->share }}) - @if($member->is_leader) <strong class="text-primary">Leader</strong> @else <strong class="text-secondary">Member</strong> @endif</p>
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
                                    <td>LEADER POLICY NO</td>
                                    <td>:</td>
                                    <td>{{ $caseList->no_leader_policy }} | PERIOD BEGIN : {{ Carbon\Carbon::parse($caseList->begin)->format('d/m/Y') }} PERIOD END : {{ Carbon\Carbon::parse($caseList->end)->format('d/m/Y') }} <br> </td>
                                </tr>
                                <tr>
                                    <td>SURVEY DATE</td>
                                    <td>:</td>
                                    <td>{{ Carbon\Carbon::parse($caseList->survey_date)->format('d/m/Y') }}</td>
                                    <td>LEADER CLAIM NO</td>
                                    <td>:</td>
                                    <td>{{ $caseList->leader_claim_no }} - <strong>{{ $caseList->no_ref_surat_asuransi }}</strong></td>
                                </tr>
                                <tr>
                                    <td>NOW UPDATE</td>
                                    <td>:</td>
                                    <td>{{ Carbon\Carbon::parse($caseList->now_update)->format('d/m/Y') }}</td>
                                    <td>AGING (DAY)</td>
                                    <td>:</td>
                                    <td>
                                        {{ Carbon\Carbon::parse($caseList->instruction_date)->diff($caseList->file_status_id == 5 ? $caseList->now_update : Carbon\Carbon::now())->d  }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>CLAIM AMOUNT</td>
                                    <td>:</td>
                                    <td>
                                        {{ $caseList->currency }} {{ number_format($caseList->claim_amount, 0, ',','.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>LETTER OF APPOINTMENT</td>
                                    <td>:</td>
                                    <td><a href="{{ route('caselist.penunjukan', $caseList->id) }}" class="btn btn-danger">LETTER OF APPOINTMENT</a></td>
                                    <td>POLICY SCHEDULE OR COPY POLICY</td>
                                    <td>:</td>
                                    <td><a href="{{ route('caselist.copyPolice', $caseList->id) }}" class="btn btn-info">POLICY SCHEDULE OR COPY POLICY</a></td>
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

                        @if(auth()->user()->hasRole('admin'))
                        <div class="table-responsive">
                            <table width="200" border="0" class="table table-striped">
                                <tbody>
                                    <form action="{{ route('expense.import') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <tr>
                                            <td>Upload File</td>
                                            <td>&nbsp;</td>
                                            <td colspan="5">&nbsp;</td>
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
                                            <td colspan="5">
                                                <button type="submit" class="btn btn-success">Import</button>
                                                <a href="{{ route('expense.download') }}" class="btn btn-primary"><i class="fas fa-download"></i> Example Format</a>
                                            </td>
                                        </tr>
                                    </form>
                                    <tr>
                                        <td colspan="7">
                                            Add Expense
                                        </td>
                                    </tr>

                                    <form action="{{ route('expense.store') }}" method="post">
                                        @csrf
                                        <tr>
                                            <input type="hidden" name="case_list_id" value="{{ $caseList->id }}">
                                            <input type="hidden" name="expense_id" id="expense_id" value="">
                                            <td>
                                                <input type="text" name="name" class="form-control" placeholder="Name" id="name">
                                                @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>
                                            <td>
                                                <select name="adjuster" id="adjuster" class="form-control">
                                                    <option disabled selected>- Choose Adjuster -</option>
                                                    @foreach($adjusters as $adjuster)
                                                    <option value="{{ $adjuster->kode_adjuster }}">{{ $adjuster->nama_lengkap }} ({{ $adjuster->kode_adjuster }})</option>
                                                    @endforeach
                                                </select>
                                                @error('adjuster')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>
                                            <td>
                                                <select name="category" id="category" class="form-control">
                                                    <option disabled selected>- Choose Category -</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{ $category->nama_kategory }}">{{ $category->nama_kategory }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="number" name="qty" id="qty" class="form-control" placeholder="Qty">
                                                @error('qty')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" id="amount" name="amount" class="form-control amount_expense" placeholder="Amount" autocomplete="off">
                                                @error('amount')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>

                                            <td>
                                                <input type="text" name="tanggal" id="tgl_expense" class="form-control tgl_expense" autocomplete="off" placeholder="dd/mm/yyyy">
                                                @error('tanggal')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                        @endif

                        @if($caseList->is_expense == 1)
                        <a href="{{ route('caselist.expense', $caseList->id) }}" class="btn btn-primary my-3"><i class="fas fa-file-pdf"></i> Download</a>
                        @endif

                        <table id="table-expense" width="100%" class="table table-bordered table-striped table-hover" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Adjuster</td>
                                    <td>Name</td>
                                    <td>Category</td>
                                    <td>Date</td>
                                    <td>Qty</td>
                                    <td>Amount</td>
                                    <td>Total</td>
                                    <td>Type Invoice</td>
                                    @if(auth()->user()->hasRole('admin'))
                                    <td>Action</td>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                $amount = 0;
                                $total = 0;
                                @endphp

                                @foreach($caseList->expense as $expense)
                                <tr>
                                    <td height="25">{{ $loop->iteration }}</td>
                                    <td>{{ $expense->adjuster }}</td>
                                    <td>{{ $expense->name }}</td>
                                    <td>{{ $expense->category_expense }}</td>
                                    <td>{{ Carbon\Carbon::parse($expense->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $expense->qty }}</td>
                                    <td>{{ $caseList->currency == 'IDR' ? 'Rp.' : '$' }} {{ number_format($expense->amount, 2)  }}</td>
                                    <td>{{ $caseList->currency == 'IDR' ? 'Rp.' : '$' }} {{ number_format($expense->total, 2)  }}</td>
                                    <td>{{ $expense->is_active == 0 ? '-' : '' }}
                                        {{ $expense->is_active == 1 ? 'Interim' : '' }}
                                        {{ $expense->is_active == 2 ? 'Final' : '' }}
                                    </td>
                                    @if(auth()->user()->hasRole('admin'))
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-expense @if($expense->is_active == 1) d-none @endif" data-id="{{ $expense->id }}" data-toggle="modal" data-target="#modalExpense"><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('expense.destroy', $expense->id) }}" method="post" onclick="return confirm('Are you sure to delete this expense ?')" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @php
                                $amount += $expense->amount;
                                $total += $expense->total;
                                @endphp
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="6">Total Amount : </td>
                                    <td>{{ $caseList->currency == 'IDR' ? 'Rp.' : '$' }} {{ number_format($amount, 2) }}</td>
                                    <td>{{ $caseList->currency == 'IDR' ? 'Rp.' : '$' }} {{ number_format($total, 2) }}</td>
                                    <td></td>
                                    @if(auth()->user()->hasRole('admin'))
                                    <td></td>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @endif

                    @if(request()->get('page') == "nav-email")
                    <div class="tab-pane fade show active mt-3" id="nav-email" aria-labelledby="nav-email-tab">
                        <h5 class="mb-3">Email Transcript</h5>
                        @if(auth()->user()->hasRole('adjuster') && $caseList->is_transcript != 2)
                        <a href="{{ route('caselist.transcript', $caseList->id) }}" class="btn btn-success mb-3"><i class="fas fa-exchange-alt"></i> Transcript</a>
                        @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subject</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(auth()->user()->hasRole('adjuster') && $caseList->is_transcript != 2 && $messages != null)
                                @foreach($messages as $message)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $message->getSubject()  }}</td>
                                    <td><a class="btn btn-sm btn-info text-white" href="/gmails/{{ $message->getId() }}/show/{{ $caseList->id }}">Detail</a></td>
                                </tr>
                                @endforeach
                                @elseif($caseList->is_transcript != 0 && $caseList->file_status_id == 5)
                                @foreach($gmails as $gmail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $gmail->subject  }}</td>
                                    <td><a class="btn btn-sm btn-info text-white" href="/gmails/{{ $gmail->id }}/show/{{ $caseList->id }}">Detail</a></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
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
                                            <input type="text" autocomplete="off" name="time_upload" class="form-control time_up" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}">
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
                                    <td>{{ Carbon\Carbon::parse($filesurvey->time_upload)->format('d/m/Y') }}</td>
                                    @php
                                    $name = str_replace('files/file-survey/', '', $filesurvey->file_upload);
                                    $file = explode('.',$filesurvey->file_upload);
                                    $ext = $file[1]
                                    @endphp
                                    <td>
                                        @if($ext == 'jpg' || $ext == 'jpeg' ||$ext == 'png')
                                        {{ number_format(\File::size($filesurvey->file_upload) / 1048576,2)  }} MB
                                        @else
                                        {{ number_format(\Storage::size($filesurvey->file_upload) / 1048576,2 )}} MB
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('file-survey.show', $filesurvey->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                                        <form action="{{ route('file-survey.destroy', $filesurvey->id) }}" method="post" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this file ?')"><i class="fas fa-trash"></i></button>
                                        </form>
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
                                        <td><input type="text" autocomplete="off" name="time_upload" class="form-control time_up" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
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
                                    <td>{{ Carbon\Carbon::parse($claimdocument->time_upload)->format('d/m/Y') }}</td>
                                    @php
                                    $name = str_replace('files/claim-document/', '', $claimdocument->file_upload);
                                    $file = explode('.',$claimdocument->file_upload);
                                    $ext = $file[1]
                                    @endphp
                                    <td>
                                        @if($ext == 'jpg' || $ext == 'jpeg' ||$ext == 'png')
                                        {{ number_format(\File::size($claimdocument->file_upload) / 1048576,2)  }} MB
                                        @else
                                        {{ number_format(\Storage::size($claimdocument->file_upload) / 1048576,2 )}} MB
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('claim-document.show', $claimdocument->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                                        <form action="{{ route('claim-document.destroy', $claimdocument->id) }}" method="post" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this file ?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
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
                                    @if($caseList->ia_status == 0 && Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->ia_limit)->addDay(1)->format('Ymd'))
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
                                $exceed = Carbon\Carbon::parse($caseList->ia_limit)->diff(Carbon\Carbon::now())->d
                                @endphp
                                <td>
                                    @if($caseList->ia_status == 0)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->ia_limit)->format('Ymd'))
                                    {{ $exceed }}
                                    @else
                                    0
                                    @endif
                                    @else
                                    Finish
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Date Uploaded</td>
                                <td> : </td>
                                <td>{{ $caseList->ia_date != NULL ? Carbon\Carbon::parse($caseList->ia_date)->format('d/m/Y') : '-'}}</td>
                            </tr>
                            <tr>
                                <td>Policy Schedule or Copy Policy</td>
                                <td> : </td>
                                <td>
                                    <a href="{{ route('case-list.edit', $caseList->id) }}" class="btn btn-sm btn-{{ $caseList->copy_polis == null ? 'danger' : 'success' }}">{{ $caseList->copy_polis == null ? 'Please Upload File' : 'Update File' }}</a>
                                </td>
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
                                        <td><input type="text" autocomplete="off" name="time_upload" class="form-control time_up" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-1"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td width="197">IA Amount</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->ia_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->ia_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" id="" name="ia_amount" class="form-control ia_amount" aria-describedby="basic-addon1" value="{{ number_format($caseList->ia_amount, 0, ',', '.') ?? '' }}">
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
                                    <td>{{ Carbon\Carbon::parse($reportsatu->time_upload)->format('d/m/Y') }}</td>
                                    @php
                                    $name = str_replace('files/report-satu/', '', $reportsatu->file_upload);
                                    $file = explode('.',$reportsatu->file_upload);
                                    $ext = $file[1]
                                    @endphp
                                    <td>
                                        @if($ext == 'jpg' || $ext == 'jpeg' ||$ext == 'png')
                                        {{ number_format(\File::size($reportsatu->file_upload) / 1048576,2)  }} MB
                                        @else
                                        {{ number_format(\Storage::size($reportsatu->file_upload) / 1048576,2 )}} MB
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('report-satu.show', $reportsatu->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                                        <form action="{{ route('report-satu.destroy', $reportsatu->id) }}" method="post" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this file ?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
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
                                    @if($caseList->pr_status == 0 && Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->pr_limit)->addDay(1)->format('Ymd'))
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
                                $exceed = Carbon\Carbon::parse($caseList->pr_limit)->diff(Carbon\Carbon::now())->d
                                @endphp
                                <td>
                                    @if($caseList->pr_status == 0)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->pr_limit)->format('Ymd'))
                                    {{ $exceed }}
                                    @else
                                    0
                                    @endif
                                    @else
                                    Finish
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Date Uploaded</td>
                                <td> : </td>
                                <td>{{ $caseList->pr_date ? Carbon\Carbon::parse($caseList->pr_date)->format('d/m/Y') : '-'}}</td>
                            </tr>
                            <tr>
                                <td>Policy Schedule or Copy Policy</td>
                                <td> : </td>
                                <td>
                                    <a href="{{ route('case-list.edit', $caseList->id) }}" class="btn btn-sm btn-{{ $caseList->copy_polis == null ? 'danger' : 'success' }}">{{ $caseList->copy_polis == null ? 'Please Upload File' : 'Update File' }}</a>
                                </td>
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
                                        <td><input type="text" autocomplete="off" name="time_upload" class="form-control time_up" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-2"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td width="100">PR Amount</td>
                                    <td width="100">Interim Report</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-prepend">
                                                    <select name="curr" id="curr" class="form-control curr">
                                                        <option {{ $caseList->pr_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                        <option {{ $caseList->pr_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="text" name="pr_amount" class="form-control pr_amount" aria-describedby="basic-addon1" value="{{ number_format( $caseList->pr_amount, 0, ',', '.') ?? '' }}">
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
                                    <td width="100">Date Report</td>
                                    <td width="100">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" name="date_complete" class="form-control time_up" value="{{ Carbon\Carbon::parse($caseList->date_complete)->format('d/m/Y') ?? '' }}">
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
                                    <td>{{ Carbon\Carbon::parse($reportdua->time_upload)->format('d/m/Y') }}</td>
                                    @php
                                    $name = str_replace('files/report-dua/', '', $reportdua->file_upload);
                                    $file = explode('.',$reportdua->file_upload);
                                    $ext = $file[1]
                                    @endphp
                                    <td>
                                        @if($ext == 'jpg' || $ext == 'jpeg' ||$ext == 'png')
                                        {{ number_format(\File::size($reportdua->file_upload) / 1048576,2)  }} MB
                                        @else
                                        {{ number_format(\Storage::size($reportdua->file_upload) / 1048576,2 )}} MB
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('report-dua.show', $reportdua->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                                        <form action="{{ route('report-dua.destroy', $reportdua->id) }}" method="post" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this file ?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
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
                                    @if($caseList->pa_status == 0 && Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->pa_limit)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                    @else
                                    {{ Carbon\Carbon::parse($caseList->ir_st_limit)->format('d/m/Y')}} (14 Days)
                                    @if($caseList->ir_st_status == 0 && Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->ir_st_limit)->format('Ymd'))
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
                                $exceed = Carbon\Carbon::parse($caseList->pa_limit)->diff(Carbon\Carbon::now())->d
                                @endphp
                                <td>
                                    @if($caseList->pa_status == 0)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->pa_limit)->format('Ymd'))
                                    {{ $exceed }}
                                    @else
                                    0
                                    @endif
                                    @else
                                    Finish
                                    @endif
                                </td>
                                @else
                                @php
                                $exceed = Carbon\Carbon::parse($caseList->ir_st_limit)->diff(Carbon\Carbon::now())->d
                                @endphp
                                <td>
                                    @if($caseList->ir_st_status == 0)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->ir_st_limit)->format('Ymd'))
                                    {{ $exceed }}
                                    @else
                                    0
                                    @endif
                                    @else
                                    Finish
                                    @endif
                                </td>
                                @endif
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
                            <tr>
                                <td>Policy Schedule or Copy Policy</td>
                                <td> : </td>
                                <td>
                                    <a href="{{ route('case-list.edit', $caseList->id) }}" class="btn btn-sm btn-{{ $caseList->copy_polis == null ? 'danger' : 'success' }}">{{ $caseList->copy_polis == null ? 'Please Upload File' : 'Update File' }}</a>
                                </td>
                            </tr>
                        </table>

                        <form action="{{ route('report-tiga.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table width="658" border="0" class="table table-3 mt-3">
                                <tbody>
                                    <tr>
                                        <td width="197">File Upload</td>
                                        <td width="300">Time Upload</td>
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
                                        <td><input type="text" autocomplete="off" name="time_upload" class="form-control time_up" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-3"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td>{{ $caseList->ir_status == 0 ? 'PA Amount' : 'IR St Amount' }}</td>
                                    <td>{{ $caseList->ir_status == 0 ? '' : 'IR Nd Amount' }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if($caseList->ir_status == 1)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->ir_st_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->ir_st_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="ir_st_amount" class="form-control ir_st_amount" aria-describedby="basic-addon1" value="{{number_format( $caseList->ir_st_amount, 0, ',', '.') ?? '' }}">
                                        </div>

                                        @error('ir_st_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                        @else

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->pa_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->pa_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="pa_amount" class="form-control pa_amount" aria-describedby="basic-addon1" value="{{ number_format( $caseList->pa_amount, 0, ',', '.') ?? '' }}">
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
                                                <select name="curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->ir_nd_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->ir_nd_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="ir_nd_amount" class="form-control ir_nd_amount" aria-describedby="basic-addon1" value="{{ number_format( $caseList->ir_nd_amount, 0, ',', '.') ?? '' }}">
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
                                    <td width="100">Date Report</td>
                                    <td width="100">Professional Service</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" name="date_complete" class="form-control time_up" value="{{ Carbon\Carbon::parse($caseList->date_complete)->format('d/m/Y') ?? '' }}">
                                        </div>
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasRole('admin'))
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->ps_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->ps_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="professional_service" class="form-control professional_service" aria-describedby="basic-addon1" value="{{ number_format( $caseList->professional_service, 0, ',', '.') ?? '' }}">
                                        </div>
                                        @endif
                                    </td>
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
                                    <td>{{ Carbon\Carbon::parse($reporttiga->time_upload)->format('d/m/Y') }}</td>
                                    @php
                                    $name = str_replace('files/report-tiga/', '', $reporttiga->file_upload);
                                    $file = explode('.',$reporttiga->file_upload);
                                    $ext = $file[1]
                                    @endphp
                                    <td>
                                        @if($ext == 'jpg' || $ext == 'jpeg' ||$ext == 'png')
                                        {{ number_format(\File::size($reporttiga->file_upload) / 1048576,2)  }} MB
                                        @else
                                        {{ number_format(\Storage::size($reporttiga->file_upload) / 1048576,2 )}} MB
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('report-tiga.show', $reporttiga->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                                        <form action="{{ route('report-tiga.destroy', $reporttiga->id) }}" method="post" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this file ?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
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
                                    @if($caseList->fr_status == 0 && (int)Carbon\Carbon::now()->format('Ymd') >= (int)Carbon\Carbon::parse($caseList->fr_limit)->addDay(1)->format('Ymd'))
                                    <small class="text-danger">*You Have Exceeded From Limit</small>
                                    @endif
                                    @else
                                    {{ Carbon\Carbon::parse($caseList->pa_limit)->format('d/m/Y')}} (7 Days)
                                    @if($caseList->pa_status == 0 && (int)Carbon\Carbon::now()->format('Ymd') >= (int)Carbon\Carbon::parse($caseList->pa_limit)->addDay(1)->format('Ymd'))
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
                                $exceed = Carbon\Carbon::parse($caseList->fr_limit)->diff(Carbon\Carbon::now())->d
                                @endphp
                                <td>
                                    @if($caseList->fr_status == 0)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->fr_limit)->format('Ymd'))
                                    {{ $exceed }}
                                    @else
                                    0
                                    @endif
                                    @else
                                    Finish
                                    @endif
                                </td>
                                @else
                                @php
                                $exceed = Carbon\Carbon::parse($caseList->pa_limit)->diff(Carbon\Carbon::now())->d
                                @endphp
                                <td>
                                    @if($caseList->pa_status == 0)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->pa_limit)->format('Ymd'))
                                    {{ $exceed }}
                                    @else
                                    0
                                    @endif
                                    @else
                                    Finish
                                    @endif
                                </td>
                                @endif
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
                                        <td><input type="text" autocomplete="off" name="time_upload" class="form-control time_up" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-4"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td>{{ $caseList->ir_status == 0 ? 'Net Adjustment' : 'PA Amount' }}</td>
                                    <td>{{ $caseList->ir_status == 0 ? 'Gross Adjustment' : '' }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if($caseList->ir_status == 1)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->pa_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->pa_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="pa_amount" class="form-control pa_amount" aria-describedby="basic-addon1" value="{{ number_format( $caseList->pa_amount, 0, ',', '.') ?? '' }}">
                                        </div>

                                        @error('pa_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                        @else
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->fr_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->fr_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="fr_amount" class="form-control fr_amount" aria-describedby="basic-addon1" value="{{ number_format( $caseList->fr_amount, 0, ',', '.') ?? '' }}">
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
                                                <select name="claim_curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->claim_amount_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->claim_amount_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="claim_amount" class="form-control claim_amount" aria-describedby="basic-addon1" value="{{ number_format($caseList->claim_amount, 0, ',', '.') ?? '' }}">
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
                                    <td>{{ Carbon\Carbon::parse($reportempat->time_upload)->format('d/m/Y') }}</td>
                                    @php
                                    $name = str_replace('files/report-empat/', '', $reportempat->file_upload);
                                    $file = explode('.',$reportempat->file_upload);
                                    $ext = $file[1]
                                    @endphp
                                    <td>
                                        @if($ext == 'jpg' || $ext == 'jpeg' ||$ext == 'png')
                                        {{ number_format(\File::size($reportempat->file_upload) / 1048576,2)  }} MB
                                        @else
                                        {{ number_format(\Storage::size($reportempat->file_upload) / 1048576,2 )}} MB
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('report-empat.show', $reportempat->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                                        <form action="{{ route('report-empat.destroy', $reportempat->id) }}" method="post" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this file ?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
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
                                    @if($caseList->fr_status == 0 && (int)Carbon\Carbon::now()->format('Ymd') >= (int)Carbon\Carbon::parse($caseList->fr_limit)->addDay(1)->format('Ymd'))
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
                                $exceed = Carbon\Carbon::parse($caseList->fr_limit)->diff(Carbon\Carbon::now())->d
                                @endphp
                                <td>
                                    @if($caseList->fr_status == 0)
                                    @if(Carbon\Carbon::now()->format('Ymd') >= Carbon\Carbon::parse($caseList->fr_limit)->format('Ymd'))
                                    {{ $exceed }}
                                    @else
                                    0
                                    @endif
                                    @else
                                    Finish
                                    @endif
                                </td>
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
                                        <td>&nbsp;</td>
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
                                        <td colspan="2"><input type="text" autocomplete="off" name="time_upload" class="form-control time_up" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
                                        <td><button type="button" class="btn btn-success plus-5"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td>Net Adjustment</td>
                                    <td>Gross Adjustment</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->fr_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->fr_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="fr_amount" class="form-control fr_amount" aria-describedby="basic-addon1" value="{{ number_format( $caseList->fr_amount, 0, ',', '.') ?? '' }}">
                                        </div>

                                        @error('fr_amount')
                                        <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td colspan="2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="claim_curr" id="curr" class="form-control curr">
                                                    <option {{ $caseList->claim_amount_curr == 'IDR' ? 'selected' : '' }} value="IDR">IDR</option>
                                                    <option {{ $caseList->claim_amount_curr == 'USD' ? 'selected' : '' }} value="USD">USD</option>
                                                </select>
                                            </div>
                                            <input type="text" name="claim_amount" class="form-control claim_amount" aria-describedby="basic-addon1" value="{{ number_format( $caseList->claim_amount, 0, ',', '.') ?? '' }}">
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
                                    <td>{{ Carbon\Carbon::parse($reportlima->time_upload)->format('d/m/Y') }}</td>
                                    @php
                                    $name = str_replace('files/report-lima/', '', $reportlima->file_upload);
                                    $file = explode('.',$reportlima->file_upload);
                                    $ext = $file[1]
                                    @endphp
                                    <td>
                                        @if($ext == 'jpg' || $ext == 'jpeg' ||$ext == 'png')
                                        {{ number_format(\File::size($reportlima->file_upload) / 1048576,2)  }} MB
                                        @else
                                        {{ number_format(\Storage::size($reportlima->file_upload) / 1048576,2 )}} MB
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('report-lima.show', $reportlima->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></a>
                                        <form action="{{ route('report-lima.destroy', $reportlima->id) }}" method="post" style="display: inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this file ?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @endif
                </div>

                <div class="button mt-3 d-flex">
                    <a href="{{ route('case-list.index') }}" class="btn btn-success mr-2">Kembali</a>
                    @if(request()->get('page') == "nav-assignment" || !request()->get('page'))
                    <a href="{{ route('caselist.assignment', $caseList->id) }}" class="btn btn-info">Cetak Assignment</a>
                    @endif

                    @if(request()->get('page') == "nav-report-1" || request()->get('page') == "nav-report-2" && $caseList->file_status_id != 5)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCloseCase">Close Case</button>
                    @endif

                    @if(request()->get('page') == "nav-report-1" || request()->get('page') == "nav-report-2" && $caseList->file_status_id != 5)
                    <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#modalInstruction">Instruction Closed</button>
                    @endif

                    @if($caseList->ir_status == 0)
                    @if(request()->get('page') == "nav-report-3" && $caseList->file_status_id != 5)
                    <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#modalInstruction">Instruction Closed</button>
                    @endif
                    @endif

                    @if($caseList->ir_status == 1)
                    @if(request()->get('page') == "nav-report-4" && $caseList->file_status_id != 5)
                    <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#modalInstruction">Instruction Closed</button>
                    @endif
                    @endif

                    @if($caseList->fr_status == 1 && $caseList->ir_status == 0 && $caseList->is_ready == 0)
                    @if(request()->get('page') == "nav-report-4" )
                    <form action="{{ route('case-list.invoice', $caseList->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="is_ready" value="2">
                        <button type="submit" class="btn btn-primary">Cetak Invoice</button>
                    </form>
                    @endif
                    @endif

                    @if($caseList->ir_status == 1 && $caseList->fr_status == 1 && $caseList->is_ready == 1)
                    @if(request()->get('page') == "nav-report-5")
                    <form action="{{ route('case-list.invoice', $caseList->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="is_ready" value="2">
                        <button type="submit" class="btn btn-primary">Cetak Invoice</button>
                    </form>
                    @endif
                    @endif

                    @if($caseList->ir_status == 1 && $caseList->ir_st_status == 1 && $caseList->is_ready == 0)
                    @if(request()->get('page') == "nav-report-3")
                    <form action="{{ route('case-list.invoice', $caseList->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="is_ready" value="1">
                        <button type="submit" class="btn btn-primary">Interim Invoice</button>
                    </form>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="modalExpense" tabindex="-1" role="dialog" aria-labelledby="modalExpenseTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('expense.update') }}" method="post">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" id="id_expense">
                    <div class="form-group">
                        <label for="adjuster">Adjuster</label>
                        <select name="adjuster" id="adjuster" class="form-control">
                            <option disabled selected></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="">Qty</label>
                        <input type="number" class="form-control" name="qty" id="qty">
                    </div>
                    <div class="form-group">
                        <label for="">Nominal</label>
                        <input type="text" class="form-control" id="nominal" name="nominal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<div class="modal fade" id="modalCloseCase" role="dialog" aria-labelledby="KonfirmasiModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" style="overflow: auto;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="KonfirmasiModalTitle">Close Case</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('caselist.closecase') }}" method="post">
                    @csrf
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="">Type Close Case</label>
                            <select name="type_close" id="type_close" class="form-control">
                                <option disabled selected>-- Choose Type --</option>
                                <option value="1">Close With Invoice</option>
                                <option value="2">Close Without Invoice</option>
                            </select>
                        </div>
                        <div class="row">
                            <input type="hidden" id="caselist" name="id" value="{{ $caseList->id }}">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Gross Adjustment</label>
                                    <input type="text" name="claim_amount" id="claim_amount" class="form-control claim_amount" value="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fee</label>
                                    <input type="text" name="fee" id="fee" class="form-control" value="0">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Remark</label>
                                    <textarea type="text" name="remark" id="remark" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" data-primary>Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInstruction" role="dialog" aria-labelledby="KonfirmasiModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" style="overflow: auto;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="KonfirmasiModalTitle">Instruction Closed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('caselist.instruction') }}" method="post">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <input type="hidden" id="caselist" name="id" value="{{ $caseList->id }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Date Instruction Closed</label>
                                    <input type="text" name="date_instruction" id="date_instruction" class="form-control date_instruction" placeholder="dd/mm/yyyy" autocomplete="off" value="{{ Carbon\Carbon::parse($caseList->date_insctruction)->format('d/m/Y') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">PIC Insurer</label>
                                    <input type="text" name="pic" id="pic" class="form-control" value="{{ $caseList->pic_insurer ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" data-primary>Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
@stop



@section('footer')
<script src="https://code.jquery.com/jquery-1.7.2.min.js" integrity="sha256-R7aNzoy2gFrVs+pNJ6+SokH04ppcEqJ0yFLkNGoFALQ=" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(document).ready(function() {
        $(".btn-expense").on('click', function() {
            let id = $(this).attr('data-id')
            $('#id_expense').val($(this).attr('data-id'))
            $.ajax({
                url: `/api/admin/expense/show/${id}`,
                success: function(resource) {
                    $('#expense_id').val(resource.id)
                    $('#name').val(resource.name)
                    $('#qty').val(resource.qty)
                    $('#amount').val(resource.amount)
                    $("#tgl_expense").val(resource.tanggal)
                    $("#adjuster").append(`<option value="` + resource.adjuster.kode_adjuster + `" selected>` + resource.adjuster.nama_lengkap + `(` + resource.adjuster.kode_adjuster + `)</option>`)
                    $("#category").append(`<option value="` + resource.category.nama_kategory + `" selected>` + resource.category.nama_kategory + `</option>`)
                },
                error: function(error) {
                    alert(error.statusText)
                }
            })
        })

        $(".tgl_expense").datepicker({
            dateFormat: "dd/mm/yy"
        });

        $(".time_up").datepicker({
            dateFormat: "dd/mm/yy"
        });

        $(".date_instruction").datepicker({
            dateFormat: "dd/mm/yy"
        });

        $('.amount_expense').keyup(function(event) {

            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });

        $('.ia_amount').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });

        $('#nominal').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });

        $('.pr_amount').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
        $('.pa_amount').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
        $('.ir_st_amount').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
        $('.ir_nd_amount').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });

        $('.professional_service').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });

        $('.fr_amount').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });

        $('.claim_amount').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });

        $('#fee').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
    })
</script>
<script>
    $(document).ready(function() {
        let tr = `<tr>
                <td><input type="file" name="file_upload[]"></td>
                <td><input type="text" autocomplete="off" name="time_upload" class="form-control time_up" id="" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"></td>
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



        // $('.ia_amount').keyup(function(event) {

        //     // skip for arrow keys
        //     if (event.which >= 37 && event.which <= 40) return;

        //     // format number
        //     $(this).val(function(index, value) {
        //         return value
        //             .replace(/\D/g, "")
        //             .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        //     });
        // });
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

                    // if (result.case_list.ir_status == 1) {
                    //     $("#myTabs").append(`<li class="nav-item">
                    //     <a class="nav-link nav-tab r5 {{ request()->get('page') == 'nav-report-5' ? 'active bg-primary text-white' : '' }}" href="{{ $caseList->pa_status == 1 ? '?page=nav-report-5' : '#' }}">Report 5</a>
                    // </li>`)
                    // } else {
                    //     $(".r5").remove()
                    // }
                }
            })
        });

        $('#table-expense').DataTable()

        // $("#type_close").on('change', function() {
        //     $("#fee").val('')
        //     let type = $(this).val();
        //     let id = $("#caselist").val()

        //     if (type == 1) {
        //         $.ajax({
        //             type: "GET",
        //             method: "GET",
        //             url: '/api/getfee/' + id,
        //             success: function(response) {
        //                 $("#fee").attr('readonly', '')
        //                 $("#fee").val(response.sum.fee)
        //             }
        //         })
        //     } else {
        //         $("#fee").removeAttr('readonly')
        //     }
        // })
    })
</script>
@stop