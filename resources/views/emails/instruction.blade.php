@extends('beautymail::templates.ark')

@section('content')

@include('beautymail::templates.ark.heading', [
'heading' => 'Dear '. $adjuster .',',
'level' => 'h1'
])

@include('beautymail::templates.ark.contentStart')

<p>This is automatically reminder.</p>

<p>
    Please Closing file to issue Final Report & Fee Note or Fee Note only (for other conditions) <br>
    Axis Ref. {{ $fileno }}/{{ $kode }}, {{ $insured }} - {{ $leader }}

<table border="0">
    <tr>
        <td>Date Instruction</td>
        <td>Insurers PIC</td>
    </tr>
    <tr>
        <td>{{ $date }}</td>
        <td>{{ $pic }}</td>
    </tr>
</table>
</p>

<p>
    Thankyou.
</p>

@include('beautymail::templates.ark.contentEnd')

@stop