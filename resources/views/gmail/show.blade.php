@extends('layouts.app')

@section('content')
<div class="row mb-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-light" style="font-weight: bold; background-color: #193C8F !important;">DETAIL CASE / INSURANCE : {{ $caseList->insurance->name }} / FILE NO : {{ $caseList->file_no }} / INSTRUCTION DATE : {{ Carbon\Carbon::parse($caseList->instruction_date)->format('d/m/Y') }}</div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-3">
            <div class="card-body">
                @if($mail == null)
                {!! $gmail->getHtmlBody() !!}
                @else
                {!! $gmail->content !!}
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card mt-3">
            <div class="card-body">
                <h5>File Attachment</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($mail == null)
                        @foreach($gmail->getAttachments() as $attachment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attachment->filename }}</td>
                            <td><a href="{{ route('gmails.attachment', $attachment->filename) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a></td>
                        </tr>
                        @endforeach
                        @else
                        @foreach($gmail->attachments as $attachment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attachment->filename }}</td>
                            <td><a href="{{ route('gmails.attachment', $attachment->filename) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop



@section('footer')
<script src="https://code.jquery.com/jquery-1.7.2.min.js" integrity="sha256-R7aNzoy2gFrVs+pNJ6+SokH04ppcEqJ0yFLkNGoFALQ=" crossorigin="anonymous"></script>

@stop