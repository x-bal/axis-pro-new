@extends('beautymail::templates.ark')

@section('content')

@include('beautymail::templates.ark.heading', [
'heading' => 'Dear '. $adjuster .',',
'level' => 'h1'
])

@include('beautymail::templates.ark.contentStart')

<p>This is auto message.</p>

<p>
    Please upload your {{ $report }} before {{ $newlimit }}
</p>

<p>With</p>

<p>
    Case No : <b>{{ $fileno }} </b>
</p>



Do not reply this email <br>
This mail is automatically sent from <br>
Axis pro <br> <br>

Thankyou
</p>

@include('beautymail::templates.ark.contentEnd')

@stop