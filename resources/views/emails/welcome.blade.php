@extends('beautymail::templates.ark')

@section('content')

@include('beautymail::templates.ark.heading', [
'heading' => 'Reminder - ' . $report,
'level' => 'h1'
])

@include('beautymail::templates.ark.contentStart')

<h4 class="secondary"><strong>Hello {{ $adjuster }}</strong></h4>
<p>{{ $content }}</p>

@include('beautymail::templates.ark.contentEnd')
@stop